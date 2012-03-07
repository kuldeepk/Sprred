<?php

require_once(dirname(__FILE__)."/../db/Connect.db.php");

class ConnectDAO
{

	private $userID = null;
	private $fbID = null;
	private $fbEmailHash = null;
	private $fbPicURL = null;
	private $fbSessionKey = null;
	private $fbAutopost = null;
	private $twUname = null;
	private $twPasswd = null;
	private $twToken = null;
	private $twSecret = null;
	private $twAutopost = null;
		
	function ConnectDAO($user_id) {
		$this->userID = $user_id;
	}
	
	function getUserId() {
		return $this->userID;
	}
	
	function changeFBID($fb_id) {
		$this->fbID=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBID($this->userID, $fb_id);
	}
	
	function getFBID() {
		if($this->fbID){
			return $this->fbID;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbID = $result['fb_id'];
			return $this->fbID;
		} else {
			$result = ConnectDB::getAll($this->userID);
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbID = $result['fb_id'];
				return $this->fbID;
			}
		}
	}
	
	function changeFBEmailHash($fbEmailHash) {
		$this->fbEmailHash=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setEmailHash($this->userID, $fbEmailHash);
	}
	
	function getFBEmailHash() {
		if($this->fbEmailHash){
			return $this->fbEmailHash;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbEmailHash = $result['fb_email_hash'];
			return $this->fbEmailHash;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbEmailHash = $result['fb_email_hash'];
				return $this->fbEmailHash;
			}
		}
	}
	
	function changeFBPicURL($fbPicURL) {
		$this->fbPicURL=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBPicURL($this->userID, $fbPicURL);
	}
	
	function getFBPicURL() {
		if($this->fbPicURL){
			return $this->fbPicURL;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbPicURL = $result['fb_pic_URL'];
			return $this->fbPicURL;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbPicURL = $result['fb_pic_URL'];
				return $this->fbPicURL;
			}
		}
	}
	
	function changeFBSessionKey($fbSessionKey) {
		$this->fbSessionKey=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBSessionKey($this->userID, $fbSessionKey);
	}
	
	function getFBSessionKey() {
		if($this->fbSessionKey){
			return $this->fbSessionKey;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbSessionKey = $result['fb_session_key'];
			return $this->fbSessionKey;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbSessionKey = $result['fb_session_key'];
				return $this->fbSessionKey;
			}
		}
	}
	
	function setFBAutopost() {
		$this->fbAutopost=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBAutopost($this->userID, 1);
	}
	
	function resetFBAutopost() {
		$this->fbAutopost=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBAutopost($this->userID, 0);
	}
	
	function changeFBPhotosMethod($fbPhotosMethod) {
		$this->fbSessionKey=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBPhotosMethod($this->userID, $fbPhotosMethod);
	}
	
	function getFBPhotosMethod() {
		if($this->fbPhotosMethod){
			return $this->fbPhotosMethod;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbPhotosMethod = $result['fb_photos_method'];
			return $this->fbPhotosMethod;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbPhotosMethod = $result['fb_photos_method'];
				return $this->fbPhotosMethod;
			}
		}
	}
	
	function changeFBVideosMethod($fbVideosMethod) {
		$this->fbSessionKey=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setFBVideosMethod($this->userID, $fbVideosMethod);
	}
	
	function getFBVideosMethod() {
		if($this->fbVideosMethod){
			return $this->fbVideosMethod;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbVideosMethod = $result['fb_videos_method'];
			return $this->fbVideosMethod;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbVideosMethod = $result['fb_videos_method'];
				return $this->fbVideosMethod;
			}
		}
	}
	
	function isFBAutopost() {
		if($this->fbAutopost != null){
			return $this->fbAutopost;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->fbAutopost = $result['fb_autopost'];
			return $this->fbAutopost;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->fbAutopost = $result['fb_autopost'];
				return $this->fbAutopost;
			}
		}
	}
	
	function linkTwitter($tw_uname, $access_token, $token_secret) {
		$this->twUname=null;
		$this->twToken=null;
		$this->twSecret=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setTwDetails($this->userID, $tw_uname, $access_token, $token_secret);
	}
	
	function getTwUname() {
		if($this->twUname){
			return $this->twUname;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->twUname = $result['tw_username'];
			return $this->twUname;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->twUname = $result['tw_username'];
				return $this->twUname;
			}
		}
	}
	
	function getTWAccessTkn() {
		if($this->twToken){
			return $this->twToken;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->twToken = $result['tw_access_token'];
			return $this->twToken;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->twToken = $result['tw_access_token'];
				return $this->twToken;
			}
		}
	}
	
	function getTWTknScrt() {
		if($this->twSecret){
			return $this->twSecret;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->twSecret = $result['tw_token_secret'];
			return $this->twSecret;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->twSecret = $result['tw_token_secret'];
				return $this->twSecret;
			}
		}
	}
	
	function setTwAutopost() {
		$this->twAutopost=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setTwAutopost($this->userID, 1);
	}
	
	function resetTwAutopost() {
		$this->twAutopost=null;
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setTwAutopost($this->userID, 0);
	}
	
	function isTwAutopost() {
		if($this->twAutopost != null){
			return $this->twAutopost;
		} elseif($result=MemClient::get("connectRow-". $this->userID)){
			$this->twAutopost = $result['tw_autopost'];
			return $this->twAutopost;
		} else {
			$result = ConnectDB::getAll($this->userID);
		
			if(is_null($result))
				return false;
			else {
				MemClient::set("connectRow-". $this->userID, $result, false, 2592000);
				$this->twAutopost = $result['tw_autopost'];
				return $this->twAutopost;
			}
		}
	}
	
	function unlinkTwitter() {
		$this->twUname=null;
		$this->twToken=null;
		$this->twSecret=null;
		$this->resetTwAutopost();
		MemClient::delete("connectRow-". $this->userID);
		return ConnectDB::setTwDetails($this->userID, null, null, null);
	}
	
	function unlinkFacebook() {
		$this->changeFBID(null);
		$this->changeFBSessionKey(null);
		$this->resetFBAutopost();
		MemClient::delete("connectRow-". $this->userID);
	}

}

?>