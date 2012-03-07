<?php
/* Include Files *********************/
require_once(dirname(__FILE__).'/../../conf/config.inc.php');
require_once(dirname(__FILE__)."/../../includes/classes/Auth.class.php");
require_once(dirname(__FILE__)."/../../includes/classes/PostInfo.class.php"); 
/*************************************/

set_time_limit(120);

$s3name = filter_input(INPUT_GET, 'id', FILTER_SANITIZE_STRING);
$imageURL = urldecode(filter_input(INPUT_GET, 'url', FILTER_SANITIZE_URL));
$size = filter_input(INPUT_GET, 'size', FILTER_SANITIZE_STRING);

if($s3name){
	$content = PostInfo::getPostContentFromName($s3name);
	$img = @imagecreatefromstring($content);
} else if($imageURL) {
	list($w_src, $h_src, $type) = getimagesize($imageURL);
	switch ($type){
		case 1:   //   gif -> jpg
	        $img = imagecreatefromgif($imageURL);
	        break;
	      case 2:   //   jpeg -> jpg
	        $img = imagecreatefromjpeg($imageURL);
	        break;
	      case 3:  //   png -> jpg
	        $img = imagecreatefrompng($imageURL);
	        break;
     }
} else {
	exit(0);
}
if($size == 'xs')
	$target_size = 120;
if($size == 's')
	$target_size = 300;
if($size == 'm')
	$target_size = 500;
if($size == 'n')
	$target_size = 640;

$width = imageSX($img);
$height = imageSY($img);
if (!$width || !$height) {
	header("HTTP/1.1 500 Internal Server Error");
	echo "Invalid width or height";
	exit(0);
}

if($width > $height)
	$target_width = $target_size;
else
	$target_height = $target_size;

$img_ratio = $width / $height;
if($max_width && $max_height){
	$target_ratio = $img_ratio;
	$target_width = $max_width;
	$target_height = $target_width / $target_ratio;
	if($target_height > $max_height)
		$target_height = $max_height;
	$target_ratio = $target_width / $target_height;
} else {
	if(!$target_width){
		$target_ratio = $img_ratio;
		$target_width = $target_ratio * $target_height;
	} else if(!$target_height){
		$target_ratio = $img_ratio;
		$target_height = $target_width / $target_ratio;		
	} else
		$target_ratio = $target_width / $target_height;
}
	
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

$new_img = ImageCreateTrueColor($target_width, $target_height);
if(!@imagecopyresampled($new_img, $img, 0, 0, ($width-$new_width)/2, ($height-$new_height)/2, $target_width, $target_height, $new_width, $new_height)) {
	header("HTTP/1.0 500 Internal Server Error");
	echo "Could not resize image";
	exit(0);
}

header("Content-Type: image/jpeg\n");
header("Content-Transfer-Encoding: binary");

imagejpeg($new_img);
imagedestroy($new_img);

?>
