<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';

/**
 * importer for textual descriptions
 */
class Importer_Annotations_Description extends AbstractImporter {

    /**
     * @inheritDoc
     * @param String $separator defaults to TAB
     */
    static function import($options, $separator = "\t") {

        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;
        $lines_imported = 0;
        $descriptions_added = 0;
        try {
            $db->beginTransaction();
            #shared parameters
            $description = null;
            $param_feature_uniq = null;

            //statement to add featureprop to feature
            $statement_insert_featureprop = $db->prepare(
                    sprintf('INSERT INTO featureprop (feature_id, type_id, rank, value) VALUES ((%s), :type_id, 0, :description)', 'SELECT feature_id FROM feature WHERE uniquename=:uniquename AND organism_id=:organism ')
            );
            $statement_insert_featureprop->bindValue('type_id', CV_ANNOTATION_DESC, PDO::PARAM_INT);
            $statement_insert_featureprop->bindParam('uniquename', $param_feature_uniq, PDO::PARAM_STR);
            $statement_insert_featureprop->bindParam('description', $description, PDO::PARAM_STR);
            $statement_insert_featureprop->bindValue('organism', DB_ORGANISM_ID, PDO::PARAM_INT);

            $file = fopen($filename, 'r');
            while (($line = fgetcsv($file, 0, $separator)) !== false) {
                if (count($line) == 0)
                    continue;
                $feature = $line[0];
                $description = $line[1];
                $param_feature_uniq = IMPORT_PREFIX . "_" . $feature;

                $statement_insert_featureprop->execute();
                $descriptions_added+=$statement_insert_featureprop->rowCount();


                self::updateProgress(++$lines_imported);
            }
            self::preCommitMsg();
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new \ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (\Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'descriptions_added' => $descriptions_added);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
Tab-Separated file with column 1: feature_id and column 2: feature description
   
\033[0;31mThis import requires a successful Sequence ID Import!\033[0m
EOF;
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'import feature descriptions';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'annotation_description';
    }

}

?>
