<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

/**
 * Web Service.
 * Returns Predpep details and all Interpro Annotations for requested isoform feature.
 */
class Interpro_predpeps extends \WebService {

    /**
     * return array by feature id
     * @global \PDO $db
     * @param int $param_feature_id
     * @return Array
     */
    public function getById($param_feature_id) {
        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $constant = 'constant';
        $param_predpep_id = null;

        //predpep details
        $query_get_predpeps = <<<EOF
SELECT predpep.*, featureloc.* 
    FROM feature AS predpep, featureloc 
    WHERE featureloc.feature_id=predpep.feature_id 
        AND featureloc.srcfeature_id=:isoform_id
        AND predpep.type_id = {$constant('CV_PREDPEP')}
EOF;

        $stm_get_predpeps = $db->prepare($query_get_predpeps);
        $stm_get_predpeps->bindParam('isoform_id', $param_feature_id);
        /**
         * get_predpep_annotations_interpro RETURNS
         *   TABLE (predpep_id int, feature_id int, uniquename text, fmin int, fmax int, strand smallint, interpro_ID text, evalue double precision, analysis_name character varying(255), program  character varying(255), programversion  character varying(255), sourcename  character varying(255), analysis_match_id text, analysis_match_description text)
         */
        $stm_get_interpro = $db->prepare('SELECT * FROM get_predpep_annotations_interpro(ARRAY[:predpep_id::int])');
        $stm_get_interpro->bindParam('predpep_id', $param_predpep_id);

        //all interpro dbxrefs, including description and cv
        $query_get_interpro_dbxrefs = <<<EOF
SELECT 
  DISTINCT ON (cvterm.dbxref_id, cv.cv_id)
  db.name AS dbname, dbxref.accession, dbxref.version AS dbversion, cvterm.name AS name, cvterm.definition AS definition, cv.name AS go_namespace 
FROM 
  feature_dbxref
  JOIN dbxref ON (dbxref.dbxref_id = feature_dbxref.dbxref_id)
  JOIN db ON (db.db_id = dbxref.db_id)
  LEFT JOIN cvterm ON (cvterm.dbxref_id = dbxref.dbxref_id)
  LEFT JOIN cv ON (cv.cv_id = cvterm.cv_id)
WHERE 
  feature_dbxref.feature_id = :interpro_feature_id                
EOF;

        $stm_get_interpro_dbxref = $db->prepare($query_get_interpro_dbxrefs);
        $stm_get_interpro_dbxref->bindParam('interpro_feature_id', $param_interpro_feature_id);

        $ret = array();

        // build return array structure
        $stm_get_predpeps->execute();
        //for each predpep
        while ($predpep = $stm_get_predpeps->fetch(PDO::FETCH_ASSOC)) {
            $ret[] = $predpep;
            //$current points to the last entry in the $ret array
            $current = &$ret[count($ret) - 1];

            $param_predpep_id = $predpep['feature_id'];
            //get interpro annotations
            $stm_get_interpro->execute();
            while ($interpro = $stm_get_interpro->fetch(PDO::FETCH_ASSOC)) {
                //accumulate these in the array $ret[last]['interpro']
                $current['interpro'][] = $interpro;
                //curr_interpro points to the currently added interpro entry
                $curr_interpro = &$current['interpro'][count($current['interpro']) - 1];
                $param_interpro_feature_id = $interpro['feature_id'];
                // for each interpro annotation get all dbxrefs
                $stm_get_interpro_dbxref->execute();
                while ($interpro_dbxref = $stm_get_interpro_dbxref->fetch(PDO::FETCH_ASSOC)) {
                    // and accumulate them in $ret[last]['interpro'][last]['dbxref'][]
                    $curr_interpro['dbxref'][] = $interpro_dbxref;
                }
            }
        }
//$ret may look like
//[
//    {
//        "feature_id": 921323,
//        "dbxref_id": 97321,
//        "organism_id": 13,
//        "name": "m.3284207",
//        "uniquename": "test_comp231081_c0_seq1:1544-510",
//        "residues": "MAAMNKYSTQLVLLALIIFAMGLFAAKVSSSRLLNSDVSMKERHEQWMKEYGRVYEDTAEKERRFNIFKINVERIESMNKLNRSFTLGVNAFTDLTLEEFRASHNGYKQRPVGSLKATSFKYENFTSVPNLINWVTNGAVTPVKDQGQCGCCWAFSAVASTEGIHSINTKKLVSLSEQQVLDCDTNGQDQGCNGGMPQGAFEYMISNGGLTTEDAYPYTGSQGWWCNLWFDAIAAKISNYENVPSDEGSLQKAVANQPCSVAIDASCDDFMQYSGGVFSESCGDNLDHAVTAVGYGTTDDGTDYWLVKNSWGTSWGENGYIRMQRNVGGNGMCGIATDASYPTM*",
//        "seqlen": 345,
//        "md5checksum": null,
//        "type_id": 219,
//        "is_analysis": false,
//        "is_obsolete": false,
//        "timeaccessioned": "2013-06-10 20:29:09.73871",
//        "timelastmodified": "2013-06-10 20:29:09.73871",
//        "featureloc_id": 295019,
//        "srcfeature_id": 456227,
//        "fmin": 510,
//        "is_fmin_partial": false,
//        "fmax": 1544,
//        "is_fmax_partial": false,
//        "strand": -1,
//        "phase": null,
//        "residue_info": null,
//        "locgroup": 0,
//        "rank": 0,
//        "interpro": [
//            {
//                "predpep_id": 921323,
//                "feature_id": 1815524,
//                "uniquename": "test_comp231081_c0_seq1:1544-510_SSF54001_33_344",
//                "fmin": 33,
//                "fmax": 344,
//                "strand": 1,
//                "interpro_id": null,
//                "evalue": "2.2e-106",
//                "analysis_name": "Interpro Analysis",
//                "program": "Interpro",
//                "programversion": "unknown",
//                "sourcename": "superfamily",
//                "analysis_match_id": "SSF54001",
//                "analysis_match_description": "Cysteine proteinases"
//            },
//            {
//                "predpep_id": 921323,
//                "feature_id": 1815640,
//                "uniquename": "test_comp231081_c0_seq1:1544-510_PF00112_128_343",
//                "fmin": 128,
//                "fmax": 343,
//                "strand": 1,
//                "interpro_id": "IPR000668",
//                "evalue": "3.1e-075",
//                "analysis_name": "Interpro Analysis",
//                "program": "Interpro",
//                "programversion": "unknown",
//                "sourcename": "HMMPfam",
//                "analysis_match_id": "PF00112",
//                "analysis_match_description": "Peptidase_C1",
//                "dbxref": [
//                    {
//                        "dbname": "GO",
//                        "accession": "0006508",
//                        "dbversion": "",
//                        "name": "proteolysis",
//                        "definition": "The hydrolysis of proteins into smaller polypeptides and\/or amino acids by cleavage of their peptide bonds.",
//                        "go_namespace": "biological_process"
//                    },
//                    {
//                        "dbname": "GO",
//                        "accession": "0008234",
//                        "dbversion": "",
//                        "name": "cysteine-type peptidase activity",
//                        "definition": "Catalysis of the hydrolysis of peptide bonds in a polypeptide chain by a mechanism in which the sulfhydryl group of a cysteine residue at the active center acts as a nucleophile.",
//                        "go_namespace": "molecular_function"
//                    }
//                ]
//            },
//        ]
//    }
//]
        return $ret;
    }

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        return $this->getById($querydata['query1']);
    }

}

?>
