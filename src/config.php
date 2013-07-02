<?php
// the path to your web site. 
// if you are at the root dir of your domain, this can be an empty string.
// otherwise, use an url like http://example.com
define('APPPATH', '');
//just like above, just for the subfolder /ajax.
//either /ajax 
//or http://example.com/ajax
define('SERVICEPATH', '/ajax');
//the domain to use for openID authentification
define('OPENID_DOMAIN', 'example.com');

//chado database
define('DB_ADAPTER','pgsql');
define('DB_CONNSTR', 'pgsql:host=${chado_db_host};dbname=${chado_db_name};port=${chado_db_port}');
define('DB_USERNAME', '${chado_db_username}');
define('DB_PASSWORD', '${chado_db_password}');

//database connection for the "blast-cron" database
define('QUEUE_DB_CONNSTR', 'pgsql:host=${queue_db_host};dbname=${queue_db_name};port=${queue_db_port}');
define('QUEUE_DB_USERNAME', '${queue_db_username}');
define('QUEUE_DB_PASSWORD', '${queue_db_password}');

//when a user visits the page for the first time, these will be selected
define('DEFAULT_ORGANISM', 1);
define('DEFAULT_RELEASE', 'test_release');

//set error reporting to a level that suits you
error_reporting(E_ALL ^ E_STRICT ^ E_NOTICE);
ini_set('display_errors', '0');

//uncomment for debugging
//if (isset($_REQUEST['DEBUG']))
//    define('DEBUG', true);
//error_reporting(E_ALL );
//ini_set('display_errors', '1');


?>
