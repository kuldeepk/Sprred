<?php

/* Include Files *********************/
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../classes/SignUp.class.php");
require_once(dirname(__FILE__)."/../lib/connect.lib.php");
require_once(dirname(__FILE__)."/../lib/twitter/tw-connect-oauth.lib.php");
require_once(dirname(__FILE__)."/../lib/fbconnect/facebook.php");
/*************************************/

class RegConnectController
{

function RegConnectController() {
	$auth = new Auth();
	if($auth->checkLogin()){
		header('Location:dashboard/');
		exit(0);
	}
	
	if(isset($_POST['sub-fb-join'])){		
		$_SESSION['registered'] = true;
		
	   if(!$_POST['password'] || !$_POST['email'] || !$_POST['url']){
		  $_SESSION['regMsg'] = "Please enter all the required fields.";
		  $_SESSION['registered'] = false;
	   }
	   
	   $passwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	   $website = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
	   $md5pass = md5($passwd);
	   $updates=0;
	   if($_POST['updates'] && $_POST['updates'] == "recieve"){
	   		$updates=1;
	   }
	   $pic_save=0;
	   if($_POST['save-pic'] && $_POST['save-pic'] == "save"){
	   		$pic_save=1;
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
			$_SESSION['regMsg'] = "Please enter a valid Email address.";
			$_SESSION['registered'] = false;
	   }
	   if(strlen($website) < 3){
	   		$_SESSION['regMsg'] = "URL should be more than 2 characters.";
			$_SESSION['registered'] = false;
	   }
	   
	   $website = 'http://'.$website.'.sprred.com';
	   if(!filter_var($website, FILTER_VALIDATE_URL)){
	   		$_SESSION['regMsg'] = "Please enter a valid URL.";
			$_SESSION['registered'] = false;
	   }
	   
	   $signUp = new SignUp();
	   if($signUp->emailTaken($email)){
	   		if(filter_var($website, FILTER_VALIDATE_URL)){
				if($auth->isUserValid($email, $md5pass)){
					if(!$signUp->isSprredProfile($email)) {
						$signUp->registerExistingUser($email, $website, $updates);
						global $fb_api_key, $fb_secret;
						$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');		
						$fb_user_id = $fb->get_loggedin_user();
						$info = $fb->api_client->users_getInfo($fb_user_id, "name,pic_square");
						Connect::fbLinkNewUser($signUp->getCreatedID($email), $fb_user_id, $email, ($pic_save && $info[0]['pic_square']) ? $info[0]['pic_square'] : null);
					}
					$auth->login($email, $md5pass);
					header('Location:dashboard/');
					exit(0);
				} else {
					$_SESSION['regMsg'] = "This email is already in use. If you are already signed up on Redanyway, please use same password here.";
					$_SESSION['registered'] = false;
				}
			}
	   }
	   if($signUp->urlTaken($website)){
			$_SESSION['regMsg'] = "This URL is already in use.";
			$_SESSION['registered'] = false;
	   }
		
	   if($_SESSION['registered'])
	   {
	   		global $fb_api_key, $fb_secret;
			$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');		
			$fb_user_id = $fb->get_loggedin_user();
			$info = $fb->api_client->users_getInfo($fb_user_id, "name,pic_square");
			$regResult = $signUp->register($email, $md5pass, $website, $updates, $info[0]['name']);
			Connect::fbLinkNewUser($signUp->getCreatedID($email), $fb_user_id, $email, ($pic_save && $info[0]['pic_square']) ? $info[0]['pic_square'] : null);
			if(!$regResult){
				$_SESSION['regMsg'] = "Our servers faced some unexpected error while registering. Please try again.";
				$_SESSION['registered'] = false;
				return;
			}
			$signUp->confirmEmail($email);
			$auth->login($email, $md5pass);
			$auth->login(null, null, 'facebook');
			header('Location:dashboard/');
			exit(0);
	   }
	} else if(isset($_POST['sub-tw-join'])){
		$_SESSION['registered'] = true;
		
		if(!$_POST['password'] || !$_POST['email'] || !$_POST['url']){
		  $_SESSION['regMsg'] = "Please enter all the required fields.";
		  $_SESSION['registered'] = false;
	   }
	   
	   $passwd = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_STRING);
	   $email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_EMAIL);
	   $website = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
	   $md5pass = md5($passwd);
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
			$_SESSION['regMsg'] = "Please enter a valid Email address.";
			$_SESSION['registered'] = false;
	   }
	   if(strlen($website) < 3){
	   		$_SESSION['regMsg'] = "URL should be more than 2 characters.";
			$_SESSION['registered'] = false;
	   }
	   
	   $website = 'http://'.$website.'.sprred.com';
	   if(!filter_var($website, FILTER_VALIDATE_URL)){
	   		$_SESSION['regMsg'] = "Please enter a valid URL.";
			$_SESSION['registered'] = false;
	   }
	   
	   $signUp = new SignUp();
	   if($signUp->emailTaken($email)){
	   		if(filter_var($website, FILTER_VALIDATE_URL)){
				if($auth->isUserValid($email, $md5pass)){
					if(!$signUp->isSprredProfile($email)) {
						$signUp->registerExistingUser($email, $website, $updates);
						$twitter = $_SESSION['twObj'];
						$info = $twitter->getUserInfo();
						Connect::twLinkUser($signUp->getCreatedID($email), $_SESSION['tw-uname'], $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
					}
					$auth->login($email, $md5pass);
					header('Location:dashboard/');
					exit(0);
				} else {
					$_SESSION['regMsg'] = "This email is already in use. If you are already signed up on Redanyway, please use same password here.";
					$_SESSION['registered'] = false;
				}
			}
	   }
	   if($signUp->urlTaken($website)){
			$_SESSION['regMsg'] = "This URL is already in use.";
			$_SESSION['registered'] = false;
	   }
	   
	   /* Add the new account to the database */
	   if($_SESSION['registered'])
	   {
	   		$twitter = $_SESSION['twObj'];
			$info = $twitter->getUserInfo();
			$regResult = $signUp->register($email, $md5pass, $website, $updates, $info->{'name'});
			Connect::twLinkUser($signUp->getCreatedID($email), $_SESSION['tw-uname'], $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
			if(!$regResult){
				$_SESSION['regMsg'] = "Our servers faced some unexpected error while registering. Please try again.";
				$_SESSION['registered'] = false;
				return;
			}
			$signUp->confirmEmail($email);
			$auth->login($email, $md5pass);
			unset($_SESSION['oauth_access_token']);
			unset($_SESSION['oauth_access_token_secret']);
			unset($_SESSION['twObj']);
			header('Location:dashboard/');
			exit(0);
	   } else
	   		return;
	} else if(isset($_POST['sub-tw-login'])){
		/* Check that all fields were typed in */
		if(!$_POST['log-email'] || !$_POST['log-passwd']){
			$_SESSION['log-status']='Fill in all the required fields.';
			return;
		}
		if(!filter_input(INPUT_POST, 'log-email', FILTER_VALIDATE_EMAIL)){
			$_SESSION['log-status']='Invalid Email or Password!';
		  	return;
		}
		$email = filter_input(INPUT_POST, 'log-email', FILTER_SANITIZE_EMAIL);
		$passwd = filter_input(INPUT_POST, 'log-passwd', FILTER_SANITIZE_STRING);
		
		/* Checks that username is in database and password is correct */
		$md5pass = md5($passwd);
		$result = $auth->login($email, $md5pass);
		
		/* Check error codes */
		if($result == 1 || $result == 2){
		  $_SESSION['log-status']='Invalid Email or Password!';
		  return;
		}
		
		Connect::twLinkUser($_SESSION['userId'], $_SESSION['tw-uname'], $_SESSION['oauth_access_token'], $_SESSION['oauth_access_token_secret']);
		unset($_SESSION['oauth_access_token']);
		unset($_SESSION['oauth_access_token_secret']);
		
		header('Location:dashboard/');
		exit(0);
	}
	
	if(isset($_SESSION['tw-uname'])){
		return;
	} else if(isset($_GET['fb'])){
		if($auth->login(null, null, 'facebook') == 0){
			header('Location:dashboard/');
			exit(0);
		} else {
			if($fb_id = $auth->isFBLoggedin()){
				if(Connect::fbLinkExistUser($fb_id)){
					if($auth->login(null, null, 'facebook') == 0){
						header('Location:dashboard/');
						exit(0);
					}
				} else {
					$_SESSION['fb-reg-id'] = $fb_id;
					return;
				}
			}
		}
	}
}

}

?>