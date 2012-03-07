<div id="join-box">
	<form action="<? echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post" id="join-form">
		<h1>Hello <?php echo $info[0]['name']; ?>,</h1>
		<p class="hi-msg">Seems this is your first time on Sprred.<br> First, let's create an account for you on Sprred!</p>
		<?php
		if($info[0]['pic_square']){ ?>
			<p class="save-msg"><input type="checkbox" name="save-pic" value="save" checked="checked"><img src="<?php echo $info[0]['pic_square']; ?>"><label>Save my Facebook profile pic</label><div class="reset"></div></p>
		<?php } ?>
		<p><span class="help"><label class="tag">Email</label></span><input type="text" id="email" name="email" maxlength="64" size="30" class="required email text"><label></label></p>
		<p><span class="help"><label class="tag">Password</label></span><input type="password" id="password" name="password" maxlength="30" size="30" class="required text" minlength="6"><label></label></p>
		<p><span class="help"><label class="tag">URL</label></span><input type="text" id="url" name="url" size="30" class="url text" minlength="3">.sprred.com<label></label></p>
		<span class="check"><input type="checkbox" name="updates" value="recieve" checked="checked"> Send me updates on Redanyway.</span>
		<?php if(isset($_SESSION['regMsg'])){ ?>
			<p><label class="error-msg"><?php echo $_SESSION['regMsg'];?></label></p>
		<?php } ?>
		<p><input type="submit" name="sub-fb-join" class="reg-submit sub-button" value="Create My Account"></p>
		<div class="reset"></div>
	</form>
</div> <!--join-box-->
<div class="reset"></div>