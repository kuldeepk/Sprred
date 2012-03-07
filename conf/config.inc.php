<?php

ini_set("display_errors", 1);

/**
 * Connect to the mysql database.
 */
$conn = mysql_connect("localhost", "root", "PASSWORD");
mysql_select_db('sprred', $conn);

/**
 * Select region specific SimpleDB domain
 */

define('DB_REGION', 'test_');
define('S3BUCKET', 'beta.sprred');

define('GA_WEB_ID', null);
define('GA_WEB_DOMAIN', '.sprred.com');

//SendGrid Configuration
define('MAIL_USERNAME', 'USERNAME');
define('MAIL_PASSWORD', 'PASSWORD');

define('FB_APP_ID', '');
define('FB_API_KEY', '');
define('FB_API_SECRET', '');

define('ZENCODER_API_KEY', '');
define('TEST_ENCODING', '1');

define('CACHE_PATH', dirname(__FILE__).'/../cache/');

?>