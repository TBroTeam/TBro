#!/usr/bin/php
<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://db.phar/');
define('SHARED', ROOT);

define('CONFIG_DIR', "${config_dir}");

include 'phar://db.phar/cli.php';
__HALT_COMPILER(); 
?>