<?php

require_once(dirname(__FILE__).'/../../conf/config.inc.php');

class UserDB
{
	
	public static function checkEntry($userID) {
		$result = mysql_query("SELECT ID FROM user WHERE ID=" . $userID);
		$row = mysql_fetch_row($result);
	
		if(is_null($row[0]))
			return false;
		else {
			return true;
		}
	}
	
	public static function emailPresent($email) {
		$result = mysql_query("SELECT email FROM user WHERE email = '". $email ."'");
		return (mysql_numrows($result) > 0);
	}
	
	public static function createUser($fullname, $email, $passwd){
		$result = mysql_query("INSERT INTO user (fullname, password, email, created, modified) VALUES ('".$fullname."', '".$passwd."', '".$email."', NOW( ) , NOW( ) )");
		return $result;
	}
	
	public static function getUserID($email){
		$result = mysql_query("SELECT ID FROM user WHERE email='" . $email . "'");
		$row = mysql_fetch_array($result);
		return $row['ID'];
	}
	
	public static function confirmUser($userID){
		return mysql_query("UPDATE user SET confirmed = 1, modified = NOW() WHERE ID = " . $userID);
	}
	
}

?>
