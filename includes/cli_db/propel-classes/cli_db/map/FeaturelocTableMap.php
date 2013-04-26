<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'featureloc' table.
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
class FeaturelocTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeaturelocTableMap';

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
        $this->setName('featureloc');
        $this->setPhpName('Featureloc');
        $this->setClassname('cli_db\\propel\\Featureloc');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('featureloc_featureloc_id_seq');
        // columns
        $this->addPrimaryKey('featureloc_id', 'FeaturelocId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('srcfeature_id', 'SrcfeatureId', 'INTEGER', 'feature', 'feature_id', false, null, null);
        $this->addColumn('fmin', 'Fmin', 'INTEGER', false, null, null);
        $this->addColumn('is_fmin_partial', 'IsFminPartial', 'BOOLEAN', true, null, false);
        $this->addColumn('fmax', 'Fmax', 'INTEGER', false, null, null);
        $this->addColumn('is_fmax_partial', 'IsFmaxPartial', 'BOOLEAN', true, null, false);
        $this->addColumn('strand', 'Strand', 'SMALLINT', false, null, null);
        $this->addColumn('phase', 'Phase', 'INTEGER', false, null, null);
        $this->addColumn('residue_info', 'ResidueInfo', 'LONGVARCHAR', false, null, null);
        $this->addColumn('locgroup', 'Locgroup', 'INTEGER', true, null, 0);
        $this->addColumn('rank', 'Rank', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('FeatureRelatedByFeatureId', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('FeatureRelatedBySrcfeatureId', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('srcfeature_id' => 'feature_id', ), 'SET NULL', null);
        $this->addRelation('FeaturelocPub', 'cli_db\\propel\\FeaturelocPub', RelationMap::ONE_TO_MANY, array('featureloc_id' => 'featureloc_id', ), 'CASCADE', null, 'FeaturelocPubs');
    } // buildRelations()

} // FeaturelocTableMap
