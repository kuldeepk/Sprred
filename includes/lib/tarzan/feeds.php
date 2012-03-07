<?php

require_once(dirname(__FILE__).'/tarzan.class.php');
require_once(dirname(__FILE__).'/favorites.php');
require_once(dirname(__FILE__).'/comments.php');
require_once(dirname(__FILE__).'/../lib/encode.lib.php');





//updatePosts($feedID, $feedLink, $postLink, $postData);	// this function will create postID and update Feeds domain with
															// $feedLink, $postLink, $postID.
											            	// It will update postData (all the data about a post in an array form to Feeds domain)
															// on updation return true, else false

//function getPosts($profileID=NULL, $fromTime=NULL, $limit=NULL )



//-------------

// this function will create postID and update Feeds domain with
// $feedLink, $postLink, $postID. It will update postData (all the data about a post in an array form to Feeds domain)
// on updation return true, else false

function updatePosts($profile_ID, $feed_type, $postData)
{
	$sdb = new AmazonSDB();
	$time = time();
	$postLink= $postData['post_link'];
	$postID = $profile_ID.$feed_type.$postLink;
	$slug = null;
	
	if( $postData['pub_time'] > $time || !$postData['pub_time']) $postData['pub_time'] = $time ; // Additional checks on pub_time to avoid future/null dates
	
	if($postData['title'] && $slug == null){
		$slug = makeslug($postData['title']);
	}
	if($postData['desc'] && $slug == null){
		$slug = makeslug($postData['desc']);
	}
	if($postLink && $slug == null){
		$slug = makeslug($postLink);
	}
	if($slug == null){
		$slug = rand(1000000000, 9999999999);
		$slug = Encode::base64_url_encode($slug);
	}
	
	$select = $sdb->select("select * from Feeds where itemName()='".$postID."'");
	if(!$select->body->SelectResult->Item->Attribute){	
		$sdb1 = new AmazonSDB();
		$put = $sdb1->put_attributes('Feeds', $postID, array(
		'post_link' => $postLink,
		'profileID' => $profile_ID,
		'feed_type' => $feed_type,
	    'title' => $postData['title'],
	    'pub_time' => $postData['pub_time'],
	    'desc' => $postData['desc'],
		'content' => $postData['content'],
		'thumbnail' => $postData['thumbnail'],
		'slug' => $slug,
		'tags' => $postData['tags'],		
		'modified' => $time
		), array('post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','slug','tags','modified'));
			if($put->body->ResponseMetadata)
			{
				if($time-$postData['pub_time'] < 1800)
				return true;
				else
				return false;
			}
			elseif(!$put->body->ResponseMetadata)
			return false;
	}
	/*
	elseif($select->body->SelectResult->Item->Attribute)
	{
		$j=0;
		for($i=0;$i<$select->body->SelectResult->Item->Attribute[$i];$i++)
		{
			if($select->body->SelectResult->Item->Attribute[$i]->Name=='title')
				{
					 if($select->body->SelectResult->Item->Attribute[$i]->Value!=$postData['title'] )
					 {
					 	$j++;
					 }
				}

			elseif($select->body->SelectResult->Item->Attribute[$i]->Name=='pub_time')
				{
					if($select->body->SelectResult->Item->Attribute[$i]->Value!=$postData['pub_time'] )
					{
						$j++;
					}
				}


			elseif($select->body->SelectResult->Item->Attribute[$i]->Name=='desc')
				{
					if($select->body->SelectResult->Item->Attribute[$i]->Value!=$postData['desc'])
					{
						$j++;
					}
				}


			elseif($select->body->SelectResult->Item->Attribute[$i]->Name=='content')
				{
					if($select->body->SelectResult->Item->Attribute[$i]->Value!=$postData['content'])
					{
						$j++;
					}
				}
		}

		if($j)
		{
			$put = $sdb->put_attributes('Feeds', $postID, array(
			'post_link' => $postLink,
			'profileID' => $profile_ID,
			'feed_type' => $feed_type,
		    'title' => $postData['title'],
		    'pub_time' => $postData['pub_time'],
		    'desc' => $postData['desc'],
			'content' => $postData['content'],
			'thumbnail' => $postData['thumbnail'],
			'slug' => $slug,
			'tags' => $postData['tags'],
			'modified' => $time
		), array('post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','slug','tags','modified'));
		}
	}*/
}

