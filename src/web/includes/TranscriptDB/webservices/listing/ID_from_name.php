<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns all Features for an Organism and Release
 */
class ID_from_name extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @param $querydata[names] array of feature names
     * @returns array of feature ids
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $release = $querydata['release'];
        $names = $querydata['names'];
        $place_holders = implode(',', array_fill(0, count($names), '?'));

        $query_get_feature_ids = <<<EOF
           
SELECT feature_id, name FROM feature 
    WHERE feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')})
        AND feature.organism_id = ?
        AND feature.dbxref_id = 
            (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=? LIMIT 1)
        AND feature.name IN ($place_holders)

EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

            
        $stm_get_feature_ids = $db->prepare($query_get_feature_ids);

        $data = array('results' => array());

        $replacement = array_merge(array($species, $release), $names);
        $stm_get_feature_ids->execute($replacement);
                
        while ($row = $stm_get_feature_ids->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][$row['name']] = $row['feature_id'];
        }
        
        return $data;
    }

}

?>
