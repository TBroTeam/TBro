<?php

session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

require_once 'TranscriptDB/WebService.php';
require_once 'TranscriptDB/WebService.php';
require_once 'TranscriptDB/cvterms.php';
require_once 'smarty/Smarty.class.php';
require_once 'lightopenid/openid.php';

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

require_once('TranscriptDB/webservices/cart/Sync.php');
$smarty->assign('regexCartName', \webservices\cart\Sync::$regexCartName);

function requestVal($key, $regexp = "/^.*$/", $defaultvalue = "") {
    if (!isset($_REQUEST[$key]) || !preg_match($regexp, $_REQUEST[$key]))
        return $defaultvalue;
    else
        return $_REQUEST[$key];
}

// OpenID stuff

$redir_url = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];

if (isset($_GET['logout'])) {
    session_destroy();
    header('Location: ' . $redir_url);
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
            header('Location: ' . $redir_url);
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
    case 'multisearch':
        $smarty->display('multisearch.tpl');
        die();
    case 'advancedsearch':
        $smarty->display('advanced_search.tpl');
        die();
    case 'unigene-details-byid':
        if (display_unigene_by_id(requestVal('feature_id', '/^[0-9]+$/', '')))
            die();
        break;
    case 'isoform-details':
        if (display_isoform(requestVal('organism', '/^[a-z0-9-_.]+$/i', ''), requestVal('uniquename', '/^[a-z0-9-_.]+$/', '')))
            die();
        break;
    case 'isoform-details-byid':
        if (display_isoform_by_id(requestVal('feature_id', '/^[0-9]+$/', '')))
            die();
        break;
    case 'graphs':
        $cartname = requestVal('query', \webservices\cart\Sync::$regexCartName, '');
        $smarty->assign('cartname', $cartname);
        $smarty->display('graphs.tpl');

        die();
}
$smarty->display('welcome.tpl');

function display_isoform($organism, $uniquename) {
    require_once 'TranscriptDB/db.php';
    global $db;
    $stm = $db->prepare(<<<EOF
SELECT feature_id 
    FROM feature 
        JOIN organism ON (feature.organism_id = organism.organism_id) 
    WHERE feature.uniquename = :uniquename AND organism.common_name = :organism
EOF
    );
    $stm->execute(array($uniquename, $organism));
    if ($stm->rowCount() == 0)
        return false;
    return display_isoform_by_id($stm->fetchColumn());
}

function display_unigene_by_id($unigene_feature_id) {
    global $smarty;
    $smarty->assign('unigene_feature_id', $unigene_feature_id);
    list($service, $trash) = WebService::factory("details/unigene");
    $data = $service->execute(array("query1" => $unigene_feature_id));
    if ($data == array()) {
        return false;
    }
    $smarty->display('display-unigene.tpl');
    return true;
}

function display_isoform_by_id($isoform_feature_id) {
    global $smarty;
    $smarty->assign('isoform_feature_id', $isoform_feature_id);
    list($service, $trash) = WebService::factory("details/isoform");
    $data = $service->execute(array("query1" => $isoform_feature_id));
    if ($data == array()) {
        return false;
    }
    $smarty->display('display-isoform.tpl');
    return true;
}

?>
