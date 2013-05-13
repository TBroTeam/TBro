<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

class Synonym extends \WebService {

    public function getById($param_feature_id) {


        global $db;
#UI hint
        if (false)
            $db = new PDO();

                $stm_get_synonyms = $db->prepare(<<<EOF
SELECT 
        synonym.synonym_id,
        synonym.name AS synonym_name, 
        cvterm.name AS synonym_type,
        pub.*,
        array_to_string((SELECT array_agg(Surname||', '||Givennames) FROM PubAuthor pa WHERE pa.pub_id = pub.pub_id ),' and ') as author
        
FROM feature_synonym 
        JOIN pub ON (feature_synonym.pub_id = pub.pub_id)
	JOIN synonym ON (feature_synonym.synonym_id = synonym.synonym_id) 
	JOIN cvterm ON (synonym.type_id = cvterm.cvterm_id)
WHERE feature_synonym.feature_id =  :feature_id
EOF
                );
        $stm_get_synonyms->bindValue('feature_id', $param_feature_id);
        
        
    
        $ret = array();

        $stm_get_synonyms->execute();
        while ($synonym = $stm_get_synonyms->fetch(PDO::FETCH_ASSOC)) {
                $ret[$synonym['synonym_id']] = $synonym;
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}
?>
