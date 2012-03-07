<?php
	require_once (dirname(__FILE__).'/simplepie.inc');
	require_once (dirname(__FILE__).'/simplepie_feedburner.inc');
  	
	function feeds_meta($url)
	{
	$feed = new SimplePie();
	$feed->set_feed_url($url);

	$feed->enable_cache(false);
	//$feed->set_cache_duration(300);
	$feed->init();
	$feed->handle_content_type();
	$max=$feed->get_item_quantity();

	$meta['link']=$feed->get_permalink();
	$meta['title']=$feed->get_title();
	$meta['language']=$feed->get_language();
	$meta['favicon']=$feed->get_favicon();
	$meta['desc']=$feed->get_description();
	if($meta['desc'])$meta['desc'] = shortenText(strip_tags($posts[$i]['desc']), 180);


	return $meta;
	}
	
	function posts_data($url)
	{
		$feed = new SimplePie();
		$feed->set_feed_url($url);
	
		$feed->enable_cache(false);
		//$feed->set_cache_duration(300);
		$feed->set_item_class('SimplePie_Item_FeedBurner');
		
		$feed->init();
		$feed->handle_content_type();
		$max=$feed->get_item_quantity();
		
		$i=0;
		foreach ($feed->get_items(0,$max) as $item)
		{
			$posts[$i]['desc']=$item->get_description();
			$posts[$i]['title']=$item->get_title();
			if($link = $item->get_original_url())
				$posts[$i]['post_link']=$link;
			else
				$posts[$i]['post_link']=$item->get_permalink();
			$posts[$i]['pub_time']=$item->get_date(U);// taking the pubtime in unix timestamp
			$posts[$i]['content']=$item->get_content();
			if($image[$i] = returnImage($posts[$i]['content'])){
				$image[$i] = scrapeImage($image[$i]);
				$image[$i] = urldecode($image[$i]);
				$size = getimagesize($image[$i]);
				if($size[0]*$size[1]>1600 && $size[0]>20 && $size[1]>20)
					$posts[$i]['thumbnail']=$image[$i];
				else
					$posts[$i]['thumbnail']=NULL;
			}
			else
				$posts[$i]['thumbnail']=NULL;
			
			$tags = null;
			if($category = $item->get_categories())
				foreach($category as $tag){
					str_replace(',', ' ', $tag->term);
					if($tags)
						$tags = $tags.",".$tag->term;
					else
						$tags = $tag->term;
				}
			$posts[$i]['tags'] = $tags;
			
			if($posts[$i]['desc'])$posts[$i]['desc'] = shortenText(strip_tags($posts[$i]['desc']), 180);
			if($posts[$i]['content'])$posts[$i]['content'] = shortenText(strip_script($posts[$i]['content']), 1010);
			
			$i++;
		}		
		return $posts;
}

function getLanguage($url){
	$feed = new SimplePie();
	$feed->set_feed_url($url);

	$feed->enable_cache(false);
	$feed->init();
	$feed->handle_content_type();

	$language=$feed->get_language();
	return $language;
}

function returnImage ($text) {
	$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
	$pattern = "/<img[^>]+\>/i";
	preg_match($pattern, $text, $matches);
	$text = $matches[0];
	return $text;
}

////////////////////////////////////////////////////////////////
//Filter out image url only

function scrapeImage($text) {

$pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';

preg_match($pattern, $text, $link);

$link = $link[1];
$link = urlencode($link);
return $link;

}
?>
