<?php
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../classes/SignUp.class.php");
/*************************************/

class ConfirmController
{

	function ConfirmController() {
		if(!isset($_GET['auth']) || !isset($_GET['id'])){
			$_SESSION['confirm-msg'] = "Invalid URL";
			return;
		}
		$auth = new Auth();
		$pass = $auth->base64_url_decode($_GET['id']);
		$email = $auth->base64_url_decode($_GET['auth']);
		$signUp = new SignUp();
		if(!$signUp->emailTaken($email) || !$auth->doMatch($email, $pass)){
			$_SESSION['confirm-msg'] = "Invalid URL";
			return;
		}
		else if($signUp->confirmUser($signUp->getCreatedID($email))){
			$_SESSION['confirm-msg'] = 'Your Sprred account has been activated. Click <a href="/">here</a> to login.';
			return;
		}
		else {
			$_SESSION['confirm-msg'] = 'An unknown error occurred. Try refreshing the page.';
			return;
		}
	}

}
?>