<?php

require_once '${config_dir}/config.php';

function connect_queue_db() {
    $pdo = new \PDO(QUEUE_DB_CONNSTR, QUEUE_DB_USERNAME, QUEUE_DB_PASSWORD, array(\PDO::ATTR_PERSISTENT => true, \PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(\PDO::ATTR_ERRMODE, \PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

?>
