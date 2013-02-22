<?php

require_once __DIR__ . '/db.php';

/**
 * loads a file containing "unigene\tisoform" lines into feature table
 * THIS FILE HAS TO BE SORTED!
 * @global DBO $db
 * @param string $mapfile filename
 * @throws ErrorException
 */
function import_map($mapfile) {
    global $db;

    #pre-initialize variables to bind statement parameters
    $param_unigene_name = null;
    $param_unigene_uniq = null;
    $param_isoform_name = null;
    $param_isoform_uniq = null;
    $param_unigene_lastid = null;

    try {
        $db->beginTransaction();
        # we are working with RETURNING feature_id here because PGSQL does not support lastInsertId
        $statement_insert_unigene = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:name, :uniquename, :type_id, :organism_id) RETURNING feature_id');
        $statement_insert_unigene->bindValue('type_id', CV_UNIGENE, PDO::PARAM_INT);
        $statement_insert_unigene->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
        $statement_insert_unigene->bindParam('name', &$param_unigene_name, PDO::PARAM_STR);
        $statement_insert_unigene->bindParam('uniquename', &$param_unigene_uniq);


        $statement_insert_isoform = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:name, :uniquename, :type_id, :organism_id)');
        $statement_insert_isoform->bindValue('type_id', CV_ISOFORM, PDO::PARAM_INT);
        $statement_insert_isoform->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
        $statement_insert_isoform->bindParam('name', &$param_isoform_name, PDO::PARAM_STR);
        $statement_insert_isoform->bindParam('uniquename', &$param_isoform_uniq, PDO::PARAM_STR);


        $statement_insert_feature_rel = $db->prepare('INSERT INTO feature_relationship (type_id, subject_id, object_id) VALUES (:type_id, :parent, currval(\'feature_feature_id_seq\'))');
        $statement_insert_feature_rel->bindValue('type_id', CV_RELATIONSHIP_UNIGENE_ISOFORM, PDO::PARAM_INT);        
        $statement_insert_feature_rel->bindParam('parent', &$param_unigene_lastid, PDO::PARAM_INT);


        $file = fopen($mapfile, 'r');

        $last_unigene = "";
        while (($line = fgetcsv($file, 0, "\t")) !== false) {
            #remove newline, split into parts
            list($param_unigene_name, $param_isoform_name) = $line;

            if ($last_unigene != $param_unigene_name) {
                # set last value, execute insert
                $param_unigene_uniq = ASSEMBLY_PREFIX . $param_unigene_name;

                $statement_insert_unigene->execute();

                # get last insert id (see query: 'RETURNING feature_id'), set id for feature_relationship insert
                $param_unigene_lastid = $statement_insert_unigene->fetchColumn();


                # set for test to skip this unigene in the future
                $last_unigene = $param_unigene_name;
            }

            # set last value, execute insert
            $param_isoform_uniq = ASSEMBLY_PREFIX . $param_isoform_name;
            $statement_insert_isoform->execute();

            # insert feature_relationship
            $statement_insert_feature_rel->execute();
        }
        if (!$db->commit()) {
            $err = $db->errorInfo();
            throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
        }
    } catch (Exception $error) {
        $db->rollback();
        throw $error;
    }
}
?>
