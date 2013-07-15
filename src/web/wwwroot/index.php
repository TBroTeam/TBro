<?php

session_start();

//config file
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';

//requiremend libs
require_once 'TranscriptDB/WebService.php';
require_once 'smarty/Smarty.class.php';
require_once 'lightopenid/openid.php';
require_once 'TranscriptDB/db.php';

//get path for TranscriptDB folder, store in CFG_SMARTY_DIR
$dbpath = stream_resolve_include_path('TranscriptDB/db.php');
define('CFG_SMARTY_DIR', substr($dbpath, 0, strlen($dbpath) - 7));

//initialize smarty
$smarty = new Smarty();
$smarty->setTemplateDir(CFG_SMARTY_DIR . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'templates');
$smarty->setCompileDir(VAR_DIR . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'templates_c');
$smarty->setCacheDir(VAR_DIR . DIRECTORY_SEPARATOR . 'cache');
$smarty->setConfigDir(CFG_SMARTY_DIR . DIRECTORY_SEPARATOR . 'configs');
$smarty->addPluginsDir(CFG_SMARTY_DIR . DIRECTORY_SEPARATOR . 'smarty' . DIRECTORY_SEPARATOR . 'plugins');
$smarty->assign('AppPath', APPPATH);
$smarty->assign('ServicePath', SERVICEPATH);
$smarty->left_delimiter = '{#';
$smarty->right_delimiter = '#}';

//cart name regexp
require_once('TranscriptDB/webservices/cart/Sync.php');
$smarty->assign('regexCartName', \webservices\cart\Sync::$regexCartName);

$smarty->assign('default_release', DEFAULT_RELEASE);
$smarty->assign('default_organism', DEFAULT_ORGANISM);

/**
 * returns $_REQUEST[$key] value if it matches $regexp, else return $defaultvalue
 * @param String $key
 * @param String $regexp
 * @param String $defaultvalue
 * @return String
 */
function requestVal($key, $regexp = "/^.*$/", $defaultvalue = "") {
    if (!isset($_REQUEST[$key]) || !preg_match($regexp, $_REQUEST[$key]))
        return $defaultvalue;
    else
        return $_REQUEST[$key];
}

// OpenID stuff
$redir_url = isset($_SERVER['REDIRECT_URL']) ? $_SERVER['REDIRECT_URL'] : $_SERVER['REQUEST_URI'];
//log out?
if (isset($_GET['logout'])) {
    session_destroy();
    //redirect to same page without logout parameter
    header('Location: ' . preg_replace('/([?&])logout(=[^&]+)?(&|$)/', '$1', $redir_url));
    die();
}
//standard LightOpenID login code, see LightOpenID documentation 
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
$page = requestVal('page', '/^[a-z-_\.]*$/', '');
switch ($page) {
    case 'js':
        $js = requestVal('js', '/^[a-zA-Z-\.]*$/', '');
        header('Content-type: application/javascript');
        $smarty->display(sprintf('js/%s.js', $js));
        die();
    case 'multisearch':
        $smarty->display('multisearch.tpl');
        die();
    case 'combisearch':
        $smarty->display('combisearch.tpl');
        die();
    case 'advancedsearch':
        $smarty->display('advanced_search.tpl');
        die();
    case 'details-byid':
        if (display_feature_by_id(requestVal('feature_id', '/^[0-9]+$/', '')))
            die();
        break;
    case 'details':
        if (display_feature(requestVal('organism', '/^[0-9]+$/i', ''), requestVal('release', '/^[a-z0-9-_.]+$/', ''), requestVal('name', '/^[a-z0-9-_.]+$/', '')))
            die();
        break;
    case 'diffexpr':
        $smarty->display('diffexpr.tpl');
        die();
        break;
    case 'graphs':
        $cartname = requestVal('query', sprintf('/%s/i', \webservices\cart\Sync::$regexCartName), '');
        $smarty->assign('cartname', $cartname);
        $smarty->display('mav.tpl');
        die();
    case 'blast':
        $smarty->display('extends:blast-layout.tpl|blast.tpl');
        die();
    case 'blast_results':
        $smarty->display('extends:blast-layout.tpl|blast_results.tpl');
        die();
}
$smarty->display('welcome.tpl');

/**
 * displays feature identified by $organism, $release and $name
 * @global \PDO $db
 * @param type $organism
 * @param type $release
 * @param type $name
 * @return boolean false on failure
 */
function display_feature($organism, $release, $name) {

    global $db;
    $stm = $db->prepare(<<<EOF
SELECT feature_id 
    FROM feature JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id)
    WHERE organism_id = ? AND accession=? AND name=?
EOF
    );

    $stm->execute(array($organism, $release, $name));

    if ($stm->rowCount() == 0)
        return false;

    return display_feature_by_id($stm->fetchColumn());
}

/**
 * displays feature based on $feature_id
 * @global \PDO $db
 * @global Smarty $smarty
 * @param int $feature_id
 * @return fasle on failure
 */
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
        case CV_PREDPEP:
            $stm_parent_isoform = $db->prepare('SELECT srcfeature_id FROM featureloc WHERE feature_id=? ');
            $stm_parent_isoform->execute(array($feature_id));
            return display_feature_by_id($stm_parent_isoform->fetchColumn());
            die();
    }
    return false;
}

/**
 * displays unigene based on $unigene_feature_id
 * @global Smarty $smarty
 * @param type $unigene_feature_id
 * @return boolean false on failure
 */
function display_unigene_by_id($unigene_feature_id) {
    global $smarty;
    $smarty->assign('unigene_feature_id', $unigene_feature_id);
    $smarty->display('display-unigene.tpl');
    return true;
}

/**
 * displays isoform based on $isoform_feature_id
 * @global Smarty $smarty
 * @param type $isoform_feature_id
 * @return boolean false on failure
 */
function display_isoform_by_id($isoform_feature_id) {
    global $smarty;
    $smarty->assign('isoform_feature_id', $isoform_feature_id);
    $smarty->display('display-isoform.tpl');
    return true;
}

?>
