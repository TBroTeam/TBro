<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'queue.lib.php';

$job = $_REQUEST['job'];
//decide if we're going to query against a protein or nucleotide database 
$type = ($job['type'] == 'blastp' || $job['type'] == 'tblastn') ? 'prot' : 'nucl';
try {
//split our fasta into single independent queries
    $queries = split_fasta($job['query'], $type);
} catch (\Exception $e) {
    die(
            json_encode(
                    array('status' => 'error', 'message' => $e->getMessage())
            )
    );
}


//serializes the additional_data array into a string. this array will be passen into and out of the database for later use
//store additional information for your job here
$additional_data = isset($job['additional_data']) ? $job['additional_data'] : array();

//execute job
die(
        json_encode(
                create_job($job['type'], $job['database'], $additional_data, $job['parameters'], $queries)
        )
);
?>

