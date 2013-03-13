<?php

class Quantifications extends WebService {

    public function execute($data) {
        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();


        $parents = $_REQUEST['parents'];


        $query = <<<EOF
SELECT 
  parent_biomaterial.name AS parent_biomaterial_name, 
  feature_relationship.type_id, 
  parent_feature.name AS parent_feature_name, 
  feature.name AS feature_name, 
  biomaterial.name AS biomaterial_name, 
  quantificationresult.value, 
  quantificationresult.type_id
FROM 
  public.quantificationresult, 
  public.biomaterial, 
  public.biomaterial_relationship, 
  public.biomaterial parent_biomaterial, 
  public.feature, 
  public.feature parent_feature, 
  public.feature_relationship, 
  public.quantification
WHERE 
  biomaterial.biomaterial_id = biomaterial_relationship.subject_id AND
  biomaterial.biomaterial_id = quantificationresult.biomaterial_id AND
  biomaterial_relationship.object_id = parent_biomaterial.biomaterial_id AND
  feature.feature_id = quantificationresult.feature_id AND
  feature.feature_id = feature_relationship.subject_id AND
  feature_relationship.object_id = parent_feature.feature_id AND
  quantification.quantification_id = quantificationresult.quantification_id AND
  biomaterial_relationship.type_id = {$_CONST('CV_BIOMATERIAL_ISA')} AND 
  feature_relationship.type_id = {$_CONST('CV_RELATIONSHIP_UNIGENE_ISOFORM')} AND
  parent_feature.uniquename IN (%s)
 ORDER BY feature_name, biomaterial_name;

EOF;
        $in_clause = '';
        for ($i = 0; $i < count($parents); $i++)
            $in_clause .= $i == 0 ? '?' : ',?';

        $stm = $db->prepare(sprintf($query, $in_clause));
        $stm->execute($parents);

        $lastcell_name = '';
        $data = array();
        $vars = array();
        $smps = array();
        $tree_vars = array();
        $tree_smps = array();
        $row = null;
        while (($cell = $stm->fetch(PDO::FETCH_ASSOC)) !== false) {
            if ($cell['feature_name'] != $lastcell_name) {
                #featue-specific actions, only once per featue
                $lastcell_name = $cell['feature_name'];
                $data[] = array();
                $row = &$data[count($data) - 1];
                $vars[] = $cell['feature_name'];
                #build feature-dendrogram
                if (!isset($tree_vars[$cell['parent_feature_name']]))
                    $tree_vars[$cell['parent_feature_name']] = array();
                $tree_vars[$cell['parent_feature_name']][] = $cell['feature_name'];
            }

            if (count($data) == 1) {
                #sample-specific actions, only executed for first var
                $smps[] = $cell['biomaterial_name'];
                #build sample-dendrogram
                if (!isset($tree_smps[$cell['parent_biomaterial_name']]))
                    $tree_smps[$cell['parent_biomaterial_name']] = array();
                $tree_smps[$cell['parent_biomaterial_name']][] = $cell['biomaterial_name'];
            }

            $row[] = floatval($cell['value']);
        }
        $t = array('vars' => '', 'smps' => '');

        foreach (array('vars' => &$tree_vars, 'smps' => &$tree_smps) as $key => $tree) {
            foreach ($tree as $children) {
                $substr = "";
                foreach ($children as $child) {
                    $substr .= (empty($substr) ? '' : ',') . $child;
                }
                $t[$key] .=(empty($t[$key]) ? '' : ',') . "($substr)";
            }
            $t[$key] = '(' . $t[$key] . ')';
        }

        return array(
            'y' => array(
                'vars' => $vars,
                'smps' => $smps,
                'data' => $data
            ),
            't' => $t
        );
    }

}

?>
