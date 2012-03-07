<?php

class Image {

	public static function resizeImage($image,$width,$height,$scale,$file_ext) {
		$newImageWidth = ceil($width * $scale);  
		$newImageHeight = ceil($height * $scale);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		if($file_ext == "jpg"){
			$source = imagecreatefromjpeg($image);
		}
		else if($file_ext == "gif"){
			$source = imagecreatefromgif($image);
		}
		else if($file_ext == "png"){
			$source = imagecreatefrompng($image);
		}
	
		imagecopyresampled($newImage,$source,0,0,0,0,$newImageWidth,$newImageHeight,$width,$height);
		imagejpeg($newImage,$image,100);
		chmod($image, 0777);
		return $image;
	}
	
	public static function resizeImageSimple($image_url, $size){
		list($width, $height, $image_type) = getimagesize($image_url);
	    switch ($image_type)
	    {
	        case 1: $img = imagecreatefromgif($image_url); break;
	        case 2: $img = imagecreatefromjpeg($image_url);  break;
	        case 3: $img = imagecreatefrompng($image_url); break;
	        default: return false;  break;
	    }
		$target_ratio = 1;
		$img_ratio = $width / $height;
		if ($target_ratio < $img_ratio) {
			$new_height = $height;
			$new_width = $img_ratio * $height;
		} else {
			$new_height = $width / $target_ratio;
			$new_width = $width;
		}
	
		if ($new_height > $height) {
			$new_height = $height;
		}
		if ($new_width > $width) {
			$new_height = $width;
		}
	
		$new_img = imagecreatetruecolor($size, $size);
		if(($image_type == 1) OR ($image_type==3)){
	        imagealphablending($new_img, false);
	        imagesavealpha($new_img,true);
	        $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
	        imagefilledrectangle($new_img, 0, 0, $size, $size, $transparent);
	    }	
		if (!@imagecopyresampled($new_img, $img, 0, 0, ($width-$new_width)/2, ($height-$new_height)/2, $size, $size, $new_width, $new_height)) {
			return false;
		}
		$result['img'] = $new_img;
		$result['type'] = $image_type; 
		return $result;
	}
	
	public static function mediumImage($src_path, $dest_path, $max_size, $type=2){
		$max_width = $max_size;
		$max_height = $max_size;
		
		list($width, $height, $image_type) = getimagesize($src_path);
	    switch ($image_type)
	    {
	        case 1: $img = imagecreatefromgif($src_path); break;
	        case 2: $img = imagecreatefromjpeg($src_path);  break;
	        case 3: $img = imagecreatefrompng($src_path); break;
	        default: return false;  break;
	    }
		
		$img_ratio = $width / $height;
		$target_ratio = $img_ratio;
		if($width > $height){
			$target_width = $max_width;
			$target_height = $target_width / $target_ratio;
		} else {
			$target_height = $max_height;
			$target_width = $target_height * $target_ratio;
		}
		$new_height = $width / $target_ratio;
		$new_width = $width;	
		if ($new_height > $height) {
			$new_height = $height;
		}
		if ($new_width > $width) {
			$new_height = $width;
		}
	
		$new_img = imagecreatetruecolor($target_width, $target_height);
		if(($image_type == 1) OR ($image_type==3)){
	        imagealphablending($new_img, false);
	        imagesavealpha($new_img,true);
	        $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
	        imagefilledrectangle($new_img, 0, 0, $target_width, $target_height, $transparent);
	    }	
		if (!@imagecopyresampled($new_img, $img, 0, 0, ($width-$new_width)/2, ($height-$new_height)/2, $target_width, $target_height, $new_width, $new_height)) {
			return false;
		}
		Image::copyImage($new_img, $dest_path, $type);
		imagedestroy($new_img);
		imagedestroy($img);
		return true;
	}
	
