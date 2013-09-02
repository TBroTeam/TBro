<?php

namespace cli_import;

use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';

/**
 * importer for differential expressions
 */
class Importer_Differential_Expressions extends AbstractImporter {

    /**
     * use for array_walk. converts 'NA', 'Inf' and '-Inf' to their postgres counterparts
     * @param in:string,out:float $value will be changed in-place
     * @param string $key neccessary for array_walk. will not be used
     */
    static function convertDbl(&$value, $key) {
        if ($value == '-Inf')
            $value = '-Infinity';
        else if ($value == 'Inf')
            $value = 'Infinity';
        else if ($value == 'NA')
            $value = 'NaN';
        else if (floatval($value) > 0 && floatval($value) < 1e-307) {
            $value = 0;
        }
    }

    /**
     * @inheritDoc
     */
    static function import($options) {

        $filename = $options['file'];
        $analysis_id = $options['analysis_id'];
        $biomaterial_parentA_name = $options['conditionGroupA'];
        $biomaterial_parentB_name = $options['conditionGroupB'];
        $quantification_id = $options['quantification_id'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;

        $lines_skipped = 0;
        
        $lines_feature_skipped = 0;
        
#IDE type hint
        if (false)
            $db = new PDO ();

        try {
            $db->beginTransaction();

            //get biomaterial A id
            $statement_get_biomaterial_id = $db->prepare('SELECT b.biomaterial_id, bp.value AS type FROM biomaterial b JOIN biomaterialprop bp ON (b.biomaterial_id = bp.biomaterial_id) WHERE b.name=:name AND bp.type_id = ' . CV_BIOMATERIAL_TYPE . ' LIMIT 1');
            $statement_get_biomaterial_id->bindValue('name', $biomaterial_parentA_name);
            $statement_get_biomaterial_id->execute();
            $rowa = $statement_get_biomaterial_id->fetch(\PDO::FETCH_ASSOC);
            if ($statement_get_biomaterial_id->rowCount() == 0) {
                throw new \ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentA_name));
            }
            //is it a condition?
            if ($rowa['type'] != 'condition') {
                throw new \ErrorException(sprintf('This biomaterial is not of type condition! (%s)', $biomaterial_parentA_name));
            }
            $biomaterial_parentA_id = $rowa['biomaterial_id'];

            //get biomaterial B id
            $statement_get_biomaterial_id->bindValue('name', $biomaterial_parentB_name);
            $statement_get_biomaterial_id->execute();
            $rowb = $statement_get_biomaterial_id->fetch(\PDO::FETCH_ASSOC);
            if ($statement_get_biomaterial_id->rowCount() == 0) {
                throw new \ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentB_name));
            }
            //is it a condition?
            if ($rowb['type'] != 'condition') {
                throw new \ErrorException(sprintf('This biomaterial is not of type condition! (%s)', $biomaterial_parentB_name));
            }
            $biomaterial_parentB_id = $rowb['biomaterial_id'];


            //does A have samples?
            $statement_test_biomaterial_children = $db->prepare('SELECT biomaterial_relationship_id FROM biomaterial_relationship WHERE object_id=:parent LIMIT 1');
            $statement_test_biomaterial_children->bindValue('parent', $biomaterial_parentA_id);
            $statement_test_biomaterial_children->execute();
            if (!($statement_test_biomaterial_children->fetchColumn())) {
                throw new \ErrorException(sprintf('Biomaterial has no children (%s)', $biomaterial_parentA_name));
            }

            //does B have samples?
            $statement_test_biomaterial_children->bindValue('parent', $biomaterial_parentB_id);
            $statement_test_biomaterial_children->execute();
            if (!($statement_test_biomaterial_children->fetchColumn())) {
                throw new \ErrorException(sprintf('Biomaterial has no children (%s)', $biomaterial_parentB_name));
            }


            $dummy = null;
            $feature_name = null;
            $param_baseMean = null;
            $param_baseMeanA = null;
            $param_baseMeanB = null;
            $param_foldChange = null;
            $param_log2foldChange = null;
            $param_pval = null;
            $param_pvaladj = null;
            $param_feature_uniquename = null;

            //query for insertion of diffexp
            $query_insert_diffexp = <<<EOF
