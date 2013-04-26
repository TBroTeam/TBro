<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'element' table.
 *
 *
 *
 * This map class is used by Propel to do runtime db structure discovery.
 * For example, the createSelectSql() method checks the type of a given column used in an
 * ORDER BY clause to know whether it needs to apply SQL to make the ORDER BY case-insensitive
 * (i.e. if it's a text column type).
 *
 * @package    propel.generator.cli_db.map
 */
class ElementTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ElementTableMap';

    /**
     * Initialize the table attributes, columns and validators
     * Relations are not initialized by this method since they are lazy loaded
     *
     * @return void
     * @throws PropelException
     */
    public function initialize()
    {
        // attributes
        $this->setName('element');
        $this->setPhpName('Element');
        $this->setClassname('cli_db\\propel\\Element');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('element_element_id_seq');
        // columns
        $this->addPrimaryKey('element_id', 'ElementId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', false, null, null);
        $this->addForeignKey('arraydesign_id', 'ArraydesignId', 'INTEGER', 'arraydesign', 'arraydesign_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Arraydesign', 'cli_db\\propel\\Arraydesign', RelationMap::MANY_TO_ONE, array('arraydesign_id' => 'arraydesign_id', ), 'CASCADE', null);
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'SET NULL', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'SET NULL', null);
        $this->addRelation('ElementRelationshipRelatedByObjectId', 'cli_db\\propel\\ElementRelationship', RelationMap::ONE_TO_MANY, array('element_id' => 'object_id', ), null, null, 'ElementRelationshipsRelatedByObjectId');
        $this->addRelation('ElementRelationshipRelatedBySubjectId', 'cli_db\\propel\\ElementRelationship', RelationMap::ONE_TO_MANY, array('element_id' => 'subject_id', ), null, null, 'ElementRelationshipsRelatedBySubjectId');
        $this->addRelation('Elementresult', 'cli_db\\propel\\Elementresult', RelationMap::ONE_TO_MANY, array('element_id' => 'element_id', ), 'CASCADE', null, 'Elementresults');
    } // buildRelations()

} // ElementTableMap
