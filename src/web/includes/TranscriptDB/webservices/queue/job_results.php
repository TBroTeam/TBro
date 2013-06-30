<?php

namespace webservices\queue;

require_once 'TranscriptDB/queue.lib.php';

class Job_results extends \WebService {

    public function execute($querydata) {
        return get_job_results($querydata['jobid']);
    }

}

?>
