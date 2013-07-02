#!/usr/bin/php
<?php
require_once '${config_dir}/config.php';
require_once '${config_dir}/cvterms.php';

require_once __DIR__.'/db.php';

if (in_array('--tables', $argv))
    execute_query_dir('tables');
if (in_array('--functions', $argv))
    execute_query_dir('functions');
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
