<?php
require_once(dirname(__FILE__).'/../../conf/memcache.conf.php');

class MemClient {
	public static function get($key) {
		global $memcache;
		if($memcache)
			return $memcache->get($key);
	}
	
	public static function set($key, $obj, $compress = false, $expire = 600) {
		global $memcache;
		if($memcache)
			$memcache->set($key, $obj, $compress, $expire);
	}
	
	public static function delete($key, $timeout = false) {
		global $memcache;
		if($timeout) {
			if($memcache)
				$memcache->delete($key, $timeout);
		}
		else {
			if($memcache)
				$memcache->delete($key);
		}
	}
}

?>
