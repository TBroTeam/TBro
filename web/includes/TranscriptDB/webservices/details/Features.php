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

        $place_holders = implode(',', array_fill(0, count($feature_ids), '? ::int'));

        global $db;

        $constant = 'constant';

        $query = <<<EOF
SELECT
    feature.feature_id, feature.name, type_id
    FROM feature
WHERE feature.feature_id = ANY(ARRAY[$place_holders])
EOF;

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
            $row['alias'] = '';
            unset($row['type_id']);
            $ret['results'][] = $row;
        }
        return $ret;
    }

}

?>
