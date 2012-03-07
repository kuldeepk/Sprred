<?php
	if(class_exists(Memcache)){
		$memcache = new Memcache;
		$memcache->connect("localhost",11211);
	}
?>
