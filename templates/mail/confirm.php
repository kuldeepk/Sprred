<?php

$body = '
<html>
<body>
  <div style="background-color:#FFFFFF; padding:0px 20px; border:1px solid #DDD; border-bottom:none;">
  	<a href="http://www.sprred.com"><img src="http://www.sprred.com/images/sprred-logo-s.png" style="border:none; margin:20px auto;"></a>
  </div>
  <div style="background-color:#BBDBE8; padding:20px; -moz-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset; -webkit-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset;">
  	<div style="background-color:#FFFFFF; padding:20px; font-family:Arial; font-size:13px; color:#333; -moz-border-radius:5px; -webkit-border-radius:5px;">
	  <p>Hello,</p>
	  <p>You are required to confirm you email address to activate your Sprred account.<br/><br/>  
	  To confirm your email address, please click <a href="'. $confirmUrl .'" style="color:#1785CD;">here</a> or visit the following address,<br/>
	  <br/>'. $confirmUrl .'
	  </p>
	  <p>
	  Thanks,<br/>
	  Sprred Team<br/>
	  <a href="http://www.sprred.com" style="color:#1785CD;">sprred.com</a>
	  </p>
	 </div>
  </div>
  <div style="background-color:#FFFFFF; padding:10px 20px; border:1px solid #DDD; color:#555;">
  	---<br/>
  	<small>This is an auto generated email. Please do not reply to this email. If you have any concerns please drop a note to info@sprred.com</small>
  </div>
</body>
</html>
';

?>
