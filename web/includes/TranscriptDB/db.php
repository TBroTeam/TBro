<?php

try {
    global $db;
    $connstr = sprintf('pgsql:host=%s;dbname=%s', DB_SERVER, DB_DB);
    if (defined('DEBUG') && DEBUG) {
        require_once 'loggedPDO/PDO.php';
        require_once 'loggedPDO/Log_firebugJSON.php';

        if (PHP_SAPI == 'cli') {
            $logtype = 'console';
        }
        else {
            if (in_array('Content-type: application/json', headers_list())) {
                $logtype = 'console';
            }
            else {
                $logtype = 'firebugJSON';
            }
        }
        $logger = Log::factory($logtype, '', 'PDO');
        $db = new \LoggedPDO\PDO($connstr, DB_USERNAME, DB_PASSWORD, null, $logger);
        //$db->log_replace_params = false;
    }
    else {
        $db = new PDO($connstr, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true));
    }
    #usually stop execution on DB error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #in debug mode, try to continue and output warning
    #DEBUG && $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
