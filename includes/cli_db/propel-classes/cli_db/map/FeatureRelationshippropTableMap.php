<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_relationshipprop' table.
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
class FeatureRelationshippropTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureRelationshippropTableMap';

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
        $this->setName('feature_relationshipprop');
        $this->setPhpName('FeatureRelationshipprop');
        $this->setClassname('cli_db\\propel\\FeatureRelationshipprop');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_relationshipprop_feature_relationshipprop_id_seq');
        // columns
        $this->addPrimaryKey('feature_relationshipprop_id', 'FeatureRelationshippropId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_relationship_id', 'FeatureRelationshipId', 'INTEGER', 'feature_relationship', 'feature_relationship_id', true, null, null);
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
        $this->addRelation('FeatureRelationship', 'cli_db\\propel\\FeatureRelationship', RelationMap::MANY_TO_ONE, array('feature_relationship_id' => 'feature_relationship_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('FeatureRelationshippropPub', 'cli_db\\propel\\FeatureRelationshippropPub', RelationMap::ONE_TO_MANY, array('feature_relationshipprop_id' => 'feature_relationshipprop_id', ), 'CASCADE', null, 'FeatureRelationshippropPubs');
    } // buildRelations()

} // FeatureRelationshippropTableMap
