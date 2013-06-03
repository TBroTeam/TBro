<?php

register_shutdown_function(function() {
            global $db;
            $db->prepare('DELETE FROM blast_cron_jobs_running_pids WHERE pid=?')->execute(array(getmypid()));
        });

global $db, $blast_parameter_config;
require_once('blast_parameter_config.php');
if (false)
    $db = new \PDO();

$db->beginTransaction();
$db->exec('LOCK TABLE blast_cron_jobs');
$stm = $db->query(<<<EOF
   UPDATE blast_cron_jobs 
   SET job_status='PROCESSING' 
   WHERE job_id = 
       (SELECT job_id FROM blast_cron_jobs WHERE job_status='NOT PROCESSED' ORDER BY job_creation_time ASC LIMIT 1) 
   RETURNING job_id, blast_type, organism_common_name, release_name, query
EOF
);
$db->commit();

if ($stm->rowCount() == 0) {
//there was nothing to do;
    exit(0);
}

$row = $stm->fetch(\PDO::FETCH_ASSOC);

$db->prepare('UPDATE blast_cron_jobs_running_pids SET job_id=? WHERE pid=?')->execute(array($row['job_id'], getmypid()));

if (!in_array($row['blast_type'], array_diff(array_keys($blast_parameter_config), array('general')))) {
    die('illegal blast type');
}

$paramconfig = array_merge($blast_parameter_config['general'], $blast_parameter_config[$row['blast_type']]);
$params = array();

foreach ($paramconfig as $param => $value) {
    if (isset($value['default'])) {
        $params[$param] = $value['default'];
    }
}

$db_stm_params = $db->prepare('SELECT job_id, property_name, property_value FROM blast_cron_jobs_properties WHERE job_id=?');
$db_stm_params->execute(array($row['job_id']));

while ($db_param = $db_stm_params->fetch(\PDO::FETCH_ASSOC)) {
    if (!isset($paramconfig[$db_param['property_name']]))
        continue;

    $cfg_param = $paramconfig[$db_param['property_name']];


    if (isset($cfg_param['test'])) {
        //test via callback specified in $paramconfig if the specified value may override the default
        if (call_user_func_array($cfg_param['test'], array_merge(array($db_param['property_value']), $cfg_param['test_additional_parameters']))) {
            $params[$db_param['property_name']] = $db_param['property_value'];
        }
    }
}

$cmd = constant(strtoupper($row['blast_type']));

if (!preg_match('{^\w+$}', $row['organism_common_name']) || !preg_match('{^\w+$}', $row['release_name']))
    die('release name or organism name not valid');
$cmd .= sprintf(' -db %s/%s_%s.fasta', BLAST_DATABASE_BASEDIR, $row['organism_common_name'], $row['release_name']);

foreach ($params as $param => $value) {
    $cmd.=sprintf(' %s %s', $param, $value);
}

echo "\nwill execute $cmd\n";

$errfile = tempnam('sys_get_temp_dir', 'runblast_pipe_stderr');
$descriptorspec = array(
    0 => array("pipe", "r"), // stdin 
    1 => array("pipe", "w"), // stdout
    2 => array("file", $errfile, "a")  // stderr
);

$cwd = BLAST_DATABASE_BASEDIR;
$pipes = array();

$process = proc_open($cmd, $descriptorspec, $pipes, $cwd);

if (is_resource($process)) {
    fwrite($pipes[0], $row['query']);
    fclose($pipes[0]);

    $result = '';

    while (!feof($pipes[1])) {
        $result .= fgets($pipes[1]);
    }
    fclose($pipes[1]);

    $return_value = proc_close($process);

    if ($return_value == 0) {
        $db->prepare("UPDATE blast_cron_jobs SET job_status='PROCESSED' WHERE job_id = ?")->execute(array($row['job_id']));
        $db->prepare("INSERT INTO blast_cron_jobs_results (job_id, results_xml) VALUES (?, ?)")->execute(array($row['job_id'], $result));
    } else {
        $errcontents = file_get_contents($errfile);

        $data = sprintf("---Exit Code: %s---\n---STDERR---\n%s\n\n\n---STDOUT---\n%s", $return_value, $errcontents, $result);
        $db->prepare("UPDATE blast_cron_jobs SET job_status='ERROR' WHERE job_id = ?")->execute(array($row['job_id']));
        $db->prepare("INSERT INTO blast_cron_jobs_results (job_id, results_xml) VALUES (?, ?)")->execute(array($row['job_id'], $data));
    }
    echo "command returned $return_value\n";
}
?>
