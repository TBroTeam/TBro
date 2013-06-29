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
  'CV_ANNOTATION_DESC' => 
  array (
    'name' => 'annotation_description',
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
    'name' => 'unigene',
    'cv' => 'sequence',
    'id' => 42825,
  ),
  'CV_ISOFORM' => 
  array (
    'name' => 'isoform',
    'cv' => 'sequence',
    'id' => 42826,
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
    'id' => 42827,
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
  'CV_BIOMATERIAL_TYPE' => 
  array (
    'name' => 'biomaterial_type',
    'cv' => 'feature_property',
    'id' => 42828,
  ),
  'WEBUSER_CART' => 
  array (
    'name' => 'webuser_data_cart',
    'cv' => 'local',
    'id' => 42829,
  ),
  'QUANTIFICATION_TYPE_EXPECTED_COUNT' => 
  array (
    'name' => 'expected_count',
    'cv' => 'Statistical Terms',
    'id' => 42830,
  ),
  'CV_ANNOTATION_MAPMAN_PROP' => 
  array (
    'name' => 'annotation_mapman',
    'cv' => 'feature_property',
    'id' => 42852,
  ),
  'CV_ANNOTATION_MAPMAN_FEATURE' => 
  array (
    'name' => 'annoation_mapman_feature',
    'cv' => 'sequence',
    'id' => 42853,
  ),
  'CV_ANNOTATION_MAPMAN_RELATIONSHIP' => 
  array (
    'name' => 'mapman_is_a',
    'cv' => 'relationship',
    'id' => 42854,
  ),
  0 => 
  array (
    'name' => 'article',
    'cv' => 'local',
    'id' => 42831,
  ),
  1 => 
  array (
    'name' => 'book',
    'cv' => 'local',
    'id' => 42832,
  ),
  2 => 
  array (
    'name' => 'booklet',
    'cv' => 'local',
    'id' => 42833,
  ),
  3 => 
  array (
    'name' => 'conference',
    'cv' => 'local',
    'id' => 42834,
  ),
  4 => 
  array (
    'name' => 'electronic',
    'cv' => 'local',
    'id' => 42835,
  ),
  5 => 
  array (
    'name' => 'inbook',
    'cv' => 'local',
    'id' => 42836,
  ),
  6 => 
  array (
    'name' => 'incollection',
    'cv' => 'local',
    'id' => 42837,
  ),
  7 => 
  array (
    'name' => 'inproceedings',
    'cv' => 'local',
    'id' => 42838,
  ),
  8 => 
  array (
    'name' => 'manual',
    'cv' => 'local',
    'id' => 42839,
  ),
  9 => 
  array (
    'name' => 'mastersthesis',
    'cv' => 'local',
    'id' => 42840,
  ),
  10 => 
  array (
    'name' => 'misc',
    'cv' => 'local',
    'id' => 42841,
  ),
  11 => 
  array (
    'name' => 'patent',
    'cv' => 'local',
    'id' => 42842,
  ),
  12 => 
  array (
    'name' => 'periodical',
    'cv' => 'local',
    'id' => 42843,
  ),
  13 => 
  array (
    'name' => 'phdthesis',
    'cv' => 'local',
    'id' => 42844,
  ),
  14 => 
  array (
    'name' => 'preamble',
    'cv' => 'local',
    'id' => 42845,
  ),
  15 => 
  array (
    'name' => 'presentation',
    'cv' => 'local',
    'id' => 42846,
  ),
  16 => 
  array (
    'name' => 'proceedings',
    'cv' => 'local',
    'id' => 42847,
  ),
  17 => 
  array (
    'name' => 'standard',
    'cv' => 'local',
    'id' => 42848,
  ),
  18 => 
  array (
    'name' => 'techreport',
    'cv' => 'local',
    'id' => 42849,
  ),
  19 => 
  array (
    'name' => 'unpublished',
    'cv' => 'local',
    'id' => 42850,
  ),
  20 => 
  array (
    'name' => 'preprint',
    'cv' => 'local',
    'id' => 42851,
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
define ('CV_ANNOTATION_DESC', '42823');
define ('CV_INTERPRO_ID', '42824');
define ('CV_UNIGENE', '42825');
define ('CV_ISOFORM', '42826');
define ('CV_RELATIONSHIP_UNIGENE_ISOFORM', '989');
define ('CV_ISOFORM_PATH', '42827');
define ('CV_PREDPEP', '219');
define ('CV_BIOMATERIAL_ISA', '32');
define ('CV_BIOMATERIAL_TYPE', '42828');
define ('WEBUSER_CART', '42829');
define ('QUANTIFICATION_TYPE_EXPECTED_COUNT', '42830');
define ('CV_ANNOTATION_MAPMAN_PROP', '42852');
define ('CV_ANNOTATION_MAPMAN_FEATURE', '42853');
define ('CV_ANNOTATION_MAPMAN_RELATIONSHIP', '42854');

?><?php
        define('DB_NAME_IMPORTS', 'local_imports');
        define('DB_ID_IMPORTS', '177');
?>