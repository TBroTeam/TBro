<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

class Dbxref extends \WebService {

    public function getById($param_isoform_id) {


        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $query_get_isoform_dbxrefs = <<<EOF
SELECT 
  DISTINCT ON (cvterm.dbxref_id, cv.cv_id)
  db.name AS dbname, dbxref.accession, dbxref.version AS dbversion, cvterm.name AS name, cvterm.definition AS definition, cv.name AS go_namespace 
FROM 
  feature_dbxref
  JOIN dbxref ON (dbxref.dbxref_id = feature_dbxref.dbxref_id)
  JOIN db ON (db.db_id = dbxref.db_id)
  LEFT JOIN cvterm ON (cvterm.dbxref_id = dbxref.dbxref_id)
  LEFT JOIN cv ON (cv.cv_id = cvterm.cv_id)
WHERE 
  feature_dbxref.feature_id = :isoform_id
EOF;

        $stm_get_isoform_dbxrefs = $db->prepare($query_get_isoform_dbxrefs);
        $stm_get_isoform_dbxrefs->bindParam('isoform_id', $param_isoform_id);

        $ret = array();

        $stm_get_isoform_dbxrefs->execute();
        while ($isoform_dbxref = $stm_get_isoform_dbxrefs->fetch(PDO::FETCH_ASSOC)) {
                $ret[$isoform_dbxref['dbname']][$isoform_dbxref['go_namespace']][] = $isoform_dbxref;
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}
?>
