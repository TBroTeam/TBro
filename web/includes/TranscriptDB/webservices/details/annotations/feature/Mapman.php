<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

class Mapman extends \WebService {

    public function getById($param_isoform_id) {


        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $const = 'constant';

        $query_get_mapman = <<<EOF
SELECT 
	f.feature_id AS annotation_feature_id,
	fp.value AS feature_annotation,
        'MapMan' AS db_name,
        fdb.dbxref_id AS dbxref_id
FROM 
	feature f
	JOIN featureprop fp ON (f.feature_id = fp.feature_id)
	JOIN feature_dbxref fdb ON (f.feature_id = fdb.feature_id)
WHERE	
	f.feature_id IN (SELECT subject_id  FROM feature_relationship WHERE object_id = :isoform_id)
        AND f.type_id={$const('CV_ANNOTATION_MAPMAN_FEATURE')}

EOF;

        $query_get_dbxrefs = <<<EOF
SELECT   
        c.dbxref_id,
        c.name AS bin_accession,
	c.definition AS bin_definition,
	split_part(cp.value, '\t', 1) AS bin_annot_chem,
	split_part(cp.value, '\t', 2) AS bin_annot_definition
FROM 
	cvterm c
	LEFT JOIN cvtermprop cp ON (c.cvterm_id = cp.cvterm_id AND cp.type_id={$const('CV_ANNOTATION_MAPMAN_PROP')})        
WHERE 
        c.dbxref_id = any(ARRAY[%s])
EOF;

        $stm_get_mapman_hits = $db->prepare($query_get_mapman);
        $stm_get_mapman_hits->bindParam('isoform_id', $param_isoform_id);

        $ret = array();
        $bins = array();

        $stm_get_mapman_hits->execute();
        while ($row = $stm_get_mapman_hits->fetch(PDO::FETCH_ASSOC)) {
            $bins[$row['dbxref_id']] = array('bin_accession' => '', 'bin_definition' => '', 'bin_annotations' => array());
            $dbxref = $bins[$row['dbxref_id']];
            $ret[$row['annotation_feature_id']]= array(
                    'annotation' => $row['feature_annotation'],
                    'dbxref' => $row['dbxref_id']
                  
                );
        }

        if (count($dbxref) > 0) {
            $lookfor = array_keys($bins);
            $place_holders = implode(',', array_fill(0, count($lookfor), '? ::int'));

            $stm_get_dbxrefs = $db->prepare(sprintf($query_get_dbxrefs, $place_holders));
            $stm_get_dbxrefs->execute($lookfor);
            while ($row = $stm_get_dbxrefs->fetch(PDO::FETCH_ASSOC)) {
                $ref = &$bins[$row['dbxref_id']];
                $ref['bin_accession'] = $row['bin_accession'];
                $ref['bin_definition'] = $row['bin_definition'];
                if ($row['bin_annot_chem'] != null) {
                    $ref['bin_annotations'][] = array(
                       'bin_annot_chem' => $row['bin_annot_chem'],
                       'bin_annot_definition' => $row['bin_annot_definition']
                    );
                }
            }
            foreach ($ret as &$val){
                $val = array_merge($val, $bins[$val['dbxref']]);
            } 
        }
        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}

?>
