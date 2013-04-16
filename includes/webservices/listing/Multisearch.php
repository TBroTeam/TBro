<?php

namespace webservices\listing;

use \PDO as PDO;

class Multisearch extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

        $species = intval($_REQUEST['species']);
        $import = $_REQUEST['dataset'];
        $longterm = $_REQUEST['longterm'];
        $terms = preg_split('/[,\s]+/m', $longterm, -1, PREG_SPLIT_NO_EMPTY);
        $qmarks = implode(',', array_fill(0, count($terms), '?'));
        $values = array_merge($terms,$terms,array($species, $import));

        $limit = 20;
        
#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
   
SELECT 
  isoform.name AS isoform_name, isoform.feature_id AS isoform_feature_id,
  unigene.name AS unigene_name, unigene.feature_id AS unigene_feature_id
FROM 
  feature AS isoform, 
  (
    SELECT u.feature_id, u.name, u.organism_id
    FROM feature AS u, feature_relationship AS fr, feature AS i, feature_dbxref AS f_dbx
    WHERE 
        (i.name IN ($qmarks) OR u.name IN ($qmarks))
        AND u.type_id = {$_CONST('CV_UNIGENE')}
        AND i.type_id = {$_CONST('CV_ISOFORM')}
        AND fr.type_id = {$_CONST('CV_RELATIONSHIP_UNIGENE_ISOFORM')}
        AND fr.object_id = u.feature_id
        AND fr.subject_id = i.feature_id
        AND u.organism_id = ?
        AND u.feature_id = f_dbx.feature_id
        AND f_dbx.dbxref_id = (SELECT dbxref_id FROM dbxref WHERE db_id = {$_CONST('DB_ID_IMPORTS')} AND accession = ?)
    LIMIT $limit
  ) AS unigene, 
  feature_relationship
WHERE 
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


         ksort($data['results']);

        return $data;
    }

}

?>


