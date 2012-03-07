<?php

require_once(dirname(__FILE__).'/../lib/mem-client.lib.php');
require_once(dirname(__FILE__).'/../db/Notifications.db.php');

class NotificationsDAO
{

	private $userID = null;
	private $follow = null;
	private $updates = null;
	private $email_follow = null;
	private $comment = null;
	
	function NotificationsDAO($userID) {
		$this->userID = $userID;
	}
	
	function getUserId() {
		return $this->userID;
	}
	
	function createEntry($updates=false) {
		if($updates == false)
			return NotificationsDB::setUpdates($this->userID);
		else
			return NotificationsDB::resetUpdates($this->userID);
	}
	
	function setUpdates() {
		MemClient::delete("sprd_notificationUpdates-". $this->userID);
		$this->updates=null;
		return NotificationsDB::setUpdates($this->userID);
	}
	
	function resetUpdates() {
		MemClient::delete("sprd_notificationUpdates-". $this->userID);
		$this->updates=null;
		return NotificationsDB::resetUpdates($this->userID);
	}
	
	function getUpdates() {
		if($this->updates != null){
			return $this->updates;
		} elseif($result=MemClient::get("sprd_notificationUpdates-". $this->userID)){
			$this->updates = $result;
			return $this->updates;
		} else {
			$result = mysql_query("SELECT updates FROM notifications WHERE ID=" . $this->userID);
			$row = mysql_fetch_row($result);
	
			if(is_null($row[0]))
				return -1;
			else {
				MemClient::set("sprd_notificationUpdates-". $this->userID, $row[0], false, 2592000);
				$this->updates = $row[0];
				return $this->updates;
			}
		}
	}

}

?>
