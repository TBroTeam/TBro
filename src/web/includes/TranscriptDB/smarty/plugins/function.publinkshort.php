<?php

function smarty_function_publinkshort($params, &$smarty) {
    
    $pub = $params['pub'];
    return sprintf('<td class="has-tooltip" data-title="Title|%2$s" data-author="Author|%1$s" data-journal="Journal|%4$s" style="text-align:right;"><a href="%3$s" target="_blank">at bibsonomy</a></td>',
            $pub['author'],
            $pub['title'],
            $pub['miniref'],
            $pub['volumetitle']
            );  
}

?>
