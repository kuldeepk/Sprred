<?php

//require_once('metaReader.php');
//require_once('reader.php');
require_once (dirname(__FILE__).'/simplepie_feeds.php');
require_once(dirname(__FILE__).'/feeds.php');
require_once(dirname(__FILE__).'/tarzan.class.php');



//...createFeedsMeta($profileID, $feedLink, $feedType); // will create $feedID and put $profileID, $feedLink, $feedType and $feedID
													 // in the FeedsMeta domain. It will then call crawlFeedsMeta() to get other metadata of the feed
													 // It will later call crawlFeedsforPosts()

//...updateFeedLink($profileID, $feedLink, $feedType);  // will Update and put $feedLink,
													 // in the FeedsMeta domain. It will then call crawlFeedsMeta() to get updated metadata of the feed
													 // It will later call crawlFeedsforPosts()
													 
//...updateFeedTitle($profileID, $feedType, $name);		 // It will accept the feed name from user and directly update it in FedsMeta
//...updateFeedDesc($profileID, $feedType, $desc);		 // It will accept the feed description from user and directly update it in FedsMeta
//...updateFeedTags($profileID, $feedType, $tags);		 // It will accept the feed tags from user as array and directly update it in FedsMeta
//...updateFeedComment($profileID, $feedType, $comment);	 // It will accept the comment feed from user and directly update it in FedsMeta
//...updateFeedModified($feedID, $modified);


//???getFeedMeta($profileID, $feedType);				 // return entire array of attributes in FeedsMeta for a particular user


//...getNewPosts($profileID, $fromTime, $limit);						 // return URLs in FeedsMeta for all feeds since $fromTime

//...crawlFeedsMeta($feedID, $feedLink); 			//...this function will crawl the feed page and get feed metadata. Call putFeedsMeta to populate the metadata

//...crawlFeedsforPosts($feedID, $feedLink);			//  will crawl the entire feed looking for only the posts' URLs. It will then call 
													// updatePosts() for each post with $feedID, $feedLink, $postLink, $postData (data of that post in array)


//...putFeedsMeta($feedID, $array, $feedLink);

//feedUpdater();									//  will be invoked by the cron.
													// It will get all the 'feedLink's from the FeedsMeta domain and call crawlFeedsforPosts()
													// for each feedlink using $feedID and $feedLink.

//...getFeedLink($profileID,$feedType);
//...getFeedTitle($profileID, $feedType);				 // return title of feed in FeedsMeta for a particular user
//...getFeedDesc($profileID, $feedType);				 // return description of feed in FeedsMeta for a particular user
//...getFeedTag($profileID, $feedType);				 // return array of tags of feed in FeedsMeta for a particular user
//...getFeedComment($profileID, $feedType);				 // return comment feed of feed in FeedsMeta for a particular user


//-------------------

//this function will create $feedID and put $profileID, $feedLink, $feedType and $feedID
// in the FeedsMeta domain. It will then call crawlFeedsMeta() to get other metadata of the feed
// It will later call crawlFeedsforPosts()

function createFeedsMeta($profileID, $feedLink, $feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$put = $sdb->put_attributes('FeedsMeta', $feedID, array(	// put $profileID, $feedLink, $feedType and $feedID in the FeedsMeta domain
		    'profile_ID' => $profileID,
		    'feed_link' => $feedLink,
		    'feed_type' => $feedType,
			),
			 array( 
    'profile_ID',
	'feed_link',
	'feed_type'
		)
	);
	
	crawlFeedsMeta($feedID, $feedLink); 									// call crawlFeedsMeta() to get other metadata of the feed
	
}


//...this function will Update and put $feedLink,
// in the FeedsMeta domain. It will then call crawlFeedsMeta() to get updated metadata of the feed
// It will later call crawlFeedsforPosts()
// ~~~~~~~~to delete previous posts???
function updateFeedLink($profileID, $feedLink, $feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select('select feed_link from FeedsMeta where itemName()=$feedID');
	$oldLink = $select->body->SelectResult->Item[0]->Attribute->Value;
	if($oldLink != $feedLink)
	{
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(	// put new $feedLink in the FeedsMeta domain
			    'feed_link' => $feedLink,
		),
			 array( 
  	'feed_link'	)
	);
	crawlFeedsMeta($feedID, $feedLink); 					// call crawlFeedsMeta() to get other metadata of the feed
	}
}

// It will accept the feed metadata from user (except the URL) and directly update it in FeedsMeta

