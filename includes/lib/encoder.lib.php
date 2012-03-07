<?php
/* Include Files *********************/
require_once(dirname(__FILE__)."/../../conf/config.inc.php");
require_once(dirname(__FILE__)."/zencoder/Zencoder.php"); 
/*************************************/

class Encoder {
	public static function encode($s3name, $outputname, $prefix, $title, $public=1){
		$request = '
		  {
				';
		if(TEST_ENCODING) 
			$request .= '"test": '.TEST_ENCODING.',';
		$request .= '"input": "http://'.S3BUCKET.'.s3.amazonaws.com/'.$s3name.'",
				 "output":[{
				      "base_url": "http://'.S3BUCKET.'.s3.amazonaws.com/'.$prefix.'",
				      "filename": "'.$outputname.'.mp4",
				      "width":640,
				      "height":480,
				      "upscale":1,
				      "thumbnails":{
				        "number": 1,
				        "base_url": "http://'.S3BUCKET.'.s3.amazonaws.com/'.$prefix.'",
				        "prefix": "'.$outputname.'"
				      },
				      "public": '.$public.'
				   }
				 ],
				 "api_key": "'.ZENCODER_API_KEY.'"
		  }
		';
		$encoding_job = new ZencoderJob($request);
		if ($encoding_job->created) {
			return 'http://'.S3BUCKET.'.s3.amazonaws.com/'.$prefix.$outputname.'.mp4';
		}
	}
}

?>
