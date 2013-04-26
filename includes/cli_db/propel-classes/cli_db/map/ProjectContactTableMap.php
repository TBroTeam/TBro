<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_contact' table.
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
class ProjectContactTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProjectContactTableMap';

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
        $this->setName('project_contact');
        $this->setPhpName('ProjectContact');
        $this->setClassname('cli_db\\propel\\ProjectContact');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('project_contact_project_contact_id_seq');
        // columns
        $this->addPrimaryKey('project_contact_id', 'ProjectContactId', 'INTEGER', true, null, null);
        $this->addForeignKey('project_id', 'ProjectId', 'INTEGER', 'project', 'project_id', true, null, null);
        $this->addForeignKey('contact_id', 'ContactId', 'INTEGER', 'contact', 'contact_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('contact_id' => 'contact_id', ), 'CASCADE', null);
        $this->addRelation('Project', 'cli_db\\propel\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'project_id', ), 'CASCADE', null);
    } // buildRelations()

} // ProjectContactTableMap
