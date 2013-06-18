#!/usr/bin/php
<?php
if ($argc !== 2)
    die('This command has to be called with exactly one(!) parameter: the path to the config file.');

$configfile = $argv[1];

if (!stream_resolve_include_path($configfile))
    die(sprintf("Missing config file: %s\n", $configfile));
require_once $configfile;


$supported_programs = unserialize(SUPPORTED_PROGRAMS);
$supported_programs_qmarks = implode(',', array_fill(0, count($supported_programs), '?'));

//TODO get rid of DB orphans

while (true) {
    $pdo = pdo_connect();
    $stm_get_job = $pdo->prepare('SELECT * FROM request_job(?, ?, ARRAY[' . $supported_programs_qmarks . '])');
    $stm_get_job->execute(array_merge(array(MAX_FORKS, HOSTNAME), array_keys($supported_programs)));
    if ($stm_get_job->rowCount() > 0) {
        $new_job = $stm_get_job->fetch(PDO::FETCH_ASSOC);
        /* we don't want fork to mess with our pdo object. this will cause trouble. */
        unset($pdo, $stm_get_job);
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('forking failed! quitting.');
        } else if ($pid) {
            //try if we can get another job
            continue;
        } else {
            execute_job($new_job);
            global $return_value;
            exit($return_value);
        }
    } else {
        usleep(5 * 1000 * 1000);
    }
}

function pdo_connect() {
    require_once '../../cli/src/shared/libs/loggedPDO/PDO.php';
    $pdo = new \LoggedPDO\PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false),
                    Log::factory('console', '', 'PDO'));
    return $pdo;
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => false, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

//job: (job_query_id integer, programname varchar, parameters varchar, query text, max_lifetime integer)
function execute_job($job) {
    $pdo = pdo_connect();
    $pdo->prepare('SELECT report_job_pid(?,?)')->execute(array($job['job_query_id'], posix_getpid()));
    global $job_id;
    $job_id = $job['job_query_id'];
    register_shutdown_function(finish_job);
    global $end_time;
    $end_time = microtime(true) + $job['max_lifetime'];
    declare(ticks = 10); //every 10 microactions, call the tick handler to check for timeout
    register_tick_function(function () {
                global $end_time;
                if ($end_time < microtime(true)) {
                    exit(-1);
                }
            });
    $supported_programs = unserialize(SUPPORTED_PROGRAMS);
    $cmd = $supported_programs[$job['programname']];
    $cmd.= ' ' . $job['parameters'];
    $cmd = str_replace('$DBFILE', '13_test.fasta', $cmd);
    execute_command(DATABASE_BASEDIR, $cmd, $job['query']);
}

function execute_command($cwd, $cmd, $query) {
    echo "\nwill execute $cmd\n";
    echo "query sequence is \n$query\n";

    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin 
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w")  // stderr
    );

    $pipes = array();

    global $process;
    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd);

    if (is_resource($process)) {
        //this is global so it can be accessed by signal handler
        global $stdout_collected, $stderr_collected, $return_value;
        $return_value = -1; //error, may be set to 0 on clean exit
        $stdout_collected = $stderr_collected = '';

        fwrite($pipes[0], $query);
        fclose($pipes[0]);

        while (true) {
            $read = array($pipes[1], $pipes[2]);
            if (($x = stream_select($read, $write = NULL, $except = NULL, 1, 200000)) > 0) {
                foreach ($read as $pipe) {
                    switch ($pipe) {
                        case $pipes[1]:
                            $stdout_collected .= fgets($pipe);
                            break;
                        case $pipes[2]:
                            $stderr_collected .= fgets($pipe);
                            break;
                    }
                }
            }
            if (isset($status) && !$status['running']) {
                $return_value = $status['exitcode'];
                break;
            }

            $status = proc_get_status($process);
        }
        fclose($pipes[1]);
        fclose($pipes[2]);

        proc_close($process);

        if (strpos($cmd, 'blast') !== FALSE) {
            // hotfix for a blast error in blast < 2.2.27 concerning * in the database, which will return a 0xff,
            // which itself will break XML parsing
            // https://github.com/yannickwurm/sequenceserver/issues/87
            // more on this here: http://blastedbio.blogspot.co.uk/2012/08/stop-breaking-ncbi-blast-searches.html
            $stdout_collected = strtr($stdout_collected, sprintf('%c', 0xff), 'X');
        }
    }
}

function finish_job() {
    global $job_id, $stdout_collected, $stderr_collected, $return_value;

    //don't leave any processes orphaned
    global $process;
    if (is_resource($process)) {
        $status = proc_get_status($process);
        if ($status['running'] == true) {
            proc_terminate($process);
        }
    }
    pdo_connect()->prepare('SELECT report_job_result(?,?,?,?);')->execute(array($job_id, $return_value, $stdout_collected, $stderr_collected));
}
?>