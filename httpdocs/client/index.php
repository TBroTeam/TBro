<?php

session_start();

define('APPPATH', '/httpdocs/client');
define('SERVICEPATH', '/httpdocs/service');

define('INC', __DIR__ . '/../../includes/');

if (isset($_REQUEST['DEBUG']))
    define('DEBUG', true);
error_reporting(E_ALL);
ini_set('display_errors', '1');


require_once INC . '/constants.php';
require_once INC . '/WebService.php';





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

require_once(INC.'/webservices/cart/Sync.php');
$smarty->assign('regexCartName', \webservices\cart\Sync::$regexCartName);

function requestVal($key, $regexp = "/^.*$/", $defaultvalue = "") {
    if (!isset($_REQUEST[$key]) || !preg_match($regexp, $_REQUEST[$key]))
        return $defaultvalue;
    else
        return $_REQUEST[$key];
}

// OpenID stuff
require_once INC . '/libs/lightopenid/openid.php';
require_once INC . '/WebService.php';

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $_SERVER['REDIRECT_URL']);
    die();
}
try {
    $openid = new LightOpenID($_SERVER['HTTP_HOST']);
    if (!$openid->mode) {
        if (isset($_GET['login'])) {
            $openid->identity = 'https://www.google.com/accounts/o8/id';
            header('Location: ' . $openid->authUrl());
            die();
        }
    } else {
        if ($openid->validate()) {
            $_SESSION['OpenID'] = $openid->identity;
            header('Location: ' . $_SERVER['REDIRECT_URL']);
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
        die();
    case 'unigene-details':
        $unigene = requestVal('query', '/^[a-z0-9._-]+$/i', '');
        $smarty->assign('unigene_uniquename', $unigene);
        list($service, $trash) = WebService::factory("details/unigene");
        $data = $service->execute(array("query1" => $unigene));
        if ($data == array()) {
            break;
        }
        $smarty->display('display-unigene.tpl');
        die();
    case 'isoform-details':
        $isoform_feature_id = requestVal('feature_id', '/^[0-9]+$/', '');
        $smarty->assign('isoform_feature_id', $isoform_feature_id);
        list($service, $trash) = WebService::factory("details/isoform");
        $data = $service->execute(array("query1" => $isoform_feature_id));
        if ($data == array()) {
            break;
        }
        $smarty->display('display-isoform.tpl');
        die();
    case 'graphs':
        $cartname = requestVal('query',\webservices\cart\Sync::$regexCartName, '');
        $smarty->assign('cartname', $cartname);
        $smarty->display('graphs.tpl');
        
        die();
}
$smarty->display('welcome.tpl');
?>
