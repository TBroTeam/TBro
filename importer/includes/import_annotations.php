<?php

require_once __DIR__ . '/db.php';
require_once __DIR__ . '/helpers.php';

/**
 * @global PDO $db
 * @param string $filename
 * @throws ErrorException
 */
function import_annot_blast2go($filename) {

    global $db;

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
            if ($description != null)
                $statement_insert_featureprop->execute();
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

/**
 * 
 * @global array $dbrefx_versions array mapping databases to their versions, e.g. array('HMMPFam'=>'1.0')
 * @global PDO $db Database
 * @param string $filename
 * @throws ErrorException
 */
function import_annot_interpro($filename) {
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


    global $dbrefx_versions;
    global $db;

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
        $param_interproID = null;
        $param_accession = null;
        $param_dbname = null;
        $trash = null;

        $statement_insert_feature_domain = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:feature_domain_name, :feature_domain_unique, :type_id, :organism_id)');
        $statement_insert_feature_domain->bindValue('type_id', CV_ANNOTATION_INTERPRO, PDO::PARAM_INT);
        $statement_insert_feature_domain->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);

        $statement_insert_feature_domain->bindParam('feature_domain_name', &$param_feature_domain_name, PDO::PARAM_STR);
        $statement_insert_feature_domain->bindParam('feature_domain_unique', &$param_feature_domain_uniq, PDO::PARAM_STR);

        $statement_insert_featureloc = $db->prepare(sprintf('INSERT INTO featureloc (fmin, fmax, strand, feature_id, srcfeature_id) VALUES (:fmin, :fmax, :strand, currval(\'feature_feature_id_seq\'), (%s))', 'SELECT feature_id FROM feature WHERE uniquename=:srcfeature_uniquename LIMIT 1'));
        $statement_insert_featureloc->bindParam('fmin', &$param_domain_fmin, PDO::PARAM_INT);
        $statement_insert_featureloc->bindParam('fmax', &$param_domain_fmax, PDO::PARAM_INT);
        $statement_insert_featureloc->bindValue('strand', 1, PDO::PARAM_INT);
        $statement_insert_featureloc->bindParam('srcfeature_uniquename', &$param_feature_uniq, PDO::PARAM_STR);

        $statement_insert_analysisfeature = $db->prepare('INSERT INTO analysisfeature (analysis_id, feature_id, significance) VALUES (get_or_insert_analysis(:name, :program, :version, :timeexecuted) ,currval(\'feature_feature_id_seq\'), :significance)');
        $statement_insert_analysisfeature->bindValue('name', 'Interpro Analysis', PDO::PARAM_STR);
        $statement_insert_analysisfeature->bindParam('program', &$param_db_name, PDO::PARAM_STR);
        $statement_insert_analysisfeature->bindParam('version', &$param_db_ver, PDO::PARAM_STR);
        $statement_insert_analysisfeature->bindParam('timeexecuted', &$param_timeexecuted, PDO::PARAM_STR);
        $statement_insert_analysisfeature->bindParam('significance', &$param_evalue, PDO::PARAM_STR);

        $statement_insert_interproID = $db->prepare('INSERT INTO featureprop (feature_id, type_id, value) VALUES (currval(\'feature_feature_id_seq\'), :type_interproID, :interproID)');
        $statement_insert_interproID > bindValue('type_interproID', CV_INTERPRO_ID, PDO::PARAM_INT);
        $statement_insert_interproID->bindParam('interproID', &$param_interproID, PDO::PARAM_STR);


        $statement_insert_feature_dbxref = $db->prepare('INSERT INTO feature_dbxref (feature_id, dbxref_id) VALUES (currval(\'feature_feature_id_seq\'), get_or_insert_dbxref(:dbname, :accession))');
        $statement_insert_feature_dbxref->bindParam('accession', &$param_accession, PDO::PARAM_STR);
        $statement_insert_feature_dbxref->bindParam('dbname', &$param_dbname, PDO::PARAM_STR);

        $file = fopen($filename, 'r');
        while (($line = fgetcsv($file, 0, "\t")) !== false) {
            if (count($line) == 0)
                continue;
            if (count($line) < 16 || count($line) > 18) {
                error_log("wrong line parameter count on line:\n\t" . implode("\t", $line));
                continue;
            }
            //fill it up so we have 17 parameters even if there are no GOs
            if (count($line) == 16) {
                $line[16] = "NULL";
            }


            #list($feature, $pepStart, $pepEnd, $pepStrand, $checksum, $length, $analysisMethod, $analysisMatchID, $analysisMatchDesc, $domStart, $domEnd, $eValue, $status, $timeexecuted, $interproID, $interproDesc, $interproGOs);
            list($feature, $pepStart, $pepEnd, $pepStrand,
                    $trash, $trash,
                    $param_db_name, $analysisMatchID, $trash,
                    $param_domain_fmin, $param_domain_fmax, $param_evalue, $trash, $param_timeexecuted,
                    $param_interproID, $trash, $interproGOs) = $line;

            $param_feature = prepare_pedpep_name($feature, $pepStart, $pepEnd, $pepStrand);
            $param_feature_uniq = ASSEMBLY_PREFIX . $param_feature;
            $param_feature_domain_name = sprintf('%s_%s_%s_%s', $param_feature, $analysisMatchID, $param_domain_fmin, $param_domain_fmax);
            $param_feature_domain_uniq = ASSEMBLY_PREFIX . $param_feature_domain_name;

            $statement_insert_feature_domain->execute();
            $statement_insert_featureloc->execute();

            if ($param_evalue == 'NA')
                $param_evalue = NULL;
            $param_db_ver = isset($dbrefx_versions[$param_db_name]) ? $dbrefx_versions[$param_db_name] : 'unknown';
            $statement_insert_analysisfeature->execute();

            if ($param_interproID != "NULL") {
                $statement_insert_interproID->execute();
            }

            if ($interproGOs != "NULL") {
                $matches = array();
                preg_match_all('/\((?<dbname>\w+):(?<accession>\w+)\)/', $interproGOs, $matches);
                for ($i = 0; $i < count($matches[0]); $i++) {
                    $param_dbname = $matches['dbname'][$i];
                    $param_accession = $matches['accession'][$i];
                    $statement_insert_feature_dbxref->execute();
                }
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

function import_annot_repeatmasker($filename) {
    /*
      How to read the results

      The annotation file contains the cross_match output lines. It lists all best matches (above a set minimum score) between the query sequence and any of the sequences in the repeat database or with low complexity DNA. The term "best matches" reflects that a match is not shown if its domain is over 80% contained within the domain of a higher scoring match, where the "domain" of a match is the region in the query sequence that is defined by the alignment start and stop. These domains have been masked in the returned masked sequence file. In the output, matches are ordered by query name, and for each query by position of the start of the alignment.


      SW  perc perc perc  query    position in query     matching repeat      position in  repeat
      score div. del. ins.  sequence begin  end  (left)    repeat  class/family   begin end (left) ID
      ...
      1320 15.6  6.2  0.0  HSU08988  6563 6781 (22462) C  MER7A   DNA/MER2_type    (0)  337  104  20
      12279 10.5  2.1  1.7  HSU08988  6782 7718 (21525) C  Tigger1 DNA/MER2_type    (0) 2418 1486  19
      1769 12.9  6.6  1.9  HSU08988  7719 8022 (21221) C  AluSx   SINE/Alu         (0)  317    1  17
      12279 10.5  2.1  1.7  HSU08988  8023 8694 (20549) C  Tigger1 DNA/MER2_type  (932) 1486  818  19
      2335 11.1  0.3  0.7  HSU08988  8695 9000 (20243) C  AluSg   SINE/Alu         (5)  305    1  18
      12279 10.5  2.1  1.7  HSU08988  9001 9695 (19548) C  Tigger1 DNA/MER2_type (1600)  818    2  19
      721 21.2  1.4  0.0  HSU08988  9696 9816 (19427) C  MER7A   DNA/MER2_type  (224)  122    2  20

      This is a sequence in which a Tigger1 DNA transposon has integrated into a MER7 DNA transposon copy. Subsequently two Alus integrated in the Tigger1 sequence. The first line is interpreted as such:

      1320     = Smith-Waterman score of the match, usually complexity adjusted
      The SW scores are not always directly comparable. Sometimes
      the complexity adjustment has been turned off, and a variety of
      scoring-matrices are used dependent on repeat age and GC level.

      15.6     = % divergence = mismatches/(matches+mismatches) **
      6.2      = % of bases opposite a gap in the query sequence (deleted bp)
      0.0      = % of bases opposite a gap in the repeat consensus (inserted bp)
      HSU08988 = name of query sequence
      6563     = starting position of match in query sequence
      6781     = ending position of match in query sequence
      (22462)  = no. of bases in query sequence past the ending position of match
      C        = match is with the Complement of the repeat consensus sequence
      MER7A    = name of the matching interspersed repeat
      DNA/MER2_type = the class of the repeat, in this case a DNA transposon
      fossil of the MER2 group (see below for list and references)
      (0)      = no. of bases in (complement of) the repeat consensus sequence
      prior to beginning of the match (0 means that the match extended
      all the way to the end of the repeat consensus sequence)
      337      = starting position of match in repeat consensus sequence
      104      = ending position of match in repeat consensus sequence
      20       = unique identifier for individual insertions

     * OWN RESULT: 
     * 1286 31.30 3.62 3.32 comp214244_c0_seq2 2820 3840 (0) C Copia-64_VV-I#LTR/Copia (150) 3893 2870 5
     * 195 4.17 0.00 0.00 comp218496_c0_seq4 1520 1543 (0) (TAG)n#Simple_repeat 2 25 (155) 0
     * 189 0.00 0.00 0.00 comp220078_c0_seq4 3 23 (4326) C (GAAA)n#Simple_repeat (1) 179 159 0
     * 216 0.00 0.00 0.00 comp224705_c0_seq18 1 24 (1188) (GAAA)n#Simple_repeat 1 24 (156) 0
     * 23 52.17 0.00 0.00 comp231081_c0_seq1 413 435 (1679) C AT_rich#Low_complexity (135) 165 143 5
     * 21 75.00 0.00 0.00 comp231081_c0_seq1 416 443 (1671) AT_rich#Low_complexity 121 148 (152) 5
     * 198 19.23 0.00 0.00 comp231081_c0_seq1 1780 1831 (283) C (A)n#Simple_repeat (0) 180 129 5
     * 245 23.19 2.33 4.76 comp231081_c0_seq1 229 314 (1800) (GGAGA)n#Simple_repeat 5 88 (92) 5
     * this is parsed weirdly. "AT_rich#Low_complexity"  should be "AT_rich Low_complexity"

     * feature:
     *  name: comp214244_c0_seq2_???
     * featureloc
     *  feature: comp214244_c0_seq2_???
     *  srcfeature: comp214244_c0_seq2
     *  fmin: start
     *  fmax: end
     *  strand: ??always sorted?? 1
     */
    global $db;

    /* $regex = '{ ^\d+ [ ] \d+\.\d+ [ ] \d+\.\d+ [ ] \d+\.\d+ [ ] (?<name>\w+) [ ] (?<start>\d+) [ ] (?<end>\d+) [ ] \(\d+\) (?:[ ] [C+])? [ ] 
      (?<stuff>[\w\/()_\-\#]+(?:[ ] \d* [ ] \d*)?) [ ] \(\d+\) [ ] (?<stuff2>(?:\d+ [ ]){0,2}\d+) $}x'; */
    $regex = <<<EOF
{^ 
\d+[ ]
# 1320     = Smith-Waterman score of the match, usually complexity adjusted
\d+\.\d+[ ]
# 15.6     = % divergence = mismatches/(matches+mismatches) **
\d+\.\d+[ ]
# 6.2      = % of bases opposite a gap in the query sequence (deleted bp)
\d+\.\d+[ ]
# 0.0      = % of bases opposite a gap in the repeat consensus (inserted bp)
(?<name>\w+)[ ]
# HSU08988 = name of query sequence
(?<start>\d+)[ ]
# 6563     = starting position of match in query sequence
(?<end>\d+)[ ]
# 6781     = ending position of match in query sequence
\(\d+\)[ ]
# (22462)  = no. of bases in query sequence past the ending position of match
(?:[C+][ ])?
# C        = match is with the Complement of the repeat consensus sequence
(?<repeat_name>[\w()-]+)\#
# MER7A    = name of the matching interspersed repeat
(?<repeat_class>[\w()-]+)
(?:/(?<repeat_family>[\w()-]+))?[ ]
# DNA/MER2_type = the class of the repeat, in this case a DNA transposon fossil of the MER2 group (see below for list and references)
\(?\d+\)?[ ]
# (0)      = no. of bases in (complement of) the repeat consensus sequence prior to beginning of the match (0 means that the match extended all the way to the end of the repeat consensus sequence)
\(?\d+\)?[ ]
# 337      = starting position of match in repeat consensus sequence
\(?\d+\)?[ ]
# 104      = ending position of match in repeat consensus sequence
\d+
# 20       = unique identifier for individual insertions    
$}x
EOF;

    /*
     * fields to DB: name, start, end, repeat_name, repeat_class, repeat_family
     */

    try {
        $db->beginTransaction();
        #shared parameters
        $param_name = null;
        $param_uniquename = null;
        $param_cvterm = null;
        $param_value = null;

        $statement_insert_domain = $db->prepare('INSERT INTO feature (name, uniquename, type_id, organism_id) VALUES (:name, :uniquename, :type_id, :organism_id)');
        $statement_insert_domain->bindValue('type_id', CV_ANNOTATION_REPEATMASKER, PDO::PARAM_INT);
        $statement_insert_domain->bindValue('organism_id', DB_ORGANISM_ID, PDO::PARAM_INT);
        $statement_insert_domain->bindParam('name', &$param_name, PDO::PARAM_STR);
        $statement_insert_domain->bindParam('uniquename', &$param_uniquename, PDO::PARAM_STR);

        $statement_annotate_domain = $db->prepare('INSERT INTO featureprop (feature_id, type_id, value) VALUES (currval(\'feature_feature_id_seq\'), :cvterm, :value)');
        $statement_annotate_domain->bindParam('cvterm', &$param_cvterm, PDO::PARAM_INT);
        $statement_annotate_domain->bindParam('value', &$param_value, PDO::PARAM_STR);

        $file = fopen($filename);
        while (($line = trim(fgets($file))) != false) {
            $matches = null;
            if (preg_match($regex, $line, &$matches)) {
                for ($i = 0; $i < count($matches['name']); $i++) {
                    $param_name = sprintf("%s(%s-%s):%s#%s(%s)"
                            , $matches['name'][$i]
                            , $matches['start'][$i]
                            , $matches['end'][$i]
                            , $matches['repeat_name'][$i]
                            , $matches['repeat_class'][$i]
                            , $matches['repeat_family'][$i]
                    );
                    $param_uniquename = ASSEMBLY_PREFIX . $param_name;

                    $statement_insert_domain->execute();

                    $param_cvterm = CV_REPEAT_NAME;
                    $param_value = $matches['repeat_name'][$i];
                    $statement_annotate_domain->execute();

                    $param_cvterm = CV_REPEAT_CLASS;
                    $param_value = $matches['repeat_class'][$i];
                    $statement_annotate_domain->execute();

                    if (!empty($matches['repeat_family'][$i])) {
                        $param_cvterm = CV_REPEAT_FAMILY;
                        $param_value = $matches['repeat_family'][$i];
                        $statement_annotate_domain->execute();
                    }
                }
            } else {
                echo "WARNING: Line does not match:\n\t$line\n";
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

?>
