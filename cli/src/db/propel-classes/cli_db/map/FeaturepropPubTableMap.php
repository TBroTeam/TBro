<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'featureprop_pub' table.
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
class FeaturepropPubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeaturepropPubTableMap';

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
        $this->setName('featureprop_pub');
        $this->setPhpName('FeaturepropPub');
        $this->setClassname('cli_db\\propel\\FeaturepropPub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('featureprop_pub_featureprop_pub_id_seq');
        // columns
        $this->addPrimaryKey('featureprop_pub_id', 'FeaturepropPubId', 'INTEGER', true, null, null);
        $this->addForeignKey('featureprop_id', 'FeaturepropId', 'INTEGER', 'featureprop', 'featureprop_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Featureprop', 'cli_db\\propel\\Featureprop', RelationMap::MANY_TO_ONE, array('featureprop_id' => 'featureprop_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeaturepropPubTableMap
