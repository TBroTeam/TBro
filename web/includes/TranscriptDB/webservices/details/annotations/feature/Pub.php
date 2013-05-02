<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

class Pub extends \WebService {

    public function getById($param_feature_id) {


        global $db;
#UI hint
        if (false)
            $db = new PDO();

        $query_get_feature_pubs = <<<EOF
SELECT 
	p.*,
	array_to_string((SELECT array_agg(Surname||', '||Givennames) FROM PubAuthor pa WHERE pa.pub_id = p.pub_id ),' and ') as author
FROM
	Feature_Pub f
	INNER JOIN Pub p ON (f.pub_id = p.pub_id)
WHERE
	f.feature_id = :feature_id;
EOF;

        $stm_get_feature_pubs = $db->prepare($query_get_feature_pubs);
        $stm_get_feature_pubs->bindParam('feature_id', $param_feature_id);

        $ret = array();

        $stm_get_feature_pubs->execute();
        while ($pub = $stm_get_feature_pubs->fetch(PDO::FETCH_ASSOC)) {
                $ret[$pub['pub_id']] = $pub;
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}
?>
