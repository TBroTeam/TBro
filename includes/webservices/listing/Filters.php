<?php

namespace webservices\listing;

use \PDO as PDO;

class Filters extends \WebService {

    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        $uniquenames = array();
        if (isset($querydata['query1'])) {
            $uniquenames[] = $querydata['query1'];
        }
        if (isset($querydata['uniquenames'])) {
            $uniquenames =
                    array_merge($uniquenames, $querydata['uniquenames']);
        }

        $place_holders = implode(',', array_fill(0, count($uniquenames), '?'));

        $query_get_filters = <<<EOF
SELECT 
  feature.uniquename AS feature_uniquename,
  analysis.analysis_id AS analysis_id, analysis.name AS analysis_name, analysis.description AS analysis_description, analysis.program AS analysis_program, analysis.programversion AS analysis_programversion, analysis.algorithm AS analysis_algorithm,
  assay.name AS assay_name, assay.description AS assay_description, 
  biomaterial.name AS biomaterial_name, biomaterial.description AS biomaterial_description
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
  feature.uniquename IN ({$place_holders});
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array('feature' => array(),
            'assay' => array(), 'analysis' => array(), 'biomaterial' => array());

        $stm_get_filters->execute($uniquenames);
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {
            self::addItem($data['feature'], 'feature', $filter);
            self::addItem($data['assay'][$filter['feature_uniquename']], 'assay', $filter);
            self::addItem($data['analysis'][$filter['feature_uniquename']][$filter['assay_name']], 'analysis', $filter);
            self::addItem($data['biomaterial'][$filter['feature_uniquename']][$filter['analysis_id']][$filter['assay_name']], 'biomaterial', $filter);
        }

        return $data;
    }

    private static function addItem(&$ref, $item_prefix, $row) {
        $item = array();
        foreach ($row as $key => $val) {
            $match = null;
            if (preg_match("/${item_prefix}_(.*)/", $key, $match)) {
                $item[$match[1]] = $val;
            }
        }

        if ($ref == null)
            $ref = array();
        if (!in_array($item, $ref))
            $ref[] = $item;
        unset($ref);
    }

}

?>
