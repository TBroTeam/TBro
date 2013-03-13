<?php
class Isoforms extends WebService {

    public function execute($data) {

        global $_CONST, $db;
        #UI hint
        if (false)
            $db = new PDO();

        $param_unigene_uniquename = $data['query1']; #1.01_comp214244_c0

        $query_get_isoforms = <<<EOF
SELECT isoform.uniquename 
    FROM feature AS isoform, feature_relationship, feature AS unigene
    WHERE unigene.uniquename = :unigene_uniquename
    AND unigene.feature_id = feature_relationship.object_id
    AND isoform.feature_id = feature_relationship.subject_id    
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    AND isoform.type_id = {$_CONST('CV_ISOFORM')}
EOF;

        $stm_get_isoforms = $db->prepare($query_get_isoforms);
        $stm_get_isoforms->bindValue('unigene_uniquename', $param_unigene_uniquename);

        $data = array('results' => array());

        $stm_get_isoforms->execute();
        while ($isoform = $stm_get_isoforms->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $isoform['uniquename'];
        }


        return $data;
    }

}

?>
