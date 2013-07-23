<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';
require_once ROOT . 'commands/Importer_Sequence_Ids.php';

/**
 * importer for fasta files. created predicted peptides.
 */
class Importer_Sequences_FASTA extends AbstractImporter {

    /**
     * reads the next fasta sequence from file handle $fasta_handle and returns a list of description and sequence (without whitespace and newlines)
     * @param resource $fasta_handle
     * @return list($description,$sequence)
     * @throws ErrorException with ErrorMsg ERRCODE_ILLEGAL_FILE_FORMAT: next non-empty line has to start with '>'
     */
    static function read_fasta($fasta_handle) {
        $description = '';
        while (empty($description) && !feof($fasta_handle))
            $description = trim(fgets($fasta_handle));
        if (strpos($description, '>') !== 0)
            throw new ErrorException(ERR_ILLEGAL_FILE_FORMAT);


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
     * @inheritDoc
     */
    static function import($options) {
        $filename = $options['file'];
        $lines_total = trim(`grep -c '>' $filename`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $isoforms_updated = 0;
        $predpeps_added = 0;

        #pre-initialize variables to bind statement parameters
        $param_isoform_name = null;
        $param_isoform_seqlen = null;
        $param_isoform_residues = null;

        $param_predpep_name = null;
        $param_predpep_uniq = null;
        $param_predpep_seqlen = null;
        $param_predpep_residues = null;
        $param_predpep_feature_id = null;
        $param_predpep_fmin = null;
        $param_predpep_fmax = null;
        $param_predpep_strand = null;
        $param_predpep_srcfeature_uniq = null;

        try {
            $db->beginTransaction();
            $import_prefix_id = Importer_Sequence_Ids::get_import_dbxref();
            # prepare statements
            #
            #insert sequence into existing isoform
            $statement_update_isoform = $db->prepare('UPDATE feature SET (seqlen, residues) = (:seqlen, :residues) WHERE name=:name AND organism_id=:organism AND type_id=:type_id RETURNING feature_id');
            $statement_update_isoform->bindParam('name', $param_isoform_name, PDO::PARAM_STR);
            $statement_update_isoform->bindParam('seqlen', $param_isoform_seqlen, PDO::PARAM_INT);
            $statement_update_isoform->bindParam('residues', $param_isoform_residues, PDO::PARAM_STR);
            $statement_update_isoform->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);
            $statement_update_isoform->bindValue('type_id', Importer_Sequence_Ids::get_import_dbxref(), PDO::PARAM_INT);

            #read file and execute statements

            $file = fopen($filename, 'r');
            while (!feof($file)) {
                #read next fasta entry
                list($description, $sequence) = self::read_fasta($file);

                $matches = array();

                #isoform header like this:
                #>comp173079_c0_seq1 len=2161 path=[2139:0-732 2872:733-733 2873:734-1159 3299:1160-1160 3300:1161-1513 3653:1514-1517 3657:1518-2160]
                if (preg_match('/^>(?<name>[^\s]+) .*$/', $description, $matches)) {
                    $param_isoform_name = $matches['name'];
                    $param_isoform_seqlen = strlen($sequence);
                    $param_isoform_residues = $sequence;
                    //update isoform with values
                    $statement_update_isoform->execute();

                    $isoforms_updated+=$statement_update_isoform->rowCount();
                }


                self::updateProgress(++$lines_imported);
            }
            self::preCommitMsg();
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'isoforms_updated' => $isoforms_updated, 'predpeps_added' => $predpeps_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "Sequence File Importer";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'sequences_fasta';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
   
File Format has to be a typical fasta file.
isoform headers have to look like
>comp173079_c0_seq1 <comment>

predpep headers have to look like
>m.1812924 <comments> comp173079_c0_seq1:3-1130(+)

\033[0;31mThis import requires a successful Sequence ID Import for the isoforms that should be imported!\033[0m
EOF;
    }

}

?>
