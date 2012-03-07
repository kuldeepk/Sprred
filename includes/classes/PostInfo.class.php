<?php
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__).'/../dao/S3.dao.php');
require_once(dirname(__FILE__)."/../dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../dao/ViewPost.dao.php");
require_once(dirname(__FILE__).'/../lib/utility.lib.php');

class PostInfo
{	
	private $post = null;
	
	function PostInfo($post) {
		$this->post = $post;
	}
	
	function getPostTitle() {
		return $this->post['title'];
	}
	
	function getPostURL($userID, $forceLinkURL=false) {
		$info = new UserInfoDAO($userID);
		if($this->post['type'] == 'link' && $forceLinkURL)
			return $this->post['content'];
		else
			return $info->getProfileURL().$this->post['postLink'];
	}
	
	function getPostDesc() {
		return $this->post['desc'];
	}
	
	function getPostedAgo() {
		return Utility::time_since($this->post['pubtime']);
	}
	
	function getBlogContent() {
		return stripslashes(PostInfo::getPostContentFromName($this->post['s3name']));
	}
	
	function getPhotoURL($size) {
		return '/images/image.php?id='. $this->post['s3name'] .'&size='.$size;
	}
	
	function getLatestPhotos($userID, $num, $set=null) {
		return ViewPostDAO::getLatestPosts($userID, $this->post['pubtime'], $num, array('photo'), array('public'), $set);
	}
	
	function getOlderPhotos($userID, $num, $set=null) {
		return ViewPostDAO::getOlderPosts($userID, $this->post['pubtime'], $num, array('photo'), array('public'), $set);
	}
	
	function getVideoThumbURL($size) {
		return '/images/image.php?url='. urlencode(substr($this->post['content'], 0, -4)."_0000.png") .'&size='.$size;
	}
	
	function getVideoURL() {
		return $this->post['content'];
	}
	
	function getLatestVideos($userID, $num, $set=null) {
		return ViewPostDAO::getLatestPosts($userID, $this->post['pubtime'], $num, array('video'), array('public'), $set);
	}
	
	function getOlderVideos($userID, $num, $set=null) {
		return ViewPostDAO::getOlderPosts($userID, $this->post['pubtime'], $num, array('video'), array('public'), $set);
	}
	
	public static function getPostContentFromName($s3name){
		$s3 = new S3DAO($s3name, S3BUCKET);		
		return $s3->getFileContent()->body;
	}

}
?>