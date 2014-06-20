<?php

namespace webservices\listing;

require_once 'TranscriptDB//db.php';

/**
 * Web Service.
 * Split the input array of feature_ids into two sub arrays (unigene, isoform).isoform.
 */
class Filter_by_type extends \WebService {

    public function execute($querydata) {
        $feature_ids = array();

        if (isset($querydata['ids']))
            $feature_ids = $querydata['ids'];

        $return = array('isoform' => array(), 'unigene' => array());

        $return['unigene'] = $this->query_database($feature_ids, TRUE);
        $return['isoform'] = $this->query_database($feature_ids, FALSE);

        return $return;
    }

    /**
     * @inheritDoc
     * @param Array[int] $querydata['ids'] multiple ids
     * @param boolean $filter_unigenes toggles filtering for unigenes (true) or isoforms (false)
     */
    public function query_database($feature_ids, $filter_unigenes) {

        $ret = array();
        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        global $db;
        $constant = 'constant';

        $query = "";
        
        if($filter_unigenes){
        $query = <<<EOF
    SELECT
    feature.feature_id
    FROM feature
        JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (feature.organism_id = organism.organism_id)
    WHERE feature.type_id={$constant('CV_UNIGENE')} AND feature.feature_id IN ($place_holders)
EOF;
    } else {
                $query = <<<EOF
    SELECT
    feature.feature_id
    FROM feature
        JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (feature.organism_id = organism.organism_id)
    WHERE feature.type_id={$constant('CV_ISOFORM')} AND feature.feature_id IN ($place_holders)
EOF;
    }
//var_dump($query);

        $stm = $db->prepare($query);
        $stm->execute($feature_ids);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $ret[] = $row['feature_id'];
        }
        return $ret;
    }

}

?>
