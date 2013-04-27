<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_relationship' table.
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
class FeatureRelationshipTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureRelationshipTableMap';

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
        $this->setName('feature_relationship');
        $this->setPhpName('FeatureRelationship');
        $this->setClassname('cli_db\\propel\\FeatureRelationship');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_relationship_feature_relationship_id_seq');
        // columns
        $this->addPrimaryKey('feature_relationship_id', 'FeatureRelationshipId', 'INTEGER', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('object_id', 'ObjectId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FeatureRelatedByObjectId', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('object_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('FeatureRelatedBySubjectId', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('subject_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('FeatureRelationshipPub', 'cli_db\\propel\\FeatureRelationshipPub', RelationMap::ONE_TO_MANY, array('feature_relationship_id' => 'feature_relationship_id', ), 'CASCADE', null, 'FeatureRelationshipPubs');
        $this->addRelation('FeatureRelationshipprop', 'cli_db\\propel\\FeatureRelationshipprop', RelationMap::ONE_TO_MANY, array('feature_relationship_id' => 'feature_relationship_id', ), 'CASCADE', null, 'FeatureRelationshipprops');
    } // buildRelations()

} // FeatureRelationshipTableMap
