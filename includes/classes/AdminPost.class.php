<?php
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__).'/../classes/ViewPosts.class.php');
require_once(dirname(__FILE__).'/../dao/Posts.dao.php');
require_once(dirname(__FILE__).'/../dao/Space.dao.php');
require_once(dirname(__FILE__).'/../dao/S3.dao.php');
require_once(dirname(__FILE__).'/../dao/UserInfo.dao.php');
require_once(dirname(__FILE__).'/../lib/utility.lib.php');


class AdminPerPost
{
		
	function AdminPerPost($user_id, $post_id) {
		$this->userID = $user_id;
		$this->postID = $post_id;
	}
	
	function updateBlogPost($title, $content, $tags, $status, $pubtime=null, $pubtime_gmt=null, $comment_status=null){
		$type = 'blog';
		$UserInfoDAO = new UserInfoDAO($this->userID);
		
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$postView = new ViewPosts($this->userID);
		$postData = $postView -> getBasicPostData($this->postID);
		
		if(!$pubtime)
			$pubtime = $postData['pubtime'];
		if(!$pubtime_gmt)
			$pubtime_gmt = $postData['pubtime_gmt'];
		if(!$comment_status)
			$comment_status = $postData['comment_status'];
			
		$s3name = $postData['s3name'];
		$s3 = new s3DAO($s3name, S3BUCKET);
		$s3 -> deleteFile();
		$s3 -> uploadFile($content, 'blog');
		$postSize = $s3 -> getFileSize();
		
		if($postSize != $postData['postSize']){
			$SpaceDAO = new SpaceDAO($this->userID);			
			if(!$SpaceDAO -> isSpaceAvailOfType($postSize, $type)){
				$s3->deleteFile();
				return 0;
			} else {
				$SpaceDAO->useSpace($postSize, $type);
			}
		}
		$s3URL = $s3->getFileURL();
		$desc = Utility::shortenText(strip_tags($content), 180);
		$PostsDAO->updatePost($this->postID, $s3name, $title, $desc, $s3URL, $tags, $status, $postSize, $set=null, $pubtime, $pubtime_gmt, $comment_status);
	}
	
	function updatePhotoPost($title, $desc, $tags, $status, $set=null, $pubtime=null, $pubtime_gmt=null, $comment_status=null){
		$type = 'photo';
		$UserInfoDAO = new UserInfoDAO($this->userID);
		$postView = new ViewPosts($this->userID);
		$postData = $postView -> getBasicPostData($this->postID);
		if(!$pubtime)
			$pubtime = $postData['pubtime'];
		if(!$pubtime_gmt)
			$pubtime_gmt = $postData['pubtime_gmt'];
		if(!$comment_status)
			$comment_status = $postData['comment_status'];
		if(!$set)
			$set = $postData['set'];
		if(!$tags)
			$tags = $postData['tags'];
		if(!$status)
			$status = $postData['status'];
		if(!$desc)
			$desc = $postData['desc'];	
		
		$desc = Utility::shortenText(strip_tags($desc), 900);
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO->updatePostShort($this->postID, $title, $desc, $tags, $status, $set, $pubtime, $pubtime_gmt, $comment_status);
	}
	
	function updateVideoPost($title, $desc, $tags, $status, $set=null, $pubtime=null, $pubtime_gmt=null, $comment_status=null){
		$type = 'video';
		$UserInfoDAO = new UserInfoDAO($this->userID);
		$postView = new ViewPosts($this->userID);
		$postData = $postView -> getBasicPostData($this->postID);
		if(!$pubtime)
			$pubtime = $postData['pubtime'];
		if(!$pubtime_gmt)
			$pubtime_gmt = $postData['pubtime_gmt'];
		if(!$comment_status)
			$comment_status = $postData['comment_status'];
		if(!$set)
			$set = $postData['set'];
		if(!$tags)
			$tags = $postData['tags'];
		if(!$status)
			$status = $postData['status'];
		if(!$desc)
			$desc = $postData['desc'];	
		
		$desc = Utility::shortenText(strip_tags($desc), 900);
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO->updatePostShort($this->postID, $title, $desc, $tags, $status, $set, $pubtime, $pubtime_gmt, $comment_status);
	}
	
	function updatePostTitle($title){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostTitle($title);
	}
	
	function updatePostContent($content){
		$postView = new ViewPost($this->userID);
		$postData = $postView -> getBasicPostData($this->postID);
		
		if($postData != 'blog')return 0;
		$s3name = $postData['s3name'];

		$s3 = new s3DAO($s3name, S3BUCKET);
		$s3 -> deleteFile();
		$s3 -> uploadFile($content, 'blog');
		$postSize = $s3 -> getFileSize();
		
		if($postSize != $postData['postSize']){
			$SpaceDAO = new SpaceDAO($this->userID);
			
			if(!$SpaceDAO -> isSpaceAvailOfType($postSize, $type)){
				$s3 -> deleteFile();
				return 0;
			}
			
			else{
				$this -> updatePostSize($postSize);
				$SpaceDAO -> useSpace($postSize, $type);
			}
		}		
		
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostContent($s3 -> getFileURL());
	}

	function updatePostS3name($s3name){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostTitle($s3name);
	}

	function updatePostPubtime($pubtime){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostPubtime($pubtime);
	}

	function updatePostPubtime_gmt($pubtime_gmt){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostPubtime_gmt($pubtime_gmt);
	}
	
	function updatePostTags($tags){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostTags($tags);
	}
	
	function updatePostStatus($status){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostStatus($status);
	}
	
	function updatePostCommentStatus($comment_status){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostCommentStatus($comment_status);
	}

	function updatePostSet($postSize){
		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO -> updatePostSize($postSize);
	}
	
	function deletePost(){
		$postView = new ViewPosts($this->userID);
		$postData = $postView -> getBasicPostData($this->postID);
		
		$s3 = new s3DAO($postData['s3name'], S3BUCKET);
		$s3->deleteFile();
		
		//$SpaceDAO = new SpaceDAO($this->userID);
		//$SpaceDAO -> releaseSpace($postData['postSize'], $postData['type']);

		$PostsDAO = new PostsDAO($this->userID, $this->postID);
		$PostsDAO->delPost();	
	}	
}
?>