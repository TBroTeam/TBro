<?php

namespace webservices\details;

require_once 'TranscriptDB//db.php';
/**
 * Web Service.
 * Get details on all passed feature_ids. Takes either one url parameter or an array as POST variable "terms"
 */
class Features extends \WebService {

    /**
     * @inheritDoc
     * @param int $querydata['query1'] one id
     * @param Array[int] $querydata['terms'] multiple ids
     */
    public function execute($querydata) {
        $feature_ids = array();

        if (isset($querydata['query1']))
            $feature_ids[] = $querydata['query1'];

        if (isset($querydata['terms']))
            $feature_ids = array_merge($feature_ids, $querydata['terms']);

        
        $ret = array('results' => array());
        if (count($feature_ids) == 0) {
            return $ret;
        }

        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        global $db;
        $constant = 'constant';

        $query = <<<EOF
    SELECT
    feature.feature_id, feature.name, dbxref.accession AS dataset, organism.common_name AS organism, type_id, COALESCE((
    SELECT s.name 
    FROM feature_synonym fs, synonym s 
    WHERE fs.feature_id=feature.feature_id 
    AND s.synonym_id=fs.synonym_id 
    AND s.type_id=(SELECT type_id FROM cvterm WHERE name='symbol' LIMIT 1)
    LIMIT 1
    ),'') AS alias
    FROM feature
        JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (feature.organism_id = organism.organism_id)
    WHERE feature.feature_id IN ($place_holders)
EOF;
//var_dump($query);

        $stm = $db->prepare($query);
        $stm->execute($feature_ids);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            switch ($row['type_id']) {
                case CV_ISOFORM:
                    $row['type'] = 'isoform';
                    break;
                case CV_UNIGENE:
                    $row['type'] = 'unigene';
                    break;
                default:
                    $row['type'] = 'unknown';
                    break;
            }
            unset($row['type_id']);
            $ret['results'][] = $row;
        }
        return $ret;
    }

}

?>
