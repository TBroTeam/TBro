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
for ($i = 0; $i < count($parents); $i++) $in_clause .= $i == 0 ? '?' : ',?';

$stm = $db->prepare(sprintf($query, $in_clause));
$stm->execute($parents);

$lastcell_name = '';
$data = array();
$vars = array();
$smps = array();
$row = null;
while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
    if ($cell['feature_name'] != $lastcell_name) {
        #featue-specific actions, only once per featue
        $lastcell_name = $cell['feature_name'];
        $data[] = array();
        $row = &$data[count($data) - 1];
        $vars[] = $cell['feature_name'];
    }

    if (count($data) == 1) {
        #sample-specific actions, only executed for first var
        $smps[] = $cell['biomaterial_name'];
    }

    $row[] = floatval($cell['value']);
}

echo json_encode(array(
    'y' => array(
        'vars' => $vars,
        'smps' => $smps,
        'data' => $data
    )
));
?>
