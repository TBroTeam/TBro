<?php

require_once __DIR__ . '/AbstractImporter.php';
require_once __DIR__ . '/Importer_Sequences.php';

#versions of databases for interpro import
global $dbrefx_versions;
$dbrefx_versions = array('HMMPIR' => '1.0');

class Importer_Annotations_Interpro extends AbstractImporter {

    /**
     * Interpro Line RegeX
     * @var RegEx-String
     */
    private static $regex = <<<EOF
{^
   (?<feature>\w+)
[\t]   (?<pepStart>\d+)
[\t]   (?<pepEnd>\d+)
[\t]   (?<pepStrand>[+-])
[\t]   (?<checksum>\w+)
[\t]   (?<length>\d+)
[\t]   (?<analysisMethod>\w+)
[\t]   (?<analysisMatchID>.*?)
(?:[\t]   (?<analysisMatchDescription>.*))?
[\t]   (?<domStart>\d+)
[\t]   (?<domEnd>\d+)
[\t]   (?<eValue>(?:NA|\d+(?:\.\d+)?(?:e[+-]\d+)?))
[\t]   (?<status>[T?])
[\t]   (?<timeexecuted>[\w-]*)
[\t]   (?<interproID>\w*)
[\t]   (?<interproDesc>.*?)
(?:[\t]   (?<interproGOs>.*))?
$}x
EOF;

    /**
     * 
     * @global array $dbrefx_versions array mapping databases to their versions, e.g. array('HMMPFam'=>'1.0')
     * @global PDO $db Database
     * @param string $filename
     * @throws ErrorException
     */
    static function import($options) {
#SEQNAME    ?   ?   ?   CRC LENGTH  EVIDENCE    MATCHID MATCHNAME   START   END SCORE   STATUS  DATE    INTERPROID  INTERPRONAME
        /*
         * http://wiki.bioinformatics.ucdavis.edu/index.php/InterProScan#Iprscan_raw_output_explanation
         * 
          ------
          NF00181542      0A5FDCE74AB7C3AD        272     HMMPIR  PIRSF001424     Prephenate dehydratase  1       270     6.5e-141        T       06-Oct-2004         IPR008237       Prephenate dehydratase with ACT region  Molecular Function:prephenate dehydratase activity (GO:0004664), Biological Process:L-phenylalanine biosynthesis (GO:0009094)
          ------

          Where: NF00181542:             is the id of the input sequence.
          27A9BBAC0587AB84:       is the crc64 (checksum) of the proteic sequence (supposed to be unique).
          272:                    is the length of the sequence (in AA).
          !HMMPIR:                 is the anaysis method launched.
          !PIRSF001424:            is the database members entry for this match.
          !Prephenate dehydratase: is the database member description for the entry.
          !1:                      is the start of the domain match.
          !270:                    is the end of the domain match.
          6.5e-141:               is the evalue of the match (reported by member database anayling method).
          T:                      is the status of the match (T: true, ?: unknown).
          06-Oct-2004:            is the date of the run.
          IPR008237:              is the corresponding InterPro entry (if iprlookup requested by the user).
          Prephenate dehydratase with ACT region:                           is the description of the InterPro entry.
          Molecular Function:prephenate dehydratase activity (GO:0004664):  is the GO (gene ontology) description for the InterPro entry.

         * file format we have differs slightly:
          comp214244_c0_seq2	252	1718	+	75AFB115E637E163	488	FPrintScan	PR00724	CRBOXYPTASEC	150	162	1e-25	T	08-Nov-2012	IPR001563	Peptidase S10, serine carboxypeptidase	Molecular Function: serine-type carboxypeptidase activity (GO:0004185), Biological Process: proteolysis (GO:0006508)
         * 
         * param 2,3 and 4 are inserted: 
         * derived from "comp214244_c0_seq2:2137-2445(+)" in predpep sequence file, which gets stored as comp214244_c0_seq2:2137-2445 in the feature table
         * 
         * 
         * feature: comp214244_c0_seq2:252-1718 # EXISTIERT BEREITS
         * feature: comp214244_c0_seq2:252-1718_PR00724_150_162 #DOMAIN
         * featureloc:
         *  start=1
         *  stop=270
         *  subject: comp214244_c0_seq2:2137-2445
         *  object: comp214244_c0_seq2:252-1718_PR00724_150_162
         * 
         * analysis: 
         *  program=FPrintScan
         *  version (manuell)
         *  timeexecuted=08-Nov-2012
         * analysisfeature:
         *  significance=1e-25
         * featureprop:
         *   type=(CVTERM)interproID
         *   value=IPR001563
         * dbxref: (evtl. mehrere)
         *    (GO:0004185), (GO:0006508)
         */


        $filename = $options['file'];
        $lines_total = trim(`wc -l $filename | cut -d' ' -f1`);
        self::setLineCount($lines_total);

        global $dbrefx_versions;
        global $db;
        $lines_imported = 0;
        $interpro_ids_added = 0;
        $dbxrefs_added = 0;

        try {
            $db->beginTransaction();
            #shared parameters
            $param_feature_uniq = null;
            $param_feature_domain_name = null;
            $param_feature_domain_uniq = null;
            $param_domain_fmin = null;
            $param_domain_fmax = null;
            $param_db_ver = null;
            $param_db_name = null;
            $param_evalue = null;
            $param_timeexecuted = null;
            $param_featureprop_type = null;
            $param_featureprop_value = null;
            $param_accession = null;
            $param_dbname = null;

            $statement_insert_feature_domain = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:feature_domain_name, :feature_domain_unique, :type_id, :organism_id)');
            $statement_insert_feature_domain->bindValue('type_id', CV_ANNOTATION_INTERPRO, PDO::PARAM_INT);
            $statement_insert_feature_domain->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);

