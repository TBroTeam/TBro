<?php

require_once __DIR__ . '/cfg/config.php';

function error($msg) {
    die(json_encode(array('status' => 'error', 'message' => $msg)));
}

$job = $_REQUEST['job'];

$type = ($job['type'] == 'blastp' || $job['type'] == 'tblastn') ? 'prot' : 'nucl';
$queries = split_fasta($job['query'], $type);

if (count($queries) == 0)
    error('No query sequence specified!');
//
$query_qmarks = implode(',', array_fill(0, count($queries), '?'));

$parameters = array();
foreach ($job['parameters'] as $key => $value) {
    $parameters[] = $key;
    $parameters[] = $value;
}
$additional_data = isset($job['additional_data']) ? $job['additional_data'] : array();
$parameter_qmarks = count($parameters) == 0 ? 'ARRAY[]' : implode(',', array_fill(0, count($parameters) / 2, 'ARRAY[?,?]'));
try {
    $pdo = new PDO(JOB_DB_CONNSTR, JOB_DB_USERNAME, JOB_DB_PASSWORD, array(PDO::ATTR_PERSISTENT => true, PDO::ATTR_EMULATE_PREPARES => false));
    $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
    $statement_create_job = $pdo->prepare('SELECT * FROM create_job(?,  ?, ?, ARRAY[' . $parameter_qmarks . '], ARRAY[' . $query_qmarks . ']);');
    $statement_create_job->execute(array_merge(
                    array($job['type'], $job['database'], json_encode($additional_data)), $parameters, $queries
            ));
    if ($statement_create_job->rowCount() == 0) {
        error('Job could not be started! Please report this error including all parameters you used.');
    }
} catch (\PDOException $e) {
    error('Job could not be started: ' . $e->getMessage());
}

die(json_encode(array('status' => 'success', 'job_id' => $statement_create_job->fetchColumn())));

/*
 * splits fasta input to sequences for processing.
 * a simple 
 * <b>$queries = explode('>', $query); for ($queries as &$val) $val = '>'.$val;</b>
 * would do the same but we also test the sequences for valid format
 * fasta format according to http://blast.ncbi.nlm.nih.gov/blastcgihelp.shtml
 */

function split_fasta($query, $type) {

    $fasta_allowed = array();
    /*
      A  adenosine          C  cytidine             G  guanine
      T  thymidine          N  A/G/C/T (any)        U  uridine
      K  G/T (keto)         S  G/C (strong)         Y  T/C (pyrimidine)
      M  A/C (amino)        W  A/T (weak)           R  G/A (purine)
      B  G/T/C              D  G/A/T                H  A/C/T
      V  G/C/A              -  gap of indeterminate length
     */
    $fasta_allowed['nucl'] = 'ACGTNUKSYMWRBDHV-';
    /*
      A  alanine               P  proline
      B  aspartate/asparagine  Q  glutamine
      C  cystine               R  arginine
      D  aspartate             S  serine
      E  glutamate             T  threonine
      F  phenylalanine         U  selenocysteine
      G  glycine               V  valine
      H  histidine             W  tryptophan
      I  isoleucine            Y  tyrosine
      K  lysine                Z  glutamate/glutamine
      L  leucine               X  any
      M  methionine            *  translation stop
      N  asparagine            -  gap of indeterminate length
     */
    $fasta_allowed['prot'] = 'ABCDEFGHIKLMNPQRSTUVWYZX*-';

    $queries = array();

    if (strpos($query, '>') === FALSE) {
        //we have just one sequence without header
        $query = trim($query);
        if (preg_match('/^[0-9\\s' . $fasta_allowed[$type] . ']+$/im', $query))
            if (preg_match('/(\n\n|\r\n\r\n|\n\r\n\r)/im', $query)) {
                error('FASTA sequence invalid! If you want to specify multiple sequences, add headers. If you want to query a single sequence, remove blank lines.');
            } else {
                $queries[] = $query;
            }
        else
            error('FASTA sequence invalid!');
    } else {
        $require_next_line_header = true;
        $lines = explode(PHP_EOL, $query);
        foreach ($lines as $nr => $line) {
            $line = trim($line);
            if (strpos($line, '>') === 0) {
// header line
                $require_next_line_header = false;
                $queries [] = "";
                $current = &$queries[count($queries) - 1];
                $current.=$line;
            } else if (strlen($line) > 0) {
// content line, check for correct sequence
                if ($require_next_line_header)
                    error(sprintf('Missing FASTA Header at line number %d', $nr));
                if (!preg_match('/^[' . $fasta_allowed[$type] . ']+$/i', $line))
                    error(sprintf('FASTA sequence invalid in line %d!', $nr));
                $current.="\n".$line;
            } else {
//empty line, require a new header
                $require_next_line_header = true;
            }
        }
    }

    return $queries;
}
?>

