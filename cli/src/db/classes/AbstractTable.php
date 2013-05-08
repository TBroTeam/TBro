<?php

namespace cli_db;

require_once SHARED . 'classes/CLI_Command.php';

interface Table {

    static function getKeys();

    static function getSubCommands();

    static function getPropelClass();
}

abstract class AbstractTable implements \CLI_Command, Table {

    private static function processSubCommand($command, $subcommand_name, $keys) {
        $submcd = $command->addCommand($subcommand_name);

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

        foreach ($keys as $key => $data) {
            if (isset($data['actions'][$subcommand_name])
                    && ($data['actions'][$subcommand_name] == 'optional' || $data['actions'][$subcommand_name] == 'required')) {
                $stdopts = array(
                    'long_name' => '--' . $key,
                    'help_name' => $key
                );
                $extraopts = array_diff_key($data, array('actions' => null, 'colname' => null));
                $options = array_merge($stdopts, $extraopts);
                $options['description'] = sprintf('(%2$s) %1$s', $data['description'], $data['actions'][$subcommand_name]);
                $option = $submcd->addOption($key, $options);
            }
        }
    }

    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')), array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'))
                ));


        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        $subcommands = call_user_func(array(get_called_class(), 'getSubCommands'));

        foreach ($subcommands as $cmd) {
            self::processSubCommand($command, $cmd, $keys);
        }
    }

    public static function CLI_checkRequiredOpts(\Console_CommandLine_Result $command) {
        //if we are called without subcommand, skip
        if (!is_object($command->command))
            return;

        $subcommand_name = $command->command_name;
        $subcommand_options = $command->command->options;

        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        foreach ($keys as $key => $data) {
            if (isset($data['actions'][$subcommand_name]) && $data['actions'][$subcommand_name] == 'required')
                if (!isset($subcommand_options[$key]))
                    throw new \Exception(sprintf('option --%s has to be set', $key));
        }
    }

    public static function CLI_execute(\Console_CommandLine_Result $command, \Console_CommandLine $parser) {
        // we are called without subcommand. just display help.
        if (!is_object($command->command))
        //this command will die
            $parser->commands[call_user_func(array(get_called_class(), 'CLI_commandName'))]->displayUsage();

        $subcommand_name = $command->command_name;
        $subcommand_options = $command->command->options;
        $keys = call_user_func(array(get_called_class(), 'getKeys'));

        $subcommands = call_user_func(array(get_called_class(), 'getSubCommands'));
        if (!in_array($subcommand_name, $subcommands))
            return false;

        call_user_func(array(get_called_class(), 'command_' . $subcommand_name), $subcommand_options, $keys);
    }

    /**
     * 
     * @param type $res PropelObjectCollection|Array[propel\BaseObject] 
     * @return type Array[Array[String]]
     */
    public static function prepareQueryResult($res) {
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        $column_keys = array();
        foreach ($keys as $key => $val) {
            if (isset($val['colname']) && $val['colname'] != null)
                $column_keys[$key] = $val['colname'];
        }

        $ret = array();
        foreach ($res as $row) {
            $ret_row = array();
            foreach ($column_keys as $key => $val)
                $ret_row[$key] = call_user_func(array($row, "get" . $val));
            $ret[] = $ret_row;
        }
        return $ret;
    }

    /**
     * 
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
    protected static function command_insert_set_defaults(\BaseObject $item) {
        
    }

    protected static function setKeys($options, $keys, $cmdname, \BaseObject $propelitem) {
        foreach ($keys as $key => $data) {
            if (isset($data['actions']) && isset($data['actions'][$cmdname]) && ($data['actions'][$cmdname] == 'required' || $data['actions'][$cmdname] == 'internal'))
                $propelitem->{"set" . $data['colname']}($options[$key]);
            else if (isset($data['actions']) && isset($data['actions'][$cmdname]) && $data['actions'][$cmdname] == 'optional' && isset($options[$key]))
                $propelitem->{"set" . $data['colname']}($options[$key]);
        }
    }

    protected static function command_insert($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass'));
        $item = new $propel_class();
        self::setKeys($options, $keys, 'insert', $item);

        call_user_func(array(get_called_class(), 'command_insert_set_defaults'), $item);

        $lines = $item->save();
        if (isset($options['short']) && $options['short'])
            print $item->getPrimaryKey();
        else
            printf("%d line(s) inserted.\n", $lines);
    }

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
