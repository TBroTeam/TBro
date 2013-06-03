<?php

//if we are in a phar archive, this has been set by the stub
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . "/");
    define('SHARED', __DIR__ . "/../shared/");
}

if ($argc !== 2)
    die('This command has to be called with exactly one(!) parameter: the path to the config file.');

$configfile = $argv[1];

if (!stream_resolve_include_path($configfile))
    die(sprintf("Missing config file: %s\n", $configfile));
require_once $configfile;

connect_db();

$stm_get_pids = $db->prepare('SELECT running_job_id, pid FROM blast_cron_jobs_running_pids');
$stm_delete_pid = $db->prepare('DELETE FROM blast_cron_jobs_running_pids WHERE running_job_id=?');
$stm_insert_pid = $db->prepare('INSERT INTO blast_cron_jobs_running_pids (pid) VALUES (?)');

$pids_running = 0;

$db->beginTransaction();
$db->exec('LOCK TABLE blast_cron_jobs_running_pids;');
$stm_get_pids->execute();
// get PIDs from database
while ($row = $stm_get_pids->fetch(\PDO::FETCH_ASSOC)) {
    //delete rows from database for processes that aren't running any more.
    if (!file_exists(sprintf('/proc/%s', $row['pid'])))
        $stm_delete_pid->execute(array($row['running_job_id']));
    else
        $pids_running++;
}
$child_processes = array();

while (($pids_running + count($child_processes)) < MAX_PARALLEL_BLAST_PROCS) {
    $pid = pcntl_fork();
    if ($pid == -1) {
        die('forking failed! quitting.');
    } else if ($pid) {
        // we are the parent process. push this pid and maybe fork another child
        array_push($child_processes, $pid);
        $stm_insert_pid->execute(array($pid));
    } else {
        // we are the child.
        // this process needs a new PDO object, otherwise the first finishing process kills the database connection for all processes
        connect_db();
        include 'run_blast.php';
        exit(0);
    }
}
//this unlocks the transaction
$db->commit();

//wait for child processes to finish so there are no zombie processes
while (count($child_processes) > 0) {
    $pid = array_shift($child_processes);
    $status = 0;
    pcntl_waitpid($pid, $status, WUNTRACED);
    //might check status here, but is not used at the moment
}

function connect_db() {
    try {
        global $db;
        if (defined('DEBUG') && DEBUG) {
            require_once SHARED . '/libs/loggedPDO/PDO.php';
            $db = new \LoggedPDO\PDO(BLAST_CRON_DB_CONNSTR, BLAST_CRON_DB_USERNAME, BLAST_CRON_DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION),
                            Log::factory('console', '', 'PDO'));
        }
        else
            $db = new PDO(BLAST_CRON_DB_CONNSTR, BLAST_CRON_DB_USERNAME, BLAST_CRON_DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>