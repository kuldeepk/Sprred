<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class UserLogDB
{
	public static function addLog($userID, $city, $country, $countryCode, $region, $zip_code){
		$sdb = new AmazonSDB();
		$time = time();
		$put = $sdb->put_attributes(DB_REGION.'UserLog', $userID, array(
			'userID' => $userID,
			'city' => $city,
			'country' => $country,
			'countryCode' => $countryCode,
			'region' => $region,
			'zip_code' => $zip_code,
			'modified' => $time
		), array('userID', 'city', 'country', 'countryCode', 'region', 'zip_code', 'modified'));
		if(!$put)
			return false;
		else 
			return true;	
	}
	
	public static function updateLoggedInTime($userID, $loggedInTime){
		$sdb = new AmazonSDB();
		$time = time();
		$put = $sdb->put_attributes(DB_REGION.'UserLog', $userID, array(
			'userID' => $userID,
			'logged_in_time' => $loggedInTime,
			'modified' => $time
		), array('userID', 'logged_in_time', 'modified'));
		if(!$put)
			return false;
		else 
			return true;
	}
	
	public static function getLog($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ". DB_REGION ."UserLog where userID='". $userID ."'");
		if(!$select->body->SelectResult->Item[0])
			return null;
		$data = array();
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$data[ (string) $field->Name ] = (string) $field->Value;
		}
		return $data;
	}
	
	public static function deleteEntry($userID){
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes(DB_REGION.'UserLog', $userID);
		if(!$put)
			return false;
		else 
			return true;
	
	}

}

?>
