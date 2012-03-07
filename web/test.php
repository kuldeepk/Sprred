<?php
ini_set('display_errors', 1);

require_once(dirname(__FILE__).'/../includes/lib/mail.lib.php');



$body = '<html>
<body>
  <div style="background-color:#FFFFFF; padding:0px 20px; border:1px solid #DDD; border-bottom:none;">
  	<a href="http://www.sprred.com"><img src="http://www.sprred.com/images/sprred-logo-s.png" style="border:none; margin:20px auto;"></a>
  </div>
  <div style="background-color:#BBDBE8; padding:20px; box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset; -moz-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset; -webkit-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset;">
  	<div style="background-color:#FFFFFF; padding:20px; font-family:Arial; font-size:13px; color:#333; border-radius:5px; -moz-border-radius:5px; -webkit-border-radius:5px;">
	  <p>Hello,</p>
	  <p>We are excited to launch our new product called, <b>Sprred</b> (<a href="http://www.sprred.com" style="color:#1785CD;">http://www.sprred.com</a>) and we\'d love you to be the first ones to check it out!
	  </p>
	  <p style="padding:10px; border-top:2px solid #AAA; border-bottom:2px solid #AAA; font-family:Arial;font-size:13px; font-weight:bold; color:#555; line-height:24px;">
	  Sprred is an easiest way to publish your \'entire content\', where you can manage and publish blog, photos, videos and links. It\'s more than a blog. It\'s your Blog+Photostream+Videostream, a content platform equivalent to the Blogger, Flickr and Vimeo combined. Sprred helps you create a complete profile.
	  </p>
	  <p style="margin:35px 10px;"><a href="http://sprred.com" style="font-size:20px; font-weight:bold; background:#2DAEBF; display: inline-block; padding:12px 20px; color: #fff; text-decoration: none;	font-weight: bold; line-height: 1; -moz-border-radius: 3px;	-webkit-border-radius: 3px;	-moz-box-shadow: 0 1px 3px rgba(0,0,0,0.5); -webkit-box-shadow: 0 1px 3px rgba(0,0,0,0.5); text-shadow: 0 -1px 1px rgba(0,0,0,0.25); border-bottom: 1px solid rgba(0,0,0,0.25);	cursor: pointer; border-bottom:1px solid rgba(0, 0, 0, 0.25);">Create your Sprred, now!</a></p>
	  <p>We hope you have a good experience with your Sprred.<br/><br/>
	  Hit \'Reply\' and let us know what do you think. We\'d love to hear it!
	  </p>
	  <br/><p>
	  Thanks,<br/>
	  Sprred Team<br/>
	  <a href="http://www.sprred.com" style="color:#1785CD;">sprred.com</a>
	  </p>
	 </div>
  </div>
</body>
</html>';

echo $body;

Mail::send('kuldeep@sprred.com', 'Kuldeep', 'kuldeep@sprred.com', 'Sprred: An easiest way to publish your \'entire content\' launches! Its more than a blog...', $body, 'test');

?>