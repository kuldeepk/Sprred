<?php
/* Start Session *********************/
require_once(dirname(__FILE__)."/../../../conf/session.conf.php");
session_start();
/*************************************/

/* Include Files *********************/
require_once(dirname(__FILE__)."/../../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../../includes/classes/SignUp.class.php");
/*************************************/

$auth = new Auth();
if(!$auth->checkLogin()){
	$response['errorMsg'] = "You don't seemed to be logged in.";
	$response['errorNum'] = 0;
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['action'] == 'del-post'){
	require_once(dirname(__FILE__)."/../../../includes/classes/AdminPost.class.php"); 
	
	$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_STRING);
	$admin = new AdminPerPost(Auth::getLoggedInID(), $postID);
	$admin->deletePost();
	$response['msg'] = "Post deleted!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['action'] == 'edit-blog-post'){
	require_once(dirname(__FILE__)."/../../../includes/classes/AdminPost.class.php"); 
	
	$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_STRING);
	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
	if(!$title)
		$title = 'Untitled';
	//$content = filter_input(INPUT_GET, 'content', FILTER_SANITIZE_STRING);
	$content = stripslashes($_GET['content']);
	$tags = filter_input(INPUT_GET, 'text-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_GET, 'text-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';
		
	$admin = new AdminPerPost(Auth::getLoggedInID(), $postID);
	$admin->updateBlogPost($title, $content, $tags, $status);
	$response['msg'] = "Post updated!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['action'] == 'edit-photo-post'){
	require_once(dirname(__FILE__)."/../../../includes/classes/AdminPost.class.php"); 
	
	$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_STRING);
	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
	if(!$title)
		$title = 'Untitled';
	//$desc = filter_input(INPUT_GET, 'desc', FILTER_SANITIZE_STRING);
	$desc = $_GET['desc'];
	$tags = filter_input(INPUT_GET, 'photo-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_GET, 'photo-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';
		
	$admin = new AdminPerPost(Auth::getLoggedInID(), $postID);
	$admin->updatePhotoPost($title, $desc, $tags, $status);
	$response['msg'] = "Post updated!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['action'] == 'edit-video-post'){
	require_once(dirname(__FILE__)."/../../../includes/classes/AdminPost.class.php"); 
	
	$postID = filter_input(INPUT_GET, 'postID', FILTER_SANITIZE_STRING);
	$title = filter_input(INPUT_GET, 'title', FILTER_SANITIZE_STRING);
	if(!$title)
		$title = 'Untitled';
	//$desc = filter_input(INPUT_GET, 'desc', FILTER_SANITIZE_STRING);
	$desc = $_GET['desc'];
	$tags = filter_input(INPUT_GET, 'video-tags', FILTER_SANITIZE_STRING);
	$publishOption = filter_input(INPUT_GET, 'video-publish-option', FILTER_SANITIZE_STRING);
	if($publishOption == 'now')
		$status = 'public';
	else if($publishOption == 'save')
		$status = 'draft';
	else if($publishOption == 'private')
		$status = 'private';
		
	$admin = new AdminPerPost(Auth::getLoggedInID(), $postID);
	$admin->updateVideoPost($title, $desc, $tags, $status);
	$response['msg'] = "Post updated!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_POST['action'] == 'update-theme'){
	require_once(dirname(__FILE__)."/../../../includes/dao/UserOptions.dao.php"); 	
	$themeID = filter_input(INPUT_POST, 'theme-id', FILTER_SANITIZE_STRING);
	$options = new UserOptionsDAO(Auth::getLoggedInID());
	$options->changeTheme($themeID);
	$response['msg'] = "Theme Updated!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_POST['action'] == 'update-name'){
	require_once(dirname(__FILE__)."/../../../includes/dao/User.dao.php"); 
	
	$fullname = filter_input(INPUT_POST, 'fullname', FILTER_SANITIZE_STRING);
	$user = new UserDAO(Auth::getLoggedInID());
	if($user->getFullName() != $fullname){
		if($user->changeFullName($fullname)){
			$response['msg'] = "Your Fullname updated!"; 
			$encoded = json_encode($response);
			die($encoded);
		} else {
			$response['errorMsg'] = "An unknown error occurred. Please try again."; 
			$response['errorNum'] = 1;
			$encoded = json_encode($response);
			die($encoded);
		}
	}
}

