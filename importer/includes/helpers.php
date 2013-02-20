<?php
/**
 * reads the next fasta sequence from file handle $fasta_handle and returns a list of description and sequence (without whitespace and newlines)
 * @param resource $fasta_handle
 * @return list ($description, $sequence)
 * @throws ErrorException with ErrorCode ERRCODE_ILLEGAL_FILE_FORMAT: next non-empty line has to start with '>'
 */
function read_fasta($fasta_handle) {
    $description = '';
    while (empty($description) && !feof($fasta_handle))
        $description = trim(fgets($fasta_handle));
    if (strpos($description, '>') !== 0)
        throw new ErrorException('', ERRCODE_ILLEGAL_FILE_FORMAT, 1);


    $sequence = '';
    while (!feof($fasta_handle)) {
        $pos = ftell($fasta_handle);
        $line = fgets($fasta_handle);
        if (strpos($line, '>') === 0) {
            fseek($fasta_handle, $pos, SEEK_SET);
            break;
        }
        $sequence .= trim($line);
    }
    return array($description, $sequence);
}


/**
 * Converts values to String that would be stored as Name (Suffic of UniqueName) in DB
 * @param string $isoform_name
 * @param int $left
 * @param int $right
 * @param char $direction [+-]
 * @return string
 */
function prepare_pedpep_name($isoform_name, $left, $right, $direction) {
    return $isoform_name . ':' . ($direction == '+' ? "$left-$right" : "$right-$left");
}
?>
