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
        require_once INC . '/webservices/details/Isoform.php';
        $service = new \webservices\details\Isoform();
        $isoform_data = $service->execute($querydata);

        $return = array();

        $min = 0;
        $max = 0;

        if (isset($isoform_data['isoform'])) {
            $isoform = $isoform_data['isoform'];
            $max = $isoform['seqlen'];
            $return[] = array(
                #'name' => 'Isoform',
                'type' => 'sequence',
                'subtype' => 'DNA',
                'data' => array(array(
                        'id' => $isoform['name'],
                        'sequence' => $isoform['residues'],
                        'translate' => array(-1, 3),
                        'dir' => 'right',
                        'offset' => 1
                ))
            );

            if (isset($isoform['repeatmasker'])) {
                $_data = array();
                foreach ($isoform['repeatmasker'] as $repeatmasker) {
                    $left = $repeatmasker['fmin'];
                    $right = $repeatmasker['fmax'];

                    $_data[] = array(
                        'id' => sprintf('%s#%s(%s)', $repeatmasker['repeat_name'],$repeatmasker['repeat_class'],$repeatmasker['repeat_family']),
                        'data' => array(array($left, $right)),
                        'dir' => self::strand2dir($repeatmasker['strand'])
                    );
                }
                if (count($_data) > 0)
                    $return[] = array(
                        #'name' => 'Interpro Domains',
                        'type' => 'box',
                        'fill' => 'rgb(255,25,51)',
                        'outline' => 'rgb(0,0,0)',
                        'data' => $_data
                    );
                unset($_data);
            }


            if (isset($isoform['predpeps'])) {
                foreach ($isoform['predpeps'] as $predpep) {
                    $return[] = array(
                        #'name' => 'Predicted Peptides',
                        'type' => 'sequence',
                        'subtype' => 'DNA',
                        'fill' => 'rgb(255,255,51)',
                        'outline' => 'rgb(0,0,0)',
                        'data' => array(array(
                                'id' => sprintf('predpep %d-%d'
                                        ,$predpep['fmin'],$predpep['fmax']),
                                'sequence' => self::rewinds(self::space($predpep['residues']), $predpep['strand']),
                                'offset' => $predpep['fmin'],
                                'dir' => 'right'#strand2dir($predpep['strand'])
                        ))
                    );
                    $_data = array();
                    if (isset($predpep['interpro'])) {
                        $_data = array();
                        foreach ($predpep['interpro'] as $interpro) {
                            $left = $predpep['fmin'] + ($interpro['fmin'] - 1) * 3;
                            $right = $left + ($interpro['fmax'] - $interpro['fmin'] + 1) * 3;
                            $_data[] = array(
                                'id' => sprintf('%s %d-%d',
                                        !empty($interpro['interpro_id'])?$interpro['interpro_id']:'IPR/anon     '
                                        ,$interpro['fmin'],$interpro['fmax']),
                                'data' => array(array($left, $right)),
                                'dir' => self::strand2dir($interpro['strand'])
                            );
                        }
                        if (count($_data) > 0)
                            $return[] = array(
                                #'name' => 'Interpro Domain',
                                'type' => 'box',
                                'fill' => 'rgb(20,255,51)',
                                'outline' => 'rgb(0,0,0)',
                                'data' => $_data
                            );
                    }
                }
            }
        }

        return array('tracks' => $return, 'min' => $min, 'max' => $max);
    }

}

?>
