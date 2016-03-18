<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features which description contains a phrase.
 */
class Interpro_match_description extends \WebService {

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

        $term = strtoupper(sprintf('%%%s%%', trim($querydata['term'])));

        $query_get_features = <<<EOF
           
SELECT feature.feature_id FROM feature, 
	(SELECT featureloc.srcfeature_id FROM featureloc, 
		(SELECT DISTINCT srcfeature_id FROM featureloc, 
			(SELECT feature_id FROM featureprop WHERE type_id={$constant('CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION')} AND UPPER(value) LIKE :term) AS fi
		WHERE featureloc.feature_id = fi.feature_id) AS fp 
	WHERE featureloc.feature_id=fp.srcfeature_id) as fl
WHERE feature.feature_id = fl.srcfeature_id
AND feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')})
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
