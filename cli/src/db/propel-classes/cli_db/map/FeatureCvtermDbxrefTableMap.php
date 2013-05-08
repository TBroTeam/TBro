<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_cvterm_dbxref' table.
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
class FeatureCvtermDbxrefTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureCvtermDbxrefTableMap';

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
        $this->setName('feature_cvterm_dbxref');
        $this->setPhpName('FeatureCvtermDbxref');
        $this->setClassname('cli_db\\propel\\FeatureCvtermDbxref');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_cvterm_dbxref_feature_cvterm_dbxref_id_seq');
        // columns
        $this->addPrimaryKey('feature_cvterm_dbxref_id', 'FeatureCvtermDbxrefId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_cvterm_id', 'FeatureCvtermId', 'INTEGER', 'feature_cvterm', 'feature_cvterm_id', true, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'CASCADE', null);
        $this->addRelation('FeatureCvterm', 'cli_db\\propel\\FeatureCvterm', RelationMap::MANY_TO_ONE, array('feature_cvterm_id' => 'feature_cvterm_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeatureCvtermDbxrefTableMap
