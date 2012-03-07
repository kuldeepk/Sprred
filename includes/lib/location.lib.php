<?php

/* Include Files *********************/
require_once(dirname(__FILE__)."/geolocation/geolocation.class.php");
/*************************************/

class Location {
	
	public static function getInfo($ip_address){
		$geolocation = new geolocation(true);
		$geolocation->setTimeout(2);
		$geolocation->setIP($ip_address);
		$locations = $geolocation->getGeoLocation();
		$errors = $geolocation->getErrors();
		if (!empty($locations[0]) && is_array($locations[0])) {
			return $locations[0];
		} else 
			return null;
	}
}

?>