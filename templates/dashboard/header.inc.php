<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml" xml:lang="en" lang="en" xmlns:fb="http://www.facebook.com/2008/fbml">
<head>
<title><?php echo $title; ?></title>
<meta http-equiv="Content-type" content="text/html; charset=utf-8" />
<meta id="robots" name="robots" content="all" />
<link rel="shortcut icon" href="/images/favicon.gif" type="image/gif"/>
<link rel="shortcut icon" href="/images/sprred-favicon.png" type="image/png"/>
<link rel="apple-touch-icon" href="/images/sprred-grapic-sq.png"/>
<link rel="stylesheet" type="text/css" href="/css/reset.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/general.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/lightbox.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/dashboard.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/uploadify.css" media="screen" />
<link rel="stylesheet" type="text/css" href="/css/jquery.rte.css" media="screen" />
<script type="text/javascript" src="/js/jquery.js"></script>

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
			<div id="main-options">
				<label>Quick Post:</label>
				<h4 class="rounded3" onclick="toggleOperation('#post-text', this);"><div id="text-button" class="icon"></div>Text</h4>
				<h4 class="rounded3" onclick="toggleOperation('#post-photos', this);"><div id="photos-button" class="icon"></div>Photos</h4>
				<h4 class="rounded3" onclick="toggleOperation('#post-videos', this);"><div id="videos-button" class="icon"></div>Videos</h4>
				<h4 class="rounded3" onclick="toggleOperation('#post-link', this);"><div id="link-button" class="icon"></div>Link</h4>
				<div class="reset"></div>
			</div>
			<div id="quick-feedback" onclick="$('#quick-feedback-form').toggle();$('#quick-feedback-overlay').toggle();">Quick Feedback</div>
			<div id="quick-feedback-overlay" onclick="$('#quick-feedback-form').toggle();$('#quick-feedback-overlay').toggle();"></div>
			<div id="quick-feedback-form" class="update-form rounded5">
				<p class="row"><label>Subject: </label><input type="text" name="feedback-subject" class="text"></p>
				<p class="row"><label>Feedback: </label><textarea name="feedback-body" class="textarea"></textarea></p>
				<p class="row"><input type="button" class="sub-button" value="Submit"><a href="Javascript:void(0);" style="margin-left:10px;" onclick="$('#quick-feedback-form').toggle();$('#quick-feedback-overlay').toggle();">Cancel</a></p>
			</div>
			<div class="reset"></div>
		</div>
		<div id="main-operations">
			<form id="post-text" class="post-box" style="display:none;">
				<div class="main-boxes">
					<p class="caption">Title</p>
					<p class="input"><input type="text" id="post-title" class="title text" name="title"></p>
					<p class="caption">Text</p>
					<p class="input"><textarea id="post-content" class="wysiwyg"></textarea></p>
					<input type="button" value="Post" class="sub-button" onclick="post('post-blog', $('form#post-text').serialize()+'&content='+urlencode($('#post-text').data('editor').get_content()));">
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down" name="text-publish-option">
							<option value="now" selected="selected">Publish Now!</option>
							<!--<option value="on">Publish On...</option>-->
							<option value="save">Save as a Draft</option>
							<option value="private">Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="tags" name="text-tags"></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
			<form id="post-photos" class="post-box" style="display:none;">
				<h2>Upload Photos</h2>
				<div class="main-boxes">
					<div id="photosQueue" class="uploadQueue rounded5"></div>
					<input type="file" id="upload-photo">
					<p><input type="button" class="sub-button" id="sub-upload-photos" value="Start Uploading"></p>
					<p><a href="Javascript:void(0);" onclick="$('#upload-photo').uploadifyClearQueue()">Cancel All Uploads</a></p>
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down" name="photos-publish-option">
							<option value="now" selected="selected">Publish Now!</option>
							<!--<option value="on">Publish On...</option>-->
							<option value="save">Save as a Draft</option>
							<option value="private">Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="photos-tags" name="photos-tags"></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
			<form id="post-videos" class="post-box" style="display:none;">
				<h2>Upload Videos</h2>
				<div class="main-boxes">
					<div id="videosQueue" class="uploadQueue rounded5"></div>
					<input type="file" id="upload-video">
					<p><input type="submit" class="sub-button" id="sub-upload-videos" value="Start Uploading"></p>
					<p><a href="Javascript:void(0);" onclick="$('#upload-video').uploadifyClearQueue()">Cancel All Uploads</a></p>
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down" name="videos-publish-option">
							<option value="now" selected="selected">Publish Now!</option>
							<!--<option value="on">Publish On...</option>-->
							<option value="save">Save as a Draft</option>
							<option value="private">Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="videos-tags" name="videos-tags"></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
			<form id="post-files" class="post-box" style="display:none;">
				<h2>Upload Files</h2>
				<div class="main-boxes">
					<div id="filesQueue" class="uploadQueue rounded5"></div>
					<input type="file" id="upload-file">
					<p><input type="submit" class="sub-button" value="Upload Files"></p>
					<p><a href="Javascript:void(0);" onclick="$('#upload-file').uploadifyClearQueue()">Cancel All Uploads</a></p>
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down" name="files-publish-option">
							<option value="now" selected="selected">Publish Now!</option>
							<!--<option value="on">Publish On...</option>-->
							<option value="save">Save as a Draft</option>
							<option value="private">Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="tags" name="files-tags"></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
			<form id="post-link" class="post-box" style="display:none;">
				<div class="main-boxes">
					<p class="caption">Link</p>
					<p class="input"><input type="text" id="link-url" class="title text" name="url"></p>
					<p class="caption">Title</p>
					<p class="input"><input type="text" id="link-title" class="title text" name="title"></p>
					<input type="button" value="Post" class="sub-button" onclick="post('post-link', $('form#post-link').serialize());">
				</div>
				<div class="post-options">
					<p class="caption">Post Options</p>
					<p class="input">
						<select class="drop-down" name="link-publish-option">
							<option value="now" selected="selected">Publish Now!</option>
							<!--<option value="on">Publish On...</option>-->
							<option value="save">Save as a Draft</option>
							<option value="private">Private</option>
						</select>
					</p>
					<p class="caption">Tags</p>
					<p class="input"><textarea id="tags" name="link-tags"></textarea></p>
				</div>
				<div class="reset"></div>
			</form>
		</div>	
		<div class="bottom-border" onclick="hideOperation();"><div class="up-arrow"></div></div>
	</div>
	
	
	