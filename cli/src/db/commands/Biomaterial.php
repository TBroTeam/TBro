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
                    'add_parent' => 'required',
                    'add_child' => 'required',
                    'remove_parent' => 'required',
                    'remove_child' => 'required',
                ),
                'description' => 'biomaterial id'
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
                    'update' => 'optional',
                ),
                'description' => 'contact id'
            ),
            'parent_id' => array(
                'actions' => array(
                    'add_parent' => 'required',
                    'remove_parent' => 'required',
                ),
                'description' => 'parent biomaterial id'
            ),
            'child_id' => array(
                'actions' => array(
                    'add_child' => 'required',
                    'remove_child' => 'required',
                ),
                'description' => 'parent biomaterial id'
            ),
        );
    }

    public static function CLI_commandDescription() {
        return 'Manipulate the database biomaterial.';
    }

    public static function CLI_commandName() {
        return 'biomaterial';
    }

    public static function CLI_longHelp() {
        
    }

    public static function getSubCommands() {
        return array('insert', 'update', 'delete', 'details', 'list', 'add_parent', 'add_child', 'remove_parent', 'remove_child');
    }


    protected static function command_details($options, $keys) {
        parent::command_details($options, $keys);

        $references = array();
        $brqp = new propel\BiomaterialRelationshipQuery();
        $parent_relationships = $brqp->findBySubjectId($options['id']);

        foreach ($parent_relationships as $parent_relationship) {
            $parent = $parent_relationship->getBiomaterialRelatedByObjectId();
            $references[] = array('Parent Biomaterial', sprintf("Id: %s\nName: %s", $parent->getBiomaterialId(), $parent->getName()));
        }

        $brqc = new propel\BiomaterialRelationshipQuery();
        $child_relationships = $brqc->findByObjectId($options['id']);
        foreach ($child_relationships as $child_relationship) {
            $child = $child_relationship->getBiomaterialRelatedBySubjectId();
            $references[] = array('Child Biomaterial', sprintf("Id: %s\nName: %s", $child->getBiomaterialId(), $child->getName()));
        }

        if (count($references) > 0) {
            print "Has Child/Parent relationships:\n";
            self::printTable(array('', 'Row'), $references);
        }
    }

    protected static function command_add_parent($options, $keys) {
        $brp = new propel\BiomaterialRelationship();
        $brp->setSubjectId($options['id']);
        $brp->setTypeId(CV_BIOMATERIAL_ISA);
        $brp->setObjectId($options['parent_id']);
        $lines = $brp->save();
        printf("%d line(s) inserted.\n", $lines);

        return array($brp, $lines);
    }

    protected static function command_add_child($options, $keys) {
        $brc = new propel\BiomaterialRelationship();
        $brc->setSubjectId($options['child_id']);
        $brc->setTypeId(CV_BIOMATERIAL_ISA);
        $brc->setObjectId($options['id']);
        $lines = $brc->save();
        printf("%d line(s) inserted.\n", $lines);
    }

    protected static function command_remove_parent($options, $keys) {
        $brqp = new propel\BiomaterialRelationshipQuery();
        $brqp->filterBySubjectId($options['id']);
        $brqp->filterByObjectId($options['parent_id']);
        $brp = $brqp->findOne();
        if ($brp == null) {
            printf("No relationship between parent %d and child %d found.\n", $options['parent_id'], $options['id']);
            return;
        }
        $brp->delete();
        printf("Relationship between parent %d and child %d deleted successfully.\n", $brp->getObjectId(), $brp->getSubjectId());

        return $brp;
    }

    protected static function command_remove_child($options, $keys) {
        $brqc = new propel\BiomaterialRelationshipQuery();
        $brqc->filterBySubjectId($options['child_id']);
        $brqc->filterByObjectId($options['id']);
        $brc = $brqc->findOne();
        if ($brc == null) {
            printf("No relationship between parent %d and child %d found.\n", $options['id'], $options['child_id']);
            return;
        }
        $brc->delete();
        printf("Relationship between parent %d and child %d deleted successfully.\n", $brc->getObjectId(), $brc->getSubjectId());
    }

    public static function getPropelClass() {
        return '\\cli_db\\propel\\Biomaterial';
    }

}

?>
