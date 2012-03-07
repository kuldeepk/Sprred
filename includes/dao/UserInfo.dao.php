<?php

require_once(dirname(__FILE__).'/../db/User.db.php');
require_once(dirname(__FILE__).'/../db/UserInfo.db.php');
require_once(dirname(__FILE__).'/../db/ProfileInfo.db.php');
require_once(dirname(__FILE__).'/../lib/mem-client.lib.php');


class UserInfoDAO
{

	private $userId;
	private $profileID = null;
	private $fullName = null;
	private $email = null;
	private $profileImage = null;
	private $profileImageSource = null;
	private $sex = null;
	private $birthDate = null;
	private $hometown = null;
	private $aboutme = null;
	private $profileHandler = null;
	private $profileURL = null;
	private $profileName = null;
	private $profileDesc = null;
	private $profileTags = null;
	private $isVerified = null;
	private $isActive = null;
	
	function UserInfoDAO($user_id){
		$this->userId = $user_id;
	}
	
	function userInfoExists() {
		return UserInfoDB::checkEntry($this->userId);
	}
	
	function createEntry() {
		if(!$this->userInfoExists()){
			return UserInfoDB::createEntry($this->userId);
		} else
			return true;
	}
	
	function createProfileEntry($sname, $website, $title) {
		if(!$this->getProfileID()){
			return  ProfileInfoDB::createEntry($this->userId, $sname, $website, $title);
		} else
			return true;
	}

