<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../conf/session.conf.php");

session_start();
global $SESSION_NAME;
setcookie((string) $SESSION_NAME, session_id(), null, '/');
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php"); 
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php"); 
require_once(dirname(__FILE__)."/../../includes/lib/connect.lib.php"); 
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	header('Location:/');
	exit(0);
}

$info = new UserInfoDAO(Auth::getLoggedInID());
$my_url = $info->getProfileURL();

$title = "Sprred - Dashboard";
?>

<?php include(dirname(__FILE__)."/../../templates/dashboard/header.inc.php"); ?>

<div id="contents">
	<div id="loading" class="rounded2">Loading...</div>
	<ul id="main-nav" class="rounded3">
		<li>
			<label><a href="#home" class="inline-nav rounded3">Home</a></label>
			<div class="reset"></div>
		</li>
		<li>
			<label><a href="Javascript:void(0);" class="drop-menu rounded3">Manage</a></label>
			<ul class="sub-nav">
				<li><a href="#manage/blog" class="inline-nav rounded2">Blog</a></li>
				<li><a href="#manage/photos" class="inline-nav rounded2">Photos</a></li>
				<li><a href="#manage/videos" class="inline-nav rounded2">Videos</a></li>
				<li><a href="#manage/links" class="inline-nav rounded2">Links</a></li>
				<div class="reset"></div>
			</ul>
			<div class="reset"></div>
		</li>
		<li>
			<label><a href="Javascript:void(0);" class="drop-menu rounded3">Profile</a></label>
			<ul class="sub-nav">
				<li><a href="#info/personal" class="inline-nav rounded2">Personal</a></li>
				<li><a href="#info/professional" class="inline-nav rounded2">Professional</a></li>
				<div class="reset"></div>
			</ul>
			<div class="reset"></div>
		</li>
		<li>
			<label><a href="#themes" class="inline-nav rounded3">Themes</a></label>
			<div class="reset"></div>
		</li>
		<li>
			<label><a href="Javascript:void(0);" class="drop-menu rounded3">Settings</a></label>
			<ul class="sub-nav">
				<li><a href="#settings/account" class="inline-nav rounded2">Account</a></li>
				<li><a href="#settings/autopost" class="inline-nav rounded2">Autopost</a></li>
				<!-- <li><a href="#themes" class="inline-nav rounded2">Themes</a></li> -->
				<div class="reset"></div>
			</ul>
			<div class="reset"></div>
		</li>
		<a href="<?php echo $my_url; ?>" target="_blank" id="view-sprred">View your Sprred &raquo;</a>
		<div class="reset"></div>
	</ul>
	<div id="main-contents" class="rounded5">
		
	</div>
</div> <!--contents-->

<?php include(dirname(__FILE__)."/../../templates/dashboard/footer.inc.php"); ?>
