<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'quantificationresult' table.
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
class QuantificationresultTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.QuantificationresultTableMap';

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
        $this->setName('quantificationresult');
        $this->setPhpName('Quantificationresult');
        $this->setClassname('cli_db\\propel\\Quantificationresult');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('quantificationresult_quantificationresult_id_seq');
        // columns
        $this->addPrimaryKey('quantificationresult_id', 'QuantificationresultId', 'INTEGER', true, null, null);
        $this->addForeignKey('feature_id', 'FeatureId', 'INTEGER', 'feature', 'feature_id', true, null, null);
        $this->addForeignKey('biomaterial_id', 'BiomaterialId', 'INTEGER', 'biomaterial', 'biomaterial_id', true, null, null);
        $this->addForeignKey('quantification_id', 'QuantificationId', 'INTEGER', 'quantification', 'quantification_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('value', 'Value', 'DOUBLE', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Biomaterial', 'cli_db\\propel\\Biomaterial', RelationMap::MANY_TO_ONE, array('biomaterial_id' => 'biomaterial_id', ), null, 'CASCADE');
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), null, 'CASCADE');
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::MANY_TO_ONE, array('feature_id' => 'feature_id', ), null, 'CASCADE');
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::MANY_TO_ONE, array('quantification_id' => 'quantification_id', ), null, 'CASCADE');
        $this->addRelation('ExpressionresultQuantificationresult', 'cli_db\\propel\\ExpressionresultQuantificationresult', RelationMap::ONE_TO_MANY, array('quantificationresult_id' => 'quantificationresult_id', ), null, 'CASCADE', 'ExpressionresultQuantificationresults');
    } // buildRelations()

} // QuantificationresultTableMap
