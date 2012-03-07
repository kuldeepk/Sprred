<?php
class Utility
{
	public static function time_since($original) {
	    $chunks = array(
	        array(60 * 60 * 24 * 365 , 'year'),
	        array(60 * 60 * 24 * 30 , 'month'),
	        array(60 * 60 * 24 * 7, 'week'),
	        array(60 * 60 * 24 , 'day'),
	        array(60 * 60 , 'hour'),
	        array(60 , 'minute'),
	    );
	    
	    $today = time();
	    $since = $today - $original;
	    
	    for ($i = 0, $j = count($chunks); $i < $j; $i++) {
	        $seconds = $chunks[$i][0];
	        $name = $chunks[$i][1];
	        if (($count = floor($since / $seconds)) != 0) {
	            break;
	        }
	    }
	    
	    $print = ($count == 1) ? '1 '.$name : "$count {$name}s";
		return $print;
		
	    /* For getting the second item
	     * 
	     * if ($i + 1 < $j) {
	        // now getting the second item
	        $seconds2 = $chunks[$i + 1][0];
	        $name2 = $chunks[$i + 1][1];
	        
	        // add second item if it's greater than 0
	        if (($count2 = floor(($since - ($seconds * $count)) / $seconds2)) != 0) {
	            $print .= ($count2 == 1) ? ', 1 '.$name2 : ", $count2 {$name2}s";
	        }
	    }
	    return $print; */
	}
	
	public static function makeslug($pslug) {
		$pslug = preg_replace('/\s+/', ' ', $pslug);
		$pslug = trim($pslug);
	    $pslug = explode(' ', $pslug);
		$pslug = implode(' ', array_slice($pslug, 0, 10));
		$pslug = substr($pslug, 0, 100);
		$pslug = preg_replace("/[^a-zA-Z0-9 ]/", "", $pslug);
		$pslug = preg_replace('/\s+/', ' ', $pslug);
		$pslug = trim($pslug);
		$pslug = str_replace(" ", "-", $pslug);
		$pslug = strtolower($pslug);
		return $pslug;
	}
	
	public static function shortenText($text, $chars) {
		if($chars < strlen($text)){
			$text = substr($text,0,$chars);
			$text = $text."...";
		}
		return $text;
	}
	
	public static function strip_script($string) {
	    // Prevent inline scripting
	    $string = eregi_replace("<script[^>]*>.*</script[^>]*>", "", $string);
	    // Prevent linking to source files
	    $string = eregi_replace("<script[^>]*>", "", $string);
	    return $string;
	}
	
	public static function returnImage ($text) {
		$text = html_entity_decode($text, ENT_QUOTES, 'UTF-8');
		$pattern = "/<img[^>]+\>/i";
		preg_match($pattern, $text, $matches);
		$text = $matches[0];
		return $text;
	}
	
	
	public static function scrapeImage($text) {
		$pattern = '/src=[\'"]?([^\'" >]+)[\'" >]/';
		preg_match($pattern, $text, $link);
		$link = $link[1];
		$link = urlencode($link);
		return $link;
	}

}
?>