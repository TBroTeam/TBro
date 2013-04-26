#!/usr/bin/php
<?php
// we're using the PEAR Console_CommandLine package: pear install Console_CommandLine
require_once 'Console/CommandLine.php';
// we're using the PEAR Console_Table package: pear install Console_Table
require_once 'Console/Table.php';

require_once __DIR__ . '/../includes/constants.php';


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

foreach (glob(INC . '/importers/*.php') as $filename) {
    include_once $filename;
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

    require_once INC . '/db.php';

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
