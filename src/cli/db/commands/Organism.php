<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Organism extends AbstractTable {

    /**
     * @inheritDoc
     */
    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'OrganismId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'organism id'
            ),
            'abbreviation' => array(
                'colname' => 'Abbreviation',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'e.g. H.sapiens'
            ),
            'genus' => array(
                'colname' => 'Genus',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'required',
                ),
                'description' => 'e.g. Homo'
            ),
            'species' => array(
                'colname' => 'Species',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'required',
                ),
                'description' => "e.g. sapiens\nNote: the combination of genus and species need to be unique!"
            ),
            'common_name' => array(
                'colname' => 'CommonName',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'required',
                ),
                'description' => 'e.g. human'
            ),
            'comment' => array(
                'colname' => 'Comment',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'some comment'
            ),
        );
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'Manipulate organisms.';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'organism';
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
        return '\\cli_db\\propel\\Organism';
    }

}

?>
