<?php

define('PHAR_DIR', __DIR__ . DIRECTORY_SEPARATOR);
Phar::mapPhar();
define('ROOT', 'phar://db.phar/');
$config = parse_ini_file('phar://db.phar/config.ini');
if (isset($config['config_dir'])) {
        define('CONFIG_DIR', $config['config_dir']);
}
include 'phar://db.phar/cli.php';
__HALT_COMPILER(); 
?>