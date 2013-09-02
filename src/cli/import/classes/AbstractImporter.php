<?php

namespace cli_import;

use \PDO;

require_once SHARED . 'classes/CLI_Command.php';

interface Importer {

    /**
     * executes import
     * @global \PDO $db
     * @param Array $options user-provided command-line options
     * @return Array results
     * @throws \Exception on error
     * @throws \ErrorException on error
     */
    static function import($options);
}

define('ERR_ILLEGAL_FILE_FORMAT', 'Unsupported file format. Please recheck');

/**
 * abstract class as parent for tbro-import commands.
 * implements standard behavior for command-line interaction. final importers only need to implement the import method
 */
abstract class AbstractImporter implements \CLI_Command, Importer {

    /**
     * adds command line options.
     * --help
     * --organism_id
     * --release
     * argument "files"
     * @param \Console_CommandLine $parser
     * @return \Console_CommandLine_Command
     */
    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')), array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'))
        ));

        $command->add_help_option = false;

        $command->addOption('help', array(
            'short_name' => '-h',
            'long_name' => '--help',
            'action' => 'Help',
            'action_params' => array('class' => get_called_class()),
            'description' => 'show this help message and exit'
        ));

        $command->addOption('organism_id', array(
            'short_name' => '-o',
            'long_name' => '--organism_id',
            'description' => 'id of the organism this import is for'
        ));
        $command->addOption('release', array(
            'short_name' => '-r',
            'long_name' => '--release',
            'description' => 'this will be used as prefix for all uniquenames and displayed in the "dataset" dropdown'
        ));
        $command->addOption('skip', array(
            'short_name' => '-k',
            'long_name' => '--skip-materialize-views',
            'action'=>'StoreTrue',
            'description' => 'this will cause the program to skip updating the materialized views'
        ));

        $command->addArgument('files', array(
            'multiple' => true,
            'description' => 'files to be imported'
        ));

        return $command;
    }

    /**
     * check if all required options have been set
     * @param \Console_CommandLine_Result $command
     * @throws \Exception on missing argument
     */
    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        $options = $command->options;

        self::dieOnMissingArg($options, 'organism_id');
        self::dieOnMissingArg($options, 'release');
    }

    /**
     * execute command. sets constants and calls self::import($options)
     * @global \PDO $db
     * @param \Console_CommandLine_Result $command
     * @param \Console_CommandLine $parser
     */
    static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {
        //set constants
        define('LINES_IMPORTED', 'datasets_imported');
        define('DB_ORGANISM_ID', $command->options['organism_id']);
        define('IMPORT_PREFIX', $command->options['release']);
        //get some values for quick access
        $command_name = call_user_func(array(get_called_class(), 'CLI_commandName'));
        $command_options = $command->options;
        $command_args = $command->args;

        //for each file argument
        foreach ($command_args['files'] as $filename) {
            //print header
            printf("importing %s as %s\n", $filename, $command_name);
            //call self::import
            $ret_table = call_user_func(array(get_called_class(), 'import'), array_merge($command_options, array('file' => $filename)));
            //output results from import
            $tbl = new \Console_Table();
            foreach ($ret_table as $key => $value)
                $tbl->addRow(array($key, $value));
            echo $tbl->getTable();
        }
        if(@!$command_options['skip']){
            //update materialized views for statistics etc.
            echo "\nupdating materialized views...";
            global $db;
            $db->query('SELECT update_materialized_views()');
            echo " done!\n";
        }
        
    }

    static function preCommitMsg() {
        echo "\ncommiting changes to database. this may take a moment.\n";
    }

    /**
     * Log instance for output
     * @var \Log 
     */
    public static $log;

    /**
     * progress bar instance
     * @var \Console_ProgressBar
     */
    private static $bar;

    /**
     * progress bar will be updated every $announce_steps imported lines
     * @var int 
     */
    private static $announce_steps = 100;

    /**
     * progress bar style
     * @var String 
     */
    private static $barstr = '[%bar%] %fraction%(%percent%), elapsed: %elapsed% , remaining est.: %estimate%';

    /**
     * updates progress bar target count
     * @param int $count
     */
    protected static function setLineCount($count) {
        $width_exec = exec('tput cols 2>&1');
        $width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 120;

        if (self::$bar == null) {
            self::$bar = new \Console_ProgressBar(self::$barstr, '=>', ' ', $width, $count);
        } else {
            self::$bar->reset(self::$barstr, '=>', ' ', $width, $count);
        }
    }

    /**
     * updates bar progress
     * @param int $current_count
     * @return nothing
     */
    protected static function updateProgress($current_count) {
        if ($current_count % self::$announce_steps != 0)
            return;
        self::$bar->update($current_count);
    }

    /**
     * throws exception if required option is not set
     * @param Array $options user-specified command-line options
     * @param String $argname name of option
     * @throws \Exception
     */
    protected static function dieOnMissingArg($options, $argname) {
        if (!isset($options[$argname]))
            throw new \Exception(sprintf('option --%s has to be set', $argname));
    }

}

//set importer Log instance
AbstractImporter::$log = \Log::factory('console', '', 'Importer');
?>
