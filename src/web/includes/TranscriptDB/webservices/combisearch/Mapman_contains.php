<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features with MapMan description.
 */
class Mapman_contains extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @param $querydata[term] term to search for
     * @returns array of feature ids
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $release = $querydata['release'];

        $term = sprintf('%%%s%%', trim($querydata['term']));

        $query_get_features = <<<EOF
          
SELECT relationship.object_id AS feature_id FROM featureprop, 
	(SELECT subject_id, object_id 
            FROM feature_relationship 
            WHERE type_id={$constant('CV_ANNOTATION_MAPMAN_RELATIONSHIP')}
            AND object_id IN (SELECT feature_id 
		FROM feature 
		WHERE feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')})
		AND feature.organism_id =:species
		AND feature.dbxref_id = 
		(SELECT dbxref_id 
			FROM dbxref 
			WHERE db_id={$constant('DB_ID_IMPORTS')} 
			AND accession=:release 
			LIMIT 1
		)
            )
        ) AS relationship
	WHERE featureprop.feature_id=relationship.subject_id
	AND featureprop.value LIKE :term
EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array(
            'term' => $term,
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
