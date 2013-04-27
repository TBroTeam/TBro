<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature_synonym' table.
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
class FeatureSynonymTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureSynonymTableMap';

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
        $this->setName('feature_synonym');
        $this->setPhpName('FeatureSynonym');
        $this->setClassname('cli_db\\propel\\FeatureSynonym');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_synonym_feature_synonym_id_seq');
        // columns
        $this->addPrimaryKey('feature_synonym_id', 'FeatureSynonymId', 'INTEGER', true, null, null);
        $this->addForeignKey('synonym_id', 'SynonymId', 'INTEGER', 'synonym', 'synonym_id', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('pub_id', 'PubId', 'INTEGER', 'pub', 'pub_id', true, null, null);
        $this->addColumn('is_current', 'IsCurrent', 'BOOLEAN', true, null, false);
        $this->addColumn('is_internal', 'IsInternal', 'BOOLEAN', true, null, false);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::MANY_TO_ONE, array('pub_id' => 'pub_id', ), 'CASCADE', null);
        $this->addRelation('Synonym', 'cli_db\\propel\\Synonym', RelationMap::MANY_TO_ONE, array('synonym_id' => 'synonym_id', ), 'CASCADE', null);
    } // buildRelations()

} // FeatureSynonymTableMap
