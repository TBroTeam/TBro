<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';

class Importer_Expressions {
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
         else if ($value>0 && $value<1e307){
             $value=0;
         }
    }

    static function import($filename, $analysis_id, $biomaterial_parentA_name, $biomaterial_parentB_name) {
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
                    .' :foldChange, :log2foldChange, :pval, :pvaladj);');
            $statement_insert_expressiondata->bindValue('analysis_id', $analysis_id, PDO::PARAM_INT);
            $statement_insert_expressiondata->bindParam('baseMean', &$param_baseMean, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('baseMeanA', &$param_baseMeanA, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('baseMeanB', &$param_baseMeanB, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('foldChange', &$param_foldChange, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('log2foldChange', &$param_log2foldChange, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('pval', &$param_pval, PDO::PARAM_STR);
            $statement_insert_expressiondata->bindParam('pvaladj', &$param_pvaladj, PDO::PARAM_STR);


            $relationship_call = 'SELECT * FROM set_expressionresult_quantificationresult_relationships('
                    . 'currval(\'expressionresult_expressionresult_id_seq\'),'
                    . ':parent_biomaterial_id,'
                    . ':cvterm_isa,'
                    . ':feature_uniquename,'
                    . ':samplegroup)';

            $statement_set_relationshipA = $db->prepare($relationship_call);
            $statement_set_relationshipA->bindValue('cvterm_isa', CV_BIOMATERIAL_ISA);
            $statement_set_relationshipA->bindValue('parent_biomaterial_id', $biomaterial_parentA_id, PDO::PARAM_INT);
            $statement_set_relationshipA->bindValue('samplegroup', 'A', PDO::PARAM_STR);
            $statement_set_relationshipA->bindParam('feature_uniquename', &$param_feature_uniquename, PDO::PARAM_STR);

            $statement_set_relationshipB = $db->prepare($relationship_call);
            $statement_set_relationshipB->bindValue('cvterm_isa', CV_BIOMATERIAL_ISA);
            $statement_set_relationshipB->bindValue('parent_biomaterial_id', $biomaterial_parentB_id, PDO::PARAM_INT);
            $statement_set_relationshipB->bindValue('samplegroup', 'B', PDO::PARAM_STR);
            $statement_set_relationshipB->bindParam('feature_uniquename', &$param_feature_uniquename, PDO::PARAM_STR);


            $file = fopen($filename, 'r');
            if (feof($file))
                return;
#just skipping header
            fgets($file);

            while (($line = fgetcsv($file, 0, ",")) !== false) {
                array_walk($line, array('Importer_Expressions', 'convertDbl'));
                list($dummy, $feature_name, $param_baseMean, $param_baseMeanA, $param_baseMeanB, $param_foldChange, $param_log2foldChange, $param_pval, $param_pvaladj) = $line;
                if ($feature_name == 'NA') {
                    $lines_skipped++;
                    continue;
                }
                


                $statement_insert_expressiondata->execute();

                $param_feature_uniquename = ASSEMBLY_PREFIX . $feature_name;

                
                
                $statement_set_relationshipA->execute();
                $quantifications_linked +=$statement_set_relationshipA->fetchColumn();
                $statement_set_relationshipB->execute();
                $quantifications_linked+= $statement_set_relationshipB->fetchColumn();

                $lines_imported++;
                if ($lines_imported % 1000 == 0)
                    echo '*';
                else if ($lines_imported % 100 == 0)
                    echo '.';
            }

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

}

?>
