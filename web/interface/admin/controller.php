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
	case "home": require(dirname(__FILE__)."/../../../templates/admin/home.inc.php"); 
			exit();
			break;
	case "allposts": require(dirname(__FILE__)."/../../../templates/admin/allposts.inc.php"); 
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

