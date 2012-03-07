<?php
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../classes/SignUp.class.php");
require_once(dirname(__FILE__)."/../dao/UserInfo.dao.php");
/*************************************/

class ResetPassController
{

function ResetPassController() {
	$auth = new Auth();
	if(isset($_POST['sub-reset'])){
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$confirm = filter_input(INPUT_POST, 'confirm', FILTER_SANITIZE_STRING);
		if($password != $confirm){
			$_SESSION['reset-msg'] = "Passwords do not match. Please enter again.";
			return;
		}
		if($auth->changePass($_SESSION['email'], md5($password))){
			$_SESSION['reset-done'] = true;
			return;
		}
		else {
			$_SESSION['reset-msg'] = "An unknown error occurred. Please try again.";
			return;
		}
		return;
	}
	if(!isset($_GET['auth']) || !isset($_GET['id'])){
		$_SESSION['reset-invalid'] = true;
		return;
	}
	$pass = $auth->base64_url_decode($_GET['id']);
	$email = $auth->base64_url_decode($_GET['auth']);
	$_SESSION['email'] = $email;
	$signUp = new SignUp();
	if(!$signUp->emailTaken($email) || !$auth->doMatch($email, $pass)){
		$_SESSION['reset-invalid'] = true;
		return;
	}
}

}
?>