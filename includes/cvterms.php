<?php
//file created with the script database/setup-cvterms.php
/*
$cvterm_data = array (
  'CV_ANNOTATION_REPEATMASKER' => 
  array (
    'name' => 'annotation_repeatmasker',
    'cv' => 'sequence',
    'id' => 42816,
  ),
  'CV_REPEAT_NAME' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_name',
    'cv' => 'feature_property',
    'id' => 42817,
  ),
  'CV_REPEAT_CLASS' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_class',
    'cv' => 'feature_property',
    'id' => 42818,
  ),
  'CV_REPEAT_FAMILY' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_family',
    'cv' => 'feature_property',
    'id' => 42819,
  ),
  'CV_ANNOTATION_INTERPRO' => 
  array (
    'name' => 'annotation_interpro',
    'cv' => 'sequence',
    'id' => 42820,
  ),
  'CV_INTERPRO_ANALYSIS_MATCH_ID' => 
  array (
    'name' => 'annotation_interpro_analysis_match_id',
    'cv' => 'feature_property',
    'id' => 42821,
  ),
  'CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION' => 
  array (
    'name' => 'annotation_interpro_analysis_match_description',
    'cv' => 'feature_property',
    'id' => 42822,
  ),
  'CV_ANNOTATION_BLAST2GO' => 
  array (
    'name' => 'annotation_blast2go',
    'cv' => 'feature_property',
    'id' => 42823,
  ),
  'CV_INTERPRO_ID' => 
  array (
    'name' => 'annotation_interpro_id',
    'cv' => 'feature_property',
    'id' => 42824,
  ),
  'CV_UNIGENE' => 
  array (
    'name' => 'predicted gene',
    'cv' => 'sequence',
    'id' => 42825,
  ),
  'CV_ISOFORM' => 
  array (
    'name' => 'alternatively_spliced_transcript',
    'cv' => 'sequence',
    'id' => 2218,
  ),
  'CV_RELATIONSHIP_UNIGENE_ISOFORM' => 
  array (
    'name' => 'alternatively_spliced',
    'cv' => 'relationship',
    'id' => 989,
  ),
  'CV_ISOFORM_PATH' => 
  array (
    'name' => 'isoform_path',
    'cv' => 'feature_property',
    'id' => 42826,
  ),
  'CV_PREDPEP' => 
  array (
    'name' => 'polypeptide',
    'cv' => 'sequence',
    'id' => 219,
  ),
  'CV_BIOMATERIAL_ISA' => 
  array (
    'name' => 'is_a',
    'cv' => 'relationship',
    'id' => 32,
  ),
  'WEBUSER_CART' => 
  array (
    'name' => 'webuser_data_cart',
    'cv' => 'local',
    'id' => 42827,
  ),
  'QUANTIFICATION_TYPE_EXPECTED_COUNT' => 
  array (
    'name' => 'expected_count',
    'cv' => 'Statistical Terms',
    'id' => 42828,
  ),
);
*/    

define ('CV_ANNOTATION_REPEATMASKER', '42816');
define ('CV_REPEAT_NAME', '42817');
define ('CV_REPEAT_CLASS', '42818');
define ('CV_REPEAT_FAMILY', '42819');
define ('CV_ANNOTATION_INTERPRO', '42820');
define ('CV_INTERPRO_ANALYSIS_MATCH_ID', '42821');
define ('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION', '42822');
define ('CV_ANNOTATION_BLAST2GO', '42823');
define ('CV_INTERPRO_ID', '42824');
define ('CV_UNIGENE', '42825');
define ('CV_ISOFORM', '2218');
define ('CV_RELATIONSHIP_UNIGENE_ISOFORM', '989');
define ('CV_ISOFORM_PATH', '42826');
define ('CV_PREDPEP', '219');
define ('CV_BIOMATERIAL_ISA', '32');
define ('WEBUSER_CART', '42827');
define ('QUANTIFICATION_TYPE_EXPECTED_COUNT', '42828');

?><?php
        define('DB_NAME_IMPORTS', 'local_imports');
        define('DB_ID_IMPORTS', '177');
?>