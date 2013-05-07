<?php

namespace webservices\details;

use \PDO as PDO;

class Unigene extends \WebService {

    public function execute($querydata) {
        global $db;
        $constant = 'constant';

#UI hint
        if (false)
            $db = new PDO();

        $param_unigene_feature_id = $querydata['query1'];

        $query_get_unigenes = <<<EOF
SELECT *
    FROM feature AS unigene
    WHERE unigene.feature_id = :feature_id
    AND unigene.type_id = {$constant('CV_UNIGENE')}
    LIMIT 20
EOF;

        $stm_get_unigenes = $db->prepare($query_get_unigenes);
        $stm_get_unigenes->bindValue('feature_id', $param_unigene_feature_id);

        $return = array();

        $stm_get_unigenes->execute();
        if (($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) != false) {
            $return['unigene'] = $unigene;
            require_once 'TranscriptDB/webservices/listing/Isoforms.php';
            $service = new \webservices\listing\Isoforms();
            $isoforms = $service->execute($querydata);
            if (isset($isoforms['isoforms']))
                $return['unigene']['isoforms'] = $isoforms['isoforms'];
        }

        return $return;
    }

}

?>
