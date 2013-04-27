<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'cv' table.
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
class CvTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.CvTableMap';

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
        $this->setName('cv');
        $this->setPhpName('Cv');
        $this->setClassname('cli_db\\propel\\Cv');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('cv_cv_id_seq');
        // columns
        $this->addPrimaryKey('cv_id', 'CvId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('definition', 'Definition', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cvprop', 'cli_db\\propel\\Cvprop', RelationMap::ONE_TO_MANY, array('cv_id' => 'cv_id', ), null, null, 'Cvprops');
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::ONE_TO_MANY, array('cv_id' => 'cv_id', ), 'CASCADE', null, 'Cvterms');
        $this->addRelation('Cvtermpath', 'cli_db\\propel\\Cvtermpath', RelationMap::ONE_TO_MANY, array('cv_id' => 'cv_id', ), 'CASCADE', null, 'Cvtermpaths');
    } // buildRelations()

} // CvTableMap