function updateFeedTitle($profileID, $feedType, $name)
{
	$feedID = $profileID.$feedType;							// create $feedID
	$sdb = new AmazonSDB();
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
	    'title' => $name),
		 array('title')
	);
}
function updateFeedDesc($profileID, $feedType, $desc)
{
	$feedID = $profileID.$feedType;							// create $feedID
	$sdb = new AmazonSDB();
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
	    'desc' => $desc),
		 array('desc'));
}
function updateFeedTags($profileID, $feedType, $tags)
{
	// accept $tags as array
	$feedID = $profileID.$feedType;							// create $feedID
	$sdb = new AmazonSDB();
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
	    'tags' => $tags),
		 array('tags'));
}
function updateFeedComment($profileID, $feedType, $comment)
{
	$feedID = $profileID.$feedType;							// create $feedID
	$sdb = new AmazonSDB();
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
	    'comment' => $comment),
		 array('comment'));
}
function updateFeedModified($feedID, $modified)
{
	$sdb = new AmazonSDB();
		$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
	    'modified' => $modified),
		 array('modified'));
}



function getFeedsMeta($profileID, $feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select * from FeedsMeta where itemName()='".$feedID."'");

////////////////// check if reqd~~~~~~~~~~~`	

}




//...this function will crawl the feed page and get feed metadata. Call putFeedsMeta to populate the metadata
/*$feedLink='http://feedproxy.google.com/Techcrunch';
$feedID='123asfd';
crawlFeedsMeta($feedID, $feedLink);
*/
function crawlFeedsMeta($feedID, $feedLink)
{
	//-echo "<li>crawlfeedsmeta()";
	$blogFeed = feeds_meta($feedLink);
/*		echo "<li>Title....";
		echo $blogFeed['title'];
		echo "<li>time....";
		echo $blogFeed['desc'];
		echo "<li>language....";
		echo $blogFeed['language'];
		echo "<li>generator....";
		echo $blogFeed['favicon'];
		echo "<li>End....";
		echo "<li>";
*/
	putFeedsMeta($feedID, $blogFeed, $feedLink);
}


function putFeedsMeta($feedID, $arr, $feedLink)
{
	//-echo "<li>putfeedsmeta()";
	$sdb = new AmazonSDB();
//	$fromTime = date('d M Y H:i:s',strtotime($fromTime));  

	$put = $sdb->put_attributes('FeedsMeta', $feedID, array(
    'title' => $arr['title'],
    'favicon' => $arr['favicon'],
    'desc' => $arr['desc'],
    'language' => $arr['language'],
	'modified' => date('d M Y H:i:s',time())
	)
	,
		 array('title','favicon','desc','language','modified'));

//	crawlFeedsforPosts($feedID, $feedLink);
}

//  will be invoked by the cron.
// It will get all the 'feedLink's from the FeedsMeta domain and call crawlFeedsforPosts()
// for each feedlink using $feedID and $feedLink.

function feedUpdater()
{
	//-echo "<li>feedUpdater()";
	$sdb = new AmazonSDB();
	//$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select('select feed_link,profile_ID,feed_type from FeedsMeta');

//print_r($select);
	for($i=0;$select->body->SelectResult->Item[$i]->Attribute;$i++)
	{
		//-echo $select->body->SelectResult->Item[$i]->Attribute->Name."...".$select->body->SelectResult->Item[$i]->Attribute->Value;
		//-echo '<li>';
		$feedID[$i]=$select->body->SelectResult->Item[$i]->Name;
		
		$link[$i]=$select->body->SelectResult->Item[$i]->Attribute->Value;
		
			for($j=0;$select->body->SelectResult->Item[$i]->Attribute[$j];$j++)
			{
				if($select->body->SelectResult->Item[$i]->Attribute[$j]->Name=='profile_ID')
				$links[$i]['profile_ID'] = $select->body->SelectResult->Item[$i]->Attribute[$j]->Value;
				elseif($select->body->SelectResult->Item[$i]->Attribute[$j]->Name=='feed_link')
				$links[$i]['feed_link'] = $select->body->SelectResult->Item[$i]->Attribute[$j]->Value;
				elseif($select->body->SelectResult->Item[$i]->Attribute[$j]->Name=='feed_type')
				$links[$i]['feed_type'] = $select->body->SelectResult->Item[$i]->Attribute[$j]->Value;
			}
	
		
	}

	$nooflinks=$i;
	$report="";
	$report=$report."Feeds Crawled";

	for($i=0;$i<$nooflinks;$i++)	
	{ 
		$report=$report."<li>".$link[$i];
//		crawlFeedsMeta($feedID[$i], $link[$i]); 
		crawlFeedsforPosts($feedID[$i], $links[$i]['profile_ID'], $links[$i]['feed_link'], $links[$i]['feed_type']);
		
	}
	//-echo $report;
}		

