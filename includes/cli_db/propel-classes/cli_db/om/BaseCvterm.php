<?php

namespace cli_db\propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\AcquisitionRelationshipQuery;
use cli_db\propel\Acquisitionprop;
use cli_db\propel\AcquisitionpropQuery;
use cli_db\propel\Analysisfeatureprop;
use cli_db\propel\AnalysisfeaturepropQuery;
use cli_db\propel\Analysisprop;
use cli_db\propel\AnalysispropQuery;
use cli_db\propel\Arraydesign;
use cli_db\propel\ArraydesignQuery;
use cli_db\propel\Arraydesignprop;
use cli_db\propel\ArraydesignpropQuery;
use cli_db\propel\Assayprop;
use cli_db\propel\AssaypropQuery;
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\BiomaterialRelationshipQuery;
use cli_db\propel\BiomaterialTreatment;
use cli_db\propel\BiomaterialTreatmentQuery;
use cli_db\propel\Biomaterialprop;
use cli_db\propel\BiomaterialpropQuery;
use cli_db\propel\Chadoprop;
use cli_db\propel\ChadopropQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\ContactRelationship;
use cli_db\propel\ContactRelationshipQuery;
use cli_db\propel\Control;
use cli_db\propel\ControlQuery;
use cli_db\propel\Cv;
use cli_db\propel\CvQuery;
use cli_db\propel\Cvprop;
use cli_db\propel\CvpropQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermDbxref;
use cli_db\propel\CvtermDbxrefQuery;
use cli_db\propel\CvtermPeer;
use cli_db\propel\CvtermQuery;
use cli_db\propel\CvtermRelationship;
use cli_db\propel\CvtermRelationshipQuery;
use cli_db\propel\Cvtermpath;
use cli_db\propel\CvtermpathQuery;
use cli_db\propel\Cvtermprop;
use cli_db\propel\CvtermpropQuery;
use cli_db\propel\Cvtermsynonym;
use cli_db\propel\CvtermsynonymQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Dbxrefprop;
use cli_db\propel\DbxrefpropQuery;
use cli_db\propel\Element;
use cli_db\propel\ElementQuery;
use cli_db\propel\ElementRelationship;
use cli_db\propel\ElementRelationshipQuery;
use cli_db\propel\ElementresultRelationship;
use cli_db\propel\ElementresultRelationshipQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\FeatureCvtermpropQuery;
use cli_db\propel\FeaturePubprop;
use cli_db\propel\FeaturePubpropQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipQuery;
use cli_db\propel\FeatureRelationshipprop;
use cli_db\propel\FeatureRelationshippropQuery;
use cli_db\propel\Featureprop;
use cli_db\propel\FeaturepropQuery;
use cli_db\propel\Organismprop;
use cli_db\propel\OrganismpropQuery;
use cli_db\propel\ProjectRelationship;
use cli_db\propel\ProjectRelationshipQuery;
use cli_db\propel\Projectprop;
use cli_db\propel\ProjectpropQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Protocolparam;
use cli_db\propel\ProtocolparamQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;
use cli_db\propel\PubRelationship;
use cli_db\propel\PubRelationshipQuery;
use cli_db\propel\Pubprop;
use cli_db\propel\PubpropQuery;
use cli_db\propel\QuantificationRelationship;
use cli_db\propel\QuantificationRelationshipQuery;
use cli_db\propel\Quantificationprop;
use cli_db\propel\QuantificationpropQuery;
use cli_db\propel\Quantificationresult;
use cli_db\propel\QuantificationresultQuery;
use cli_db\propel\Studydesignprop;
use cli_db\propel\StudydesignpropQuery;
use cli_db\propel\Studyfactor;
use cli_db\propel\StudyfactorQuery;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropFeature;
use cli_db\propel\StudypropFeatureQuery;
use cli_db\propel\StudypropQuery;
use cli_db\propel\Synonym;
use cli_db\propel\SynonymQuery;
use cli_db\propel\Treatment;
use cli_db\propel\TreatmentQuery;
use cli_db\propel\WebuserData;
use cli_db\propel\WebuserDataQuery;

/**
 * Base class that represents a row from the 'cvterm' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvterm extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\CvtermPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CvtermPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the cvterm_id field.
     * @var        int
     */
    protected $cvterm_id;

    /**
     * The value for the cv_id field.
     * @var        int
     */
    protected $cv_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the definition field.
     * @var        string
     */
    protected $definition;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * The value for the is_obsolete field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_obsolete;

    /**
     * The value for the is_relationshiptype field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_relationshiptype;

    /**
     * @var        Cv
     */
    protected $aCv;

    /**
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        PropelObjectCollection|AcquisitionRelationship[] Collection to store aggregation of AcquisitionRelationship objects.
     */
    protected $collAcquisitionRelationships;
    protected $collAcquisitionRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Acquisitionprop[] Collection to store aggregation of Acquisitionprop objects.
     */
    protected $collAcquisitionprops;
    protected $collAcquisitionpropsPartial;

    /**
     * @var        PropelObjectCollection|Analysisfeatureprop[] Collection to store aggregation of Analysisfeatureprop objects.
     */
    protected $collAnalysisfeatureprops;
    protected $collAnalysisfeaturepropsPartial;

    /**
     * @var        PropelObjectCollection|Analysisprop[] Collection to store aggregation of Analysisprop objects.
     */
    protected $collAnalysisprops;
    protected $collAnalysispropsPartial;

    /**
     * @var        PropelObjectCollection|Arraydesign[] Collection to store aggregation of Arraydesign objects.
     */
    protected $collArraydesignsRelatedByPlatformtypeId;
    protected $collArraydesignsRelatedByPlatformtypeIdPartial;

    /**
     * @var        PropelObjectCollection|Arraydesign[] Collection to store aggregation of Arraydesign objects.
     */
    protected $collArraydesignsRelatedBySubstratetypeId;
    protected $collArraydesignsRelatedBySubstratetypeIdPartial;

    /**
     * @var        PropelObjectCollection|Arraydesignprop[] Collection to store aggregation of Arraydesignprop objects.
     */
    protected $collArraydesignprops;
    protected $collArraydesignpropsPartial;

    /**
     * @var        PropelObjectCollection|Assayprop[] Collection to store aggregation of Assayprop objects.
     */
    protected $collAssayprops;
    protected $collAssaypropsPartial;

    /**
     * @var        PropelObjectCollection|BiomaterialRelationship[] Collection to store aggregation of BiomaterialRelationship objects.
     */
    protected $collBiomaterialRelationships;
    protected $collBiomaterialRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|BiomaterialTreatment[] Collection to store aggregation of BiomaterialTreatment objects.
     */
    protected $collBiomaterialTreatments;
    protected $collBiomaterialTreatmentsPartial;

    /**
     * @var        PropelObjectCollection|Biomaterialprop[] Collection to store aggregation of Biomaterialprop objects.
     */
    protected $collBiomaterialprops;
    protected $collBiomaterialpropsPartial;

    /**
     * @var        PropelObjectCollection|Chadoprop[] Collection to store aggregation of Chadoprop objects.
     */
    protected $collChadoprops;
    protected $collChadopropsPartial;

    /**
     * @var        PropelObjectCollection|Contact[] Collection to store aggregation of Contact objects.
     */
    protected $collContacts;
    protected $collContactsPartial;

    /**
     * @var        PropelObjectCollection|ContactRelationship[] Collection to store aggregation of ContactRelationship objects.
     */
    protected $collContactRelationships;
    protected $collContactRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Control[] Collection to store aggregation of Control objects.
     */
    protected $collControls;
    protected $collControlsPartial;

    /**
     * @var        PropelObjectCollection|Cvprop[] Collection to store aggregation of Cvprop objects.
     */
    protected $collCvprops;
    protected $collCvpropsPartial;

    /**
     * @var        PropelObjectCollection|CvtermDbxref[] Collection to store aggregation of CvtermDbxref objects.
     */
    protected $collCvtermDbxrefs;
    protected $collCvtermDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|CvtermRelationship[] Collection to store aggregation of CvtermRelationship objects.
     */
    protected $collCvtermRelationshipsRelatedByObjectId;
    protected $collCvtermRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|CvtermRelationship[] Collection to store aggregation of CvtermRelationship objects.
     */
    protected $collCvtermRelationshipsRelatedBySubjectId;
    protected $collCvtermRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|CvtermRelationship[] Collection to store aggregation of CvtermRelationship objects.
     */
    protected $collCvtermRelationshipsRelatedByTypeId;
    protected $collCvtermRelationshipsRelatedByTypeIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermpath[] Collection to store aggregation of Cvtermpath objects.
     */
    protected $collCvtermpathsRelatedByObjectId;
    protected $collCvtermpathsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermpath[] Collection to store aggregation of Cvtermpath objects.
     */
    protected $collCvtermpathsRelatedBySubjectId;
    protected $collCvtermpathsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermpath[] Collection to store aggregation of Cvtermpath objects.
     */
    protected $collCvtermpathsRelatedByTypeId;
    protected $collCvtermpathsRelatedByTypeIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermprop[] Collection to store aggregation of Cvtermprop objects.
     */
    protected $collCvtermpropsRelatedByCvtermId;
    protected $collCvtermpropsRelatedByCvtermIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermprop[] Collection to store aggregation of Cvtermprop objects.
     */
    protected $collCvtermpropsRelatedByTypeId;
    protected $collCvtermpropsRelatedByTypeIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermsynonym[] Collection to store aggregation of Cvtermsynonym objects.
     */
    protected $collCvtermsynonymsRelatedByCvtermId;
    protected $collCvtermsynonymsRelatedByCvtermIdPartial;

    /**
     * @var        PropelObjectCollection|Cvtermsynonym[] Collection to store aggregation of Cvtermsynonym objects.
     */
    protected $collCvtermsynonymsRelatedByTypeId;
    protected $collCvtermsynonymsRelatedByTypeIdPartial;

    /**
     * @var        PropelObjectCollection|Dbxrefprop[] Collection to store aggregation of Dbxrefprop objects.
     */
    protected $collDbxrefprops;
    protected $collDbxrefpropsPartial;

    /**
     * @var        PropelObjectCollection|Element[] Collection to store aggregation of Element objects.
     */
    protected $collElements;
    protected $collElementsPartial;

    /**
     * @var        PropelObjectCollection|ElementRelationship[] Collection to store aggregation of ElementRelationship objects.
     */
    protected $collElementRelationships;
    protected $collElementRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|ElementresultRelationship[] Collection to store aggregation of ElementresultRelationship objects.
     */
    protected $collElementresultRelationships;
    protected $collElementresultRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Feature[] Collection to store aggregation of Feature objects.
     */
    protected $collFeatures;
    protected $collFeaturesPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvterm[] Collection to store aggregation of FeatureCvterm objects.
     */
    protected $collFeatureCvterms;
    protected $collFeatureCvtermsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermprop[] Collection to store aggregation of FeatureCvtermprop objects.
     */
    protected $collFeatureCvtermprops;
    protected $collFeatureCvtermpropsPartial;

    /**
     * @var        PropelObjectCollection|FeaturePubprop[] Collection to store aggregation of FeaturePubprop objects.
     */
    protected $collFeaturePubprops;
    protected $collFeaturePubpropsPartial;

    /**
     * @var        PropelObjectCollection|FeatureRelationship[] Collection to store aggregation of FeatureRelationship objects.
     */
    protected $collFeatureRelationships;
    protected $collFeatureRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|FeatureRelationshipprop[] Collection to store aggregation of FeatureRelationshipprop objects.
     */
    protected $collFeatureRelationshipprops;
    protected $collFeatureRelationshippropsPartial;

    /**
     * @var        PropelObjectCollection|Featureprop[] Collection to store aggregation of Featureprop objects.
     */
    protected $collFeatureprops;
    protected $collFeaturepropsPartial;

    /**
     * @var        PropelObjectCollection|Organismprop[] Collection to store aggregation of Organismprop objects.
     */
    protected $collOrganismprops;
    protected $collOrganismpropsPartial;

    /**
     * @var        PropelObjectCollection|ProjectRelationship[] Collection to store aggregation of ProjectRelationship objects.
     */
    protected $collProjectRelationships;
    protected $collProjectRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Projectprop[] Collection to store aggregation of Projectprop objects.
     */
    protected $collProjectprops;
    protected $collProjectpropsPartial;

    /**
     * @var        PropelObjectCollection|Protocol[] Collection to store aggregation of Protocol objects.
     */
    protected $collProtocols;
    protected $collProtocolsPartial;

    /**
     * @var        PropelObjectCollection|Protocolparam[] Collection to store aggregation of Protocolparam objects.
     */
    protected $collProtocolparamsRelatedByDatatypeId;
    protected $collProtocolparamsRelatedByDatatypeIdPartial;

    /**
     * @var        PropelObjectCollection|Protocolparam[] Collection to store aggregation of Protocolparam objects.
     */
    protected $collProtocolparamsRelatedByUnittypeId;
    protected $collProtocolparamsRelatedByUnittypeIdPartial;

    /**
     * @var        PropelObjectCollection|Pub[] Collection to store aggregation of Pub objects.
     */
    protected $collPubs;
    protected $collPubsPartial;

    /**
     * @var        PropelObjectCollection|PubRelationship[] Collection to store aggregation of PubRelationship objects.
     */
    protected $collPubRelationships;
    protected $collPubRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Pubprop[] Collection to store aggregation of Pubprop objects.
     */
    protected $collPubprops;
    protected $collPubpropsPartial;

    /**
     * @var        PropelObjectCollection|QuantificationRelationship[] Collection to store aggregation of QuantificationRelationship objects.
     */
    protected $collQuantificationRelationships;
    protected $collQuantificationRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Quantificationprop[] Collection to store aggregation of Quantificationprop objects.
     */
    protected $collQuantificationprops;
    protected $collQuantificationpropsPartial;

    /**
     * @var        PropelObjectCollection|Quantificationresult[] Collection to store aggregation of Quantificationresult objects.
     */
    protected $collQuantificationresults;
    protected $collQuantificationresultsPartial;

    /**
     * @var        PropelObjectCollection|Studydesignprop[] Collection to store aggregation of Studydesignprop objects.
     */
    protected $collStudydesignprops;
    protected $collStudydesignpropsPartial;

    /**
     * @var        PropelObjectCollection|Studyfactor[] Collection to store aggregation of Studyfactor objects.
     */
    protected $collStudyfactors;
    protected $collStudyfactorsPartial;

    /**
     * @var        PropelObjectCollection|Studyprop[] Collection to store aggregation of Studyprop objects.
     */
    protected $collStudyprops;
    protected $collStudypropsPartial;

    /**
     * @var        PropelObjectCollection|StudypropFeature[] Collection to store aggregation of StudypropFeature objects.
     */
    protected $collStudypropFeatures;
    protected $collStudypropFeaturesPartial;

    /**
     * @var        PropelObjectCollection|Synonym[] Collection to store aggregation of Synonym objects.
     */
    protected $collSynonyms;
    protected $collSynonymsPartial;

    /**
     * @var        PropelObjectCollection|Treatment[] Collection to store aggregation of Treatment objects.
     */
    protected $collTreatments;
    protected $collTreatmentsPartial;

    /**
     * @var        PropelObjectCollection|WebuserData[] Collection to store aggregation of WebuserData objects.
     */
    protected $collWebuserDatas;
    protected $collWebuserDatasPartial;

    /**
     * Flag to prevent endless save loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInSave = false;

    /**
     * Flag to prevent endless validation loop, if this object is referenced
     * by another object which falls in this transaction.
     * @var        boolean
     */
    protected $alreadyInValidation = false;

    /**
     * Flag to prevent endless clearAllReferences($deep=true) loop, if this object is referenced
     * @var        boolean
     */
    protected $alreadyInClearAllReferencesDeep = false;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $acquisitionRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $acquisitionpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $analysisfeaturepropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $analysispropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $arraydesignsRelatedByPlatformtypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $arraydesignsRelatedBySubstratetypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $arraydesignpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assaypropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialTreatmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $chadopropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contactsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contactRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $controlsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermRelationshipsRelatedByTypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpathsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpathsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpathsRelatedByTypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpropsRelatedByCvtermIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermpropsRelatedByTypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermsynonymsRelatedByCvtermIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermsynonymsRelatedByTypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $dbxrefpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementresultRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurePubpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureRelationshippropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurepropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $organismpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $protocolsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $protocolparamsRelatedByDatatypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $protocolparamsRelatedByUnittypeIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationresultsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studydesignpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studyfactorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studypropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studypropFeaturesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $synonymsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $treatmentsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $webuserDatasScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_obsolete = 0;
        $this->is_relationshiptype = 0;
    }

    /**
     * Initializes internal state of BaseCvterm object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [cvterm_id] column value.
     *
     * @return int
     */
    public function getCvtermId()
    {
        return $this->cvterm_id;
    }

    /**
     * Get the [cv_id] column value.
     *
     * @return int
     */
    public function getCvId()
    {
        return $this->cv_id;
    }

    /**
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [definition] column value.
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Get the [dbxref_id] column value.
     *
     * @return int
     */
    public function getDbxrefId()
    {
        return $this->dbxref_id;
    }

    /**
     * Get the [is_obsolete] column value.
     *
     * @return int
     */
    public function getIsObsolete()
    {
        return $this->is_obsolete;
    }

    /**
     * Get the [is_relationshiptype] column value.
     *
     * @return int
     */
    public function getIsRelationshiptype()
    {
        return $this->is_relationshiptype;
    }

    /**
     * Set the value of [cvterm_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cvterm_id !== $v) {
            $this->cvterm_id = $v;
            $this->modifiedColumns[] = CvtermPeer::CVTERM_ID;
        }


        return $this;
    } // setCvtermId()

    /**
     * Set the value of [cv_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cv_id !== $v) {
            $this->cv_id = $v;
            $this->modifiedColumns[] = CvtermPeer::CV_ID;
        }

        if ($this->aCv !== null && $this->aCv->getCvId() !== $v) {
            $this->aCv = null;
        }


        return $this;
    } // setCvId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CvtermPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [definition] column.
     *
     * @param string $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setDefinition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->definition !== $v) {
            $this->definition = $v;
            $this->modifiedColumns[] = CvtermPeer::DEFINITION;
        }


        return $this;
    } // setDefinition()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = CvtermPeer::DBXREF_ID;
        }

        if ($this->aDbxref !== null && $this->aDbxref->getDbxrefId() !== $v) {
            $this->aDbxref = null;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [is_obsolete] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setIsObsolete($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_obsolete !== $v) {
            $this->is_obsolete = $v;
            $this->modifiedColumns[] = CvtermPeer::IS_OBSOLETE;
        }


        return $this;
    } // setIsObsolete()

    /**
     * Set the value of [is_relationshiptype] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setIsRelationshiptype($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_relationshiptype !== $v) {
            $this->is_relationshiptype = $v;
            $this->modifiedColumns[] = CvtermPeer::IS_RELATIONSHIPTYPE;
        }


        return $this;
    } // setIsRelationshiptype()

    /**
     * Indicates whether the columns in this object are only set to default values.
     *
     * This method can be used in conjunction with isModified() to indicate whether an object is both
     * modified _and_ has some values set which are non-default.
     *
     * @return boolean Whether the columns in this object are only been set with default values.
     */
    public function hasOnlyDefaultValues()
    {
            if ($this->is_obsolete !== 0) {
                return false;
            }

            if ($this->is_relationshiptype !== 0) {
                return false;
            }

        // otherwise, everything was equal, so return true
        return true;
    } // hasOnlyDefaultValues()

    /**
     * Hydrates (populates) the object variables with values from the database resultset.
     *
     * An offset (0-based "start column") is specified so that objects can be hydrated
     * with a subset of the columns in the resultset rows.  This is needed, for example,
     * for results of JOIN queries where the resultset row includes columns from two or
     * more tables.
     *
     * @param array $row The row returned by PDOStatement->fetch(PDO::FETCH_NUM)
     * @param int $startcol 0-based offset column which indicates which restultset column to start with.
     * @param boolean $rehydrate Whether this object is being re-hydrated from the database.
     * @return int             next starting column
     * @throws PropelException - Any caught Exception will be rewrapped as a PropelException.
     */
    public function hydrate($row, $startcol = 0, $rehydrate = false)
    {
        try {

            $this->cvterm_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->cv_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->definition = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->dbxref_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->is_obsolete = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->is_relationshiptype = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = CvtermPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Cvterm object", $e);
        }
    }

    /**
     * Checks and repairs the internal consistency of the object.
     *
     * This method is executed after an already-instantiated object is re-hydrated
     * from the database.  It exists to check any foreign keys to make sure that
     * the objects related to the current object are correct based on foreign key.
     *
     * You can override this method in the stub class, but you should always invoke
     * the base method from the overridden method (i.e. parent::ensureConsistency()),
     * in case your model changes.
     *
     * @throws PropelException
     */
    public function ensureConsistency()
    {

        if ($this->aCv !== null && $this->cv_id !== $this->aCv->getCvId()) {
            $this->aCv = null;
        }
        if ($this->aDbxref !== null && $this->dbxref_id !== $this->aDbxref->getDbxrefId()) {
            $this->aDbxref = null;
        }
    } // ensureConsistency

    /**
     * Reloads this object from datastore based on primary key and (optionally) resets all associated objects.
     *
     * This will only work if the object has been saved and has a valid primary key set.
     *
     * @param boolean $deep (optional) Whether to also de-associated any related objects.
     * @param PropelPDO $con (optional) The PropelPDO connection to use.
     * @return void
     * @throws PropelException - if this object is deleted, unsaved or doesn't have pk match in db
     */
    public function reload($deep = false, PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("Cannot reload a deleted object.");
        }

        if ($this->isNew()) {
            throw new PropelException("Cannot reload an unsaved object.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CvtermPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCv = null;
            $this->aDbxref = null;
            $this->collAcquisitionRelationships = null;

            $this->collAcquisitionprops = null;

            $this->collAnalysisfeatureprops = null;

            $this->collAnalysisprops = null;

            $this->collArraydesignsRelatedByPlatformtypeId = null;

            $this->collArraydesignsRelatedBySubstratetypeId = null;

            $this->collArraydesignprops = null;

            $this->collAssayprops = null;

            $this->collBiomaterialRelationships = null;

            $this->collBiomaterialTreatments = null;

            $this->collBiomaterialprops = null;

            $this->collChadoprops = null;

            $this->collContacts = null;

            $this->collContactRelationships = null;

            $this->collControls = null;

            $this->collCvprops = null;

            $this->collCvtermDbxrefs = null;

            $this->collCvtermRelationshipsRelatedByObjectId = null;

            $this->collCvtermRelationshipsRelatedBySubjectId = null;

            $this->collCvtermRelationshipsRelatedByTypeId = null;

            $this->collCvtermpathsRelatedByObjectId = null;

            $this->collCvtermpathsRelatedBySubjectId = null;

            $this->collCvtermpathsRelatedByTypeId = null;

            $this->collCvtermpropsRelatedByCvtermId = null;

            $this->collCvtermpropsRelatedByTypeId = null;

            $this->collCvtermsynonymsRelatedByCvtermId = null;

            $this->collCvtermsynonymsRelatedByTypeId = null;

            $this->collDbxrefprops = null;

            $this->collElements = null;

            $this->collElementRelationships = null;

            $this->collElementresultRelationships = null;

            $this->collFeatures = null;

            $this->collFeatureCvterms = null;

            $this->collFeatureCvtermprops = null;

            $this->collFeaturePubprops = null;

            $this->collFeatureRelationships = null;

            $this->collFeatureRelationshipprops = null;

            $this->collFeatureprops = null;

            $this->collOrganismprops = null;

            $this->collProjectRelationships = null;

            $this->collProjectprops = null;

            $this->collProtocols = null;

            $this->collProtocolparamsRelatedByDatatypeId = null;

            $this->collProtocolparamsRelatedByUnittypeId = null;

            $this->collPubs = null;

            $this->collPubRelationships = null;

            $this->collPubprops = null;

            $this->collQuantificationRelationships = null;

            $this->collQuantificationprops = null;

            $this->collQuantificationresults = null;

            $this->collStudydesignprops = null;

            $this->collStudyfactors = null;

            $this->collStudyprops = null;

            $this->collStudypropFeatures = null;

            $this->collSynonyms = null;

            $this->collTreatments = null;

            $this->collWebuserDatas = null;

        } // if (deep)
    }

    /**
     * Removes this object from datastore and sets delete attribute.
     *
     * @param PropelPDO $con
     * @return void
     * @throws PropelException
     * @throws Exception
     * @see        BaseObject::setDeleted()
     * @see        BaseObject::isDeleted()
     */
    public function delete(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("This object has already been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CvtermQuery::create()
                ->filterByPrimaryKey($this->getPrimaryKey());
            $ret = $this->preDelete($con);
            if ($ret) {
                $deleteQuery->delete($con);
                $this->postDelete($con);
                $con->commit();
                $this->setDeleted(true);
            } else {
                $con->commit();
            }
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Persists this object to the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All modified related objects will also be persisted in the doSave()
     * method.  This method wraps all precipitate database operations in a
     * single transaction.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @throws Exception
     * @see        doSave()
     */
    public function save(PropelPDO $con = null)
    {
        if ($this->isDeleted()) {
            throw new PropelException("You cannot save an object that has been deleted.");
        }

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        $isInsert = $this->isNew();
        try {
            $ret = $this->preSave($con);
            if ($isInsert) {
                $ret = $ret && $this->preInsert($con);
            } else {
                $ret = $ret && $this->preUpdate($con);
            }
            if ($ret) {
                $affectedRows = $this->doSave($con);
                if ($isInsert) {
                    $this->postInsert($con);
                } else {
                    $this->postUpdate($con);
                }
                $this->postSave($con);
                CvtermPeer::addInstanceToPool($this);
            } else {
                $affectedRows = 0;
            }
            $con->commit();

            return $affectedRows;
        } catch (Exception $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs the work of inserting or updating the row in the database.
     *
     * If the object is new, it inserts it; otherwise an update is performed.
     * All related objects are also updated in this method.
     *
     * @param PropelPDO $con
     * @return int             The number of rows affected by this insert/update and any referring fk objects' save() operations.
     * @throws PropelException
     * @see        save()
     */
    protected function doSave(PropelPDO $con)
    {
        $affectedRows = 0; // initialize var to track total num of affected rows
        if (!$this->alreadyInSave) {
            $this->alreadyInSave = true;

            // We call the save method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCv !== null) {
                if ($this->aCv->isModified() || $this->aCv->isNew()) {
                    $affectedRows += $this->aCv->save($con);
                }
                $this->setCv($this->aCv);
            }

            if ($this->aDbxref !== null) {
                if ($this->aDbxref->isModified() || $this->aDbxref->isNew()) {
                    $affectedRows += $this->aDbxref->save($con);
                }
                $this->setDbxref($this->aDbxref);
            }

            if ($this->isNew() || $this->isModified()) {
                // persist changes
                if ($this->isNew()) {
                    $this->doInsert($con);
                } else {
                    $this->doUpdate($con);
                }
                $affectedRows += 1;
                $this->resetModified();
            }

            if ($this->acquisitionRelationshipsScheduledForDeletion !== null) {
                if (!$this->acquisitionRelationshipsScheduledForDeletion->isEmpty()) {
                    AcquisitionRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->acquisitionRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->acquisitionRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitionRelationships !== null) {
                foreach ($this->collAcquisitionRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->acquisitionpropsScheduledForDeletion !== null) {
                if (!$this->acquisitionpropsScheduledForDeletion->isEmpty()) {
                    AcquisitionpropQuery::create()
                        ->filterByPrimaryKeys($this->acquisitionpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->acquisitionpropsScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitionprops !== null) {
                foreach ($this->collAcquisitionprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->analysisfeaturepropsScheduledForDeletion !== null) {
                if (!$this->analysisfeaturepropsScheduledForDeletion->isEmpty()) {
                    AnalysisfeaturepropQuery::create()
                        ->filterByPrimaryKeys($this->analysisfeaturepropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->analysisfeaturepropsScheduledForDeletion = null;
                }
            }

            if ($this->collAnalysisfeatureprops !== null) {
                foreach ($this->collAnalysisfeatureprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->analysispropsScheduledForDeletion !== null) {
                if (!$this->analysispropsScheduledForDeletion->isEmpty()) {
                    AnalysispropQuery::create()
                        ->filterByPrimaryKeys($this->analysispropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->analysispropsScheduledForDeletion = null;
                }
            }

            if ($this->collAnalysisprops !== null) {
                foreach ($this->collAnalysisprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion !== null) {
                if (!$this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion->isEmpty()) {
                    ArraydesignQuery::create()
                        ->filterByPrimaryKeys($this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collArraydesignsRelatedByPlatformtypeId !== null) {
                foreach ($this->collArraydesignsRelatedByPlatformtypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion !== null) {
                if (!$this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion as $arraydesignRelatedBySubstratetypeId) {
                        // need to save related object because we set the relation to null
                        $arraydesignRelatedBySubstratetypeId->save($con);
                    }
                    $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collArraydesignsRelatedBySubstratetypeId !== null) {
                foreach ($this->collArraydesignsRelatedBySubstratetypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->arraydesignpropsScheduledForDeletion !== null) {
                if (!$this->arraydesignpropsScheduledForDeletion->isEmpty()) {
                    ArraydesignpropQuery::create()
                        ->filterByPrimaryKeys($this->arraydesignpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->arraydesignpropsScheduledForDeletion = null;
                }
            }

            if ($this->collArraydesignprops !== null) {
                foreach ($this->collArraydesignprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assaypropsScheduledForDeletion !== null) {
                if (!$this->assaypropsScheduledForDeletion->isEmpty()) {
                    AssaypropQuery::create()
                        ->filterByPrimaryKeys($this->assaypropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assaypropsScheduledForDeletion = null;
                }
            }

            if ($this->collAssayprops !== null) {
                foreach ($this->collAssayprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialRelationshipsScheduledForDeletion !== null) {
                if (!$this->biomaterialRelationshipsScheduledForDeletion->isEmpty()) {
                    BiomaterialRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialRelationships !== null) {
                foreach ($this->collBiomaterialRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialTreatmentsScheduledForDeletion !== null) {
                if (!$this->biomaterialTreatmentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->biomaterialTreatmentsScheduledForDeletion as $biomaterialTreatment) {
                        // need to save related object because we set the relation to null
                        $biomaterialTreatment->save($con);
                    }
                    $this->biomaterialTreatmentsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialTreatments !== null) {
                foreach ($this->collBiomaterialTreatments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialpropsScheduledForDeletion !== null) {
                if (!$this->biomaterialpropsScheduledForDeletion->isEmpty()) {
                    BiomaterialpropQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialpropsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialprops !== null) {
                foreach ($this->collBiomaterialprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->chadopropsScheduledForDeletion !== null) {
                if (!$this->chadopropsScheduledForDeletion->isEmpty()) {
                    ChadopropQuery::create()
                        ->filterByPrimaryKeys($this->chadopropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->chadopropsScheduledForDeletion = null;
                }
            }

            if ($this->collChadoprops !== null) {
                foreach ($this->collChadoprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contactsScheduledForDeletion !== null) {
                if (!$this->contactsScheduledForDeletion->isEmpty()) {
                    foreach ($this->contactsScheduledForDeletion as $contact) {
                        // need to save related object because we set the relation to null
                        $contact->save($con);
                    }
                    $this->contactsScheduledForDeletion = null;
                }
            }

            if ($this->collContacts !== null) {
                foreach ($this->collContacts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contactRelationshipsScheduledForDeletion !== null) {
                if (!$this->contactRelationshipsScheduledForDeletion->isEmpty()) {
                    ContactRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->contactRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contactRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collContactRelationships !== null) {
                foreach ($this->collContactRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->controlsScheduledForDeletion !== null) {
                if (!$this->controlsScheduledForDeletion->isEmpty()) {
                    ControlQuery::create()
                        ->filterByPrimaryKeys($this->controlsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->controlsScheduledForDeletion = null;
                }
            }

            if ($this->collControls !== null) {
                foreach ($this->collControls as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvpropsScheduledForDeletion !== null) {
                if (!$this->cvpropsScheduledForDeletion->isEmpty()) {
                    CvpropQuery::create()
                        ->filterByPrimaryKeys($this->cvpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvpropsScheduledForDeletion = null;
                }
            }

            if ($this->collCvprops !== null) {
                foreach ($this->collCvprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermDbxrefsScheduledForDeletion !== null) {
                if (!$this->cvtermDbxrefsScheduledForDeletion->isEmpty()) {
                    CvtermDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->cvtermDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermDbxrefs !== null) {
                foreach ($this->collCvtermDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    CvtermRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collCvtermRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    CvtermRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collCvtermRelationshipsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion !== null) {
                if (!$this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion->isEmpty()) {
                    CvtermRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermRelationshipsRelatedByTypeId !== null) {
                foreach ($this->collCvtermRelationshipsRelatedByTypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpathsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->cvtermpathsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    CvtermpathQuery::create()
                        ->filterByPrimaryKeys($this->cvtermpathsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermpathsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpathsRelatedByObjectId !== null) {
                foreach ($this->collCvtermpathsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpathsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->cvtermpathsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    CvtermpathQuery::create()
                        ->filterByPrimaryKeys($this->cvtermpathsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpathsRelatedBySubjectId !== null) {
                foreach ($this->collCvtermpathsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpathsRelatedByTypeIdScheduledForDeletion !== null) {
                if (!$this->cvtermpathsRelatedByTypeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->cvtermpathsRelatedByTypeIdScheduledForDeletion as $cvtermpathRelatedByTypeId) {
                        // need to save related object because we set the relation to null
                        $cvtermpathRelatedByTypeId->save($con);
                    }
                    $this->cvtermpathsRelatedByTypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpathsRelatedByTypeId !== null) {
                foreach ($this->collCvtermpathsRelatedByTypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpropsRelatedByCvtermIdScheduledForDeletion !== null) {
                if (!$this->cvtermpropsRelatedByCvtermIdScheduledForDeletion->isEmpty()) {
                    CvtermpropQuery::create()
                        ->filterByPrimaryKeys($this->cvtermpropsRelatedByCvtermIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpropsRelatedByCvtermId !== null) {
                foreach ($this->collCvtermpropsRelatedByCvtermId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermpropsRelatedByTypeIdScheduledForDeletion !== null) {
                if (!$this->cvtermpropsRelatedByTypeIdScheduledForDeletion->isEmpty()) {
                    CvtermpropQuery::create()
                        ->filterByPrimaryKeys($this->cvtermpropsRelatedByTypeIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermpropsRelatedByTypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermpropsRelatedByTypeId !== null) {
                foreach ($this->collCvtermpropsRelatedByTypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion !== null) {
                if (!$this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion->isEmpty()) {
                    CvtermsynonymQuery::create()
                        ->filterByPrimaryKeys($this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermsynonymsRelatedByCvtermId !== null) {
                foreach ($this->collCvtermsynonymsRelatedByCvtermId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion !== null) {
                if (!$this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion as $cvtermsynonymRelatedByTypeId) {
                        // need to save related object because we set the relation to null
                        $cvtermsynonymRelatedByTypeId->save($con);
                    }
                    $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermsynonymsRelatedByTypeId !== null) {
                foreach ($this->collCvtermsynonymsRelatedByTypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dbxrefpropsScheduledForDeletion !== null) {
                if (!$this->dbxrefpropsScheduledForDeletion->isEmpty()) {
                    DbxrefpropQuery::create()
                        ->filterByPrimaryKeys($this->dbxrefpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dbxrefpropsScheduledForDeletion = null;
                }
            }

            if ($this->collDbxrefprops !== null) {
                foreach ($this->collDbxrefprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementsScheduledForDeletion !== null) {
                if (!$this->elementsScheduledForDeletion->isEmpty()) {
                    foreach ($this->elementsScheduledForDeletion as $element) {
                        // need to save related object because we set the relation to null
                        $element->save($con);
                    }
                    $this->elementsScheduledForDeletion = null;
                }
            }

            if ($this->collElements !== null) {
                foreach ($this->collElements as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementRelationshipsScheduledForDeletion !== null) {
                if (!$this->elementRelationshipsScheduledForDeletion->isEmpty()) {
                    ElementRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collElementRelationships !== null) {
                foreach ($this->collElementRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementresultRelationshipsScheduledForDeletion !== null) {
                if (!$this->elementresultRelationshipsScheduledForDeletion->isEmpty()) {
                    ElementresultRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementresultRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementresultRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collElementresultRelationships !== null) {
                foreach ($this->collElementresultRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featuresScheduledForDeletion !== null) {
                if (!$this->featuresScheduledForDeletion->isEmpty()) {
                    FeatureQuery::create()
                        ->filterByPrimaryKeys($this->featuresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featuresScheduledForDeletion = null;
                }
            }

            if ($this->collFeatures !== null) {
                foreach ($this->collFeatures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureCvtermsScheduledForDeletion !== null) {
                if (!$this->featureCvtermsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvterms !== null) {
                foreach ($this->collFeatureCvterms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureCvtermpropsScheduledForDeletion !== null) {
                if (!$this->featureCvtermpropsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermpropQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermpropsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermprops !== null) {
                foreach ($this->collFeatureCvtermprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurePubpropsScheduledForDeletion !== null) {
                if (!$this->featurePubpropsScheduledForDeletion->isEmpty()) {
                    FeaturePubpropQuery::create()
                        ->filterByPrimaryKeys($this->featurePubpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurePubpropsScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturePubprops !== null) {
                foreach ($this->collFeaturePubprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureRelationshipsScheduledForDeletion !== null) {
                if (!$this->featureRelationshipsScheduledForDeletion->isEmpty()) {
                    FeatureRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->featureRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureRelationships !== null) {
                foreach ($this->collFeatureRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureRelationshippropsScheduledForDeletion !== null) {
                if (!$this->featureRelationshippropsScheduledForDeletion->isEmpty()) {
                    FeatureRelationshippropQuery::create()
                        ->filterByPrimaryKeys($this->featureRelationshippropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureRelationshippropsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureRelationshipprops !== null) {
                foreach ($this->collFeatureRelationshipprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurepropsScheduledForDeletion !== null) {
                if (!$this->featurepropsScheduledForDeletion->isEmpty()) {
                    FeaturepropQuery::create()
                        ->filterByPrimaryKeys($this->featurepropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurepropsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureprops !== null) {
                foreach ($this->collFeatureprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->organismpropsScheduledForDeletion !== null) {
                if (!$this->organismpropsScheduledForDeletion->isEmpty()) {
                    OrganismpropQuery::create()
                        ->filterByPrimaryKeys($this->organismpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->organismpropsScheduledForDeletion = null;
                }
            }

            if ($this->collOrganismprops !== null) {
                foreach ($this->collOrganismprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectRelationshipsScheduledForDeletion !== null) {
                if (!$this->projectRelationshipsScheduledForDeletion->isEmpty()) {
                    ProjectRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->projectRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectRelationships !== null) {
                foreach ($this->collProjectRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectpropsScheduledForDeletion !== null) {
                if (!$this->projectpropsScheduledForDeletion->isEmpty()) {
                    ProjectpropQuery::create()
                        ->filterByPrimaryKeys($this->projectpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectpropsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectprops !== null) {
                foreach ($this->collProjectprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->protocolsScheduledForDeletion !== null) {
                if (!$this->protocolsScheduledForDeletion->isEmpty()) {
                    ProtocolQuery::create()
                        ->filterByPrimaryKeys($this->protocolsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->protocolsScheduledForDeletion = null;
                }
            }

            if ($this->collProtocols !== null) {
                foreach ($this->collProtocols as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->protocolparamsRelatedByDatatypeIdScheduledForDeletion !== null) {
                if (!$this->protocolparamsRelatedByDatatypeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->protocolparamsRelatedByDatatypeIdScheduledForDeletion as $protocolparamRelatedByDatatypeId) {
                        // need to save related object because we set the relation to null
                        $protocolparamRelatedByDatatypeId->save($con);
                    }
                    $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collProtocolparamsRelatedByDatatypeId !== null) {
                foreach ($this->collProtocolparamsRelatedByDatatypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->protocolparamsRelatedByUnittypeIdScheduledForDeletion !== null) {
                if (!$this->protocolparamsRelatedByUnittypeIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->protocolparamsRelatedByUnittypeIdScheduledForDeletion as $protocolparamRelatedByUnittypeId) {
                        // need to save related object because we set the relation to null
                        $protocolparamRelatedByUnittypeId->save($con);
                    }
                    $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion = null;
                }
            }

            if ($this->collProtocolparamsRelatedByUnittypeId !== null) {
                foreach ($this->collProtocolparamsRelatedByUnittypeId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubsScheduledForDeletion !== null) {
                if (!$this->pubsScheduledForDeletion->isEmpty()) {
                    PubQuery::create()
                        ->filterByPrimaryKeys($this->pubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubsScheduledForDeletion = null;
                }
            }

            if ($this->collPubs !== null) {
                foreach ($this->collPubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubRelationshipsScheduledForDeletion !== null) {
                if (!$this->pubRelationshipsScheduledForDeletion->isEmpty()) {
                    PubRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->pubRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collPubRelationships !== null) {
                foreach ($this->collPubRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubpropsScheduledForDeletion !== null) {
                if (!$this->pubpropsScheduledForDeletion->isEmpty()) {
                    PubpropQuery::create()
                        ->filterByPrimaryKeys($this->pubpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubpropsScheduledForDeletion = null;
                }
            }

            if ($this->collPubprops !== null) {
                foreach ($this->collPubprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationRelationshipsScheduledForDeletion !== null) {
                if (!$this->quantificationRelationshipsScheduledForDeletion->isEmpty()) {
                    QuantificationRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->quantificationRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collQuantificationRelationships !== null) {
                foreach ($this->collQuantificationRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationpropsScheduledForDeletion !== null) {
                if (!$this->quantificationpropsScheduledForDeletion->isEmpty()) {
                    QuantificationpropQuery::create()
                        ->filterByPrimaryKeys($this->quantificationpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationpropsScheduledForDeletion = null;
                }
            }

            if ($this->collQuantificationprops !== null) {
                foreach ($this->collQuantificationprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationresultsScheduledForDeletion !== null) {
                if (!$this->quantificationresultsScheduledForDeletion->isEmpty()) {
                    QuantificationresultQuery::create()
                        ->filterByPrimaryKeys($this->quantificationresultsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationresultsScheduledForDeletion = null;
                }
            }

            if ($this->collQuantificationresults !== null) {
                foreach ($this->collQuantificationresults as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studydesignpropsScheduledForDeletion !== null) {
                if (!$this->studydesignpropsScheduledForDeletion->isEmpty()) {
                    StudydesignpropQuery::create()
                        ->filterByPrimaryKeys($this->studydesignpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studydesignpropsScheduledForDeletion = null;
                }
            }

            if ($this->collStudydesignprops !== null) {
                foreach ($this->collStudydesignprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studyfactorsScheduledForDeletion !== null) {
                if (!$this->studyfactorsScheduledForDeletion->isEmpty()) {
                    foreach ($this->studyfactorsScheduledForDeletion as $studyfactor) {
                        // need to save related object because we set the relation to null
                        $studyfactor->save($con);
                    }
                    $this->studyfactorsScheduledForDeletion = null;
                }
            }

            if ($this->collStudyfactors !== null) {
                foreach ($this->collStudyfactors as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studypropsScheduledForDeletion !== null) {
                if (!$this->studypropsScheduledForDeletion->isEmpty()) {
                    StudypropQuery::create()
                        ->filterByPrimaryKeys($this->studypropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studypropsScheduledForDeletion = null;
                }
            }

            if ($this->collStudyprops !== null) {
                foreach ($this->collStudyprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studypropFeaturesScheduledForDeletion !== null) {
                if (!$this->studypropFeaturesScheduledForDeletion->isEmpty()) {
                    foreach ($this->studypropFeaturesScheduledForDeletion as $studypropFeature) {
                        // need to save related object because we set the relation to null
                        $studypropFeature->save($con);
                    }
                    $this->studypropFeaturesScheduledForDeletion = null;
                }
            }

            if ($this->collStudypropFeatures !== null) {
                foreach ($this->collStudypropFeatures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->synonymsScheduledForDeletion !== null) {
                if (!$this->synonymsScheduledForDeletion->isEmpty()) {
                    SynonymQuery::create()
                        ->filterByPrimaryKeys($this->synonymsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->synonymsScheduledForDeletion = null;
                }
            }

            if ($this->collSynonyms !== null) {
                foreach ($this->collSynonyms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->treatmentsScheduledForDeletion !== null) {
                if (!$this->treatmentsScheduledForDeletion->isEmpty()) {
                    TreatmentQuery::create()
                        ->filterByPrimaryKeys($this->treatmentsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->treatmentsScheduledForDeletion = null;
                }
            }

            if ($this->collTreatments !== null) {
                foreach ($this->collTreatments as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->webuserDatasScheduledForDeletion !== null) {
                if (!$this->webuserDatasScheduledForDeletion->isEmpty()) {
                    foreach ($this->webuserDatasScheduledForDeletion as $webuserData) {
                        // need to save related object because we set the relation to null
                        $webuserData->save($con);
                    }
                    $this->webuserDatasScheduledForDeletion = null;
                }
            }

            if ($this->collWebuserDatas !== null) {
                foreach ($this->collWebuserDatas as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            $this->alreadyInSave = false;

        }

        return $affectedRows;
    } // doSave()

    /**
     * Insert the row in the database.
     *
     * @param PropelPDO $con
     *
     * @throws PropelException
     * @see        doSave()
     */
    protected function doInsert(PropelPDO $con)
    {
        $modifiedColumns = array();
        $index = 0;

        $this->modifiedColumns[] = CvtermPeer::CVTERM_ID;
        if (null !== $this->cvterm_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CvtermPeer::CVTERM_ID . ')');
        }
        if (null === $this->cvterm_id) {
            try {
                $stmt = $con->query("SELECT nextval('cvterm_cvterm_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->cvterm_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CvtermPeer::CVTERM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cvterm_id"';
        }
        if ($this->isColumnModified(CvtermPeer::CV_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cv_id"';
        }
        if ($this->isColumnModified(CvtermPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(CvtermPeer::DEFINITION)) {
            $modifiedColumns[':p' . $index++]  = '"definition"';
        }
        if ($this->isColumnModified(CvtermPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(CvtermPeer::IS_OBSOLETE)) {
            $modifiedColumns[':p' . $index++]  = '"is_obsolete"';
        }
        if ($this->isColumnModified(CvtermPeer::IS_RELATIONSHIPTYPE)) {
            $modifiedColumns[':p' . $index++]  = '"is_relationshiptype"';
        }

        $sql = sprintf(
            'INSERT INTO "cvterm" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"cvterm_id"':
                        $stmt->bindValue($identifier, $this->cvterm_id, PDO::PARAM_INT);
                        break;
                    case '"cv_id"':
                        $stmt->bindValue($identifier, $this->cv_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"definition"':
                        $stmt->bindValue($identifier, $this->definition, PDO::PARAM_STR);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"is_obsolete"':
                        $stmt->bindValue($identifier, $this->is_obsolete, PDO::PARAM_INT);
                        break;
                    case '"is_relationshiptype"':
                        $stmt->bindValue($identifier, $this->is_relationshiptype, PDO::PARAM_INT);
                        break;
                }
            }
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute INSERT statement [%s]', $sql), $e);
        }

        $this->setNew(false);
    }

    /**
     * Update the row in the database.
     *
     * @param PropelPDO $con
     *
     * @see        doSave()
     */
    protected function doUpdate(PropelPDO $con)
    {
        $selectCriteria = $this->buildPkeyCriteria();
        $valuesCriteria = $this->buildCriteria();
        BasePeer::doUpdate($selectCriteria, $valuesCriteria, $con);
    }

    /**
     * Array of ValidationFailed objects.
     * @var        array ValidationFailed[]
     */
    protected $validationFailures = array();

    /**
     * Gets any ValidationFailed objects that resulted from last call to validate().
     *
     *
     * @return array ValidationFailed[]
     * @see        validate()
     */
    public function getValidationFailures()
    {
        return $this->validationFailures;
    }

    /**
     * Validates the objects modified field values and all objects related to this table.
     *
     * If $columns is either a column name or an array of column names
     * only those columns are validated.
     *
     * @param mixed $columns Column name or an array of column names.
     * @return boolean Whether all columns pass validation.
     * @see        doValidate()
     * @see        getValidationFailures()
     */
    public function validate($columns = null)
    {
        $res = $this->doValidate($columns);
        if ($res === true) {
            $this->validationFailures = array();

            return true;
        }

        $this->validationFailures = $res;

        return false;
    }

    /**
     * This function performs the validation work for complex object models.
     *
     * In addition to checking the current object, all related objects will
     * also be validated.  If all pass then <code>true</code> is returned; otherwise
     * an aggreagated array of ValidationFailed objects will be returned.
     *
     * @param array $columns Array of column names to validate.
     * @return mixed <code>true</code> if all validations pass; array of <code>ValidationFailed</code> objets otherwise.
     */
    protected function doValidate($columns = null)
    {
        if (!$this->alreadyInValidation) {
            $this->alreadyInValidation = true;
            $retval = null;

            $failureMap = array();


            // We call the validate method on the following object(s) if they
            // were passed to this object by their coresponding set
            // method.  This object relates to these object(s) by a
            // foreign key reference.

            if ($this->aCv !== null) {
                if (!$this->aCv->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCv->getValidationFailures());
                }
            }

            if ($this->aDbxref !== null) {
                if (!$this->aDbxref->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDbxref->getValidationFailures());
                }
            }


            if (($retval = CvtermPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAcquisitionRelationships !== null) {
                    foreach ($this->collAcquisitionRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAcquisitionprops !== null) {
                    foreach ($this->collAcquisitionprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAnalysisfeatureprops !== null) {
                    foreach ($this->collAnalysisfeatureprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAnalysisprops !== null) {
                    foreach ($this->collAnalysisprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collArraydesignsRelatedByPlatformtypeId !== null) {
                    foreach ($this->collArraydesignsRelatedByPlatformtypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collArraydesignsRelatedBySubstratetypeId !== null) {
                    foreach ($this->collArraydesignsRelatedBySubstratetypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collArraydesignprops !== null) {
                    foreach ($this->collArraydesignprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssayprops !== null) {
                    foreach ($this->collAssayprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialRelationships !== null) {
                    foreach ($this->collBiomaterialRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialTreatments !== null) {
                    foreach ($this->collBiomaterialTreatments as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialprops !== null) {
                    foreach ($this->collBiomaterialprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collChadoprops !== null) {
                    foreach ($this->collChadoprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContacts !== null) {
                    foreach ($this->collContacts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContactRelationships !== null) {
                    foreach ($this->collContactRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collControls !== null) {
                    foreach ($this->collControls as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvprops !== null) {
                    foreach ($this->collCvprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermDbxrefs !== null) {
                    foreach ($this->collCvtermDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collCvtermRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collCvtermRelationshipsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermRelationshipsRelatedByTypeId !== null) {
                    foreach ($this->collCvtermRelationshipsRelatedByTypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpathsRelatedByObjectId !== null) {
                    foreach ($this->collCvtermpathsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpathsRelatedBySubjectId !== null) {
                    foreach ($this->collCvtermpathsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpathsRelatedByTypeId !== null) {
                    foreach ($this->collCvtermpathsRelatedByTypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpropsRelatedByCvtermId !== null) {
                    foreach ($this->collCvtermpropsRelatedByCvtermId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermpropsRelatedByTypeId !== null) {
                    foreach ($this->collCvtermpropsRelatedByTypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermsynonymsRelatedByCvtermId !== null) {
                    foreach ($this->collCvtermsynonymsRelatedByCvtermId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermsynonymsRelatedByTypeId !== null) {
                    foreach ($this->collCvtermsynonymsRelatedByTypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collDbxrefprops !== null) {
                    foreach ($this->collDbxrefprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElements !== null) {
                    foreach ($this->collElements as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElementRelationships !== null) {
                    foreach ($this->collElementRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElementresultRelationships !== null) {
                    foreach ($this->collElementresultRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatures !== null) {
                    foreach ($this->collFeatures as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvterms !== null) {
                    foreach ($this->collFeatureCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvtermprops !== null) {
                    foreach ($this->collFeatureCvtermprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeaturePubprops !== null) {
                    foreach ($this->collFeaturePubprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureRelationships !== null) {
                    foreach ($this->collFeatureRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureRelationshipprops !== null) {
                    foreach ($this->collFeatureRelationshipprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureprops !== null) {
                    foreach ($this->collFeatureprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collOrganismprops !== null) {
                    foreach ($this->collOrganismprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectRelationships !== null) {
                    foreach ($this->collProjectRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectprops !== null) {
                    foreach ($this->collProjectprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProtocols !== null) {
                    foreach ($this->collProtocols as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProtocolparamsRelatedByDatatypeId !== null) {
                    foreach ($this->collProtocolparamsRelatedByDatatypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProtocolparamsRelatedByUnittypeId !== null) {
                    foreach ($this->collProtocolparamsRelatedByUnittypeId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubs !== null) {
                    foreach ($this->collPubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubRelationships !== null) {
                    foreach ($this->collPubRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubprops !== null) {
                    foreach ($this->collPubprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantificationRelationships !== null) {
                    foreach ($this->collQuantificationRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantificationprops !== null) {
                    foreach ($this->collQuantificationprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantificationresults !== null) {
                    foreach ($this->collQuantificationresults as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudydesignprops !== null) {
                    foreach ($this->collStudydesignprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudyfactors !== null) {
                    foreach ($this->collStudyfactors as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudyprops !== null) {
                    foreach ($this->collStudyprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudypropFeatures !== null) {
                    foreach ($this->collStudypropFeatures as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSynonyms !== null) {
                    foreach ($this->collSynonyms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collTreatments !== null) {
                    foreach ($this->collTreatments as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collWebuserDatas !== null) {
                    foreach ($this->collWebuserDatas as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }


            $this->alreadyInValidation = false;
        }

        return (!empty($failureMap) ? $failureMap : true);
    }

    /**
     * Retrieves a field from the object by name passed in as a string.
     *
     * @param string $name name
     * @param string $type The type of fieldname the $name is of:
     *               one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *               BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *               Defaults to BasePeer::TYPE_PHPNAME
     * @return mixed Value of field.
     */
    public function getByName($name, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
        $field = $this->getByPosition($pos);

        return $field;
    }

    /**
     * Retrieves a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @return mixed Value of field at $pos
     */
    public function getByPosition($pos)
    {
        switch ($pos) {
            case 0:
                return $this->getCvtermId();
                break;
            case 1:
                return $this->getCvId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getDefinition();
                break;
            case 4:
                return $this->getDbxrefId();
                break;
            case 5:
                return $this->getIsObsolete();
                break;
            case 6:
                return $this->getIsRelationshiptype();
                break;
            default:
                return null;
                break;
        } // switch()
    }

    /**
     * Exports the object as an array.
     *
     * You can specify the key type of the array by passing one of the class
     * type constants.
     *
     * @param     string  $keyType (optional) One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     *                    BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                    Defaults to BasePeer::TYPE_PHPNAME.
     * @param     boolean $includeLazyLoadColumns (optional) Whether to include lazy loaded columns. Defaults to true.
     * @param     array $alreadyDumpedObjects List of objects to skip to avoid recursion
     * @param     boolean $includeForeignObjects (optional) Whether to include hydrated related objects. Default to FALSE.
     *
     * @return array an associative array containing the field names (as keys) and field values
     */
    public function toArray($keyType = BasePeer::TYPE_PHPNAME, $includeLazyLoadColumns = true, $alreadyDumpedObjects = array(), $includeForeignObjects = false)
    {
        if (isset($alreadyDumpedObjects['Cvterm'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Cvterm'][$this->getPrimaryKey()] = true;
        $keys = CvtermPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCvtermId(),
            $keys[1] => $this->getCvId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDefinition(),
            $keys[4] => $this->getDbxrefId(),
            $keys[5] => $this->getIsObsolete(),
            $keys[6] => $this->getIsRelationshiptype(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCv) {
                $result['Cv'] = $this->aCv->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAcquisitionRelationships) {
                $result['AcquisitionRelationships'] = $this->collAcquisitionRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAcquisitionprops) {
                $result['Acquisitionprops'] = $this->collAcquisitionprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAnalysisfeatureprops) {
                $result['Analysisfeatureprops'] = $this->collAnalysisfeatureprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAnalysisprops) {
                $result['Analysisprops'] = $this->collAnalysisprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collArraydesignsRelatedByPlatformtypeId) {
                $result['ArraydesignsRelatedByPlatformtypeId'] = $this->collArraydesignsRelatedByPlatformtypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collArraydesignsRelatedBySubstratetypeId) {
                $result['ArraydesignsRelatedBySubstratetypeId'] = $this->collArraydesignsRelatedBySubstratetypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collArraydesignprops) {
                $result['Arraydesignprops'] = $this->collArraydesignprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssayprops) {
                $result['Assayprops'] = $this->collAssayprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialRelationships) {
                $result['BiomaterialRelationships'] = $this->collBiomaterialRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialTreatments) {
                $result['BiomaterialTreatments'] = $this->collBiomaterialTreatments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialprops) {
                $result['Biomaterialprops'] = $this->collBiomaterialprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collChadoprops) {
                $result['Chadoprops'] = $this->collChadoprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContacts) {
                $result['Contacts'] = $this->collContacts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContactRelationships) {
                $result['ContactRelationships'] = $this->collContactRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collControls) {
                $result['Controls'] = $this->collControls->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvprops) {
                $result['Cvprops'] = $this->collCvprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermDbxrefs) {
                $result['CvtermDbxrefs'] = $this->collCvtermDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermRelationshipsRelatedByObjectId) {
                $result['CvtermRelationshipsRelatedByObjectId'] = $this->collCvtermRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermRelationshipsRelatedBySubjectId) {
                $result['CvtermRelationshipsRelatedBySubjectId'] = $this->collCvtermRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermRelationshipsRelatedByTypeId) {
                $result['CvtermRelationshipsRelatedByTypeId'] = $this->collCvtermRelationshipsRelatedByTypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpathsRelatedByObjectId) {
                $result['CvtermpathsRelatedByObjectId'] = $this->collCvtermpathsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpathsRelatedBySubjectId) {
                $result['CvtermpathsRelatedBySubjectId'] = $this->collCvtermpathsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpathsRelatedByTypeId) {
                $result['CvtermpathsRelatedByTypeId'] = $this->collCvtermpathsRelatedByTypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpropsRelatedByCvtermId) {
                $result['CvtermpropsRelatedByCvtermId'] = $this->collCvtermpropsRelatedByCvtermId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermpropsRelatedByTypeId) {
                $result['CvtermpropsRelatedByTypeId'] = $this->collCvtermpropsRelatedByTypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermsynonymsRelatedByCvtermId) {
                $result['CvtermsynonymsRelatedByCvtermId'] = $this->collCvtermsynonymsRelatedByCvtermId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermsynonymsRelatedByTypeId) {
                $result['CvtermsynonymsRelatedByTypeId'] = $this->collCvtermsynonymsRelatedByTypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDbxrefprops) {
                $result['Dbxrefprops'] = $this->collDbxrefprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElements) {
                $result['Elements'] = $this->collElements->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementRelationships) {
                $result['ElementRelationships'] = $this->collElementRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementresultRelationships) {
                $result['ElementresultRelationships'] = $this->collElementresultRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatures) {
                $result['Features'] = $this->collFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvterms) {
                $result['FeatureCvterms'] = $this->collFeatureCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermprops) {
                $result['FeatureCvtermprops'] = $this->collFeatureCvtermprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeaturePubprops) {
                $result['FeaturePubprops'] = $this->collFeaturePubprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureRelationships) {
                $result['FeatureRelationships'] = $this->collFeatureRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureRelationshipprops) {
                $result['FeatureRelationshipprops'] = $this->collFeatureRelationshipprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureprops) {
                $result['Featureprops'] = $this->collFeatureprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrganismprops) {
                $result['Organismprops'] = $this->collOrganismprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectRelationships) {
                $result['ProjectRelationships'] = $this->collProjectRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectprops) {
                $result['Projectprops'] = $this->collProjectprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocols) {
                $result['Protocols'] = $this->collProtocols->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocolparamsRelatedByDatatypeId) {
                $result['ProtocolparamsRelatedByDatatypeId'] = $this->collProtocolparamsRelatedByDatatypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocolparamsRelatedByUnittypeId) {
                $result['ProtocolparamsRelatedByUnittypeId'] = $this->collProtocolparamsRelatedByUnittypeId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubs) {
                $result['Pubs'] = $this->collPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubRelationships) {
                $result['PubRelationships'] = $this->collPubRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubprops) {
                $result['Pubprops'] = $this->collPubprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationRelationships) {
                $result['QuantificationRelationships'] = $this->collQuantificationRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationprops) {
                $result['Quantificationprops'] = $this->collQuantificationprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationresults) {
                $result['Quantificationresults'] = $this->collQuantificationresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudydesignprops) {
                $result['Studydesignprops'] = $this->collStudydesignprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudyfactors) {
                $result['Studyfactors'] = $this->collStudyfactors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudyprops) {
                $result['Studyprops'] = $this->collStudyprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudypropFeatures) {
                $result['StudypropFeatures'] = $this->collStudypropFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSynonyms) {
                $result['Synonyms'] = $this->collSynonyms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTreatments) {
                $result['Treatments'] = $this->collTreatments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collWebuserDatas) {
                $result['WebuserDatas'] = $this->collWebuserDatas->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
        }

        return $result;
    }

    /**
     * Sets a field from the object by name passed in as a string.
     *
     * @param string $name peer name
     * @param mixed $value field value
     * @param string $type The type of fieldname the $name is of:
     *                     one of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                     BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     *                     Defaults to BasePeer::TYPE_PHPNAME
     * @return void
     */
    public function setByName($name, $value, $type = BasePeer::TYPE_PHPNAME)
    {
        $pos = CvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

        $this->setByPosition($pos, $value);
    }

    /**
     * Sets a field from the object by Position as specified in the xml schema.
     * Zero-based.
     *
     * @param int $pos position in xml schema
     * @param mixed $value field value
     * @return void
     */
    public function setByPosition($pos, $value)
    {
        switch ($pos) {
            case 0:
                $this->setCvtermId($value);
                break;
            case 1:
                $this->setCvId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setDefinition($value);
                break;
            case 4:
                $this->setDbxrefId($value);
                break;
            case 5:
                $this->setIsObsolete($value);
                break;
            case 6:
                $this->setIsRelationshiptype($value);
                break;
        } // switch()
    }

    /**
     * Populates the object using an array.
     *
     * This is particularly useful when populating an object from one of the
     * request arrays (e.g. $_POST).  This method goes through the column
     * names, checking to see whether a matching key exists in populated
     * array. If so the setByName() method is called for that column.
     *
     * You can specify the key type of the array by additionally passing one
     * of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME,
     * BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM.
     * The default key type is the column's BasePeer::TYPE_PHPNAME
     *
     * @param array  $arr     An array to populate the object from.
     * @param string $keyType The type of keys the array uses.
     * @return void
     */
    public function fromArray($arr, $keyType = BasePeer::TYPE_PHPNAME)
    {
        $keys = CvtermPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setCvtermId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCvId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDefinition($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDbxrefId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIsObsolete($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsRelationshiptype($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CvtermPeer::DATABASE_NAME);

        if ($this->isColumnModified(CvtermPeer::CVTERM_ID)) $criteria->add(CvtermPeer::CVTERM_ID, $this->cvterm_id);
        if ($this->isColumnModified(CvtermPeer::CV_ID)) $criteria->add(CvtermPeer::CV_ID, $this->cv_id);
        if ($this->isColumnModified(CvtermPeer::NAME)) $criteria->add(CvtermPeer::NAME, $this->name);
        if ($this->isColumnModified(CvtermPeer::DEFINITION)) $criteria->add(CvtermPeer::DEFINITION, $this->definition);
        if ($this->isColumnModified(CvtermPeer::DBXREF_ID)) $criteria->add(CvtermPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(CvtermPeer::IS_OBSOLETE)) $criteria->add(CvtermPeer::IS_OBSOLETE, $this->is_obsolete);
        if ($this->isColumnModified(CvtermPeer::IS_RELATIONSHIPTYPE)) $criteria->add(CvtermPeer::IS_RELATIONSHIPTYPE, $this->is_relationshiptype);

        return $criteria;
    }

    /**
     * Builds a Criteria object containing the primary key for this object.
     *
     * Unlike buildCriteria() this method includes the primary key values regardless
     * of whether or not they have been modified.
     *
     * @return Criteria The Criteria object containing value(s) for primary key(s).
     */
    public function buildPkeyCriteria()
    {
        $criteria = new Criteria(CvtermPeer::DATABASE_NAME);
        $criteria->add(CvtermPeer::CVTERM_ID, $this->cvterm_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCvtermId();
    }

    /**
     * Generic method to set the primary key (cvterm_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCvtermId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getCvtermId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Cvterm (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCvId($this->getCvId());
        $copyObj->setName($this->getName());
        $copyObj->setDefinition($this->getDefinition());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setIsObsolete($this->getIsObsolete());
        $copyObj->setIsRelationshiptype($this->getIsRelationshiptype());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAcquisitionRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisitionRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAcquisitionprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisitionprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAnalysisfeatureprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnalysisfeatureprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAnalysisprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnalysisprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getArraydesignsRelatedByPlatformtypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArraydesignRelatedByPlatformtypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getArraydesignsRelatedBySubstratetypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArraydesignRelatedBySubstratetypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getArraydesignprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArraydesignprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssayprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssayprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialTreatments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialTreatment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getChadoprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addChadoprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContacts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContact($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContactRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContactRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getControls() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addControl($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermRelationshipsRelatedByTypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermRelationshipRelatedByTypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpathsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpathRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpathsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpathRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpathsRelatedByTypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpathRelatedByTypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpropsRelatedByCvtermId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpropRelatedByCvtermId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermpropsRelatedByTypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermpropRelatedByTypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermsynonymsRelatedByCvtermId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermsynonymRelatedByCvtermId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermsynonymsRelatedByTypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermsynonymRelatedByTypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDbxrefprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDbxrefprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElement($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementresultRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementresultRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeaturePubprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturePubprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureRelationshipprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureRelationshipprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrganismprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrganismprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProtocols() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocol($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProtocolparamsRelatedByDatatypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocolparamRelatedByDatatypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProtocolparamsRelatedByUnittypeId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocolparamRelatedByUnittypeId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationresults() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationresult($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudydesignprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudydesignprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudyfactors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyfactor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudyprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudypropFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudypropFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSynonyms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSynonym($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTreatments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTreatment($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getWebuserDatas() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addWebuserData($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCvtermId(NULL); // this is a auto-increment column, so set to default value
        }
    }

    /**
     * Makes a copy of this object that will be inserted as a new row in table when saved.
     * It creates a new object filling in the simple attributes, but skipping any primary
     * keys that are defined for the table.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @return Cvterm Clone of current object.
     * @throws PropelException
     */
    public function copy($deepCopy = false)
    {
        // we use get_class(), because this might be a subclass
        $clazz = get_class($this);
        $copyObj = new $clazz();
        $this->copyInto($copyObj, $deepCopy);

        return $copyObj;
    }

    /**
     * Returns a peer instance associated with this om.
     *
     * Since Peer classes are not to have any instance attributes, this method returns the
     * same instance for all member of this class. The method could therefore
     * be static, but this would prevent one from overriding the behavior.
     *
     * @return CvtermPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CvtermPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cv object.
     *
     * @param             Cv $v
     * @return Cvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCv(Cv $v = null)
    {
        if ($v === null) {
            $this->setCvId(NULL);
        } else {
            $this->setCvId($v->getCvId());
        }

        $this->aCv = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cv object, it will not be re-added.
        if ($v !== null) {
            $v->addCvterm($this);
        }


        return $this;
    }


    /**
     * Get the associated Cv object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Cv The associated Cv object.
     * @throws PropelException
     */
    public function getCv(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCv === null && ($this->cv_id !== null) && $doQuery) {
            $this->aCv = CvQuery::create()->findPk($this->cv_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCv->addCvterms($this);
             */
        }

        return $this->aCv;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Cvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDbxref(Dbxref $v = null)
    {
        if ($v === null) {
            $this->setDbxrefId(NULL);
        } else {
            $this->setDbxrefId($v->getDbxrefId());
        }

        $this->aDbxref = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Dbxref object, it will not be re-added.
        if ($v !== null) {
            $v->addCvterm($this);
        }


        return $this;
    }


    /**
     * Get the associated Dbxref object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Dbxref The associated Dbxref object.
     * @throws PropelException
     */
    public function getDbxref(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aDbxref === null && ($this->dbxref_id !== null) && $doQuery) {
            $this->aDbxref = DbxrefQuery::create()->findPk($this->dbxref_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDbxref->addCvterms($this);
             */
        }

        return $this->aDbxref;
    }


    /**
     * Initializes a collection based on the name of a relation.
     * Avoids crafting an 'init[$relationName]s' method name
     * that wouldn't work when StandardEnglishPluralizer is used.
     *
     * @param string $relationName The name of the relation to initialize
     * @return void
     */
    public function initRelation($relationName)
    {
        if ('AcquisitionRelationship' == $relationName) {
            $this->initAcquisitionRelationships();
        }
        if ('Acquisitionprop' == $relationName) {
            $this->initAcquisitionprops();
        }
        if ('Analysisfeatureprop' == $relationName) {
            $this->initAnalysisfeatureprops();
        }
        if ('Analysisprop' == $relationName) {
            $this->initAnalysisprops();
        }
        if ('ArraydesignRelatedByPlatformtypeId' == $relationName) {
            $this->initArraydesignsRelatedByPlatformtypeId();
        }
        if ('ArraydesignRelatedBySubstratetypeId' == $relationName) {
            $this->initArraydesignsRelatedBySubstratetypeId();
        }
        if ('Arraydesignprop' == $relationName) {
            $this->initArraydesignprops();
        }
        if ('Assayprop' == $relationName) {
            $this->initAssayprops();
        }
        if ('BiomaterialRelationship' == $relationName) {
            $this->initBiomaterialRelationships();
        }
        if ('BiomaterialTreatment' == $relationName) {
            $this->initBiomaterialTreatments();
        }
        if ('Biomaterialprop' == $relationName) {
            $this->initBiomaterialprops();
        }
        if ('Chadoprop' == $relationName) {
            $this->initChadoprops();
        }
        if ('Contact' == $relationName) {
            $this->initContacts();
        }
        if ('ContactRelationship' == $relationName) {
            $this->initContactRelationships();
        }
        if ('Control' == $relationName) {
            $this->initControls();
        }
        if ('Cvprop' == $relationName) {
            $this->initCvprops();
        }
        if ('CvtermDbxref' == $relationName) {
            $this->initCvtermDbxrefs();
        }
        if ('CvtermRelationshipRelatedByObjectId' == $relationName) {
            $this->initCvtermRelationshipsRelatedByObjectId();
        }
        if ('CvtermRelationshipRelatedBySubjectId' == $relationName) {
            $this->initCvtermRelationshipsRelatedBySubjectId();
        }
        if ('CvtermRelationshipRelatedByTypeId' == $relationName) {
            $this->initCvtermRelationshipsRelatedByTypeId();
        }
        if ('CvtermpathRelatedByObjectId' == $relationName) {
            $this->initCvtermpathsRelatedByObjectId();
        }
        if ('CvtermpathRelatedBySubjectId' == $relationName) {
            $this->initCvtermpathsRelatedBySubjectId();
        }
        if ('CvtermpathRelatedByTypeId' == $relationName) {
            $this->initCvtermpathsRelatedByTypeId();
        }
        if ('CvtermpropRelatedByCvtermId' == $relationName) {
            $this->initCvtermpropsRelatedByCvtermId();
        }
        if ('CvtermpropRelatedByTypeId' == $relationName) {
            $this->initCvtermpropsRelatedByTypeId();
        }
        if ('CvtermsynonymRelatedByCvtermId' == $relationName) {
            $this->initCvtermsynonymsRelatedByCvtermId();
        }
        if ('CvtermsynonymRelatedByTypeId' == $relationName) {
            $this->initCvtermsynonymsRelatedByTypeId();
        }
        if ('Dbxrefprop' == $relationName) {
            $this->initDbxrefprops();
        }
        if ('Element' == $relationName) {
            $this->initElements();
        }
        if ('ElementRelationship' == $relationName) {
            $this->initElementRelationships();
        }
        if ('ElementresultRelationship' == $relationName) {
            $this->initElementresultRelationships();
        }
        if ('Feature' == $relationName) {
            $this->initFeatures();
        }
        if ('FeatureCvterm' == $relationName) {
            $this->initFeatureCvterms();
        }
        if ('FeatureCvtermprop' == $relationName) {
            $this->initFeatureCvtermprops();
        }
        if ('FeaturePubprop' == $relationName) {
            $this->initFeaturePubprops();
        }
        if ('FeatureRelationship' == $relationName) {
            $this->initFeatureRelationships();
        }
        if ('FeatureRelationshipprop' == $relationName) {
            $this->initFeatureRelationshipprops();
        }
        if ('Featureprop' == $relationName) {
            $this->initFeatureprops();
        }
        if ('Organismprop' == $relationName) {
            $this->initOrganismprops();
        }
        if ('ProjectRelationship' == $relationName) {
            $this->initProjectRelationships();
        }
        if ('Projectprop' == $relationName) {
            $this->initProjectprops();
        }
        if ('Protocol' == $relationName) {
            $this->initProtocols();
        }
        if ('ProtocolparamRelatedByDatatypeId' == $relationName) {
            $this->initProtocolparamsRelatedByDatatypeId();
        }
        if ('ProtocolparamRelatedByUnittypeId' == $relationName) {
            $this->initProtocolparamsRelatedByUnittypeId();
        }
        if ('Pub' == $relationName) {
            $this->initPubs();
        }
        if ('PubRelationship' == $relationName) {
            $this->initPubRelationships();
        }
        if ('Pubprop' == $relationName) {
            $this->initPubprops();
        }
        if ('QuantificationRelationship' == $relationName) {
            $this->initQuantificationRelationships();
        }
        if ('Quantificationprop' == $relationName) {
            $this->initQuantificationprops();
        }
        if ('Quantificationresult' == $relationName) {
            $this->initQuantificationresults();
        }
        if ('Studydesignprop' == $relationName) {
            $this->initStudydesignprops();
        }
        if ('Studyfactor' == $relationName) {
            $this->initStudyfactors();
        }
        if ('Studyprop' == $relationName) {
            $this->initStudyprops();
        }
        if ('StudypropFeature' == $relationName) {
            $this->initStudypropFeatures();
        }
        if ('Synonym' == $relationName) {
            $this->initSynonyms();
        }
        if ('Treatment' == $relationName) {
            $this->initTreatments();
        }
        if ('WebuserData' == $relationName) {
            $this->initWebuserDatas();
        }
    }

    /**
     * Clears out the collAcquisitionRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addAcquisitionRelationships()
     */
    public function clearAcquisitionRelationships()
    {
        $this->collAcquisitionRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitionRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitionRelationships($v = true)
    {
        $this->collAcquisitionRelationshipsPartial = $v;
    }

    /**
     * Initializes the collAcquisitionRelationships collection.
     *
     * By default this just sets the collAcquisitionRelationships collection to an empty array (like clearcollAcquisitionRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitionRelationships($overrideExisting = true)
    {
        if (null !== $this->collAcquisitionRelationships && !$overrideExisting) {
            return;
        }
        $this->collAcquisitionRelationships = new PropelObjectCollection();
        $this->collAcquisitionRelationships->setModel('AcquisitionRelationship');
    }

    /**
     * Gets an array of AcquisitionRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     * @throws PropelException
     */
    public function getAcquisitionRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationships) {
                // return empty collection
                $this->initAcquisitionRelationships();
            } else {
                $collAcquisitionRelationships = AcquisitionRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionRelationshipsPartial && count($collAcquisitionRelationships)) {
                      $this->initAcquisitionRelationships(false);

                      foreach($collAcquisitionRelationships as $obj) {
                        if (false == $this->collAcquisitionRelationships->contains($obj)) {
                          $this->collAcquisitionRelationships->append($obj);
                        }
                      }

                      $this->collAcquisitionRelationshipsPartial = true;
                    }

                    $collAcquisitionRelationships->getInternalIterator()->rewind();
                    return $collAcquisitionRelationships;
                }

                if($partial && $this->collAcquisitionRelationships) {
                    foreach($this->collAcquisitionRelationships as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitionRelationships[] = $obj;
                        }
                    }
                }

                $this->collAcquisitionRelationships = $collAcquisitionRelationships;
                $this->collAcquisitionRelationshipsPartial = false;
            }
        }

        return $this->collAcquisitionRelationships;
    }

    /**
     * Sets a collection of AcquisitionRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitionRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setAcquisitionRelationships(PropelCollection $acquisitionRelationships, PropelPDO $con = null)
    {
        $acquisitionRelationshipsToDelete = $this->getAcquisitionRelationships(new Criteria(), $con)->diff($acquisitionRelationships);

        $this->acquisitionRelationshipsScheduledForDeletion = unserialize(serialize($acquisitionRelationshipsToDelete));

        foreach ($acquisitionRelationshipsToDelete as $acquisitionRelationshipRemoved) {
            $acquisitionRelationshipRemoved->setCvterm(null);
        }

        $this->collAcquisitionRelationships = null;
        foreach ($acquisitionRelationships as $acquisitionRelationship) {
            $this->addAcquisitionRelationship($acquisitionRelationship);
        }

        $this->collAcquisitionRelationships = $acquisitionRelationships;
        $this->collAcquisitionRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AcquisitionRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AcquisitionRelationship objects.
     * @throws PropelException
     */
    public function countAcquisitionRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitionRelationships());
            }
            $query = AcquisitionRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collAcquisitionRelationships);
    }

    /**
     * Method called to associate a AcquisitionRelationship object to this object
     * through the AcquisitionRelationship foreign key attribute.
     *
     * @param    AcquisitionRelationship $l AcquisitionRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addAcquisitionRelationship(AcquisitionRelationship $l)
    {
        if ($this->collAcquisitionRelationships === null) {
            $this->initAcquisitionRelationships();
            $this->collAcquisitionRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collAcquisitionRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisitionRelationship($l);
        }

        return $this;
    }

    /**
     * @param	AcquisitionRelationship $acquisitionRelationship The acquisitionRelationship object to add.
     */
    protected function doAddAcquisitionRelationship($acquisitionRelationship)
    {
        $this->collAcquisitionRelationships[]= $acquisitionRelationship;
        $acquisitionRelationship->setCvterm($this);
    }

    /**
     * @param	AcquisitionRelationship $acquisitionRelationship The acquisitionRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeAcquisitionRelationship($acquisitionRelationship)
    {
        if ($this->getAcquisitionRelationships()->contains($acquisitionRelationship)) {
            $this->collAcquisitionRelationships->remove($this->collAcquisitionRelationships->search($acquisitionRelationship));
            if (null === $this->acquisitionRelationshipsScheduledForDeletion) {
                $this->acquisitionRelationshipsScheduledForDeletion = clone $this->collAcquisitionRelationships;
                $this->acquisitionRelationshipsScheduledForDeletion->clear();
            }
            $this->acquisitionRelationshipsScheduledForDeletion[]= clone $acquisitionRelationship;
            $acquisitionRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related AcquisitionRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     */
    public function getAcquisitionRelationshipsJoinAcquisitionRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionRelationshipQuery::create(null, $criteria);
        $query->joinWith('AcquisitionRelatedByObjectId', $join_behavior);

        return $this->getAcquisitionRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related AcquisitionRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     */
    public function getAcquisitionRelationshipsJoinAcquisitionRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionRelationshipQuery::create(null, $criteria);
        $query->joinWith('AcquisitionRelatedBySubjectId', $join_behavior);

        return $this->getAcquisitionRelationships($query, $con);
    }

    /**
     * Clears out the collAcquisitionprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addAcquisitionprops()
     */
    public function clearAcquisitionprops()
    {
        $this->collAcquisitionprops = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitionprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitionprops($v = true)
    {
        $this->collAcquisitionpropsPartial = $v;
    }

    /**
     * Initializes the collAcquisitionprops collection.
     *
     * By default this just sets the collAcquisitionprops collection to an empty array (like clearcollAcquisitionprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitionprops($overrideExisting = true)
    {
        if (null !== $this->collAcquisitionprops && !$overrideExisting) {
            return;
        }
        $this->collAcquisitionprops = new PropelObjectCollection();
        $this->collAcquisitionprops->setModel('Acquisitionprop');
    }

    /**
     * Gets an array of Acquisitionprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Acquisitionprop[] List of Acquisitionprop objects
     * @throws PropelException
     */
    public function getAcquisitionprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionpropsPartial && !$this->isNew();
        if (null === $this->collAcquisitionprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionprops) {
                // return empty collection
                $this->initAcquisitionprops();
            } else {
                $collAcquisitionprops = AcquisitionpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionpropsPartial && count($collAcquisitionprops)) {
                      $this->initAcquisitionprops(false);

                      foreach($collAcquisitionprops as $obj) {
                        if (false == $this->collAcquisitionprops->contains($obj)) {
                          $this->collAcquisitionprops->append($obj);
                        }
                      }

                      $this->collAcquisitionpropsPartial = true;
                    }

                    $collAcquisitionprops->getInternalIterator()->rewind();
                    return $collAcquisitionprops;
                }

                if($partial && $this->collAcquisitionprops) {
                    foreach($this->collAcquisitionprops as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitionprops[] = $obj;
                        }
                    }
                }

                $this->collAcquisitionprops = $collAcquisitionprops;
                $this->collAcquisitionpropsPartial = false;
            }
        }

        return $this->collAcquisitionprops;
    }

    /**
     * Sets a collection of Acquisitionprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitionprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setAcquisitionprops(PropelCollection $acquisitionprops, PropelPDO $con = null)
    {
        $acquisitionpropsToDelete = $this->getAcquisitionprops(new Criteria(), $con)->diff($acquisitionprops);

        $this->acquisitionpropsScheduledForDeletion = unserialize(serialize($acquisitionpropsToDelete));

        foreach ($acquisitionpropsToDelete as $acquisitionpropRemoved) {
            $acquisitionpropRemoved->setCvterm(null);
        }

        $this->collAcquisitionprops = null;
        foreach ($acquisitionprops as $acquisitionprop) {
            $this->addAcquisitionprop($acquisitionprop);
        }

        $this->collAcquisitionprops = $acquisitionprops;
        $this->collAcquisitionpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Acquisitionprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Acquisitionprop objects.
     * @throws PropelException
     */
    public function countAcquisitionprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionpropsPartial && !$this->isNew();
        if (null === $this->collAcquisitionprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitionprops());
            }
            $query = AcquisitionpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collAcquisitionprops);
    }

    /**
     * Method called to associate a Acquisitionprop object to this object
     * through the Acquisitionprop foreign key attribute.
     *
     * @param    Acquisitionprop $l Acquisitionprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addAcquisitionprop(Acquisitionprop $l)
    {
        if ($this->collAcquisitionprops === null) {
            $this->initAcquisitionprops();
            $this->collAcquisitionpropsPartial = true;
        }
        if (!in_array($l, $this->collAcquisitionprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisitionprop($l);
        }

        return $this;
    }

    /**
     * @param	Acquisitionprop $acquisitionprop The acquisitionprop object to add.
     */
    protected function doAddAcquisitionprop($acquisitionprop)
    {
        $this->collAcquisitionprops[]= $acquisitionprop;
        $acquisitionprop->setCvterm($this);
    }

    /**
     * @param	Acquisitionprop $acquisitionprop The acquisitionprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeAcquisitionprop($acquisitionprop)
    {
        if ($this->getAcquisitionprops()->contains($acquisitionprop)) {
            $this->collAcquisitionprops->remove($this->collAcquisitionprops->search($acquisitionprop));
            if (null === $this->acquisitionpropsScheduledForDeletion) {
                $this->acquisitionpropsScheduledForDeletion = clone $this->collAcquisitionprops;
                $this->acquisitionpropsScheduledForDeletion->clear();
            }
            $this->acquisitionpropsScheduledForDeletion[]= clone $acquisitionprop;
            $acquisitionprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Acquisitionprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisitionprop[] List of Acquisitionprop objects
     */
    public function getAcquisitionpropsJoinAcquisition($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionpropQuery::create(null, $criteria);
        $query->joinWith('Acquisition', $join_behavior);

        return $this->getAcquisitionprops($query, $con);
    }

    /**
     * Clears out the collAnalysisfeatureprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addAnalysisfeatureprops()
     */
    public function clearAnalysisfeatureprops()
    {
        $this->collAnalysisfeatureprops = null; // important to set this to null since that means it is uninitialized
        $this->collAnalysisfeaturepropsPartial = null;

        return $this;
    }

    /**
     * reset is the collAnalysisfeatureprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialAnalysisfeatureprops($v = true)
    {
        $this->collAnalysisfeaturepropsPartial = $v;
    }

    /**
     * Initializes the collAnalysisfeatureprops collection.
     *
     * By default this just sets the collAnalysisfeatureprops collection to an empty array (like clearcollAnalysisfeatureprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnalysisfeatureprops($overrideExisting = true)
    {
        if (null !== $this->collAnalysisfeatureprops && !$overrideExisting) {
            return;
        }
        $this->collAnalysisfeatureprops = new PropelObjectCollection();
        $this->collAnalysisfeatureprops->setModel('Analysisfeatureprop');
    }

    /**
     * Gets an array of Analysisfeatureprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Analysisfeatureprop[] List of Analysisfeatureprop objects
     * @throws PropelException
     */
    public function getAnalysisfeatureprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturepropsPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatureprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatureprops) {
                // return empty collection
                $this->initAnalysisfeatureprops();
            } else {
                $collAnalysisfeatureprops = AnalysisfeaturepropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAnalysisfeaturepropsPartial && count($collAnalysisfeatureprops)) {
                      $this->initAnalysisfeatureprops(false);

                      foreach($collAnalysisfeatureprops as $obj) {
                        if (false == $this->collAnalysisfeatureprops->contains($obj)) {
                          $this->collAnalysisfeatureprops->append($obj);
                        }
                      }

                      $this->collAnalysisfeaturepropsPartial = true;
                    }

                    $collAnalysisfeatureprops->getInternalIterator()->rewind();
                    return $collAnalysisfeatureprops;
                }

                if($partial && $this->collAnalysisfeatureprops) {
                    foreach($this->collAnalysisfeatureprops as $obj) {
                        if($obj->isNew()) {
                            $collAnalysisfeatureprops[] = $obj;
                        }
                    }
                }

                $this->collAnalysisfeatureprops = $collAnalysisfeatureprops;
                $this->collAnalysisfeaturepropsPartial = false;
            }
        }

        return $this->collAnalysisfeatureprops;
    }

    /**
     * Sets a collection of Analysisfeatureprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $analysisfeatureprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setAnalysisfeatureprops(PropelCollection $analysisfeatureprops, PropelPDO $con = null)
    {
        $analysisfeaturepropsToDelete = $this->getAnalysisfeatureprops(new Criteria(), $con)->diff($analysisfeatureprops);

        $this->analysisfeaturepropsScheduledForDeletion = unserialize(serialize($analysisfeaturepropsToDelete));

        foreach ($analysisfeaturepropsToDelete as $analysisfeaturepropRemoved) {
            $analysisfeaturepropRemoved->setCvterm(null);
        }

        $this->collAnalysisfeatureprops = null;
        foreach ($analysisfeatureprops as $analysisfeatureprop) {
            $this->addAnalysisfeatureprop($analysisfeatureprop);
        }

        $this->collAnalysisfeatureprops = $analysisfeatureprops;
        $this->collAnalysisfeaturepropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Analysisfeatureprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Analysisfeatureprop objects.
     * @throws PropelException
     */
    public function countAnalysisfeatureprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturepropsPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatureprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatureprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAnalysisfeatureprops());
            }
            $query = AnalysisfeaturepropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collAnalysisfeatureprops);
    }

    /**
     * Method called to associate a Analysisfeatureprop object to this object
     * through the Analysisfeatureprop foreign key attribute.
     *
     * @param    Analysisfeatureprop $l Analysisfeatureprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addAnalysisfeatureprop(Analysisfeatureprop $l)
    {
        if ($this->collAnalysisfeatureprops === null) {
            $this->initAnalysisfeatureprops();
            $this->collAnalysisfeaturepropsPartial = true;
        }
        if (!in_array($l, $this->collAnalysisfeatureprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAnalysisfeatureprop($l);
        }

        return $this;
    }

    /**
     * @param	Analysisfeatureprop $analysisfeatureprop The analysisfeatureprop object to add.
     */
    protected function doAddAnalysisfeatureprop($analysisfeatureprop)
    {
        $this->collAnalysisfeatureprops[]= $analysisfeatureprop;
        $analysisfeatureprop->setCvterm($this);
    }

    /**
     * @param	Analysisfeatureprop $analysisfeatureprop The analysisfeatureprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeAnalysisfeatureprop($analysisfeatureprop)
    {
        if ($this->getAnalysisfeatureprops()->contains($analysisfeatureprop)) {
            $this->collAnalysisfeatureprops->remove($this->collAnalysisfeatureprops->search($analysisfeatureprop));
            if (null === $this->analysisfeaturepropsScheduledForDeletion) {
                $this->analysisfeaturepropsScheduledForDeletion = clone $this->collAnalysisfeatureprops;
                $this->analysisfeaturepropsScheduledForDeletion->clear();
            }
            $this->analysisfeaturepropsScheduledForDeletion[]= clone $analysisfeatureprop;
            $analysisfeatureprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Analysisfeatureprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Analysisfeatureprop[] List of Analysisfeatureprop objects
     */
    public function getAnalysisfeaturepropsJoinAnalysisfeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AnalysisfeaturepropQuery::create(null, $criteria);
        $query->joinWith('Analysisfeature', $join_behavior);

        return $this->getAnalysisfeatureprops($query, $con);
    }

    /**
     * Clears out the collAnalysisprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addAnalysisprops()
     */
    public function clearAnalysisprops()
    {
        $this->collAnalysisprops = null; // important to set this to null since that means it is uninitialized
        $this->collAnalysispropsPartial = null;

        return $this;
    }

    /**
     * reset is the collAnalysisprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialAnalysisprops($v = true)
    {
        $this->collAnalysispropsPartial = $v;
    }

    /**
     * Initializes the collAnalysisprops collection.
     *
     * By default this just sets the collAnalysisprops collection to an empty array (like clearcollAnalysisprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnalysisprops($overrideExisting = true)
    {
        if (null !== $this->collAnalysisprops && !$overrideExisting) {
            return;
        }
        $this->collAnalysisprops = new PropelObjectCollection();
        $this->collAnalysisprops->setModel('Analysisprop');
    }

    /**
     * Gets an array of Analysisprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Analysisprop[] List of Analysisprop objects
     * @throws PropelException
     */
    public function getAnalysisprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAnalysispropsPartial && !$this->isNew();
        if (null === $this->collAnalysisprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnalysisprops) {
                // return empty collection
                $this->initAnalysisprops();
            } else {
                $collAnalysisprops = AnalysispropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAnalysispropsPartial && count($collAnalysisprops)) {
                      $this->initAnalysisprops(false);

                      foreach($collAnalysisprops as $obj) {
                        if (false == $this->collAnalysisprops->contains($obj)) {
                          $this->collAnalysisprops->append($obj);
                        }
                      }

                      $this->collAnalysispropsPartial = true;
                    }

                    $collAnalysisprops->getInternalIterator()->rewind();
                    return $collAnalysisprops;
                }

                if($partial && $this->collAnalysisprops) {
                    foreach($this->collAnalysisprops as $obj) {
                        if($obj->isNew()) {
                            $collAnalysisprops[] = $obj;
                        }
                    }
                }

                $this->collAnalysisprops = $collAnalysisprops;
                $this->collAnalysispropsPartial = false;
            }
        }

        return $this->collAnalysisprops;
    }

    /**
     * Sets a collection of Analysisprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $analysisprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setAnalysisprops(PropelCollection $analysisprops, PropelPDO $con = null)
    {
        $analysispropsToDelete = $this->getAnalysisprops(new Criteria(), $con)->diff($analysisprops);

        $this->analysispropsScheduledForDeletion = unserialize(serialize($analysispropsToDelete));

        foreach ($analysispropsToDelete as $analysispropRemoved) {
            $analysispropRemoved->setCvterm(null);
        }

        $this->collAnalysisprops = null;
        foreach ($analysisprops as $analysisprop) {
            $this->addAnalysisprop($analysisprop);
        }

        $this->collAnalysisprops = $analysisprops;
        $this->collAnalysispropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Analysisprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Analysisprop objects.
     * @throws PropelException
     */
    public function countAnalysisprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAnalysispropsPartial && !$this->isNew();
        if (null === $this->collAnalysisprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnalysisprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAnalysisprops());
            }
            $query = AnalysispropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collAnalysisprops);
    }

    /**
     * Method called to associate a Analysisprop object to this object
     * through the Analysisprop foreign key attribute.
     *
     * @param    Analysisprop $l Analysisprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addAnalysisprop(Analysisprop $l)
    {
        if ($this->collAnalysisprops === null) {
            $this->initAnalysisprops();
            $this->collAnalysispropsPartial = true;
        }
        if (!in_array($l, $this->collAnalysisprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAnalysisprop($l);
        }

        return $this;
    }

    /**
     * @param	Analysisprop $analysisprop The analysisprop object to add.
     */
    protected function doAddAnalysisprop($analysisprop)
    {
        $this->collAnalysisprops[]= $analysisprop;
        $analysisprop->setCvterm($this);
    }

    /**
     * @param	Analysisprop $analysisprop The analysisprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeAnalysisprop($analysisprop)
    {
        if ($this->getAnalysisprops()->contains($analysisprop)) {
            $this->collAnalysisprops->remove($this->collAnalysisprops->search($analysisprop));
            if (null === $this->analysispropsScheduledForDeletion) {
                $this->analysispropsScheduledForDeletion = clone $this->collAnalysisprops;
                $this->analysispropsScheduledForDeletion->clear();
            }
            $this->analysispropsScheduledForDeletion[]= clone $analysisprop;
            $analysisprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Analysisprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Analysisprop[] List of Analysisprop objects
     */
    public function getAnalysispropsJoinAnalysis($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AnalysispropQuery::create(null, $criteria);
        $query->joinWith('Analysis', $join_behavior);

        return $this->getAnalysisprops($query, $con);
    }

    /**
     * Clears out the collArraydesignsRelatedByPlatformtypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addArraydesignsRelatedByPlatformtypeId()
     */
    public function clearArraydesignsRelatedByPlatformtypeId()
    {
        $this->collArraydesignsRelatedByPlatformtypeId = null; // important to set this to null since that means it is uninitialized
        $this->collArraydesignsRelatedByPlatformtypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collArraydesignsRelatedByPlatformtypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialArraydesignsRelatedByPlatformtypeId($v = true)
    {
        $this->collArraydesignsRelatedByPlatformtypeIdPartial = $v;
    }

    /**
     * Initializes the collArraydesignsRelatedByPlatformtypeId collection.
     *
     * By default this just sets the collArraydesignsRelatedByPlatformtypeId collection to an empty array (like clearcollArraydesignsRelatedByPlatformtypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArraydesignsRelatedByPlatformtypeId($overrideExisting = true)
    {
        if (null !== $this->collArraydesignsRelatedByPlatformtypeId && !$overrideExisting) {
            return;
        }
        $this->collArraydesignsRelatedByPlatformtypeId = new PropelObjectCollection();
        $this->collArraydesignsRelatedByPlatformtypeId->setModel('Arraydesign');
    }

    /**
     * Gets an array of Arraydesign objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     * @throws PropelException
     */
    public function getArraydesignsRelatedByPlatformtypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsRelatedByPlatformtypeIdPartial && !$this->isNew();
        if (null === $this->collArraydesignsRelatedByPlatformtypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArraydesignsRelatedByPlatformtypeId) {
                // return empty collection
                $this->initArraydesignsRelatedByPlatformtypeId();
            } else {
                $collArraydesignsRelatedByPlatformtypeId = ArraydesignQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByPlatformtypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collArraydesignsRelatedByPlatformtypeIdPartial && count($collArraydesignsRelatedByPlatformtypeId)) {
                      $this->initArraydesignsRelatedByPlatformtypeId(false);

                      foreach($collArraydesignsRelatedByPlatformtypeId as $obj) {
                        if (false == $this->collArraydesignsRelatedByPlatformtypeId->contains($obj)) {
                          $this->collArraydesignsRelatedByPlatformtypeId->append($obj);
                        }
                      }

                      $this->collArraydesignsRelatedByPlatformtypeIdPartial = true;
                    }

                    $collArraydesignsRelatedByPlatformtypeId->getInternalIterator()->rewind();
                    return $collArraydesignsRelatedByPlatformtypeId;
                }

                if($partial && $this->collArraydesignsRelatedByPlatformtypeId) {
                    foreach($this->collArraydesignsRelatedByPlatformtypeId as $obj) {
                        if($obj->isNew()) {
                            $collArraydesignsRelatedByPlatformtypeId[] = $obj;
                        }
                    }
                }

                $this->collArraydesignsRelatedByPlatformtypeId = $collArraydesignsRelatedByPlatformtypeId;
                $this->collArraydesignsRelatedByPlatformtypeIdPartial = false;
            }
        }

        return $this->collArraydesignsRelatedByPlatformtypeId;
    }

    /**
     * Sets a collection of ArraydesignRelatedByPlatformtypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $arraydesignsRelatedByPlatformtypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setArraydesignsRelatedByPlatformtypeId(PropelCollection $arraydesignsRelatedByPlatformtypeId, PropelPDO $con = null)
    {
        $arraydesignsRelatedByPlatformtypeIdToDelete = $this->getArraydesignsRelatedByPlatformtypeId(new Criteria(), $con)->diff($arraydesignsRelatedByPlatformtypeId);

        $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion = unserialize(serialize($arraydesignsRelatedByPlatformtypeIdToDelete));

        foreach ($arraydesignsRelatedByPlatformtypeIdToDelete as $arraydesignRelatedByPlatformtypeIdRemoved) {
            $arraydesignRelatedByPlatformtypeIdRemoved->setCvtermRelatedByPlatformtypeId(null);
        }

        $this->collArraydesignsRelatedByPlatformtypeId = null;
        foreach ($arraydesignsRelatedByPlatformtypeId as $arraydesignRelatedByPlatformtypeId) {
            $this->addArraydesignRelatedByPlatformtypeId($arraydesignRelatedByPlatformtypeId);
        }

        $this->collArraydesignsRelatedByPlatformtypeId = $arraydesignsRelatedByPlatformtypeId;
        $this->collArraydesignsRelatedByPlatformtypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arraydesign objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Arraydesign objects.
     * @throws PropelException
     */
    public function countArraydesignsRelatedByPlatformtypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsRelatedByPlatformtypeIdPartial && !$this->isNew();
        if (null === $this->collArraydesignsRelatedByPlatformtypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArraydesignsRelatedByPlatformtypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getArraydesignsRelatedByPlatformtypeId());
            }
            $query = ArraydesignQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByPlatformtypeId($this)
                ->count($con);
        }

        return count($this->collArraydesignsRelatedByPlatformtypeId);
    }

    /**
     * Method called to associate a Arraydesign object to this object
     * through the Arraydesign foreign key attribute.
     *
     * @param    Arraydesign $l Arraydesign
     * @return Cvterm The current object (for fluent API support)
     */
    public function addArraydesignRelatedByPlatformtypeId(Arraydesign $l)
    {
        if ($this->collArraydesignsRelatedByPlatformtypeId === null) {
            $this->initArraydesignsRelatedByPlatformtypeId();
            $this->collArraydesignsRelatedByPlatformtypeIdPartial = true;
        }
        if (!in_array($l, $this->collArraydesignsRelatedByPlatformtypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddArraydesignRelatedByPlatformtypeId($l);
        }

        return $this;
    }

    /**
     * @param	ArraydesignRelatedByPlatformtypeId $arraydesignRelatedByPlatformtypeId The arraydesignRelatedByPlatformtypeId object to add.
     */
    protected function doAddArraydesignRelatedByPlatformtypeId($arraydesignRelatedByPlatformtypeId)
    {
        $this->collArraydesignsRelatedByPlatformtypeId[]= $arraydesignRelatedByPlatformtypeId;
        $arraydesignRelatedByPlatformtypeId->setCvtermRelatedByPlatformtypeId($this);
    }

    /**
     * @param	ArraydesignRelatedByPlatformtypeId $arraydesignRelatedByPlatformtypeId The arraydesignRelatedByPlatformtypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeArraydesignRelatedByPlatformtypeId($arraydesignRelatedByPlatformtypeId)
    {
        if ($this->getArraydesignsRelatedByPlatformtypeId()->contains($arraydesignRelatedByPlatformtypeId)) {
            $this->collArraydesignsRelatedByPlatformtypeId->remove($this->collArraydesignsRelatedByPlatformtypeId->search($arraydesignRelatedByPlatformtypeId));
            if (null === $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion) {
                $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion = clone $this->collArraydesignsRelatedByPlatformtypeId;
                $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion->clear();
            }
            $this->arraydesignsRelatedByPlatformtypeIdScheduledForDeletion[]= clone $arraydesignRelatedByPlatformtypeId;
            $arraydesignRelatedByPlatformtypeId->setCvtermRelatedByPlatformtypeId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedByPlatformtypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedByPlatformtypeIdJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getArraydesignsRelatedByPlatformtypeId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedByPlatformtypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedByPlatformtypeIdJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getArraydesignsRelatedByPlatformtypeId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedByPlatformtypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedByPlatformtypeIdJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getArraydesignsRelatedByPlatformtypeId($query, $con);
    }

    /**
     * Clears out the collArraydesignsRelatedBySubstratetypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addArraydesignsRelatedBySubstratetypeId()
     */
    public function clearArraydesignsRelatedBySubstratetypeId()
    {
        $this->collArraydesignsRelatedBySubstratetypeId = null; // important to set this to null since that means it is uninitialized
        $this->collArraydesignsRelatedBySubstratetypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collArraydesignsRelatedBySubstratetypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialArraydesignsRelatedBySubstratetypeId($v = true)
    {
        $this->collArraydesignsRelatedBySubstratetypeIdPartial = $v;
    }

    /**
     * Initializes the collArraydesignsRelatedBySubstratetypeId collection.
     *
     * By default this just sets the collArraydesignsRelatedBySubstratetypeId collection to an empty array (like clearcollArraydesignsRelatedBySubstratetypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArraydesignsRelatedBySubstratetypeId($overrideExisting = true)
    {
        if (null !== $this->collArraydesignsRelatedBySubstratetypeId && !$overrideExisting) {
            return;
        }
        $this->collArraydesignsRelatedBySubstratetypeId = new PropelObjectCollection();
        $this->collArraydesignsRelatedBySubstratetypeId->setModel('Arraydesign');
    }

    /**
     * Gets an array of Arraydesign objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     * @throws PropelException
     */
    public function getArraydesignsRelatedBySubstratetypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsRelatedBySubstratetypeIdPartial && !$this->isNew();
        if (null === $this->collArraydesignsRelatedBySubstratetypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArraydesignsRelatedBySubstratetypeId) {
                // return empty collection
                $this->initArraydesignsRelatedBySubstratetypeId();
            } else {
                $collArraydesignsRelatedBySubstratetypeId = ArraydesignQuery::create(null, $criteria)
                    ->filterByCvtermRelatedBySubstratetypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collArraydesignsRelatedBySubstratetypeIdPartial && count($collArraydesignsRelatedBySubstratetypeId)) {
                      $this->initArraydesignsRelatedBySubstratetypeId(false);

                      foreach($collArraydesignsRelatedBySubstratetypeId as $obj) {
                        if (false == $this->collArraydesignsRelatedBySubstratetypeId->contains($obj)) {
                          $this->collArraydesignsRelatedBySubstratetypeId->append($obj);
                        }
                      }

                      $this->collArraydesignsRelatedBySubstratetypeIdPartial = true;
                    }

                    $collArraydesignsRelatedBySubstratetypeId->getInternalIterator()->rewind();
                    return $collArraydesignsRelatedBySubstratetypeId;
                }

                if($partial && $this->collArraydesignsRelatedBySubstratetypeId) {
                    foreach($this->collArraydesignsRelatedBySubstratetypeId as $obj) {
                        if($obj->isNew()) {
                            $collArraydesignsRelatedBySubstratetypeId[] = $obj;
                        }
                    }
                }

                $this->collArraydesignsRelatedBySubstratetypeId = $collArraydesignsRelatedBySubstratetypeId;
                $this->collArraydesignsRelatedBySubstratetypeIdPartial = false;
            }
        }

        return $this->collArraydesignsRelatedBySubstratetypeId;
    }

    /**
     * Sets a collection of ArraydesignRelatedBySubstratetypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $arraydesignsRelatedBySubstratetypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setArraydesignsRelatedBySubstratetypeId(PropelCollection $arraydesignsRelatedBySubstratetypeId, PropelPDO $con = null)
    {
        $arraydesignsRelatedBySubstratetypeIdToDelete = $this->getArraydesignsRelatedBySubstratetypeId(new Criteria(), $con)->diff($arraydesignsRelatedBySubstratetypeId);

        $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion = unserialize(serialize($arraydesignsRelatedBySubstratetypeIdToDelete));

        foreach ($arraydesignsRelatedBySubstratetypeIdToDelete as $arraydesignRelatedBySubstratetypeIdRemoved) {
            $arraydesignRelatedBySubstratetypeIdRemoved->setCvtermRelatedBySubstratetypeId(null);
        }

        $this->collArraydesignsRelatedBySubstratetypeId = null;
        foreach ($arraydesignsRelatedBySubstratetypeId as $arraydesignRelatedBySubstratetypeId) {
            $this->addArraydesignRelatedBySubstratetypeId($arraydesignRelatedBySubstratetypeId);
        }

        $this->collArraydesignsRelatedBySubstratetypeId = $arraydesignsRelatedBySubstratetypeId;
        $this->collArraydesignsRelatedBySubstratetypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arraydesign objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Arraydesign objects.
     * @throws PropelException
     */
    public function countArraydesignsRelatedBySubstratetypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsRelatedBySubstratetypeIdPartial && !$this->isNew();
        if (null === $this->collArraydesignsRelatedBySubstratetypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArraydesignsRelatedBySubstratetypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getArraydesignsRelatedBySubstratetypeId());
            }
            $query = ArraydesignQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedBySubstratetypeId($this)
                ->count($con);
        }

        return count($this->collArraydesignsRelatedBySubstratetypeId);
    }

    /**
     * Method called to associate a Arraydesign object to this object
     * through the Arraydesign foreign key attribute.
     *
     * @param    Arraydesign $l Arraydesign
     * @return Cvterm The current object (for fluent API support)
     */
    public function addArraydesignRelatedBySubstratetypeId(Arraydesign $l)
    {
        if ($this->collArraydesignsRelatedBySubstratetypeId === null) {
            $this->initArraydesignsRelatedBySubstratetypeId();
            $this->collArraydesignsRelatedBySubstratetypeIdPartial = true;
        }
        if (!in_array($l, $this->collArraydesignsRelatedBySubstratetypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddArraydesignRelatedBySubstratetypeId($l);
        }

        return $this;
    }

    /**
     * @param	ArraydesignRelatedBySubstratetypeId $arraydesignRelatedBySubstratetypeId The arraydesignRelatedBySubstratetypeId object to add.
     */
    protected function doAddArraydesignRelatedBySubstratetypeId($arraydesignRelatedBySubstratetypeId)
    {
        $this->collArraydesignsRelatedBySubstratetypeId[]= $arraydesignRelatedBySubstratetypeId;
        $arraydesignRelatedBySubstratetypeId->setCvtermRelatedBySubstratetypeId($this);
    }

    /**
     * @param	ArraydesignRelatedBySubstratetypeId $arraydesignRelatedBySubstratetypeId The arraydesignRelatedBySubstratetypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeArraydesignRelatedBySubstratetypeId($arraydesignRelatedBySubstratetypeId)
    {
        if ($this->getArraydesignsRelatedBySubstratetypeId()->contains($arraydesignRelatedBySubstratetypeId)) {
            $this->collArraydesignsRelatedBySubstratetypeId->remove($this->collArraydesignsRelatedBySubstratetypeId->search($arraydesignRelatedBySubstratetypeId));
            if (null === $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion) {
                $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion = clone $this->collArraydesignsRelatedBySubstratetypeId;
                $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion->clear();
            }
            $this->arraydesignsRelatedBySubstratetypeIdScheduledForDeletion[]= $arraydesignRelatedBySubstratetypeId;
            $arraydesignRelatedBySubstratetypeId->setCvtermRelatedBySubstratetypeId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedBySubstratetypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedBySubstratetypeIdJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getArraydesignsRelatedBySubstratetypeId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedBySubstratetypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedBySubstratetypeIdJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getArraydesignsRelatedBySubstratetypeId($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ArraydesignsRelatedBySubstratetypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsRelatedBySubstratetypeIdJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getArraydesignsRelatedBySubstratetypeId($query, $con);
    }

    /**
     * Clears out the collArraydesignprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addArraydesignprops()
     */
    public function clearArraydesignprops()
    {
        $this->collArraydesignprops = null; // important to set this to null since that means it is uninitialized
        $this->collArraydesignpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collArraydesignprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialArraydesignprops($v = true)
    {
        $this->collArraydesignpropsPartial = $v;
    }

    /**
     * Initializes the collArraydesignprops collection.
     *
     * By default this just sets the collArraydesignprops collection to an empty array (like clearcollArraydesignprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArraydesignprops($overrideExisting = true)
    {
        if (null !== $this->collArraydesignprops && !$overrideExisting) {
            return;
        }
        $this->collArraydesignprops = new PropelObjectCollection();
        $this->collArraydesignprops->setModel('Arraydesignprop');
    }

    /**
     * Gets an array of Arraydesignprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Arraydesignprop[] List of Arraydesignprop objects
     * @throws PropelException
     */
    public function getArraydesignprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignpropsPartial && !$this->isNew();
        if (null === $this->collArraydesignprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArraydesignprops) {
                // return empty collection
                $this->initArraydesignprops();
            } else {
                $collArraydesignprops = ArraydesignpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collArraydesignpropsPartial && count($collArraydesignprops)) {
                      $this->initArraydesignprops(false);

                      foreach($collArraydesignprops as $obj) {
                        if (false == $this->collArraydesignprops->contains($obj)) {
                          $this->collArraydesignprops->append($obj);
                        }
                      }

                      $this->collArraydesignpropsPartial = true;
                    }

                    $collArraydesignprops->getInternalIterator()->rewind();
                    return $collArraydesignprops;
                }

                if($partial && $this->collArraydesignprops) {
                    foreach($this->collArraydesignprops as $obj) {
                        if($obj->isNew()) {
                            $collArraydesignprops[] = $obj;
                        }
                    }
                }

                $this->collArraydesignprops = $collArraydesignprops;
                $this->collArraydesignpropsPartial = false;
            }
        }

        return $this->collArraydesignprops;
    }

    /**
     * Sets a collection of Arraydesignprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $arraydesignprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setArraydesignprops(PropelCollection $arraydesignprops, PropelPDO $con = null)
    {
        $arraydesignpropsToDelete = $this->getArraydesignprops(new Criteria(), $con)->diff($arraydesignprops);

        $this->arraydesignpropsScheduledForDeletion = unserialize(serialize($arraydesignpropsToDelete));

        foreach ($arraydesignpropsToDelete as $arraydesignpropRemoved) {
            $arraydesignpropRemoved->setCvterm(null);
        }

        $this->collArraydesignprops = null;
        foreach ($arraydesignprops as $arraydesignprop) {
            $this->addArraydesignprop($arraydesignprop);
        }

        $this->collArraydesignprops = $arraydesignprops;
        $this->collArraydesignpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arraydesignprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Arraydesignprop objects.
     * @throws PropelException
     */
    public function countArraydesignprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignpropsPartial && !$this->isNew();
        if (null === $this->collArraydesignprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArraydesignprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getArraydesignprops());
            }
            $query = ArraydesignpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collArraydesignprops);
    }

    /**
     * Method called to associate a Arraydesignprop object to this object
     * through the Arraydesignprop foreign key attribute.
     *
     * @param    Arraydesignprop $l Arraydesignprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addArraydesignprop(Arraydesignprop $l)
    {
        if ($this->collArraydesignprops === null) {
            $this->initArraydesignprops();
            $this->collArraydesignpropsPartial = true;
        }
        if (!in_array($l, $this->collArraydesignprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddArraydesignprop($l);
        }

        return $this;
    }

    /**
     * @param	Arraydesignprop $arraydesignprop The arraydesignprop object to add.
     */
    protected function doAddArraydesignprop($arraydesignprop)
    {
        $this->collArraydesignprops[]= $arraydesignprop;
        $arraydesignprop->setCvterm($this);
    }

    /**
     * @param	Arraydesignprop $arraydesignprop The arraydesignprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeArraydesignprop($arraydesignprop)
    {
        if ($this->getArraydesignprops()->contains($arraydesignprop)) {
            $this->collArraydesignprops->remove($this->collArraydesignprops->search($arraydesignprop));
            if (null === $this->arraydesignpropsScheduledForDeletion) {
                $this->arraydesignpropsScheduledForDeletion = clone $this->collArraydesignprops;
                $this->arraydesignpropsScheduledForDeletion->clear();
            }
            $this->arraydesignpropsScheduledForDeletion[]= clone $arraydesignprop;
            $arraydesignprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Arraydesignprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesignprop[] List of Arraydesignprop objects
     */
    public function getArraydesignpropsJoinArraydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignpropQuery::create(null, $criteria);
        $query->joinWith('Arraydesign', $join_behavior);

        return $this->getArraydesignprops($query, $con);
    }

    /**
     * Clears out the collAssayprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addAssayprops()
     */
    public function clearAssayprops()
    {
        $this->collAssayprops = null; // important to set this to null since that means it is uninitialized
        $this->collAssaypropsPartial = null;

        return $this;
    }

    /**
     * reset is the collAssayprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssayprops($v = true)
    {
        $this->collAssaypropsPartial = $v;
    }

    /**
     * Initializes the collAssayprops collection.
     *
     * By default this just sets the collAssayprops collection to an empty array (like clearcollAssayprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssayprops($overrideExisting = true)
    {
        if (null !== $this->collAssayprops && !$overrideExisting) {
            return;
        }
        $this->collAssayprops = new PropelObjectCollection();
        $this->collAssayprops->setModel('Assayprop');
    }

    /**
     * Gets an array of Assayprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Assayprop[] List of Assayprop objects
     * @throws PropelException
     */
    public function getAssayprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssaypropsPartial && !$this->isNew();
        if (null === $this->collAssayprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssayprops) {
                // return empty collection
                $this->initAssayprops();
            } else {
                $collAssayprops = AssaypropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssaypropsPartial && count($collAssayprops)) {
                      $this->initAssayprops(false);

                      foreach($collAssayprops as $obj) {
                        if (false == $this->collAssayprops->contains($obj)) {
                          $this->collAssayprops->append($obj);
                        }
                      }

                      $this->collAssaypropsPartial = true;
                    }

                    $collAssayprops->getInternalIterator()->rewind();
                    return $collAssayprops;
                }

                if($partial && $this->collAssayprops) {
                    foreach($this->collAssayprops as $obj) {
                        if($obj->isNew()) {
                            $collAssayprops[] = $obj;
                        }
                    }
                }

                $this->collAssayprops = $collAssayprops;
                $this->collAssaypropsPartial = false;
            }
        }

        return $this->collAssayprops;
    }

    /**
     * Sets a collection of Assayprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assayprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setAssayprops(PropelCollection $assayprops, PropelPDO $con = null)
    {
        $assaypropsToDelete = $this->getAssayprops(new Criteria(), $con)->diff($assayprops);

        $this->assaypropsScheduledForDeletion = unserialize(serialize($assaypropsToDelete));

        foreach ($assaypropsToDelete as $assaypropRemoved) {
            $assaypropRemoved->setCvterm(null);
        }

        $this->collAssayprops = null;
        foreach ($assayprops as $assayprop) {
            $this->addAssayprop($assayprop);
        }

        $this->collAssayprops = $assayprops;
        $this->collAssaypropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Assayprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Assayprop objects.
     * @throws PropelException
     */
    public function countAssayprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssaypropsPartial && !$this->isNew();
        if (null === $this->collAssayprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssayprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAssayprops());
            }
            $query = AssaypropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collAssayprops);
    }

    /**
     * Method called to associate a Assayprop object to this object
     * through the Assayprop foreign key attribute.
     *
     * @param    Assayprop $l Assayprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addAssayprop(Assayprop $l)
    {
        if ($this->collAssayprops === null) {
            $this->initAssayprops();
            $this->collAssaypropsPartial = true;
        }
        if (!in_array($l, $this->collAssayprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssayprop($l);
        }

        return $this;
    }

    /**
     * @param	Assayprop $assayprop The assayprop object to add.
     */
    protected function doAddAssayprop($assayprop)
    {
        $this->collAssayprops[]= $assayprop;
        $assayprop->setCvterm($this);
    }

    /**
     * @param	Assayprop $assayprop The assayprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeAssayprop($assayprop)
    {
        if ($this->getAssayprops()->contains($assayprop)) {
            $this->collAssayprops->remove($this->collAssayprops->search($assayprop));
            if (null === $this->assaypropsScheduledForDeletion) {
                $this->assaypropsScheduledForDeletion = clone $this->collAssayprops;
                $this->assaypropsScheduledForDeletion->clear();
            }
            $this->assaypropsScheduledForDeletion[]= clone $assayprop;
            $assayprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Assayprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Assayprop[] List of Assayprop objects
     */
    public function getAssaypropsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssaypropQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAssayprops($query, $con);
    }

    /**
     * Clears out the collBiomaterialRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addBiomaterialRelationships()
     */
    public function clearBiomaterialRelationships()
    {
        $this->collBiomaterialRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialRelationships($v = true)
    {
        $this->collBiomaterialRelationshipsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialRelationships collection.
     *
     * By default this just sets the collBiomaterialRelationships collection to an empty array (like clearcollBiomaterialRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialRelationships($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialRelationships && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialRelationships = new PropelObjectCollection();
        $this->collBiomaterialRelationships->setModel('BiomaterialRelationship');
    }

    /**
     * Gets an array of BiomaterialRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     * @throws PropelException
     */
    public function getBiomaterialRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationships) {
                // return empty collection
                $this->initBiomaterialRelationships();
            } else {
                $collBiomaterialRelationships = BiomaterialRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialRelationshipsPartial && count($collBiomaterialRelationships)) {
                      $this->initBiomaterialRelationships(false);

                      foreach($collBiomaterialRelationships as $obj) {
                        if (false == $this->collBiomaterialRelationships->contains($obj)) {
                          $this->collBiomaterialRelationships->append($obj);
                        }
                      }

                      $this->collBiomaterialRelationshipsPartial = true;
                    }

                    $collBiomaterialRelationships->getInternalIterator()->rewind();
                    return $collBiomaterialRelationships;
                }

                if($partial && $this->collBiomaterialRelationships) {
                    foreach($this->collBiomaterialRelationships as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialRelationships[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialRelationships = $collBiomaterialRelationships;
                $this->collBiomaterialRelationshipsPartial = false;
            }
        }

        return $this->collBiomaterialRelationships;
    }

    /**
     * Sets a collection of BiomaterialRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setBiomaterialRelationships(PropelCollection $biomaterialRelationships, PropelPDO $con = null)
    {
        $biomaterialRelationshipsToDelete = $this->getBiomaterialRelationships(new Criteria(), $con)->diff($biomaterialRelationships);

        $this->biomaterialRelationshipsScheduledForDeletion = unserialize(serialize($biomaterialRelationshipsToDelete));

        foreach ($biomaterialRelationshipsToDelete as $biomaterialRelationshipRemoved) {
            $biomaterialRelationshipRemoved->setCvterm(null);
        }

        $this->collBiomaterialRelationships = null;
        foreach ($biomaterialRelationships as $biomaterialRelationship) {
            $this->addBiomaterialRelationship($biomaterialRelationship);
        }

        $this->collBiomaterialRelationships = $biomaterialRelationships;
        $this->collBiomaterialRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BiomaterialRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BiomaterialRelationship objects.
     * @throws PropelException
     */
    public function countBiomaterialRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialRelationships());
            }
            $query = BiomaterialRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collBiomaterialRelationships);
    }

    /**
     * Method called to associate a BiomaterialRelationship object to this object
     * through the BiomaterialRelationship foreign key attribute.
     *
     * @param    BiomaterialRelationship $l BiomaterialRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addBiomaterialRelationship(BiomaterialRelationship $l)
    {
        if ($this->collBiomaterialRelationships === null) {
            $this->initBiomaterialRelationships();
            $this->collBiomaterialRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialRelationship($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialRelationship $biomaterialRelationship The biomaterialRelationship object to add.
     */
    protected function doAddBiomaterialRelationship($biomaterialRelationship)
    {
        $this->collBiomaterialRelationships[]= $biomaterialRelationship;
        $biomaterialRelationship->setCvterm($this);
    }

    /**
     * @param	BiomaterialRelationship $biomaterialRelationship The biomaterialRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeBiomaterialRelationship($biomaterialRelationship)
    {
        if ($this->getBiomaterialRelationships()->contains($biomaterialRelationship)) {
            $this->collBiomaterialRelationships->remove($this->collBiomaterialRelationships->search($biomaterialRelationship));
            if (null === $this->biomaterialRelationshipsScheduledForDeletion) {
                $this->biomaterialRelationshipsScheduledForDeletion = clone $this->collBiomaterialRelationships;
                $this->biomaterialRelationshipsScheduledForDeletion->clear();
            }
            $this->biomaterialRelationshipsScheduledForDeletion[]= clone $biomaterialRelationship;
            $biomaterialRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsJoinBiomaterialRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('BiomaterialRelatedByObjectId', $join_behavior);

        return $this->getBiomaterialRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsJoinBiomaterialRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('BiomaterialRelatedBySubjectId', $join_behavior);

        return $this->getBiomaterialRelationships($query, $con);
    }

    /**
     * Clears out the collBiomaterialTreatments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addBiomaterialTreatments()
     */
    public function clearBiomaterialTreatments()
    {
        $this->collBiomaterialTreatments = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialTreatmentsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialTreatments collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialTreatments($v = true)
    {
        $this->collBiomaterialTreatmentsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialTreatments collection.
     *
     * By default this just sets the collBiomaterialTreatments collection to an empty array (like clearcollBiomaterialTreatments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialTreatments($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialTreatments && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialTreatments = new PropelObjectCollection();
        $this->collBiomaterialTreatments->setModel('BiomaterialTreatment');
    }

    /**
     * Gets an array of BiomaterialTreatment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialTreatment[] List of BiomaterialTreatment objects
     * @throws PropelException
     */
    public function getBiomaterialTreatments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialTreatmentsPartial && !$this->isNew();
        if (null === $this->collBiomaterialTreatments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialTreatments) {
                // return empty collection
                $this->initBiomaterialTreatments();
            } else {
                $collBiomaterialTreatments = BiomaterialTreatmentQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialTreatmentsPartial && count($collBiomaterialTreatments)) {
                      $this->initBiomaterialTreatments(false);

                      foreach($collBiomaterialTreatments as $obj) {
                        if (false == $this->collBiomaterialTreatments->contains($obj)) {
                          $this->collBiomaterialTreatments->append($obj);
                        }
                      }

                      $this->collBiomaterialTreatmentsPartial = true;
                    }

                    $collBiomaterialTreatments->getInternalIterator()->rewind();
                    return $collBiomaterialTreatments;
                }

                if($partial && $this->collBiomaterialTreatments) {
                    foreach($this->collBiomaterialTreatments as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialTreatments[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialTreatments = $collBiomaterialTreatments;
                $this->collBiomaterialTreatmentsPartial = false;
            }
        }

        return $this->collBiomaterialTreatments;
    }

    /**
     * Sets a collection of BiomaterialTreatment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialTreatments A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setBiomaterialTreatments(PropelCollection $biomaterialTreatments, PropelPDO $con = null)
    {
        $biomaterialTreatmentsToDelete = $this->getBiomaterialTreatments(new Criteria(), $con)->diff($biomaterialTreatments);

        $this->biomaterialTreatmentsScheduledForDeletion = unserialize(serialize($biomaterialTreatmentsToDelete));

        foreach ($biomaterialTreatmentsToDelete as $biomaterialTreatmentRemoved) {
            $biomaterialTreatmentRemoved->setCvterm(null);
        }

        $this->collBiomaterialTreatments = null;
        foreach ($biomaterialTreatments as $biomaterialTreatment) {
            $this->addBiomaterialTreatment($biomaterialTreatment);
        }

        $this->collBiomaterialTreatments = $biomaterialTreatments;
        $this->collBiomaterialTreatmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BiomaterialTreatment objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BiomaterialTreatment objects.
     * @throws PropelException
     */
    public function countBiomaterialTreatments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialTreatmentsPartial && !$this->isNew();
        if (null === $this->collBiomaterialTreatments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialTreatments) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialTreatments());
            }
            $query = BiomaterialTreatmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collBiomaterialTreatments);
    }

    /**
     * Method called to associate a BiomaterialTreatment object to this object
     * through the BiomaterialTreatment foreign key attribute.
     *
     * @param    BiomaterialTreatment $l BiomaterialTreatment
     * @return Cvterm The current object (for fluent API support)
     */
    public function addBiomaterialTreatment(BiomaterialTreatment $l)
    {
        if ($this->collBiomaterialTreatments === null) {
            $this->initBiomaterialTreatments();
            $this->collBiomaterialTreatmentsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialTreatments->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialTreatment($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialTreatment $biomaterialTreatment The biomaterialTreatment object to add.
     */
    protected function doAddBiomaterialTreatment($biomaterialTreatment)
    {
        $this->collBiomaterialTreatments[]= $biomaterialTreatment;
        $biomaterialTreatment->setCvterm($this);
    }

    /**
     * @param	BiomaterialTreatment $biomaterialTreatment The biomaterialTreatment object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeBiomaterialTreatment($biomaterialTreatment)
    {
        if ($this->getBiomaterialTreatments()->contains($biomaterialTreatment)) {
            $this->collBiomaterialTreatments->remove($this->collBiomaterialTreatments->search($biomaterialTreatment));
            if (null === $this->biomaterialTreatmentsScheduledForDeletion) {
                $this->biomaterialTreatmentsScheduledForDeletion = clone $this->collBiomaterialTreatments;
                $this->biomaterialTreatmentsScheduledForDeletion->clear();
            }
            $this->biomaterialTreatmentsScheduledForDeletion[]= $biomaterialTreatment;
            $biomaterialTreatment->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialTreatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialTreatment[] List of BiomaterialTreatment objects
     */
    public function getBiomaterialTreatmentsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialTreatmentQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getBiomaterialTreatments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialTreatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialTreatment[] List of BiomaterialTreatment objects
     */
    public function getBiomaterialTreatmentsJoinTreatment($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialTreatmentQuery::create(null, $criteria);
        $query->joinWith('Treatment', $join_behavior);

        return $this->getBiomaterialTreatments($query, $con);
    }

    /**
     * Clears out the collBiomaterialprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addBiomaterialprops()
     */
    public function clearBiomaterialprops()
    {
        $this->collBiomaterialprops = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialprops($v = true)
    {
        $this->collBiomaterialpropsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialprops collection.
     *
     * By default this just sets the collBiomaterialprops collection to an empty array (like clearcollBiomaterialprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialprops($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialprops && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialprops = new PropelObjectCollection();
        $this->collBiomaterialprops->setModel('Biomaterialprop');
    }

    /**
     * Gets an array of Biomaterialprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Biomaterialprop[] List of Biomaterialprop objects
     * @throws PropelException
     */
    public function getBiomaterialprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialpropsPartial && !$this->isNew();
        if (null === $this->collBiomaterialprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialprops) {
                // return empty collection
                $this->initBiomaterialprops();
            } else {
                $collBiomaterialprops = BiomaterialpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialpropsPartial && count($collBiomaterialprops)) {
                      $this->initBiomaterialprops(false);

                      foreach($collBiomaterialprops as $obj) {
                        if (false == $this->collBiomaterialprops->contains($obj)) {
                          $this->collBiomaterialprops->append($obj);
                        }
                      }

                      $this->collBiomaterialpropsPartial = true;
                    }

                    $collBiomaterialprops->getInternalIterator()->rewind();
                    return $collBiomaterialprops;
                }

                if($partial && $this->collBiomaterialprops) {
                    foreach($this->collBiomaterialprops as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialprops[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialprops = $collBiomaterialprops;
                $this->collBiomaterialpropsPartial = false;
            }
        }

        return $this->collBiomaterialprops;
    }

    /**
     * Sets a collection of Biomaterialprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setBiomaterialprops(PropelCollection $biomaterialprops, PropelPDO $con = null)
    {
        $biomaterialpropsToDelete = $this->getBiomaterialprops(new Criteria(), $con)->diff($biomaterialprops);

        $this->biomaterialpropsScheduledForDeletion = unserialize(serialize($biomaterialpropsToDelete));

        foreach ($biomaterialpropsToDelete as $biomaterialpropRemoved) {
            $biomaterialpropRemoved->setCvterm(null);
        }

        $this->collBiomaterialprops = null;
        foreach ($biomaterialprops as $biomaterialprop) {
            $this->addBiomaterialprop($biomaterialprop);
        }

        $this->collBiomaterialprops = $biomaterialprops;
        $this->collBiomaterialpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Biomaterialprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Biomaterialprop objects.
     * @throws PropelException
     */
    public function countBiomaterialprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialpropsPartial && !$this->isNew();
        if (null === $this->collBiomaterialprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialprops());
            }
            $query = BiomaterialpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collBiomaterialprops);
    }

    /**
     * Method called to associate a Biomaterialprop object to this object
     * through the Biomaterialprop foreign key attribute.
     *
     * @param    Biomaterialprop $l Biomaterialprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addBiomaterialprop(Biomaterialprop $l)
    {
        if ($this->collBiomaterialprops === null) {
            $this->initBiomaterialprops();
            $this->collBiomaterialpropsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialprop($l);
        }

        return $this;
    }

    /**
     * @param	Biomaterialprop $biomaterialprop The biomaterialprop object to add.
     */
    protected function doAddBiomaterialprop($biomaterialprop)
    {
        $this->collBiomaterialprops[]= $biomaterialprop;
        $biomaterialprop->setCvterm($this);
    }

    /**
     * @param	Biomaterialprop $biomaterialprop The biomaterialprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeBiomaterialprop($biomaterialprop)
    {
        if ($this->getBiomaterialprops()->contains($biomaterialprop)) {
            $this->collBiomaterialprops->remove($this->collBiomaterialprops->search($biomaterialprop));
            if (null === $this->biomaterialpropsScheduledForDeletion) {
                $this->biomaterialpropsScheduledForDeletion = clone $this->collBiomaterialprops;
                $this->biomaterialpropsScheduledForDeletion->clear();
            }
            $this->biomaterialpropsScheduledForDeletion[]= clone $biomaterialprop;
            $biomaterialprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Biomaterialprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Biomaterialprop[] List of Biomaterialprop objects
     */
    public function getBiomaterialpropsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialpropQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getBiomaterialprops($query, $con);
    }

    /**
     * Clears out the collChadoprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addChadoprops()
     */
    public function clearChadoprops()
    {
        $this->collChadoprops = null; // important to set this to null since that means it is uninitialized
        $this->collChadopropsPartial = null;

        return $this;
    }

    /**
     * reset is the collChadoprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialChadoprops($v = true)
    {
        $this->collChadopropsPartial = $v;
    }

    /**
     * Initializes the collChadoprops collection.
     *
     * By default this just sets the collChadoprops collection to an empty array (like clearcollChadoprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initChadoprops($overrideExisting = true)
    {
        if (null !== $this->collChadoprops && !$overrideExisting) {
            return;
        }
        $this->collChadoprops = new PropelObjectCollection();
        $this->collChadoprops->setModel('Chadoprop');
    }

    /**
     * Gets an array of Chadoprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Chadoprop[] List of Chadoprop objects
     * @throws PropelException
     */
    public function getChadoprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collChadopropsPartial && !$this->isNew();
        if (null === $this->collChadoprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collChadoprops) {
                // return empty collection
                $this->initChadoprops();
            } else {
                $collChadoprops = ChadopropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collChadopropsPartial && count($collChadoprops)) {
                      $this->initChadoprops(false);

                      foreach($collChadoprops as $obj) {
                        if (false == $this->collChadoprops->contains($obj)) {
                          $this->collChadoprops->append($obj);
                        }
                      }

                      $this->collChadopropsPartial = true;
                    }

                    $collChadoprops->getInternalIterator()->rewind();
                    return $collChadoprops;
                }

                if($partial && $this->collChadoprops) {
                    foreach($this->collChadoprops as $obj) {
                        if($obj->isNew()) {
                            $collChadoprops[] = $obj;
                        }
                    }
                }

                $this->collChadoprops = $collChadoprops;
                $this->collChadopropsPartial = false;
            }
        }

        return $this->collChadoprops;
    }

    /**
     * Sets a collection of Chadoprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $chadoprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setChadoprops(PropelCollection $chadoprops, PropelPDO $con = null)
    {
        $chadopropsToDelete = $this->getChadoprops(new Criteria(), $con)->diff($chadoprops);

        $this->chadopropsScheduledForDeletion = unserialize(serialize($chadopropsToDelete));

        foreach ($chadopropsToDelete as $chadopropRemoved) {
            $chadopropRemoved->setCvterm(null);
        }

        $this->collChadoprops = null;
        foreach ($chadoprops as $chadoprop) {
            $this->addChadoprop($chadoprop);
        }

        $this->collChadoprops = $chadoprops;
        $this->collChadopropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Chadoprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Chadoprop objects.
     * @throws PropelException
     */
    public function countChadoprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collChadopropsPartial && !$this->isNew();
        if (null === $this->collChadoprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collChadoprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getChadoprops());
            }
            $query = ChadopropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collChadoprops);
    }

    /**
     * Method called to associate a Chadoprop object to this object
     * through the Chadoprop foreign key attribute.
     *
     * @param    Chadoprop $l Chadoprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addChadoprop(Chadoprop $l)
    {
        if ($this->collChadoprops === null) {
            $this->initChadoprops();
            $this->collChadopropsPartial = true;
        }
        if (!in_array($l, $this->collChadoprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddChadoprop($l);
        }

        return $this;
    }

    /**
     * @param	Chadoprop $chadoprop The chadoprop object to add.
     */
    protected function doAddChadoprop($chadoprop)
    {
        $this->collChadoprops[]= $chadoprop;
        $chadoprop->setCvterm($this);
    }

    /**
     * @param	Chadoprop $chadoprop The chadoprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeChadoprop($chadoprop)
    {
        if ($this->getChadoprops()->contains($chadoprop)) {
            $this->collChadoprops->remove($this->collChadoprops->search($chadoprop));
            if (null === $this->chadopropsScheduledForDeletion) {
                $this->chadopropsScheduledForDeletion = clone $this->collChadoprops;
                $this->chadopropsScheduledForDeletion->clear();
            }
            $this->chadopropsScheduledForDeletion[]= clone $chadoprop;
            $chadoprop->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collContacts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addContacts()
     */
    public function clearContacts()
    {
        $this->collContacts = null; // important to set this to null since that means it is uninitialized
        $this->collContactsPartial = null;

        return $this;
    }

    /**
     * reset is the collContacts collection loaded partially
     *
     * @return void
     */
    public function resetPartialContacts($v = true)
    {
        $this->collContactsPartial = $v;
    }

    /**
     * Initializes the collContacts collection.
     *
     * By default this just sets the collContacts collection to an empty array (like clearcollContacts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContacts($overrideExisting = true)
    {
        if (null !== $this->collContacts && !$overrideExisting) {
            return;
        }
        $this->collContacts = new PropelObjectCollection();
        $this->collContacts->setModel('Contact');
    }

    /**
     * Gets an array of Contact objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Contact[] List of Contact objects
     * @throws PropelException
     */
    public function getContacts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                // return empty collection
                $this->initContacts();
            } else {
                $collContacts = ContactQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContactsPartial && count($collContacts)) {
                      $this->initContacts(false);

                      foreach($collContacts as $obj) {
                        if (false == $this->collContacts->contains($obj)) {
                          $this->collContacts->append($obj);
                        }
                      }

                      $this->collContactsPartial = true;
                    }

                    $collContacts->getInternalIterator()->rewind();
                    return $collContacts;
                }

                if($partial && $this->collContacts) {
                    foreach($this->collContacts as $obj) {
                        if($obj->isNew()) {
                            $collContacts[] = $obj;
                        }
                    }
                }

                $this->collContacts = $collContacts;
                $this->collContactsPartial = false;
            }
        }

        return $this->collContacts;
    }

    /**
     * Sets a collection of Contact objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contacts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setContacts(PropelCollection $contacts, PropelPDO $con = null)
    {
        $contactsToDelete = $this->getContacts(new Criteria(), $con)->diff($contacts);

        $this->contactsScheduledForDeletion = unserialize(serialize($contactsToDelete));

        foreach ($contactsToDelete as $contactRemoved) {
            $contactRemoved->setCvterm(null);
        }

        $this->collContacts = null;
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }

        $this->collContacts = $contacts;
        $this->collContactsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contact objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Contact objects.
     * @throws PropelException
     */
    public function countContacts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContacts());
            }
            $query = ContactQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collContacts);
    }

    /**
     * Method called to associate a Contact object to this object
     * through the Contact foreign key attribute.
     *
     * @param    Contact $l Contact
     * @return Cvterm The current object (for fluent API support)
     */
    public function addContact(Contact $l)
    {
        if ($this->collContacts === null) {
            $this->initContacts();
            $this->collContactsPartial = true;
        }
        if (!in_array($l, $this->collContacts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContact($l);
        }

        return $this;
    }

    /**
     * @param	Contact $contact The contact object to add.
     */
    protected function doAddContact($contact)
    {
        $this->collContacts[]= $contact;
        $contact->setCvterm($this);
    }

    /**
     * @param	Contact $contact The contact object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeContact($contact)
    {
        if ($this->getContacts()->contains($contact)) {
            $this->collContacts->remove($this->collContacts->search($contact));
            if (null === $this->contactsScheduledForDeletion) {
                $this->contactsScheduledForDeletion = clone $this->collContacts;
                $this->contactsScheduledForDeletion->clear();
            }
            $this->contactsScheduledForDeletion[]= $contact;
            $contact->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collContactRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addContactRelationships()
     */
    public function clearContactRelationships()
    {
        $this->collContactRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collContactRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collContactRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialContactRelationships($v = true)
    {
        $this->collContactRelationshipsPartial = $v;
    }

    /**
     * Initializes the collContactRelationships collection.
     *
     * By default this just sets the collContactRelationships collection to an empty array (like clearcollContactRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContactRelationships($overrideExisting = true)
    {
        if (null !== $this->collContactRelationships && !$overrideExisting) {
            return;
        }
        $this->collContactRelationships = new PropelObjectCollection();
        $this->collContactRelationships->setModel('ContactRelationship');
    }

    /**
     * Gets an array of ContactRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     * @throws PropelException
     */
    public function getContactRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsPartial && !$this->isNew();
        if (null === $this->collContactRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContactRelationships) {
                // return empty collection
                $this->initContactRelationships();
            } else {
                $collContactRelationships = ContactRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContactRelationshipsPartial && count($collContactRelationships)) {
                      $this->initContactRelationships(false);

                      foreach($collContactRelationships as $obj) {
                        if (false == $this->collContactRelationships->contains($obj)) {
                          $this->collContactRelationships->append($obj);
                        }
                      }

                      $this->collContactRelationshipsPartial = true;
                    }

                    $collContactRelationships->getInternalIterator()->rewind();
                    return $collContactRelationships;
                }

                if($partial && $this->collContactRelationships) {
                    foreach($this->collContactRelationships as $obj) {
                        if($obj->isNew()) {
                            $collContactRelationships[] = $obj;
                        }
                    }
                }

                $this->collContactRelationships = $collContactRelationships;
                $this->collContactRelationshipsPartial = false;
            }
        }

        return $this->collContactRelationships;
    }

    /**
     * Sets a collection of ContactRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contactRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setContactRelationships(PropelCollection $contactRelationships, PropelPDO $con = null)
    {
        $contactRelationshipsToDelete = $this->getContactRelationships(new Criteria(), $con)->diff($contactRelationships);

        $this->contactRelationshipsScheduledForDeletion = unserialize(serialize($contactRelationshipsToDelete));

        foreach ($contactRelationshipsToDelete as $contactRelationshipRemoved) {
            $contactRelationshipRemoved->setCvterm(null);
        }

        $this->collContactRelationships = null;
        foreach ($contactRelationships as $contactRelationship) {
            $this->addContactRelationship($contactRelationship);
        }

        $this->collContactRelationships = $contactRelationships;
        $this->collContactRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContactRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContactRelationship objects.
     * @throws PropelException
     */
    public function countContactRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsPartial && !$this->isNew();
        if (null === $this->collContactRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContactRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContactRelationships());
            }
            $query = ContactRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collContactRelationships);
    }

    /**
     * Method called to associate a ContactRelationship object to this object
     * through the ContactRelationship foreign key attribute.
     *
     * @param    ContactRelationship $l ContactRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addContactRelationship(ContactRelationship $l)
    {
        if ($this->collContactRelationships === null) {
            $this->initContactRelationships();
            $this->collContactRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collContactRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContactRelationship($l);
        }

        return $this;
    }

    /**
     * @param	ContactRelationship $contactRelationship The contactRelationship object to add.
     */
    protected function doAddContactRelationship($contactRelationship)
    {
        $this->collContactRelationships[]= $contactRelationship;
        $contactRelationship->setCvterm($this);
    }

    /**
     * @param	ContactRelationship $contactRelationship The contactRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeContactRelationship($contactRelationship)
    {
        if ($this->getContactRelationships()->contains($contactRelationship)) {
            $this->collContactRelationships->remove($this->collContactRelationships->search($contactRelationship));
            if (null === $this->contactRelationshipsScheduledForDeletion) {
                $this->contactRelationshipsScheduledForDeletion = clone $this->collContactRelationships;
                $this->contactRelationshipsScheduledForDeletion->clear();
            }
            $this->contactRelationshipsScheduledForDeletion[]= clone $contactRelationship;
            $contactRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ContactRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     */
    public function getContactRelationshipsJoinContactRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContactRelationshipQuery::create(null, $criteria);
        $query->joinWith('ContactRelatedByObjectId', $join_behavior);

        return $this->getContactRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ContactRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     */
    public function getContactRelationshipsJoinContactRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContactRelationshipQuery::create(null, $criteria);
        $query->joinWith('ContactRelatedBySubjectId', $join_behavior);

        return $this->getContactRelationships($query, $con);
    }

    /**
     * Clears out the collControls collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addControls()
     */
    public function clearControls()
    {
        $this->collControls = null; // important to set this to null since that means it is uninitialized
        $this->collControlsPartial = null;

        return $this;
    }

    /**
     * reset is the collControls collection loaded partially
     *
     * @return void
     */
    public function resetPartialControls($v = true)
    {
        $this->collControlsPartial = $v;
    }

    /**
     * Initializes the collControls collection.
     *
     * By default this just sets the collControls collection to an empty array (like clearcollControls());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initControls($overrideExisting = true)
    {
        if (null !== $this->collControls && !$overrideExisting) {
            return;
        }
        $this->collControls = new PropelObjectCollection();
        $this->collControls->setModel('Control');
    }

    /**
     * Gets an array of Control objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Control[] List of Control objects
     * @throws PropelException
     */
    public function getControls($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collControlsPartial && !$this->isNew();
        if (null === $this->collControls || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collControls) {
                // return empty collection
                $this->initControls();
            } else {
                $collControls = ControlQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collControlsPartial && count($collControls)) {
                      $this->initControls(false);

                      foreach($collControls as $obj) {
                        if (false == $this->collControls->contains($obj)) {
                          $this->collControls->append($obj);
                        }
                      }

                      $this->collControlsPartial = true;
                    }

                    $collControls->getInternalIterator()->rewind();
                    return $collControls;
                }

                if($partial && $this->collControls) {
                    foreach($this->collControls as $obj) {
                        if($obj->isNew()) {
                            $collControls[] = $obj;
                        }
                    }
                }

                $this->collControls = $collControls;
                $this->collControlsPartial = false;
            }
        }

        return $this->collControls;
    }

    /**
     * Sets a collection of Control objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $controls A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setControls(PropelCollection $controls, PropelPDO $con = null)
    {
        $controlsToDelete = $this->getControls(new Criteria(), $con)->diff($controls);

        $this->controlsScheduledForDeletion = unserialize(serialize($controlsToDelete));

        foreach ($controlsToDelete as $controlRemoved) {
            $controlRemoved->setCvterm(null);
        }

        $this->collControls = null;
        foreach ($controls as $control) {
            $this->addControl($control);
        }

        $this->collControls = $controls;
        $this->collControlsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Control objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Control objects.
     * @throws PropelException
     */
    public function countControls(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collControlsPartial && !$this->isNew();
        if (null === $this->collControls || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collControls) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getControls());
            }
            $query = ControlQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collControls);
    }

    /**
     * Method called to associate a Control object to this object
     * through the Control foreign key attribute.
     *
     * @param    Control $l Control
     * @return Cvterm The current object (for fluent API support)
     */
    public function addControl(Control $l)
    {
        if ($this->collControls === null) {
            $this->initControls();
            $this->collControlsPartial = true;
        }
        if (!in_array($l, $this->collControls->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddControl($l);
        }

        return $this;
    }

    /**
     * @param	Control $control The control object to add.
     */
    protected function doAddControl($control)
    {
        $this->collControls[]= $control;
        $control->setCvterm($this);
    }

    /**
     * @param	Control $control The control object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeControl($control)
    {
        if ($this->getControls()->contains($control)) {
            $this->collControls->remove($this->collControls->search($control));
            if (null === $this->controlsScheduledForDeletion) {
                $this->controlsScheduledForDeletion = clone $this->collControls;
                $this->controlsScheduledForDeletion->clear();
            }
            $this->controlsScheduledForDeletion[]= clone $control;
            $control->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Controls from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Control[] List of Control objects
     */
    public function getControlsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ControlQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getControls($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Controls from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Control[] List of Control objects
     */
    public function getControlsJoinTableinfo($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ControlQuery::create(null, $criteria);
        $query->joinWith('Tableinfo', $join_behavior);

        return $this->getControls($query, $con);
    }

    /**
     * Clears out the collCvprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvprops()
     */
    public function clearCvprops()
    {
        $this->collCvprops = null; // important to set this to null since that means it is uninitialized
        $this->collCvpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvprops($v = true)
    {
        $this->collCvpropsPartial = $v;
    }

    /**
     * Initializes the collCvprops collection.
     *
     * By default this just sets the collCvprops collection to an empty array (like clearcollCvprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvprops($overrideExisting = true)
    {
        if (null !== $this->collCvprops && !$overrideExisting) {
            return;
        }
        $this->collCvprops = new PropelObjectCollection();
        $this->collCvprops->setModel('Cvprop');
    }

    /**
     * Gets an array of Cvprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvprop[] List of Cvprop objects
     * @throws PropelException
     */
    public function getCvprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvpropsPartial && !$this->isNew();
        if (null === $this->collCvprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvprops) {
                // return empty collection
                $this->initCvprops();
            } else {
                $collCvprops = CvpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvpropsPartial && count($collCvprops)) {
                      $this->initCvprops(false);

                      foreach($collCvprops as $obj) {
                        if (false == $this->collCvprops->contains($obj)) {
                          $this->collCvprops->append($obj);
                        }
                      }

                      $this->collCvpropsPartial = true;
                    }

                    $collCvprops->getInternalIterator()->rewind();
                    return $collCvprops;
                }

                if($partial && $this->collCvprops) {
                    foreach($this->collCvprops as $obj) {
                        if($obj->isNew()) {
                            $collCvprops[] = $obj;
                        }
                    }
                }

                $this->collCvprops = $collCvprops;
                $this->collCvpropsPartial = false;
            }
        }

        return $this->collCvprops;
    }

    /**
     * Sets a collection of Cvprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvprops(PropelCollection $cvprops, PropelPDO $con = null)
    {
        $cvpropsToDelete = $this->getCvprops(new Criteria(), $con)->diff($cvprops);

        $this->cvpropsScheduledForDeletion = unserialize(serialize($cvpropsToDelete));

        foreach ($cvpropsToDelete as $cvpropRemoved) {
            $cvpropRemoved->setCvterm(null);
        }

        $this->collCvprops = null;
        foreach ($cvprops as $cvprop) {
            $this->addCvprop($cvprop);
        }

        $this->collCvprops = $cvprops;
        $this->collCvpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvprop objects.
     * @throws PropelException
     */
    public function countCvprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvpropsPartial && !$this->isNew();
        if (null === $this->collCvprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvprops());
            }
            $query = CvpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collCvprops);
    }

    /**
     * Method called to associate a Cvprop object to this object
     * through the Cvprop foreign key attribute.
     *
     * @param    Cvprop $l Cvprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvprop(Cvprop $l)
    {
        if ($this->collCvprops === null) {
            $this->initCvprops();
            $this->collCvpropsPartial = true;
        }
        if (!in_array($l, $this->collCvprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvprop($l);
        }

        return $this;
    }

    /**
     * @param	Cvprop $cvprop The cvprop object to add.
     */
    protected function doAddCvprop($cvprop)
    {
        $this->collCvprops[]= $cvprop;
        $cvprop->setCvterm($this);
    }

    /**
     * @param	Cvprop $cvprop The cvprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvprop($cvprop)
    {
        if ($this->getCvprops()->contains($cvprop)) {
            $this->collCvprops->remove($this->collCvprops->search($cvprop));
            if (null === $this->cvpropsScheduledForDeletion) {
                $this->cvpropsScheduledForDeletion = clone $this->collCvprops;
                $this->cvpropsScheduledForDeletion->clear();
            }
            $this->cvpropsScheduledForDeletion[]= clone $cvprop;
            $cvprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Cvprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvprop[] List of Cvprop objects
     */
    public function getCvpropsJoinCv($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvpropQuery::create(null, $criteria);
        $query->joinWith('Cv', $join_behavior);

        return $this->getCvprops($query, $con);
    }

    /**
     * Clears out the collCvtermDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermDbxrefs()
     */
    public function clearCvtermDbxrefs()
    {
        $this->collCvtermDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermDbxrefs($v = true)
    {
        $this->collCvtermDbxrefsPartial = $v;
    }

    /**
     * Initializes the collCvtermDbxrefs collection.
     *
     * By default this just sets the collCvtermDbxrefs collection to an empty array (like clearcollCvtermDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collCvtermDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collCvtermDbxrefs = new PropelObjectCollection();
        $this->collCvtermDbxrefs->setModel('CvtermDbxref');
    }

    /**
     * Gets an array of CvtermDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CvtermDbxref[] List of CvtermDbxref objects
     * @throws PropelException
     */
    public function getCvtermDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collCvtermDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermDbxrefs) {
                // return empty collection
                $this->initCvtermDbxrefs();
            } else {
                $collCvtermDbxrefs = CvtermDbxrefQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermDbxrefsPartial && count($collCvtermDbxrefs)) {
                      $this->initCvtermDbxrefs(false);

                      foreach($collCvtermDbxrefs as $obj) {
                        if (false == $this->collCvtermDbxrefs->contains($obj)) {
                          $this->collCvtermDbxrefs->append($obj);
                        }
                      }

                      $this->collCvtermDbxrefsPartial = true;
                    }

                    $collCvtermDbxrefs->getInternalIterator()->rewind();
                    return $collCvtermDbxrefs;
                }

                if($partial && $this->collCvtermDbxrefs) {
                    foreach($this->collCvtermDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collCvtermDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collCvtermDbxrefs = $collCvtermDbxrefs;
                $this->collCvtermDbxrefsPartial = false;
            }
        }

        return $this->collCvtermDbxrefs;
    }

    /**
     * Sets a collection of CvtermDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermDbxrefs(PropelCollection $cvtermDbxrefs, PropelPDO $con = null)
    {
        $cvtermDbxrefsToDelete = $this->getCvtermDbxrefs(new Criteria(), $con)->diff($cvtermDbxrefs);

        $this->cvtermDbxrefsScheduledForDeletion = unserialize(serialize($cvtermDbxrefsToDelete));

        foreach ($cvtermDbxrefsToDelete as $cvtermDbxrefRemoved) {
            $cvtermDbxrefRemoved->setCvterm(null);
        }

        $this->collCvtermDbxrefs = null;
        foreach ($cvtermDbxrefs as $cvtermDbxref) {
            $this->addCvtermDbxref($cvtermDbxref);
        }

        $this->collCvtermDbxrefs = $cvtermDbxrefs;
        $this->collCvtermDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CvtermDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CvtermDbxref objects.
     * @throws PropelException
     */
    public function countCvtermDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collCvtermDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermDbxrefs());
            }
            $query = CvtermDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collCvtermDbxrefs);
    }

    /**
     * Method called to associate a CvtermDbxref object to this object
     * through the CvtermDbxref foreign key attribute.
     *
     * @param    CvtermDbxref $l CvtermDbxref
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermDbxref(CvtermDbxref $l)
    {
        if ($this->collCvtermDbxrefs === null) {
            $this->initCvtermDbxrefs();
            $this->collCvtermDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collCvtermDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermDbxref($l);
        }

        return $this;
    }

    /**
     * @param	CvtermDbxref $cvtermDbxref The cvtermDbxref object to add.
     */
    protected function doAddCvtermDbxref($cvtermDbxref)
    {
        $this->collCvtermDbxrefs[]= $cvtermDbxref;
        $cvtermDbxref->setCvterm($this);
    }

    /**
     * @param	CvtermDbxref $cvtermDbxref The cvtermDbxref object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermDbxref($cvtermDbxref)
    {
        if ($this->getCvtermDbxrefs()->contains($cvtermDbxref)) {
            $this->collCvtermDbxrefs->remove($this->collCvtermDbxrefs->search($cvtermDbxref));
            if (null === $this->cvtermDbxrefsScheduledForDeletion) {
                $this->cvtermDbxrefsScheduledForDeletion = clone $this->collCvtermDbxrefs;
                $this->cvtermDbxrefsScheduledForDeletion->clear();
            }
            $this->cvtermDbxrefsScheduledForDeletion[]= clone $cvtermDbxref;
            $cvtermDbxref->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related CvtermDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|CvtermDbxref[] List of CvtermDbxref objects
     */
    public function getCvtermDbxrefsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermDbxrefQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getCvtermDbxrefs($query, $con);
    }

    /**
     * Clears out the collCvtermRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermRelationshipsRelatedByObjectId()
     */
    public function clearCvtermRelationshipsRelatedByObjectId()
    {
        $this->collCvtermRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermRelationshipsRelatedByObjectId($v = true)
    {
        $this->collCvtermRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collCvtermRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collCvtermRelationshipsRelatedByObjectId collection to an empty array (like clearcollCvtermRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collCvtermRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collCvtermRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collCvtermRelationshipsRelatedByObjectId->setModel('CvtermRelationship');
    }

    /**
     * Gets an array of CvtermRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CvtermRelationship[] List of CvtermRelationship objects
     * @throws PropelException
     */
    public function getCvtermRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initCvtermRelationshipsRelatedByObjectId();
            } else {
                $collCvtermRelationshipsRelatedByObjectId = CvtermRelationshipQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermRelationshipsRelatedByObjectIdPartial && count($collCvtermRelationshipsRelatedByObjectId)) {
                      $this->initCvtermRelationshipsRelatedByObjectId(false);

                      foreach($collCvtermRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collCvtermRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collCvtermRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collCvtermRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collCvtermRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collCvtermRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collCvtermRelationshipsRelatedByObjectId) {
                    foreach($this->collCvtermRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collCvtermRelationshipsRelatedByObjectId = $collCvtermRelationshipsRelatedByObjectId;
                $this->collCvtermRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collCvtermRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of CvtermRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermRelationshipsRelatedByObjectId(PropelCollection $cvtermRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $cvtermRelationshipsRelatedByObjectIdToDelete = $this->getCvtermRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($cvtermRelationshipsRelatedByObjectId);

        $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($cvtermRelationshipsRelatedByObjectIdToDelete));

        foreach ($cvtermRelationshipsRelatedByObjectIdToDelete as $cvtermRelationshipRelatedByObjectIdRemoved) {
            $cvtermRelationshipRelatedByObjectIdRemoved->setCvtermRelatedByObjectId(null);
        }

        $this->collCvtermRelationshipsRelatedByObjectId = null;
        foreach ($cvtermRelationshipsRelatedByObjectId as $cvtermRelationshipRelatedByObjectId) {
            $this->addCvtermRelationshipRelatedByObjectId($cvtermRelationshipRelatedByObjectId);
        }

        $this->collCvtermRelationshipsRelatedByObjectId = $cvtermRelationshipsRelatedByObjectId;
        $this->collCvtermRelationshipsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CvtermRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CvtermRelationship objects.
     * @throws PropelException
     */
    public function countCvtermRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermRelationshipsRelatedByObjectId());
            }
            $query = CvtermRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collCvtermRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a CvtermRelationship object to this object
     * through the CvtermRelationship foreign key attribute.
     *
     * @param    CvtermRelationship $l CvtermRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermRelationshipRelatedByObjectId(CvtermRelationship $l)
    {
        if ($this->collCvtermRelationshipsRelatedByObjectId === null) {
            $this->initCvtermRelationshipsRelatedByObjectId();
            $this->collCvtermRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermRelationshipRelatedByObjectId $cvtermRelationshipRelatedByObjectId The cvtermRelationshipRelatedByObjectId object to add.
     */
    protected function doAddCvtermRelationshipRelatedByObjectId($cvtermRelationshipRelatedByObjectId)
    {
        $this->collCvtermRelationshipsRelatedByObjectId[]= $cvtermRelationshipRelatedByObjectId;
        $cvtermRelationshipRelatedByObjectId->setCvtermRelatedByObjectId($this);
    }

    /**
     * @param	CvtermRelationshipRelatedByObjectId $cvtermRelationshipRelatedByObjectId The cvtermRelationshipRelatedByObjectId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermRelationshipRelatedByObjectId($cvtermRelationshipRelatedByObjectId)
    {
        if ($this->getCvtermRelationshipsRelatedByObjectId()->contains($cvtermRelationshipRelatedByObjectId)) {
            $this->collCvtermRelationshipsRelatedByObjectId->remove($this->collCvtermRelationshipsRelatedByObjectId->search($cvtermRelationshipRelatedByObjectId));
            if (null === $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collCvtermRelationshipsRelatedByObjectId;
                $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->cvtermRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $cvtermRelationshipRelatedByObjectId;
            $cvtermRelationshipRelatedByObjectId->setCvtermRelatedByObjectId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermRelationshipsRelatedBySubjectId()
     */
    public function clearCvtermRelationshipsRelatedBySubjectId()
    {
        $this->collCvtermRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collCvtermRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collCvtermRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collCvtermRelationshipsRelatedBySubjectId collection to an empty array (like clearcollCvtermRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collCvtermRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collCvtermRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collCvtermRelationshipsRelatedBySubjectId->setModel('CvtermRelationship');
    }

    /**
     * Gets an array of CvtermRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CvtermRelationship[] List of CvtermRelationship objects
     * @throws PropelException
     */
    public function getCvtermRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initCvtermRelationshipsRelatedBySubjectId();
            } else {
                $collCvtermRelationshipsRelatedBySubjectId = CvtermRelationshipQuery::create(null, $criteria)
                    ->filterByCvtermRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermRelationshipsRelatedBySubjectIdPartial && count($collCvtermRelationshipsRelatedBySubjectId)) {
                      $this->initCvtermRelationshipsRelatedBySubjectId(false);

                      foreach($collCvtermRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collCvtermRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collCvtermRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collCvtermRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collCvtermRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collCvtermRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collCvtermRelationshipsRelatedBySubjectId) {
                    foreach($this->collCvtermRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collCvtermRelationshipsRelatedBySubjectId = $collCvtermRelationshipsRelatedBySubjectId;
                $this->collCvtermRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collCvtermRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of CvtermRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermRelationshipsRelatedBySubjectId(PropelCollection $cvtermRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $cvtermRelationshipsRelatedBySubjectIdToDelete = $this->getCvtermRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($cvtermRelationshipsRelatedBySubjectId);

        $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($cvtermRelationshipsRelatedBySubjectIdToDelete));

        foreach ($cvtermRelationshipsRelatedBySubjectIdToDelete as $cvtermRelationshipRelatedBySubjectIdRemoved) {
            $cvtermRelationshipRelatedBySubjectIdRemoved->setCvtermRelatedBySubjectId(null);
        }

        $this->collCvtermRelationshipsRelatedBySubjectId = null;
        foreach ($cvtermRelationshipsRelatedBySubjectId as $cvtermRelationshipRelatedBySubjectId) {
            $this->addCvtermRelationshipRelatedBySubjectId($cvtermRelationshipRelatedBySubjectId);
        }

        $this->collCvtermRelationshipsRelatedBySubjectId = $cvtermRelationshipsRelatedBySubjectId;
        $this->collCvtermRelationshipsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CvtermRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CvtermRelationship objects.
     * @throws PropelException
     */
    public function countCvtermRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermRelationshipsRelatedBySubjectId());
            }
            $query = CvtermRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collCvtermRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a CvtermRelationship object to this object
     * through the CvtermRelationship foreign key attribute.
     *
     * @param    CvtermRelationship $l CvtermRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermRelationshipRelatedBySubjectId(CvtermRelationship $l)
    {
        if ($this->collCvtermRelationshipsRelatedBySubjectId === null) {
            $this->initCvtermRelationshipsRelatedBySubjectId();
            $this->collCvtermRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermRelationshipRelatedBySubjectId $cvtermRelationshipRelatedBySubjectId The cvtermRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddCvtermRelationshipRelatedBySubjectId($cvtermRelationshipRelatedBySubjectId)
    {
        $this->collCvtermRelationshipsRelatedBySubjectId[]= $cvtermRelationshipRelatedBySubjectId;
        $cvtermRelationshipRelatedBySubjectId->setCvtermRelatedBySubjectId($this);
    }

    /**
     * @param	CvtermRelationshipRelatedBySubjectId $cvtermRelationshipRelatedBySubjectId The cvtermRelationshipRelatedBySubjectId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermRelationshipRelatedBySubjectId($cvtermRelationshipRelatedBySubjectId)
    {
        if ($this->getCvtermRelationshipsRelatedBySubjectId()->contains($cvtermRelationshipRelatedBySubjectId)) {
            $this->collCvtermRelationshipsRelatedBySubjectId->remove($this->collCvtermRelationshipsRelatedBySubjectId->search($cvtermRelationshipRelatedBySubjectId));
            if (null === $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collCvtermRelationshipsRelatedBySubjectId;
                $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->cvtermRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $cvtermRelationshipRelatedBySubjectId;
            $cvtermRelationshipRelatedBySubjectId->setCvtermRelatedBySubjectId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermRelationshipsRelatedByTypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermRelationshipsRelatedByTypeId()
     */
    public function clearCvtermRelationshipsRelatedByTypeId()
    {
        $this->collCvtermRelationshipsRelatedByTypeId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermRelationshipsRelatedByTypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermRelationshipsRelatedByTypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermRelationshipsRelatedByTypeId($v = true)
    {
        $this->collCvtermRelationshipsRelatedByTypeIdPartial = $v;
    }

    /**
     * Initializes the collCvtermRelationshipsRelatedByTypeId collection.
     *
     * By default this just sets the collCvtermRelationshipsRelatedByTypeId collection to an empty array (like clearcollCvtermRelationshipsRelatedByTypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermRelationshipsRelatedByTypeId($overrideExisting = true)
    {
        if (null !== $this->collCvtermRelationshipsRelatedByTypeId && !$overrideExisting) {
            return;
        }
        $this->collCvtermRelationshipsRelatedByTypeId = new PropelObjectCollection();
        $this->collCvtermRelationshipsRelatedByTypeId->setModel('CvtermRelationship');
    }

    /**
     * Gets an array of CvtermRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CvtermRelationship[] List of CvtermRelationship objects
     * @throws PropelException
     */
    public function getCvtermRelationshipsRelatedByTypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedByTypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedByTypeId) {
                // return empty collection
                $this->initCvtermRelationshipsRelatedByTypeId();
            } else {
                $collCvtermRelationshipsRelatedByTypeId = CvtermRelationshipQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByTypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermRelationshipsRelatedByTypeIdPartial && count($collCvtermRelationshipsRelatedByTypeId)) {
                      $this->initCvtermRelationshipsRelatedByTypeId(false);

                      foreach($collCvtermRelationshipsRelatedByTypeId as $obj) {
                        if (false == $this->collCvtermRelationshipsRelatedByTypeId->contains($obj)) {
                          $this->collCvtermRelationshipsRelatedByTypeId->append($obj);
                        }
                      }

                      $this->collCvtermRelationshipsRelatedByTypeIdPartial = true;
                    }

                    $collCvtermRelationshipsRelatedByTypeId->getInternalIterator()->rewind();
                    return $collCvtermRelationshipsRelatedByTypeId;
                }

                if($partial && $this->collCvtermRelationshipsRelatedByTypeId) {
                    foreach($this->collCvtermRelationshipsRelatedByTypeId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermRelationshipsRelatedByTypeId[] = $obj;
                        }
                    }
                }

                $this->collCvtermRelationshipsRelatedByTypeId = $collCvtermRelationshipsRelatedByTypeId;
                $this->collCvtermRelationshipsRelatedByTypeIdPartial = false;
            }
        }

        return $this->collCvtermRelationshipsRelatedByTypeId;
    }

    /**
     * Sets a collection of CvtermRelationshipRelatedByTypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermRelationshipsRelatedByTypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermRelationshipsRelatedByTypeId(PropelCollection $cvtermRelationshipsRelatedByTypeId, PropelPDO $con = null)
    {
        $cvtermRelationshipsRelatedByTypeIdToDelete = $this->getCvtermRelationshipsRelatedByTypeId(new Criteria(), $con)->diff($cvtermRelationshipsRelatedByTypeId);

        $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion = unserialize(serialize($cvtermRelationshipsRelatedByTypeIdToDelete));

        foreach ($cvtermRelationshipsRelatedByTypeIdToDelete as $cvtermRelationshipRelatedByTypeIdRemoved) {
            $cvtermRelationshipRelatedByTypeIdRemoved->setCvtermRelatedByTypeId(null);
        }

        $this->collCvtermRelationshipsRelatedByTypeId = null;
        foreach ($cvtermRelationshipsRelatedByTypeId as $cvtermRelationshipRelatedByTypeId) {
            $this->addCvtermRelationshipRelatedByTypeId($cvtermRelationshipRelatedByTypeId);
        }

        $this->collCvtermRelationshipsRelatedByTypeId = $cvtermRelationshipsRelatedByTypeId;
        $this->collCvtermRelationshipsRelatedByTypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CvtermRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CvtermRelationship objects.
     * @throws PropelException
     */
    public function countCvtermRelationshipsRelatedByTypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermRelationshipsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermRelationshipsRelatedByTypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermRelationshipsRelatedByTypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermRelationshipsRelatedByTypeId());
            }
            $query = CvtermRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByTypeId($this)
                ->count($con);
        }

        return count($this->collCvtermRelationshipsRelatedByTypeId);
    }

    /**
     * Method called to associate a CvtermRelationship object to this object
     * through the CvtermRelationship foreign key attribute.
     *
     * @param    CvtermRelationship $l CvtermRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermRelationshipRelatedByTypeId(CvtermRelationship $l)
    {
        if ($this->collCvtermRelationshipsRelatedByTypeId === null) {
            $this->initCvtermRelationshipsRelatedByTypeId();
            $this->collCvtermRelationshipsRelatedByTypeIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermRelationshipsRelatedByTypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermRelationshipRelatedByTypeId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermRelationshipRelatedByTypeId $cvtermRelationshipRelatedByTypeId The cvtermRelationshipRelatedByTypeId object to add.
     */
    protected function doAddCvtermRelationshipRelatedByTypeId($cvtermRelationshipRelatedByTypeId)
    {
        $this->collCvtermRelationshipsRelatedByTypeId[]= $cvtermRelationshipRelatedByTypeId;
        $cvtermRelationshipRelatedByTypeId->setCvtermRelatedByTypeId($this);
    }

    /**
     * @param	CvtermRelationshipRelatedByTypeId $cvtermRelationshipRelatedByTypeId The cvtermRelationshipRelatedByTypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermRelationshipRelatedByTypeId($cvtermRelationshipRelatedByTypeId)
    {
        if ($this->getCvtermRelationshipsRelatedByTypeId()->contains($cvtermRelationshipRelatedByTypeId)) {
            $this->collCvtermRelationshipsRelatedByTypeId->remove($this->collCvtermRelationshipsRelatedByTypeId->search($cvtermRelationshipRelatedByTypeId));
            if (null === $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion) {
                $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion = clone $this->collCvtermRelationshipsRelatedByTypeId;
                $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion->clear();
            }
            $this->cvtermRelationshipsRelatedByTypeIdScheduledForDeletion[]= clone $cvtermRelationshipRelatedByTypeId;
            $cvtermRelationshipRelatedByTypeId->setCvtermRelatedByTypeId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermpathsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermpathsRelatedByObjectId()
     */
    public function clearCvtermpathsRelatedByObjectId()
    {
        $this->collCvtermpathsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpathsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpathsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpathsRelatedByObjectId($v = true)
    {
        $this->collCvtermpathsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collCvtermpathsRelatedByObjectId collection.
     *
     * By default this just sets the collCvtermpathsRelatedByObjectId collection to an empty array (like clearcollCvtermpathsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpathsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collCvtermpathsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collCvtermpathsRelatedByObjectId = new PropelObjectCollection();
        $this->collCvtermpathsRelatedByObjectId->setModel('Cvtermpath');
    }

    /**
     * Gets an array of Cvtermpath objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     * @throws PropelException
     */
    public function getCvtermpathsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedByObjectId) {
                // return empty collection
                $this->initCvtermpathsRelatedByObjectId();
            } else {
                $collCvtermpathsRelatedByObjectId = CvtermpathQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpathsRelatedByObjectIdPartial && count($collCvtermpathsRelatedByObjectId)) {
                      $this->initCvtermpathsRelatedByObjectId(false);

                      foreach($collCvtermpathsRelatedByObjectId as $obj) {
                        if (false == $this->collCvtermpathsRelatedByObjectId->contains($obj)) {
                          $this->collCvtermpathsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collCvtermpathsRelatedByObjectIdPartial = true;
                    }

                    $collCvtermpathsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collCvtermpathsRelatedByObjectId;
                }

                if($partial && $this->collCvtermpathsRelatedByObjectId) {
                    foreach($this->collCvtermpathsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpathsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collCvtermpathsRelatedByObjectId = $collCvtermpathsRelatedByObjectId;
                $this->collCvtermpathsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collCvtermpathsRelatedByObjectId;
    }

    /**
     * Sets a collection of CvtermpathRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpathsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermpathsRelatedByObjectId(PropelCollection $cvtermpathsRelatedByObjectId, PropelPDO $con = null)
    {
        $cvtermpathsRelatedByObjectIdToDelete = $this->getCvtermpathsRelatedByObjectId(new Criteria(), $con)->diff($cvtermpathsRelatedByObjectId);

        $this->cvtermpathsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($cvtermpathsRelatedByObjectIdToDelete));

        foreach ($cvtermpathsRelatedByObjectIdToDelete as $cvtermpathRelatedByObjectIdRemoved) {
            $cvtermpathRelatedByObjectIdRemoved->setCvtermRelatedByObjectId(null);
        }

        $this->collCvtermpathsRelatedByObjectId = null;
        foreach ($cvtermpathsRelatedByObjectId as $cvtermpathRelatedByObjectId) {
            $this->addCvtermpathRelatedByObjectId($cvtermpathRelatedByObjectId);
        }

        $this->collCvtermpathsRelatedByObjectId = $cvtermpathsRelatedByObjectId;
        $this->collCvtermpathsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermpath objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermpath objects.
     * @throws PropelException
     */
    public function countCvtermpathsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpathsRelatedByObjectId());
            }
            $query = CvtermpathQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collCvtermpathsRelatedByObjectId);
    }

    /**
     * Method called to associate a Cvtermpath object to this object
     * through the Cvtermpath foreign key attribute.
     *
     * @param    Cvtermpath $l Cvtermpath
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermpathRelatedByObjectId(Cvtermpath $l)
    {
        if ($this->collCvtermpathsRelatedByObjectId === null) {
            $this->initCvtermpathsRelatedByObjectId();
            $this->collCvtermpathsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermpathsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpathRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermpathRelatedByObjectId $cvtermpathRelatedByObjectId The cvtermpathRelatedByObjectId object to add.
     */
    protected function doAddCvtermpathRelatedByObjectId($cvtermpathRelatedByObjectId)
    {
        $this->collCvtermpathsRelatedByObjectId[]= $cvtermpathRelatedByObjectId;
        $cvtermpathRelatedByObjectId->setCvtermRelatedByObjectId($this);
    }

    /**
     * @param	CvtermpathRelatedByObjectId $cvtermpathRelatedByObjectId The cvtermpathRelatedByObjectId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermpathRelatedByObjectId($cvtermpathRelatedByObjectId)
    {
        if ($this->getCvtermpathsRelatedByObjectId()->contains($cvtermpathRelatedByObjectId)) {
            $this->collCvtermpathsRelatedByObjectId->remove($this->collCvtermpathsRelatedByObjectId->search($cvtermpathRelatedByObjectId));
            if (null === $this->cvtermpathsRelatedByObjectIdScheduledForDeletion) {
                $this->cvtermpathsRelatedByObjectIdScheduledForDeletion = clone $this->collCvtermpathsRelatedByObjectId;
                $this->cvtermpathsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->cvtermpathsRelatedByObjectIdScheduledForDeletion[]= clone $cvtermpathRelatedByObjectId;
            $cvtermpathRelatedByObjectId->setCvtermRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related CvtermpathsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsRelatedByObjectIdJoinCv($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('Cv', $join_behavior);

        return $this->getCvtermpathsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collCvtermpathsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermpathsRelatedBySubjectId()
     */
    public function clearCvtermpathsRelatedBySubjectId()
    {
        $this->collCvtermpathsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpathsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpathsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpathsRelatedBySubjectId($v = true)
    {
        $this->collCvtermpathsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collCvtermpathsRelatedBySubjectId collection.
     *
     * By default this just sets the collCvtermpathsRelatedBySubjectId collection to an empty array (like clearcollCvtermpathsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpathsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collCvtermpathsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collCvtermpathsRelatedBySubjectId = new PropelObjectCollection();
        $this->collCvtermpathsRelatedBySubjectId->setModel('Cvtermpath');
    }

    /**
     * Gets an array of Cvtermpath objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     * @throws PropelException
     */
    public function getCvtermpathsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedBySubjectId) {
                // return empty collection
                $this->initCvtermpathsRelatedBySubjectId();
            } else {
                $collCvtermpathsRelatedBySubjectId = CvtermpathQuery::create(null, $criteria)
                    ->filterByCvtermRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpathsRelatedBySubjectIdPartial && count($collCvtermpathsRelatedBySubjectId)) {
                      $this->initCvtermpathsRelatedBySubjectId(false);

                      foreach($collCvtermpathsRelatedBySubjectId as $obj) {
                        if (false == $this->collCvtermpathsRelatedBySubjectId->contains($obj)) {
                          $this->collCvtermpathsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collCvtermpathsRelatedBySubjectIdPartial = true;
                    }

                    $collCvtermpathsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collCvtermpathsRelatedBySubjectId;
                }

                if($partial && $this->collCvtermpathsRelatedBySubjectId) {
                    foreach($this->collCvtermpathsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpathsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collCvtermpathsRelatedBySubjectId = $collCvtermpathsRelatedBySubjectId;
                $this->collCvtermpathsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collCvtermpathsRelatedBySubjectId;
    }

    /**
     * Sets a collection of CvtermpathRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpathsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermpathsRelatedBySubjectId(PropelCollection $cvtermpathsRelatedBySubjectId, PropelPDO $con = null)
    {
        $cvtermpathsRelatedBySubjectIdToDelete = $this->getCvtermpathsRelatedBySubjectId(new Criteria(), $con)->diff($cvtermpathsRelatedBySubjectId);

        $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($cvtermpathsRelatedBySubjectIdToDelete));

        foreach ($cvtermpathsRelatedBySubjectIdToDelete as $cvtermpathRelatedBySubjectIdRemoved) {
            $cvtermpathRelatedBySubjectIdRemoved->setCvtermRelatedBySubjectId(null);
        }

        $this->collCvtermpathsRelatedBySubjectId = null;
        foreach ($cvtermpathsRelatedBySubjectId as $cvtermpathRelatedBySubjectId) {
            $this->addCvtermpathRelatedBySubjectId($cvtermpathRelatedBySubjectId);
        }

        $this->collCvtermpathsRelatedBySubjectId = $cvtermpathsRelatedBySubjectId;
        $this->collCvtermpathsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermpath objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermpath objects.
     * @throws PropelException
     */
    public function countCvtermpathsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpathsRelatedBySubjectId());
            }
            $query = CvtermpathQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collCvtermpathsRelatedBySubjectId);
    }

    /**
     * Method called to associate a Cvtermpath object to this object
     * through the Cvtermpath foreign key attribute.
     *
     * @param    Cvtermpath $l Cvtermpath
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermpathRelatedBySubjectId(Cvtermpath $l)
    {
        if ($this->collCvtermpathsRelatedBySubjectId === null) {
            $this->initCvtermpathsRelatedBySubjectId();
            $this->collCvtermpathsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermpathsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpathRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermpathRelatedBySubjectId $cvtermpathRelatedBySubjectId The cvtermpathRelatedBySubjectId object to add.
     */
    protected function doAddCvtermpathRelatedBySubjectId($cvtermpathRelatedBySubjectId)
    {
        $this->collCvtermpathsRelatedBySubjectId[]= $cvtermpathRelatedBySubjectId;
        $cvtermpathRelatedBySubjectId->setCvtermRelatedBySubjectId($this);
    }

    /**
     * @param	CvtermpathRelatedBySubjectId $cvtermpathRelatedBySubjectId The cvtermpathRelatedBySubjectId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermpathRelatedBySubjectId($cvtermpathRelatedBySubjectId)
    {
        if ($this->getCvtermpathsRelatedBySubjectId()->contains($cvtermpathRelatedBySubjectId)) {
            $this->collCvtermpathsRelatedBySubjectId->remove($this->collCvtermpathsRelatedBySubjectId->search($cvtermpathRelatedBySubjectId));
            if (null === $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion) {
                $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion = clone $this->collCvtermpathsRelatedBySubjectId;
                $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->cvtermpathsRelatedBySubjectIdScheduledForDeletion[]= clone $cvtermpathRelatedBySubjectId;
            $cvtermpathRelatedBySubjectId->setCvtermRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related CvtermpathsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsRelatedBySubjectIdJoinCv($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('Cv', $join_behavior);

        return $this->getCvtermpathsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collCvtermpathsRelatedByTypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermpathsRelatedByTypeId()
     */
    public function clearCvtermpathsRelatedByTypeId()
    {
        $this->collCvtermpathsRelatedByTypeId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpathsRelatedByTypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpathsRelatedByTypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpathsRelatedByTypeId($v = true)
    {
        $this->collCvtermpathsRelatedByTypeIdPartial = $v;
    }

    /**
     * Initializes the collCvtermpathsRelatedByTypeId collection.
     *
     * By default this just sets the collCvtermpathsRelatedByTypeId collection to an empty array (like clearcollCvtermpathsRelatedByTypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpathsRelatedByTypeId($overrideExisting = true)
    {
        if (null !== $this->collCvtermpathsRelatedByTypeId && !$overrideExisting) {
            return;
        }
        $this->collCvtermpathsRelatedByTypeId = new PropelObjectCollection();
        $this->collCvtermpathsRelatedByTypeId->setModel('Cvtermpath');
    }

    /**
     * Gets an array of Cvtermpath objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     * @throws PropelException
     */
    public function getCvtermpathsRelatedByTypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedByTypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedByTypeId) {
                // return empty collection
                $this->initCvtermpathsRelatedByTypeId();
            } else {
                $collCvtermpathsRelatedByTypeId = CvtermpathQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByTypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpathsRelatedByTypeIdPartial && count($collCvtermpathsRelatedByTypeId)) {
                      $this->initCvtermpathsRelatedByTypeId(false);

                      foreach($collCvtermpathsRelatedByTypeId as $obj) {
                        if (false == $this->collCvtermpathsRelatedByTypeId->contains($obj)) {
                          $this->collCvtermpathsRelatedByTypeId->append($obj);
                        }
                      }

                      $this->collCvtermpathsRelatedByTypeIdPartial = true;
                    }

                    $collCvtermpathsRelatedByTypeId->getInternalIterator()->rewind();
                    return $collCvtermpathsRelatedByTypeId;
                }

                if($partial && $this->collCvtermpathsRelatedByTypeId) {
                    foreach($this->collCvtermpathsRelatedByTypeId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpathsRelatedByTypeId[] = $obj;
                        }
                    }
                }

                $this->collCvtermpathsRelatedByTypeId = $collCvtermpathsRelatedByTypeId;
                $this->collCvtermpathsRelatedByTypeIdPartial = false;
            }
        }

        return $this->collCvtermpathsRelatedByTypeId;
    }

    /**
     * Sets a collection of CvtermpathRelatedByTypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpathsRelatedByTypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermpathsRelatedByTypeId(PropelCollection $cvtermpathsRelatedByTypeId, PropelPDO $con = null)
    {
        $cvtermpathsRelatedByTypeIdToDelete = $this->getCvtermpathsRelatedByTypeId(new Criteria(), $con)->diff($cvtermpathsRelatedByTypeId);

        $this->cvtermpathsRelatedByTypeIdScheduledForDeletion = unserialize(serialize($cvtermpathsRelatedByTypeIdToDelete));

        foreach ($cvtermpathsRelatedByTypeIdToDelete as $cvtermpathRelatedByTypeIdRemoved) {
            $cvtermpathRelatedByTypeIdRemoved->setCvtermRelatedByTypeId(null);
        }

        $this->collCvtermpathsRelatedByTypeId = null;
        foreach ($cvtermpathsRelatedByTypeId as $cvtermpathRelatedByTypeId) {
            $this->addCvtermpathRelatedByTypeId($cvtermpathRelatedByTypeId);
        }

        $this->collCvtermpathsRelatedByTypeId = $cvtermpathsRelatedByTypeId;
        $this->collCvtermpathsRelatedByTypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermpath objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermpath objects.
     * @throws PropelException
     */
    public function countCvtermpathsRelatedByTypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpathsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermpathsRelatedByTypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpathsRelatedByTypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpathsRelatedByTypeId());
            }
            $query = CvtermpathQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByTypeId($this)
                ->count($con);
        }

        return count($this->collCvtermpathsRelatedByTypeId);
    }

    /**
     * Method called to associate a Cvtermpath object to this object
     * through the Cvtermpath foreign key attribute.
     *
     * @param    Cvtermpath $l Cvtermpath
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermpathRelatedByTypeId(Cvtermpath $l)
    {
        if ($this->collCvtermpathsRelatedByTypeId === null) {
            $this->initCvtermpathsRelatedByTypeId();
            $this->collCvtermpathsRelatedByTypeIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermpathsRelatedByTypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpathRelatedByTypeId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermpathRelatedByTypeId $cvtermpathRelatedByTypeId The cvtermpathRelatedByTypeId object to add.
     */
    protected function doAddCvtermpathRelatedByTypeId($cvtermpathRelatedByTypeId)
    {
        $this->collCvtermpathsRelatedByTypeId[]= $cvtermpathRelatedByTypeId;
        $cvtermpathRelatedByTypeId->setCvtermRelatedByTypeId($this);
    }

    /**
     * @param	CvtermpathRelatedByTypeId $cvtermpathRelatedByTypeId The cvtermpathRelatedByTypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermpathRelatedByTypeId($cvtermpathRelatedByTypeId)
    {
        if ($this->getCvtermpathsRelatedByTypeId()->contains($cvtermpathRelatedByTypeId)) {
            $this->collCvtermpathsRelatedByTypeId->remove($this->collCvtermpathsRelatedByTypeId->search($cvtermpathRelatedByTypeId));
            if (null === $this->cvtermpathsRelatedByTypeIdScheduledForDeletion) {
                $this->cvtermpathsRelatedByTypeIdScheduledForDeletion = clone $this->collCvtermpathsRelatedByTypeId;
                $this->cvtermpathsRelatedByTypeIdScheduledForDeletion->clear();
            }
            $this->cvtermpathsRelatedByTypeIdScheduledForDeletion[]= $cvtermpathRelatedByTypeId;
            $cvtermpathRelatedByTypeId->setCvtermRelatedByTypeId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related CvtermpathsRelatedByTypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvtermpath[] List of Cvtermpath objects
     */
    public function getCvtermpathsRelatedByTypeIdJoinCv($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermpathQuery::create(null, $criteria);
        $query->joinWith('Cv', $join_behavior);

        return $this->getCvtermpathsRelatedByTypeId($query, $con);
    }

    /**
     * Clears out the collCvtermpropsRelatedByCvtermId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermpropsRelatedByCvtermId()
     */
    public function clearCvtermpropsRelatedByCvtermId()
    {
        $this->collCvtermpropsRelatedByCvtermId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpropsRelatedByCvtermIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpropsRelatedByCvtermId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpropsRelatedByCvtermId($v = true)
    {
        $this->collCvtermpropsRelatedByCvtermIdPartial = $v;
    }

    /**
     * Initializes the collCvtermpropsRelatedByCvtermId collection.
     *
     * By default this just sets the collCvtermpropsRelatedByCvtermId collection to an empty array (like clearcollCvtermpropsRelatedByCvtermId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpropsRelatedByCvtermId($overrideExisting = true)
    {
        if (null !== $this->collCvtermpropsRelatedByCvtermId && !$overrideExisting) {
            return;
        }
        $this->collCvtermpropsRelatedByCvtermId = new PropelObjectCollection();
        $this->collCvtermpropsRelatedByCvtermId->setModel('Cvtermprop');
    }

    /**
     * Gets an array of Cvtermprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermprop[] List of Cvtermprop objects
     * @throws PropelException
     */
    public function getCvtermpropsRelatedByCvtermId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpropsRelatedByCvtermIdPartial && !$this->isNew();
        if (null === $this->collCvtermpropsRelatedByCvtermId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpropsRelatedByCvtermId) {
                // return empty collection
                $this->initCvtermpropsRelatedByCvtermId();
            } else {
                $collCvtermpropsRelatedByCvtermId = CvtermpropQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByCvtermId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpropsRelatedByCvtermIdPartial && count($collCvtermpropsRelatedByCvtermId)) {
                      $this->initCvtermpropsRelatedByCvtermId(false);

                      foreach($collCvtermpropsRelatedByCvtermId as $obj) {
                        if (false == $this->collCvtermpropsRelatedByCvtermId->contains($obj)) {
                          $this->collCvtermpropsRelatedByCvtermId->append($obj);
                        }
                      }

                      $this->collCvtermpropsRelatedByCvtermIdPartial = true;
                    }

                    $collCvtermpropsRelatedByCvtermId->getInternalIterator()->rewind();
                    return $collCvtermpropsRelatedByCvtermId;
                }

                if($partial && $this->collCvtermpropsRelatedByCvtermId) {
                    foreach($this->collCvtermpropsRelatedByCvtermId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpropsRelatedByCvtermId[] = $obj;
                        }
                    }
                }

                $this->collCvtermpropsRelatedByCvtermId = $collCvtermpropsRelatedByCvtermId;
                $this->collCvtermpropsRelatedByCvtermIdPartial = false;
            }
        }

        return $this->collCvtermpropsRelatedByCvtermId;
    }

    /**
     * Sets a collection of CvtermpropRelatedByCvtermId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpropsRelatedByCvtermId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermpropsRelatedByCvtermId(PropelCollection $cvtermpropsRelatedByCvtermId, PropelPDO $con = null)
    {
        $cvtermpropsRelatedByCvtermIdToDelete = $this->getCvtermpropsRelatedByCvtermId(new Criteria(), $con)->diff($cvtermpropsRelatedByCvtermId);

        $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion = unserialize(serialize($cvtermpropsRelatedByCvtermIdToDelete));

        foreach ($cvtermpropsRelatedByCvtermIdToDelete as $cvtermpropRelatedByCvtermIdRemoved) {
            $cvtermpropRelatedByCvtermIdRemoved->setCvtermRelatedByCvtermId(null);
        }

        $this->collCvtermpropsRelatedByCvtermId = null;
        foreach ($cvtermpropsRelatedByCvtermId as $cvtermpropRelatedByCvtermId) {
            $this->addCvtermpropRelatedByCvtermId($cvtermpropRelatedByCvtermId);
        }

        $this->collCvtermpropsRelatedByCvtermId = $cvtermpropsRelatedByCvtermId;
        $this->collCvtermpropsRelatedByCvtermIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermprop objects.
     * @throws PropelException
     */
    public function countCvtermpropsRelatedByCvtermId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpropsRelatedByCvtermIdPartial && !$this->isNew();
        if (null === $this->collCvtermpropsRelatedByCvtermId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpropsRelatedByCvtermId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpropsRelatedByCvtermId());
            }
            $query = CvtermpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByCvtermId($this)
                ->count($con);
        }

        return count($this->collCvtermpropsRelatedByCvtermId);
    }

    /**
     * Method called to associate a Cvtermprop object to this object
     * through the Cvtermprop foreign key attribute.
     *
     * @param    Cvtermprop $l Cvtermprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermpropRelatedByCvtermId(Cvtermprop $l)
    {
        if ($this->collCvtermpropsRelatedByCvtermId === null) {
            $this->initCvtermpropsRelatedByCvtermId();
            $this->collCvtermpropsRelatedByCvtermIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermpropsRelatedByCvtermId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpropRelatedByCvtermId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermpropRelatedByCvtermId $cvtermpropRelatedByCvtermId The cvtermpropRelatedByCvtermId object to add.
     */
    protected function doAddCvtermpropRelatedByCvtermId($cvtermpropRelatedByCvtermId)
    {
        $this->collCvtermpropsRelatedByCvtermId[]= $cvtermpropRelatedByCvtermId;
        $cvtermpropRelatedByCvtermId->setCvtermRelatedByCvtermId($this);
    }

    /**
     * @param	CvtermpropRelatedByCvtermId $cvtermpropRelatedByCvtermId The cvtermpropRelatedByCvtermId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermpropRelatedByCvtermId($cvtermpropRelatedByCvtermId)
    {
        if ($this->getCvtermpropsRelatedByCvtermId()->contains($cvtermpropRelatedByCvtermId)) {
            $this->collCvtermpropsRelatedByCvtermId->remove($this->collCvtermpropsRelatedByCvtermId->search($cvtermpropRelatedByCvtermId));
            if (null === $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion) {
                $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion = clone $this->collCvtermpropsRelatedByCvtermId;
                $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion->clear();
            }
            $this->cvtermpropsRelatedByCvtermIdScheduledForDeletion[]= clone $cvtermpropRelatedByCvtermId;
            $cvtermpropRelatedByCvtermId->setCvtermRelatedByCvtermId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermpropsRelatedByTypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermpropsRelatedByTypeId()
     */
    public function clearCvtermpropsRelatedByTypeId()
    {
        $this->collCvtermpropsRelatedByTypeId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermpropsRelatedByTypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermpropsRelatedByTypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermpropsRelatedByTypeId($v = true)
    {
        $this->collCvtermpropsRelatedByTypeIdPartial = $v;
    }

    /**
     * Initializes the collCvtermpropsRelatedByTypeId collection.
     *
     * By default this just sets the collCvtermpropsRelatedByTypeId collection to an empty array (like clearcollCvtermpropsRelatedByTypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermpropsRelatedByTypeId($overrideExisting = true)
    {
        if (null !== $this->collCvtermpropsRelatedByTypeId && !$overrideExisting) {
            return;
        }
        $this->collCvtermpropsRelatedByTypeId = new PropelObjectCollection();
        $this->collCvtermpropsRelatedByTypeId->setModel('Cvtermprop');
    }

    /**
     * Gets an array of Cvtermprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermprop[] List of Cvtermprop objects
     * @throws PropelException
     */
    public function getCvtermpropsRelatedByTypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpropsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermpropsRelatedByTypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermpropsRelatedByTypeId) {
                // return empty collection
                $this->initCvtermpropsRelatedByTypeId();
            } else {
                $collCvtermpropsRelatedByTypeId = CvtermpropQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByTypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermpropsRelatedByTypeIdPartial && count($collCvtermpropsRelatedByTypeId)) {
                      $this->initCvtermpropsRelatedByTypeId(false);

                      foreach($collCvtermpropsRelatedByTypeId as $obj) {
                        if (false == $this->collCvtermpropsRelatedByTypeId->contains($obj)) {
                          $this->collCvtermpropsRelatedByTypeId->append($obj);
                        }
                      }

                      $this->collCvtermpropsRelatedByTypeIdPartial = true;
                    }

                    $collCvtermpropsRelatedByTypeId->getInternalIterator()->rewind();
                    return $collCvtermpropsRelatedByTypeId;
                }

                if($partial && $this->collCvtermpropsRelatedByTypeId) {
                    foreach($this->collCvtermpropsRelatedByTypeId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermpropsRelatedByTypeId[] = $obj;
                        }
                    }
                }

                $this->collCvtermpropsRelatedByTypeId = $collCvtermpropsRelatedByTypeId;
                $this->collCvtermpropsRelatedByTypeIdPartial = false;
            }
        }

        return $this->collCvtermpropsRelatedByTypeId;
    }

    /**
     * Sets a collection of CvtermpropRelatedByTypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermpropsRelatedByTypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermpropsRelatedByTypeId(PropelCollection $cvtermpropsRelatedByTypeId, PropelPDO $con = null)
    {
        $cvtermpropsRelatedByTypeIdToDelete = $this->getCvtermpropsRelatedByTypeId(new Criteria(), $con)->diff($cvtermpropsRelatedByTypeId);

        $this->cvtermpropsRelatedByTypeIdScheduledForDeletion = unserialize(serialize($cvtermpropsRelatedByTypeIdToDelete));

        foreach ($cvtermpropsRelatedByTypeIdToDelete as $cvtermpropRelatedByTypeIdRemoved) {
            $cvtermpropRelatedByTypeIdRemoved->setCvtermRelatedByTypeId(null);
        }

        $this->collCvtermpropsRelatedByTypeId = null;
        foreach ($cvtermpropsRelatedByTypeId as $cvtermpropRelatedByTypeId) {
            $this->addCvtermpropRelatedByTypeId($cvtermpropRelatedByTypeId);
        }

        $this->collCvtermpropsRelatedByTypeId = $cvtermpropsRelatedByTypeId;
        $this->collCvtermpropsRelatedByTypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermprop objects.
     * @throws PropelException
     */
    public function countCvtermpropsRelatedByTypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermpropsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermpropsRelatedByTypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermpropsRelatedByTypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermpropsRelatedByTypeId());
            }
            $query = CvtermpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByTypeId($this)
                ->count($con);
        }

        return count($this->collCvtermpropsRelatedByTypeId);
    }

    /**
     * Method called to associate a Cvtermprop object to this object
     * through the Cvtermprop foreign key attribute.
     *
     * @param    Cvtermprop $l Cvtermprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermpropRelatedByTypeId(Cvtermprop $l)
    {
        if ($this->collCvtermpropsRelatedByTypeId === null) {
            $this->initCvtermpropsRelatedByTypeId();
            $this->collCvtermpropsRelatedByTypeIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermpropsRelatedByTypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermpropRelatedByTypeId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermpropRelatedByTypeId $cvtermpropRelatedByTypeId The cvtermpropRelatedByTypeId object to add.
     */
    protected function doAddCvtermpropRelatedByTypeId($cvtermpropRelatedByTypeId)
    {
        $this->collCvtermpropsRelatedByTypeId[]= $cvtermpropRelatedByTypeId;
        $cvtermpropRelatedByTypeId->setCvtermRelatedByTypeId($this);
    }

    /**
     * @param	CvtermpropRelatedByTypeId $cvtermpropRelatedByTypeId The cvtermpropRelatedByTypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermpropRelatedByTypeId($cvtermpropRelatedByTypeId)
    {
        if ($this->getCvtermpropsRelatedByTypeId()->contains($cvtermpropRelatedByTypeId)) {
            $this->collCvtermpropsRelatedByTypeId->remove($this->collCvtermpropsRelatedByTypeId->search($cvtermpropRelatedByTypeId));
            if (null === $this->cvtermpropsRelatedByTypeIdScheduledForDeletion) {
                $this->cvtermpropsRelatedByTypeIdScheduledForDeletion = clone $this->collCvtermpropsRelatedByTypeId;
                $this->cvtermpropsRelatedByTypeIdScheduledForDeletion->clear();
            }
            $this->cvtermpropsRelatedByTypeIdScheduledForDeletion[]= clone $cvtermpropRelatedByTypeId;
            $cvtermpropRelatedByTypeId->setCvtermRelatedByTypeId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermsynonymsRelatedByCvtermId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermsynonymsRelatedByCvtermId()
     */
    public function clearCvtermsynonymsRelatedByCvtermId()
    {
        $this->collCvtermsynonymsRelatedByCvtermId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermsynonymsRelatedByCvtermIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermsynonymsRelatedByCvtermId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermsynonymsRelatedByCvtermId($v = true)
    {
        $this->collCvtermsynonymsRelatedByCvtermIdPartial = $v;
    }

    /**
     * Initializes the collCvtermsynonymsRelatedByCvtermId collection.
     *
     * By default this just sets the collCvtermsynonymsRelatedByCvtermId collection to an empty array (like clearcollCvtermsynonymsRelatedByCvtermId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermsynonymsRelatedByCvtermId($overrideExisting = true)
    {
        if (null !== $this->collCvtermsynonymsRelatedByCvtermId && !$overrideExisting) {
            return;
        }
        $this->collCvtermsynonymsRelatedByCvtermId = new PropelObjectCollection();
        $this->collCvtermsynonymsRelatedByCvtermId->setModel('Cvtermsynonym');
    }

    /**
     * Gets an array of Cvtermsynonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermsynonym[] List of Cvtermsynonym objects
     * @throws PropelException
     */
    public function getCvtermsynonymsRelatedByCvtermId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsynonymsRelatedByCvtermIdPartial && !$this->isNew();
        if (null === $this->collCvtermsynonymsRelatedByCvtermId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermsynonymsRelatedByCvtermId) {
                // return empty collection
                $this->initCvtermsynonymsRelatedByCvtermId();
            } else {
                $collCvtermsynonymsRelatedByCvtermId = CvtermsynonymQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByCvtermId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermsynonymsRelatedByCvtermIdPartial && count($collCvtermsynonymsRelatedByCvtermId)) {
                      $this->initCvtermsynonymsRelatedByCvtermId(false);

                      foreach($collCvtermsynonymsRelatedByCvtermId as $obj) {
                        if (false == $this->collCvtermsynonymsRelatedByCvtermId->contains($obj)) {
                          $this->collCvtermsynonymsRelatedByCvtermId->append($obj);
                        }
                      }

                      $this->collCvtermsynonymsRelatedByCvtermIdPartial = true;
                    }

                    $collCvtermsynonymsRelatedByCvtermId->getInternalIterator()->rewind();
                    return $collCvtermsynonymsRelatedByCvtermId;
                }

                if($partial && $this->collCvtermsynonymsRelatedByCvtermId) {
                    foreach($this->collCvtermsynonymsRelatedByCvtermId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermsynonymsRelatedByCvtermId[] = $obj;
                        }
                    }
                }

                $this->collCvtermsynonymsRelatedByCvtermId = $collCvtermsynonymsRelatedByCvtermId;
                $this->collCvtermsynonymsRelatedByCvtermIdPartial = false;
            }
        }

        return $this->collCvtermsynonymsRelatedByCvtermId;
    }

    /**
     * Sets a collection of CvtermsynonymRelatedByCvtermId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermsynonymsRelatedByCvtermId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermsynonymsRelatedByCvtermId(PropelCollection $cvtermsynonymsRelatedByCvtermId, PropelPDO $con = null)
    {
        $cvtermsynonymsRelatedByCvtermIdToDelete = $this->getCvtermsynonymsRelatedByCvtermId(new Criteria(), $con)->diff($cvtermsynonymsRelatedByCvtermId);

        $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion = unserialize(serialize($cvtermsynonymsRelatedByCvtermIdToDelete));

        foreach ($cvtermsynonymsRelatedByCvtermIdToDelete as $cvtermsynonymRelatedByCvtermIdRemoved) {
            $cvtermsynonymRelatedByCvtermIdRemoved->setCvtermRelatedByCvtermId(null);
        }

        $this->collCvtermsynonymsRelatedByCvtermId = null;
        foreach ($cvtermsynonymsRelatedByCvtermId as $cvtermsynonymRelatedByCvtermId) {
            $this->addCvtermsynonymRelatedByCvtermId($cvtermsynonymRelatedByCvtermId);
        }

        $this->collCvtermsynonymsRelatedByCvtermId = $cvtermsynonymsRelatedByCvtermId;
        $this->collCvtermsynonymsRelatedByCvtermIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermsynonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermsynonym objects.
     * @throws PropelException
     */
    public function countCvtermsynonymsRelatedByCvtermId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsynonymsRelatedByCvtermIdPartial && !$this->isNew();
        if (null === $this->collCvtermsynonymsRelatedByCvtermId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermsynonymsRelatedByCvtermId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermsynonymsRelatedByCvtermId());
            }
            $query = CvtermsynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByCvtermId($this)
                ->count($con);
        }

        return count($this->collCvtermsynonymsRelatedByCvtermId);
    }

    /**
     * Method called to associate a Cvtermsynonym object to this object
     * through the Cvtermsynonym foreign key attribute.
     *
     * @param    Cvtermsynonym $l Cvtermsynonym
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermsynonymRelatedByCvtermId(Cvtermsynonym $l)
    {
        if ($this->collCvtermsynonymsRelatedByCvtermId === null) {
            $this->initCvtermsynonymsRelatedByCvtermId();
            $this->collCvtermsynonymsRelatedByCvtermIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermsynonymsRelatedByCvtermId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermsynonymRelatedByCvtermId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermsynonymRelatedByCvtermId $cvtermsynonymRelatedByCvtermId The cvtermsynonymRelatedByCvtermId object to add.
     */
    protected function doAddCvtermsynonymRelatedByCvtermId($cvtermsynonymRelatedByCvtermId)
    {
        $this->collCvtermsynonymsRelatedByCvtermId[]= $cvtermsynonymRelatedByCvtermId;
        $cvtermsynonymRelatedByCvtermId->setCvtermRelatedByCvtermId($this);
    }

    /**
     * @param	CvtermsynonymRelatedByCvtermId $cvtermsynonymRelatedByCvtermId The cvtermsynonymRelatedByCvtermId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermsynonymRelatedByCvtermId($cvtermsynonymRelatedByCvtermId)
    {
        if ($this->getCvtermsynonymsRelatedByCvtermId()->contains($cvtermsynonymRelatedByCvtermId)) {
            $this->collCvtermsynonymsRelatedByCvtermId->remove($this->collCvtermsynonymsRelatedByCvtermId->search($cvtermsynonymRelatedByCvtermId));
            if (null === $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion) {
                $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion = clone $this->collCvtermsynonymsRelatedByCvtermId;
                $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion->clear();
            }
            $this->cvtermsynonymsRelatedByCvtermIdScheduledForDeletion[]= clone $cvtermsynonymRelatedByCvtermId;
            $cvtermsynonymRelatedByCvtermId->setCvtermRelatedByCvtermId(null);
        }

        return $this;
    }

    /**
     * Clears out the collCvtermsynonymsRelatedByTypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addCvtermsynonymsRelatedByTypeId()
     */
    public function clearCvtermsynonymsRelatedByTypeId()
    {
        $this->collCvtermsynonymsRelatedByTypeId = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermsynonymsRelatedByTypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermsynonymsRelatedByTypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermsynonymsRelatedByTypeId($v = true)
    {
        $this->collCvtermsynonymsRelatedByTypeIdPartial = $v;
    }

    /**
     * Initializes the collCvtermsynonymsRelatedByTypeId collection.
     *
     * By default this just sets the collCvtermsynonymsRelatedByTypeId collection to an empty array (like clearcollCvtermsynonymsRelatedByTypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermsynonymsRelatedByTypeId($overrideExisting = true)
    {
        if (null !== $this->collCvtermsynonymsRelatedByTypeId && !$overrideExisting) {
            return;
        }
        $this->collCvtermsynonymsRelatedByTypeId = new PropelObjectCollection();
        $this->collCvtermsynonymsRelatedByTypeId->setModel('Cvtermsynonym');
    }

    /**
     * Gets an array of Cvtermsynonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvtermsynonym[] List of Cvtermsynonym objects
     * @throws PropelException
     */
    public function getCvtermsynonymsRelatedByTypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsynonymsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermsynonymsRelatedByTypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermsynonymsRelatedByTypeId) {
                // return empty collection
                $this->initCvtermsynonymsRelatedByTypeId();
            } else {
                $collCvtermsynonymsRelatedByTypeId = CvtermsynonymQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByTypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermsynonymsRelatedByTypeIdPartial && count($collCvtermsynonymsRelatedByTypeId)) {
                      $this->initCvtermsynonymsRelatedByTypeId(false);

                      foreach($collCvtermsynonymsRelatedByTypeId as $obj) {
                        if (false == $this->collCvtermsynonymsRelatedByTypeId->contains($obj)) {
                          $this->collCvtermsynonymsRelatedByTypeId->append($obj);
                        }
                      }

                      $this->collCvtermsynonymsRelatedByTypeIdPartial = true;
                    }

                    $collCvtermsynonymsRelatedByTypeId->getInternalIterator()->rewind();
                    return $collCvtermsynonymsRelatedByTypeId;
                }

                if($partial && $this->collCvtermsynonymsRelatedByTypeId) {
                    foreach($this->collCvtermsynonymsRelatedByTypeId as $obj) {
                        if($obj->isNew()) {
                            $collCvtermsynonymsRelatedByTypeId[] = $obj;
                        }
                    }
                }

                $this->collCvtermsynonymsRelatedByTypeId = $collCvtermsynonymsRelatedByTypeId;
                $this->collCvtermsynonymsRelatedByTypeIdPartial = false;
            }
        }

        return $this->collCvtermsynonymsRelatedByTypeId;
    }

    /**
     * Sets a collection of CvtermsynonymRelatedByTypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermsynonymsRelatedByTypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermsynonymsRelatedByTypeId(PropelCollection $cvtermsynonymsRelatedByTypeId, PropelPDO $con = null)
    {
        $cvtermsynonymsRelatedByTypeIdToDelete = $this->getCvtermsynonymsRelatedByTypeId(new Criteria(), $con)->diff($cvtermsynonymsRelatedByTypeId);

        $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion = unserialize(serialize($cvtermsynonymsRelatedByTypeIdToDelete));

        foreach ($cvtermsynonymsRelatedByTypeIdToDelete as $cvtermsynonymRelatedByTypeIdRemoved) {
            $cvtermsynonymRelatedByTypeIdRemoved->setCvtermRelatedByTypeId(null);
        }

        $this->collCvtermsynonymsRelatedByTypeId = null;
        foreach ($cvtermsynonymsRelatedByTypeId as $cvtermsynonymRelatedByTypeId) {
            $this->addCvtermsynonymRelatedByTypeId($cvtermsynonymRelatedByTypeId);
        }

        $this->collCvtermsynonymsRelatedByTypeId = $cvtermsynonymsRelatedByTypeId;
        $this->collCvtermsynonymsRelatedByTypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvtermsynonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvtermsynonym objects.
     * @throws PropelException
     */
    public function countCvtermsynonymsRelatedByTypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsynonymsRelatedByTypeIdPartial && !$this->isNew();
        if (null === $this->collCvtermsynonymsRelatedByTypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermsynonymsRelatedByTypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermsynonymsRelatedByTypeId());
            }
            $query = CvtermsynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByTypeId($this)
                ->count($con);
        }

        return count($this->collCvtermsynonymsRelatedByTypeId);
    }

    /**
     * Method called to associate a Cvtermsynonym object to this object
     * through the Cvtermsynonym foreign key attribute.
     *
     * @param    Cvtermsynonym $l Cvtermsynonym
     * @return Cvterm The current object (for fluent API support)
     */
    public function addCvtermsynonymRelatedByTypeId(Cvtermsynonym $l)
    {
        if ($this->collCvtermsynonymsRelatedByTypeId === null) {
            $this->initCvtermsynonymsRelatedByTypeId();
            $this->collCvtermsynonymsRelatedByTypeIdPartial = true;
        }
        if (!in_array($l, $this->collCvtermsynonymsRelatedByTypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermsynonymRelatedByTypeId($l);
        }

        return $this;
    }

    /**
     * @param	CvtermsynonymRelatedByTypeId $cvtermsynonymRelatedByTypeId The cvtermsynonymRelatedByTypeId object to add.
     */
    protected function doAddCvtermsynonymRelatedByTypeId($cvtermsynonymRelatedByTypeId)
    {
        $this->collCvtermsynonymsRelatedByTypeId[]= $cvtermsynonymRelatedByTypeId;
        $cvtermsynonymRelatedByTypeId->setCvtermRelatedByTypeId($this);
    }

    /**
     * @param	CvtermsynonymRelatedByTypeId $cvtermsynonymRelatedByTypeId The cvtermsynonymRelatedByTypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeCvtermsynonymRelatedByTypeId($cvtermsynonymRelatedByTypeId)
    {
        if ($this->getCvtermsynonymsRelatedByTypeId()->contains($cvtermsynonymRelatedByTypeId)) {
            $this->collCvtermsynonymsRelatedByTypeId->remove($this->collCvtermsynonymsRelatedByTypeId->search($cvtermsynonymRelatedByTypeId));
            if (null === $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion) {
                $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion = clone $this->collCvtermsynonymsRelatedByTypeId;
                $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion->clear();
            }
            $this->cvtermsynonymsRelatedByTypeIdScheduledForDeletion[]= $cvtermsynonymRelatedByTypeId;
            $cvtermsynonymRelatedByTypeId->setCvtermRelatedByTypeId(null);
        }

        return $this;
    }

    /**
     * Clears out the collDbxrefprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addDbxrefprops()
     */
    public function clearDbxrefprops()
    {
        $this->collDbxrefprops = null; // important to set this to null since that means it is uninitialized
        $this->collDbxrefpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collDbxrefprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialDbxrefprops($v = true)
    {
        $this->collDbxrefpropsPartial = $v;
    }

    /**
     * Initializes the collDbxrefprops collection.
     *
     * By default this just sets the collDbxrefprops collection to an empty array (like clearcollDbxrefprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDbxrefprops($overrideExisting = true)
    {
        if (null !== $this->collDbxrefprops && !$overrideExisting) {
            return;
        }
        $this->collDbxrefprops = new PropelObjectCollection();
        $this->collDbxrefprops->setModel('Dbxrefprop');
    }

    /**
     * Gets an array of Dbxrefprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Dbxrefprop[] List of Dbxrefprop objects
     * @throws PropelException
     */
    public function getDbxrefprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collDbxrefpropsPartial && !$this->isNew();
        if (null === $this->collDbxrefprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDbxrefprops) {
                // return empty collection
                $this->initDbxrefprops();
            } else {
                $collDbxrefprops = DbxrefpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collDbxrefpropsPartial && count($collDbxrefprops)) {
                      $this->initDbxrefprops(false);

                      foreach($collDbxrefprops as $obj) {
                        if (false == $this->collDbxrefprops->contains($obj)) {
                          $this->collDbxrefprops->append($obj);
                        }
                      }

                      $this->collDbxrefpropsPartial = true;
                    }

                    $collDbxrefprops->getInternalIterator()->rewind();
                    return $collDbxrefprops;
                }

                if($partial && $this->collDbxrefprops) {
                    foreach($this->collDbxrefprops as $obj) {
                        if($obj->isNew()) {
                            $collDbxrefprops[] = $obj;
                        }
                    }
                }

                $this->collDbxrefprops = $collDbxrefprops;
                $this->collDbxrefpropsPartial = false;
            }
        }

        return $this->collDbxrefprops;
    }

    /**
     * Sets a collection of Dbxrefprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $dbxrefprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setDbxrefprops(PropelCollection $dbxrefprops, PropelPDO $con = null)
    {
        $dbxrefpropsToDelete = $this->getDbxrefprops(new Criteria(), $con)->diff($dbxrefprops);

        $this->dbxrefpropsScheduledForDeletion = unserialize(serialize($dbxrefpropsToDelete));

        foreach ($dbxrefpropsToDelete as $dbxrefpropRemoved) {
            $dbxrefpropRemoved->setCvterm(null);
        }

        $this->collDbxrefprops = null;
        foreach ($dbxrefprops as $dbxrefprop) {
            $this->addDbxrefprop($dbxrefprop);
        }

        $this->collDbxrefprops = $dbxrefprops;
        $this->collDbxrefpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Dbxrefprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Dbxrefprop objects.
     * @throws PropelException
     */
    public function countDbxrefprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collDbxrefpropsPartial && !$this->isNew();
        if (null === $this->collDbxrefprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDbxrefprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getDbxrefprops());
            }
            $query = DbxrefpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collDbxrefprops);
    }

    /**
     * Method called to associate a Dbxrefprop object to this object
     * through the Dbxrefprop foreign key attribute.
     *
     * @param    Dbxrefprop $l Dbxrefprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addDbxrefprop(Dbxrefprop $l)
    {
        if ($this->collDbxrefprops === null) {
            $this->initDbxrefprops();
            $this->collDbxrefpropsPartial = true;
        }
        if (!in_array($l, $this->collDbxrefprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddDbxrefprop($l);
        }

        return $this;
    }

    /**
     * @param	Dbxrefprop $dbxrefprop The dbxrefprop object to add.
     */
    protected function doAddDbxrefprop($dbxrefprop)
    {
        $this->collDbxrefprops[]= $dbxrefprop;
        $dbxrefprop->setCvterm($this);
    }

    /**
     * @param	Dbxrefprop $dbxrefprop The dbxrefprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeDbxrefprop($dbxrefprop)
    {
        if ($this->getDbxrefprops()->contains($dbxrefprop)) {
            $this->collDbxrefprops->remove($this->collDbxrefprops->search($dbxrefprop));
            if (null === $this->dbxrefpropsScheduledForDeletion) {
                $this->dbxrefpropsScheduledForDeletion = clone $this->collDbxrefprops;
                $this->dbxrefpropsScheduledForDeletion->clear();
            }
            $this->dbxrefpropsScheduledForDeletion[]= clone $dbxrefprop;
            $dbxrefprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Dbxrefprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Dbxrefprop[] List of Dbxrefprop objects
     */
    public function getDbxrefpropsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DbxrefpropQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getDbxrefprops($query, $con);
    }

    /**
     * Clears out the collElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addElements()
     */
    public function clearElements()
    {
        $this->collElements = null; // important to set this to null since that means it is uninitialized
        $this->collElementsPartial = null;

        return $this;
    }

    /**
     * reset is the collElements collection loaded partially
     *
     * @return void
     */
    public function resetPartialElements($v = true)
    {
        $this->collElementsPartial = $v;
    }

    /**
     * Initializes the collElements collection.
     *
     * By default this just sets the collElements collection to an empty array (like clearcollElements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElements($overrideExisting = true)
    {
        if (null !== $this->collElements && !$overrideExisting) {
            return;
        }
        $this->collElements = new PropelObjectCollection();
        $this->collElements->setModel('Element');
    }

    /**
     * Gets an array of Element objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Element[] List of Element objects
     * @throws PropelException
     */
    public function getElements($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                // return empty collection
                $this->initElements();
            } else {
                $collElements = ElementQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementsPartial && count($collElements)) {
                      $this->initElements(false);

                      foreach($collElements as $obj) {
                        if (false == $this->collElements->contains($obj)) {
                          $this->collElements->append($obj);
                        }
                      }

                      $this->collElementsPartial = true;
                    }

                    $collElements->getInternalIterator()->rewind();
                    return $collElements;
                }

                if($partial && $this->collElements) {
                    foreach($this->collElements as $obj) {
                        if($obj->isNew()) {
                            $collElements[] = $obj;
                        }
                    }
                }

                $this->collElements = $collElements;
                $this->collElementsPartial = false;
            }
        }

        return $this->collElements;
    }

    /**
     * Sets a collection of Element objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elements A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setElements(PropelCollection $elements, PropelPDO $con = null)
    {
        $elementsToDelete = $this->getElements(new Criteria(), $con)->diff($elements);

        $this->elementsScheduledForDeletion = unserialize(serialize($elementsToDelete));

        foreach ($elementsToDelete as $elementRemoved) {
            $elementRemoved->setCvterm(null);
        }

        $this->collElements = null;
        foreach ($elements as $element) {
            $this->addElement($element);
        }

        $this->collElements = $elements;
        $this->collElementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Element objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Element objects.
     * @throws PropelException
     */
    public function countElements(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElements());
            }
            $query = ElementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collElements);
    }

    /**
     * Method called to associate a Element object to this object
     * through the Element foreign key attribute.
     *
     * @param    Element $l Element
     * @return Cvterm The current object (for fluent API support)
     */
    public function addElement(Element $l)
    {
        if ($this->collElements === null) {
            $this->initElements();
            $this->collElementsPartial = true;
        }
        if (!in_array($l, $this->collElements->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElement($l);
        }

        return $this;
    }

    /**
     * @param	Element $element The element object to add.
     */
    protected function doAddElement($element)
    {
        $this->collElements[]= $element;
        $element->setCvterm($this);
    }

    /**
     * @param	Element $element The element object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeElement($element)
    {
        if ($this->getElements()->contains($element)) {
            $this->collElements->remove($this->collElements->search($element));
            if (null === $this->elementsScheduledForDeletion) {
                $this->elementsScheduledForDeletion = clone $this->collElements;
                $this->elementsScheduledForDeletion->clear();
            }
            $this->elementsScheduledForDeletion[]= $element;
            $element->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinArraydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Arraydesign', $join_behavior);

        return $this->getElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getElements($query, $con);
    }

    /**
     * Clears out the collElementRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addElementRelationships()
     */
    public function clearElementRelationships()
    {
        $this->collElementRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collElementRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collElementRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementRelationships($v = true)
    {
        $this->collElementRelationshipsPartial = $v;
    }

    /**
     * Initializes the collElementRelationships collection.
     *
     * By default this just sets the collElementRelationships collection to an empty array (like clearcollElementRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementRelationships($overrideExisting = true)
    {
        if (null !== $this->collElementRelationships && !$overrideExisting) {
            return;
        }
        $this->collElementRelationships = new PropelObjectCollection();
        $this->collElementRelationships->setModel('ElementRelationship');
    }

    /**
     * Gets an array of ElementRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     * @throws PropelException
     */
    public function getElementRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsPartial && !$this->isNew();
        if (null === $this->collElementRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementRelationships) {
                // return empty collection
                $this->initElementRelationships();
            } else {
                $collElementRelationships = ElementRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementRelationshipsPartial && count($collElementRelationships)) {
                      $this->initElementRelationships(false);

                      foreach($collElementRelationships as $obj) {
                        if (false == $this->collElementRelationships->contains($obj)) {
                          $this->collElementRelationships->append($obj);
                        }
                      }

                      $this->collElementRelationshipsPartial = true;
                    }

                    $collElementRelationships->getInternalIterator()->rewind();
                    return $collElementRelationships;
                }

                if($partial && $this->collElementRelationships) {
                    foreach($this->collElementRelationships as $obj) {
                        if($obj->isNew()) {
                            $collElementRelationships[] = $obj;
                        }
                    }
                }

                $this->collElementRelationships = $collElementRelationships;
                $this->collElementRelationshipsPartial = false;
            }
        }

        return $this->collElementRelationships;
    }

    /**
     * Sets a collection of ElementRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setElementRelationships(PropelCollection $elementRelationships, PropelPDO $con = null)
    {
        $elementRelationshipsToDelete = $this->getElementRelationships(new Criteria(), $con)->diff($elementRelationships);

        $this->elementRelationshipsScheduledForDeletion = unserialize(serialize($elementRelationshipsToDelete));

        foreach ($elementRelationshipsToDelete as $elementRelationshipRemoved) {
            $elementRelationshipRemoved->setCvterm(null);
        }

        $this->collElementRelationships = null;
        foreach ($elementRelationships as $elementRelationship) {
            $this->addElementRelationship($elementRelationship);
        }

        $this->collElementRelationships = $elementRelationships;
        $this->collElementRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementRelationship objects.
     * @throws PropelException
     */
    public function countElementRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsPartial && !$this->isNew();
        if (null === $this->collElementRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementRelationships());
            }
            $query = ElementRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collElementRelationships);
    }

    /**
     * Method called to associate a ElementRelationship object to this object
     * through the ElementRelationship foreign key attribute.
     *
     * @param    ElementRelationship $l ElementRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addElementRelationship(ElementRelationship $l)
    {
        if ($this->collElementRelationships === null) {
            $this->initElementRelationships();
            $this->collElementRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collElementRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementRelationship($l);
        }

        return $this;
    }

    /**
     * @param	ElementRelationship $elementRelationship The elementRelationship object to add.
     */
    protected function doAddElementRelationship($elementRelationship)
    {
        $this->collElementRelationships[]= $elementRelationship;
        $elementRelationship->setCvterm($this);
    }

    /**
     * @param	ElementRelationship $elementRelationship The elementRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeElementRelationship($elementRelationship)
    {
        if ($this->getElementRelationships()->contains($elementRelationship)) {
            $this->collElementRelationships->remove($this->collElementRelationships->search($elementRelationship));
            if (null === $this->elementRelationshipsScheduledForDeletion) {
                $this->elementRelationshipsScheduledForDeletion = clone $this->collElementRelationships;
                $this->elementRelationshipsScheduledForDeletion->clear();
            }
            $this->elementRelationshipsScheduledForDeletion[]= clone $elementRelationship;
            $elementRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ElementRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     */
    public function getElementRelationshipsJoinElementRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementRelationshipQuery::create(null, $criteria);
        $query->joinWith('ElementRelatedByObjectId', $join_behavior);

        return $this->getElementRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ElementRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     */
    public function getElementRelationshipsJoinElementRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementRelationshipQuery::create(null, $criteria);
        $query->joinWith('ElementRelatedBySubjectId', $join_behavior);

        return $this->getElementRelationships($query, $con);
    }

    /**
     * Clears out the collElementresultRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addElementresultRelationships()
     */
    public function clearElementresultRelationships()
    {
        $this->collElementresultRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collElementresultRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collElementresultRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementresultRelationships($v = true)
    {
        $this->collElementresultRelationshipsPartial = $v;
    }

    /**
     * Initializes the collElementresultRelationships collection.
     *
     * By default this just sets the collElementresultRelationships collection to an empty array (like clearcollElementresultRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementresultRelationships($overrideExisting = true)
    {
        if (null !== $this->collElementresultRelationships && !$overrideExisting) {
            return;
        }
        $this->collElementresultRelationships = new PropelObjectCollection();
        $this->collElementresultRelationships->setModel('ElementresultRelationship');
    }

    /**
     * Gets an array of ElementresultRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     * @throws PropelException
     */
    public function getElementresultRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsPartial && !$this->isNew();
        if (null === $this->collElementresultRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationships) {
                // return empty collection
                $this->initElementresultRelationships();
            } else {
                $collElementresultRelationships = ElementresultRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementresultRelationshipsPartial && count($collElementresultRelationships)) {
                      $this->initElementresultRelationships(false);

                      foreach($collElementresultRelationships as $obj) {
                        if (false == $this->collElementresultRelationships->contains($obj)) {
                          $this->collElementresultRelationships->append($obj);
                        }
                      }

                      $this->collElementresultRelationshipsPartial = true;
                    }

                    $collElementresultRelationships->getInternalIterator()->rewind();
                    return $collElementresultRelationships;
                }

                if($partial && $this->collElementresultRelationships) {
                    foreach($this->collElementresultRelationships as $obj) {
                        if($obj->isNew()) {
                            $collElementresultRelationships[] = $obj;
                        }
                    }
                }

                $this->collElementresultRelationships = $collElementresultRelationships;
                $this->collElementresultRelationshipsPartial = false;
            }
        }

        return $this->collElementresultRelationships;
    }

    /**
     * Sets a collection of ElementresultRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementresultRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setElementresultRelationships(PropelCollection $elementresultRelationships, PropelPDO $con = null)
    {
        $elementresultRelationshipsToDelete = $this->getElementresultRelationships(new Criteria(), $con)->diff($elementresultRelationships);

        $this->elementresultRelationshipsScheduledForDeletion = unserialize(serialize($elementresultRelationshipsToDelete));

        foreach ($elementresultRelationshipsToDelete as $elementresultRelationshipRemoved) {
            $elementresultRelationshipRemoved->setCvterm(null);
        }

        $this->collElementresultRelationships = null;
        foreach ($elementresultRelationships as $elementresultRelationship) {
            $this->addElementresultRelationship($elementresultRelationship);
        }

        $this->collElementresultRelationships = $elementresultRelationships;
        $this->collElementresultRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementresultRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementresultRelationship objects.
     * @throws PropelException
     */
    public function countElementresultRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsPartial && !$this->isNew();
        if (null === $this->collElementresultRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementresultRelationships());
            }
            $query = ElementresultRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collElementresultRelationships);
    }

    /**
     * Method called to associate a ElementresultRelationship object to this object
     * through the ElementresultRelationship foreign key attribute.
     *
     * @param    ElementresultRelationship $l ElementresultRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addElementresultRelationship(ElementresultRelationship $l)
    {
        if ($this->collElementresultRelationships === null) {
            $this->initElementresultRelationships();
            $this->collElementresultRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collElementresultRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementresultRelationship($l);
        }

        return $this;
    }

    /**
     * @param	ElementresultRelationship $elementresultRelationship The elementresultRelationship object to add.
     */
    protected function doAddElementresultRelationship($elementresultRelationship)
    {
        $this->collElementresultRelationships[]= $elementresultRelationship;
        $elementresultRelationship->setCvterm($this);
    }

    /**
     * @param	ElementresultRelationship $elementresultRelationship The elementresultRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeElementresultRelationship($elementresultRelationship)
    {
        if ($this->getElementresultRelationships()->contains($elementresultRelationship)) {
            $this->collElementresultRelationships->remove($this->collElementresultRelationships->search($elementresultRelationship));
            if (null === $this->elementresultRelationshipsScheduledForDeletion) {
                $this->elementresultRelationshipsScheduledForDeletion = clone $this->collElementresultRelationships;
                $this->elementresultRelationshipsScheduledForDeletion->clear();
            }
            $this->elementresultRelationshipsScheduledForDeletion[]= clone $elementresultRelationship;
            $elementresultRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ElementresultRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     */
    public function getElementresultRelationshipsJoinElementresultRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultRelationshipQuery::create(null, $criteria);
        $query->joinWith('ElementresultRelatedByObjectId', $join_behavior);

        return $this->getElementresultRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ElementresultRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     */
    public function getElementresultRelationshipsJoinElementresultRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultRelationshipQuery::create(null, $criteria);
        $query->joinWith('ElementresultRelatedBySubjectId', $join_behavior);

        return $this->getElementresultRelationships($query, $con);
    }

    /**
     * Clears out the collFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatures()
     */
    public function clearFeatures()
    {
        $this->collFeatures = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturesPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatures collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatures($v = true)
    {
        $this->collFeaturesPartial = $v;
    }

    /**
     * Initializes the collFeatures collection.
     *
     * By default this just sets the collFeatures collection to an empty array (like clearcollFeatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatures($overrideExisting = true)
    {
        if (null !== $this->collFeatures && !$overrideExisting) {
            return;
        }
        $this->collFeatures = new PropelObjectCollection();
        $this->collFeatures->setModel('Feature');
    }

    /**
     * Gets an array of Feature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Feature[] List of Feature objects
     * @throws PropelException
     */
    public function getFeatures($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturesPartial && !$this->isNew();
        if (null === $this->collFeatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatures) {
                // return empty collection
                $this->initFeatures();
            } else {
                $collFeatures = FeatureQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturesPartial && count($collFeatures)) {
                      $this->initFeatures(false);

                      foreach($collFeatures as $obj) {
                        if (false == $this->collFeatures->contains($obj)) {
                          $this->collFeatures->append($obj);
                        }
                      }

                      $this->collFeaturesPartial = true;
                    }

                    $collFeatures->getInternalIterator()->rewind();
                    return $collFeatures;
                }

                if($partial && $this->collFeatures) {
                    foreach($this->collFeatures as $obj) {
                        if($obj->isNew()) {
                            $collFeatures[] = $obj;
                        }
                    }
                }

                $this->collFeatures = $collFeatures;
                $this->collFeaturesPartial = false;
            }
        }

        return $this->collFeatures;
    }

    /**
     * Sets a collection of Feature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $features A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatures(PropelCollection $features, PropelPDO $con = null)
    {
        $featuresToDelete = $this->getFeatures(new Criteria(), $con)->diff($features);

        $this->featuresScheduledForDeletion = unserialize(serialize($featuresToDelete));

        foreach ($featuresToDelete as $featureRemoved) {
            $featureRemoved->setCvterm(null);
        }

        $this->collFeatures = null;
        foreach ($features as $feature) {
            $this->addFeature($feature);
        }

        $this->collFeatures = $features;
        $this->collFeaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Feature objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Feature objects.
     * @throws PropelException
     */
    public function countFeatures(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturesPartial && !$this->isNew();
        if (null === $this->collFeatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatures) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatures());
            }
            $query = FeatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatures);
    }

    /**
     * Method called to associate a Feature object to this object
     * through the Feature foreign key attribute.
     *
     * @param    Feature $l Feature
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeature(Feature $l)
    {
        if ($this->collFeatures === null) {
            $this->initFeatures();
            $this->collFeaturesPartial = true;
        }
        if (!in_array($l, $this->collFeatures->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeature($l);
        }

        return $this;
    }

    /**
     * @param	Feature $feature The feature object to add.
     */
    protected function doAddFeature($feature)
    {
        $this->collFeatures[]= $feature;
        $feature->setCvterm($this);
    }

    /**
     * @param	Feature $feature The feature object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeature($feature)
    {
        if ($this->getFeatures()->contains($feature)) {
            $this->collFeatures->remove($this->collFeatures->search($feature));
            if (null === $this->featuresScheduledForDeletion) {
                $this->featuresScheduledForDeletion = clone $this->collFeatures;
                $this->featuresScheduledForDeletion->clear();
            }
            $this->featuresScheduledForDeletion[]= clone $feature;
            $feature->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getFeatures($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getFeatures($query, $con);
    }

    /**
     * Clears out the collFeatureCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureCvterms()
     */
    public function clearFeatureCvterms()
    {
        $this->collFeatureCvterms = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvterms collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvterms($v = true)
    {
        $this->collFeatureCvtermsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvterms collection.
     *
     * By default this just sets the collFeatureCvterms collection to an empty array (like clearcollFeatureCvterms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvterms($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvterms && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvterms = new PropelObjectCollection();
        $this->collFeatureCvterms->setModel('FeatureCvterm');
    }

    /**
     * Gets an array of FeatureCvterm objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     * @throws PropelException
     */
    public function getFeatureCvterms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermsPartial && !$this->isNew();
        if (null === $this->collFeatureCvterms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvterms) {
                // return empty collection
                $this->initFeatureCvterms();
            } else {
                $collFeatureCvterms = FeatureCvtermQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermsPartial && count($collFeatureCvterms)) {
                      $this->initFeatureCvterms(false);

                      foreach($collFeatureCvterms as $obj) {
                        if (false == $this->collFeatureCvterms->contains($obj)) {
                          $this->collFeatureCvterms->append($obj);
                        }
                      }

                      $this->collFeatureCvtermsPartial = true;
                    }

                    $collFeatureCvterms->getInternalIterator()->rewind();
                    return $collFeatureCvterms;
                }

                if($partial && $this->collFeatureCvterms) {
                    foreach($this->collFeatureCvterms as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvterms[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvterms = $collFeatureCvterms;
                $this->collFeatureCvtermsPartial = false;
            }
        }

        return $this->collFeatureCvterms;
    }

    /**
     * Sets a collection of FeatureCvterm objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvterms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureCvterms(PropelCollection $featureCvterms, PropelPDO $con = null)
    {
        $featureCvtermsToDelete = $this->getFeatureCvterms(new Criteria(), $con)->diff($featureCvterms);

        $this->featureCvtermsScheduledForDeletion = unserialize(serialize($featureCvtermsToDelete));

        foreach ($featureCvtermsToDelete as $featureCvtermRemoved) {
            $featureCvtermRemoved->setCvterm(null);
        }

        $this->collFeatureCvterms = null;
        foreach ($featureCvterms as $featureCvterm) {
            $this->addFeatureCvterm($featureCvterm);
        }

        $this->collFeatureCvterms = $featureCvterms;
        $this->collFeatureCvtermsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvterm objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvterm objects.
     * @throws PropelException
     */
    public function countFeatureCvterms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermsPartial && !$this->isNew();
        if (null === $this->collFeatureCvterms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvterms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvterms());
            }
            $query = FeatureCvtermQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvterms);
    }

    /**
     * Method called to associate a FeatureCvterm object to this object
     * through the FeatureCvterm foreign key attribute.
     *
     * @param    FeatureCvterm $l FeatureCvterm
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureCvterm(FeatureCvterm $l)
    {
        if ($this->collFeatureCvterms === null) {
            $this->initFeatureCvterms();
            $this->collFeatureCvtermsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvterms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvterm($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to add.
     */
    protected function doAddFeatureCvterm($featureCvterm)
    {
        $this->collFeatureCvterms[]= $featureCvterm;
        $featureCvterm->setCvterm($this);
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureCvterm($featureCvterm)
    {
        if ($this->getFeatureCvterms()->contains($featureCvterm)) {
            $this->collFeatureCvterms->remove($this->collFeatureCvterms->search($featureCvterm));
            if (null === $this->featureCvtermsScheduledForDeletion) {
                $this->featureCvtermsScheduledForDeletion = clone $this->collFeatureCvterms;
                $this->featureCvtermsScheduledForDeletion->clear();
            }
            $this->featureCvtermsScheduledForDeletion[]= clone $featureCvterm;
            $featureCvterm->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }

    /**
     * Clears out the collFeatureCvtermprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureCvtermprops()
     */
    public function clearFeatureCvtermprops()
    {
        $this->collFeatureCvtermprops = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermprops($v = true)
    {
        $this->collFeatureCvtermpropsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermprops collection.
     *
     * By default this just sets the collFeatureCvtermprops collection to an empty array (like clearcollFeatureCvtermprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermprops($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermprops && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermprops = new PropelObjectCollection();
        $this->collFeatureCvtermprops->setModel('FeatureCvtermprop');
    }

    /**
     * Gets an array of FeatureCvtermprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermprop[] List of FeatureCvtermprop objects
     * @throws PropelException
     */
    public function getFeatureCvtermprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermpropsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermprops) {
                // return empty collection
                $this->initFeatureCvtermprops();
            } else {
                $collFeatureCvtermprops = FeatureCvtermpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermpropsPartial && count($collFeatureCvtermprops)) {
                      $this->initFeatureCvtermprops(false);

                      foreach($collFeatureCvtermprops as $obj) {
                        if (false == $this->collFeatureCvtermprops->contains($obj)) {
                          $this->collFeatureCvtermprops->append($obj);
                        }
                      }

                      $this->collFeatureCvtermpropsPartial = true;
                    }

                    $collFeatureCvtermprops->getInternalIterator()->rewind();
                    return $collFeatureCvtermprops;
                }

                if($partial && $this->collFeatureCvtermprops) {
                    foreach($this->collFeatureCvtermprops as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermprops[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermprops = $collFeatureCvtermprops;
                $this->collFeatureCvtermpropsPartial = false;
            }
        }

        return $this->collFeatureCvtermprops;
    }

    /**
     * Sets a collection of FeatureCvtermprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermprops(PropelCollection $featureCvtermprops, PropelPDO $con = null)
    {
        $featureCvtermpropsToDelete = $this->getFeatureCvtermprops(new Criteria(), $con)->diff($featureCvtermprops);

        $this->featureCvtermpropsScheduledForDeletion = unserialize(serialize($featureCvtermpropsToDelete));

        foreach ($featureCvtermpropsToDelete as $featureCvtermpropRemoved) {
            $featureCvtermpropRemoved->setCvterm(null);
        }

        $this->collFeatureCvtermprops = null;
        foreach ($featureCvtermprops as $featureCvtermprop) {
            $this->addFeatureCvtermprop($featureCvtermprop);
        }

        $this->collFeatureCvtermprops = $featureCvtermprops;
        $this->collFeatureCvtermpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermprop objects.
     * @throws PropelException
     */
    public function countFeatureCvtermprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermpropsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermprops());
            }
            $query = FeatureCvtermpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermprops);
    }

    /**
     * Method called to associate a FeatureCvtermprop object to this object
     * through the FeatureCvtermprop foreign key attribute.
     *
     * @param    FeatureCvtermprop $l FeatureCvtermprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureCvtermprop(FeatureCvtermprop $l)
    {
        if ($this->collFeatureCvtermprops === null) {
            $this->initFeatureCvtermprops();
            $this->collFeatureCvtermpropsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermprop($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermprop $featureCvtermprop The featureCvtermprop object to add.
     */
    protected function doAddFeatureCvtermprop($featureCvtermprop)
    {
        $this->collFeatureCvtermprops[]= $featureCvtermprop;
        $featureCvtermprop->setCvterm($this);
    }

    /**
     * @param	FeatureCvtermprop $featureCvtermprop The featureCvtermprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureCvtermprop($featureCvtermprop)
    {
        if ($this->getFeatureCvtermprops()->contains($featureCvtermprop)) {
            $this->collFeatureCvtermprops->remove($this->collFeatureCvtermprops->search($featureCvtermprop));
            if (null === $this->featureCvtermpropsScheduledForDeletion) {
                $this->featureCvtermpropsScheduledForDeletion = clone $this->collFeatureCvtermprops;
                $this->featureCvtermpropsScheduledForDeletion->clear();
            }
            $this->featureCvtermpropsScheduledForDeletion[]= clone $featureCvtermprop;
            $featureCvtermprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvtermprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermprop[] List of FeatureCvtermprop objects
     */
    public function getFeatureCvtermpropsJoinFeatureCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermpropQuery::create(null, $criteria);
        $query->joinWith('FeatureCvterm', $join_behavior);

        return $this->getFeatureCvtermprops($query, $con);
    }

    /**
     * Clears out the collFeaturePubprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeaturePubprops()
     */
    public function clearFeaturePubprops()
    {
        $this->collFeaturePubprops = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturePubpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturePubprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturePubprops($v = true)
    {
        $this->collFeaturePubpropsPartial = $v;
    }

    /**
     * Initializes the collFeaturePubprops collection.
     *
     * By default this just sets the collFeaturePubprops collection to an empty array (like clearcollFeaturePubprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturePubprops($overrideExisting = true)
    {
        if (null !== $this->collFeaturePubprops && !$overrideExisting) {
            return;
        }
        $this->collFeaturePubprops = new PropelObjectCollection();
        $this->collFeaturePubprops->setModel('FeaturePubprop');
    }

    /**
     * Gets an array of FeaturePubprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeaturePubprop[] List of FeaturePubprop objects
     * @throws PropelException
     */
    public function getFeaturePubprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubpropsPartial && !$this->isNew();
        if (null === $this->collFeaturePubprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubprops) {
                // return empty collection
                $this->initFeaturePubprops();
            } else {
                $collFeaturePubprops = FeaturePubpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturePubpropsPartial && count($collFeaturePubprops)) {
                      $this->initFeaturePubprops(false);

                      foreach($collFeaturePubprops as $obj) {
                        if (false == $this->collFeaturePubprops->contains($obj)) {
                          $this->collFeaturePubprops->append($obj);
                        }
                      }

                      $this->collFeaturePubpropsPartial = true;
                    }

                    $collFeaturePubprops->getInternalIterator()->rewind();
                    return $collFeaturePubprops;
                }

                if($partial && $this->collFeaturePubprops) {
                    foreach($this->collFeaturePubprops as $obj) {
                        if($obj->isNew()) {
                            $collFeaturePubprops[] = $obj;
                        }
                    }
                }

                $this->collFeaturePubprops = $collFeaturePubprops;
                $this->collFeaturePubpropsPartial = false;
            }
        }

        return $this->collFeaturePubprops;
    }

    /**
     * Sets a collection of FeaturePubprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurePubprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeaturePubprops(PropelCollection $featurePubprops, PropelPDO $con = null)
    {
        $featurePubpropsToDelete = $this->getFeaturePubprops(new Criteria(), $con)->diff($featurePubprops);

        $this->featurePubpropsScheduledForDeletion = unserialize(serialize($featurePubpropsToDelete));

        foreach ($featurePubpropsToDelete as $featurePubpropRemoved) {
            $featurePubpropRemoved->setCvterm(null);
        }

        $this->collFeaturePubprops = null;
        foreach ($featurePubprops as $featurePubprop) {
            $this->addFeaturePubprop($featurePubprop);
        }

        $this->collFeaturePubprops = $featurePubprops;
        $this->collFeaturePubpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeaturePubprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeaturePubprop objects.
     * @throws PropelException
     */
    public function countFeaturePubprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubpropsPartial && !$this->isNew();
        if (null === $this->collFeaturePubprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturePubprops());
            }
            $query = FeaturePubpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeaturePubprops);
    }

    /**
     * Method called to associate a FeaturePubprop object to this object
     * through the FeaturePubprop foreign key attribute.
     *
     * @param    FeaturePubprop $l FeaturePubprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeaturePubprop(FeaturePubprop $l)
    {
        if ($this->collFeaturePubprops === null) {
            $this->initFeaturePubprops();
            $this->collFeaturePubpropsPartial = true;
        }
        if (!in_array($l, $this->collFeaturePubprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturePubprop($l);
        }

        return $this;
    }

    /**
     * @param	FeaturePubprop $featurePubprop The featurePubprop object to add.
     */
    protected function doAddFeaturePubprop($featurePubprop)
    {
        $this->collFeaturePubprops[]= $featurePubprop;
        $featurePubprop->setCvterm($this);
    }

    /**
     * @param	FeaturePubprop $featurePubprop The featurePubprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeaturePubprop($featurePubprop)
    {
        if ($this->getFeaturePubprops()->contains($featurePubprop)) {
            $this->collFeaturePubprops->remove($this->collFeaturePubprops->search($featurePubprop));
            if (null === $this->featurePubpropsScheduledForDeletion) {
                $this->featurePubpropsScheduledForDeletion = clone $this->collFeaturePubprops;
                $this->featurePubpropsScheduledForDeletion->clear();
            }
            $this->featurePubpropsScheduledForDeletion[]= clone $featurePubprop;
            $featurePubprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeaturePubprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeaturePubprop[] List of FeaturePubprop objects
     */
    public function getFeaturePubpropsJoinFeaturePub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturePubpropQuery::create(null, $criteria);
        $query->joinWith('FeaturePub', $join_behavior);

        return $this->getFeaturePubprops($query, $con);
    }

    /**
     * Clears out the collFeatureRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureRelationships()
     */
    public function clearFeatureRelationships()
    {
        $this->collFeatureRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureRelationships($v = true)
    {
        $this->collFeatureRelationshipsPartial = $v;
    }

    /**
     * Initializes the collFeatureRelationships collection.
     *
     * By default this just sets the collFeatureRelationships collection to an empty array (like clearcollFeatureRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureRelationships($overrideExisting = true)
    {
        if (null !== $this->collFeatureRelationships && !$overrideExisting) {
            return;
        }
        $this->collFeatureRelationships = new PropelObjectCollection();
        $this->collFeatureRelationships->setModel('FeatureRelationship');
    }

    /**
     * Gets an array of FeatureRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     * @throws PropelException
     */
    public function getFeatureRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsPartial && !$this->isNew();
        if (null === $this->collFeatureRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationships) {
                // return empty collection
                $this->initFeatureRelationships();
            } else {
                $collFeatureRelationships = FeatureRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureRelationshipsPartial && count($collFeatureRelationships)) {
                      $this->initFeatureRelationships(false);

                      foreach($collFeatureRelationships as $obj) {
                        if (false == $this->collFeatureRelationships->contains($obj)) {
                          $this->collFeatureRelationships->append($obj);
                        }
                      }

                      $this->collFeatureRelationshipsPartial = true;
                    }

                    $collFeatureRelationships->getInternalIterator()->rewind();
                    return $collFeatureRelationships;
                }

                if($partial && $this->collFeatureRelationships) {
                    foreach($this->collFeatureRelationships as $obj) {
                        if($obj->isNew()) {
                            $collFeatureRelationships[] = $obj;
                        }
                    }
                }

                $this->collFeatureRelationships = $collFeatureRelationships;
                $this->collFeatureRelationshipsPartial = false;
            }
        }

        return $this->collFeatureRelationships;
    }

    /**
     * Sets a collection of FeatureRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureRelationships(PropelCollection $featureRelationships, PropelPDO $con = null)
    {
        $featureRelationshipsToDelete = $this->getFeatureRelationships(new Criteria(), $con)->diff($featureRelationships);

        $this->featureRelationshipsScheduledForDeletion = unserialize(serialize($featureRelationshipsToDelete));

        foreach ($featureRelationshipsToDelete as $featureRelationshipRemoved) {
            $featureRelationshipRemoved->setCvterm(null);
        }

        $this->collFeatureRelationships = null;
        foreach ($featureRelationships as $featureRelationship) {
            $this->addFeatureRelationship($featureRelationship);
        }

        $this->collFeatureRelationships = $featureRelationships;
        $this->collFeatureRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureRelationship objects.
     * @throws PropelException
     */
    public function countFeatureRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsPartial && !$this->isNew();
        if (null === $this->collFeatureRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureRelationships());
            }
            $query = FeatureRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureRelationships);
    }

    /**
     * Method called to associate a FeatureRelationship object to this object
     * through the FeatureRelationship foreign key attribute.
     *
     * @param    FeatureRelationship $l FeatureRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureRelationship(FeatureRelationship $l)
    {
        if ($this->collFeatureRelationships === null) {
            $this->initFeatureRelationships();
            $this->collFeatureRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collFeatureRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureRelationship($l);
        }

        return $this;
    }

    /**
     * @param	FeatureRelationship $featureRelationship The featureRelationship object to add.
     */
    protected function doAddFeatureRelationship($featureRelationship)
    {
        $this->collFeatureRelationships[]= $featureRelationship;
        $featureRelationship->setCvterm($this);
    }

    /**
     * @param	FeatureRelationship $featureRelationship The featureRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureRelationship($featureRelationship)
    {
        if ($this->getFeatureRelationships()->contains($featureRelationship)) {
            $this->collFeatureRelationships->remove($this->collFeatureRelationships->search($featureRelationship));
            if (null === $this->featureRelationshipsScheduledForDeletion) {
                $this->featureRelationshipsScheduledForDeletion = clone $this->collFeatureRelationships;
                $this->featureRelationshipsScheduledForDeletion->clear();
            }
            $this->featureRelationshipsScheduledForDeletion[]= clone $featureRelationship;
            $featureRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     */
    public function getFeatureRelationshipsJoinFeatureRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureRelationshipQuery::create(null, $criteria);
        $query->joinWith('FeatureRelatedByObjectId', $join_behavior);

        return $this->getFeatureRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     */
    public function getFeatureRelationshipsJoinFeatureRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureRelationshipQuery::create(null, $criteria);
        $query->joinWith('FeatureRelatedBySubjectId', $join_behavior);

        return $this->getFeatureRelationships($query, $con);
    }

    /**
     * Clears out the collFeatureRelationshipprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureRelationshipprops()
     */
    public function clearFeatureRelationshipprops()
    {
        $this->collFeatureRelationshipprops = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureRelationshippropsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureRelationshipprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureRelationshipprops($v = true)
    {
        $this->collFeatureRelationshippropsPartial = $v;
    }

    /**
     * Initializes the collFeatureRelationshipprops collection.
     *
     * By default this just sets the collFeatureRelationshipprops collection to an empty array (like clearcollFeatureRelationshipprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureRelationshipprops($overrideExisting = true)
    {
        if (null !== $this->collFeatureRelationshipprops && !$overrideExisting) {
            return;
        }
        $this->collFeatureRelationshipprops = new PropelObjectCollection();
        $this->collFeatureRelationshipprops->setModel('FeatureRelationshipprop');
    }

    /**
     * Gets an array of FeatureRelationshipprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureRelationshipprop[] List of FeatureRelationshipprop objects
     * @throws PropelException
     */
    public function getFeatureRelationshipprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshippropsPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipprops) {
                // return empty collection
                $this->initFeatureRelationshipprops();
            } else {
                $collFeatureRelationshipprops = FeatureRelationshippropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureRelationshippropsPartial && count($collFeatureRelationshipprops)) {
                      $this->initFeatureRelationshipprops(false);

                      foreach($collFeatureRelationshipprops as $obj) {
                        if (false == $this->collFeatureRelationshipprops->contains($obj)) {
                          $this->collFeatureRelationshipprops->append($obj);
                        }
                      }

                      $this->collFeatureRelationshippropsPartial = true;
                    }

                    $collFeatureRelationshipprops->getInternalIterator()->rewind();
                    return $collFeatureRelationshipprops;
                }

                if($partial && $this->collFeatureRelationshipprops) {
                    foreach($this->collFeatureRelationshipprops as $obj) {
                        if($obj->isNew()) {
                            $collFeatureRelationshipprops[] = $obj;
                        }
                    }
                }

                $this->collFeatureRelationshipprops = $collFeatureRelationshipprops;
                $this->collFeatureRelationshippropsPartial = false;
            }
        }

        return $this->collFeatureRelationshipprops;
    }

    /**
     * Sets a collection of FeatureRelationshipprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureRelationshipprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureRelationshipprops(PropelCollection $featureRelationshipprops, PropelPDO $con = null)
    {
        $featureRelationshippropsToDelete = $this->getFeatureRelationshipprops(new Criteria(), $con)->diff($featureRelationshipprops);

        $this->featureRelationshippropsScheduledForDeletion = unserialize(serialize($featureRelationshippropsToDelete));

        foreach ($featureRelationshippropsToDelete as $featureRelationshippropRemoved) {
            $featureRelationshippropRemoved->setCvterm(null);
        }

        $this->collFeatureRelationshipprops = null;
        foreach ($featureRelationshipprops as $featureRelationshipprop) {
            $this->addFeatureRelationshipprop($featureRelationshipprop);
        }

        $this->collFeatureRelationshipprops = $featureRelationshipprops;
        $this->collFeatureRelationshippropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureRelationshipprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureRelationshipprop objects.
     * @throws PropelException
     */
    public function countFeatureRelationshipprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshippropsPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureRelationshipprops());
            }
            $query = FeatureRelationshippropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureRelationshipprops);
    }

    /**
     * Method called to associate a FeatureRelationshipprop object to this object
     * through the FeatureRelationshipprop foreign key attribute.
     *
     * @param    FeatureRelationshipprop $l FeatureRelationshipprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureRelationshipprop(FeatureRelationshipprop $l)
    {
        if ($this->collFeatureRelationshipprops === null) {
            $this->initFeatureRelationshipprops();
            $this->collFeatureRelationshippropsPartial = true;
        }
        if (!in_array($l, $this->collFeatureRelationshipprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureRelationshipprop($l);
        }

        return $this;
    }

    /**
     * @param	FeatureRelationshipprop $featureRelationshipprop The featureRelationshipprop object to add.
     */
    protected function doAddFeatureRelationshipprop($featureRelationshipprop)
    {
        $this->collFeatureRelationshipprops[]= $featureRelationshipprop;
        $featureRelationshipprop->setCvterm($this);
    }

    /**
     * @param	FeatureRelationshipprop $featureRelationshipprop The featureRelationshipprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureRelationshipprop($featureRelationshipprop)
    {
        if ($this->getFeatureRelationshipprops()->contains($featureRelationshipprop)) {
            $this->collFeatureRelationshipprops->remove($this->collFeatureRelationshipprops->search($featureRelationshipprop));
            if (null === $this->featureRelationshippropsScheduledForDeletion) {
                $this->featureRelationshippropsScheduledForDeletion = clone $this->collFeatureRelationshipprops;
                $this->featureRelationshippropsScheduledForDeletion->clear();
            }
            $this->featureRelationshippropsScheduledForDeletion[]= clone $featureRelationshipprop;
            $featureRelationshipprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureRelationshipprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureRelationshipprop[] List of FeatureRelationshipprop objects
     */
    public function getFeatureRelationshippropsJoinFeatureRelationship($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureRelationshippropQuery::create(null, $criteria);
        $query->joinWith('FeatureRelationship', $join_behavior);

        return $this->getFeatureRelationshipprops($query, $con);
    }

    /**
     * Clears out the collFeatureprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureprops()
     */
    public function clearFeatureprops()
    {
        $this->collFeatureprops = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturepropsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureprops($v = true)
    {
        $this->collFeaturepropsPartial = $v;
    }

    /**
     * Initializes the collFeatureprops collection.
     *
     * By default this just sets the collFeatureprops collection to an empty array (like clearcollFeatureprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureprops($overrideExisting = true)
    {
        if (null !== $this->collFeatureprops && !$overrideExisting) {
            return;
        }
        $this->collFeatureprops = new PropelObjectCollection();
        $this->collFeatureprops->setModel('Featureprop');
    }

    /**
     * Gets an array of Featureprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Featureprop[] List of Featureprop objects
     * @throws PropelException
     */
    public function getFeatureprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturepropsPartial && !$this->isNew();
        if (null === $this->collFeatureprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureprops) {
                // return empty collection
                $this->initFeatureprops();
            } else {
                $collFeatureprops = FeaturepropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturepropsPartial && count($collFeatureprops)) {
                      $this->initFeatureprops(false);

                      foreach($collFeatureprops as $obj) {
                        if (false == $this->collFeatureprops->contains($obj)) {
                          $this->collFeatureprops->append($obj);
                        }
                      }

                      $this->collFeaturepropsPartial = true;
                    }

                    $collFeatureprops->getInternalIterator()->rewind();
                    return $collFeatureprops;
                }

                if($partial && $this->collFeatureprops) {
                    foreach($this->collFeatureprops as $obj) {
                        if($obj->isNew()) {
                            $collFeatureprops[] = $obj;
                        }
                    }
                }

                $this->collFeatureprops = $collFeatureprops;
                $this->collFeaturepropsPartial = false;
            }
        }

        return $this->collFeatureprops;
    }

    /**
     * Sets a collection of Featureprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureprops(PropelCollection $featureprops, PropelPDO $con = null)
    {
        $featurepropsToDelete = $this->getFeatureprops(new Criteria(), $con)->diff($featureprops);

        $this->featurepropsScheduledForDeletion = unserialize(serialize($featurepropsToDelete));

        foreach ($featurepropsToDelete as $featurepropRemoved) {
            $featurepropRemoved->setCvterm(null);
        }

        $this->collFeatureprops = null;
        foreach ($featureprops as $featureprop) {
            $this->addFeatureprop($featureprop);
        }

        $this->collFeatureprops = $featureprops;
        $this->collFeaturepropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Featureprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Featureprop objects.
     * @throws PropelException
     */
    public function countFeatureprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturepropsPartial && !$this->isNew();
        if (null === $this->collFeatureprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureprops());
            }
            $query = FeaturepropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureprops);
    }

    /**
     * Method called to associate a Featureprop object to this object
     * through the Featureprop foreign key attribute.
     *
     * @param    Featureprop $l Featureprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureprop(Featureprop $l)
    {
        if ($this->collFeatureprops === null) {
            $this->initFeatureprops();
            $this->collFeaturepropsPartial = true;
        }
        if (!in_array($l, $this->collFeatureprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureprop($l);
        }

        return $this;
    }

    /**
     * @param	Featureprop $featureprop The featureprop object to add.
     */
    protected function doAddFeatureprop($featureprop)
    {
        $this->collFeatureprops[]= $featureprop;
        $featureprop->setCvterm($this);
    }

    /**
     * @param	Featureprop $featureprop The featureprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureprop($featureprop)
    {
        if ($this->getFeatureprops()->contains($featureprop)) {
            $this->collFeatureprops->remove($this->collFeatureprops->search($featureprop));
            if (null === $this->featurepropsScheduledForDeletion) {
                $this->featurepropsScheduledForDeletion = clone $this->collFeatureprops;
                $this->featurepropsScheduledForDeletion->clear();
            }
            $this->featurepropsScheduledForDeletion[]= clone $featureprop;
            $featureprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Featureprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Featureprop[] List of Featureprop objects
     */
    public function getFeaturepropsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturepropQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureprops($query, $con);
    }

    /**
     * Clears out the collOrganismprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addOrganismprops()
     */
    public function clearOrganismprops()
    {
        $this->collOrganismprops = null; // important to set this to null since that means it is uninitialized
        $this->collOrganismpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collOrganismprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialOrganismprops($v = true)
    {
        $this->collOrganismpropsPartial = $v;
    }

    /**
     * Initializes the collOrganismprops collection.
     *
     * By default this just sets the collOrganismprops collection to an empty array (like clearcollOrganismprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrganismprops($overrideExisting = true)
    {
        if (null !== $this->collOrganismprops && !$overrideExisting) {
            return;
        }
        $this->collOrganismprops = new PropelObjectCollection();
        $this->collOrganismprops->setModel('Organismprop');
    }

    /**
     * Gets an array of Organismprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Organismprop[] List of Organismprop objects
     * @throws PropelException
     */
    public function getOrganismprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collOrganismpropsPartial && !$this->isNew();
        if (null === $this->collOrganismprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrganismprops) {
                // return empty collection
                $this->initOrganismprops();
            } else {
                $collOrganismprops = OrganismpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collOrganismpropsPartial && count($collOrganismprops)) {
                      $this->initOrganismprops(false);

                      foreach($collOrganismprops as $obj) {
                        if (false == $this->collOrganismprops->contains($obj)) {
                          $this->collOrganismprops->append($obj);
                        }
                      }

                      $this->collOrganismpropsPartial = true;
                    }

                    $collOrganismprops->getInternalIterator()->rewind();
                    return $collOrganismprops;
                }

                if($partial && $this->collOrganismprops) {
                    foreach($this->collOrganismprops as $obj) {
                        if($obj->isNew()) {
                            $collOrganismprops[] = $obj;
                        }
                    }
                }

                $this->collOrganismprops = $collOrganismprops;
                $this->collOrganismpropsPartial = false;
            }
        }

        return $this->collOrganismprops;
    }

    /**
     * Sets a collection of Organismprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $organismprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setOrganismprops(PropelCollection $organismprops, PropelPDO $con = null)
    {
        $organismpropsToDelete = $this->getOrganismprops(new Criteria(), $con)->diff($organismprops);

        $this->organismpropsScheduledForDeletion = unserialize(serialize($organismpropsToDelete));

        foreach ($organismpropsToDelete as $organismpropRemoved) {
            $organismpropRemoved->setCvterm(null);
        }

        $this->collOrganismprops = null;
        foreach ($organismprops as $organismprop) {
            $this->addOrganismprop($organismprop);
        }

        $this->collOrganismprops = $organismprops;
        $this->collOrganismpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Organismprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Organismprop objects.
     * @throws PropelException
     */
    public function countOrganismprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collOrganismpropsPartial && !$this->isNew();
        if (null === $this->collOrganismprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrganismprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getOrganismprops());
            }
            $query = OrganismpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collOrganismprops);
    }

    /**
     * Method called to associate a Organismprop object to this object
     * through the Organismprop foreign key attribute.
     *
     * @param    Organismprop $l Organismprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addOrganismprop(Organismprop $l)
    {
        if ($this->collOrganismprops === null) {
            $this->initOrganismprops();
            $this->collOrganismpropsPartial = true;
        }
        if (!in_array($l, $this->collOrganismprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrganismprop($l);
        }

        return $this;
    }

    /**
     * @param	Organismprop $organismprop The organismprop object to add.
     */
    protected function doAddOrganismprop($organismprop)
    {
        $this->collOrganismprops[]= $organismprop;
        $organismprop->setCvterm($this);
    }

    /**
     * @param	Organismprop $organismprop The organismprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeOrganismprop($organismprop)
    {
        if ($this->getOrganismprops()->contains($organismprop)) {
            $this->collOrganismprops->remove($this->collOrganismprops->search($organismprop));
            if (null === $this->organismpropsScheduledForDeletion) {
                $this->organismpropsScheduledForDeletion = clone $this->collOrganismprops;
                $this->organismpropsScheduledForDeletion->clear();
            }
            $this->organismpropsScheduledForDeletion[]= clone $organismprop;
            $organismprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Organismprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Organismprop[] List of Organismprop objects
     */
    public function getOrganismpropsJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = OrganismpropQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getOrganismprops($query, $con);
    }

    /**
     * Clears out the collProjectRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addProjectRelationships()
     */
    public function clearProjectRelationships()
    {
        $this->collProjectRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collProjectRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectRelationships($v = true)
    {
        $this->collProjectRelationshipsPartial = $v;
    }

    /**
     * Initializes the collProjectRelationships collection.
     *
     * By default this just sets the collProjectRelationships collection to an empty array (like clearcollProjectRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectRelationships($overrideExisting = true)
    {
        if (null !== $this->collProjectRelationships && !$overrideExisting) {
            return;
        }
        $this->collProjectRelationships = new PropelObjectCollection();
        $this->collProjectRelationships->setModel('ProjectRelationship');
    }

    /**
     * Gets an array of ProjectRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     * @throws PropelException
     */
    public function getProjectRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsPartial && !$this->isNew();
        if (null === $this->collProjectRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationships) {
                // return empty collection
                $this->initProjectRelationships();
            } else {
                $collProjectRelationships = ProjectRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectRelationshipsPartial && count($collProjectRelationships)) {
                      $this->initProjectRelationships(false);

                      foreach($collProjectRelationships as $obj) {
                        if (false == $this->collProjectRelationships->contains($obj)) {
                          $this->collProjectRelationships->append($obj);
                        }
                      }

                      $this->collProjectRelationshipsPartial = true;
                    }

                    $collProjectRelationships->getInternalIterator()->rewind();
                    return $collProjectRelationships;
                }

                if($partial && $this->collProjectRelationships) {
                    foreach($this->collProjectRelationships as $obj) {
                        if($obj->isNew()) {
                            $collProjectRelationships[] = $obj;
                        }
                    }
                }

                $this->collProjectRelationships = $collProjectRelationships;
                $this->collProjectRelationshipsPartial = false;
            }
        }

        return $this->collProjectRelationships;
    }

    /**
     * Sets a collection of ProjectRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProjectRelationships(PropelCollection $projectRelationships, PropelPDO $con = null)
    {
        $projectRelationshipsToDelete = $this->getProjectRelationships(new Criteria(), $con)->diff($projectRelationships);

        $this->projectRelationshipsScheduledForDeletion = unserialize(serialize($projectRelationshipsToDelete));

        foreach ($projectRelationshipsToDelete as $projectRelationshipRemoved) {
            $projectRelationshipRemoved->setCvterm(null);
        }

        $this->collProjectRelationships = null;
        foreach ($projectRelationships as $projectRelationship) {
            $this->addProjectRelationship($projectRelationship);
        }

        $this->collProjectRelationships = $projectRelationships;
        $this->collProjectRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectRelationship objects.
     * @throws PropelException
     */
    public function countProjectRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsPartial && !$this->isNew();
        if (null === $this->collProjectRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectRelationships());
            }
            $query = ProjectRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collProjectRelationships);
    }

    /**
     * Method called to associate a ProjectRelationship object to this object
     * through the ProjectRelationship foreign key attribute.
     *
     * @param    ProjectRelationship $l ProjectRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addProjectRelationship(ProjectRelationship $l)
    {
        if ($this->collProjectRelationships === null) {
            $this->initProjectRelationships();
            $this->collProjectRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collProjectRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectRelationship($l);
        }

        return $this;
    }

    /**
     * @param	ProjectRelationship $projectRelationship The projectRelationship object to add.
     */
    protected function doAddProjectRelationship($projectRelationship)
    {
        $this->collProjectRelationships[]= $projectRelationship;
        $projectRelationship->setCvterm($this);
    }

    /**
     * @param	ProjectRelationship $projectRelationship The projectRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProjectRelationship($projectRelationship)
    {
        if ($this->getProjectRelationships()->contains($projectRelationship)) {
            $this->collProjectRelationships->remove($this->collProjectRelationships->search($projectRelationship));
            if (null === $this->projectRelationshipsScheduledForDeletion) {
                $this->projectRelationshipsScheduledForDeletion = clone $this->collProjectRelationships;
                $this->projectRelationshipsScheduledForDeletion->clear();
            }
            $this->projectRelationshipsScheduledForDeletion[]= clone $projectRelationship;
            $projectRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ProjectRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     */
    public function getProjectRelationshipsJoinProjectRelatedByObjectProjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectRelationshipQuery::create(null, $criteria);
        $query->joinWith('ProjectRelatedByObjectProjectId', $join_behavior);

        return $this->getProjectRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ProjectRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     */
    public function getProjectRelationshipsJoinProjectRelatedBySubjectProjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectRelationshipQuery::create(null, $criteria);
        $query->joinWith('ProjectRelatedBySubjectProjectId', $join_behavior);

        return $this->getProjectRelationships($query, $con);
    }

    /**
     * Clears out the collProjectprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addProjectprops()
     */
    public function clearProjectprops()
    {
        $this->collProjectprops = null; // important to set this to null since that means it is uninitialized
        $this->collProjectpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectprops($v = true)
    {
        $this->collProjectpropsPartial = $v;
    }

    /**
     * Initializes the collProjectprops collection.
     *
     * By default this just sets the collProjectprops collection to an empty array (like clearcollProjectprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectprops($overrideExisting = true)
    {
        if (null !== $this->collProjectprops && !$overrideExisting) {
            return;
        }
        $this->collProjectprops = new PropelObjectCollection();
        $this->collProjectprops->setModel('Projectprop');
    }

    /**
     * Gets an array of Projectprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectprop[] List of Projectprop objects
     * @throws PropelException
     */
    public function getProjectprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectpropsPartial && !$this->isNew();
        if (null === $this->collProjectprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectprops) {
                // return empty collection
                $this->initProjectprops();
            } else {
                $collProjectprops = ProjectpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectpropsPartial && count($collProjectprops)) {
                      $this->initProjectprops(false);

                      foreach($collProjectprops as $obj) {
                        if (false == $this->collProjectprops->contains($obj)) {
                          $this->collProjectprops->append($obj);
                        }
                      }

                      $this->collProjectpropsPartial = true;
                    }

                    $collProjectprops->getInternalIterator()->rewind();
                    return $collProjectprops;
                }

                if($partial && $this->collProjectprops) {
                    foreach($this->collProjectprops as $obj) {
                        if($obj->isNew()) {
                            $collProjectprops[] = $obj;
                        }
                    }
                }

                $this->collProjectprops = $collProjectprops;
                $this->collProjectpropsPartial = false;
            }
        }

        return $this->collProjectprops;
    }

    /**
     * Sets a collection of Projectprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProjectprops(PropelCollection $projectprops, PropelPDO $con = null)
    {
        $projectpropsToDelete = $this->getProjectprops(new Criteria(), $con)->diff($projectprops);

        $this->projectpropsScheduledForDeletion = unserialize(serialize($projectpropsToDelete));

        foreach ($projectpropsToDelete as $projectpropRemoved) {
            $projectpropRemoved->setCvterm(null);
        }

        $this->collProjectprops = null;
        foreach ($projectprops as $projectprop) {
            $this->addProjectprop($projectprop);
        }

        $this->collProjectprops = $projectprops;
        $this->collProjectpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Projectprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Projectprop objects.
     * @throws PropelException
     */
    public function countProjectprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectpropsPartial && !$this->isNew();
        if (null === $this->collProjectprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectprops());
            }
            $query = ProjectpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collProjectprops);
    }

    /**
     * Method called to associate a Projectprop object to this object
     * through the Projectprop foreign key attribute.
     *
     * @param    Projectprop $l Projectprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addProjectprop(Projectprop $l)
    {
        if ($this->collProjectprops === null) {
            $this->initProjectprops();
            $this->collProjectpropsPartial = true;
        }
        if (!in_array($l, $this->collProjectprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectprop($l);
        }

        return $this;
    }

    /**
     * @param	Projectprop $projectprop The projectprop object to add.
     */
    protected function doAddProjectprop($projectprop)
    {
        $this->collProjectprops[]= $projectprop;
        $projectprop->setCvterm($this);
    }

    /**
     * @param	Projectprop $projectprop The projectprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProjectprop($projectprop)
    {
        if ($this->getProjectprops()->contains($projectprop)) {
            $this->collProjectprops->remove($this->collProjectprops->search($projectprop));
            if (null === $this->projectpropsScheduledForDeletion) {
                $this->projectpropsScheduledForDeletion = clone $this->collProjectprops;
                $this->projectpropsScheduledForDeletion->clear();
            }
            $this->projectpropsScheduledForDeletion[]= clone $projectprop;
            $projectprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Projectprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectprop[] List of Projectprop objects
     */
    public function getProjectpropsJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectpropQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectprops($query, $con);
    }

    /**
     * Clears out the collProtocols collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addProtocols()
     */
    public function clearProtocols()
    {
        $this->collProtocols = null; // important to set this to null since that means it is uninitialized
        $this->collProtocolsPartial = null;

        return $this;
    }

    /**
     * reset is the collProtocols collection loaded partially
     *
     * @return void
     */
    public function resetPartialProtocols($v = true)
    {
        $this->collProtocolsPartial = $v;
    }

    /**
     * Initializes the collProtocols collection.
     *
     * By default this just sets the collProtocols collection to an empty array (like clearcollProtocols());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProtocols($overrideExisting = true)
    {
        if (null !== $this->collProtocols && !$overrideExisting) {
            return;
        }
        $this->collProtocols = new PropelObjectCollection();
        $this->collProtocols->setModel('Protocol');
    }

    /**
     * Gets an array of Protocol objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     * @throws PropelException
     */
    public function getProtocols($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProtocolsPartial && !$this->isNew();
        if (null === $this->collProtocols || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProtocols) {
                // return empty collection
                $this->initProtocols();
            } else {
                $collProtocols = ProtocolQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProtocolsPartial && count($collProtocols)) {
                      $this->initProtocols(false);

                      foreach($collProtocols as $obj) {
                        if (false == $this->collProtocols->contains($obj)) {
                          $this->collProtocols->append($obj);
                        }
                      }

                      $this->collProtocolsPartial = true;
                    }

                    $collProtocols->getInternalIterator()->rewind();
                    return $collProtocols;
                }

                if($partial && $this->collProtocols) {
                    foreach($this->collProtocols as $obj) {
                        if($obj->isNew()) {
                            $collProtocols[] = $obj;
                        }
                    }
                }

                $this->collProtocols = $collProtocols;
                $this->collProtocolsPartial = false;
            }
        }

        return $this->collProtocols;
    }

    /**
     * Sets a collection of Protocol objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $protocols A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProtocols(PropelCollection $protocols, PropelPDO $con = null)
    {
        $protocolsToDelete = $this->getProtocols(new Criteria(), $con)->diff($protocols);

        $this->protocolsScheduledForDeletion = unserialize(serialize($protocolsToDelete));

        foreach ($protocolsToDelete as $protocolRemoved) {
            $protocolRemoved->setCvterm(null);
        }

        $this->collProtocols = null;
        foreach ($protocols as $protocol) {
            $this->addProtocol($protocol);
        }

        $this->collProtocols = $protocols;
        $this->collProtocolsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Protocol objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Protocol objects.
     * @throws PropelException
     */
    public function countProtocols(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProtocolsPartial && !$this->isNew();
        if (null === $this->collProtocols || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProtocols) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProtocols());
            }
            $query = ProtocolQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collProtocols);
    }

    /**
     * Method called to associate a Protocol object to this object
     * through the Protocol foreign key attribute.
     *
     * @param    Protocol $l Protocol
     * @return Cvterm The current object (for fluent API support)
     */
    public function addProtocol(Protocol $l)
    {
        if ($this->collProtocols === null) {
            $this->initProtocols();
            $this->collProtocolsPartial = true;
        }
        if (!in_array($l, $this->collProtocols->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProtocol($l);
        }

        return $this;
    }

    /**
     * @param	Protocol $protocol The protocol object to add.
     */
    protected function doAddProtocol($protocol)
    {
        $this->collProtocols[]= $protocol;
        $protocol->setCvterm($this);
    }

    /**
     * @param	Protocol $protocol The protocol object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProtocol($protocol)
    {
        if ($this->getProtocols()->contains($protocol)) {
            $this->collProtocols->remove($this->collProtocols->search($protocol));
            if (null === $this->protocolsScheduledForDeletion) {
                $this->protocolsScheduledForDeletion = clone $this->collProtocols;
                $this->protocolsScheduledForDeletion->clear();
            }
            $this->protocolsScheduledForDeletion[]= clone $protocol;
            $protocol->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Protocols from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     */
    public function getProtocolsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getProtocols($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Protocols from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     */
    public function getProtocolsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getProtocols($query, $con);
    }

    /**
     * Clears out the collProtocolparamsRelatedByDatatypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addProtocolparamsRelatedByDatatypeId()
     */
    public function clearProtocolparamsRelatedByDatatypeId()
    {
        $this->collProtocolparamsRelatedByDatatypeId = null; // important to set this to null since that means it is uninitialized
        $this->collProtocolparamsRelatedByDatatypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collProtocolparamsRelatedByDatatypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProtocolparamsRelatedByDatatypeId($v = true)
    {
        $this->collProtocolparamsRelatedByDatatypeIdPartial = $v;
    }

    /**
     * Initializes the collProtocolparamsRelatedByDatatypeId collection.
     *
     * By default this just sets the collProtocolparamsRelatedByDatatypeId collection to an empty array (like clearcollProtocolparamsRelatedByDatatypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProtocolparamsRelatedByDatatypeId($overrideExisting = true)
    {
        if (null !== $this->collProtocolparamsRelatedByDatatypeId && !$overrideExisting) {
            return;
        }
        $this->collProtocolparamsRelatedByDatatypeId = new PropelObjectCollection();
        $this->collProtocolparamsRelatedByDatatypeId->setModel('Protocolparam');
    }

    /**
     * Gets an array of Protocolparam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     * @throws PropelException
     */
    public function getProtocolparamsRelatedByDatatypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsRelatedByDatatypeIdPartial && !$this->isNew();
        if (null === $this->collProtocolparamsRelatedByDatatypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProtocolparamsRelatedByDatatypeId) {
                // return empty collection
                $this->initProtocolparamsRelatedByDatatypeId();
            } else {
                $collProtocolparamsRelatedByDatatypeId = ProtocolparamQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByDatatypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProtocolparamsRelatedByDatatypeIdPartial && count($collProtocolparamsRelatedByDatatypeId)) {
                      $this->initProtocolparamsRelatedByDatatypeId(false);

                      foreach($collProtocolparamsRelatedByDatatypeId as $obj) {
                        if (false == $this->collProtocolparamsRelatedByDatatypeId->contains($obj)) {
                          $this->collProtocolparamsRelatedByDatatypeId->append($obj);
                        }
                      }

                      $this->collProtocolparamsRelatedByDatatypeIdPartial = true;
                    }

                    $collProtocolparamsRelatedByDatatypeId->getInternalIterator()->rewind();
                    return $collProtocolparamsRelatedByDatatypeId;
                }

                if($partial && $this->collProtocolparamsRelatedByDatatypeId) {
                    foreach($this->collProtocolparamsRelatedByDatatypeId as $obj) {
                        if($obj->isNew()) {
                            $collProtocolparamsRelatedByDatatypeId[] = $obj;
                        }
                    }
                }

                $this->collProtocolparamsRelatedByDatatypeId = $collProtocolparamsRelatedByDatatypeId;
                $this->collProtocolparamsRelatedByDatatypeIdPartial = false;
            }
        }

        return $this->collProtocolparamsRelatedByDatatypeId;
    }

    /**
     * Sets a collection of ProtocolparamRelatedByDatatypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $protocolparamsRelatedByDatatypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProtocolparamsRelatedByDatatypeId(PropelCollection $protocolparamsRelatedByDatatypeId, PropelPDO $con = null)
    {
        $protocolparamsRelatedByDatatypeIdToDelete = $this->getProtocolparamsRelatedByDatatypeId(new Criteria(), $con)->diff($protocolparamsRelatedByDatatypeId);

        $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion = unserialize(serialize($protocolparamsRelatedByDatatypeIdToDelete));

        foreach ($protocolparamsRelatedByDatatypeIdToDelete as $protocolparamRelatedByDatatypeIdRemoved) {
            $protocolparamRelatedByDatatypeIdRemoved->setCvtermRelatedByDatatypeId(null);
        }

        $this->collProtocolparamsRelatedByDatatypeId = null;
        foreach ($protocolparamsRelatedByDatatypeId as $protocolparamRelatedByDatatypeId) {
            $this->addProtocolparamRelatedByDatatypeId($protocolparamRelatedByDatatypeId);
        }

        $this->collProtocolparamsRelatedByDatatypeId = $protocolparamsRelatedByDatatypeId;
        $this->collProtocolparamsRelatedByDatatypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Protocolparam objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Protocolparam objects.
     * @throws PropelException
     */
    public function countProtocolparamsRelatedByDatatypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsRelatedByDatatypeIdPartial && !$this->isNew();
        if (null === $this->collProtocolparamsRelatedByDatatypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProtocolparamsRelatedByDatatypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProtocolparamsRelatedByDatatypeId());
            }
            $query = ProtocolparamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByDatatypeId($this)
                ->count($con);
        }

        return count($this->collProtocolparamsRelatedByDatatypeId);
    }

    /**
     * Method called to associate a Protocolparam object to this object
     * through the Protocolparam foreign key attribute.
     *
     * @param    Protocolparam $l Protocolparam
     * @return Cvterm The current object (for fluent API support)
     */
    public function addProtocolparamRelatedByDatatypeId(Protocolparam $l)
    {
        if ($this->collProtocolparamsRelatedByDatatypeId === null) {
            $this->initProtocolparamsRelatedByDatatypeId();
            $this->collProtocolparamsRelatedByDatatypeIdPartial = true;
        }
        if (!in_array($l, $this->collProtocolparamsRelatedByDatatypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProtocolparamRelatedByDatatypeId($l);
        }

        return $this;
    }

    /**
     * @param	ProtocolparamRelatedByDatatypeId $protocolparamRelatedByDatatypeId The protocolparamRelatedByDatatypeId object to add.
     */
    protected function doAddProtocolparamRelatedByDatatypeId($protocolparamRelatedByDatatypeId)
    {
        $this->collProtocolparamsRelatedByDatatypeId[]= $protocolparamRelatedByDatatypeId;
        $protocolparamRelatedByDatatypeId->setCvtermRelatedByDatatypeId($this);
    }

    /**
     * @param	ProtocolparamRelatedByDatatypeId $protocolparamRelatedByDatatypeId The protocolparamRelatedByDatatypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProtocolparamRelatedByDatatypeId($protocolparamRelatedByDatatypeId)
    {
        if ($this->getProtocolparamsRelatedByDatatypeId()->contains($protocolparamRelatedByDatatypeId)) {
            $this->collProtocolparamsRelatedByDatatypeId->remove($this->collProtocolparamsRelatedByDatatypeId->search($protocolparamRelatedByDatatypeId));
            if (null === $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion) {
                $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion = clone $this->collProtocolparamsRelatedByDatatypeId;
                $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion->clear();
            }
            $this->protocolparamsRelatedByDatatypeIdScheduledForDeletion[]= $protocolparamRelatedByDatatypeId;
            $protocolparamRelatedByDatatypeId->setCvtermRelatedByDatatypeId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ProtocolparamsRelatedByDatatypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     */
    public function getProtocolparamsRelatedByDatatypeIdJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolparamQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getProtocolparamsRelatedByDatatypeId($query, $con);
    }

    /**
     * Clears out the collProtocolparamsRelatedByUnittypeId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addProtocolparamsRelatedByUnittypeId()
     */
    public function clearProtocolparamsRelatedByUnittypeId()
    {
        $this->collProtocolparamsRelatedByUnittypeId = null; // important to set this to null since that means it is uninitialized
        $this->collProtocolparamsRelatedByUnittypeIdPartial = null;

        return $this;
    }

    /**
     * reset is the collProtocolparamsRelatedByUnittypeId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProtocolparamsRelatedByUnittypeId($v = true)
    {
        $this->collProtocolparamsRelatedByUnittypeIdPartial = $v;
    }

    /**
     * Initializes the collProtocolparamsRelatedByUnittypeId collection.
     *
     * By default this just sets the collProtocolparamsRelatedByUnittypeId collection to an empty array (like clearcollProtocolparamsRelatedByUnittypeId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProtocolparamsRelatedByUnittypeId($overrideExisting = true)
    {
        if (null !== $this->collProtocolparamsRelatedByUnittypeId && !$overrideExisting) {
            return;
        }
        $this->collProtocolparamsRelatedByUnittypeId = new PropelObjectCollection();
        $this->collProtocolparamsRelatedByUnittypeId->setModel('Protocolparam');
    }

    /**
     * Gets an array of Protocolparam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     * @throws PropelException
     */
    public function getProtocolparamsRelatedByUnittypeId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsRelatedByUnittypeIdPartial && !$this->isNew();
        if (null === $this->collProtocolparamsRelatedByUnittypeId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProtocolparamsRelatedByUnittypeId) {
                // return empty collection
                $this->initProtocolparamsRelatedByUnittypeId();
            } else {
                $collProtocolparamsRelatedByUnittypeId = ProtocolparamQuery::create(null, $criteria)
                    ->filterByCvtermRelatedByUnittypeId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProtocolparamsRelatedByUnittypeIdPartial && count($collProtocolparamsRelatedByUnittypeId)) {
                      $this->initProtocolparamsRelatedByUnittypeId(false);

                      foreach($collProtocolparamsRelatedByUnittypeId as $obj) {
                        if (false == $this->collProtocolparamsRelatedByUnittypeId->contains($obj)) {
                          $this->collProtocolparamsRelatedByUnittypeId->append($obj);
                        }
                      }

                      $this->collProtocolparamsRelatedByUnittypeIdPartial = true;
                    }

                    $collProtocolparamsRelatedByUnittypeId->getInternalIterator()->rewind();
                    return $collProtocolparamsRelatedByUnittypeId;
                }

                if($partial && $this->collProtocolparamsRelatedByUnittypeId) {
                    foreach($this->collProtocolparamsRelatedByUnittypeId as $obj) {
                        if($obj->isNew()) {
                            $collProtocolparamsRelatedByUnittypeId[] = $obj;
                        }
                    }
                }

                $this->collProtocolparamsRelatedByUnittypeId = $collProtocolparamsRelatedByUnittypeId;
                $this->collProtocolparamsRelatedByUnittypeIdPartial = false;
            }
        }

        return $this->collProtocolparamsRelatedByUnittypeId;
    }

    /**
     * Sets a collection of ProtocolparamRelatedByUnittypeId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $protocolparamsRelatedByUnittypeId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProtocolparamsRelatedByUnittypeId(PropelCollection $protocolparamsRelatedByUnittypeId, PropelPDO $con = null)
    {
        $protocolparamsRelatedByUnittypeIdToDelete = $this->getProtocolparamsRelatedByUnittypeId(new Criteria(), $con)->diff($protocolparamsRelatedByUnittypeId);

        $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion = unserialize(serialize($protocolparamsRelatedByUnittypeIdToDelete));

        foreach ($protocolparamsRelatedByUnittypeIdToDelete as $protocolparamRelatedByUnittypeIdRemoved) {
            $protocolparamRelatedByUnittypeIdRemoved->setCvtermRelatedByUnittypeId(null);
        }

        $this->collProtocolparamsRelatedByUnittypeId = null;
        foreach ($protocolparamsRelatedByUnittypeId as $protocolparamRelatedByUnittypeId) {
            $this->addProtocolparamRelatedByUnittypeId($protocolparamRelatedByUnittypeId);
        }

        $this->collProtocolparamsRelatedByUnittypeId = $protocolparamsRelatedByUnittypeId;
        $this->collProtocolparamsRelatedByUnittypeIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Protocolparam objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Protocolparam objects.
     * @throws PropelException
     */
    public function countProtocolparamsRelatedByUnittypeId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsRelatedByUnittypeIdPartial && !$this->isNew();
        if (null === $this->collProtocolparamsRelatedByUnittypeId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProtocolparamsRelatedByUnittypeId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProtocolparamsRelatedByUnittypeId());
            }
            $query = ProtocolparamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvtermRelatedByUnittypeId($this)
                ->count($con);
        }

        return count($this->collProtocolparamsRelatedByUnittypeId);
    }

    /**
     * Method called to associate a Protocolparam object to this object
     * through the Protocolparam foreign key attribute.
     *
     * @param    Protocolparam $l Protocolparam
     * @return Cvterm The current object (for fluent API support)
     */
    public function addProtocolparamRelatedByUnittypeId(Protocolparam $l)
    {
        if ($this->collProtocolparamsRelatedByUnittypeId === null) {
            $this->initProtocolparamsRelatedByUnittypeId();
            $this->collProtocolparamsRelatedByUnittypeIdPartial = true;
        }
        if (!in_array($l, $this->collProtocolparamsRelatedByUnittypeId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProtocolparamRelatedByUnittypeId($l);
        }

        return $this;
    }

    /**
     * @param	ProtocolparamRelatedByUnittypeId $protocolparamRelatedByUnittypeId The protocolparamRelatedByUnittypeId object to add.
     */
    protected function doAddProtocolparamRelatedByUnittypeId($protocolparamRelatedByUnittypeId)
    {
        $this->collProtocolparamsRelatedByUnittypeId[]= $protocolparamRelatedByUnittypeId;
        $protocolparamRelatedByUnittypeId->setCvtermRelatedByUnittypeId($this);
    }

    /**
     * @param	ProtocolparamRelatedByUnittypeId $protocolparamRelatedByUnittypeId The protocolparamRelatedByUnittypeId object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProtocolparamRelatedByUnittypeId($protocolparamRelatedByUnittypeId)
    {
        if ($this->getProtocolparamsRelatedByUnittypeId()->contains($protocolparamRelatedByUnittypeId)) {
            $this->collProtocolparamsRelatedByUnittypeId->remove($this->collProtocolparamsRelatedByUnittypeId->search($protocolparamRelatedByUnittypeId));
            if (null === $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion) {
                $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion = clone $this->collProtocolparamsRelatedByUnittypeId;
                $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion->clear();
            }
            $this->protocolparamsRelatedByUnittypeIdScheduledForDeletion[]= $protocolparamRelatedByUnittypeId;
            $protocolparamRelatedByUnittypeId->setCvtermRelatedByUnittypeId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related ProtocolparamsRelatedByUnittypeId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     */
    public function getProtocolparamsRelatedByUnittypeIdJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolparamQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getProtocolparamsRelatedByUnittypeId($query, $con);
    }

    /**
     * Clears out the collPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubs()
     */
    public function clearPubs()
    {
        $this->collPubs = null; // important to set this to null since that means it is uninitialized
        $this->collPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubs($v = true)
    {
        $this->collPubsPartial = $v;
    }

    /**
     * Initializes the collPubs collection.
     *
     * By default this just sets the collPubs collection to an empty array (like clearcollPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubs($overrideExisting = true)
    {
        if (null !== $this->collPubs && !$overrideExisting) {
            return;
        }
        $this->collPubs = new PropelObjectCollection();
        $this->collPubs->setModel('Pub');
    }

    /**
     * Gets an array of Pub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Pub[] List of Pub objects
     * @throws PropelException
     */
    public function getPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubsPartial && !$this->isNew();
        if (null === $this->collPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubs) {
                // return empty collection
                $this->initPubs();
            } else {
                $collPubs = PubQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubsPartial && count($collPubs)) {
                      $this->initPubs(false);

                      foreach($collPubs as $obj) {
                        if (false == $this->collPubs->contains($obj)) {
                          $this->collPubs->append($obj);
                        }
                      }

                      $this->collPubsPartial = true;
                    }

                    $collPubs->getInternalIterator()->rewind();
                    return $collPubs;
                }

                if($partial && $this->collPubs) {
                    foreach($this->collPubs as $obj) {
                        if($obj->isNew()) {
                            $collPubs[] = $obj;
                        }
                    }
                }

                $this->collPubs = $collPubs;
                $this->collPubsPartial = false;
            }
        }

        return $this->collPubs;
    }

    /**
     * Sets a collection of Pub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubs(PropelCollection $pubs, PropelPDO $con = null)
    {
        $pubsToDelete = $this->getPubs(new Criteria(), $con)->diff($pubs);

        $this->pubsScheduledForDeletion = unserialize(serialize($pubsToDelete));

        foreach ($pubsToDelete as $pubRemoved) {
            $pubRemoved->setCvterm(null);
        }

        $this->collPubs = null;
        foreach ($pubs as $pub) {
            $this->addPub($pub);
        }

        $this->collPubs = $pubs;
        $this->collPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Pub objects.
     * @throws PropelException
     */
    public function countPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubsPartial && !$this->isNew();
        if (null === $this->collPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubs());
            }
            $query = PubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubs);
    }

    /**
     * Method called to associate a Pub object to this object
     * through the Pub foreign key attribute.
     *
     * @param    Pub $l Pub
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPub(Pub $l)
    {
        if ($this->collPubs === null) {
            $this->initPubs();
            $this->collPubsPartial = true;
        }
        if (!in_array($l, $this->collPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPub($l);
        }

        return $this;
    }

    /**
     * @param	Pub $pub The pub object to add.
     */
    protected function doAddPub($pub)
    {
        $this->collPubs[]= $pub;
        $pub->setCvterm($this);
    }

    /**
     * @param	Pub $pub The pub object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePub($pub)
    {
        if ($this->getPubs()->contains($pub)) {
            $this->collPubs->remove($this->collPubs->search($pub));
            if (null === $this->pubsScheduledForDeletion) {
                $this->pubsScheduledForDeletion = clone $this->collPubs;
                $this->pubsScheduledForDeletion->clear();
            }
            $this->pubsScheduledForDeletion[]= clone $pub;
            $pub->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collPubRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubRelationships()
     */
    public function clearPubRelationships()
    {
        $this->collPubRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collPubRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubRelationships($v = true)
    {
        $this->collPubRelationshipsPartial = $v;
    }

    /**
     * Initializes the collPubRelationships collection.
     *
     * By default this just sets the collPubRelationships collection to an empty array (like clearcollPubRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubRelationships($overrideExisting = true)
    {
        if (null !== $this->collPubRelationships && !$overrideExisting) {
            return;
        }
        $this->collPubRelationships = new PropelObjectCollection();
        $this->collPubRelationships->setModel('PubRelationship');
    }

    /**
     * Gets an array of PubRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     * @throws PropelException
     */
    public function getPubRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsPartial && !$this->isNew();
        if (null === $this->collPubRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubRelationships) {
                // return empty collection
                $this->initPubRelationships();
            } else {
                $collPubRelationships = PubRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubRelationshipsPartial && count($collPubRelationships)) {
                      $this->initPubRelationships(false);

                      foreach($collPubRelationships as $obj) {
                        if (false == $this->collPubRelationships->contains($obj)) {
                          $this->collPubRelationships->append($obj);
                        }
                      }

                      $this->collPubRelationshipsPartial = true;
                    }

                    $collPubRelationships->getInternalIterator()->rewind();
                    return $collPubRelationships;
                }

                if($partial && $this->collPubRelationships) {
                    foreach($this->collPubRelationships as $obj) {
                        if($obj->isNew()) {
                            $collPubRelationships[] = $obj;
                        }
                    }
                }

                $this->collPubRelationships = $collPubRelationships;
                $this->collPubRelationshipsPartial = false;
            }
        }

        return $this->collPubRelationships;
    }

    /**
     * Sets a collection of PubRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubRelationships(PropelCollection $pubRelationships, PropelPDO $con = null)
    {
        $pubRelationshipsToDelete = $this->getPubRelationships(new Criteria(), $con)->diff($pubRelationships);

        $this->pubRelationshipsScheduledForDeletion = unserialize(serialize($pubRelationshipsToDelete));

        foreach ($pubRelationshipsToDelete as $pubRelationshipRemoved) {
            $pubRelationshipRemoved->setCvterm(null);
        }

        $this->collPubRelationships = null;
        foreach ($pubRelationships as $pubRelationship) {
            $this->addPubRelationship($pubRelationship);
        }

        $this->collPubRelationships = $pubRelationships;
        $this->collPubRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PubRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PubRelationship objects.
     * @throws PropelException
     */
    public function countPubRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsPartial && !$this->isNew();
        if (null === $this->collPubRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubRelationships());
            }
            $query = PubRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubRelationships);
    }

    /**
     * Method called to associate a PubRelationship object to this object
     * through the PubRelationship foreign key attribute.
     *
     * @param    PubRelationship $l PubRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPubRelationship(PubRelationship $l)
    {
        if ($this->collPubRelationships === null) {
            $this->initPubRelationships();
            $this->collPubRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collPubRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubRelationship($l);
        }

        return $this;
    }

    /**
     * @param	PubRelationship $pubRelationship The pubRelationship object to add.
     */
    protected function doAddPubRelationship($pubRelationship)
    {
        $this->collPubRelationships[]= $pubRelationship;
        $pubRelationship->setCvterm($this);
    }

    /**
     * @param	PubRelationship $pubRelationship The pubRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePubRelationship($pubRelationship)
    {
        if ($this->getPubRelationships()->contains($pubRelationship)) {
            $this->collPubRelationships->remove($this->collPubRelationships->search($pubRelationship));
            if (null === $this->pubRelationshipsScheduledForDeletion) {
                $this->pubRelationshipsScheduledForDeletion = clone $this->collPubRelationships;
                $this->pubRelationshipsScheduledForDeletion->clear();
            }
            $this->pubRelationshipsScheduledForDeletion[]= clone $pubRelationship;
            $pubRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related PubRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsJoinPubRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('PubRelatedByObjectId', $join_behavior);

        return $this->getPubRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related PubRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsJoinPubRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('PubRelatedBySubjectId', $join_behavior);

        return $this->getPubRelationships($query, $con);
    }

    /**
     * Clears out the collPubprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubprops()
     */
    public function clearPubprops()
    {
        $this->collPubprops = null; // important to set this to null since that means it is uninitialized
        $this->collPubpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubprops($v = true)
    {
        $this->collPubpropsPartial = $v;
    }

    /**
     * Initializes the collPubprops collection.
     *
     * By default this just sets the collPubprops collection to an empty array (like clearcollPubprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubprops($overrideExisting = true)
    {
        if (null !== $this->collPubprops && !$overrideExisting) {
            return;
        }
        $this->collPubprops = new PropelObjectCollection();
        $this->collPubprops->setModel('Pubprop');
    }

    /**
     * Gets an array of Pubprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Pubprop[] List of Pubprop objects
     * @throws PropelException
     */
    public function getPubprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubpropsPartial && !$this->isNew();
        if (null === $this->collPubprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubprops) {
                // return empty collection
                $this->initPubprops();
            } else {
                $collPubprops = PubpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubpropsPartial && count($collPubprops)) {
                      $this->initPubprops(false);

                      foreach($collPubprops as $obj) {
                        if (false == $this->collPubprops->contains($obj)) {
                          $this->collPubprops->append($obj);
                        }
                      }

                      $this->collPubpropsPartial = true;
                    }

                    $collPubprops->getInternalIterator()->rewind();
                    return $collPubprops;
                }

                if($partial && $this->collPubprops) {
                    foreach($this->collPubprops as $obj) {
                        if($obj->isNew()) {
                            $collPubprops[] = $obj;
                        }
                    }
                }

                $this->collPubprops = $collPubprops;
                $this->collPubpropsPartial = false;
            }
        }

        return $this->collPubprops;
    }

    /**
     * Sets a collection of Pubprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubprops(PropelCollection $pubprops, PropelPDO $con = null)
    {
        $pubpropsToDelete = $this->getPubprops(new Criteria(), $con)->diff($pubprops);

        $this->pubpropsScheduledForDeletion = unserialize(serialize($pubpropsToDelete));

        foreach ($pubpropsToDelete as $pubpropRemoved) {
            $pubpropRemoved->setCvterm(null);
        }

        $this->collPubprops = null;
        foreach ($pubprops as $pubprop) {
            $this->addPubprop($pubprop);
        }

        $this->collPubprops = $pubprops;
        $this->collPubpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pubprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Pubprop objects.
     * @throws PropelException
     */
    public function countPubprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubpropsPartial && !$this->isNew();
        if (null === $this->collPubprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubprops());
            }
            $query = PubpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubprops);
    }

    /**
     * Method called to associate a Pubprop object to this object
     * through the Pubprop foreign key attribute.
     *
     * @param    Pubprop $l Pubprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPubprop(Pubprop $l)
    {
        if ($this->collPubprops === null) {
            $this->initPubprops();
            $this->collPubpropsPartial = true;
        }
        if (!in_array($l, $this->collPubprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubprop($l);
        }

        return $this;
    }

    /**
     * @param	Pubprop $pubprop The pubprop object to add.
     */
    protected function doAddPubprop($pubprop)
    {
        $this->collPubprops[]= $pubprop;
        $pubprop->setCvterm($this);
    }

    /**
     * @param	Pubprop $pubprop The pubprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePubprop($pubprop)
    {
        if ($this->getPubprops()->contains($pubprop)) {
            $this->collPubprops->remove($this->collPubprops->search($pubprop));
            if (null === $this->pubpropsScheduledForDeletion) {
                $this->pubpropsScheduledForDeletion = clone $this->collPubprops;
                $this->pubpropsScheduledForDeletion->clear();
            }
            $this->pubpropsScheduledForDeletion[]= clone $pubprop;
            $pubprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Pubprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Pubprop[] List of Pubprop objects
     */
    public function getPubpropsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubpropQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getPubprops($query, $con);
    }

    /**
     * Clears out the collQuantificationRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addQuantificationRelationships()
     */
    public function clearQuantificationRelationships()
    {
        $this->collQuantificationRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantificationRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantificationRelationships($v = true)
    {
        $this->collQuantificationRelationshipsPartial = $v;
    }

    /**
     * Initializes the collQuantificationRelationships collection.
     *
     * By default this just sets the collQuantificationRelationships collection to an empty array (like clearcollQuantificationRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantificationRelationships($overrideExisting = true)
    {
        if (null !== $this->collQuantificationRelationships && !$overrideExisting) {
            return;
        }
        $this->collQuantificationRelationships = new PropelObjectCollection();
        $this->collQuantificationRelationships->setModel('QuantificationRelationship');
    }

    /**
     * Gets an array of QuantificationRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     * @throws PropelException
     */
    public function getQuantificationRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationships) {
                // return empty collection
                $this->initQuantificationRelationships();
            } else {
                $collQuantificationRelationships = QuantificationRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationRelationshipsPartial && count($collQuantificationRelationships)) {
                      $this->initQuantificationRelationships(false);

                      foreach($collQuantificationRelationships as $obj) {
                        if (false == $this->collQuantificationRelationships->contains($obj)) {
                          $this->collQuantificationRelationships->append($obj);
                        }
                      }

                      $this->collQuantificationRelationshipsPartial = true;
                    }

                    $collQuantificationRelationships->getInternalIterator()->rewind();
                    return $collQuantificationRelationships;
                }

                if($partial && $this->collQuantificationRelationships) {
                    foreach($this->collQuantificationRelationships as $obj) {
                        if($obj->isNew()) {
                            $collQuantificationRelationships[] = $obj;
                        }
                    }
                }

                $this->collQuantificationRelationships = $collQuantificationRelationships;
                $this->collQuantificationRelationshipsPartial = false;
            }
        }

        return $this->collQuantificationRelationships;
    }

    /**
     * Sets a collection of QuantificationRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantificationRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setQuantificationRelationships(PropelCollection $quantificationRelationships, PropelPDO $con = null)
    {
        $quantificationRelationshipsToDelete = $this->getQuantificationRelationships(new Criteria(), $con)->diff($quantificationRelationships);

        $this->quantificationRelationshipsScheduledForDeletion = unserialize(serialize($quantificationRelationshipsToDelete));

        foreach ($quantificationRelationshipsToDelete as $quantificationRelationshipRemoved) {
            $quantificationRelationshipRemoved->setCvterm(null);
        }

        $this->collQuantificationRelationships = null;
        foreach ($quantificationRelationships as $quantificationRelationship) {
            $this->addQuantificationRelationship($quantificationRelationship);
        }

        $this->collQuantificationRelationships = $quantificationRelationships;
        $this->collQuantificationRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related QuantificationRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related QuantificationRelationship objects.
     * @throws PropelException
     */
    public function countQuantificationRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantificationRelationships());
            }
            $query = QuantificationRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collQuantificationRelationships);
    }

    /**
     * Method called to associate a QuantificationRelationship object to this object
     * through the QuantificationRelationship foreign key attribute.
     *
     * @param    QuantificationRelationship $l QuantificationRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addQuantificationRelationship(QuantificationRelationship $l)
    {
        if ($this->collQuantificationRelationships === null) {
            $this->initQuantificationRelationships();
            $this->collQuantificationRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collQuantificationRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantificationRelationship($l);
        }

        return $this;
    }

    /**
     * @param	QuantificationRelationship $quantificationRelationship The quantificationRelationship object to add.
     */
    protected function doAddQuantificationRelationship($quantificationRelationship)
    {
        $this->collQuantificationRelationships[]= $quantificationRelationship;
        $quantificationRelationship->setCvterm($this);
    }

    /**
     * @param	QuantificationRelationship $quantificationRelationship The quantificationRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeQuantificationRelationship($quantificationRelationship)
    {
        if ($this->getQuantificationRelationships()->contains($quantificationRelationship)) {
            $this->collQuantificationRelationships->remove($this->collQuantificationRelationships->search($quantificationRelationship));
            if (null === $this->quantificationRelationshipsScheduledForDeletion) {
                $this->quantificationRelationshipsScheduledForDeletion = clone $this->collQuantificationRelationships;
                $this->quantificationRelationshipsScheduledForDeletion->clear();
            }
            $this->quantificationRelationshipsScheduledForDeletion[]= clone $quantificationRelationship;
            $quantificationRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related QuantificationRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     */
    public function getQuantificationRelationshipsJoinQuantificationRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationRelationshipQuery::create(null, $criteria);
        $query->joinWith('QuantificationRelatedByObjectId', $join_behavior);

        return $this->getQuantificationRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related QuantificationRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     */
    public function getQuantificationRelationshipsJoinQuantificationRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationRelationshipQuery::create(null, $criteria);
        $query->joinWith('QuantificationRelatedBySubjectId', $join_behavior);

        return $this->getQuantificationRelationships($query, $con);
    }

    /**
     * Clears out the collQuantificationprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addQuantificationprops()
     */
    public function clearQuantificationprops()
    {
        $this->collQuantificationprops = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantificationprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantificationprops($v = true)
    {
        $this->collQuantificationpropsPartial = $v;
    }

    /**
     * Initializes the collQuantificationprops collection.
     *
     * By default this just sets the collQuantificationprops collection to an empty array (like clearcollQuantificationprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantificationprops($overrideExisting = true)
    {
        if (null !== $this->collQuantificationprops && !$overrideExisting) {
            return;
        }
        $this->collQuantificationprops = new PropelObjectCollection();
        $this->collQuantificationprops->setModel('Quantificationprop');
    }

    /**
     * Gets an array of Quantificationprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Quantificationprop[] List of Quantificationprop objects
     * @throws PropelException
     */
    public function getQuantificationprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationpropsPartial && !$this->isNew();
        if (null === $this->collQuantificationprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantificationprops) {
                // return empty collection
                $this->initQuantificationprops();
            } else {
                $collQuantificationprops = QuantificationpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationpropsPartial && count($collQuantificationprops)) {
                      $this->initQuantificationprops(false);

                      foreach($collQuantificationprops as $obj) {
                        if (false == $this->collQuantificationprops->contains($obj)) {
                          $this->collQuantificationprops->append($obj);
                        }
                      }

                      $this->collQuantificationpropsPartial = true;
                    }

                    $collQuantificationprops->getInternalIterator()->rewind();
                    return $collQuantificationprops;
                }

                if($partial && $this->collQuantificationprops) {
                    foreach($this->collQuantificationprops as $obj) {
                        if($obj->isNew()) {
                            $collQuantificationprops[] = $obj;
                        }
                    }
                }

                $this->collQuantificationprops = $collQuantificationprops;
                $this->collQuantificationpropsPartial = false;
            }
        }

        return $this->collQuantificationprops;
    }

    /**
     * Sets a collection of Quantificationprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantificationprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setQuantificationprops(PropelCollection $quantificationprops, PropelPDO $con = null)
    {
        $quantificationpropsToDelete = $this->getQuantificationprops(new Criteria(), $con)->diff($quantificationprops);

        $this->quantificationpropsScheduledForDeletion = unserialize(serialize($quantificationpropsToDelete));

        foreach ($quantificationpropsToDelete as $quantificationpropRemoved) {
            $quantificationpropRemoved->setCvterm(null);
        }

        $this->collQuantificationprops = null;
        foreach ($quantificationprops as $quantificationprop) {
            $this->addQuantificationprop($quantificationprop);
        }

        $this->collQuantificationprops = $quantificationprops;
        $this->collQuantificationpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Quantificationprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Quantificationprop objects.
     * @throws PropelException
     */
    public function countQuantificationprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationpropsPartial && !$this->isNew();
        if (null === $this->collQuantificationprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantificationprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantificationprops());
            }
            $query = QuantificationpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collQuantificationprops);
    }

    /**
     * Method called to associate a Quantificationprop object to this object
     * through the Quantificationprop foreign key attribute.
     *
     * @param    Quantificationprop $l Quantificationprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addQuantificationprop(Quantificationprop $l)
    {
        if ($this->collQuantificationprops === null) {
            $this->initQuantificationprops();
            $this->collQuantificationpropsPartial = true;
        }
        if (!in_array($l, $this->collQuantificationprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantificationprop($l);
        }

        return $this;
    }

    /**
     * @param	Quantificationprop $quantificationprop The quantificationprop object to add.
     */
    protected function doAddQuantificationprop($quantificationprop)
    {
        $this->collQuantificationprops[]= $quantificationprop;
        $quantificationprop->setCvterm($this);
    }

    /**
     * @param	Quantificationprop $quantificationprop The quantificationprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeQuantificationprop($quantificationprop)
    {
        if ($this->getQuantificationprops()->contains($quantificationprop)) {
            $this->collQuantificationprops->remove($this->collQuantificationprops->search($quantificationprop));
            if (null === $this->quantificationpropsScheduledForDeletion) {
                $this->quantificationpropsScheduledForDeletion = clone $this->collQuantificationprops;
                $this->quantificationpropsScheduledForDeletion->clear();
            }
            $this->quantificationpropsScheduledForDeletion[]= clone $quantificationprop;
            $quantificationprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Quantificationprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationprop[] List of Quantificationprop objects
     */
    public function getQuantificationpropsJoinQuantification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationpropQuery::create(null, $criteria);
        $query->joinWith('Quantification', $join_behavior);

        return $this->getQuantificationprops($query, $con);
    }

    /**
     * Clears out the collQuantificationresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addQuantificationresults()
     */
    public function clearQuantificationresults()
    {
        $this->collQuantificationresults = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationresultsPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantificationresults collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantificationresults($v = true)
    {
        $this->collQuantificationresultsPartial = $v;
    }

    /**
     * Initializes the collQuantificationresults collection.
     *
     * By default this just sets the collQuantificationresults collection to an empty array (like clearcollQuantificationresults());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantificationresults($overrideExisting = true)
    {
        if (null !== $this->collQuantificationresults && !$overrideExisting) {
            return;
        }
        $this->collQuantificationresults = new PropelObjectCollection();
        $this->collQuantificationresults->setModel('Quantificationresult');
    }

    /**
     * Gets an array of Quantificationresult objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Quantificationresult[] List of Quantificationresult objects
     * @throws PropelException
     */
    public function getQuantificationresults($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationresultsPartial && !$this->isNew();
        if (null === $this->collQuantificationresults || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantificationresults) {
                // return empty collection
                $this->initQuantificationresults();
            } else {
                $collQuantificationresults = QuantificationresultQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationresultsPartial && count($collQuantificationresults)) {
                      $this->initQuantificationresults(false);

                      foreach($collQuantificationresults as $obj) {
                        if (false == $this->collQuantificationresults->contains($obj)) {
                          $this->collQuantificationresults->append($obj);
                        }
                      }

                      $this->collQuantificationresultsPartial = true;
                    }

                    $collQuantificationresults->getInternalIterator()->rewind();
                    return $collQuantificationresults;
                }

                if($partial && $this->collQuantificationresults) {
                    foreach($this->collQuantificationresults as $obj) {
                        if($obj->isNew()) {
                            $collQuantificationresults[] = $obj;
                        }
                    }
                }

                $this->collQuantificationresults = $collQuantificationresults;
                $this->collQuantificationresultsPartial = false;
            }
        }

        return $this->collQuantificationresults;
    }

    /**
     * Sets a collection of Quantificationresult objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantificationresults A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setQuantificationresults(PropelCollection $quantificationresults, PropelPDO $con = null)
    {
        $quantificationresultsToDelete = $this->getQuantificationresults(new Criteria(), $con)->diff($quantificationresults);

        $this->quantificationresultsScheduledForDeletion = unserialize(serialize($quantificationresultsToDelete));

        foreach ($quantificationresultsToDelete as $quantificationresultRemoved) {
            $quantificationresultRemoved->setCvterm(null);
        }

        $this->collQuantificationresults = null;
        foreach ($quantificationresults as $quantificationresult) {
            $this->addQuantificationresult($quantificationresult);
        }

        $this->collQuantificationresults = $quantificationresults;
        $this->collQuantificationresultsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Quantificationresult objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Quantificationresult objects.
     * @throws PropelException
     */
    public function countQuantificationresults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationresultsPartial && !$this->isNew();
        if (null === $this->collQuantificationresults || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantificationresults) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantificationresults());
            }
            $query = QuantificationresultQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collQuantificationresults);
    }

    /**
     * Method called to associate a Quantificationresult object to this object
     * through the Quantificationresult foreign key attribute.
     *
     * @param    Quantificationresult $l Quantificationresult
     * @return Cvterm The current object (for fluent API support)
     */
    public function addQuantificationresult(Quantificationresult $l)
    {
        if ($this->collQuantificationresults === null) {
            $this->initQuantificationresults();
            $this->collQuantificationresultsPartial = true;
        }
        if (!in_array($l, $this->collQuantificationresults->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantificationresult($l);
        }

        return $this;
    }

    /**
     * @param	Quantificationresult $quantificationresult The quantificationresult object to add.
     */
    protected function doAddQuantificationresult($quantificationresult)
    {
        $this->collQuantificationresults[]= $quantificationresult;
        $quantificationresult->setCvterm($this);
    }

    /**
     * @param	Quantificationresult $quantificationresult The quantificationresult object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeQuantificationresult($quantificationresult)
    {
        if ($this->getQuantificationresults()->contains($quantificationresult)) {
            $this->collQuantificationresults->remove($this->collQuantificationresults->search($quantificationresult));
            if (null === $this->quantificationresultsScheduledForDeletion) {
                $this->quantificationresultsScheduledForDeletion = clone $this->collQuantificationresults;
                $this->quantificationresultsScheduledForDeletion->clear();
            }
            $this->quantificationresultsScheduledForDeletion[]= clone $quantificationresult;
            $quantificationresult->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationresult[] List of Quantificationresult objects
     */
    public function getQuantificationresultsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationresultQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getQuantificationresults($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationresult[] List of Quantificationresult objects
     */
    public function getQuantificationresultsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationresultQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getQuantificationresults($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationresult[] List of Quantificationresult objects
     */
    public function getQuantificationresultsJoinQuantification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationresultQuery::create(null, $criteria);
        $query->joinWith('Quantification', $join_behavior);

        return $this->getQuantificationresults($query, $con);
    }

    /**
     * Clears out the collStudydesignprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addStudydesignprops()
     */
    public function clearStudydesignprops()
    {
        $this->collStudydesignprops = null; // important to set this to null since that means it is uninitialized
        $this->collStudydesignpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collStudydesignprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudydesignprops($v = true)
    {
        $this->collStudydesignpropsPartial = $v;
    }

    /**
     * Initializes the collStudydesignprops collection.
     *
     * By default this just sets the collStudydesignprops collection to an empty array (like clearcollStudydesignprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudydesignprops($overrideExisting = true)
    {
        if (null !== $this->collStudydesignprops && !$overrideExisting) {
            return;
        }
        $this->collStudydesignprops = new PropelObjectCollection();
        $this->collStudydesignprops->setModel('Studydesignprop');
    }

    /**
     * Gets an array of Studydesignprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studydesignprop[] List of Studydesignprop objects
     * @throws PropelException
     */
    public function getStudydesignprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudydesignpropsPartial && !$this->isNew();
        if (null === $this->collStudydesignprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudydesignprops) {
                // return empty collection
                $this->initStudydesignprops();
            } else {
                $collStudydesignprops = StudydesignpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudydesignpropsPartial && count($collStudydesignprops)) {
                      $this->initStudydesignprops(false);

                      foreach($collStudydesignprops as $obj) {
                        if (false == $this->collStudydesignprops->contains($obj)) {
                          $this->collStudydesignprops->append($obj);
                        }
                      }

                      $this->collStudydesignpropsPartial = true;
                    }

                    $collStudydesignprops->getInternalIterator()->rewind();
                    return $collStudydesignprops;
                }

                if($partial && $this->collStudydesignprops) {
                    foreach($this->collStudydesignprops as $obj) {
                        if($obj->isNew()) {
                            $collStudydesignprops[] = $obj;
                        }
                    }
                }

                $this->collStudydesignprops = $collStudydesignprops;
                $this->collStudydesignpropsPartial = false;
            }
        }

        return $this->collStudydesignprops;
    }

    /**
     * Sets a collection of Studydesignprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studydesignprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setStudydesignprops(PropelCollection $studydesignprops, PropelPDO $con = null)
    {
        $studydesignpropsToDelete = $this->getStudydesignprops(new Criteria(), $con)->diff($studydesignprops);

        $this->studydesignpropsScheduledForDeletion = unserialize(serialize($studydesignpropsToDelete));

        foreach ($studydesignpropsToDelete as $studydesignpropRemoved) {
            $studydesignpropRemoved->setCvterm(null);
        }

        $this->collStudydesignprops = null;
        foreach ($studydesignprops as $studydesignprop) {
            $this->addStudydesignprop($studydesignprop);
        }

        $this->collStudydesignprops = $studydesignprops;
        $this->collStudydesignpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studydesignprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studydesignprop objects.
     * @throws PropelException
     */
    public function countStudydesignprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudydesignpropsPartial && !$this->isNew();
        if (null === $this->collStudydesignprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudydesignprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudydesignprops());
            }
            $query = StudydesignpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collStudydesignprops);
    }

    /**
     * Method called to associate a Studydesignprop object to this object
     * through the Studydesignprop foreign key attribute.
     *
     * @param    Studydesignprop $l Studydesignprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addStudydesignprop(Studydesignprop $l)
    {
        if ($this->collStudydesignprops === null) {
            $this->initStudydesignprops();
            $this->collStudydesignpropsPartial = true;
        }
        if (!in_array($l, $this->collStudydesignprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudydesignprop($l);
        }

        return $this;
    }

    /**
     * @param	Studydesignprop $studydesignprop The studydesignprop object to add.
     */
    protected function doAddStudydesignprop($studydesignprop)
    {
        $this->collStudydesignprops[]= $studydesignprop;
        $studydesignprop->setCvterm($this);
    }

    /**
     * @param	Studydesignprop $studydesignprop The studydesignprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeStudydesignprop($studydesignprop)
    {
        if ($this->getStudydesignprops()->contains($studydesignprop)) {
            $this->collStudydesignprops->remove($this->collStudydesignprops->search($studydesignprop));
            if (null === $this->studydesignpropsScheduledForDeletion) {
                $this->studydesignpropsScheduledForDeletion = clone $this->collStudydesignprops;
                $this->studydesignpropsScheduledForDeletion->clear();
            }
            $this->studydesignpropsScheduledForDeletion[]= clone $studydesignprop;
            $studydesignprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Studydesignprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studydesignprop[] List of Studydesignprop objects
     */
    public function getStudydesignpropsJoinStudydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudydesignpropQuery::create(null, $criteria);
        $query->joinWith('Studydesign', $join_behavior);

        return $this->getStudydesignprops($query, $con);
    }

    /**
     * Clears out the collStudyfactors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addStudyfactors()
     */
    public function clearStudyfactors()
    {
        $this->collStudyfactors = null; // important to set this to null since that means it is uninitialized
        $this->collStudyfactorsPartial = null;

        return $this;
    }

    /**
     * reset is the collStudyfactors collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudyfactors($v = true)
    {
        $this->collStudyfactorsPartial = $v;
    }

    /**
     * Initializes the collStudyfactors collection.
     *
     * By default this just sets the collStudyfactors collection to an empty array (like clearcollStudyfactors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyfactors($overrideExisting = true)
    {
        if (null !== $this->collStudyfactors && !$overrideExisting) {
            return;
        }
        $this->collStudyfactors = new PropelObjectCollection();
        $this->collStudyfactors->setModel('Studyfactor');
    }

    /**
     * Gets an array of Studyfactor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studyfactor[] List of Studyfactor objects
     * @throws PropelException
     */
    public function getStudyfactors($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudyfactorsPartial && !$this->isNew();
        if (null === $this->collStudyfactors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyfactors) {
                // return empty collection
                $this->initStudyfactors();
            } else {
                $collStudyfactors = StudyfactorQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudyfactorsPartial && count($collStudyfactors)) {
                      $this->initStudyfactors(false);

                      foreach($collStudyfactors as $obj) {
                        if (false == $this->collStudyfactors->contains($obj)) {
                          $this->collStudyfactors->append($obj);
                        }
                      }

                      $this->collStudyfactorsPartial = true;
                    }

                    $collStudyfactors->getInternalIterator()->rewind();
                    return $collStudyfactors;
                }

                if($partial && $this->collStudyfactors) {
                    foreach($this->collStudyfactors as $obj) {
                        if($obj->isNew()) {
                            $collStudyfactors[] = $obj;
                        }
                    }
                }

                $this->collStudyfactors = $collStudyfactors;
                $this->collStudyfactorsPartial = false;
            }
        }

        return $this->collStudyfactors;
    }

    /**
     * Sets a collection of Studyfactor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studyfactors A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setStudyfactors(PropelCollection $studyfactors, PropelPDO $con = null)
    {
        $studyfactorsToDelete = $this->getStudyfactors(new Criteria(), $con)->diff($studyfactors);

        $this->studyfactorsScheduledForDeletion = unserialize(serialize($studyfactorsToDelete));

        foreach ($studyfactorsToDelete as $studyfactorRemoved) {
            $studyfactorRemoved->setCvterm(null);
        }

        $this->collStudyfactors = null;
        foreach ($studyfactors as $studyfactor) {
            $this->addStudyfactor($studyfactor);
        }

        $this->collStudyfactors = $studyfactors;
        $this->collStudyfactorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studyfactor objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studyfactor objects.
     * @throws PropelException
     */
    public function countStudyfactors(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudyfactorsPartial && !$this->isNew();
        if (null === $this->collStudyfactors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyfactors) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudyfactors());
            }
            $query = StudyfactorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collStudyfactors);
    }

    /**
     * Method called to associate a Studyfactor object to this object
     * through the Studyfactor foreign key attribute.
     *
     * @param    Studyfactor $l Studyfactor
     * @return Cvterm The current object (for fluent API support)
     */
    public function addStudyfactor(Studyfactor $l)
    {
        if ($this->collStudyfactors === null) {
            $this->initStudyfactors();
            $this->collStudyfactorsPartial = true;
        }
        if (!in_array($l, $this->collStudyfactors->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudyfactor($l);
        }

        return $this;
    }

    /**
     * @param	Studyfactor $studyfactor The studyfactor object to add.
     */
    protected function doAddStudyfactor($studyfactor)
    {
        $this->collStudyfactors[]= $studyfactor;
        $studyfactor->setCvterm($this);
    }

    /**
     * @param	Studyfactor $studyfactor The studyfactor object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeStudyfactor($studyfactor)
    {
        if ($this->getStudyfactors()->contains($studyfactor)) {
            $this->collStudyfactors->remove($this->collStudyfactors->search($studyfactor));
            if (null === $this->studyfactorsScheduledForDeletion) {
                $this->studyfactorsScheduledForDeletion = clone $this->collStudyfactors;
                $this->studyfactorsScheduledForDeletion->clear();
            }
            $this->studyfactorsScheduledForDeletion[]= $studyfactor;
            $studyfactor->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Studyfactors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studyfactor[] List of Studyfactor objects
     */
    public function getStudyfactorsJoinStudydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyfactorQuery::create(null, $criteria);
        $query->joinWith('Studydesign', $join_behavior);

        return $this->getStudyfactors($query, $con);
    }

    /**
     * Clears out the collStudyprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addStudyprops()
     */
    public function clearStudyprops()
    {
        $this->collStudyprops = null; // important to set this to null since that means it is uninitialized
        $this->collStudypropsPartial = null;

        return $this;
    }

    /**
     * reset is the collStudyprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudyprops($v = true)
    {
        $this->collStudypropsPartial = $v;
    }

    /**
     * Initializes the collStudyprops collection.
     *
     * By default this just sets the collStudyprops collection to an empty array (like clearcollStudyprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyprops($overrideExisting = true)
    {
        if (null !== $this->collStudyprops && !$overrideExisting) {
            return;
        }
        $this->collStudyprops = new PropelObjectCollection();
        $this->collStudyprops->setModel('Studyprop');
    }

    /**
     * Gets an array of Studyprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studyprop[] List of Studyprop objects
     * @throws PropelException
     */
    public function getStudyprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudypropsPartial && !$this->isNew();
        if (null === $this->collStudyprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyprops) {
                // return empty collection
                $this->initStudyprops();
            } else {
                $collStudyprops = StudypropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudypropsPartial && count($collStudyprops)) {
                      $this->initStudyprops(false);

                      foreach($collStudyprops as $obj) {
                        if (false == $this->collStudyprops->contains($obj)) {
                          $this->collStudyprops->append($obj);
                        }
                      }

                      $this->collStudypropsPartial = true;
                    }

                    $collStudyprops->getInternalIterator()->rewind();
                    return $collStudyprops;
                }

                if($partial && $this->collStudyprops) {
                    foreach($this->collStudyprops as $obj) {
                        if($obj->isNew()) {
                            $collStudyprops[] = $obj;
                        }
                    }
                }

                $this->collStudyprops = $collStudyprops;
                $this->collStudypropsPartial = false;
            }
        }

        return $this->collStudyprops;
    }

    /**
     * Sets a collection of Studyprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studyprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setStudyprops(PropelCollection $studyprops, PropelPDO $con = null)
    {
        $studypropsToDelete = $this->getStudyprops(new Criteria(), $con)->diff($studyprops);

        $this->studypropsScheduledForDeletion = unserialize(serialize($studypropsToDelete));

        foreach ($studypropsToDelete as $studypropRemoved) {
            $studypropRemoved->setCvterm(null);
        }

        $this->collStudyprops = null;
        foreach ($studyprops as $studyprop) {
            $this->addStudyprop($studyprop);
        }

        $this->collStudyprops = $studyprops;
        $this->collStudypropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studyprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studyprop objects.
     * @throws PropelException
     */
    public function countStudyprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudypropsPartial && !$this->isNew();
        if (null === $this->collStudyprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudyprops());
            }
            $query = StudypropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collStudyprops);
    }

    /**
     * Method called to associate a Studyprop object to this object
     * through the Studyprop foreign key attribute.
     *
     * @param    Studyprop $l Studyprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addStudyprop(Studyprop $l)
    {
        if ($this->collStudyprops === null) {
            $this->initStudyprops();
            $this->collStudypropsPartial = true;
        }
        if (!in_array($l, $this->collStudyprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudyprop($l);
        }

        return $this;
    }

    /**
     * @param	Studyprop $studyprop The studyprop object to add.
     */
    protected function doAddStudyprop($studyprop)
    {
        $this->collStudyprops[]= $studyprop;
        $studyprop->setCvterm($this);
    }

    /**
     * @param	Studyprop $studyprop The studyprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeStudyprop($studyprop)
    {
        if ($this->getStudyprops()->contains($studyprop)) {
            $this->collStudyprops->remove($this->collStudyprops->search($studyprop));
            if (null === $this->studypropsScheduledForDeletion) {
                $this->studypropsScheduledForDeletion = clone $this->collStudyprops;
                $this->studypropsScheduledForDeletion->clear();
            }
            $this->studypropsScheduledForDeletion[]= clone $studyprop;
            $studyprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Studyprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studyprop[] List of Studyprop objects
     */
    public function getStudypropsJoinStudy($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudypropQuery::create(null, $criteria);
        $query->joinWith('Study', $join_behavior);

        return $this->getStudyprops($query, $con);
    }

    /**
     * Clears out the collStudypropFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addStudypropFeatures()
     */
    public function clearStudypropFeatures()
    {
        $this->collStudypropFeatures = null; // important to set this to null since that means it is uninitialized
        $this->collStudypropFeaturesPartial = null;

        return $this;
    }

    /**
     * reset is the collStudypropFeatures collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudypropFeatures($v = true)
    {
        $this->collStudypropFeaturesPartial = $v;
    }

    /**
     * Initializes the collStudypropFeatures collection.
     *
     * By default this just sets the collStudypropFeatures collection to an empty array (like clearcollStudypropFeatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudypropFeatures($overrideExisting = true)
    {
        if (null !== $this->collStudypropFeatures && !$overrideExisting) {
            return;
        }
        $this->collStudypropFeatures = new PropelObjectCollection();
        $this->collStudypropFeatures->setModel('StudypropFeature');
    }

    /**
     * Gets an array of StudypropFeature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|StudypropFeature[] List of StudypropFeature objects
     * @throws PropelException
     */
    public function getStudypropFeatures($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudypropFeaturesPartial && !$this->isNew();
        if (null === $this->collStudypropFeatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudypropFeatures) {
                // return empty collection
                $this->initStudypropFeatures();
            } else {
                $collStudypropFeatures = StudypropFeatureQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudypropFeaturesPartial && count($collStudypropFeatures)) {
                      $this->initStudypropFeatures(false);

                      foreach($collStudypropFeatures as $obj) {
                        if (false == $this->collStudypropFeatures->contains($obj)) {
                          $this->collStudypropFeatures->append($obj);
                        }
                      }

                      $this->collStudypropFeaturesPartial = true;
                    }

                    $collStudypropFeatures->getInternalIterator()->rewind();
                    return $collStudypropFeatures;
                }

                if($partial && $this->collStudypropFeatures) {
                    foreach($this->collStudypropFeatures as $obj) {
                        if($obj->isNew()) {
                            $collStudypropFeatures[] = $obj;
                        }
                    }
                }

                $this->collStudypropFeatures = $collStudypropFeatures;
                $this->collStudypropFeaturesPartial = false;
            }
        }

        return $this->collStudypropFeatures;
    }

    /**
     * Sets a collection of StudypropFeature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studypropFeatures A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setStudypropFeatures(PropelCollection $studypropFeatures, PropelPDO $con = null)
    {
        $studypropFeaturesToDelete = $this->getStudypropFeatures(new Criteria(), $con)->diff($studypropFeatures);

        $this->studypropFeaturesScheduledForDeletion = unserialize(serialize($studypropFeaturesToDelete));

        foreach ($studypropFeaturesToDelete as $studypropFeatureRemoved) {
            $studypropFeatureRemoved->setCvterm(null);
        }

        $this->collStudypropFeatures = null;
        foreach ($studypropFeatures as $studypropFeature) {
            $this->addStudypropFeature($studypropFeature);
        }

        $this->collStudypropFeatures = $studypropFeatures;
        $this->collStudypropFeaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StudypropFeature objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related StudypropFeature objects.
     * @throws PropelException
     */
    public function countStudypropFeatures(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudypropFeaturesPartial && !$this->isNew();
        if (null === $this->collStudypropFeatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudypropFeatures) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudypropFeatures());
            }
            $query = StudypropFeatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collStudypropFeatures);
    }

    /**
     * Method called to associate a StudypropFeature object to this object
     * through the StudypropFeature foreign key attribute.
     *
     * @param    StudypropFeature $l StudypropFeature
     * @return Cvterm The current object (for fluent API support)
     */
    public function addStudypropFeature(StudypropFeature $l)
    {
        if ($this->collStudypropFeatures === null) {
            $this->initStudypropFeatures();
            $this->collStudypropFeaturesPartial = true;
        }
        if (!in_array($l, $this->collStudypropFeatures->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudypropFeature($l);
        }

        return $this;
    }

    /**
     * @param	StudypropFeature $studypropFeature The studypropFeature object to add.
     */
    protected function doAddStudypropFeature($studypropFeature)
    {
        $this->collStudypropFeatures[]= $studypropFeature;
        $studypropFeature->setCvterm($this);
    }

    /**
     * @param	StudypropFeature $studypropFeature The studypropFeature object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeStudypropFeature($studypropFeature)
    {
        if ($this->getStudypropFeatures()->contains($studypropFeature)) {
            $this->collStudypropFeatures->remove($this->collStudypropFeatures->search($studypropFeature));
            if (null === $this->studypropFeaturesScheduledForDeletion) {
                $this->studypropFeaturesScheduledForDeletion = clone $this->collStudypropFeatures;
                $this->studypropFeaturesScheduledForDeletion->clear();
            }
            $this->studypropFeaturesScheduledForDeletion[]= $studypropFeature;
            $studypropFeature->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StudypropFeature[] List of StudypropFeature objects
     */
    public function getStudypropFeaturesJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudypropFeatureQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getStudypropFeatures($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StudypropFeature[] List of StudypropFeature objects
     */
    public function getStudypropFeaturesJoinStudyprop($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudypropFeatureQuery::create(null, $criteria);
        $query->joinWith('Studyprop', $join_behavior);

        return $this->getStudypropFeatures($query, $con);
    }

    /**
     * Clears out the collSynonyms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addSynonyms()
     */
    public function clearSynonyms()
    {
        $this->collSynonyms = null; // important to set this to null since that means it is uninitialized
        $this->collSynonymsPartial = null;

        return $this;
    }

    /**
     * reset is the collSynonyms collection loaded partially
     *
     * @return void
     */
    public function resetPartialSynonyms($v = true)
    {
        $this->collSynonymsPartial = $v;
    }

    /**
     * Initializes the collSynonyms collection.
     *
     * By default this just sets the collSynonyms collection to an empty array (like clearcollSynonyms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSynonyms($overrideExisting = true)
    {
        if (null !== $this->collSynonyms && !$overrideExisting) {
            return;
        }
        $this->collSynonyms = new PropelObjectCollection();
        $this->collSynonyms->setModel('Synonym');
    }

    /**
     * Gets an array of Synonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Synonym[] List of Synonym objects
     * @throws PropelException
     */
    public function getSynonyms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSynonymsPartial && !$this->isNew();
        if (null === $this->collSynonyms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSynonyms) {
                // return empty collection
                $this->initSynonyms();
            } else {
                $collSynonyms = SynonymQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSynonymsPartial && count($collSynonyms)) {
                      $this->initSynonyms(false);

                      foreach($collSynonyms as $obj) {
                        if (false == $this->collSynonyms->contains($obj)) {
                          $this->collSynonyms->append($obj);
                        }
                      }

                      $this->collSynonymsPartial = true;
                    }

                    $collSynonyms->getInternalIterator()->rewind();
                    return $collSynonyms;
                }

                if($partial && $this->collSynonyms) {
                    foreach($this->collSynonyms as $obj) {
                        if($obj->isNew()) {
                            $collSynonyms[] = $obj;
                        }
                    }
                }

                $this->collSynonyms = $collSynonyms;
                $this->collSynonymsPartial = false;
            }
        }

        return $this->collSynonyms;
    }

    /**
     * Sets a collection of Synonym objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $synonyms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setSynonyms(PropelCollection $synonyms, PropelPDO $con = null)
    {
        $synonymsToDelete = $this->getSynonyms(new Criteria(), $con)->diff($synonyms);

        $this->synonymsScheduledForDeletion = unserialize(serialize($synonymsToDelete));

        foreach ($synonymsToDelete as $synonymRemoved) {
            $synonymRemoved->setCvterm(null);
        }

        $this->collSynonyms = null;
        foreach ($synonyms as $synonym) {
            $this->addSynonym($synonym);
        }

        $this->collSynonyms = $synonyms;
        $this->collSynonymsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Synonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Synonym objects.
     * @throws PropelException
     */
    public function countSynonyms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSynonymsPartial && !$this->isNew();
        if (null === $this->collSynonyms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSynonyms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getSynonyms());
            }
            $query = SynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collSynonyms);
    }

    /**
     * Method called to associate a Synonym object to this object
     * through the Synonym foreign key attribute.
     *
     * @param    Synonym $l Synonym
     * @return Cvterm The current object (for fluent API support)
     */
    public function addSynonym(Synonym $l)
    {
        if ($this->collSynonyms === null) {
            $this->initSynonyms();
            $this->collSynonymsPartial = true;
        }
        if (!in_array($l, $this->collSynonyms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSynonym($l);
        }

        return $this;
    }

    /**
     * @param	Synonym $synonym The synonym object to add.
     */
    protected function doAddSynonym($synonym)
    {
        $this->collSynonyms[]= $synonym;
        $synonym->setCvterm($this);
    }

    /**
     * @param	Synonym $synonym The synonym object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeSynonym($synonym)
    {
        if ($this->getSynonyms()->contains($synonym)) {
            $this->collSynonyms->remove($this->collSynonyms->search($synonym));
            if (null === $this->synonymsScheduledForDeletion) {
                $this->synonymsScheduledForDeletion = clone $this->collSynonyms;
                $this->synonymsScheduledForDeletion->clear();
            }
            $this->synonymsScheduledForDeletion[]= clone $synonym;
            $synonym->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collTreatments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addTreatments()
     */
    public function clearTreatments()
    {
        $this->collTreatments = null; // important to set this to null since that means it is uninitialized
        $this->collTreatmentsPartial = null;

        return $this;
    }

    /**
     * reset is the collTreatments collection loaded partially
     *
     * @return void
     */
    public function resetPartialTreatments($v = true)
    {
        $this->collTreatmentsPartial = $v;
    }

    /**
     * Initializes the collTreatments collection.
     *
     * By default this just sets the collTreatments collection to an empty array (like clearcollTreatments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTreatments($overrideExisting = true)
    {
        if (null !== $this->collTreatments && !$overrideExisting) {
            return;
        }
        $this->collTreatments = new PropelObjectCollection();
        $this->collTreatments->setModel('Treatment');
    }

    /**
     * Gets an array of Treatment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     * @throws PropelException
     */
    public function getTreatments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTreatmentsPartial && !$this->isNew();
        if (null === $this->collTreatments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTreatments) {
                // return empty collection
                $this->initTreatments();
            } else {
                $collTreatments = TreatmentQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTreatmentsPartial && count($collTreatments)) {
                      $this->initTreatments(false);

                      foreach($collTreatments as $obj) {
                        if (false == $this->collTreatments->contains($obj)) {
                          $this->collTreatments->append($obj);
                        }
                      }

                      $this->collTreatmentsPartial = true;
                    }

                    $collTreatments->getInternalIterator()->rewind();
                    return $collTreatments;
                }

                if($partial && $this->collTreatments) {
                    foreach($this->collTreatments as $obj) {
                        if($obj->isNew()) {
                            $collTreatments[] = $obj;
                        }
                    }
                }

                $this->collTreatments = $collTreatments;
                $this->collTreatmentsPartial = false;
            }
        }

        return $this->collTreatments;
    }

    /**
     * Sets a collection of Treatment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $treatments A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setTreatments(PropelCollection $treatments, PropelPDO $con = null)
    {
        $treatmentsToDelete = $this->getTreatments(new Criteria(), $con)->diff($treatments);

        $this->treatmentsScheduledForDeletion = unserialize(serialize($treatmentsToDelete));

        foreach ($treatmentsToDelete as $treatmentRemoved) {
            $treatmentRemoved->setCvterm(null);
        }

        $this->collTreatments = null;
        foreach ($treatments as $treatment) {
            $this->addTreatment($treatment);
        }

        $this->collTreatments = $treatments;
        $this->collTreatmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Treatment objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Treatment objects.
     * @throws PropelException
     */
    public function countTreatments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTreatmentsPartial && !$this->isNew();
        if (null === $this->collTreatments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTreatments) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTreatments());
            }
            $query = TreatmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collTreatments);
    }

    /**
     * Method called to associate a Treatment object to this object
     * through the Treatment foreign key attribute.
     *
     * @param    Treatment $l Treatment
     * @return Cvterm The current object (for fluent API support)
     */
    public function addTreatment(Treatment $l)
    {
        if ($this->collTreatments === null) {
            $this->initTreatments();
            $this->collTreatmentsPartial = true;
        }
        if (!in_array($l, $this->collTreatments->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTreatment($l);
        }

        return $this;
    }

    /**
     * @param	Treatment $treatment The treatment object to add.
     */
    protected function doAddTreatment($treatment)
    {
        $this->collTreatments[]= $treatment;
        $treatment->setCvterm($this);
    }

    /**
     * @param	Treatment $treatment The treatment object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeTreatment($treatment)
    {
        if ($this->getTreatments()->contains($treatment)) {
            $this->collTreatments->remove($this->collTreatments->search($treatment));
            if (null === $this->treatmentsScheduledForDeletion) {
                $this->treatmentsScheduledForDeletion = clone $this->collTreatments;
                $this->treatmentsScheduledForDeletion->clear();
            }
            $this->treatmentsScheduledForDeletion[]= clone $treatment;
            $treatment->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Treatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     */
    public function getTreatmentsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TreatmentQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getTreatments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Treatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     */
    public function getTreatmentsJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TreatmentQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getTreatments($query, $con);
    }

    /**
     * Clears out the collWebuserDatas collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addWebuserDatas()
     */
    public function clearWebuserDatas()
    {
        $this->collWebuserDatas = null; // important to set this to null since that means it is uninitialized
        $this->collWebuserDatasPartial = null;

        return $this;
    }

    /**
     * reset is the collWebuserDatas collection loaded partially
     *
     * @return void
     */
    public function resetPartialWebuserDatas($v = true)
    {
        $this->collWebuserDatasPartial = $v;
    }

    /**
     * Initializes the collWebuserDatas collection.
     *
     * By default this just sets the collWebuserDatas collection to an empty array (like clearcollWebuserDatas());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initWebuserDatas($overrideExisting = true)
    {
        if (null !== $this->collWebuserDatas && !$overrideExisting) {
            return;
        }
        $this->collWebuserDatas = new PropelObjectCollection();
        $this->collWebuserDatas->setModel('WebuserData');
    }

    /**
     * Gets an array of WebuserData objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|WebuserData[] List of WebuserData objects
     * @throws PropelException
     */
    public function getWebuserDatas($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collWebuserDatasPartial && !$this->isNew();
        if (null === $this->collWebuserDatas || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collWebuserDatas) {
                // return empty collection
                $this->initWebuserDatas();
            } else {
                $collWebuserDatas = WebuserDataQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collWebuserDatasPartial && count($collWebuserDatas)) {
                      $this->initWebuserDatas(false);

                      foreach($collWebuserDatas as $obj) {
                        if (false == $this->collWebuserDatas->contains($obj)) {
                          $this->collWebuserDatas->append($obj);
                        }
                      }

                      $this->collWebuserDatasPartial = true;
                    }

                    $collWebuserDatas->getInternalIterator()->rewind();
                    return $collWebuserDatas;
                }

                if($partial && $this->collWebuserDatas) {
                    foreach($this->collWebuserDatas as $obj) {
                        if($obj->isNew()) {
                            $collWebuserDatas[] = $obj;
                        }
                    }
                }

                $this->collWebuserDatas = $collWebuserDatas;
                $this->collWebuserDatasPartial = false;
            }
        }

        return $this->collWebuserDatas;
    }

    /**
     * Sets a collection of WebuserData objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $webuserDatas A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setWebuserDatas(PropelCollection $webuserDatas, PropelPDO $con = null)
    {
        $webuserDatasToDelete = $this->getWebuserDatas(new Criteria(), $con)->diff($webuserDatas);

        $this->webuserDatasScheduledForDeletion = unserialize(serialize($webuserDatasToDelete));

        foreach ($webuserDatasToDelete as $webuserDataRemoved) {
            $webuserDataRemoved->setCvterm(null);
        }

        $this->collWebuserDatas = null;
        foreach ($webuserDatas as $webuserData) {
            $this->addWebuserData($webuserData);
        }

        $this->collWebuserDatas = $webuserDatas;
        $this->collWebuserDatasPartial = false;

        return $this;
    }

    /**
     * Returns the number of related WebuserData objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related WebuserData objects.
     * @throws PropelException
     */
    public function countWebuserDatas(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collWebuserDatasPartial && !$this->isNew();
        if (null === $this->collWebuserDatas || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collWebuserDatas) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getWebuserDatas());
            }
            $query = WebuserDataQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collWebuserDatas);
    }

    /**
     * Method called to associate a WebuserData object to this object
     * through the WebuserData foreign key attribute.
     *
     * @param    WebuserData $l WebuserData
     * @return Cvterm The current object (for fluent API support)
     */
    public function addWebuserData(WebuserData $l)
    {
        if ($this->collWebuserDatas === null) {
            $this->initWebuserDatas();
            $this->collWebuserDatasPartial = true;
        }
        if (!in_array($l, $this->collWebuserDatas->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddWebuserData($l);
        }

        return $this;
    }

    /**
     * @param	WebuserData $webuserData The webuserData object to add.
     */
    protected function doAddWebuserData($webuserData)
    {
        $this->collWebuserDatas[]= $webuserData;
        $webuserData->setCvterm($this);
    }

    /**
     * @param	WebuserData $webuserData The webuserData object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeWebuserData($webuserData)
    {
        if ($this->getWebuserDatas()->contains($webuserData)) {
            $this->collWebuserDatas->remove($this->collWebuserDatas->search($webuserData));
            if (null === $this->webuserDatasScheduledForDeletion) {
                $this->webuserDatasScheduledForDeletion = clone $this->collWebuserDatas;
                $this->webuserDatasScheduledForDeletion->clear();
            }
            $this->webuserDatasScheduledForDeletion[]= $webuserData;
            $webuserData->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->cvterm_id = null;
        $this->cv_id = null;
        $this->name = null;
        $this->definition = null;
        $this->dbxref_id = null;
        $this->is_obsolete = null;
        $this->is_relationshiptype = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
        $this->applyDefaultValues();
        $this->resetModified();
        $this->setNew(true);
        $this->setDeleted(false);
    }

    /**
     * Resets all references to other model objects or collections of model objects.
     *
     * This method is a user-space workaround for PHP's inability to garbage collect
     * objects with circular references (even in PHP 5.3). This is currently necessary
     * when using Propel in certain daemon or large-volumne/high-memory operations.
     *
     * @param boolean $deep Whether to also clear the references on all referrer objects.
     */
    public function clearAllReferences($deep = false)
    {
        if ($deep && !$this->alreadyInClearAllReferencesDeep) {
            $this->alreadyInClearAllReferencesDeep = true;
            if ($this->collAcquisitionRelationships) {
                foreach ($this->collAcquisitionRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAcquisitionprops) {
                foreach ($this->collAcquisitionprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAnalysisfeatureprops) {
                foreach ($this->collAnalysisfeatureprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAnalysisprops) {
                foreach ($this->collAnalysisprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collArraydesignsRelatedByPlatformtypeId) {
                foreach ($this->collArraydesignsRelatedByPlatformtypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collArraydesignsRelatedBySubstratetypeId) {
                foreach ($this->collArraydesignsRelatedBySubstratetypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collArraydesignprops) {
                foreach ($this->collArraydesignprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssayprops) {
                foreach ($this->collAssayprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialRelationships) {
                foreach ($this->collBiomaterialRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialTreatments) {
                foreach ($this->collBiomaterialTreatments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialprops) {
                foreach ($this->collBiomaterialprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collChadoprops) {
                foreach ($this->collChadoprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContacts) {
                foreach ($this->collContacts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContactRelationships) {
                foreach ($this->collContactRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collControls) {
                foreach ($this->collControls as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvprops) {
                foreach ($this->collCvprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermDbxrefs) {
                foreach ($this->collCvtermDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermRelationshipsRelatedByObjectId) {
                foreach ($this->collCvtermRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermRelationshipsRelatedBySubjectId) {
                foreach ($this->collCvtermRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermRelationshipsRelatedByTypeId) {
                foreach ($this->collCvtermRelationshipsRelatedByTypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpathsRelatedByObjectId) {
                foreach ($this->collCvtermpathsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpathsRelatedBySubjectId) {
                foreach ($this->collCvtermpathsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpathsRelatedByTypeId) {
                foreach ($this->collCvtermpathsRelatedByTypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpropsRelatedByCvtermId) {
                foreach ($this->collCvtermpropsRelatedByCvtermId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermpropsRelatedByTypeId) {
                foreach ($this->collCvtermpropsRelatedByTypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermsynonymsRelatedByCvtermId) {
                foreach ($this->collCvtermsynonymsRelatedByCvtermId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermsynonymsRelatedByTypeId) {
                foreach ($this->collCvtermsynonymsRelatedByTypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDbxrefprops) {
                foreach ($this->collDbxrefprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElements) {
                foreach ($this->collElements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementRelationships) {
                foreach ($this->collElementRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementresultRelationships) {
                foreach ($this->collElementresultRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatures) {
                foreach ($this->collFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvterms) {
                foreach ($this->collFeatureCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermprops) {
                foreach ($this->collFeatureCvtermprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeaturePubprops) {
                foreach ($this->collFeaturePubprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureRelationships) {
                foreach ($this->collFeatureRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureRelationshipprops) {
                foreach ($this->collFeatureRelationshipprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureprops) {
                foreach ($this->collFeatureprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrganismprops) {
                foreach ($this->collOrganismprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectRelationships) {
                foreach ($this->collProjectRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectprops) {
                foreach ($this->collProjectprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProtocols) {
                foreach ($this->collProtocols as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProtocolparamsRelatedByDatatypeId) {
                foreach ($this->collProtocolparamsRelatedByDatatypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProtocolparamsRelatedByUnittypeId) {
                foreach ($this->collProtocolparamsRelatedByUnittypeId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubs) {
                foreach ($this->collPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubRelationships) {
                foreach ($this->collPubRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubprops) {
                foreach ($this->collPubprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationRelationships) {
                foreach ($this->collQuantificationRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationprops) {
                foreach ($this->collQuantificationprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationresults) {
                foreach ($this->collQuantificationresults as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudydesignprops) {
                foreach ($this->collStudydesignprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudyfactors) {
                foreach ($this->collStudyfactors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudyprops) {
                foreach ($this->collStudyprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudypropFeatures) {
                foreach ($this->collStudypropFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSynonyms) {
                foreach ($this->collSynonyms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTreatments) {
                foreach ($this->collTreatments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collWebuserDatas) {
                foreach ($this->collWebuserDatas as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCv instanceof Persistent) {
              $this->aCv->clearAllReferences($deep);
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAcquisitionRelationships instanceof PropelCollection) {
            $this->collAcquisitionRelationships->clearIterator();
        }
        $this->collAcquisitionRelationships = null;
        if ($this->collAcquisitionprops instanceof PropelCollection) {
            $this->collAcquisitionprops->clearIterator();
        }
        $this->collAcquisitionprops = null;
        if ($this->collAnalysisfeatureprops instanceof PropelCollection) {
            $this->collAnalysisfeatureprops->clearIterator();
        }
        $this->collAnalysisfeatureprops = null;
        if ($this->collAnalysisprops instanceof PropelCollection) {
            $this->collAnalysisprops->clearIterator();
        }
        $this->collAnalysisprops = null;
        if ($this->collArraydesignsRelatedByPlatformtypeId instanceof PropelCollection) {
            $this->collArraydesignsRelatedByPlatformtypeId->clearIterator();
        }
        $this->collArraydesignsRelatedByPlatformtypeId = null;
        if ($this->collArraydesignsRelatedBySubstratetypeId instanceof PropelCollection) {
            $this->collArraydesignsRelatedBySubstratetypeId->clearIterator();
        }
        $this->collArraydesignsRelatedBySubstratetypeId = null;
        if ($this->collArraydesignprops instanceof PropelCollection) {
            $this->collArraydesignprops->clearIterator();
        }
        $this->collArraydesignprops = null;
        if ($this->collAssayprops instanceof PropelCollection) {
            $this->collAssayprops->clearIterator();
        }
        $this->collAssayprops = null;
        if ($this->collBiomaterialRelationships instanceof PropelCollection) {
            $this->collBiomaterialRelationships->clearIterator();
        }
        $this->collBiomaterialRelationships = null;
        if ($this->collBiomaterialTreatments instanceof PropelCollection) {
            $this->collBiomaterialTreatments->clearIterator();
        }
        $this->collBiomaterialTreatments = null;
        if ($this->collBiomaterialprops instanceof PropelCollection) {
            $this->collBiomaterialprops->clearIterator();
        }
        $this->collBiomaterialprops = null;
        if ($this->collChadoprops instanceof PropelCollection) {
            $this->collChadoprops->clearIterator();
        }
        $this->collChadoprops = null;
        if ($this->collContacts instanceof PropelCollection) {
            $this->collContacts->clearIterator();
        }
        $this->collContacts = null;
        if ($this->collContactRelationships instanceof PropelCollection) {
            $this->collContactRelationships->clearIterator();
        }
        $this->collContactRelationships = null;
        if ($this->collControls instanceof PropelCollection) {
            $this->collControls->clearIterator();
        }
        $this->collControls = null;
        if ($this->collCvprops instanceof PropelCollection) {
            $this->collCvprops->clearIterator();
        }
        $this->collCvprops = null;
        if ($this->collCvtermDbxrefs instanceof PropelCollection) {
            $this->collCvtermDbxrefs->clearIterator();
        }
        $this->collCvtermDbxrefs = null;
        if ($this->collCvtermRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collCvtermRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collCvtermRelationshipsRelatedByObjectId = null;
        if ($this->collCvtermRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collCvtermRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collCvtermRelationshipsRelatedBySubjectId = null;
        if ($this->collCvtermRelationshipsRelatedByTypeId instanceof PropelCollection) {
            $this->collCvtermRelationshipsRelatedByTypeId->clearIterator();
        }
        $this->collCvtermRelationshipsRelatedByTypeId = null;
        if ($this->collCvtermpathsRelatedByObjectId instanceof PropelCollection) {
            $this->collCvtermpathsRelatedByObjectId->clearIterator();
        }
        $this->collCvtermpathsRelatedByObjectId = null;
        if ($this->collCvtermpathsRelatedBySubjectId instanceof PropelCollection) {
            $this->collCvtermpathsRelatedBySubjectId->clearIterator();
        }
        $this->collCvtermpathsRelatedBySubjectId = null;
        if ($this->collCvtermpathsRelatedByTypeId instanceof PropelCollection) {
            $this->collCvtermpathsRelatedByTypeId->clearIterator();
        }
        $this->collCvtermpathsRelatedByTypeId = null;
        if ($this->collCvtermpropsRelatedByCvtermId instanceof PropelCollection) {
            $this->collCvtermpropsRelatedByCvtermId->clearIterator();
        }
        $this->collCvtermpropsRelatedByCvtermId = null;
        if ($this->collCvtermpropsRelatedByTypeId instanceof PropelCollection) {
            $this->collCvtermpropsRelatedByTypeId->clearIterator();
        }
        $this->collCvtermpropsRelatedByTypeId = null;
        if ($this->collCvtermsynonymsRelatedByCvtermId instanceof PropelCollection) {
            $this->collCvtermsynonymsRelatedByCvtermId->clearIterator();
        }
        $this->collCvtermsynonymsRelatedByCvtermId = null;
        if ($this->collCvtermsynonymsRelatedByTypeId instanceof PropelCollection) {
            $this->collCvtermsynonymsRelatedByTypeId->clearIterator();
        }
        $this->collCvtermsynonymsRelatedByTypeId = null;
        if ($this->collDbxrefprops instanceof PropelCollection) {
            $this->collDbxrefprops->clearIterator();
        }
        $this->collDbxrefprops = null;
        if ($this->collElements instanceof PropelCollection) {
            $this->collElements->clearIterator();
        }
        $this->collElements = null;
        if ($this->collElementRelationships instanceof PropelCollection) {
            $this->collElementRelationships->clearIterator();
        }
        $this->collElementRelationships = null;
        if ($this->collElementresultRelationships instanceof PropelCollection) {
            $this->collElementresultRelationships->clearIterator();
        }
        $this->collElementresultRelationships = null;
        if ($this->collFeatures instanceof PropelCollection) {
            $this->collFeatures->clearIterator();
        }
        $this->collFeatures = null;
        if ($this->collFeatureCvterms instanceof PropelCollection) {
            $this->collFeatureCvterms->clearIterator();
        }
        $this->collFeatureCvterms = null;
        if ($this->collFeatureCvtermprops instanceof PropelCollection) {
            $this->collFeatureCvtermprops->clearIterator();
        }
        $this->collFeatureCvtermprops = null;
        if ($this->collFeaturePubprops instanceof PropelCollection) {
            $this->collFeaturePubprops->clearIterator();
        }
        $this->collFeaturePubprops = null;
        if ($this->collFeatureRelationships instanceof PropelCollection) {
            $this->collFeatureRelationships->clearIterator();
        }
        $this->collFeatureRelationships = null;
        if ($this->collFeatureRelationshipprops instanceof PropelCollection) {
            $this->collFeatureRelationshipprops->clearIterator();
        }
        $this->collFeatureRelationshipprops = null;
        if ($this->collFeatureprops instanceof PropelCollection) {
            $this->collFeatureprops->clearIterator();
        }
        $this->collFeatureprops = null;
        if ($this->collOrganismprops instanceof PropelCollection) {
            $this->collOrganismprops->clearIterator();
        }
        $this->collOrganismprops = null;
        if ($this->collProjectRelationships instanceof PropelCollection) {
            $this->collProjectRelationships->clearIterator();
        }
        $this->collProjectRelationships = null;
        if ($this->collProjectprops instanceof PropelCollection) {
            $this->collProjectprops->clearIterator();
        }
        $this->collProjectprops = null;
        if ($this->collProtocols instanceof PropelCollection) {
            $this->collProtocols->clearIterator();
        }
        $this->collProtocols = null;
        if ($this->collProtocolparamsRelatedByDatatypeId instanceof PropelCollection) {
            $this->collProtocolparamsRelatedByDatatypeId->clearIterator();
        }
        $this->collProtocolparamsRelatedByDatatypeId = null;
        if ($this->collProtocolparamsRelatedByUnittypeId instanceof PropelCollection) {
            $this->collProtocolparamsRelatedByUnittypeId->clearIterator();
        }
        $this->collProtocolparamsRelatedByUnittypeId = null;
        if ($this->collPubs instanceof PropelCollection) {
            $this->collPubs->clearIterator();
        }
        $this->collPubs = null;
        if ($this->collPubRelationships instanceof PropelCollection) {
            $this->collPubRelationships->clearIterator();
        }
        $this->collPubRelationships = null;
        if ($this->collPubprops instanceof PropelCollection) {
            $this->collPubprops->clearIterator();
        }
        $this->collPubprops = null;
        if ($this->collQuantificationRelationships instanceof PropelCollection) {
            $this->collQuantificationRelationships->clearIterator();
        }
        $this->collQuantificationRelationships = null;
        if ($this->collQuantificationprops instanceof PropelCollection) {
            $this->collQuantificationprops->clearIterator();
        }
        $this->collQuantificationprops = null;
        if ($this->collQuantificationresults instanceof PropelCollection) {
            $this->collQuantificationresults->clearIterator();
        }
        $this->collQuantificationresults = null;
        if ($this->collStudydesignprops instanceof PropelCollection) {
            $this->collStudydesignprops->clearIterator();
        }
        $this->collStudydesignprops = null;
        if ($this->collStudyfactors instanceof PropelCollection) {
            $this->collStudyfactors->clearIterator();
        }
        $this->collStudyfactors = null;
        if ($this->collStudyprops instanceof PropelCollection) {
            $this->collStudyprops->clearIterator();
        }
        $this->collStudyprops = null;
        if ($this->collStudypropFeatures instanceof PropelCollection) {
            $this->collStudypropFeatures->clearIterator();
        }
        $this->collStudypropFeatures = null;
        if ($this->collSynonyms instanceof PropelCollection) {
            $this->collSynonyms->clearIterator();
        }
        $this->collSynonyms = null;
        if ($this->collTreatments instanceof PropelCollection) {
            $this->collTreatments->clearIterator();
        }
        $this->collTreatments = null;
        if ($this->collWebuserDatas instanceof PropelCollection) {
            $this->collWebuserDatas->clearIterator();
        }
        $this->collWebuserDatas = null;
        $this->aCv = null;
        $this->aDbxref = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CvtermPeer::DEFAULT_STRING_FORMAT);
    }

    /**
     * return true is the object is in saving state
     *
     * @return boolean
     */
    public function isAlreadyInSave()
    {
        return $this->alreadyInSave;
    }

}
