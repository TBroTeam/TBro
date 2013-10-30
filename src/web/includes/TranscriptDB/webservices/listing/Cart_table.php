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

        if (!is_array($querydata['terms'])) {
            $querydata['terms'] = explode(",", $querydata['terms']);
        }
        $ids = $querydata['terms'];
        if (isset($querydata['sSearch']) && $querydata['sSearch'] !== '') {
            $ids = $this->filter_ids($querydata);
        }

        \sort($ids);
        $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
        $terms = array_slice($ids, intval($querydata['iDisplayStart']), $limit_count);

        list($service) = \WebService::factory('details/features');
        $results = ($service->execute(array('terms' => $terms)));

        $data = array(
            "sEcho" => intval($querydata['sEcho']),
            "iTotalDisplayRecords" => sizeof($ids),
            "iTotalRecords" => sizeof($querydata['terms']),
            "aaData" => array()
        );

        foreach ($results['results'] as $result) {
            $data['aaData'][] = $result; //array_values($row);
        }

        return $data;
    }

    public function filter_ids($querydata) {
        global $db;
        $ret = array();
#UI hint
        if (false)
            $db = new PDO();

        $place_holders = implode(',', array_fill(0, count($querydata['terms']), '?'));
        $term = sprintf('%%%s%%', trim($querydata['sSearch']));

        $query = <<<EOF
    SELECT * FROM (SELECT
    feature.feature_id, feature.name, type_id, COALESCE((
    SELECT s.name 
    FROM feature_synonym fs, synonym s 
    WHERE fs.feature_id=feature.feature_id 
    AND s.synonym_id=fs.synonym_id 
    AND s.type_id=(SELECT type_id FROM cvterm WHERE name='symbol' LIMIT 1)
    LIMIT 1
    ),'') AS alias
    FROM feature
    WHERE feature.feature_id IN ($place_holders)) as f
    WHERE (f.name LIKE ? OR f.alias LIKE ?)
EOF;
        $stm = $db->prepare($query);
        $replacement = array_merge($querydata['terms'], array($term, $term));
        $stm->execute($replacement);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $ret[] = $row['feature_id'];
        }
        return $ret;
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
