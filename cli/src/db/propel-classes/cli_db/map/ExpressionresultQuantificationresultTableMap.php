<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'expressionresult_quantificationresult' table.
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
class ExpressionresultQuantificationresultTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ExpressionresultQuantificationresultTableMap';

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
        $this->setName('expressionresult_quantificationresult');
        $this->setPhpName('ExpressionresultQuantificationresult');
        $this->setClassname('cli_db\\propel\\ExpressionresultQuantificationresult');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('expressionresult_quantificationresult_id_seq');
        // columns
        $this->addPrimaryKey('id', 'Id', 'INTEGER', true, null, null);
        $this->addForeignKey('expressionresult_id', 'ExpressionresultId', 'INTEGER', 'expressionresult', 'expressionresult_id', false, null, null);
        $this->addForeignKey('quantificationresult_id', 'QuantificationresultId', 'INTEGER', 'quantificationresult', 'quantificationresult_id', false, null, null);
        $this->addColumn('samplegroup', 'Samplegroup', 'VARCHAR', false, 1, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Expressionresult', 'cli_db\\propel\\Expressionresult', RelationMap::MANY_TO_ONE, array('expressionresult_id' => 'expressionresult_id', ), null, 'CASCADE');
        $this->addRelation('Quantificationresult', 'cli_db\\propel\\Quantificationresult', RelationMap::MANY_TO_ONE, array('quantificationresult_id' => 'quantificationresult_id', ), null, 'CASCADE');
    } // buildRelations()

} // ExpressionresultQuantificationresultTableMap
