<?php

namespace webservices\blast;

use \PDO as PDO;

class Start_job extends \WebService {
    /*
     * $querydata = array(
     *   'blast_job' => array(
     *     'type' => 'blastp',
     *     'organism' => id,
     *     'release' => 'string' 
     *     'parameters' => array('-param'=>'value'),
     *     'query' => 'long fasta string'
     *   )
     * );
     */

    public function execute($querydata) {
        //TODO connect BLAST_DB
        global $db;
        $blast_db = connect_blast_db();

        $blastjob = $querydata['blast_job'];
        ksort($blastjob['parameters']);
        $md5 = md5(var_export($blastjob, true));

        $existing_job_stm = $blast_db->prepare('SELECT job_id, blast_type, organism_common_name, release_name, query FROM blast_cron_jobs WHERE job_md5=? AND job_status!=\'ERROR\'')->execute(array($md5));
        if ($existing_job_stm->row_count() > 0) {
            $existing_job = $existing_job_stm->fetch(\PDO::FETCH_ASSOC);

            //TODO verify if this is REALLY the correct job
            return array('job_id' => $existing_job['job_id']);
        }

        //TODO validation. not really necessary because it will be validated anyways on the blast host, but might be nice

        $organism_name = $db->prepare('SELECT common_name FROM organism WHERE organism_id=?')->execute(array($blastjob['organism']))->fetchColumn();
        if (!$organism_name)
            return array('job_id' => -1);

        $blast_db->beginTransaction();
        $stm_insert_job = $blast_db->prepare('INSERT INTO blast_cron_jobs (blast_type, organism_common_name, release_name, query, job_md5) VALUES (?,?,?,?,?) RETURNING job_id');
        $stm_insert_job->execute(array($blastjob['type'], $organism_name, $blastjob['release'], $blastjob['query'], $md5));
        $job_id = $stm_insert_job->fetchColumn();

        $stm_insert_param = $blast_db->prepare('INSERT INTO blast_cron_jobs_properties (job_id, property_name, property_value) VALUES (?,?,?)');
        foreach ($blastjob['parameters'] as $parameter => $value) {
            $stm_insert_param->execute(array($job_id, '-' . $parameter, $value));
        }
        $blast_db->commit();
        
        return $job_id;
    }

}

?>
