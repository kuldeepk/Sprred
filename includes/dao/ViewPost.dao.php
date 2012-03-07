<?php

require_once(dirname(__FILE__).'/../db/Posts.db.php');
require_once(dirname(__FILE__).'/../lib/utility.lib.php');
require_once(dirname(__FILE__).'/../dao/S3.dao.php');

class ViewPostDAO
{

	function ViewPostDAO() {
	}
	
	function getMultiPosts($userID, $limit=NULL , $offset=0, $fromTime=NULL, $type=NULL, $status=array('public'), $set=null) {			
		if($type)$type = "('".implode("', '", $type)."')";
		if($status)$status = "('".implode("', '", $status)."')";
		if($set)$set = "('".implode("', '", $set)."')";
		
		$posts = PostsDB::getMultiPosts($userID, $limit, $offset, $fromTime, $type, $status, $set);
	
		if($limit && $posts)
			$posts = array_slice($posts, $offset, $limit);

		return $posts;
	}

	function getPostsCount($userID=null, $type=NULL, $status=array('public'), $set=null){
		if($type)$type = "('".implode("', '", $type)."')";
		if($status)$status = "('".implode("', '", $status)."')";
		if($set)$set = "('".implode("', '", $set)."')";
		
		return PostsDB::getPostsCount($userID, $type, $status, $set);
	}
	
	function getPost($postID) {			
		return PostsDB::getPost($postID);
	}
	
	function getSinglePost($userID, $timestamp, $slug) {			
		return PostsDB::getSinglePost($userID, $timestamp, $slug);
	}
	
	public static function getLatestPosts($userID, $timestamp, $num, $type=null, $status=array('public'), $set=null) {
		if($type)$type = "('".implode("', '", $type)."')";
		if($status)$status = "('".implode("', '", $status)."')";
		if($set)$set = "('".implode("', '", $set)."')";
		return PostsDB::getLatestPosts($userID, $timestamp, $num, $type, $status, $set);
	}
	
	public static function getOlderPosts($userID, $timestamp, $num, $type=null, $status=array('public'), $set=null) {
		if($type)$type = "('".implode("', '", $type)."')";
		if($status)$status = "('".implode("', '", $status)."')";
		if($set)$set = "('".implode("', '", $set)."')";
		return PostsDB::getOlderPosts($userID, $timestamp, $num, $type, $status, $set);
	}
}
?>