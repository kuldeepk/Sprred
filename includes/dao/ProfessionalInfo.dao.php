<?php

require_once dirname(__FILE__)."/../db/UserMeta.db.php";

class ProfessionalInfoDAO
{

	private $userID = null;
		
	function ProfessionalInfoDAO($user_id) {
		$this->userID = $user_id;
	}
	
	function setEduCount($count) {
		MemClient::delete("eduCount-". $this->userID);
		$this->eduCount = null;
		return UserMetaDB::setMeta($this->userID, 'eduCount', $count);
	}
	
	function getEduCount() {
		if($this->eduCount){
			return $this->eduCount;
		} elseif($result=MemClient::get("eduCount-". $this->userID)){
			$this->eduCount = $result;
			return $this->eduCount;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'eduCount');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("eduCount-". $this->userID, $result, false, 2592000);
				$this->eduCount = $result;
				return $this->eduCount;
			}
		}
	}
	
	function setWorkCount($count) {
		MemClient::delete("workCount-". $this->userID);
		$this->workCount = null;
		return UserMetaDB::setMeta($this->userID, 'workCount', $count);
	}
	
	function getWorkCount() {
		if($this->workCount){
			return $this->workCount;
		} elseif($result=MemClient::get("workCount-". $this->userID)){
			$this->workCount = $result;
			return $this->workCount;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workCount');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workCount-". $this->userID, $result, false, 2592000);
				$this->workCount = $result;
				return $this->workCount;
			}
		}
	}
	
	function setUniv($univ, $count=1) {
		MemClient::delete("univ-".$count."-". $this->userID);
		$this->univ[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'univ-'.$count, $univ);
	}
	
	function getUniv($count=1) {
		if($this->univ[(int)$count]){
			return $this->univ[(int)$count];
		} elseif($result=MemClient::get("univ-".$count."-". $this->userID)){
			$this->univ[(int)$count] = $result;
			return $this->univ[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'univ-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("univ-".$count."-". $this->userID, $result, false, 2592000);
				$this->univ[(int)$count] = $result;
				return $this->univ[(int)$count];
			}
		}
	}
	
	function setUnivYear($univYear, $count=1) {
		MemClient::delete("univYear-".$count."-". $this->userID);
		$this->univYear[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'univYear-'.$count, $univYear);
	}
	
	function getUnivYear($count=1) {
		if($this->univYear[(int)$count]){
			return $this->univYear[(int)$count];
		} elseif($result=MemClient::get("univYear-".$count."-". $this->userID)){
			$this->univYear[(int)$count] = $result;
			return $this->univYear[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'univYear-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("univYear-".$count."-". $this->userID, $result, false, 2592000);
				$this->univYear[(int)$count] = $result;
				return $this->univYear[(int)$count];
			}
		}
	}
	
	function setUnivDegree($univDegree, $count=1) {
		MemClient::delete("univDegree-".$count."-". $this->userID);
		$this->univDegree[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'univDegree-'.$count, $univDegree);
	}
	
	function getUnivDegree($count=1) {
		if($this->univDegree[(int)$count]){
			return $this->univDegree[(int)$count];
		} elseif($result=MemClient::get("univDegree-".$count."-". $this->userID)){
			$this->univDegree[(int)$count] = $result;
			return $this->univDegree[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'univDegree-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("univDegree-".$count."-". $this->userID, $result, false, 2592000);
				$this->univDegree[(int)$count] = $result;
				return $this->univDegree[(int)$count];
			}
		}
	}
	
	function setUnivFocus($univFocus, $count=1) {
		MemClient::delete("univFocus-".$count."-". $this->userID);
		$this->univFocus[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'univFocus-'.$count, $univFocus);
	}
	
	function getUnivFocus($count=1) {
		if($this->univFocus[(int)$count]){
			return $this->univFocus[(int)$count];
		} elseif($result=MemClient::get("univFocus-".$count."-". $this->userID)){
			$this->univFocus[(int)$count] = $result;
			return $this->univFocus[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'univFocus-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("univFocus-".$count."-". $this->userID, $result, false, 2592000);
				$this->univFocus[(int)$count] = $result;
				return $this->univFocus[(int)$count];
			}
		}
	}
	
	function setEmployer($employer, $count=1) {
		MemClient::delete("employer-".$count."-". $this->userID);
		$this->employer[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'employer-'.$count, $employer);
	}
	
	function getEmployer($count=1) {
		if($this->employer[(int)$count]){
			return $this->employer[(int)$count];
		} elseif($result=MemClient::get("employer-".$count."-". $this->userID)){
			$this->employer[(int)$count] = $result;
			return $this->employer[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'employer-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("employer-".$count."-". $this->userID, $result, false, 2592000);
				$this->employer[(int)$count] = $result;
				return $this->employer[(int)$count];
			}
		}
	}
	
	function setWorkTitle($workTitle, $count=1) {
		MemClient::delete("workTitle-".$count."-". $this->userID);
		$this->workTitle[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workTitle-'.$count, $workTitle);
	}
	
	function getWorkTitle($count=1) {
		if($this->workTitle[(int)$count]){
			return $this->workTitle[(int)$count];
		} elseif($result=MemClient::get("workTitle-".$count."-". $this->userID)){
			$this->workTitle[(int)$count] = $result;
			return $this->workTitle[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workTitle-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workTitle-".$count."-". $this->userID, $result, false, 2592000);
				$this->workTitle[(int)$count] = $result;
				return $this->workTitle[(int)$count];
			}
		}
	}
	
	function setWorkDesc($workDesc, $count=1) {
		MemClient::delete("workDesc-".$count."-". $this->userID);
		$this->workDesc[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workDesc-'.$count, $workDesc);
	}
	
	function getWorkDesc($count=1) {
		if($this->workDesc[(int)$count]){
			return $this->workDesc[(int)$count];
		} elseif($result=MemClient::get("workDesc-".$count."-". $this->userID)){
			$this->workDesc[(int)$count] = $result;
			return $this->workDesc[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workDesc-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workDesc-".$count."-". $this->userID, $result, false, 2592000);
				$this->workDesc[(int)$count] = $result;
				return $this->workDesc[(int)$count];
			}
		}
	}
	
	function setWorkFromMonth($workFromMonth, $count=1) {
		MemClient::delete("workFromMonth-".$count."-". $this->userID);
		$this->workFromMonth[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workFromMonth-'.$count, $workFromMonth);
	}
	
	function getWorkFromMonth($count=1) {
		if($this->workFromMonth[(int)$count]){
			return $this->workFromMonth[(int)$count];
		} elseif($result=MemClient::get("workFromMonth-".$count."-". $this->userID)){
			$this->workFromMonth[(int)$count] = $result;
			return $this->workFromMonth[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workFromMonth-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workFromMonth-".$count."-". $this->userID, $result, false, 2592000);
				$this->workFromMonth[(int)$count] = $result;
				return $this->workFromMonth[(int)$count];
			}
		}
	}
	
	function setWorkFromYear($workFromYear, $count=1) {
		MemClient::delete("workFromYear-".$count."-". $this->userID);
		$this->workFromYear[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workFromYear-'.$count, $workFromYear);
	}
	
	function getWorkFromYear($count=1) {
		if($this->workFromYear[(int)$count]){
			return $this->workFromYear[(int)$count];
		} elseif($result=MemClient::get("workFromYear-".$count."-". $this->userID)){
			$this->workFromYear[(int)$count] = $result;
			return $this->workFromYear[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workFromYear-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workFromYear-".$count."-". $this->userID, $result, false, 2592000);
				$this->workFromYear[(int)$count] = $result;
				return $this->workFromYear[(int)$count];
			}
		}
	}
	
	function setWorkTillMonth($workTillMonth, $count=1) {
		MemClient::delete("workTillMonth-".$count."-". $this->userID);
		$this->workTillMonth[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workTillMonth-'.$count, $workTillMonth);
	}
	
	function getWorkTillMonth($count=1) {
		if($this->workTillMonth[(int)$count]){
			return $this->workTillMonth[(int)$count];
		} elseif($result=MemClient::get("workTillMonth-".$count."-". $this->userID)){
			$this->workTillMonth[(int)$count] = $result;
			return $this->workTillMonth[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workTillMonth-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workTillMonth-".$count."-". $this->userID, $result, false, 2592000);
				$this->workTillMonth[(int)$count] = $result;
				return $this->workTillMonth[(int)$count];
			}
		}
	}
	
	function setWorkTillYear($workTillYear, $count=1) {
		MemClient::delete("workTillYear-".$count."-". $this->userID);
		$this->workTillYear[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workTillYear-'.$count, $workTillYear);
	}
	
	function getWorkTillYear($count=1) {
		if($this->workTillYear[(int)$count]){
			return $this->workTillYear[(int)$count];
		} elseif($result=MemClient::get("workTillYear-".$count."-". $this->userID)){
			$this->workTillYear[(int)$count] = $result;
			return $this->workTillYear[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workTillYear-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workTillYear-".$count."-". $this->userID, $result, false, 2592000);
				$this->workTillYear[(int)$count] = $result;
				return $this->workTillYear[(int)$count];
			}
		}
	}
	
	function setWorkTillPresent($count=1) {
		MemClient::delete("workTillPresent-".$count."-". $this->userID);
		$this->workTillPresent[(int)$count] = null;
		return UserMetaDB::setMeta($this->userID, 'workTillPresent-'.$count, 'present');
	}
	
	function isWorkTillPresent($count=1) {
		if($this->workTillPresent[(int)$count]){
			return $this->workTillPresent[(int)$count];
		} elseif($result=MemClient::get("workTillPresent-".$count."-". $this->userID)){
			$this->workTillPresent[(int)$count] = $result;
			return $this->workTillPresent[(int)$count];
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'workTillPresent-'.$count);	
			if(is_null($result))
				return null;
			else {
				MemClient::set("workTillPresent-".$count."-". $this->userID, $result, false, 2592000);
				$this->workTillYear[(int)$count] = $result;
				return $this->workTillYear[(int)$count];
			}
		}
	}
	
}

?>