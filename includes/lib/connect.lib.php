<?php

require_once(dirname(__FILE__)."/fbconnect/facebook.php");
require_once(dirname(__FILE__)."/twitter/tw-connect-oauth.lib.php");
require_once(dirname(__FILE__)."/../dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../dao/Connect.dao.php");

class Connect {

    public static function isTwConnected($token, $secret){
    	return ConnectDB::isTwConnected($token, $secret);
    }
	
	public static function isTwConnectedAlt($userID){
    	return ConnectDB::isTwConnectedAlt($userID);
    }
	
	public static function twLinkUser($user_id, $twuname, $token, $secret, $autopost=false){
		$twConnect = new TwConnectOAuth($_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
		$info = $twConnect->getUserInfo();
		$connect = new ConnectDAO($user_id);
		$connect->linkTwitter($twuname, $token, $secret);
		if($autopost)
			$connect->setTwAutopost();
		return true;
	}
	
	public static function isFBConnected($user_id){
    	$connect = new ConnectDAO($user_id);
		if($fb_id = $connect->getFBID())
			return $fb_id;
		else
			return false;
    }
	
	public static function isFBUserExist($email_hashes) {
		$email_hash = $email_hashes[0];
		if($result = ConnectDB::isFBEmailHashExist($email_hash))
			return $result;
		else
			return false;
	}
	
	public static function isFBUserLinked($fb_id) {
		if($result = ConnectDB::isFBIDExist($fb_id))
			return $result;
		else
			return false;
	}
	
	public static function fbLinkNewUser($user_id, $fb_id, $fb_session, $autopost=false, $pic_url=null) {
		$connect = new ConnectDAO($user_id);
		$connect->changeFBID($fb_id);
		$connect->changeFBSessionKey($fb_session['access_token']);
		$connect->changeFBPhotosMethod('status');
		$connect->changeFBVideosMethod('status');
		if($autopost)
			$connect->setFBAutopost();
		if($pic_url) {
			$connect->changeFBPicURL($pic_url);
		}
	}
	
	public static function fbLinkExistUser($fb_id) {
		global $fb_api_key, $fb_secret;
		$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');
		$info = $fb->api_client->users_getInfo($fb_id,"name,email_hashes");
		if($user_id = Connect::isFBUserExist($info[0]['email_hashes'])){
			$connect = new ConnectDAO($user_id);
			$connect->changeFBID($fb_id);
			return true;
		} else
			return false;
	}
	
	public static function registerUserOnFB($user_id, $email) {
		$result = Connect::fbRegisterUser($email);
		if($result[0]){
			$connect = new ConnectDAO($user_id);
			$connect->changeFBEmailHash($result[0]);
		}
	}
	
	public static function fbRegisterUser($email){
		global $fb_api_key, $fb_secret;
		$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');
		$email = trim($email);
		$email = strtolower($email);
		$eid = crc32($email);
		$eid = sprintf('%u', $eid);
		$email_hash = md5($email);
		$email_hash = $eid .'_'. $email_hash;
		$accounts[0]['email_hash'] = $email_hash;
		$accounts = json_encode($accounts);
		$result = $fb->api_client->connect_registerUsers($accounts);
		return $result;
	}
}
?>
