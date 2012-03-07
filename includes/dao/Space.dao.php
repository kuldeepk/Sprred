<?php

require_once(dirname(__FILE__).'/../../conf/space.conf.php');
require_once(dirname(__FILE__).'/../db/Space.db.php');

class SpaceDAO
{
	private $userID = null;
	
	function SpaceDAO($user_id) {
		$this->userID = $user_id;
		$totalSpaceLimit = $this->totalSpaceLimit();
		if(!$totalSpaceLimit['totalLimit']){
			$this->createSpace();
		}
	}
	
	function totalSpaceLimit(){
		return SpaceDB::totalSpaceLimit($this->userID);
		// return arr	
	}
	
	function spaceUsed(){
		return SpaceDB::spaceUsed($this->userID);	
		// return arr
	}
	
	function spaceAvail(){
	
		$totalSpaceLimit = $this->totalSpaceLimit();
		$spaceUsed = $this->spaceUsed();
	
		$spaceAvail['blog'] = $totalSpaceLimit['blogLimit'] - $spaceUsed['blog'];
		$spaceAvail['photo'] = $totalSpaceLimit['photoLimit'] - $spaceUsed['photo'];
		$spaceAvail['video'] = $totalSpaceLimit['videoLimit'] - $spaceUsed['video'];
		$spaceAvail['total'] = $totalSpaceLimit['totalLimit'] - $spaceUsed['total'];
		
		return $spaceAvail;
	}
	
	function isSpaceAvail($space){
		$spaceAvail = $this->spaceAvail();
		if($spaceAvail['total'] > $space)
			return 1;
		else return 0;
	}
	
	function isSpaceAvailOfType($space, $type){
		$spaceAvail = $this->spaceAvail();
		if($spaceAvail['total'] > $space)
			return 1;
		else return 0;
	}
	
	
	function useSpace($size, $type){
		if($this->isSpaceAvailOfType($size, $type)){
			$totalSpaceLimit = $this->totalSpaceLimit();
			$spaceUsed = $this->spaceUsed();
			$space = array_merge($totalSpaceLimit, $spaceUsed);
			$space[ (string) $type ] = $space[ (string) $type ] + $size;
			$space['total'] = $space['total'] + $size;
				return SpaceDB::putSpace($this->userID, $space);	
		}
		else return 0;
	}
	
	function releaseSpace($size, $type){
		$totalSpaceLimit = $this->totalSpaceLimit();
		$spaceUsed = $this->spaceUsed();
		$space = array_merge($totalSpaceLimit, $spaceUsed);
		$space[ (string) $type ] = $space[ (string) $type ] - $size;
		$space['total'] = $space['total'] - $size;
			return SpaceDB::putSpace($this->userID, $space);	
	}
	
	function upgradeSpace(){
		
		$space['blogLimtit']=PREMIUM_TOTAL_SPACE;
		$space['photoLimtit']=PREMIUM_TOTAL_SPACE;
		$space['videoLimtit']=PREMIUM_TOTAL_SPACE;
		$space['totalLimtit']=PREMIUM_TOTAL_SPACE;
		$spaceUsed = $this->spaceUsed();
		$space = array_merge($space, $spaceUsed);
		return SpaceDB::putSpace($this->userID, $space);
	}
	
	function downgradeSpace(){
		
		$space['blogLimtit']=TOTAL_SPACE;
		$space['photoLimtit']=TOTAL_SPACE;
		$space['videoLimtit']=TOTAL_SPACE;
		$space['totalLimtit']=TOTAL_SPACE;
		$spaceUsed = $this->spaceUsed();
		$space = array_merge($space, $spaceUsed);
		return SpaceDB::putSpace($this->userID, $space);	
	}
	
	function createSpace() {
		$space['blog'] = 0;
		$space['photo'] = 0;
		$space['video'] = 0;
		$space['file'] = 0;
		$space['total'] = 0;
		$space['blogLimit'] = TOTAL_SPACE;
		$space['photoLimit'] = TOTAL_SPACE;
		$space['videoLimit'] = TOTAL_SPACE;
		$space['fileLimit'] = TOTAL_SPACE;
		$space['totalLimit'] = TOTAL_SPACE;
		return SpaceDB::putSpace($this->userID, $space);
	}

}
?>