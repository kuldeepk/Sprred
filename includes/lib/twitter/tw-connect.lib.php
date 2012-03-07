<?php
require_once(dirname(__FILE__)."/../../import/twconnect/twitter.lib.php");

class TwConnect {
	private $username = null, $passwd = null, $twitter = null, $userInfo = null, $verified = null, $followers = null;
	
	public function TwConnect($username, $passwd) {
		$this->username = $username;
		$this->passwd = $passwd;
		$this->twitter = new Twitter($this->username, $this->passwd);
	}
	
	public function verifyUser() {
		if($this->verified != null)
			return $this->verified;
		$response = $this->twitter->verifyCredentials('json');
		$result = json_decode($response);
		$this->userInfo = $result;
		if($result->{'name'})
			return $this->verified=true;
		else
			return $this->verified=false;
	}
	
	public function getUserInfo() {
		if($this->userInfo) return $this->userInfo;
		$response = $this->twitter->verifyCredentials('json');
		$result = json_decode($response);
		return $this->userInfo=$result;
	}
	
	public function getFollowers() {
		if($this->followers) return $this->followers;
		$response = $this->twitter->getFollowers(array(), 'json');
		$result = json_decode($response);
		return $result;
	}

}
?>
