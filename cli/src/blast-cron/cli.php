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

$start_time = microtime(true);
$end_time = $start_time + BLAST_CRON_PARENT_LIFE_TIME;


$child_processes = array();

pcntl_signal(SIGTERM, "sig_handler");
pcntl_signal(SIGINT, "sig_handler");


while (BLAST_CRON_PARENT_LIFE_TIME == -1 || $end_time > microtime(true)) {
    // after forking, commit unlocks the table but calling beginTransaction on the old $db object gives an SQL error.
    // => we need a new connection every cycle.
    connect_blast_db();
    global $db;
    $stm_get_pids = $db->prepare('SELECT running_job_id, pid, job_id FROM blast_cron_jobs_running_pids WHERE hostname=?');
    $stm_delete_pid = $db->prepare('DELETE FROM blast_cron_jobs_running_pids WHERE running_job_id=?');
    $stm_insert_pid = $db->prepare('INSERT INTO blast_cron_jobs_running_pids (pid, hostname) VALUES (?, ?)');


    // if we receive a SIGTERM, here would be a good point to exit
    pcntl_signal_dispatch();

    $pids_running = 0;
    $db->beginTransaction();
    $db->exec('LOCK TABLE blast_cron_jobs_running_pids;');
    $stm_get_pids->execute(array(gethostname()));

    //get PIDs from database
    while ($row = $stm_get_pids->fetch(\PDO::FETCH_ASSOC)) {
        //delete rows from database for processes that aren't running any more.
        if (!file_exists(sprintf('/proc/%s', $row['pid']))) {
            //TODO: set to error
            $jobstatus = $db->prepare("SELECT job_status FROM blast_cron_jobs WHERE job_id = ?");
            $jobstatus->execute(array($row['job_id']));
            if ($jobstatus->fetchColumn() == 'PROCESSING') {
                $db->prepare("UPDATE blast_cron_jobs SET job_status='ERROR', job_processing_finish_time=CURRENT_TIMESTAMP WHERE job_id = ?")->execute(array($row['job_id']));
                $db->prepare("INSERT INTO blast_cron_jobs_results (job_id,  error_text) VALUES (?, ?)")->execute(array($row['job_id']
                    , 'queueing error: process got lost on the way'));
            }



            $stm_delete_pid->execute(array($row['running_job_id']));
        }
        else
            $pids_running++;
    }

    while (($pids_running) < BLAST_CRON_MAX_PARALLEL_PROCS) {
        $queryres = $db->query("SELECT 1  FROM blast_cron_jobs WHERE job_status='NOT PROCESSED'");
        if ($queryres->rowCount() == 0) {
            //nothing to do, wait for next loop
            break;
        }

        $pid = pcntl_fork();
        if ($pid == -1) {
            die('forking failed! quitting.');
        } else if ($pid) {
            // we are the parent process. push this pid and store it to db. continue forking.
            array_push($child_processes, $pid);
            $stm_insert_pid->execute(array($pid, gethostname()));
            $pids_running++;
        } else {
            // we are the child.
            // this process needs a new PDO object, otherwise the first finishing process kills the database connection for all processes
            unset($db);
            connect_blast_db();
            include 'run_blast.php';
            exit(0);
        }
    }
    //this unlocks the table
    $db->commit();
    unset($db);
    // if we receive a SIGTERM, here would be a good point to exit
    pcntl_signal_dispatch();

    wait_for_child_exit(10, $dummy);
}
echo 'time is up, waiting for graceful exit';
wait_for_graceful_exit();
kill_children();
echo "\n";
exit(0);





## handler functions ###

function sig_handler($signo) {
    if ($signo == SIGTERM || $signo == SIGINT) {
        // yeah, static function-scope variables. this initialisation is called just for the first time, the variable keeps its value.
        static $sigterm_count = 0;
        $graceful = false;
        $sigterm_count++;
        if ($sigterm_count == 1) {
            echo "received SIGTERM, waiting for graceful exit. if you don\'t want to wait, send another SIGTERM.\n";
            $graceful = wait_for_graceful_exit();
        } else {
            echo 'received a second SIGTERM. sending SIGKILL to children and exiting';
        }
        if ($graceful)
            echo "all child processes terminated, exiting gracefully";
        else {
            echo "some child processes are still running, sending SIGKILL to children and exiting";
            kill_children();
        }
        echo "\n";
        exit(0);
    }
}

function wait_for_graceful_exit() {
    global $child_processes;

    $exit_start_time = microtime(true);
    while (($time_left = $exit_start_time + BLAST_CRON_MAX_GRACEFUL_EXIT_TIME - microtime(true)) > 0) {
        //wait for child processes to finish so there are no zombie processes
        if (count($child_processes) > 0) {
            wait_for_child_exit($time_left, $dummy);
        } else
            return true;
    }
    return count($child_processes) == 0;
}

function kill_children($signal = SIGKILL) {
    global $child_processes;

    foreach ($child_processes as $pid) {
        posix_kill($pid, $signal);
    }
}

function wait_for_child_exit($time_to_wait, &$status, $step_time_microseconds = 500000) {
    $sleep_until = microtime(true) + $time_to_wait;
    global $child_processes;

    while (($time_left = ($sleep_until - microtime(true)) * 1000 * 1000) > 0) {
        $process_exited = pcntl_wait($status, WNOHANG | WUNTRACED);
        //a child has finished, start another child
        if ($process_exited > 0) {
            unset($child_processes[array_search($process_exited, $child_processes)]);
            return $process_exited;
        }
        // if we receive a SIGTERM, here would be a good point to exit
        pcntl_signal_dispatch();
        usleep($step_time_microseconds < $time_left ? $step_time_microseconds : $time_left);
    }
}

function connect_blast_db() {
    try {
        global $db;
        if (defined('DEBUG') && DEBUG) {
            require_once SHARED . '/libs/loggedPDO/PDO.php';
            $db = new \LoggedPDO\PDO(BLAST_CRON_DB_CONNSTR, BLAST_CRON_DB_USERNAME, BLAST_CRON_DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false),
                            Log::factory('console', '', 'PDO'));
        }
        else
            $db = new PDO(BLAST_CRON_DB_CONNSTR, BLAST_CRON_DB_USERNAME, BLAST_CRON_DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION, PDO::ATTR_PERSISTENT => false));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>