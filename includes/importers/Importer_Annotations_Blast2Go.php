<?php

require_once __DIR__ . '/AbstractImporter.php';

class Importer_Annotations_Blast2Go extends AbstractImporter {

    /**
     * @global PDO $db
     * @param string $filename
     * @throws ErrorException
     */
    function import($options) {

        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        $this->setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $descriptions_added = 0;
        try {
            $db->beginTransaction();
            #shared parameters
            $param_accession = null;
            $description = null;
            $param_dbname = null;
            $param_feature_uniq = null;


            $statement_insert_feature_dbxref = $db->prepare(
                    sprintf('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES ((%s), get_or_insert_dbxref(:dbname, :accession))', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename')
            );
            $statement_insert_feature_dbxref->bindParam('accession', $param_accession, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('dbname', $param_dbname, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);

            $statement_insert_featureprop = $db->prepare(
                    sprintf('INSERT INTO featureprop (feature_id, type_id, rank, value) VALUES ((%s), :type_id, 0, :description)', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename')
            );
            $statement_insert_featureprop->bindValue('type_id', CV_ANNOTATION_BLAST2GO, PDO::PARAM_INT);
            $statement_insert_featureprop->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_featureprop->bindParam('description', $description, PDO::PARAM_STR);

            $file = fopen($filename, 'r');
            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                $feature = $line[0];
                $dbxref = $line[1];
                list($param_dbname, $param_accession) = explode(':', $dbxref);
                $param_feature_uniq = IMPORT_PREFIX . "_" . $feature;
                $statement_insert_feature_dbxref->execute();

                $description = isset($line[2]) ? $line[2] : null;
                if ($description != null) {
                    $statement_insert_featureprop->execute();
                    $descriptions_added++;
                }


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
        return array(LINES_IMPORTED => $lines_imported, 'descriptions_added' => $descriptions_added);
    }

    protected function calledFromShell() {
        return $this->import($this->options);
    }

    public function help() {
        return $this->sharedHelp() . "\n" . <<<EOF

\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }

    protected function getName() {
        return "Blast2Go Output Importer";
    }

}

?>
