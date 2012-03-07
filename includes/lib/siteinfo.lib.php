<?php

/* Include Files *********************/
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__)."/../../includes/lib/info.lib.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserOptions.dao.php");
require_once(dirname(__FILE__)."/../../includes/dao/PersonalInfo.dao.php");
/*************************************/

$info = new UserInfoDAO($userID);
$options = new UserOptionsDAO($userID);
$personalInfo = new PersonalInfoDAO($userID);

if($theme_preview = filter_input(INPUT_GET, 'theme-preview', FILTER_SANITIZE_STRING))
	$theme = $theme_preview;
else
	$theme = $options->getTheme();

if(!$theme) $theme = 'default';
$themes_directory = '/site/themes/'.$theme;
$reset_css = "/css/reset.css";
$chiclet_css = "/css/chiclet.css";

?>