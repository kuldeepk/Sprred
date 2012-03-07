<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class UserMetaDB
{
	public static function setMeta($userID, $meta_key, $meta_value){
		$sdb = new AmazonSDB();
		$put = $sdb->put_attributes(DB_REGION.'UserMeta', $userID.'_'.$meta_key, array(
			'userID' => $userID,
			'meta_key' => $meta_key,
			'meta_value' => $meta_value
		), array('userID', 'meta_key', 'meta_value'));
		if(!$put)
			return false;
		else 
			return true;	
	}
	
	public static function getMetaValue($userID, $meta_key){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select meta_value from ". DB_REGION ."UserMeta where userID='". $userID ."' and meta_key='". $meta_key ."'");
		if(!$select->body->SelectResult->Item[0])
			return null;
		$data = array();
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$data[ (string) $field->Name ] = (string) $field->Value;
		}
		return $data['meta_value'];
	}
	
	public static function deleteEntry($userID, $meta_key){
		$sdb = new AmazonSDB();
		$delete = $sdb->delete_attributes(DB_REGION.'UserMeta', $userID.'_'.$meta_key);
		if(!$put)
			return false;
		else 
			return true;
	
	}

}

?>
