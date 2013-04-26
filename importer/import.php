#!/usr/bin/php
<?php
// Include the Console_CommandLine package.
require_once 'Console/CommandLine.php';

require_once __DIR__ . '/../includes/constants.php';


$parser = new Console_CommandLine(array(
    'description' => 'importer for transcriptome browser!',
    'version' => '0.1'
        ));

$parser->addOption('debug',
        array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode (queries will be output to console)'
));

$classes = get_declared_classes();

foreach (glob(INC . '/importers/*.php') as $filename) {
    include_once $filename;
}
$new_classes = array_diff(get_declared_classes(), $classes);
$classes = array();
foreach ($new_classes as $class) {
    $ref = new ReflectionClass($class);

    if ($ref->implementsInterface('CLI_Importer') && !$ref->isAbstract()) {
        call_user_func(array($class, 'CLI_getCommand'), $parser);
        $classes[call_user_func(array($class, 'CLI_commandName'))] = $class;
    }
}



try {
    $result = $parser->parse();

    foreach ($result->command->args['files'] as $filename) {
        if (!file_exists($filename))
            throw new Exception(sprintf('input file %s does not exist!', $filename));
    }

    $class = $classes[$result->command_name];
    $ref = new ReflectionClass($class);
    if ($ref->implementsInterface('CLI_Importer') && $ref->implementsInterface('Importer') && !$ref->isAbstract()) {
        call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command->options);
        foreach ($result->args['files'] as $filename) {
            call_user_func(array($class, 'import'), array_merge($result->command->options, array('file' => $filename)));
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
