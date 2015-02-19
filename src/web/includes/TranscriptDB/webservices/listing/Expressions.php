<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * returns Expression data for use in an expression table
 */
class Expressions extends \WebService {

    /**
     * @inheritDoc
     */
    public function fullRelease($querydata) {
        set_time_limit(300);
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        if (!isset($_SESSION))
            session_start();

        $analysis = $querydata['analysis']; //one or more analysises
        $assay = $querydata['assay']; //one or more assays
        $biomaterial = $querydata['biomaterial']; //one or more biomaterial samples
        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';

        $metadata = array();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'][$querydata['currentContext']])
            $metadata = &$_SESSION['cart']['metadata'][$querydata['currentContext']];

        $query_values = array();
        $query_subqueries = array();
        foreach (
        array('analysis' => $analysis, 'assay' => $assay, 'biomaterial' => $biomaterial)
        AS $prefix => $values) {
            for ($i = 0; $i < count($values); $i++) {
                $query_values[$prefix][':' . $prefix . $i] = $values[$i];
            }
            $query_subqueries[$prefix] = implode(',', array_keys($query_values[$prefix]));
        }

        $query = <<<EOF
SELECT 
  feature.feature_id AS feature_id,
  feature.name AS feature_name, 
  biomaterial.name AS biomaterial_name, 
  expressionresult.value, 
  parent_biomaterial.biomaterial_id AS parent_biomaterial_id
FROM 
  expressionresult, 
  biomaterial,
  analysis,
  feature, 
  quantification,
  acquisition,
  assay,
  biomaterial_relationship, 
  biomaterial AS parent_biomaterial
WHERE 
  expressionresult.biomaterial_id IN ({$query_subqueries['biomaterial']}) AND
  expressionresult.biomaterial_id = biomaterial.biomaterial_id AND
  
  expressionresult.feature_id = feature.feature_id AND
  
  expressionresult.analysis_id IN ({$query_subqueries['analysis']}) AND
  expressionresult.analysis_id = analysis.analysis_id AND
  
  expressionresult.quantification_id = quantification.quantification_id AND  
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id IN ({$query_subqueries['assay']}) AND
  acquisition.assay_id = assay.assay_id AND
  
  biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND
  biomaterial_relationship.object_id = parent_biomaterial.biomaterial_id AND 
      
  feature.organism_id=:organism AND 
  feature.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')}  AND accession = :release)
 ORDER BY feature_name, biomaterial_name;

EOF;

        $data_array = array_merge(
                $query_values['biomaterial'], $query_values['analysis'], $query_values['assay']
        );

        $stm = $db->prepare($query);
        foreach ($data_array as $key => $val)
            $stm->bindValue($key, $val, \PDO::PARAM_STR);

        $stm->bindValue('organism', $organism, \PDO::PARAM_STR);
        $stm->bindValue('release', $release, \PDO::PARAM_STR);
        $stm->execute();


        $lastcell_name = '';
        $data = array();
        $smps = array("ID", "name", "user_alias");
        $parents = array(-1, -1, -1);
        $row = null;
        $first = true;
        $needcomma = false;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                if ($first && $lastcell_name != "") {
                    echo "{\"header\":[\"" . implode("\",\"", $smps) . "\"],\"data\":[\n";
                    $first = false;
                }
                if (!$first && $this->passes_main_filters($row, $querydata)) {
                    if ($needcomma) {
                        echo ",\n";
                    } else {
                        $needcomma = true;
                    }
                    echo "[" . implode(",", $row) . "]";
                }
                $lastcell_name = $cell['feature_name'];
                $user_alias = "\"\"";
                if (array_key_exists($cell['feature_id'], $metadata)) {
                    if (array_key_exists('alias', $metadata[$cell['feature_id']]))
                        $user_alias = "\"" . $metadata[$cell['feature_id']]['alias'] . "\"";
                }
                $row = array($cell['feature_id'], "\"" . $cell['feature_name'] . "\"", $user_alias);
            }

