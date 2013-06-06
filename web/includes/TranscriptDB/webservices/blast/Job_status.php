<?php

namespace webservices\blast;

use \PDO as PDO;

class Job_status extends \WebService {

    public function execute($querydata) {
        try {
            $blast_db = connect_blast_db();

            $job_uuid = $querydata['query1'];

            $stm_job_status = $blast_db->prepare(<<<EOF
SELECT organism_common_name, release_name, job_status, queue_position, queue_length
FROM blast_cron_jobs j 
LEFT JOIN (
	SELECT job_id, row_number() OVER (PARTITION BY job_status ORDER BY job_creation_time ASC) AS queue_position
	FROM blast_cron_jobs WHERE job_status='NOT PROCESSED'
	) AS stats ON (j.job_id = stats.job_id),
(SELECT COUNT(*) AS queue_length FROM blast_cron_jobs WHERE job_status='NOT PROCESSED') cnt
WHERE job_uuid=?
EOF
            );
            $stm_job_status->execute(array($job_uuid));
            $job_status = $stm_job_status->fetch(\PDO::FETCH_ASSOC);
            switch ($job_status['job_status']) {
                case 'PROCESSING':
                    return array('job_status' => $job_status['job_status']);
                    break;
                case 'NOT PROCESSED':
                    return $job_status;
                    break;
                case 'ERROR':                
                case 'PROCESSED':
                    $stm_job_results = $blast_db->prepare('SELECT results_xml FROM blast_cron_jobs LEFT JOIN blast_cron_jobs_results ON (blast_cron_jobs.job_id = blast_cron_jobs_results.job_id) WHERE job_uuid=?');
                    $stm_job_results->execute(array($job_uuid));
                    return array('job_status' => $job_status['job_status'],
                        'job_results' => $stm_job_results->fetchColumn(),
                        'organism_name' => $job_status['organism_common_name'],
                        'release' => $job_status['release_name'],
                    );
                    break;
            }

            return array('job_status' => 'UNKNOWN');
        } catch (\PDOException $e) {
            return array('job_status' => 'UNKNOWN');
        }
    }

}

?>