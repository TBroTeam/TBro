<?php

function smarty_modifier_clean_id($params) {
    return str_replace('.', '_', $params);
}

?>
