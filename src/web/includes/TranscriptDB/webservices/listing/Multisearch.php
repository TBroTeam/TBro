<?php

namespace webservices\listing;

use \PDO as PDO;

/**
 * Web Service.
 * Splits $querydata['longterm'] into words and searches for matching features and their associated features
 */
class Multisearch extends \WebService {

    /**
     * @inheritDoc
     */
    public function execute($querydata) {
        global $db;
        $species = intval($querydata['species']);
        $import = $querydata['release'];
        $longterm = $querydata['longterm'];
        $terms = preg_split('/[,\s]+/m', $longterm, -1, PREG_SPLIT_NO_EMPTY);
        foreach ($terms as &$term) {
            $term = trim($term, "'\"");
        }
        $qmarks = implode(',', array_fill(0, count($terms), '?'));
        $values = array_merge(array($species, $import), $terms);

#UI hint
        if (false)
            $db = new PDO();

        $query_get_features = <<<EOF
SELECT * FROM multisearch(?, ?, ARRAY[$qmarks]::varchar[])
EOF;

        if (isset($querydata['strict']) && $querydata['strict'] === 'true') {

            $query_get_features = <<<EOF
SELECT * FROM multisearch_strict(?, ?, ARRAY[$qmarks]::varchar[])
EOF;
        }

        $stm_get_features = $db->prepare($query_get_features);

        $data = array('results' => array());

        $stm_get_features->execute($values);
        
        $metadata = array();
        if (!isset($_SESSION))
            session_start();
        if (isset($_SESSION['cart']) && $_SESSION['cart']['metadata'][$querydata['currentContext']])
            $metadata = $_SESSION['cart']['metadata'][$querydata['currentContext']];
        
        while ($feature = $stm_get_features->fetch(PDO::FETCH_ASSOC)) {
            // add user annotations
            $user_alias = '';
            $user_annotations = '';
            if (array_key_exists($feature['feature_id'], $metadata)) {
                if (array_key_exists('alias', $metadata[$feature['feature_id']]))
                    $user_alias = $metadata[$feature['feature_id']]['alias'];
                if (array_key_exists('annotations', $metadata[$feature['feature_id']]))
                    $user_annotations = $metadata[$feature['feature_id']]['annotations'];
            }
            // if description is null: set to empty string
            if (is_null($feature['description']))
                $feature['description'] = '';
            $data['results'][$feature['feature_id']] = array(
                'name' => $feature['feature_name']
                , 'type' => $feature['type_id'] == CV_UNIGENE ? 'unigene' : (CV_ISOFORM ? 'isoform' : 'unknonwn')
                , 'feature_id' => $feature['feature_id']
                , 'alias' => $feature['synonym_name']
                , 'description' => $feature['description']
                    , 'user_alias' => $user_alias
                    , 'user_annotations' => $user_annotations
            );
        }

        return $data;
    }

}
?>


