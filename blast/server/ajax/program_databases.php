<?php

require_once __DIR__ . '/cfg/config.php';

try {
    //connect to the database
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    //prepare our get_programname_database statement
    $stm = $pdo->prepare('SELECT * FROM get_programname_database()');
    //and execute it
    $stm->execute();
    $ret = array();
    while ($row = $stm->fetch(PDO::FETCH_ASSOC)) {
        //put the rows into an array
        $ret[$row['program_name']][] = $row['database_name'];
    }
    //and return it
    die(json_encode($ret));
} catch (\PDOException $e) {
    //on error, just return an empty json object
    die('{}');
}
?>
