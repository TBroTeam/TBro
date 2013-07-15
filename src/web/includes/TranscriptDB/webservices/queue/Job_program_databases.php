<?php

namespace webservices\queue;

require_once 'TranscriptDB/queue.lib.php';

/**
 * Web Service. Returns possible program/database combinations, based on $querydata['filter_string'].
 * filter_string might be &lt;organims_id&gt;_&lt;release_name&gt;
 */
class Job_program_databases extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        return get_program_databases($querydata['filter_string']);
    }

}

?>
