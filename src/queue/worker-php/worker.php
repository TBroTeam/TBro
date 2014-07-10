#!/usr/bin/php
<?php
chdir(__DIR__);

require_once('functions.php');

if ($argc !== 2)
    die("This command has to be called with exactly one(!) parameter: the path to the config file.\n");

$configfile = $argv[1];

set_error_handler("myErrorHandler");

if (!stream_resolve_include_path($configfile))
    die(sprintf("Missing config file: %s\n", $configfile));
require_once $configfile;


$supported_programs = unserialize(SUPPORTED_PROGRAMS);
$supported_programs_qmarks = implode(',', array_fill(0, count($supported_programs), '?'));

while (true) {
    // check if child processes are already terminated
    $child_pid = pcntl_wait($child_status, WNOHANG);
    if ($child_pid == -1)
    {
       // Error during waitpid!
    } else if ($child_pid == 0)
    {
       // No child finished
    } else 
    {
       // Child with pid $child_pid finished
    }  
      
    $pdo = pdo_connect();
    $stm_get_job = $pdo->prepare('SELECT * FROM request_job(?, ?, ARRAY[' . $supported_programs_qmarks . '])');
    $stm_get_job->execute(array_merge(array(MAX_FORKS, HOSTNAME), array_keys($supported_programs)));
    if ($stm_get_job->rowCount() > 0) {
        $job = $stm_get_job->fetch(PDO::FETCH_ASSOC);
        /* we don't want fork to mess with our pdo object. this will cause trouble. */
        unset($pdo, $stm_get_job);

        //works with unix systems
        if (function_exists('pcntl_fork')) {
            $pid = pcntl_fork();
            if ($pid == -1) {
                die('forking failed! quitting.');
            } else if ($pid) {
                //try if we can get another job
                continue;
            } else {
                include "worker-thread.php";
            }
        } 
        //we are in windows, try it a different way
        else {
            $tmpfile = tempnam(sys_get_temp_dir(), "worker");
            file_put_contents($tmpfile, serialize(array('job'=>$job, 'configfile'=>$configfile)));
            exec(sprintf('psexec -d php.exe worker-thread.php "%s"', $tmpfile));
        }
    } else {
        // After discussion with Lenz we detected this code snipped causing open database connections... Therefore, I close the connection first
      	$pdo = null;
        usleep(5 * 1000 * 1000);
    }
}


//handles only E_USER_NOTICE, rest is still handled my php
function myErrorHandler($errno, $errstr, $errfile, $errline)
{
    if (!(error_reporting() & $errno)) {
        // This error code is not included in error_reporting
        return;
    }
    if ($errno == E_USER_NOTICE){
        printf("Notice: %s in %s on line %d\n", $errstr, $errfile, $errline);
        //php should no more handle this
        return true;
    }
    //let php handle this
    return false;
}
?>