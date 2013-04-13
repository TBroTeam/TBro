<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';
require_once INC . '/libs/php-progress-bar.php';

class Importer_Quantifications {

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
    static function import($filename, $quantification_id, $biomaterial_name, $type_name, $value_column) {

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);

        global $db;

        $lines_imported = 0;

        try {
            $statement_get_type_id = $db->prepare('SELECT cvterm_id FROM cvterm WHERE name=:type_name LIMIT 1');
            $statement_get_type_id->bindValue('type_name', $type_name, PDO::PARAM_STR);
            $statement_get_type_id->execute();
            $type_id = $statement_get_type_id->fetchColumn();
            if (!$type_id) {
                throw new ErrorException('Type with this name not defined in table cvterm');
            }

            $statement_get_biomaterial_id = $db->prepare('SELECT biomaterial_id FROM biomaterial WHERE name=:biomaterial_name LIMIT 1');
            $statement_get_biomaterial_id->bindValue('biomaterial_name', $biomaterial_name, PDO::PARAM_STR);
            $statement_get_biomaterial_id->execute();
            $biomaterial_id = $statement_get_biomaterial_id->fetchColumn();
            if (!$biomaterial_id) {
                throw new ErrorException('Biomaterial with this name not defined');
            }

            $db->beginTransaction();

            #shared parameters
            $param_uniquename = null;
            $param_value = null;


            $statement_insert_quant = $db->prepare(
                    sprintf('INSERT INTO quantificationresult (feature_id, quantification_id, biomaterial_id, type_id, value) '
                            . 'VALUES ((%s), :quantification_id, :biomaterial_id, :type_id, :value)'
                            , 'SELECT feature_id FROM feature WHERE uniquename=:gene_uniquename LIMIT 1'));
            $statement_insert_quant->bindParam('gene_uniquename', $param_uniquename, PDO::PARAM_STR);
            $statement_insert_quant->bindParam('value', $param_value, PDO::PARAM_STR);
            $statement_insert_quant->bindValue('quantification_id', $quantification_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('biomaterial_id', $biomaterial_id, PDO::PARAM_INT);
            $statement_insert_quant->bindValue('type_id', $type_id, PDO::PARAM_INT);


            $file = fopen($filename, 'r');
            if (feof($file))
                return;
            #just skipping header
            fgets($file);

            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                $param_uniquename = IMPORT_PREFIX . $line[0];
                $param_value = $line[$value_column - 1];
                $statement_insert_quant->execute();

                $lines_imported++;
                if ($lines_imported % 200 == 0)
                    php_progress_bar_show_status($lines_imported, $lines_total, 60);
            }


            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported);
    }

}

?>
