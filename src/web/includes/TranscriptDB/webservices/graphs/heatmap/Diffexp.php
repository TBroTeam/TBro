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


        $feature_id = $querydata['featureid']; //feature id
        $analysis = $querydata['analysis']; //one analysises
        $quantification = $querydata['quantification']; //one quantification


        $query = <<<EOF
SELECT 
    log2foldchange, 
    pvaladj,
    ba.name AS bioa,
    bb.name AS biob
FROM 
    diffexpresult,
    biomaterial ba, 
    biomaterial bb 
WHERE 
    feature_id=? AND 
    ba.biomaterial_id=biomateriala_id AND 
    bb.biomaterial_id=biomaterialb_id AND
    analysis_id=? AND
    quantification_id=?

EOF;

        $stm = $db->prepare($query);

        $stm->execute(array($feature_id, $analysis, $quantification));

        $values = array();
        $biomaterials = array();
        $counter = 0;

        $data = array();
        $vars = array();
        $ids = array();
        $smps = array();
        $x = array();
        $row = null;
        //again, see http://canvasxpress.org/documentation.html#data !
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if (!array_key_exists($cell['bioa'], $biomaterials)) {
                $biomaterials[$cell['bioa']] = $counter++;
            }
            if (!array_key_exists($cell['biob'], $biomaterials)) {
                $biomaterials[$cell['biob']] = $counter++;
            }
            if (!array_key_exists($cell['bioa'], $values)) {
                $values[$cell['bioa']] = array();
            }
            $values[$cell['bioa']][$cell['biob']] = array('pvaladj' => $cell['pvaladj'], 'log2foldchange' => $cell['log2foldchange']);
        }

        return array($biomaterials, $values);
    }

}

?>
