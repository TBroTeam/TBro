<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'dbxref' table.
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
class DbxrefTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.DbxrefTableMap';

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
        $this->setName('dbxref');
        $this->setPhpName('Dbxref');
        $this->setClassname('cli_db\\propel\\Dbxref');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('dbxref_dbxref_id_seq');
        // columns
        $this->addPrimaryKey('dbxref_id', 'DbxrefId', 'INTEGER', true, null, null);
        $this->addForeignKey('db_id', 'DbId', 'INTEGER', 'db', 'db_id', true, null, null);
        $this->addColumn('accession', 'Accession', 'VARCHAR', true, 255, null);
        $this->addColumn('version', 'Version', 'VARCHAR', true, 255, '');
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Db', 'cli_db\\propel\\Db', RelationMap::MANY_TO_ONE, array('db_id' => 'db_id', ), 'CASCADE', null);
        $this->addRelation('Arraydesign', 'cli_db\\propel\\Arraydesign', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Arraydesigns');
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Assays');
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Biomaterials');
        $this->addRelation('BiomaterialDbxref', 'cli_db\\propel\\BiomaterialDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'BiomaterialDbxrefs');
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Cvterms');
        $this->addRelation('CvtermDbxref', 'cli_db\\propel\\CvtermDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'CvtermDbxrefs');
        $this->addRelation('Dbxrefprop', 'cli_db\\propel\\Dbxrefprop', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), null, null, 'Dbxrefprops');
        $this->addRelation('Element', 'cli_db\\propel\\Element', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Elements');
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Features');
        $this->addRelation('FeatureCvtermDbxref', 'cli_db\\propel\\FeatureCvtermDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'FeatureCvtermDbxrefs');
        $this->addRelation('FeatureDbxref', 'cli_db\\propel\\FeatureDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'FeatureDbxrefs');
        $this->addRelation('OrganismDbxref', 'cli_db\\propel\\OrganismDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'OrganismDbxrefs');
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Protocols');
        $this->addRelation('PubDbxref', 'cli_db\\propel\\PubDbxref', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null, 'PubDbxrefs');
        $this->addRelation('Study', 'cli_db\\propel\\Study', RelationMap::ONE_TO_MANY, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null, 'Studys');
    } // buildRelations()

} // DbxrefTableMap
