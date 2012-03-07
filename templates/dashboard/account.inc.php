<?php
header("Content-Type: text/html; charset=utf-8");

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/dao/UserInfo.dao.php"); 
/*************************************/

$info = new UserInfoDAO(Auth::getLoggedInID());
?>
<div class="update-form">
	<h1>Edit Your Account Details</h1>
	
	<h2>Change Display Name</h2>
	<p class="row"><label>Full Name</label><input type="text" id="fullname" class="text" value="<?php echo $info->getFullName();?>"></p>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-name', 'fullname='+$('#fullname').val())"></p>
</div>
<div class="update-form">
	<h2>Change Sprred Name</h2>
	<div class="row"><label>Sprred Name</label><div id="sname-box"><input type="text" id="sprred-name" value="<?php echo $info->getProfileHandler();?>" size="30" onfocus="$(this).parent().toggleClass('selected')" onblur="$(this).parent().toggleClass('selected')">.sprred.com</div><div class="reset"></div></div>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-sname', 'sname='+$('#sprred-name').val())"></p>
</div>
<div class="update-form">
	<h2>Change Sprred Title</h2>
	<p class="row"><label>Sprred Title</label><input type="text" id="sprred-title" class="text" value="<?php echo $info->getProfileName();?>"></p>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-stitle', 'stitle='+$('#sprred-title').val())"></p>
</div>
<div class="update-form">
	<h2>Change Email</h2>
	<p class="row"><label>Email Address</label><input type="text" id="email" class="text" value="<?php echo $info->getEmail();?>"></p>
	<p class="row"><input type="button" class="sub-button" value="Update" onclick="updateData('update-email', 'email='+$('#email').val())"></p>
</div>
<div class="update-form">
	<h2>Change Password</h2>
	<p class="row"><label>Current Password</label><input type="password" class="text"></p>
	<p class="row"><label>New Password</label><input type="password" class="text"></p>
	<p class="row"><label>Re-type Password</label><input type="password" class="text"></p>
	<p class="row"><input type="button" class="sub-button" value="Update"></p>
</div>