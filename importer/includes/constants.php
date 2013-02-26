<?php

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

#versions of databases for interpro import
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');
?>
