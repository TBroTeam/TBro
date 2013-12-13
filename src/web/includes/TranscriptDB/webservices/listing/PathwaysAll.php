<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * returns Pathways for the given features
 */
class PathwaysAll extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;


#UI hint
        if (false)
            $db = new PDO();

        $query_get_pathways = <<<EOF

SELECT definition FROM cvterm,
	(SELECT * FROM dbxref WHERE db_id=
		(SELECT db_id FROM db WHERE UPPER(name)='KEGG')
	) AS dbx
WHERE cvterm.dbxref_id = dbx.dbxref_id

EOF;

        $stm_get_features = $db->prepare($query_get_pathways);

        $data = array('results' => array());

        $stm_get_features->execute();
        while ($pw = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $pw['definition'];
        }

        return $data;
    }

}

?>