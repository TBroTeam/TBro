<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'analysisfeature' table.
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
class AnalysisfeatureTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AnalysisfeatureTableMap';

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
        $this->setName('analysisfeature');
        $this->setPhpName('Analysisfeature');
        $this->setClassname('cli_db\\propel\\Analysisfeature');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('analysisfeature_analysisfeature_id_seq');
        // columns
        $this->addPrimaryKey('analysisfeature_id', 'AnalysisfeatureId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('analysis_id', 'AnalysisId', 'INTEGER', 'analysis', 'analysis_id', true, null, null);
        $this->addColumn('rawscore', 'Rawscore', 'DOUBLE', false, null, null);
        $this->addColumn('normscore', 'Normscore', 'DOUBLE', false, null, null);
        $this->addColumn('significance', 'Significance', 'DOUBLE', false, null, null);
        $this->addColumn('identity', 'Identity', 'DOUBLE', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Analysis', 'cli_db\\propel\\Analysis', RelationMap::MANY_TO_ONE, array('analysis_id' => 'analysis_id', ), 'CASCADE', null);
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), 'CASCADE', null);
        $this->addRelation('Analysisfeatureprop', 'cli_db\\propel\\Analysisfeatureprop', RelationMap::ONE_TO_MANY, array('analysisfeature_id' => 'analysisfeature_id', ), 'CASCADE', null, 'Analysisfeatureprops');
    } // buildRelations()

} // AnalysisfeatureTableMap
