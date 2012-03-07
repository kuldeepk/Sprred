<?php

class Encode {
	
	static public function base64_url_encode($input) {
	    return strtr(base64_encode($input.'absurd_22'), '+/=', '-_~');
	}
	
	static public function base64_url_decode($input) {
	    return substr(base64_decode(strtr($input, '-_~', '+/=')), 0, -9);
	}
	
	static public function base64_pass_encode($input) {
	    return strtr(base64_encode($input.'funky_naussau23'), '+/=', '-_~');
	}
	
	static public function base64_pass_decode($input) {
	    return substr(base64_decode(strtr($input, '-_~', '+/=')), 0, -15);
	}
	
	static public function short($url){  
		$ch = curl_init();  
		$timeout = 5;  
		$id='kuldeepk';
		$api='R_fea6ffd914c2165939dc3c63e258f154';
		//echo 'http://api.bit.ly/v3/shorten&longUrl='.$url.'&x_apiKey='.$api;
		curl_setopt($ch,CURLOPT_URL,'http://api.bit.ly/v3/shorten?login='.$id.'&apiKey='.$api.'&longUrl='.urlencode($url).'&format=json');
		curl_setopt($ch,CURLOPT_RETURNTRANSFER,1);  
		curl_setopt($ch,CURLOPT_CONNECTTIMEOUT,$timeout);  
		$new_url = curl_exec($ch);  
		curl_close($ch);  
		$new_url=json_decode($new_url);
		return $new_url->data->url;
	}

}

?>
