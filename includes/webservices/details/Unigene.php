<?php

namespace webservices\details;

use \PDO as PDO;

class Unigene extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();

        $param_unigene_uniquename = $querydata['query1'];

        $query_get_unigenes = <<<EOF
SELECT *
    FROM feature AS unigene
    WHERE unigene.uniquename = :uniquename
    AND unigene.type_id = {$_CONST('CV_UNIGENE')}
    LIMIT 20
EOF;

        $stm_get_unigenes = $db->prepare($query_get_unigenes);
        $stm_get_unigenes->bindValue('uniquename', $param_unigene_uniquename);

        $return = array();

        $stm_get_unigenes->execute();
        if (($unigene = $stm_get_unigenes->fetch(PDO::FETCH_ASSOC)) != false) {
            $return['unigene'] = $unigene;
            require_once INC . 'webservices/listing/Isoforms.php';
            $service = new \webservices\listing\Isoforms();
            $isoforms = $service->execute($querydata);
            $return['unigene']['isoforms'] = $isoforms['isoforms'];
        }

        return $return;
    }

}

?>
