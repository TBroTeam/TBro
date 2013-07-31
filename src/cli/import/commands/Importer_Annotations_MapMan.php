<?php

namespace cli_import;
use \PDO;

require_once ROOT . 'classes/Importer_Annotations_Dbxref.php';

class Importer_Annotations_MapMan extends Importer_Annotations_Dbxref {

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return "annotation_mapman";
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return "import MapMan annotations";
    }

    /**
     * add entry to DB table if non-existant and return DB id in any case
     * @global \PDO $db
     * @param String $dbname name of DB to add
     * @return DB id
     */
    public static function get_or_create_DB($dbname) {
        global $db;
        $stm = $db->prepare(<<<EOF
WITH new_row AS (
	INSERT INTO db (name) SELECT ? WHERE NOT EXISTS (SELECT 1 FROM db WHERE name = ?) RETURNING db_id
)
SELECT db_id FROM new_row
UNION
SELECT db_id FROM db WHERE name = ?;
EOF
        );
        $stm->execute(array($dbname, $dbname, $dbname));
        return $stm->fetchColumn();
    }

    /**
     * imported Mapman BINs will be linked as dbxref to a DB with this name
     * @var String
     */
    static $db_name = 'MapMan';

    /**
     * @inheritDoc
     */
    public static function import($options) {
        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);
        $lines_imported = 0;
        $lines_skipped = 0;

        global $db;
        try {
            $db->beginTransaction();
            $import_prefix_id = Importer_Sequence_Ids::get_import_dbxref();

            self::get_or_create_DB(self::$db_name);


            /**
             * get parent feature id
             * parameters: :object_name, :organism_id, :dbxref_id
             */
            $stm_get_parentfeature = $db->prepare('SELECT feature_id FROM feature WHERE name=:object_name AND organism_id=:organism_id AND dbxref_id=:dbxref_id');

            /**
             * insert new feature for hit
             * parameters: :name, :uniquename, :type_id, :organism_id, :dbxref_id
             * returns: feature_id
             */
            $stm_insert_feature = $db->prepare("INSERT INTO feature (name, uniquename, type_id, organism_id, dbxref_id) VALUES (:name, :uniquename, :type_id, :organism_id, :dbxref_id) RETURNING feature_id");

            /**
             * link new feature with parent feature
             * parameters:  :subject_id, :type_id, :object_id
             */
            $stm_link_feature = $db->prepare("INSERT INTO feature_relationship (subject_id, type_id, object_id) VALUES (:subject_id, :type_id, :object_id)");

            /**
             * add textual annoation
             * parameters:  feature_id, type_id, value
             */
            $stm_insert_featureprop = $db->prepare("INSERT INTO featureprop (feature_id, type_id, value) VALUES (?,?,?)");

            /**
             * link new feature to dbxref
             * parameters: feature_id, cvterm_id
             */
            $stm_link_dbxref = $db->prepare('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES (?,?)');

            /**
             * get dbxref id. if non-existant, create
             * parameters: :dbname, :accession
             * returns: dbxref_id
             */
            $stm_try_insert_dbxref_id = $db->prepare("SELECT * FROM get_or_insert_dbxref(:dbname, :accession)");

            /**
             * get cvterm_id. if non-existant, create
             * parameters: name, definition, dbxref_id dbxref_id, dbxref_id
             * returns: cvterm_id
             */
            $stm_try_insert_cvterm = $db->prepare(<<<EOF
WITH new_row AS (
	INSERT INTO cvterm (name, definition, cv_id, dbxref_id) SELECT ?,?,(SELECT cv_id FROM cv WHERE name='local'),? WHERE NOT EXISTS (SELECT 1 FROM cvterm WHERE dbxref_id = ?) RETURNING cvterm_id
)
SELECT cvterm_id FROM new_row
UNION
SELECT cvterm_id FROM cvterm WHERE dbxref_id = ?;   
EOF
            );
            /**
             * insert cvtermprop if non-existant with these values
             * parameters: cvterm_id, type_id, value, cvterm_id, type_id, cvterm_id, type_id, value
             */
            $stm_try_insert_cvtermprop = $db->prepare(
                    <<<EOF
INSERT INTO cvtermprop (cvterm_id, type_id, value, rank) SELECT ?,?,?, COALESCE((SELECT rank+1 FROM cvtermprop WHERE cvterm_id=? AND type_id=? ORDER BY rank DESC LIMIT 1), 0)
    WHERE NOT EXISTS (SELECT 1 FROM cvtermprop WHERE cvterm_id = ? AND type_id=? AND value=? )

EOF
            );
            $dbxrefs = array();
            $cvterms = array();

            $file = fopen($filename, 'r');
            //skip header line
            fgets($file);
            while (($line = fgetcsv($file, 0, "\t")) != false) {
                //if..elseif..else: check which section we are in
                // header, looks like <BINCODE>\t<H_DESC>
                if (count($line) == 2) {
                    $stm_try_insert_dbxref_id->execute(array(
                        // parameters: :dbname, :accession
                        // returns: dbxref_id
                        self::$db_name,
                        $line[0]
                    ));
                    $dbxref_id = $stm_try_insert_dbxref_id->fetchColumn();
                    $dbxrefs[$line[0]] = $dbxref_id;
                    $stm_try_insert_cvterm->execute(array(
                        // parameters: name, definition, dbxref_id dbxref_id, dbxref_id
                        // returns: cvterm_id
                        $line[0],
                        $line[1],
                        $dbxref_id,
                        $dbxref_id,
                        $dbxref_id
                    ));
                    $cvterms[$line[0]] = $stm_try_insert_cvterm->fetchColumn();
                } else if (count($line) == 5) {
                    //mapping, looks like <BINCODE>, <H_DESC>, <srcfeature_name>, <feature_description>, "T"
                    if ($line[4] == 'T') {
                        $stm_get_parentfeature->execute(array(
                            ':object_name' => $line[2],
                            ':organism_id' => DB_ORGANISM_ID,
                            ':dbxref_id' => $import_prefix_id
                        ));
                        if ($stm_get_parentfeature->rowCount() == 0) {
                            self::updateProgress($lines_imported + (++$lines_skipped));
                            continue;
                        }
                        $parent_id = $stm_get_parentfeature->fetchColumn();
                        $stm_insert_feature->execute(array(
                            ':name' => $line[2] . '_MapMan_' . $line[0],
                            ':uniquename' => IMPORT_PREFIX . '_' . $line[2] . '_MapMan_' . $line[0],
                            ':type_id' => CV_ANNOTATION_MAPMAN_FEATURE,
                            ':organism_id' => DB_ORGANISM_ID,
                            ':dbxref_id' => $import_prefix_id
                        ));
                        $feature_id = $stm_insert_feature->fetchColumn();
                        $stm_link_feature->execute(array(
                            ':subject_id' => $feature_id,
                            ':type_id' => CV_ANNOTATION_MAPMAN_RELATIONSHIP,
                            ':object_id' => $parent_id
                        ));
                        $stm_insert_featureprop->execute(array(
                            //parameters:  feature_id, type_id, value
                            $feature_id,
                            CV_ANNOTATION_MAPMAN_PROP,
                            $line[3]
                        ));
                        $stm_link_dbxref->execute(array(
                            // parameters: feature_id, cvterm_id
                            $feature_id,
                            $dbxrefs[$line[0]]
                        ));
                    } else
                    //footer, looks like: <BINCODE>, <H_DESC>, <CHEM>, <C_DESC>, "M"
                    if ($line[4] == 'M') {
                        $val = sprintf("%s\t%s", $line[2], $line[3]);
                        $cvterm_id = $cvterms[$line[0]];
                        $stm_try_insert_cvtermprop->execute(array(
                            //cvterm_id, type_id, value, cvterm_id, type_id, cvterm_id, type_id, value
                            $cvterm_id,
                            CV_ANNOTATION_MAPMAN_PROP,
                            $val,
                            $cvterm_id,
                            CV_ANNOTATION_MAPMAN_PROP,
                            $cvterm_id,
                            CV_ANNOTATION_MAPMAN_PROP,
                            $val
                        ));
                    }
                }
                self::updateProgress((++$lines_imported) + $lines_skipped);
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
        return array(LINES_IMPORTED => $lines_imported);
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        return <<<EOF
   \033[0;31mThis import requires a successful Sequence ID Import!\033[0m
EOF;
    }

}

?>
