<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'protocolparam' table.
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
class ProtocolparamTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProtocolparamTableMap';

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
        $this->setName('protocolparam');
        $this->setPhpName('Protocolparam');
        $this->setClassname('cli_db\\propel\\Protocolparam');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('protocolparam_protocolparam_id_seq');
        // columns
        $this->addPrimaryKey('protocolparam_id', 'ProtocolparamId', 'INTEGER', true, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', true, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addForeignKey('datatype_id', 'DatatypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addForeignKey('unittype_id', 'UnittypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CvtermRelatedByDatatypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('datatype_id' => 'cvterm_id', ), 'SET NULL', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedByUnittypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('unittype_id' => 'cvterm_id', ), 'SET NULL', null);
    } // buildRelations()

} // ProtocolparamTableMap
