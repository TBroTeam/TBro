<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'featureloc_pub' table.
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
class FeaturelocPubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeaturelocPubTableMap';

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
        $this->setName('featureloc_pub');
        $this->setPhpName('FeaturelocPub');
        $this->setClassname('cli_db\\propel\\FeaturelocPub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('featureloc_pub_featureloc_pub_id_seq');
        // columns
        $this->addPrimaryKey('featureloc_pub_id', 'FeaturelocPubId', 'INTEGER', true, null, null);
        $this->addForeignKey('featureloc_id', 'FeaturelocId', 'INTEGER', 'featureloc', 'featureloc_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Featureloc', 'cli_db\\propel\\Featureloc', RelationMap::MANY_TO_ONE, array('featureloc_id' => 'featureloc_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeaturelocPubTableMap
