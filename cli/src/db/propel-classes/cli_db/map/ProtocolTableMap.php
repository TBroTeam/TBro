<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'protocol' table.
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
class ProtocolTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProtocolTableMap';

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
        $this->setName('protocol');
        $this->setPhpName('Protocol');
        $this->setClassname('cli_db\\propel\\Protocol');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('protocol_protocol_id_seq');
        // columns
        $this->addPrimaryKey('protocol_id', 'ProtocolId', 'INTEGER', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', false, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('uri', 'Uri', 'LONGVARCHAR', false, null, null);
        $this->addColumn('protocoldescription', 'Protocoldescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('hardwaredescription', 'Hardwaredescription', 'LONGVARCHAR', false, null, null);
        $this->addColumn('softwaredescription', 'Softwaredescription', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'SET NULL', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('Acquisition', 'cli_db\\propel\\Acquisition', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'SET NULL', null, 'Acquisitions');
        $this->addRelation('Arraydesign', 'cli_db\\propel\\Arraydesign', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'SET NULL', null, 'Arraydesigns');
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'SET NULL', null, 'Assays');
        $this->addRelation('Protocolparam', 'cli_db\\propel\\Protocolparam', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'CASCADE', null, 'Protocolparams');
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'SET NULL', null, 'Quantifications');
        $this->addRelation('Treatment', 'cli_db\\propel\\Treatment', RelationMap::ONE_TO_MANY, array('protocol_id' => 'protocol_id', ), 'SET NULL', null, 'Treatments');
    } // buildRelations()

} // ProtocolTableMap
