<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'arraydesign' table.
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
class ArraydesignTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ArraydesignTableMap';

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
        $this->setName('arraydesign');
        $this->setPhpName('Arraydesign');
        $this->setClassname('cli_db\\propel\\Arraydesign');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('arraydesign_arraydesign_id_seq');
        // columns
        $this->addPrimaryKey('arraydesign_id', 'ArraydesignId', 'INTEGER', true, null, null);
        $this->addForeignKey('manufacturer_id', 'ManufacturerId', 'INTEGER', 'contact', 'contact_id', true, null, null);
        $this->addForeignKey('platformtype_id', 'PlatformtypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('substratetype_id', 'SubstratetypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', false, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('version', 'Version', 'LONGVARCHAR', false, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('array_dimensions', 'ArrayDimensions', 'LONGVARCHAR', false, null, null);
        $this->addColumn('element_dimensions', 'ElementDimensions', 'LONGVARCHAR', false, null, null);
        $this->addColumn('num_of_elements', 'NumOfElements', 'INTEGER', false, null, null);
        $this->addColumn('num_array_columns', 'NumArrayColumns', 'INTEGER', false, null, null);
        $this->addColumn('num_array_rows', 'NumArrayRows', 'INTEGER', false, null, null);
        $this->addColumn('num_grid_columns', 'NumGridColumns', 'INTEGER', false, null, null);
        $this->addColumn('num_grid_rows', 'NumGridRows', 'INTEGER', false, null, null);
        $this->addColumn('num_sub_columns', 'NumSubColumns', 'INTEGER', false, null, null);
        $this->addColumn('num_sub_rows', 'NumSubRows', 'INTEGER', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('manufacturer_id' => 'contact_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedByPlatformtypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('platformtype_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'SET NULL', null);
        $this->addRelation('CvtermRelatedBySubstratetypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('substratetype_id' => 'cvterm_id', ), 'SET NULL', null);
        $this->addRelation('Arraydesignprop', 'cli_db\\propel\\Arraydesignprop', RelationMap::ONE_TO_MANY, array('arraydesign_id' => 'arraydesign_id', ), 'CASCADE', null, 'Arraydesignprops');
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::ONE_TO_MANY, array('arraydesign_id' => 'arraydesign_id', ), 'CASCADE', null, 'Assays');
        $this->addRelation('Element', 'cli_db\\propel\\Element', RelationMap::ONE_TO_MANY, array('arraydesign_id' => 'arraydesign_id', ), 'CASCADE', null, 'Elements');
    } // buildRelations()

} // ArraydesignTableMap