function putAnnc($profile_ID, $annc)
{
	$annc = shortenText(strip_tags($annc), 180);
	$time=time();
	$sdb = new AmazonSDB();
	$time_gap= 86400; // -> one day : 1*24*60*60
 	$slug = null;
	if($postData['content'] && $slug == null){
		$slug = makeslug($postData['content']);
	}
	if($postData['desc'] && $slug == null){
		$slug = makeslug($postData['desc']);
	}
	if($slug == null){
		$slug = Encode::base64_url_encode($postData['desc']);
	}
	if($slug == null){
		$slug = rand(1000000000, 9999999999);
		$slug = Encode::base64_url_encode($slug);
	}


	$select = $sdb->select("select pub_time from Feeds where profileID = '".$profile_ID."' and feed_type = 'annc' and pub_time != 'null' order by pub_time desc");
	$time_last = $select->body->SelectResult->Item[0]->Attribute->Value;
	if($time-$time_last < $time_gap){return 0;}
	else{
		$postID = $profile_ID.'annc'.$time;
		$put = $sdb->put_attributes('Feeds', $postID, array(
		'profileID' => $profile_ID,
		'feed_type' => 'annc',
		'pub_time' => $time,
		'content' => $annc,
		'desc' => $annc,
		'slug' => $slug,
		'modified' => $time
		), array('profileID','feed_type','pub_time','content','desc','slug','modified'));

		if(!$put){return -1;}
		else {return 1;}
	}
}

function addShared($profileID, $parentPostID) {
	$sdb = new AmazonSDB();
	$time = time();
	$postData = getPostFromPostID($parentPostID);
	if(trim($postData['parent_post'])){
		$parentPostID = $postData['parent_post'];
		$parentProfileID = $postData['parent_ID'];
	} else {
		$parentPostID = $postData['postID'];
		$parentProfileID = $postData['profileID'];
	}
	
	if($profileID != $parentProfileID){
		$postLink= $postData['post_link'];
		$postID = $profileID.$postData['feed_type'].$postLink;
		$select = $sdb->select("select * from Feeds where itemName()='".$postID."'");
		if(!$select->body->SelectResult->Item){
			$sdb1 = new AmazonSDB();
			$put = $sdb1->put_attributes('Feeds', $postID, array(
			'post_link' => $postLink,
			'profileID' => $profileID,
			'feed_type' => $feed_type,
		    'title' => $postData['title'],
		    'pub_time' => $postData['pub_time'],
		    'desc' => $postData['desc'],
			'content' => $postData['content'],
			'thumbnail' => $postData['thumbnail'],
			'slug' => $postData['slug'],
			'tags' => $postData['tags'],
			'parent_post' =>$parentPostID,
			'parent_ID' =>$parentProfileID,
			'modified' => $time
			), array('post_link','profileID','feed_type','title','pub_time','desc','content','thumbnail','slug','tags','parent_post','parent_ID','modified'));

			if($put->body->ResponseMetadata){
				addtoExplore($parentPostID, 'share');
				return $postID;
			}
			elseif(!$put->body->ResponseMetadata)
				return false;
		} else
			return $postID;
	}
}

function delPost($postID)
{
	$sdb = new AmazonSDB();
	$posts = getPostFromPostID($postID);
	$select = $sdb->select("select parentPostID from Feeds where itemName()='".$postID."'");
	$parentPostID = $select->body->SelectResult->Item[0]->Attribute->Value;
	removeExplore($parentPostID, 'share');
	$delete = $sdb->delete_attributes('Feeds', $postID);
	return true;
}