	public static function thumbnailImage($src_path, $dest_path, $size, $type=2){
		list($width, $height, $image_type) = getimagesize($src_path);
	    switch ($image_type)
	    {
	        case 1: $img = imagecreatefromgif($src_path); break;
	        case 2: $img = imagecreatefromjpeg($src_path);  break;
	        case 3: $img = imagecreatefrompng($src_path); break;
	        default: return false;  break;
	    }
		$target_ratio = 1;
		$img_ratio = $width / $height;
		if ($target_ratio > $img_ratio) {
	       $new_height = $width;
	       $new_width = $width;
	    } else {
	       $new_width = $height;
	       $new_height = $height;
	    }
	   
	    $x_mid = $new_width/2;  //horizontal middle
	    $y_mid = $new_height/2; //vertical middle
	
		$new_img = imagecreatetruecolor($size, $size);
		if(($image_type == 1) OR ($image_type==3)){
	        imagealphablending($new_img, false);
	        imagesavealpha($new_img,true);
	        $transparent = imagecolorallocatealpha($new_img, 255, 255, 255, 127);
	        imagefilledrectangle($new_img, 0, 0, $size, $size, $transparent);
	    }
		if (!@imagecopyresampled($new_img, $img, 0, 0, ($x_mid-($new_width/2)), ($y_mid-($new_height/2)), $size, $size, $new_width, $new_height)) {
			return false;
		}
		Image::copyImage($new_img, $dest_path, $type);
		imagedestroy($new_img);
		imagedestroy($img);
		return true;
	}
	
	public static function convertImage($src_path, $dest_path, $type=2, $interlacing = false){
		list($width, $height, $image_type) = getimagesize($src_path);		
	    switch ($image_type)
	    {
	        case 1: $img = imagecreatefromgif($src_path); break;
	        case 2: $img = imagecreatefromjpeg($src_path);  break;
	        case 3: $img = imagecreatefrompng($src_path); break;
	        default: return false;  break;
	    }
		Image::copyImage($img, $dest_path, $type, $interlacing);
		imagedestroy($img);
		return true;
	}
	
	public static function getImageFromURL($imgURL){
		list($width, $height, $image_type) = getimagesize($imgURL);
	    switch ($image_type)
	    {
	        case 1: $img = imagecreatefromgif($imgURL); break;
	        case 2: $img = imagecreatefromjpeg($imgURL);  break;
	        case 3: $img = imagecreatefrompng($imgURL); break;
	        default: return false;  break;
	    }
		$result['img'] = $img;
		$result['type'] = $image_type; 
		return $result;
	}
	
	public static function drawImage($img, $type){
		switch ($type)
	    {
	        case 1: header("Content-Type: image/gif\n");
				header("Content-Transfer-Encoding: binary");
				imagegif($img);
				return;
				break;
	        case 2: header("Content-Type: image/jpeg\n");
				header("Content-Transfer-Encoding: binary");
				imagejpeg($img);
				return;
				break;
	        case 3: header("Content-Type: image/png\n");
				header("Content-Transfer-Encoding: binary");
				imagepng($img);
				return;
				break;
	        default: return false;  break;
	    }
	}
	
	public static function copyImage($src_img, $dest_path, $type, $interlacing=false){
		if($interlacing)
			imageinterlace($src_img, true);
		switch ($type)
	    {
	        case 1:
				imagegif($src_img, $dest_path);
				return true;
				break;
	        case 2:
				imagejpeg($src_img, $dest_path, 100);
				return true;
				break;
	        case 3:
				imagepng($src_img, $dest_path);
				return true;
				break;
	        default: return false;  break;
	    }
	}
	
	public static function resizeThumbnailImage($thumb_image_name, $image, $width, $height, $start_width, $start_height, $scale){
		$newImageWidth = ceil($width);
		$newImageHeight = ceil($height);
		$newImage = imagecreatetruecolor($newImageWidth,$newImageHeight);
		$source = imagecreatefromjpeg($image);
		imagecopyresampled($newImage,$source,0,0,$start_width,$start_height,$width,$height,$width,$height);
		imagejpeg($newImage,$thumb_image_name,100);
		chmod($thumb_image_name, 0777);
		return $thumb_image_name;
	}
	
	public static function getHeight($image) {
		$sizes = getimagesize($image);
		$height = $sizes[1];
		return $height;
	}
	
	public static function getWidth($image) {
		$sizes = getimagesize($image);
		$width = $sizes[0];
		return $width;
	}
}

?>
