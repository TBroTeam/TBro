<?php

chdir(__DIR__);
//if job is set, we are forked via pcntl_fork()
//else we forked some obscure way to work on windows and have to read our job and configfile name back
if (!isset($job)) {
    extract(unserialize(file_get_contents($argv[1])));
}
require_once $configfile;
require_once 'functions.php';

execute_job($job);
global $return_value;
exit($return_value);


/* job: array(
 *   job_query_id integer,
 *   programname varchar, 
 *   parameters varchar, 
 *   query text, 
 *   max_lifetime integer,
 *   target_db varchar,
 *   target_db_md5 varchar,
 *   target_db_download_uri varchar
 * ) */

function execute_job($job) {
    trigger_error(sprintf("starting job id: %d", $job['running_query_id']), E_USER_NOTICE);
    global $die_on_timeout;
    global $job_id;
    $job_id = $job['running_query_id'];
    $pdo = pdo_connect();
    $pdo->prepare('SELECT report_job_pid(?,?)')->execute(array($job_id, getmypid()));
    //intitalize "parameters" for the tick function
    $end_time = microtime(true) + $job['max_lifetime'];
    $send_keepalive = true;
    $die_on_timeout = true;

    //closure to die on timeout and regularly send a keepalive to the server. will be installed as tick_function later on
    $die_or_keepalive = function() use (&$end_time, &$send_keepalive, &$die_on_timeout, &$pdo, &$job_id) {
                //did we time out? if yes, die
                if ($die_on_timeout && $end_time < microtime(true)) {
                    trigger_error("timed out, exiting", E_USER_NOTICE);
                    exit(-1);
                }
                static $next_keepalive = 0; //static. will be created on first function execution and then the value will be kept between executions
                //do we need to send another keepalive? go on!
                if ($send_keepalive && $next_keepalive < microtime(true)) {
                    //we don't want to prepare a statement on every execution, cache this as a function static
                    static $keepalive_statement = null;
                    if ($keepalive_statement == null)
                        $keepalive_statement = $pdo->prepare('SELECT keepalive_ping(?)');

                    trigger_error("sending keepalive", E_USER_NOTICE);
                    $keepalive_statement->execute(array($job_id));
                    $keepalive_timeout = $keepalive_statement->fetchColumn();
                    if ($keepalive_timeout == -1) {
                        //this is no longer our job. maybe we timed out, maybe our keepalive was too late.
                        //die the next time this gets executed and $die_on_timeout is set
                        $end_time = 0;
                        //no more keepalives
                        $send_keepalive = false;
                        trigger_error("returned -1, will die on next occasion", E_USER_NOTICE);
                    } else {
                        //send a keepalive 3 seconds before neccessary
                        $next_keepalive = microtime(true) + $keepalive_timeout - 3;
                        trigger_error(sprintf("next keepalive in %d seconds", $keepalive_timeout - 3), E_USER_NOTICE);
                    }
                }
            };
    register_tick_function($die_or_keepalive);
    declare(ticks = 10); //every 10 microactions, call the tick handler to check for timeout or the need of a keepalive
    $dbfile = acquire_database($job['target_db'], $job['target_db_md5'], $job['target_db_download_uri']);

    $supported_programs = unserialize(SUPPORTED_PROGRAMS);
    $program = $supported_programs[$job['programname']];
    if (strpos($program, DIRECTORY_SEPARATOR) !== 0)
        $program = __DIR__ . DIRECTORY_SEPARATOR . $program;
    //escape unescaped spaces
    $cmd = preg_replace('{([^\\\\]) }', '\\1\\\\ ', $program);
    $cmd.= ' ' . $job['parameters'];
    $cmd = str_replace('$DBFILE', $dbfile, $cmd);
    execute_command(DATABASE_BASEDIR, $cmd, $job['query']);
    report_results_cleanup();
}

/**
 * checks if database file already exists, if not downloads it from the server.
 * returns full path to database file
 * @param string $dbname "
 */
