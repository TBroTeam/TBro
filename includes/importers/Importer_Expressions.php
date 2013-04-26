<?php

require_once __DIR__ . '/AbstractImporter.php';

class Importer_Expressions extends AbstractImporter {
    /*
      /storage/genomics/projects/dmuscipula/transcriptome/diffexpr/testing/quant/res.quant.pooled.sig.csv


      /**
     * use for array_walk. converts 'NA', 'Inf' and '-Inf' to their postgres coutnerparts
     * @param string $value will be changed in-place
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

    static function import($options) {

        $filename = $options['file'];
        $analysis_id = $options['analysis_id'];
        $biomaterial_parentA_name = $options['biomaterialA_name'];
        $biomaterial_parentB_name = $options['biomaterialB_name'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $quantifications_linked = 0;
        $lines_skipped = 0;
#IDE type hint
        if (false)
            $db = new PDO ();

        try {
            $db->beginTransaction();

            $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=:name LIMIT 1');
            $statement_get_biomaterial_id->bindValue('name', $biomaterial_parentA_name);
            $statement_get_biomaterial_id->execute();
            if (!($biomaterial_parentA_id = $statement_get_biomaterial_id->fetchColumn())) {
                throw new ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentA_name));
            }

            $statement_get_biomaterial_id->bindValue('name', $biomaterial_parentB_name);
            $statement_get_biomaterial_id->execute();
            if (!($biomaterial_parentB_id = $statement_get_biomaterial_id->fetchColumn())) {
                throw new ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentB_name));
            }

            $statement_test_biomaterial_children = $db->prepare('SELECT biomaterial_relationship_id FROM biomaterial_relationship WHERE object_id=:parent LIMIT 1');
            $statement_test_biomaterial_children->bindValue('parent', $biomaterial_parentA_id);
            $statement_test_biomaterial_children->execute();
            if (!($statement_test_biomaterial_children->fetchColumn())) {
                throw new ErrorException(sprintf('Biomaterial has no children (%s)', $biomaterial_parentA_name));
            }

            $statement_test_biomaterial_children->bindValue('parent', $biomaterial_parentB_id);
            $statement_test_biomaterial_children->execute();
            if (!($statement_test_biomaterial_children->fetchColumn())) {
                throw new ErrorException(sprintf('Biomaterial has no children (%s)', $biomaterial_parentB_name));
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

            $statement_insert_expressiondata = $db->prepare('INSERT INTO expressionresult(analysis_id, "baseMean", "baseMeanA", "baseMeanB", "foldChange", "log2foldChange", pval, pvaladj)'
                    . 'VALUES (:analysis_id, :baseMean, :baseMeanA, :baseMeanB,'
                    . ' :foldChange, :log2foldChange, :pval, :pvaladj);');
            $statement_insert_expressiondata->bindValue('analysis_id', $analysis_id, PDO::PARAM_INT);
            $statement_insert_expressiondata->bindParam('baseMean', $param_baseMean, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('baseMeanA', $param_baseMeanA, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('baseMeanB', $param_baseMeanB, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('foldChange', $param_foldChange, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('log2foldChange', $param_log2foldChange, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('pval', $param_pval, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('pvaladj', $param_pvaladj, PDO::PARAM_STR);


            $relationship_call = 'SELECT * FROM set_expressionresult_quantificationresult_relationships('
                    . 'currval(\'expressionresult_expressionresult_id_seq\'),'
                    . ':parent_biomaterial_id,'
                    . ':feature_uniquename,'
                    . ':samplegroup)';

            $statement_set_relationshipA = $db->prepare($relationship_call);
            $statement_set_relationshipA->bindValue('parent_biomaterial_id', $biomaterial_parentA_id, PDO::PARAM_INT);
            $statement_set_relationshipA->bindValue('samplegroup', 'A', PDO::PARAM_STR);
            $statement_set_relationshipA->bindParam('feature_uniquename', $param_feature_uniquename, PDO::PARAM_STR);

            $statement_set_relationshipB = $db->prepare($relationship_call);
            $statement_set_relationshipB->bindValue('parent_biomaterial_id', $biomaterial_parentB_id, PDO::PARAM_INT);
            $statement_set_relationshipB->bindValue('samplegroup', 'B', PDO::PARAM_STR);
            $statement_set_relationshipB->bindParam('feature_uniquename', $param_feature_uniquename, PDO::PARAM_STR);


            $file = fopen($filename, 'r');
            if (feof($file))
                return;
#just skipping header
            fgets($file);

            while (($line = fgetcsv($file, 0, ",")) !== false) {
                array_walk($line, array('Importer_Expressions', 'convertDbl'));
                list($dummy, $feature_name, $param_baseMean, $param_baseMeanA, $param_baseMeanB, $param_foldChange, $param_log2foldChange, $param_pval, $param_pvaladj) = $line;
                if ($feature_name == 'NaN') {
                    $lines_skipped++;
                    continue;
                }

                $statement_insert_expressiondata->execute();

                $param_feature_uniquename = IMPORT_PREFIX . "_" . $feature_name;



                $statement_set_relationshipA->execute();
                $quantifications_linked +=$statement_set_relationshipA->fetchColumn();
                $statement_set_relationshipB->execute();
                $quantifications_linked+= $statement_set_relationshipB->fetchColumn();

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
        return array(LINES_IMPORTED => $lines_imported, 'quantifications_linked' => $quantifications_linked, 'lines_NA_skipped' => $lines_skipped);
    }

    public static function CLI_getCommand($parser) {
        $command = parent::CLI_getCommand($parser);

        $command->addOption('analysis_id',
                array(
            'short_name' => '-a',
            'long_name' => '--analysis_id',
            'description' => 'analysis id'
        ));
        $command->addOption('biomaterialA_name',
                array(
            'short_name' => '-A',
            'long_name' => '--biomaterialA_name',
            'description' => 'parent biomaterial A name'
        ));
        $command->addOption('biomaterialB_name',
                array(
            'short_name' => '-B',
            'long_name' => '--biomaterialB_name',
            'description' => 'parent biomaterial B name'
        ));
    }

    public static function CLI_checkRequiredOpts($options) {
        parent::CLI_checkRequiredOpts($options);
        AbstractImporter::dieOnMissingArg($options, 'analysis_id');
        AbstractImporter::dieOnMissingArg($options, 'biomaterialA_name');
        AbstractImporter::dieOnMissingArg($options, 'biomaterialB_name');
    }

    public static function CLI_commandDescription() {
        return "Pooled Expression File Importer";
    }

    public static function CLI_commandName() {
        return 'pooled-expressions';
    }

    public static function CLI_longHelp() {
        return <<<EOF

File Format looks like this (\033[0;31mFirst line will be skipped\033[0m):
,id,baseMean,baseMeanA,baseMeanB,foldChange,log2FoldChange,pval,padj
6,comp230079_c0,249.687338527051,206.660251316251,292.714425737851,1.41640409257952,0.502232917392478,2.32555262831702e-08,9.65409100672613e-08
9,comp234683_c0,1904.88401956508,1811.60920428892,1998.15883484125,1.10297454335664,0.141399493923902,0.000466092095479145,0.00137346251047776
   
\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a set of successful Count File Import!\033[0m
EOF;
    }

}

?>
