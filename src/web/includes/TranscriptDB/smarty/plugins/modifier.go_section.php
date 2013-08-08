<?php

function smarty_modifier_go_section($params) {
    if($params == "molecular_function"){
        return "Molecular Function";
    }
    if($params == "biological_process"){
        return "Biological Process";
    }
    if($params == "cellular_component"){
        return "Cellular Component";
    }
    return $params;
}

?>