function acquire_database($target_db, $target_db_md5, $target_db_download_uri) {
    //prepend this file's directory if it's a relative path
    $basedir = DATABASE_BASEDIR;
    if (strpos($basedir, DIRECTORY_SEPARATOR) !== 0)
        $basedir = __DIR__ . DIRECTORY_SEPARATOR . $basedir;

    $db_dir = $basedir . DIRECTORY_SEPARATOR . $target_db . '.' . $target_db_md5;
    $db_file = $db_dir . DIRECTORY_SEPARATOR . $target_db;
    $lockfile = $db_dir . '.lock';
    //database directory exists and lock file has been removed, e.g. this is ready to use
    if (is_dir($db_dir) && !file_exists($lockfile)) {
        return $db_file;
    }
    if (file_exists($lockfile)) {
        //we are just waiting, not downloading. this can timeout
        //wait a sec
        usleep(1000 * 1000);
        //try again
        return acquire_database($target_db, $target_db_md5, $target_db_download_uri);
    }
    //we are downloading, do not die on timeout!
    global $die_on_timeout;
    $die_on_timeout = false;
    touch($lockfile);
    $download_file = $db_dir . '.download';
    printf('will download %s to %s', $target_db_download_uri, $download_file);
    try {
        mkdir($db_dir, 777, true);
        download($target_db_download_uri, $download_file);
        if ($target_db_md5 !== ($real_md5 = md5_file($download_file)))
            throw new Exception(sprintf('download md5 could not be validated. should be %s but was %s', $target_db_md5, $real_md5));
        unzip($download_file, $db_dir);
    } catch (Exception $e) {
        rmdir($db_dir);
        unlink($download_file);
        unlink($lockfile);
        throw $e;
    }
    unlink($download_file);
    unlink($lockfile);
    //download is ready, now we can die if we timed out in the meantime
    $die_on_timeout = true;

    return $db_file;
}

function download($uri, $target_file) {
    if (function_exists('curl_version')) {
        $fp = fopen($target_file, 'w+');
        $ch = curl_init($uri);
        curl_setopt($ch, CURLOPT_TIMEOUT, 50);
        curl_setopt($ch, CURLOPT_FILE, $fp);
        curl_setopt($ch, CURLOPT_FOLLOWLOCATION, true);

        curl_exec($ch);
        curl_close($ch);
        fclose($fp);
    } else {
        $out = array();
        $retcode = -1;
        exec('command -v wget', $out, $retcode);
        if ($retcode != 0) {
            throw new Exception('could neither find php-curl nor wget, could not download file');
        }
        $cmd = sprintf('command wget -O %2$s %1$s', escapeshellcmd($uri), escapeshellcmd($target_file));
        exec($cmd, $out);
    }
}

function unzip($zipfile, $target_dir) {
    $zip = new ZipArchive;
    if ($zip->open($zipfile) === TRUE) {
        $zip->extractTo($target_dir);
        $zip->close();
    }
    else
        throw new Exception(sprintf('problems opening zipfile %s', $zipfile));
}

function execute_command($cwd, $cmd, $query) {
    trigger_error("will execute $cmd", E_USER_NOTICE);
    trigger_error("query sequence is \n$query", E_USER_NOTICE);


    $descriptorspec = array(
        0 => array("pipe", "r"), // stdin 
        1 => array("pipe", "w"), // stdout
        2 => array("pipe", "w")  // stderr
    );

    $pipes = array();

    global $process;
    $process = proc_open($cmd, $descriptorspec, $pipes, $cwd, NULL, array('bypass_shell' => true));

    if (is_resource($process)) {
        //this is global so it can be accessed by signal handler
        global $stdout_collected, $stderr_collected, $return_value;
        $return_value = -1; //error, may be set to 0 on clean exit
        $stdout_collected = $stderr_collected = '';

        fwrite($pipes[0], $query);
        fclose($pipes[0]);

        while (true) {
            $status = proc_get_status($process);

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

function report_results_cleanup() {
    //don't leave any processes orphaned
    global $process;
    if (is_resource($process)) {
        $status = proc_get_status($process);
        if ($status['running'] == true) {
            proc_terminate($process);
        }
    }

    global $job_id, $stdout_collected, $stderr_collected, $return_value;
    pdo_connect()->prepare('SELECT report_job_result(?,?,?,?);')->execute(array($job_id, $return_value, $stdout_collected, $stderr_collected));
    
    trigger_error("reported processed job back", E_USER_NOTICE);
}

?>
