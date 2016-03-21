<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features which description contains a phrase.
 */
class Interpro_id extends \WebService {

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

        $ids = array();
        $ids_query = "";
        if (isset($querydata['ids']) && count($querydata['ids']) > 0) {
            $ids = $querydata['ids'];
            $ids_query = 'AND feature.feature_id IN (' . implode(',', array_fill(0, count($ids), '?')) . ')';
        }

        $term = strtoupper(trim($querydata['term']));
        # Interpro identifiers always start with IPR if the user did not specify it: add it.
        if(strpos($term, "IPR") !== 0){
            $term = "IPR" . $term;
        }

        $query_get_features = <<<EOF
           
SELECT feature.feature_id FROM feature, 
	(SELECT featureloc.srcfeature_id FROM featureloc, 
		(SELECT DISTINCT srcfeature_id FROM featureloc, 
			(SELECT feature_id FROM featureprop WHERE type_id={$constant('CV_INTERPRO_ID')} AND value=?) AS fi
		WHERE featureloc.feature_id = fi.feature_id) AS fp 
	WHERE featureloc.feature_id=fp.srcfeature_id) as fl
WHERE feature.feature_id = fl.srcfeature_id
AND feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')})
AND feature.organism_id = ? 
AND feature.dbxref_id = 
	(SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=? LIMIT 1)
{$ids_query}
EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array_merge(array($term, $species, $release), $ids));
        
        while ($row = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $row['feature_id'];
        }
        $data['results'] = array_unique($data['results']);
        
        return $data;
    }
}

?>
