<?

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