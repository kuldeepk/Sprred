<?php

require_once dirname(__FILE__)."/../../conf/config.inc.php";
require_once dirname(__FILE__)."/../lib/tarzan/tarzan.class.php";

class PostsDB
{
	public static function addPost($userID, $postID, $postLink, $s3name, $type, $title, $pubtime, $pubtime_gmt, $desc, $content, $slug, $tags, $status, $comment_status, $postSize, $set) {	
		$sdb = new AmazonSDB();
		$time = time();
		if($pubtime==null)$pubtime=$time;
		if($pubtime_gmt==null)$pubtime_gmt=$time;
		$put = $sdb->put_attributes(DB_REGION.'Posts', $postID, array(
			'userID' => $userID, 
			'postLink' => $postLink, 
			's3name' => $s3name, 
			'type' => $type, 
			'title' => $title,
			'pubtime' => $pubtime, 
			'pubtime_gmt' => $pubtime_gmt, 
			'desc' => $desc, 
			'content' => $content, 
			'slug' => $slug, 
			'tags' => $tags, 
			'status' => $status, 
			'comment_status' => $comment_status, 
			'postSize' => $postSize,
			'set' => $set,
			'modified' => $time,
			'modified_gmt' => $time,			
			),array('userID','postLink','s3name','type','title','pubtime','pubtime_gmt','desc','content','slug','tags','status','comment_status','postSize','modified','modified_gmt')
		);
	
		if($put->body->ResponseMetadata){
					return 1;	
				}
	
		elseif(!$put->body->ResponseMetadata)
			return 0;
		
	}
	
	public static function updateWholePost($postID, $s3name, $title, $desc, $s3URL, $tags, $status, $postSize, $set=null, $pubtime=null, $pubtime_gmt=null, $comment_status=null) {
		$sdb = new AmazonSDB();
		$time = time();
		$put = $sdb->put_attributes(DB_REGION.'Posts', $postID, array(
			's3name' => $s3name, 
			'title' => $title,
			'pubtime' => $pubtime, 
			'pubtime_gmt' => $pubtime_gmt, 
			'desc' => $desc, 
			'content' => $s3URL, 
			'tags' => $tags, 
			'status' => $status, 
			'comment_status' => $comment_status, 
			'postSize' => $postSize,
			'set' => $set,
			'modified' => $time,
			'modified_gmt' => $time,			
			),array('s3name','title','pubtime','pubtime_gmt','desc','content','tags','status','comment_status','postSize','modified','modified_gmt')
		);	
		if($put->body->ResponseMetadata){
			return 1;	
		}	
		elseif(!$put->body->ResponseMetadata)
			return 0;		
	}
	
	public static function updatePostShort($postID, $title, $desc, $tags, $status, $set, $pubtime, $pubtime_gmt, $comment_status){
		$sdb = new AmazonSDB();
		$time = time();
		$put = $sdb->put_attributes(DB_REGION.'Posts', $postID, array(
			'title' => $title,
			'pubtime' => $pubtime, 
			'pubtime_gmt' => $pubtime_gmt, 
			'desc' => $desc, 
			'tags' => $tags, 
			'status' => $status, 
			'comment_status' => $comment_status, 
			'set' => $set,
			'modified' => $time,
			'modified_gmt' => $time,			
			),array('title','pubtime','pubtime_gmt','desc','tags','status','comment_status','modified','modified_gmt')
		);	
		if($put->body->ResponseMetadata){
			return 1;	
		}	
		elseif(!$put->body->ResponseMetadata)
			return 0;		
	}

	public static function updatePost($data, $type, $postID) {
		$sdb = new AmazonSDB();
		$time = time();
		$put = $sdb->put_attributes(DB_REGION.'Posts', $postID, array(
			(string) $type => $data, 
			'modified' => $time,
			'modified_gmt' => $time			
			),array((string) $type)
		);	
		if($put->body->ResponseMetadata){
			return 1;
		}	
		elseif(!$put->body->ResponseMetadata)
			return 0;	
	}

