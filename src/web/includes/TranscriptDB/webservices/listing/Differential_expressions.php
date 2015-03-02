<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Returns Differential Expressions for dataTable Server-Side processing.
 * See http://www.datatables.net/release-datatables/examples/server_side/server_side.html
 */
class Differential_expressions extends \WebService {

    /**
     * mapping for dataTable columns to database columns.
     * only these are allowed for filtering
     * @var Array 
     */
    public static $columns = array(
        'f.name' => '"feature_name"',
        's.name' => 'synonym_name',
        "des.value" => 'db_description',
        "null" => 'user_alias',
        "NULL" => 'user_annotations',
        'd.baseMean' => '"baseMean"',
        'd.baseMeanA' => '"baseMeanA"',
        'd.baseMeanB' => '"baseMeanB"',
        'd.foldChange' => '"foldChange"',
        'd.log2foldChange' => '"log2foldChange"',
        'd.pval' => 'pval',
        'd.pvaladj' => 'pvaladj',
        "f.feature_id" => 'feature_id',
    );

    /**
     * get query details for Results overview/csv header
     * @global \PDO $db
     * @param Array $querydata
     * @param boolean $apply_filters
     * @return Array
     */
    public function fullRelease_getQueryDetails($querydata, $apply_filters = false) {
        $ret = array(
            'organism' => '',
            'release' => '',
            'conditionA' => '',
            'conditionB' => '',
            'analysis' => '',
            'filters' => array()
        );

        global $db;

        $query_biomat = $db->prepare('SELECT biomaterial_id AS id, name, description FROM biomaterial WHERE biomaterial_id=?');
        $query_biomat->execute(array($querydata['conditionA']));
        $ret['conditionA'] = $query_biomat->fetch(\PDO::FETCH_ASSOC);

        $query_biomat->execute(array($querydata['conditionB']));
        $ret['conditionB'] = $query_biomat->fetch(\PDO::FETCH_ASSOC);

        $query_analysis = $db->prepare('SELECT analysis_id AS id, name, description, program, programversion, algorithm FROM analysis WHERE analysis_id=?');
        $query_analysis->execute(array($querydata['analysis']));
        $ret['analysis'] = $query_analysis->fetch(\PDO::FETCH_ASSOC);

        $query_organism = $db->prepare('SELECT organism_id AS id, common_name AS name FROM organism WHERE organism_id=?');
        $query_organism->execute(array($querydata['organism']));
        $ret['organism'] = $query_organism->fetch(\PDO::FETCH_ASSOC);

        $ret['release'] = $querydata['release'];

        if ($apply_filters) {
            $where = array();
            $arguments = array();
            $this->get_filters($querydata, $where, $arguments, array_values(self::$columns));

            for ($i = 0; $i < count($where); $i++) {
                array_push($ret['filters'], str_replace('"', '', str_replace('?', $arguments[$i], $where[$i])));
            }
        }

        if (isset($querydata['ids']) && count($querydata['ids']) > 0) {
            array_push($ret['filters'], 'feature_id in (' . implode(';', $querydata['ids']) . ')');
        }

        return $ret;
    }

    /**
     * Evaluates $querydata and stores filter expressions for SQL WHERE in $where, values in $arguments
     * @param Array $querydata
     * @param outArray &$where
     * @param outArray &$arguments
     * @param Array $keys array_keys(self::$columns)
     */
    public function get_filters($querydata, &$where, &$arguments, $keys) {
        foreach ($querydata['filter_column'] as $key => $filter_column) {
            $type = $filter_column['type'];
            $value = str_replace('Inf', 'Infinity', $filter_column['value']);
            if ($value === "")
                continue;
            if (!in_array($type, array('lt', 'gt', 'eq', 'geq', 'leq')))
                continue;
            if (!is_numeric($value) && $value != 'Infinity' && $value != '-Infinity')
                continue;
            if ($key > count(self::$columns))
                continue;
            switch ($type) {
                case 'eq':
                    array_push($where, sprintf('%s = ?', $keys[$key]));
                    break;
                case 'gt':
                    array_push($where, sprintf('%s > ?', $keys[$key]));
                    break;
                case 'lt':
                    array_push($where, sprintf('%s < ?', $keys[$key]));
                    break;
                case 'geq':
                    array_push($where, sprintf('%s >= ?', $keys[$key]));
                    break;
                case 'leq':
                    array_push($where, sprintf('%s <= ?', $keys[$key]));
                    break;
            }
            array_push($arguments, $value);
        }
    }

