<?php
require_once(dirname(__FILE__)."/twitteroauth/twitterOAuth.php");

class TwConnectOAuth {
	private $access_token = null, $token_secret = null, $twitter = null, $verified = null, $followers = null;
	public $userInfo = null;
	
	public function TwConnectOAuth($access_token, $token_secret) {
		$this->access_token = $access_token;
		$this->token_secret = $token_secret;
		$this->twitter = new TwitterOAuth($this->access_token, $this->token_secret);
	}
	
	public function verifyUser() {
		if($this->verified != null)
			return $this->verified;
		$response = $this->twitter->OAuthRequest('https://twitter.com/account/verify_credentials.json', array(), 'GET');
		$result = json_decode($response);
		$this->userInfo = $result;
		if($result->{'name'})
			return $this->verified=true;
		else
			return $this->verified=false;
	}
	
	public function getTwUsername() {
		if(!$this->userInfo) {
			$this->verifyUser();
		}
		return $this->userInfo->{'screen_name'};
	}
	
	public function updateStatus($status) {
		if($this->verified == null) {
			if(!$this->verifyUser())
				return false;
		}
		
		$response = $this->twitter->OAuthRequest('https://twitter.com/statuses/update.json', array('status' => $status), 'POST');
		$result = json_decode($response);
		if($result->{'text'})
			return true;
		else
			return false;		
	}
	
	public function getUserInfo() {
		if($this->userInfo) return $this->userInfo;
		else $this->verifyUser();
		return $this->userInfo;
	}
	
	public function getFollowers() {
		if($this->followers) return $this->followers;
		$response = $this->twitter->OAuthRequest('https://twitter.com/statuses/followers.json', array('status' => $status), 'GET');
		$result = json_decode($response);
		return $result;
	}

}
?>
