<div id="join-box" class="rounded5">
	<h2>Sign Up</h2>
	<p class="text-msg">Already on Sprred? <a href="login.php">Login</a></p>
	<div class="reset"></div>
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" id="join-form">
		<p><span class="help"><label class="tag">Email</label></span><input type="text" id="email" name="email" maxlength="64" size="30" class="required email text"><label></label></p>
		<p><span class="help"><label class="tag">Password</label></span><input type="password" id="password" name="password" maxlength="30" size="30" class="required text" minlength="6"><label></label></p>
		<p><span class="help"><label class="tag">URL</label></span><input type="text" id="url" name="url" size="30" class="url text" minlength="3">.sprred.com<label></label></p>
		<span class="check"><input type="checkbox" name="updates" value="recieve" checked="checked">Send me updates on Sprred.</span>
		<?php if(isset($_SESSION['regMsg'])){ ?>
			<p><label class="error-msg"><?php echo $_SESSION['regMsg'];?></label></p>
		<?php } ?>
		<p><input type="submit" name="sub-join" class="reg-submit sub-button" value="Create My Account"></p>
		<div class="reset"></div>
	</form>
</div> <!--join-box-->
<div class="reset"></div>