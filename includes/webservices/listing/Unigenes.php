<?php
namespace webservices\listing;
use \PDO as PDO;

class Unigenes extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();

        $param_unigene_namequery = $querydata['query1'] . '%';

        $query_get_unigenes = <<<EOF
SELECT unigene.uniquename,
        count(*) OVER() AS full_count
    FROM feature AS unigene
    WHERE unigene.name LIKE :unigene_namequery
    OR unigene.uniquename LIKE :unigene_namequery2
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    LIMIT 20
EOF;

        $stm_get_unigenes = $db->prepare($query_get_unigenes);
        $stm_get_unigenes->bindValue('unigene_namequery', $param_unigene_namequery);
        $stm_get_unigenes->bindValue('unigene_namequery2', $param_unigene_namequery);

        $data = array('full_count' => 0, 'results' => array());

        $stm_get_unigenes->execute();
        while ($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) {
            if ($data['full_count'] == 0)
                $data['full_count'] = $unigene['full_count'];
            $data['results'][] = $unigene['uniquename'];
        }



        return $data;
    }

}

?>
