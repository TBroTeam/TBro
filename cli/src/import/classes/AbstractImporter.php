<?php


require_once SHARED . 'classes/CLI_Command.php';

interface Importer {

    static function import($options);
}

define('ERR_ILLEGAL_FILE_FORMAT', 'Unsupported file format. Please recheck');

abstract class AbstractImporter implements CLI_Command, Importer {

    public static function CLI_getCommand(Console_CommandLine $parser) {
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')),
                array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'))
        ));

        $command->add_help_option = false;

        $opt = $command->addOption('help',
                array(
            'short_name' => '-h',
            'long_name' => '--help',
            'action' => 'Help',
            'action_params' => array('class' => get_called_class()),
            'description' => 'show this help message and exit'
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

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        $options = $command->options;
        
        self::dieOnMissingArg($options, 'organism_id');
        self::dieOnMissingArg($options, 'import_prefix');
    }
    
    static function CLI_execute(Console_CommandLine_Result $command, Console_CommandLine $parser){
        define('LINES_IMPORTED', 'datasets_imported');
        define('DB_ORGANISM_ID', $command->options['organism_id']);
        define('IMPORT_PREFIX', $command->options['import_prefix']);
        $command_name = call_user_func(array(get_called_class(), 'CLI_commandName'));
        $command_options = $command->options;
        $command_args = $command->args;
        
        foreach ($command_args['files'] as $filename) {
            printf("importing %s as %s\n", $filename, $command_name);
            $ret_table = call_user_func(array(get_called_class, 'import'), array_merge($command_options, array('file' => $filename)));
            $tbl = new Console_Table();
            foreach ($ret_table as $key => $value)
                $tbl->addRow(array($key, $value));
            echo $tbl->getTable();
        }
    }
    
    

    static function preCommitMsg() {
        echo "\ncommiting changes to database. this may take a moment.\n";
    }

    public static $log;
    private static $bar;
    private static $announce_steps = 100;
    private static $barstr = '[%bar%] %fraction%(%percent%), elapsed: %elapsed% , remaining est.: %estimate%';

    protected static function setLineCount($count) {
        $width_exec = exec('tput cols 2>&1');
        $width = is_int($width_exec) && $width_exec > 0 ? $width_exec : 200;

        if (self::$bar == null) {
            self::$bar = new Console_ProgressBar(self::$barstr, '=>', ' ', $width, $count);
        }
        else {
            self::$bar->reset(self::$barstr, '=>', ' ', $width, $count);
        }
    }

    protected static function updateProgress($current_count) {
        if ($current_count % self::$announce_steps != 0)
            return;
        self::$bar->update($current_count);
    }

    protected static function dieOnMissingArg($options, $argname) {
        if (!isset($options[$argname]))
            throw new Exception(sprintf('option --%s has to be set', $argname));
    }

}

//set importer Log instance
AbstractImporter::$log = Log::factory('console', '', 'Importer');
?>
