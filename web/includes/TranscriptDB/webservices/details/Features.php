<?php

namespace webservices\details;

require_once 'TranscriptDB//db.php';

class Features extends \WebService {

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

        $query = <<<EOF
    SELECT
    feature.feature_id, feature.name, type_id, COALESCE((
    SELECT s.name 
    FROM feature_synonym fs, synonym s 
    WHERE fs.feature_id=feature.feature_id 
    AND s.synonym_id=fs.synonym_id 
    AND s.type_id=(SELECT type_id FROM cvterm WHERE name='symbol' LIMIT 1)
    LIMIT 1
    ),'') AS alias
    FROM feature
    WHERE feature.feature_id IN ($place_holders)
EOF;
        
        /*

SELECT
    feature.feature_id, feature.name, type_id, (SELECT * FROM )
    FROM feature
WHERE feature.feature_id IN ($place_holders)
         * 
         * SELECT
    feature.feature_id, feature.name, type_id, (
    SELECT s.name 
    FROM feature_synonym fs, synonym s 
    WHERE fs.feature_id=feature.feature_id 
    AND s.synonym_id=fs.synonym_id 
    AND s.type_id=(SELECT type_id FROM cvterm WHERE name='symbol' LIMIT 1)
    LIMIT 1
    )
    FROM feature
WHERE feature.feature_id IN (152073, 538848)
         */

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