//  will crawl the entire feed looking for the posts' URLs and also get posts' data. It will then call 
// updatePosts() for each post with $feedID, $feedLink, $postLink, $postData (data of that post in array)
// updatePosts() will return true if post is new and updated in Feeds domain else false.
// if updation is made the corresponding feed's modified time is updated in FeedsMeta.

function crawlFeedsforPosts($profileID, $feedLink, $feedType)
{
	//-echo "<li>";	
	$blogFeed = posts_data($feedLink);
	
	$j=0;
	for($i=0;$blogFeed[$i];$i++)
	{
		/*
			echo "<li>Title....";
			echo $blogFeed[$i]['title'];
			echo "<li>time....";
			echo $blogFeed[$i]['pubtime'];
			echo "<li>Desc....";
			echo $blogFeed[$i]['desc'];
			echo "<li>Link....";
			echo $blogFeed[$i]['link'];
			echo "<li>Thumb....";
			echo $blogFeed[$i]['content'];
			echo "<li>End....";
			echo "<li>";
*/	
		$modified=updatePosts($profileID, $feedType, $blogFeed[$i]);
		if($modified==1)
		{
		$statusData[$j]=$blogFeed[$i];
		$statusData[$j]['profile_ID']=$profileID;
		//print_r($statusData[$j]);
		$j++;
		}
	}
	
	return $statusData;
		//call status_update($statusData);

}




//////////-------GET functions

/*
//function getNewPosts($profileID=NULL, $fromTime=NULL, $Limit=NULL, $feedType=NULL)<---- to be changed to this
function getNewPosts($profileID=NULL, $feedType=NULL, $fromTime=NULL, $limit=NULL)
{
//	feedUpdater();
	if($fromTime && !$feedType)
	{
		$fromTime = date('d M Y H:i:s',strtotime($fromTime));  
		$select = $sdb->select("select feed_link from FeedsMeta where modified >= '".$fromTime."' and profile_ID='".$profileID."'");
	}
	elseif(!$fromTime && !$feedType) 
	{
		$select = $sdb->select('select feed_link from FeedsMeta');
	}
	elseif($fromTime && $feedType) 
	{
		$fromTime = date('d M Y H:i:s',strtotime($fromTime));  
		$select = $sdb->select("select feed_link from FeedsMeta where modified >= '".$fromTime."' and itemName() = '".$profileID.$feedType."'");
	}							
	elseif(!$fromTime && $feedType) 
	{
		$select = $sdb->select("select feed_link from FeedsMeta where itemName() = '".$profileID.$feedType."'");
	}
	if($feedLimit)
	{
		for($i=0;$i<$feedLimit;$i++)
		{
			$links[$i] = $select->body->SelectResult->Item[$i]->Attribute->Value;
		}
	}	
	else
	{
		for($i=0;$select->body->SelectResult->Item[$i]->Attribute;$i++)
		{
			$links[$i] = $select->body->SelectResult->Item[$i]->Attribute->Value;
		}
	}
	$links=getposts($links, $fromTime, $postLimit);
		return $links;
}

*/

function getFeedLink($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select feed_link from FeedsMeta where itemName()='".$feedID."'");
	$link = $select->body->SelectResult->Item->Attribute->Value;
	return $link;
}
function getFeedTitle($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select title from FeedsMeta where itemName()='".$feedID."'");
	$title = $select->body->SelectResult->Item->Attribute->Value;
	return $title;
}
function getFeedDesc($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select desc from FeedsMeta where itemName()='".$feedID."'");
	$desc = $select->body->SelectResult->Item->Attribute->Value;
	return $desc;
}
function getFeedTags($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select tags from FeedsMeta where itemName()='".$feedID."'");
	for($i=0;$select->body->SelectResult->Item->Attribute[$i];$i++)
	{
		$tags[$i] = $select->body->SelectResult->Item->Attribute[$i]->Value;
	}
	return $tags;
}
function getFeedComment($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select comment from FeedsMeta where itemName()='".$feedID."'");
	$comment = $select->body->SelectResult->Item->Attribute->Value;
	return $comment;
}
function getFeedFavicon($profileID,$feedType)
{
	$sdb = new AmazonSDB();
	$feedID = $profileID.$feedType;							// create $feedID
	$select = $sdb->select("select favicon from FeedsMeta where itemName()='".$feedID."'");
	$favicon = $select->body->SelectResult->Item->Attribute->Value;
	return $favicon;
}

?>
