<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'pub' table.
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
class PubTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.PubTableMap';

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
        $this->setName('pub');
        $this->setPhpName('Pub');
        $this->setClassname('cli_db\\propel\\Pub');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('pub_pub_id_seq');
        // columns
        $this->addPrimaryKey('pub_id', 'PubId', 'INTEGER', true, null, null);
        $this->addColumn('title', 'Title', 'LONGVARCHAR', false, null, null);
        $this->addColumn('volumetitle', 'Volumetitle', 'LONGVARCHAR', false, null, null);
        $this->addColumn('volume', 'Volume', 'VARCHAR', false, 255, null);
        $this->addColumn('series_name', 'SeriesName', 'VARCHAR', false, 255, null);
        $this->addColumn('issue', 'Issue', 'VARCHAR', false, 255, null);
        $this->addColumn('pyear', 'Pyear', 'VARCHAR', false, 255, null);
        $this->addColumn('pages', 'Pages', 'VARCHAR', false, 255, null);
        $this->addColumn('miniref', 'Miniref', 'VARCHAR', false, 255, null);
        $this->addColumn('uniquename', 'Uniquename', 'LONGVARCHAR', true, null, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('is_obsolete', 'IsObsolete', 'BOOLEAN', false, null, false);
        $this->addColumn('publisher', 'Publisher', 'VARCHAR', false, 255, null);
        $this->addColumn('pubplace', 'Pubplace', 'VARCHAR', false, 255, null);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('FeatureCvterm', 'cli_db\\propel\\FeatureCvterm', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'FeatureCvterms');
        $this->addRelation('FeatureCvtermPub', 'cli_db\\propel\\FeatureCvtermPub', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'FeatureCvtermPubs');
        $this->addRelation('FeaturePub', 'cli_db\\propel\\FeaturePub', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'FeaturePubs');
        $this->addRelation('PubDbxref', 'cli_db\\propel\\PubDbxref', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'PubDbxrefs');
        $this->addRelation('PubRelationshipRelatedByObjectId', 'cli_db\\propel\\PubRelationship', RelationMap::ONE_TO_MANY, array('pub_id' => 'object_id', ), 'CASCADE', null, 'PubRelationshipsRelatedByObjectId');
        $this->addRelation('PubRelationshipRelatedBySubjectId', 'cli_db\\propel\\PubRelationship', RelationMap::ONE_TO_MANY, array('pub_id' => 'subject_id', ), 'CASCADE', null, 'PubRelationshipsRelatedBySubjectId');
        $this->addRelation('Pubauthor', 'cli_db\\propel\\Pubauthor', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'Pubauthors');
        $this->addRelation('Pubprop', 'cli_db\\propel\\Pubprop', RelationMap::ONE_TO_MANY, array('pub_id' => 'pub_id', ), 'CASCADE', null, 'Pubprops');
    } // buildRelations()

} // PubTableMap
