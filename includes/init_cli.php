<?php

global $cli_options;

// we're using GetOptionKit from https://github.com/c9s/php-GetOptionKit
// install it via
// pear channel-discover pear.corneltek.com
// pear install corneltek/GetOptionKit

require_once 'GetOptionKit/SplClassLoader.php';
foreach (get_required_files() as $filename) {
    if (strpos($filename, 'GetOptionKit' . DIRECTORY_SEPARATOR . 'SplClassLoader.php') !== FALSE) {
        $classLoader = new GetOptionKit\SplClassLoader('GetOptionKit', dirname($filename) . '/../');
        $classLoader->register();
        break;
    }
}

define('ERR_MISSING_PARAMTER', "missing parameter: %s\n");

function require_parameter($param_names) {
    global $parms;
    foreach ($param_names as $param_name) if (!isset($parms[$param_name])) {
            throw new ErrorException(sprintf(ERR_MISSING_PARAMTER, $param_name));
        }
}

function confirm($message = "are you sure you want to delete this row? all referencing rows in other tables will be deleted too, so be careful! (yes/no)\n> ") {
    global $parms;
    if (isset($parms['--noinput']) && $parms['--noinput'])
        return true;

    echo $message;
    while (!in_array($line = trim(fgets(STDIN)), array('yes', 'no'))) {

        echo "enter one of (yes/no):\n> ";
    }
    return $line == 'yes';
}

?>