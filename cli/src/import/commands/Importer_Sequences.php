<?php

require_once ROOT . 'classes/AbstractImporter.php';

class Importer_Sequences extends AbstractImporter {

    public static function get_import_dbxref() {
        global $db;
        # get import prefix id, insert into dbxref if neccessary
        $stm_get_import_prefix_id = $db->prepare('SELECT get_or_insert_dbxref(?, ?)');
        $stm_get_import_prefix_id->execute(array(DB_NAME_IMPORTS, IMPORT_PREFIX));
        $import_prefix_id = $stm_get_import_prefix_id->fetchColumn();
        unset($stm_get_import_prefix_id);

        return $import_prefix_id;
    }

    /**
     * loads a file containing "unigene\tisoform" lines into feature table
     * THIS FILE HAS TO BE SORTED!
     * @global DBO $db
     * @param string $filename filename
     * @throws ErrorException
     */
    static function import($options) {
        $filename = $options['file'];
        $file_type = $options['file_type'];

        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $db;
        if (false)
            $db = new PDO();

        $lines_imported = 0;
        $isoforms_added = 0;
        $unigenes_added = 0;

        #pre-initialize variables to bind statement parameters
        $param_unigene_name = null;
        $param_unigene_uniq = null;
        $param_isoform_name = null;
        $param_isoform_uniq = null;
        $param_unigene_lastid = null;

        try {
            $db->beginTransaction();
            $import_prefix_id = self::get_import_dbxref();

            # link import dbxref to organism if not already linked
            $stm_link_organism_import_dbxref = $db->prepare("SELECT * FROM organism_dbxref WHERE organism_id=? AND dbxref_id=?");
            $stm_link_organism_import_dbxref->execute(array(DB_ORGANISM_ID, $import_prefix_id));
            if ($stm_link_organism_import_dbxref->rowCount() == 0)
                $db->prepare("INSERT INTO organism_dbxref (organism_id, dbxref_id) VALUES (?, ?)")->execute(array(DB_ORGANISM_ID, $import_prefix_id));
            unset($stm_link_organism_import_dbxref);

            $stm_sel_unigene_byUniquename = $db->prepare('SELECT feature_id FROM feature WHERE uniquename=:uniquename AND organism_id=:organism_id');
            $stm_sel_unigene_byUniquename->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $stm_sel_unigene_byUniquename->bindParam('uniquename', $param_unigene_uniq);


            # we are working with RETURNING feature_id here because PGSQL does not support lastInsertId
            $stm_ins_unigene = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id, dbxref_id) VALUES (:name, :uniquename, :type_id, :organism_id, :dbxref_id) RETURNING feature_id');
            $stm_ins_unigene->bindValue('type_id', CV_UNIGENE, PDO::PARAM_INT);
            $stm_ins_unigene->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $stm_ins_unigene->bindParam('name', $param_unigene_name, PDO::PARAM_STR);
            $stm_ins_unigene->bindParam('uniquename', $param_unigene_uniq);
            $stm_ins_unigene->bindValue('dbxref_id', $import_prefix_id, PDO::PARAM_INT);


            $stm_ins_isoform = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id, dbxref_id) VALUES (:name, :uniquename, :type_id, :organism_id, :dbxref_id)');
            $stm_ins_isoform->bindValue('type_id', CV_ISOFORM, PDO::PARAM_INT);
            $stm_ins_isoform->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $stm_ins_isoform->bindParam('name', $param_isoform_name, PDO::PARAM_STR);
            $stm_ins_isoform->bindParam('uniquename', $param_isoform_uniq, PDO::PARAM_STR);
            $stm_ins_isoform->bindValue('dbxref_id', $import_prefix_id, PDO::PARAM_INT);

            $stm_ins_feature_rel = $db->prepare('INSERT INTO feature_relationship (subject_id, type_id, object_id) VALUES (currval(\'feature_feature_id_seq\'), :type_id, :parent)');
            $stm_ins_feature_rel->bindValue('type_id', CV_RELATIONSHIP_UNIGENE_ISOFORM, PDO::PARAM_INT);
            $stm_ins_feature_rel->bindParam('parent', $param_unigene_lastid, PDO::PARAM_INT);


            $file = fopen($filename, 'r');

            $last_unigene = "";
            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                switch ($file_type) {
                    case 'only_isoforms':
                        $param_isoform_name = $line[0];
                        $param_isoform_uniq = IMPORT_PREFIX . "_" . $param_isoform_name;
                        $stm_ins_isoform->execute();
                        $isoforms_added++;
                        break;

                    case 'only_unigenes':
                        $param_unigene_name = $line[0];
                        $param_unigene_uniq = IMPORT_PREFIX . "_" . $param_unigene_name;
                        $stm_ins_unigene->execute();
                        $unigenes_added++;
                        break;

                    case 'map':
                        #remove newline, split into parts
                        list($param_unigene_name, $param_isoform_name) = $line;

                        if ($last_unigene != $param_unigene_name) {
                            # set last value, execute insert
                            $param_unigene_uniq = IMPORT_PREFIX . "_" . $param_unigene_name;

                            $stm_sel_unigene_byUniquename->execute();
                            $param_unigene_lastid = $stm_sel_unigene_byUniquename->fetchColumn();
                            if (!$param_unigene_lastid) {


                                $stm_ins_unigene->execute();
                                $unigenes_added++;

                                # get last insert id (see query: 'RETURNING feature_id'), set id for feature_relationship insert
                                $param_unigene_lastid = $stm_ins_unigene->fetchColumn();
                            }
                            # set for test to skip this unigene in the future
                            $last_unigene = $param_unigene_name;
                        }

                        if (!empty($param_isoform_name)) {
                            # set last value, execute insert
                            $param_isoform_uniq = IMPORT_PREFIX . "_" . $param_isoform_name;
                            $stm_ins_isoform->execute();
                            $isoforms_added++;

                            # insert feature_relationship
                            $stm_ins_feature_rel->execute();
                        }
                        break;
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
        return array(LINES_IMPORTED => $lines_imported, 'unigenes_added' => $unigenes_added, 'isoforms_added' => $isoforms_added);
    }

    public static function CLI_getCommand(Console_CommandLine $parser) {
        $command = parent::CLI_getCommand($parser);
        $command->addOption('file_type', array(
            'short_name' => '-t',
            'long_name' => '--file_type',
            'description' => "file format description. one of ('map', 'only_isoforms', 'only_unigenes'). defaults to 'map'",
            'choices' => array('map', 'only_isoforms', 'only_unigenes'),
            'default' => 'map'
        ));
    }

    //TODO sequence map
    public static function CLI_commandName() {
        return 'sequences';
    }

    public static function CLI_commandDescription() {
        return "Mapping File Importer";
    }

    //TODO --only-unigenes / --only-isoforms
    public static function CLI_longHelp() {
        return <<<EOF

This command creates the database features all other commands work with.
You can either import a line-separated file with just the sequence ids you use throughout the files that will be imported or you can import a map, which maps isoforms on unigenes.
   
File format "only_isoforms":
isoform1
isoform2
isoform3

File format "only_unigenes":
unigene1
unigene2
unigene3

File Format "map" (tab-separated):
unigene1    isoform1
unigene1    isoform2
unigene2    isoform3
unigene3    isoform4
EOF;
    }

}

?>
