<?php

namespace webservices\listing;

use \PDO as PDO;

class Differential_expressions extends \WebService {

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


        $query_get_filters = <<<EOF
SELECT 
  name,
  "baseMean",
  "baseMeanA",
  "baseMeanB",
  "foldChange",
  "log2foldChange",
  pval,
  pvaladj
FROM 
  diffexpresult d JOIN 
  feature f ON (d.feature_id = f.feature_id)
  
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);

        $data = array();

        $stm_get_diffexpr->execute($ids);
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = array_values($row);
        }

        return $data;
    }
    
    static function format(&$val, $key){
        if (is_numeric($val))
            $val = sprintf('%.5e',$val);
    }

}

?>
