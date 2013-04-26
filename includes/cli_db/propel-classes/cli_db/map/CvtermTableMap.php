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
        $this->addForeignKey('dbxref_id', 'DbxrefId', 'INTEGER', 'dbxref', 'dbxref_id', true, null, null);
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
        $this->addRelation('Dbxref', 'cli_db\\propel\\Dbxref', RelationMap::MANY_TO_ONE, array('dbxref_id' => 'dbxref_id', ), 'SET NULL', null);
        $this->addRelation('AcquisitionRelationship', 'cli_db\\propel\\AcquisitionRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'AcquisitionRelationships');
        $this->addRelation('Acquisitionprop', 'cli_db\\propel\\Acquisitionprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Acquisitionprops');
        $this->addRelation('Analysisfeatureprop', 'cli_db\\propel\\Analysisfeatureprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Analysisfeatureprops');
        $this->addRelation('Analysisprop', 'cli_db\\propel\\Analysisprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Analysisprops');
        $this->addRelation('ArraydesignRelatedByPlatformtypeId', 'cli_db\\propel\\Arraydesign', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'platformtype_id', ), 'CASCADE', null, 'ArraydesignsRelatedByPlatformtypeId');
        $this->addRelation('ArraydesignRelatedBySubstratetypeId', 'cli_db\\propel\\Arraydesign', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'substratetype_id', ), 'SET NULL', null, 'ArraydesignsRelatedBySubstratetypeId');
        $this->addRelation('Arraydesignprop', 'cli_db\\propel\\Arraydesignprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Arraydesignprops');
        $this->addRelation('Assayprop', 'cli_db\\propel\\Assayprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Assayprops');
        $this->addRelation('BiomaterialRelationship', 'cli_db\\propel\\BiomaterialRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'BiomaterialRelationships');
        $this->addRelation('BiomaterialTreatment', 'cli_db\\propel\\BiomaterialTreatment', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'unittype_id', ), 'SET NULL', null, 'BiomaterialTreatments');
        $this->addRelation('Biomaterialprop', 'cli_db\\propel\\Biomaterialprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Biomaterialprops');
        $this->addRelation('Chadoprop', 'cli_db\\propel\\Chadoprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'Chadoprops');
        $this->addRelation('Contact', 'cli_db\\propel\\Contact', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'Contacts');
        $this->addRelation('ContactRelationship', 'cli_db\\propel\\ContactRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'ContactRelationships');
        $this->addRelation('Control', 'cli_db\\propel\\Control', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Controls');
        $this->addRelation('Cvprop', 'cli_db\\propel\\Cvprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'Cvprops');
        $this->addRelation('CvtermDbxref', 'cli_db\\propel\\CvtermDbxref', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null, 'CvtermDbxrefs');
        $this->addRelation('CvtermRelationshipRelatedByObjectId', 'cli_db\\propel\\CvtermRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'object_id', ), 'CASCADE', null, 'CvtermRelationshipsRelatedByObjectId');
        $this->addRelation('CvtermRelationshipRelatedBySubjectId', 'cli_db\\propel\\CvtermRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'subject_id', ), 'CASCADE', null, 'CvtermRelationshipsRelatedBySubjectId');
        $this->addRelation('CvtermRelationshipRelatedByTypeId', 'cli_db\\propel\\CvtermRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'CvtermRelationshipsRelatedByTypeId');
        $this->addRelation('CvtermpathRelatedByObjectId', 'cli_db\\propel\\Cvtermpath', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'object_id', ), 'CASCADE', null, 'CvtermpathsRelatedByObjectId');
        $this->addRelation('CvtermpathRelatedBySubjectId', 'cli_db\\propel\\Cvtermpath', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'subject_id', ), 'CASCADE', null, 'CvtermpathsRelatedBySubjectId');
        $this->addRelation('CvtermpathRelatedByTypeId', 'cli_db\\propel\\Cvtermpath', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'SET NULL', null, 'CvtermpathsRelatedByTypeId');
        $this->addRelation('CvtermpropRelatedByCvtermId', 'cli_db\\propel\\Cvtermprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null, 'CvtermpropsRelatedByCvtermId');
        $this->addRelation('CvtermpropRelatedByTypeId', 'cli_db\\propel\\Cvtermprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'CvtermpropsRelatedByTypeId');
        $this->addRelation('CvtermsynonymRelatedByCvtermId', 'cli_db\\propel\\Cvtermsynonym', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null, 'CvtermsynonymsRelatedByCvtermId');
        $this->addRelation('CvtermsynonymRelatedByTypeId', 'cli_db\\propel\\Cvtermsynonym', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'CvtermsynonymsRelatedByTypeId');
        $this->addRelation('Dbxrefprop', 'cli_db\\propel\\Dbxrefprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'Dbxrefprops');
        $this->addRelation('Element', 'cli_db\\propel\\Element', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'SET NULL', null, 'Elements');
        $this->addRelation('ElementRelationship', 'cli_db\\propel\\ElementRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'ElementRelationships');
        $this->addRelation('ElementresultRelationship', 'cli_db\\propel\\ElementresultRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'ElementresultRelationships');
        $this->addRelation('Feature', 'cli_db\\propel\\Feature', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Features');
        $this->addRelation('FeatureCvterm', 'cli_db\\propel\\FeatureCvterm', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'cvterm_id', ), 'CASCADE', null, 'FeatureCvterms');
        $this->addRelation('FeatureCvtermprop', 'cli_db\\propel\\FeatureCvtermprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'FeatureCvtermprops');
        $this->addRelation('FeaturePubprop', 'cli_db\\propel\\FeaturePubprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'FeaturePubprops');
        $this->addRelation('FeatureRelationship', 'cli_db\\propel\\FeatureRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'FeatureRelationships');
        $this->addRelation('FeatureRelationshipprop', 'cli_db\\propel\\FeatureRelationshipprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'FeatureRelationshipprops');
        $this->addRelation('Featureprop', 'cli_db\\propel\\Featureprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Featureprops');
        $this->addRelation('Organismprop', 'cli_db\\propel\\Organismprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Organismprops');
        $this->addRelation('ProjectRelationship', 'cli_db\\propel\\ProjectRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'RESTRICT', null, 'ProjectRelationships');
        $this->addRelation('Projectprop', 'cli_db\\propel\\Projectprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Projectprops');
        $this->addRelation('Protocol', 'cli_db\\propel\\Protocol', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Protocols');
        $this->addRelation('ProtocolparamRelatedByDatatypeId', 'cli_db\\propel\\Protocolparam', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'datatype_id', ), 'SET NULL', null, 'ProtocolparamsRelatedByDatatypeId');
        $this->addRelation('ProtocolparamRelatedByUnittypeId', 'cli_db\\propel\\Protocolparam', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'unittype_id', ), 'SET NULL', null, 'ProtocolparamsRelatedByUnittypeId');
        $this->addRelation('Pub', 'cli_db\\propel\\Pub', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Pubs');
        $this->addRelation('PubRelationship', 'cli_db\\propel\\PubRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'PubRelationships');
        $this->addRelation('Pubprop', 'cli_db\\propel\\Pubprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Pubprops');
        $this->addRelation('QuantificationRelationship', 'cli_db\\propel\\QuantificationRelationship', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'QuantificationRelationships');
        $this->addRelation('Quantificationprop', 'cli_db\\propel\\Quantificationprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Quantificationprops');
        $this->addRelation('Quantificationresult', 'cli_db\\propel\\Quantificationresult', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, 'CASCADE', 'Quantificationresults');
        $this->addRelation('Studydesignprop', 'cli_db\\propel\\Studydesignprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Studydesignprops');
        $this->addRelation('Studyfactor', 'cli_db\\propel\\Studyfactor', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'SET NULL', null, 'Studyfactors');
        $this->addRelation('Studyprop', 'cli_db\\propel\\Studyprop', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Studyprops');
        $this->addRelation('StudypropFeature', 'cli_db\\propel\\StudypropFeature', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'StudypropFeatures');
        $this->addRelation('Synonym', 'cli_db\\propel\\Synonym', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Synonyms');
        $this->addRelation('Treatment', 'cli_db\\propel\\Treatment', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), 'CASCADE', null, 'Treatments');
        $this->addRelation('WebuserData', 'cli_db\\propel\\WebuserData', RelationMap::ONE_TO_MANY, array('cvterm_id' => 'type_id', ), null, null, 'WebuserDatas');
    } // buildRelations()

} // CvtermTableMap
