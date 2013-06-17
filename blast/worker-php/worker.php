<?php

if ($argc !== 2)
    die('This command has to be called with exactly one(!) parameter: the path to the config file.');

$configfile = $argv[1];

if (!stream_resolve_include_path($configfile))
    die(sprintf("Missing config file: %s\n", $configfile));
require_once $configfile;

$pdo = pdo_connect();
$supported_programs = unserialize(SUPPORTED_PROGRAMS);
$supported_programs_qmarks = implode(',', array_fill(0, count($supported_programs), '?'));

$stm_get_job = $pdo->prepare('SELECT * FROM request_job(?, ?, ARRAY[' . $supported_programs_qmarks . '])');
while (true) {
    $stm_get_job->execute(array_merge(array(MAX_FORKS, HOSTNAME), array_keys($supported_programs)));
    if ($stm_get_job->rowCount() > 0) {
        $new_job = $stm_get_job->fetch(PDO::FETCH_ASSOC);
        $pid = pcntl_fork();
        if ($pid == -1) {
            die('forking failed! quitting.');
        } else if ($pid) {
            //try if we can get another job
            continue;
        } else {
            //we are in another pid, database connections don't get carried over to forks,
            //unset this so that we can't use it by accident.
            unset($pdo);
            execute_job($new_job);
        }
    } else {
        usleep(0.5 * 1000 * 1000);
    }
}

function pdo_connect() {
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    return $pdo;
}

//job: (job_query_id integer, programname varchar, parameters varchar, query text, max_lifetime integer)
function execute_job($job) {
    $pdo = pdo_connect();
    $pdo->prepare('SELECT report_job_pid(?,?)')->execute(array($job['job_query_id'], posix_getpid()));
    register_shutdown_function(function() {
                finish_job($pdo, $job['job_query_id']);
            });

    $supported_programs = unserialize(SUPPORTED_PROGRAMS);
    $cmd = $supported_programs[$job['programname']];
    $cmd.= ' ' . $job['parameters'];
    //TODO
    $cmd .=' -db 13_test.fasta';
    execute_command(BLAST_DATABASE_BASEDIR, $cmd, $job['query']);
}

function execute_command($cwd, $cmd, $query) {
    echo "\nwill execute $cmd\n";

    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin 
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "a")  // stderr
    );

    $pipes = array();

    global $process;
    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd);

    if (is_resource($process)) {
        $stdin = &$pipes[0];
        $stdout = &$pipes[1];
        $stderr = &$pipes[2];


        fwrite($stdin, $query);
        fclose($stdin);

        //this is global so it can be accessed by signal handler on SIGTERM etc.
        global $stdout_collected, $stderr_collected, $return_value;
        $stdout_collected = '';
        $stderr_collected = '';


        while (!feof($stdout) || !feof($stderr)) {
            $read = array($stdout, $stderr);
            $write = NULL;
            $except = NULL;
            if (@stream_select($read, $write, $except, 0, 200000) > 0) {
                if (in_array($stdout, $read))
                    $stdout_collected .= fgets($stdout);
                if (in_array($stderr, $read))
                    $stderr_collected .= fgets($stderr);
            }
        }
        fclose($stdout);
        fclose($stderr);

        $status = proc_get_status($process);
        $return_value = $status['exitcode'];
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

function finish_job($pdo, $job_id) {
    global $stdout_collected, $stderr_collected, $return_value;
    //don't leave any processes orphaned
    global $process;
    if (is_resource($process)) {
        $status = proc_get_status($process);
        if ($status['running'] == true) {
            proc_terminate($process);
        }
    }

    $pdo->prepare('SELECT report_job_result(?,?,?,?);')->execute(array($job_id, $return_value, $stdout_collected, $stderr_collected));
}
?>