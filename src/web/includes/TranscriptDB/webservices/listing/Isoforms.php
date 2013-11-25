<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns Isoforms for Unigene
 */
class Isoforms extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {

        global $db;
        $constant = 'constant';
        #UI hint
        if (false)
            $db = new PDO();

        $param_unigene_feature_id = $querydata['query1']; #1.01_comp214244_c0

        $query_get_isoforms = <<<EOF
SELECT details.*, fp.value AS description FROM (SELECT isoform.uniquename, isoform.feature_id, isoform.name 
    FROM feature AS isoform, feature_relationship
    WHERE 
    feature_relationship.object_id = :unigene_feature_id
    AND isoform.feature_id = feature_relationship.subject_id    
    AND isoform.type_id = {$constant('CV_ISOFORM')}) AS details 
        LEFT JOIN (SELECT feature_id, value FROM featureprop WHERE featureprop.type_id={$constant('CV_ANNOTATION_DESC')}) AS fp
        ON fp.feature_id = details.feature_id
EOF;

        $stm_get_isoforms = $db->prepare($query_get_isoforms);
        $stm_get_isoforms->bindValue('unigene_feature_id', $param_unigene_feature_id);

        $data = array('results' => array());

        $stm_get_isoforms->execute();
        while ($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) {
            $data['isoforms'][] = array(
                'uniquename' => $isoform['uniquename'], 
                'name' => $isoform['name'], 
                'feature_id' => $isoform['feature_id'], 
                'description' => $isoform['description'], 
                'type'=>'isoform');
        }


        return $data;
    }

}

?>
