<?php

namespace webservices\details;

use \PDO as PDO;
/**
 * Web Service.
 * Returns isoform details (feature.*, import, organism_name), parent unigene and textual annotations
 */
class Isoform extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

#UI hint
        if (false)
            $db = new PDO();

        //isoform details (feature.*, import, organism_name)
        $param_isoform_feature_id = $querydata['query1'];
        $param_isoform_id = null;
        $query_get_isoforms = <<<EOF
SELECT DISTINCT ON (isoform.feature_id, dbxref.dbxref_id)
        isoform.*, dbxref.accession AS import, organism.common_name AS organism_name
    FROM feature AS isoform
        JOIN dbxref ON (isoform.dbxref_id = dbxref.dbxref_id AND dbxref.db_id = {$constant('DB_ID_IMPORTS')})
        JOIN organism ON (isoform.organism_id = organism.organism_id)
    WHERE isoform.feature_id = :isoform_id
        AND isoform.type_id = {$constant('CV_ISOFORM')}
    LIMIT 1;
EOF;
        $stm_get_isoforms = $db->prepare($query_get_isoforms);
        $stm_get_isoforms->bindValue('isoform_id', $param_isoform_feature_id);

        
        
//all textual annotations
        $query_get_desc = <<<EOF
SELECT
  *
FROM
  featureprop
WHERE
  featureprop.feature_id = :isoform_id AND
  featureprop.type_id = {$constant('CV_ANNOTATION_DESC')}
EOF;

        $stm_get_desc = $db->prepare($query_get_desc);
        $stm_get_desc->bindParam('isoform_id', $param_isoform_id);

//all custom annotations
        $query_get_custom = <<<EOF
SELECT
  cvterm.name, featureprop.value
FROM
  featureprop, cvterm
WHERE
  featureprop.feature_id = :isoform_id AND
  cvterm.cvterm_id = featureprop.type_id AND
  cvterm.cv_id = {$constant('CUSTOM_ANNOTATION_TYPE_CV_ID')}
EOF;

        $stm_get_custom = $db->prepare($query_get_custom);
        $stm_get_custom->bindParam('isoform_id', $param_isoform_id);

//parent unigene
        $query_get_unigene = <<<EOF
SELECT unigene.*
    FROM feature_relationship, feature AS unigene
    WHERE unigene.feature_id = feature_relationship.object_id
    AND :isoform_id = feature_relationship.subject_id    
    AND unigene.type_id = {$constant('CV_UNIGENE')}
    LIMIT 1
EOF;

        $stm_get_unigene = $db->prepare($query_get_unigene);
        $stm_get_unigene->bindParam('isoform_id', $param_isoform_id);
        $return = array();

        $stm_get_isoforms->execute();
        if (($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) !== false) {
            $param_isoform_id = $isoform['feature_id'];


            $stm_get_unigene->execute();
            //set $isoform['unigene'] to parent
            if (($unigene = $stm_get_unigene->fetch(PDO::FETCH_ASSOC)) !== false) {
                $isoform['unigene'] = $unigene;
            }

            $stm_get_desc->execute();
            //add all descriptions to array $isoform['description']
            while ($desc = $stm_get_desc->fetch(PDO::FETCH_ASSOC)) {
                $isoform['description'][] = $desc;
            }

            $stm_get_custom->execute();
            //add all custom annotations to array $isoform['custom_annotations']
            while ($custom = $stm_get_desc->fetch(PDO::FETCH_ASSOC)) {
                $isoform['custom_annotations'][] = $custom;
            }

            $return['isoform'] = &$isoform;
        }

        return $return;
    }

}

?>
