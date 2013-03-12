<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');
if (DEBUG) {
    error_reporting(E_ALL);
    ini_set('display_errors', '1');
}

define('INC', __DIR__ . '/../../../includes/');
require_once INC . '/db.php';
require_once INC . '/json_indent.php';

?>
