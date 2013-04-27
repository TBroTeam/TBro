<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'contact' table.
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
class ContactTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ContactTableMap';

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
        $this->setName('contact');
        $this->setPhpName('Contact');
        $this->setClassname('cli_db\\propel\\Contact');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('contact_contact_id_seq');
        // columns
        $this->addPrimaryKey('contact_id', 'ContactId', 'INTEGER', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 255, null);
        $this->addColumn('description', 'Description', 'VARCHAR', false, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), null, null);
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::ONE_TO_MANY, array('contact_id' => 'operator_id', ), 'CASCADE', null, 'Assays');
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::ONE_TO_MANY, array('contact_id' => 'biosourceprovider_id', ), 'SET NULL', null, 'Biomaterials');
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::ONE_TO_MANY, array('contact_id' => 'operator_id', ), 'SET NULL', null, 'Quantifications');
    } // buildRelations()

} // ContactTableMap
