<?php

require_once(dirname(__FILE__)."/../lib/fbconnect/facebook.php");
require_once(dirname(__FILE__)."/../lib/twitter/tw-connect-oauth.lib.php");
require_once(dirname(__FILE__)."/../lib/encode.lib.php");
require_once(dirname(__FILE__)."/../dao/UserInfo.dao.php");
require_once(dirname(__FILE__)."/../dao/Connect.dao.php");

class Autopost {
	
	private $userID = null;
	
	function Autopost($userID){
		$this->userID = $userID;
	}
	
	function post($postTitle, $postLink, $postDesc=null, $picURL=null, $photoPath=null, $videoPath=null){
		$connect = new ConnectDAO($this->userID);
		$userInfo = new UserInfoDAO($this->userID);
		$postURL = $userInfo->getProfileURL().$postLink;
		if($connect->isTwAutopost() && $connect->getTWAccessTkn() && $connect->getTWTknScrt()){
			$twConnect = new TwConnectOAuth($connect->getTWAccessTkn(), $connect->getTWTknScrt());
			$shortURL = Encode::short($postURL);
			$twConnect->updateStatus($postTitle.' - '.$shortURL);
		}
		if($connect->isFBAutopost() && $connect->getFBSessionKey() && $connect->getFBID()){
			$facebook = new Facebook(array('cookie' => false));
			if($postDesc)
				$desc = $postDesc;
			else
				$desc = 'Check out the new post on Sprred.';
			if($photoPath && $connect->getFBPhotosMethod() == 'album'){
				$facebook->setFileUploadSupport(true);
				$attachment =  array(
					'access_token' => $connect->getFBSessionKey(),
					'message' => $postTitle,
					'description' => $desc
				);
				$attachment['image'] = '@' . realpath($photoPath);
				$ret_code=$facebook->api('/'. $connect->getFBID() .'/photos', 'POST', $attachment);
			} else {
				if($picURL)
					$picture_url = $picURL;
				else
					$picture_url = "http://www.sprred.com/images/sprred-graphic-sq.png";
				$attachment =  array(
					'access_token' => $connect->getFBSessionKey(),
					'name' => $postTitle,
					'link' => $postURL,
					'description' => $desc,
					'picture'=> $picture_url
				);			
				$ret_code=$facebook->api('/'. $connect->getFBID() .'/feed', 'POST', $attachment);
			}
		}
	}
}