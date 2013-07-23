<?php

namespace cli_import;

use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';
require_once ROOT . 'commands/Importer_Sequence_Ids.php';

/**
 * importer for fasta files. created predicted peptides.
 */
class Importer_Peptides extends AbstractImporter {

    /**
     * @inheritDoc
     */
    static function import($options) {
        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $predpeps_added = 0;

        #pre-initialize variables to bind statement parameters

        $param_predpep_name = null;
        $param_predpep_uniq = null;
        $param_predpep_seqlen = null;
        $param_predpep_feature_id = null;
        $param_predpep_fmin = null;
        $param_predpep_fmax = null;
        $param_predpep_strand = null;
        $param_predpep_srcfeature_uniq = null;

        try {
            $db->beginTransaction();
            $import_prefix_id = Importer_Sequence_Ids::get_import_dbxref();
            # prepare statements
            #create predicted peptide
            $statement_insert_predpep = $db->prepare('INSERT INTO feature  (type_id, organism_id, name, uniquename, seqlen, dbxref_id) '
                    . 'VALUES (:type_id, :organism_id, :name, :uniquename, :seqlen, :dbxref_id) RETURNING feature_id');
            $statement_insert_predpep->bindValue('type_id', CV_PREDPEP, PDO::PARAM_INT);
            $statement_insert_predpep->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $statement_insert_predpep->bindParam('name', $param_predpep_name, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('uniquename', $param_predpep_uniq, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('seqlen', $param_predpep_seqlen, PDO::PARAM_INT);

            $statement_insert_predpep->bindValue('dbxref_id', $import_prefix_id, PDO::PARAM_INT);

            #link predpep to parent isoform
            $statement_insert_predpep_location = $db->prepare(sprintf('INSERT INTO featureloc (fmin, fmax, strand, feature_id, srcfeature_id) VALUES (:fmin, :fmax, :strand, :feature_id, (%s))', 'SELECT feature_id FROM feature WHERE uniquename=:srcfeature_uniquename LIMIT 1'));
            $statement_insert_predpep_location->bindParam('fmin', $param_predpep_fmin, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('fmax', $param_predpep_fmax, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('strand', $param_predpep_strand, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('feature_id', $param_predpep_feature_id, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('srcfeature_uniquename', $param_predpep_srcfeature_uniq, PDO::PARAM_STR);

            #read file and execute statements

            $file = fopen($filename, 'r');
            while (!feof($file)) {

                $line = fgetcsv($file, 0, "\t");
                list($param_predpep_name, $isoform_name, $predpep_start, $predpep_end, $predpep_dir) = $line;

                $param_predpep_uniq = IMPORT_PREFIX . "_" . $param_predpep_name;
                $param_predpep_seqlen = abs($predpep_end - $predpep_start) + 1;
                // $param_predpep_residues = $sequence;
                //create predpep
                $statement_insert_predpep->execute();
                //link to parent feature
                $param_predpep_feature_id = $statement_insert_predpep->fetchColumn();
                $param_predpep_srcfeature_uniq = IMPORT_PREFIX . "_" . $isoform_name;
                $param_predpep_fmin = min($predpep_start, $predpep_end);
                $param_predpep_fmax = max($predpep_start, $predpep_end);
                $param_predpep_strand = $predpep_dir == '+' ? 1 : -1;
                $statement_insert_predpep_location->execute();
                $predpeps_added+=$statement_insert_predpep->rowCount();

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
        return array(LINES_IMPORTED => $lines_imported, 'predpeps_added' => $predpeps_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "Peptide Table File Importer";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'peptide_ids';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
   
File Format has to be a tab separated file.
consisting of
peptide_id  isoform_id  start   end strand(+-)

\033[0;31mThis import requires a successful Sequence ID Import for the parent isoforms!\033[0m
EOF;
    }

}

?>
