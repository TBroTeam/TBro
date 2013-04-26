<?php

namespace cli_db;

require_once __DIR__ . '/AbstractTable.php';

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

    public static function executeCommand($options, $command_name) {
        $keys = self::getKeys();
        switch ($command_name) {
            case 'insert':
                $biomaterial = new propel\Biomaterial();
                $biomaterial->setName($options['name']);
                isset($options['description']) && $biomaterial->setDescription($options['description']);
                isset($options['organism_id']) && $biomaterial->setTaxonId($options['organism_id']);
                isset($options['biosourceprovider_id']) && $biomaterial->setBiosourceproviderId($options['biosourceprovider_id']);
                $lines = $biomaterial->save();
                printf("%d line(s) inserted.\n", $lines);
                break;
            case 'update':
                $bq = new propel\BiomaterialQuery();
                $biomaterial = $bq->findOneByBiomaterialId($options['id']);
                if ($biomaterial == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }
                isset($options['name']) && $biomaterial->setName($options['name']);
                isset($options['description']) && $biomaterial->setDescription($options['description']);
                isset($options['organism_id']) && $biomaterial->setTaxonId($options['organism_id']);
                isset($options['biosourceprovider_id']) && $biomaterial->setBiosourceproviderId($options['biosourceprovider_id']);
                $lines = $biomaterial->save();
                printf("%d line(s) udpated.\n", $lines);
                break;
            case 'delete':
                $bq = new propel\BiomaterialQuery();
                $biomaterial = $bq->findOneByBiomaterialId($options['id']);
                if ($biomaterial == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }
                $biomaterial->delete();
                printf("Contact with id %d deleted successfully.\n", $biomaterial->getContactId());
                break;
            case 'details':
                $bq = new propel\BiomaterialQuery();
                $biomaterial = $bq->findOneByBiomaterialId($options['id']);
                if ($biomaterial == null) {
                    printf("No contact found for id %d.\n", $options['id']);
                    break;
                }

                $table_keys = array_keys(array_filter($keys,
                                function($val) {
                                    return isset($val['colname']);
                                }));
                $results = self::prepareQueryResult(array($biomaterial));
                self::printTable($table_keys, $results);

                $references = array();
                $brqp = new propel\BiomaterialRelationshipQuery();
                $parent_relationships = $brqp->findBySubjectId($biomaterial->getBiomaterialId());

                foreach ($parent_relationships as $parent_relationship) {
                    $parent = $parent_relationship->getBiomaterialRelatedByObjectId();
                    $references[] = array('Parent Biomaterial', sprintf("Id: %s\nName: %s", $parent->getBiomaterialId(), $parent->getName()));
                }

                $brqc = new propel\BiomaterialRelationshipQuery();
                $child_relationships = $brqc->findByObjectId($biomaterial->getBiomaterialId());
                foreach ($child_relationships as $child_relationship) {
                    $child = $child_relationship->getBiomaterialRelatedBySubjectId();
                    $references[] = array('Child Biomaterial', sprintf("Id: %s\nName: %s", $child->getBiomaterialId(), $child->getName()));
                }

                if (count($references) > 0) {
                    print "Has Child/Parent relationships:\n";
                    self::printTable(array('', 'Row'), $references);
                }
                break;
            case 'list':
                $bq = new propel\BiomaterialQuery();
                $results = self::prepareQueryResult($bq->find());
                self::printTable(array_keys($keys), $results);
                break;
            case 'add_parent':
                $brp = new propel\BiomaterialRelationship();
                $brp->setSubjectId($options['id']);
                $brp->setTypeId(CV_BIOMATERIAL_ISA);
                $brp->setObjectId($options['parent_id']);
                $lines = $brp->save();
                printf("%d line(s) inserted.\n", $lines);
                break;
            case 'add_child':
                $brc = new propel\BiomaterialRelationship();
                $brc->setSubjectId($options['child_id']);
                $brc->setTypeId(CV_BIOMATERIAL_ISA);
                $brc->setObjectId($options['id']);
                $lines = $brc->save();
                printf("%d line(s) inserted.\n", $lines);
                break;

            case 'remove_parent':
                $brqp = new propel\BiomaterialRelationshipQuery();
                $brqp->filterBySubjectId($options['id']);
                $brqp->filterByObjectId($options['parent_id']);
                $brp = $brqp->findOne();
                if ($brp == null) {
                    printf("No relationship between parent %d and child %d found.\n", $options['parent_id'], $options['id']);
                    break;
                }
                $brp->delete();
                printf("Relationship between parent %d and child %d deleted successfully.\n", $brp->getObjectId(), $brp->getSubjectId());
                break;
            case 'remove_child':
                $brqc = new propel\BiomaterialRelationshipQuery();
                $brqc->filterBySubjectId($options['child_id']);
                $brqc->filterByObjectId($options['id']);
                $brc = $brqc->findOne();
                if ($brc == null) {
                    printf("No relationship between parent %d and child %d found.\n", $options['id'], $options['child_id']);
                    break;
                }
                $brc->delete();
                printf("Relationship between parent %d and child %d deleted successfully.\n", $brc->getObjectId(), $brc->getSubjectId());
                break;
        }
    }

}

?>
