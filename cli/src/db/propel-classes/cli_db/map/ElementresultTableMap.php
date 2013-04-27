<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'elementresult' table.
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
class ElementresultTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.ElementresultTableMap';

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
        $this->setName('elementresult');
        $this->setPhpName('Elementresult');
        $this->setClassname('cli_db\\propel\\Elementresult');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('elementresult_elementresult_id_seq');
        // columns
        $this->addPrimaryKey('elementresult_id', 'ElementresultId', 'INTEGER', true, null, null);
        $this->addForeignKey('element_id', 'ElementId', 'INTEGER', 'element', 'element_id', true, null, null);
        $this->addForeignKey('quantification_id', 'QuantificationId', 'INTEGER', 'quantification', 'quantification_id', true, null, null);
        $this->addColumn('signal', 'Signal', 'DOUBLE', true, null, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Element', 'cli_db\\propel\\Element', RelationMap::MANY_TO_ONE, array('element_id' => 'element_id', ), 'CASCADE', null);
        $this->addRelation('Quantification', 'cli_db\\propel\\Quantification', RelationMap::MANY_TO_ONE, array('quantification_id' => 'quantification_id', ), 'CASCADE', null);
        $this->addRelation('ElementresultRelationshipRelatedByObjectId', 'cli_db\\propel\\ElementresultRelationship', RelationMap::ONE_TO_MANY, array('elementresult_id' => 'object_id', ), null, null, 'ElementresultRelationshipsRelatedByObjectId');
        $this->addRelation('ElementresultRelationshipRelatedBySubjectId', 'cli_db\\propel\\ElementresultRelationship', RelationMap::ONE_TO_MANY, array('elementresult_id' => 'subject_id', ), null, null, 'ElementresultRelationshipsRelatedBySubjectId');
    } // buildRelations()

} // ElementresultTableMap
