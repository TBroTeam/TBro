<?php

function smarty_function_call_webservice($params, &$smarty) {
    require_once INC . '/WebService.php';
    $service = WebService::factory($params['path']);
    if ($service[0] != null) {
        $ret = $service[0]->execute($params['data']);
        $smarty->assign($params['assign'], $ret);
    }
}

?>
