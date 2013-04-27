<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'assay' table.
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
class AssayTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AssayTableMap';

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
        $this->setName('assay');
        $this->setPhpName('Assay');
        $this->setClassname('cli_db\\propel\\Assay');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('assay_assay_id_seq');
        // columns
        $this->addPrimaryKey('assay_id', 'AssayId', 'INTEGER', true, null, null);
        $this->addForeignKey('arraydesign_id', 'ArraydesignId', 'INTEGER', 'arraydesign', 'arraydesign_id', true, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', false, null, null);
        $this->addColumn('assaydate', 'Assaydate', 'TIMESTAMP', false, null, 'now()');
        $this->addColumn('arrayidentifier', 'Arrayidentifier', 'LONGVARCHAR', false, null, null);
        $this->addColumn('arraybatchidentifier', 'Arraybatchidentifier', 'LONGVARCHAR', false, null, null);
        $this->addForeignKey('operator_id', 'OperatorId', 'INTEGER', 'contact', 'contact_id', true, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Arraydesign', 'cli_db\\propel\\Arraydesign', RelationMap::MANY_TO_ONE, array('arraydesign_id' => 'arraydesign_id', ), 'CASCADE', null);
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('operator_id' => 'contact_id', ), 'CASCADE', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'SET NULL', null);
        $this->addRelation('Acquisition', 'cli_db\\propel\\Acquisition', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'Acquisitions');
        $this->addRelation('AssayBiomaterial', 'cli_db\\propel\\AssayBiomaterial', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'AssayBiomaterials');
        $this->addRelation('AssayProject', 'cli_db\\propel\\AssayProject', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), null, null, 'AssayProjects');
        $this->addRelation('Assayprop', 'cli_db\\propel\\Assayprop', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'Assayprops');
        $this->addRelation('Control', 'cli_db\\propel\\Control', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'Controls');
        $this->addRelation('StudyAssay', 'cli_db\\propel\\StudyAssay', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'StudyAssays');
        $this->addRelation('Studyfactorvalue', 'cli_db\\propel\\Studyfactorvalue', RelationMap::ONE_TO_MANY, array('assay_id' => 'assay_id', ), 'CASCADE', null, 'Studyfactorvalues');
    } // buildRelations()

} // AssayTableMap
