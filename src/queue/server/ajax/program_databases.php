<?php

require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'queue.lib.php';

die(
        json_encode(
                get_program_databases()
        )
);
?>
