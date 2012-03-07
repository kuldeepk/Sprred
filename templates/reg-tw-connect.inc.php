<div id="join-box">
	<h2 class="reg-heading">Hello <?php echo $info->{'name'}; ?>,</h2>
	<h1 class="reg-heading">Link Your Account</h1>
	<p class="desc">Why this step?</p><div class="reset"></div>
	<p class="hi-msg">Seems like this is your first time on Redanyway with Twitter login.<br> Please login or register yourself and let us link your Twitter account.</p>
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" id="join-form" class="tw-link-form">
		<h1>New on Redanyway? Sign up.</h1>
		<p><span class="help"><label class="tag">Email *</label></span><input type="text" id="email" name="email" maxlength="64" size="30" class="required email text"><label></label></p>
		<p><span class="help"><label class="tag">Password *</label></span><input type="password" id="password" name="password" maxlength="30" size="30" class="required text" minlength="6"><label></label></p>
		<p><span class="help"><label class="tag">Blog URL</label></span><input type="text" id="url" name="url" size="30" class="text url" minlength="3"><label></label></p>
		<span class="check"><input type="checkbox" name="updates" value="recieve" checked="checked"> Send me updates on Redanyway.</span>
		<?php if(isset($_SESSION['regMsg'])){ ?>
			<p><label class="error-msg"><?php echo $_SESSION['regMsg'];?></label></p>
		<?php 
			unset($_SESSION['regMsg']);
		} ?>
		<p><input type="submit" name="sub-tw-join" class="reg-submit sub-button" value="Create My Account"></p>
		<div class="reset"></div>
	</form>
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" id="login-form" class="join-form tw-link-form">
		<h1>Already on Redanyway? Log in.</h1>
		<p><span class="help"><label class="tag">Email</label></span><input type="text" id="log-email" name="log-email" maxlength="32" size="30" class="required email text"><label></label></p>
		<p><span class="help"><label class="tag">Password</label></span><input type="password" id="log-passwd" name="log-passwd" maxlength="30" size="30" class="required text" minlength="6"><label></label></p>
		<?php if(isset($_SESSION['log-status'])){ ?>
			<p><label class="error-msg"><?php echo $_SESSION['log-status'];?></label></p>
		<?php 
			unset($_SESSION['log-status']);
		} ?>
		<p><input type="submit" name="sub-tw-login" class="reg-submit sub-button" value="Log in"></p>
		<div class="reset"></div>
	</form>
		
	<div class="reset"></div>
</div> <!--join-box-->
<div class="reset"></div>