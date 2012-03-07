<?php

define("SIMPLE_NAMESPACE_FEEDBURNER", "http://rssnamespace.org/feedburner/ext/1.0");

	class SimplePie_Item_FeedBurner extends SimplePie_Item 
	{
		function get_original_url() {
		$data = $this->get_item_tags(SIMPLE_NAMESPACE_FEEDBURNER, 'origLink');
		return $data[0]['data'];
	}

}
?>
