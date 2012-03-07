<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/controllers/ForgotPass.cntrl.php");
/*************************************/

$cntrl =& new ForgotPassController();

$title = '<title>Sprred - Forgot Your Password?</title>';
$header = '<script>
  $(document).ready(function(){
    $("#forgot-form").validate();
  });
</script>';
?>

<?php include(dirname(__FILE__)."/../templates/header.inc.php"); ?>

<div id="contents" class="rounded5">
	<div id="forgot">
	<form id="forgot-form" action="<?php echo $HTTP_SERVER_VARS['PHP_SELF']; ?>" method="post">
		<?php if(isset($_SESSION['forgot-sent'])) {?>
			<div id="forget-success">
				<p>An email is sent to this address with a link. Please follow that link to reset you password. </p>
				<p>If you do not recieve any email please click <a href="/forgot.php">here</a> to try again. </p>
			</div>	
		<?php 
			unset($_SESSION['forgot-sent']);
		} else {?>
		<div id="forgot-content">
			<h2>Forgot your password?</h2>
			<label>Enter Your Email Address</label>
			<input type="text" size="30" name="email" id="email" class="email required">
			<?php if(isset($_SESSION['forgot-msg'])) {?>
				<label class="error"><?php echo $_SESSION['forgot-msg']; ?></label>
			<?php 
				unset($_SESSION['forgot-msg']);
			} ?><br/>
			<input type="submit" value="Submit" name="sub-forgot" id="frgt-submit">
		</div>
		<?php } ?>
	</form>
	</div>
	<div class="reset"></div>
</div> <!--contents-->

<?php include(dirname(__FILE__)."/../templates/footer.inc.php"); ?>