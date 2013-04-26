<?php

// we're using the PEAR Log package: pear install Log
require_once 'Log.php';
// we're using Pear Console_Progressbar: pear install channel://pear.php.net/Console_Progressbar-0.5.2beta
require_once 'Console/ProgressBar.php';

require_once __DIR__ . '/../constants.php';
require_once INC . '/libs/php-progress-bar.php';

interface CLI_Importer {

    static function CLI_commandName();

    static function CLI_commandDescription();

    static function CLI_longHelp();

    static function CLI_getCommand($parser);

    static function CLI_checkRequiredOpts($options);
}

interface Importer {

    static function import($options);
}

abstract class AbstractImporter implements CLI_Importer, Importer {

    public static function CLI_getCommand($parser) {
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')),
                array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'), $parser)
        ));

        $command->addOption('organism_id',
                array(
            'short_name' => '-o',
            'long_name' => '--organism_id',
            'description' => 'id of the organism this import is for'
        ));

        $command->addOption('import_prefix',
                array(
            'short_name' => '-p',
            'long_name' => '--import_prefix',
            'description' => 'this will be used as prefix for all uniquenames and displayed in the "dataset" dropdown'
        ));

        $command->addArgument('files', array(
            'multiple' => true,
            'description' => 'id of the organism this import is for'
        ));

        return $command;
    }
    
    public static function CLI_checkRequiredOpts($options){
        self::dieOnMissingArg($options, 'organism_id');
        self::dieOnMissingArg($options, 'import_prefix');
    }
    
    public static $log;
   
    
    private $bar;
    private $announce_steps = 100;

    protected static function setLineCount($count) {
        if (self::$bar == null){
            self::$bar = new Console_ProgressBar('[%bar%] %percent%', '=>', ' ', 80, $count);
        } else {
            self::$bar->reset('[%bar%] %percent%', '=>', ' ', 80, $count);
        }
    }

    protected static function updateProgress($current_count) {
        if ($current_count % $this->announce_steps != 0)
            return;
        self::$bar->update($current_count);
    }

    protected static function dieOnMissingArg($options, $argname) {
        if (!isset($options[$argname]))
            throw new Exception(sprintf('option --%s has to be set', $argname));
    }

}

AbstractImporter::$log = Log::factory('console', '', 'Importer');;

?>
