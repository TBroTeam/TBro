<?php

#define('DEBUG',true);
require '../inc/service_init.php';
global $_CONST, $db;

#UI hint
if (false)
    $db = new PDO();



$param_unigene_uniquename = $_REQUEST['query'] . '%';

$query_get_unigenes = <<<EOF
SELECT unigene.uniquename,
        count(*) OVER() AS full_count
    FROM feature AS unigene
    WHERE unigene.uniquename LIKE :unigene_uniquename
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    LIMIT 20
EOF;

$stm_get_unigenes = $db->prepare($query_get_unigenes);
$stm_get_unigenes->bindValue('unigene_uniquename', $param_unigene_uniquename);

$data = array('full_count' => 0, 'results' => array());

$stm_get_unigenes->execute();
while ($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) {
    if ($data['full_count'] == 0)
        $data['full_count'] = $unigene['full_count'];
    $data['results'][] = $unigene['uniquename'];
}



$json_data = $data;

echo (json_indent(json_encode($json_data)));
?>
