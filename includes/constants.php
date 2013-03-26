<?php
if ((isset($_SERVER['SERVER_NAME']) && in_array(strtolower($_SERVER['SERVER_NAME']), array('sadrithmora'))) 
        || (isset($_SERVER['HOSTNAME']) && strtolower($_SERVER['HOSTNAME']) == 'sadrithmora')) {
    define('DB_SERVER', '127.0.0.1');
    define('DB_USERNAME', 's202139');
    define('DB_PASSWORD', 's202139');
    define('DB_DB', 'dionaea_transcript_db_dev_test1');
} else {
    define('DB_SERVER', '132.187.22.155');
    define('DB_USERNAME', 's202139');
    define('DB_PASSWORD', 's202139');
    define('DB_DB', 'dionaea_transcript_db_dev_test1');
}

define('ASSEMBLY_PREFIX', '1.01_');
define('DB_ORGANISM_ID', '13');
define('DUMMY', 123);
define('CV_ANNOTATION_REPEATMASKER', 124);
define('CV_ANNOTATION_INTERPRO', 125);
define('CV_ANNOTATION_BLAST2GO', 126);

define('CV_INTERPRO_ID', 127);

define('CV_UNIGENE', 780); #CVTERM 1080: "predicted gene" or 780: "gene_with_recorded_mRNA' ?
define('CV_ISOFORM', 2191); #CVTERM 2191: alternatively_spliced_transcript
define('CV_RELATIONSHIP_UNIGENE_ISOFORM', 962); #CVTERM 962: alternatively_spliced  

define('CV_ISOFORM_PATH', 775); #CVTERM 775: golden_path
define('CV_PREDPEP', 192); #CVTERM 192: polypeptide

define('CV_REPEAT_NAME', 128);
define('CV_REPEAT_CLASS', 129);
define('CV_REPEAT_FAMILY', 130);

define('CV_BIOMATERIAL_ISA', 32);

define('LINES_IMPORTED', 'datasets_imported');

define('CV_INTERPRO_ANALYSIS_MATCH_ID', 131);
define('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION', 132);

#versions of databases for interpro import
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');

global $_CONST;
$_CONST = 'constant';




?>
