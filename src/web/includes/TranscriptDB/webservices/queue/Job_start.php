<?php

namespace webservices\queue;

require_once 'TranscriptDB/queue.lib.php';

/**
 * Web Service.
 * Creates a new job.
 */
class Job_start extends \WebService {

    /**
     * @inheritDoc
     * @param Array $querydata
     * @param Array $querydata['job']
     * @param String $querydata['job']['type']
     * @param String $querydata['job']['query']
     * @param String $querydata['job']['additional_data']
     * @param String $querydata['job']['database']
     * @param Array $querydata['job']['parameters']
     */
    public function execute($querydata) {
        $job = $querydata['job'];
//decide if we're going to query against a protein or nucleotide database 
        $type = ($job['type'] == 'blastp' || $job['type'] == 'tblastn') ? 'prot' : 'nucl';
        try {
//split our fasta into single independent queries
            $queries = split_fasta($job['query'], $type);
        } catch (\Exception $e) {
            return array('status' => 'error', 'message' => $e->getMessage());
        }


//serializes the additional_data array into a string. this array will be passen into and out of the database for later use
//store additional information for your job here
        $additional_data = isset($job['additional_data']) ? $job['additional_data'] : array();

//execute job
        return create_job($job['type'], $job['database'], $additional_data, $job['parameters'], $queries);
    }

}
?>