    /**
     * Builds full SQL query with $querydata applied
     * @param Array $querydata
     * @param boolean $apply_filters
     * @param boolean $apply_order
     * @param boolean $apply_limit
     * @return list($query, $arguments)
     */
    public function fullRelease_buildQuery($querydata, $apply_filters = false, $apply_order = false, $apply_limit = false) {
        $keys = array_keys(self::$columns);
        $arguments = array();

        $select = implode(",\n", array_map(function($key, $value) {
                    return sprintf("%s AS %s", $key, $value);
                }, $keys, self::$columns));

        if ($apply_limit)
            $select.=', COUNT(*) OVER () AS cnt';

        $where = array();

        array_push($where, 'd.analysis_id = ?');
        array_push($arguments, $querydata['analysis']);

        array_push($where, 'd.quantification_id = ?');
        array_push($arguments, $querydata['quantification']);

        array_push($where, 'd.biomateriala_id = ?');
        array_push($arguments, $querydata['conditionA']);

        array_push($where, 'd.biomaterialb_id = ?');
        array_push($arguments, $querydata['conditionB']);

        array_push($where, 'f.organism_id = ?');
        array_push($arguments, $querydata['organism']);

        array_push($where, 'f.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = ' . DB_ID_IMPORTS . ' AND accession = ?)');
        array_push($arguments, $querydata['release']);

        if (isset($querydata['ids']) && count($querydata['ids']) > 0) {
            array_push($where, 'd.feature_id IN (' . implode(',', array_fill(0, count($querydata['ids']), '?')) . ')');
            foreach ($querydata['ids'] as $id) {
                array_push($arguments, $id);
            }
        }

        if ($apply_filters) {
            $this->get_filters($querydata, $where, $arguments, $keys);
        }
        $wherestr = implode(" AND \n", $where);


        $order_by = 'ORDER BY ' . self::$columns[$keys[0]] . ' DESC';
        if ($apply_order && isset($querydata['iSortCol_0'])) {
            for ($i = 0; $i < intval($querydata['iSortingCols']); $i++) {
                if ($querydata['bSortable_' . intval($querydata['iSortCol_' . $i])] == "true") {
                    $order_by = 'ORDER BY ' . self::$columns[$keys[intval($querydata['iSortCol_' . $i])]] . ' ' . ($querydata['sSortDir_' . $i] === 'asc' ? 'ASC' : 'DESC')
                            . ', ' . self::$columns[$keys[0]] . ' DESC';
                }
            }
        }
        $limit = '';
        if ($apply_limit) {
            $limit_from = intval($querydata['iDisplayStart']);
            $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
            $limit = sprintf('OFFSET %d LIMIT %d', $limit_from, $limit_count);
        }

        $constant = 'constant';

        $query = <<<EOF
SELECT 
$select 
FROM 
	diffexpresult d 
	JOIN feature f ON d.feature_id=f.feature_id 
        LEFT JOIN feature_synonym fs ON f.feature_id=fs.feature_id
        LEFT JOIN synonym s ON fs.synonym_id=s.synonym_id
        LEFT JOIN (SELECT feature_id, value FROM featureprop WHERE featureprop.type_id={$constant('CV_ANNOTATION_DESC')}) des ON f.feature_id=des.feature_id
WHERE
$wherestr
$order_by
$limit
EOF;

        return array($query, $arguments);
    }

