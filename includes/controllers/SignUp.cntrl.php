<?php

/* Include Files *********************/
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../classes/SignUp.class.php");
/*************************************/

class SignUpController
{

function SignUpController() {
	$auth = new Auth();
	if($auth->checkLogin()){
		header('Location:dashboard/');
		exit(0);
	}
	
	if(isset($_POST['sub-join'])){
		$_SESSION['registered'] = true;
		
	   if(!$_POST['password'] || !$_POST['email'] || !$_POST['sname']){
		  $_SESSION['regMsg'] = "Please enter all the required fields.";
		  $_SESSION['registered'] = false;
	   }
	   
	   $passwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	   $sname = filter_input(INPUT_POST, 'sname', FILTER_SANITIZE_URL);
	   $md5pass = md5($passwd);
	   $sname = strtolower($sname);
	   $website = 'http://'.$sname.'.sprred.com';
	   $updates=0;
	   if($_POST['updates'] && $_POST['updates'] == "recieve"){
	   		$updates=1;
	   }
	
	   if(strlen($passwd) > 30){
		  $_SESSION['regMsg'] = "The password is longer than 30 characters, please shorten it.";
		  $_SESSION['registered'] = false;
	   }
	   if(strlen($passwd) < 6){
			 $_SESSION['regMsg'] = "The password is less than 6 characters, please lengthen it.";
			 $_SESSION['registered'] = false;
	   }
	   if(!filter_input(INPUT_POST, 'email', FILTER_VALIDATE_EMAIL)){
			$_SESSION['regMsg'] = "Please enter a valid email address.";
			$_SESSION['registered'] = false;
	   }
	   if(strlen($sname) < 3){
	   		$_SESSION['regMsg'] = "Your Sprred name should be more than 2 characters.";
			$_SESSION['registered'] = false;
	   }
	   
	   if(!ereg("^[A-Za-z0-9\-]{3,30}$", $sname)){
	   		$_SESSION['regMsg'] = "Please enter a valid Sprred name. No special characters, please.";
			$_SESSION['registered'] = false;
	   }
	   
	   if(!filter_var($website, FILTER_VALIDATE_URL)){
	   		$_SESSION['regMsg'] = "Please enter a valid Sprred name. No special characters, please.";
			$_SESSION['registered'] = false;
	   }
	   
	   $signUp = new SignUp();
	   if($signUp->emailTaken($email)){
			if($auth->isUserValid($email, $md5pass)){
				$auth->login($email, $md5pass);
				header('Location:dashboard/');
				exit(0);
			} else {
				$_SESSION['regMsg'] = "This email is already in use.";
				$_SESSION['registered'] = false;
			}
	   }
	   $forbiddenSNames = array("test", "prod", "prod1", "prod2", "beta", "stg", "blog", "sprredname", "theofficialsprred", "officialsprred", "photos", "videos", "info", "profile", "api", "support", "developer", "team", "about", "contact", "upload", "help", "faq", "admin", "share", "code", "redanyway", "threepoint", "reach", "aboutus", "www", "htttp", "sperm", "semen", "masturbate", "genital", "genitals", "motherfucker", "sex", "milf", "pussy", "tits");
	   if($signUp->sprredNameTaken($sname) || in_array($sname, $forbiddenSNames)){
			$_SESSION['regMsg'] = "This Sprred name is already in use.";
			$_SESSION['registered'] = false;
	   }
	  
	   if($_SESSION['registered'])
	   {
			$regResult = $signUp->register($email, $md5pass, $sname, $website, $updates);
			if(!$regResult){
				$_SESSION['regMsg'] = "Our servers faced some unexpected error while registering. Please try again.";
				$_SESSION['registered'] = false;
				return;
			}
			$auth->login($email, $md5pass);
			header('Location:dashboard/');
			exit(0);
	   }
	} else if(isset($_POST['sub-login'])){
		$passwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
		$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
		$md5pass = md5($passwd);
		if(!$result = $auth->login($email, $md5pass)){
			header('Location:dashboard/');
			exit(0);
		} else {
			$_SESSION['loginMsg'] = "Invalid email or password.";
			return;
		}
	} else
		return;
}

}

?>