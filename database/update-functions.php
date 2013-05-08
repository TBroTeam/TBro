#!/usr/bin/php
<?php
define('DEBUG', false);

set_include_path(get_include_path() . PATH_SEPARATOR . '/home/s202139/git/web/includes');

require_once __DIR__ . '/../web/httpdocs/config.php';
require_once __DIR__ . '/../web/httpdocs/config_cvterms.php';

require_once 'TranscriptDB/db.php';
global $db;

$dirname = __DIR__ . DIRECTORY_SEPARATOR . 'functions' . DIRECTORY_SEPARATOR;
foreach (new DirectoryIterator($dirname) as $file) {
    if (!is_file($dirname . $file)) continue;
    $func = file_get_contents($dirname . $file);
    $query = preg_replace_callback("/\{PHPCONST\('(.*)'\)\}/", function($c) {
                return constant($c[1]);
            }, $func);

    $match = null;
    preg_match('{CREATE FUNCTION\s*(.*)\s*RETURNS}m', $query, $match);
    $query_drop = sprintf("DROP FUNCTION IF EXISTS %s;", $match[1]);

    echo $query_drop."\n\n";
    $db->query($query_drop);
    echo $query."\n\n";
    $db->query($query);
    
}

?>
