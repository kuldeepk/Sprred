<?php
/* Include Files *********************/
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__)."/../dao/Connect.dao.php");
require_once(dirname(__FILE__)."/../dao/UserLog.dao.php");
require_once(dirname(__FILE__)."/../lib/fbconnect/facebook.php");
require_once(dirname(__FILE__)."/../lib/connect.lib.php");
require_once(dirname(__FILE__)."/../lib/twitter/tw-connect-oauth.lib.php");
/*************************************/

class Auth
{
	
	static public function getLoggedInID(){
		return $_SESSION['userId'];
	}

	function login($username, $password, $service = 'redanyway', $remember = true) {
	
		if($service == 'redanyway'){
			/* Verify that user is in database */
			$result = mysql_query("SELECT password FROM user WHERE email='" . $username . "'");
			if(!$result || (mysql_num_rows($result) < 1)){
			  return 1; //Indicates username failure
			}
			/* Retrieve password from result, strip slashes */
			$dbarray = mysql_fetch_array($result);
			$dbarray['password']  = stripslashes($dbarray['password']);
			$password = stripslashes($password);
			
			/* Validate that password is correct */
			if($password == $dbarray['password']){
				/* Username and password correct, register session variables */
				$_SESSION['username'] = $username;
				$_SESSION['login-service'] = $service;
				$_SESSION['userId'] = $this->getUserID();
				$_SESSION['loggedIn'] = true;
				if($remember){
					setcookie("cookuname", $_SESSION['username'], time()+60*60*24*100, "/");
				  	setcookie("cookpass", $password, time()+60*60*24*100, "/");
					setcookie("cookservice", $service, time()+60*60*24*100, "/");
				}
				$log = new UserLogDAO($_SESSION['userId']);
				$log->updateLoggedInTime(time());
				return 0; //Success! Username and password confirmed
			}
			else{
			  return 2; //Indicates password failure
			}
		} else if($service == 'twitter'){
			$twitter = new TwConnectOAuth($username, $password);
			if($twitter->verifyUser()) {
				$result = Connect::isTwConnected($username, $password);
				if(!$result){
				  return 1; //Indicates username failure
				}
				$user_id = $result;
				
				$_SESSION['username'] = $twitter->getTwUsername();
				$_SESSION['login-service'] = $service;
				$_SESSION['userId'] = $user_id;
				$_SESSION['loggedIn'] = true;
				/*if($remember) {
					setcookie("cookuname", $_SESSION['username'], time()+60*60*24*100, "/");
				  	setcookie("cookpass", $this->base64_pass_encode($password), time()+60*60*24*100, "/");
					setcookie("cookservice", $service, time()+60*60*24*100, "/");
				}*/
				return 0;
			} else
				return 2;
		} else if($service == 'facebook') {
			global $fb_api_key, $fb_secret;
			$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');		
			$fb_user_id = $fb->get_loggedin_user();
			if($fb_user_id){
				try {
					$info = $fb->api_client->users_getInfo($fb_user_id,"name,email_hashes");
					if($user_id = Connect::isFBUserLinked($fb_user_id)){
						$_SESSION['login-service'] = $service;
						$_SESSION['fb-user-id'] = $fb_user_id;
						$_SESSION['userId'] = $user_id;
						$_SESSION['username'] = $this->getUserEmail();
						$_SESSION['loggedIn'] = true;
						return 0;
					} else
						return 2;
				} catch(Exception $e) {
					return 2;
				}			
			} else {
				return 2;
			}
		}
	   
	}
	
	function isUserValid($username, $md5pass) {
		$result = mysql_query("SELECT password FROM user WHERE email = '" . $username . "' AND password = '" . $md5pass . "'");
		if(!$result || (mysql_num_rows($result) < 1)){
		  return false; //Indicates username failure
		} else
			return true;
	}
	
	function isFBLoggedin() {
		global $fb_api_key, $fb_secret;
		$fb = new Facebook($fb_api_key, $fb_secret, false, 'connect.facebook.com');		
		$fb_user_id = $fb->get_loggedin_user();
		if($fb_user_id){
			try {
				$info = $fb->api_client->users_getInfo($fb_user_id,"name,email_hashes");
				return $fb_user_id;
			} catch(Exception $e) {
				return false;
			}			
		} else {
			return false;
		}
	}
	
