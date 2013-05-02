#!/usr/bin/php
<?php
ini_set('display_errors', '0');
error_reporting(E_ALL);
define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://db.phar/');
define('SHARED', ROOT);
$config = parse_ini_file(ROOT.'config.ini');
if (isset($config['config_dir'])) {
        $confdir = preg_replace('{^.$}', PHAR_DIR, $config['config_dir']);
        $confdir = preg_replace('{^./}', PHAR_DIR, $confdir);
        define('CONFIG_DIR', $confdir);
}
include 'phar://db.phar/cli.php';
__HALT_COMPILER(); 
?>