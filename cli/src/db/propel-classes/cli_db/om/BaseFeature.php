<?php

namespace cli_db\propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\Analysisfeature;
use cli_db\propel\AnalysisfeatureQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Element;
use cli_db\propel\ElementQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\FeatureDbxrefQuery;
use cli_db\propel\FeaturePeer;
use cli_db\propel\FeaturePub;
use cli_db\propel\FeaturePubQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipQuery;
use cli_db\propel\FeatureSynonym;
use cli_db\propel\FeatureSynonymQuery;
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocQuery;
use cli_db\propel\Featureprop;
use cli_db\propel\FeaturepropQuery;
use cli_db\propel\Organism;
use cli_db\propel\OrganismQuery;
use cli_db\propel\Quantificationresult;
use cli_db\propel\QuantificationresultQuery;
use cli_db\propel\StudypropFeature;
use cli_db\propel\StudypropFeatureQuery;

/**
 * Base class that represents a row from the 'feature' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeature extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeaturePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeaturePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * The value for the organism_id field.
     * @var        int
     */
    protected $organism_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the uniquename field.
     * @var        string
     */
    protected $uniquename;

    /**
     * The value for the residues field.
     * @var        string
     */
    protected $residues;

    /**
     * The value for the seqlen field.
     * @var        int
     */
    protected $seqlen;

    /**
     * The value for the md5checksum field.
     * @var        string
     */
    protected $md5checksum;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the is_analysis field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_analysis;

    /**
     * The value for the is_obsolete field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_obsolete;

    /**
     * The value for the timeaccessioned field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $timeaccessioned;

    /**
     * The value for the timelastmodified field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $timelastmodified;

    /**
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        Organism
     */
    protected $aOrganism;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|Analysisfeature[] Collection to store aggregation of Analysisfeature objects.
     */
    protected $collAnalysisfeatures;
    protected $collAnalysisfeaturesPartial;

    /**
     * @var        PropelObjectCollection|Element[] Collection to store aggregation of Element objects.
     */
    protected $collElements;
    protected $collElementsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvterm[] Collection to store aggregation of FeatureCvterm objects.
     */
    protected $collFeatureCvterms;
    protected $collFeatureCvtermsPartial;

    /**
     * @var        PropelObjectCollection|FeatureDbxref[] Collection to store aggregation of FeatureDbxref objects.
     */
    protected $collFeatureDbxrefs;
    protected $collFeatureDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|FeaturePub[] Collection to store aggregation of FeaturePub objects.
     */
    protected $collFeaturePubs;
    protected $collFeaturePubsPartial;

    /**
     * @var        PropelObjectCollection|FeatureRelationship[] Collection to store aggregation of FeatureRelationship objects.
     */
    protected $collFeatureRelationshipsRelatedByObjectId;
    protected $collFeatureRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|FeatureRelationship[] Collection to store aggregation of FeatureRelationship objects.
     */
    protected $collFeatureRelationshipsRelatedBySubjectId;
    protected $collFeatureRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|FeatureSynonym[] Collection to store aggregation of FeatureSynonym objects.
     */
    protected $collFeatureSynonyms;
    protected $collFeatureSynonymsPartial;

    /**
     * @var        PropelObjectCollection|Featureloc[] Collection to store aggregation of Featureloc objects.
     */
    protected $collFeaturelocsRelatedByFeatureId;
    protected $collFeaturelocsRelatedByFeatureIdPartial;

    /**
     * @var        PropelObjectCollection|Featureloc[] Collection to store aggregation of Featureloc objects.
     */
    protected $collFeaturelocsRelatedBySrcfeatureId;
    protected $collFeaturelocsRelatedBySrcfeatureIdPartial;

    /**
     * @var        PropelObjectCollection|Featureprop[] Collection to store aggregation of Featureprop objects.
     */
    protected $collFeatureprops;
    protected $collFeaturepropsPartial;

    /**
     * @var        PropelObjectCollection|Quantificationresult[] Collection to store aggregation of Quantificationresult objects.
     */
    protected $collQuantificationresults;
    protected $collQuantificationresultsPartial;

    /**
     * @var        PropelObjectCollection|StudypropFeature[] Collection to store aggregation of StudypropFeature objects.
     */
    protected $collStudypropFeatures;
    protected $collStudypropFeaturesPartial;

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
    protected $analysisfeaturesScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurePubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureSynonymsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurelocsRelatedByFeatureIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurelocsRelatedBySrcfeatureIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurepropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationresultsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studypropFeaturesScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_analysis = false;
        $this->is_obsolete = false;
    }

    /**
     * Initializes internal state of BaseFeature object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [feature_id] column value.
     *
     * @return int
     */
    public function getFeatureId()
    {
        return $this->feature_id;
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
     * Get the [organism_id] column value.
     *
     * @return int
     */
    public function getOrganismId()
    {
        return $this->organism_id;
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
     * Get the [uniquename] column value.
     *
     * @return string
     */
    public function getUniquename()
    {
        return $this->uniquename;
    }

    /**
     * Get the [residues] column value.
     *
     * @return string
     */
    public function getResidues()
    {
        return $this->residues;
    }

    /**
     * Get the [seqlen] column value.
     *
     * @return int
     */
    public function getSeqlen()
    {
        return $this->seqlen;
    }

    /**
     * Get the [md5checksum] column value.
     *
     * @return string
     */
    public function getMd5checksum()
    {
        return $this->md5checksum;
    }

    /**
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Get the [is_analysis] column value.
     *
     * @return boolean
     */
    public function getIsAnalysis()
    {
        return $this->is_analysis;
    }

    /**
     * Get the [is_obsolete] column value.
     *
     * @return boolean
     */
    public function getIsObsolete()
    {
        return $this->is_obsolete;
    }

    /**
     * Get the [optionally formatted] temporal [timeaccessioned] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimeaccessioned($format = 'Y-m-d H:i:s')
    {
        if ($this->timeaccessioned === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->timeaccessioned);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->timeaccessioned, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [optionally formatted] temporal [timelastmodified] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimelastmodified($format = 'Y-m-d H:i:s')
    {
        if ($this->timelastmodified === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->timelastmodified);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->timelastmodified, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = FeaturePeer::FEATURE_ID;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = FeaturePeer::DBXREF_ID;
        }

        if ($this->aDbxref !== null && $this->aDbxref->getDbxrefId() !== $v) {
            $this->aDbxref = null;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [organism_id] column.
     *
     * @param int $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setOrganismId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->organism_id !== $v) {
            $this->organism_id = $v;
            $this->modifiedColumns[] = FeaturePeer::ORGANISM_ID;
        }

        if ($this->aOrganism !== null && $this->aOrganism->getOrganismId() !== $v) {
            $this->aOrganism = null;
        }


        return $this;
    } // setOrganismId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = FeaturePeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [uniquename] column.
     *
     * @param string $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setUniquename($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->uniquename !== $v) {
            $this->uniquename = $v;
            $this->modifiedColumns[] = FeaturePeer::UNIQUENAME;
        }


        return $this;
    } // setUniquename()

    /**
     * Set the value of [residues] column.
     *
     * @param string $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setResidues($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->residues !== $v) {
            $this->residues = $v;
            $this->modifiedColumns[] = FeaturePeer::RESIDUES;
        }


        return $this;
    } // setResidues()

    /**
     * Set the value of [seqlen] column.
     *
     * @param int $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setSeqlen($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->seqlen !== $v) {
            $this->seqlen = $v;
            $this->modifiedColumns[] = FeaturePeer::SEQLEN;
        }


        return $this;
    } // setSeqlen()

    /**
     * Set the value of [md5checksum] column.
     *
     * @param string $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setMd5checksum($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->md5checksum !== $v) {
            $this->md5checksum = $v;
            $this->modifiedColumns[] = FeaturePeer::MD5CHECKSUM;
        }


        return $this;
    } // setMd5checksum()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Feature The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = FeaturePeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Sets the value of the [is_analysis] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Feature The current object (for fluent API support)
     */
    public function setIsAnalysis($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_analysis !== $v) {
            $this->is_analysis = $v;
            $this->modifiedColumns[] = FeaturePeer::IS_ANALYSIS;
        }


        return $this;
    } // setIsAnalysis()

    /**
     * Sets the value of the [is_obsolete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Feature The current object (for fluent API support)
     */
    public function setIsObsolete($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_obsolete !== $v) {
            $this->is_obsolete = $v;
            $this->modifiedColumns[] = FeaturePeer::IS_OBSOLETE;
        }


        return $this;
    } // setIsObsolete()

    /**
     * Sets the value of [timeaccessioned] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Feature The current object (for fluent API support)
     */
    public function setTimeaccessioned($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timeaccessioned !== null || $dt !== null) {
            $currentDateAsString = ($this->timeaccessioned !== null && $tmpDt = new DateTime($this->timeaccessioned)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->timeaccessioned = $newDateAsString;
                $this->modifiedColumns[] = FeaturePeer::TIMEACCESSIONED;
            }
        } // if either are not null


        return $this;
    } // setTimeaccessioned()

    /**
     * Sets the value of [timelastmodified] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Feature The current object (for fluent API support)
     */
    public function setTimelastmodified($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timelastmodified !== null || $dt !== null) {
            $currentDateAsString = ($this->timelastmodified !== null && $tmpDt = new DateTime($this->timelastmodified)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->timelastmodified = $newDateAsString;
                $this->modifiedColumns[] = FeaturePeer::TIMELASTMODIFIED;
            }
        } // if either are not null


        return $this;
    } // setTimelastmodified()

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
            if ($this->is_analysis !== false) {
                return false;
            }

            if ($this->is_obsolete !== false) {
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

            $this->feature_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->dbxref_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->organism_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->uniquename = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->residues = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->seqlen = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->md5checksum = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->type_id = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->is_analysis = ($row[$startcol + 9] !== null) ? (boolean) $row[$startcol + 9] : null;
            $this->is_obsolete = ($row[$startcol + 10] !== null) ? (boolean) $row[$startcol + 10] : null;
            $this->timeaccessioned = ($row[$startcol + 11] !== null) ? (string) $row[$startcol + 11] : null;
            $this->timelastmodified = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 13; // 13 = FeaturePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Feature object", $e);
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

        if ($this->aDbxref !== null && $this->dbxref_id !== $this->aDbxref->getDbxrefId()) {
            $this->aDbxref = null;
        }
        if ($this->aOrganism !== null && $this->organism_id !== $this->aOrganism->getOrganismId()) {
            $this->aOrganism = null;
        }
        if ($this->aCvterm !== null && $this->type_id !== $this->aCvterm->getCvtermId()) {
            $this->aCvterm = null;
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
            $con = Propel::getConnection(FeaturePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeaturePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDbxref = null;
            $this->aOrganism = null;
            $this->aCvterm = null;
            $this->collAnalysisfeatures = null;

            $this->collElements = null;

            $this->collFeatureCvterms = null;

            $this->collFeatureDbxrefs = null;

            $this->collFeaturePubs = null;

            $this->collFeatureRelationshipsRelatedByObjectId = null;

            $this->collFeatureRelationshipsRelatedBySubjectId = null;

            $this->collFeatureSynonyms = null;

            $this->collFeaturelocsRelatedByFeatureId = null;

            $this->collFeaturelocsRelatedBySrcfeatureId = null;

            $this->collFeatureprops = null;

            $this->collQuantificationresults = null;

            $this->collStudypropFeatures = null;

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
            $con = Propel::getConnection(FeaturePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeatureQuery::create()
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
            $con = Propel::getConnection(FeaturePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeaturePeer::addInstanceToPool($this);
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

            if ($this->aDbxref !== null) {
                if ($this->aDbxref->isModified() || $this->aDbxref->isNew()) {
                    $affectedRows += $this->aDbxref->save($con);
                }
                $this->setDbxref($this->aDbxref);
            }

            if ($this->aOrganism !== null) {
                if ($this->aOrganism->isModified() || $this->aOrganism->isNew()) {
                    $affectedRows += $this->aOrganism->save($con);
                }
                $this->setOrganism($this->aOrganism);
            }

            if ($this->aCvterm !== null) {
                if ($this->aCvterm->isModified() || $this->aCvterm->isNew()) {
                    $affectedRows += $this->aCvterm->save($con);
                }
                $this->setCvterm($this->aCvterm);
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

            if ($this->analysisfeaturesScheduledForDeletion !== null) {
                if (!$this->analysisfeaturesScheduledForDeletion->isEmpty()) {
                    AnalysisfeatureQuery::create()
                        ->filterByPrimaryKeys($this->analysisfeaturesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->analysisfeaturesScheduledForDeletion = null;
                }
            }

            if ($this->collAnalysisfeatures !== null) {
                foreach ($this->collAnalysisfeatures as $referrerFK) {
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

            if ($this->featureDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureDbxrefs !== null) {
                foreach ($this->collFeatureDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurePubsScheduledForDeletion !== null) {
                if (!$this->featurePubsScheduledForDeletion->isEmpty()) {
                    FeaturePubQuery::create()
                        ->filterByPrimaryKeys($this->featurePubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurePubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturePubs !== null) {
                foreach ($this->collFeaturePubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->featureRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    FeatureRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->featureRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collFeatureRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    FeatureRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collFeatureRelationshipsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureSynonymsScheduledForDeletion !== null) {
                if (!$this->featureSynonymsScheduledForDeletion->isEmpty()) {
                    FeatureSynonymQuery::create()
                        ->filterByPrimaryKeys($this->featureSynonymsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureSynonymsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureSynonyms !== null) {
                foreach ($this->collFeatureSynonyms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurelocsRelatedByFeatureIdScheduledForDeletion !== null) {
                if (!$this->featurelocsRelatedByFeatureIdScheduledForDeletion->isEmpty()) {
                    FeaturelocQuery::create()
                        ->filterByPrimaryKeys($this->featurelocsRelatedByFeatureIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurelocsRelatedByFeatureIdScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturelocsRelatedByFeatureId !== null) {
                foreach ($this->collFeaturelocsRelatedByFeatureId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion !== null) {
                if (!$this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion->isEmpty()) {
                    foreach ($this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion as $featurelocRelatedBySrcfeatureId) {
                        // need to save related object because we set the relation to null
                        $featurelocRelatedBySrcfeatureId->save($con);
                    }
                    $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturelocsRelatedBySrcfeatureId !== null) {
                foreach ($this->collFeaturelocsRelatedBySrcfeatureId as $referrerFK) {
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

            if ($this->studypropFeaturesScheduledForDeletion !== null) {
                if (!$this->studypropFeaturesScheduledForDeletion->isEmpty()) {
                    StudypropFeatureQuery::create()
                        ->filterByPrimaryKeys($this->studypropFeaturesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[] = FeaturePeer::FEATURE_ID;
        if (null !== $this->feature_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeaturePeer::FEATURE_ID . ')');
        }
        if (null === $this->feature_id) {
            try {
                $stmt = $con->query("SELECT nextval('feature_feature_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->feature_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeaturePeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(FeaturePeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(FeaturePeer::ORGANISM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"organism_id"';
        }
        if ($this->isColumnModified(FeaturePeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(FeaturePeer::UNIQUENAME)) {
            $modifiedColumns[':p' . $index++]  = '"uniquename"';
        }
        if ($this->isColumnModified(FeaturePeer::RESIDUES)) {
            $modifiedColumns[':p' . $index++]  = '"residues"';
        }
        if ($this->isColumnModified(FeaturePeer::SEQLEN)) {
            $modifiedColumns[':p' . $index++]  = '"seqlen"';
        }
        if ($this->isColumnModified(FeaturePeer::MD5CHECKSUM)) {
            $modifiedColumns[':p' . $index++]  = '"md5checksum"';
        }
        if ($this->isColumnModified(FeaturePeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(FeaturePeer::IS_ANALYSIS)) {
            $modifiedColumns[':p' . $index++]  = '"is_analysis"';
        }
        if ($this->isColumnModified(FeaturePeer::IS_OBSOLETE)) {
            $modifiedColumns[':p' . $index++]  = '"is_obsolete"';
        }
        if ($this->isColumnModified(FeaturePeer::TIMEACCESSIONED)) {
            $modifiedColumns[':p' . $index++]  = '"timeaccessioned"';
        }
        if ($this->isColumnModified(FeaturePeer::TIMELASTMODIFIED)) {
            $modifiedColumns[':p' . $index++]  = '"timelastmodified"';
        }

        $sql = sprintf(
            'INSERT INTO "feature" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"organism_id"':
                        $stmt->bindValue($identifier, $this->organism_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"uniquename"':
                        $stmt->bindValue($identifier, $this->uniquename, PDO::PARAM_STR);
                        break;
                    case '"residues"':
                        $stmt->bindValue($identifier, $this->residues, PDO::PARAM_STR);
                        break;
                    case '"seqlen"':
                        $stmt->bindValue($identifier, $this->seqlen, PDO::PARAM_INT);
                        break;
                    case '"md5checksum"':
                        $stmt->bindValue($identifier, $this->md5checksum, PDO::PARAM_STR);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"is_analysis"':
                        $stmt->bindValue($identifier, $this->is_analysis, PDO::PARAM_BOOL);
                        break;
                    case '"is_obsolete"':
                        $stmt->bindValue($identifier, $this->is_obsolete, PDO::PARAM_BOOL);
                        break;
                    case '"timeaccessioned"':
                        $stmt->bindValue($identifier, $this->timeaccessioned, PDO::PARAM_STR);
                        break;
                    case '"timelastmodified"':
                        $stmt->bindValue($identifier, $this->timelastmodified, PDO::PARAM_STR);
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

            if ($this->aDbxref !== null) {
                if (!$this->aDbxref->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDbxref->getValidationFailures());
                }
            }

            if ($this->aOrganism !== null) {
                if (!$this->aOrganism->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aOrganism->getValidationFailures());
                }
            }

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = FeaturePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAnalysisfeatures !== null) {
                    foreach ($this->collAnalysisfeatures as $referrerFK) {
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

                if ($this->collFeatureCvterms !== null) {
                    foreach ($this->collFeatureCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureDbxrefs !== null) {
                    foreach ($this->collFeatureDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeaturePubs !== null) {
                    foreach ($this->collFeaturePubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collFeatureRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collFeatureRelationshipsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureSynonyms !== null) {
                    foreach ($this->collFeatureSynonyms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeaturelocsRelatedByFeatureId !== null) {
                    foreach ($this->collFeaturelocsRelatedByFeatureId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeaturelocsRelatedBySrcfeatureId !== null) {
                    foreach ($this->collFeaturelocsRelatedBySrcfeatureId as $referrerFK) {
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

                if ($this->collQuantificationresults !== null) {
                    foreach ($this->collQuantificationresults as $referrerFK) {
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
        $pos = FeaturePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeatureId();
                break;
            case 1:
                return $this->getDbxrefId();
                break;
            case 2:
                return $this->getOrganismId();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
                return $this->getUniquename();
                break;
            case 5:
                return $this->getResidues();
                break;
            case 6:
                return $this->getSeqlen();
                break;
            case 7:
                return $this->getMd5checksum();
                break;
            case 8:
                return $this->getTypeId();
                break;
            case 9:
                return $this->getIsAnalysis();
                break;
            case 10:
                return $this->getIsObsolete();
                break;
            case 11:
                return $this->getTimeaccessioned();
                break;
            case 12:
                return $this->getTimelastmodified();
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
        if (isset($alreadyDumpedObjects['Feature'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Feature'][$this->getPrimaryKey()] = true;
        $keys = FeaturePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeatureId(),
            $keys[1] => $this->getDbxrefId(),
            $keys[2] => $this->getOrganismId(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getUniquename(),
            $keys[5] => $this->getResidues(),
            $keys[6] => $this->getSeqlen(),
            $keys[7] => $this->getMd5checksum(),
            $keys[8] => $this->getTypeId(),
            $keys[9] => $this->getIsAnalysis(),
            $keys[10] => $this->getIsObsolete(),
            $keys[11] => $this->getTimeaccessioned(),
            $keys[12] => $this->getTimelastmodified(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrganism) {
                $result['Organism'] = $this->aOrganism->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAnalysisfeatures) {
                $result['Analysisfeatures'] = $this->collAnalysisfeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElements) {
                $result['Elements'] = $this->collElements->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvterms) {
                $result['FeatureCvterms'] = $this->collFeatureCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureDbxrefs) {
                $result['FeatureDbxrefs'] = $this->collFeatureDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeaturePubs) {
                $result['FeaturePubs'] = $this->collFeaturePubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureRelationshipsRelatedByObjectId) {
                $result['FeatureRelationshipsRelatedByObjectId'] = $this->collFeatureRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureRelationshipsRelatedBySubjectId) {
                $result['FeatureRelationshipsRelatedBySubjectId'] = $this->collFeatureRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureSynonyms) {
                $result['FeatureSynonyms'] = $this->collFeatureSynonyms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeaturelocsRelatedByFeatureId) {
                $result['FeaturelocsRelatedByFeatureId'] = $this->collFeaturelocsRelatedByFeatureId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeaturelocsRelatedBySrcfeatureId) {
                $result['FeaturelocsRelatedBySrcfeatureId'] = $this->collFeaturelocsRelatedBySrcfeatureId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureprops) {
                $result['Featureprops'] = $this->collFeatureprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationresults) {
                $result['Quantificationresults'] = $this->collQuantificationresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudypropFeatures) {
                $result['StudypropFeatures'] = $this->collStudypropFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FeaturePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeatureId($value);
                break;
            case 1:
                $this->setDbxrefId($value);
                break;
            case 2:
                $this->setOrganismId($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
                $this->setUniquename($value);
                break;
            case 5:
                $this->setResidues($value);
                break;
            case 6:
                $this->setSeqlen($value);
                break;
            case 7:
                $this->setMd5checksum($value);
                break;
            case 8:
                $this->setTypeId($value);
                break;
            case 9:
                $this->setIsAnalysis($value);
                break;
            case 10:
                $this->setIsObsolete($value);
                break;
            case 11:
                $this->setTimeaccessioned($value);
                break;
            case 12:
                $this->setTimelastmodified($value);
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
        $keys = FeaturePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeatureId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setDbxrefId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOrganismId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUniquename($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setResidues($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSeqlen($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setMd5checksum($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setTypeId($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setIsAnalysis($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setIsObsolete($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setTimeaccessioned($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setTimelastmodified($arr[$keys[12]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeaturePeer::DATABASE_NAME);

        if ($this->isColumnModified(FeaturePeer::FEATURE_ID)) $criteria->add(FeaturePeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(FeaturePeer::DBXREF_ID)) $criteria->add(FeaturePeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(FeaturePeer::ORGANISM_ID)) $criteria->add(FeaturePeer::ORGANISM_ID, $this->organism_id);
        if ($this->isColumnModified(FeaturePeer::NAME)) $criteria->add(FeaturePeer::NAME, $this->name);
        if ($this->isColumnModified(FeaturePeer::UNIQUENAME)) $criteria->add(FeaturePeer::UNIQUENAME, $this->uniquename);
        if ($this->isColumnModified(FeaturePeer::RESIDUES)) $criteria->add(FeaturePeer::RESIDUES, $this->residues);
        if ($this->isColumnModified(FeaturePeer::SEQLEN)) $criteria->add(FeaturePeer::SEQLEN, $this->seqlen);
        if ($this->isColumnModified(FeaturePeer::MD5CHECKSUM)) $criteria->add(FeaturePeer::MD5CHECKSUM, $this->md5checksum);
        if ($this->isColumnModified(FeaturePeer::TYPE_ID)) $criteria->add(FeaturePeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(FeaturePeer::IS_ANALYSIS)) $criteria->add(FeaturePeer::IS_ANALYSIS, $this->is_analysis);
        if ($this->isColumnModified(FeaturePeer::IS_OBSOLETE)) $criteria->add(FeaturePeer::IS_OBSOLETE, $this->is_obsolete);
        if ($this->isColumnModified(FeaturePeer::TIMEACCESSIONED)) $criteria->add(FeaturePeer::TIMEACCESSIONED, $this->timeaccessioned);
        if ($this->isColumnModified(FeaturePeer::TIMELASTMODIFIED)) $criteria->add(FeaturePeer::TIMELASTMODIFIED, $this->timelastmodified);

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
        $criteria = new Criteria(FeaturePeer::DATABASE_NAME);
        $criteria->add(FeaturePeer::FEATURE_ID, $this->feature_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeatureId();
    }

    /**
     * Generic method to set the primary key (feature_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeatureId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeatureId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Feature (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setOrganismId($this->getOrganismId());
        $copyObj->setName($this->getName());
        $copyObj->setUniquename($this->getUniquename());
        $copyObj->setResidues($this->getResidues());
        $copyObj->setSeqlen($this->getSeqlen());
        $copyObj->setMd5checksum($this->getMd5checksum());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setIsAnalysis($this->getIsAnalysis());
        $copyObj->setIsObsolete($this->getIsObsolete());
        $copyObj->setTimeaccessioned($this->getTimeaccessioned());
        $copyObj->setTimelastmodified($this->getTimelastmodified());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAnalysisfeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnalysisfeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElement($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeaturePubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturePub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureSynonyms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureSynonym($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeaturelocsRelatedByFeatureId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturelocRelatedByFeatureId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeaturelocsRelatedBySrcfeatureId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturelocRelatedBySrcfeatureId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationresults() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationresult($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudypropFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudypropFeature($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setFeatureId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Feature Clone of current object.
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
     * @return FeaturePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeaturePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Feature The current object (for fluent API support)
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
            $v->addFeature($this);
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
                $this->aDbxref->addFeatures($this);
             */
        }

        return $this->aDbxref;
    }

    /**
     * Declares an association between this object and a Organism object.
     *
     * @param             Organism $v
     * @return Feature The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrganism(Organism $v = null)
    {
        if ($v === null) {
            $this->setOrganismId(NULL);
        } else {
            $this->setOrganismId($v->getOrganismId());
        }

        $this->aOrganism = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Organism object, it will not be re-added.
        if ($v !== null) {
            $v->addFeature($this);
        }


        return $this;
    }


    /**
     * Get the associated Organism object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Organism The associated Organism object.
     * @throws PropelException
     */
    public function getOrganism(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aOrganism === null && ($this->organism_id !== null) && $doQuery) {
            $this->aOrganism = OrganismQuery::create()->findPk($this->organism_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrganism->addFeatures($this);
             */
        }

        return $this->aOrganism;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Feature The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvterm(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setTypeId(NULL);
        } else {
            $this->setTypeId($v->getCvtermId());
        }

        $this->aCvterm = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addFeature($this);
        }


        return $this;
    }


    /**
     * Get the associated Cvterm object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Cvterm The associated Cvterm object.
     * @throws PropelException
     */
    public function getCvterm(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvterm === null && ($this->type_id !== null) && $doQuery) {
            $this->aCvterm = CvtermQuery::create()->findPk($this->type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvterm->addFeatures($this);
             */
        }

        return $this->aCvterm;
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
        if ('Analysisfeature' == $relationName) {
            $this->initAnalysisfeatures();
        }
        if ('Element' == $relationName) {
            $this->initElements();
        }
        if ('FeatureCvterm' == $relationName) {
            $this->initFeatureCvterms();
        }
        if ('FeatureDbxref' == $relationName) {
            $this->initFeatureDbxrefs();
        }
        if ('FeaturePub' == $relationName) {
            $this->initFeaturePubs();
        }
        if ('FeatureRelationshipRelatedByObjectId' == $relationName) {
            $this->initFeatureRelationshipsRelatedByObjectId();
        }
        if ('FeatureRelationshipRelatedBySubjectId' == $relationName) {
            $this->initFeatureRelationshipsRelatedBySubjectId();
        }
        if ('FeatureSynonym' == $relationName) {
            $this->initFeatureSynonyms();
        }
        if ('FeaturelocRelatedByFeatureId' == $relationName) {
            $this->initFeaturelocsRelatedByFeatureId();
        }
        if ('FeaturelocRelatedBySrcfeatureId' == $relationName) {
            $this->initFeaturelocsRelatedBySrcfeatureId();
        }
        if ('Featureprop' == $relationName) {
            $this->initFeatureprops();
        }
        if ('Quantificationresult' == $relationName) {
            $this->initQuantificationresults();
        }
        if ('StudypropFeature' == $relationName) {
            $this->initStudypropFeatures();
        }
    }

    /**
     * Clears out the collAnalysisfeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addAnalysisfeatures()
     */
    public function clearAnalysisfeatures()
    {
        $this->collAnalysisfeatures = null; // important to set this to null since that means it is uninitialized
        $this->collAnalysisfeaturesPartial = null;

        return $this;
    }

    /**
     * reset is the collAnalysisfeatures collection loaded partially
     *
     * @return void
     */
    public function resetPartialAnalysisfeatures($v = true)
    {
        $this->collAnalysisfeaturesPartial = $v;
    }

    /**
     * Initializes the collAnalysisfeatures collection.
     *
     * By default this just sets the collAnalysisfeatures collection to an empty array (like clearcollAnalysisfeatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnalysisfeatures($overrideExisting = true)
    {
        if (null !== $this->collAnalysisfeatures && !$overrideExisting) {
            return;
        }
        $this->collAnalysisfeatures = new PropelObjectCollection();
        $this->collAnalysisfeatures->setModel('Analysisfeature');
    }

    /**
     * Gets an array of Analysisfeature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Analysisfeature[] List of Analysisfeature objects
     * @throws PropelException
     */
    public function getAnalysisfeatures($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturesPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatures) {
                // return empty collection
                $this->initAnalysisfeatures();
            } else {
                $collAnalysisfeatures = AnalysisfeatureQuery::create(null, $criteria)
                    ->filterByFeature($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAnalysisfeaturesPartial && count($collAnalysisfeatures)) {
                      $this->initAnalysisfeatures(false);

                      foreach($collAnalysisfeatures as $obj) {
                        if (false == $this->collAnalysisfeatures->contains($obj)) {
                          $this->collAnalysisfeatures->append($obj);
                        }
                      }

                      $this->collAnalysisfeaturesPartial = true;
                    }

                    $collAnalysisfeatures->getInternalIterator()->rewind();
                    return $collAnalysisfeatures;
                }

                if($partial && $this->collAnalysisfeatures) {
                    foreach($this->collAnalysisfeatures as $obj) {
                        if($obj->isNew()) {
                            $collAnalysisfeatures[] = $obj;
                        }
                    }
                }

                $this->collAnalysisfeatures = $collAnalysisfeatures;
                $this->collAnalysisfeaturesPartial = false;
            }
        }

        return $this->collAnalysisfeatures;
    }

    /**
     * Sets a collection of Analysisfeature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $analysisfeatures A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setAnalysisfeatures(PropelCollection $analysisfeatures, PropelPDO $con = null)
    {
        $analysisfeaturesToDelete = $this->getAnalysisfeatures(new Criteria(), $con)->diff($analysisfeatures);

        $this->analysisfeaturesScheduledForDeletion = unserialize(serialize($analysisfeaturesToDelete));

        foreach ($analysisfeaturesToDelete as $analysisfeatureRemoved) {
            $analysisfeatureRemoved->setFeature(null);
        }

        $this->collAnalysisfeatures = null;
        foreach ($analysisfeatures as $analysisfeature) {
            $this->addAnalysisfeature($analysisfeature);
        }

        $this->collAnalysisfeatures = $analysisfeatures;
        $this->collAnalysisfeaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Analysisfeature objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Analysisfeature objects.
     * @throws PropelException
     */
    public function countAnalysisfeatures(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturesPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatures) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAnalysisfeatures());
            }
            $query = AnalysisfeatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collAnalysisfeatures);
    }

    /**
     * Method called to associate a Analysisfeature object to this object
     * through the Analysisfeature foreign key attribute.
     *
     * @param    Analysisfeature $l Analysisfeature
     * @return Feature The current object (for fluent API support)
     */
    public function addAnalysisfeature(Analysisfeature $l)
    {
        if ($this->collAnalysisfeatures === null) {
            $this->initAnalysisfeatures();
            $this->collAnalysisfeaturesPartial = true;
        }
        if (!in_array($l, $this->collAnalysisfeatures->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAnalysisfeature($l);
        }

        return $this;
    }

    /**
     * @param	Analysisfeature $analysisfeature The analysisfeature object to add.
     */
    protected function doAddAnalysisfeature($analysisfeature)
    {
        $this->collAnalysisfeatures[]= $analysisfeature;
        $analysisfeature->setFeature($this);
    }

    /**
     * @param	Analysisfeature $analysisfeature The analysisfeature object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeAnalysisfeature($analysisfeature)
    {
        if ($this->getAnalysisfeatures()->contains($analysisfeature)) {
            $this->collAnalysisfeatures->remove($this->collAnalysisfeatures->search($analysisfeature));
            if (null === $this->analysisfeaturesScheduledForDeletion) {
                $this->analysisfeaturesScheduledForDeletion = clone $this->collAnalysisfeatures;
                $this->analysisfeaturesScheduledForDeletion->clear();
            }
            $this->analysisfeaturesScheduledForDeletion[]= clone $analysisfeature;
            $analysisfeature->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Analysisfeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Analysisfeature[] List of Analysisfeature objects
     */
    public function getAnalysisfeaturesJoinAnalysis($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AnalysisfeatureQuery::create(null, $criteria);
        $query->joinWith('Analysis', $join_behavior);

        return $this->getAnalysisfeatures($query, $con);
    }

    /**
     * Clears out the collElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
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
     * If this Feature is new, it will return
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
                    ->filterByFeature($this)
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
     * @return Feature The current object (for fluent API support)
     */
    public function setElements(PropelCollection $elements, PropelPDO $con = null)
    {
        $elementsToDelete = $this->getElements(new Criteria(), $con)->diff($elements);

        $this->elementsScheduledForDeletion = unserialize(serialize($elementsToDelete));

        foreach ($elementsToDelete as $elementRemoved) {
            $elementRemoved->setFeature(null);
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
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collElements);
    }

    /**
     * Method called to associate a Element object to this object
     * through the Element foreign key attribute.
     *
     * @param    Element $l Element
     * @return Feature The current object (for fluent API support)
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
        $element->setFeature($this);
    }

    /**
     * @param	Element $element The element object to remove.
     * @return Feature The current object (for fluent API support)
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
            $element->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElements($query, $con);
    }

    /**
     * Clears out the collFeatureCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
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
     * If this Feature is new, it will return
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
                    ->filterByFeature($this)
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
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureCvterms(PropelCollection $featureCvterms, PropelPDO $con = null)
    {
        $featureCvtermsToDelete = $this->getFeatureCvterms(new Criteria(), $con)->diff($featureCvterms);

        $this->featureCvtermsScheduledForDeletion = unserialize(serialize($featureCvtermsToDelete));

        foreach ($featureCvtermsToDelete as $featureCvtermRemoved) {
            $featureCvtermRemoved->setFeature(null);
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
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collFeatureCvterms);
    }

    /**
     * Method called to associate a FeatureCvterm object to this object
     * through the FeatureCvterm foreign key attribute.
     *
     * @param    FeatureCvterm $l FeatureCvterm
     * @return Feature The current object (for fluent API support)
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
        $featureCvterm->setFeature($this);
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to remove.
     * @return Feature The current object (for fluent API support)
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
            $featureCvterm->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * Clears out the collFeatureDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeatureDbxrefs()
     */
    public function clearFeatureDbxrefs()
    {
        $this->collFeatureDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureDbxrefs($v = true)
    {
        $this->collFeatureDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureDbxrefs collection.
     *
     * By default this just sets the collFeatureDbxrefs collection to an empty array (like clearcollFeatureDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureDbxrefs = new PropelObjectCollection();
        $this->collFeatureDbxrefs->setModel('FeatureDbxref');
    }

    /**
     * Gets an array of FeatureDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     * @throws PropelException
     */
    public function getFeatureDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                // return empty collection
                $this->initFeatureDbxrefs();
            } else {
                $collFeatureDbxrefs = FeatureDbxrefQuery::create(null, $criteria)
                    ->filterByFeature($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureDbxrefsPartial && count($collFeatureDbxrefs)) {
                      $this->initFeatureDbxrefs(false);

                      foreach($collFeatureDbxrefs as $obj) {
                        if (false == $this->collFeatureDbxrefs->contains($obj)) {
                          $this->collFeatureDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureDbxrefsPartial = true;
                    }

                    $collFeatureDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureDbxrefs;
                }

                if($partial && $this->collFeatureDbxrefs) {
                    foreach($this->collFeatureDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureDbxrefs = $collFeatureDbxrefs;
                $this->collFeatureDbxrefsPartial = false;
            }
        }

        return $this->collFeatureDbxrefs;
    }

    /**
     * Sets a collection of FeatureDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureDbxrefs(PropelCollection $featureDbxrefs, PropelPDO $con = null)
    {
        $featureDbxrefsToDelete = $this->getFeatureDbxrefs(new Criteria(), $con)->diff($featureDbxrefs);

        $this->featureDbxrefsScheduledForDeletion = unserialize(serialize($featureDbxrefsToDelete));

        foreach ($featureDbxrefsToDelete as $featureDbxrefRemoved) {
            $featureDbxrefRemoved->setFeature(null);
        }

        $this->collFeatureDbxrefs = null;
        foreach ($featureDbxrefs as $featureDbxref) {
            $this->addFeatureDbxref($featureDbxref);
        }

        $this->collFeatureDbxrefs = $featureDbxrefs;
        $this->collFeatureDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureDbxref objects.
     * @throws PropelException
     */
    public function countFeatureDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureDbxrefs());
            }
            $query = FeatureDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collFeatureDbxrefs);
    }

    /**
     * Method called to associate a FeatureDbxref object to this object
     * through the FeatureDbxref foreign key attribute.
     *
     * @param    FeatureDbxref $l FeatureDbxref
     * @return Feature The current object (for fluent API support)
     */
    public function addFeatureDbxref(FeatureDbxref $l)
    {
        if ($this->collFeatureDbxrefs === null) {
            $this->initFeatureDbxrefs();
            $this->collFeatureDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to add.
     */
    protected function doAddFeatureDbxref($featureDbxref)
    {
        $this->collFeatureDbxrefs[]= $featureDbxref;
        $featureDbxref->setFeature($this);
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeatureDbxref($featureDbxref)
    {
        if ($this->getFeatureDbxrefs()->contains($featureDbxref)) {
            $this->collFeatureDbxrefs->remove($this->collFeatureDbxrefs->search($featureDbxref));
            if (null === $this->featureDbxrefsScheduledForDeletion) {
                $this->featureDbxrefsScheduledForDeletion = clone $this->collFeatureDbxrefs;
                $this->featureDbxrefsScheduledForDeletion->clear();
            }
            $this->featureDbxrefsScheduledForDeletion[]= clone $featureDbxref;
            $featureDbxref->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     */
    public function getFeatureDbxrefsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureDbxrefQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getFeatureDbxrefs($query, $con);
    }

    /**
     * Clears out the collFeaturePubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeaturePubs()
     */
    public function clearFeaturePubs()
    {
        $this->collFeaturePubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturePubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturePubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturePubs($v = true)
    {
        $this->collFeaturePubsPartial = $v;
    }

    /**
     * Initializes the collFeaturePubs collection.
     *
     * By default this just sets the collFeaturePubs collection to an empty array (like clearcollFeaturePubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturePubs($overrideExisting = true)
    {
        if (null !== $this->collFeaturePubs && !$overrideExisting) {
            return;
        }
        $this->collFeaturePubs = new PropelObjectCollection();
        $this->collFeaturePubs->setModel('FeaturePub');
    }

    /**
     * Gets an array of FeaturePub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeaturePub[] List of FeaturePub objects
     * @throws PropelException
     */
    public function getFeaturePubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubsPartial && !$this->isNew();
        if (null === $this->collFeaturePubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubs) {
                // return empty collection
                $this->initFeaturePubs();
            } else {
                $collFeaturePubs = FeaturePubQuery::create(null, $criteria)
                    ->filterByFeature($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturePubsPartial && count($collFeaturePubs)) {
                      $this->initFeaturePubs(false);

                      foreach($collFeaturePubs as $obj) {
                        if (false == $this->collFeaturePubs->contains($obj)) {
                          $this->collFeaturePubs->append($obj);
                        }
                      }

                      $this->collFeaturePubsPartial = true;
                    }

                    $collFeaturePubs->getInternalIterator()->rewind();
                    return $collFeaturePubs;
                }

                if($partial && $this->collFeaturePubs) {
                    foreach($this->collFeaturePubs as $obj) {
                        if($obj->isNew()) {
                            $collFeaturePubs[] = $obj;
                        }
                    }
                }

                $this->collFeaturePubs = $collFeaturePubs;
                $this->collFeaturePubsPartial = false;
            }
        }

        return $this->collFeaturePubs;
    }

    /**
     * Sets a collection of FeaturePub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurePubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeaturePubs(PropelCollection $featurePubs, PropelPDO $con = null)
    {
        $featurePubsToDelete = $this->getFeaturePubs(new Criteria(), $con)->diff($featurePubs);

        $this->featurePubsScheduledForDeletion = unserialize(serialize($featurePubsToDelete));

        foreach ($featurePubsToDelete as $featurePubRemoved) {
            $featurePubRemoved->setFeature(null);
        }

        $this->collFeaturePubs = null;
        foreach ($featurePubs as $featurePub) {
            $this->addFeaturePub($featurePub);
        }

        $this->collFeaturePubs = $featurePubs;
        $this->collFeaturePubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeaturePub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeaturePub objects.
     * @throws PropelException
     */
    public function countFeaturePubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubsPartial && !$this->isNew();
        if (null === $this->collFeaturePubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturePubs());
            }
            $query = FeaturePubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collFeaturePubs);
    }

    /**
     * Method called to associate a FeaturePub object to this object
     * through the FeaturePub foreign key attribute.
     *
     * @param    FeaturePub $l FeaturePub
     * @return Feature The current object (for fluent API support)
     */
    public function addFeaturePub(FeaturePub $l)
    {
        if ($this->collFeaturePubs === null) {
            $this->initFeaturePubs();
            $this->collFeaturePubsPartial = true;
        }
        if (!in_array($l, $this->collFeaturePubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturePub($l);
        }

        return $this;
    }

    /**
     * @param	FeaturePub $featurePub The featurePub object to add.
     */
    protected function doAddFeaturePub($featurePub)
    {
        $this->collFeaturePubs[]= $featurePub;
        $featurePub->setFeature($this);
    }

    /**
     * @param	FeaturePub $featurePub The featurePub object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeaturePub($featurePub)
    {
        if ($this->getFeaturePubs()->contains($featurePub)) {
            $this->collFeaturePubs->remove($this->collFeaturePubs->search($featurePub));
            if (null === $this->featurePubsScheduledForDeletion) {
                $this->featurePubsScheduledForDeletion = clone $this->collFeaturePubs;
                $this->featurePubsScheduledForDeletion->clear();
            }
            $this->featurePubsScheduledForDeletion[]= clone $featurePub;
            $featurePub->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeaturePubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeaturePub[] List of FeaturePub objects
     */
    public function getFeaturePubsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturePubQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeaturePubs($query, $con);
    }

    /**
     * Clears out the collFeatureRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeatureRelationshipsRelatedByObjectId()
     */
    public function clearFeatureRelationshipsRelatedByObjectId()
    {
        $this->collFeatureRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureRelationshipsRelatedByObjectId($v = true)
    {
        $this->collFeatureRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collFeatureRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collFeatureRelationshipsRelatedByObjectId collection to an empty array (like clearcollFeatureRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collFeatureRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collFeatureRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collFeatureRelationshipsRelatedByObjectId->setModel('FeatureRelationship');
    }

    /**
     * Gets an array of FeatureRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     * @throws PropelException
     */
    public function getFeatureRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initFeatureRelationshipsRelatedByObjectId();
            } else {
                $collFeatureRelationshipsRelatedByObjectId = FeatureRelationshipQuery::create(null, $criteria)
                    ->filterByFeatureRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureRelationshipsRelatedByObjectIdPartial && count($collFeatureRelationshipsRelatedByObjectId)) {
                      $this->initFeatureRelationshipsRelatedByObjectId(false);

                      foreach($collFeatureRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collFeatureRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collFeatureRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collFeatureRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collFeatureRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collFeatureRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collFeatureRelationshipsRelatedByObjectId) {
                    foreach($this->collFeatureRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collFeatureRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collFeatureRelationshipsRelatedByObjectId = $collFeatureRelationshipsRelatedByObjectId;
                $this->collFeatureRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collFeatureRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of FeatureRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureRelationshipsRelatedByObjectId(PropelCollection $featureRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $featureRelationshipsRelatedByObjectIdToDelete = $this->getFeatureRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($featureRelationshipsRelatedByObjectId);

        $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($featureRelationshipsRelatedByObjectIdToDelete));

        foreach ($featureRelationshipsRelatedByObjectIdToDelete as $featureRelationshipRelatedByObjectIdRemoved) {
            $featureRelationshipRelatedByObjectIdRemoved->setFeatureRelatedByObjectId(null);
        }

        $this->collFeatureRelationshipsRelatedByObjectId = null;
        foreach ($featureRelationshipsRelatedByObjectId as $featureRelationshipRelatedByObjectId) {
            $this->addFeatureRelationshipRelatedByObjectId($featureRelationshipRelatedByObjectId);
        }

        $this->collFeatureRelationshipsRelatedByObjectId = $featureRelationshipsRelatedByObjectId;
        $this->collFeatureRelationshipsRelatedByObjectIdPartial = false;

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
    public function countFeatureRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureRelationshipsRelatedByObjectId());
            }
            $query = FeatureRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collFeatureRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a FeatureRelationship object to this object
     * through the FeatureRelationship foreign key attribute.
     *
     * @param    FeatureRelationship $l FeatureRelationship
     * @return Feature The current object (for fluent API support)
     */
    public function addFeatureRelationshipRelatedByObjectId(FeatureRelationship $l)
    {
        if ($this->collFeatureRelationshipsRelatedByObjectId === null) {
            $this->initFeatureRelationshipsRelatedByObjectId();
            $this->collFeatureRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collFeatureRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	FeatureRelationshipRelatedByObjectId $featureRelationshipRelatedByObjectId The featureRelationshipRelatedByObjectId object to add.
     */
    protected function doAddFeatureRelationshipRelatedByObjectId($featureRelationshipRelatedByObjectId)
    {
        $this->collFeatureRelationshipsRelatedByObjectId[]= $featureRelationshipRelatedByObjectId;
        $featureRelationshipRelatedByObjectId->setFeatureRelatedByObjectId($this);
    }

    /**
     * @param	FeatureRelationshipRelatedByObjectId $featureRelationshipRelatedByObjectId The featureRelationshipRelatedByObjectId object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeatureRelationshipRelatedByObjectId($featureRelationshipRelatedByObjectId)
    {
        if ($this->getFeatureRelationshipsRelatedByObjectId()->contains($featureRelationshipRelatedByObjectId)) {
            $this->collFeatureRelationshipsRelatedByObjectId->remove($this->collFeatureRelationshipsRelatedByObjectId->search($featureRelationshipRelatedByObjectId));
            if (null === $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collFeatureRelationshipsRelatedByObjectId;
                $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->featureRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $featureRelationshipRelatedByObjectId;
            $featureRelationshipRelatedByObjectId->setFeatureRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     */
    public function getFeatureRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collFeatureRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeatureRelationshipsRelatedBySubjectId()
     */
    public function clearFeatureRelationshipsRelatedBySubjectId()
    {
        $this->collFeatureRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collFeatureRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collFeatureRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collFeatureRelationshipsRelatedBySubjectId collection to an empty array (like clearcollFeatureRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collFeatureRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collFeatureRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collFeatureRelationshipsRelatedBySubjectId->setModel('FeatureRelationship');
    }

    /**
     * Gets an array of FeatureRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     * @throws PropelException
     */
    public function getFeatureRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initFeatureRelationshipsRelatedBySubjectId();
            } else {
                $collFeatureRelationshipsRelatedBySubjectId = FeatureRelationshipQuery::create(null, $criteria)
                    ->filterByFeatureRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureRelationshipsRelatedBySubjectIdPartial && count($collFeatureRelationshipsRelatedBySubjectId)) {
                      $this->initFeatureRelationshipsRelatedBySubjectId(false);

                      foreach($collFeatureRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collFeatureRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collFeatureRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collFeatureRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collFeatureRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collFeatureRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collFeatureRelationshipsRelatedBySubjectId) {
                    foreach($this->collFeatureRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collFeatureRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collFeatureRelationshipsRelatedBySubjectId = $collFeatureRelationshipsRelatedBySubjectId;
                $this->collFeatureRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collFeatureRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of FeatureRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureRelationshipsRelatedBySubjectId(PropelCollection $featureRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $featureRelationshipsRelatedBySubjectIdToDelete = $this->getFeatureRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($featureRelationshipsRelatedBySubjectId);

        $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($featureRelationshipsRelatedBySubjectIdToDelete));

        foreach ($featureRelationshipsRelatedBySubjectIdToDelete as $featureRelationshipRelatedBySubjectIdRemoved) {
            $featureRelationshipRelatedBySubjectIdRemoved->setFeatureRelatedBySubjectId(null);
        }

        $this->collFeatureRelationshipsRelatedBySubjectId = null;
        foreach ($featureRelationshipsRelatedBySubjectId as $featureRelationshipRelatedBySubjectId) {
            $this->addFeatureRelationshipRelatedBySubjectId($featureRelationshipRelatedBySubjectId);
        }

        $this->collFeatureRelationshipsRelatedBySubjectId = $featureRelationshipsRelatedBySubjectId;
        $this->collFeatureRelationshipsRelatedBySubjectIdPartial = false;

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
    public function countFeatureRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collFeatureRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureRelationshipsRelatedBySubjectId());
            }
            $query = FeatureRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collFeatureRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a FeatureRelationship object to this object
     * through the FeatureRelationship foreign key attribute.
     *
     * @param    FeatureRelationship $l FeatureRelationship
     * @return Feature The current object (for fluent API support)
     */
    public function addFeatureRelationshipRelatedBySubjectId(FeatureRelationship $l)
    {
        if ($this->collFeatureRelationshipsRelatedBySubjectId === null) {
            $this->initFeatureRelationshipsRelatedBySubjectId();
            $this->collFeatureRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collFeatureRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	FeatureRelationshipRelatedBySubjectId $featureRelationshipRelatedBySubjectId The featureRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddFeatureRelationshipRelatedBySubjectId($featureRelationshipRelatedBySubjectId)
    {
        $this->collFeatureRelationshipsRelatedBySubjectId[]= $featureRelationshipRelatedBySubjectId;
        $featureRelationshipRelatedBySubjectId->setFeatureRelatedBySubjectId($this);
    }

    /**
     * @param	FeatureRelationshipRelatedBySubjectId $featureRelationshipRelatedBySubjectId The featureRelationshipRelatedBySubjectId object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeatureRelationshipRelatedBySubjectId($featureRelationshipRelatedBySubjectId)
    {
        if ($this->getFeatureRelationshipsRelatedBySubjectId()->contains($featureRelationshipRelatedBySubjectId)) {
            $this->collFeatureRelationshipsRelatedBySubjectId->remove($this->collFeatureRelationshipsRelatedBySubjectId->search($featureRelationshipRelatedBySubjectId));
            if (null === $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collFeatureRelationshipsRelatedBySubjectId;
                $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->featureRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $featureRelationshipRelatedBySubjectId;
            $featureRelationshipRelatedBySubjectId->setFeatureRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureRelationship[] List of FeatureRelationship objects
     */
    public function getFeatureRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collFeatureSynonyms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeatureSynonyms()
     */
    public function clearFeatureSynonyms()
    {
        $this->collFeatureSynonyms = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureSynonymsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureSynonyms collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureSynonyms($v = true)
    {
        $this->collFeatureSynonymsPartial = $v;
    }

    /**
     * Initializes the collFeatureSynonyms collection.
     *
     * By default this just sets the collFeatureSynonyms collection to an empty array (like clearcollFeatureSynonyms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureSynonyms($overrideExisting = true)
    {
        if (null !== $this->collFeatureSynonyms && !$overrideExisting) {
            return;
        }
        $this->collFeatureSynonyms = new PropelObjectCollection();
        $this->collFeatureSynonyms->setModel('FeatureSynonym');
    }

    /**
     * Gets an array of FeatureSynonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     * @throws PropelException
     */
    public function getFeatureSynonyms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureSynonymsPartial && !$this->isNew();
        if (null === $this->collFeatureSynonyms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureSynonyms) {
                // return empty collection
                $this->initFeatureSynonyms();
            } else {
                $collFeatureSynonyms = FeatureSynonymQuery::create(null, $criteria)
                    ->filterByFeature($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureSynonymsPartial && count($collFeatureSynonyms)) {
                      $this->initFeatureSynonyms(false);

                      foreach($collFeatureSynonyms as $obj) {
                        if (false == $this->collFeatureSynonyms->contains($obj)) {
                          $this->collFeatureSynonyms->append($obj);
                        }
                      }

                      $this->collFeatureSynonymsPartial = true;
                    }

                    $collFeatureSynonyms->getInternalIterator()->rewind();
                    return $collFeatureSynonyms;
                }

                if($partial && $this->collFeatureSynonyms) {
                    foreach($this->collFeatureSynonyms as $obj) {
                        if($obj->isNew()) {
                            $collFeatureSynonyms[] = $obj;
                        }
                    }
                }

                $this->collFeatureSynonyms = $collFeatureSynonyms;
                $this->collFeatureSynonymsPartial = false;
            }
        }

        return $this->collFeatureSynonyms;
    }

    /**
     * Sets a collection of FeatureSynonym objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureSynonyms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureSynonyms(PropelCollection $featureSynonyms, PropelPDO $con = null)
    {
        $featureSynonymsToDelete = $this->getFeatureSynonyms(new Criteria(), $con)->diff($featureSynonyms);

        $this->featureSynonymsScheduledForDeletion = unserialize(serialize($featureSynonymsToDelete));

        foreach ($featureSynonymsToDelete as $featureSynonymRemoved) {
            $featureSynonymRemoved->setFeature(null);
        }

        $this->collFeatureSynonyms = null;
        foreach ($featureSynonyms as $featureSynonym) {
            $this->addFeatureSynonym($featureSynonym);
        }

        $this->collFeatureSynonyms = $featureSynonyms;
        $this->collFeatureSynonymsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureSynonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureSynonym objects.
     * @throws PropelException
     */
    public function countFeatureSynonyms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureSynonymsPartial && !$this->isNew();
        if (null === $this->collFeatureSynonyms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureSynonyms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureSynonyms());
            }
            $query = FeatureSynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collFeatureSynonyms);
    }

    /**
     * Method called to associate a FeatureSynonym object to this object
     * through the FeatureSynonym foreign key attribute.
     *
     * @param    FeatureSynonym $l FeatureSynonym
     * @return Feature The current object (for fluent API support)
     */
    public function addFeatureSynonym(FeatureSynonym $l)
    {
        if ($this->collFeatureSynonyms === null) {
            $this->initFeatureSynonyms();
            $this->collFeatureSynonymsPartial = true;
        }
        if (!in_array($l, $this->collFeatureSynonyms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureSynonym($l);
        }

        return $this;
    }

    /**
     * @param	FeatureSynonym $featureSynonym The featureSynonym object to add.
     */
    protected function doAddFeatureSynonym($featureSynonym)
    {
        $this->collFeatureSynonyms[]= $featureSynonym;
        $featureSynonym->setFeature($this);
    }

    /**
     * @param	FeatureSynonym $featureSynonym The featureSynonym object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeatureSynonym($featureSynonym)
    {
        if ($this->getFeatureSynonyms()->contains($featureSynonym)) {
            $this->collFeatureSynonyms->remove($this->collFeatureSynonyms->search($featureSynonym));
            if (null === $this->featureSynonymsScheduledForDeletion) {
                $this->featureSynonymsScheduledForDeletion = clone $this->collFeatureSynonyms;
                $this->featureSynonymsScheduledForDeletion->clear();
            }
            $this->featureSynonymsScheduledForDeletion[]= clone $featureSynonym;
            $featureSynonym->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureSynonyms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     */
    public function getFeatureSynonymsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureSynonymQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeatureSynonyms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related FeatureSynonyms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     */
    public function getFeatureSynonymsJoinSynonym($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureSynonymQuery::create(null, $criteria);
        $query->joinWith('Synonym', $join_behavior);

        return $this->getFeatureSynonyms($query, $con);
    }

    /**
     * Clears out the collFeaturelocsRelatedByFeatureId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeaturelocsRelatedByFeatureId()
     */
    public function clearFeaturelocsRelatedByFeatureId()
    {
        $this->collFeaturelocsRelatedByFeatureId = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturelocsRelatedByFeatureIdPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturelocsRelatedByFeatureId collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturelocsRelatedByFeatureId($v = true)
    {
        $this->collFeaturelocsRelatedByFeatureIdPartial = $v;
    }

    /**
     * Initializes the collFeaturelocsRelatedByFeatureId collection.
     *
     * By default this just sets the collFeaturelocsRelatedByFeatureId collection to an empty array (like clearcollFeaturelocsRelatedByFeatureId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturelocsRelatedByFeatureId($overrideExisting = true)
    {
        if (null !== $this->collFeaturelocsRelatedByFeatureId && !$overrideExisting) {
            return;
        }
        $this->collFeaturelocsRelatedByFeatureId = new PropelObjectCollection();
        $this->collFeaturelocsRelatedByFeatureId->setModel('Featureloc');
    }

    /**
     * Gets an array of Featureloc objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Featureloc[] List of Featureloc objects
     * @throws PropelException
     */
    public function getFeaturelocsRelatedByFeatureId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocsRelatedByFeatureIdPartial && !$this->isNew();
        if (null === $this->collFeaturelocsRelatedByFeatureId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocsRelatedByFeatureId) {
                // return empty collection
                $this->initFeaturelocsRelatedByFeatureId();
            } else {
                $collFeaturelocsRelatedByFeatureId = FeaturelocQuery::create(null, $criteria)
                    ->filterByFeatureRelatedByFeatureId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturelocsRelatedByFeatureIdPartial && count($collFeaturelocsRelatedByFeatureId)) {
                      $this->initFeaturelocsRelatedByFeatureId(false);

                      foreach($collFeaturelocsRelatedByFeatureId as $obj) {
                        if (false == $this->collFeaturelocsRelatedByFeatureId->contains($obj)) {
                          $this->collFeaturelocsRelatedByFeatureId->append($obj);
                        }
                      }

                      $this->collFeaturelocsRelatedByFeatureIdPartial = true;
                    }

                    $collFeaturelocsRelatedByFeatureId->getInternalIterator()->rewind();
                    return $collFeaturelocsRelatedByFeatureId;
                }

                if($partial && $this->collFeaturelocsRelatedByFeatureId) {
                    foreach($this->collFeaturelocsRelatedByFeatureId as $obj) {
                        if($obj->isNew()) {
                            $collFeaturelocsRelatedByFeatureId[] = $obj;
                        }
                    }
                }

                $this->collFeaturelocsRelatedByFeatureId = $collFeaturelocsRelatedByFeatureId;
                $this->collFeaturelocsRelatedByFeatureIdPartial = false;
            }
        }

        return $this->collFeaturelocsRelatedByFeatureId;
    }

    /**
     * Sets a collection of FeaturelocRelatedByFeatureId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurelocsRelatedByFeatureId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeaturelocsRelatedByFeatureId(PropelCollection $featurelocsRelatedByFeatureId, PropelPDO $con = null)
    {
        $featurelocsRelatedByFeatureIdToDelete = $this->getFeaturelocsRelatedByFeatureId(new Criteria(), $con)->diff($featurelocsRelatedByFeatureId);

        $this->featurelocsRelatedByFeatureIdScheduledForDeletion = unserialize(serialize($featurelocsRelatedByFeatureIdToDelete));

        foreach ($featurelocsRelatedByFeatureIdToDelete as $featurelocRelatedByFeatureIdRemoved) {
            $featurelocRelatedByFeatureIdRemoved->setFeatureRelatedByFeatureId(null);
        }

        $this->collFeaturelocsRelatedByFeatureId = null;
        foreach ($featurelocsRelatedByFeatureId as $featurelocRelatedByFeatureId) {
            $this->addFeaturelocRelatedByFeatureId($featurelocRelatedByFeatureId);
        }

        $this->collFeaturelocsRelatedByFeatureId = $featurelocsRelatedByFeatureId;
        $this->collFeaturelocsRelatedByFeatureIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Featureloc objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Featureloc objects.
     * @throws PropelException
     */
    public function countFeaturelocsRelatedByFeatureId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocsRelatedByFeatureIdPartial && !$this->isNew();
        if (null === $this->collFeaturelocsRelatedByFeatureId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocsRelatedByFeatureId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturelocsRelatedByFeatureId());
            }
            $query = FeaturelocQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureRelatedByFeatureId($this)
                ->count($con);
        }

        return count($this->collFeaturelocsRelatedByFeatureId);
    }

    /**
     * Method called to associate a Featureloc object to this object
     * through the Featureloc foreign key attribute.
     *
     * @param    Featureloc $l Featureloc
     * @return Feature The current object (for fluent API support)
     */
    public function addFeaturelocRelatedByFeatureId(Featureloc $l)
    {
        if ($this->collFeaturelocsRelatedByFeatureId === null) {
            $this->initFeaturelocsRelatedByFeatureId();
            $this->collFeaturelocsRelatedByFeatureIdPartial = true;
        }
        if (!in_array($l, $this->collFeaturelocsRelatedByFeatureId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturelocRelatedByFeatureId($l);
        }

        return $this;
    }

    /**
     * @param	FeaturelocRelatedByFeatureId $featurelocRelatedByFeatureId The featurelocRelatedByFeatureId object to add.
     */
    protected function doAddFeaturelocRelatedByFeatureId($featurelocRelatedByFeatureId)
    {
        $this->collFeaturelocsRelatedByFeatureId[]= $featurelocRelatedByFeatureId;
        $featurelocRelatedByFeatureId->setFeatureRelatedByFeatureId($this);
    }

    /**
     * @param	FeaturelocRelatedByFeatureId $featurelocRelatedByFeatureId The featurelocRelatedByFeatureId object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeaturelocRelatedByFeatureId($featurelocRelatedByFeatureId)
    {
        if ($this->getFeaturelocsRelatedByFeatureId()->contains($featurelocRelatedByFeatureId)) {
            $this->collFeaturelocsRelatedByFeatureId->remove($this->collFeaturelocsRelatedByFeatureId->search($featurelocRelatedByFeatureId));
            if (null === $this->featurelocsRelatedByFeatureIdScheduledForDeletion) {
                $this->featurelocsRelatedByFeatureIdScheduledForDeletion = clone $this->collFeaturelocsRelatedByFeatureId;
                $this->featurelocsRelatedByFeatureIdScheduledForDeletion->clear();
            }
            $this->featurelocsRelatedByFeatureIdScheduledForDeletion[]= clone $featurelocRelatedByFeatureId;
            $featurelocRelatedByFeatureId->setFeatureRelatedByFeatureId(null);
        }

        return $this;
    }

    /**
     * Clears out the collFeaturelocsRelatedBySrcfeatureId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
     * @see        addFeaturelocsRelatedBySrcfeatureId()
     */
    public function clearFeaturelocsRelatedBySrcfeatureId()
    {
        $this->collFeaturelocsRelatedBySrcfeatureId = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturelocsRelatedBySrcfeatureIdPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturelocsRelatedBySrcfeatureId collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturelocsRelatedBySrcfeatureId($v = true)
    {
        $this->collFeaturelocsRelatedBySrcfeatureIdPartial = $v;
    }

    /**
     * Initializes the collFeaturelocsRelatedBySrcfeatureId collection.
     *
     * By default this just sets the collFeaturelocsRelatedBySrcfeatureId collection to an empty array (like clearcollFeaturelocsRelatedBySrcfeatureId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturelocsRelatedBySrcfeatureId($overrideExisting = true)
    {
        if (null !== $this->collFeaturelocsRelatedBySrcfeatureId && !$overrideExisting) {
            return;
        }
        $this->collFeaturelocsRelatedBySrcfeatureId = new PropelObjectCollection();
        $this->collFeaturelocsRelatedBySrcfeatureId->setModel('Featureloc');
    }

    /**
     * Gets an array of Featureloc objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Feature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Featureloc[] List of Featureloc objects
     * @throws PropelException
     */
    public function getFeaturelocsRelatedBySrcfeatureId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocsRelatedBySrcfeatureIdPartial && !$this->isNew();
        if (null === $this->collFeaturelocsRelatedBySrcfeatureId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocsRelatedBySrcfeatureId) {
                // return empty collection
                $this->initFeaturelocsRelatedBySrcfeatureId();
            } else {
                $collFeaturelocsRelatedBySrcfeatureId = FeaturelocQuery::create(null, $criteria)
                    ->filterByFeatureRelatedBySrcfeatureId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturelocsRelatedBySrcfeatureIdPartial && count($collFeaturelocsRelatedBySrcfeatureId)) {
                      $this->initFeaturelocsRelatedBySrcfeatureId(false);

                      foreach($collFeaturelocsRelatedBySrcfeatureId as $obj) {
                        if (false == $this->collFeaturelocsRelatedBySrcfeatureId->contains($obj)) {
                          $this->collFeaturelocsRelatedBySrcfeatureId->append($obj);
                        }
                      }

                      $this->collFeaturelocsRelatedBySrcfeatureIdPartial = true;
                    }

                    $collFeaturelocsRelatedBySrcfeatureId->getInternalIterator()->rewind();
                    return $collFeaturelocsRelatedBySrcfeatureId;
                }

                if($partial && $this->collFeaturelocsRelatedBySrcfeatureId) {
                    foreach($this->collFeaturelocsRelatedBySrcfeatureId as $obj) {
                        if($obj->isNew()) {
                            $collFeaturelocsRelatedBySrcfeatureId[] = $obj;
                        }
                    }
                }

                $this->collFeaturelocsRelatedBySrcfeatureId = $collFeaturelocsRelatedBySrcfeatureId;
                $this->collFeaturelocsRelatedBySrcfeatureIdPartial = false;
            }
        }

        return $this->collFeaturelocsRelatedBySrcfeatureId;
    }

    /**
     * Sets a collection of FeaturelocRelatedBySrcfeatureId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurelocsRelatedBySrcfeatureId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Feature The current object (for fluent API support)
     */
    public function setFeaturelocsRelatedBySrcfeatureId(PropelCollection $featurelocsRelatedBySrcfeatureId, PropelPDO $con = null)
    {
        $featurelocsRelatedBySrcfeatureIdToDelete = $this->getFeaturelocsRelatedBySrcfeatureId(new Criteria(), $con)->diff($featurelocsRelatedBySrcfeatureId);

        $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion = unserialize(serialize($featurelocsRelatedBySrcfeatureIdToDelete));

        foreach ($featurelocsRelatedBySrcfeatureIdToDelete as $featurelocRelatedBySrcfeatureIdRemoved) {
            $featurelocRelatedBySrcfeatureIdRemoved->setFeatureRelatedBySrcfeatureId(null);
        }

        $this->collFeaturelocsRelatedBySrcfeatureId = null;
        foreach ($featurelocsRelatedBySrcfeatureId as $featurelocRelatedBySrcfeatureId) {
            $this->addFeaturelocRelatedBySrcfeatureId($featurelocRelatedBySrcfeatureId);
        }

        $this->collFeaturelocsRelatedBySrcfeatureId = $featurelocsRelatedBySrcfeatureId;
        $this->collFeaturelocsRelatedBySrcfeatureIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Featureloc objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Featureloc objects.
     * @throws PropelException
     */
    public function countFeaturelocsRelatedBySrcfeatureId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocsRelatedBySrcfeatureIdPartial && !$this->isNew();
        if (null === $this->collFeaturelocsRelatedBySrcfeatureId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocsRelatedBySrcfeatureId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturelocsRelatedBySrcfeatureId());
            }
            $query = FeaturelocQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureRelatedBySrcfeatureId($this)
                ->count($con);
        }

        return count($this->collFeaturelocsRelatedBySrcfeatureId);
    }

    /**
     * Method called to associate a Featureloc object to this object
     * through the Featureloc foreign key attribute.
     *
     * @param    Featureloc $l Featureloc
     * @return Feature The current object (for fluent API support)
     */
    public function addFeaturelocRelatedBySrcfeatureId(Featureloc $l)
    {
        if ($this->collFeaturelocsRelatedBySrcfeatureId === null) {
            $this->initFeaturelocsRelatedBySrcfeatureId();
            $this->collFeaturelocsRelatedBySrcfeatureIdPartial = true;
        }
        if (!in_array($l, $this->collFeaturelocsRelatedBySrcfeatureId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturelocRelatedBySrcfeatureId($l);
        }

        return $this;
    }

    /**
     * @param	FeaturelocRelatedBySrcfeatureId $featurelocRelatedBySrcfeatureId The featurelocRelatedBySrcfeatureId object to add.
     */
    protected function doAddFeaturelocRelatedBySrcfeatureId($featurelocRelatedBySrcfeatureId)
    {
        $this->collFeaturelocsRelatedBySrcfeatureId[]= $featurelocRelatedBySrcfeatureId;
        $featurelocRelatedBySrcfeatureId->setFeatureRelatedBySrcfeatureId($this);
    }

    /**
     * @param	FeaturelocRelatedBySrcfeatureId $featurelocRelatedBySrcfeatureId The featurelocRelatedBySrcfeatureId object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeFeaturelocRelatedBySrcfeatureId($featurelocRelatedBySrcfeatureId)
    {
        if ($this->getFeaturelocsRelatedBySrcfeatureId()->contains($featurelocRelatedBySrcfeatureId)) {
            $this->collFeaturelocsRelatedBySrcfeatureId->remove($this->collFeaturelocsRelatedBySrcfeatureId->search($featurelocRelatedBySrcfeatureId));
            if (null === $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion) {
                $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion = clone $this->collFeaturelocsRelatedBySrcfeatureId;
                $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion->clear();
            }
            $this->featurelocsRelatedBySrcfeatureIdScheduledForDeletion[]= $featurelocRelatedBySrcfeatureId;
            $featurelocRelatedBySrcfeatureId->setFeatureRelatedBySrcfeatureId(null);
        }

        return $this;
    }

    /**
     * Clears out the collFeatureprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
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
     * If this Feature is new, it will return
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
                    ->filterByFeature($this)
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
     * @return Feature The current object (for fluent API support)
     */
    public function setFeatureprops(PropelCollection $featureprops, PropelPDO $con = null)
    {
        $featurepropsToDelete = $this->getFeatureprops(new Criteria(), $con)->diff($featureprops);

        $this->featurepropsScheduledForDeletion = unserialize(serialize($featurepropsToDelete));

        foreach ($featurepropsToDelete as $featurepropRemoved) {
            $featurepropRemoved->setFeature(null);
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
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collFeatureprops);
    }

    /**
     * Method called to associate a Featureprop object to this object
     * through the Featureprop foreign key attribute.
     *
     * @param    Featureprop $l Featureprop
     * @return Feature The current object (for fluent API support)
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
        $featureprop->setFeature($this);
    }

    /**
     * @param	Featureprop $featureprop The featureprop object to remove.
     * @return Feature The current object (for fluent API support)
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
            $featureprop->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Featureprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Featureprop[] List of Featureprop objects
     */
    public function getFeaturepropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturepropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureprops($query, $con);
    }

    /**
     * Clears out the collQuantificationresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
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
     * If this Feature is new, it will return
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
                    ->filterByFeature($this)
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
     * @return Feature The current object (for fluent API support)
     */
    public function setQuantificationresults(PropelCollection $quantificationresults, PropelPDO $con = null)
    {
        $quantificationresultsToDelete = $this->getQuantificationresults(new Criteria(), $con)->diff($quantificationresults);

        $this->quantificationresultsScheduledForDeletion = unserialize(serialize($quantificationresultsToDelete));

        foreach ($quantificationresultsToDelete as $quantificationresultRemoved) {
            $quantificationresultRemoved->setFeature(null);
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
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collQuantificationresults);
    }

    /**
     * Method called to associate a Quantificationresult object to this object
     * through the Quantificationresult foreign key attribute.
     *
     * @param    Quantificationresult $l Quantificationresult
     * @return Feature The current object (for fluent API support)
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
        $quantificationresult->setFeature($this);
    }

    /**
     * @param	Quantificationresult $quantificationresult The quantificationresult object to remove.
     * @return Feature The current object (for fluent API support)
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
            $quantificationresult->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationresult[] List of Quantificationresult objects
     */
    public function getQuantificationresultsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationresultQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getQuantificationresults($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * Clears out the collStudypropFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Feature The current object (for fluent API support)
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
     * If this Feature is new, it will return
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
                    ->filterByFeature($this)
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
     * @return Feature The current object (for fluent API support)
     */
    public function setStudypropFeatures(PropelCollection $studypropFeatures, PropelPDO $con = null)
    {
        $studypropFeaturesToDelete = $this->getStudypropFeatures(new Criteria(), $con)->diff($studypropFeatures);

        $this->studypropFeaturesScheduledForDeletion = unserialize(serialize($studypropFeaturesToDelete));

        foreach ($studypropFeaturesToDelete as $studypropFeatureRemoved) {
            $studypropFeatureRemoved->setFeature(null);
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
                ->filterByFeature($this)
                ->count($con);
        }

        return count($this->collStudypropFeatures);
    }

    /**
     * Method called to associate a StudypropFeature object to this object
     * through the StudypropFeature foreign key attribute.
     *
     * @param    StudypropFeature $l StudypropFeature
     * @return Feature The current object (for fluent API support)
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
        $studypropFeature->setFeature($this);
    }

    /**
     * @param	StudypropFeature $studypropFeature The studypropFeature object to remove.
     * @return Feature The current object (for fluent API support)
     */
    public function removeStudypropFeature($studypropFeature)
    {
        if ($this->getStudypropFeatures()->contains($studypropFeature)) {
            $this->collStudypropFeatures->remove($this->collStudypropFeatures->search($studypropFeature));
            if (null === $this->studypropFeaturesScheduledForDeletion) {
                $this->studypropFeaturesScheduledForDeletion = clone $this->collStudypropFeatures;
                $this->studypropFeaturesScheduledForDeletion->clear();
            }
            $this->studypropFeaturesScheduledForDeletion[]= clone $studypropFeature;
            $studypropFeature->setFeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Feature is new, it will return
     * an empty collection; or if this Feature has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Feature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StudypropFeature[] List of StudypropFeature objects
     */
    public function getStudypropFeaturesJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudypropFeatureQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getStudypropFeatures($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->feature_id = null;
        $this->dbxref_id = null;
        $this->organism_id = null;
        $this->name = null;
        $this->uniquename = null;
        $this->residues = null;
        $this->seqlen = null;
        $this->md5checksum = null;
        $this->type_id = null;
        $this->is_analysis = null;
        $this->is_obsolete = null;
        $this->timeaccessioned = null;
        $this->timelastmodified = null;
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
            if ($this->collAnalysisfeatures) {
                foreach ($this->collAnalysisfeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElements) {
                foreach ($this->collElements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvterms) {
                foreach ($this->collFeatureCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureDbxrefs) {
                foreach ($this->collFeatureDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeaturePubs) {
                foreach ($this->collFeaturePubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureRelationshipsRelatedByObjectId) {
                foreach ($this->collFeatureRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureRelationshipsRelatedBySubjectId) {
                foreach ($this->collFeatureRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureSynonyms) {
                foreach ($this->collFeatureSynonyms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeaturelocsRelatedByFeatureId) {
                foreach ($this->collFeaturelocsRelatedByFeatureId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeaturelocsRelatedBySrcfeatureId) {
                foreach ($this->collFeaturelocsRelatedBySrcfeatureId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureprops) {
                foreach ($this->collFeatureprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationresults) {
                foreach ($this->collQuantificationresults as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudypropFeatures) {
                foreach ($this->collStudypropFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }
            if ($this->aOrganism instanceof Persistent) {
              $this->aOrganism->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAnalysisfeatures instanceof PropelCollection) {
            $this->collAnalysisfeatures->clearIterator();
        }
        $this->collAnalysisfeatures = null;
        if ($this->collElements instanceof PropelCollection) {
            $this->collElements->clearIterator();
        }
        $this->collElements = null;
        if ($this->collFeatureCvterms instanceof PropelCollection) {
            $this->collFeatureCvterms->clearIterator();
        }
        $this->collFeatureCvterms = null;
        if ($this->collFeatureDbxrefs instanceof PropelCollection) {
            $this->collFeatureDbxrefs->clearIterator();
        }
        $this->collFeatureDbxrefs = null;
        if ($this->collFeaturePubs instanceof PropelCollection) {
            $this->collFeaturePubs->clearIterator();
        }
        $this->collFeaturePubs = null;
        if ($this->collFeatureRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collFeatureRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collFeatureRelationshipsRelatedByObjectId = null;
        if ($this->collFeatureRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collFeatureRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collFeatureRelationshipsRelatedBySubjectId = null;
        if ($this->collFeatureSynonyms instanceof PropelCollection) {
            $this->collFeatureSynonyms->clearIterator();
        }
        $this->collFeatureSynonyms = null;
        if ($this->collFeaturelocsRelatedByFeatureId instanceof PropelCollection) {
            $this->collFeaturelocsRelatedByFeatureId->clearIterator();
        }
        $this->collFeaturelocsRelatedByFeatureId = null;
        if ($this->collFeaturelocsRelatedBySrcfeatureId instanceof PropelCollection) {
            $this->collFeaturelocsRelatedBySrcfeatureId->clearIterator();
        }
        $this->collFeaturelocsRelatedBySrcfeatureId = null;
        if ($this->collFeatureprops instanceof PropelCollection) {
            $this->collFeatureprops->clearIterator();
        }
        $this->collFeatureprops = null;
        if ($this->collQuantificationresults instanceof PropelCollection) {
            $this->collQuantificationresults->clearIterator();
        }
        $this->collQuantificationresults = null;
        if ($this->collStudypropFeatures instanceof PropelCollection) {
            $this->collStudypropFeatures->clearIterator();
        }
        $this->collStudypropFeatures = null;
        $this->aDbxref = null;
        $this->aOrganism = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeaturePeer::DEFAULT_STRING_FORMAT);
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
