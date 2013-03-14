<?php

define('APPPATH', '/httpdocs/client');
define('SERVICEPATH', '/httpdocs/service');
define('INC', __DIR__.'/../../includes/');

error_reporting(E_ALL);
ini_set('display_errors', '1');



require(__DIR__ . '/../../lib/smarty/Smarty.class.php');
$smarty = new Smarty();
$smarty->setTemplateDir(__DIR__ . '/../smarty/templates');
$smarty->setCompileDir(__DIR__ . '/../smarty/templates_c');
$smarty->setCacheDir(__DIR__ . '/../smarty/cache');
$smarty->setConfigDir(__DIR__ . '/../smarty/configs');
$smarty->addPluginsDir(__DIR__ . '/../smarty/plugins');

$smarty->assign('AppPath', APPPATH);
$smarty->assign('ServicePath', SERVICEPATH);
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';

function requestVal($key, $regexp = "/^.*$/", $defaultvalue = "") {
    if (!isset($_REQUEST[$key]) || !preg_match($regexp, $_REQUEST[$key]))
        return $defaultvalue;
    else
        return $_REQUEST[$key];
}

$page = requestVal('page', '/^[a-z-]*$/', '');

switch ($page) {
    case 'unigene-details':
        $smarty->assign('unigene_uniquename', requestVal('query', '/^[a-z0-9._]+$/i', '1.01_comp231081_c0'));
        $smarty->display('display-unigene.tpl');
        break;
    case 'isoform-details':
        $smarty->assign('isoform_uniquename', requestVal('query', '/^[a-z0-9._]+$/i', '1.01_comp231081_c0'));
        $smarty->display('display-isoform.tpl');
        break;    
    default:
        $smarty->display('welcome.tpl');
        break;
}
?>
