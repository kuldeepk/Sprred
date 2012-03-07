<?php
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__).'/../dao/ViewPost.dao.php');
//require_once(dirname(__FILE__).'/../dao/Favorites.dao.php');
//require_once(dirname(__FILE__).'/../dao/Comments.dao.php');
require_once(dirname(__FILE__).'/../dao/UserInfo.dao.php');
require_once(dirname(__FILE__).'/../dao/Feeds.dao.php');

class ViewPosts
{	
	function ViewPosts($admin_id) {
		$this->admin = $admin_id;
	}
	
	function getAllPosts($limit=NULL , $offset=0, $status=array('public'), $fromTime=NULL, $withFavs=false, $withComments=false){	
		$viewPostDAO = new ViewPostDAO();
		$posts = $viewPostDAO->getMultiPosts($this->admin, $limit , $offset, $fromTime, null, $status);
		
		if($this->viewer && $withFavs)
			$posts = $this->chkForFavs($posts, $this->viewer);
		
		if($withComments)	
			$posts = $this->getCommentsForAll($posts);
		
		return $posts;
	}
	
	function getAllBlogPosts($limit=NULL , $offset=0, $status=array('public'), $fromTime=NULL, $withFavs=false, $withComments=false){	
		$viewPostDAO = new ViewPostDAO();
		$posts = $viewPostDAO->getMultiPosts($this->admin, $limit , $offset, $fromTime, array('blog'), $status);
		
		if($this->viewer && $withFavs)
			$posts = $this->chkForFavs($posts, $this->viewer);
		
		if($withComments)	
			$posts = $this->getCommentsForAll($posts);
		
		return $posts;
	}
	
	function getBlogPostsCount($status=array('public')){
		$viewPostDAO = new ViewPostDAO();
		$count = $viewPostDAO->getPostsCount($this->admin, array('blog'), $status);
		return $count;
	}
	
	function getAllPhotos($limit=NULL , $offset=0, $status=array('public'), $fromTime=NULL, $withFavs=false, $withComments=false){	
		$viewPostDAO = new ViewPostDAO();
		$posts = $viewPostDAO->getMultiPosts($this->admin, $limit, $offset, $fromTime, array('photo'), $status);
		
		if($this->viewer && $withFavs)
			$posts = $this->chkForFavs($posts, $this->viewer);
		
		if($withComments)	
			$posts = $this->getCommentsForAll($posts);
		
		return $posts;
	}
	
	function getPhotosCount($status=array('public')){
		$viewPostDAO = new ViewPostDAO();
		$count = $viewPostDAO->getPostsCount($this->admin, array('photo'), $status);
		return $count;
	}
	
	function getAllVideos($limit=NULL , $offset=0, $status=array('public'), $fromTime=NULL, $withFavs=false, $withComments=false){	
		$viewPostDAO = new ViewPostDAO();
		$posts = $viewPostDAO->getMultiPosts($this->admin, $limit, $offset, $fromTime, array('video'), $status);
		//print_r($status);
		if($this->viewer && $withFavs)
			$posts = $this->chkForFavs($posts, $this->viewer);
		
		if($withComments)	
			$posts = $this->getCommentsForAll($posts);
		
		return $posts;
	}
	
	function getVideosCount($status=array('public')){
		$viewPostDAO = new ViewPostDAO();
		$count = $viewPostDAO->getPostsCount($this->admin, array('video'), $status);
		return $count;
	}
	
	function getAllLinks($limit=NULL , $offset=0, $status=array('public'), $fromTime=NULL){
		$viewPostDAO = new ViewPostDAO();
		$posts = $viewPostDAO->getMultiPosts($this->admin, $limit, $offset, $fromTime, array('link'), $status);
		
		return $posts;
	}
	
	function getLinksCount($status=array('public')){
		$viewPostDAO = new ViewPostDAO();
		$count = $viewPostDAO->getPostsCount($this->admin, array('link'), $status);
		return $count;
	}
	
	function getPostData($postID){		
		$ViewPostDAO = new ViewPostDAO();
		$posts = $ViewPostDAO -> getPost($postID);		
		if($this->viewer)
			$posts = $this -> chkForFavs($posts, $this->viewer);
	
		$posts = $this -> getCommentsForAll($posts);
		return $posts;	
	}
	
	function getBasicPostData($postID){
		$ViewPostDAO = new ViewPostDAO();
		$posts = $ViewPostDAO->getPost($postID);
		return $posts;
	}
	
	function getSinglePost($userID, $timestamp, $slug){
		$ViewPostDAO = new ViewPostDAO();
		$posts = $ViewPostDAO->getSinglePost($userID, $timestamp, $slug);
		return $posts;
	}
	
	public static function getPostContentFromID($postID){
		$ViewPostDAO = new ViewPostDAO();
		$postData = $ViewPostDAO->getPost($postID);
		
		if($postData != 'blog')return 0;
		$s3name = $postData['s3name'];

		$s3 = new s3DAO($s3name, S3BUCKET);		
		return $S3->getFileContent()->body;
	}
	
	function shareThisPost($postID){
	/*
	 * check if viewer not= admin
	 * 
	 * Call addShared(**$profileID**, $this->$postID); from Shared.php
	 */	
		
		if($this->admin == $this->viewer)return 0;
		
		$parentPostID = $postID;
		$UserInfoDAO = new UserInfoDAO($this->viewer);
		$RAprofileID = $UserInfoDAO -> getProfileID();
	
		$postData = $this -> getBasicPostData($postID);
		
		$UserInfoDAO = new UserInfoDAO($this->admin);
		$RAparentID = $UserInfoDAO -> getProfileID();
	
		$feedsDAO = new FeedsDAO($this->viewer, $postID);
		$feedsDAO -> addShared($postData['postLink'], $postData['profileID'], $postData['type'], $postData['title'], $postData['pubtime'], $postData['desc'], $postData['content'], null, $postData['slug'], $postData['tags'], $parentPostID, $parentProfileID);
		 
	}
	
	function chkForFavs($posts, $userID) {
		$FavDAO = FavoritesDAO($postID, $userID);
			
		foreach($posts as $key=>$post){
			if($FavDAO -> isFav()){
					$posts[$key]['isFav'] = true;
			}
		}
		return $posts;
	}
	
	function getCommentsForAll($links) {
		foreach($links as $key=>$post){
				$comments = $this -> getPostComments($post['postID']);
			if($comments){
				$links[$key]['comments'] = $comments;
				$links[$key]['comment_count'] = $this -> getCommentCount($post['postID']);
	
			}
		}
		return $posts;
	}
	
	function favThisPost($postID){
		$FavDAO = FavoritesDAO($postID, $this->viewer);
		return $FavDAO -> addFav();
	}
	
	function getPostComments($postID){
		$CommentsDAO = new CommentsDAO($postID);
		return $CommentsDAO -> getComments();
	}
	
	function getCommentCount($postID){
		$CommentsDAO = new CommentsDAO($postID);
		return $CommentsDAO -> countComment();
	}
	
	function addComment($postID, $comment, $parent = null){
		$CommentsDAO = new CommentsDAO($postID);
		return $CommentsDAO -> addComment($this->viewer, $comment, $parent = null);
	
	}
	
	function deleteComment($commentID){
		$CommentsDAO = new CommentsDAO($postID);
		$CommentsDAO -> delComment($commentID);
	
	}

}
?>