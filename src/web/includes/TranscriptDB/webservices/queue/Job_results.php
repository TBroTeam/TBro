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
        if (isset($querydata['xmlonly'])) {
            $this->printXML($querydata);
        } else {
            return get_job_results($querydata['jobid']);
        }
    }

    private function printXML($querydata) {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"blast_result.xml\";");
        header("Content-Transfer-Encoding: binary");
        $jobres = get_job_results($querydata['jobid']);
        echo $jobres['processed_results'][$querydata['query_index']]['result'];
        //die or WebService->output will attach return value to output (in our case: null)
        die();
    }

}

?>
