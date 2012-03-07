<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../../conf/session.conf.php");
if($cookie = $_GET['cookie-data']){
	global $SESSION_NAME;
	$chars = explode($SESSION_NAME."=", $cookie);
	$chars = preg_split('/[;]/', $chars[1], -1, PREG_SPLIT_OFFSET_CAPTURE);
	//$chars = preg_split('/[=]/', $chars[0][0], -1, PREG_SPLIT_OFFSET_CAPTURE);
	session_id($chars[0][0]);
}
session_start();

set_time_limit(300);
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../../includes/classes/Auth.class.php"); 
require_once(dirname(__FILE__)."/../../../includes/classes/UploadPost.class.php"); 
require_once(dirname(__FILE__)."/../../../includes/lib/connect.lib.php");
require_once(dirname(__FILE__)."/../../../includes/lib/encode.lib.php");  
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	$response['errorMsg'] = "You don't seemed to be logged in.";
	$response['errorNum'] = 0;
	$encoded = json_encode($response);
	die($encoded);
}

if($_FILES['photo']){
    $userfile_name = $_FILES['photo']['name'];
	$userfile_tmp = $_FILES['photo']['tmp_name'];
	$userfile_size = $_FILES['photo']['size'];
	$filename = basename($_FILES['photo']['name']);
	$tags = filter_input(INPUT_GET, 'photos-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_GET, 'photos-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';
	
	$tmpPath = CACHE_PATH.Auth::getLoggedInID()."-".time().$filename;
	
	if($_FILES['photo']['size']==0){
		$response['errorMsg'] = "Invalid file.";
		$response['errorNum'] = 2;
		$encoded = json_encode($response);
		die($encoded);
	}
	if(!move_uploaded_file($userfile_tmp, $tmpPath)){
		$response['errorMsg'] = "Unable to cache file.";
		$response['errorNum'] = 3;
		$encoded = json_encode($response);
		die($encoded);
	}
	
	$path_parts = pathinfo($tmpPath);			
	$onlyname = $path_parts['filename'];
	$file_ext = $path_parts['extension'];
	if (($file_ext!="jpg") && ($file_ext!="JPG") && ($file_ext!="jpeg") && ($file_ext!="JPEG") && ($file_ext!="gif") && ($file_ext!="png")) {
		if(file_exists($tmpPath))
			unlink($tmpPath);
		$response['errorMsg'] = "File extension is : $file_ext. ONLY .jpg, .gif, .png images are accepted for upload.";
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	}
	
	$upload = new UploadPost(Auth::getLoggedInID());
	if($publishOption != 'on')
		$upload->createPhotoPost(basename($filename, '.'.$file_ext), $tmpPath, null, $tags, time(), time(), $status);
	if(file_exists($tmpPath))
		unlink($tmpPath);
	$response['msg'] = $filename;
	$encoded = json_encode($response);
	die($encoded);
} if($_FILES['video']){
    $userfile_name = $_FILES['video']['name'];
	$userfile_tmp = $_FILES['video']['tmp_name'];
	$userfile_size = $_FILES['video']['size'];
	$filename = basename($_FILES['video']['name']);
	$tags = filter_input(INPUT_GET, 'videos-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_GET, 'videos-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';
	
	$tmpPath = CACHE_PATH.Auth::getLoggedInID()."-".time().$filename;
	
	if($_FILES['video']['size']==0){
		$response['errorMsg'] = "Invalid file.";
		$response['errorNum'] = 2;
		$encoded = json_encode($response);
		die($encoded);
	}
	if(!move_uploaded_file($userfile_tmp, $tmpPath)){
		$response['errorMsg'] = "Unable to cache file.";
		$response['errorNum'] = 3;
		$encoded = json_encode($response);
		die($encoded);
	}
	
	$path_parts = pathinfo($tmpPath);			
	$onlyname = $path_parts['filename'];
	$file_ext = $path_parts['extension'];
	/*if (($file_ext!="jpg") && ($file_ext!="JPG") && ($file_ext!="jpeg") && ($file_ext!="JPEG") && ($file_ext!="gif") && ($file_ext!="png")) {
		if(file_exists($tmpPath))
			unlink($tmpPath);
		$response['errorMsg'] = "File extension is : $file_ext. ONLY .jpg, .gif, .png images are accepted for upload.";
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	}*/
	
	$upload = new UploadPost(Auth::getLoggedInID());
	if($publishOption != 'on')
		$upload->createVideoPost(basename($filename, '.'.$file_ext), $file_ext, $tmpPath, null, $tags, time(), time(), $status);
	if(file_exists($tmpPath))
		unlink($tmpPath);
	$response['msg'] = $filename;
	$encoded = json_encode($response);
	die($encoded);
} else if($_FILES['file']){
    $userfile_name = $_FILES['file']['name'];
	$userfile_tmp = $_FILES['file']['tmp_name'];
	$userfile_size = $_FILES['file']['size'];
	$filename = basename($_FILES['file']['name']);
	$parts = explode('.', $filename);
	$onlyname = $parts[0];
	$file_ext = $parts[1];
	$tmpPath = CACHE_PATH.Auth::getLoggedInID()."-".time().$filename;
	
	if($_FILES['file']['size']==0){
		$response['errorMsg'] = "Invalid file.";
		$response['errorNum'] = 2;
		$encoded = json_encode($response);
		die($encoded);
	}
	if(!move_uploaded_file($userfile_tmp, $tmpPath)){
		$response['errorMsg'] = "Unable to cache file.";
		$response['errorNum'] = 3;
		$encoded = json_encode($response);
		die($encoded);
	}
	
	$upload = new UploadPost(Auth::getLoggedInID());
	$upload->createFilePost($userfile_name, $tmpPath, null, null, time(), time());
	if(file_exists($tmpPath))
		unlink($tmpPath);
	$response['msg'] = $filename;
	$encoded = json_encode($response);
	die($encoded);
} else if($_POST['action'] == 'post-blog'){
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	if(!$title){
		$response['errorMsg'] = "Title is empty. Please provide a title to the post.";
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	}
	//$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_SPECIAL_CHARS);
	$content = stripslashes($_POST['content']);
	if(!$content){
		$response['errorMsg'] = "The message is empty.";
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	}
	$tags = filter_input(INPUT_POST, 'text-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_POST, 'text-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';	
	$upload = new UploadPost(Auth::getLoggedInID());
	if($publishOption != 'on')
		$upload->createBlogPost($title, $content, $tags, time(), time(), $status);
		
	$response['msg'] = "Blog Posted!";
	$encoded = json_encode($response);
	die($encoded);
} else if($_POST['action'] == 'post-inline'){
	$content = filter_input(INPUT_POST, 'content', FILTER_SANITIZE_STRING);
	if(!$content){
		$response['errorMsg'] = "The message is empty.";
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	}
	if(strlen($content) > 800){
		$response['errorMsg'] = "The message length is greater than maximum allowed length of 800 characters.";
		$response['errorNum'] = 2;
		$encoded = json_encode($response);
		die($encoded);
	}
	$content = strip_tags($content);
	$upload = new UploadPost(Auth::getLoggedInID());
	$upload->createInlinePost($content, null, time(), time());
	$response['msg'] = $content;
	$encoded = json_encode($response);
	die($encoded);
} else if($_POST['action'] == 'post-link'){
	if(!filter_input(INPUT_POST, 'url', FILTER_VALIDATE_URL)){
		$response['errorMsg'] = "Invalid URL!";
		$response['errorNum'] = 2;
		$encoded = json_encode($response);
		die($encoded);
	}
	$url = filter_input(INPUT_POST, 'url', FILTER_SANITIZE_URL);
	$title = filter_input(INPUT_POST, 'title', FILTER_SANITIZE_STRING);
	if(!$title)
		$title = 'Untitled';
	$tags = filter_input(INPUT_POST, 'link-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_POST, 'link-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';	
	$upload = new UploadPost(Auth::getLoggedInID());
	$upload->createLinkPost($title, $url, $tags, time(), time(), $status);
	
	$response['msg'] = $title;
	$encoded = json_encode($response);
	die($encoded);
}



?>
