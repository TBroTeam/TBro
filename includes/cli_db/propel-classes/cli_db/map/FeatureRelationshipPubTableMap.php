<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_relationship_pub' table.
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
class FeatureRelationshipPubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureRelationshipPubTableMap';

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
        $this->setName('feature_relationship_pub');
        $this->setPhpName('FeatureRelationshipPub');
        $this->setClassname('cli_db\\propel\\FeatureRelationshipPub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_relationship_pub_feature_relationship_pub_id_seq');
        // columns
        $this->addPrimaryKey('feature_relationship_pub_id', 'FeatureRelationshipPubId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_relationship_id', 'FeatureRelationshipId', 'INTEGER', 'feature_relationship', 'feature_relationship_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FeatureRelationship', 'cli_db\\propel\\FeatureRelationship', RelationMap::MANY_TO_ONE, array('feature_relationship_id' => 'feature_relationship_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeatureRelationshipPubTableMap
