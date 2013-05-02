<?php

//if we are in a phar archive, this has been set by the stub
if (!defined('ROOT')) {
    define('ROOT', __DIR__ . "/");
    define('SHARED', __DIR__ . "/../shared/");
    define('CONFIG_DIR', __DIR__ . "/../../etc/");
}

if (stream_resolve_include_path('Console/CommandLine.php'))
    require_once 'Console/CommandLine.php';
else
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");

if (stream_resolve_include_path('Console/Table.php'))
    require_once 'Console/Table.php';
else
    die("Failure including Console/Table.php\nplease install PEAR::Console_Table or check your include_path\n");

if (stream_resolve_include_path('propel/Propel.php'))
    require_once 'propel/Propel.php';
else
    die(<<<EOF
Failure including propel/Propel.php
please install propel_runtime via PEAR or check your include_path
        
    pear channel-discover pear.propelorm.org
    pear install -a propel/propel_runtime
EOF
    );

if (!@include_once CONFIG_DIR . 'db-config.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-config.php'));

if (!@include_once CONFIG_DIR . 'db-cvterms.php')
    die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'db-cvterms.php'));


$parser = new \Console_CommandLine(array(
            'description' => 'database tool for transcriptome browser!',
            'version' => '0.1'
        ));
$parser->subcommand_required = true;

$width_exec = exec('tput cols 2>&1');
$width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;
$parser->renderer->line_width = $width;

$parser->addOption('debug', array(
    'short_name' => '-d',
    'long_name' => '--debug',
    'action' => 'StoreTrue',
    'description' => 'enables debug mode'
));

$old_classes = get_declared_classes();
foreach (new DirectoryIterator(ROOT . 'commands') as $file) {
    if (strpos($file, '.php') !== FALSE)
        include_once ROOT . 'commands/' . $file;
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


    require_once ROOT . '/propel-conf/propel-init.php';


    if (is_object($result->command)) {
        $class = $command_classes[$result->command_name];

        $ref = new ReflectionClass($class);
        if ($ref->implementsInterface('\CLI_Command') && !$ref->isAbstract()) {
            call_user_func(array($class, 'CLI_checkRequiredOpts'), $result->command);
            call_user_func(array($class, 'CLI_execute'), $result->command, $parser);
        } else
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
