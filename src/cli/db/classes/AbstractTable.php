<?php

namespace cli_db;

require_once SHARED . 'classes/CLI_Command.php';

interface Table {

    /**
     * returns associative array of command parameters.
     * key is command name, value is an array describing paramteters consisting of
     * .  action: array of subcommands this parameter is available for. array key is subcommand name, value is one of optional|required
     * .  description: description for help text
     * .  colname: name of associated Propel column. Ucfirst. can be unset, but then this parameter will not be evaluated automatically
     * .  all other keys will be passed to $submcd->addOption
     */
    static function getKeys();

    /**
     * array of available subcommands
     */
    static function getSubCommands();

    /**
     * namespace and class name of propel class this table is based on
     */
    static function getPropelClass();
}

/**
 * abstract class as parent for tbro-db commands.
 * implements standard behavior for insert, update, delete, list and display subcommands
 */
abstract class AbstractTable implements \CLI_Command, Table {

    /**
     * create subcommand for $command and add parameters
     * @param \Console_CommandLine $command 
     * @param string $subcommand_name subcommand name.
     * @param array $keys returnvalue of Table::getKeys()
     */
    private static function processSubCommand($command, $subcommand_name, $keys) {
        //adds a subcommand
        $submcd = $command->addCommand($subcommand_name);

        //merge passed keys with standard values. standard values will be overwritten
        $keys = array_merge(array(
            'short' => array(
                'actions' => array(
                    'insert' => 'optional',
                ),
                'description' => 'if set, will just output the ID of newly inserted line on success',
                'action' => 'StoreTrue'
            ),
            'noconfirm' => array(
                'actions' => array(
                    'delete' => 'optional',
                ),
                'description' => 'if set, will not ask for confirmation on delete',
                'action' => 'StoreTrue'
            ),
                ), $keys);

        // for all possible parameters
        foreach ($keys as $key => $data) {
            // if parameter is required or optional for this subcommand
            if (isset($data['actions'][$subcommand_name]) && ($data['actions'][$subcommand_name] == 'optional' || $data['actions'][$subcommand_name] == 'required')) {
                //set standard options for $submcd->addOption
                $stdopts = array(
                    'long_name' => '--' . $key,
                    'help_name' => $key
                );
                //add extra options. ignore $data['actions'] and $data['colname'], these are not of interest to $submcd->addOption
                $extraopts = array_diff_key($data, array('actions' => null, 'colname' => null));
                $options = array_merge($stdopts, $extraopts);
                //add prefix (required) or (optional) to description
                $options['description'] = sprintf('(%2$s) %1$s', $data['description'], $data['actions'][$subcommand_name]);
                //add option to subcommand
                $option = $submcd->addOption($key, $options);
            }
        }
    }

