<?php
//file created with phing target database-initialize-cvterms
/*
$cvterm_data = array (
  'CV_ANNOTATION_REPEATMASKER' => 
  array (
    'name' => 'annotation_repeatmasker',
    'cv' => 'sequence',
    'id' => 45824,
  ),
  'CV_REPEAT_NAME' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_name',
    'cv' => 'feature_property',
    'id' => 45825,
  ),
  'CV_REPEAT_CLASS' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_class',
    'cv' => 'feature_property',
    'id' => 45826,
  ),
  'CV_REPEAT_FAMILY' => 
  array (
    'name' => 'annotation_repeatmasker_repeat_family',
    'cv' => 'feature_property',
    'id' => 45827,
  ),
  'CV_ANNOTATION_INTERPRO' => 
  array (
    'name' => 'annotation_interpro',
    'cv' => 'sequence',
    'id' => 45828,
  ),
  'CV_INTERPRO_ANALYSIS_MATCH_ID' => 
  array (
    'name' => 'annotation_interpro_analysis_match_id',
    'cv' => 'feature_property',
    'id' => 45829,
  ),
  'CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION' => 
  array (
    'name' => 'annotation_interpro_analysis_match_description',
    'cv' => 'feature_property',
    'id' => 45830,
  ),
  'CV_ANNOTATION_DESC' => 
  array (
    'name' => 'annotation_description',
    'cv' => 'feature_property',
    'id' => 45831,
  ),
  'CV_INTERPRO_ID' => 
  array (
    'name' => 'annotation_interpro_id',
    'cv' => 'feature_property',
    'id' => 45832,
  ),
  'CV_INTERPRO_DESCRIPTION' => 
  array (
    'name' => 'annotation_interpro_description',
    'cv' => 'feature_property',
    'id' => 45833,
  ),
  'CV_UNIGENE' => 
  array (
    'name' => 'unigene',
    'cv' => 'sequence',
    'id' => 45834,
  ),
  'CV_ISOFORM' => 
  array (
    'name' => 'isoform',
    'cv' => 'sequence',
    'id' => 45835,
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
    'id' => 45836,
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
    'id' => 45837,
  ),
  'WEBUSER_CART' => 
  array (
    'name' => 'webuser_data_cart',
    'cv' => 'local',
    'id' => 45838,
  ),
  'QUANTIFICATION_TYPE_EXPECTED_COUNT' => 
  array (
    'name' => 'expected_count',
    'cv' => 'Statistical Terms',
    'id' => 45839,
  ),
  'CV_ANNOTATION_MAPMAN_PROP' => 
  array (
    'name' => 'annotation_mapman',
    'cv' => 'feature_property',
    'id' => 45840,
  ),
  'CV_ANNOTATION_MAPMAN_FEATURE' => 
  array (
    'name' => 'annoation_mapman_feature',
    'cv' => 'sequence',
    'id' => 45841,
  ),
  'CV_ANNOTATION_MAPMAN_RELATIONSHIP' => 
  array (
    'name' => 'mapman_is_a',
    'cv' => 'relationship',
    'id' => 45842,
  ),
  0 => 
  array (
    'name' => 'article',
    'cv' => 'local',
    'id' => 45843,
  ),
  1 => 
  array (
    'name' => 'book',
    'cv' => 'local',
    'id' => 45844,
  ),
  2 => 
  array (
    'name' => 'booklet',
    'cv' => 'local',
    'id' => 45845,
  ),
  3 => 
  array (
    'name' => 'conference',
    'cv' => 'local',
    'id' => 45846,
  ),
  4 => 
  array (
    'name' => 'electronic',
    'cv' => 'local',
    'id' => 45847,
  ),
  5 => 
  array (
    'name' => 'inbook',
    'cv' => 'local',
    'id' => 45848,
  ),
  6 => 
  array (
    'name' => 'incollection',
    'cv' => 'local',
    'id' => 45849,
  ),
  7 => 
  array (
    'name' => 'inproceedings',
    'cv' => 'local',
    'id' => 45850,
  ),
  8 => 
  array (
    'name' => 'manual',
    'cv' => 'local',
    'id' => 45851,
  ),
  9 => 
  array (
    'name' => 'mastersthesis',
    'cv' => 'local',
    'id' => 45852,
  ),
  10 => 
  array (
    'name' => 'misc',
    'cv' => 'local',
    'id' => 45853,
  ),
  11 => 
  array (
    'name' => 'patent',
    'cv' => 'local',
    'id' => 45854,
  ),
  12 => 
  array (
    'name' => 'periodical',
    'cv' => 'local',
    'id' => 45855,
  ),
  13 => 
  array (
    'name' => 'phdthesis',
    'cv' => 'local',
    'id' => 45856,
  ),
  14 => 
  array (
    'name' => 'preamble',
    'cv' => 'local',
    'id' => 45857,
  ),
  15 => 
  array (
    'name' => 'presentation',
    'cv' => 'local',
    'id' => 45858,
  ),
  16 => 
  array (
    'name' => 'proceedings',
    'cv' => 'local',
    'id' => 45859,
  ),
  17 => 
  array (
    'name' => 'standard',
    'cv' => 'local',
    'id' => 45860,
  ),
  18 => 
  array (
    'name' => 'techreport',
    'cv' => 'local',
    'id' => 45861,
  ),
  19 => 
  array (
    'name' => 'unpublished',
    'cv' => 'local',
    'id' => 45862,
  ),
  20 => 
  array (
    'name' => 'preprint',
    'cv' => 'local',
    'id' => 45863,
  ),
);
*/    

define ('CV_ANNOTATION_REPEATMASKER', '45824');
define ('CV_REPEAT_NAME', '45825');
define ('CV_REPEAT_CLASS', '45826');
define ('CV_REPEAT_FAMILY', '45827');
define ('CV_ANNOTATION_INTERPRO', '45828');
define ('CV_INTERPRO_ANALYSIS_MATCH_ID', '45829');
define ('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION', '45830');
define ('CV_ANNOTATION_DESC', '45831');
define ('CV_INTERPRO_ID', '45832');
define ('CV_INTERPRO_DESCRIPTION', '45833');
define ('CV_UNIGENE', '45834');
define ('CV_ISOFORM', '45835');
define ('CV_RELATIONSHIP_UNIGENE_ISOFORM', '989');
define ('CV_ISOFORM_PATH', '45836');
define ('CV_PREDPEP', '219');
define ('CV_BIOMATERIAL_ISA', '32');
define ('CV_BIOMATERIAL_TYPE', '45837');
define ('WEBUSER_CART', '45838');
define ('QUANTIFICATION_TYPE_EXPECTED_COUNT', '45839');
define ('CV_ANNOTATION_MAPMAN_PROP', '45840');
define ('CV_ANNOTATION_MAPMAN_FEATURE', '45841');
define ('CV_ANNOTATION_MAPMAN_RELATIONSHIP', '45842');

?><?php
        define('DB_NAME_IMPORTS', 'local_imports');
        define('DB_ID_IMPORTS', '193');
?><?php
        define('CUSTOM_ANNOTATION_TYPE_CV', 'custom_annotation_type');
        define('CUSTOM_ANNOTATION_TYPE_CV_ID', '19');
?>