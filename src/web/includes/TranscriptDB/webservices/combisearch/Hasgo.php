<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features with specified GO.
 */
class Hasgo extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @param $querydata[term] GO to search for
     * @returns array of feature ids
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $release = $querydata['release'];

        $term = trim($querydata['term']);

        $ids = array();
        $ids_query = "";
        if (isset($querydata['ids']) && count($querydata['ids']) > 0) {
            $ids = $querydata['ids'];
            $ids_query = 'AND feature.feature_id IN (' . implode(',', array_fill(0, count($ids), '?')) . ')';
        }

// this query ignores leading zeroes in accession string
        $query_get_features = <<<EOF
SELECT fd.feature_id 
FROM 
	feature_dbxref fd,
	(SELECT dbxref_id FROM dbxref WHERE dbxref.db_id = (SELECT db_id FROM db WHERE db.name = 'GO' LIMIT 1) AND trim(LEADING '0' FROM dbxref.accession) = trim(LEADING '0' FROM ?)) AS dbxref,
	(SELECT feature_id FROM feature WHERE feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')}) AND feature.organism_id = ? AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=? LIMIT 1)) as feature
WHERE 
feature.feature_id = fd.feature_id
AND fd.dbxref_id = dbxref.dbxref_id
{$ids_query}
EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array_merge(array($term, $species, $release), $ids));
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $feature['feature_id'];
        }
        $data['results'] = array_unique($data['results']);
        
        return $data;
    }

}

?>
