<?php

if (!defined('VERBOSE')) define('VERBOSE', false);
if (!defined('DEBUG')) define('DEBUG', false);

try {
    global $db;
    if (VERBOSE || DEBUG) {
        require_once __DIR__.'/LoggedPDO.php';
        $db = new LoggedPDO('pgsql:host=wbbi155;dbname=dionaea_transcript_db_dev;user=s202139;password=s202139');
        DEBUG && $db->logLevel = LoggedPDO::LOGLEVEL_LONG;
        VERBOSE && $db->logLevel = LoggedPDO::LOGLEVEL_LONG;
    } else {
        $db = new PDO('pgsql:host=wbbi155;dbname=dionaea_transcript_db_dev;user=s202139;password=s202139');
    }
    #usually stop execution on DB error
    $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    #in debug mode, try to continue and output warning
    DEBUG && $db->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_WARNING);
} catch (PDOException $e) {
    print "Error!: " . $e->getMessage() . "<br/>";
    die();
}
?>
