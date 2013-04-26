<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'channel' table.
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
class ChannelTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ChannelTableMap';

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
        $this->setName('channel');
        $this->setPhpName('Channel');
        $this->setClassname('cli_db\\propel\\Channel');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('channel_channel_id_seq');
        // columns
        $this->addPrimaryKey('channel_id', 'ChannelId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('definition', 'Definition', 'LONGVARCHAR', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Acquisition', 'cli_db\\propel\\Acquisition', RelationMap::ONE_TO_MANY, array('channel_id' => 'channel_id', ), 'SET NULL', null, 'Acquisitions');
        $this->addRelation('AssayBiomaterial', 'cli_db\\propel\\AssayBiomaterial', RelationMap::ONE_TO_MANY, array('channel_id' => 'channel_id', ), 'SET NULL', null, 'AssayBiomaterials');
    } // buildRelations()

} // ChannelTableMap
