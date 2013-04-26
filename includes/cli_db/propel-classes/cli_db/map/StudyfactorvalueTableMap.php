<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'studyfactorvalue' table.
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
class StudyfactorvalueTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudyfactorvalueTableMap';

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
        $this->setName('studyfactorvalue');
        $this->setPhpName('Studyfactorvalue');
        $this->setClassname('cli_db\\propel\\Studyfactorvalue');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('studyfactorvalue_studyfactorvalue_id_seq');
        // columns
        $this->addPrimaryKey('studyfactorvalue_id', 'StudyfactorvalueId', 'INTEGER', true, null, null);
        $this->addForeignKey('studyfactor_id', 'StudyfactorId', 'INTEGER', 'studyfactor', 'studyfactor_id', true, null, null);
        $this->addForeignKey('assay_id', 'AssayId', 'INTEGER', 'assay', 'assay_id', true, null, null);
        $this->addColumn('factorvalue', 'Factorvalue', 'LONGVARCHAR', false, null, null);
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::MANY_TO_ONE, array('assay_id' => 'assay_id', ), 'CASCADE', null);
        $this->addRelation('Studyfactor', 'cli_db\\propel\\Studyfactor', RelationMap::MANY_TO_ONE, array('studyfactor_id' => 'studyfactor_id', ), 'CASCADE', null);
    } // buildRelations()

} // StudyfactorvalueTableMap
