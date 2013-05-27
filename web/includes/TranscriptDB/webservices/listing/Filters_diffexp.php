<?php

namespace webservices\listing;

use \PDO as PDO;

class Filters_diffexp extends \WebService {

    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        
        $ids = array();
        if (isset($querydata['ids'])) {
            $ids = array_merge($ids, $querydata['ids']);
        }
        
        
        $place_holders = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  d.feature_id AS feature_id,
  analysis.analysis_id, analysis.name AS analysis_name, analysis.description AS analysis_description, analysis.program AS analysis_program, analysis.programversion AS analysis_programversion, analysis.algorithm AS analysis_algorithm,
  ba.biomaterial_id AS ba_id, ba.name AS ba_name, ba.description AS ba_description,
  bb.biomaterial_id AS bb_id, bb.name AS bb_name, bb.description AS bb_description
FROM 
  diffexpresult d
  JOIN analysis ON (d.analysis_id = analysis.analysis_id)
  JOIN biomaterial ba ON (d.biomateriala_id = ba.biomaterial_id)
  JOIN biomaterial bb ON (d.biomaterialb_id = bb.biomaterial_id)
WHERE 
  d.feature_id IN ({$place_holders});
EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array();
        
        $stm_get_filters->execute($ids);
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {
            
            $data['data']['feature'][$filter['feature_id']] = self::getItem('feature', $filter);
            $data['data']['analysis'][$filter['analysis_id']] = self::getItem('analysis', $filter);
            $data['data']['ba'][$filter['ba_id']] = self::getItem('ba', $filter);
            $data['data']['bb'][$filter['bb_id']] = self::getItem('bb', $filter);
            
            $data['values'][] = array(
                'feature' => $filter['feature_id'],
                'analysis' => $filter['analysis_id'],
                'ba' => $filter['ba_id'],
                'bb' => $filter['bb_id'],
            );
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
