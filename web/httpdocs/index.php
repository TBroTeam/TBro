<?php

session_start();

require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config_cvterms.php';

require_once 'TranscriptDB/WebService.php';
require_once 'TranscriptDB/WebService.php';
require_once 'smarty/Smarty.class.php';
require_once 'lightopenid/openid.php';
require_once 'TranscriptDB/db.php';

$smarty = new Smarty();
$smarty->setTemplateDir(CFG_SMARTY_DIR . '/templates');
$smarty->setCompileDir(CFG_SMARTY_DIR . '/templates_c');
$smarty->setCacheDir(CFG_SMARTY_DIR . '/cache');
$smarty->setConfigDir(CFG_SMARTY_DIR . '/configs');
$smarty->addPluginsDir(CFG_SMARTY_DIR . '/plugins');

$smarty->assign('AppPath', APPPATH);
$smarty->assign('ServicePath', SERVICEPATH);
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';

require_once('TranscriptDB/webservices/cart/Sync.php');
$smarty->assign('regexCartName', \webservices\cart\Sync::$regexCartName);

$smarty->assign('release', DEFAULT_RELEASE);
$smarty->assign('organism', DEFAULT_ORGANISM);

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
    case 'js':
        $js = requestVal('js', '/^[a-z-\.]*$/', '');
        header('Content-type: application/javascript');
        $smarty->display(sprintf('js/%s.js', $js));
        die();
    case 'multisearch':
        $smarty->display('multisearch.tpl');
        die();
    case 'advancedsearch':
        $smarty->display('advanced_search.tpl');
        die();
    case 'details-byid':
        if (display_feature_by_id(requestVal('feature_id', '/^[0-9]+$/', '')))
            die();
        break;
    case 'details':
        if (display_isoform(requestVal('organism', '/^[a-z0-9-_.]+$/i', ''), requestVal('uniquename', '/^[a-z0-9-_.]+$/', '')))
            die();
        break;
    case 'graphs':
        $cartname = requestVal('query', sprintf('/%s/i',\webservices\cart\Sync::$regexCartName), '');
        $smarty->assign('cartname', $cartname);
        $smarty->display('mav.tpl');
        die();
}
$smarty->display('welcome.tpl');

function display_feature($organism, $uniquename) {

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
    return display_feature_by_id($stm->fetchColumn());
}

function display_feature_by_id($feature_id) {
    global $db;
    global $smarty;
    $stm = $db->prepare(<<<EOF
SELECT type_id, dbxref.accession, organism_id FROM feature JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id) WHERE feature_id=?;
EOF
    );
    $stm->execute(array($feature_id));
    if ($stm->rowCount() == 0)
        return false;
    $row = $stm->fetch(PDO::FETCH_ASSOC);
    $smarty->assign('release', $row['accession']);
    $smarty->assign('organism', $row['organism_id']);
    switch ($row['type_id']) {
        case CV_ISOFORM:
            return display_isoform_by_id($feature_id);
            break;
        case CV_UNIGENE:
            return display_unigene_by_id($feature_id);
            break;
    }
    return false;
}

function display_unigene_by_id($unigene_feature_id) {
    global $smarty;
    $smarty->assign('unigene_feature_id', $unigene_feature_id);
    $smarty->display('display-unigene.tpl');
    return true;
}

function display_isoform_by_id($isoform_feature_id) {
    global $smarty;
    $smarty->assign('isoform_feature_id', $isoform_feature_id);
    $smarty->display('display-isoform.tpl');
    return true;
}

?>
