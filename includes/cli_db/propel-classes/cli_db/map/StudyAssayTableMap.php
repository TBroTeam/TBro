<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'study_assay' table.
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
class StudyAssayTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudyAssayTableMap';

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
        $this->setName('study_assay');
        $this->setPhpName('StudyAssay');
        $this->setClassname('cli_db\\propel\\StudyAssay');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('study_assay_study_assay_id_seq');
        // columns
        $this->addPrimaryKey('study_assay_id', 'StudyAssayId', 'INTEGER', true, null, null);
        $this->addForeignKey('study_id', 'StudyId', 'INTEGER', 'study', 'study_id', true, null, null);
        $this->addForeignKey('assay_id', 'AssayId', 'INTEGER', 'assay', 'assay_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::MANY_TO_ONE, array('assay_id' => 'assay_id', ), 'CASCADE', null);
        $this->addRelation('Study', 'cli_db\\propel\\Study', RelationMap::MANY_TO_ONE, array('study_id' => 'study_id', ), 'CASCADE', null);
    } // buildRelations()

} // StudyAssayTableMap
