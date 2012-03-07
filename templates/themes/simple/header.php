<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en">
<head>
<title><?php if($postInfo) { echo $postInfo->getPostTitle()." - "; } echo $info->getProfileName(); if($current_page == 'blog' || $current_page == 'photos' || $current_page == 'videos' || $current_page == 'info'){ echo " / ".ucfirst($current_page); } ?> - Sprred</title>
<meta http-equiv="content-type" content="text/html" />
<meta name="description" content="<?php echo $info->getProfileDesc(); ?>" />
<meta name="keywords" content="" />
<link rel="shortcut icon" href="/images/favicon.gif" type="image/gif"/>
<link rel="shortcut icon" href="/images/sprred-favicon.png" type="image/png"/>
<link rel="apple-touch-icon" href="/images/sprred-grapic-sq.png"/> 
<link rel="stylesheet" type="text/css" href="<?php echo $reset_css; ?>" />
<link rel="stylesheet" type="text/css" href="<?php echo $themes_directory; ?>/style.css" />
<link rel="stylesheet" type="text/css" href="<?php echo $chiclet_css; ?>" />
<link rel="alternate" type="application/rss+xml" title="RSS 2.0" href="/rss" />
<script type="text/javascript" src="/js/jquery.js"></script>

<?php include(dirname(__FILE__)."/../../themes/analytics.inc.php"); ?>

</head>
<body>

<div id="body-wrap">
<?php require_once(dirname(__FILE__).'/../chiclet.inc.php'); ?>

<div id="header-panel">
	<div id="menu">
		<ul>
			<li class="<?php if($current_page == "home") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/">Home</a></li>
			<li class="<?php if($current_page == "blog") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/blog">Blog</a></li>
			<li class="<?php if($current_page == "photos") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/photos">Photos</a></li>
			<li class="<?php if($current_page == "videos") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/videos">Videos</a></li>
			<li class="<?php if($current_page == "links") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/links">Links</a></li>
			<li class="<?php if($current_page == "info") echo "page_item current_page_item"; ?>"><a href="<?php echo $info->getProfileURL(); ?>/info">Info</a></li>
			<div class="reset"></div>
		</ul>
	</div>
	<div id="header">
		<h1><a href="<?php echo $info->getProfileURL(); ?>"><?php echo $info->getProfileName(); if($info->getProfileName() == 'Untitled') echo ' - Sprred'; ?></a></h1>
	</div>
</div>
