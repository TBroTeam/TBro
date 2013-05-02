<?php

//TODO: http://jqueryui.com/tooltip/#custom-content
function smarty_function_publink($params, &$smarty) {
    
    $pub = $params['pub'];
    return sprintf('<tr class="has-tooltip" data-title="Title|%2$s" data-author="Author|%1$s" data-journal="Journal|%4$s"><td>%2$s</td><td><a href="%3$s" target="_blank">at bibsonomy</a></td></tr>',
            $pub['author'],
            $pub['title'],
            $pub['miniref'],
            $pub['volumetitle']
            );
    
}

?>
