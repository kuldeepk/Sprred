<?php

require_once(dirname(__FILE__).'/../../conf/config.inc.php');

class UserInfoDB
{
	
	public static function checkEntry($userID) {
		$result = mysql_query("SELECT ID FROM user_info WHERE ID=" . $userID);
		if(!$result)
			return false;
		$row = mysql_fetch_row($result);
	
		if(is_null($row[0]))
			return false;
		else {
			return true;
		}
	}
	
	public static function createEntry($userID) {
		return mysql_query("INSERT INTO user_info (ID, created, modified) VALUES (". $userID .", NOW( ) , NOW( ) )");
	}
	
}

?>
