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
        $padj = array();
        $type = array();
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
        
        for($i=0; $i<$counter; $i++){
            $data[$i] = array_fill(0, $counter, 'NA');
            $padj[$i] = array_fill(0, $counter, 1);
            $type[$i] = array_fill(0, $counter, 'NA');
        }
        
        foreach($values AS $bioa => $val){
            foreach($val AS $biob => $v){
                if($v['log2foldchange'] == "Infinity" || $v['log2foldchange'] == "-Infinity"){
                    $data[$biomaterials[$bioa]][$biomaterials[$biob]] = 'NA';
                    $data[$biomaterials[$biob]][$biomaterials[$bioa]] = 'NA';
                    $type[$biomaterials[$bioa]][$biomaterials[$biob]] = ($v['log2foldchange'] == "Infinity" ? 'INF' : '-INF');
                    $type[$biomaterials[$biob]][$biomaterials[$bioa]] = ($v['log2foldchange'] == "Infinity" ? '-INF' : 'INF');
                }
                else{
                    $data[$biomaterials[$bioa]][$biomaterials[$biob]] = $v['log2foldchange'];
                    $data[$biomaterials[$biob]][$biomaterials[$bioa]] = -$v['log2foldchange'];
                    $type[$biomaterials[$bioa]][$biomaterials[$biob]] = 'NUM';
                    $type[$biomaterials[$biob]][$biomaterials[$bioa]] = 'NUM';
                }
                $padj[$biomaterials[$bioa]][$biomaterials[$biob]] = $v['pvaladj'];
                $padj[$biomaterials[$biob]][$biomaterials[$bioa]] = $v['pvaladj'];
            }
        }

        return array(
            'x' => array('Condition' => array_keys($biomaterials)),
            'y' => array(
                'vars' => array_keys($biomaterials),
                'smps' => array_keys($biomaterials),
                'data' => $data,
                'cor' => $data,
                'padj' => $padj,
                'type' => $type
            )
        );
    }

}

?>