            if ($first) {
                #sample-specific actions, only executed for first var
                $smps[] = $cell['biomaterial_name'];
                $parents[] = $cell['parent_biomaterial_id'];
            }

            $row[] = floatval($cell['value']);
        }
        if ($needcomma) {
            echo ",\n";
        }
        echo "[" . implode(",", $row) . "]]}\n";
        die();

        if (is_numeric($querydata['mainFilterAllValue']) || is_numeric($querydata['mainFilterOneValue']) || is_numeric($querydata['mainFilterMeanValue']))
            $data = $this->apply_main_filters($data, $querydata);

        if (isset($querydata['biomaterialFilters']))
            $data = $this->apply_biomaterial_filters($data, $parents, $querydata);

        return array(
            'header' => $smps,
            'data' => $data
        );
    }

    public function passes_main_filters($data, $querydata) {
        return $this->passes_main_all_filter($data, $querydata) && $this->passes_main_one_filter($data, $querydata) && $this->passes_main_mean_filter($data, $querydata);
    }

    public function passes_main_all_filter($data, $querydata) {
        if (is_numeric($querydata['mainFilterAllValue'])) {
            switch ($querydata['mainFilterAllType']) {
                case 'eq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n != $querydata['mainFilterAllValue'])
                            return false;
                    }
                    break;
                case 'gt':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n <= $querydata['mainFilterAllValue'])
                            return false;
                    }
                    break;
                case 'lt':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n >= $querydata['mainFilterAllValue'])
                            return false;
                    }
                    break;
                case 'geq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n < $querydata['mainFilterAllValue'])
                            return false;
                    }
                    break;
                case 'leq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n > $querydata['mainFilterAllValue'])
                            return false;
                    }
                    break;
            }
        }
        return true;
    }

    public function passes_main_one_filter($data, $querydata) {
        if (is_numeric($querydata['mainFilterOneValue'])) {
            switch ($querydata['mainFilterOneType']) {
                case 'eq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n == $querydata['mainFilterOneValue'])
                            return true;
                    }
                    break;
                case 'gt':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n > $querydata['mainFilterOneValue'])
                            return true;
                    }
                    break;
                case 'lt':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n < $querydata['mainFilterOneValue'])
                            return true;
                    }
                    break;
                case 'geq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n >= $querydata['mainFilterOneValue'])
                            return true;
                    }
                    break;
                case 'leq':
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        if ($n <= $querydata['mainFilterOneValue'])
                            return true;
                    }
                    break;
            }
        } else {
            return true;
        }
        return false;
    }

    public function passes_main_mean_filter($data, $querydata) {
        $result = array();
        if (is_numeric($querydata['mainFilterMeanValue'])) {
            switch ($querydata['mainFilterMeanType']) {
                case 'eq':
                    $sum = 0;
                    $len = 0;
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        $sum += $n;
                        $len++;
                    }
                    if ($len > 0 && $sum / $len == $querydata['mainFilterMeanValue'])
                        return true;
                    break;
                case 'gt':
                    $sum = 0;
                    $len = 0;
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        $sum += $n;
                        $len++;
                    }
                    if ($len > 0 && $sum / $len > $querydata['mainFilterMeanValue'])
                        return true;
                    break;
                case 'lt':
                    $sum = 0;
                    $len = 0;
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        $sum += $n;
                        $len++;
                    }
                    if ($len > 0 && $sum / $len < $querydata['mainFilterMeanValue'])
                        return true;
                    break;
                case 'geq':
                    $sum = 0;
                    $len = 0;
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        $sum += $n;
                        $len++;
                    }
                    if ($len > 0 && $sum / $len >= $querydata['mainFilterMeanValue'])
                        return true;
                    break;
                case 'leq':
                    $sum = 0;
                    $len = 0;
                    foreach ($data AS $i => $n) {
                        if ($i < 3)
                            continue;
                        $sum += $n;
                        $len++;
                    }
                    if ($len > 0 && $sum / $len <= $querydata['mainFilterMeanValue'])
                        return true;
                    break;
            }
        } else {
            return true;
        }
        return false;
    }

    public function apply_biomaterial_filters($data, $parents, $querydata) {
        $result = $data;
        foreach ($querydata['biomaterialFilters'] AS $bioid => $filter) {
            $fil_results = array();
            if (is_numeric($filter['value'])) {
                $indices = array_keys($parents, $bioid);
                if (count($indices) > 0) {
                    switch ($filter['type']) {
                        case 'eq':
                            foreach ($result AS $index => $values) {
                                $sum = 0;
                                $len = 0;
                                foreach ($indices AS $i) {
                                    $sum += $values[$i];
                                    $len++;
                                }
                                if ($len > 0 && $sum / $len == $filter['value'])
                                    array_push($fil_results, $values);
                            }
                            $result = $fil_results;
                            break;
                        case 'gt':
                            foreach ($result AS $index => $values) {
                                $sum = 0;
                                $len = 0;
                                foreach ($indices AS $i) {
                                    $sum += $values[$i];
                                    $len++;
                                }
                                if ($len > 0 && $sum / $len > $filter['value'])
                                    array_push($fil_results, $values);
                            }
                            $result = $fil_results;
                            break;
                        case 'lt':
                            foreach ($result AS $index => $values) {
                                $sum = 0;
                                $len = 0;
                                foreach ($indices AS $i) {
                                    $sum += $values[$i];
                                    $len++;
                                }
                                if ($len > 0 && $sum / $len < $filter['value'])
                                    array_push($fil_results, $values);
                            }
                            $result = $fil_results;
                            break;
                        case 'geq':
                            foreach ($result AS $index => $values) {
                                $sum = 0;
                                $len = 0;
                                foreach ($indices AS $i) {
                                    $sum += $values[$i];
                                    $len++;
                                }
                                if ($len > 0 && $sum / $len >= $filter['value'])
                                    array_push($fil_results, $values);
                            }
                            $result = $fil_results;
                            break;
                        case 'leq':
                            foreach ($result AS $index => $values) {
                                $sum = 0;
                                $len = 0;
                                foreach ($indices AS $i) {
                                    $sum += $values[$i];
                                    $len++;
                                }
                                if ($len > 0 && $sum / $len <= $filter['value'])
                                    array_push($fil_results, $values);
                            }
                            $result = $fil_results;
                            break;
                    }
                }
            }
        }
        return $result;
    }

    public function printCsv($expressions) {
        // output header
        echo "# Expression Results\n";
        printf("# you can reach the feature details via %s/details/byId/<feature_id>\n", APPPATH);

        //output csv
        $out = fopen('php://output', 'w');
        fputcsv($out, $expressions["header"], "\t");

        foreach ($expressions["data"] as $key => $val) {
            fputcsv($out, $val, "\t");
        }

        fclose($out);
    }

    /**
     * @inheritDoc
     * Switches behaviour based on $querydata['query1']: "fullRelease" or "releaseCsv"
     * @param Array $querydata
     * @return Array
     */
    public function execute($querydata) {
        if ($querydata['query1'] == 'fullRelease') {
            return $this->fullRelease($querydata);
        } elseif ($querydata['query1'] == 'releaseCsv') {
            header("Pragma: public");
            header("Expires: 0");
            header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
            header("Cache-Control: private", false);
            header("Content-Type: application/octet-stream");
            header("Content-Disposition: attachment; filename=\"expressions_export.tsv\";");
            header("Content-Transfer-Encoding: binary");
            $this->printCsv($this->fullRelease($querydata));
            //die or WebService->output will attach return value to output (in our case: null)
            die();
        }
    }

}

?>
