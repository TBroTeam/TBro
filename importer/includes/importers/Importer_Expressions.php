<?php

/*
 * To change this template, choose Tools | Templates
 * and open the template in the editor.
 */

/**
 * Description of Importer_Expression
 *
 * @author s202139
 */
class Importer_Expressions {
    /*
      /storage/genomics/projects/dmuscipula/transcriptome/diffexpr/testing/quant/res.quant.pooled.sig.csv


    /**
     * use for array_walk. converts 'NA', 'Inf' and '-Inf' to their postgres coutnerparts
     * @param string $value will be changed in-place
     * @param string $key neccessary for array_walk. will not be used
     */
    function convertDbl(&$value, $key) {
        if ($value == '-Inf')
            $value = '-Infinity';
        else if ($value == 'Inf')
            $value = 'Infinity';
        else if ($value == 'NA')
            $value = 'NaN';
    }

    function import($filename, $analysis_id, $biomaterial_parentA_name, $biomaterial_parentB_name) {

        global $db;
#IDE type hint
        if (false)
            $db = new PDO ();

        $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=? LIMIT 1');

        $statement_get_biomaterial_id->execute(array($biomaterial_parentA_name));
        if (!($biomaterial_parentA_id = $statement_get_biomaterial_id->fetchColumn())) {
            throw new ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentA_name));
        }

        $statement_get_biomaterial_id->execute(array($biomaterial_parentB_name));
        if (!($biomaterial_parentB_id = $statement_get_biomaterial_id->fetchColumn())) {
            throw new ErrorException(sprintf('Biomaterial with this name not defined (%s)', $biomaterial_parentB_name));
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
                , 'VALUES (:analysis_id, :baseMean, :baseMeanA, :baseMeanB, :foldChange, :log2foldChange, :pval, :pvaladj);');
        $statement_insert_expressiondata->bindValue('analysis_id', $analysis_id, PDO::PARAM_INT);
        $statement_insert_expressiondata->bindParam('baseMean', $param_baseMean, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('baseMeanA', $param_baseMeanA, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('baseMeanB', $param_baseMeanB, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('foldChange', $param_foldChange, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('log2foldChange', $param_log2foldChange, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('pval', $param_pval, PDO::PARAM_STR);
        $statement_insert_expressiondata->bindParam('pvaladj', $param_pvaladj, PDO::PARAM_STR);


        $relationship_call = 'set_expressionresult_quantificationresult_relationships('
                . 'currval(\'expressionresult_expressionresult_id_seq\'),'
                . ':parent_biomaterial_id,'
                . ':cvterm_isa'
                . ':feature_uniquename'
                . ':samplegroup)';
        $statement_set_relationshipA = $db->prepare($relationship_call);
        $statement_set_relationshipA->bindValue('cvterm_isa', CV_BIOMATERIAL_ISA);
        $statement_set_relationshipA->bindValue('parent_biomaterial_id', $biomaterial_parentA_id, PDO::PARAM_ID);
        $statement_set_relationshipA->bindValue('samplegroup', 'expressionresult_samplegroup.A', PDO::PARAM_STR);
        $statement_set_relationshipA->bindParam('feature_uniquename', $param_feature_uniquename, PDO::PARAM_STR);

        $statement_set_relationshipB = $db->prepare($relationship_call);
        $statement_set_relationshipB->bindValue('cvterm_isa', CV_BIOMATERIAL_ISA);
        $statement_set_relationshipB->bindValue('parent_biomaterial_id', $biomaterial_parentB_id, PDO::PARAM_ID);
        $statement_set_relationshipB->bindValue('samplegroup', 'expressionresult_samplegroup.B', PDO::PARAM_STR);
        $statement_set_relationshipB->bindParam('feature_uniquename', $param_feature_uniquename, PDO::PARAM_STR);


        $db->beginTransaction();

        $file = fopen($filename, 'r');
        if (feof($file))
            return;
#just skipping header
        fgets($file);

        $quantifications_linked = 0;
        $lines_imported = 0;

        while (($line = fgetcsv($file, 0, ",")) !== false) {
            array_walk($line, array($this, 'convertDbl'));
            list($dummy, $feature_name, $param_baseMean, $param_baseMeanA, $param_baseMeanB, $param_foldChange, $param_log2foldChange, $param_pval, $param_pvaladj) = $line;
            $statement_insert_expressiondata->execute();
            $lines_imported++;

            $param_feature_uniquename = ASSEMBLY_PREFIX . $feature_name;
            $statement_set_relationshipA->execute();
            $quantifications_linked+=$statement_set_relationshipA->fetch();
            $statement_set_relationshipB->execute();
            $quantifications_linked+=$statement_set_relationshipB->fetch();
        }

        $db->commit();
        return array('lines_imported' => $lines_imported, 'quantifications_linked' => $quantifications_linked);
    }

}

?>
