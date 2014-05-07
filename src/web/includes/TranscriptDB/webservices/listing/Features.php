<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns all Features for an Organism and Release
 */
class Features extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @returns array of feature ids
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $release = $querydata['release'];

        $query_get_features = <<<EOF
           
SELECT feature_id FROM feature 
    WHERE feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')})
        AND feature.organism_id = :species 
        AND feature.dbxref_id = 
            (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=:release LIMIT 1)

EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array(
            'species' => $species,
            'release' => $release
        ));
        
        while ($row = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $row['feature_id'];
        }
        $data['results'] = array_unique($data['results']);
        
        return $data;
    }

}

?>
