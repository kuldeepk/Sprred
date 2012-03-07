<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class FavoritesDB
{
	public static function addFav($favID, $postID, $userID){
		
		$sdb = new AmazonSDB();
		$time = time();
		
		$select = $sdb1->select("select * from Feeds where itemName()='".$postID."'");
		foreach($select->body->SelectResult->Item[0]->Attribute as $field)
		{
			$links[ (string) $field->Name ] = (string)$field->Value;
		}
		$sdb2 = new AmazonSDB();
		$put = $sdb2->put_attributes('Favorites', $favID, array(
			'postID' => $postID,	
			'userID' => $userID,
			'tags' => $links['tags'],
			'post_link' => $links['post_link'],
			'profileID' => $links['profile_ID'],	
			'feed_type' => $links['feed_type'],
		    'title' => $links['title'],
		    'pub_time' => $links['pub_time'],
		    'desc' => $links['desc'],
			'content' => $links['content'],
			'thumbnail' => $links['thumbnail'],
			'parent_post' =>$links['parent_post'],
			'parent_ID' =>$links['parent_ID'],
			'time' => $time
			), array('postID','userID','tags','post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','parent_post','parent_ID','time')
		);
		
		if($put->body->ResponseMetadata){
				return true;	
			}
		else
			return false;

	}


	public static function isFav($postID, $userID){
	
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from Favorites where userID = '".$userID."' and postID = '".$postID."'");
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item->Attribute){
			return false;		
		}
		else {
			return true;
		}
	}


	public static function delFav($favID){
		
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes('Favorites', $favID);
	
		return 1;
	}
	
}

?>
