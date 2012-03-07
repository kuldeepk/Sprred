<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class SpaceDB
{

	public static function totalSpaceLimit($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select blogLimit, photoLimit, videoLimit, fileLimit, totalLimit  from ".DB_REGION."Space where itemName()='".$userID."'");
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		}
		else{
			foreach($select->body->SelectResult->Item[0]->Attribute as $attribute)
			{   
				$space[ (string) $attribute->Name ] = (string)$attribute->Value;
			}
		}
		return $space;
	
	}
	
	public static function spaceUsed($userID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select blog, photo, video, file, total  from ".DB_REGION."Space where itemName()='".$userID."'");
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		}
		else{
			foreach($select->body->SelectResult->Item[0]->Attribute as $attribute)
			{   
				$space[ (string) $attribute->Name ] = (string)$attribute->Value;
			}
		}
		return $space;
	
	}

	public static function putSpace($userID, $space){
		$sdb = new AmazonSDB();
		$time = time();
		
		$put = $sdb->put_attributes(DB_REGION.'Space', $userID, array(
			'blog' => $space['blog'],	
			'photo' => $space['photo'],
			'video' => $space['video'],
			'file' => $space['file'],
		    'total' => $space['total'],
			'blogLimit' => $space['blogLimit'],	
			'photoLimit' => $space['photoLimit'],
			'videoLimit' => $space['videoLimit'],
			'fileLimit' => $space['fileLimit'],
		    'totalLimit' => $space['totalLimit'],
			'modified' => $time
			), array('blog', 'photo', 'video', 'file', 'total', 'blogLimit', 'photoLimit', 'videoLimit', 'fileLimit', 'totalLimit', 'modified')
		);
	
		if($put->body->ResponseMetadata){
			return $commentID;	
		}
	
		elseif(!$put->body->ResponseMetadata)
			return false;
	
	}


	
}

?>
