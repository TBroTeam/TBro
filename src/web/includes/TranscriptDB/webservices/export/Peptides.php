<?php

namespace webservices\export;

require_once 'TranscriptDB//db.php';

/**
 * Web Service.
 * Get fasta sequences of all predicted peptides of passed feature_ids. Takes either one url parameter or an array as POST variable "terms"
 */
class Peptides extends \WebService {

    /**
     * @inheritDoc
     * @param int $querydata['query1'] one id
     * @param Array[int] $querydata['terms'] multiple ids
     */
    public function execute($querydata) {
        header("Pragma: public");
        header("Expires: 0");
        header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
        header("Cache-Control: private", false);
        header("Content-Type: application/octet-stream");
        $cartname = "sequences";
        if (isset($querydata['cartname']))
            $cartname = $querydata['cartname'];
        header(sprintf("Content-Disposition: attachment; filename=\"%s_peptides.fasta\";", $cartname));
        header("Content-Transfer-Encoding: binary");

        $feature_ids = array();

        if (isset($querydata['query1']) && !empty($querydata['query1']))
            $feature_ids[] = $querydata['query1'];

        if (isset($querydata['terms']))
            $feature_ids = array_merge($feature_ids, $querydata['terms']);

        if (count($feature_ids) == 0) {
            die();
        }

        $place_holders = implode(',', array_fill(0, count($feature_ids), '?'));

        global $db;
        $constant = 'constant';

        $query = <<<EOF
SELECT 
    feature.name AS pepid, floc.name AS seqid, floc.fmin, floc.fmax, floc.strand, feature.residues FROM feature,
	(SELECT fl.fmin, fl.fmax, fl.strand, fl.feature_id, f.name
            FROM featureloc AS fl, 
                (SELECT feature_id, name 
                    FROM feature 
                    WHERE feature_id IN ($place_holders)
                ) AS f
            WHERE fl.srcfeature_id IN ($place_holders) 
            AND fl.srcfeature_id=f.feature_id
        ) AS floc
    WHERE feature.feature_id=floc.feature_id 
    AND feature.type_id={$constant('CV_PREDPEP')} 
EOF;

        $stm = $db->prepare($query);
        $stm->execute(array_merge($feature_ids, $feature_ids));
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            printf(">%s REF=%s START=%s END=%s STRAND=%s\n%s\n", $row['pepid'], $row['seqid'], $row['fmin'], $row['fmax'], $row['strand'], $row['residues']);
        }
        die();
    }

}

?>
