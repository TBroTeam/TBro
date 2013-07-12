<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Quantification extends AbstractTable {

    /**
     * @inheritDoc
     */
    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'QuantificationId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'quantification id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => "name\nNote: the combination of quantification name and analysis id has to be unique!"
            ),
            'uri' => array(
                'colname' => 'Uri',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'uri'
            ),
            'acquisition_id' => array(
                'colname' => 'AcquisitionId',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'acquisition id'
            ),
            'operator_id' => array(
                'colname' => 'OperatorId',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'contact id'
            ),
            'protocol_id' => array(
                'colname' => 'ProtocolId',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'protocol id'
            ),
            'analysis_id' => array(
                'colname' => 'AnalysisId',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'analysis id'
            ),
            'quantificationdate' => array(
                'colname' => 'Quantificationdate',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'time of quantification'
            ),
        );
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'Manipulate quantifications.';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'quantification';
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
        return '\\cli_db\\propel\\Quantification';
    }

}

?>
