<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'tableinfo' table.
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
class TableinfoTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.TableinfoTableMap';

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
        $this->setName('tableinfo');
        $this->setPhpName('Tableinfo');
        $this->setClassname('cli_db\\propel\\Tableinfo');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('tableinfo_tableinfo_id_seq');
        // columns
        $this->addPrimaryKey('tableinfo_id', 'TableinfoId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 30, null);
        $this->addColumn('primary_key_column', 'PrimaryKeyColumn', 'VARCHAR', false, 30, null);
        $this->addColumn('is_view', 'IsView', 'INTEGER', true, null, 0);
        $this->addColumn('view_on_table_id', 'ViewOnTableId', 'INTEGER', false, null, null);
        $this->addColumn('superclass_table_id', 'SuperclassTableId', 'INTEGER', false, null, null);
        $this->addColumn('is_updateable', 'IsUpdateable', 'INTEGER', true, null, 1);
        $this->addColumn('modification_date', 'ModificationDate', 'DATE', true, null, 'now()');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Control', 'cli_db\\propel\\Control', RelationMap::ONE_TO_MANY, array('tableinfo_id' => 'tableinfo_id', ), 'CASCADE', null, 'Controls');
        $this->addRelation('Magedocumentation', 'cli_db\\propel\\Magedocumentation', RelationMap::ONE_TO_MANY, array('tableinfo_id' => 'tableinfo_id', ), 'CASCADE', null, 'Magedocumentations');
    } // buildRelations()

} // TableinfoTableMap
