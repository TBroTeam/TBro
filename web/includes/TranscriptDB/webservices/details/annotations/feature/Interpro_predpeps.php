<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

class Interpro_predpeps extends \WebService {

    public function getById($param_feature_id) {
        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $constant = 'constant';
        $param_predpep_id = null;

        $query_get_predpeps = <<<EOF
SELECT predpep.*, featureloc.* 
    FROM feature AS predpep, featureloc 
    WHERE featureloc.feature_id=predpep.feature_id 
        AND featureloc.srcfeature_id=:isoform_id
        AND predpep.type_id = {$constant('CV_PREDPEP')}
EOF;

        $stm_get_predpeps = $db->prepare($query_get_predpeps);
        $stm_get_predpeps->bindParam('isoform_id', $param_feature_id);

        $stm_get_interpro = $db->prepare('SELECT * FROM get_predpep_annotations_interpro(ARRAY[:predpep_id::int])');
        $stm_get_interpro->bindParam('predpep_id', $param_predpep_id);

        $query_get_interpro_dbxrefs = <<<EOF
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
  feature_dbxref.feature_id = :interpro_feature_id                
EOF;

        $stm_get_interpro_dbxref = $db->prepare($query_get_interpro_dbxrefs);
        $stm_get_interpro_dbxref->bindParam('interpro_feature_id', $param_interpro_feature_id);

        $ret = array();

        $stm_get_predpeps->execute();
        while ($predpep = $stm_get_predpeps->fetch(PDO::FETCH_ASSOC)) {
            $ret[] = $predpep;
            $current = &$ret[count($ret) - 1];

            $param_predpep_id = $predpep['feature_id'];
            $stm_get_interpro->execute();
            while ($interpro = $stm_get_interpro->fetch(PDO::FETCH_ASSOC)) {
                $current['interpro'][] = $interpro;
                $curr_interpro = &$current['interpro'][count($current['interpro']) - 1];
                $param_interpro_feature_id = $interpro['feature_id'];
                $stm_get_interpro_dbxref->execute();
                while ($interpro_dbxref = $stm_get_interpro_dbxref->fetch(PDO::FETCH_ASSOC)) {
                    $curr_interpro['dbxref'][] = $interpro_dbxref;
                }
            }
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}

?>
