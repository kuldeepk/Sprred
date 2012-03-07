<?php

class SubscribeDAO
{

private $email = null;
private $subscribed = null;

	
function SubscribeDAO($email) {
	$this->email = $email;
}

function getEmail() {
	return $this->email;
}

function subscribe() {
	if($this->isSubscribed() == -1)
		return mysql_query("INSERT INTO invitees (email, subscribed, created, modified) VALUES ('$this->email', 1, NOW( ) , NOW( ) )");
	else if($this->isSubscribed() == 1){
		$this->increment();
		return true;
	} else
		return mysql_query("UPDATE invitees SET subscribed = 1, modified = NOW() WHERE email = '" . $this->email ."'");
}

function unsubscribe() {
	if($this->isSubscribed() != -1)
		return mysql_query("UPDATE invitees SET subscribed = 0, modified = NOW() WHERE email = '" . $this->email ."'");
	else
		return true;
}

function isSubscribed() {
	if($this->subscribed != null){
		return $this->subscribed;
	} else {
		$result = mysql_query("SELECT * FROM invitees WHERE email='". $this->email ."'");
		$row = mysql_fetch_assoc($result);
	
		if(is_null($row['email']))
			return $this->subscribed = -1;
		else {
			if($row['subscribed'])
				return $this->subscribed = 1;
			else
				return $this->subscribed = 0;
		}
	}
}

function increment(){
	return mysql_query("UPDATE invitees SET count = count+1, modified = NOW() WHERE email = '" . $this->email ."'");
}

}

?>