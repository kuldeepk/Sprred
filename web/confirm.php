<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/controllers/Confirm.cntrl.php");
/*************************************/

$cntrl =& new ConfirmController();

$title = "<title>Sprred - Email Confirmation</title>";
$header = '';

?>

<?php include(dirname(__FILE__)."/../templates/header.inc.php"); ?>

<div id="contents" class="rounded5">
	<div id="reset-form">
		<?php 
		if(isset($_SESSION['confirm-msg'])){ ?>
			<div id="reset-done">
				<p><?php echo $_SESSION['confirm-msg']; ?></p>
			</div>
		<?php 
			unset($_SESSION['confirm-msg']);
		} ?>
	</div>
	<div class="reset"></div>
</div> <!--contents-->

<?php include(dirname(__FILE__)."/../templates/footer.inc.php"); ?>