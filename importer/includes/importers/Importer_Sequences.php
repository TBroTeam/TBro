<?php

require_once __DIR__ . '/../db.php';
require_once __DIR__ . '/../constants.php';

class Importer_Sequences {

    /**
     * reads the next fasta sequence from file handle $fasta_handle and returns a list of description and sequence (without whitespace and newlines)
     * @param resource $fasta_handle
     * @return list ($description, $sequence)
     * @throws ErrorException with ErrorCode ERRCODE_ILLEGAL_FILE_FORMAT: next non-empty line has to start with '>'
     */
    static function read_fasta($fasta_handle) {
        $description = '';
        while (empty($description) && !feof($fasta_handle))
            $description = trim(fgets($fasta_handle));
        if (strpos($description, '>') !== 0)
            throw new ErrorException('', ERRCODE_ILLEGAL_FILE_FORMAT, 1);


        $sequence = '';
        while (!feof($fasta_handle)) {
            $pos = ftell($fasta_handle);
            $line = fgets($fasta_handle);
            if (strpos($line, '>') === 0) {
                fseek($fasta_handle, $pos, SEEK_SET);
                break;
            }
            $sequence .= trim($line);
        }
        return array($description, $sequence);
    }

    /**
     * Converts values to String that would be stored as Name (Suffic of UniqueName) in DB
     * @param string $isoform_name
     * @param int $left
     * @param int $right
     * @param char $direction [+-]
     * @return string
     */
    static function prepare_predpep_name($isoform_name, $left, $right, $direction) {
        return $isoform_name . ':' . ($direction == '+' ? "$left-$right" : "$right-$left");
    }

    /**
     * imports FASTA file. 
     * isoform entries will be updated
     * predicted peptide entries will be inserted & located on isoform
     * @global DBO $db
     * @param string $filename filename
     * @throws ErrorException
     */
    static function import($filename) {
        global $db;

        #pre-initialize variables to bind statement parameters
        $param_isoform_uniq = null;
        $param_isoform_seqlen = null;
        $param_isoform_residues = null;
        $param_isoform_feature_id = null;
        $param_isoform_path = null;

        $param_predpep_name = null;
        $param_predpep_uniq = null;
        $param_predpep_seqlen = null;
        $param_predpep_residues = null;
        $param_predpep_feature_id = null;
        $param_predpep_fmin = null;
        $param_predpep_fmax = null;
        $param_predpep_strand = null;
        $param_predpep_srcfeature_uniq = null;

        try {
            $db->beginTransaction();
            # prepare statements
            #
        #isoform sequence
            $statement_update_isoform = $db->prepare('UPDATE feature SET (seqlen, residues) = (:seqlen, :residues) WHERE uniquename=:uniquename RETURNING feature_id');
            $statement_update_isoform->bindParam('uniquename', &$param_isoform_uniq, PDO::PARAM_STR);
            $statement_update_isoform->bindParam('seqlen', &$param_isoform_seqlen, PDO::PARAM_INT);
            $statement_update_isoform->bindParam('residues', &$param_isoform_residues, PDO::PARAM_STR);

            $statement_insert_isoform_path = $db->prepare('INSERT INTO featureprop (feature_id, type_id, value) VALUES (:feature_id, :type_id, :value)');
            $statement_insert_isoform_path->bindValue('type_id', CV_ISOFORM_PATH, PDO::PARAM_INT);
            $statement_insert_isoform_path->bindParam('feature_id', &$param_isoform_feature_id, PDO::PARAM_INT);
            $statement_insert_isoform_path->bindParam('value', &$param_isoform_path, PDO::PARAM_STR);

            #predicted peptide
            $statement_insert_predpep = $db->prepare('INSERT INTO feature  (type_id, organism_id, name, uniquename, seqlen, residues) '
                    . 'VALUES (:type_id, :organism_id, :name, :uniquename, :seqlen, :residues) RETURNING feature_id');
            $statement_insert_predpep->bindValue('type_id', CV_PREDPEP, PDO::PARAM_INT);
            $statement_insert_predpep->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
            $statement_insert_predpep->bindParam('name', &$param_predpep_name, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('uniquename', &$param_predpep_uniq, PDO::PARAM_STR);
            $statement_insert_predpep->bindParam('seqlen', &$param_predpep_seqlen, PDO::PARAM_INT);
            $statement_insert_predpep->bindParam('residues', &$param_predpep_residues, PDO::PARAM_STR);

            $statement_insert_predpep_location = $db->prepare(sprintf('INSERT INTO featureloc (fmin, fmax, strand, feature_id, srcfeature_id) VALUES (:fmin, :fmax, :strand, :feature_id, (%s))', 'SELECT feature_id FROM feature WHERE uniquename=:srcfeature_uniquename LIMIT 1'));
            $statement_insert_predpep_location->bindParam('fmin', &$param_predpep_fmin, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('fmax', &$param_predpep_fmax, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('strand', &$param_predpep_strand, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('feature_id', &$param_predpep_feature_id, PDO::PARAM_INT);
            $statement_insert_predpep_location->bindParam('srcfeature_uniquename', &$param_predpep_srcfeature_uniq, PDO::PARAM_STR);

            #read file and execute statements

            $file = fopen($filename, 'r');
            while (!feof($file)) {
                #remove newline, split into parts
                list($description, $sequence) = self::read_fasta($file);

                $matches = array();

                #isoform header like this:
                #>comp173079_c0_seq1 len=2161 path=[2139:0-732 2872:733-733 2873:734-1159 3299:1160-1160 3300:1161-1513 3653:1514-1517 3657:1518-2160]
                if (preg_match('/^>(?<name>\w+) len=(?<seqlen>\d+) path=(?<path>\[(?:\d+:\d+-\d+ ?)+\])$/', $description, &$matches)) {
                    $param_isoform_uniq = ASSEMBLY_PREFIX . $matches['name'];
                    $param_isoform_seqlen = $matches['seqlen'];
                    $param_isoform_residues = $sequence;

                    $statement_update_isoform->execute();

                    # get last insert id (see query: 'RETURNING feature_id'), set id for feature_relationship insert
                    $param_isoform_feature_id = $statement_update_isoform->fetchColumn();
                    $param_isoform_path = $matches['path'];

                    $statement_insert_isoform_path->execute();
                }
                #predicted peptide header like this:
                #>m.1812924 g.1812924  ORF g.1812924 m.1812924 type:5prime_partial len:376 (+) comp224705_c0_seq18:3-1130(+)
                else if (preg_match('/^>m.\d+ g.\d+  ORF g.\d+ m.\d+ type:\w+ len:(?<len>\d+) \([+-]\) (?<name>\w+):(?<from>\d+)-(?<to>\d+)\((?<dir>[+-])\)$/', $description, &$matches)) {
                    $param_predpep_name = self::prepare_predpep_name($matches['name'], $matches['from'], $matches['to'], $matches['dir']);
                    $param_predpep_uniq = ASSEMBLY_PREFIX . $param_predpep_name;
                    $param_predpep_seqlen = $matches['len'];
                    $param_predpep_residues = $sequence;

                    $statement_insert_predpep->execute();

                    $param_predpep_feature_id = $statement_insert_predpep->fetchColumn();
                    $param_predpep_srcfeature_uniq = ASSEMBLY_PREFIX . $matches['name'];
                    $param_predpep_fmin = min($matches['from'], $matches['to']);
                    $param_predpep_fmax = max($matches['from'], $matches['to']);
                    $param_predpep_strand = $matches['dir'] == '+' ? 1 : -1;
                    $statement_insert_predpep_location->execute();
                }
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

}

?>