INSERT INTO diffexpresult(analysis_id, feature_id, biomateriala_id, biomaterialb_id, quantification_id, baseMean, baseMeanA, baseMeanB, foldChange, log2foldChange, pval, pvaladj)
SELECT :analysis_id, feature_id, :biomaterialA_id, :biomaterialB_id, :quantification_id, :baseMean, :baseMeanA, :baseMeanB, :foldChange, :log2foldChange, :pval, :pvaladj
FROM feature WHERE uniquename = :feature_uniquename AND organism_id = :organism
EOF;

            $statement_insert_diffexp = $db->prepare($query_insert_diffexp);
            $statement_insert_diffexp->bindValue('analysis_id', $analysis_id, PDO::PARAM_INT);
            $statement_insert_diffexp->bindValue('biomaterialA_id', $biomaterial_parentA_id, PDO::PARAM_INT);
            $statement_insert_diffexp->bindValue('biomaterialB_id', $biomaterial_parentB_id, PDO::PARAM_INT);
            $statement_insert_diffexp->bindValue('quantification_id', $quantification_id, PDO::PARAM_INT);
            $statement_insert_diffexp->bindParam('baseMean', $param_baseMean, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('baseMeanA', $param_baseMeanA, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('baseMeanB', $param_baseMeanB, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('foldChange', $param_foldChange, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('log2foldChange', $param_log2foldChange, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('pval', $param_pval, PDO::PARAM_STR);
            $statement_insert_diffexp->bindParam('pvaladj', $param_pvaladj, PDO::PARAM_STR);

            $statement_insert_diffexp->bindParam('feature_uniquename', $param_feature_uniquename, PDO::PARAM_STR);
            $statement_insert_diffexp->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);


            $file = fopen($filename, 'r');
            if (feof($file))
                return;
#just skipping header
            fgets($file);
           
            while (($line = fgetcsv($file, 0, ",")) !== false) {
                array_walk($line, function(&$value, $key) {
                            if ($value == '-Inf')
                                $value = '-Infinity';
                            else if ($value == 'Inf')
                                $value = 'Infinity';
                            else if ($value == 'NA')
                                $value = 'NaN';
                            else if (floatval($value) > 0 && floatval($value) < 1e-307) {
                                $value = 0;
                            }
                        });
                list($dummy, $feature_name, $param_baseMean, $param_baseMeanA, $param_baseMeanB, $param_foldChange, $param_log2foldChange, $param_pval, $param_pvaladj) = $line;
                //this importer may encounter lines of NA NA NA NA (...batman!). skip these
                if ($feature_name == 'NaN') {
                    $lines_skipped++;
                    continue;
                }

                //insert diffexp
                $param_feature_uniquename = IMPORT_PREFIX . "_" . $feature_name;
                $statement_insert_diffexp->execute();

                $lines_feature_skipped += ($statement_insert_diffexp->rowCount() == 0) ? 1 : 0;
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
        return array(LINES_IMPORTED => $lines_imported, 'lines_featurenotfound_skipped' => $lines_feature_skipped, 'lines_NA_skipped' => $lines_skipped);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = parent::CLI_getCommand($parser);

        $command->addOption('analysis_id', array(
            'short_name' => '-a',
            'long_name' => '--analysis_id',
            'description' => 'analysis id'
        ));
        $command->addOption('conditionGroupA', array(
            'short_name' => '-A',
            'long_name' => '--conditionA',
            'description' => 'condition A name'
        ));
        $command->addOption('conditionGroupB', array(
            'short_name' => '-B',
            'long_name' => '--conditionB',
            'description' => 'condition B name'
        ));
        $command->addOption('quantification_id', array(
            'short_name' => '-q',
            'long_name' => '--quantification_id',
            'description' => 'quantification id'
        ));
        return $command;
    }

    /**
     * @inheritDoc
     */
    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        parent::CLI_checkRequiredOpts($command);
        $options = $command->options;
        AbstractImporter::dieOnMissingArg($options, 'analysis_id');
        AbstractImporter::dieOnMissingArg($options, 'conditionGroupA');
        AbstractImporter::dieOnMissingArg($options, 'conditionGroupB');
        AbstractImporter::dieOnMissingArg($options, 'quantification_id');
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "Importer for differential expression results";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'differential_expressions';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF

File Format looks like this (\033[0;31mFirst line will be skipped\033[0m):
,id,baseMean,baseMeanA,baseMeanB,foldChange,log2FoldChange,pval,padj
6,comp230079_c0,249.687338527051,206.660251316251,292.714425737851,1.41640409257952,0.502232917392478,2.32555262831702e-08,9.65409100672613e-08
9,comp234683_c0,1904.88401956508,1811.60920428892,1998.15883484125,1.10297454335664,0.141399493923902,0.000466092095479145,0.00137346251047776
   
\033[0;31mThis import requires a successful Sequence ID Import!\033[0m
EOF;
    }

}

?>
