<?php

require_once(dirname(__FILE__).'/../db/S3.db.php');

class S3DAO
{
	function S3DAO($filename, $bucket) {
		$this->filename = $filename;
		$this->bucket = $bucket;	
	}
		
	function uploadFile($content, $type){
		
		return S3DB::uploadFile($this->filename, $this->bucket, $type, $content);
	}

	function uploadFileFromURL($remoteFile){

		return S3DB::uploadFileFromURL($remoteFile, $this->filename, $this->bucket);
		
	}
	function deleteFile(){

		return S3DB::deleteFile($this->filename, $this->bucket);

	}

	function getFileSize(){

		return S3DB::getFileSize($this->filename, $this->bucket);

	}

	function getFileURL(){

		return S3DB::getFileURL($this->filename, $this->bucket);

	}

	
}

?>
