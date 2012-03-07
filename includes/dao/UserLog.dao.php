<?php

require_once dirname(__FILE__)."/../db/UserLog.db.php";

class UserLogDAO
{

	private $userID = null;
		
	function UserLogDAO($user_id) {
		$this->userID = $user_id;
	}
		
	function addLog($city, $country, $countryCode, $region, $zip_code) {
		return UserLogDB::addLog($this->userID, $city, $country, $countryCode, $region, $zip_code);
	}
	
	function updateLoggedInTime($loggedInTime){
		return UserLogDB::updateLoggedInTime($this->userID, $loggedInTime);
	}
	
	function getLog() {
		return UserLogDB::getLog($this->userID);
	}
	
}

?>