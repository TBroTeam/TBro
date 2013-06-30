#!/usr/bin/php
<?php
define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://import.phar/');
define('SHARED', ROOT);

define('CONFIG_DIR', "${config_dir}/");

include 'phar://import.phar/cli.php';
__HALT_COMPILER(); 
?>