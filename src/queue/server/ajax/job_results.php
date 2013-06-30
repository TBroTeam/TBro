<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'queue.lib.php';

die(
        json_encode(
                get_job_results($_REQUEST['job_id'])
        )
);
?>
