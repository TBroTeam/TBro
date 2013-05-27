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
        if (isset($querydata['ids'])) {
            $ids = array_merge($ids, $querydata['ids']);
        }
        
        $analysis = $querydata['analysis'];
        $sampleA = $querydata['sampleA'];
        $sampleB = $querydata['sampleB'];
        

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
  diffexpresult d 
  JOIN feature f ON (d.feature_id = f.feature_id)
WHERE
   d.feature_id IN ($qmarks) AND
   d.analysis_id = ? AND 
   d.biomateriala_id = ? AND
   d.biomaterialb_id = ?
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);

        $data = array('aaData'=>array());

        $stm_get_diffexpr->execute(array_merge($ids, array($analysis, $sampleA, $sampleB)));
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = $row;//array_values($row);
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
