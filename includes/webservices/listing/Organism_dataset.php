<?php

namespace webservices\listing;

use \PDO as PDO;

class Organism_dataset extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;


#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT organism.common_name AS organism_name, organism.organism_id AS organism_id, dbxref.accession AS dataset_name
FROM organism
    JOIN organism_dbxref ON (organism.organism_id = organism_dbxref.organism_id)
    JOIN dbxref ON (organism_dbxref.dbxref_id = dbxref.dbxref_id)
WHERE
   dbxref.db_id = {$_CONST('DB_ID_IMPORTS')}
EOF;

        $stm_get_organism_dataset = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_organism_dataset->execute();
        while ($row = $stm_get_organism_dataset->fetch(PDO::FETCH_ASSOC)) {
            $data['results']['organism'][] = array('organism_name'=>$row['organism_name'], 'organism_id'=>$row['organism_id']);
            $data['results']['dataset'][$row['organism_id']][] = array('dataset'=>$row['dataset_name']);
        }

        return $data;
    }

}

?>
