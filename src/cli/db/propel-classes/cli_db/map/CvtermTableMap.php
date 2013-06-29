<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'cvterm' table.
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
class CvtermTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.CvtermTableMap';

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
        $this->setName('cvterm');
        $this->setPhpName('Cvterm');
        $this->setClassname('cli_db\\propel\\Cvterm');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('cvterm_cvterm_id_seq');
        // columns
        $this->addPrimaryKey('cvterm_id', 'CvtermId', 'INTEGER', true, null, null);
        $this->addForeignKey('cv_id', 'CvId', 'INTEGER', 'cv', 'cv_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', true, 1024, null);
        $this->addColumn('definition', 'Definition', 'LONGVARCHAR', false, null, null);
        $this->addColumn('dbxref_id', 'DbxrefId', 'INTEGER', true, null, null);
        $this->addColumn('is_obsolete', 'IsObsolete', 'INTEGER', true, null, 0);
        $this->addColumn('is_relationshiptype', 'IsRelationshiptype', 'INTEGER', true, null, 0);
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Cv', 'cli_db\\propel\\Cv', RelationMap::MANY_TO_ONE, array('cv_id' => 'cv_id', ), 'CASCADE', null);
        $this->addRelation('BiomaterialRelationship', 'cli_db\\propel\\BiomaterialRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'BiomaterialRelationships');
        $this->addRelation('Biomaterialprop', 'cli_db\\propel\\Biomaterialprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Biomaterialprops');
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'Contacts');
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Features');
        $this->addRelation('FeatureCvterm', 'cli_db\\propel\\FeatureCvterm', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null, 'FeatureCvterms');
        $this->addRelation('FeatureCvtermprop', 'cli_db\\propel\\FeatureCvtermprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'FeatureCvtermprops');
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Protocols');
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Pubs');
        $this->addRelation('PubRelationship', 'cli_db\\propel\\PubRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'PubRelationships');
        $this->addRelation('Pubprop', 'cli_db\\propel\\Pubprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Pubprops');
        $this->addRelation('Synonym', 'cli_db\\propel\\Synonym', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Synonyms');
    } // buildRelations()

} // CvtermTableMap
