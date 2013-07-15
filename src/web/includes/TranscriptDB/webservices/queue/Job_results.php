<?php

namespace webservices\queue;

require_once 'TranscriptDB/queue.lib.php';

/**
 * Web Service.
 * Returns job results for job with uid $querydata['jobid']
 */

class Job_results extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        return get_job_results($querydata['jobid']);
    }

}

?>
