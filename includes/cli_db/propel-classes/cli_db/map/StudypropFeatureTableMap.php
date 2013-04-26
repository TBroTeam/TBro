<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'studyprop_feature' table.
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
class StudypropFeatureTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.StudypropFeatureTableMap';

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
        $this->setName('studyprop_feature');
        $this->setPhpName('StudypropFeature');
        $this->setClassname('cli_db\\propel\\StudypropFeature');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('studyprop_feature_studyprop_feature_id_seq');
        // columns
        $this->addPrimaryKey('studyprop_feature_id', 'StudypropFeatureId', 'INTEGER', true, null, null);
        $this->addForeignKey('studyprop_id', 'StudypropId', 'INTEGER', 'studyprop', 'studyprop_id', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('Studyprop', 'cli_db\\propel\\Studyprop', RelationMap::MANY_TO_ONE, array('studyprop_id' => 'studyprop_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
    } // buildRelations()

} // StudypropFeatureTableMap