if($_POST['action'] == 'update-sname'){
	require_once(dirname(__FILE__)."/../../../includes/dao/UserInfo.dao.php"); 
	
	$sname = filter_input(INPUT_POST, 'sname', FILTER_SANITIZE_STRING);
	$user = new UserInfoDAO(Auth::getLoggedInID());
	if($user->getProfileHandler() != $sname){
		$forbiddenSNames = array("test", "prod", "prod1", "prod2", "beta", "stg", "blog", "sprredname", "theofficialsprred", "officialsprred", "photos", "videos", "info", "profile", "api", "support", "developer", "team", "about", "contact", "upload", "help", "faq", "admin", "share", "code", "redanyway", "threepoint", "reach", "aboutus", "www", "htttp", "sperm", "semen", "masturbate", "genital", "genitals", "motherfucker", "sex", "milf", "pussy", "tits");
		if(!SignUp::sprredNameTaken($sname) || in_array($sname, $forbiddenSNames)){
			if($user->changeProfileHandler($sname)){
				if(stristr($user->getProfileURL(), 'sprred.com')){
					$user->changeProfileURL("http://".$sname.".sprred.com");
				}
				$response['msg'] = "Your Sprred name updated!"; 
				$encoded = json_encode($response);
				die($encoded);
			} else {
				$response['errorMsg'] = "An unknown error occurred. Please try again."; 
				$response['errorNum'] = 1;
				$encoded = json_encode($response);
				die($encoded);
			}
		} else {
				$response['errorMsg'] = "This Sprred name is already taken."; 
				$response['errorNum'] = 1;
				$encoded = json_encode($response);
				die($encoded);
		}
	}
}

if($_POST['action'] == 'update-stitle'){
	require_once(dirname(__FILE__)."/../../../includes/dao/UserInfo.dao.php"); 
	
	$stitle = filter_input(INPUT_POST, 'stitle', FILTER_SANITIZE_STRING);
	$user = new UserInfoDAO(Auth::getLoggedInID());
	if($user->getProfileName() != $stitle){
		if($user->changeProfileName($stitle)){
			$response['msg'] = "Your Sprred title updated!"; 
			$encoded = json_encode($response);
			die($encoded);
		} else {
			$response['errorMsg'] = "An unknown error occurred. Please try again."; 
			$response['errorNum'] = 1;
			$encoded = json_encode($response);
			die($encoded);
		}
	}
}

if($_POST['action'] == 'update-email'){
	require_once(dirname(__FILE__)."/../../../includes/dao/User.dao.php"); 
	
	$email = filter_input(INPUT_POST, 'email', FILTER_SANITIZE_STRING);
	$user = new UserDAO(Auth::getLoggedInID());
	if($user->getEmail() != $email){
		if($user->changeEmail($email)){
			$response['msg'] = "Your Email updated!"; 
			$encoded = json_encode($response);
			die($encoded);
		} else {
			$response['errorMsg'] = "An unknown error occurred. Please try again."; 
			$response['errorNum'] = 1;
			$encoded = json_encode($response);
			die($encoded);
		}
	}
}

