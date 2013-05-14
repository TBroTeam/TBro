<?php

namespace webservices\graphs\genome;

class Isoform extends \WebService {

    private static function strand2dir($strand) {
        return $strand > 0 ? 'right' : 'left';
    }

    private static function space($sequence) {
        $ret = "";
        for ($i = 0; $i < strlen($sequence); $i++)
            $ret .= $sequence{$i} . '  ';
        return $ret;
    }

    private static function rewinds($sequence, $strand) {
        if ($strand < 0)
            return strrev($sequence);
        return $sequence;
    }

    public function execute($querydata) {
        global $db;

        #UI hint
        if (false)
            $db = new \PDO();

        $stm_get_features = $db->prepare('SELECT * FROM get_isoform_graph(?)');
        $stm_get_features->execute(array($querydata['query1']));

        $return = array();
        $min = 0;
        $max = 0;

        $last_row = null;

        //(feature_id int, type_id int, residues text, seqlen int, fmin int, fmax int, strand smallint);
        while ($row = $stm_get_features->fetch(\PDO::FETCH_ASSOC)) {
            switch ($row['type_id']) {
                case CV_ISOFORM:
                    $max = $row['seqlen'];
                    $return[] = array(
                        #'name' => 'Isoform',
                        'type' => 'sequence',
                        'subtype' => 'DNA',
                        'data' => array(array(
                                'id' => $row['name'],
                                'sequence' => $row['residues'],
                                'translate' => array(-1, 3),
                                'dir' => 'right',
                                'offset' => 1
                        ))
                    );
                    break;
                case CV_ANNOTATION_REPEATMASKER:
                    // this would look better, but canvasXpress cuts datasets after 8 rows so each bar has to be it's own dataset
                    //if (!isset($return['repeatmasker'])) {
                        $return[] = array(
                            #'name' => 'Repeatmasker',
                            'type' => 'box',
                            'fill' => 'rgb(255,25,51)',
                            'outline' => 'rgb(0,0,0)',
                            'data' => array()
                        );
                        $current_repeatmasker = &$return[count($return)-1];
                    //}
                    
                    $current_repeatmasker['data'][] = array(
                        'id' => $row['name'],
                        'data' => array(array($row['fmin'], $row['fmax'])),
                        'dir' => self::strand2dir($row['strand'])
                    );
                    break;
                case CV_PREDPEP:
                    $last_predpep_row = $row;
                    $return[] = array(
                        #'name' => 'Predicted Peptides',
                        'type' => 'sequence',
                        'subtype' => 'DNA',
                        'fill' => 'rgb(255,255,51)',
                        'outline' => 'rgb(0,0,0)',
                        'data' => array(array(
                                'id' => sprintf('predpep %d-%d'
                                        , $row['fmin'], $row['fmax']),
                                'sequence' => self::rewinds(self::space($row['residues']), $row['strand']),
                                'offset' => $row['fmin'],
                                'dir' => 'right'#strand2dir($predpep['strand'])
                        ))
                    );
                    break;
                case CV_ANNOTATION_INTERPRO:
                    // this would look better, but canvasXpress cuts datasets after 8 rows so each bar has to be it's own dataset
                    //if ($last_row['type_id'] != CV_ANNOTATION_INTERPRO) {
                        
                        $return[] = array(
                            #'name' => 'Interpro Domain',
                            'type' => 'box',
                            'fill' => 'rgb(20,255,51)',
                            'outline' => 'rgb(0,0,0)',
                            'data' => array()
                        );
                        $current_interpro = &$return[count($return)-1];
                    //}
                    $left = $last_predpep_row['fmin'] + ($row['fmin'] - 1) * 3;
                    $right = $left + ($row['fmax'] - $row['fmin'] + 1) * 3;
                    $current_interpro['data'][] = array(
                        'id' => $row['name'],
                        'data' => array(array($left, $right)),
                        'dir' => self::strand2dir($row['strand'])
                    );
                    break;
            }
            $last_row = $row;
        }
        return array('tracks' => array_values($return), 'min' => $min, 'max' => $max);
    }

}

?>
