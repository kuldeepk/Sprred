<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class CommentsDB
{
	public static function addComment($commentID, $postID, $userID, $comment, $parent = null){
		$sdb = new AmazonSDB();
		$time = time();
		
		$put = $sdb->put_attributes('Comments', $commentID, array(
			'postID' => $postID,	
			'userID' => $userID,
			'parent' => $parent,
		    'comment' => $comment,
			'time' => $time
			), array('postID','userID','parent','comment','time')
		);
	
		if($put->body->ResponseMetadata){
					return $commentID;	
				}
	
		elseif(!$put->body->ResponseMetadata)
			return false;
	
	}


	public static function getComments($postID){
	
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from Comments where postID='".$postID."' and time != 'null' order by time asc");
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		}
		else{
			$cnt = 0;
			foreach($select->body->SelectResult->Item as $item)
			{
				$comments[$cnt]['commentID'] = (string) $item->Name;
				foreach($item->Attribute as $attribute)
				{   
					$comments[$cnt][ (string) $attribute->Name ] = (string)$attribute->Value;
				}
				$cnt++;
			}
		}
		return $comments;
	
	}

	public static function countComment($postID)
	{
		$sdb = new AmazonSDB();
	
		$select = $sdb->select("select count(*) from Comments where postID = '".$postID."'");
		if(!$select->body->SelectResult->Item[0]->Attribute){
			return 0;		
		}
		else
		return $select->body->SelectResult->Item->Attribute->Value;
	}

	public static function delComment($commentID){
		$sdb = new AmazonSDB();
		
		$delete = $sdb->delete_attributes('Comments', $commentID);
	
		return 1;
	}
	
}

?>
