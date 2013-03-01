<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';

class Importer_Annotations_Blast2Go {

    /**
     * @global PDO $db
     * @param string $filename
     * @throws ErrorException
     */
    static function import($filename) {

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
            $statement_insert_feature_dbxref->bindParam('accession', &$param_accession, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('dbname', &$param_dbname, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('uniquename', &$param_feature_uniq, PDO::PARAM_STR);

            $statement_insert_featureprop = $db->prepare(
                    sprintf('INSERT INTO featureprop (feature_id, type_id, rank, value) VALUES ((%s), :type_id, 0, :description)', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename')
            );
            $statement_insert_featureprop->bindValue('type_id', CV_ANNOTATION_BLAST2GO, PDO::PARAM_INT);
            $statement_insert_featureprop->bindParam('uniquename', &$param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_featureprop->bindParam('description', &$description, PDO::PARAM_STR);

            $file = fopen($filename, 'r');
            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                if (count($line) == 0)
                    continue;
                $feature = $line[0];
                $dbxref = $line[1];
                list($param_dbname, $param_accession) = explode(':', $dbxref);
                $param_feature_uniq = ASSEMBLY_PREFIX . $feature;
                $statement_insert_feature_dbxref->execute();

                $description = isset($line[2]) ? $line[2] : null;
                if ($description != null) {
                    $statement_insert_featureprop->execute();
                    $descriptions_added++;
                }


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
        return array(LINES_IMPORTED => $lines_imported, 'descriptions_added' => $descriptions_added);
    }

}

?>
