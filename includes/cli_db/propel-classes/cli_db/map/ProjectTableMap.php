<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project' table.
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
class ProjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProjectTableMap';

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
        $this->setName('project');
        $this->setPhpName('Project');
        $this->setClassname('cli_db\\propel\\Project');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('project_project_id_seq');
        // columns
        $this->addPrimaryKey('project_id', 'ProjectId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', true, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('AssayProject', 'cli_db\\propel\\AssayProject', RelationMap::ONE_TO_MANY, array('project_id' => 'project_id', ), null, null, 'AssayProjects');
        $this->addRelation('ProjectContact', 'cli_db\\propel\\ProjectContact', RelationMap::ONE_TO_MANY, array('project_id' => 'project_id', ), 'CASCADE', null, 'ProjectContacts');
        $this->addRelation('ProjectPub', 'cli_db\\propel\\ProjectPub', RelationMap::ONE_TO_MANY, array('project_id' => 'project_id', ), 'CASCADE', null, 'ProjectPubs');
        $this->addRelation('ProjectRelationshipRelatedByObjectProjectId', 'cli_db\\propel\\ProjectRelationship', RelationMap::ONE_TO_MANY, array('project_id' => 'object_project_id', ), 'CASCADE', null, 'ProjectRelationshipsRelatedByObjectProjectId');
        $this->addRelation('ProjectRelationshipRelatedBySubjectProjectId', 'cli_db\\propel\\ProjectRelationship', RelationMap::ONE_TO_MANY, array('project_id' => 'subject_project_id', ), 'CASCADE', null, 'ProjectRelationshipsRelatedBySubjectProjectId');
        $this->addRelation('Projectprop', 'cli_db\\propel\\Projectprop', RelationMap::ONE_TO_MANY, array('project_id' => 'project_id', ), 'CASCADE', null, 'Projectprops');
    } // buildRelations()

} // ProjectTableMap
