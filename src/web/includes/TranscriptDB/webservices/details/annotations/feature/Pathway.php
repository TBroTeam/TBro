<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

/**
 * Web Service.
 * Returns all Dbxrefs associated with specified feature, grouped by GO namespaces if GO.
 */
class Pathway extends \WebService {

    public function getById($param_isoform_id) {
        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $query_get_isoform_pathways = <<<EOF
SELECT accession, path.definition, path.ec FROM dbxref, 
    (SELECT * FROM cvterm, 
        (SELECT subject_id, x.accession AS ec FROM cvterm_relationship AS r, 
            (SELECT * FROM feature_dbxref 
                JOIN dbxref ON (dbxref.dbxref_id = feature_dbxref.dbxref_id) 
                LEFT JOIN cvterm ON (cvterm.dbxref_id = dbxref.dbxref_id)
                    WHERE feature_id=:isoform_id AND db_id=116
             ) AS x 
             WHERE r.object_id=x.cvterm_id
        ) AS rel
	WHERE cvterm.cvterm_id=rel.subject_id
    ) AS path
    WHERE dbxref.dbxref_id=path.dbxref_id
EOF;

        $stm_get_isoform_pathways = $db->prepare($query_get_isoform_pathways);
        $stm_get_isoform_pathways->bindParam('isoform_id', $param_isoform_id);

        $ret = array();

        $stm_get_isoform_pathways->execute();
        while ($isoform_pathway = $stm_get_isoform_pathways->fetch(PDO::FETCH_ASSOC)) {
                $ret[] = $isoform_pathway;
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}
?>
