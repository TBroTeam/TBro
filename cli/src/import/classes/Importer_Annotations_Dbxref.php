<?php

require_once ROOT . 'classes/AbstractImporter.php';

abstract class Importer_Annotations_Dbxref extends AbstractImporter {

    /**
     * @global PDO $db
     * @param string $filename
     * @throws ErrorException
     */
    static function _import($options, $feature_pos=0, $dbxref_pos=1, $separator="\t") {

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

            $file = fopen($filename, 'r');
            while (($line = fgetcsv($file, 0, $separator)) !== false) {
                if (count($line) == 0)
                    continue;
                $feature = $line[$feature_pos];
                $dbxref = $line[$dbxref_pos];
                list($param_dbname, $param_accession) = explode(':', $dbxref);
                $param_feature_uniq = IMPORT_PREFIX . "_" . $feature;
                $statement_insert_feature_dbxref->execute();

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

    public static function CLI_longHelp() {
        return <<<EOF
\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }

}

?>
