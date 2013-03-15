<?php

function smarty_function_dbxreflink($params, &$smarty) {
    require_once INC . '/db.php';
    global $db_urls, $db;
    if (!isset($db_urls))
        $db_urls = array('GO'=>'http://amigo.geneontology.org/cgi-bin/amigo/term_details?term=GO:');

    if (!isset($db_urls[$params['dbxref']['dbname']])) {
        $stm = $db->prepare('SELECT urlprefix FROM db WHERE name=:dbname');
        $stm->bindValue('dbname', $params['dbxref']['dbname']);
        $stm->execute();
        if (($row = $stm->fetch(PDO::FETCH_ASSOC)) != false) {
            $db_urls[$params['dbxref']['dbname']] = $row['urlprefix'];
        }
        else
            $db_urls[$params['dbxref']['dbname']] = '';
    }
    $description = sprintf('<span data-tooltip class="has-tip" title="DB Version: %3$s">%1$s:%2$s%4$s</span>', $params['dbxref']['dbname'], $params['dbxref']['accession'],
            !empty($params['dbxref']['dbversion']) ? $params['dbxref']['dbversion'] : 'unknown', !empty($params['dbxref']['description']) ? ' (' . $params['dbxref']['description'] . ')' : '');
    
    
    if ($db_urls[$params['dbxref']['dbname']] == '') {
        return $description;
    }
    else {
        return sprintf('<a href="%1$s%2$s" target="_blank">%3$s</a>', $db_urls[$params['dbxref']['dbname']], $params['dbxref']['accession'], $description);
    }
}

?>
