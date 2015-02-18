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
        array('analysis' => $analysis, 'assay' => $assay, 'biomaterial' => $biomaterial, 'biomat' => $biomaterial)
        AS $prefix => $values) {
            $query_subqueries[$prefix] = implode(',', $values);
        }
        foreach (
        array('bio' => $biomaterial)
        AS $prefix => $values) {
            for ($i = 0; $i < count($values); $i++) {
                $query_values[$prefix][':' . $prefix . $i] = $values[$i];
            }
            $query_subqueries[$prefix] = implode(',', array_keys($query_values[$prefix]));
        }
        $query_biomaterials = <<<EOF
SELECT 
  name biomaterial_name, object_id parent_id 
FROM 
  biomaterial, 
  biomaterial_relationship 
WHERE 
  biomaterial_id IN ({$query_subqueries['bio']}) AND 
  biomaterial_id = subject_id 
ORDER BY 
  1

EOF;

        $biomats = array();
        $parents = array();
        $stm_biomaterials = $db->prepare($query_biomaterials);
        foreach ($query_values['bio'] as $key => $val)
            $stm_biomaterials->bindValue($key, $val, \PDO::PARAM_STR);
        $stm_biomaterials->execute();
        while (($cell = $stm_biomaterials->fetch(PDO::FETCH_ASSOC)) !== false) {
            $biomats[] = $cell['biomaterial_name'];
            $parents[] = $cell['parent_id'];
        }

        $bi = $biomats;
        for ($i = 0; $i < count($bi); $i++) {
            $bi[$i] = '"' . $biomats[$i] . '"' . " double precision";
        }
        $colnamespec = implode(',', $bi);


        $query = <<<EOF
SELECT 
  * 
