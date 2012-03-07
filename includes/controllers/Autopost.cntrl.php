<?php

/* Include Files *********************/
require_once(dirname(__FILE__)."/../classes/Auth.class.php");
require_once(dirname(__FILE__)."/../dao/Connect.dao.php");
require_once(dirname(__FILE__)."/../db/Connect.db.php");
/*************************************/

class AutopostController
{

	function AutopostController() {
		$auth = new Auth();
		if(!$auth->checkLogin()){
			header('Location:/');
			exit(0);
		}
	}

}

?>