	/**
	 * getuserID - returns the ID of user who has already previously
	 * logged in.
	 */
	private function getUserID(){
		$result = mysql_query("SELECT ID FROM user WHERE email='" . $_SESSION['username'] . "'");
		$row = mysql_fetch_array($result);
		return $row['ID'];
	}
	
	private function getUserEmail(){
		$result = mysql_query("SELECT email FROM user WHERE ID='" . $_SESSION['userId'] . "'");
		$row = mysql_fetch_array($result);
		return $row['email'];
	}
	
	/**
	 * checkLogin - Checks if the user has already previously
	 * logged in, and a session with the user has already been
	 * established. Also checks to see if user has been remembered.
	 * If so, the database is queried to make sure of the user's
	 * authenticity. Returns true if the user has logged in.
	 */
	function checkLogin(){
		/* Check if facebook is logged-in */
		if(isset($_SESSION['fb-user-id'])){
			if(isset($_SESSION['loggedIn']) && isset($_SESSION['userId'])){
				return true;
			}
		}	
		
		if(isset($_SESSION['loggedIn']) && isset($_SESSION['userId'])){
			return true;
		}
		
	   /* Check if user has been remembered */
	   if(isset($_COOKIE['cookuname']) && isset($_COOKIE['cookpass'])){
	      $username = $_COOKIE['cookuname'];
		  $passwd = $_COOKIE['cookpass'];
		  $service = $_COOKIE['cookservice'];
	   }
	
	   /* Username and password have been set */
	   if(isset($username) && isset($passwd) && isset($service)){
	      /* Confirm that username and password are valid */
	      if($this->login($username, $passwd, $service, false) != 0){
	         /* Variables are incorrect, user not logged in */
	         return false;
	      }
	      return true;
	   }
	   /* User not logged in */
	   else{
	      return false;
	   }
	}
	
	function logout() {
		/**
		* Delete cookies - the time must be in the past,
		* so just negate what you added when creating the
		* cookie.
		*/
		if(isset($_COOKIE['cookuname']) || isset($_COOKIE['cookpass'])){
			setcookie("cookuname", "", time()-60*60*24*101, "/");
			setcookie("cookpass", "", time()-60*60*24*101, "/");
			setcookie("cookservice", "", time()-60*60*24*101, "/");
		}
	
		/* Kill session variables */	
		unset($_SESSION['loggedIn']);
		unset($_SESSION['username']);
		unset($_SESSION['userId']);
		unset($_SESSION['fb-user-id']);
		unset($_SESSION['login-service']);
		$_SESSION = array(); // reset session array
		session_destroy();   // destroy session.
		
	}
	
	function getPass($email) {
		$result = mysql_query("SELECT password FROM user WHERE email='" . $email . "'");
		if(mysql_num_rows($result) < 1){
			return null;
		}
		else {
			$row = mysql_fetch_assoc($result);
			return $row['password'];		
		}
	}
	
	function changePass($email, $pass) {
		$status = mysql_query("UPDATE user SET password = '". $pass ."', modified = NOW() WHERE email = '". $email ."'");
		return $status;
	}
	
	function doMatch($email, $pass) {
		$result = mysql_query("SELECT ID FROM user WHERE email='" . $email . "' AND password='". $pass ."'");
		if(mysql_num_rows($result) < 1){
			return false;
		}
		else {
			return true;		
		}
	}
	
	function base64_url_encode($input) {
	    return strtr(base64_encode($input.'absurd_22'), '+/=', '-_~');
	}
	
	function base64_url_decode($input) {
	    return substr(base64_decode(strtr($input, '-_~', '+/=')), 0, -9);
	}
	
	function base64_pass_encode($input) {
	    return strtr(base64_encode($input.'funky_naussau23'), '+/=', '-_~');
	}
	
	function base64_pass_decode($input) {
	    return substr(base64_decode(strtr($input, '-_~', '+/=')), 0, -15);
	}

}

?>