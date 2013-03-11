<?php

header('Cache-Control: no-cache, must-revalidate');
header('Expires: Mon, 26 Jul 1997 05:00:00 GMT');
header('Content-type: application/json');

define('INC', __DIR__ . '/../../includes/');
require_once INC . '/db.php';

global $db;
#UI hint
if (false)
    $db = new PDO();

$parents = $_REQUEST['parents'];

$query = file_get_contents('quantification.sql');
$in_clause = '';
for ($i = 0; $i < count($parents); $i++)
    $in_clause .= $i == 0 ? '?' : ',?';

$stm = $db->prepare(sprintf($query, $in_clause));
$stm->execute($parents);

$lastcell_name = '';
$data = array();
$vars = array();
$smps = array();
$tree_vars = array();
$tree_smps = array();
$row = null;
while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
    if ($cell['feature_name'] != $lastcell_name) {
        #featue-specific actions, only once per featue
        $lastcell_name = $cell['feature_name'];
        $data[] = array();
        $row = &$data[count($data) - 1];
        $vars[] = $cell['feature_name'];
        if (!isset($tree_vars[$cell['parent_feature_name']]))
            $tree_vars[$cell['parent_feature_name']] = array();
        $tree_vars[$cell['parent_feature_name']][] = $cell['feature_name'];
    }

    if (count($data) == 1) {
        #sample-specific actions, only executed for first var
        $smps[] = $cell['biomaterial_name'];
        if (!isset($tree_smps[$cell['parent_biomaterial_name']]))
            $tree_smps[$cell['parent_biomaterial_name']] = array();
        $tree_smps[$cell['parent_biomaterial_name']][] = $cell['biomaterial_name'];
    }

    $row[] = floatval($cell['value']);
}
$t = array('vars' => '', 'smps' => '');

foreach (array('vars' => &$tree_vars, 'smps' => &$tree_smps) as $key => $tree) {
    foreach ($tree as $children) {
        $substr = "";
        foreach ($children as $child) {
            $substr .= (empty($substr) ? '' : ',') . $child;
        }
        $t[$key] .=(empty($t[$key]) ? '' : ',') . "($substr)";
    }
    $t[$key] = '(' . $t[$key] . ')';
}

echo json_encode(array(
    'y' => array(
        'vars' => $vars,
        'smps' => $smps,
        'data' => $data
    ),
    't' => $t
));
?>
