<?php
require_once(dirname(__FILE__).'/tarzan.class.php');
require_once(dirname(__FILE__).'/explore.php');
//require_once('relation.php');


function addFav($postID, $userID, $tags = null)
{
	$sdb = new AmazonSDB();
	$time = time();
	$favID = $postID.$userID;

	$select = $sdb->select("select * from Favorites where itemName()='".$favID."'");

	if(!$select->body->SelectResult->Item){
		$sdb1 = new AmazonSDB();
		$select = $sdb1->select("select * from Feeds where itemName()='".$postID."'");
		foreach($select->body->SelectResult->Item[0]->Attribute as $field)
		{
			$links[ (string) $field->Name ] = (string)$field->Value;
		}
		$sdb2 = new AmazonSDB();
		$put = $sdb2->put_attributes('Favorites', $favID, array(
			'postID' => $postID,
			'userID' => $userID,
			'fav_tags' => $tags,
			'post_link' => $links['post_link'],
			'profileID' => $links['profile_ID'],
			'feed_type' => $links['feed_type'],
		    'title' => $links['title'],
		    'pub_time' => $links['pub_time'],
		    'desc' => $links['desc'],
			'content' => $links['content'],
			'thumbnail' => $links['thumbnail'],
			'slug' => $links['slug'],
			'tags' => $links['tags'],
			'parent_post' =>$links['parent_post'],
			'parent_ID' =>$links['parent_ID'],
			'time' => $time
			), array('postID','userID','fav_tags','post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','parent_post','parent_ID','time')
		);

		if($put->body->ResponseMetadata){
				addtoExplore($postID, 'fav');
				return true;
			}
		else
			return false;
	}
	elseif($select->body->SelectResult->Item)
		return false;

}

function delFav($postID, $userID)
{
	$sdb = new AmazonSDB();
	$favID = $postID.$userID;
	$delete = $sdb->delete_attributes('Favorites', $favID);
	removeExplore($postID, 'fav');

	return true;
}

function getFavPosts($userID, $fromTime=NULL, $limit=NULL , $type=NULL, $range=0)
{
	$sdb = new AmazonSDB();

	if($type)$type = "('".implode("', '", $type)."')";

	if(!$fromTime && $type)
	{
		$select = $sdb->select("select * from Favorites where userID = '".$userID."' and feed_type IN ".$type." and pub_time != 'null' order by pub_time desc");
	}
	elseif(!$fromTime && !$type)
	{
		$select = $sdb->select("select * from Favorites where userID = '".$userID."' and pub_time != 'null' order by pub_time desc");
	}
	elseif($fromTime && $type)
	{
		$select = $sdb->select("select * from Favorites where userID = '".$userID."' and pub_time >='".$fromTime."' and feed_type IN ".$type." and pub_time != 'null' order by pub_time desc");
	}
	elseif($fromTime && !$type)
	{
		$select = $sdb->select("select * from Favorites where userID = '".$userID."' and pub_time >='".$fromTime."' and pub_time != 'null' order by pub_time desc");
	}

	for($i=0;$select->body->SelectResult->Item[$i]->Attribute;$i++)
	{
		$links[$i]['favID'] = (string)$select->body->SelectResult->Item[$i]->Name;
		foreach($select->body->SelectResult->Item[$i]->Attribute as $field){
			$links[$i][ (string) $field->Name ] = (string)$field->Value;
		}
	}

	if($limit)
	$links = array_slice($links, $range, $limit);

	return $links;
}

function followingFav($userID, $postID){
	//accept userID as array!

	$result = getAllFollowingList($user_id);
	$i=0;
	while($row = mysql_fetch_assoc($result))
	{
		$following[$i] = $row['profile_ID'];
		$i++;
	}

	if($i < 20 )
	{
		if($following)$following = "('".implode("', '", $following)."')";
		$list = isFav($following, $postID);
		return $list;
	}

	if($following && $i > 19)
	{
		$following = array_chunk($following, 20);
		for($i=0;$i<count($following, 0);$i++)
			$following[$i] = "('".implode("', '", $following[$i])."')";
		$cnt = $i;
	}
	$arr =array();
	$list =array();
	for($i=0;$i<$cnt;$i++){
		if(isFav($following[$i]))
		{
			$arr = isFav($following[$i], $postID);
			$list = array_merge( $list, $arr);
		}
	}

	return $list;
}


function isFav($userID, $postID){
	$sdb = new AmazonSDB();
	$select = $sdb->select("select * from Favorites where userID = '".$userID."' and postID = '".$postID."'");
	if(!$select->body->SelectResult->Item || !$select->body->SelectResult->Item->Attribute){
		return false;
	}
	else {
		return true;
	}
}

function favCount($userID)
{
	$sdb = new AmazonSDB();

	$select = $sdb->select("select count(*) from Favorites where userID = '".$userID."'");
	if(!$select->body->SelectResult->Item[0]->Attribute){
		return 0;
	}
	else
	return $select->body->SelectResult->Item->Attribute->Value;
}

function getFavTags($userID, $postID){
	$select = $sdb->select("select tags from Favorites where itemName()='".$postID.$userID."'");

	if($select->body->SelectResult->Item->Attribute){
			return $select->body->SelectResult->Item->Attribute->Value;
	}
	else return 0;
}



?>
