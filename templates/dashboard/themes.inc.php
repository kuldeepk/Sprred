<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserOptions.dao.php");
/*************************************/

$options = new UserOptionsDAO(Auth::getLoggedInID());
$themeID = $options->getTheme();
if(!$themeID)
	$themeID = 'default';

?>

<ul id="themes-list">
	<h1>Choose A Theme</h1>
	<li onclick="updateData('update-theme', 'theme-id=default');$('#themes-list .selected').toggleClass('selected');$(this).toggleClass('selected');" class="rounded5 <?php if($themeID == 'default') { echo 'selected '; } ?>">
		<img src="/images/default-theme-preview.png" class="rounded5">
		<label>Default</label>
	</li>
	<li onclick="updateData('update-theme', 'theme-id=simple');$('#themes-list .selected').toggleClass('selected');$(this).toggleClass('selected');" class="rounded5 <?php if($themeID == 'simple') { echo 'selected '; } ?>">
		<img src="/images/simple-theme-preview.png" class="rounded5">
		<label>Minimalist</label>
	</li>
	<li onclick="updateData('update-theme', 'theme-id=wine');$('#themes-list .selected').toggleClass('selected');$(this).toggleClass('selected');" class="rounded5 <?php if($themeID == 'wine') { echo 'selected '; } ?>">
		<img src="/images/wine-theme-preview.png" class="rounded5">
		<label>Wine Box</label>
	</li>
	<div class="reset"></div>
</ul>
