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

//database connection for the "blast-cron" database
define('BLAST_CRON_DB_CONNSTR', 'pgsql:host=127.0.0.1;dbname=blastdb');
define('BLAST_CRON_DB_USERNAME', 'root');
define('BLAST_CRON_DB_PASSWORD', '');

if (isset($_REQUEST['DEBUG']))
    define('DEBUG', true);

error_reporting(E_ALL);
ini_set('display_errors', '1');

?>
