<?php
define('APPPATH', '');
define('SERVICEPATH', '/ajax');

define('OPENID_DOMAIN', 'localhost');

define('DB_ADAPTER','pgsql');
define('DB_CONNSTR', 'pgsql:host=localhost;dbname=dionaea_transcript_db_dev');
define('DB_USERNAME', 's202139');
define('DB_PASSWORD', 's202139');

//database connection for the "blast-cron" database
define('QUEUE_DB_CONNSTR', 'pgsql:host=localhost;port=6543;dbname=dionaea_transcript_db_dev');
define('QUEUE_DB_USERNAME', 's202139');
define('QUEUE_DB_PASSWORD', 's202139');

if (isset($_REQUEST['DEBUG']))
    define('DEBUG', true);

define('DEFAULT_ORGANISM', 13);
define('DEFAULT_RELEASE', 'test');

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
