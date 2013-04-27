#!/usr/bin/php
<?php
//if we are in a phar archive, this has been set by the stub
if (!defined('ROOT'))
    define('ROOT', __DIR__ . "/");
if (!defined('CONFIG_DIR'))
    define('CONFIG_DIR', __DIR__ . "/../");

if (!@include_once 'Console/CommandLine.php')
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");

if (!@include_once 'Console/Table.php')
    die("Failure including Console/Table.php\nplease install PEAR::Console_Table or check your include_path\n");

if (!@include_once 'Console/ProgressBar.php')
    die("Failure including Console/ProgressBar.php\nplease install PEAR::Console_ProgressBar or check your include_path\n");

if (!@include_once 'Log.php')
    die("Failure including Log.php\nplease install PEAR::Log or check your include_path\n");


if (!@include_once CONFIG_DIR . 'db-config.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-config.php'));

if (!@include_once CONFIG_DIR . 'db-cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-cvterms.php'));

$parser = new Console_CommandLine(array(
    'description' => 'importer for transcriptome browser!',
    'version' => '0.1'
        ));

$parser->subcommand_required = true;
$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$parser->addOption('debug',
        array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode (queries will be output to console)'
));

$old_classes = get_declared_classes();
foreach (new DirectoryIterator(ROOT . 'importers') as $file) {
    if (strpos($file, '.php') !== FALSE)
        include_once ROOT . 'importers/' . $file;
}
$new_classes = array_diff(get_declared_classes(), $old_classes);

$command_classes = array();
foreach ($new_classes as $class) {
    $ref = new ReflectionClass($class);

    if ($ref->implementsInterface('CLI_Command') && !$ref->isAbstract()) {
        call_user_func(array($class, 'CLI_getCommand'), $parser);
        $command_classes[call_user_func(array($class, 'CLI_commandName'))] = $class;
    }
}

try {

    $result = $parser->parse();

    if ($result->options['debug'] === true) {
        define('DEBUG', true);
    }

    try {
        global $db;
        if (@DEBUG) {
            require_once ROOT . '/libs/loggedPDO/LoggedPDO.php';
            $db = new \LoggedPDO\PDO(DB_CONNSTR, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION),
                    Log::factory('console', '', 'PDO'));
        }
        else
            $db = new PDO(DB_CONNSTR, DB_USERNAME, DB_PASSWORD, array(PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION));
    } catch (PDOException $e) {
        print "Error!: " . $e->getMessage() . "<br/>";
        die();
    }

    foreach ($result->command->args['files'] as $filename) {
        if (!file_exists($filename))
            throw new Exception(sprintf('input file %s does not exist!', $filename));
    }

    $class = $command_classes[$result->command_name];
    $ref = new ReflectionClass($class);
    if ($ref->implementsInterface('CLI_Command') && $ref->implementsInterface('Importer') && !$ref->isAbstract()) {

        call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command->options);

        define('DB_ORGANISM_ID', $result->command->options['organism_id']);
        define('IMPORT_PREFIX', $result->command->options['import_prefix']);

        foreach ($result->command->args['files'] as $filename) {
            printf("importing %s as %s\n", $filename, $result->command_name);
            $ret_table = call_user_func(array($class, 'import'), array_merge($result->command->options, array('file' => $filename)));
            $tbl = new Console_Table();
            foreach ($ret_table as $key => $value) $tbl->addRow(array($key, $value));
            echo $tbl->getTable();
        }
    }
    else {
        $parser->displayUsage();
        exit(0);
    }
} catch (Exception $exc) {
    $parser->displayError($exc->getMessage());
}
?>
