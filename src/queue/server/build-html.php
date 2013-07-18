#!/usr/bin/php
<?php
require_once 'smarty/Smarty.class.php';
//initialize smarty
$smarty = new Smarty();
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';
$smarty->setTemplateDir(__DIR__ . DIRECTORY_SEPARATOR . 'tpl');
ob_start();
$smarty->display('extends:layout.tpl|' . $argv[1] . '.tpl');
file_put_contents(__DIR__ . DIRECTORY_SEPARATOR . $argv[1] . '.html', ob_get_clean());
?>
