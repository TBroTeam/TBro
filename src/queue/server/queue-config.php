<?php

//include requirements
if (stream_resolve_include_path('Console/CommandLine.php'))
    require_once 'Console/CommandLine.php';
else
    die("Failure including Console/CommandLine.php\nplease install PEAR::Console_CommandLine or check your include_path\n");

$xmldata = <<<EOF
<?xml version="1.0" encoding="utf-8" standalone="yes"?>
<command>
    <option name="configfile">
        <short_name>-c</short_name>
        <long_name>--config</long_name>
        <description>path to configuration file</description>
    </option>    

    <command name="list_databases">
       <description>list_databases</description>
    </command>

    <command name="add_database">
       <description>add_database</description>
    </command>

    <command name="remove_database">
       <description>remove_database</description>
    </command>
</command>
EOF;

$parser = Console_CommandLine::fromXmlString($xmldata);
$parser->subcommand_required = true;


try {
    $result = $parser->parse();

    if ($result->options['debug'] === true) {
        define('DEBUG', true);
    }


    //have we been called with a command?
    if (is_object($result->command)) {

        //include config files
        if (isset($result->options->configfile) && file_exists($result->options->configfile))
            include_once $result->options->configfile;
        else
            die(sprintf("Missing config file: %s\n", CONFIG_DIR . 'config.php'));

        switch ($result->command_name) {
            
        }

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
