<?php

require_once dirname(__FILE__)."/Auth.class.php";
require_once dirname(__FILE__)."/Notification.class.php";
require_once dirname(__FILE__)."/../db/User.db.php";
require_once dirname(__FILE__)."/../db/ProfileInfo.db.php";
require_once dirname(__FILE__)."/../dao/UserInfo.dao.php";
require_once dirname(__FILE__)."/../dao/RANotify.dao.php";
require_once dirname(__FILE__)."/../dao/Space.dao.php";
require_once dirname(__FILE__)."/../dao/Notifications.dao.php";
require_once dirname(__FILE__)."/../lib/connect.lib.php";
require_once dirname(__FILE__)."/../lib/mail.lib.php";
require_once(dirname(__FILE__)."/../dao/UserLog.dao.php");
require_once(dirname(__FILE__)."/../lib/location.lib.php");

class SignUp
{

	private $userId = null;
	
	function getCreatedID($email){
		return UserDB::getUserID($email);
	}
	
	function emailTaken($email){
	   if(!get_magic_quotes_gpc()){
	      $email = addslashes($email);
	   }
	   return UserDB::emailPresent($email);
	}
	
	function urlTaken($url){
	   return ProfileInfoDB::urlPresent($url);
	}
	
	public static function sprredNameTaken($sname){
	   return ProfileInfoDB::sprredNamePresent($sname);
	}
	
	function register($email, $password, $sname, $website, $updates=false, $fullname=null){
		if($fullname == null) {
			$fullname = 'Unknown';
			$title = 'Untitled';
		} else
			$title = $fullname."'s Sprred";
		if(!get_magic_quotes_gpc()){
	      $title = addslashes($title);
	    }
			
		$status = UserDB::createUser($fullname, $email, $password);					
		$userID = $this->getCreatedID($email);		
		$notify = new NotificationsDAO($userID);
		$status2 = $notify->createEntry($updates);		
		$userInfo = new UserInfoDAO($userID);
		$status3 = $userInfo->createProfileEntry($sname, $website, $title);
		$space = new SpaceDAO($userID);
		$status4 = $space->createSpace();
		//Connect::registerUserOnFB($userID, $email);
		$notify = new Notification($userID);
		$notify->confirmEmail();
		$location = Location::getInfo($_SERVER['REMOTE_ADDR']);
		$log = new UserLogDAO($userID);
		$log->addLog($location['City'], $location['CountryName'], $location['CountryCode'], $location['RegionName'], $location['ZipPostalCode']);
		$log->updateLoggedInTime(time());
		return $status;
	}
	
	function confirmUser($userID) {
		return UserDB::confirmUser($userID);
	}
	
	function confirmEmail($email) {
		$auth = new Auth();
		$confirmUrl = "http://www.sprred.com/confirm.php?id=". $auth->base64_url_encode($auth->getPass($email)) ."&auth=". $auth->base64_url_encode($email);
		$fromName = "Sprred";
		$to = $email;
		$userInfo = new UserInfoDAO($this->getCreatedID($email));
		$toName = $userInfo->getFullName();
		$subject = "Confirm your email address";
		$from = "do-not-reply@sprred.com";
		require(dirname(__FILE__)."/../../templates/mail/confirm.php");
		Mail::send($from, $fromName, $to, $subject, $body, "Email Confirmation");
	}
}

?>