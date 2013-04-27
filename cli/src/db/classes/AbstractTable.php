<?php

namespace cli_db;

require_once ROOT . 'classes/CLI_Command.php';

interface Table {

    static function getKeys();

    static function getSubCommands();

    static function executeCommand($command, $options);
}

abstract class AbstractTable implements \CLI_Command, Table {

    private static function processSubCommand($command, $subcommand_name, $keys) {
        $submcd = $command->addCommand($subcommand_name);


        foreach ($keys as $key => $data) {
            if (isset($data['actions'][$subcommand_name]))
                $submcd->addOption($key,
                        array(
                    'long_name' => '--' . $key,
                    'description' => sprintf('(%2$s) %1$s', $data['description'], $data['actions'][$subcommand_name]),
                    'help_name' => $key
                ));
        }
    }

    public static function CLI_getCommand(\Console_CommandLine $parser) {
        $command = $parser->addCommand(call_user_func(array(get_called_class(), 'CLI_commandName')),
                array(
            'description' => call_user_func(array(get_called_class(), 'CLI_commandDescription'), $parser)
        ));


        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        $subcommands = call_user_func(array(get_called_class(), 'getSubCommands'));

        foreach ($subcommands as $cmd) {
            self::processSubCommand($command, $cmd, $keys);
        }
    }

    public static function CLI_checkRequiredOpts($options, $subcommand_name = null) {
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        foreach ($keys as $key => $data) {
            if (isset($data['actions'][$subcommand_name]) && $data['actions'][$subcommand_name] == 'required')
                if (!isset($options[$key]))
                    throw new \Exception(sprintf('option --%s has to be set', $key));
        }
    }

    public static function prepareQueryResult($res) {
        $keys = call_user_func(array(get_called_class(), 'getKeys'));
        $column_keys = array();
        foreach ($keys as $key=>$val){
            if (@$val['colname']!=null)
                $column_keys[$key]=$val['colname'];
        }

        $ret = array();
        foreach ($res as $row) {
            $ret_row = array();
            foreach ($column_keys as $key => $val) $ret_row[$key] = call_user_func(array($row, "get" . $val));
            $ret[] = $ret_row;
        }
        return $ret;
    }

    public static function printTable($headers, $data) {
        $tbl = new \Console_Table();
        $tbl->setHeaders($headers);
        $tbl->addData($data);
        echo $tbl->getTable();
    }

}


?>
