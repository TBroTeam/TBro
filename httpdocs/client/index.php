<?php

session_start();

define('APPPATH', '/httpdocs/client');
define('SERVICEPATH', '/httpdocs/service');

define('INC', __DIR__ . '/../../includes/');

require_once INC . '/constants.php';

error_reporting(E_ALL);
ini_set('display_errors', '1');



require(INC . '/libs/smarty/Smarty.class.php');
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

// OpenID stuff
require_once INC . '/libs/lightopenid/openid.php';
require_once INC . '/WebService.php';

if (isset($_GET['logout'])){
    session_destroy();
    header('Location: '.$_SERVER['REDIRECT_URL']);
    die();
}
try {
    # Change 'localhost' to your domain name.
    $openid = new LightOpenID('localhost');
    if (!$openid->mode) {
        if (isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            header('Location: ' . $openid->authUrl());
            die();
        }
    } else {
        if ($openid->validate()) {
            $_SESSION['OpenID'] = $openid->identity;
            list($sync, $trash) = WebService::factory('cart/sync');
            $sync->execute(array('action' => 'loadFromDB'));
            header('Location: '.$_SERVER['REDIRECT_URL']);
            die();
        }
    }
} catch (ErrorException $e) {
    
}

// Page display
$page = requestVal('page', '/^[a-z-\.]*$/', '');
switch ($page) {
    case 'cart.js':
        header('Content-type: application/javascript');
        $smarty->display('cart.js');
        break;
    case 'unigene-details':
        //TODO check if exists
        $smarty->assign('unigene_uniquename', requestVal('query', '/^[a-z0-9._]+$/i', '1.01_comp231081_c0'));
        $smarty->display('display-unigene.tpl');
        break;
    case 'isoform-details':
        //TODO check if exists
        $smarty->assign('isoform_uniquename', requestVal('query', '/^[a-z0-9._]+$/i', '1.01_comp231081_c0'));
        $smarty->display('display-isoform.tpl');
        break;
    default:
        $smarty->display('welcome.tpl');
        break;
}
?>
