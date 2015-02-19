<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Filters for Expression (full Release)
 */
class Filters_expression extends \WebService {

    /**
     * @inheritDoc
     * returns array(
     *   'data' => array(
     *     'feature' => array(id=>metadata,....),
     *     'assay' => array(id=>metadata,....)
     *     'analysis' => array(id=>metadata,....)
     *     'parent_biomaterial' => array(id=>metadata,....)
     *     'sample' => array(id=>metadata,....)
     *   ),
     *   'values' => array(
     *     array( combination of feature,assay,analysis,sample ids ),...
     *   )
     * )
     */
    public function execute($querydata) {
        global $db;

#UI hint
        if (false)
            $db = new PDO();

        $organism = $querydata['organism'];
        $release = $querydata['release'];
        $constant = 'constant';

        $query_get_filters = <<<EOF
SELECT analysis.analysis_id, analysis.name AS analysis_name, analysis.description AS analysis_description, analysis.program AS analysis_program, analysis.programversion AS analysis_programversion, analysis.algorithm AS analysis_algorithm,
  assay.assay_id, assay.name AS assay_name, assay.description AS assay_description,
  acquisition.name AS acquisition_name, acquisition.acquisition_id,
  quantification.name AS quantification_name, quantification.quantification_id,
  biomaterial.biomaterial_id, biomaterial.name AS biomaterial_name, biomaterial.description AS biomaterial_description, parent_biomaterial.biomaterial_id AS biomaterial_parent_id,
  parent_biomaterial.biomaterial_id AS parent_biomaterial_id, parent_biomaterial.name AS parent_biomaterial_name, parent_biomaterial.description AS parent_biomaterial_description 
 FROM
(   SELECT *
        FROM 
            materialized_view_expression_filter
        WHERE 
            organism_id=? 
            AND dbxref_id=(SELECT dbxref_id FROM dbxref WHERE db_id = {$constant('DB_ID_IMPORTS')}  AND accession = ?)
)   AS map
        JOIN biomaterial ON (map.biomaterial_id=biomaterial.biomaterial_id)
        JOIN biomaterial parent_biomaterial ON (map.parent_biomaterial_id=parent_biomaterial.biomaterial_id)
	JOIN analysis ON (map.analysis_id=analysis.analysis_id)
	JOIN quantification ON (map.quantification_id=quantification.quantification_id)
	JOIN acquisition ON (quantification.acquisition_id = acquisition.acquisition_id)
	JOIN assay ON (acquisition.assay_id=assay.assay_id)

EOF;

        $stm_get_filters = $db->prepare($query_get_filters);

        $data = array();

        $stm_get_filters->execute(array($organism, $release));
        while ($filter = $stm_get_filters->fetch(PDO::FETCH_ASSOC)) {

            $data['data']['assay'][$filter['assay_id']] = self::getItem('assay', $filter);
            $data['data']['analysis'][$filter['analysis_id']] = self::getItem('analysis', $filter);
            $data['data']['acquisition'][$filter['acquisition_id']] = self::getItem('acquisition', $filter);
            $data['data']['quantification'][$filter['quantification_id']] = self::getItem('quantification', $filter);
            $data['data']['parent_biomaterial'][$filter['parent_biomaterial_id']] = self::getItem('parent_biomaterial', $filter);
            $data['data']['sample'][$filter['biomaterial_id']] = self::getItem('biomaterial', $filter);

            $data['values'][] = array(
                'assay' => $filter['assay_id'],
                'analysis' => $filter['analysis_id'],
                'acquisition' => $filter['acquisition_id'],
                'quantification' => $filter['quantification_id'],
                'parent_biomaterial' => $filter['parent_biomaterial_id'],
                'sample' => $filter['biomaterial_id'],
            );
        }

        return $data;
    }

    /**
     * returns an Array of all $row values whose key begins with $item_prefix (removing prefix)
     * @param String $item_prefix
     * @param Array $row
     * @return Array item
     */
    private static function getItem($item_prefix, $row) {
        $item = array();
        foreach ($row as $key => $val) {
            $match = null;
            if (preg_match("/^${item_prefix}_(.*)/", $key, $match)) {
                $item[$match[1]] = $val;
            }
        }
        return $item;
    }

}

?>
