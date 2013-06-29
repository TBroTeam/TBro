<?php

global $db;
$db = get_db_connection(DB_CONNSTR, DB_USERNAME, DB_PASSWORD);

function connect_queue_db() {
    return get_db_connection(QUEUE_DB_CONNSTR, QUEUE_DB_USERNAME, QUEUE_DB_PASSWORD);
}

function get_db_connection($connstr, $username, $password) {
    try {
        if (defined('DEBUG') && DEBUG) {
            require_once 'loggedPDO/PDO.php';
            require_once 'loggedPDO/Log_firebugJSON.php';

            if (PHP_SAPI == 'cli') {
                $logtype = 'console';
            } else {
                if (in_array('Content-type: application/json', headers_list())) {
                    $logtype = 'console';
                } else {
                    $logtype = 'firebugJSON';
                }
            }
            $logger = Log::factory($logtype, '', 'PDO');
            $db = new \LoggedPDO\PDO($connstr, $username, $password, null, $logger);
            //$db->log_replace_params = false;
        } else {
            $db = new PDO($connstr, $username, $password, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
        }
        #usually stop execution on DB error
        $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        
        return $db;
    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }
}

?>
