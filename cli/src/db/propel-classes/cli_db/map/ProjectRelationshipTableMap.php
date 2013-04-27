<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_relationship' table.
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
class ProjectRelationshipTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProjectRelationshipTableMap';

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
        $this->setName('project_relationship');
        $this->setPhpName('ProjectRelationship');
        $this->setClassname('cli_db\\propel\\ProjectRelationship');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('project_relationship_project_relationship_id_seq');
        // columns
        $this->addPrimaryKey('project_relationship_id', 'ProjectRelationshipId', 'INTEGER', true, null, null);
        $this->addForeignKey('subject_project_id', 'SubjectProjectId', 'INTEGER', 'project', 'project_id', true, null, null);
        $this->addForeignKey('object_project_id', 'ObjectProjectId', 'INTEGER', 'project', 'project_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('ProjectRelatedByObjectProjectId', 'cli_db\\propel\\Project', RelationMap::MANY_TO_ONE, array('object_project_id' => 'project_id', ), 'CASCADE', null);
        $this->addRelation('ProjectRelatedBySubjectProjectId', 'cli_db\\propel\\Project', RelationMap::MANY_TO_ONE, array('subject_project_id' => 'project_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'RESTRICT', null);
    } // buildRelations()

} // ProjectRelationshipTableMap
