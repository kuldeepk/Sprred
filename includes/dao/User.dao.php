<?php

class UserDAO
{

	private $userId = null;
	private $fullName = null;
	private $email = null;
	private $pass = null;
		
	function UserDAO($user_id) {
		$this->userId = $user_id;
	}
	
	function getUserId() {
		return $this->userId;
	}
	
	function changeFullName($fullName) {
		MemClient::delete("fullname-". $this->userId);
		$this->fullName=null;
		return mysql_query("UPDATE user SET fullname = '" . $fullName . "', modified = NOW() WHERE ID = " . $this->userId);
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
	
	function changePassword($pass) {
		$this->pass=null;
		return mysql_query("UPDATE user SET password = '" . $pass . "', modified = NOW() WHERE ID = " . $this->userId);
	}
	
	function getPassword() {
		if($this->pass){
			return $this->pass;
		}
		else {
			$result = mysql_query("SELECT password FROM user WHERE ID=" . $this->userId);
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				$this->pass = $row[0];
				return $this->pass;
			}
		}
	}

}

?>