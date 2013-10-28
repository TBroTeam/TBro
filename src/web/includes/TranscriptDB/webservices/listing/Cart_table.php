<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns CartTable entries for dataTable Server-Side processing.
 * See http://www.datatables.net/release-datatables/examples/server_side/server_side.html
 */
class Cart_table extends \WebService {

    /**
     * returns data in format for dataTable
     * @global \PDO $db
     * @param Array $querydata
     * @return Array
     */
    public function getDetails($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();
        
        if(!is_array($querydata['terms'])){
            $querydata['terms'] = explode(",", $querydata['terms']);
        }
        \sort($querydata['terms']);
        $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
        $terms = array_slice($querydata['terms'], intval($querydata['iDisplayStart']), $limit_count);

        list($service) = \WebService::factory('details/features');
        $results = ($service->execute(array('terms' =>  $terms)));
        
        $data = array(
            "sEcho" => intval($querydata['sEcho']),
            "iTotalDisplayRecords" => sizeof($querydata['terms']),
            "iTotalRecords" => sizeof($querydata['terms']),
            "aaData" => array()
        );

        foreach ($results['results'] as $result) {
            $data['aaData'][] = $result; //array_values($row);
        }

        return $data;
    }



    /**
     * @inheritDoc
     * @param Array $querydata
     * @return Array
     */
    public function execute($querydata) {
        return $this->getDetails($querydata);
    }
}

?>
