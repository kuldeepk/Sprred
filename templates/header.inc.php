<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<?php echo $title; ?>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta id="robots" name="robots" content="all" />
<meta name="keywords" http-equiv="keywords" content="share, content, blog, photos, videos" /> 
<meta name="description" http-equiv="description" content="Sprred is the easiest way to publish your 'entire content', where you can manage and publish blog, photos, videos and links. It's more than a blog. It's your Blog+Photostream+Videostream, a content platform equivalent to the Blogger, Flickr and Vimeo combined. Sprred helps you create a complete profile." />
<link rel="shortcut icon" href="/images/favicon.gif" type="image/gif"/>
<link rel="shortcut icon" href="/images/sprred-favicon.png" type="image/png"/>
<link rel="apple-touch-icon" href="/images/sprred-grapic-sq.png"/> 
<link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/lightbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/general.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/home.css" media="screen" />
<script type="text/javascript" src="/js/jquery.js"></script>

<?php echo $header; ?>

<?php include(dirname(__FILE__)."/analytics.inc.php"); ?>
</head>

<body>
<div id="bg-left">
<div id="bg-right">	
	<div id="header" class="roundedbottom5">
		<div id="sprred-logo">
			<a href="http://www.sprred.com/"><img src="/images/sprred-logo-s.png"></a>
		</div>
		<div id="login-button" onclick="$('#login-box').toggle();">Log in</div>
		<div id="login-box">
			<form action="/" method="post" id="login-form">
				<p><input type="text" id="email" name="email" value="Email address" title="Email address" maxlength="64" size="30" class="required email text toggle"><label></label></p>
				<p><input type="password" id="password" name="password" value="Password" title="Password" maxlength="30" size="30" class="required text toggle" minlength="6"><label></label></p>
				<?php if(isset($_SESSION['loginMsg'])){ ?>
					<p><label class="error-msg"><?php echo $_SESSION['loginMsg'];?></label></p>
				<?php } ?>
				<p><input type="submit" name="sub-login" class="login-submit sub-button" value="Log In"></p>
				<div class="reset"></div>
			</form>
			<p class="text-msg"><a href="forgot.php">Forgot your password?</a></p>
		</div> <!--login-box-->
		<div class="reset"></div>
	</div>
	<div id="main-nav"></div>