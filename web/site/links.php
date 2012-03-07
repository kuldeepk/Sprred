<?php
header('Content-Type: text/html; charset=UTF-8');

/* Start Session *********************/
require_once(dirname(__FILE__)."/../../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../../includes/lib/info.lib.php");
require_once(dirname(__FILE__)."/../../includes/lib/utility.lib.php");
require_once(dirname(__FILE__).'/../../includes/classes/ViewPosts.class.php');
require_once(dirname(__FILE__)."/../../includes/classes/PostInfo.class.php");
/*************************************/

$sprred_name = filter_input(INPUT_GET, 'sname', FILTER_SANITIZE_STRING);
if(!$sprred_name){
	echo "Opps! Wrong Page!";
	exit(0);
}
	
$userID = SprredInfo::getUserID($sprred_name);
if(!$userID){
	echo "Opps! This Sprred doesn't exist!";
	exit(0);
}
require(dirname(__FILE__)."/../../includes/lib/siteinfo.lib.php");

$view = new ViewPosts($userID);
$posts = $view->getAllLinks(10 , 0, array('public'));

$current_page = "links";

require(dirname(__FILE__).'/../../templates/themes/'.$theme.'/links.php');

?>
