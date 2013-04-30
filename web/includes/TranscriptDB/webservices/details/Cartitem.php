<?php

namespace webservices\details;

require_once 'TranscriptDB//db.php';

class Cartitem extends \WebService {

    public function execute($querydata) {
        $feature_id = $querydata['query1'];

        global $db;
        $constant = 'constant';

        $query = <<<EOF
SELECT
    feature.feature_id, feature.name, type_id, dbxref.accession AS dataset, organism.common_name AS organism
    FROM feature
        JOIN feature_dbxref ON (feature_dbxref.feature_id = feature.feature_id)
        JOIN dbxref ON (feature_dbxref.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (feature.organism_id = organism.organism_id)
WHERE feature.feature_id = :feature_id
LIMIT 1
EOF;

        $stm = $db->prepare($query);
        $stm->bindValue('feature_id', $feature_id, \PDO::PARAM_INT);
        $stm->execute();
        $ret = $stm->fetch(\PDO::FETCH_ASSOC);
        switch ($ret['type_id']) {
            case CV_ISOFORM:
                $ret['type'] = 'isoform';
                break;
            case CV_UNIGENE:
                $ret['type'] = 'unigene';
                break;
            default:
                $ret['type'] = 'unknown';
        }
        unset($ret['type_id']);
        return $ret;
    }

}

?>
