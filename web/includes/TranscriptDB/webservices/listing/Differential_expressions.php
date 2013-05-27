<?php

namespace webservices\listing;

use \PDO as PDO;

class Differential_expressions extends \WebService {

    public function byIds($querydata) {
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
            return array('aaData' => array());

        $qmarks = implode(',', array_fill(0, count($ids), '?'));

        $query_get_filters = <<<EOF
SELECT 
  f.name AS feature_name,
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
   (d.biomateriala_id = ? AND
   d.biomaterialb_id = ?)
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);

        $data = array('aaData' => array());

        $stm_get_diffexpr->execute(array_merge($ids, array($analysis, $sampleA, $sampleB)));
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = $row; //array_values($row);
        }

        return $data;
    }

    public function fullRelease($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        $aColumns = array('feature_name',
            'baseMean',
            'baseMeanA',
            'baseMeanB',
            'foldChange',
            'log2foldChange',
            'pval',
            'pvaladj');

        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';
        $analysis = $querydata['analysis'];
        $sampleA = $querydata['sampleA'];
        $sampleB = $querydata['sampleB'];

        //dataTable variables:


        $limit_from = intval($querydata['iDisplayStart']);
        $limit_count = max(array(10, min(array(1000, intval($querydata['iDisplayLength'])))));

        $order_by = $aColumns[0];
        $order_dir = 'desc';
        if (isset($_GET['iSortCol_0'])) {
            for ($i = 0; $i < intval($_GET['iSortingCols']); $i++) {
                if ($_GET['bSortable_' . intval($_GET['iSortCol_' . $i])] == "true") {
                    $order_by = $aColumns[intval($_GET['iSortCol_' . $i])];
                    $order_dir = ($_GET['sSortDir_' . $i] === 'asc' ? 'asc' : 'desc');
                }
            }
        }
        $query_get_filters = <<<EOF
SELECT 
  f.name AS feature_name,
  d."baseMean",
  d."baseMeanA",
  d."baseMeanB",
  d."foldChange",
  d."log2foldChange",
  d.pval,
  d.pvaladj,
  COUNT(*) OVER () AS cnt 
FROM 
	diffexpresult d 
	join feature f on d.feature_id=f.feature_id 
WHERE
   d.analysis_id = ? AND 
   d.biomateriala_id = ? AND
   d.biomaterialb_id = ? AND
   f.organism_id=? 
   AND f.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)        
ORDER BY "$order_by" $order_dir
OFFSET $limit_from LIMIT $limit_count
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);
        $stm_get_diffexpr->execute(array($analysis, $sampleA, $sampleB, $organism, $release));
        $data = array(
            "sEcho" => intval($querydata['sEcho']),
            "iTotalDisplayRecords" => $stm_get_diffexpr->rowCount(),
            "aaData" => array()
        );


        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($data['iTotalRecords'])) {
                $data['iTotalRecords'] = $row['cnt'];
                $data['iTotalDisplayRecords'] = $row['cnt'];
            }
            array_walk($row, array('webservices\listing\Differential_expressions', 'format'));
            $data['aaData'][] = $row; //array_values($row);
        }

        return $data;
    }

    public function releaseCsv($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';
        $analysis = $querydata['analysis'];
        $sampleA = $querydata['sampleA'];
        $sampleB = $querydata['sampleB'];


        $query_get_filters = <<<EOF
SELECT 
  f.name AS feature_name,
  d."baseMean",
  d."baseMeanA",
  d."baseMeanB",
  d."foldChange",
  d."log2foldChange",
  d.pval,
  d.pvaladj
FROM 
	diffexpresult d 
	join feature f on d.feature_id=f.feature_id 
WHERE
   d.analysis_id = ? AND 
   d.biomateriala_id = ? AND
   d.biomaterialb_id = ? AND
   f.organism_id=? 
   AND f.dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')} AND accession = ?)        
EOF;

        $stm_get_diffexpr = $db->prepare($query_get_filters);
        $stm_get_diffexpr->execute(array($analysis, $sampleA, $sampleB, $organism, $release));

        $table = sprintf('diffexp_%d_%s_%d_%d_%d', $organism, $release, $sampleA, $sampleB, $analysis);

        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        header("Content-Disposition: attachment; filename=\"$table.csv\";");
        header("Content-Transfer-Encoding: binary");


        $out = fopen('php://output', 'w');
        $first = true;
        while ($row = $stm_get_diffexpr->fetch(PDO::FETCH_ASSOC)) {
            if ($first) {
                $first = false;
                fputcsv($out, array_keys($row));
            }
            fputcsv($out, array_values($row));
        }
        fclose($out);
        return null;
    }

    public function execute($querydata) {
        if ($querydata['query1'] == 'byIds') {
            return $this->byIds($querydata);
        } elseif ($querydata['query1'] == 'fullRelease') {
            return $this->fullRelease($querydata);
        } elseif ($querydata['query1'] == 'releaseCsv') {
            return $this->releaseCsv($querydata);
        }
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
