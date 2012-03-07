<?php 

require_once dirname(__FILE__)."/Auth.class.php";
include_once dirname(__FILE__)."/../dao/UserInfo.dao.php";
include_once dirname(__FILE__)."/../lib/mail.lib.php";

class Notification {
	
	private $userID;
	
	function Notification($userID){
		$this->userID = $userID;
	}
	
	function confirmEmail() {
		$userInfo = new UserInfoDAO($this->userID);
		$email = $userInfo->getEmail();
		$auth = new Auth();
		$confirmUrl = "http://www.sprred.com/confirm.php?id=". $auth->base64_url_encode($auth->getPass($email)) ."&auth=". $auth->base64_url_encode($email);
		$fromName = "Sprred";
		$to = $email;
		$toName = $userInfo->getFullName();
		$subject = "Confirm your email address";
		$from = "do-not-reply@sprred.com";
		require(dirname(__FILE__)."/../../templates/mail/confirm.php");
		Mail::send($from, $fromName, $to, $subject, $body, "Email Confirmation");
	}
	
	function passwordReset(){
		$userInfo = new UserInfoDAO($this->userID);
		$email = $userInfo->getEmail();
		$auth = new Auth();
		$resetUrl = "http://www.sprred.com/reset.php?id=". $auth->base64_url_encode($auth->getPass($email)) ."&auth=". $auth->base64_url_encode($email);
		$fromName = "Sprred";
		$to = $email;
		$toName = $userInfo->getFullName();
		$subject = "Reset your Sprred password";
		$from = "do-not-reply@sprred.com";
		require(dirname(__FILE__)."/../../templates/mail/reset.php");
		Mail::send($from, $fromName, $to, $subject, $body, "Forgot Password");
	}
	
	function postStatus($posts){
		$userInfo = new UserInfoDAO($this->userID);
		$email = $userInfo->getEmail();
		$profileURL = $userInfo -> getProfileURL();
		$fromName = "Sprred";
		$to = $email;
		$toName = $userInfo->getFullName();
		$subject = "Status of your posts published on Sprred";
		$from = "post@sprred.com";
		require(dirname(__FILE__)."/../../templates/mail/post.status.php");
		Mail::send($from, $fromName, $to, $subject, $body, "Post Status");
	}
	
}

?>