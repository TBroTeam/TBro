<?php

require_once __DIR__ . '/helpers.php';

/**
 * imports quant.*.results file. supported types: genes|isoforms
 * @global PDO $db
 * @param string $filename filename
 * @param int $quantification_id DB primary key
 * @return null
 * @throws ErrorException
 */
function import_quantification_results($filename, $quantification_id, $biomaterial_name) {
    global $db;
    $file = fopen($filename, 'r');
    if (feof($file))
        return;
    $header = trim(fgets($file));


    try {
        $db->beginTransaction();
        
        $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=:biomaterial_name LIMIT 1');
        $statement_get_biomaterial_id->bindValue('biomaterial_name', $biomaterial_name, PDO::PARAM_STR);
        $statement_get_biomaterial_id->execute();
        $biomaterial_id = $statement_get_biomaterial_id->fetchColumn();
        
#shared parameters
        $param_uniquename = null;
        $param_length = null;
        $param_effective_length = null;
        $param_expected_count = null;
        $param_TPM = null;
        $param_FPKM = null;
        $param_IsoPct = null;
        $trash = null;

#quant.*_*.genes.results
        if ($header == "gene_id\ttranscript_id(s)\tlength\teffective_length\texpected_count\tTPM\tFPKM") {
            $statement_insert_gene_quant = $db->prepare(
                    sprintf('INSERT INTO quantificationresult (feature_id, quantification_id, biomaterial_id, length, effective_length, expected_count, "TPM", "FPKM") '
                            . 'VALUES ((%s), :quantification_id, :biomaterial_id, :length, :effective_length, :expected_count, :TPM, :FPKM)'
                            , 'SELECT feature_id FROM feature WHERE uniquename=:gene_uniquename LIMIT 1'));
            $statement_insert_gene_quant->bindParam('gene_uniquename', &$param_uniquename, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindParam('length', &$param_length, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindParam('effective_length', &$param_effective_length, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindParam('expected_count', &$param_expected_count, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindParam('TPM', &$param_TPM, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindParam('FPKM', &$param_FPKM, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindValue('quantification_id', $quantification_id, PDO::PARAM_STR);
            $statement_insert_gene_quant->bindValue('biomaterial_id', $biomaterial_id, PDO::PARAM_STR);

            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                list($gene, $trash, $param_length, $param_effective_length, $param_expected_count, $param_TPM, $param_FPKM) = $line;
                $param_uniquename = ASSEMBLY_PREFIX . $gene;
                $statement_insert_gene_quant->execute();
            }
        }
#quant.*_*.isoforms.results
        else if ($header == "transcript_id\tgene_id\tlength\teffective_length\texpected_count\tTPM\tFPKM\tIsoPct") {
            $statement_insert_isoform_quant = $db->prepare(
                    sprintf('INSERT INTO quantificationresult (feature_id, quantification_id, biomaterial_id, length, effective_length, expected_count, "TPM", "FPKM", "IsoPct") '
                            . 'VALUES ((%s), :quantification_id, :biomaterial_id, :length, :effective_length, :expected_count, :TPM, :FPKM, :IsoPct)'
                            , 'SELECT feature_id FROM feature WHERE uniquename=:gene_uniquename LIMIT 1'));
            $statement_insert_isoform_quant->bindParam('gene_uniquename', &$param_uniquename, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('length', &$param_length, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('effective_length', &$param_effective_length, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('expected_count', &$param_expected_count, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('TPM', &$param_TPM, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('FPKM', &$param_FPKM, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindParam('IsoPct', &$param_IsoPct, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindValue('quantification_id', $quantification_id, PDO::PARAM_STR);
            $statement_insert_isoform_quant->bindValue('biomaterial_id', $biomaterial_id, PDO::PARAM_STR);

            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                list($gene, $trash, $param_length, $param_effective_length, $param_expected_count, $param_TPM, $param_FPKM, $param_IsoPct) = $line;
                $param_uniquename = ASSEMBLY_PREFIX . $gene;
                $statement_insert_isoform_quant->execute();
            }
        }
        if (!$db->commit()) {
            $err = $db->errorInfo();
            throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
        }
    } catch (Exception $error) {
        $db->rollback();
        throw $error;
    }
}

?>
