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

        if (!isset($_SESSION))
            session_start();

        $metadata = array();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'])
            $metadata = &$_SESSION['cart']['metadata'];
        // var_dump($metadata);

        if (!is_array($querydata['terms'])) {
            $querydata['terms'] = explode(",", $querydata['terms']);
        }
        $ids_filtered = $querydata['terms'];
        if ($ids_filtered[0] === '') {
            array_splice($ids_filtered, 0, 1);
        }

        if (isset($querydata['sSearch']) && $querydata['sSearch'] !== '') {
            $ids_filtered = array();
            if (strpos('isoform', $querydata['sSearch']) !== FALSE) {
                $ids_filtered = array_merge($this->filter_ids_bytype('isoform', $querydata['terms']), $ids_filtered);
            }
            if (strpos('unigene', $querydata['sSearch']) !== FALSE) {
                $ids_filtered = array_merge($this->filter_ids_bytype('unigene', $querydata['terms']), $ids_filtered);
            }
            $ids_filtered = array_merge($this->filter_ids_db($querydata['sSearch'], $querydata['terms']), $ids_filtered);
            $ids_filtered = array_merge($this->filter_ids_user_annotation($querydata['sSearch'], $querydata['terms']), $ids_filtered);
            $ids_filtered = array_merge($this->filter_ids_description($querydata['sSearch'], $querydata['terms']), $ids_filtered);
        }


        # If no sorting is requested or there are too many terms just return the result with the appropriate ids
        if (sizeof($ids_filtered) > 1000 || $querydata['iSortCol_0'] == 0) {
            \sort($ids_filtered);
            $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
            $terms = array_slice($ids_filtered, intval($querydata['iDisplayStart']), $limit_count);
            $data = array(
                "sEcho" => intval($querydata['sEcho']),
                "iTotalDisplayRecords" => sizeof($ids_filtered),
                "iTotalRecords" => sizeof($querydata['terms']),
                "idsFiltered" => $ids_filtered,
                "aaData" => array()
            );
            list($service) = \WebService::factory('details/features');
            $results = ($service->execute(array('terms' => $terms)));
            foreach ($results['results'] as &$result) {
                $result['actions'] = '';
                $result['user_alias'] = '';
                $result['user_annotations'] = '';
                if (array_key_exists($result['feature_id'], $metadata)) {
                    if (array_key_exists('alias', $metadata[$result['feature_id']]))
                        $result['user_alias'] = $metadata[$result['feature_id']]['alias'];
                    if (array_key_exists('annotations', $metadata[$result['feature_id']]))
                        $result['user_annotations'] = $metadata[$result['feature_id']]['annotations'];
                }
                $data['aaData'][] = $result;
            }

            return $data;
        } else {
            # get full set of feature descriptions, apply sorting and return the appropriate range
            list($service) = \WebService::factory('details/features');
            $results = ($service->execute(array('terms' => $ids_filtered)));
            foreach ($results['results'] as &$result) {
                $result['actions'] = '';
                $result['user_alias'] = '';
                $result['user_annotations'] = '';
                if (array_key_exists($result['feature_id'], $metadata)) {
                    if (array_key_exists('alias', $metadata[$result['feature_id']]))
                        $result['user_alias'] = $metadata[$result['feature_id']]['alias'];
                    if (array_key_exists('annotations', $metadata[$result['feature_id']]))
                        $result['user_annotations'] = $metadata[$result['feature_id']]['annotations'];
                }
            }
            if ($querydata['iSortCol_0'] == 1)
                usort($results['results'], array($this, "cmp_name"));
            if ($querydata['iSortCol_0'] == 2)
                usort($results['results'], array($this, "cmp_alias"));
            if ($querydata['iSortCol_0'] == 3)
                usort($results['results'], array($this, "cmp_description"));
            if ($querydata['iSortCol_0'] == 4)
                usort($results['results'], array($this, "cmp_user_alias"));
            if ($querydata['iSortCol_0'] == 5)
                usort($results['results'], array($this, "cmp_user_annotations"));
            if ($querydata['sSortDir_0'] == 'desc')
                $results['results'] = array_reverse($results['results']);
            $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
            $final_results = array_slice($results['results'], intval($querydata['iDisplayStart']), $limit_count);

            $data = array(
                "sEcho" => intval($querydata['sEcho']),
                "iTotalDisplayRecords" => sizeof($ids_filtered),
                "iTotalRecords" => sizeof($querydata['terms']),
                "aaData" => array()
            );

            foreach ($final_results as &$result) {
                $data['aaData'][] = $result; //array_values($row);
            }

            return $data;
        }
    }

    private function cmp_name($a, $b) {
        return strcmp($a['name'], $b['name']);
    }

    private function cmp_alias($a, $b) {
        return strcmp($a['alias'], $b['alias']);
    }

    private function cmp_description($a, $b) {
        return strcmp($a['description'], $b['description']);
    }

    private function cmp_user_alias($a, $b) {
        return strcmp($a['user_alias'], $b['user_alias']);
    }

    private function cmp_user_annotations($a, $b) {
        return strcmp($a['user_annotations'], $b['user_annotations']);
    }

    public function filter_ids_bytype($type, $ids) {
        $type_id = '';
        if ($type === 'isoform') {
            $type_id = CV_ISOFORM;
        } elseif ($type === 'unigene') {
            $type_id = CV_UNIGENE;
        } else {
            return array();
        }

        global $db;
        $ret = array();
#UI hint
        if (false)
            $db = new PDO();

        $place_holders = implode(',', array_fill(0, count($ids), '?'));

        $query = <<<EOF
    SELECT feature.feature_id, type_id FROM feature
    WHERE feature_id IN ($place_holders) AND type_id = ?
EOF;
        $stm = $db->prepare($query);
        $replacement = array_merge($ids, array($type_id));
        $stm->execute($replacement);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $ret[] = $row['feature_id'];
        }
        return $ret;
    }

    public function filter_ids_db($searchterm, $ids) {
        global $db;
        $ret = array();
#UI hint
        if (false)
            $db = new PDO();

        $place_holders = implode(',', array_fill(0, count($ids), '?'));
        $term = sprintf('%%%s%%', trim($searchterm));

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
        $replacement = array_merge($ids, array($term, $term));
        $stm->execute($replacement);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            $ret[] = $row['feature_id'];
        }
        return $ret;
    }

    public function filter_ids_user_annotation($searchterm, $ids) {
        $metadata = array();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'])
            $metadata = &$_SESSION['cart']['metadata'];
        $ret = array();
        foreach ($ids as $id) {
            if (array_key_exists($id, $metadata)) {
                if (array_key_exists('alias', $metadata[$id]) && (strpos($metadata[$id]['alias'], $searchterm) !== FALSE)) {
                    $ret[] = $id;
                } elseif (array_key_exists('annotations', $metadata[$id]) && (strpos($metadata[$id]['annotations'], $searchterm) !== FALSE)) {
                    $ret[] = $id;
                }
            }
        }
        return $ret;
    }

    public function filter_ids_description($searchterm, $ids) {
        list($service) = \WebService::factory('details/features');
        $results = ($service->execute(array('terms' => $ids)));
        $ret = array();
        foreach ($results['results'] as $result) {
            if (strpos($result['description'], $searchterm) !== FALSE)
                $ret[] = $result['feature_id'];
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