            $statement_insert_feature_domain->bindParam('feature_domain_name', $param_feature_domain_name, PDO::PARAM_STR);
            $statement_insert_feature_domain->bindParam('feature_domain_unique', $param_feature_domain_uniq, PDO::PARAM_STR);

            $statement_insert_featureloc = $db->prepare(sprintf('INSERT INTO featureloc (fmin, fmax, strand, feature_id, srcfeature_id) VALUES (:fmin, :fmax, :strand, currval(\'feature_feature_id_seq\'), (%s))', 'SELECT feature_id FROM feature WHERE uniquename=:srcfeature_uniquename LIMIT 1'));
            $statement_insert_featureloc->bindParam('fmin', $param_domain_fmin, PDO::PARAM_INT);
            $statement_insert_featureloc->bindParam('fmax', $param_domain_fmax, PDO::PARAM_INT);
            $statement_insert_featureloc->bindValue('strand', 1, PDO::PARAM_INT);
            $statement_insert_featureloc->bindParam('srcfeature_uniquename', $param_feature_uniq, PDO::PARAM_STR);

            $statement_insert_analysisfeature = $db->prepare('INSERT INTO analysisfeature (analysis_id, feature_id, significance) VALUES (get_or_insert_analysis(:name, :program, :version, :timeexecuted) ,currval(\'feature_feature_id_seq\'), :significance)');
            $statement_insert_analysisfeature->bindValue('name', 'Interpro Analysis', PDO::PARAM_STR);
            $statement_insert_analysisfeature->bindParam('program', $param_db_name, PDO::PARAM_STR);
            $statement_insert_analysisfeature->bindParam('version', $param_db_ver, PDO::PARAM_STR);
            $statement_insert_analysisfeature->bindParam('timeexecuted', $param_timeexecuted, PDO::PARAM_STR);
            $statement_insert_analysisfeature->bindParam('significance', $param_evalue, PDO::PARAM_STR);

            $statement_insert_featureprop = $db->prepare('INSERT INTO featureprop (feature_id, type_id, value) VALUES (currval(\'feature_feature_id_seq\'), :type_id, :value)');
            $statement_insert_featureprop->bindParam(':type_id', $param_featureprop_type, PDO::PARAM_INT);
            $statement_insert_featureprop->bindParam(':value', $param_featureprop_value, PDO::PARAM_STR);


