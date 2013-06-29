<?php

namespace webservices\advancedsearch;

class Actions extends \WebService {

    public $actions = array(
        'feature_type' => array(
            'description' => 'search for feature type',
            'selectors' => array('is'),
            'type' => 'select',
            'options' => array('unigene', 'isoform'),
            'required' => 'required'
        ),
        'feature_name' => array(
            'selectors' => array('is', 'starts with'),
            'type' => 'input',
            'regex' => '/[a-z0-9._-]{3,}/i',
        ),
        'has_interpro' => array(
            'description' => 'has predpep with interpro annotation',
            'selectors' => array('interpro id'),
            'type' => 'input',
            'regex' => '/IPR[0-9]+/'
        ),
        'has_interpro_db_match' => array(
            'selectors' => array(
                'Coil',
                'FPrintScan',
                'Gene3D',
                'HMMPanther',
                'HMMPfam',
                'HMMPIR',
                'HMMSmart',
                'HMMTigr',
                'PatternScan',
                'ProfileScan',
                'Seg',
                'superfamily',
                'TMHMM'
            ),
            'type' => 'input',
        ),
        'has_interpro_GO_match' => array(
            'type' => 'input',
            'selectors' => array('GO accession'),
            'regex' => '/\d{3,8}/'
        ),
        'has_GO_match' => array(
            'type' => 'input',
            'selectors' => array('GO accession'),
            'regex' => '/\d{3,8}/'
        ),
        'has_repeatmasker_match' => array(
            'type' => 'input',
            'selectors' => array('name','class','family'),
            'regex' => '/\w+/'
        )
    );
    
    public function execute($data) {
        return array('actions'=>$this->actions);
    }
}

?>
