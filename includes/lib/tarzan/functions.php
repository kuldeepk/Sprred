<?php

require_once('tarzan.class.php');
require_once('reader.php');

/**
 * Instantiate a new AmazonSDB object using the settings from the config.inc.php file.
 * 
 * 
 * Select::::
 * get row / attributes->
 * $select->body->SelectResult->Item->Attribute[$i]->Value;
 * 
 * get column / Items ->
 * $select->body->SelectResult->Item[0]->Attribute->Value;
 * 
 */
 
echo date('d M Y H:i:s',time());
$sdb = new AmazonSDB();
$desc = "A couple years ago, Netflix began supplementing its DVD mail rental business with movie streams over the Web. for a few thousand select titles.  Today, millions of Netflix customers stream their movies instead of waiting for them to come in the mail (or, more often, do both).  ComScore Video Metrix estimates Netflix's online viewership a bit lower at 645,000 unique viewers in March.  They watched 6.9 million video streams and the average time spent watching per viewer is an amazing 128 minutes for the month, which is right up there with YouTube in terms of time spent (having full-length feature films helps keep people around longer). I ran into Netflix CEO Reed Hastings at the AllThingsD conference this week, and asked him in the video (after the jump) how his streaming service is going and how its economics compare to that of mailing out A couple years ago, Netflix began supplementing its DVD mail rental business with movie streams over the Web. for a few thousand select titles.  Today, millions of Netflix customers stream their movies instead of waiting for them to come in the mail (or, more often, do both).  ComScore Video Metrix estimates Netflix's online viewership a bit lower at 645,000 unique viewers in March.  They watched 6.9 million video streams and the average time spent watching per viewer is an amazing 128 minutes for the month, which is right up there with YouTube in terms of time spent (having full-length feature films helps keep people around longer). I ran into Netflix CEO Reed Hastings at the AllThingsD conference this week, and asked him in the video (after the jump) how his streaming service is going and how its economics compare to that of mailing out 1700";

$desc = substr($desc , 0 , 1021)."...";

//$select = $sdb->select('select * from warpshare_test where no >= "1" order by no desc');
$postID='222bloghttp://ausumness.blogspot.com/2008/12/now-this-is-awesome.html';
$no='5';
$con='dsf';//"select COUNT(*) FROM inv WHERE site='" . $sname . "'"
	$select = $sdb->select("select * from Feeds where itemName()='".$postID."'");
	echo "<li>".print_r($select)."<li>";
/*
	print_r($select);
		$put = $sdb->put_attributes('warpshare_test', 'time', array(
	    'modified' => $desc),
		 array( 
    'modified'
		)
		);
*/


/*
	$select = $sdb->select('select email from warpshare_test where name="rohan" and con="asfd"');
	print_r($select);
	echo '<li>';
	$i=0;
	if(!$select->body->SelectResult->Item->Attribute){echo "nei nei";}
	echo $select->body->SelectResult->Item[0]->Attribute[0]->Name."...".$select->body->SelectResult->Item[0]->Attribute[0]->Value;
	/*/
//	$tags[$i] = $select->body->SelectResult->Item->Attribute[$i]->Value;
	
	//$link = $select->body->SelectResult->Item[3]->Attribute->Value;
	
/*$tags = array ('cool','one','done');
$put = $sdb->put_attributes('warpshare_test', 'user_data', array(
    'surname' => 'wusup'
    ,'tags' => $tags
));
*/
/**
 * Create a new SimpleDB domain.

$domain = $sdb->create_domain('warpshare_test');

// As long as the request was successful...
if ($domain->isOK())
{
    // Do stuff!
	echo 'cool';
}

// Use Select

$select = $sdb->select('select url from redanyway');

for($i=0;$select->body->SelectResult->Item[$i];$i++)
{
echo '<li>';
echo $select->body->SelectResult->Item[$i]->Attribute->Value;
}
*/

// get item
//$select = $sdb->select('select url from redanyway where itemName()="kk"');
//$feed=$select->body->SelectResult->Item[0]->Attribute->Value;
//echo $feed;
$feed='http://feedproxy.google.com/Techcrunch';
// read feed

//$blogFeed = readFeed($feed);
for($i=0;$blogFeed[$i];$i++)
{
	/*	echo "<li>Title....";
		echo $blogFeed[$i]['title'];
		echo "<li>time....";
		echo $blogFeed[$i]['pubTime'];
		echo "<li>Desc....";
		echo $blogFeed[$i]['desc'];
		echo "<li>Link....";
		echo $blogFeed[$i]['link'];
		echo "<li>Thumb....";
		echo $blogFeed[$i]['thumb'];
		echo "<li>Comments....";
		echo $blogFeed[$i]['comment'];
		echo "<li>Content....";
		echo $blogFeed[$i]['content'];
		echo "<li>End....";
		echo "<li>";
*/
//echo $blogFeed[$i];
}

?>