            $statement_insert_feature_dbxref = $db->prepare('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES (currval(\'feature_feature_id_seq\'), get_or_insert_dbxref(:dbname, :accession))');
            $statement_insert_feature_dbxref->bindParam('accession', $param_accession, PDO::PARAM_STR);
            $statement_insert_feature_dbxref->bindParam('dbname', $param_dbname, PDO::PARAM_STR);

            $file = fopen($filename, 'r');
            while (($line = trim(fgets($file))) != false) {
                $match = array();
                preg_match(self::$regex, $line, $match);
                if (count($match) == 0)
                    self::$log->log(sprintf("line does not match, skipping:\n\t" . $line), PEAR_LOG_NOTICE);


                // set params for statements
                // available matches, see RegEx
                $param_db_name = $match['analysisMethod'];
                $param_domain_fmin = $match['domStart'];
                $param_domain_fmax = $match['domEnd'];
                $param_evalue = $match['eValue'];
                $param_timeexecuted = $match['timeexecuted'];

                //more complex parameters
                $param_feature = Importer_Sequences::prepare_predpep_name($match['feature'], $match['pepStart'], $match['pepEnd'], $match['pepStrand']);
                $param_feature_uniq = IMPORT_PREFIX . "_" . $param_feature;
                $param_feature_domain_name = sprintf('%s_%s_%s_%s', $param_feature, $match['analysisMatchID'], $param_domain_fmin, $param_domain_fmax);
                $param_feature_domain_uniq = IMPORT_PREFIX . "_" . $param_feature_domain_name;

                $statement_insert_feature_domain->execute();
                $statement_insert_featureloc->execute();

                if ($param_evalue == 'NA')
                    $param_evalue = NULL;
                $param_db_ver = isset($dbrefx_versions[$param_db_name]) ? $dbrefx_versions[$param_db_name] : 'unknown';
                $statement_insert_analysisfeature->execute();

                if ($match['interproID'] != "NULL") {
                    $param_featureprop_type = CV_INTERPRO_ID;
                    $param_featureprop_value = $match['interproID'];

                    $statement_insert_featureprop->execute();
                    $interpro_ids_added++;
                }

                if ($match['analysisMatchID'] != null) {
                    $param_featureprop_type = CV_INTERPRO_ANALYSIS_MATCH_ID;
                    $param_featureprop_value = $match['analysisMatchID'];
                    $statement_insert_featureprop->execute();

                    if (isset($match['analysisMatchDescription']) && !empty($match['analysisMatchDescription'])) {
                        $param_featureprop_type = CV_INTERPRO_ANALYSIS_MATCH_DESCRIPTION;
                        $param_featureprop_value = $match['analysisMatchDescription'];
                        $statement_insert_featureprop->execute();
                    }
                }

                if (isset($match['interproGOs']) && $match['interproGOs'] != "NULL") {
                    $go_matches = array();
                    preg_match_all('/[\s,]*(?<description>.*?)\((?<dbname>\w+):(?<accession>\w+)\)/', $match['interproGOs'], $go_matches);
                    for ($i = 0; $i < count($go_matches[0]); $i++) {
                        $param_dbname = $go_matches['dbname'][$i];
                        $param_accession = $go_matches['accession'][$i];
                        $statement_insert_feature_dbxref->execute();
                        $dbxrefs_added++;
                    }
                }

                self::updateProgress(++$lines_imported);
            }

            if (!$db->commit()) {
                $err = $db->errorInfo();
                throw new ErrorException($err[2], ERRCODE_TRANSACTION_NOT_COMPLETED, 1);
            }
        } catch (Exception $error) {
            $db->rollback();
            throw $error;
        }
        return array(LINES_IMPORTED => $lines_imported, 'interpro_ids_added' => $interpro_ids_added, 'dbxrefs_added' => $dbxrefs_added);
    }



    public static function CLI_commandDescription() {
        return "Interpro Output Importer";
    }

    public static function CLI_commandName() {
        return 'annotation_interpro';
    }

    public static function CLI_longHelp() {
        return <<<EOF

\033[0;31mThis import requires a successful Map File Import!\033[0m
\033[0;31mThis import requires a successful Sequence File Import!\033[0m
EOF;
    }
}

?>
