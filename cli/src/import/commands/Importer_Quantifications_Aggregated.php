<?php

require_once ROOT . 'classes/AbstractImporter.php';

class Importer_Quantifications_Aggregated extends AbstractImporter {

    /**
     * This function will import Quantification data from a tab-separated file.
     * First line will be skiped ad header.
     * Which column will be used for value is specified with $value_column
     * @global PDO $db database
     * @param string $filename file name
     * @param int $quantification_id quantification id
     * @param string $biomaterial_name biomaterial name
     * @param string $type_name type name (=>cvterm)
     * @param int $value_column csv column with "value". this numbering starts at 1!
     * @return count of imported lines
     * @throws Exception
     * @throws ErrorException
     */
    static function import($options) {

        $filename = $options['file'];
        $quantification_id = $options['quantification_id'];
        $type_name = $options['type_name'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;

        $lines_imported = 0;
        $inserts_executed = 0;

        try {
            $statement_get_type_id = $db->prepare('SELECT cvterm_id FROM cvterm WHERE name=:type_name LIMIT 1');
            $statement_get_type_id->bindValue('type_name', $type_name, PDO::PARAM_STR);
            $statement_get_type_id->execute();
            $type_id = $statement_get_type_id->fetchColumn();
            if (!$type_id) {
                throw new ErrorException('Type with this name not defined in table cvterm');
            }

            $db->beginTransaction();

            #shared parameters
            $param_feature_id = null;
            $param_value = null;
            $param_biomaterial_id = null;


            $statement_insert_quant = $db->prepare('INSERT INTO quantificationresult (feature_id, quantification_id, biomaterial_id, type_id, value) '
                    . 'VALUES (:feature_id, :quantification_id, :biomaterial_id, :type_id, :value)');
            $statement_insert_quant->bindParam('feature_id', $param_feature_id, PDO::PARAM_STR);
            $statement_insert_quant->bindParam('value', $param_value, PDO::PARAM_STR);
            $statement_insert_quant->bindParam('biomaterial_id', $param_biomaterial_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('quantification_id', $quantification_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('type_id', $type_id, PDO::PARAM_INT);

            $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=? LIMIT 1');

            $statement_get_feature_id = $db->prepare('SELECT feature_id FROM feature WHERE uniquename=? LIMIT 1');

            $file = fopen($filename, 'r');
            if (feof($file))
                return;
            #process header line, get biomaterial_ids for names
            $biomaterial_names = fgetcsv($file, 0, "\t");
            $biomaterial_ids = array();
            for ($i = 1; $i < count($biomaterial_names); $i++) {
                $statement_get_biomaterial_id->execute(array($biomaterial_names[$i]));
                $biomaterial_ids[$i] = $statement_get_biomaterial_id->fetchColumn();
                if (!$biomaterial_ids[$i]) {
                    throw new ErrorException('Biomaterial with this name not defined');
                }
            }



            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                $feature_uniquename = IMPORT_PREFIX . "_" . $line[0];
                $statement_get_feature_id->execute(array($feature_uniquename));
                $param_feature_id = $statement_get_feature_id->fetchColumn();

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
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'inserts executed' => $inserts_executed);
    }

    public static function CLI_getCommand(Console_CommandLine $parser) {
        $command = parent::CLI_getCommand($parser);
        $command->addOption('quantification_id',
                array(
            'short_name' => '-q',
            'long_name' => '--quantification_id',
            'description' => 'quantification id'
        ));
        $command->addOption('type_name',
                array(
            'short_name' => '-t',
            'long_name' => '--type_name',
            'description' => 'type name. this has to be a cvterm.'
        ));
    }

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        parent::CLI_checkRequiredOpts($command);
        $options = $command->options;
        AbstractImporter::dieOnMissingArg($options, 'quantification_id');
        AbstractImporter::dieOnMissingArg($options, 'type_name');
    }

    public static function CLI_commandDescription() {
        return "Aggregated Count File Importer";
    }

    public static function CLI_commandName() {
        return 'count_matrix';
    }

    public static function CLI_longHelp() {
        return <<<EOF
   
Imports output files from Anna-Lena Keller's "aggregator_CountMat.pl" script.

File format looks like:
ID      flower_L1       flower_L2       flower_L3       coronatin_L1    coronatin_L2    coronatin_L3
comp234711_c0_seq9      21.93   11.26   8.83    2.40    0.00    2.25

The label_RSEM names have to match the biomaterial names.
\033[0;31mThis import requires a successful Map File Import!\033[0m
EOF;
    }

}

?>
