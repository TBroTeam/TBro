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
        $param_predpep_uniquename = null;

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
    WHERE isoform.uniquename = :isoform_uniquename
    AND unigene.feature_id = feature_relationship.object_id
    AND isoform.feature_id = feature_relationship.subject_id    
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    AND isoform.type_id = {$_CONST('CV_ISOFORM')}
EOF;

        $stm_get_unigene = $db->prepare($query_get_unigene);
        $stm_get_unigene->bindValue('isoform_uniquename', $param_isoform_uniquename);
        
        $query_get_predpeps = <<<EOF
SELECT predpep.*, featureloc.* 
    FROM feature AS predpep, featureloc, feature AS isoform 
    WHERE featureloc.feature_id=predpep.feature_id 
        AND featureloc.srcfeature_id=isoform.feature_id
        AND predpep.type_id = {$_CONST('CV_PREDPEP')}
        AND isoform.uniquename = :isoform_uniquename
EOF;
        $stm_get_predpeps = $db->prepare($query_get_predpeps);
        $stm_get_predpeps->bindValue('isoform_uniquename', $param_isoform_uniquename);

        $query_get_interpro = <<<EOF
SELECT 
  interpro.* , featureloc.* 
FROM 
  feature predpep, 
  feature interpro, 
  featureloc
WHERE 
  interpro.feature_id = featureloc.feature_id AND
  featureloc.srcfeature_id = predpep.feature_id AND
  interpro.type_id = {$_CONST('CV_ANNOTATION_INTERPRO')} AND 
  predpep.uniquename = :predpep_uniquename
        
EOF;
        $stm_get_interpro = $db->prepare($query_get_interpro);
        $stm_get_interpro->bindParam('predpep_uniquename', $param_predpep_uniquename);

        $query_get_repeatmasker = <<<EOF
SELECT 
  repeatmasker.* , featureloc.* 
FROM 
  feature isoform, 
  feature repeatmasker, 
  featureloc
WHERE 
  repeatmasker.feature_id = featureloc.feature_id AND
  featureloc.srcfeature_id = isoform.feature_id AND
  repeatmasker.type_id = {$_CONST('CV_ANNOTATION_REPEATMASKER')} AND 
  isoform.uniquename = :isoform_uniquename
        
EOF;
        $stm_get_repeatmasker = $db->prepare($query_get_repeatmasker);
        $stm_get_repeatmasker->bindValue('isoform_uniquename', $param_isoform_uniquename);

        $return = array();

        $stm_get_isoforms->execute();
        if (($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) !== false) {
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

                $param_predpep_uniquename = $predpep['uniquename'];
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
