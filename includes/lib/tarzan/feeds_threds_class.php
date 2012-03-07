<?php
/**
 * PHP_Fork class usage examples
 * ==================================================================================
 * NOTE: In real world you surely want to keep each class into
 * a separate file, then include() it into your application.
 * For this examples is more useful to keep all_code_into_one_file,
 * so that each example shows a unique feature of the PHP_Fork framework.
 * ==================================================================================
 * feeds_threads_class.php
 * 
 * This is example to spawn threads to cron the feeds parallely ...
 * Simply create thread for every feedID and call to the function crawlFeedsforPosts().This class extends PHP_Fork, so we have
* multiple instances running cuncurrently.
 * ==================================================================================
 */
require_once("feedsMeta.php");
require_once("Fork.php");
class feeds_threads extends PHP_Fork
{
	var $feedLink;
	var $feedID;
	var $feedType;
	var $counter;
	function feeds_threads($name, $feedLink, $feedID ,$feedType)
	{
		$this->PHP_Fork($name);
		$this->counter = 0;
		$this->feedLink = $feedLink;
		$this->feedID = $feedID;
		$this->feedType = $feedType;
		$this->start();
		echo "Started" . $this->getName() . " with PID " . $this->getPid() . "...\n";
	}
	function run()
	{
		crawlFeedsMeta($this->feedID, $this->feedLink, $this->feedType);
	}
}
?>
