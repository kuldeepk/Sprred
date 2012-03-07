<?php

require_once(dirname(__FILE__).'/../db/Comments.db.php');
require_once(dirname(__FILE__).'/../lib/utility.lib.php');
require_once(dirname(__FILE__).'/../lib/Explore.lib.php');

class CommentsDAO
{

	function CommentsDAO($post_id) {
		$this->postID = $post_id;	
	}
	
	function addComment($commentID, $userID, $comment, $parent = null) {
	
		$commentID = $this->postID.$userID.$time;
		$comment = Utility::shortenText($comment, 1020);
		
		$commentID = CommentsDB::addComment($commentID, $this->postID, $userID, $comment, $parent = null);	
		
		if ($commentID){
			$explore = new ExploreDAO($postID, 'comment');
			$explore -> addtoExplore();
		}
		return $commentID;
	
	}

	
	function getComments(){
	
		return CommentsDB::getComments($this->postID);	
	
	}

	
	function countComment(){
	
		return CommentsDB::countComment($this->postID);
	}
	
	
	function delComment($commentID) {
	
		if (CommentsDB::delComment($commentID))
				$explore = new ExploreDAO($postID, 'comment');
				$explore -> removeExplore();
	
	}

}
?>