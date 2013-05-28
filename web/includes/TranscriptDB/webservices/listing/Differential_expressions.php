<?php

namespace webservices\listing;

use \PDO as PDO;

class Differential_expressions extends \WebService {

    public function byIds($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();


        $ids = array();
        if (isset($querydata['ids'])) {
            $ids = array_merge($ids, $querydata['ids']);
        }

        $analysis = $querydata['analysis'];
        $sampleA = $querydata['sampleA'];
        $sampleB = $querydata['sampleB'];






        if (count($ids) == 0)
            return array('aaData' => array());

        $qmarks = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  f.name AS feature_name,
  d.baseMean AS baseMean",
  d.baseMeanA AS "baseMeanA",
  d.baseMeanB AS "baseMeanB",
  d.foldChange AS "foldChange",
  d.log2foldChange AS "log2foldChange",
  d.pval,
  d.pvaladj
FROM 
  diffexpresult d 
  JOIN feature f ON (d.feature_id = f.feature_id)
WHERE
   d.feature_id IN ($qmarks) AND
   d.analysis_id = ? AND 
   (d.biomateriala_id = ? AND
   d.biomaterialb_id = ?)
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);

        $data = array('aaData' => array());

        $stm_get_diffexpr->execute(array_merge($ids, array($analysis, $sampleA, $sampleB)));
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = $row; //array_values($row);
        }

        return $data;
    }

    public static $columns = array(
        'f.name' => '"feature_name"',
        'd.baseMean' => '"baseMean"',
        'd.baseMeanA' => '"baseMeanA"',
        'd.baseMeanB' => '"baseMeanB"',
        'd.foldChange' => '"foldChange"',
        'd.log2foldChange' => '"log2foldChange"',
        'd.pval' => 'pval',
        'd.pvaladj' => 'pvaladj'
    );

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

        array_push($where, 'd.biomateriala_id = ?');
        array_push($arguments, $querydata['conditionA']);

        array_push($where, 'd.biomaterialb_id = ?');
        array_push($arguments, $querydata['conditionB']);

        array_push($where, 'f.organism_id = ?');
        array_push($arguments, $querydata['organism']);

        array_push($where, 'f.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = ' . DB_ID_IMPORTS . ' AND accession = ?)');
        array_push($arguments, $querydata['release']);

        if ($apply_filters) {
            foreach ($querydata['filter_column'] as $key => $filter_column) {
                $type = $filter_column['type'];
                $value = str_replace('Inf', 'Infinity', $filter_column['value']);
                if (empty($value))
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
        $wherestr = implode(" AND \n", $where);


        $order_by = 'ORDER BY ' . self::$columns[$keys[0]] . ' DESC';
        if ($apply_order && isset($querydata['iSortCol_0'])) {
            for ($i = 0; $i < intval($querydata['iSortingCols']); $i++) {
                if ($querydata['bSortable_' . intval($querydata['iSortCol_' . $i])] == "true") {
                    $order_by = 'ORDER BY ' . self::$columns[$keys[intval($querydata['iSortCol_' . $i])]] . ' ' . ($querydata['sSortDir_' . $i] === 'asc' ? 'ASC' : 'DESC');
                }
            }
        }
        $limit = '';
        if ($apply_limit) {
            $limit_from = intval($querydata['iDisplayStart']);
            $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));
            $limit = sprintf('OFFSET %d LIMIT %d', $limit_from, $limit_count);
        }

        $query = <<<EOF
SELECT 
$select
FROM 
	diffexpresult d 
	join feature f on d.feature_id=f.feature_id 
WHERE
$wherestr
$order_by
$limit
EOF;

        return array($query, $arguments);
    }

    public function fullRelease($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

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
            $data['aaData'][] = $row; //array_values($row);
        }

        return $data;
    }

    public function releaseCsv($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        list($query, $arguments) = $this->fullRelease_buildQuery($querydata, true, true, false);

        $stm_get_diffexpr = $db->prepare($query);
        $stm_get_diffexpr->execute($arguments);


        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"diffexp_export.csv\";");
        header("Content-Transfer-Encoding: binary");


        $out = fopen('php://output', 'w');
        $first = true;
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            if ($first) {
                $first = false;
                fputcsv($out, array_keys($row));
            }
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            fputcsv($out, array_values($row));
        }
        fclose($out);
        die();
    }

    public function execute($querydata) {
        if ($querydata['query1'] == 'byIds') {
            return $this->byIds($querydata);
        } elseif ($querydata['query1'] == 'fullRelease') {
            return $this->fullRelease($querydata);
        } elseif ($querydata['query1'] == 'releaseCsv') {
            return $this->releaseCsv($querydata);
        }
    }

    static function format(&$val, $key) {
        if (is_numeric($val))
            $val = sprintf('%.5e', $val);
        else if ($val == 'Infinity') {
            $val = 'Inf';
        } else if ($val == '-Infinity') {
            $val = '-Inf';
        }
    }

}

?>
