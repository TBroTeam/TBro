<?php

namespace webservices\listing\wordcloud;

use \PDO as PDO;

/**
 * Web Service.
 * returns GO annotations for the given features
 */
class Gos extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $constant = 'constant';

        $parents = $querydata['parents'];

        $qmarks = implode(',', array_fill(0, count($parents), '?'));


#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT 
  cvterm.name AS go, cv.name AS cv, dbxref.accession
FROM 
  public.feature_dbxref, 
  public.dbxref, 
  public.db, 
  public.cv, 
  public.cvterm
WHERE 
  feature_dbxref.dbxref_id = dbxref.dbxref_id AND
  dbxref.db_id = db.db_id AND
  cvterm.dbxref_id = dbxref.dbxref_id AND
  cvterm.cv_id = cv.cv_id AND
  db.name = 'GO' AND 
  feature_dbxref.feature_id IN ($qmarks);

EOF;

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute($parents);
        while ($go = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            if (!isset($data['results'][$go['cv']]))
                $data['results'][$go['cv']] = array();
            if (!isset($data['results'][$go['cv']][$go['go']]))
                $data['results'][$go['cv']][$go['go']] = array('count'=>0, 'accession'=>$go['accession']);
            $data['results'][$go['cv']][$go['go']]['count']++;
        }

        return $data;
    }

}

?>
