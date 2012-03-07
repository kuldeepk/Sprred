<div id="login-box">
	<h2>Log In</h2>
	<form action="#" method="post" id="login-form">
		<p><span class="help"><label class="tag">Email</label></span><input type="text" id="email" name="email" maxlength="64" size="30" class="required email text"><label></label></p>
		<p><span class="help"><label class="tag">Password</label></span><input type="password" id="password" name="password" maxlength="30" size="30" class="required text" minlength="6"><label></label></p>
		<?php if(isset($_SESSION['loginMsg'])){ ?>
			<p><label class="error-msg"><?php echo $_SESSION['loginMsg'];?></label></p>
		<?php } ?>
		<p><input type="submit" name="sub-login" class="login-submit sub-button" value="Log In"></p>
		<div class="reset"></div>
	</form>
	<p class="text-msg"><a href="forgot.php">Forgot your password?</a></p>
	<div id="connect-links">
		<a href="Javascript:void(0);" onclick="twOAuthPop('<?=$request_link ?>');">Sign in with Twitter</a>
		<a href="Javascript:void(0);" onclick="FB.Connect.requireSession(fb_login);" id="fb-connect-button" class="connect-button rounded5">Sign in with Facebook</a>
	</div>
</div> <!--login-box-->
<div class="reset"></div>