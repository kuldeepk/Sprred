<?php

require_once(dirname(__FILE__).'/../../conf/config.inc.php');

class ProfileInfoDB
{
	
	public static function checkEntry($userID) {
		$result = mysql_query("SELECT ID FROM profile_info WHERE ID=" . $userID);
		$row = mysql_fetch_row($result);
	
		if(is_null($row[0]))
			return false;
		else {
			return true;
		}
	}
	
	public static function createEntry($userID, $sname, $url, $title) {
		return mysql_query("INSERT INTO profile_info (ID, sname, url, name, created, modified) VALUES (". $userID .", '". $sname ."', '". $url ."', '". $title ."', NOW( ) , NOW( ) )");
	}
	
	public static function urlPresent($url) {
		$result = mysql_query("SELECT url FROM profile_info WHERE url = '". $url ."'");
		return (mysql_numrows($result) > 0);
	}
	
	public static function sprredNamePresent($sname) {
		$result = mysql_query("SELECT sname FROM profile_info WHERE sname = '". $sname ."'");
		return (mysql_numrows($result) > 0);
	}
	
	public static function updateEntry($userID, $url, $title) {
		return mysql_query("UPDATE profile_info SET url = '". $url ."', name = '". $title ."', isSprred = 1, modified = NOW() WHERE ID = " . $userID);
	}
	
}

?>
