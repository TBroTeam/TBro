<?php
    if (strpos(get_include_path(), '${share_path}')===FALSE){
        set_include_path(get_include_path().PATH_SEPARATOR.'${share_path}');
    }
    require_once '${config_dir}/config.php';
    require_once '${config_dir}/cvterms.php';
    
    define('VAR_DIR', '${var_path}');
?>
