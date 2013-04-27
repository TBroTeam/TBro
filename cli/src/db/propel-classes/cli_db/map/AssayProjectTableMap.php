<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'assay_project' table.
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
class AssayProjectTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AssayProjectTableMap';

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
        $this->setName('assay_project');
        $this->setPhpName('AssayProject');
        $this->setClassname('cli_db\\propel\\AssayProject');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('assay_project_assay_project_id_seq');
        // columns
        $this->addPrimaryKey('assay_project_id', 'AssayProjectId', 'INTEGER', true, null, null);
        $this->addForeignKey('assay_id', 'AssayId', 'INTEGER', 'assay', 'assay_id', true, null, null);
        $this->addForeignKey('project_id', 'ProjectId', 'INTEGER', 'project', 'project_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::MANY_TO_ONE, array('assay_id' => 'assay_id', ), null, null);
        $this->addRelation('Project', 'cli_db\\propel\\Project', RelationMap::MANY_TO_ONE, array('project_id' => 'project_id', ), null, null);
    } // buildRelations()

} // AssayProjectTableMap
