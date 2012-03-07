<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../../includes/dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../../../includes/lib/mail.lib.php");
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	$response['errorMsg'] = "You don't seemed to be logged in.";
	$response['errorNum'] = 0;
	$encoded = json_encode($response);
	die($encoded);
}

$info = new UserInfoDAO(Auth::getLoggedInID());

$body = filter_input(INPUT_POST, 'body', FILTER_SANITIZE_STRING);
$subject = filter_input(INPUT_POST, 'subject', FILTER_SANITIZE_STRING);

Mail::send('no-reply@sprred.com', 'Sprred Feedback', 'support@sprred.com', 'User['. Auth::getLoggedInID() .'] Feedback: '.$subject, '<html><body>User Feedback:<br/>ID:'.Auth::getLoggedInID().'<br/>Name: '.$info->getFullname().'<br/>Email: '.$info->getEmail().'<br/><p>'.$body.'</p></body></html>', 'support');

?>
