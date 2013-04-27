<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'studyprop' table.
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
class StudypropTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudypropTableMap';

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
        $this->setName('studyprop');
        $this->setPhpName('Studyprop');
        $this->setClassname('cli_db\\propel\\Studyprop');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('studyprop_studyprop_id_seq');
        // columns
        $this->addPrimaryKey('studyprop_id', 'StudypropId', 'INTEGER', true, null, null);
        $this->addForeignKey('study_id', 'StudyId', 'INTEGER', 'study', 'study_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('value', 'Value', 'LONGVARCHAR', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Study', 'cli_db\\propel\\Study', RelationMap::MANY_TO_ONE, array('study_id' => 'study_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('StudypropFeature', 'cli_db\\propel\\StudypropFeature', RelationMap::ONE_TO_MANY, array('studyprop_id' => 'studyprop_id', ), 'CASCADE', null, 'StudypropFeatures');
    } // buildRelations()

} // StudypropTableMap
