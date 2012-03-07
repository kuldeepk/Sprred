<?php

function readFeed($feedURL) {
	$xmlDoc = new DOMDocument("<rss/>");
	libxml_use_internal_errors(true);
	$opts = array(
	    'http' => array(
	        'User-Agent' => 'Redanyway',
	    )
	);	
	$context = stream_context_create($opts);
	libxml_set_streams_context($context);
	if(!$xmlDoc->load($feedURL)){
		return null;
	}
	$errors = libxml_get_errors();
    if(!empty($errors))
        return null;
	
	$feed = array();
	
	$entry = $xmlDoc->getElementsByTagName('item');
	if($entry->item(0)){
		$cnt = 0;
		while($entry){
			$elem = $entry->item($cnt);
			if(!$elem||$cnt==5){
				break;	
			}
			if($tag = $elem->getElementsByTagName('title')->item(0))
				$feed[$cnt]['title'] = $tag->nodeValue;
			if($tag = $elem->getElementsByTagName('thumbnail')->item(0))	
				$feed[$cnt]['thumb'] = $tag->attributes->getNamedItem('url')->nodeValue;
			if($tag = $elem->getElementsByTagName('link')->item(0))
				$feed[$cnt]['link'] = $tag->nodeValue;
			if($tag = $elem->getElementsByTagName('pubDate')->item(0))
				$feed[$cnt]['pubTime'] = date('d M Y H:i',strtotime($tag->nodeValue)); 
			if($tag = $elem->getElementsByTagName('description')->item(0))
				$feed[$cnt]['desc'] = strip_script1($tag->nodeValue);
			if($tag = $elem->getElementsByTagName('comments')->item(0))
				$feed[$cnt]['comment'] = strip_script1($tag->nodeValue);
			if($tag = $elem->getElementsByTagName('guid')->item(0))
				$feed[$cnt]['guid'] = strip_script1($tag->nodeValue);
			if($tag = $elem->getElementsByTagName('content')->item(0))
				{$feed[$cnt]['content'] = strip_script1($tag->nodeValue);}
				if($feed[$cnt]['desc'])$feed[$cnt]['desc'] = substr($feed[$cnt]['desc'] , 0 , 1010)."...";
				if($feed[$cnt]['content'])$feed[$cnt]['content'] = substr($feed[$cnt]['content'] , 0 , 1010)."...";
		
			//$feed[$cnt]['desc'] = shortenText(strip_tags($tag->nodeValue),300);
			
			$cnt++;
		}
	}
	else {	
		$entry = $xmlDoc->getElementsByTagName('entry');
		$cnt = 0;
		while($entry){
			$elem = $entry->item($cnt);
			if(!$elem||$cnt==5){
				break;	
			}
			if($tag = $elem->getElementsByTagName('title')->item(0))
				$feed[$cnt]['title'] = $tag->nodeValue;
			if($tag = $elem->getElementsByTagName('published')->item(0))
				$feed[$cnt]['pubTime'] = date('d M Y H:i',strtotime($tag->nodeValue)); 
			if($tag = $elem->getElementsByTagName('content')->item(0))
				$feed[$cnt]['desc'] = strip_script1($tag->nodeValue);	
			if($tag = $elem->getElementsByTagName('comments')->item(0))
				$feed[$cnt]['comment'] = strip_script1($tag->nodeValue);	
			if($tag = $elem->getElementsByTagName('guid')->item(0))
				$feed[$cnt]['guid'] = strip_script1($tag->nodeValue);	
			if($tag = $elem->getElementsByTagName('content')->item(0))
				{$feed[$cnt]['content'] = strip_script1($tag->nodeValue);}
				if($feed[$cnt]['desc'])$feed[$cnt]['desc'] = substr($feed[$cnt]['desc'] , 0 , 1010)."...";
				if($feed[$cnt]['content'])$feed[$cnt]['content'] = substr($feed[$cnt]['content'] , 0 , 1010)."...";
			//$feed[$cnt]['desc'] = shortenText(strip_tags($tag->nodeValue),300);

			$inc = 0;
			while($parse = $elem->getElementsByTagName('link')->item($inc++)){
				$attr = $parse->attributes;
				if($attr->getNamedItem('type')->nodeValue=='text/html' && $attr->getNamedItem('rel')->nodeValue=='alternate'){
					$feed[$cnt]['link'] = $attr->getNamedItem('href')->nodeValue;
					//break;
				}
				if($attr->getNamedItem('type')->nodeValue=='image/jpeg'){
					$feed[$cnt]['thumb'] = $attr->getNamedItem('href')->nodeValue;
					//break;
				}
			}
			
			$cnt++;
		}
	}
	
	return $feed;
}

function shortenText1($text, $chars) {
	if($chars < strlen($text)){
		$text = substr($text,0,$chars);
		$text = $text."...";
	}
	return $text;
}

function strip_script1($string) {
    // Prevent inline scripting
    $string = eregi_replace("<script[^>]*>.*</script[^>]*>", "", $string);
    // Prevent linking to source files
    $string = eregi_replace("<script[^>]*>", "", $string);
    return $string;
}


?>
