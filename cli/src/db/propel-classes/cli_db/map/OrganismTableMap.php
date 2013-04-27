<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'organism' table.
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
class OrganismTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.OrganismTableMap';

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
        $this->setName('organism');
        $this->setPhpName('Organism');
        $this->setClassname('cli_db\\propel\\Organism');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('organism_organism_id_seq');
        // columns
        $this->addPrimaryKey('organism_id', 'OrganismId', 'INTEGER', true, null, null);
        $this->addColumn('abbreviation', 'Abbreviation', 'VARCHAR', false, 255, null);
        $this->addColumn('genus', 'Genus', 'VARCHAR', true, 255, null);
        $this->addColumn('species', 'Species', 'VARCHAR', true, 255, null);
        $this->addColumn('common_name', 'CommonName', 'VARCHAR', false, 255, null);
        $this->addColumn('comment', 'Comment', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::ONE_TO_MANY, array('organism_id' => 'taxon_id', ), 'SET NULL', null, 'Biomaterials');
    } // buildRelations()

} // OrganismTableMap
