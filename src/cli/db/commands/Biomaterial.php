<?php

namespace cli_db;

require_once ROOT . 'classes/AbstractTable.php';

class Biomaterial extends AbstractTable {

    public static function getKeys() {
        return array(
            'id' => array(
                'colname' => 'BiomaterialId',
                'actions' => array(
                    'details' => 'required',
                    'update' => 'required',
                    'delete' => 'required',
                ),
                'description' => 'biomaterial id'
            ),
            'name' => array(
                'colname' => 'Name',
                'actions' => array(
                    'insert' => 'required',
                    'add_condition' => 'required',
                    'add_condition_sample' => 'required',
                    'update' => 'optional',
                ),
                'description' => 'name'
            ),
            'description' => array(
                'colname' => 'Description',
                'actions' => array(
                    'insert' => 'optional',
                    'add_condition' => 'optional',
                    'add_condition_sample' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'description'
            ),
            'organism_id' => array(
                'colname' => 'TaxonId',
                'actions' => array(
                    'insert' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'organism id'
            ),
            'biosourceprovider_id' => array(
                'colname' => 'BiosourceproviderId',
                'actions' => array(
                    'insert' => 'optional',
                    'add_condition' => 'optional',
                    'add_condition_sample' => 'optional',
                    'update' => 'optional',
                ),
                'description' => 'contact id'
            ),
            'short' => array(
                'actions' => array(
                    'insert' => 'optional',
                    'add_condition' => 'optional',
                    'add_condition_sample' => 'optional',
                ),
                'description' => 'if set, will just output the ID of newly inserted line on success',
                'action' => 'StoreTrue'
            ),
            'parent_biomaterial_name' => array(
                'actions' => array(
                    'add_condition' => 'required',
                ),
                'description' => 'parent biomaterial name'
            ),
            'parent_condition_name' => array(
                'actions' => array(
                    'add_condition_sample' => 'required',
                ),
                'description' => 'parent condition name'
            ),
            'type' => array('colname' => 'Type'),
            'parent' => array('colname' => 'Parent')
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate biomaterials, conditions and samples.';
    }

    public static function CLI_commandName() {
        return 'biomaterial';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list', 'add_condition', 'add_condition_sample');
    }

    protected static function command_insert($options, $keys) {
        $biomat = new propel\Biomaterial();
        self::setKeys($options, $keys, 'insert', $biomat);

        $lines = $biomat->save();
        $biomat->setType('biomaterial');
        $lines += $biomat->save();

        if (isset($options['short']) && $options['short'])
            print $biomat->getPrimaryKey();
        else
            printf("%d line(s) inserted.\n", $lines);
    }

    protected static function command_add_condition($options, $keys) {
        $parent = propel\BiomaterialQuery::create()->findOneByName($options['parent_biomaterial_name']);
        if ($parent == null)
            trigger_error('This parent Biomaterial does not exist!', E_USER_ERROR);
        if ($parent->getType() != 'biomaterial')
            trigger_error('Specified parent is of wrong type!' . $parent->getType(), E_USER_ERROR);


        $biomat = new propel\Biomaterial();
        self::setKeys($options, $keys, 'insert', $biomat);

        $lines = $biomat->save();
        $biomat->setType('condition');
        $biomat->setParent($parent);
        $lines += $biomat->save();

        if (isset($options['short']) && $options['short'])
            print $biomat->getPrimaryKey();
        else
            printf("%d line(s) inserted.\n", $lines);
    }

    protected static function command_add_condition_sample($options, $keys) {
        $parent = propel\BiomaterialQuery::create()->findOneByName($options['parent_condition_name']);
        if ($parent == null)
            trigger_error('This parent Biomaterial does not exist!', E_USER_ERROR);
        if ($parent->getType() != 'condition')
            trigger_error('Specified parent is of wrong type!', E_USER_ERROR);

        $biomat = new propel\Biomaterial();
        self::setKeys($options, $keys, 'insert', $biomat);

        $lines = $biomat->save();
        $biomat->setType('condition_sample');
        $biomat->setParent($parent);
        $lines += $biomat->save();

        if (isset($options['short']) && $options['short'])
            print $biomat->getPrimaryKey();
        else
            printf("%d line(s) inserted.\n", $lines);
    }

    protected static function command_details($options, $keys) {
        parent::command_details($options, $keys);

        $references = array();

        $child_relationships = propel\BiomaterialRelationshipQuery::create()->findByObjectId($options['id']);
        foreach ($child_relationships as $child_relationship) {
            $child = $child_relationship->getBiomaterialRelatedBySubjectId();
            $references[] = array($child->getType(), sprintf("Id: %s\nName: %s", $child->getBiomaterialId(), $child->getName()));
        }

        if (count($references) > 0) {
            print "has relationships:\n";
            self::printTable(array('', 'Row'), $references);
        }
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Biomaterial';
    }

}

?>
