<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class UserOptionsDB
{
	public static function setOption($userID, $option_key, $option_value){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'UserOptions', $userID.'_'.$option_key, array(
			'userID' => $userID,
			'option_key' => $option_key,
			'option_value' => $option_value
		), array('userID', 'option_key', 'option_value'));
		if(!$put)
			return false;
		else 
			return true;	
	}
	
	public static function getOptionValue($userID, $option_key){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select option_value from ". DB_REGION ."UserOptions where userID='". $userID ."' and option_key='". $option_key ."'");
		if(!$select->body->SelectResult->Item[0])
			return null;
		return $select->body->SelectResult->Item[0]->Attribute->Value[0];
	}
	
	public static function deleteEntry($userID, $option_key){
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes(DB_REGION.'UserOptions', $userID.'_'.$option_key);
		if(!$put)
			return false;
		else 
			return true;
	
	}

}

?>
