<?php
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../classes/SignUp.class.php");
require_once(dirname(__FILE__)."/../classes/Notification.class.php");
require_once(dirname(__FILE__)."/../dao/UserInfo.dao.php");
include_once dirname(__FILE__)."/../lib/mail.lib.php";
/*************************************/

class ForgotPassController
{

function ForgotPassController() {
	$auth = new Auth();
	if($auth->checkLogin()){
		header('Location:dashboard/');
		exit(0);
	}
	if(isset($_POST['sub-forgot'])){
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		if(!$email || !filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
			$_SESSION['forgot-msg'] = "Please enter a valid email address";
			return;
		}
		$signUp = new SignUp();
		if(!$signUp->emailTaken($email)){
			$_SESSION['forgot-msg'] = "This email address doesn't exist in our database.";
			return;
		}
		else {
			$notify = new Notification($signUp->getCreatedID($email));
			$notify->passwordReset();
			$_SESSION['forgot-sent'] = true;
		}
	}
}

}
?>