<?php

require_once(dirname(__FILE__).'/../db/Space.db.php');

class SpaceDAO
{

private $freeblogspace = 10000000;
private $freephotoize = 10000000;
private $freevideoize = 10000000;
private $freetotalize = 30000000;
private $premiumblogspace = 50000000;
private $premiumphotospace = 50000000;
private $premiumvideospace = 50000000;
private $premiumtotalspace = 15000000;

	
function SpaceDAO($user_id) {
	$this->userID = $user_id;
	$totalSpaceLimit = totalSpaceLimit();
	if(!$totalSpaceLimit['totalLimit']){
		downgradeSpace();
	}
}
	
	function totalSpaceLimit(){
		return SpaceDB::totalSpaceLimit($this->userID);
		// return arr	
	}
	
	function spaceUsed(){
		return SpaceDB::spaceUsed();	
		// return arr
	}
	
	function spaceAvail(){
	
		$totalSpaceLimit = totalSpaceLimit();
		$spaceUsed = spaceUsed();
	
		$spaceAvail['blog'] = $totalSpaceLimit['blogLimit'] - $spaceUsed['blog'];
		$spaceAvail['photo'] = $totalSpaceLimit['photoLimit'] - $spaceUsed['photo'];
		$spaceAvail['video'] = $totalSpaceLimit['videoLimit'] - $spaceUsed['video'];
		$spaceAvail['total'] = $totalSpaceLimit['totalLimit'] - $spaceUsed['total'];
		
		return $spaceAvail;
	}
	
	function isSpaceAvail($space){
		$spaceAvail = spaceAvail();
		if($spaceAvail['total'] > $space)
			return 1;
		else return 0;
	}
	
	function isSpaceAvailOfType($space, $type){
		$spaceAvail = spaceAvail();
		if($spaceAvail[ (string) $type ] > $space)
			return 1;
		else return 0;
	}
	
	
	function useSpace($size, $type){
		if(isSpaceAvailOfType($size, $type)){
			$totalSpaceLimit = totalSpaceLimit();
			$spaceUsed = spaceUsed();
			$space = array_merge($totalSpaceLimit, $spaceUsed);
			$space[ (string) $type ] = $space[ (string) $type ] + $size;
			$space['total'] = $space['total'] + $size;
				return SpaceDB::putSpace($this->userID, $space);	
		}
		else return 0;
	}
	
	function releaseSpace($size, $type){
			$totalSpaceLimit = totalSpaceLimit();
			$spaceUsed = spaceUsed();
			$space = array_merge($totalSpaceLimit, $spaceUsed);
			$space[ (string) $type ] = $space[ (string) $type ] - $size;
			$space['total'] = $space['total'] - $size;
				return SpaceDB::putSpace($this->userID, $space);	
	}
	
	function upgradeSpace(){
		
		$space['blogLimtit']=$premiumblogspace;
		$space['photoLimtit']=$premiumphotospace;
		$space['videoLimtit']=$premiumvideospace;
		$space['totalLimtit']=$premiumtotalspace;
		$spaceUsed = spaceUsed();
		$space = array_merge($space, $spaceUsed);
		return SpaceDB::putSpace($this->userID, $space);
	}
	
	function downgradeSpace(){
		
		$space['blogLimtit']=$freeblogspace;
		$space['photoLimtit']=$freephotospace;
		$space['videoLimtit']=$freevideospace;
		$space['totalLimtit']=$freetotalspace;
		$spaceUsed = spaceUsed();
		$space = array_merge($space, $spaceUsed);
		return SpaceDB::putSpace($this->userID, $space);	
	}

}
?>