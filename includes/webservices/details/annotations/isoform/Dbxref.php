<?php

namespace webservices\details\annotations\isoform;

use \PDO as PDO;

class Dbxref extends \WebService {

    public function getById($param_isoform_id) {


        global $_CONST, $db;
#UI hint
        if (false)
            $db = new PDO();

        $query_get_isoform_dbxrefs = <<<EOF
SELECT
  db.name AS dbname, dbxref.accession, dbxref.version AS dbversion, dbxref.description AS description, cv.name AS namespace
FROM
  feature_dbxref
  JOIN dbxref ON (dbxref.dbxref_id = feature_dbxref.dbxref_id)
  JOIN db ON (db.db_id = dbxref.db_id)  
  LEFT JOIN cvterm_dbxref ON (dbxref.dbxref_id = cvterm_dbxref.dbxref_id)
  LEFT JOIN cvterm ON (cvterm.cvterm_id = cvterm_dbxref.cvterm_id)
  LEFT JOIN cv ON (cvterm.cv_id=cv.cv_id)
WHERE
  feature_dbxref.feature_id = :isoform_id
EOF;

        $stm_get_isoform_dbxrefs = $db->prepare($query_get_isoform_dbxrefs);
        $stm_get_isoform_dbxrefs->bindParam('isoform_id', $param_isoform_id);

        $ret = array();

        $stm_get_isoform_dbxrefs->execute();
        while ($isoform_dbxref = $stm_get_isoform_dbxrefs->fetch(PDO::FETCH_ASSOC)) {
            $ret[] = $isoform_dbxref;
        }

        return $ret;
    }

    public function execute($querydata) {

        return $this->getById($querydata['query1']);
    }

}
/*
 * select count(cvterm_dbxref.cvterm_id) as cnt, cvterm.cvterm_id, name from cvterm_dbxref, cvterm where cvterm.cvterm_id=cvterm_dbxref.cvterm_id group by cvterm.cvterm_id order by cnt desc;
 */

/*
 SELECT 
  dbxref.db_id,
  dbxref.accession, 
  cvterm.name,
  par1.name,
  par2.name
FROM 
  public.dbxref, 
  public.cvterm_dbxref, 
  public.cvterm
  RIGHT JOIN cvterm_relationship rel1 ON (cvterm.cvterm_id = rel1.object_id)
  LEFT JOIN public.cvterm par1 ON (rel1.subject_id = par1.cvterm_id)
  RIGHT JOIN cvterm_relationship rel2 ON (par1.cvterm_id = rel2.object_id)
  LEFT JOIN public.cvterm par2 ON (rel2.subject_id = par2.cvterm_id)
  RIGHT JOIN cvterm_relationship rel3 ON (par2.cvterm_id = rel3.object_id)
  LEFT JOIN public.cvterm par3 ON (rel3.subject_id = par3.cvterm_id)
WHERE 
  dbxref.dbxref_id = cvterm_dbxref.dbxref_id AND
  cvterm.cvterm_id = cvterm_dbxref.cvterm_id AND
  accession='0048748' AND
  dbxref.db_id = 79;
 */
?>