    /**
     * returns data in format for dataTable
     * @global \PDO $db
     * @param Array $querydata
     * @return Array
     */
    public function fullRelease($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        if (!isset($_SESSION))
            session_start();

        $metadata = array();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'][$querydata['currentContext']])
            $metadata = &$_SESSION['cart']['metadata'][$querydata['currentContext']];

        list($query, $arguments) = $this->fullRelease_buildQuery($querydata, true, true, true);

        $stm_get_diffexpr = $db->prepare($query);
        $stm_get_diffexpr->execute($arguments);
        $data = array(
            "sEcho" => intval($querydata['sEcho']),
            "iTotalDisplayRecords" => $stm_get_diffexpr->rowCount(),
            "aaData" => array()
        );


        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($data['iTotalRecords'])) {
                $data['iTotalRecords'] = $row['cnt'];
                $data['iTotalDisplayRecords'] = $row['cnt'];
            }
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $row['user_alias'] = '';
            $row['user_annotations'] = '';
            if (array_key_exists($row['feature_id'], $metadata)) {
                if (array_key_exists('alias', $metadata[$row['feature_id']]))
                    $row['user_alias'] = $metadata[$row['feature_id']]['alias'];
                if (array_key_exists('annotations', $metadata[$row['feature_id']]))
                    $row['user_annotations'] = $metadata[$row['feature_id']]['annotations'];
            }
            $data['aaData'][] = $row; //array_values($row);
        }

        $data['query_details'] = $this->fullRelease_getQueryDetails($querydata, true, true, true);

        return $data;
    }

    /**
     * outputs data as csv
     * @global \PDO $db
     * @param Array $querydata
     */
    public function printCsv($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        if (!isset($_SESSION))
            session_start();
        if (!isset($querydata['ids']))
            $querydata['ids'] = array();
        if (isset($querydata['cartname']) && $_SESSION['cart']['carts'][$querydata['currentContext']][$querydata['cartname']] !== null) {
            foreach ($_SESSION['cart']['carts'][$querydata['currentContext']][$querydata['cartname']]['items'] as $index => $id) {
                array_push($querydata['ids'], $id);
            }
        }
        $metadata = array();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'][$querydata['currentContext']])
            $metadata = &$_SESSION['cart']['metadata'][$querydata['currentContext']];

        list($query, $arguments) = $this->fullRelease_buildQuery($querydata, true, true, false);

        $stm_get_diffexpr = $db->prepare($query);
        $stm_get_diffexpr->execute($arguments);

        $query_details = $this->fullRelease_getQueryDetails($querydata, true, true, true);

        // output header
        echo "# Differential Expression Results\n";
        printf("# you can reach the feature details via %s/details/byId/<feature_id>\n", APPPATH);
        foreach ($query_details as $mkey => $item) {
            echo "# $mkey";

            if (is_string($item)) {
                echo "\n#\t$item\n";
            } else if (is_array($item)) {
                echo "\n";
                foreach ($item as $ikey => $ivalue) {
                    if (is_string($ikey))
                        echo "#\t$ikey\t$ivalue\n";
                    else
                        echo "#\t$ivalue\n";
                }
            }
        }

        //output csv
        $out = fopen('php://output', 'w');
        $first = true;
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            if ($first) {
                $first = false;
                fputcsv($out, array_keys($row), "\t");
            }
            if (array_key_exists($row['feature_id'], $metadata)) {
                if (array_key_exists('alias', $metadata[$row['feature_id']]))
                    $row['user_alias'] = $metadata[$row['feature_id']]['alias'];
                if (array_key_exists('annotations', $metadata[$row['feature_id']]))
                    $row['user_annotations'] = $metadata[$row['feature_id']]['annotations'];
            }
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            fputcsv($out, array_values($row), "\t");
        }
        fclose($out);
    }

    public function getAllMatching($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        list($query, $arguments) = $this->fullRelease_buildQuery($querydata, true, true, false);

        $stm_get_diffexpr = $db->prepare($query);
        $stm_get_diffexpr->execute($arguments);

        $ids = array();
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC))
            $ids[] = $row['feature_id'];

        return $ids;
    }

    public function getMAPlot($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        $x = array();
        $ids_high = array();
        $coords_high = array();
        $highlight_high = array();
        $ids = array();
        $coords = array();
        $highlight = array();
        # Get IDs to highlight
        list($query, $arguments) = $this->fullRelease_buildQuery($querydata, true, false, false);

        $stm_get_diffexpr = $db->prepare($query);
        $stm_get_diffexpr->execute($arguments);

        $highids = array();
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            $highids[$row['feature_id']] = 1;
            # Remove Inf values for now (maybe display on top or bottom later)
            if (!is_numeric($row['log2foldChange'])) {
                continue;
            }
            $ids_high[] = $row['feature_id'];
            $coords_high[] = array($row['baseMean'], $row['log2foldChange']);
            $highlight_high[] = 1;
        }

        # Get all info
        # unset ids to get all matching ids in organism_release_quantification_analysis combination
        $columns2 = array(
            'd.baseMean' => '"baseMean"',
            'd.log2foldChange' => '"log2foldChange"',
            "f.feature_id" => 'feature_id',
        );

        $keys = array_keys($columns2);
        $arguments2 = array();

        $select = implode(",\n", array_map(function($key, $value) {
                    return sprintf("%s AS %s", $key, $value);
                }, $keys, $columns2));

        $where = array();

        $constant = 'constant';

        array_push($where, 'd.analysis_id = ?');
        array_push($arguments2, $querydata['analysis']);

        array_push($where, 'd.quantification_id = ?');
        array_push($arguments2, $querydata['quantification']);

        array_push($where, 'd.biomateriala_id = ?');
        array_push($arguments2, $querydata['conditionA']);

        array_push($where, 'd.biomaterialb_id = ?');
        array_push($arguments2, $querydata['conditionB']);

        array_push($where, 'f.organism_id = ?');
        array_push($arguments2, $querydata['organism']);

        array_push($where, 'f.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = ' . DB_ID_IMPORTS . ' AND accession = ?)');
        array_push($arguments2, $querydata['release']);

        $wherestr = implode(" AND \n", $where);
        
        // Limit to avoid out of memory errors
        $limit = "LIMIT 100000";
        // $limit = "";

        $query2 = <<<EOF