if($_POST['action'] == 'update-persnl-info'){
	require_once(dirname(__FILE__)."/../../../includes/dao/PersonalInfo.dao.php");
	$info = new PersonalInfoDAO(Auth::getLoggedInID());
	
	$sex = filter_input(INPUT_POST, 'sex', FILTER_SANITIZE_STRING);
	if(array_search($sex, array('male', 'female', 'unspecified', '')) === false){
		$response['errorMsg'] = "Invalid 'Sex' value! ".$sex; 
		$response['errorNum'] = 1;
		$encoded = json_encode($response);
		die($encoded);
	} else if($sex && $sex!='unspecified' && $sex != $info->getSex()){
		$info->setSex($sex);
	}
	
	$birthMonth = filter_input(INPUT_POST, 'birth-month', FILTER_SANITIZE_STRING);
	if($birthMonth != $info->getBirthMonth())
		$info->setBirthMonth($birthMonth);
	$birthDate = filter_input(INPUT_POST, 'birth-date', FILTER_SANITIZE_STRING);
	if($birthDate != $info->getBirthDate())
		$info->setBirthDate($birthDate);	
	$birthYear = filter_input(INPUT_POST, 'birth-year', FILTER_SANITIZE_STRING);
	if($birthYear != $info->getBirthYear())
		$info->setBirthYear($birthYear);
	$hometown = filter_input(INPUT_POST, 'hometown', FILTER_SANITIZE_STRING);
	if($hometown != $info->getHometown())
		$info->setHometown($hometown);
	$aboutMe = filter_input(INPUT_POST, 'aboutme', FILTER_SANITIZE_STRING);
	$aboutMe = strip_tags($aboutMe);
	if($aboutMe != $info->getAboutMe())
		$info->setAboutMe($aboutMe);	
	$hobbies = filter_input(INPUT_POST, 'hobbies', FILTER_SANITIZE_STRING);
	$hobbies = strip_tags($hobbies);
	if($hobbies != $info->getHobbies())
		$info->setHobbies($hobbies);
	$music = filter_input(INPUT_POST, 'music', FILTER_SANITIZE_STRING);
	$music = strip_tags($music);
	if($music != $info->getFavMusic())
		$info->setFavMusic($music);
	$movies = filter_input(INPUT_POST, 'movies', FILTER_SANITIZE_STRING);
	$movies = strip_tags($movies);
	if($movies != $info->getFavMovies())
		$info->setFavMovies($movies);
	$books = filter_input(INPUT_POST, 'books', FILTER_SANITIZE_STRING);
	$books = strip_tags($books);
	if($books != $info->getFavBooks())
		$info->setFavBooks($books);
		
	$response['msg'] = "Personal info updated!"; 
	$encoded = json_encode($response);
	die($encoded);	
}

if($_POST['action'] == 'update-pro-info'){
	require_once(dirname(__FILE__)."/../../../includes/dao/ProfessionalInfo.dao.php");
	$info = new ProfessionalInfoDAO(Auth::getLoggedInID());
	
	$limit = filter_input(INPUT_POST, 'edu-count', FILTER_SANITIZE_STRING);
	for($count=1,$realCount=0;$count<=$limit;$count++){
		$univ = filter_input(INPUT_POST, 'univ-'.$count, FILTER_SANITIZE_STRING);
		$univYear = filter_input(INPUT_POST, 'univ-year-'.$count, FILTER_SANITIZE_STRING);
		$univDegree = filter_input(INPUT_POST, 'degree-'.$count, FILTER_SANITIZE_STRING);
		$univFocus = filter_input(INPUT_POST, 'concentration-'.$count, FILTER_SANITIZE_STRING);
		if($univ != $info->getUniv($count)){
			$info->setUniv($univ, $count);
		}
		if($univYear != $info->getUnivYear($count)){
			$info->setUnivYear($univYear, $count);
		}	
		if($univDegree != $info->getUnivDegree($count)){
			$info->setUnivDegree($univDegree, $count);
		}
		if($univFocus != $info->getUnivFocus($count)){
			$info->setUnivFocus($univFocus, $count);
		}
		if($univ || $univYear || $univDegree || $univFocus) 
			$realCount++;
	}
	if($realCount < 1) $realCount = 1;
	if($info->getEduCount() != $realCount)
		$info->setEduCount($realCount);
		
	$limit = filter_input(INPUT_POST, 'work-count', FILTER_SANITIZE_STRING);
	for($count=1,$realCount=0;$count<=$limit;$count++){
		$employer = filter_input(INPUT_POST, 'employer-'.$count, FILTER_SANITIZE_STRING);
		$workTitle = filter_input(INPUT_POST, 'work-title-'.$count, FILTER_SANITIZE_STRING);
		$workDesc = filter_input(INPUT_POST, 'work-desc-'.$count, FILTER_SANITIZE_STRING);
		$workFromMonth = filter_input(INPUT_POST, 'work-from-month-'.$count, FILTER_SANITIZE_STRING);
		$workFromYear = filter_input(INPUT_POST, 'work-from-year-'.$count, FILTER_SANITIZE_STRING);
		$workTillMonth = filter_input(INPUT_POST, 'work-till-month-'.$count, FILTER_SANITIZE_STRING);
		$workTillYear = filter_input(INPUT_POST, 'work-till-year-'.$count, FILTER_SANITIZE_STRING);
		$workTillPresent = filter_input(INPUT_POST, 'work-till-present-'.$count, FILTER_SANITIZE_STRING);
		if($workTillPresent != 'present' && $workTillPresent)
			$workTillPresent = null;
		if($employer != $info->getEmployer($count)){
			$info->setEmployer($employer, $count);
		}
		if($workTitle != $info->getWorkTitle($count)){
			$info->setWorkTitle($workTitle, $count);
		}	
		if($workDesc != $info->getWorkDesc($count)){
			$info->setWorkDesc($workDesc, $count);
		}
		if($workFromMonth != $info->getWorkFromMonth($count)){
			$info->setWorkFromMonth($workFromMonth, $count);
		}
		if($workFromYear != $info->getWorkFromYear($count)){
			$info->setWorkFromYear($workFromYear, $count);
		}
		if($workTillMonth != $info->getWorkTillMonth($count)){
			$info->setWorkTillMonth($workTillMonth, $count);
		}
		if($workTillYear != $info->getWorkTillYear($count)){
			$info->setWorkTillYear($workTillYear, $count);
		}
		if($workTillPresent != $info->isWorkTillPresent($count)){
			$info->setWorkTillPresent($count);
		}
		if($employer || $workTitle || $workDesc || $workFromMonth || $workFromYear) 
			$realCount++;
	}
	if($realCount < 1) $realCount = 1;
	if($info->getWorkCount() != $realCount)
		$info->setWorkCount($realCount);	
		
	$response['msg'] = "Professional info updated!"; 
	$encoded = json_encode($response);
	die($encoded);	
}

