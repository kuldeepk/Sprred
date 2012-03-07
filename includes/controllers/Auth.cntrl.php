<?php

/* Include Files *********************/
require_once("../conf/config.inc");
require_once("../includes/Auth.php"); 
/*************************************/

class AuthController
{

function AuthController(){
	$auth = new Auth();
	if($auth->checkLogin()){
		header('Location:dashboard/');
		exit(0);
	} 

	if(isset($_POST['sublogin'])){
		/* Check that all fields were typed in */
		if(!$_POST['email'] || !$_POST['pass']){
			$_SESSION['status']='Fill in all the required fields.';
			return;
		}
		if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
			$_SESSION['status']='Invalid Email or Password!';
		  	return;
		}
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$passwd = filter_input(INPUT_POST, 'pass', FILTER_SANITIZE_STRING);
		
		/* Checks that username is in database and password is correct */
		$md5pass = md5($passwd);
		$result = $auth->login($email, $md5pass);
		
		/* Check error codes */
		if($result == 1 || $result == 2){
		  $_SESSION['status']='Invalid Email or Password!';
		  return;
		}
		if($redirect = filter_input(INPUT_GET, 'sendmeto', FILTER_SANITIZE_URL)){
			$redirect = urldecode($redirect);
			$location = explode('redanyway.com', $redirect);
			header('Location:'.$location[1]);
		} else
			header('Location:dashboard/');
		exit(0);
	}
	if(isset($_POST['subTwLogin'])){
		if(!$_POST['twuname'] || !$_POST['twpasswd']){
			$_SESSION['tw-login-status']='Fill in all the required fields.';
			return;
		}
		$tw_uname = filter_input(INPUT_POST, 'twuname', FILTER_SANITIZE_STRING);
		$tw_passwd = filter_input(INPUT_POST, 'twpasswd', FILTER_SANITIZE_STRING);
		if($_POST['tw-remember'] == 'remember') $remember = true;
		else $remember = false;
		if(Connect::isTwConnected($tw_uname)){
			if($auth->login($tw_uname, $tw_passwd, 'twitter', $remember) != 0){
				$_SESSION['tw-login-status'] = 'Invalid Username or Password!';
		  		return;
			}
			header('Location:dashboard/');
			exit(0);
		} else {
			$_SESSION['tw-uname'] = $tw_uname;
			header('Location:reg-connect.php');
			exit(0);
		}
	}
	return;
}

}