<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'cvtermsynonym' table.
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
class CvtermsynonymTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.CvtermsynonymTableMap';

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
        $this->setName('cvtermsynonym');
        $this->setPhpName('Cvtermsynonym');
        $this->setClassname('cli_db\\propel\\Cvtermsynonym');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('cvtermsynonym_cvtermsynonym_id_seq');
        // columns
        $this->addPrimaryKey('cvtermsynonym_id', 'CvtermsynonymId', 'INTEGER', true, null, null);
        $this->addForeignKey('cvterm_id', 'CvtermId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('synonym', 'Synonym', 'VARCHAR', true, 1024, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('CvtermRelatedByCvtermId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('CvtermRelatedByTypeId', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
    } // buildRelations()

} // CvtermsynonymTableMap
