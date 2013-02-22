<?

define('ERR_MISSING_PARAMTER', 'missing parameter: %s\n');

function require_parameter($param_names) {
    global $parms;
    foreach ($param_names as $param_name)
        if (!isset($parms[$param_name])) {
            die(sprintf(ERR_MISSING_PARAMTER, $param_name));
        }
}


function init_cli() {
    global $parms;
    $parms = array();
    global $argc;
    global $argv;
    for ($i = 1; $i < $argc; $i++) {
        if (strpos($argv[$i], '--') !== 0)
            continue;
        $param = $argv[$i];
        
        $args = array();
        while (isset($argv[$i + 1]) && strpos($argv[$i+1], '--') !== 0){
            $args[] = $argv[++$i];
        }
        if (count($args)==0){
            $parms[$param] = true;
        } else if (count($args)==1){
            $parms[$param] = $args[0];
        } else {
            $parms[$param] = $args;
        }
    }
}

?>