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

        if (count($ids) == 0)
            return array('aaData'=>array());

        $qmarks = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  f.name,
  d."baseMean",
  d."baseMeanA",
  d."baseMeanB",
  d."foldChange",
  d."log2foldChange",
  d.pval,
  d.pvaladj
FROM 
  diffexpresult d JOIN 
  feature f ON (d.feature_id = f.feature_id)
WHERE
   f.feature_id IN ($qmarks)
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);

        $data = array('aaData'=>array());

        $stm_get_diffexpr->execute($ids);
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = array_values($row);
        }

        return $data;
    }

    static function format(&$val, $key) {
        if (is_numeric($val))
            $val = sprintf('%.5e', $val);
        else if ($val == 'Infinity') {
            $val = 'Inf';
        } else if ($val == '-Infinity') {
            $val = '-Inf';
        }
    }

}

?>
