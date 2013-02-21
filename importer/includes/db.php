<?php

try {
    global $db;
    if (VERBOSE || DEBUG) {
        include __DIR__.'/loggedPDO.php';
        $db = new LoggedPDO('pgsql:host=wbbi155;dbname=dionaea_transcript_db_dev;user=s202139;password=s202139');
        DEBUG && $db->logLevel = LoggedPDO::LOGLEVEL_LONG;
        VERBOSE && $db->logLevel = LoggedPDO::LOGLEVEL_SHORT;
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
