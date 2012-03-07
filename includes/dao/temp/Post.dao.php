<?php

require_once(dirname(__FILE__).'/../db/Posts.db.php');
require_once(dirname(__FILE__).'/../lib/Utility.lib.php');

class PostsDAO
{

	function PostsDAO($user_id, $post_id) {
		$this->userID = $user_id;	
		$this->postID = $post_id;	
	}
	
	function addPost($postLink, $s3name=null, $RAprofile_ID, $type=null, $title=null, $pubtime=null, $pubtime_gmt=null, $desc=null, $content=null, $slug=null, $tags=null, $status=null, $comment_status=null, $postSize=null, $set=null) {
			
		return PostsDB::addPost($this->userID, $this->postID, $postLink, $s3URL, $RAprofile_ID, $type, $title, $pubtime, $pubtime_gmt, $desc, $content, $slug, $tags, $status, $comment_status, $postSize, $set);	
	
	}

	function updatePostTitle($title){
		return PostsDB::updatePost($title, 'title', $this->postID);	
	}
	function updatePostContent($content){
		return PostsDB::updatePost($content, 'content', $this->postID);	
	}
	function updatePostS3URL($s3URL){
		return PostsDB::updatePost($s3URL, 's3URL', $this->postID);	
	}
	function updatePostPubtime($pubtime){
		return PostsDB::updatePost($pubtime, 'pubtime', $this->postID);	
	}
	function updatePostPubtime_gmt($pubtime_gmt){
		return PostsDB::updatePost($pubtime_gmt, 'pubtime_gmt', $this->postID);	
	}
	function updatePostTags($tags){
		return PostsDB::updatePost($tags, 'tags', $this->postID);	
	}
	function updatePostStatus($status){
		return PostsDB::updatePost($status, 'status', $this->postID);	
	}
	function updatePostCommentStatus($comment_status){
		return PostsDB::updatePost($comment_status, 'comment_status', $this->postID);	
	}
	function updatePostSet($postSize){
		return PostsDB::updatePost($postSize, 'postSize', $this->postID);	
	}
	function updatePostSet($set){
		return PostsDB::updatePost($set, 'set', $this->postID);	
	}

	
	function delPost() {
	
	//------	get $profile_ID from userInfo; @ fn level
	
	//------	create $postID from $profile_ID, type, link @ fn level
		FeedsDB::delPost($this->postID);
	
	}

}
?>