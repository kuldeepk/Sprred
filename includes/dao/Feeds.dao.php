<?php

require_once(dirname(__FILE__).'/../db/Feeds.db.php');
require_once(dirname(__FILE__).'/../lib/utility.lib.php');

class FeedsDAO
{

	function FeedsDAO($user_id, $post_id) {
		$this->userID = $user_id;	
		$this->postID = $post_id;	
	}
	
	function addFeed($postLink, $profile_ID, $feed_type, $title, $pub_time, $desc, $content, $thumbnail, $slug, $tags) {
	
		$desc = strip_tags($desc);
		$content = strip_tags($content);
		$content = Utility::strip_script($content);
		$content = Utility::shortenText($content, 1020);
		

		
		return FeedsDB::addFeed($this->postID, $postLink, $profile_ID, $feed_type, $title, $pub_time, $desc, $content, $thumbnail, $slug, $tags);	
	
	}

	
	function delFeed() {
	
	//------	get $profile_ID from userInfo; @ fn level
	
	//------	create $postID from $profile_ID, type, link @ fn level
		FeedsDB::delFeed($this->postID);
	
	}

}
?>