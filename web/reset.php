<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/controllers/ResetPass.cntrl.php");
/*************************************/

$cntrl =& new ResetPassController();

$title = '<title>Sprred - Forgot Your Password?</title>';
$header = '<script>
  $(document).ready(function(){
    $("#reset-form").validate();
  });
</script>';
?>

<?php include(dirname(__FILE__)."/../templates/header.inc.php"); ?>

<div id="contents" class="rounded5">
	<form id="reset-form" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>?id=<?php echo $_GET['id']; ?>&auth=<?php echo $_GET['auth']; ?>" method="post">
		<?php 
		if(isset($_SESSION['reset-done'])) {?>
			<div id="reset-done">
				<p>Your new password is set. Please click <a href="/">here</a> to login. </p>
			</div>
		<?php 
			unset($_SESSION['reset-done']);
			unset($_SESSION['email']);
		} else if(isset($_SESSION['reset-invalid'])) {?>
			<div id="reset-done">
				<p class="error">Invalid URL!</p>
			</div>
		<?php 
			unset($_SESSION['reset-invalid']);
		} else { ?>		
		<div id="reset-content">
			<h2>Reset your password</h2>
			<table cellspacing="10px">
				<tr><td>New Password</td><td><input type="password" size="20" minlength="6" maxlength="30" name="password" class="required"></td></tr>
				<tr><td>Confirm Password</td><td><input type="password" size="20" minlength="6" maxlength="30" name="confirm" class="required"></td></tr>
			<?php if(isset($_SESSION['reset-msg'])) {?>
				<tr><td colspan="2"><label class="error"><?php echo $_SESSION['reset-msg']; ?></label></td></tr>
			<?php 
				unset($_SESSION['reset-msg']);
			} ?><br/>
				<tr><td colspan="2" align="center"><input type="submit" value="Submit" name="sub-reset" id="reset-submit"></td></tr>
			</table>
		</div>
		<?php } ?>
	</form>
	<div class="reset"></div>
</div> <!--contents-->

<?php include(dirname(__FILE__)."/../templates/footer.inc.php"); ?>