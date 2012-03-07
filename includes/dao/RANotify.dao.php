<?php

require_once(dirname(__FILE__).'/../lib/mem-client.lib.php');
require_once(dirname(__FILE__).'/UserInfo.dao.php');

class RANotifyDAO
{

private $userId = null;
private $follow = null;
private $updates = null;
private $email_follow = null;
private $comment = null;

function RANotifyDAO($user_id) {
	$this->userId = $user_id;
}

function getUserId() {
	return $this->userId;
}

function createEntry($updates=false) {
	if($updates == false)
		return mysql_query("INSERT INTO notifications (ID, updates, modified) VALUES (". $this->userId .", 0, NOW( ) )");
	else
		return mysql_query("INSERT INTO notifications (ID, updates, modified) VALUES (". $this->userId .", 1, NOW( ) )");
}

function changeUpdatesNotifctn($flag) {
	MemClient::delete("notificationUpdates-". $this->userId);
	$this->updates=null;
	if($flag == true)
		return mysql_query("UPDATE notifications SET updates = 1, modified = NOW() WHERE ID = " . $this->userId);
	else
		return mysql_query("UPDATE notifications SET updates = 0, modified = NOW() WHERE ID = " . $this->userId);
}

function getUpdatesNotifctn() {
	if($this->updates != null){
		return $this->updates;
	} elseif($result=MemClient::get("notificationUpdates-". $this->userId)){
		$this->updates = $result;
		return $this->updates;
	} else {
		$result = mysql_query("SELECT updates FROM notifications WHERE ID=" . $this->userId);
		$row = mysql_fetch_row($result);

		if(is_null($row[0]))
			return -1;
		else {
			MemClient::set("notificationUpdates-". $this->userId, $row[0], false, 2592000);
			$this->updates = $row[0];
			return $this->updates;
		}
	}
}

function changeEmailFllwNotifctn($flag) {
	MemClient::delete("notificationEmailFollow-". $this->userId);
	$this->email_follow=null;
	if($flag == true)
		return mysql_query("UPDATE notifications SET email_follow = 1, modified = NOW() WHERE ID = " . $this->userId);
	else
		return mysql_query("UPDATE notifications SET email_follow = 0, modified = NOW() WHERE ID = " . $this->userId);
}

function getEmailFllwNotifctn() {
	if($this->email_follow != null){
		return $this->email_follow;
	} elseif($result=MemClient::get("notificationEmailFollow-". $this->userId)){
		$this->email_follow = $result;
		return $this->email_follow;
	} else {
		$result = mysql_query("SELECT email_follow FROM notifications WHERE ID=" . $this->userId);
		$row = mysql_fetch_row($result);

		if(is_null($row[0]))
			return -1;
		else {
			MemClient::set("notificationEmailFollow-". $this->userId, $row[0], false, 2592000);
			$this->email_follow = $row[0];
			return $this->email_follow;
		}
	}
}

function notifyEmailFllw($postData){
	if(!$postData)
		return false;
	if($this->getEmailFllwNotifctn()){
		$toInfo = new UserInfoDAO($this->userId);
		$to = $toInfo->getEmail($this->userId);
		$toName = $toInfo->getFullName($this->userId);
		require(dirname(__FILE__)."/../../templates/mail/reader.php");
		//mail($to, $subject, $body, $headers);
	}
}

function changeFollowNotifctn($flag) {
	MemClient::delete("notificationFollow-". $this->userId);
	$this->follow=null;
	if($flag == true)
		return mysql_query("UPDATE notifications SET follow = 1, modified = NOW() WHERE ID = " . $this->userId);
	else
		return mysql_query("UPDATE notifications SET follow = 0, modified = NOW() WHERE ID = " . $this->userId);
}

function getFollowNotifctn() {
	if($this->follow != null){
		return $this->follow;
	} elseif($result=MemClient::get("notificationFollow-". $this->userId)){
		$this->follow = $result;
		return $this->follow;
	} else {
		$result = mysql_query("SELECT follow FROM notifications WHERE ID=" . $this->userId);
		$row = mysql_fetch_row($result);

		if(is_null($row[0]))
			return -1;
		else {
			MemClient::set("notificationFollow-". $this->userId, $row[0], false, 2592000);
			$this->follow = $row[0];
			return $this->follow;
		}
	}
}

function notifyFollow($whoID){
	if(!$whoID)
		return false;
	if($this->getFollowNotifctn()){
		$toInfo = new UserInfoDAO($this->userId);
		$to = $toInfo->getEmail($this->userId);
		$toName = $toInfo->getFullName($this->userId);
		$whoInfo = new UserInfoDAO($whoID);
		$who = $whoInfo->getFullName($whoID);
		$profileURL = $whoInfo->getProfileURL();
		$whosProfile = $whoInfo->getProfileName();
		$what = $toInfo->getProfileName();
		$whatURL = $toInfo->getProfileURL();
		require(dirname(__FILE__)."/../../templates/mail/following.php");
		//mail($to, $subject, $body, $headers);
	}
}

function changeOwnerCommentNotifctn($flag) {
	MemClient::delete("notificationOwnerComment-". $this->userId);
	$this->ownerComment=null;
	if($flag == true)
		return mysql_query("UPDATE notifications SET owner_comment = 1, modified = NOW() WHERE ID = " . $this->userId);
	else
		return mysql_query("UPDATE notifications SET owner_comment = 0, modified = NOW() WHERE ID = " . $this->userId);
}

function getOwnerCommentNotifctn() {
	if($this->ownerComment != null){
		return $this->ownerComment;
	} elseif($result=MemClient::get("notificationOwnerComment-". $this->userId)){
		$this->ownerComment = $result;
		return $this->ownerComment;
	} else {
		$result = mysql_query("SELECT owner_comment FROM notifications WHERE ID=" . $this->userId);
		$row = mysql_fetch_row($result);

		if(is_null($row[0]))
			return -1;
		else {
			MemClient::set("notificationOwnerComment-". $this->userId, $row[0], false, 2592000);
			$this->ownerComment = $row[0];
			return $this->ownerComment;
		}
	}
}

function notifyOwnerComment($whoID, $post, $comment){
	if(!$whoID || !$post || $comment)
		return false;
	if($this->getOwnerCommentNotifctn()){
		$toInfo = new UserInfoDAO($this->userId);
		$to = $toInfo->getEmail($this->userId);
		$toName = $toInfo->getFullName($this->userId);
		$whoInfo = new UserInfoDAO($whoID);
		$who = $whoInfo->getFullName($whoID);
		$title = $post['title'];
		if($post['parent_ID'])
			$thisProfileID = $post['parent_ID'];
		else
			$thisProfileID = $post['profileID'];		
		$link = 'http://www.redanyway.com/post.php?id='.$thisProfileID.'&time='.(int)$post['pub_time'].'&slug='.$post['slug'];
		require(dirname(__FILE__)."/../../templates/mail/owner.comment.php");
		//mail($to, $subject, $body, $headers);
	}
}

function changeCommentNotifctn($flag) {
	MemClient::delete("notificationComment-". $this->userId);
	$this->comment=null;
	if($flag == true)
		return mysql_query("UPDATE notifications SET comment = 1, modified = NOW() WHERE ID = " . $this->userId);
	else
		return mysql_query("UPDATE notifications SET comment = 0, modified = NOW() WHERE ID = " . $this->userId);
}

function getCommentNotifctn() {
	if($this->comment != null){
		return $this->comment;
	} elseif($result=MemClient::get("notificationComment-". $this->userId)){
		$this->comment = $result;
		return $this->comment;
	} else {
		$result = mysql_query("SELECT comment FROM notifications WHERE ID=" . $this->userId);
		$row = mysql_fetch_row($result);

		if(is_null($row[0]))
			return -1;
		else {
			MemClient::set("notificationComment-". $this->userId, $row[0], false, 2592000);
			$this->comment = $row[0];
			return $this->comment;
		}
	}
}

function notifyComment($whoID, $post, $comment){
	if(!$whoID || !$post || $comment)
		return false;
	if($this->getCommentNotifctn()){
		$toInfo = new UserInfoDAO($this->userId);
		$to = $toInfo->getEmail($this->userId);
		$toName = $toInfo->getFullName($this->userId);
		$whoInfo = new UserInfoDAO($whoID);
		$who = $whoInfo->getFullName($whoID);
		$title = $post['title'];
		if($post['parent_ID'])
			$thisProfileID = $post['parent_ID'];
		else
			$thisProfileID = $post['profileID'];	
		$link = 'http://www.redanyway.com/post.php?id='.$thisProfileID.'&time='.(int)$post['pub_time'].'&slug='.$post['slug'];
		$link = $post['post_link'];
		require(dirname(__FILE__)."/../../templates/mail/comment.php");
		//mail($to, $subject, $body, $headers);
	}
}

}

?>
