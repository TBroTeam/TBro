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

// this query ignores leading zeroes in accession string
        $query_get_features = <<<EOF
SELECT fd.feature_id 
FROM 
	feature_dbxref fd,
	(SELECT dbxref_id FROM dbxref WHERE dbxref.db_id = (SELECT db_id FROM db WHERE db.name = 'GO' LIMIT 1) AND trim(LEADING '0' FROM dbxref.accession) = trim(LEADING '0' FROM :accession)) AS dbxref,
	(SELECT feature_id FROM feature WHERE feature.type_id={$constant('CV_ISOFORM')} AND feature.organism_id = :species AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=:release LIMIT 1)) as feature
WHERE 
feature.feature_id = fd.feature_id
AND fd.dbxref_id = dbxref.dbxref_id
EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array(
            'accession' => $term,
            'species' => $species,
            'release' => $release
        ));
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $feature['feature_id'];
        }

        return $data;
    }

}

?>
