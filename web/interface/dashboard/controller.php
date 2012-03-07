<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../../includes/classes/Auth.class.php"); 
require_once(dirname(__FILE__)."/../../../includes/lib/connect.lib.php"); 
require_once(dirname(__FILE__)."/../../../includes/db/UserMeta.db.php"); 
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	echo "You don't seemed to be logged in.";
	exit();
}

$request_url = $_GET['content'];

switch($request_url){
	case "home": require(dirname(__FILE__)."/../../../templates/dashboard/home.inc.php"); 
			exit();
			break;
	case "manage/blog": require(dirname(__FILE__)."/../../../templates/dashboard/blogposts.inc.php"); 
			exit();
			break;
	case "manage/photos": require(dirname(__FILE__)."/../../../templates/dashboard/photos.inc.php"); 
			exit();
			break;
	case "manage/videos": require(dirname(__FILE__)."/../../../templates/dashboard/videos.inc.php"); 
			exit();
			break;
	case "manage/links": require(dirname(__FILE__)."/../../../templates/dashboard/links.inc.php"); 
			exit();
			break;
	case "info/personal": require(dirname(__FILE__)."/../../../templates/dashboard/personal.info.inc.php"); 
			exit();
			break;
	case "info/professional": require(dirname(__FILE__)."/../../../templates/dashboard/professional.info.inc.php"); 
			exit();
			break;
	case "home": require(dirname(__FILE__)."/../../../templates/dashboard/home.inc.php"); 
			exit();
			break;
	case "themes": require(dirname(__FILE__)."/../../../templates/dashboard/themes.inc.php"); 
			exit();
			break;
	case "settings/account": require(dirname(__FILE__)."/../../../templates/dashboard/account.inc.php"); 
			exit();
			break;
	case "settings/autopost": require(dirname(__FILE__)."/../../../templates/dashboard/autopost.inc.php"); 
			exit();
			break;
	default: ?>
		<div class="message">
			<h1>Comming Soon!</h1>
		</div>
	<?php
			exit();
}

?>

