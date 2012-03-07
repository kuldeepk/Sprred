<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class S3DB
{
	public static function uploadFile($filename, $bucket, $type, $content){

		$s3 = new AmazonS3();

		$file = $s3->create_object($bucket, array(
    		'filename' => $filename,
		 		'body' => $content,
		 		'contentType' => $type,
		    'acl' => S3_ACL_PUBLIC
		));
		if ($file->isOK())
			return 1;
		else
			return 0;
	}

	public static function uploadFileFromURL($remoteFile, $filename, $bucket){

		$s3 = new AmazonS3();

		$fileURL = $s3->store_remote_file($remoteFile, $bucket, $filename, array(
	    'acl' => S3_ACL_PUBLIC
		));
		
		return $fileURL;

	}

	public static function deleteFile($filename, $bucket){
		$s3 = new AmazonS3();
		$delete = $s3->delete_object($bucket, $filename);
		if ($delete->isOK())
		    return 1;
		else
		    return 0;
	}

	public static function getFileSize($filename, $bucket){
		$s3 = new AmazonS3();
		return $s3->get_object_filesize($bucket, $filename);
	}

	public static function getFileURL($filename, $bucket){
		$s3 = new AmazonS3();
		return $s3->get_object_url($bucket, $filename);
	}

	public static function getFileContent($filename, $bucket){
		$s3 = new AmazonS3();
		$response = $s3->get_object($bucket, $filename);
		return $response;
	}
}

?>
