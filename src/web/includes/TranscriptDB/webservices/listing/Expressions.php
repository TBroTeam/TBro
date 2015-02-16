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
    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();


        $analysis = $querydata['analysis']; //one or more analysises
        $assay = $querydata['assay']; //one or more assays
        $biomaterial = $querydata['biomaterial']; //one or more biomaterial samples
        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';

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
            $stm->bindValue ($key, $val, \PDO::PARAM_STR);
        
        $stm->bindValue ('organism', $organism, \PDO::PARAM_STR);
        $stm->bindValue ('release', $release, \PDO::PARAM_STR);
        $stm->execute();
        
        
        $lastcell_name = '';
        $data = array();
        $vars = array();
        $ids = array();
        $smps = array("ID", "name");
        $x = array();
        $row = null;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                $lastcell_name = $cell['feature_name'];
                $data[] = array($cell['feature_id'], $cell['feature_name']);
                $row = &$data[count($data) - 1];
            }

            if (count($data) == 1) {
                #sample-specific actions, only executed for first var
                $smps[] = $cell['biomaterial_name'];
            }

            $row[] = floatval($cell['value']);
        }

        return array(
            'header' => $smps,
            'data' => $data
        );
    }

}

?>
