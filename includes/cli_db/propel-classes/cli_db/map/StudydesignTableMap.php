<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'studydesign' table.
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
class StudydesignTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudydesignTableMap';

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
        $this->setName('studydesign');
        $this->setPhpName('Studydesign');
        $this->setClassname('cli_db\\propel\\Studydesign');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('studydesign_studydesign_id_seq');
        // columns
        $this->addPrimaryKey('studydesign_id', 'StudydesignId', 'INTEGER', true, null, null);
        $this->addForeignKey('study_id', 'StudyId', 'INTEGER', 'study', 'study_id', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Study', 'cli_db\\propel\\Study', RelationMap::MANY_TO_ONE, array('study_id' => 'study_id', ), 'CASCADE', null);
        $this->addRelation('Studydesignprop', 'cli_db\\propel\\Studydesignprop', RelationMap::ONE_TO_MANY, array('studydesign_id' => 'studydesign_id', ), 'CASCADE', null, 'Studydesignprops');
        $this->addRelation('Studyfactor', 'cli_db\\propel\\Studyfactor', RelationMap::ONE_TO_MANY, array('studydesign_id' => 'studydesign_id', ), 'CASCADE', null, 'Studyfactors');
    } // buildRelations()

} // StudydesignTableMap
