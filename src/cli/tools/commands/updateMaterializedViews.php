<?php

require_once SHARED . 'classes/CLI_Command.php';

class updateMaterializedViews implements \CLI_Command {

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        
    }

    public static function CLI_commandDescription() {
        return "Updates materialized views. \nNecessary after manually altering database entries like organism name \nor when using the --skip-materialize-views option in importers";
    }

    public static function CLI_commandName() {
        return "updateMaterializedViews";
    }

    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(self::CLI_commandName(), array(
            'description' => self::CLI_commandDescription()
                ));

        return $command;
    }

    public static function CLI_longHelp() {
        
    }

    public static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {
            //update materialized views for statistics etc.
            echo "\nupdating materialized views...";
            global $db;
            $db->query('SELECT update_materialized_views()');
            echo " done!\n";
    }

}

?>
