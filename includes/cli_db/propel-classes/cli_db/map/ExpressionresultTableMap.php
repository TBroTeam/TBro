<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'expressionresult' table.
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
class ExpressionresultTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ExpressionresultTableMap';

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
        $this->setName('expressionresult');
        $this->setPhpName('Expressionresult');
        $this->setClassname('cli_db\\propel\\Expressionresult');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('expressionresult_expressionresult_id_seq');
        // columns
        $this->addPrimaryKey('expressionresult_id', 'ExpressionresultId', 'INTEGER', true, null, null);
        $this->addForeignKey('analysis_id', 'AnalysisId', 'INTEGER', 'analysis', 'analysis_id', false, null, null);
        $this->addColumn('baseMean', 'Basemean', 'DOUBLE', false, null, null);
        $this->addColumn('baseMeanA', 'Basemeana', 'DOUBLE', false, null, null);
        $this->addColumn('baseMeanB', 'Basemeanb', 'DOUBLE', false, null, null);
        $this->addColumn('foldChange', 'Foldchange', 'DOUBLE', false, null, null);
        $this->addColumn('log2foldChange', 'Log2foldchange', 'DOUBLE', false, null, null);
        $this->addColumn('pval', 'Pval', 'DOUBLE', false, null, null);
        $this->addColumn('pvaladj', 'Pvaladj', 'DOUBLE', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Analysis', 'cli_db\\propel\\Analysis', RelationMap::MANY_TO_ONE, array('analysis_id' => 'analysis_id', ), null, 'CASCADE');
        $this->addRelation('ExpressionresultQuantificationresult', 'cli_db\\propel\\ExpressionresultQuantificationresult', RelationMap::ONE_TO_MANY, array('expressionresult_id' => 'expressionresult_id', ), null, 'CASCADE', 'ExpressionresultQuantificationresults');
    } // buildRelations()

} // ExpressionresultTableMap
