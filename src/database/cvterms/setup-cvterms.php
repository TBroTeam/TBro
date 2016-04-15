#!/usr/bin/php
<?php
define('DEBUG', false);

require_once __DIR__ . '/config.php';

require_once __DIR__ . '/db.php';
global $db;

$outfilename = __DIR__ . DIRECTORY_SEPARATOR . "cvterms.php.generated";

global $cvterms;
$cvterms = array(
    'CV_ANNOTATION_REPEATMASKER' => array(
        'name' => 'annotation_repeatmasker',
        'cv' => 'sequence'
    ),
    'CV_REPEAT_NAME' => array(
        'name' => 'annotation_repeatmasker_repeat_name',
        'cv' => 'feature_property'
    ),
    'CV_REPEAT_CLASS' => array(
        'name' => 'annotation_repeatmasker_repeat_class',
        'cv' => 'feature_property'
    ),
    'CV_REPEAT_FAMILY' => array(
        'name' => 'annotation_repeatmasker_repeat_family',
        'cv' => 'feature_property'
    ),
    'CV_ANNOTATION_INTERPRO' => array(
        'name' => 'annotation_interpro',
        'cv' => 'sequence'
    ),
    'CV_INTERPRO_ANALYSIS_MATCH_ID' => array(
        'name' => 'annotation_interpro_analysis_match_id',
        'cv' => 'feature_property'
    ),
    'CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION' => array(
        'name' => 'annotation_interpro_analysis_match_description',
        'cv' => 'feature_property'
    ),
    'CV_ANNOTATION_DESC' => array(
        'name' => 'annotation_description',
        'cv' => 'feature_property'
    ),
    'CV_INTERPRO_ID' => array(
        'name' => 'annotation_interpro_id',
        'cv' => 'feature_property'
    ),
    'CV_INTERPRO_DESCRIPTION' => array(
        'name' => 'annotation_interpro_description',
        'cv' => 'feature_property'
    ),
    'CV_UNIGENE' => array(
        'name' => 'unigene',
        'cv' => 'sequence'
    ),
    'CV_ISOFORM' => array(
        'name' => 'isoform',
        'cv' => 'sequence'
    ),
    'CV_RELATIONSHIP_UNIGENE_ISOFORM' => array(
        'name' => 'alternatively_spliced',
        'cv' => 'relationship'
    ),
    'CV_ISOFORM_PATH' => array(
        'name' => 'isoform_path',
        'cv' => 'feature_property'
    ),
    'CV_PREDPEP' => array(
        'name' => 'polypeptide',
        'cv' => 'sequence'
    ),
    'CV_BIOMATERIAL_ISA' => array(
        'name' => 'is_a',
        'cv' => 'relationship'
    ),
    'CV_BIOMATERIAL_TYPE' => array(
        'name' => 'biomaterial_type',
        'cv' => 'feature_property'
    ),
    'WEBUSER_CART' => array(
        'name' => 'webuser_data_cart',
        'cv' => 'local'
    ),
    'WEBUSER_CART' => array(
        'name' => 'webuser_data_cart',
        'cv' => 'local'
    ),
    'QUANTIFICATION_TYPE_EXPECTED_COUNT' => array(
        'name' => 'expected_count',
        'cv' => 'Statistical Terms'
    ),
    'CV_ANNOTATION_MAPMAN_PROP' => array(
        'name' => 'annotation_mapman',
        'cv' => 'feature_property'
    ),
    'CV_ANNOTATION_MAPMAN_FEATURE' => array(
        'name' => 'annoation_mapman_feature',
        'cv' => 'sequence'
    ),
    'CV_ANNOTATION_MAPMAN_RELATIONSHIP' => array(
        'name' => 'mapman_is_a',
        'cv' => 'relationship'
    ),
    array('name' => 'article', 'cv' => 'local'),
    array('name' => 'book', 'cv' => 'local'),
    array('name' => 'booklet', 'cv' => 'local'),
    array('name' => 'conference', 'cv' => 'local'),
    array('name' => 'electronic', 'cv' => 'local'),
    array('name' => 'inbook', 'cv' => 'local'),
    array('name' => 'incollection', 'cv' => 'local'),
    array('name' => 'inproceedings', 'cv' => 'local'),
    array('name' => 'manual', 'cv' => 'local'),
    array('name' => 'mastersthesis', 'cv' => 'local'),
    array('name' => 'misc', 'cv' => 'local'),
    array('name' => 'patent', 'cv' => 'local'),
    array('name' => 'periodical', 'cv' => 'local'),
    array('name' => 'phdthesis', 'cv' => 'local'),
    array('name' => 'preamble', 'cv' => 'local'),
    array('name' => 'presentation', 'cv' => 'local'),
    array('name' => 'proceedings', 'cv' => 'local'),
    array('name' => 'standard', 'cv' => 'local'),
    array('name' => 'techreport', 'cv' => 'local'),
    array('name' => 'unpublished', 'cv' => 'local'),
    array('name' => 'preprint', 'cv' => 'local'),
    array('name' => 'fullname', 'cv' => 'local')
);




