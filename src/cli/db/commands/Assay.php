<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Assay extends AbstractTable {

    /**
     * @inheritDoc
     */
    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'AssayId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                    'link_biomaterial_sample' => 'required',
                    'unlink_biomaterial_sample' => 'required',
                ),
                'description' => 'assay id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'name (unique)'
            ),
            'description' => array(
                'colname' => 'Description',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'description'
            ),
            'protocol_id' => array(
                'colname' => 'ProtocolId',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'protocol id'
            ),
            'assaydate' => array(
                'colname' => 'Assaydate',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'date of assay gathering'
            ),
            'operator_id' => array(
                'colname' => 'OperatorId',
                'actions' => array(
                    'insert' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'contact id'
            ),
            'biomaterial_id' => array(
                'actions' => array(
                    'link_biomaterial_sample' => 'required',
                    'unlink_biomaterial_sample' => 'required',
                ),
                'description' => 'biomaterial id'
            ),
        );
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandDescription() {
        return 'Manipulate assays.';
    }

    /**
     * @inheritDoc
     */
    public static function CLI_commandName() {
        return 'assay';
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
        return array('insert', 'update', 'delete', 'details', 'list', 'link_biomaterial_sample', 'unlink_biomaterial_sample');
    }

    /**
     * @inheritDoc
     */
    public static function getPropelClass() {
        return '\\cli_db\\propel\\Assay';
    }

    /**
     * @inheritDoc
     */
    protected static function command_insert_set_defaults(\BaseObject $item) {
        // satisfy NOT NULL constraint
        $item->setArraydesignId(1);
    }

    /**
     * @inheritDoc
     * overwritten to show linked samples
     */
    protected static function command_details($options, $keys) {
        parent::command_details($options, $keys);

        $q = new propel\AssayQuery();
        $assay = $q->findOneByAssayId($options['id']);

        $references = array();
        foreach ($assay->getAssayBiomaterialsJoinBiomaterial() as $ass_b) {
            $biomat = $ass_b->getBiomaterial();
            $references[] = array('Sample', sprintf("Id: %s\nName: %s", $biomat->getBiomaterialId(), $biomat->getName()));
        }
        if (count($references) > 0) {
            print "linked Samples:\n";
            self::printTable(array('Table', 'Row'), $references);
        }
    }

    /**
     * links given biomaterial sample against this assay
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     * @return type
     */
    protected static function command_link_biomaterial_sample($options, $keys) {
        $ass_b = new propel\AssayBiomaterial();
        $ass_b->setAssayId($options['id']);
        $ass_b->setBiomaterialId($options['biomaterial_id']);
        $lines = $ass_b->save();
        printf("%d line(s) inserted.\n", $lines);

        return array($ass_b, $lines);
    }

    /**
     * unlinks given biomaterial sample from this assay
     * @param Array $options user-specified command line parameters
     * @param Array $keys result from self::getKeys()
     * @return type
     */
    protected static function command_unlink_biomaterial_sample($options, $keys) {
        $ass_b_q = new propel\AssayBiomaterialQuery();
        $ass_b_q->filterByAssayId($options['id']);
        $ass_b_q->filterByBiomaterialId($options['biomaterial_id']);
        $ass_b = $ass_b_q->findOne();
        if ($ass_b == null) {
            trigger_error(sprintf("No relationship between assay %d and biomaterial %d found.\n", $options['id'], $options['biomaterial_id']), E_USER_ERROR);
        }
        $ass_b->delete();
        printf("Relationship between assay %d and biomaterial %d deleted successfully.\n", $ass_b->getAssayId(), $ass_b->getBiomaterialId());

        return $ass_b;
    }

}

?>
