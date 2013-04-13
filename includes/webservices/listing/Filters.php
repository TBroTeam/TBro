<?php

namespace webservices\listing;

use \PDO as PDO;

class Filters extends \WebService {

    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        
        $ids = array();
        if (isset($querydata['query1']) && !empty($querydata['query1'])) {
            $ids[] = $querydata['query1'];
        }
        if (isset($querydata['ids'])) {
            $ids = array_merge($ids, $querydata['ids']);
        }

        $place_holders = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  feature.feature_id,
  analysis.analysis_id, analysis.name AS analysis_name, analysis.description AS analysis_description, analysis.program AS analysis_program, analysis.programversion AS analysis_programversion, analysis.algorithm AS analysis_algorithm,
  assay.assay_id, assay.name AS assay_name, assay.description AS assay_description, 
  biomaterial.biomaterial_id, biomaterial.name AS biomaterial_name, biomaterial.description AS biomaterial_description
FROM 
  feature, 
  quantificationresult, 
  quantification, 
  analysis,
  acquisition,
  assay,
  biomaterial
WHERE 
  quantificationresult.feature_id = feature.feature_id AND
  quantificationresult.biomaterial_id = biomaterial.biomaterial_id AND
  quantification.quantification_id = quantificationresult.quantification_id AND
  quantification.analysis_id = analysis.analysis_id AND
  quantification.acquisition_id = acquisition.acquisition_id AND
  acquisition.assay_id = assay.assay_id AND
  feature.feature_id IN ({$place_holders});
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array('feature' => array(),
            'assay' => array(), 'analysis' => array(), 'biomaterial' => array());

        $stm_get_filters->execute($ids);
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {
            $data['data']['feature'][$filter['feature_id']] = self::getItem('feature', $filter);
            $data['data']['assay'][$filter['assay_id']] = self::getItem('assay', $filter);
            $data['data']['analysis'][$filter['analysis_id']] = self::getItem('analysis', $filter);
            $data['data']['biomaterial'][$filter['biomaterial_id']] = self::getItem('biomaterial', $filter);
            
            
            self::addId($data['feature'], $filter['feature_id']);
            self::addId($data['assay'][$filter['feature_id']], $filter['assay_id']);
            self::addId($data['analysis'][$filter['feature_id']][$filter['assay_id']], $filter['analysis_id']);
            self::addId($data['biomaterial'][$filter['feature_id']][$filter['analysis_id']][$filter['assay_id']], $filter['biomaterial_id']);
        }

        return $data;
    }
    
    private static function getItem($item_prefix, $row){
        $item = array();
        foreach ($row as $key => $val) {
            $match = null;
            if (preg_match("/${item_prefix}_(.*)/", $key, $match)) {
                $item[$match[1]] = $val;
            }
        }
        return $item;
    }

    private static function addId(&$ref, $id) {
        if ($ref == null)
            $ref = array();
        if (!in_array($id, $ref))
            $ref[] = $id;
        unset($ref);
    }

}

?>
