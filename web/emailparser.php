<?php

require_once(dirname(__FILE__)."/../conf/config.inc.php"); 
require_once dirname(__FILE__)."/../includes/lib/mail.lib.php";
require_once(dirname(__FILE__)."/../includes/classes/UploadPost.class.php"); 
require_once(dirname(__FILE__)."/../includes/lib/connect.lib.php"); 
require_once(dirname(__FILE__)."/../includes/dao/UserInfo.dao.php"); 
require_once(dirname(__FILE__)."/../includes/classes/SignUp.class.php"); 
require_once(dirname(__FILE__)."/../includes/classes/Notification.class.php");
set_time_limit(600);

$from_email = split('[<>]', $_POST['from']);
$signup = new SignUp();
if($from_email[1])
	$userID = $signup -> getCreatedID($from_email[1]);
else
	$userID = $signup -> getCreatedID(trim($_POST['from']));

if( ! (trim($_POST['to']) == "post@post.sprred.com" || trim($_POST['to']) == "post@sprred.com") )
	exit(0);
if(!$userID){
	Mail::send('info@sprred.com', 'Sprred', $from_email[1], "Sprred account not found", "Your email ID is not registered on Sprred. You can register now at <a href='http://sprred.com'>Sprred</a> and start posting! ", 'user unavailable');
	exit(0);
}
$upload = new UploadPost($userID);
$userInfo = new UserInfoDAO($userID);
$profileURL = $userInfo -> getProfileURL();

if($_POST['attachments'])
{
	for($i=1; $i<=$_POST['attachments']; $i++){
		$title = $_POST['subject'];
		if(!$title){
			$title = 'Untitled';
		}
		$post_status[$i]['title'] = $title;
		
	    $userfile_name = $_FILES['attachment'.$i]['name'];
		$userfile_tmp = $_FILES['attachment'.$i]['tmp_name'];
		$userfile_size = $_FILES['attachment'.$i]['size'];
		$filename = basename($_FILES['attachment'.$i]['name']);
		
		$tmpPath = CACHE_PATH.$userID."-".time().$filename;
		
		if($_FILES['attachment'.$i]['size']==0){
			$response['errorMsg'] = $_FILES['attachment'.$i]['name']." is an invalid image/video file";
		//	Mail::send('info@sprred.com', 'Info', $from_email[1], 'Error in posting your file', $response['errorMsg'], 'test');
			$post_status[$i]['error'] = true;
			$post_status[$i]['errorCode'] = 100;
			continue;
		}
		if(!move_uploaded_file($userfile_tmp, $tmpPath)){
			$response['errorMsg'] = "Error in caching your image/video file : ".$_FILES['attachment'.$i]['name']."";
		//	Mail::send('info@sprred.com', 'Info', $from_email[1], 'Error in posting your file', $response['errorMsg'],'test');
			$post_status[$i]['error'] = true;
			$post_status[$i]['errorCode'] = 101;
			continue;
		}
		
		$path_parts = pathinfo($tmpPath);			
		$onlyname = $path_parts['filename'];
		$file_ext = $path_parts['extension'];
		
	
		if(stristr($_FILES['attachment'.$i][type], "image")){
			$status = $upload->createPhotoPost($title, $tmpPath, $_POST['html'], null, time(), time());
			$post_status[$i]['type'] = 'photo';
		}
		if(stristr($_FILES['attachment'.$i][type], "video")){
			$status = $upload->createVideoPost($title, $file_ext, $tmpPath, $_POST['html'], null, time(), time());
			$post_status[$i]['type'] = 'video';
		}
		$post_status[$i]['filename'] = $filename;
		$post_status[$i]['url'] = $profileURL.$status['link'];
		$post_status[0]['title'] = $title;
		
		if(file_exists($tmpPath))
			unlink($tmpPath);
	
	}
	$notify = new Notification($userID);
	$notify -> postStatus($post_status);
//	Mail::send('info@sprred.com', 'Info', $from_email[1], "Status of your files posted on Sprred", "<li>".implode("<li>",$post_status), 'test');
	
}
else
{
	$title = $_POST['subject'];
	if(!$title){
		$title = 'Untitled';
	}
	$post_status[0]['title'] = $title;
	//$content = filter_input(INPUT_GET, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
	$content = $_POST['html'];
	if(!$content){
		$content = $_POST['text'];
		if(!$content){
			$post_status[0]['error'] = true;
			$post_status[0]['errorCode'] = 102;
			//Mail::send('info@sprred.com', 'Info', $from_email[1], 'Error in posting your blog', "Failure in posting Empty Blog",'test');
		}
	}

	$upload = new UploadPost($userID);
		$status = $upload->createBlogPost($title, $content, null, time(), time());
	if($status['link'])
		$post_status[0]['url'] = $profileURL.$status['link'];
	$post_status[0]['type'] = 'blog';

	$notify = new Notification($userID);
	$notify -> postStatus($post_status);
	
	//Mail::send('info@sprred.com', 'Info', $from_email[1], $postlink, $_POST['to'], 'test');
}




?>