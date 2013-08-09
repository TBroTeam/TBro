<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';

class Importer_Expressions extends AbstractImporter {

    /**
     * This function will import Quantification data from a tab-separated file.
     * First line will be skiped as header.
     * @inheritDoc
     */
    static function import($options) {

        $filename = $options['file'];
        $quantification_id = $options['quantification_id'];
        $analysis_id = $options['analysis_id'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`) - 1; //-1 for header line
        self::setLineCount($lines_total);

        global $db;

        $lines_imported = 0;
        $inserts_executed = 0;

        try {

            $db->beginTransaction();

            #shared parameters
            $param_feature_id = null;
            $param_value = null;
            $param_biomaterial_id = null;

            // statement for insertion of expressionresult
            $statement_insert_quant = $db->prepare('INSERT INTO expressionresult (feature_id, quantification_id, biomaterial_id, analysis_id, value) '
                    . 'VALUES (:feature_id, :quantification_id, :biomaterial_id, :analysis_id, :value)');
            $statement_insert_quant->bindParam('feature_id', $param_feature_id, PDO::PARAM_STR);
            $statement_insert_quant->bindParam('value', $param_value, PDO::PARAM_STR);
            $statement_insert_quant->bindParam('biomaterial_id', $param_biomaterial_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('quantification_id', $quantification_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('analysis_id', $analysis_id, PDO::PARAM_INT);

            //statement to get biomaterial ids
            $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=? LIMIT 1');

            //statement for feature ids
            $statement_get_feature_id = $db->prepare('SELECT feature_id FROM feature WHERE uniquename=?  AND organism_id=? LIMIT 1');

            $file = fopen($filename, 'r');
            if (feof($file))
                return;
            //process header line, get biomaterial_ids for names
            $biomaterial_names = fgetcsv($file, 0, "\t");
            $biomaterial_ids = array();
            for ($i = 1; $i < count($biomaterial_names); $i++) {
                $statement_get_biomaterial_id->execute(array($biomaterial_names[$i]));
                $biomaterial_ids[$i] = $statement_get_biomaterial_id->fetchColumn();
                if (!$biomaterial_ids[$i]) {
                    throw new \ErrorException('Biomaterial with this name not defined');
                }
            }

            //process count lines
            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                //get feature id once per line
                $feature_uniquename = IMPORT_PREFIX . "_" . $line[0];
                $statement_get_feature_id->execute(array($feature_uniquename, DB_ORGANISM_ID));
                $param_feature_id = $statement_get_feature_id->fetchColumn();

                //for all columns >1, insert counts based on feature_id and biomaterial_id
                for ($i = 1; $i < count($line); $i++) {
                    $param_value = $line[$i];
                    $param_biomaterial_id = $biomaterial_ids[$i];
                    $statement_insert_quant->execute();
                    $inserts_executed++;
                }

                self::updateProgress(++$lines_imported);
            }

            self::preCommitMsg();
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new \ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'inserts executed' => $inserts_executed);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = parent::CLI_getCommand($parser);
        $command->addOption('quantification_id', array(
            'short_name' => '-q',
            'long_name' => '--quantification_id',
            'description' => 'quantification id'
        ));

        $command->addOption('analysis_id', array(
            'short_name' => '-a',
            'long_name' => '--analysis_id',
            'description' => 'analysis_id.'
        ));
        return $command;
    }

    /**
     * @inheritDoc
     */
    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        parent::CLI_checkRequiredOpts($command);
        $options = $command->options;
        AbstractImporter::dieOnMissingArg($options, 'quantification_id');
        AbstractImporter::dieOnMissingArg($options, 'analysis_id');
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "Importer for expression result \"count matrix\" files";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'expressions';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
   
Imports output files from "aggregator_CountMat.pl" script.

File format looks like:
ID      flower_L1       flower_L2       flower_L3       coronatin_L1    coronatin_L2    coronatin_L3
comp234711_c0_seq9      21.93   11.26   8.83    2.40    0.00    2.25

The labels in the header have to match the condition sample names in the database
\033[0;31mThis import requires a successful Sequence ID Import!\033[0m
EOF;
    }

}

?>