    /**
     * adds a command representing this class to $parser
     * @param \Console_CommandLine $parser
     */
    public static function CLI_getCommand(\Console_CommandLine $parser) {
        //create command
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')), array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'))
        ));

        //essentially self::getKeys(), but calling the overwriting getKeys function and not AbstractTable::getKeys()
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        //same with self::getSubCommands()
        $subcommands = call_user_func(array(get_called_class(), 'getSubCommands'));

        //add all subcommands
        foreach ($subcommands as $cmd) {
            self::processSubCommand($command, $cmd, $keys);
        }
    }

    /**
     * check if all required options have been set by the user
     * @param \Console_CommandLine_Result $command
     * @return nothing
     * @throws \Exception if an option is missing
     */
    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        //if we are called without subcommand, skip
        if (!is_object($command->command))
            return;

        $subcommand_name = $command->command_name;
        $subcommand_options = $command->command->options;

        //self::getKeys()
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        //check for all keys if it is required for currently called subcommand
        foreach ($keys as $key => $data) {
            if (isset($data['actions'][$subcommand_name]) && $data['actions'][$subcommand_name] == 'required')
                if (!isset($subcommand_options[$key]))
                    throw new \Exception(sprintf('option --%s has to be set', $key));
        }
    }

    /**
     * execute this command
     * @param \Console_CommandLine_Result $command the command as created by self::CLI_getCommand
     * @param \Console_CommandLine $parser
     * @return false if subcommand is unknown
     */
    public static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {
        // we are called without subcommand. just display help.
        if (!is_object($command->command))
        //this command will die
            $parser->commands[call_user_func(array(get_called_class(), 'CLI_commandName'))]->displayUsage();

        $subcommand_name = $command->command_name;
        $subcommand_options = $command->command->options;
        //self::getKeys()
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        $subcommands = call_user_func(array(get_called_class(), 'getSubCommands'));
        //if invalid subcommand, cancel
        if (!in_array($subcommand_name, $subcommands))
            return false;

        //execute the command, i.e. a function self::command_<subcommand_name>
        call_user_func(array(get_called_class(), 'command_' . $subcommand_name), $subcommand_options, $keys);
    }

    /**
     * prepare a propel result for displaying with printTable
     * @param type $res PropelObjectCollection|Array[propel\BaseObject] 
     * @return type Array[Array[String]]
     */
    public static function prepareQueryResult($res) {
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        //identify all parameters with "colname" set
        $column_keys = array();
        foreach ($keys as $key => $val) {
            if (isset($val['colname']) && $val['colname'] != null)
                $column_keys[$key] = $val['colname'];
        }

        //for all items
        $ret = array();
        foreach ($res as $row) {
            $ret_row = array();
            //for the identified parameters
            foreach ($column_keys as $key => $val)
            //execute $row->get<ParameterColname>
                $ret_row[$key] = call_user_func(array($row, "get" . $val));
            $ret[] = $ret_row;
        }
        return $ret;
    }

    /**
     * print a table
     * @param Array[String] $headers
     * @param Array[Array[String]] $data 
     */
    public static function printTable($headers, $data) {
        $tbl = new \Console_Table();
        $tbl->setHeaders($headers);
        $tbl->addData($data);
        echo $tbl->getTable();
    }

    //<editor-fold defaultstate="collapsed" desc="Table manipulation commands">
    /**
     * can be overwritten. is called after filling Propel item, before calling $item->save
     * can be used to satisfy non-null-constraints by setting default values
     * @param \BaseObject $item
     */
    protected static function command_insert_set_defaults(\BaseObject $item) {
        
    }

    /**
     * parsing $keys for paramters, set values from $options in $propelitem. 
     ** @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     * @param String $cmdname command name to scan keys for
     * @param \BaseObject $propelitem propel item to set values
     */
    protected static function setKeys($options, $keys, $cmdname, \BaseObject $propelitem) {
        foreach ($keys as $key => $data) {
            if (!isset($data['colname']) || !isset($data['actions']) || !isset($data['actions'][$cmdname]))
                continue;
            if ($data['actions'][$cmdname] == 'required' || $data['actions'][$cmdname] == 'internal')
                $propelitem->{"set" . $data['colname']}($options[$key]);
            else if ($data['actions'][$cmdname] == 'optional' && isset($options[$key]))
                $propelitem->{"set" . $data['colname']}($options[$key]);
        }
    }

    /**
     * default insert row command
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     */
    protected static function command_insert($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass'));
        $item = new $propel_class();
        self::setKeys($options, $keys, 'insert', $item);

        call_user_func(array(get_called_class(), 'command_insert_set_defaults'), $item);

        $lines = $item->save();
        if (isset($options['short']) && $options['short'])
            print $item->getPrimaryKey();
        else {
            printf("%d line(s) inserted.\nNew item ID is %d.\n", $lines, $item->getPrimaryKey());
        }
    }

    /**
     * default update row command
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     */
    protected static function command_update($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);
        if ($item == null) {
            trigger_error(sprintf("No contact found for id %d.\n", $options['id']), E_USER_ERROR);
        }

        foreach ($keys as $key => $data) {
            if ($key != 'id' && isset($data['colname']) && isset($options[$key]))
                $item->{"set" . $data['colname']}($options[$key]);
        }

        $lines = $item->save();
        printf("%d line(s) udpated.\n", $lines);
    }

    /**
     * prompts the user to confirm deletion of a row if $option['noconfirm'] is not set
     * @param Array $options user-specified command line parameters
     * @param type $message message to promt the user
     * @return boolean delete or not
     */
    public static function command_delete_confirm($options, $message = "This will delete a row from the database.\n") {
        if (isset($options['noconfirm']) && $options['noconfirm'])
            return true;

        echo $message;
        echo "Coninue (yes/no)\n> ";
        while (!in_array($line = trim(fgets(STDIN)), array('yes', 'no'))) {

            echo "enter one of (yes/no):\n> ";
        }
        return $line == 'yes';
    }

    /**
     * default delete row command
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     */
    protected static function command_delete($options, $keys) {

        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);

        $cmdname = call_user_func(array(get_called_class(), 'CLI_commandName'));

        if ($item == null) {
            trigger_error(sprintf("No $cmdname found for id %d.\n", $options['id']), E_USER_ERROR);
        }
        if (self::command_delete_confirm($options)) {
            $item->delete();
            printf("$cmdname with id %d deleted successfully.\n", $options['id']);
        }
    }

    /**
     * default show details for row command
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     */
    protected static function command_details($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);
        if ($item == null) {
            $cmdname = call_user_func(array(get_called_class(), 'CLI_commandName'));
            trigger_error(sprintf("No $cmdname found for id %d.\n", $options['id']), E_USER_ERROR);
        }

        $table_keys = array_keys(array_filter($keys, function($val) {
                            return isset($val['colname']);
                        }));
        $results = self::prepareQueryResult(array($item));
        self::printTable($table_keys, $results);
    }

    /**
     * default list rows command
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     */
    protected static function command_list($options, $keys) {

        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $table_keys = array_keys(array_filter($keys, function($val) {
                            return isset($val['colname']);
                        }));
        $results = self::prepareQueryResult($q->find());
        self::printTable($table_keys, $results);
    }

    //</editor-fold>
}

?>
