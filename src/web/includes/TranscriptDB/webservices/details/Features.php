<?php

namespace webservices\details;

require_once 'TranscriptDB//db.php';
require_once 'Zend/Cache.php';

/**
 * Web Service.
 * Get details on all passed feature_ids. Takes either one url parameter or an array as POST variable "terms"
 */
class Features extends \WebService {

    public function execute($querydata) {
        $feature_ids = array();
        $with_descriptions = true;

        if (isset($querydata['query1']) && !empty($querydata['query1']))
            $feature_ids[] = $querydata['query1'];

        if (isset($querydata['terms']))
            $feature_ids = array_merge($feature_ids, $querydata['terms']);

        if (isset($querydata['no_description']))
            $with_descriptions = false;

        $cache = \Zend_Cache::factory(
                        'Core', 'Memcached', array('caching' => true, 'lifetime' => '3600', 'automatic_serialization' => true), array('servers' => array(array('host' => 'localhost', 'port' => 11211, 'persistent' => true, 'weight' => 1, 'timeout' => 5, 'retry_interval' => 15, 'status' => true)))
        );

        $return = array('results' => array());
        $uncached_ids = array();
        foreach ($feature_ids as $id) {
            if (($feature = $cache->load(strval($id))) === false)
                $uncached_ids[] = $id;
            else
                $return['results'][] = $feature;
        }

        if (count($uncached_ids) > 0) {
            $new_features = $this->query_database($uncached_ids, $with_descriptions);

            foreach ($new_features['results'] as $new_feature) {
                $cache->save($new_feature, strval($new_feature['feature_id']));
                $return['results'][] = $new_feature;
            }
        }

        return $return;
    }

    /**
     * @inheritDoc
     * @param int $querydata['query1'] one id
     * @param Array[int] $querydata['terms'] multiple ids
     */
    public function query_database($feature_ids, $with_descriptions) {
        
        $ret = array('results' => array());
        if (count($feature_ids) == 0) {
            return $ret;
        }

        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        global $db;
        $constant = 'constant';

        $query;
        
        if($with_descriptions){           
        $query = <<<EOF
        SELECT raw.*, fp.value AS description FROM (SELECT
    feature.feature_id, feature.name, dbxref.accession AS dataset, organism.common_name AS organism, type_id, COALESCE((
    SELECT s.name 
    FROM feature_synonym fs, synonym s 
    WHERE fs.feature_id=feature.feature_id 
    AND s.synonym_id=fs.synonym_id 
    AND s.type_id=(SELECT type_id FROM cvterm c WHERE name='symbol' LIMIT 1)
    LIMIT 1
    ),'') AS alias
    FROM feature
        JOIN dbxref ON (feature.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (feature.organism_id = organism.organism_id)
    WHERE feature.feature_id IN ($place_holders)) AS raw LEFT JOIN (SELECT feature_id, value FROM featureprop WHERE featureprop.type_id={$constant('CV_ANNOTATION_DESC')}) AS fp
    ON raw.feature_id=fp.feature_id
EOF;
        }
        else{
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
        }


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
            // if description is null: set to empty string
            if(is_null ( $row['description'] )) 
                $row['description'] = '';
            $ret['results'][] = $row;
        }
        return $ret;
    }

}

?>
