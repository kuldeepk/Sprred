<?php
 
require_once(dirname(__FILE__).'/../lib/encode.lib.php');
require_once(dirname(__FILE__).'/../lib/utility.lib.php');
require_once(dirname(__FILE__).'/../lib/image.lib.php');
require_once(dirname(__FILE__).'/../lib/encoder.lib.php');
require_once(dirname(__FILE__).'/../dao/S3.dao.php');
require_once(dirname(__FILE__).'/../dao/Space.dao.php');
require_once(dirname(__FILE__).'/../dao/Posts.dao.php');
require_once(dirname(__FILE__).'/../dao/Feeds.dao.php');
require_once(dirname(__FILE__).'/../dao/UserInfo.dao.php');
require_once(dirname(__FILE__).'/Autopost.class.php');

class UploadPost
{
	
	function UploadPost($user_id) {
		$this->userID = $user_id;
	}

	function createInlinePost($desc=null, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='public', $comment_status=true){
		$type = 'inline';
		$slug = null;
		
		$UserInfoDAO = new UserInfoDAO($this->userID);
		if(!$UserInfoDAO -> isSprred())
			return 0;
			
		$RAprofileID = $UserInfoDAO -> getProfileID();
			
		if($desc){
			$slug = Utility::makeslug($desc);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		
		$postLink = $UserInfoDAO -> getProfileURL()."/".$this->$type."/".$pubtime_gmt."/".$slug;
		$postID = $this->userID.$type.$slug.$pubtime_gmt;
		$PostsDAO = new PostsDAO($this->userID, $postID);
	
		$RApostID = $RAprofile_ID.$type.$postLink;
	
		if( $PostsDAO -> addPost($postLink, $s3name=null, $RAprofile_ID, $type, $title=null, $pubtime, $pubtime_gmt, $desc, $content=null, $slug, $tags, $status, $comment_status, $postSize=null, $set=null)){			
			$thumbnail = NULL;
			//$FeedsDAO = new FeedsDAO($this->userID, $RApostID);
			//$FeedsDAO -> addFeed($postLink, $RAprofile_ID, $type, $title, $pubtime, $desc=null, $content=null, $thumbnail, $slug, $tags);				
		}
			
	}
	
	function createBlogPost($title=null, $content=null, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='public', $comment_status=true){
		$type = 'blog';
		$slug = null;
		
		$UserInfoDAO = new UserInfoDAO($this->userID);
			
		if($title){
			$slug = Utility::makeslug($title);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		
		$postLink = "/post/".$pubtime_gmt."/".$slug;
		
		if($content){
			$desc = Utility::shortenText(strip_tags($content), 180);
			$s3name = $this->userID."/blog/".$slug."-".$pubtime_gmt.".txt";
			$S3DAO = new S3DAO($s3name, S3BUCKET);
			if( $S3DAO -> uploadFile($content, "text/html")){ 				
				$postSize = $S3DAO -> getFileSize();
				$SpaceDAO = new SpaceDAO($this->userID);
				if(!$SpaceDAO->isSpaceAvailOfType($postSize, $type)){
					$S3DAO -> deleteFile();
					return false;
				} else
					$SpaceDAO -> useSpace($postSize, $type);
				$s3URL = $S3DAO -> getFileURL();
				$postID = $this->userID.$type.$slug.$pubtime_gmt;
				$PostsDAO = new PostsDAO($this->userID, $postID);
	
				if( $PostsDAO -> addPost($postLink, $s3name, $type, $title, $pubtime, $pubtime_gmt, $desc, $s3URL, $slug, $tags, $status, $comment_status, $postSize, $set=null)){
					$autopost = new Autopost($this->userID);
					if($status=='public')
						$autopost->post($title, $postLink, $desc);
					$result['status'] = true;
					$result['link'] = $postLink;
					return $result;
				} else
					return false;
			}
		}	
	}
	
	function createLinkPost($title, $url, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='public', $comment_status=true){
		$type = 'link';
		$slug = null;
		
		if($title){
			$slug = Utility::makeslug($title);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		$UserInfoDAO = new UserInfoDAO($this->userID);
		$postLink = "/".$type."/".$pubtime_gmt."/".$slug;
		
		$postID = $this->userID.$type.$slug.$pubtime_gmt;
		$PostsDAO = new PostsDAO($this->userID, $postID);

		if( $PostsDAO -> addPost($postLink, null, $type, $title, $pubtime, $pubtime_gmt, null, $url, $slug, $tags, $status, $comment_status, 0, $set=null)){
			$result['status'] = true;
			$result['link'] = $postLink;
			return $result;
		} else
			return false;
	}
	
	function createPhotoPost($title=null, $content=null, $desc=null, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='public', $comment_status=true, $set=null){
		$type = 'photo';
		$slug = null;
		
		$UserInfoDAO = new UserInfoDAO($this->userID);
			
		if($title){
			$slug = Utility::makeslug($title);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		
		$postLink = "/".$type."/".$pubtime_gmt."/".$slug;		
		
		if($content){
			$desc = Utility::shortenText(strip_tags($desc), 800);
			
			$newImage = CACHE_PATH."/".$this->userID."-".$slug."-".$pubtime_gmt.'.jpg';
			Image::convertImage($content, $newImage, 2, true);			
			$s3name = $this->userID."/photos/".$slug."-".$pubtime_gmt.'.jpg';
			$S3DAO = new S3DAO($s3name, S3BUCKET);
			$upload = $S3DAO -> uploadFile(file_get_contents($newImage), "image/jpeg");
			if($upload){
				$postSize = $S3DAO -> getFileSize();				
				$SpaceDAO = new SpaceDAO($this->userID);				
				if(!$SpaceDAO -> isSpaceAvailOfType($postSize, $type)){
					$S3DAO -> deleteFile();
					return false;
				} else
					$SpaceDAO -> useSpace($postSize, $type);
			
				$s3URL = $S3DAO -> getFileURL();
				$postID = $this->userID.$type.$slug.$pubtime_gmt;
				$PostsDAO = new PostsDAO($this->userID, $postID);	
	
				if( $PostsDAO -> addPost($postLink, $s3name, $type, $title, $pubtime, $pubtime_gmt, $desc, $s3URL, $slug, $tags, $status, $comment_status, $postSize, $set)){
					$autopost = new Autopost($this->userID);
					if($status=='public')
						$autopost->post($title, $postLink, $desc, $s3URL, $newImage);
					if(file_exists($newImage))
						unlink($newImage);		
					$result['status'] = true;
					$result['link'] = $postLink;
					return $result;
				} else
					return false;
			} else
				return false;
		} else
			return false;
	}
	
	function createVideoPost($title=null, $file_ext=null, $content=null, $desc=null, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='public', $comment_status=true, $set=null){
		$type = 'video';
		$slug = null;		

		$UserInfoDAO = new UserInfoDAO($this->userID);
		if($title){
			$slug = Utility::makeslug($title);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		
		$postLink = "/".$type."/".$pubtime_gmt."/".$slug;
		
		if($content){
			$desc = Utility::shortenText(strip_tags($desc), 800);
			$s3name = $this->userID."/videos/".$slug."-".$pubtime_gmt.".".$file_ext;
			$filename = $slug."-".$pubtime_gmt;
			$S3DAO = new S3DAO($s3name, S3BUCKET);
			$upload = $S3DAO -> uploadFile(file_get_contents($content), "");				
			if($upload){
				$postSize = $S3DAO -> getFileSize();			
				$SpaceDAO = new SpaceDAO($this->userID);				
				if(!$SpaceDAO -> isSpaceAvailOfType($postSize, $type)){
					$S3DAO -> deleteFile();	
					return false;			
				} else
					$SpaceDAO -> useSpace($postSize, $type);			
				$s3URL = Encoder::encode($s3name, $filename, $this->userID."/videos/", $title);
				
				$postID = $this->userID.$type.$slug.$pubtime_gmt;
				$PostsDAO = new PostsDAO($this->userID, $postID);
				if( $PostsDAO -> addPost($postLink, $s3name, $type, $title, $pubtime, $pubtime_gmt, $desc, $s3URL, $slug, $tags, $status, $comment_status, $postSize, $set)){
					$autopost = new Autopost($this->userID);
					if($status=='public')
						$autopost->post($title, $postLink, $desc, substr($s3URL, 0, -4)."_0000.png", null, $content);
					if(file_exists($content))
						unlink($content);
					$result['status'] = true;
					$result['link'] = $postLink;
					return $result;
				} else
					return false;				
			}
		}
	}
	
	function createFilePost($title=null, $content=null, $desc=null, $tags=null, $pubtime=null, $pubtime_gmt=null, $status='private', $comment_status=true, $local=1){
		$type = 'file';
		$slug = null;
		
		$UserInfoDAO = new UserInfoDAO($this->userID);
			
		if($title){
			$slug = Utility::makeslug($title);
		}
		if($slug == null){
			$slug = rand(1000000000, 9999999999);
			$slug = Encode::base64_url_encode($slug);
		}
		
		$postLink = "/".$type."/".$pubtime."/".$slug;		
		
		if($content){
			if(function_exists(finfo_open)){
				$finfo = finfo_open(FILEINFO_MIME_TYPE);
				$mime_type = finfo_file($finfo, $content);
				finfo_close($finfo);
			} else
				$mime_type = mime_content_type($content);
			$path_parts = pathinfo($content);			
			$ext = $path_parts['extension'];
			$desc = Utility::shortenText(strip_tags($desc), 800);
			$s3name = $this->userID."/files/".$slug."-".$pubtime_gmt.".".$ext;	
			$S3DAO = new S3DAO($s3name, S3BUCKET);
			if($local == 1)
				$upload = $S3DAO -> uploadFile(file_get_contents($content), $mime_type);
			else 
				$upload = $S3DAO -> uploadFileFromURL($content);
				
			if($upload){   // $content = file_get_contents($content) in case of photo/video where $local=1				
				$postSize = $S3DAO -> getFileSize();				
				$SpaceDAO = new SpaceDAO($this->userID);				
				if(!$SpaceDAO -> isSpaceAvailOfType($postSize, $type))
					$S3DAO -> deleteFile();				
				else
					$SpaceDAO -> useSpace($postSize, $type);
			
				//------- put post in SDB
				$s3URL = $S3DAO -> getFileURL();
				$postID = $this->userID.$type.$slug.$pubtime_gmt;
				$PostsDAO = new PostsDAO($this->userID, $postID);	
	
				if( $PostsDAO -> addPost($postLink, $s3name, $type, $title, $pubtime, $pubtime_gmt, $desc, $s3URL, $slug, $tags, $status, $comment_status, $postSize, $set)){			
					//------ RA connect
					$thumbnail = $s3URL;
					//$FeedsDAO = new FeedsDAO($this->userID, $RApostID);
					//$FeedsDAO -> addFeed($postLink, $RAprofile_ID, $type, $title, $pubtime, $desc, $content=null, $thumbnail, $slug, $tags);				
				}
			}
		}
	}
	

}

?>