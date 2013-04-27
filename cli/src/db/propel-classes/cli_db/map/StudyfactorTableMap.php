<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'studyfactor' table.
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
class StudyfactorTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudyfactorTableMap';

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
        $this->setName('studyfactor');
        $this->setPhpName('Studyfactor');
        $this->setClassname('cli_db\\propel\\Studyfactor');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('studyfactor_studyfactor_id_seq');
        // columns
        $this->addPrimaryKey('studyfactor_id', 'StudyfactorId', 'INTEGER', true, null, null);
        $this->addForeignKey('studydesign_id', 'StudydesignId', 'INTEGER', 'studydesign', 'studydesign_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Studydesign', 'cli_db\\propel\\Studydesign', RelationMap::MANY_TO_ONE, array('studydesign_id' => 'studydesign_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'SET NULL', null);
        $this->addRelation('Studyfactorvalue', 'cli_db\\propel\\Studyfactorvalue', RelationMap::ONE_TO_MANY, array('studyfactor_id' => 'studyfactor_id', ), 'CASCADE', null, 'Studyfactorvalues');
    } // buildRelations()

} // StudyfactorTableMap
