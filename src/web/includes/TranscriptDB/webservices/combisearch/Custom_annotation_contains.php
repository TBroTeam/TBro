<?php

namespace webservices\combisearch;

use \PDO as PDO;

/**
 * WebService.
 * Searches for Features which custom annotation of type contains a phrase.
 */
class Custom_annotation_contains extends \WebService {

    /**
     * @param $querydata[species] organism id
     * @param $querydata[release] release name
     * @param $querydata[type] custom annotation type to search for
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
        $term = sprintf('%%%s%%', trim($querydata['term']));
        $type = $querydata['type'];

        $query_get_features = <<<EOF
           
SELECT featureprop.feature_id
    FROM
        featureprop, cvterm,
        (SELECT feature_id FROM feature WHERE feature.type_id IN ({$constant('CV_ISOFORM')}, {$constant('CV_UNIGENE')}) AND feature.organism_id = ? AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id={$constant('DB_ID_IMPORTS')} AND accession=? LIMIT 1)) as feature
    WHERE
        featureprop.type_id = cvterm.cvterm_id
        AND cvterm.cv_id = {$constant('CUSTOM_ANNOTATION_TYPE_CV_ID')}
        AND featureprop.value LIKE ?
        AND cvterm.name = ?
        AND featureprop.feature_id = feature.feature_id
        {$ids_query}
EOF;
        
//        $query = "SELECT name FROM feature WHERE id=?";
//        $stm = $db->prepare($query);
//        $stm->execute(array(12));

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array_merge(array($species, $release, $term, $type), $ids));
        
        while ($row = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $row['feature_id'];
        }
        $data['results'] = array_unique($data['results']);
        
        return $data;
    }

}

?>
