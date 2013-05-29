<?php

namespace webservices\listing;

use \PDO as PDO;

class Differential_expressions extends \WebService {
    /* public function byIds($querydata) {
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
      } */

    public static $columns = array(
        'f.name' => '"feature_name"',
        'd.baseMean' => '"baseMean"',
        'd.baseMeanA' => '"baseMeanA"',
        'd.baseMeanB' => '"baseMeanB"',
        'd.foldChange' => '"foldChange"',
        'd.log2foldChange' => '"log2foldChange"',
        'd.pval' => 'pval',
        'd.pvaladj' => 'pvaladj',
        "f.feature_id" => 'feature_id'
    );

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

        return $ret;
    }

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

        if (isset($querydata['ids']) && count($querydata['ids']) > 0) {
            array_push($where, 'd.feature_id IN (' . implode(',', array_fill(0, count($querydata['ids']), '?')) . ')');
            foreach ($querydata['ids'] as $id){
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

        $data['query_details'] = $this->fullRelease_getQueryDetails($querydata, true, true, true);

        return $data;
    }

    public function printCsv($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

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
                fputcsv($out, array_keys($row));
            }
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            fputcsv($out, array_values($row));
        }
        fclose($out);
    }

    public function execute($querydata) {
        if ($querydata['query1'] == 'byIds') {
            return $this->byIds($querydata);
        } elseif ($querydata['query1'] == 'fullRelease') {
            return $this->fullRelease($querydata);
        } elseif ($querydata['query1'] == 'releaseCsv') {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"diffexp_export.csv\";");
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