$param_cvterm_name = null;
$param_cv_name = null;
$param_dbxref_id = null;


$stm_select_id = $db->prepare('SELECT cvterm_id FROM cvterm WHERE name=:cvterm_name');
$stm_select_id->bindParam('cvterm_name', $param_cvterm_name, PDO::PARAM_STR);

$stm_insert_dbxref = $db->prepare('INSERT INTO dbxref (db_id, accession) VALUES (1, concat(\'transcript_db:\', :cvterm_name::varchar)) RETURNING dbxref_id');
$stm_insert_dbxref->bindParam('cvterm_name', $param_cvterm_name, PDO::PARAM_STR);
$stm_insert_cvterm = $db->prepare(sprintf('INSERT INTO cvterm (cv_id, dbxref_id, name) VALUES (%s, :dbxref_id, :cvterm_name) RETURNING cvterm_id '
                , '(SELECT cv_id FROM cv WHERE name=:cv_name)'));
$stm_insert_cvterm->bindParam('cvterm_name', $param_cvterm_name, PDO::PARAM_STR);
$stm_insert_cvterm->bindParam('dbxref_id', $param_dbxref_id, PDO::PARAM_INT);
$stm_insert_cvterm->bindParam('cv_name', $param_cv_name, PDO::PARAM_INT);


$db->beginTransaction();
foreach ($cvterms as $cvterm_const => &$cvterm) {
    $param_cvterm_name = $cvterm['name'];

    $stm_select_id->execute();

    if (($cvterm_id = $stm_select_id->fetchColumn()) != false) {
//already exists in DB
        $cvterm['id'] = $cvterm_id;
    } else {
        echo "insert\n";
//does not exist in DB, insert
#param_cvterm_name is already set
        $stm_insert_dbxref->execute();

        $param_dbxref_id = $stm_insert_dbxref->fetchColumn();
        $param_cv_name = $cvterm['cv'];
#param_cvterm_name is already set
        $stm_insert_cvterm->execute();
        $cvterm_id = $stm_insert_cvterm->fetchColumn();
        $cvterm['id'] = $cvterm_id;
    }
}
unset($cvterm);
$db->commit();

$insert = "";
foreach ($cvterms as $cvterm_const => $cvterm) {
    //skip lines without const
    if (is_int($cvterm_const)) continue;
    
    $insert .= sprintf("define ('%s', '%s');\n", $cvterm_const, $cvterms[$cvterm_const]['id']);
}


$export = var_export($cvterms, true);

$cvterms_output = <<<EOF
<?php
//file created with phing target database-initialize-cvterms
/*
\$cvterm_data = $export;
*/    

$insert
?>
EOF;


//other
$const_local_imports = 'local_imports';
$stm = $db->prepare("SELECT db_id FROM db WHERE name=?");
$stm->execute(array($const_local_imports));
if ($stm->rowCount() == 0) {
    $stm = $db->prepare("INSERT INTO db (name) VALUES (?) RETURNING db_id");
    $stm->execute(array($const_local_imports));
}
$const_id_imports = $stm->fetchColumn();
unset($stm);

$cvterms_output .= <<<EOF
<?php
        define('DB_NAME_IMPORTS', '$const_local_imports');
        define('DB_ID_IMPORTS', '$const_id_imports');
?>
EOF;


file_put_contents($outfilename, $cvterms_output);
?>