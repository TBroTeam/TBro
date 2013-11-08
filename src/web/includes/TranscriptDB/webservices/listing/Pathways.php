<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * returns Pathways for the given features
 */
class Pathways extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;

        $parents = $querydata['parents'];

        $qmarks = implode(',', array_fill(0, count($parents), '?'));


#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT
  dbx.feature_id, dbx.comp_acc, dbx.comp_def, dbxref.accession AS pw_acc, cvterm.definition AS pw_def, feature.name
FROM
  cvterm_relationship,
  cvterm,
  dbxref,
  feature,
	(SELECT 
	  feature_id, dbxref.accession AS comp_acc, cvterm.definition AS comp_def, cvterm_id
	FROM 
	  public.feature_dbxref, 
	  public.dbxref, 
	  public.db, 
	  public.cvterm
	WHERE 
	  feature_dbxref.dbxref_id = dbxref.dbxref_id AND
	  dbxref.db_id = db.db_id AND
	  cvterm.dbxref_id = dbxref.dbxref_id AND
	  db.name = 'EC' AND 
	  feature_dbxref.feature_id IN ($qmarks)) AS dbx
WHERE
  cvterm_relationship.object_id = dbx.cvterm_id AND
  cvterm.cvterm_id = cvterm_relationship.subject_id AND
  dbxref.dbxref_id = cvterm.dbxref_id AND
  feature.feature_id = dbx.feature_id

EOF;

        $stm_get_features = $db->prepare($query_get_features);

        # The result should be like that:
        # results -> array(
        #   pathways -> array( 
        #       acc_x -> array(
        #           definition -> ''
        #           comps -> array(
        #               comp_x -> 1     # keys in the components sub_array (split because of redundance)
        #               ...
        #           )
        #       )
        #       ...
        #   )
        #   components -> array(
        #       comp_x -> array(
        #           definition -> ''
        #           features -> array(
        #               feature_x -> 1
        #               ...
        #           )
        #       )
        #       ...
        #    )
        # )
        $data = array('results' => array('pathways' => array(), 'components' => array()));

        $stm_get_features->execute($parents);
        while ($pw = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($data['results']['pathways'][$pw['pw_acc']]))
                $data['results']['pathways'][$pw['pw_acc']] = array('definition' => $pw['pw_def'], 'comps' => array());
            $data['results']['pathways'][$pw['pw_acc']]['comps'][$pw['comp_acc']] = 1;
            if (!isset($data['results']['components'][$pw['comp_acc']]))
                $data['results']['components'][$pw['comp_acc']] = array('definition'=>$pw['comp_def'], 'features'=>array());
            $data['results']['components'][$pw['comp_acc']]['features'][$pw['feature_id']] = $pw['name'];
        }

        return $data;
    }

}

?>
