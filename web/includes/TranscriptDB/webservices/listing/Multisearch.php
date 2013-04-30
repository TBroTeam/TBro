<?php

namespace webservices\listing;

use \PDO as PDO;

class Multisearch extends \WebService {

    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $species = intval($_REQUEST['species']);
        $import = $_REQUEST['dataset'];
        $longterm = $_REQUEST['longterm'];
        $terms = preg_split('/[,\s]+/m', $longterm, -1, PREG_SPLIT_NO_EMPTY);
        $qmarks = implode(',', array_fill(0, count($terms), '?'));
        $values = array_merge($terms, array($import, $species));
        $values = array_merge($values,$values);

        $limit = 20;
        
#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
   
   SELECT 
  isoform.name AS isoform_name, isoform.feature_id AS isoform_feature_id,
  unigene.name AS unigene_name, unigene.feature_id AS unigene_feature_id
FROM 
  (SELECT feature_id, name FROM feature WHERE type_id = {$constant('CV_ISOFORM')}) AS isoform, 
  (
    SELECT u.feature_id, u.name, u.organism_id
    FROM feature AS u, feature_relationship AS fr, feature AS i
    WHERE 
        i.name IN ($qmarks)
        AND u.type_id = {$constant('CV_UNIGENE')}
        AND i.type_id = {$constant('CV_ISOFORM')}
        AND fr.object_id = u.feature_id
        AND fr.subject_id = i.feature_id
  ) AS unigene, 
  feature_relationship, 
  feature_dbxref  
WHERE 
  unigene.feature_id = feature_dbxref.feature_id AND
  feature_dbxref.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?) AND
  unigene.organism_id = ? AND      
  feature_relationship.object_id = unigene.feature_id AND
  feature_relationship.subject_id = isoform.feature_id

UNION
SELECT 
  isoform.name AS isoform_name, isoform.feature_id AS isoform_feature_id,
  unigene.name AS unigene_name, unigene.feature_id AS unigene_feature_id
FROM 
  (SELECT feature_id, name FROM feature WHERE type_id = {$constant('CV_ISOFORM')} ) AS isoform, 
  (SELECT feature_id, name, organism_id FROM feature WHERE type_id = {$constant('CV_UNIGENE')} AND name IN ($qmarks)) AS unigene, 
  feature_relationship, 
  feature_dbxref  
WHERE 
  unigene.feature_id = feature_dbxref.feature_id AND
  feature_dbxref.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?) AND
  unigene.organism_id = ? AND      
  feature_relationship.object_id = unigene.feature_id AND
  feature_relationship.subject_id = isoform.feature_id
LIMIT $limit
EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute($values);
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][$feature['isoform_feature_id']] = array(
                'name' => $feature['isoform_name']
                , 'type' => 'isoform'
                , 'id' => $feature['isoform_feature_id']
            );

            $data['results'][$feature['unigene_feature_id']] = array(
                'name' => $feature['unigene_name']
                , 'type' => 'unigene'
                , 'id' => $feature['unigene_feature_id']
            );
        }



        return $data;
    }

}

?>


