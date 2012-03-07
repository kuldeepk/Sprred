<?php

require_once(dirname(__FILE__).'/tarzan.class.php');

function addtoExplore($postID, $add){
	$sdb = new AmazonSDB();
	$time = time();
	$select = $sdb->select("select ".$add." from Explore where itemName()='".$postID."'");
	
	if($add == 'fav'){
		$fav = (int)$select->body->SelectResult->Item->Attribute->Value + 1;
		
		$put = $sdb->put_attributes('Explore', $postID, array(
		    'fav' => $fav,
			'modified' => $time
		), array('fav','modified'));
	}
	elseif($add == 'comment'){
		$comment = (int)$select->body->SelectResult->Item->Attribute->Value + 1;
		$put = $sdb->put_attributes('Explore', $postID, array(
		    'comment' => $comment,
			'modified' => $time
		), array('comment','modified'));		
	}
	elseif($add == 'share'){
		$share = (int)$select->body->SelectResult->Item->Attribute->Value + 1;
		$put = $sdb->put_attributes('Explore', $postID, array(
		    'share' => $share,
			'modified' => $time
		), array('share','modified'));		
	}	
}

function removeExplore($postID, $remove){
	$sdb = new AmazonSDB();
	$time = time();
	$select = $sdb->select("select ".$remove." from Explore where itemName()='".$postID."'");

	if((int)$select->body->SelectResult->Item->Attribute->Value){
	
		if($remove == 'fav'){
			$fav = (int)$select->body->SelectResult->Item->Attribute->Value - 1;
			
			$put = $sdb->put_attributes('Explore', $postID, array(
			    'fav' => $fav,
				'modified' => $time
			), array('fav','modified'));
		}
		elseif($remove == 'comment'){
			$comment = (int)$select->body->SelectResult->Item->Attribute->Value - 1;
			$put = $sdb->put_attributes('Explore', $postID, array(
			    'comment' => $comment,
				'modified' => $time
			), array('comment','modified'));		
		}
		elseif($remove == 'share'){
			$share = (int)$select->body->SelectResult->Item->Attribute->Value - 1;
			$put = $sdb->put_attributes('Explore', $postID, array(
			    'share' => $share,
				'modified' => $time
			), array('share','modified'));		
		}
	}
	
}
	
function exploreFav($limit=null, $range=0, $userID=null){
	$sdb = new AmazonSDB();
	$select = $sdb->select("select * from Explore where fav != 'null' order by fav desc");

	for($i=0;$select->body->SelectResult->Item[$i]->Attribute && $i<100;$i++)
	{
		$links[$i] = getPostFromPostID($select->body->SelectResult->Item[$i]->Name);
	}
		
	if($limit)
	$links = array_slice($links, $range, $range+$limit);
	$links = getCommentsForAll($links);
	if($userID)
		$links = chkForFavs($links, $userID);
	return $links;	
}

function exploreComment($limit=null, $range=0, $userID=null){
	$sdb = new AmazonSDB();
	$select = $sdb->select("select * from Explore where comment != 'null' order by comment desc");
	
	for($i=0;$select->body->SelectResult->Item[$i]->Attribute && $i<100;$i++)
	{
		$links[$i] = getPostFromPostID($select->body->SelectResult->Item[$i]->Name);
	}
		
	if($limit)
	$links = array_slice($links, $range, $range+$limit);
	$links = getCommentsForAll($links);
	if($userID)
		$links = chkForFavs($links, $userID);
	return $links;
}

function exploreShare($limit=null, $range=0, $userID=null){
	$sdb = new AmazonSDB();
	$select = $sdb->select("select * from Explore where share != 'null' order by share desc");
	
	for($i=0;$select->body->SelectResult->Item[$i]->Attribute && $i<100;$i++)
	{
		$links[$i] = getPostFromPostID($select->body->SelectResult->Item[$i]->Name);
	}
		
	if($limit)
	$links = array_slice($links, $range, $range+$limit);
	$links = getCommentsForAll($links);
	if($userID)
		$links = chkForFavs($links, $userID);
	return $links;
	
}
?>
