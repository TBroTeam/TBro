<?php

namespace webservices\graphs\barplot;

use \PDO as PDO;
/**
 * returns Quantification data as y/x canvasxpress data, see http://canvasxpress.org/documentation.html#data
 */
class Quantifications extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();


        $parents = $querydata['parents']; //feature ids
        $analysises = $querydata['analysis']; //one analysises
        $assays = $querydata['quantification']; //one quantification
        $biomaterials = $querydata['biomaterial']; //one or more biomaterial samples


        $query_values = array();
        $query_subqueries = array();
        foreach (
        array('parent' => $parents, 'biomaterial' => $biomaterials)
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
  parent_biomaterial.name AS parent_biomaterial_name,
  assay.name AS assay_name,
  analysis.analysis_id,
  analysis.name AS analysis_name
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
  
  expressionresult.feature_id IN ({$query_subqueries['parent']}) AND    
  expressionresult.feature_id = feature.feature_id AND
  
  expressionresult.analysis_id = :analysis AND
  expressionresult.analysis_id = analysis.analysis_id AND
  
  expressionresult.quantification_id = quantification.quantification_id AND  
  expressionresult.quantification_id = :quantification AND  
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id = assay.assay_id AND
  
  biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND
  biomaterial_relationship.object_id = parent_biomaterial.biomaterial_id
 ORDER BY feature_name, biomaterial_name;

EOF;

        $data_array = array_merge(
                $query_values['biomaterial'], $query_values['parent']
        );

        $stm = $db->prepare($query);
        foreach ($data_array as $key => $val)
            $stm->bindValue ($key, $val, \PDO::PARAM_STR);
        
        $stm->bindValue ('analysis', $querydata['analysis'], \PDO::PARAM_STR);
        $stm->bindValue ('quantification', $querydata['quantification'], \PDO::PARAM_STR);
        
        $stm->execute();
        

        $lastcell_name = '';
        $data = array();
        $vars = array();
        $ids = array();
        $smps = array();
        $x = array();
        $row = null;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                $lastcell_name = $cell['feature_name'];
                $data[] = array();
                $row = &$data[count($data) - 1];
                $vars[] = $cell['feature_name'];
                $ids[] = $cell['feature_id'];
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
                'data' => $data,
                'ids' => $ids
            )
        );
    }

}

?>