FROM 
  crosstab('
    SELECT 
      feature.feature_id AS feature_id,
      feature.name AS feature_name,
      biomaterial.name AS biomaterial_name, 
      expressionresult.value
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
      
      feature.organism_id={$organism} AND 
      feature.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')}  AND accession = ''{$release}'')
    ORDER BY 
      feature_id, biomaterial_name
  ', '
    SELECT 
      name 
    FROM 
      biomaterial 
    WHERE 
      biomaterial_id IN ({$query_subqueries['biomat']})
  ')
    AS 
      ct(
        "ID" int, 
        "name" text, 
        {$colnamespec}
);

EOF;

        $stm = $db->prepare($query);

        //foreach ($data_array as $key => $val)
        //   $stm->bindValue($key, $val, \PDO::PARAM_STR);
        //$stm->bindValue('organism', $organism, \PDO::PARAM_STR);
        //$stm->bindValue('release', $release, \PDO::PARAM_STR);

        $stm->execute();

        $lastcell_name = '';
        $data = array();
        $smps = array_merge(array("ID", "name"), $biomats, array("user_alias"));
        $parents = array_merge(array(-1, -1), $parents, array(-1));
        $row = null;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            $user_alias = "";
            if (array_key_exists($cell['ID'], $metadata)) {
                if (array_key_exists('alias', $metadata[$cell['ID']]))
                    $user_alias = $metadata[$cell['ID']]['alias'];
            }
            $cell["user_alias"] = $user_alias;
            $data[] = array_values($cell);
        }

        if (is_numeric($querydata['mainFilterAllValue']) || is_numeric($querydata['mainFilterOneValue']) || is_numeric($querydata['mainFilterMeanValue']))
            $data = $this->apply_main_filters($data, $querydata);

        if (isset($querydata['biomaterialFilters']))
            $data = $this->apply_biomaterial_filters($data, $parents, $querydata);

        return array(
            'header' => $smps,
            'data' => $data
        );
    }

    public function apply_main_filters($data, $querydata) {
        $result = $this->apply_main_all_filter($data, $querydata);
        $result = $this->apply_main_one_filter($result, $querydata);
        $result = $this->apply_main_mean_filter($result, $querydata);

        return $result;
    }

    public function apply_main_all_filter($data, $querydata) {
        $result = array();
        if (is_numeric($querydata['mainFilterAllValue'])) {
            switch ($querydata['mainFilterAllType']) {
                case 'eq':
                    foreach ($data AS $index => $values) {
                        $valid = true;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n != $querydata['mainFilterAllValue'])
                                $valid = false;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'gt':
                    foreach ($data AS $index => $values) {
                        $valid = true;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n <= $querydata['mainFilterAllValue'])
                                $valid = false;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'lt':
                    foreach ($data AS $index => $values) {
                        $valid = true;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n >= $querydata['mainFilterAllValue'])
                                $valid = false;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'geq':
                    foreach ($data AS $index => $values) {
                        $valid = true;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n < $querydata['mainFilterAllValue'])
                                $valid = false;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'leq':
                    foreach ($data AS $index => $values) {
                        $valid = true;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n > $querydata['mainFilterAllValue'])
                                $valid = false;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
            }
        } else {
            $result = $data;
        }

        return $result;
    }

    public function apply_main_one_filter($data, $querydata) {
        $result = array();
        if (is_numeric($querydata['mainFilterOneValue'])) {
            switch ($querydata['mainFilterOneType']) {
                case 'eq':
                    foreach ($data AS $index => $values) {
                        $valid = false;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n == $querydata['mainFilterOneValue'])
                                $valid = true;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'gt':
                    foreach ($data AS $index => $values) {
                        $valid = false;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n > $querydata['mainFilterOneValue'])
                                $valid = true;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'lt':
                    foreach ($data AS $index => $values) {
                        $valid = false;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n < $querydata['mainFilterOneValue'])
                                $valid = true;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'geq':
                    foreach ($data AS $index => $values) {
                        $valid = false;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n >= $querydata['mainFilterOneValue'])
                                $valid = true;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
                case 'leq':
                    foreach ($data AS $index => $values) {
                        $valid = false;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            if ($n <= $querydata['mainFilterOneValue'])
                                $valid = true;
                        }
                        if ($valid)
                            array_push($result, $values);
                    }
                    break;
            }
        } else {
            $result = $data;
        }

        return $result;
    }

    public function apply_main_mean_filter($data, $querydata) {
        $result = array();
        if (is_numeric($querydata['mainFilterMeanValue'])) {
            switch ($querydata['mainFilterMeanType']) {
                case 'eq':
                    foreach ($data AS $index => $values) {
                        $sum = 0;
                        $len = 0;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            $sum += $n;
                            $len++;
                        }
                        if ($len > 0 && $sum / $len == $querydata['mainFilterMeanValue'])
                            array_push($result, $values);
                    }
                    break;
                case 'gt':
                    foreach ($data AS $index => $values) {
                        $sum = 0;
                        $len = 0;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            $sum += $n;
                            $len++;
                        }
                        if ($len > 0 && $sum / $len > $querydata['mainFilterMeanValue'])
                            array_push($result, $values);
                    }
                    break;
                case 'lt':
                    foreach ($data AS $index => $values) {
                        $sum = 0;
                        $len = 0;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            $sum += $n;
                            $len++;
                        }
                        if ($len > 0 && $sum / $len < $querydata['mainFilterMeanValue'])
                            array_push($result, $values);
                    }
                    break;
                case 'geq':
                    foreach ($data AS $index => $values) {
                        $sum = 0;
                        $len = 0;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            $sum += $n;
                            $len++;
                        }
                        if ($len > 0 && $sum / $len >= $querydata['mainFilterMeanValue'])
                            array_push($result, $values);
                    }
                    break;
                case 'leq':
                    foreach ($data AS $index => $values) {
                        $sum = 0;
                        $len = 0;
                        foreach ($values AS $i => $n) {
                            if ($i < 3)
                                continue;
                            $sum += $n;
                            $len++;
                        }
                        if ($len > 0 && $sum / $len <= $querydata['mainFilterMeanValue'])
                            array_push($result, $values);
                    }
                    break;
            }
        } else {
            $result = $data;
        }

        return $result;
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
