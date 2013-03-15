<?php

namespace webservices\details;

use \PDO as PDO;

class Isoform extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();

        $param_isoform_uniquename = $querydata['query1'];
        $param_isoform_id = null;
        $param_predpep_id = null;

        $query_get_isoforms = <<<EOF
SELECT isoform.* 
    FROM feature AS isoform
    WHERE isoform.uniquename = :isoform_uniquename
    AND isoform.type_id = {$_CONST('CV_ISOFORM')}
EOF;
        $stm_get_isoforms = $db->prepare($query_get_isoforms);
        $stm_get_isoforms->bindValue('isoform_uniquename', $param_isoform_uniquename);

        $query_get_unigene = <<<EOF
SELECT unigene.*
    FROM feature AS isoform, feature_relationship, feature AS unigene
    WHERE unigene.feature_id = feature_relationship.object_id
    AND :isoform_id = feature_relationship.subject_id    
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    AND isoform.type_id = {$_CONST('CV_ISOFORM')}
EOF;

        $stm_get_unigene = $db->prepare($query_get_unigene);
        $stm_get_unigene->bindParam('isoform_id', $param_isoform_id);

        $query_get_predpeps = <<<EOF
SELECT predpep.*, featureloc.* 
    FROM feature AS predpep, featureloc 
    WHERE featureloc.feature_id=predpep.feature_id 
        AND featureloc.srcfeature_id=:isoform_id
        AND predpep.type_id = {$_CONST('CV_PREDPEP')}
EOF;
        $stm_get_predpeps = $db->prepare($query_get_predpeps);
        $stm_get_predpeps->bindParam('isoform_id', $param_isoform_id);

        $query_get_interpro = <<<EOF
SELECT 
  interpro.* , featureloc.* 
FROM 
  feature interpro, 
  featureloc
WHERE 
  interpro.feature_id = featureloc.feature_id AND
  featureloc.srcfeature_id = :predpep_id AND
  interpro.type_id = {$_CONST('CV_ANNOTATION_INTERPRO')}        
EOF;
        $stm_get_interpro = $db->prepare($query_get_interpro);
        $stm_get_interpro->bindParam('predpep_id', $param_predpep_id);

        $query_get_repeatmasker = <<<EOF
SELECT 
  repeatmasker.*, featureloc.*, repeat_name.value AS repeat_name, repeat_family.value AS repeat_family, repeat_class.value AS repeat_class
FROM 
  public.feature AS repeatmasker 
 INNER JOIN public.featureloc ON (repeatmasker.feature_id = featureloc.feature_id AND featureloc.srcfeature_id = :isoform_id)
 LEFT OUTER JOIN public.featureprop AS repeat_name   ON (repeat_name.feature_id   = repeatmasker.feature_id AND repeat_name.type_id = {$_CONST('CV_REPEAT_NAME')}) 
 LEFT OUTER JOIN public.featureprop AS repeat_family ON (repeat_family.feature_id = repeatmasker.feature_id AND repeat_family.type_id = {$_CONST('CV_REPEAT_FAMILY')}) 
 LEFT OUTER JOIN public.featureprop AS repeat_class  ON (repeat_class.feature_id  = repeatmasker.feature_id AND repeat_class.type_id = {$_CONST('CV_REPEAT_CLASS')}) 
WHERE 
  repeatmasker.type_id = {$_CONST('CV_ANNOTATION_REPEATMASKER')}
EOF;

        $stm_get_repeatmasker = $db->prepare($query_get_repeatmasker);
        $stm_get_repeatmasker->bindParam('isoform_id', $param_isoform_id);


        $return = array();

        $stm_get_isoforms->execute();
        if (($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) !== false) {
            $param_isoform_id = $isoform['feature_id'];
            
            
            $stm_get_unigene->execute();
            
            if (($unigene = $stm_get_unigene->fetch(PDO::FETCH_ASSOC)) !== false) {
                $isoform['unigene'] = $unigene;
            }

            $stm_get_repeatmasker->execute();
            while ($repeatmasker = $stm_get_repeatmasker->fetch(PDO::FETCH_ASSOC)) {
                $isoform['repeatmasker'][] = $repeatmasker;
            }

            $stm_get_predpeps->execute();
            while ($predpep = $stm_get_predpeps->fetch(PDO::FETCH_ASSOC)) {
                $isoform['predpeps'][] = $predpep;
                $current = &$isoform['predpeps'][count($isoform['predpeps']) - 1];

                $param_predpep_id = $predpep['feature_id'];
                $stm_get_interpro->execute();
                while ($interpro = $stm_get_interpro->fetch(PDO::FETCH_ASSOC)) {
                    $current['interpro'][] = $interpro;
                }
            }
            $return['isoform'] = &$isoform;
        }

        return $return;
    }

}

?>
