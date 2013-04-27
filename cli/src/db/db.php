#!/usr/bin/php
<?php
//root dir. for testing, this can be __DIR__."/", for deployment it can be phing://
define('ROOT', __DIR__ . "/");
//TODO put this into configure options
define('CONFIG', __DIR__ . "/../");

if (!@include_once 'Console/CommandLine.php')
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");

if (!@include_once 'Console/Table.php')
    die("Failure including Console/Table.php\nplease install PEAR::Console_Table or check your include_path\n");


if (!@include_once CONFIG . 'db-config.php')
    die(sprintf("Missing config file: %s\n", CONFIG . 'db-config.php'));

if (!@include_once CONFIG . 'db-cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG . 'db-cvterms.php'));


$parser = new \Console_CommandLine(array(
    'description' => 'database tool for transcriptome browser!',
    'version' => '0.1'
        ));
$parser->subcommand_required = true;
$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$old_classes = get_declared_classes();

foreach (glob(ROOT . '/tables/*.php') as $filename) {
    include_once $filename;
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
    $class = $command_classes[$result->command_name];

    require_once ROOT . '/propel-conf/propel-init.php';
    
    $ref = new ReflectionClass($class);
    if ($ref->implementsInterface('\CLI_Command') && $ref->implementsInterface('\cli_db\Table') && !$ref->isAbstract()) {
        call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command->command->options, $result->command->command_name);
        call_user_func(array($class, 'executeCommand'), $result->command->command->options, $result->command->command_name);
    }
    else {
        $parser->displayUsage();
        exit(0);
    }
} catch (\Exception $exc) {
    $parser->displayError($exc->getMessage());
}
?>
