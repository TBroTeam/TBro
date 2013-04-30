#!/usr/bin/php
<?php
ini_set('display_errors', '0');
error_reporting(E_ALL);
define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://import.phar/');
$config = parse_ini_file(ROOT.'config.ini');
if (isset($config['config_dir'])) {
        $confdir = preg_replace('{^.$}', PHAR_DIR, $config['config_dir']);
        $confdir = preg_replace('{^./}', PHAR_DIR, $confdir);
        define('CONFIG_DIR', $confdir);
}
include 'phar://import.phar/cli.php';
__HALT_COMPILER(); 
?>