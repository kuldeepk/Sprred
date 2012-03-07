<?php 
$auth = new Auth();
?>
<div id="sprred-chiclet">
	<?php if(!$auth->checkLogin()){ ?>
	<a href="http://www.sprred.com" id="create-sprred">Create your own Sprred</a>
	<?php } ?>
	<a href="http://www.sprred.com" id="sprred-logo"><img src="/images/sprred-logo-xs.png"></a>
	<?php if(!$auth->checkLogin()){ ?>
	<div id="sprred-login">
		<a href="Javascript:void(0);" id="login-button" onclick="$('#login-box').toggle();$(this).toggleClass('selected');">Log in</a>
		<div id="login-box">
			<form action="http://www.sprred.com/" method="post" id="login-form">
				<p><input type="text" id="email" name="email" value="Email address" title="Email address" maxlength="64" size="30" class="required email text toggle" onfocus="if($(this).val()==$(this).attr('title')){ $(this).toggleClass('selected'); $(this).val('');}" onblur="if($(this).val()==''){ $(this).toggleClass('selected'); $(this).val($(this).attr('title')); }"><label></label></p>
				<p><input type="password" id="password" name="password" value="Password" title="Password" maxlength="30" size="30" class="required text toggle" minlength="6" onfocus="if($(this).val()==$(this).attr('title')){ $(this).toggleClass('selected'); $(this).val('');}" onblur="if($(this).val()==''){ $(this).toggleClass('selected'); $(this).val($(this).attr('title')); }"><label></label></p>
				<p><input type="submit" name="sub-login" class="login-submit sub-button" value="Log In"></p>
				<div class="reset"></div>
			</form>
			<p class="text-msg"><a href="http://www.sprred.com/forgot.php">Forgot your password?</a></p>
		</div>
	</div>
	<?php } else { ?>
	<a href="http://www.sprred.com/dashboard/" id="sprred-dashboard">Dashboard</a>
	<?php } ?>
</div>