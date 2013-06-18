<?php

require_once __DIR__ . '/cfg/config.php';

try {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

    $statement_jobresults = $pdo->prepare('SELECT * FROM get_job_results(?);');
    $statement_jobresults->execute(array($_REQUEST['jobid']));
    $res = array();
    while ($row = $statement_jobresults->fetch(PDO::FETCH_ASSOC)) {
        if (empty($res)) {
            $res['job_status'] = $row['status'];
            $res['additional_data'] = json_decode($row['additional_data']);
            if ($row['status'] == 'NOT_PROCESSED') {
                $statement_queuepos = $pdo->prepare('SELECT * FROM get_queue_position(?);');
                $statement_queuepos->execute(array($_REQUEST['jobid']));
                $pos = $statement_queuepos->fetch(PDO::FETCH_ASSOC);
                $res['queue_position'] = $pos['queue_position'];
                $res['queue_length'] = $pos['queue_length'];
            }
        }
        $res['processed_results'][] = array(
            'query' => $row['query'],
            'status' => $row['query_status'],
            'result' => $row['query_stdout'],
            'error' => $row['query_stderr']
        );
    }
    die(json_encode($res));
} catch (\PDOException $e) {
    throw $e;
}
?>
