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
        $param_interpro_feature_id = null;

        $query_get_isoforms = <<<EOF
SELECT isoform.* 
    FROM feature AS isoform
    WHERE isoform.uniquename = :isoform_uniquename
    AND isoform.type_id = {$_CONST('CV_ISOFORM')}
EOF;
        $stm_get_isoforms = $db->prepare($query_get_isoforms);
        $stm_get_isoforms->bindValue('isoform_uniquename', $param_isoform_uniquename);

        $query_get_isoform_dbxrefs = <<<EOF
SELECT
  db.name AS dbname, dbxref.accession, dbxref.version AS dbversion, dbxref.description AS description
FROM
  feature_dbxref, dbxref, db
WHERE
  feature_dbxref.feature_id = :isoform_id AND
  dbxref.dbxref_id = feature_dbxref.dbxref_id AND
  db.db_id = dbxref.db_id
EOF;

        $stm_get_isoform_dbxrefs = $db->prepare($query_get_isoform_dbxrefs);
        $stm_get_isoform_dbxrefs->bindParam('isoform_id', $param_isoform_id);
        
        
        $query_get_blast2go = <<<EOF
SELECT
  *
FROM
  featureprop
WHERE
  featureprop.feature_id = :isoform_id AND
  featureprop.type_id = {$_CONST('CV_ANNOTATION_BLAST2GO')}
EOF;

        $stm_get_blast2go = $db->prepare($query_get_blast2go);
        $stm_get_blast2go->bindParam('isoform_id', $param_isoform_id);


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
  interpro.* , featureloc.*, interpro_ID.value AS interpro_ID, analysisfeature.significance AS evalue, analysis.name AS analysis_name, analysis.program, analysis.programversion, analysis.timeexecuted
FROM 
  feature interpro
  INNER JOIN featureloc ON (interpro.feature_id = featureloc.feature_id)
  LEFT OUTER JOIN featureprop AS interpro_ID ON (interpro_ID.feature_id   = interpro.feature_id AND interpro_ID.type_id = {$_CONST('CV_INTERPRO_ID')}) 
  LEFT OUTER JOIN analysisfeature ON (interpro.feature_id = analysisfeature.feature_id)
  LEFT OUTER JOIN analysis ON (analysisfeature.analysis_id = analysis.analysis_id)
WHERE 
  featureloc.srcfeature_id = :predpep_id AND
  interpro.type_id = {$_CONST('CV_ANNOTATION_INTERPRO')}        
EOF;
        $stm_get_interpro = $db->prepare($query_get_interpro);
        $stm_get_interpro->bindParam('predpep_id', $param_predpep_id);

        $query_get_interpro_dbxrefs = <<<EOF
SELECT
  db.name AS dbname, dbxref.accession, dbxref.version AS dbversion, dbxref.description AS description
FROM
  feature_dbxref, dbxref, db
WHERE
  feature_dbxref.feature_id = :interpro_feature_id AND
  dbxref.dbxref_id = feature_dbxref.dbxref_id AND
  db.db_id = dbxref.db_id
EOF;

        $stm_get_interpro_dbxref = $db->prepare($query_get_interpro_dbxrefs);
        $stm_get_interpro_dbxref->bindParam('interpro_feature_id', $param_interpro_feature_id);

        $query_get_repeatmasker = <<<EOF
SELECT 
  repeatmasker.*, featureloc.*, repeat_name.value AS repeat_name, repeat_family.value AS repeat_family, repeat_class.value AS repeat_class
FROM 
  feature AS repeatmasker 
 INNER JOIN featureloc ON (repeatmasker.feature_id = featureloc.feature_id)
 LEFT OUTER JOIN featureprop AS repeat_name   ON (repeat_name.feature_id   = repeatmasker.feature_id AND repeat_name.type_id = {$_CONST('CV_REPEAT_NAME')}) 
 LEFT OUTER JOIN featureprop AS repeat_family ON (repeat_family.feature_id = repeatmasker.feature_id AND repeat_family.type_id = {$_CONST('CV_REPEAT_FAMILY')}) 
 LEFT OUTER JOIN featureprop AS repeat_class  ON (repeat_class.feature_id  = repeatmasker.feature_id AND repeat_class.type_id = {$_CONST('CV_REPEAT_CLASS')}) 
WHERE 
  featureloc.srcfeature_id = :isoform_id AND 
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

            $stm_get_isoform_dbxrefs->execute();
            while ($isoform_dbxref = $stm_get_isoform_dbxrefs->fetch(PDO::FETCH_ASSOC)) {
                $isoform['dbxref'][] = $isoform_dbxref;
            }
            
            $stm_get_blast2go->execute();
            while ($blast2go = $stm_get_blast2go->fetch(PDO::FETCH_ASSOC)) {
                $isoform['blast2go'][] = $blast2go;
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
                    $curr_interpro = &$current['interpro'][count($current['interpro']) - 1];
                    $param_interpro_feature_id = $interpro['feature_id'];
                    $stm_get_interpro_dbxref->execute();
                    while ($interpro_dbxref = $stm_get_interpro_dbxref->fetch(PDO::FETCH_ASSOC)) {
                        $curr_interpro['dbxref'][] = $interpro_dbxref;
                    }
                }
            }
            $return['isoform'] = &$isoform;
        }

        return $return;
    }

}

?>
