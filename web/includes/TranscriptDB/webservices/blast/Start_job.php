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

    public function start_job($querydata) {
        //TODO put BLAST_DB connection string into config
        global $db;
        $blast_db = connect_blast_db();

        $blastjob = $querydata['blast_job'];

        $stm_organism_name = $db->prepare('SELECT common_name FROM organism WHERE organism_id=?');
        $stm_organism_name->execute(array($blastjob['organism']));

        $organism_name = $stm_organism_name->fetchColumn();
        if (!$organism_name)
            return -1;

        unset($blastjob['organism']);
        $blastjob['organism_name'] = $organism_name;
        $blastjob['query'] = trim($blastjob['query']);

        ksort($blastjob['parameters']);
        $md5 = md5(var_export($blastjob, true));

//TODO validation. not really necessary because it will be validated anyways on the blast host, but might be nice here too


        $blast_db->beginTransaction();
        //lock around all this to prevent multiple identical requests in very short time bypassing md5 test
        $blast_db->exec('LOCK TABLE blast_cron_jobs');

        $existing_job_stm = $blast_db->prepare('SELECT job_id, job_uuid, blast_type, organism_common_name, release_name, query FROM blast_cron_jobs WHERE job_md5=? AND job_status!=\'ERROR\'');
        $existing_job_stm->execute(array($md5));
        while ($existing_job = $existing_job_stm->fetch(\PDO::FETCH_ASSOC)) {
            $compObj = array(
                'type' => $existing_job['blast_type'],
                'organism_name' => $existing_job['organism_common_name'],
                'release' => $existing_job['release_name'],
                'parameters' => array(),
                'query' => $existing_job['query']
            );

            $stm_params = $blast_db->prepare('SELECT property_name, property_value FROM blast_cron_jobs_properties WHERE job_id=?');
            $stm_params->execute(array($existing_job['job_id']));
            while ($param = $stm_params->fetch(\PDO::FETCH_ASSOC)) {
                $parname = substr($param['property_name'], 1); //cut off the leading -
                $compObj['parameters'][$parname] = $param['property_value'];
            }

            if ($blastjob == $compObj) {
                $blast_db->commit();
                return $existing_job['job_uuid'];
            }
        }



        $stm_insert_job = $blast_db->prepare(<<<EOF
INSERT INTO blast_cron_jobs (job_uuid, blast_type, organism_common_name, release_name, query, job_md5) 
    (SELECT ?,?,?,?,?,? WHERE NOT EXISTS (
        SELECT job_uuid FROM blast_cron_jobs WHERE job_uuid=?
   )) RETURNING job_id
EOF
        );
        do {
            $uuid = uniqid();
            $stm_insert_job->execute(array($uuid, $blastjob['type'], $organism_name, $blastjob['release'], $blastjob['query'], $md5, $uuid));
        } while ($stm_insert_job->rowCount() == 0);


        $job_id = $stm_insert_job->fetchColumn();

        $stm_insert_param = $blast_db->prepare('INSERT INTO blast_cron_jobs_properties (job_id, property_name, property_value) VALUES (?,?,?)');
        foreach ($blastjob['parameters'] as $parameter => $value) {
            $stm_insert_param->execute(array($job_id, '-' . $parameter, $value));
        }
        $blast_db->commit();

        return $uuid;
    }

    public function execute($querydata) {
        return array('job_id' => $this->start_job($querydata));
        ;
    }

}

?>
