<?php

namespace webservices\details;

use \PDO as PDO;
/**
 * Web Service.
 * Get unigene details.
 */
class Unigene extends \WebService {

    public function execute($querydata) {
        global $db;
        $constant = 'constant';

#UI hint
        if (false)
            $db = new PDO();

        $param_unigene_feature_id = $querydata['query1'];
        
        $metadata = array();
        if (!isset($_SESSION))
            session_start();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata']) {
            foreach ($_SESSION['cart']['metadata'] as $meta)
                $metadata = $metadata + $meta;
        }

        $query_get_unigenes = <<<EOF
SELECT *
    FROM feature AS unigene
    WHERE unigene.feature_id = :feature_id
    AND unigene.type_id = {$constant('CV_UNIGENE')}
    LIMIT 1
EOF;

        $stm_get_unigenes = $db->prepare($query_get_unigenes);
        $stm_get_unigenes->bindValue('feature_id', $param_unigene_feature_id);

        //all textual annotations
        $query_get_desc = <<<EOF
SELECT
  *
FROM
  featureprop
WHERE
  featureprop.feature_id = :unigene_id AND
  featureprop.type_id = {$constant('CV_ANNOTATION_DESC')}
EOF;

        $stm_get_desc = $db->prepare($query_get_desc);
        $stm_get_desc->bindParam('unigene_id', $param_unigene_feature_id);

        //all custom annotations
        $query_get_custom = <<<EOF
SELECT
  cvterm.name, featureprop.value
FROM
  featureprop, cvterm
WHERE
  featureprop.feature_id = :unigene_id AND
  cvterm.cvterm_id = featureprop.type_id AND
  cvterm.cv_id = {$constant('CUSTOM_ANNOTATION_TYPE_CV_ID')}
EOF;

        $stm_get_custom = $db->prepare($query_get_custom);
        $stm_get_custom->bindParam('unigene_id', $param_unigene_feature_id);

        
        $return = array();

        $stm_get_unigenes->execute();
        if (($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) != false) {
            $return['unigene'] = $unigene;
            require_once 'TranscriptDB/webservices/listing/Isoforms.php';
            $service = new \webservices\listing\Isoforms();
            $isoforms = $service->execute($querydata);
            if (isset($isoforms['isoforms']))
                $return['unigene']['isoforms'] = $isoforms['isoforms'];
            $stm_get_desc->execute();
            //add all descriptions to array $unigene['description']
            while ($desc = $stm_get_desc->fetch(PDO::FETCH_ASSOC)) {
                $return['unigene']['description'][] = $desc;
            }
            $stm_get_custom->execute();
            //add all custom annotations to array $unigene['custom_annotations']
            while ($custom = $stm_get_custom->fetch(PDO::FETCH_ASSOC)) {
                $return['unigene']['custom_annotations'][] = $custom;
            }
        }

        return $return;
    }

}

?>