function getPostFromPostID($postID, $userID=null){
	$sdb = new AmazonSDB();
	$select = $sdb->select("select * from Feeds where itemName()='".$postID."'");

	$links['postID'] = (string) $select->body->SelectResult->Item[0]->Name[0];
	foreach($select->body->SelectResult->Item[0]->Attribute as $field){
		$links[ (string) $field->Name ] = (string)$field->Value;
	}
	$posts[0] = $links;
	$posts = getCommentsForAll($posts);
	if($userID)
		$posts = chkForFavs($posts, $userID);
	$links = $posts[0];
	return $links;
}

function getPostFromSlug($profileID,$timestamp,$slug=NULL,$userID=NULL){
	$sdb = new AmazonSDB();
	if($slug != NULL)
		$select = $sdb->select("select * from Feeds where profileID='".$profileID."' and pub_time='".$timestamp."' and slug='".$slug."'");
	else 
		$select = $sdb->select("select * from Feeds where profileID='".$profileID."' and pub_time='".$timestamp."'");
	
	$links['postID'] = (string) $select->body->SelectResult->Item[0]->Name[0];
	foreach($select->body->SelectResult->Item[0]->Attribute as $field){
		$links[ (string) $field->Name ] = (string)$field->Value;
	}
	$posts[0] = $links;
	$posts = getCommentsForAll($posts);
	if($userID)
		$posts = chkForFavs($posts, $userID);
	$links = $posts[0];
	return $links;
}

function getPosts($profileID=NULL, $fromTime=NULL, $limit=NULL , $type=NULL, $range=0, $userID=NULL)
{
	if(!$profileID){
		$links = getPostsData($profileID, $fromTime, (int)$range+$limit, $type, $userID);
		if($limit)
		$links = array_slice($links, $range, $limit);
		$links = getCommentsForAll($links);
		if($userID)
			$links = chkForFavs($links, $userID);
		return $links;
	}
	if(count($profileID,0) < 20 ){
		if($profileID)$profileID = "('".implode("', '", $profileID)."')";
		$links = getPostsData($profileID, $fromTime, NULL, $type, $userID);
		if($limit && $links)
			$links = array_slice($links, $range, $limit);
		$links = getCommentsForAll($links);
		if($userID)
			$links = chkForFavs($links, $userID);
		return $links;
	}


	if(count($profileID,0) > 19){
		$profileID = array_chunk($profileID, 20);
		for($i=0;$i<count($profileID, 0);$i++)
			$profileID[$i] = "('".implode("', '", $profileID[$i])."')";
		$cnt = $i;
	}
	$arr =array();
	$links =array();
	for($i=0;$i<$cnt;$i++){
		if($arr = getPostsData($profileID[$i], $fromTime, (int)$range+$limit, $type, $userID)){
			$links = array_merge( $links, $arr);
		}
	}


	for($i=0;$links[$i];$i++)
		$aux[$i] = $links[$i]['pub_time'];

	array_multisort($aux,SORT_DESC,SORT_NUMERIC,$links,SORT_DESC,SORT_NUMERIC);

	if($limit)
	$links = array_slice($links, $range, $limit);

	$links = getCommentsForAll($links);
	if($userID)
		$links = chkForFavs($links, $userID);

	return $links;
}
///////////




