<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Protocol extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'ProtocolId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'protocol id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'protocol name'
            ),
            'uri' => array(
                'colname' => 'Uri',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'uri'
            ),
            'protocol_description' => array(
                'colname' => 'Protocoldescription',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'the protocol text',
                'short_name' => '-p'
            ),
            'hardware_description' => array(
                'colname' => 'Hardwaredescription',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'a description of hardware involved',
                'short_name' => '-w'
            ),
            'software_description' => array(
                'colname' => 'Softwaredescription',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'a description of software involved',
                'short_name' => '-s'
            )
        );
    }

    protected static function command_insert_set_defaults(\BaseObject $item) {
        // satisfy NOT NULL constraint
        $item->setTypeId(1);
    }

    public static function CLI_commandDescription() {
        return 'Manipulate protocols.';
    }

    public static function CLI_commandName() {
        return 'protocol';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Protocol';
    }

}

?>
