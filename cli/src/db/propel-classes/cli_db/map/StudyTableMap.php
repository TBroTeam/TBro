<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'study' table.
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
class StudyTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudyTableMap';

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
        $this->setName('study');
        $this->setPhpName('Study');
        $this->setClassname('cli_db\\propel\\Study');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('study_study_id_seq');
        // columns
        $this->addPrimaryKey('study_id', 'StudyId', 'INTEGER', true, null, null);
        $this->addForeignKey('contact_id', 'ContactId', 'INTEGER', 'contact', 'contact_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', false, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', true, null, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('contact_id' => 'contact_id', ), 'CASCADE', null);
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'SET NULL', null);
        $this->addRelation('StudyAssay', 'cli_db\\propel\\StudyAssay', RelationMap::ONE_TO_MANY, array('study_id' => 'study_id', ), 'CASCADE', null, 'StudyAssays');
        $this->addRelation('Studydesign', 'cli_db\\propel\\Studydesign', RelationMap::ONE_TO_MANY, array('study_id' => 'study_id', ), 'CASCADE', null, 'Studydesigns');
        $this->addRelation('Studyprop', 'cli_db\\propel\\Studyprop', RelationMap::ONE_TO_MANY, array('study_id' => 'study_id', ), 'CASCADE', null, 'Studyprops');
    } // buildRelations()

} // StudyTableMap