SELECT 
$select 
FROM 
	diffexpresult d 
        JOIN feature f ON d.feature_id=f.feature_id 
WHERE
$wherestr
$limit
EOF;


        $stm_get_diffexpr2 = $db->prepare($query2);
        $stm_get_diffexpr2->execute($arguments2);

        while ($row = $stm_get_diffexpr2->fetch(PDO::FETCH_ASSOC)) {
            # Remove Inf values for now (maybe display on top or bottom later)
            if (!is_numeric($row['log2foldChange'])) {
                continue;
            }
            if (!array_key_exists($row['feature_id'], $highids)) {
                $ids[] = $row['feature_id'];
                $coords[] = array($row['baseMean'], $row['log2foldChange']);
                $highlight[] = 0;
            }
        }
        
        $ids = array_merge($ids, $ids_high);
        $coords = array_merge($coords, $coords_high);
        $highlight = array_merge($highlight, $highlight_high);
        // free some memory.
        $ids_high = null;
        $coords_high = null;
        $highlight_high = null;
                
        return array(
            'x' => $x,
            'y' => array(
                'smps' => array('baseMean', 'log2foldChange'),
                'vars' => $ids,
                'data' => $coords
            ),
            'z' => array(
                'Highlight' => $highlight
            )
        );
    }

    /**
     * @inheritDoc
     * Switches behaviour based on $querydata['query1']: "fullRelease" or "releaseCsv"
     * even though the name indicates differently, feature ids for a full release subset can be passed
     * @param Array $querydata
     * @return Array
     */
    public function execute($querydata) {
        if ($querydata['query1'] == 'fullRelease') {
            return $this->fullRelease($querydata);
        } elseif ($querydata['query1'] == 'getAllMatching') {
            return $this->getAllMatching($querydata);
        } elseif ($querydata['query1'] == 'maPlot') {
            return $this->getMAPlot($querydata);
        } elseif ($querydata['query1'] == 'releaseCsv') {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"diffexp_export.tsv\";");
            header("Content-Transfer-Encoding: binary");
            $this->printCsv($querydata);
            //die or WebService->output will attach return value to output (in our case: null)
            die();
        }
    }

    static function format(&$val, $key) {
        if (is_numeric($val) && round($val) != $val)
            $val = sprintf('%.5e', $val);
        else if ($val == 'Infinity') {
            $val = 'Inf';
        } else if ($val == '-Infinity') {
            $val = '-Inf';
        }
    }

}

?>
