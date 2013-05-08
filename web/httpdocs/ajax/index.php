<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

require_once __DIR__ . DIRECTORY_SEPARATOR . '../config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../config_cvterms.php';

require_once 'TranscriptDB/WebService.php';
require_once 'TranscriptDB/db.php';


if (defined('DEBUG') && DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
    $logger = Log::factory('console', '', 'PDO');
    global $db;
    $db->log = $logger;
}


list($service, $args) = WebService::factory($_REQUEST['path']);
if ($service == null) {
    WebService::output(array('error' => 'Web Service not found'));
    die();
}
WebService::output($service->execute(array_merge($args, $_REQUEST)));
?>
