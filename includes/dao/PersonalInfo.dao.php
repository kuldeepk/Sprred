<?php

require_once dirname(__FILE__)."/../db/UserMeta.db.php";

class PersonalInfoDAO
{

	private $userID = null;
	private $sex = null;
	private $birthDate = null;
	private $birthMonth = null;
	private $birthYear = null;
	private $hometown = null;
	private $aboutMe = null;
	private $relationshipStatus = null;
	private $hobbies = null;
	private $music = null;
	private $movies = null;
	private $books = null;
		
	function PersonalInfoDAO($user_id) {
		$this->userID = $user_id;
	}
	
	function setSex($sex) {
		MemClient::delete("sex-". $this->userID);
		$this->sex = null;
		return UserMetaDB::setMeta($this->userID, 'sex', $sex);
	}
	
	function getSex() {
		if($this->sex){
			return $this->sex;
		} elseif($result=MemClient::get("sex-". $this->userID)){
			$this->sex = $result;
			return $this->sex;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'sex');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("sex-". $this->userID, $result, false, 2592000);
				$this->sex = $result;
				return $this->sex;
			}
		}
	}
	
	function setBirthDate($birthDate) {
		MemClient::delete("birthDate-". $this->userID);
		$this->birthDate = null;
		return UserMetaDB::setMeta($this->userID, 'birthDate', $birthDate);
	}
	
	function getBirthDate() {
		if($this->birthDate){
			return $this->birthDate;
		} elseif($result=MemClient::get("birthDate-". $this->userID)){
			$this->birthDate = $result;
			return $this->birthDate;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'birthDate');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("birthDate-". $this->userID, $result, false, 2592000);
				$this->birthDate = $result;
				return $this->birthDate;
			}
		}
	}
	
	function setBirthMonth($birthMonth) {
		MemClient::delete("birthMonth-". $this->userID);
		$this->birthMonth = null;
		return UserMetaDB::setMeta($this->userID, 'birthMonth', $birthMonth);
	}
	
	function getBirthMonth() {
		if($this->birthMonth){
			return $this->birthMonth;
		} elseif($result=MemClient::get("birthMonth-". $this->userID)){
			$this->birthMonth = $result;
			return $this->birthMonth;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'birthMonth');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("birthMonth-". $this->userID, $result, false, 2592000);
				$this->birthMonth = $result;
				return $this->birthMonth;
			}
		}
	}
	
	function setBirthYear($birthYear) {
		MemClient::delete("birthYear-". $this->userID);
		$this->birthYear = null;
		return UserMetaDB::setMeta($this->userID, 'birthYear', $birthYear);
	}
	
	function getBirthYear() {
		if($this->birthYear){
			return $this->birthYear;
		} elseif($result=MemClient::get("birthYear-". $this->userID)){
			$this->birthYear = $result;
			return $this->birthYear;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'birthYear');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("birthYear-". $this->userID, $result, false, 2592000);
				$this->birthYear = $result;
				return $this->birthYear;
			}
		}
	}
	
	function setHometown($hometown) {
		MemClient::delete("hometown-". $this->userID);
		$this->hometown = null;
		return UserMetaDB::setMeta($this->userID, 'hometown', $hometown);
	}
	
	function getHometown() {
		if($this->hometown){
			return $this->hometown;
		} elseif($result=MemClient::get("hometown-". $this->userID)){
			$this->hometown = $result;
			return $this->hometown;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'hometown');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("hometown-". $this->userID, $result, false, 2592000);
				$this->hometown = $result;
				return $this->hometown;
			}
		}
	}
	
	function setAboutMe($aboutMe) {
		MemClient::delete("aboutMe-". $this->userID);
		$this->aboutMe = null;
		return UserMetaDB::setMeta($this->userID, 'aboutMe', $aboutMe);
	}
	
	function getAboutMe() {
		if($this->aboutMe){
			return $this->aboutMe;
		} elseif($result=MemClient::get("aboutMe-". $this->userID)){
			$this->aboutMe = $result;
			return $this->aboutMe;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'aboutMe');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("aboutMe-". $this->userID, $result, false, 2592000);
				$this->aboutMe = $result;
				return $this->aboutMe;
			}
		}
	}
	
	function setHobbies($hobbies) {
		MemClient::delete("hobbies-". $this->userID);
		$this->hobbies = null;
		return UserMetaDB::setMeta($this->userID, 'hobbies', $hobbies);
	}
	
	function getHobbies() {
		if($this->hobbies){
			return $this->hobbies;
		} elseif($result=MemClient::get("hobbies-". $this->userID)){
			$this->hobbies = $result;
			return $this->hobbies;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'hobbies');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("hobbies-". $this->userID, $result, false, 2592000);
				$this->hobbies = $result;
				return $this->hobbies;
			}
		}
	}
	
	function setFavMusic($music) {
		MemClient::delete("music-". $this->userID);
		$this->music = null;
		return UserMetaDB::setMeta($this->userID, 'music', $music);
	}
	
	function getFavMusic() {
		if($this->music){
			return $this->music;
		} elseif($result=MemClient::get("music-". $this->userID)){
			$this->music = $result;
			return $this->music;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'music');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("music-". $this->userID, $result, false, 2592000);
				$this->music = $result;
				return $this->music;
			}
		}
	}
	
	function setFavMovies($movies) {
		MemClient::delete("movies-". $this->userID);
		$this->movies = null;
		return UserMetaDB::setMeta($this->userID, 'movies', $movies);
	}
	
	function getFavMovies() {
		if($this->movies){
			return $this->movies;
		} elseif($result=MemClient::get("movies-". $this->userID)){
			$this->movies = $result;
			return $this->movies;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'movies');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("movies-". $this->userID, $result, false, 2592000);
				$this->movies = $result;
				return $this->movies;
			}
		}
	}
	
	function setFavBooks($books) {
		MemClient::delete("books-". $this->userID);
		$this->books = null;
		return UserMetaDB::setMeta($this->userID, 'books', $books);
	}
	
	function getFavBooks() {
		if($this->books){
			return $this->books;
		} elseif($result=MemClient::get("books-". $this->userID)){
			$this->books = $result;
			return $this->books;
		} else {
			$result = UserMetaDB::getMetaValue($this->userID, 'books');	
			if(is_null($result))
				return null;
			else {
				MemClient::set("books-". $this->userID, $result, false, 2592000);
				$this->books = $result;
				return $this->books;
			}
		}
	}

}

?>