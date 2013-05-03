<?php

namespace webservices\listing;

use \PDO as PDO;

class Searchbox extends \WebService {

    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = $_REQUEST['species'];
        $import = $_REQUEST['dataset'];

        $term = $_REQUEST['term'] . '%';


#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT feature.name, feature.feature_id, feature.type_id
    FROM feature
    WHERE 
    feature.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)
    AND feature.organism_id = ?
    AND feature.name LIKE ?
    AND (feature.type_id = {$constant('CV_UNIGENE')} OR feature.type_id = {$constant('CV_ISOFORM')})
    LIMIT 20
EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute(array($import, $species, $term));
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = array('name' => $feature['name']
                , 'type' => ($feature['type_id'] == CV_UNIGENE ? 'unigene' : ($feature['type_id'] == CV_ISOFORM ? 'isoform' : 'error'))
                , 'id' => $feature['feature_id']);
        }



        return $data;
    }

}

?>
