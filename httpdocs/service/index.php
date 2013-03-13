<?php

if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}
require_once('inc/WebService.php');
require_once INC . '/db.php';


list($service, $args) = WebServiceFactory::getServiceAndArgs($_REQUEST['path']);
if ($service == null) {
    WebService::output(array('error' => 'Web Service not found'));
    die();
}
WebService::output($service->execute($args));

?>
