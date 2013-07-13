<?php

namespace webservices\details\annotations\feature;

use \PDO as PDO;

/**
 * WebService.
 * get all Repeatmasker annotations for feature id.
 */
class Repeatmasker extends \WebService {

    public function getById($param_feature_id) {


        global $db;
#UI hint
        if (false)
            $db = new PDO();

        /*
         *     get_isoform_annotations_repeatmasker(_isoform_ids integer[])
         * RETURNS
         *   TABLE (isoform_id int, uniquename text, fmin integer, fmax integer, strand smallint, repeat_name text, repeat_family text, repeat_class text)
         */
        $stm_get_repeatmasker = $db->prepare('SELECT * FROM get_isoform_annotations_repeatmasker(ARRAY[:isoform_id::int])');
        $stm_get_repeatmasker->bindParam('isoform_id', $param_feature_id, PDO::PARAM_INT);

        $ret = array();

        $stm_get_repeatmasker->execute();
        while ($repeatmasker = $stm_get_repeatmasker->fetch(PDO::FETCH_ASSOC)) {
            $ret[] = $repeatmasker;
        }

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
