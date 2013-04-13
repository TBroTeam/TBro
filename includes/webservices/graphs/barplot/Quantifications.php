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
  quantificationresult.type_id,
  parent_biomaterial.name AS parent_biomaterial_name,
  assay.name AS assay_name,
  analysis.analysis_id,
  analysis.name AS analysis_name
FROM 
  quantificationresult, 
  biomaterial,
  analysis,
  feature, 
  quantification,
  acquisition,
  assay,
  biomaterial_relationship, 
  biomaterial AS parent_biomaterial
WHERE 
  quantificationresult.biomaterial_id IN ({$query_subqueries['biomaterial']}) AND
  quantificationresult.biomaterial_id = biomaterial.biomaterial_id AND
  
  quantificationresult.feature_id IN ({$query_subqueries['parent']}) AND    
  quantificationresult.feature_id = feature.feature_id AND
  

  quantificationresult.quantification_id = quantification.quantification_id AND
  quantification.analysis_id IN ({$query_subqueries['analysis']}) AND
  quantification.analysis_id = analysis.analysis_id AND
  
  
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id IN ({$query_subqueries['assay']}) AND
  acquisition.assay_id = assay.assay_id AND
  
  biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND
  biomaterial_relationship.object_id = parent_biomaterial.biomaterial_id
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
        $x = array();
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
                $x['Tissue_Group'][] = $cell['parent_biomaterial_name'];
                $x['Assay'][] = $cell['assay_name'];
                $x['Analysis'][] = "${cell['analysis_name']} (${cell['analysis_id']})";
            }

            $row[] = floatval($cell['value']);
        }

        return array(
            'x' => $x,
            'y' => array(
                'vars' => $vars,
                'smps' => $smps,
                'data' => $data
            )
        );
    }

}

?>
