<?php

require_once __DIR__ . '/AbstractImporter.php';

class Importer_Quantifications extends AbstractImporter {

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
    function import($options) {

        $filename = $options['file'];
        $quantification_id = $options['quantification-id'];
        $biomaterial_name = $options['biomaterial-name'];
        $type_name = $options['type-name'];
        $value_column = $options['column'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        $this->setLineCount($lines_total);

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
                $param_uniquename = IMPORT_PREFIX . "_" . $line[0];
                $param_value = $line[$value_column - 1];
                $statement_insert_quant->execute();

                $this->updateProgress(++$lines_imported);
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

    protected function calledFromShell() {
        $this->require_parameter($this->options, array('quantification-id', 'biomaterial-name', 'type-name', 'column'));
        return $this->import($this->options);
    }

    public function help() {
        return $this->sharedHelp() . "\n" . <<<EOF
File Format has to look like RSEM output.
\033[0;31mFirst line will be skipped.\033[0m
e.g. like:
gene_id	transcript_id(s)	length	effective_length	expected_count	TPM	FPKM
comp234852_c1	comp234852_c1_seq1,comp234852_c1_seq2,comp234852_c1_seq3,comp234852_c1_seq4,comp234852_c1_seq5,comp234852_c1_seq6	2081.75	1914.35	93095.99	1243.34	880.55
or 
transcript_id	gene_id	length	effective_length	expected_count	TPM	FPKM	IsoPct
comp234852_c1_seq1	comp234852_c1	2067	1899.59	82704.68	1113.13	788.33	89.53
   
\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }

    protected function getName() {
        return "Count File Importer";
    }

    protected function register_getopt($getopt) {
        parent::register_getopt($getopt);
        $getopt->add('q|quantification-id:=i', 'quantification id');
        $getopt->add('b|biomaterial-name:=s', 'biomaterial name');
        $getopt->add('t|type-name:=s', 'type name. this has to be a cvterm.');
        $getopt->add('c|column:=s', 'column number that will be read for values (e.g. in the example below: 5 for expected_count)');
    }

}

?>
