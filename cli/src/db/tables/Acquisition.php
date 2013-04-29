<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Acquisition extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'AcquisitionId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'acquisition id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'name'
            ),
            'uri' => array(
                'colname' => 'Uri',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'uri'
            ),
            'assay_id' => array(
                'colname' => 'AssayId',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'assay id'
            ),
            'protocol_id' => array(
                'colname' => 'ProtocolId',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'protocol id'
            ),
            'acquisitiondate' => array(
                'colname' => 'Acquisitiondate',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'time of acquisition'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate the database acquisition.';
    }

    public static function CLI_commandName() {
        return 'acquisition';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }

    public static function executeCommand($options, $command_name) {
        $keys = self::getKeys();
        switch ($command_name) {
            case 'insert':
                self::command_insert($options, $keys);
                break;
            case 'update':
                self::command_update($options, $keys);
                break;
            case 'delete':
                self::command_delete($options, $keys);
                break;
            case 'details':
                self::command_details($options, $keys);
                break;
            case 'list':
                self::command_list($options, $keys);
                break;
        }
    }
   

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Acquisition';
    }
    
}

?>
