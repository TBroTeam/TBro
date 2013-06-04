<?php

function child_sig_handler($signo) {
    if ($signo == SIGTERM || $signo == SIGINT) {
        // call shutdown function, exit
        echo "child process receiving signal " . $signo == SIGTERM ? 'SIGTERM' : 'SIGINT' . "\n";
        exit(0);
    }
}

pcntl_signal(SIGTERM, "child_sig_handler");
pcntl_signal(SIGINT, "child_sig_handler");

register_shutdown_function(function() {
            global $db;
            global $error_message;

            //don't leave any blast processes that won't get evaluated anyways
            global $process;
            if (is_resource($process)) {
                $status = proc_get_status($process);
                if ($status['running'] == true) {
                    proc_terminate($process);
                    $error_message = 'Process has received TERM signal or timeout, exiting.';
                }
            }

            if (!empty($error_message)) {
                global $job_id;
                global $stdout_collected;

                $data = sprintf("---Error Messages---\n%s\n---Results so far---\n %s", $error_message, $stdout_collected);
                $db->prepare("UPDATE blast_cron_jobs SET job_status='ERROR' WHERE job_id = ?")->execute(array($job_id));
                $db->prepare("INSERT INTO blast_cron_jobs_results (job_id, results_xml) VALUES (?, ?)")->execute(array($job_id, $data));
            }

            $db->prepare('DELETE FROM blast_cron_jobs_running_pids WHERE pid=?')->execute(array(getmypid()));
        }
);

global $end_time;
$end_time = microtime(true) + BLAST_CRON_BLAST_MAX_EXECUTION_TIME;

// function called on every tick event. check for timeout
function tick_handler() {
    global $end_time;
    if ($end_time < microtime(true)) {
        echo 'script timeout!';
        exit(-1);
    }
}

require_once('blast_parameter_config.php');

declare(ticks = 10); //every 10 microactions, call the tick handler to check for timeout

register_tick_function('tick_handler');
global $db;
$jobdata = acquire_job();
$cmd = prepare_job($jobdata);
list($job_status, $job_stdout, $job_stderr) = handle_job($cmd, $jobdata);

if ($job_status == 'PROCESSED') {
    $db->prepare("UPDATE blast_cron_jobs SET job_status='PROCESSED', job_processing_finish_time=CURRENT_TIMESTAMP WHERE job_id = ?")->execute(array($jobdata['job_id']));
    $db->prepare("INSERT INTO blast_cron_jobs_results (job_id, results_xml) VALUES (?, ?)")->execute(array($jobdata['job_id'], $job_stdout));
} else {
    $data = sprintf("---Exit Code: %s---\n---STDERR---\n%s\n\n\n---STDOUT---\n%s", $job_status, $job_stderr, $job_stdout);
    $db->prepare("UPDATE blast_cron_jobs SET job_status='ERROR', job_processing_finish_time=CURRENT_TIMESTAMP WHERE job_id = ?")->execute(array($jobdata['job_id']));
    $db->prepare("INSERT INTO blast_cron_jobs_results (job_id, results_xml) VALUES (?, ?)")->execute(array($jobdata['job_id'], $data));
}
unregister_tick_function('tick_handler');

function acquire_job() {
    global $db;

    $db->beginTransaction();
    $db->exec('LOCK TABLE blast_cron_jobs');
    $stm = $db->query(<<<EOF
   UPDATE blast_cron_jobs 
   SET job_status='PROCESSING', job_processing_start_time=CURRENT_TIMESTAMP
   WHERE job_id = 
       (SELECT job_id FROM blast_cron_jobs WHERE job_status='NOT PROCESSED' ORDER BY job_creation_time ASC LIMIT 1) 
   RETURNING job_id, blast_type, organism_common_name, release_name, query
EOF
    );
    $db->commit();

    if ($stm->rowCount() == 0) {
        //there was nothing to do; maybe another process was faster racing for a job
        exit(0);
    }

    $row = $stm->fetch(\PDO::FETCH_ASSOC);
    global $job_id;
    $job_id = $row['job_id'];

    $db->prepare('UPDATE blast_cron_jobs_running_pids SET job_id=? WHERE pid=?')->execute(array($row['job_id'], getmypid()));

    return $row;
}

function prepare_job($jobdata) {
    global $db, $blast_parameter_config;
    if (!in_array($jobdata['blast_type'], array_diff(array_keys($blast_parameter_config), array('general')))) {
        global $error_message;
        $error_message = 'illegal blast type';
        exit(-1);
    }

    $paramconfig = array_merge($blast_parameter_config['general'], $blast_parameter_config[$jobdata['blast_type']]);
    $params = array();

    foreach ($paramconfig as $param => $value) {
        if (isset($value['default'])) {
            $params[$param] = $value['default'];
        }
    }

    $db_stm_params = $db->prepare('SELECT job_id, property_name, property_value FROM blast_cron_jobs_properties WHERE job_id=?');
    $db_stm_params->execute(array($jobdata['job_id']));

    while ($db_param = $db_stm_params->fetch(\PDO::FETCH_ASSOC)) {
        if (!isset($paramconfig[$db_param['property_name']]))
            continue;

        $cfg_param = $paramconfig[$db_param['property_name']];


        if (isset($cfg_param['test'])) {
            //test via callback specified in $paramconfig if the specified value may override the default
            if (call_user_func_array($cfg_param['test'], array_merge(array($db_param['property_value']), $cfg_param['test_additional_parameters']))) {
                $params[$db_param['property_name']] = $db_param['property_value'];
            } else {
                global $error_message;
                $error_message = sprintf('illegal parameter or value specified: %s %s', $db_param['property_name'], $db_param['property_value']);
                exit(-1);
            }
        }
    }

    $cmd = constant(strtoupper($jobdata['blast_type']));

    if (!preg_match('{^\w+$}', $jobdata['organism_common_name']) || !preg_match('{^\w+$}', $jobdata['release_name'])) {
        global $error_message;
        $error_message = 'release name or organism name not valid';
        exit(-1);
    }

    $cmd .= sprintf(' -db %s/%s_%s.fasta', BLAST_DATABASE_BASEDIR, $jobdata['organism_common_name'], $jobdata['release_name']);

    foreach ($params as $param => $value) {
        $cmd.=sprintf(' %s %s', $param, $value);
    }

    return $cmd;
}

function handle_job($cmd, $jobdata) {
    echo "\033[43m" . "\nwill execute $cmd\n" . "\033[0m";

    $errfile = tempnam('sys_get_temp_dir', 'runblast_pipe_stderr');
    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin 
        1 => array("pipe", "w"), // stdout
        2 => array("file", $errfile, "a")  // stderr
    );

    $cwd = BLAST_DATABASE_BASEDIR;
    $pipes = array();

    global $process;
    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd);

    if (is_resource($process)) {

        fwrite($pipes[0], $jobdata['query']);
        fclose($pipes[0]);

        //this is global so it can be accessed by signal handler
        global $stdout_collected;
        $stdout_collected = '';



        while (!feof($pipes[1])) {
            $read = array($pipes[1]);
            $write = NULL;
            $except = NULL;
            if (@stream_select($read, $write, $except, 0, 200000) > 0) {
                $stdout_collected .= fgets($pipes[1]);
            }
        }
        fclose($pipes[1]);

        $return_value = proc_close($process);

        if ($return_value == 0) {
            return array('PROCESSED', $stdout_collected, '');
        } else {
            $errcontents = file_get_contents($errfile);
            return array($return_value, $stdout_collected, $errcontents);
        }
        echo "command returned $return_value\n";
    }
}

?>