if($_POST['action'] == 'update-fb-options'){
	require_once(dirname(__FILE__)."/../../../includes/dao/Connect.dao.php");
	$connect = new ConnectDAO(Auth::getLoggedInID());
	$autopost = filter_input(INPUT_POST, 'fb-status', FILTER_SANITIZE_STRING);
	$photos_method = filter_input(INPUT_POST, 'fb-photos-method', FILTER_SANITIZE_STRING);
	$videos_method = filter_input(INPUT_POST, 'fb-videos-method', FILTER_SANITIZE_STRING);
	if($autopost == 'enable')
		$connect->setFBAutopost();
	else if($autopost == 'disable')
		$connect->resetFBAutopost();
	
	$connect->changeFBPhotosMethod($photos_method);
	if($videos_method)
		$connect->changeFBVideosMethod($videos_method);
	$response['msg'] = "Facebook autoposting options updated!"; 
	$encoded = json_encode($response);
	die($encoded);	
}

if($_POST['action'] == 'update-tw-options'){
	require_once(dirname(__FILE__)."/../../../includes/dao/Connect.dao.php");
	$connect = new ConnectDAO(Auth::getLoggedInID());
	$autopost = filter_input(INPUT_POST, 'tw-status', FILTER_SANITIZE_STRING);
	if($autopost == 'enable')
		$connect->setTwAutopost();
	else if($autopost == 'disable')
		$connect->resetTwAutopost();
	$response['msg'] = "Twitter autoposting options updated!"; 
	$encoded = json_encode($response);
	die($encoded);
}

if($_GET['action'] == 'unlink-service'){
	require_once(dirname(__FILE__)."/../../../includes/dao/Connect.dao.php");
	$connect = new ConnectDAO(Auth::getLoggedInID());
	if($_GET['service'] == 'facebook')
		$connect->unlinkFacebook();
	else if($_GET['service'] == 'twitter')
		$connect->unlinkTwitter();
	$response['msg'] = "Unlinked!"; 
	$encoded = json_encode($response);
	die($encoded);
}

?>
