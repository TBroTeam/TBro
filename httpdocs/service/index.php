<?php

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
define('INC', '../../includes/');
require_once(INC . '/WebService.php');
require_once INC . '/db.php';


list($service, $args) = WebService::factory($_REQUEST['path']);
if ($service == null) {
    WebService::output(array('error' => 'Web Service not found'));
    die();
}
WebService::output($service->execute(array_merge($args, $_REQUEST)));
?>
