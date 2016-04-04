<?php
// this is the default file
// please copy to config.php and adjust carefully before executing tests
// make sure to never set the constants to your production database (otherwise it will be cleared)

//chado test database
define('DB_ADAPTER','pgsql');
define('DB_HOST','localhost');
define('DB_PORT','5432');
define('DB_DBNAME','testchado');
define('DB_CONNSTR', 'pgsql:host='.DB_HOST.';dbname='.DB_DBNAME.';port='.DB_PORT);
define('DB_USERNAME', 'postgres');
define('DB_PASSWORD', '');
?>
