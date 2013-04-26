<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'biomaterial_treatment' table.
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
class BiomaterialTreatmentTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.BiomaterialTreatmentTableMap';

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
        $this->setName('biomaterial_treatment');
        $this->setPhpName('BiomaterialTreatment');
        $this->setClassname('cli_db\\propel\\BiomaterialTreatment');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('biomaterial_treatment_biomaterial_treatment_id_seq');
        // columns
        $this->addPrimaryKey('biomaterial_treatment_id', 'BiomaterialTreatmentId', 'INTEGER', true, null, null);
        $this->addForeignKey('biomaterial_id', 'BiomaterialId', 'INTEGER', 'biomaterial', 'biomaterial_id', true, null, null);
        $this->addForeignKey('treatment_id', 'TreatmentId', 'INTEGER', 'treatment', 'treatment_id', true, null, null);
        $this->addForeignKey('unittype_id', 'UnittypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addColumn('value', 'Value', 'FLOAT', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::MANY_TO_ONE, array('biomaterial_id' => 'biomaterial_id', ), 'CASCADE', null);
        $this->addRelation('Treatment', 'cli_db\\propel\\Treatment', RelationMap::MANY_TO_ONE, array('treatment_id' => 'treatment_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('unittype_id' => 'cvterm_id', ), 'SET NULL', null);
    } // buildRelations()

} // BiomaterialTreatmentTableMap
