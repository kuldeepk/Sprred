<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class CommentsDB
{
	public static function addFeed($postID, $postLink, $profile_ID, $feed_type, $title, $pub_time, $desc, $content, $thumbnail, $slug, $tags){
		$sdb = new AmazonSDB();
		if($pub_time==null)$pub_time=time();
		
		$put = $sdb->put_attributes('Feeds', $postID, array(
		'post_link' => $postLink,
		'profileID' => $profile_ID,
		'feed_type' => $feed_type,
	    'title' => $title,
	    'pub_time' => $pub_time,
	    'desc' => $desc,
		'content' => $content,
		'thumbnail' => $thumbnail,
		'slug' => $slug,
		'tags' => $tags,		
		'modified' => time()
		), array('post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','slug','tags','modified'));
			
		if($put->body->ResponseMetadata){
			return $commentID;	
		}
	
		elseif(!$put->body->ResponseMetadata)
			return false;
		
	}
	
	public static function delFeed($postID){
		$sdb = new AmazonSDB();
		
		$delete = $sdb->delete_attributes('Feeds', $postID);
	
		return 1;
	}
	
	
}

?>