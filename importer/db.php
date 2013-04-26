#!/usr/bin/php
<?php
// we're using the PEAR Console_CommandLine package: pear install Console_CommandLine
require_once 'Console/CommandLine.php';
// we're using the PEAR Console_Table package: pear install Console_Table
require_once 'Console/Table.php';

require_once __DIR__ . '/../includes/constants.php';

$parser = new \Console_CommandLine(array(
    'description' => 'database tool for transcriptome browser!',
    'version' => '0.1'
        ));
$parser->subcommand_required = true;
$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$old_classes = get_declared_classes();

foreach (glob(INC . '/cli_db/*.php') as $filename) {
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
