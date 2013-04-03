#!/usr/bin/php
<?php
define('DEBUG', false);
define('INC', __DIR__ . '/../includes/');

$outfilename = "setup-cvterms.latest";

require_once INC . '/db.php';
require_once INC . '/constants.php';
global $db, $_CONST;


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
    'CV_ANNOTATION_BLAST2GO' => array(
        'name' => 'annotation_blast2go',
        'cv' => 'feature_property'
    ),
    'CV_INTERPRO_ID' => array(
        'name' => 'annotation_interpro_id',
        'cv' => 'feature_property'
    ),
    'CV_UNIGENE' => array(
        'name' => 'predicted gene',
        'cv' => 'sequence'
    ),
    'CV_ISOFORM' => array(
        'name' => 'alternatively_spliced_transcript',
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
);

$param_cvterm_name = null;
$param_cv_name = null;
$param_dbxref_id = null;

if (false)
    $db = new PDO();

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

    if ($_CONST($cvterm_const) != $cvterm['id']) {
        printf("-- constant %s has changed: %d => %d", $cvterm_const, $_CONST($cvterm_const), $cvterm['id']);
        print(" suggested query:\n");
        switch ($cvterm['cv']) {
            case 'sequence':
                printf('UPDATE feature SET type_id=%2$d WHERE type_id=%1$d;', $_CONST($cvterm_const), $cvterm['id']);
                break;
            case 'feature_property':
                printf('UPDATE featureprop SET type_id=%2$d WHERE type_id=%1$d;', $_CONST($cvterm_const), $cvterm['id']);
                break;
            case 'relationship':
                if (strpos(strtolower($cvterm_const), 'biomaterial') !== false) {
                    printf('UPDATE biomaterial_relationship SET type_id=%2$d WHERE type_id=%1$d;', $_CONST($cvterm_const), $cvterm['id']);
                } else {
                    printf('UPDATE feature_relationship SET type_id=%2$d WHERE type_id=%1$d;', $_CONST($cvterm_const), $cvterm['id']);
                }
                break;
        }
        print "\n";
    }
}
unset ($cvterm);
$db->commit();

print "\n\n\n";
print "data file output to $outfilename. copy to includes/cvterms.php\n";

$insert = "";
foreach ($cvterms as $cvterm_const => $cvterm) {
    $insert .= sprintf("define ('%s', '%s');\n", $cvterm_const, $cvterms[$cvterm_const]['id']);
}


$export = var_export($cvterms, true);

$cvterms_output = <<<EOF
<?php
//file created with the script database/setup-cvterms.php
/*
\$cvterm_data = $export;
*/    

$insert
?>
EOF;


file_put_contents($outfilename, $cvterms_output);
?>