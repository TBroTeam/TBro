#!/urs/bin/php
<?php
$p = new Phar('db.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'db.phar');

$p->buildFromDirectory(__DIR__.'/db/');
$p['configuration.php'] = file_get_contents(__DIR__.'/configuration.php');
$p->setStub(<<<EOF
<?php 
    define('PHAR_DIR', __DIR__.'/'); 
    Phar::mapPhar(); 
    define('ROOT', 'phar://db.phar/'); 
    include 'phar://db.phar/configuration.php'; 
    include 'phar://db.phar/db.php'; 
    __HALT_COMPILER(); ?>
EOF
        );


$p = new Phar('import.phar', FilesystemIterator::CURRENT_AS_FILEINFO | FilesystemIterator::KEY_AS_FILENAME, 'import.phar');

$p->buildFromDirectory(__DIR__.'/import/');
$p['configuration.php'] = file_get_contents(__DIR__.'/configuration.php');
$p->setStub(<<<EOF
<?php 
    define('PHAR_DIR', __DIR__.'/'); 
    Phar::mapPhar(); 
    define('ROOT', 'phar://import.phar/'); 
    include 'phar://import.phar/configuration.php'; 
    include 'phar://import.phar/import.php'; 
    __HALT_COMPILER(); ?>
EOF
        );

?>


