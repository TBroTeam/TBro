<?php
    if (strpos(ini_get('include_path'), '${share_path}')===FALSE){
        ini_set('include_path', ini_get('include_path').';${share_path}');
    }
    require_once '${config_dir}/config.php';
    require_once '${config_dir}/cvterms.php';
    
    define('VAR_DIR', '${var_path}');
?>
