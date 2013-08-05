<?php

//if we are in a phar archive, this has been set by the stub
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . "/");
    define('SHARED', __DIR__ . "/../../shared/");
    define('CONFIG_DIR', __DIR__ . "/../../../etc/");
}

//include config files
if (file_exists(CONFIG_DIR . 'config.php'))
    include_once CONFIG_DIR . 'config.php';
else
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'config.php'));


if (file_exists(CONFIG_DIR . 'cvterms.php'))
    include_once CONFIG_DIR . 'cvterms.php';
else
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'cvterms.php'));


//include requirements
if (stream_resolve_include_path('Console/CommandLine.php'))
    require_once 'Console/CommandLine.php';
else
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");


if (!@include_once CONFIG_DIR . 'config.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'config.php'));

if (!@include_once CONFIG_DIR . 'cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'cvterms.php'));


$parser = new \Console_CommandLine(array(
    'description' => 'database tool for transcriptome browser!',
    'version' => '0.1'
        ));
$parser->subcommand_required = true;

require_once SHARED . '/' . 'cli_error_handler.php';
//determine console width
$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$parser->addOption('debug', array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode'
));
//include command files
$old_classes = get_declared_classes();
foreach (new DirectoryIterator(ROOT . 'commands') as $file) {
    if (strpos($file, '.php') !== FALSE)
        include_once ROOT . 'commands/' . $file;
}
$new_classes = array_diff(get_declared_classes(), $old_classes);

$command_classes = array();
//for all newly included classes
foreach ($new_classes as $class) {
    $ref = new ReflectionClass($class);
    //if it implements \CLI_Command
    if ($ref->implementsInterface('\CLI_Command') && !$ref->isAbstract()) {
        //call $class::CLI_getCommand to create new command on parser
        call_user_func(array($class, 'CLI_getCommand'), $parser);
        //create mapping "commandname" => "classname"
        $command_classes[call_user_func(array($class, 'CLI_commandName'))] = $class;
    }
}

if ($argv[1] == '--build-autocomplete'){
    require_once SHARED . 'classes/CommandLineComplete.php';
    CommandLineComplete::fromConsoleCommandLine(basename($argv[0]), $parser);
    exit(0);
}

try {
    $result = $parser->parse();

    if ($result->options['debug'] === true) {
        define('DEBUG', true);
    }


    //have we been called with a command?
    if (is_object($result->command)) {
        //map command back to class
        $class = $command_classes[$result->command_name];
        //if class is CLI_Command and not abstract
        $ref = new ReflectionClass($class);
        if ($ref->implementsInterface('\CLI_Command') && !$ref->isAbstract()) {
            //$class::CLI_checkRequiredOpts
            call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command);
            //$class::CLI_execute
            call_user_func(array($class, 'CLI_execute'), $result->command, $parser);
        }
        else
            die('command not implemented correctly!');
    } else {
        $parser->displayUsage();
        exit(0);
    }
} catch (\Exception $exc) {
    if (defined('DEBUG') && DEBUG) {
        throw $exc;
    }
    $parser->displayError($exc->getMessage());
}
?>
