<?php

$body = '
<html>
<body>
  <div style="background-color:#FFFFFF; padding:0px 20px; border:1px solid #DDD; border-bottom:none;">
  	<a href="http://www.sprred.com"><img src="http://www.sprred.com/images/sprred-logo-s.png" style="border:none; margin:20px auto;"></a>
  </div>
  <div style="background-color:#BBDBE8; padding:20px; -moz-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset; -webkit-box-shadow:0px 2px 3px rgba(0, 0, 0, 0.2) inset;">
  	<div style="background-color:#FFFFFF; padding:20px; font-family:Arial; font-size:13px; color:#333; -moz-border-radius:5px; -webkit-border-radius:5px;">
	  <p>Hello'; 
		if($toName)
			$body .= ' '.$toName;
$body .=',</p>
	  <p>Following content has been published on your Sprred,<br/><br/>  
	  </p>
	  <p>
	  	<ol style="">';

		foreach($posts as $key=>$post){
			if(!$post['error']){
				if($post['type']=='blog'){
					$body.='<li><b>Blog Post</b>: '.$post['title'].' - '.$post['url'].'</li>';
				} else if($post['type']=='photo'){
					$body.='<li><b>Photo</b>: '.$post['title'].' - '.$post['url'].' with attachment - '.$post['filename'].'</li>';
				} else if($post['type']=='video'){
					$body.='<li><b>Video</b>: '.$post['title'].' - '.$post['url'].' with attachment - '.$post['filename'].'</li>';
				}
			} else {
				if($post['type']=='blog' && $post['errorCode']==102){
					$body.='<li>Email with subject: '.$post['title'].' - couldn\'t be posted due to empty email body.</li>';
				} else if($post['errorCode']==100){
					$body.='<li>Error in while posting due to unrecognized file type of attachment - '.$post['filename'].'</li>';
				} else if($post['errorCode']==101){
					$body.='<li>Unknown error while posting attachment - '.$post['filename'].'</li>';
				}
			}
		}
	  		
	  $body .= '</ol>
	  </p>
	  <br/><br/>
	  <p>Visit your Sprred <a href="'.$profileURL.'" style="color:#1785CD;">here</a>
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
