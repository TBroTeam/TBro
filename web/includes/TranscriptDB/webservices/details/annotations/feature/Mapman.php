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

        $query_get_isoform_dbxrefs = <<<EOF
SELECT 
	fr.object_id AS parent_feature_id,
	f.feature_id AS annotation_feature_id,
	fp.value AS feature_annotation,
	--db.name AS db_name,
        'MapMan' AS db_name,
	c.name AS bin_accession,
	c.definition AS bin_definition,
	split_part(cp.value, '\t', 1) AS bin_annot_chem,
	split_part(cp.value, '\t', 2) AS bin_annot_definition
FROM 
	feature_relationship fr
	LEFT JOIN feature f ON (f.feature_id = fr.subject_id AND f.type_id={$const('CV_ANNOTATION_MAPMAN_FEATURE')})
	JOIN featureprop fp ON (f.feature_id = fp.feature_id)
	JOIN feature_dbxref fdb ON (f.feature_id = fdb.feature_id)
	--JOIN dbxref dbx ON (fdb.dbxref_id = dbx.dbxref_id) --unneccesary if we don't join DB
	--JOIN db ON (dbx.db_id = db.db_id)
	JOIN cvterm c ON (fdb.dbxref_id = c.dbxref_id)
	LEFT JOIN cvtermprop cp ON (c.cvterm_id = cp.cvterm_id AND cp.type_id={$const('CV_ANNOTATION_MAPMAN_PROP')})
WHERE	
	fr.object_id = :isoform_id
EOF;

        $stm_get_mapman_hits = $db->prepare($query_get_isoform_dbxrefs);
        $stm_get_mapman_hits->bindParam('isoform_id', $param_isoform_id);

        $ret = array();

        $stm_get_mapman_hits->execute();
        while ($row = $stm_get_mapman_hits->fetch(PDO::FETCH_ASSOC)) {
            $ref = &$ret[$row['annotation_feature_id']];
            if (!is_array($ref))
                $ref = array(
                    'annotation' => $row['feature_annotation'],
                    'bin_accession' => $row['bin_accession'],
                    'bin_definition' => $row['bin_definition'],
                    'bin_annotations' => array(/*
                        array(
                            'bin_annot_chem' => 'chem1',
                            'bin_annot_definition' => "desc1"
                        ),
                        array(
                            'bin_annot_chem' => 'chem2',
                            'bin_annot_definition' => "desc2"
                        ),
                    */)
                );
            if ($row['bin_annot_chem'] != null)
                $ref['bin_annotations'][] = array(
                    'bin_annot_chem' => $row['bin_annot_chem'],
                    'bin_annot_definition' => $row['bin_annot_definition']
                );
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}

?>
