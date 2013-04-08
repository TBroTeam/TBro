<?php

namespace webservices\listing\isoform;

use \PDO as PDO;

class Filters extends \WebService {

    public function execute($querydata) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();

        $param_unigene_name = $querydata['query1'];

        $query_get_filters = <<<EOF
SELECT 
 --DISTINCT ON (quantificationresult.type_id, assay.name, biomaterial.name)
  cvterm.name AS quantification_type_name, assay.name AS assay_name, assay.description AS assay_description, biomaterial.name AS biomaterial_name, biomaterial.description AS biomaterial_description
FROM 
  feature, 
  quantificationresult, 
  quantification, 
  analysis, 
  acquisition, 
  assay, 
  biomaterial,
  cvterm
WHERE 
  quantificationresult.feature_id = feature.feature_id AND
  quantificationresult.biomaterial_id = biomaterial.biomaterial_id AND
  quantification.quantification_id = quantificationresult.quantification_id AND
  quantification.analysis_id = analysis.analysis_id AND
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id = assay.assay_id AND
  quantificationresult.type_id = cvterm.cvterm_id AND
  feature.uniquename = :unigene_name;
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);
        $stm_get_filters->bindValue('unigene_name', $param_unigene_name);

        $data = array('assay' => array(), 'quantification_type_name' => array(), 'biomaterial' => array());

        $stm_get_filters->execute();
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {
            $ref = &$data['assay'];
            $item = array('name' => $filter['assay_name'], 'description' => $filter['assay_description']);
            if (!in_array($item, $ref))
                $ref[] = $item;
            unset($ref);

            $ref = &$data['quantification_type_name'][$filter['assay_name']];
            if ($ref == null)
                $ref = array();
            if (!in_array($filter['quantification_type_name'], $ref))
                $ref[] = $filter['quantification_type_name'];
            unset($ref);

            $ref = &$data['biomaterial'][$filter['quantification_type_name']][$filter['assay_name']];
            $item = array('name' => $filter['biomaterial_name'], 'description' => $filter['biomaterial_description']);
            if ($ref == null)
                $ref = array();
            if (!in_array($item, $ref))
                $ref[] = $item;
            unset($ref);
        }

        return $data;
    }

}

?>
