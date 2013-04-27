<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'magedocumentation' table.
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
class MagedocumentationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.MagedocumentationTableMap';

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
        $this->setName('magedocumentation');
        $this->setPhpName('Magedocumentation');
        $this->setClassname('cli_db\\propel\\Magedocumentation');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('magedocumentation_magedocumentation_id_seq');
        // columns
        $this->addPrimaryKey('magedocumentation_id', 'MagedocumentationId', 'INTEGER', true, null, null);
        $this->addForeignKey('mageml_id', 'MagemlId', 'INTEGER', 'mageml', 'mageml_id', true, null, null);
        $this->addForeignKey('tableinfo_id', 'TableinfoId', 'INTEGER', 'tableinfo', 'tableinfo_id', true, null, null);
        $this->addColumn('row_id', 'RowId', 'INTEGER', true, null, null);
        $this->addColumn('mageidentifier', 'Mageidentifier', 'LONGVARCHAR', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Mageml', 'cli_db\\propel\\Mageml', RelationMap::MANY_TO_ONE, array('mageml_id' => 'mageml_id', ), 'CASCADE', null);
        $this->addRelation('Tableinfo', 'cli_db\\propel\\Tableinfo', RelationMap::MANY_TO_ONE, array('tableinfo_id' => 'tableinfo_id', ), 'CASCADE', null);
    } // buildRelations()

} // MagedocumentationTableMap
