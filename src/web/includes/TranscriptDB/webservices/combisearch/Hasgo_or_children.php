<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for features containing submitted GO or a child GO
 */
class Hasgo_or_children extends \WebService {

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

        $query_get_parent_cvterm = <<<EOF
SELECT cvterm.cvterm_id
	FROM dbxref, cvterm, cvterm_relationship 
	WHERE db_id=(SELECT db_id FROM db WHERE name='GO') 
	AND trim(LEADING '0' FROM accession)=trim(LEADING '0' FROM :accession)
	AND dbxref.dbxref_id = cvterm.dbxref_id
	LIMIT 1
EOF;
        $stm_get_parent = $db->prepare($query_get_parent_cvterm);

        // selects all child GOs (actually containing the parent as well), join this with a pre-filtered feature table
        // get_cvterm_children can return duplicate rows, so it is grouped by cvterm_id, dbxref_id
        $query_get_features = <<<EOF
SELECT fd.feature_id 
FROM 
	feature_dbxref fd,
	(SELECT dbxref_id FROM get_cvterm_children(:parent) GROUP BY cvterm_id, dbxref_id
        ) AS dbxref,
	(SELECT feature_id FROM feature WHERE feature.type_id={$constant('CV_ISOFORM')} AND feature.organism_id = :species AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=:release LIMIT 1)) as feature
WHERE 
feature.feature_id = fd.feature_id
AND fd.dbxref_id = dbxref.dbxref_id


EOF;

        $stm_get_features = $db->prepare($query_get_features);


        $data = array('results' => array());

        $stm_get_parent->execute(array(
            'accession' => $term
        ));
        $parent = $stm_get_parent->fetchColumn();
        if ($parent == null)
            return $data;

        $stm_get_features->execute(array(
            'parent' => $parent,
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
