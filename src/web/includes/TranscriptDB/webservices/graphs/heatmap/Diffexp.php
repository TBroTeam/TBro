<?php

namespace webservices\graphs\heatmap;

use \PDO as PDO;
/**
 * returns Differential Expression data as y/x canvasxpress data, see http://canvasxpress.org/documentation.html#data
 */
class Diffexp extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();


        $feature_id = $querydata['featureid']; //feature ids


        $query = <<<EOF
SELECT 
    log2foldchange, 
    pvaladj,
    ba.name AS bioa,
    bb.name AS biob,
    analysis_id,
    quantification_id,
FROM 
    diffexpresult,
    biomaterial ba, 
    biomaterial bb 
WHERE 
    feature_id=? AND 
    ba.biomaterial_id=biomateriala_id AND 
    bb.biomaterial_id=biomaterialb_id AND
    analysis_id=?

EOF;

        $stm = $db->prepare($query);
        
        $stm->execute(array($feature_id));
        
        $values = array();
        
        $lastcell_name = '';
        $data = array();
        $vars = array();
        $ids = array();
        $smps = array();
        $x = array();
        $row = null;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
                
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                $lastcell_name = $cell['feature_name'];
                $data[] = array();
                $row = &$data[count($data) - 1];
                $vars[] = $cell['feature_name'];
                $ids[] = $cell['feature_id'];
            }

            if (count($data) == 1) {
                #sample-specific actions, only executed for first var
                $smps[] = $cell['biomaterial_name'];
                $x['Tissue_Group'][] = $cell['parent_biomaterial_name'];
                $x['Assay'][] = $cell['assay_name'];
                $x['Analysis'][] = "${cell['analysis_name']} (${cell['analysis_id']})";
            }

            $row[] = floatval($cell['value']);
        }

        return array(
            'x' => $x,
            'y' => array(
                'vars' => $vars,
                'smps' => $smps,
                'data' => $data,
                'ids' => $ids
            )
        );
    }

}

?>
