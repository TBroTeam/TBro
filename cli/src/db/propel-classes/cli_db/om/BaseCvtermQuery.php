<?php

namespace cli_db\propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\Acquisitionprop;
use cli_db\propel\Analysisfeatureprop;
use cli_db\propel\Analysisprop;
use cli_db\propel\Arraydesign;
use cli_db\propel\Arraydesignprop;
use cli_db\propel\Assayprop;
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\BiomaterialTreatment;
use cli_db\propel\Biomaterialprop;
use cli_db\propel\Chadoprop;
use cli_db\propel\Contact;
use cli_db\propel\ContactRelationship;
use cli_db\propel\Control;
use cli_db\propel\Cv;
use cli_db\propel\Cvprop;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermDbxref;
use cli_db\propel\CvtermPeer;
use cli_db\propel\CvtermQuery;
use cli_db\propel\CvtermRelationship;
use cli_db\propel\Cvtermpath;
use cli_db\propel\Cvtermprop;
use cli_db\propel\Cvtermsynonym;
use cli_db\propel\Dbxref;
use cli_db\propel\Dbxrefprop;
use cli_db\propel\Element;
use cli_db\propel\ElementRelationship;
use cli_db\propel\ElementresultRelationship;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\FeaturePubprop;
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipprop;
use cli_db\propel\Featureprop;
use cli_db\propel\Organismprop;
use cli_db\propel\ProjectRelationship;
use cli_db\propel\Projectprop;
use cli_db\propel\Protocol;
use cli_db\propel\Protocolparam;
use cli_db\propel\Pub;
use cli_db\propel\PubRelationship;
use cli_db\propel\Pubprop;
use cli_db\propel\QuantificationRelationship;
use cli_db\propel\Quantificationprop;
use cli_db\propel\Quantificationresult;
use cli_db\propel\Studydesignprop;
use cli_db\propel\Studyfactor;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropFeature;
use cli_db\propel\Synonym;
use cli_db\propel\Treatment;
use cli_db\propel\WebuserData;

