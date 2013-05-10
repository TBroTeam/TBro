#!/usr/bin/php
<?php
define('DEBUG', false);

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/s202139/git/web/includes');

require_once __DIR__ . '/../web/httpdocs/config.php';
require_once __DIR__ . '/../web/httpdocs/config_cvterms.php';

require_once 'TranscriptDB/db.php';

if (in_array('--functions', $argv))
    execute_query_dir('functions');
if (in_array('--tables', $argv))
    execute_query_dir('tables');
if (in_array('--mat_views', $argv))
    execute_query_dir('materialized_views');

function execute_query_dir($subdirname) {
    global $db;
    $dirname = __DIR__ . DIRECTORY_SEPARATOR . $subdirname . DIRECTORY_SEPARATOR;
    foreach (new DirectoryIterator($dirname) as $file) {
        if (!is_file($dirname . $file))
            continue;
        $unprepared = file_get_contents($dirname . $file);
        $prepared = preg_replace_callback("/\{PHPCONST\('(.*)'\)\}/", function($c) {
                    return constant($c[1]);
                }, $unprepared);

        $queries = explode('--NEWCMD--', $prepared);

        foreach ($queries as $query) {
            echo $query . "\n\n";
            $db->query($query);
        }
    }
}
?>
