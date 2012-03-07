<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class NotificationsDB
{

	public static function setUpdates($userID){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Notifications', $userID, array(
		'updates' => 1
		), array('updates'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function resetUpdates($userID){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'Notifications', $userID, array(
		'updates' => 0
		), array('updates'));
		if(!$put)
			return false;
		else 
			return true;
	
	}
	
	public static function getNotify($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from '". DB_REGION ."Notifications' where itemName()='".$userID."'");
	
		$data = (string) $select->body->SelectResult->Item[0]->Name[0];
		if(!data)
			return null;
		$data = array();
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$data[ (string) $field->Name ] = (string)$field->Value;
		}
		
		return $data;
		
	}
	
	public static function deleteEntry($userID){
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes(DB_REGION.'Notifications', $userID);
		if(!$put)
			return false;
		else 
			return true;
	
	}

}

?>
