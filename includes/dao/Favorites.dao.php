<?php

require_once(dirname(__FILE__).'/../db/Favorites.db.php');
require_once(dirname(__FILE__).'/../lib/ExploreDAO.php');


class FavoritesDAO
{

	function FavoritesDAO($postID, $userID) {
		$this->postID = $postID;	
		$this->userID = $userID;
	}


	function addFav(){
	
		if(!isFav()){
			$favID = $this->postId.$this->userID;
			if(FavoritesDB::addFav($favID, $this->postID, $this->userID)){
				$explore = new ExploreDAO($postID, 'fav');
				$explore -> addtoExplore();
				return 1;
			}
		}
		return 0;
	}

	
	function delFav(){
		$favID = $this->postID.$this->userID;
		FavoritesDB::delFav($favID);
			$explore = new ExploreDAO($postID, 'fav');
			$explore -> removeExplore();

	}

	
	function isFav(){
		if(FavoritesDB::isFav($this->postID, $this->userID))	
			return 1;		
	}


}
?>