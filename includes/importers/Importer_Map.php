<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';
require_once INC . '/libs/php-progress-bar.php';

class Importer_Map {

    /**
     * loads a file containing "unigene\tisoform" lines into feature table
     * THIS FILE HAS TO BE SORTED!
     * @global DBO $db
     * @param string $filename filename
     * @throws ErrorException
     */
    static function import($filename) {
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);

        global $db;
        if (false)
            $db = new PDO();

        $lines_imported = 0;
        $unigenes_added = 0;

        #pre-initialize variables to bind statement parameters
        $param_unigene_name = null;
        $param_unigene_uniq = null;
        $param_isoform_name = null;
        $param_isoform_uniq = null;
        $param_unigene_lastid = null;

        try {
            $db->beginTransaction();

            # get import prefix id, insert into dbxref if neccessary
            $stm_get_import_prefix_id = $db->prepare('SELECT get_or_insert_dbxref(?, ?)');
            $stm_get_import_prefix_id->execute(array(DB_NAME_IMPORTS, IMPORT_PREFIX));
            $import_prefix_id = $stm_get_import_prefix_id->fetchColumn();
            unset($stm_get_import_prefix_id);

            # link import dbxref to organism if not already linked
            $stm_link_organism_import_dbxref = $db->prepare("SELECT * FROM organism_dbxref WHERE organism_id=? AND dbxref_id=?");
            $stm_link_organism_import_dbxref->execute(array(DB_ORGANISM_ID, $import_prefix_id));
            if ($stm_link_organism_import_dbxref->rowCount() == 0)
                $db->prepare("INSERT INTO organism_dbxref (organism_id, dbxref_id) VALUES (?, ?)")->execute(array(DB_ORGANISM_ID, $import_prefix_id));
            unset($stm_link_organism_import_dbxref);

            #link last inserted feature to current import. has to be called after every insert
            $stm_lnk_feature_import = $db->prepare('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES (currval(\'feature_feature_id_seq\'), :dbxref_id)');
            $stm_lnk_feature_import->bindValue('dbxref_id', $import_prefix_id);

            # we are working with RETURNING feature_id here because PGSQL does not support lastInsertId
            $stm_ins_unigene = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:name, :uniquename, :type_id, :organism_id) RETURNING feature_id');
            $stm_ins_unigene->bindValue('type_id', CV_UNIGENE, PDO::PARAM_INT);
            $stm_ins_unigene->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $stm_ins_unigene->bindParam('name', $param_unigene_name, PDO::PARAM_STR);
            $stm_ins_unigene->bindParam('uniquename', $param_unigene_uniq);


            $stm_ins_isoform = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:name, :uniquename, :type_id, :organism_id)');
            $stm_ins_isoform->bindValue('type_id', CV_ISOFORM, PDO::PARAM_INT);
            $stm_ins_isoform->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $stm_ins_isoform->bindParam('name', $param_isoform_name, PDO::PARAM_STR);
            $stm_ins_isoform->bindParam('uniquename', $param_isoform_uniq, PDO::PARAM_STR);


            $stm_ins_feature_rel = $db->prepare('INSERT INTO feature_relationship (subject_id, type_id, object_id) VALUES (currval(\'feature_feature_id_seq\'), :type_id, :parent)');
            $stm_ins_feature_rel->bindValue('type_id', CV_RELATIONSHIP_UNIGENE_ISOFORM, PDO::PARAM_INT);
            $stm_ins_feature_rel->bindParam('parent', $param_unigene_lastid, PDO::PARAM_INT);


            $file = fopen($filename, 'r');

            $last_unigene = "";
            while (($line = fgetcsv($file, 0, "\t")) !== false) {
                #remove newline, split into parts
                list($param_unigene_name, $param_isoform_name) = $line;

                if ($last_unigene != $param_unigene_name) {
                    # set last value, execute insert
                    $param_unigene_uniq = IMPORT_PREFIX . "_" .$param_unigene_name;

                    $stm_ins_unigene->execute();
                    $unigenes_added++;

                    # get last insert id (see query: 'RETURNING feature_id'), set id for feature_relationship insert
                    $param_unigene_lastid = $stm_ins_unigene->fetchColumn();

                    # set for test to skip this unigene in the future
                    $last_unigene = $param_unigene_name;

                    #link unigene to import
                    $stm_lnk_feature_import->execute();
                }

                # set last value, execute insert
                $param_isoform_uniq = IMPORT_PREFIX . "_" .$param_isoform_name;
                $stm_ins_isoform->execute();

                # insert feature_relationship
                $stm_ins_feature_rel->execute();

                #link isoform to import
                $stm_lnk_feature_import->execute();

                $lines_imported++;
                if ($lines_imported % 200 == 0)
                    php_progress_bar_show_status($lines_imported, $lines_total, 60);
            }
            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'unigenes_added' => $unigenes_added);
    }

}

?>
