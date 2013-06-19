<?php

require_once __DIR__ . '/cfg/config.php';

try {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $stm = $pdo->prepare('SELECT * FROM get_programname_database()');
    $stm->execute();
    $ret = array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        $ret[$row['program_name']][] = $row['database_name'];
    }

    die(json_encode($ret));
} catch (\PDOException $e) {
    throw $e;
}
?>
