<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'acquisition' table.
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
class AcquisitionTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.AcquisitionTableMap';

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
        $this->setName('acquisition');
        $this->setPhpName('Acquisition');
        $this->setClassname('cli_db\\propel\\Acquisition');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('acquisition_acquisition_id_seq');
        // columns
        $this->addPrimaryKey('acquisition_id', 'AcquisitionId', 'INTEGER', true, null, null);
        $this->addForeignKey('assay_id', 'AssayId', 'INTEGER', 'assay', 'assay_id', true, null, null);
        $this->addForeignKey('protocol_id', 'ProtocolId', 'INTEGER', 'protocol', 'protocol_id', false, null, null);
        $this->addForeignKey('channel_id', 'ChannelId', 'INTEGER', 'channel', 'channel_id', false, null, null);
        $this->addColumn('acquisitiondate', 'Acquisitiondate', 'TIMESTAMP', false, null, 'now()');
        $this->addColumn('name', 'Name', 'LONGVARCHAR', false, null, null);
        $this->addColumn('uri', 'Uri', 'LONGVARCHAR', false, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Assay', 'cli_db\\propel\\Assay', RelationMap::MANY_TO_ONE, array('assay_id' => 'assay_id', ), 'CASCADE', null);
        $this->addRelation('Channel', 'cli_db\\propel\\Channel', RelationMap::MANY_TO_ONE, array('channel_id' => 'channel_id', ), 'SET NULL', null);
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::MANY_TO_ONE, array('protocol_id' => 'protocol_id', ), 'SET NULL', null);
        $this->addRelation('AcquisitionRelationshipRelatedByObjectId', 'cli_db\\propel\\AcquisitionRelationship', RelationMap::ONE_TO_MANY, array('acquisition_id' => 'object_id', ), 'CASCADE', null, 'AcquisitionRelationshipsRelatedByObjectId');
        $this->addRelation('AcquisitionRelationshipRelatedBySubjectId', 'cli_db\\propel\\AcquisitionRelationship', RelationMap::ONE_TO_MANY, array('acquisition_id' => 'subject_id', ), 'CASCADE', null, 'AcquisitionRelationshipsRelatedBySubjectId');
        $this->addRelation('Acquisitionprop', 'cli_db\\propel\\Acquisitionprop', RelationMap::ONE_TO_MANY, array('acquisition_id' => 'acquisition_id', ), 'CASCADE', null, 'Acquisitionprops');
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::ONE_TO_MANY, array('acquisition_id' => 'acquisition_id', ), 'CASCADE', null, 'Quantifications');
    } // buildRelations()

} // AcquisitionTableMap
