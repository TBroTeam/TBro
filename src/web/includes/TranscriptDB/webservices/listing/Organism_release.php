<?php

namespace webservices\listing;

use \PDO as PDO;
/**
 * Web Service.
 * Returns all Organism-Release combinations
 */
class Organism_release extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';


#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT organism.common_name AS organism_name, organism.organism_id AS organism_id, dbxref.accession AS release_name
FROM organism
    JOIN organism_dbxref ON (organism.organism_id = organism_dbxref.organism_id)
    JOIN dbxref ON (organism_dbxref.dbxref_id = dbxref.dbxref_id)
WHERE
   dbxref.db_id = {$constant('DB_ID_IMPORTS')}
EOF;

        $stm_get_organism_release = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_organism_release->execute();
        while ($row = $stm_get_organism_release->fetch(PDO::FETCH_ASSOC)) {
            $data['results']['organism'][$row['organism_id']] = array('organism_name'=>$row['organism_name'], 'organism_id'=>$row['organism_id']);
            $data['results']['release'][$row['organism_id']][$row['release_name']] = array('release'=>$row['release_name']);
        }

        return $data;
    }

}

?>
