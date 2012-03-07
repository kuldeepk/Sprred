<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../../includes/classes/Auth.class.php");
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	$response['errorMsg'] = "You don't seemed to be logged in.";
	$response['errorNum'] = 0;
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['get'] == 'blog-content'){
	require_once(dirname(__FILE__)."/../../../includes/classes/PostInfo.class.php"); 
	
	$s3name = filter_input(INPUT_GET, 's3name', FILTER_SANITIZE_STRING);
	$content = PostInfo::getPostContentFromName($s3name);
	if($content)
		$response['content'] = $content; 
	else{
		$response['errorMsg'] = "An unknown error occurred. Please try again."; 
		$response['errorNum'] = 1;
	}		
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['get'] == 'url-title'){
	$htmlDoc = new DOMDocument();
	libxml_use_internal_errors(true);
	if(!filter_input(INPUT_GET, 'url', FILTER_VALIDATE_URL))
		return null;
	if(!$htmlDoc->loadHtmlFile(filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL)))
		return null;
		
	$elem = $htmlDoc->getElementsByTagName('title');
    echo $elem->item(0)->nodeValue;
}
?>
