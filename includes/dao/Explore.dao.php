<?php

require_once(dirname(__FILE__).'/../db/Explore.db.php');

class ExploreDAO
{

	function ExploreDAO($postID, $type) {
		$this->postID = $postID;	
		$this->type = $type;	
	}
	
	function addtoExplore() {
	
		return ExploreDB::addtoExplore($this->postID, $this->type);	
	
	}
	function removeExplore() {
	
		return ExploreDB::removeExplore($this->postID, $this->type);	
	
	}

}
?>