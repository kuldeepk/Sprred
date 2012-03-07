<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/classes/Auth.class.php"); 
/*************************************/

$auth = new Auth();
$auth->logout();
header('Location:/');
exit(0);
?>