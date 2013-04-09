<?php

namespace webservices\graphs\barplot;

use \PDO as PDO;

class Quantifications extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();


        $parents = $querydata['parents'];
        $analysises = $querydata['analysis'];
        $assays = $querydata['assay'];
        $biomaterials = $querydata['biomaterial'];


        $query_values = array();
        $query_subqueries = array();
        foreach (
        array('parent' => $parents, 'analysis' => $analysises, 'assay' => $assays, 'biomaterial' => $biomaterials)
        AS $prefix => $values) {
            for ($i = 0; $i < count($values); $i++) {
                $query_values[$prefix][':' . $prefix . $i] = $values[$i];
            }
            $query_subqueries[$prefix] = implode(',', array_keys($query_values[$prefix]));
        }


        $query = <<<EOF
SELECT 
  feature.name AS feature_name, 
  biomaterial.name AS biomaterial_name, 
  quantificationresult.value, 
  quantificationresult.type_id
FROM 
  quantificationresult, 
  biomaterial,
  analysis,
  feature, 
  quantification,
  acquisition,
  assay
WHERE 
  quantificationresult.biomaterial_id = biomaterial.biomaterial_id AND
  biomaterial.name IN ({$query_subqueries['biomaterial']}) AND
      
  quantificationresult.feature_id = feature.feature_id AND
  feature.uniquename IN ({$query_subqueries['parent']}) AND

  quantificationresult.quantification_id = quantification.quantification_id AND
  quantification.analysis_id = analysis.analysis_id AND
  analysis.analysis_id IN ({$query_subqueries['analysis']}) AND
  
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id = assay.assay_id AND
  assay.name IN ({$query_subqueries['assay']})
 ORDER BY feature_name, biomaterial_name;

EOF;

        $data_array = array_merge(
                $query_values['biomaterial'], $query_values['parent'], $query_values['analysis'], $query_values['assay']
        );

        $stm = $db->prepare($query);
        foreach ($data_array as $key => $val)
            $stm->bindValue ($key, $val, \PDO::PARAM_STR);
        
        $stm->execute();
        

        $lastcell_name = '';
        $data = array();
        $vars = array();
        $smps = array();
        $tree_vars = array();
        $tree_smps = array();
        $row = null;
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                $lastcell_name = $cell['feature_name'];
                $data[] = array();
                $row = &$data[count($data) - 1];
                $vars[] = $cell['feature_name'];
            }

            if (count($data) == 1) {
                #sample-specific actions, only executed for first var
                $smps[] = $cell['biomaterial_name'];
            }

            $row[] = floatval($cell['value']);
        }
        $t = array('vars' => '', 'smps' => '');

        foreach (array('vars' => &$tree_vars, 'smps' => &$tree_smps) as $key => $tree) {
            foreach ($tree as $children) {
                $substr = "";
                foreach ($children as $child) {
                    $substr .= (empty($substr) ? '' : ',') . $child;
                }
                $t[$key] .=(empty($t[$key]) ? '' : ',') . "($substr)";
            }
            $t[$key] = '(' . $t[$key] . ')';
        }

        return array(
            'y' => array(
                'vars' => $vars,
                'smps' => $smps,
                'data' => $data
            ),
            't' => $t
        );
    }

}

?>
