<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../includes/controllers/SignUp.cntrl.php");
/*************************************/

$cntrl =& new SignUpController();

$title = '<title>Sprred - The best place to share all your content!</title>';

$header = '<link rel="stylesheet" type="text/css" href="css/home/register.css" media="screen" />
<script>
$(document).ready(function(){
	$("input.toggle").focus(function(){
		if($(this).val()==$(this).attr("title")){ $(this).toggleClass("selected"); $(this).val(""); }
	});
	$("input.toggle").blur(function(event){
		if($(this).val()==""){ $(this).toggleClass("selected"); $(this).val($(this).attr("title")); }
	});
	setTimeout(rotate, 5000);
});

function rotate(){
	if($("#title").is(":visible")){
		$("#title").fadeOut("slow");
		$("#title2").fadeIn("slow");
	} else if($("#title2").is(":visible")){
		$("#title2").fadeOut("slow");
		$("#title3").fadeIn("slow");
	} else if($("#title3").is(":visible")){
		$("#title3").fadeOut("slow");
		$("#title").fadeIn("slow");
	}
	setTimeout(rotate, 4000);
}
</script>';
$footer = '<script type="text/javascript" src="js/home/reg.validate.js"></script>';

?>

<?php include(dirname(__FILE__)."/../templates/header.inc.php"); ?>

<div id="contents" class="rounded5">
	<div id="title"></div>
	<div id="title2" style="display:none"></div>
	<div id="title3" style="display:none"></div>
	<div id="join-box" class="rounded5">
		<form action="/" method="post" id="join-form">
			<p><input type="text" id="email" name="email" value="Email Address" title="Email Address" maxlength="64" size="30" class="required email text toggle"><label></label></p>
			<p><input type="password" id="password" name="password" value="Password" title="Password" maxlength="30" size="30" class="required text toggle" minlength="6"><label></label></p>
			<p><div id="sname-box"><input type="text" id="sname" name="sname" value="sprredname" title="sprredname" size="30" class="toggle" minlength="3" onfocus="$(this).parent().toggleClass('selected')" onblur="$(this).parent().toggleClass('selected')">.sprred.com</div><label></label></p>
			<?php if(isset($_SESSION['regMsg'])){ ?>
				<p><label class="error-msg error"><?php echo $_SESSION['regMsg']; unset($_SESSION['regMsg']); ?></label></p>
			<?php } ?>
			<p><input type="submit" name="sub-join" class="reg-submit sub-button" value="Create My Sprred"></p>
			<div class="reset"></div>
		</form>
	</div> <!--join-box-->
	<div class="reset"></div>
	<div><a href="http://kuldeep.sprred.com" id="demo-link">View an Example Sprred &rarr;</a></div>
	<div class="reset"></div>
	<div id="bottom">
		<div class="highlight rounded5 space-out">
			<h2>Post By Email</h2>
			<p>Email your blog, photos or videos to the address below and we will post it to your sprred.</p>
			<h3 class="post-email">post@sprred.com</h3>
		</div>
		<div class="highlight rounded5 space-out">
			<h2>Autopost</h2>
			<p>Autopost your content to other services. Setup a service once on sprred and you don't have to worry about managing it, ever.</p>
			<div class="icons">
				<div class="facebook"></div>
				<div class="twitter"></div>
				<div class="flickr"></div>
				<div class="vimeo"></div>
			</div>
		</div>
		<div class="highlight rounded5">
			<h2>Organize Your Content</h2>
			<p>Now, you can organize your blog, photos and videos separately.</p>
			<h3 class="bold">blog <br/>+<br/> photostream <br/>+<br/> videostream</h3>
		</div>
		<div class="reset"></div>
	</div>
</div> <!--contents-->

<?php include(dirname(__FILE__)."/../templates/footer.inc.php"); ?>