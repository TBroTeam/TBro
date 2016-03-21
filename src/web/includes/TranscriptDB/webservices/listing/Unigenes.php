<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns list of Unigene ids for Isoforms
 */
class Unigenes extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {

        global $db;
        $constant = 'constant';
        #UI hint
        if (false)
            $db = new PDO();
        
        $feature_ids = array();
        if (isset($querydata['query1']) && !empty($querydata['query1']))
            $feature_ids[] = $querydata['query1'];

        if (isset($querydata['terms']))
            $feature_ids = array_merge($feature_ids, $querydata['terms']);

        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        $query_get_unigenes = <<<EOF
SELECT DISTINCT unigene.feature_id
    FROM feature_relationship, feature AS unigene
    WHERE unigene.feature_id = feature_relationship.object_id
    AND feature_relationship.subject_id IN ($place_holders)
    AND unigene.type_id = {$constant('CV_UNIGENE')}
EOF;

        $stm_get_unigenes = $db->prepare($query_get_unigenes);

        $data = array();

        $stm_get_unigenes->execute($feature_ids);
        while ($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) {
            $data['unigenes'][] = $unigene['feature_id'];
        }

        return $data;
    }

}

?>
