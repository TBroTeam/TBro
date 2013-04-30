<?php

function smarty_function_interprolink($params, &$smarty) {
    return sprintf('<a href="http://www.ebi.ac.uk/interpro/entry/%1$s">%1$s</a>', $params['id']);
}

?>