/**
 * Base class that represents a query for the 'cvterm' table.
 *
 *
 *
 * @method CvtermQuery orderByCvtermId($order = Criteria::ASC) Order by the cvterm_id column
 * @method CvtermQuery orderByCvId($order = Criteria::ASC) Order by the cv_id column
 * @method CvtermQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CvtermQuery orderByDefinition($order = Criteria::ASC) Order by the definition column
 * @method CvtermQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method CvtermQuery orderByIsObsolete($order = Criteria::ASC) Order by the is_obsolete column
 * @method CvtermQuery orderByIsRelationshiptype($order = Criteria::ASC) Order by the is_relationshiptype column
 *
 * @method CvtermQuery groupByCvtermId() Group by the cvterm_id column
 * @method CvtermQuery groupByCvId() Group by the cv_id column
 * @method CvtermQuery groupByName() Group by the name column
 * @method CvtermQuery groupByDefinition() Group by the definition column
 * @method CvtermQuery groupByDbxrefId() Group by the dbxref_id column
 * @method CvtermQuery groupByIsObsolete() Group by the is_obsolete column
 * @method CvtermQuery groupByIsRelationshiptype() Group by the is_relationshiptype column
 *
 * @method CvtermQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvtermQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvtermQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvtermQuery leftJoinCv($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cv relation
 * @method CvtermQuery rightJoinCv($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cv relation
 * @method CvtermQuery innerJoinCv($relationAlias = null) Adds a INNER JOIN clause to the query using the Cv relation
 *
 * @method CvtermQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method CvtermQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method CvtermQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method CvtermQuery leftJoinAcquisitionRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the AcquisitionRelationship relation
 * @method CvtermQuery rightJoinAcquisitionRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AcquisitionRelationship relation
 * @method CvtermQuery innerJoinAcquisitionRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the AcquisitionRelationship relation
 *
 * @method CvtermQuery leftJoinAcquisitionprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisitionprop relation
 * @method CvtermQuery rightJoinAcquisitionprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisitionprop relation
 * @method CvtermQuery innerJoinAcquisitionprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisitionprop relation
 *
 * @method CvtermQuery leftJoinAnalysisfeatureprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisfeatureprop relation
 * @method CvtermQuery rightJoinAnalysisfeatureprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisfeatureprop relation
 * @method CvtermQuery innerJoinAnalysisfeatureprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisfeatureprop relation
 *
 * @method CvtermQuery leftJoinAnalysisprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisprop relation
 * @method CvtermQuery rightJoinAnalysisprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisprop relation
 * @method CvtermQuery innerJoinAnalysisprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisprop relation
 *
 * @method CvtermQuery leftJoinArraydesignRelatedByPlatformtypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ArraydesignRelatedByPlatformtypeId relation
 * @method CvtermQuery rightJoinArraydesignRelatedByPlatformtypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ArraydesignRelatedByPlatformtypeId relation
 * @method CvtermQuery innerJoinArraydesignRelatedByPlatformtypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the ArraydesignRelatedByPlatformtypeId relation
 *
 * @method CvtermQuery leftJoinArraydesignRelatedBySubstratetypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ArraydesignRelatedBySubstratetypeId relation
 * @method CvtermQuery rightJoinArraydesignRelatedBySubstratetypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ArraydesignRelatedBySubstratetypeId relation
 * @method CvtermQuery innerJoinArraydesignRelatedBySubstratetypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the ArraydesignRelatedBySubstratetypeId relation
 *
 * @method CvtermQuery leftJoinArraydesignprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arraydesignprop relation
 * @method CvtermQuery rightJoinArraydesignprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arraydesignprop relation
 * @method CvtermQuery innerJoinArraydesignprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Arraydesignprop relation
 *
 * @method CvtermQuery leftJoinAssayprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assayprop relation
 * @method CvtermQuery rightJoinAssayprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assayprop relation
 * @method CvtermQuery innerJoinAssayprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Assayprop relation
 *
 * @method CvtermQuery leftJoinBiomaterialRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialRelationship relation
 * @method CvtermQuery rightJoinBiomaterialRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialRelationship relation
 * @method CvtermQuery innerJoinBiomaterialRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialRelationship relation
 *
 * @method CvtermQuery leftJoinBiomaterialTreatment($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialTreatment relation
 * @method CvtermQuery rightJoinBiomaterialTreatment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialTreatment relation
 * @method CvtermQuery innerJoinBiomaterialTreatment($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialTreatment relation
 *
 * @method CvtermQuery leftJoinBiomaterialprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterialprop relation
 * @method CvtermQuery rightJoinBiomaterialprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterialprop relation
 * @method CvtermQuery innerJoinBiomaterialprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterialprop relation
 *
 * @method CvtermQuery leftJoinChadoprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Chadoprop relation
 * @method CvtermQuery rightJoinChadoprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Chadoprop relation
 * @method CvtermQuery innerJoinChadoprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Chadoprop relation
 *
 * @method CvtermQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method CvtermQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method CvtermQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method CvtermQuery leftJoinContactRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the ContactRelationship relation
 * @method CvtermQuery rightJoinContactRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ContactRelationship relation
 * @method CvtermQuery innerJoinContactRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the ContactRelationship relation
 *
 * @method CvtermQuery leftJoinControl($relationAlias = null) Adds a LEFT JOIN clause to the query using the Control relation
 * @method CvtermQuery rightJoinControl($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Control relation
 * @method CvtermQuery innerJoinControl($relationAlias = null) Adds a INNER JOIN clause to the query using the Control relation
 *
 * @method CvtermQuery leftJoinCvprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvprop relation
 * @method CvtermQuery rightJoinCvprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvprop relation
 * @method CvtermQuery innerJoinCvprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvprop relation
 *
 * @method CvtermQuery leftJoinCvtermDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermDbxref relation
 * @method CvtermQuery rightJoinCvtermDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermDbxref relation
 * @method CvtermQuery innerJoinCvtermDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermDbxref relation
 *
 * @method CvtermQuery leftJoinCvtermRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelationshipRelatedByObjectId relation
 * @method CvtermQuery rightJoinCvtermRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelationshipRelatedByObjectId relation
 * @method CvtermQuery innerJoinCvtermRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelationshipRelatedByObjectId relation
 *
 * @method CvtermQuery leftJoinCvtermRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelationshipRelatedBySubjectId relation
 * @method CvtermQuery rightJoinCvtermRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelationshipRelatedBySubjectId relation
 * @method CvtermQuery innerJoinCvtermRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelationshipRelatedBySubjectId relation
 *
 * @method CvtermQuery leftJoinCvtermRelationshipRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelationshipRelatedByTypeId relation
 * @method CvtermQuery rightJoinCvtermRelationshipRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelationshipRelatedByTypeId relation
 * @method CvtermQuery innerJoinCvtermRelationshipRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelationshipRelatedByTypeId relation
 *
 * @method CvtermQuery leftJoinCvtermpathRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermpathRelatedByObjectId relation
 * @method CvtermQuery rightJoinCvtermpathRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermpathRelatedByObjectId relation
 * @method CvtermQuery innerJoinCvtermpathRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermpathRelatedByObjectId relation
 *
 * @method CvtermQuery leftJoinCvtermpathRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermpathRelatedBySubjectId relation
 * @method CvtermQuery rightJoinCvtermpathRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermpathRelatedBySubjectId relation
 * @method CvtermQuery innerJoinCvtermpathRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermpathRelatedBySubjectId relation
 *
 * @method CvtermQuery leftJoinCvtermpathRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermpathRelatedByTypeId relation
 * @method CvtermQuery rightJoinCvtermpathRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermpathRelatedByTypeId relation
 * @method CvtermQuery innerJoinCvtermpathRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermpathRelatedByTypeId relation
 *
 * @method CvtermQuery leftJoinCvtermpropRelatedByCvtermId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermpropRelatedByCvtermId relation
 * @method CvtermQuery rightJoinCvtermpropRelatedByCvtermId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermpropRelatedByCvtermId relation
 * @method CvtermQuery innerJoinCvtermpropRelatedByCvtermId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermpropRelatedByCvtermId relation
 *
 * @method CvtermQuery leftJoinCvtermpropRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermpropRelatedByTypeId relation
 * @method CvtermQuery rightJoinCvtermpropRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermpropRelatedByTypeId relation
 * @method CvtermQuery innerJoinCvtermpropRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermpropRelatedByTypeId relation
 *
 * @method CvtermQuery leftJoinCvtermsynonymRelatedByCvtermId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermsynonymRelatedByCvtermId relation
 * @method CvtermQuery rightJoinCvtermsynonymRelatedByCvtermId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermsynonymRelatedByCvtermId relation
 * @method CvtermQuery innerJoinCvtermsynonymRelatedByCvtermId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermsynonymRelatedByCvtermId relation
 *
 * @method CvtermQuery leftJoinCvtermsynonymRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermsynonymRelatedByTypeId relation
 * @method CvtermQuery rightJoinCvtermsynonymRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermsynonymRelatedByTypeId relation
 * @method CvtermQuery innerJoinCvtermsynonymRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermsynonymRelatedByTypeId relation
 *
 * @method CvtermQuery leftJoinDbxrefprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxrefprop relation
 * @method CvtermQuery rightJoinDbxrefprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxrefprop relation
 * @method CvtermQuery innerJoinDbxrefprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxrefprop relation
 *
 * @method CvtermQuery leftJoinElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Element relation
 * @method CvtermQuery rightJoinElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Element relation
 * @method CvtermQuery innerJoinElement($relationAlias = null) Adds a INNER JOIN clause to the query using the Element relation
 *
 * @method CvtermQuery leftJoinElementRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementRelationship relation
 * @method CvtermQuery rightJoinElementRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementRelationship relation
 * @method CvtermQuery innerJoinElementRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementRelationship relation
 *
 * @method CvtermQuery leftJoinElementresultRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementresultRelationship relation
 * @method CvtermQuery rightJoinElementresultRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementresultRelationship relation
 * @method CvtermQuery innerJoinElementresultRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementresultRelationship relation
 *
 * @method CvtermQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method CvtermQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method CvtermQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method CvtermQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method CvtermQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method CvtermQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method CvtermQuery leftJoinFeatureCvtermprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermprop relation
 * @method CvtermQuery rightJoinFeatureCvtermprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermprop relation
 * @method CvtermQuery innerJoinFeatureCvtermprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermprop relation
 *
 * @method CvtermQuery leftJoinFeaturePubprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeaturePubprop relation
 * @method CvtermQuery rightJoinFeaturePubprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeaturePubprop relation
 * @method CvtermQuery innerJoinFeaturePubprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeaturePubprop relation
 *
 * @method CvtermQuery leftJoinFeatureRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationship relation
 * @method CvtermQuery rightJoinFeatureRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationship relation
 * @method CvtermQuery innerJoinFeatureRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationship relation
 *
 * @method CvtermQuery leftJoinFeatureRelationshipprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationshipprop relation
 * @method CvtermQuery rightJoinFeatureRelationshipprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationshipprop relation
 * @method CvtermQuery innerJoinFeatureRelationshipprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationshipprop relation
 *
 * @method CvtermQuery leftJoinFeatureprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Featureprop relation
 * @method CvtermQuery rightJoinFeatureprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Featureprop relation
 * @method CvtermQuery innerJoinFeatureprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Featureprop relation
 *
 * @method CvtermQuery leftJoinOrganismprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Organismprop relation
 * @method CvtermQuery rightJoinOrganismprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Organismprop relation
 * @method CvtermQuery innerJoinOrganismprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Organismprop relation
 *
 * @method CvtermQuery leftJoinProjectRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectRelationship relation
 * @method CvtermQuery rightJoinProjectRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectRelationship relation
 * @method CvtermQuery innerJoinProjectRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectRelationship relation
 *
 * @method CvtermQuery leftJoinProjectprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projectprop relation
 * @method CvtermQuery rightJoinProjectprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projectprop relation
 * @method CvtermQuery innerJoinProjectprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Projectprop relation
 *
 * @method CvtermQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method CvtermQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method CvtermQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method CvtermQuery leftJoinProtocolparamRelatedByDatatypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProtocolparamRelatedByDatatypeId relation
 * @method CvtermQuery rightJoinProtocolparamRelatedByDatatypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProtocolparamRelatedByDatatypeId relation
 * @method CvtermQuery innerJoinProtocolparamRelatedByDatatypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProtocolparamRelatedByDatatypeId relation
 *
 * @method CvtermQuery leftJoinProtocolparamRelatedByUnittypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProtocolparamRelatedByUnittypeId relation
 * @method CvtermQuery rightJoinProtocolparamRelatedByUnittypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProtocolparamRelatedByUnittypeId relation
 * @method CvtermQuery innerJoinProtocolparamRelatedByUnittypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProtocolparamRelatedByUnittypeId relation
 *
 * @method CvtermQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method CvtermQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method CvtermQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method CvtermQuery leftJoinPubRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubRelationship relation
 * @method CvtermQuery rightJoinPubRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubRelationship relation
 * @method CvtermQuery innerJoinPubRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the PubRelationship relation
 *
 * @method CvtermQuery leftJoinPubprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pubprop relation
 * @method CvtermQuery rightJoinPubprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pubprop relation
 * @method CvtermQuery innerJoinPubprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Pubprop relation
 *
 * @method CvtermQuery leftJoinQuantificationRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the QuantificationRelationship relation
 * @method CvtermQuery rightJoinQuantificationRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the QuantificationRelationship relation
 * @method CvtermQuery innerJoinQuantificationRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the QuantificationRelationship relation
 *
 * @method CvtermQuery leftJoinQuantificationprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantificationprop relation
 * @method CvtermQuery rightJoinQuantificationprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantificationprop relation
 * @method CvtermQuery innerJoinQuantificationprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantificationprop relation
 *
 * @method CvtermQuery leftJoinQuantificationresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantificationresult relation
 * @method CvtermQuery rightJoinQuantificationresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantificationresult relation
 * @method CvtermQuery innerJoinQuantificationresult($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantificationresult relation
 *
 * @method CvtermQuery leftJoinStudydesignprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studydesignprop relation
 * @method CvtermQuery rightJoinStudydesignprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studydesignprop relation
 * @method CvtermQuery innerJoinStudydesignprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Studydesignprop relation
 *
 * @method CvtermQuery leftJoinStudyfactor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyfactor relation
 * @method CvtermQuery rightJoinStudyfactor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyfactor relation
 * @method CvtermQuery innerJoinStudyfactor($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyfactor relation
 *
 * @method CvtermQuery leftJoinStudyprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyprop relation
 * @method CvtermQuery rightJoinStudyprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyprop relation
 * @method CvtermQuery innerJoinStudyprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyprop relation
 *
 * @method CvtermQuery leftJoinStudypropFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the StudypropFeature relation
 * @method CvtermQuery rightJoinStudypropFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StudypropFeature relation
 * @method CvtermQuery innerJoinStudypropFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the StudypropFeature relation
 *
 * @method CvtermQuery leftJoinSynonym($relationAlias = null) Adds a LEFT JOIN clause to the query using the Synonym relation
 * @method CvtermQuery rightJoinSynonym($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Synonym relation
 * @method CvtermQuery innerJoinSynonym($relationAlias = null) Adds a INNER JOIN clause to the query using the Synonym relation
 *
 * @method CvtermQuery leftJoinTreatment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Treatment relation
 * @method CvtermQuery rightJoinTreatment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Treatment relation
 * @method CvtermQuery innerJoinTreatment($relationAlias = null) Adds a INNER JOIN clause to the query using the Treatment relation
 *
 * @method CvtermQuery leftJoinWebuserData($relationAlias = null) Adds a LEFT JOIN clause to the query using the WebuserData relation
 * @method CvtermQuery rightJoinWebuserData($relationAlias = null) Adds a RIGHT JOIN clause to the query using the WebuserData relation
 * @method CvtermQuery innerJoinWebuserData($relationAlias = null) Adds a INNER JOIN clause to the query using the WebuserData relation
 *
 * @method Cvterm findOne(PropelPDO $con = null) Return the first Cvterm matching the query
 * @method Cvterm findOneOrCreate(PropelPDO $con = null) Return the first Cvterm matching the query, or a new Cvterm object populated from the query conditions when no match is found
 *
 * @method Cvterm findOneByCvId(int $cv_id) Return the first Cvterm filtered by the cv_id column
 * @method Cvterm findOneByName(string $name) Return the first Cvterm filtered by the name column
 * @method Cvterm findOneByDefinition(string $definition) Return the first Cvterm filtered by the definition column
 * @method Cvterm findOneByDbxrefId(int $dbxref_id) Return the first Cvterm filtered by the dbxref_id column
 * @method Cvterm findOneByIsObsolete(int $is_obsolete) Return the first Cvterm filtered by the is_obsolete column
 * @method Cvterm findOneByIsRelationshiptype(int $is_relationshiptype) Return the first Cvterm filtered by the is_relationshiptype column
 *
 * @method array findByCvtermId(int $cvterm_id) Return Cvterm objects filtered by the cvterm_id column
 * @method array findByCvId(int $cv_id) Return Cvterm objects filtered by the cv_id column
 * @method array findByName(string $name) Return Cvterm objects filtered by the name column
 * @method array findByDefinition(string $definition) Return Cvterm objects filtered by the definition column
 * @method array findByDbxrefId(int $dbxref_id) Return Cvterm objects filtered by the dbxref_id column
 * @method array findByIsObsolete(int $is_obsolete) Return Cvterm objects filtered by the is_obsolete column
 * @method array findByIsRelationshiptype(int $is_relationshiptype) Return Cvterm objects filtered by the is_relationshiptype column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvtermQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Cvterm', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvtermQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvtermQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvtermQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvtermQuery) {
            return $criteria;
        }
        $query = new CvtermQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Cvterm|Cvterm[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvtermPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Cvterm A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvtermId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Cvterm A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cvterm_id", "cv_id", "name", "definition", "dbxref_id", "is_obsolete", "is_relationshiptype" FROM "cvterm" WHERE "cvterm_id" = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Cvterm();
            $obj->hydrate($row);
            CvtermPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Cvterm|Cvterm[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Cvterm[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermId(1234); // WHERE cvterm_id = 1234
     * $query->filterByCvtermId(array(12, 34)); // WHERE cvterm_id IN (12, 34)
     * $query->filterByCvtermId(array('min' => 12)); // WHERE cvterm_id >= 12
     * $query->filterByCvtermId(array('max' => 12)); // WHERE cvterm_id <= 12
     * </code>
     *
     * @param     mixed $cvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByCvtermId($cvtermId = null, $comparison = null)
    {
        if (is_array($cvtermId)) {
            $useMinMax = false;
            if (isset($cvtermId['min'])) {
                $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermId['max'])) {
                $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermId, $comparison);
    }

    /**
     * Filter the query on the cv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvId(1234); // WHERE cv_id = 1234
     * $query->filterByCvId(array(12, 34)); // WHERE cv_id IN (12, 34)
     * $query->filterByCvId(array('min' => 12)); // WHERE cv_id >= 12
     * $query->filterByCvId(array('max' => 12)); // WHERE cv_id <= 12
     * </code>
     *
     * @see       filterByCv()
     *
     * @param     mixed $cvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByCvId($cvId = null, $comparison = null)
    {
        if (is_array($cvId)) {
            $useMinMax = false;
            if (isset($cvId['min'])) {
                $this->addUsingAlias(CvtermPeer::CV_ID, $cvId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvId['max'])) {
                $this->addUsingAlias(CvtermPeer::CV_ID, $cvId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::CV_ID, $cvId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CvtermPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the definition column
     *
     * Example usage:
     * <code>
     * $query->filterByDefinition('fooValue');   // WHERE definition = 'fooValue'
     * $query->filterByDefinition('%fooValue%'); // WHERE definition LIKE '%fooValue%'
     * </code>
     *
     * @param     string $definition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByDefinition($definition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($definition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $definition)) {
                $definition = str_replace('*', '%', $definition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CvtermPeer::DEFINITION, $definition, $comparison);
    }

    /**
     * Filter the query on the dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDbxrefId(1234); // WHERE dbxref_id = 1234
     * $query->filterByDbxrefId(array(12, 34)); // WHERE dbxref_id IN (12, 34)
     * $query->filterByDbxrefId(array('min' => 12)); // WHERE dbxref_id >= 12
     * $query->filterByDbxrefId(array('max' => 12)); // WHERE dbxref_id <= 12
     * </code>
     *
     * @see       filterByDbxref()
     *
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query on the is_obsolete column
     *
     * Example usage:
     * <code>
     * $query->filterByIsObsolete(1234); // WHERE is_obsolete = 1234
     * $query->filterByIsObsolete(array(12, 34)); // WHERE is_obsolete IN (12, 34)
     * $query->filterByIsObsolete(array('min' => 12)); // WHERE is_obsolete >= 12
     * $query->filterByIsObsolete(array('max' => 12)); // WHERE is_obsolete <= 12
     * </code>
     *
     * @param     mixed $isObsolete The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByIsObsolete($isObsolete = null, $comparison = null)
    {
        if (is_array($isObsolete)) {
            $useMinMax = false;
            if (isset($isObsolete['min'])) {
                $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isObsolete['max'])) {
                $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::IS_OBSOLETE, $isObsolete, $comparison);
    }

    /**
     * Filter the query on the is_relationshiptype column
     *
     * Example usage:
     * <code>
     * $query->filterByIsRelationshiptype(1234); // WHERE is_relationshiptype = 1234
     * $query->filterByIsRelationshiptype(array(12, 34)); // WHERE is_relationshiptype IN (12, 34)
     * $query->filterByIsRelationshiptype(array('min' => 12)); // WHERE is_relationshiptype >= 12
     * $query->filterByIsRelationshiptype(array('max' => 12)); // WHERE is_relationshiptype <= 12
     * </code>
     *
     * @param     mixed $isRelationshiptype The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function filterByIsRelationshiptype($isRelationshiptype = null, $comparison = null)
    {
        if (is_array($isRelationshiptype)) {
            $useMinMax = false;
            if (isset($isRelationshiptype['min'])) {
                $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isRelationshiptype['max'])) {
                $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermPeer::IS_RELATIONSHIPTYPE, $isRelationshiptype, $comparison);
    }

    /**
     * Filter the query by a related Cv object
     *
     * @param   Cv|PropelObjectCollection $cv The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCv($cv, $comparison = null)
    {
        if ($cv instanceof Cv) {
            return $this
                ->addUsingAlias(CvtermPeer::CV_ID, $cv->getCvId(), $comparison);
        } elseif ($cv instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermPeer::CV_ID, $cv->toKeyValue('PrimaryKey', 'CvId'), $comparison);
        } else {
            throw new PropelException('filterByCv() only accepts arguments of type Cv or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cv relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCv($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cv');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Cv');
        }

        return $this;
    }

    /**
     * Use the Cv relation Cv object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvQuery A secondary query class using the current class as primary query
     */
    public function useCvQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCv($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cv', '\cli_db\propel\CvQuery');
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
        } else {
            throw new PropelException('filterByDbxref() only accepts arguments of type Dbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Dbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Dbxref');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Dbxref');
        }

        return $this;
    }

    /**
     * Use the Dbxref relation Dbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbxrefQuery A secondary query class using the current class as primary query
     */
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related AcquisitionRelationship object
     *
     * @param   AcquisitionRelationship|PropelObjectCollection $acquisitionRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionRelationship($acquisitionRelationship, $comparison = null)
    {
        if ($acquisitionRelationship instanceof AcquisitionRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $acquisitionRelationship->getTypeId(), $comparison);
        } elseif ($acquisitionRelationship instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionRelationshipQuery()
                ->filterByPrimaryKeys($acquisitionRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAcquisitionRelationship() only accepts arguments of type AcquisitionRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AcquisitionRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinAcquisitionRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AcquisitionRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'AcquisitionRelationship');
        }

        return $this;
    }

    /**
     * Use the AcquisitionRelationship relation AcquisitionRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AcquisitionRelationship', '\cli_db\propel\AcquisitionRelationshipQuery');
    }

    /**
     * Filter the query by a related Acquisitionprop object
     *
     * @param   Acquisitionprop|PropelObjectCollection $acquisitionprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionprop($acquisitionprop, $comparison = null)
    {
        if ($acquisitionprop instanceof Acquisitionprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $acquisitionprop->getTypeId(), $comparison);
        } elseif ($acquisitionprop instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionpropQuery()
                ->filterByPrimaryKeys($acquisitionprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAcquisitionprop() only accepts arguments of type Acquisitionprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Acquisitionprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinAcquisitionprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Acquisitionprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Acquisitionprop');
        }

        return $this;
    }

    /**
     * Use the Acquisitionprop relation Acquisitionprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionpropQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Acquisitionprop', '\cli_db\propel\AcquisitionpropQuery');
    }

    /**
     * Filter the query by a related Analysisfeatureprop object
     *
     * @param   Analysisfeatureprop|PropelObjectCollection $analysisfeatureprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisfeatureprop($analysisfeatureprop, $comparison = null)
    {
        if ($analysisfeatureprop instanceof Analysisfeatureprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $analysisfeatureprop->getTypeId(), $comparison);
        } elseif ($analysisfeatureprop instanceof PropelObjectCollection) {
            return $this
                ->useAnalysisfeaturepropQuery()
                ->filterByPrimaryKeys($analysisfeatureprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnalysisfeatureprop() only accepts arguments of type Analysisfeatureprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisfeatureprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinAnalysisfeatureprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisfeatureprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Analysisfeatureprop');
        }

        return $this;
    }

    /**
     * Use the Analysisfeatureprop relation Analysisfeatureprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisfeaturepropQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisfeaturepropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisfeatureprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisfeatureprop', '\cli_db\propel\AnalysisfeaturepropQuery');
    }

    /**
     * Filter the query by a related Analysisprop object
     *
     * @param   Analysisprop|PropelObjectCollection $analysisprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisprop($analysisprop, $comparison = null)
    {
        if ($analysisprop instanceof Analysisprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $analysisprop->getTypeId(), $comparison);
        } elseif ($analysisprop instanceof PropelObjectCollection) {
            return $this
                ->useAnalysispropQuery()
                ->filterByPrimaryKeys($analysisprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnalysisprop() only accepts arguments of type Analysisprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinAnalysisprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Analysisprop');
        }

        return $this;
    }

    /**
     * Use the Analysisprop relation Analysisprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysispropQuery A secondary query class using the current class as primary query
     */
    public function useAnalysispropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisprop', '\cli_db\propel\AnalysispropQuery');
    }

    /**
     * Filter the query by a related Arraydesign object
     *
     * @param   Arraydesign|PropelObjectCollection $arraydesign  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesignRelatedByPlatformtypeId($arraydesign, $comparison = null)
    {
        if ($arraydesign instanceof Arraydesign) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $arraydesign->getPlatformtypeId(), $comparison);
        } elseif ($arraydesign instanceof PropelObjectCollection) {
            return $this
                ->useArraydesignRelatedByPlatformtypeIdQuery()
                ->filterByPrimaryKeys($arraydesign->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArraydesignRelatedByPlatformtypeId() only accepts arguments of type Arraydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ArraydesignRelatedByPlatformtypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinArraydesignRelatedByPlatformtypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ArraydesignRelatedByPlatformtypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ArraydesignRelatedByPlatformtypeId');
        }

        return $this;
    }

    /**
     * Use the ArraydesignRelatedByPlatformtypeId relation Arraydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignRelatedByPlatformtypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArraydesignRelatedByPlatformtypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ArraydesignRelatedByPlatformtypeId', '\cli_db\propel\ArraydesignQuery');
    }

    /**
     * Filter the query by a related Arraydesign object
     *
     * @param   Arraydesign|PropelObjectCollection $arraydesign  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesignRelatedBySubstratetypeId($arraydesign, $comparison = null)
    {
        if ($arraydesign instanceof Arraydesign) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $arraydesign->getSubstratetypeId(), $comparison);
        } elseif ($arraydesign instanceof PropelObjectCollection) {
            return $this
                ->useArraydesignRelatedBySubstratetypeIdQuery()
                ->filterByPrimaryKeys($arraydesign->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArraydesignRelatedBySubstratetypeId() only accepts arguments of type Arraydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ArraydesignRelatedBySubstratetypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinArraydesignRelatedBySubstratetypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ArraydesignRelatedBySubstratetypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ArraydesignRelatedBySubstratetypeId');
        }

        return $this;
    }

    /**
     * Use the ArraydesignRelatedBySubstratetypeId relation Arraydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignRelatedBySubstratetypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinArraydesignRelatedBySubstratetypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ArraydesignRelatedBySubstratetypeId', '\cli_db\propel\ArraydesignQuery');
    }

    /**
     * Filter the query by a related Arraydesignprop object
     *
     * @param   Arraydesignprop|PropelObjectCollection $arraydesignprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesignprop($arraydesignprop, $comparison = null)
    {
        if ($arraydesignprop instanceof Arraydesignprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $arraydesignprop->getTypeId(), $comparison);
        } elseif ($arraydesignprop instanceof PropelObjectCollection) {
            return $this
                ->useArraydesignpropQuery()
                ->filterByPrimaryKeys($arraydesignprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArraydesignprop() only accepts arguments of type Arraydesignprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arraydesignprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinArraydesignprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arraydesignprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Arraydesignprop');
        }

        return $this;
    }

    /**
     * Use the Arraydesignprop relation Arraydesignprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignpropQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArraydesignprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arraydesignprop', '\cli_db\propel\ArraydesignpropQuery');
    }

    /**
     * Filter the query by a related Assayprop object
     *
     * @param   Assayprop|PropelObjectCollection $assayprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssayprop($assayprop, $comparison = null)
    {
        if ($assayprop instanceof Assayprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $assayprop->getTypeId(), $comparison);
        } elseif ($assayprop instanceof PropelObjectCollection) {
            return $this
                ->useAssaypropQuery()
                ->filterByPrimaryKeys($assayprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssayprop() only accepts arguments of type Assayprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Assayprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinAssayprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Assayprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Assayprop');
        }

        return $this;
    }

    /**
     * Use the Assayprop relation Assayprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssaypropQuery A secondary query class using the current class as primary query
     */
    public function useAssaypropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssayprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Assayprop', '\cli_db\propel\AssaypropQuery');
    }

    /**
     * Filter the query by a related BiomaterialRelationship object
     *
     * @param   BiomaterialRelationship|PropelObjectCollection $biomaterialRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialRelationship($biomaterialRelationship, $comparison = null)
    {
        if ($biomaterialRelationship instanceof BiomaterialRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $biomaterialRelationship->getTypeId(), $comparison);
        } elseif ($biomaterialRelationship instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialRelationshipQuery()
                ->filterByPrimaryKeys($biomaterialRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialRelationship() only accepts arguments of type BiomaterialRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinBiomaterialRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BiomaterialRelationship');
        }

        return $this;
    }

    /**
     * Use the BiomaterialRelationship relation BiomaterialRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialRelationship', '\cli_db\propel\BiomaterialRelationshipQuery');
    }

    /**
     * Filter the query by a related BiomaterialTreatment object
     *
     * @param   BiomaterialTreatment|PropelObjectCollection $biomaterialTreatment  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialTreatment($biomaterialTreatment, $comparison = null)
    {
        if ($biomaterialTreatment instanceof BiomaterialTreatment) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $biomaterialTreatment->getUnittypeId(), $comparison);
        } elseif ($biomaterialTreatment instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialTreatmentQuery()
                ->filterByPrimaryKeys($biomaterialTreatment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialTreatment() only accepts arguments of type BiomaterialTreatment or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialTreatment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinBiomaterialTreatment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialTreatment');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'BiomaterialTreatment');
        }

        return $this;
    }

    /**
     * Use the BiomaterialTreatment relation BiomaterialTreatment object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialTreatmentQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialTreatmentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBiomaterialTreatment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialTreatment', '\cli_db\propel\BiomaterialTreatmentQuery');
    }

    /**
     * Filter the query by a related Biomaterialprop object
     *
     * @param   Biomaterialprop|PropelObjectCollection $biomaterialprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialprop($biomaterialprop, $comparison = null)
    {
        if ($biomaterialprop instanceof Biomaterialprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $biomaterialprop->getTypeId(), $comparison);
        } elseif ($biomaterialprop instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialpropQuery()
                ->filterByPrimaryKeys($biomaterialprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialprop() only accepts arguments of type Biomaterialprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biomaterialprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinBiomaterialprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biomaterialprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Biomaterialprop');
        }

        return $this;
    }

    /**
     * Use the Biomaterialprop relation Biomaterialprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialpropQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biomaterialprop', '\cli_db\propel\BiomaterialpropQuery');
    }

    /**
     * Filter the query by a related Chadoprop object
     *
     * @param   Chadoprop|PropelObjectCollection $chadoprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByChadoprop($chadoprop, $comparison = null)
    {
        if ($chadoprop instanceof Chadoprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $chadoprop->getTypeId(), $comparison);
        } elseif ($chadoprop instanceof PropelObjectCollection) {
            return $this
                ->useChadopropQuery()
                ->filterByPrimaryKeys($chadoprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByChadoprop() only accepts arguments of type Chadoprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Chadoprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinChadoprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Chadoprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Chadoprop');
        }

        return $this;
    }

    /**
     * Use the Chadoprop relation Chadoprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ChadopropQuery A secondary query class using the current class as primary query
     */
    public function useChadopropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinChadoprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Chadoprop', '\cli_db\propel\ChadopropQuery');
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $contact->getTypeId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            return $this
                ->useContactQuery()
                ->filterByPrimaryKeys($contact->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type Contact or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\cli_db\propel\ContactQuery');
    }

    /**
     * Filter the query by a related ContactRelationship object
     *
     * @param   ContactRelationship|PropelObjectCollection $contactRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContactRelationship($contactRelationship, $comparison = null)
    {
        if ($contactRelationship instanceof ContactRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $contactRelationship->getTypeId(), $comparison);
        } elseif ($contactRelationship instanceof PropelObjectCollection) {
            return $this
                ->useContactRelationshipQuery()
                ->filterByPrimaryKeys($contactRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByContactRelationship() only accepts arguments of type ContactRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ContactRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinContactRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ContactRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ContactRelationship');
        }

        return $this;
    }

    /**
     * Use the ContactRelationship relation ContactRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ContactRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useContactRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContactRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ContactRelationship', '\cli_db\propel\ContactRelationshipQuery');
    }

    /**
     * Filter the query by a related Control object
     *
     * @param   Control|PropelObjectCollection $control  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByControl($control, $comparison = null)
    {
        if ($control instanceof Control) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $control->getTypeId(), $comparison);
        } elseif ($control instanceof PropelObjectCollection) {
            return $this
                ->useControlQuery()
                ->filterByPrimaryKeys($control->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByControl() only accepts arguments of type Control or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Control relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinControl($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Control');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Control');
        }

        return $this;
    }

    /**
     * Use the Control relation Control object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ControlQuery A secondary query class using the current class as primary query
     */
    public function useControlQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinControl($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Control', '\cli_db\propel\ControlQuery');
    }

    /**
     * Filter the query by a related Cvprop object
     *
     * @param   Cvprop|PropelObjectCollection $cvprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvprop($cvprop, $comparison = null)
    {
        if ($cvprop instanceof Cvprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvprop->getTypeId(), $comparison);
        } elseif ($cvprop instanceof PropelObjectCollection) {
            return $this
                ->useCvpropQuery()
                ->filterByPrimaryKeys($cvprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvprop() only accepts arguments of type Cvprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cvprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cvprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Cvprop');
        }

        return $this;
    }

    /**
     * Use the Cvprop relation Cvprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvpropQuery A secondary query class using the current class as primary query
     */
    public function useCvpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cvprop', '\cli_db\propel\CvpropQuery');
    }

    /**
     * Filter the query by a related CvtermDbxref object
     *
     * @param   CvtermDbxref|PropelObjectCollection $cvtermDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermDbxref($cvtermDbxref, $comparison = null)
    {
        if ($cvtermDbxref instanceof CvtermDbxref) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermDbxref->getCvtermId(), $comparison);
        } elseif ($cvtermDbxref instanceof PropelObjectCollection) {
            return $this
                ->useCvtermDbxrefQuery()
                ->filterByPrimaryKeys($cvtermDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermDbxref() only accepts arguments of type CvtermDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermDbxref');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermDbxref');
        }

        return $this;
    }

    /**
     * Use the CvtermDbxref relation CvtermDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermDbxrefQuery A secondary query class using the current class as primary query
     */
    public function useCvtermDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermDbxref', '\cli_db\propel\CvtermDbxrefQuery');
    }

    /**
     * Filter the query by a related CvtermRelationship object
     *
     * @param   CvtermRelationship|PropelObjectCollection $cvtermRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelationshipRelatedByObjectId($cvtermRelationship, $comparison = null)
    {
        if ($cvtermRelationship instanceof CvtermRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermRelationship->getObjectId(), $comparison);
        } elseif ($cvtermRelationship instanceof PropelObjectCollection) {
            return $this
                ->useCvtermRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($cvtermRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermRelationshipRelatedByObjectId() only accepts arguments of type CvtermRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelationshipRelatedByObjectId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelationshipRelatedByObjectId relation CvtermRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelationshipRelatedByObjectId', '\cli_db\propel\CvtermRelationshipQuery');
    }

    /**
     * Filter the query by a related CvtermRelationship object
     *
     * @param   CvtermRelationship|PropelObjectCollection $cvtermRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelationshipRelatedBySubjectId($cvtermRelationship, $comparison = null)
    {
        if ($cvtermRelationship instanceof CvtermRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermRelationship->getSubjectId(), $comparison);
        } elseif ($cvtermRelationship instanceof PropelObjectCollection) {
            return $this
                ->useCvtermRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($cvtermRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermRelationshipRelatedBySubjectId() only accepts arguments of type CvtermRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelationshipRelatedBySubjectId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelationshipRelatedBySubjectId relation CvtermRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelationshipRelatedBySubjectId', '\cli_db\propel\CvtermRelationshipQuery');
    }

    /**
     * Filter the query by a related CvtermRelationship object
     *
     * @param   CvtermRelationship|PropelObjectCollection $cvtermRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelationshipRelatedByTypeId($cvtermRelationship, $comparison = null)
    {
        if ($cvtermRelationship instanceof CvtermRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermRelationship->getTypeId(), $comparison);
        } elseif ($cvtermRelationship instanceof PropelObjectCollection) {
            return $this
                ->useCvtermRelationshipRelatedByTypeIdQuery()
                ->filterByPrimaryKeys($cvtermRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermRelationshipRelatedByTypeId() only accepts arguments of type CvtermRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelationshipRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermRelationshipRelatedByTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelationshipRelatedByTypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermRelationshipRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelationshipRelatedByTypeId relation CvtermRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelationshipRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelationshipRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelationshipRelatedByTypeId', '\cli_db\propel\CvtermRelationshipQuery');
    }

    /**
     * Filter the query by a related Cvtermpath object
     *
     * @param   Cvtermpath|PropelObjectCollection $cvtermpath  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermpathRelatedByObjectId($cvtermpath, $comparison = null)
    {
        if ($cvtermpath instanceof Cvtermpath) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermpath->getObjectId(), $comparison);
        } elseif ($cvtermpath instanceof PropelObjectCollection) {
            return $this
                ->useCvtermpathRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($cvtermpath->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermpathRelatedByObjectId() only accepts arguments of type Cvtermpath or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermpathRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermpathRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermpathRelatedByObjectId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermpathRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermpathRelatedByObjectId relation Cvtermpath object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermpathQuery A secondary query class using the current class as primary query
     */
    public function useCvtermpathRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermpathRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermpathRelatedByObjectId', '\cli_db\propel\CvtermpathQuery');
    }

    /**
     * Filter the query by a related Cvtermpath object
     *
     * @param   Cvtermpath|PropelObjectCollection $cvtermpath  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermpathRelatedBySubjectId($cvtermpath, $comparison = null)
    {
        if ($cvtermpath instanceof Cvtermpath) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermpath->getSubjectId(), $comparison);
        } elseif ($cvtermpath instanceof PropelObjectCollection) {
            return $this
                ->useCvtermpathRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($cvtermpath->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermpathRelatedBySubjectId() only accepts arguments of type Cvtermpath or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermpathRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermpathRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermpathRelatedBySubjectId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermpathRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermpathRelatedBySubjectId relation Cvtermpath object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermpathQuery A secondary query class using the current class as primary query
     */
    public function useCvtermpathRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermpathRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermpathRelatedBySubjectId', '\cli_db\propel\CvtermpathQuery');
    }

    /**
     * Filter the query by a related Cvtermpath object
     *
     * @param   Cvtermpath|PropelObjectCollection $cvtermpath  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermpathRelatedByTypeId($cvtermpath, $comparison = null)
    {
        if ($cvtermpath instanceof Cvtermpath) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermpath->getTypeId(), $comparison);
        } elseif ($cvtermpath instanceof PropelObjectCollection) {
            return $this
                ->useCvtermpathRelatedByTypeIdQuery()
                ->filterByPrimaryKeys($cvtermpath->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermpathRelatedByTypeId() only accepts arguments of type Cvtermpath or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermpathRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermpathRelatedByTypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermpathRelatedByTypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermpathRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermpathRelatedByTypeId relation Cvtermpath object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermpathQuery A secondary query class using the current class as primary query
     */
    public function useCvtermpathRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvtermpathRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermpathRelatedByTypeId', '\cli_db\propel\CvtermpathQuery');
    }

    /**
     * Filter the query by a related Cvtermprop object
     *
     * @param   Cvtermprop|PropelObjectCollection $cvtermprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermpropRelatedByCvtermId($cvtermprop, $comparison = null)
    {
        if ($cvtermprop instanceof Cvtermprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermprop->getCvtermId(), $comparison);
        } elseif ($cvtermprop instanceof PropelObjectCollection) {
            return $this
                ->useCvtermpropRelatedByCvtermIdQuery()
                ->filterByPrimaryKeys($cvtermprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermpropRelatedByCvtermId() only accepts arguments of type Cvtermprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermpropRelatedByCvtermId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermpropRelatedByCvtermId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermpropRelatedByCvtermId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermpropRelatedByCvtermId');
        }

        return $this;
    }

    /**
     * Use the CvtermpropRelatedByCvtermId relation Cvtermprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermpropQuery A secondary query class using the current class as primary query
     */
    public function useCvtermpropRelatedByCvtermIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermpropRelatedByCvtermId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermpropRelatedByCvtermId', '\cli_db\propel\CvtermpropQuery');
    }

    /**
     * Filter the query by a related Cvtermprop object
     *
     * @param   Cvtermprop|PropelObjectCollection $cvtermprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermpropRelatedByTypeId($cvtermprop, $comparison = null)
    {
        if ($cvtermprop instanceof Cvtermprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermprop->getTypeId(), $comparison);
        } elseif ($cvtermprop instanceof PropelObjectCollection) {
            return $this
                ->useCvtermpropRelatedByTypeIdQuery()
                ->filterByPrimaryKeys($cvtermprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermpropRelatedByTypeId() only accepts arguments of type Cvtermprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermpropRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermpropRelatedByTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermpropRelatedByTypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermpropRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermpropRelatedByTypeId relation Cvtermprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermpropQuery A secondary query class using the current class as primary query
     */
    public function useCvtermpropRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermpropRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermpropRelatedByTypeId', '\cli_db\propel\CvtermpropQuery');
    }

    /**
     * Filter the query by a related Cvtermsynonym object
     *
     * @param   Cvtermsynonym|PropelObjectCollection $cvtermsynonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermsynonymRelatedByCvtermId($cvtermsynonym, $comparison = null)
    {
        if ($cvtermsynonym instanceof Cvtermsynonym) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermsynonym->getCvtermId(), $comparison);
        } elseif ($cvtermsynonym instanceof PropelObjectCollection) {
            return $this
                ->useCvtermsynonymRelatedByCvtermIdQuery()
                ->filterByPrimaryKeys($cvtermsynonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermsynonymRelatedByCvtermId() only accepts arguments of type Cvtermsynonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermsynonymRelatedByCvtermId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermsynonymRelatedByCvtermId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermsynonymRelatedByCvtermId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermsynonymRelatedByCvtermId');
        }

        return $this;
    }

    /**
     * Use the CvtermsynonymRelatedByCvtermId relation Cvtermsynonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermsynonymQuery A secondary query class using the current class as primary query
     */
    public function useCvtermsynonymRelatedByCvtermIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermsynonymRelatedByCvtermId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermsynonymRelatedByCvtermId', '\cli_db\propel\CvtermsynonymQuery');
    }

    /**
     * Filter the query by a related Cvtermsynonym object
     *
     * @param   Cvtermsynonym|PropelObjectCollection $cvtermsynonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermsynonymRelatedByTypeId($cvtermsynonym, $comparison = null)
    {
        if ($cvtermsynonym instanceof Cvtermsynonym) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $cvtermsynonym->getTypeId(), $comparison);
        } elseif ($cvtermsynonym instanceof PropelObjectCollection) {
            return $this
                ->useCvtermsynonymRelatedByTypeIdQuery()
                ->filterByPrimaryKeys($cvtermsynonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByCvtermsynonymRelatedByTypeId() only accepts arguments of type Cvtermsynonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermsynonymRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinCvtermsynonymRelatedByTypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermsynonymRelatedByTypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'CvtermsynonymRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermsynonymRelatedByTypeId relation Cvtermsynonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermsynonymQuery A secondary query class using the current class as primary query
     */
    public function useCvtermsynonymRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvtermsynonymRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermsynonymRelatedByTypeId', '\cli_db\propel\CvtermsynonymQuery');
    }

    /**
     * Filter the query by a related Dbxrefprop object
     *
     * @param   Dbxrefprop|PropelObjectCollection $dbxrefprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxrefprop($dbxrefprop, $comparison = null)
    {
        if ($dbxrefprop instanceof Dbxrefprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $dbxrefprop->getTypeId(), $comparison);
        } elseif ($dbxrefprop instanceof PropelObjectCollection) {
            return $this
                ->useDbxrefpropQuery()
                ->filterByPrimaryKeys($dbxrefprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByDbxrefprop() only accepts arguments of type Dbxrefprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Dbxrefprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinDbxrefprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Dbxrefprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Dbxrefprop');
        }

        return $this;
    }

    /**
     * Use the Dbxrefprop relation Dbxrefprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbxrefpropQuery A secondary query class using the current class as primary query
     */
    public function useDbxrefpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDbxrefprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxrefprop', '\cli_db\propel\DbxrefpropQuery');
    }

    /**
     * Filter the query by a related Element object
     *
     * @param   Element|PropelObjectCollection $element  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElement($element, $comparison = null)
    {
        if ($element instanceof Element) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $element->getTypeId(), $comparison);
        } elseif ($element instanceof PropelObjectCollection) {
            return $this
                ->useElementQuery()
                ->filterByPrimaryKeys($element->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElement() only accepts arguments of type Element or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Element relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinElement($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Element');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Element');
        }

        return $this;
    }

    /**
     * Use the Element relation Element object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Element', '\cli_db\propel\ElementQuery');
    }

    /**
     * Filter the query by a related ElementRelationship object
     *
     * @param   ElementRelationship|PropelObjectCollection $elementRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementRelationship($elementRelationship, $comparison = null)
    {
        if ($elementRelationship instanceof ElementRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $elementRelationship->getTypeId(), $comparison);
        } elseif ($elementRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementRelationshipQuery()
                ->filterByPrimaryKeys($elementRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementRelationship() only accepts arguments of type ElementRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinElementRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ElementRelationship');
        }

        return $this;
    }

    /**
     * Use the ElementRelationship relation ElementRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementRelationship', '\cli_db\propel\ElementRelationshipQuery');
    }

    /**
     * Filter the query by a related ElementresultRelationship object
     *
     * @param   ElementresultRelationship|PropelObjectCollection $elementresultRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementresultRelationship($elementresultRelationship, $comparison = null)
    {
        if ($elementresultRelationship instanceof ElementresultRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $elementresultRelationship->getTypeId(), $comparison);
        } elseif ($elementresultRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementresultRelationshipQuery()
                ->filterByPrimaryKeys($elementresultRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementresultRelationship() only accepts arguments of type ElementresultRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementresultRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinElementresultRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementresultRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ElementresultRelationship');
        }

        return $this;
    }

    /**
     * Use the ElementresultRelationship relation ElementresultRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementresultRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementresultRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementresultRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementresultRelationship', '\cli_db\propel\ElementresultRelationshipQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $feature->getTypeId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            return $this
                ->useFeatureQuery()
                ->filterByPrimaryKeys($feature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureCvterm->getCvtermId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermQuery()
                ->filterByPrimaryKeys($featureCvterm->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvterm() only accepts arguments of type FeatureCvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvterm');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureCvterm');
        }

        return $this;
    }

    /**
     * Use the FeatureCvterm relation FeatureCvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvterm', '\cli_db\propel\FeatureCvtermQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermprop object
     *
     * @param   FeatureCvtermprop|PropelObjectCollection $featureCvtermprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermprop($featureCvtermprop, $comparison = null)
    {
        if ($featureCvtermprop instanceof FeatureCvtermprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureCvtermprop->getTypeId(), $comparison);
        } elseif ($featureCvtermprop instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermpropQuery()
                ->filterByPrimaryKeys($featureCvtermprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermprop() only accepts arguments of type FeatureCvtermprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureCvtermprop');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermprop relation FeatureCvtermprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermpropQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermprop', '\cli_db\propel\FeatureCvtermpropQuery');
    }

    /**
     * Filter the query by a related FeaturePubprop object
     *
     * @param   FeaturePubprop|PropelObjectCollection $featurePubprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeaturePubprop($featurePubprop, $comparison = null)
    {
        if ($featurePubprop instanceof FeaturePubprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featurePubprop->getTypeId(), $comparison);
        } elseif ($featurePubprop instanceof PropelObjectCollection) {
            return $this
                ->useFeaturePubpropQuery()
                ->filterByPrimaryKeys($featurePubprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeaturePubprop() only accepts arguments of type FeaturePubprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeaturePubprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeaturePubprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeaturePubprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeaturePubprop');
        }

        return $this;
    }

    /**
     * Use the FeaturePubprop relation FeaturePubprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturePubpropQuery A secondary query class using the current class as primary query
     */
    public function useFeaturePubpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeaturePubprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeaturePubprop', '\cli_db\propel\FeaturePubpropQuery');
    }

    /**
     * Filter the query by a related FeatureRelationship object
     *
     * @param   FeatureRelationship|PropelObjectCollection $featureRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationship($featureRelationship, $comparison = null)
    {
        if ($featureRelationship instanceof FeatureRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureRelationship->getTypeId(), $comparison);
        } elseif ($featureRelationship instanceof PropelObjectCollection) {
            return $this
                ->useFeatureRelationshipQuery()
                ->filterByPrimaryKeys($featureRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureRelationship() only accepts arguments of type FeatureRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureRelationship');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationship relation FeatureRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationship', '\cli_db\propel\FeatureRelationshipQuery');
    }

    /**
     * Filter the query by a related FeatureRelationshipprop object
     *
     * @param   FeatureRelationshipprop|PropelObjectCollection $featureRelationshipprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationshipprop($featureRelationshipprop, $comparison = null)
    {
        if ($featureRelationshipprop instanceof FeatureRelationshipprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureRelationshipprop->getTypeId(), $comparison);
        } elseif ($featureRelationshipprop instanceof PropelObjectCollection) {
            return $this
                ->useFeatureRelationshippropQuery()
                ->filterByPrimaryKeys($featureRelationshipprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureRelationshipprop() only accepts arguments of type FeatureRelationshipprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationshipprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureRelationshipprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationshipprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'FeatureRelationshipprop');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationshipprop relation FeatureRelationshipprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshippropQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshippropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationshipprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationshipprop', '\cli_db\propel\FeatureRelationshippropQuery');
    }

    /**
     * Filter the query by a related Featureprop object
     *
     * @param   Featureprop|PropelObjectCollection $featureprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureprop($featureprop, $comparison = null)
    {
        if ($featureprop instanceof Featureprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $featureprop->getTypeId(), $comparison);
        } elseif ($featureprop instanceof PropelObjectCollection) {
            return $this
                ->useFeaturepropQuery()
                ->filterByPrimaryKeys($featureprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureprop() only accepts arguments of type Featureprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Featureprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinFeatureprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Featureprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Featureprop');
        }

        return $this;
    }

    /**
     * Use the Featureprop relation Featureprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturepropQuery A secondary query class using the current class as primary query
     */
    public function useFeaturepropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Featureprop', '\cli_db\propel\FeaturepropQuery');
    }

    /**
     * Filter the query by a related Organismprop object
     *
     * @param   Organismprop|PropelObjectCollection $organismprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOrganismprop($organismprop, $comparison = null)
    {
        if ($organismprop instanceof Organismprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $organismprop->getTypeId(), $comparison);
        } elseif ($organismprop instanceof PropelObjectCollection) {
            return $this
                ->useOrganismpropQuery()
                ->filterByPrimaryKeys($organismprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByOrganismprop() only accepts arguments of type Organismprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Organismprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinOrganismprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Organismprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Organismprop');
        }

        return $this;
    }

    /**
     * Use the Organismprop relation Organismprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\OrganismpropQuery A secondary query class using the current class as primary query
     */
    public function useOrganismpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrganismprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Organismprop', '\cli_db\propel\OrganismpropQuery');
    }

    /**
     * Filter the query by a related ProjectRelationship object
     *
     * @param   ProjectRelationship|PropelObjectCollection $projectRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectRelationship($projectRelationship, $comparison = null)
    {
        if ($projectRelationship instanceof ProjectRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $projectRelationship->getTypeId(), $comparison);
        } elseif ($projectRelationship instanceof PropelObjectCollection) {
            return $this
                ->useProjectRelationshipQuery()
                ->filterByPrimaryKeys($projectRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectRelationship() only accepts arguments of type ProjectRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProjectRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProjectRelationship');
        }

        return $this;
    }

    /**
     * Use the ProjectRelationship relation ProjectRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useProjectRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectRelationship', '\cli_db\propel\ProjectRelationshipQuery');
    }

    /**
     * Filter the query by a related Projectprop object
     *
     * @param   Projectprop|PropelObjectCollection $projectprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectprop($projectprop, $comparison = null)
    {
        if ($projectprop instanceof Projectprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $projectprop->getTypeId(), $comparison);
        } elseif ($projectprop instanceof PropelObjectCollection) {
            return $this
                ->useProjectpropQuery()
                ->filterByPrimaryKeys($projectprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectprop() only accepts arguments of type Projectprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projectprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProjectprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projectprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Projectprop');
        }

        return $this;
    }

    /**
     * Use the Projectprop relation Projectprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectpropQuery A secondary query class using the current class as primary query
     */
    public function useProjectpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projectprop', '\cli_db\propel\ProjectpropQuery');
    }

    /**
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $protocol->getTypeId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            return $this
                ->useProtocolQuery()
                ->filterByPrimaryKeys($protocol->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProtocol() only accepts arguments of type Protocol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Protocol relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProtocol($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Protocol');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Protocol');
        }

        return $this;
    }

    /**
     * Use the Protocol relation Protocol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolQuery A secondary query class using the current class as primary query
     */
    public function useProtocolQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProtocol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Protocol', '\cli_db\propel\ProtocolQuery');
    }

    /**
     * Filter the query by a related Protocolparam object
     *
     * @param   Protocolparam|PropelObjectCollection $protocolparam  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocolparamRelatedByDatatypeId($protocolparam, $comparison = null)
    {
        if ($protocolparam instanceof Protocolparam) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $protocolparam->getDatatypeId(), $comparison);
        } elseif ($protocolparam instanceof PropelObjectCollection) {
            return $this
                ->useProtocolparamRelatedByDatatypeIdQuery()
                ->filterByPrimaryKeys($protocolparam->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProtocolparamRelatedByDatatypeId() only accepts arguments of type Protocolparam or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProtocolparamRelatedByDatatypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProtocolparamRelatedByDatatypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProtocolparamRelatedByDatatypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProtocolparamRelatedByDatatypeId');
        }

        return $this;
    }

    /**
     * Use the ProtocolparamRelatedByDatatypeId relation Protocolparam object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolparamQuery A secondary query class using the current class as primary query
     */
    public function useProtocolparamRelatedByDatatypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProtocolparamRelatedByDatatypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProtocolparamRelatedByDatatypeId', '\cli_db\propel\ProtocolparamQuery');
    }

    /**
     * Filter the query by a related Protocolparam object
     *
     * @param   Protocolparam|PropelObjectCollection $protocolparam  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocolparamRelatedByUnittypeId($protocolparam, $comparison = null)
    {
        if ($protocolparam instanceof Protocolparam) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $protocolparam->getUnittypeId(), $comparison);
        } elseif ($protocolparam instanceof PropelObjectCollection) {
            return $this
                ->useProtocolparamRelatedByUnittypeIdQuery()
                ->filterByPrimaryKeys($protocolparam->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProtocolparamRelatedByUnittypeId() only accepts arguments of type Protocolparam or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProtocolparamRelatedByUnittypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinProtocolparamRelatedByUnittypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProtocolparamRelatedByUnittypeId');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'ProtocolparamRelatedByUnittypeId');
        }

        return $this;
    }

    /**
     * Use the ProtocolparamRelatedByUnittypeId relation Protocolparam object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolparamQuery A secondary query class using the current class as primary query
     */
    public function useProtocolparamRelatedByUnittypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProtocolparamRelatedByUnittypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProtocolparamRelatedByUnittypeId', '\cli_db\propel\ProtocolparamQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pub->getTypeId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            return $this
                ->usePubQuery()
                ->filterByPrimaryKeys($pub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPub() only accepts arguments of type Pub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pub');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pub');
        }

        return $this;
    }

    /**
     * Use the Pub relation Pub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubQuery A secondary query class using the current class as primary query
     */
    public function usePubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Filter the query by a related PubRelationship object
     *
     * @param   PubRelationship|PropelObjectCollection $pubRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubRelationship($pubRelationship, $comparison = null)
    {
        if ($pubRelationship instanceof PubRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pubRelationship->getTypeId(), $comparison);
        } elseif ($pubRelationship instanceof PropelObjectCollection) {
            return $this
                ->usePubRelationshipQuery()
                ->filterByPrimaryKeys($pubRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubRelationship() only accepts arguments of type PubRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPubRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'PubRelationship');
        }

        return $this;
    }

    /**
     * Use the PubRelationship relation PubRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubRelationshipQuery A secondary query class using the current class as primary query
     */
    public function usePubRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubRelationship', '\cli_db\propel\PubRelationshipQuery');
    }

    /**
     * Filter the query by a related Pubprop object
     *
     * @param   Pubprop|PropelObjectCollection $pubprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubprop($pubprop, $comparison = null)
    {
        if ($pubprop instanceof Pubprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $pubprop->getTypeId(), $comparison);
        } elseif ($pubprop instanceof PropelObjectCollection) {
            return $this
                ->usePubpropQuery()
                ->filterByPrimaryKeys($pubprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubprop() only accepts arguments of type Pubprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pubprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinPubprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pubprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Pubprop');
        }

        return $this;
    }

    /**
     * Use the Pubprop relation Pubprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubpropQuery A secondary query class using the current class as primary query
     */
    public function usePubpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pubprop', '\cli_db\propel\PubpropQuery');
    }

    /**
     * Filter the query by a related QuantificationRelationship object
     *
     * @param   QuantificationRelationship|PropelObjectCollection $quantificationRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationRelationship($quantificationRelationship, $comparison = null)
    {
        if ($quantificationRelationship instanceof QuantificationRelationship) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $quantificationRelationship->getTypeId(), $comparison);
        } elseif ($quantificationRelationship instanceof PropelObjectCollection) {
            return $this
                ->useQuantificationRelationshipQuery()
                ->filterByPrimaryKeys($quantificationRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuantificationRelationship() only accepts arguments of type QuantificationRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the QuantificationRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinQuantificationRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('QuantificationRelationship');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'QuantificationRelationship');
        }

        return $this;
    }

    /**
     * Use the QuantificationRelationship relation QuantificationRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantificationRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'QuantificationRelationship', '\cli_db\propel\QuantificationRelationshipQuery');
    }

    /**
     * Filter the query by a related Quantificationprop object
     *
     * @param   Quantificationprop|PropelObjectCollection $quantificationprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationprop($quantificationprop, $comparison = null)
    {
        if ($quantificationprop instanceof Quantificationprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $quantificationprop->getTypeId(), $comparison);
        } elseif ($quantificationprop instanceof PropelObjectCollection) {
            return $this
                ->useQuantificationpropQuery()
                ->filterByPrimaryKeys($quantificationprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuantificationprop() only accepts arguments of type Quantificationprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantificationprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinQuantificationprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantificationprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Quantificationprop');
        }

        return $this;
    }

    /**
     * Use the Quantificationprop relation Quantificationprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationpropQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantificationprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantificationprop', '\cli_db\propel\QuantificationpropQuery');
    }

    /**
     * Filter the query by a related Quantificationresult object
     *
     * @param   Quantificationresult|PropelObjectCollection $quantificationresult  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationresult($quantificationresult, $comparison = null)
    {
        if ($quantificationresult instanceof Quantificationresult) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $quantificationresult->getTypeId(), $comparison);
        } elseif ($quantificationresult instanceof PropelObjectCollection) {
            return $this
                ->useQuantificationresultQuery()
                ->filterByPrimaryKeys($quantificationresult->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuantificationresult() only accepts arguments of type Quantificationresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantificationresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinQuantificationresult($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantificationresult');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Quantificationresult');
        }

        return $this;
    }

    /**
     * Use the Quantificationresult relation Quantificationresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationresultQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationresultQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantificationresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantificationresult', '\cli_db\propel\QuantificationresultQuery');
    }

    /**
     * Filter the query by a related Studydesignprop object
     *
     * @param   Studydesignprop|PropelObjectCollection $studydesignprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudydesignprop($studydesignprop, $comparison = null)
    {
        if ($studydesignprop instanceof Studydesignprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $studydesignprop->getTypeId(), $comparison);
        } elseif ($studydesignprop instanceof PropelObjectCollection) {
            return $this
                ->useStudydesignpropQuery()
                ->filterByPrimaryKeys($studydesignprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudydesignprop() only accepts arguments of type Studydesignprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studydesignprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinStudydesignprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studydesignprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Studydesignprop');
        }

        return $this;
    }

    /**
     * Use the Studydesignprop relation Studydesignprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudydesignpropQuery A secondary query class using the current class as primary query
     */
    public function useStudydesignpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudydesignprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studydesignprop', '\cli_db\propel\StudydesignpropQuery');
    }

    /**
     * Filter the query by a related Studyfactor object
     *
     * @param   Studyfactor|PropelObjectCollection $studyfactor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyfactor($studyfactor, $comparison = null)
    {
        if ($studyfactor instanceof Studyfactor) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $studyfactor->getTypeId(), $comparison);
        } elseif ($studyfactor instanceof PropelObjectCollection) {
            return $this
                ->useStudyfactorQuery()
                ->filterByPrimaryKeys($studyfactor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyfactor() only accepts arguments of type Studyfactor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyfactor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinStudyfactor($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyfactor');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Studyfactor');
        }

        return $this;
    }

    /**
     * Use the Studyfactor relation Studyfactor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyfactorQuery A secondary query class using the current class as primary query
     */
    public function useStudyfactorQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStudyfactor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyfactor', '\cli_db\propel\StudyfactorQuery');
    }

    /**
     * Filter the query by a related Studyprop object
     *
     * @param   Studyprop|PropelObjectCollection $studyprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyprop($studyprop, $comparison = null)
    {
        if ($studyprop instanceof Studyprop) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $studyprop->getTypeId(), $comparison);
        } elseif ($studyprop instanceof PropelObjectCollection) {
            return $this
                ->useStudypropQuery()
                ->filterByPrimaryKeys($studyprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyprop() only accepts arguments of type Studyprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinStudyprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyprop');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Studyprop');
        }

        return $this;
    }

    /**
     * Use the Studyprop relation Studyprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudypropQuery A secondary query class using the current class as primary query
     */
    public function useStudypropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyprop', '\cli_db\propel\StudypropQuery');
    }

    /**
     * Filter the query by a related StudypropFeature object
     *
     * @param   StudypropFeature|PropelObjectCollection $studypropFeature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudypropFeature($studypropFeature, $comparison = null)
    {
        if ($studypropFeature instanceof StudypropFeature) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $studypropFeature->getTypeId(), $comparison);
        } elseif ($studypropFeature instanceof PropelObjectCollection) {
            return $this
                ->useStudypropFeatureQuery()
                ->filterByPrimaryKeys($studypropFeature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudypropFeature() only accepts arguments of type StudypropFeature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StudypropFeature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinStudypropFeature($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StudypropFeature');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'StudypropFeature');
        }

        return $this;
    }

    /**
     * Use the StudypropFeature relation StudypropFeature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudypropFeatureQuery A secondary query class using the current class as primary query
     */
    public function useStudypropFeatureQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinStudypropFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StudypropFeature', '\cli_db\propel\StudypropFeatureQuery');
    }

    /**
     * Filter the query by a related Synonym object
     *
     * @param   Synonym|PropelObjectCollection $synonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySynonym($synonym, $comparison = null)
    {
        if ($synonym instanceof Synonym) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $synonym->getTypeId(), $comparison);
        } elseif ($synonym instanceof PropelObjectCollection) {
            return $this
                ->useSynonymQuery()
                ->filterByPrimaryKeys($synonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterBySynonym() only accepts arguments of type Synonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Synonym relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinSynonym($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Synonym');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Synonym');
        }

        return $this;
    }

    /**
     * Use the Synonym relation Synonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\SynonymQuery A secondary query class using the current class as primary query
     */
    public function useSynonymQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSynonym($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Synonym', '\cli_db\propel\SynonymQuery');
    }

    /**
     * Filter the query by a related Treatment object
     *
     * @param   Treatment|PropelObjectCollection $treatment  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTreatment($treatment, $comparison = null)
    {
        if ($treatment instanceof Treatment) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $treatment->getTypeId(), $comparison);
        } elseif ($treatment instanceof PropelObjectCollection) {
            return $this
                ->useTreatmentQuery()
                ->filterByPrimaryKeys($treatment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTreatment() only accepts arguments of type Treatment or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Treatment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinTreatment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Treatment');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Treatment');
        }

        return $this;
    }

    /**
     * Use the Treatment relation Treatment object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\TreatmentQuery A secondary query class using the current class as primary query
     */
    public function useTreatmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTreatment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Treatment', '\cli_db\propel\TreatmentQuery');
    }

    /**
     * Filter the query by a related WebuserData object
     *
     * @param   WebuserData|PropelObjectCollection $webuserData  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByWebuserData($webuserData, $comparison = null)
    {
        if ($webuserData instanceof WebuserData) {
            return $this
                ->addUsingAlias(CvtermPeer::CVTERM_ID, $webuserData->getTypeId(), $comparison);
        } elseif ($webuserData instanceof PropelObjectCollection) {
            return $this
                ->useWebuserDataQuery()
                ->filterByPrimaryKeys($webuserData->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByWebuserData() only accepts arguments of type WebuserData or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the WebuserData relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function joinWebuserData($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('WebuserData');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'WebuserData');
        }

        return $this;
    }

    /**
     * Use the WebuserData relation WebuserData object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\WebuserDataQuery A secondary query class using the current class as primary query
     */
    public function useWebuserDataQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinWebuserData($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'WebuserData', '\cli_db\propel\WebuserDataQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Cvterm $cvterm Object to remove from the list of results
     *
     * @return CvtermQuery The current query, for fluid interface
     */
    public function prune($cvterm = null)
    {
        if ($cvterm) {
            $this->addUsingAlias(CvtermPeer::CVTERM_ID, $cvterm->getCvtermId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