	public static function getMultiPosts($userID, $limit=NULL, $offset=0, $fromTime=NULL, $type=NULL, $status=NULL, $set=null){
		$sdb = new AmazonSDB();
		$query = "select * from ".DB_REGION."Posts where pubtime != 'null' and userID = '".$userID."'";
		if($fromTime)
			$query = $query." and pubtime >='".$fromTime."'"; 
		if($type)	
			$query = $query." and type IN ".$type;
		if($status)	
			$query = $query." and status IN ".$status;	
		if($set)
			$query = $query." and set IN '".$set;
		$query = $query." order by pubtime desc";
		$select = $sdb->select($query);
		
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		} else{
			$cnt = 0;
			foreach($select->body->SelectResult->Item as $item)
			{
				$posts[$cnt]['postID'] = (string) $item->Name;
				foreach($item->Attribute as $attribute)
				{   
					$posts[$cnt][ (string) $attribute->Name ] = (string)$attribute->Value;
				}
				$cnt++;
			}
		}
		return $posts;
	}
	
	public static function getAllPosts($limit=NULL, $offset=0, $type=NULL, $status=NULL, $set=null){
		$sdb = new AmazonSDB();
		$query = "select * from ".DB_REGION."Posts where pubtime != 'null'";
		if($fromTime)
			$query = $query." and pubtime >='".$fromTime."'"; 
		if($type)	
			$query = $query." and type IN ".$type;
		if($status)	
			$query = $query." and status IN ".$status;	
		if($set)
			$query = $query." and set IN '".$set;
		$query = $query." order by pubtime desc";
		$select = $sdb->select($query);
		
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		} else{
			$cnt = 0;
			foreach($select->body->SelectResult->Item as $item)
			{
				$posts[$cnt]['postID'] = (string) $item->Name;
				foreach($item->Attribute as $attribute)
				{   
					$posts[$cnt][ (string) $attribute->Name ] = (string)$attribute->Value;
				}
				$cnt++;
			}
		}
		return $posts;
	}
	
	public static function getPost($postID){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ".DB_REGION."Posts where itemName()='".$postID."'");
	
		$links['postID'] = (string) $select->body->SelectResult->Item[0]->Name[0];
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$links[ (string) $field->Name ] = (string)$field->Value;
		}
	
		return $links;
	}
	
	public static function getPostsCount($userID, $type, $status, $set){
		$sdb = new AmazonSDB();
		if($userID)
			$query = "select count(*) from ".DB_REGION."Posts where pubtime != 'null' and userID = '".$userID."'";
		else
			$query = "select count(*) from ".DB_REGION."Posts where pubtime != 'null'";
		if($type)	
			$query = $query." and type IN ".$type;
		if($status)	
			$query = $query." and status IN ".$status;	
		if($set)
			$query = $query." and set IN '".$set;
		$query = $query." ";
		$select = $sdb->select($query);

		return $select->body->SelectResult->Item[0]->Attribute->Value;
	}
	
	public static function getSinglePost($userID, $timestamp, $slug){
		$sdb = new AmazonSDB();
		$select = $sdb->select("select * from ".DB_REGION."Posts where userID='".$userID."' and pubtime_gmt='".$timestamp."' and slug='".$slug."'");
			
		$links['postID'] = (string) $select->body->SelectResult->Item[0]->Name[0];
		foreach($select->body->SelectResult->Item[0]->Attribute as $field){
			$links[ (string) $field->Name ] = (string)$field->Value;
		}
	
		return $links;
	}
	
	
	public static function delPost($postID) {
		$sdb = new AmazonSDB();		
		$delete = $sdb->delete_attributes(DB_REGION.'Posts', $postID);	
		return 1;
	
	}
	
	public static function getLatestPosts($userID, $timestamp, $num, $type, $status, $set) {
		$sdb = new AmazonSDB();
		$query = "select * from ".DB_REGION."Posts where pubtime != 'null' and userID = '".$userID."' and pubtime > '".$timestamp."'";
		if($type)	
			$query = $query." and type IN ".$type;
		if($status)	
			$query = $query." and status IN ".$status;	
		if($set)
			$query = $query." and set IN ".$set;
		$query = $query." order by pubtime asc limit ".$num;
		$select = $sdb->select($query);
		
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		} else{
			$cnt = 0;
			foreach($select->body->SelectResult->Item as $item)
			{
				$posts[$cnt]['postID'] = (string) $item->Name;
				foreach($item->Attribute as $attribute)
				{   
					$posts[$cnt][ (string) $attribute->Name ] = (string)$attribute->Value;
				}
				$cnt++;
			}
		}
		$posts = array_reverse($posts);
		return $posts;
	}
	
	public static function getOlderPosts($userID, $timestamp, $num, $type, $status, $set) {
		$sdb = new AmazonSDB();
		$query = "select * from ".DB_REGION."Posts where pubtime != 'null' and userID = '".$userID."' and pubtime < '".$timestamp."'";
		if($type)	
			$query = $query." and type IN ".$type;
		if($status)	
			$query = $query." and status IN ".$status;	
		if($set)
			$query = $query." and set IN ".$set;
		$query = $query." order by pubtime desc limit ".$num;
		$select = $sdb->select($query);
		
		if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item[0]->Attribute[0]){
			return null;
		} else{
			$cnt = 0;
			foreach($select->body->SelectResult->Item as $item)
			{
				$posts[$cnt]['postID'] = (string) $item->Name;
				foreach($item->Attribute as $attribute)
				{   
					$posts[$cnt][ (string) $attribute->Name ] = (string)$attribute->Value;
				}
				$cnt++;
			}
		}
		return $posts;
	}

}
?>