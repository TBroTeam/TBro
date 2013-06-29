<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'analysis' table.
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
class AnalysisTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AnalysisTableMap';

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
        $this->setName('analysis');
        $this->setPhpName('Analysis');
        $this->setClassname('cli_db\\propel\\Analysis');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('analysis_analysis_id_seq');
        // columns
        $this->addPrimaryKey('analysis_id', 'AnalysisId', 'INTEGER', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('description', 'Description', 'LONGVARCHAR', false, null, null);
        $this->addColumn('program', 'Program', 'VARCHAR', true, 255, null);
        $this->addColumn('programversion', 'Programversion', 'VARCHAR', true, 255, null);
        $this->addColumn('algorithm', 'Algorithm', 'VARCHAR', false, 255, null);
        $this->addColumn('sourcename', 'Sourcename', 'VARCHAR', false, 255, null);
        $this->addColumn('sourceversion', 'Sourceversion', 'VARCHAR', false, 255, null);
        $this->addColumn('sourceuri', 'Sourceuri', 'LONGVARCHAR', false, null, null);
        $this->addColumn('timeexecuted', 'Timeexecuted', 'TIMESTAMP', true, null, 'now()');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::ONE_TO_MANY, array('analysis_id' => 'analysis_id', ), 'CASCADE', null, 'Quantifications');
    } // buildRelations()

} // AnalysisTableMap
