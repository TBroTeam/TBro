<?php
if ((isset($_SERVER['SERVER_NAME']) && in_array(strtolower($_SERVER['SERVER_NAME']), array('sadrithmora'))) 
        || (isset($_SERVER['HOSTNAME']) && strtolower($_SERVER['HOSTNAME']) == 'sadrithmora')) {
    define('DB_SERVER', '127.0.0.1');
    define('DB_USERNAME', 's202139');
    define('DB_PASSWORD', 's202139');
    define('DB_DB', 'dionaea_transcript_db_dev_test1');
} else {
    define('DB_SERVER', '132.187.22.155');
    define('DB_USERNAME', 's202139');
    define('DB_PASSWORD', 's202139');
    define('DB_DB', 'dionaea_transcript_db_dev_test1');
}

define('ASSEMBLY_PREFIX', '1.01_');
define('DB_ORGANISM_ID', '13');
define('DUMMY', 123);

require_once (__DIR__.'/cvterms.php');

define('LINES_IMPORTED', 'datasets_imported');

#versions of databases for interpro import
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');

global $_CONST;
$_CONST = 'constant';




?>