function getPostsData($profileID=NULL, $fromTime=NULL, $limit=NULL , $type=NULL)
{
	$sdb = new AmazonSDB();

	if($type)$type = "('".implode("', '", $type)."')";

	if($fromTime && $profileID && $type)
	{
		$select = $sdb->select("select * from Feeds where pub_time >='".$fromTime."' and profileID IN ".$profileID." and feed_type IN ".$type." and pub_time != 'null' order by pub_time desc");
	}
	elseif($fromTime && $profileID && !$type)
	{
		$select = $sdb->select("select * from Feeds where pub_time >='".$fromTime."' and profileID IN ".$profileID." and pub_time != 'null' order by pub_time desc");
	}
	elseif(! $fromTime && $profileID && $type)
	{
		$select = $sdb->select("select * from Feeds where profileID IN ".$profileID." and feed_type IN ".$type."  and pub_time != 'null' order by pub_time desc");
	}
	elseif(! $fromTime && $profileID && !$type)
	{
		$select = $sdb->select("select * from Feeds where profileID IN ".$profileID." and pub_time != 'null' order by pub_time desc");
	}

	elseif(!$fromTime && !$profileID && $type)
	{
	//-	echo"4";
		$select = $sdb->select("select * from Feeds where feed_type IN ".$type." and pub_time != 'null' order by pub_time desc");
	}
	elseif(!$fromTime && !$profileID && !$type)
	{
	//-	echo"6";
		$select = $sdb->select("select * from Feeds where pub_time != 'null' order by pub_time desc");
	}

	///////////

	elseif($fromTime && !$profileID && $type)
	{
	//-	echo"5";
		$select = $sdb->select("select * from Feeds where pub_time >='".$fromTime."' and feed_type IN ".$type." and pub_time != 'null' order by pub_time desc");
	}
	elseif($fromTime && !$profileID && !$type)
	{
	//-	echo "right";
		$select = $sdb->select("select * from Feeds where pub_time >='".$fromTime."' and pub_time != 'null' order by pub_time desc");
	}

	///////////

	for($i=0;$select->body->SelectResult->Item[$i]->Attribute;$i++)
	{
		$links[$i]['postID'] = (string) $select->body->SelectResult->Item[$i]->Name[0];

		$links[$i]['tags'] = null;
		$links[$i]['isFav'] = null;

		//is the post Fav'ed by user
		/*if($userID){
			if(isFav($userID, $links[$i]['postID'])){
				//$links[$i]['tags'] = getFavTags($userID, $links[$i]['postID']);
				$links[$i]['isFav'] = 1;
			}

			//is the post Fav'ed by ppl the user is following
			//$favedBy = followingFav($userID, $links[$i]['postID']);
			//$links[$i]['favedBy'] = $favedBy;
		}


		//get all comments to a post
		$comments = getComments($links[$i]['postID']);
		if($comments){
			$links[$i]['comments'] = $comments;
		}*/

		foreach($select->body->SelectResult->Item[$i]->Attribute as $field)
		{
			$links[$i][ (string) $field->Name ] = (string)$field->Value;
		}
	}
	return $links;
}

function postCount($profileID)
{
	$sdb = new AmazonSDB();

	$select = $sdb->select("select count(*) from Feeds where profileID = '".$profileID."'");
	if(!$select->body->SelectResult->Item[0]->Attribute){
		return 0;
	}
	else
	return $select->body->SelectResult->Item->Attribute->Value;
}

function getCommentsForAll($posts) {
	foreach($posts as $key=>$post){
		if($post['parent_post'])
			$comments = getComments($post['parent_post']);
		else
			$comments = getComments($post['postID']);
		if($comments){
			$posts[$key]['comments'] = $comments;
		}
	}
	return $posts;
}

function chkForFavs($posts, $userID) {
	foreach($posts as $key=>$post){
		if($post['parent_post']){
			if(isFav($userID, $post['parent_post'])){
				$posts[$key]['isFav'] = true;
			}
		} else {
			if(isFav($userID, $post['postID'])){
				$posts[$key]['isFav'] = true;
			}
		}
	}
	return $posts;
}

function makeslug($pslug) {
		$pslug = preg_replace('/\s+/', ' ', $pslug);
		$pslug = trim($pslug);
	    $pslug = explode(' ', $pslug);
		$pslug = implode(' ', array_slice($pslug, 0, 10));
		$pslug = substr($pslug, 0, 100);
		$pslug = preg_replace("/[^a-zA-Z0-9 ]/", "", $pslug);
		$pslug = preg_replace('/\s+/', ' ', $pslug);
		$pslug = trim($pslug);
		$pslug = str_replace(" ", "-", $pslug);
		$pslug = strtolower($pslug);
		return $pslug;
}

?>