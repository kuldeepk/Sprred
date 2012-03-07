<?php

/* Include Files *********************/
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
/*************************************/

class SprredInfo {
	public static function getUserID($sprred_name) {
		if($result=MemClient::get("userIDFromSprredName-". $sprred_name)){
			return $result;
		} else {
			$result = mysql_query("SELECT ID FROM profile_info WHERE sname='". $sprred_name ."'");
			$row = mysql_fetch_row($result);
		
			if(is_null($row[0]))
				return false;
			else {
				MemClient::set("userIDFromSprredName-". $sprred_name, $row[0], false, 2592000);
				return $row[0];
			}
		}
	}
}

?>
