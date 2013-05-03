<?php

require_once ROOT . 'classes/AbstractImporter.php';

class Importer_Annotations_Blast2Go extends AbstractImporter {

    /**
     * @global PDO $db
     * @param string $filename
     * @throws ErrorException
     */
    static function import($options) {

        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

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
                    sprintf('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES ((%s), get_or_insert_dbxref(:dbname, :accession))', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename AND organism_id=:organism')
            );
            $statement_insert_feature_dbxref->bindParam('accession', $param_accession, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('dbname', $param_dbname, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);

            $statement_insert_featureprop = $db->prepare(
                    sprintf('INSERT INTO featureprop (feature_id, type_id, rank, value) VALUES ((%s), :type_id, 0, :description)', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename AND organism_id=:organism ')
            );
            $statement_insert_featureprop->bindValue('type_id', CV_ANNOTATION_BLAST2GO, PDO::PARAM_INT);
            $statement_insert_featureprop->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_featureprop->bindParam('description', $description, PDO::PARAM_STR);
            $statement_insert_featureprop->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);

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
        return array(LINES_IMPORTED => $lines_imported, 'descriptions_added' => $descriptions_added);
    }

    public static function CLI_commandDescription() {
        return "Blast2Go Output Importer";
    }

    public static function CLI_commandName() {
        return 'annotation_blast2go';
    }

    public static function CLI_longHelp() {
        return <<<EOF

\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }

}

?>
