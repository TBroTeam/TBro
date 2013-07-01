<?php

namespace webservices\queue;

require_once 'TranscriptDB/queue.lib.php';

class Job_program_databases extends \WebService {

    public function execute($queuedata) {
        return get_program_databases($queuedata['filter_string']);
    }

}

?>
