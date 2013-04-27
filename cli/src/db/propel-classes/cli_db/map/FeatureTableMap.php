<?php

namespace cli_db\propel\map;

use \RelationMap;
use \TableMap;


/**
 * This class defines the structure of the 'feature' table.
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
class FeatureTableMap extends TableMap
{

    /**
     * The (dot-path) name of this class
     */
    const CLASS_NAME = 'cli_db.map.FeatureTableMap';

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
        $this->setName('feature');
        $this->setPhpName('Feature');
        $this->setClassname('cli_db\\propel\\Feature');
        $this->setPackage('cli_db');
        $this->setUseIdGenerator(true);
        $this->setPrimaryKeyMethodInfo('feature_feature_id_seq');
        // columns
        $this->addPrimaryKey('feature_id', 'FeatureId', 'INTEGER', true, null, null);
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', false, null, null);
        $this->addForeignKey('organism_id', 'OrganismId', 'INTEGER', 'organism', 'organism_id', true, null, null);
        $this->addColumn('name', 'Name', 'VARCHAR', false, 255, null);
        $this->addColumn('uniquename', 'Uniquename', 'LONGVARCHAR', true, null, null);
        $this->addColumn('residues', 'Residues', 'LONGVARCHAR', false, null, null);
        $this->addColumn('seqlen', 'Seqlen', 'INTEGER', false, null, null);
        $this->addColumn('md5checksum', 'Md5checksum', 'CHAR', false, 32, null);
        $this->addForeignKey('type_id', 'TypeId', 'INTEGER', 'cvterm', 'cvterm_id', true, null, null);
        $this->addColumn('is_analysis', 'IsAnalysis', 'BOOLEAN', true, null, false);
        $this->addColumn('is_obsolete', 'IsObsolete', 'BOOLEAN', true, null, false);
        $this->addColumn('timeaccessioned', 'Timeaccessioned', 'TIMESTAMP', true, null, 'now()');
        $this->addColumn('timelastmodified', 'Timelastmodified', 'TIMESTAMP', true, null, 'now()');
        // validators
    } // initialize()

    /**
     * Build the RelationMap objects for this table relationships
     */
    public function buildRelations()
    {
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('Organism', 'cli_db\\propel\\Organism', RelationMap::MANY_TO_ONE, array('organism_id' => 'organism_id', ), 'CASCADE', null);
        $this->addRelation('Cvterm', 'cli_db\\propel\\Cvterm', RelationMap::MANY_TO_ONE, array('type_id' => 'cvterm_id', ), 'CASCADE', null);
        $this->addRelation('Analysisfeature', 'cli_db\\propel\\Analysisfeature', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'Analysisfeatures');
        $this->addRelation('Element', 'cli_db\\propel\\Element', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'SET NULL', null, 'Elements');
        $this->addRelation('FeatureCvterm', 'cli_db\\propel\\FeatureCvterm', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'FeatureCvterms');
        $this->addRelation('FeatureDbxref', 'cli_db\\propel\\FeatureDbxref', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'FeatureDbxrefs');
        $this->addRelation('FeaturePub', 'cli_db\\propel\\FeaturePub', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'FeaturePubs');
        $this->addRelation('FeatureRelationshipRelatedByObjectId', 'cli_db\\propel\\FeatureRelationship', RelationMap::ONE_TO_MANY, array('feature_id' => 'object_id', ), 'CASCADE', null, 'FeatureRelationshipsRelatedByObjectId');
        $this->addRelation('FeatureRelationshipRelatedBySubjectId', 'cli_db\\propel\\FeatureRelationship', RelationMap::ONE_TO_MANY, array('feature_id' => 'subject_id', ), 'CASCADE', null, 'FeatureRelationshipsRelatedBySubjectId');
        $this->addRelation('FeatureSynonym', 'cli_db\\propel\\FeatureSynonym', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'FeatureSynonyms');
        $this->addRelation('FeaturelocRelatedByFeatureId', 'cli_db\\propel\\Featureloc', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'FeaturelocsRelatedByFeatureId');
        $this->addRelation('FeaturelocRelatedBySrcfeatureId', 'cli_db\\propel\\Featureloc', RelationMap::ONE_TO_MANY, array('feature_id' => 'srcfeature_id', ), 'SET NULL', null, 'FeaturelocsRelatedBySrcfeatureId');
        $this->addRelation('Featureprop', 'cli_db\\propel\\Featureprop', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'Featureprops');
        $this->addRelation('Quantificationresult', 'cli_db\\propel\\Quantificationresult', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), null, 'CASCADE', 'Quantificationresults');
        $this->addRelation('StudypropFeature', 'cli_db\\propel\\StudypropFeature', RelationMap::ONE_TO_MANY, array('feature_id' => 'feature_id', ), 'CASCADE', null, 'StudypropFeatures');
    } // buildRelations()

} // FeatureTableMap