	function getProfileID() {
		if($this->profileID){
			return $this->profileID;
		} elseif($result=MemClient::get("profileID-". $this->userId)){
			$this->profileID = $result;
			return $this->profileID;
		} else {
			$result = mysql_query("SELECT profile_ID FROM profile_info WHERE ID=" . $this->userId);
			if(!$result)
				return false;
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileID-". $this->userId, $row[0], false, 2592000);
				$this->profileID = $row[0];
				return $this->profileID;
			}
		}
	}
	
	function getFullName() {
		if($this->fullName){
			return $this->fullName;
		} elseif($result=MemClient::get("fullname-". $this->userId)){
			$this->fullName = $result;
			return $this->fullName;
		} else {
			$result = mysql_query("SELECT fullname FROM user WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("fullname-". $this->userId, $row[0], false, 2592000);
				$this->fullName = $row[0];
				return $this->fullName;
			}
		}
	}
	
	function changeEmail($email) {
		MemClient::delete("email-". $this->userId);
		$this->email=null;
		return mysql_query("UPDATE user SET email = '" . $email . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getEmail() {
		if($this->email){
			return $this->email;
		} elseif($result=MemClient::get("email-". $this->userId)){
			$this->email = $result;
			return $this->email;
		} else {
			$result = mysql_query("SELECT email FROM user WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("email-". $this->userId, $row[0], false, 2592000);
				$this->email = $row[0];
				return $this->email;
			}
		}
	}
	
	function changeProfileImage($profileImage) {
		MemClient::delete("profileImage-". $this->userId);
		$this->profileImage=null;
		if($profileImage)
			return mysql_query("UPDATE user_info SET image = '" . $profileImage . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET image = null, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileImage($size=35) {
		if($this->profileImage){
			return $this->profileImage;
		} elseif($result=MemClient::get("profileImage-". $this->userId)){
			$this->profileImage = $result;
			return $this->profileImage;
		} else {
			$result = mysql_query("SELECT image FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileImage-". $this->userId, $row[0], false, 2592000);
				$this->profileImage = $row[0];
				return $this->profileImage;
			}
		}
	}
	
	function changeProfileImageSource($source) {
		MemClient::delete("profileImageSource-". $this->userId);
		$this->profileImageSource=null;
		if(profileImageSource)
			return mysql_query("UPDATE user_info SET image_source = '" . $source . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET image_source = null, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileImageSource() {
		if($this->profileImageSource){
			return $this->profileImageSource;
		} elseif($result=MemClient::get("profileImageSource-". $this->userId)){
			$this->profileImageSource = $result;
			return $this->profileImageSource;
		} else {
			$result = mysql_query("SELECT image_source FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileImageSource-". $this->userId, $row[0], false, 2592000);
				$this->profileImageSource = $row[0];
				return $this->profileImageSource;
			}
		}
	}
	
	function changeSex($sex) {
		MemClient::delete("sex-". $this->userId);
		$this->sex=null;
		if($sex)
			return mysql_query("UPDATE user_info SET sex = '" . $sex . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET sex = 'U', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getSex() {
		if($this->sex){
			return $this->sex;
		} elseif($result=MemClient::get("sex-". $this->userId)){
			$this->sex = $result;
			return $this->sex;
		} else {
			$result = mysql_query("SELECT sex FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("sex-". $this->userId, $row[0], false, 2592000);
				$this->sex = $row[0];
				return $this->sex;
			}
		}
	}
	
	function changeBirthDate($birthDate) {
		MemClient::delete("birthDate-". $this->userId);
		$this->birthDate=null;
		if($birthDate)
			return mysql_query("UPDATE user_info SET birthdate = '" . $birthDate . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET birthdate = null, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getBirthDate() {
		if($this->birthDate){
			return $this->birthDate;
		} elseif($result=MemClient::get("birthDate-". $this->userId)){
			$this->birthDate = $result;
			return $this->birthDate;
		} else {
			$result = mysql_query("SELECT birthdate FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
			echo mysql_error();
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("birthDate-". $this->userId, $row[0], false, 2592000);
				$this->birthDate = $row[0];
				return $this->birthDate;
			}
		}
	}
	
	function changeHometown($hometown) {
		MemClient::delete("hometown-". $this->userId);
		$this->hometown=null;
		if($hometown)
			return mysql_query("UPDATE user_info SET hometown = '" . $hometown . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET hometown = null, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getHometown() {
		if($this->hometown){
			return $this->hometown;
		} elseif($result=MemClient::get("hometown-". $this->userId)){
			$this->hometown = $result;
			return $this->hometown;
		} else {
			$result = mysql_query("SELECT hometown FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("hometown-". $this->userId, $row[0], false, 2592000);
				$this->hometown = $row[0];
				return $this->hometown;
			}
		}
	}
	
	function changeAboutme($aboutme) {
		MemClient::delete("aboutMe-". $this->userId);
		$this->aboutme=null;
		if($aboutme)
			return mysql_query("UPDATE user_info SET aboutme = '" . $aboutme . "', modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE user_info SET aboutme = null, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getAboutme() {
		if($this->aboutme){
			return $this->aboutme;
		} elseif($result=MemClient::get("aboutMe-". $this->userId)){
			$this->aboutme = $result;
			return $this->aboutme;
		} else {
			$result = mysql_query("SELECT aboutme FROM user_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("aboutMe-". $this->userId, $row[0], false, 86400);
				$this->aboutme = $row[0];
				return $this->aboutme;
			}
		}
	}
	
	function changeProfileHandler($handler) {
		MemClient::delete("profileHandler-". $this->userId);
		$this->profileHandler=null;
		if($handler == null)
			return mysql_query("UPDATE profile_info SET sname = NULL, modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE profile_info SET sname = '" . $handler . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileHandler() {
		if($this->profileHandler){
			return $this->profileHandler;
		} elseif($result=MemClient::get("profileHandler-". $this->userId)){
			$this->profileHandler = $result;
			return $this->profileHandler;
		} else {
			$result = mysql_query("SELECT sname FROM profile_info WHERE ID=". $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileHandler-". $this->userId, $row[0], false, 2592000);
				$this->profileHandler = $row[0];
				return $this->profileHandler;
			}
		}
	}
	
	function changeProfileURL($url) {
		MemClient::delete("profileURL-". $this->userId);
		$this->profileURL=null;
		if($url == null)
			return mysql_query("UPDATE profile_info SET url = NULL, modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE profile_info SET url = '" . $url . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileURL() {
		if($this->profileURL){
			return $this->profileURL;
		} elseif($result=MemClient::get("profileURL-". $this->userId)){
			$this->profileURL = $result;
			return $this->profileURL;
		} else {
			$result = mysql_query("SELECT url FROM profile_info WHERE ID=". $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileURL-". $this->userId, $row[0], false, 2592000);
				$this->profileURL = $row[0];
				return $this->profileURL;
			}
		}
	}
	
	function changeProfileName($name) {
		MemClient::delete("profileName-". $this->userId);
		$this->profileName=null;
		if($name == null)
			return mysql_query("UPDATE profile_info SET name = NULL, modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE profile_info SET name = '" . $name . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileName() {
		if($this->profileName){
			return $this->profileName;
		} elseif($result=MemClient::get("profileName-". $this->userId)){
			$this->profileName = $result;
			return $this->profileName;
		} else {
			$result = mysql_query("SELECT name FROM profile_info WHERE ID=". $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileName-". $this->userId, $row[0], false, 2592000);
				$this->profileName = $row[0];
				return $this->profileName;
			}
		}
	}
	
	function changeProfileDesc($desc) {
		MemClient::delete("profileDesc-". $this->userId);
		$this->profileDesc=null;
		if($desc == null)
			return mysql_query("UPDATE profile_info SET description = NULL, modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE profile_info SET description = '" . $desc . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileDesc() {
		if($this->profileDesc){
			return $this->profileDesc;
		} elseif($result=MemClient::get("profileDesc-". $this->userId)){
			$this->profileDesc = $result;
			return $this->profileDesc;
		} else {
			$result = mysql_query("SELECT description FROM profile_info WHERE ID=". $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileDesc-". $this->userId, $row[0], false, 2592000);
				$this->profileDesc = $row[0];
				return $this->profileDesc;
			}
		}
	}
	
	function changeProfileTags($tags) {
		MemClient::delete("profileTags-". $this->userId);
		$this->profileTags=null;
		if($tags == null)
			return mysql_query("UPDATE profile_info SET tags = NULL, modified = NOW() WHERE ID = " . $this->userId);
		else
			return mysql_query("UPDATE profile_info SET tags = '" . $tags . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getProfileTags() {
		if($this->profileTags){
			return $this->profileTags;
		} elseif($result=MemClient::get("profileTags-". $this->userId)){
			$this->profileTags = $result;
			return $this->profileTags;
		} else {
			$result = mysql_query("SELECT tags FROM profile_info WHERE ID=". $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("profileTags-". $this->userId, $row[0], false, 2592000);
				$this->profileTags = $row[0];
				return $this->profileTags;
			}
		}
	}
	
	function setVerify() {
		MemClient::delete("isVerified-". $this->userId);
		$this->isVerified=null;
		return mysql_query("UPDATE profile_info SET verified = 1, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function resetVerify() {
		MemClient::delete("isVerified-". $this->userId);
		$this->isVerified=null;
		return mysql_query("UPDATE profile_info SET verified = 0, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function isVerified() {
		if($this->isVerified){
			return $this->isVerified;
		} elseif($result=MemClient::get("isVerified-". $this->userId)){
			$this->isVerified = $result;
			return $this->isVerified;
		} else {
			$result = mysql_query("SELECT verified FROM profile_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("isVerified-". $this->userId, $row[0], false, 86400);
				$this->isVerified = $row[0];
				return $this->isVerified;
			}
		}
	}
	
	function setActive() {
		MemClient::delete("isActive-". $this->userId);
		$this->isActive=null;
		return mysql_query("UPDATE profile_info SET status = 1, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function resetActive() {
		MemClient::delete("isActive-". $this->userId);
		$this->isActive=null;
		return mysql_query("UPDATE profile_info SET status = 0, modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function isActive() {
		if($this->isActive){
			return $this->isActive;
		} elseif($result=MemClient::get("isActive-". $this->userId)){
			$this->isActive = $result;
			return $this->isActive;
		} else {
			$result = mysql_query("SELECT status FROM profile_info WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("isActive-". $this->userId, $row[0], false, 86400);
				$this->isActive = $row[0];
				return $this->isActive;
			}
		}
	}

}
?>