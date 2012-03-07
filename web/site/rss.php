<?php
 header("Content-Type: application/xml; charset=ISO-8859-1"); 
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
$posts = $view->getAllPosts(10 , 0, array('public'));


  $output ="";
  $output .= "<?xml version=\"1.0\" encoding=\"UTF-8\" ?>\n";
  $output .= "<rss version=\"2.0\">\n";
  $output .= "<channel>\n";
  
  $output .= "<title>". htmlentities(strip_tags($info->getProfileName())) ."</title>\n";
  $output .= "<link>". htmlentities($info->getProfileURL()) ."</link>\n";
  $output .= "<generator>http://www.sprred.com</generator>\n";
  $output .= "<language>en</language>\n";
  
  foreach($posts as $key=>$post){
	  $postInfo = new PostInfo($post);
	  $output .= "<item>\n";
	  $output .= "<title>". htmlentities($postInfo->getPostTitle()) ."</title>\n";
	  $output .= "<link>". htmlentities($postInfo->getPostURL($userID, true)) ."</link>\n";
	  $output .= "<description>". htmlentities(strip_tags($postInfo->getPostDesc()))."</description>\n";
	  $output .= "</item>\n";
  }
  
  $output .= "</channel>\n";
  $output .= "</rss>\n";

  echo $output;


?>




