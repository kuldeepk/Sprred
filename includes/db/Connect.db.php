<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class ConnectDB
{
	public static function isFBEmailHashExist($email_hash){	
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."Connect where fb_email_hash='".$email_hash."'");
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		
		if($data)
			return $data;
		else
			return false;
		
	}
	
	public static function isFBIDExist($fb_id){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."Connect where fb_id='".$fb_id."'");
	
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		if($data)
			return $data;
		else
			return false;
		
	}

	public static function setEmailHash($userID, $email_hash){		
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_email_hash' => $email_hash
		), array('fb_email_hash'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBPicURL($userID, $picURL){		
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_pic_URL' => $picURL
		), array('fb_pic_URL'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBSessionKey($userID, $fbSessionKey){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_session_key' => $fbSessionKey
		), array('fb_session_key'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBPhotosMethod($userID, $fbPhotosMethod){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_photos_method' => $fbPhotosMethod
		), array('fb_photos_method'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBVideosMethod($userID, $fbVideosMethod){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_videos_method' => $fbVideosMethod
		), array('fb_videos_method'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBID($userID, $fb_id){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_id' => $fb_id
		), array('fb_id'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setFBAutopost($userID, $flag){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'fb_autopost' => $flag
		), array('fb_autopost'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setTwAutopost($userID, $flag){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'tw_autopost' => $flag
		), array('tw_autopost'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function setTwDetails($userID, $tw_uname, $access_token, $token_secret){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Connect', $userID, array(
			'tw_username' => $tw_uname,
			'tw_access_token' => $access_token,
			'tw_token_secret' => $token_secret
		), array('twitter_username', 'tw_access_token', 'tw_token_secret'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function isTwConnected($token, $secret){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."Connect where tw_access_token='".$token."' and tw_token_secret='".$secret."'");
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		
		if($data)
			return $data;
		else
			return false;
	
	}
	
	public static function isTwConnectedAlt($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."Connect where itemName()='".$userID."'");
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		
		if($data)
			return $data;
		else
			return false;
	
	}
	
	public static function getAll($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."Connect where itemName()='".$userID."'");
	
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		if(!data)
			return null;
		$data = array();
		if(!$select->body->SelectResult->Item[0]->Attribute)
			return null;
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$data[ (string) $field->Name ] = (string) $field->Value;
		}
		return $data;
		
	}
	
	public static function deleteEntry($userID){
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes(DB_REGION.'Connect', $userID);
		if(!$put)
			return false;
		else 
			return true;
	
	}

}

?>
