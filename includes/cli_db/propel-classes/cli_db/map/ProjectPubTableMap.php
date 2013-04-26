<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'project_pub' table.
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
class ProjectPubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ProjectPubTableMap';

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
        $this->setName('project_pub');
        $this->setPhpName('ProjectPub');
        $this->setClassname('cli_db\\propel\\ProjectPub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('project_pub_project_pub_id_seq');
        // columns
        $this->addPrimaryKey('project_pub_id', 'ProjectPubId', 'INTEGER', true, null, null);
        $this->addForeignKey('project_id', 'ProjectId', 'INTEGER', 'project', 'project_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Project', 'cli_db\\propel\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'project_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
    } // buildRelations()

} // ProjectPubTableMap
