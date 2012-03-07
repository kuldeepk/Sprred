<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta id="robots" name="robots" content="NOINDEX, NOFOLLOW" />
<link rel="shortcut icon" href="/images/favicon.gif" type="image/gif"/>
<link rel="shortcut icon" href="/images/sprred-favicon.png" type="image/png"/>
<link rel="apple-touch-icon" href="/images/sprred-grapic-sq.png"/>
<link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/general.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/lightbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/dashboard.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/admin.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/uploadify.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/jquery.rte.css" media="screen" />
<script type="text/javascript" src="/js/jquery.js"></script>
<script type="text/javascript" src="/js/admin/application.js"></script>

<?php echo $header; ?>

<?php include(dirname(__FILE__)."/../analytics.inc.php"); ?>
</head>

<body>
<div id="bg-left">
<div id="bg-right">
	<br>	
	<div id="header">
		<div id="header-bar">
			<div id="sprred-logo">
				<a href="http://www.sprred.com/"><img src="/images/sprred-logo-s.png"></a>
			</div>
			<form id="search-box-s" method="get" action="/admin121/search.php" class="rounded6">
				<input type="text" name="q" size="30" value="<?php echo $_GET['q']; ?>">
				<input type="submit" value="Search" id="s-button">
			</form>
			<!--
			<div id="status-box">
				<textarea id="inline-content" onfocus="" onblur="">What's happening?</textarea>
				<input type="submit" value="Post" onclick="postInline($('#inline-content').val());" style="display:none;" class="sub-button">
				<div class="reset"></div>
			</div>
			-->
			<div id="univ-actions">
				<a href="http://sprred.uservoice.com" target="_blank">Support</a> | <a href="/logout.php">Log out</a>
				<div class="reset"></div>
			</div>
			<div class="reset"></div>
		</div>
	<div class="bottom-border" onclick="hideOperation();"><div class="up-arrow"></div></div>
	</div>
	
	
	