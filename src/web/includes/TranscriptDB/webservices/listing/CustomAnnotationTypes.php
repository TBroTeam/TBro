<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * returns a list of all custom annotation types (for any organism/release)
 */
class CustomAnnotationTypes extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $query_get_custom_annotation_types = <<<EOF

SELECT name FROM cvterm
WHERE cv_id = {$constant('CUSTOM_ANNOTATION_TYPE_CV_ID')}

EOF;

        $stm_get_features = $db->prepare($query_get_custom_annotation_types);

        $data = array('results' => array());

        $stm_get_features->execute();
        while ($pw = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            $data['results'][] = $pw['name'];
        }

        return $data;
    }

}

?>