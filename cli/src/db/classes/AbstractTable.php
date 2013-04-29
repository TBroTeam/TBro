<?php

namespace cli_db;

require_once ROOT . 'classes/CLI_Command.php';

interface Table {

    static function getKeys();

    static function getSubCommands();

    static function executeCommand($command, $options);

    static function getPropelClass();
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
        if ($subcommand_name == 'delete') {
            $submcd->addOption('noconfirm',
                    array(
                'long_name' => '--noconfirm' . $key,
                'description' => 'if set, will not ask for confirmation on delete',
                'action' => 'StoreTrue'
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
        foreach ($keys as $key => $val) {
            if (@$val['colname'] != null)
                $column_keys[$key] = $val['colname'];
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

    public static function confirm($options) {
        if (isset($options['noconfirm']) && $options['noconfirm'])
            return true;

        echo "are you sure you want to delete this row? (yes/no)\n> ";
        while (!in_array($line = trim(fgets(STDIN)), array('yes', 'no'))) {

            echo "enter one of (yes/no):\n> ";
        }
        return $line == 'yes';
    }

    protected static function command_insert($options, $keys, $callback_set_defaults=null) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass'));
        $item = new $propel_class();
        foreach ($keys as $key => $data) {
            if (@$data['actions']['insert'] == 'required')
                $item->{"set" . $data['colname']}($options[$key]);
            else if (@$data['actions']['insert'] == 'optional' && isset($options[$key]))
                $item->{"set" . $data['colname']}($options[$key]);
        }
        if ($callback_set_defaults!=null){
            $callback_set_defaults($item);
        }
        $lines = $item->save();
        printf("%d line(s) inserted.\n", $lines);
    }

    protected static function command_update($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);
        if ($item == null) {
            printf("No contact found for id %d.\n", $options['id']);
            return;
        }

        foreach ($keys as $key => $data) {
            if ($key != 'id' && isset($data['colname']) && isset($options[$key]))
                $item->{"set" . $data['colname']}($options[$key]);
        }

        $lines = $item->save();
        printf("%d line(s) udpated.\n", $lines);
    }

    protected static function command_delete($options, $keys) {

        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);

        if ($item == null) {
            printf("No contact found for id %d.\n", $options['id']);
            return;
        }
        if (self::confirm($options)) {
            $item->delete();
            printf("Contact with id %d deleted successfully.\n", $item->getContactId());
        }
    }

    protected static function command_details($options, $keys) {
        $propel_class = call_user_func(array(get_called_class(), 'getPropelClass')) . 'Query';
        $q = new $propel_class;

        $item = $q->findOneBy($keys['id']['colname'], $options['id']);
        if ($item == null) {
            printf("No contact found for id %d.\n", $options['id']);
            return;
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

}

?>
