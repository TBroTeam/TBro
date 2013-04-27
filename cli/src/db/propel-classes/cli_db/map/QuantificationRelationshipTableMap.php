<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'quantification_relationship' table.
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
class QuantificationRelationshipTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.QuantificationRelationshipTableMap';

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
        $this->setName('quantification_relationship');
        $this->setPhpName('QuantificationRelationship');
        $this->setClassname('cli_db\\propel\\QuantificationRelationship');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('quantification_relationship_quantification_relationship_id_seq');
        // columns
        $this->addPrimaryKey('quantification_relationship_id', 'QuantificationRelationshipId', 'INTEGER', true, null, null);
        $this->addForeignKey('subject_id', 'SubjectId', 'INTEGER', 'quantification', 'quantification_id', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addForeignKey('object_id', 'ObjectId', 'INTEGER', 'quantification', 'quantification_id', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('QuantificationRelatedByObjectId', 'cli_db\\propel\\Quantification', RelationMap::MANY_TO_ONE, array('object_id' => 'quantification_id', ), 'CASCADE', null);
        $this->addRelation('QuantificationRelatedBySubjectId', 'cli_db\\propel\\Quantification', RelationMap::MANY_TO_ONE, array('subject_id' => 'quantification_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
    } // buildRelations()

} // QuantificationRelationshipTableMap
