<?php

interface CLI_Command {

    static function CLI_commandName();

    static function CLI_commandDescription();

    static function CLI_longHelp();

    static function CLI_getCommand(Console_CommandLine $parser);

    static function CLI_checkRequiredOpts($options);
}

?>
