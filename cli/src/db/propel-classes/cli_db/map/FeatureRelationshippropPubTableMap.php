<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_relationshipprop_pub' table.
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
class FeatureRelationshippropPubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureRelationshippropPubTableMap';

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
        $this->setName('feature_relationshipprop_pub');
        $this->setPhpName('FeatureRelationshippropPub');
        $this->setClassname('cli_db\\propel\\FeatureRelationshippropPub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_relationshipprop_pub_feature_relationshipprop_pub_id_seq');
        // columns
        $this->addPrimaryKey('feature_relationshipprop_pub_id', 'FeatureRelationshippropPubId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_relationshipprop_id', 'FeatureRelationshippropId', 'INTEGER', 'feature_relationshipprop', 'feature_relationshipprop_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FeatureRelationshipprop', 'cli_db\\propel\\FeatureRelationshipprop', RelationMap::MANY_TO_ONE, array('feature_relationshipprop_id' => 'feature_relationshipprop_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeatureRelationshippropPubTableMap
