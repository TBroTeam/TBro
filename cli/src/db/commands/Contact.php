<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Contact extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'ContactId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'contact id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'name'
            ),
            'description' => array(
                'colname' => 'Description',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'description'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate the database contacts.';
    }

    public static function CLI_commandName() {
        return 'contact';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list');
    }


    protected static function command_details($options, $keys) {
        parent::command_details($options, $keys);

        $q = new \cli_db\propel\ContactQuery();
        $contact = $q->findOneByContactId($options['id']);

        $references = array();
        foreach ($contact->getBiomaterials() as $biomat) {
            $references[] = array('Biomaterial', sprintf("Id: %s\nName: %s", $biomat->getBiomaterialId(), $biomat->getName()));
        }
        foreach ($contact->getAssays() as $assay) {
            $references[] = array('Assay', sprintf("Id: %s\nName: %s", $assay->getAssayId(), $assay->getName()));
        }
        foreach ($contact->getQuantifications() as $assay) {
            $references[] = array('Quantification', sprintf("Id: %s\nName: %s", $assay->getQuantificationId(), $assay->getName()));
        }
        if (count($references) > 0) {
            print "referenced by other tables:\n";
            self::printTable(array('Table', 'Row'), $references);
        }
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Contact';
    }

}

?>
