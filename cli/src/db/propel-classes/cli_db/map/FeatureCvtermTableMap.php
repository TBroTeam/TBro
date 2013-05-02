<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_cvterm' table.
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
class FeatureCvtermTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureCvtermTableMap';

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
        $this->setName('feature_cvterm');
        $this->setPhpName('FeatureCvterm');
        $this->setClassname('cli_db\\propel\\FeatureCvterm');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_cvterm_feature_cvterm_id_seq');
        // columns
        $this->addPrimaryKey('feature_cvterm_id', 'FeatureCvtermId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('cvterm_id', 'CvtermId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        $this->addColumn('is_not', 'IsNot', 'BOOLEAN', true, null, false);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
        $this->addRelation('FeatureCvtermDbxref', 'cli_db\\propel\\FeatureCvtermDbxref', RelationMap::ONE_TO_MANY, array('feature_cvterm_id' => 'feature_cvterm_id', ), 'CASCADE', null, 'FeatureCvtermDbxrefs');
        $this->addRelation('FeatureCvtermPub', 'cli_db\\propel\\FeatureCvtermPub', RelationMap::ONE_TO_MANY, array('feature_cvterm_id' => 'feature_cvterm_id', ), 'CASCADE', null, 'FeatureCvtermPubs');
        $this->addRelation('FeatureCvtermprop', 'cli_db\\propel\\FeatureCvtermprop', RelationMap::ONE_TO_MANY, array('feature_cvterm_id' => 'feature_cvterm_id', ), 'CASCADE', null, 'FeatureCvtermprops');
    } // buildRelations()

} // FeatureCvtermTableMap
