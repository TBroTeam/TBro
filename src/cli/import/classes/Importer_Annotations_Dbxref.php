<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';

/**
 * abstract database crossreference importer
 */
abstract class Importer_Annotations_Dbxref extends AbstractImporter {

    /**
     * takes a CSV as $options['file']
     * @global \PDO $db
     * @param Array $options user-specified command-line options
     * @param int $feature_pos column with feature name
     * @param int $dbxref_pos column with crossref
     * @param String $separator column separator, defaults to TAB
     * @return array to be displayed as table
     * @throws Exception
     * @throws ErrorException
     */
    static function _import($options, $feature_pos = 0, $dbxref_pos = 1, $separator = "\t") {

        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $dbxref_inserted = 0;
        try {
            $db->beginTransaction();
            #shared parameters
            $param_accession = null;
            $param_dbname = null;
            $param_feature_uniq = null;

            //statement inserts feature_dbxref connection. creates dbxref if non-existant.
            $statement_insert_feature_dbxref = $db->prepare(
                    sprintf('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES ((%s), get_or_insert_dbxref(:dbname, :accession))', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename AND organism_id=:organism')
            );
            $statement_insert_feature_dbxref->bindParam('accession', $param_accession, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('dbname', $param_dbname, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);

            $file = fopen($filename, 'r');
            while (($line = fgetcsv($file, 0, $separator)) !== false) {
                //skip empty lines
                if (count($line) == 0)
                    continue;
                $feature = $line[$feature_pos];
                $dbxref = $line[$dbxref_pos];
                list($param_dbname, $param_accession) = explode(':', $dbxref);
                $param_feature_uniq = IMPORT_PREFIX . "_" . $feature;
                //execute insert statement
                $statement_insert_feature_dbxref->execute();
                $dbxref_inserted += $statement_insert_feature_dbxref->rowCount();
                //update progress bar
                self::updateProgress(++$lines_imported);
            }
            self::preCommitMsg();
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'references_linked' => $dbxref_inserted);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }

}

?>
