<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Acquisition extends AbstractTable {

    /**
     * @inheritDoc
     */
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
                'description' => 'name (unique)'
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

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'Manipulate acquisitions.';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'acquisition';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_longHelp() {
        
    }

    /**
     * @inheritDoc
     */
    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }

    /**
     * @inheritDoc
     */
    public static function getPropelClass() {
        return '\\cli_db\\propel\\Acquisition';
    }

}

?>
