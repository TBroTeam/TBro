<?php
function in_between($val, $min, $max) {
    return $min <= $val && $val <= $max;
}

$blast_matrix_options = array('BLOSUM45','BLOSUM50','BLOSUM62','BLOSUM80','BLOSUM90','PAM30','PAM70','PAM250');

$blast_parameter_config = array(
    'general' => array(
        '-outfmt' => array(
            'default' => 5
        ),
        '-num_descriptions' => array(
            'default' => 10,
            'test' => 'in_between',
            'test_additional_parameters' => array(1, 500)
        ),
        '-num_alignments' => array(
            'default' => 10,
            'test' => 'in_between',
            'test_additional_parameters' => array(1, 200)
        ),
        '-evalue'=>array(
            'default' => 0.1,
            'test' => 'in_between',
            'test_additional_parameters' => array(0, 100)
        )
    ),
    'blastn' => array(
        '-task' => array(
            'default' => 'megablast',
            'test' => 'in_array',
            'test_additional_parameters' => array(array('blastn', 'dc-megablast', 'megablast'))
        )
    ),
    'blastp' => array(
        '-task' => array(
            'default' => 'blastp',
        ),
        '-matrix' => array(
            'default' => 'BLOSUM62',
            'test' => 'in_array',
            'test_additional_parameters' => array($blast_matrix_options)
        )
    ),
    'blastx' => array(
        '-matrix' => array(
            'default' => 'BLOSUM62',
            'test' => 'in_array',
            'test_additional_parameters' => array($blast_matrix_options)
        )
    ),
    'tblastn' => array(
         '-matrix' => array(
            'default' => 'BLOSUM62',
            'test' => 'in_array',
            'test_additional_parameters' => array($blast_matrix_options)
        )
    ),
    'tblastx' => array(
         '-matrix' => array(
            'default' => 'BLOSUM62',
            'test' => 'in_array',
            'test_additional_parameters' => array($blast_matrix_options)
        )
    ),
);

?>
