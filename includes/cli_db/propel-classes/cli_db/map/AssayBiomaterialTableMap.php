<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'assay_biomaterial' table.
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
class AssayBiomaterialTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AssayBiomaterialTableMap';

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
        $this->setName('assay_biomaterial');
        $this->setPhpName('AssayBiomaterial');
        $this->setClassname('cli_db\\propel\\AssayBiomaterial');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('assay_biomaterial_assay_biomaterial_id_seq');
        // columns
        $this->addPrimaryKey('assay_biomaterial_id', 'AssayBiomaterialId', 'INTEGER', true, null, null);
        $this->addForeignKey('assay_id', 'AssayId', 'INTEGER', 'assay', 'assay_id', true, null, null);
        $this->addForeignKey('biomaterial_id', 'BiomaterialId', 'INTEGER', 'biomaterial', 'biomaterial_id', true, null, null);
        $this->addForeignKey('channel_id', 'ChannelId', 'INTEGER', 'channel', 'channel_id', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::MANY_TO_ONE, array('assay_id' => 'assay_id', ), 'CASCADE', null);
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::MANY_TO_ONE, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null);
        $this->addRelation('Channel', 'cli_db\\propel\\Channel', RelationMap::MANY_TO_ONE, array('channel_id' => 'channel_id', ), 'SET NULL', null);
    } // buildRelations()

} // AssayBiomaterialTableMap
