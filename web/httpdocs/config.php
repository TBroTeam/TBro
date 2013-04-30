<?php
define('APPPATH', '/httpdocs/');
define('SERVICEPATH', '/httpdocs/ajax');

define('OPENID_DOMAIN', 'localhost');

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/s202139/git/web/includes');

define('DB_SERVER', '132.187.22.155');
define('DB_USERNAME', 's202139');
define('DB_PASSWORD', 's202139');
define('DB_DB', 'dionaea_transcript_db_dev');

if (isset($_REQUEST['DEBUG']))
    define('DEBUG', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
