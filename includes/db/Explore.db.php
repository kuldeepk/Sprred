<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class CommentsDB
{

	public static function addtoExplore($postID, $type)
	{

		$sdb = new AmazonSDB();
		$time = time();
		$select = $sdb->select("select ".$type." from Explore where itemName()='".$postID."'");
	
		$cnt = (int)$select->body->SelectResult->Item->Attribute->Value + 1;
		
		$put = $sdb->put_attributes('Explore', $postID, array(
		    (string) $type => $cnt,
			'modified' => $time
		), array((string) $type, 'modified'));

		if($put->body->ResponseMetadata){
			return true;	
		}
		elseif(!$put->body->ResponseMetadata)
			return false;

	}

	public static function removeExplore($postID, $type){

		$sdb = new AmazonSDB();
		$time = time();
		$select = $sdb->select("select ".$type." from Explore where itemName()='".$postID."'");
	
		$cnt = (int)$select->body->SelectResult->Item->Attribute->Value - 1;
		
		$put = $sdb->put_attributes('Explore', $postID, array(
		    (string) $type => $cnt,
			'modified' => $time
		), array((string) $type, 'modified'));

		if($put->body->ResponseMetadata){
			return true;	
		}
		elseif(!$put->body->ResponseMetadata)
			return false;

	}
	
}

?>
