<?php
ini_set('display_errors', '1');
error_reporting(E_ALL);
define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://import.phar/');
$config = parse_ini_file('phar://db.phar/config.ini');
if (isset($config['config_dir'])) {
        define('CONFIG_DIR', $config['config_dir']);
}
include 'phar://import.phar/cli.php';
__HALT_COMPILER(); 
?>