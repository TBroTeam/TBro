<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * returns up to 20+20 features, searching by start of featurename or synonym
 */
class Searchbox extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $querydata['species'];
        $import = $querydata['release'];

        $term = '%' . trim($querydata['term']) . '%';

        if (!isset($_SESSION))
            session_start();

        $data = array('results' => array());

        $metadata = array();
        $currentContext = $species . '_' . $import;
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'][$currentContext])
            $metadata = &$_SESSION['cart']['metadata'][$currentContext];

        foreach($metadata as $featureid => $md){
            if(in_array('alias', $md) && strpos($md['alias'], $querydata['term']) === FALSE){
                $data['results'][] = array('name' => $md['alias']
                    , 'type' => 'user alias'
                    , 'id' => $featureid);
            }
            if(in_array('annotations', $md) && strpos($md['annotations'], $querydata['term']) === FALSE){
                $data['results'][] = array('name' => $md['annotations']
                    , 'type' => 'user description'
                    , 'id' => $featureid);
            }
        }

#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
    (SELECT 
        synonym.name, 
        feature_synonym.feature_id, 
        cvterm.name AS type
    FROM 
        feature_synonym, 
        synonym, 
        feature,
        cvterm
    WHERE 
        feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)
        AND synonym.name ILIKE ?
        AND feature_synonym.feature_id = feature.feature_id
        AND synonym.synonym_id = feature_synonym.synonym_id
        AND feature.organism_id = ?
        AND synonym.type_id=cvterm.cvterm_id
    LIMIT 20
)
UNION 
    (SELECT feature.name, feature.feature_id, cvterm.name AS type
    FROM feature, cvterm
    WHERE 
        feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)
        AND feature.name ILIKE ?
        AND feature.organism_id = ?
        AND (feature.type_id = {$constant('CV_UNIGENE')} OR feature.type_id = {$constant('CV_ISOFORM')})
        AND feature.type_id=cvterm.cvterm_id    
    LIMIT 20
)
UNION
    (SELECT featureprop.value AS name, feature.feature_id, 'description' AS type
    FROM featureprop, feature
    WHERE
        featureprop.feature_id = feature.feature_id
        AND feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)
        AND featureprop.value ILIKE ?
        AND feature.organism_id = ?
        AND (feature.type_id = {$constant('CV_UNIGENE')} OR feature.type_id = {$constant('CV_ISOFORM')})
    LIMIT 20
)
EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $stm_get_features->execute(array($import, $term, $species, $import, $term, $species, $import, $term, $species));
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = array('name' => $feature['name']
                , 'type' => $feature['type']
                , 'id' => $feature['feature_id']);
        }



        return $data;
    }

}

?>
