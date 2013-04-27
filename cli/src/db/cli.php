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


if (!@include_once CONFIG_DIR . 'db-config.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-config.php'));

if (!@include_once CONFIG_DIR . 'db-cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-cvterms.php'));


$parser = new \Console_CommandLine(array(
    'description' => 'database tool for transcriptome browser!',
    'version' => '0.1'
        ));
$parser->subcommand_required = true;

$parser->addOption('debug', array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode'
));

$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$old_classes = get_declared_classes();
foreach (new DirectoryIterator(ROOT . 'tables') as $file) {
    if (strpos($file, '.php') !== FALSE)
        include_once ROOT . 'tables/' . $file;
}
$new_classes = array_diff(get_declared_classes(), $old_classes);

$command_classes = array();
foreach ($new_classes as $class) {
    $ref = new ReflectionClass($class);
    if ($ref->implementsInterface('\CLI_Command') && !$ref->isAbstract()) {
        call_user_func(array($class, 'CLI_getCommand'), $parser);
        $command_classes[call_user_func(array($class, 'CLI_commandName'))] = $class;
    }
}

try {
    $result = $parser->parse();

    if ($result->options['debug'] === true) {
        define('DEBUG', true);
    }
    if (is_object($result->command)) {
        $class = $command_classes[$result->command_name];


        require_once ROOT . '/propel-conf/propel-init.php';

        $ref = new ReflectionClass($class);
        if ($ref->implementsInterface('\CLI_Command') && $ref->implementsInterface('\cli_db\Table') && !$ref->isAbstract()) {
            if (is_object($result->command->command)) {
                call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command->command->options, $result->command->command_name);
                call_user_func(array($class, 'executeCommand'), $result->command->command->options, $result->command->command_name);
            }
            else {
                $parser->commands[$result->command_name]->displayUsage();
            }
        }
    }
    else {
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
