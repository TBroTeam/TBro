<?php

//if we are in a phar archive, this has been set by the stub
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . "/");
    define('SHARED', __DIR__ . "/../../shared/");
    define('CONFIG_DIR', __DIR__ . "/../../../etc/");
}

//include configuration
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

if (stream_resolve_include_path('Console/Table.php'))
    require_once 'Console/Table.php';
else
    die("Failure including Console/Table.php\nplease install PEAR::Console_Table or check your include_path\n");

if (stream_resolve_include_path('Console/ProgressBar.php'))
    require_once 'Console/ProgressBar.php';
else
    die("Failure including Console/ProgressBar.php\nplease install PEAR::Console_ProgressBar or check your include_path\n");

if (stream_resolve_include_path('Log.php'))
    require_once 'Log.php';
else
    die("Failure including Log.php\nplease install PEAR::Log or check your include_path\n");

if (!@include_once CONFIG_DIR . 'cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'cvterms.php'));


$parser = new Console_CommandLine(array(
    'description' => 'importer for transcriptome browser!',
    'version' => '0.1'
        ));
$parser->subcommand_required = true;
//determine console width
$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$parser->addOption('debug', array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode (queries will be output to console)'
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
    if ($ref->implementsInterface('CLI_Command') && !$ref->isAbstract()) {
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

    try {
        global $db;
        if (defined('DEBUG') && DEBUG) {
            require_once SHARED . '/libs/loggedPDO/PDO.php';
            $db = new \LoggedPDO\PDO(DB_CONNSTR, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION), Log::factory('console', '', 'PDO'));
        }
        else
            $db = new PDO(DB_CONNSTR, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (\PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    foreach ($result->command->args['files'] as $filename) {
        if (!file_exists($filename))
            throw new Exception(sprintf('input file %s does not exist!', $filename));
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