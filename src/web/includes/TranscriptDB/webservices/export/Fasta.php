<?php

namespace webservices\export;

require_once 'TranscriptDB//db.php';

/**
 * Web Service.
 * Get fasta sequences of all passed feature_ids. Takes either one url parameter or an array as POST variable "terms"
 */
class Fasta extends \WebService {

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
        header("Content-Disposition: attachment; filename=\"sequences.fasta\";");
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

        $query = <<<EOF
    SELECT
    feature.name, feature.residues
    FROM feature       
    WHERE feature.feature_id IN ($place_holders)
EOF;

        $stm = $db->prepare($query);
        $stm->execute($feature_ids);
        while ($row = $stm->fetch(\PDO::FETCH_ASSOC)) {
            printf(">%s\n%s\n", $row['name'], $row['residues']);
        }
        die();
    }

}

?>
