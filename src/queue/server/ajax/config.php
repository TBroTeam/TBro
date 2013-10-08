<?php
//database connection for the "blast-cron" database
define('QUEUE_DB_CONNSTR', 'pgsql:host=${queue_db_host};dbname=${queue_db_name};port=${queue_db_port}');
define('QUEUE_DB_USERNAME', '${queue_db_username}');
define('QUEUE_DB_PASSWORD', '${queue_db_password}');

function connect_queue_db() {
    $pdo = new \PDO(QUEUE_DB_CONNSTR, QUEUE_DB_USERNAME, QUEUE_DB_PASSWORD, array(\PDO::ATTR_PERSISTENT => true, \PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

?>
