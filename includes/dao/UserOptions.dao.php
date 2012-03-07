<?php
require_once dirname(__FILE__)."/../db/UserOptions.db.php";

class UserOptionsDAO
{

	private $userId = null;
	private $theme = null;
		
	function UserOptionsDAO($user_id) {
		$this->userId = $user_id;
	}	
	
	function changeTheme($theme) {
		MemClient::delete("theme-". $this->userId);
		$this->theme=null;
		return UserOptionsDB::setOption($this->userId, 'current_theme', $theme);
	}
	
	function getTheme() {
		if($this->theme){
			return $this->theme;
		} elseif($result=MemClient::get("theme-". $this->userId)){
			$this->theme = $result;
			return $this->theme;
		} else {
			$value = UserOptionsDB::getOptionValue($this->userId, 'current_theme');
		
			if(!$value)
				return false;
			else {
				MemClient::set("theme-". $this->userId, $value, false, 2592000);
				$this->theme = $value;
				return $this->theme;
			}
		}
	}
	
}
	
?>