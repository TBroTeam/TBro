<?php
define('APPPATH', '/httpdocs');
define('SERVICEPATH', '/httpdocs/ajax');

define('OPENID_DOMAIN', 'localhost');

define('CFG_SMARTY_DIR', '/path/to/web/smarty/');
set_include_path(get_include_path() . PATH_SEPARATOR . '/path/to/web/includes/');

define('DB_SERVER', 'localhost');
define('DB_USERNAME', 'root');
define('DB_PASSWORD', '');
define('DB_DB', 'mydb');

define('DEFAULT_ORGANISM', 1);
define('DEFAULT_RELEASE', 'test');

if (isset($_REQUEST['DEBUG']))
    define('DEBUG', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
