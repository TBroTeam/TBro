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
  feature.uniquename = :unigene_name;
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);
        $stm_get_filters->bindValue('unigene_name', $param_unigene_name);

        $data = array('assay' => array(), 'analysis' => array(), 'biomaterial' => array());

        $stm_get_filters->execute();
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {
            self::addItem(&$data['assay'], 'assay', $filter);
            self::addItem(&$data['analysis'][$filter['assay_name']], 'analysis', $filter);
            self::addItem(&$data['biomaterial'][$filter['analysis_id']][$filter['assay_name']], 'biomaterial', $filter);
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
