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
        
        $metadata = array();
        if (!isset($_SESSION))
            session_start();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata']) {
            foreach ($_SESSION['cart']['metadata'] as $meta)
                $metadata = $metadata + $meta;
        }
        
        $feature_ids = array();
        if (isset($querydata['query1']) && !empty($querydata['query1']))
            $feature_ids[] = $querydata['query1'];

        if (isset($querydata['terms']))
            $feature_ids = array_merge($feature_ids, $querydata['terms']);

        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        $query_get_isoforms = <<<EOF
SELECT details.*, fp.value AS description FROM (SELECT isoform.uniquename, isoform.feature_id, isoform.name 
    FROM feature AS isoform, feature_relationship
    WHERE 
    feature_relationship.object_id IN ($place_holders)
    AND isoform.feature_id = feature_relationship.subject_id    
    AND isoform.type_id = {$constant('CV_ISOFORM')}) AS details 
        LEFT JOIN (SELECT feature_id, value FROM featureprop WHERE featureprop.type_id={$constant('CV_ANNOTATION_DESC')}) AS fp
        ON fp.feature_id = details.feature_id
EOF;

        $stm_get_isoforms = $db->prepare($query_get_isoforms);

        $data = array();

        $stm_get_isoforms->execute($feature_ids);
        while ($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) {
            // add user annotations
            $user_alias = '';
            $user_annotations = '';
            if (array_key_exists($isoform['feature_id'], $metadata)) {
                if (array_key_exists('alias', $metadata[$isoform['feature_id']]))
                    $user_alias = $metadata[$isoform['feature_id']]['alias'];
                if (array_key_exists('annotations', $metadata[$isoform['feature_id']]))
                    $user_annotations = $metadata[$isoform['feature_id']]['annotations'];
            }
            $data['isoforms'][] = array(
                'uniquename' => $isoform['uniquename'], 
                'name' => $isoform['name'], 
                'feature_id' => $isoform['feature_id'], 
                'description' => $isoform['description'], 
                'type'=>'isoform',
                'user_alias' => $user_alias,
                'user_annotations' => $user_annotations);
        }


        return $data;
    }

}

?>
