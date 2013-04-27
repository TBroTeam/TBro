<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'quantification' table.
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
class QuantificationTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.QuantificationTableMap';

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
        $this->setName('quantification');
        $this->setPhpName('Quantification');
        $this->setClassname('cli_db\\propel\\Quantification');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('quantification_quantification_id_seq');
        // columns
        $this->addPrimaryKey('quantification_id', 'QuantificationId', 'INTEGER', true, null, null);
        $this->addForeignKey('acquisition_id', 'AcquisitionId', 'INTEGER', 'acquisition', 'acquisition_id', true, null, null);
        $this->addForeignKey('operator_id', 'OperatorId', 'INTEGER', 'contact', 'contact_id', false, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', false, null, null);
        $this->addForeignKey('analysis_id', 'AnalysisId', 'INTEGER', 'analysis', 'analysis_id', true, null, null);
        $this->addColumn('quantificationdate', 'Quantificationdate', 'TIMESTAMP', false, null, 'now()');
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('uri', 'Uri', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Acquisition', 'cli_db\\propel\\Acquisition', RelationMap::MANY_TO_ONE, array('acquisition_id' => 'acquisition_id', ), 'CASCADE', null);
        $this->addRelation('Analysis', 'cli_db\\propel\\Analysis', RelationMap::MANY_TO_ONE, array('analysis_id' => 'analysis_id', ), 'CASCADE', null);
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::MANY_TO_ONE, array('operator_id' => 'contact_id', ), 'SET NULL', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'SET NULL', null);
    } // buildRelations()

} // QuantificationTableMap
