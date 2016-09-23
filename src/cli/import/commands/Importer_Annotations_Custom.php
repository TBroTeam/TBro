<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/AbstractImporter.php';

/**
 * importer for custom textual annotations
 */
class Importer_Annotations_Custom extends AbstractImporter {

    /**
     * @inheritDoc
     * @param String $separator defaults to TAB
     */
    static function import($options, $separator = "\t") {
        $cvterm_id = self::get_annotation_type_cvterm_id($options['annotation_type']);
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
            $statement_insert_featureprop = $db->prepare(<<<EOF
WITH new_values (feature_id, type_id, rank, description) as (
	SELECT feature_id, :type_id ::integer, 0, :description ::varchar
	FROM feature 
	WHERE uniquename=:uniquename AND organism_id=:organism
),
upsert as
(
    UPDATE featureprop p 
        SET value = nv.description
    FROM new_values nv
    WHERE p.feature_id = nv.feature_id
	AND p.type_id = nv.type_id
	AND p.rank = nv.rank
    RETURNING p.*
)
INSERT INTO featureprop (feature_id, type_id, rank, value)
SELECT feature_id, type_id, rank, description FROM new_values
WHERE NOT EXISTS (SELECT 1 FROM upsert up WHERE up.feature_id = new_values.feature_id)
EOF
);
            $statement_insert_featureprop->bindValue('type_id', $cvterm_id, PDO::PARAM_INT);
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
        return array(LINES_IMPORTED => $lines_imported, 'custom_annotations_added' => $descriptions_added);
    }

    /**
     * @param $term string custom annotation type cvterm
     * @return int cvterm_id of the custom annotation type (inserted if not exists)
     */
    private static function get_annotation_type_cvterm_id($term){
        global $db;
        $stm = $db->prepare("SELECT cvterm_id FROM cvterm WHERE name=? AND cv_id=?");
        $stm->execute(array($term, CUSTOM_ANNOTATION_TYPE_CV_ID));
        if ($stm->rowCount() == 0) {
            $stm_insert_dbxref = $db->prepare('INSERT INTO dbxref (db_id, accession) VALUES (1, concat(\'transcript_db:cat:\', ?::varchar)) RETURNING dbxref_id');
            $stm_insert_dbxref->execute(array($term));
            $dbxref_id = $stm_insert_dbxref->fetchColumn();
            $stm = $db->prepare("INSERT INTO cvterm (name, is_obsolete, is_relationshiptype, cv_id, dbxref_id) VALUES (?, 0, 0, ?, ?) RETURNING cvterm_id");
            $stm->execute(array($term, CUSTOM_ANNOTATION_TYPE_CV_ID, $dbxref_id));
        }
        $cvterm_id = $stm->fetchColumn();
        unset($stm);
        return $cvterm_id;
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
Add custom annotation of a given type (--annotation_type) to isoforms/unigenes
Tab-Separated file with column 1: feature_id and column 2: feature description
   
\033[0;31mThis import requires a successful Sequence ID Import!\033[0m
EOF;
    }

    /**
     * @inheritDoc
     */
    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = parent::CLI_getCommand($parser);
        $command->addOption('annotation_type', array(
            'short_name' => '-a',
            'long_name' => '--annotation_type',
            'description' => 'name of the custom annotation type'
        ));
    }

    /**
     * @inheritDoc
     */
    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        parent::CLI_checkRequiredOpts($command);
        $options = $command->options;
        AbstractImporter::dieOnMissingArg($options, 'annotation_type');
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
        return 'annotation_custom';
    }

}

?>
