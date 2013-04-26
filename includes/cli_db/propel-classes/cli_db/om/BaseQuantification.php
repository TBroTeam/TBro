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
use cli_db\propel\Acquisition;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\Analysis;
use cli_db\propel\AnalysisQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Elementresult;
use cli_db\propel\ElementresultQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationPeer;
use cli_db\propel\QuantificationQuery;
use cli_db\propel\QuantificationRelationship;
use cli_db\propel\QuantificationRelationshipQuery;
use cli_db\propel\Quantificationprop;
use cli_db\propel\QuantificationpropQuery;
use cli_db\propel\Quantificationresult;
use cli_db\propel\QuantificationresultQuery;

/**
 * Base class that represents a row from the 'quantification' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseQuantification extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\QuantificationPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        QuantificationPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the quantification_id field.
     * @var        int
     */
    protected $quantification_id;

    /**
     * The value for the acquisition_id field.
     * @var        int
     */
    protected $acquisition_id;

    /**
     * The value for the operator_id field.
     * @var        int
     */
    protected $operator_id;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

    /**
     * The value for the analysis_id field.
     * @var        int
     */
    protected $analysis_id;

    /**
     * The value for the quantificationdate field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $quantificationdate;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the uri field.
     * @var        string
     */
    protected $uri;

    /**
     * @var        Acquisition
     */
    protected $aAcquisition;

    /**
     * @var        Analysis
     */
    protected $aAnalysis;

    /**
     * @var        Contact
     */
    protected $aContact;

    /**
     * @var        Protocol
     */
    protected $aProtocol;

    /**
     * @var        PropelObjectCollection|Elementresult[] Collection to store aggregation of Elementresult objects.
     */
    protected $collElementresults;
    protected $collElementresultsPartial;

    /**
     * @var        PropelObjectCollection|QuantificationRelationship[] Collection to store aggregation of QuantificationRelationship objects.
     */
    protected $collQuantificationRelationshipsRelatedByObjectId;
    protected $collQuantificationRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|QuantificationRelationship[] Collection to store aggregation of QuantificationRelationship objects.
     */
    protected $collQuantificationRelationshipsRelatedBySubjectId;
    protected $collQuantificationRelationshipsRelatedBySubjectIdPartial;

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
    protected $elementresultsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of BaseQuantification object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [quantification_id] column value.
     *
     * @return int
     */
    public function getQuantificationId()
    {
        return $this->quantification_id;
    }

    /**
     * Get the [acquisition_id] column value.
     *
     * @return int
     */
    public function getAcquisitionId()
    {
        return $this->acquisition_id;
    }

    /**
     * Get the [operator_id] column value.
     *
     * @return int
     */
    public function getOperatorId()
    {
        return $this->operator_id;
    }

    /**
     * Get the [protocol_id] column value.
     *
     * @return int
     */
    public function getProtocolId()
    {
        return $this->protocol_id;
    }

    /**
     * Get the [analysis_id] column value.
     *
     * @return int
     */
    public function getAnalysisId()
    {
        return $this->analysis_id;
    }

    /**
     * Get the [optionally formatted] temporal [quantificationdate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getQuantificationdate($format = 'Y-m-d H:i:s')
    {
        if ($this->quantificationdate === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->quantificationdate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->quantificationdate, true), $x);
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [uri] column value.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Set the value of [quantification_id] column.
     *
     * @param int $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->quantification_id !== $v) {
            $this->quantification_id = $v;
            $this->modifiedColumns[] = QuantificationPeer::QUANTIFICATION_ID;
        }


        return $this;
    } // setQuantificationId()

    /**
     * Set the value of [acquisition_id] column.
     *
     * @param int $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setAcquisitionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->acquisition_id !== $v) {
            $this->acquisition_id = $v;
            $this->modifiedColumns[] = QuantificationPeer::ACQUISITION_ID;
        }

        if ($this->aAcquisition !== null && $this->aAcquisition->getAcquisitionId() !== $v) {
            $this->aAcquisition = null;
        }


        return $this;
    } // setAcquisitionId()

    /**
     * Set the value of [operator_id] column.
     *
     * @param int $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setOperatorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->operator_id !== $v) {
            $this->operator_id = $v;
            $this->modifiedColumns[] = QuantificationPeer::OPERATOR_ID;
        }

        if ($this->aContact !== null && $this->aContact->getContactId() !== $v) {
            $this->aContact = null;
        }


        return $this;
    } // setOperatorId()

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = QuantificationPeer::PROTOCOL_ID;
        }

        if ($this->aProtocol !== null && $this->aProtocol->getProtocolId() !== $v) {
            $this->aProtocol = null;
        }


        return $this;
    } // setProtocolId()

    /**
     * Set the value of [analysis_id] column.
     *
     * @param int $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setAnalysisId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->analysis_id !== $v) {
            $this->analysis_id = $v;
            $this->modifiedColumns[] = QuantificationPeer::ANALYSIS_ID;
        }

        if ($this->aAnalysis !== null && $this->aAnalysis->getAnalysisId() !== $v) {
            $this->aAnalysis = null;
        }


        return $this;
    } // setAnalysisId()

    /**
     * Sets the value of [quantificationdate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationdate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->quantificationdate !== null || $dt !== null) {
            $currentDateAsString = ($this->quantificationdate !== null && $tmpDt = new DateTime($this->quantificationdate)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->quantificationdate = $newDateAsString;
                $this->modifiedColumns[] = QuantificationPeer::QUANTIFICATIONDATE;
            }
        } // if either are not null


        return $this;
    } // setQuantificationdate()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = QuantificationPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [uri] column.
     *
     * @param string $v new value
     * @return Quantification The current object (for fluent API support)
     */
    public function setUri($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->uri !== $v) {
            $this->uri = $v;
            $this->modifiedColumns[] = QuantificationPeer::URI;
        }


        return $this;
    } // setUri()

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

            $this->quantification_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->acquisition_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->operator_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->protocol_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->analysis_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->quantificationdate = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->name = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->uri = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 8; // 8 = QuantificationPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Quantification object", $e);
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

        if ($this->aAcquisition !== null && $this->acquisition_id !== $this->aAcquisition->getAcquisitionId()) {
            $this->aAcquisition = null;
        }
        if ($this->aContact !== null && $this->operator_id !== $this->aContact->getContactId()) {
            $this->aContact = null;
        }
        if ($this->aProtocol !== null && $this->protocol_id !== $this->aProtocol->getProtocolId()) {
            $this->aProtocol = null;
        }
        if ($this->aAnalysis !== null && $this->analysis_id !== $this->aAnalysis->getAnalysisId()) {
            $this->aAnalysis = null;
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
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = QuantificationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAcquisition = null;
            $this->aAnalysis = null;
            $this->aContact = null;
            $this->aProtocol = null;
            $this->collElementresults = null;

            $this->collQuantificationRelationshipsRelatedByObjectId = null;

            $this->collQuantificationRelationshipsRelatedBySubjectId = null;

            $this->collQuantificationprops = null;

            $this->collQuantificationresults = null;

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
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = QuantificationQuery::create()
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
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                QuantificationPeer::addInstanceToPool($this);
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

            if ($this->aAcquisition !== null) {
                if ($this->aAcquisition->isModified() || $this->aAcquisition->isNew()) {
                    $affectedRows += $this->aAcquisition->save($con);
                }
                $this->setAcquisition($this->aAcquisition);
            }

            if ($this->aAnalysis !== null) {
                if ($this->aAnalysis->isModified() || $this->aAnalysis->isNew()) {
                    $affectedRows += $this->aAnalysis->save($con);
                }
                $this->setAnalysis($this->aAnalysis);
            }

            if ($this->aContact !== null) {
                if ($this->aContact->isModified() || $this->aContact->isNew()) {
                    $affectedRows += $this->aContact->save($con);
                }
                $this->setContact($this->aContact);
            }

            if ($this->aProtocol !== null) {
                if ($this->aProtocol->isModified() || $this->aProtocol->isNew()) {
                    $affectedRows += $this->aProtocol->save($con);
                }
                $this->setProtocol($this->aProtocol);
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

            if ($this->elementresultsScheduledForDeletion !== null) {
                if (!$this->elementresultsScheduledForDeletion->isEmpty()) {
                    ElementresultQuery::create()
                        ->filterByPrimaryKeys($this->elementresultsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementresultsScheduledForDeletion = null;
                }
            }

            if ($this->collElementresults !== null) {
                foreach ($this->collElementresults as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    QuantificationRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collQuantificationRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collQuantificationRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    QuantificationRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collQuantificationRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collQuantificationRelationshipsRelatedBySubjectId as $referrerFK) {
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

        $this->modifiedColumns[] = QuantificationPeer::QUANTIFICATION_ID;
        if (null !== $this->quantification_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . QuantificationPeer::QUANTIFICATION_ID . ')');
        }
        if (null === $this->quantification_id) {
            try {
                $stmt = $con->query("SELECT nextval('quantification_quantification_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->quantification_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(QuantificationPeer::QUANTIFICATION_ID)) {
            $modifiedColumns[':p' . $index++]  = '"quantification_id"';
        }
        if ($this->isColumnModified(QuantificationPeer::ACQUISITION_ID)) {
            $modifiedColumns[':p' . $index++]  = '"acquisition_id"';
        }
        if ($this->isColumnModified(QuantificationPeer::OPERATOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '"operator_id"';
        }
        if ($this->isColumnModified(QuantificationPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(QuantificationPeer::ANALYSIS_ID)) {
            $modifiedColumns[':p' . $index++]  = '"analysis_id"';
        }
        if ($this->isColumnModified(QuantificationPeer::QUANTIFICATIONDATE)) {
            $modifiedColumns[':p' . $index++]  = '"quantificationdate"';
        }
        if ($this->isColumnModified(QuantificationPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(QuantificationPeer::URI)) {
            $modifiedColumns[':p' . $index++]  = '"uri"';
        }

        $sql = sprintf(
            'INSERT INTO "quantification" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"quantification_id"':
                        $stmt->bindValue($identifier, $this->quantification_id, PDO::PARAM_INT);
                        break;
                    case '"acquisition_id"':
                        $stmt->bindValue($identifier, $this->acquisition_id, PDO::PARAM_INT);
                        break;
                    case '"operator_id"':
                        $stmt->bindValue($identifier, $this->operator_id, PDO::PARAM_INT);
                        break;
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"analysis_id"':
                        $stmt->bindValue($identifier, $this->analysis_id, PDO::PARAM_INT);
                        break;
                    case '"quantificationdate"':
                        $stmt->bindValue($identifier, $this->quantificationdate, PDO::PARAM_STR);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"uri"':
                        $stmt->bindValue($identifier, $this->uri, PDO::PARAM_STR);
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

            if ($this->aAcquisition !== null) {
                if (!$this->aAcquisition->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAcquisition->getValidationFailures());
                }
            }

            if ($this->aAnalysis !== null) {
                if (!$this->aAnalysis->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAnalysis->getValidationFailures());
                }
            }

            if ($this->aContact !== null) {
                if (!$this->aContact->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aContact->getValidationFailures());
                }
            }

            if ($this->aProtocol !== null) {
                if (!$this->aProtocol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProtocol->getValidationFailures());
                }
            }


            if (($retval = QuantificationPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collElementresults !== null) {
                    foreach ($this->collElementresults as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantificationRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collQuantificationRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantificationRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collQuantificationRelationshipsRelatedBySubjectId as $referrerFK) {
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
        $pos = QuantificationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getQuantificationId();
                break;
            case 1:
                return $this->getAcquisitionId();
                break;
            case 2:
                return $this->getOperatorId();
                break;
            case 3:
                return $this->getProtocolId();
                break;
            case 4:
                return $this->getAnalysisId();
                break;
            case 5:
                return $this->getQuantificationdate();
                break;
            case 6:
                return $this->getName();
                break;
            case 7:
                return $this->getUri();
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
        if (isset($alreadyDumpedObjects['Quantification'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Quantification'][$this->getPrimaryKey()] = true;
        $keys = QuantificationPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getQuantificationId(),
            $keys[1] => $this->getAcquisitionId(),
            $keys[2] => $this->getOperatorId(),
            $keys[3] => $this->getProtocolId(),
            $keys[4] => $this->getAnalysisId(),
            $keys[5] => $this->getQuantificationdate(),
            $keys[6] => $this->getName(),
            $keys[7] => $this->getUri(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAcquisition) {
                $result['Acquisition'] = $this->aAcquisition->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aAnalysis) {
                $result['Analysis'] = $this->aAnalysis->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContact) {
                $result['Contact'] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProtocol) {
                $result['Protocol'] = $this->aProtocol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collElementresults) {
                $result['Elementresults'] = $this->collElementresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationRelationshipsRelatedByObjectId) {
                $result['QuantificationRelationshipsRelatedByObjectId'] = $this->collQuantificationRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationRelationshipsRelatedBySubjectId) {
                $result['QuantificationRelationshipsRelatedBySubjectId'] = $this->collQuantificationRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationprops) {
                $result['Quantificationprops'] = $this->collQuantificationprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantificationresults) {
                $result['Quantificationresults'] = $this->collQuantificationresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = QuantificationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setQuantificationId($value);
                break;
            case 1:
                $this->setAcquisitionId($value);
                break;
            case 2:
                $this->setOperatorId($value);
                break;
            case 3:
                $this->setProtocolId($value);
                break;
            case 4:
                $this->setAnalysisId($value);
                break;
            case 5:
                $this->setQuantificationdate($value);
                break;
            case 6:
                $this->setName($value);
                break;
            case 7:
                $this->setUri($value);
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
        $keys = QuantificationPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setQuantificationId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAcquisitionId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setOperatorId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setProtocolId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAnalysisId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setQuantificationdate($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setUri($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(QuantificationPeer::DATABASE_NAME);

        if ($this->isColumnModified(QuantificationPeer::QUANTIFICATION_ID)) $criteria->add(QuantificationPeer::QUANTIFICATION_ID, $this->quantification_id);
        if ($this->isColumnModified(QuantificationPeer::ACQUISITION_ID)) $criteria->add(QuantificationPeer::ACQUISITION_ID, $this->acquisition_id);
        if ($this->isColumnModified(QuantificationPeer::OPERATOR_ID)) $criteria->add(QuantificationPeer::OPERATOR_ID, $this->operator_id);
        if ($this->isColumnModified(QuantificationPeer::PROTOCOL_ID)) $criteria->add(QuantificationPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(QuantificationPeer::ANALYSIS_ID)) $criteria->add(QuantificationPeer::ANALYSIS_ID, $this->analysis_id);
        if ($this->isColumnModified(QuantificationPeer::QUANTIFICATIONDATE)) $criteria->add(QuantificationPeer::QUANTIFICATIONDATE, $this->quantificationdate);
        if ($this->isColumnModified(QuantificationPeer::NAME)) $criteria->add(QuantificationPeer::NAME, $this->name);
        if ($this->isColumnModified(QuantificationPeer::URI)) $criteria->add(QuantificationPeer::URI, $this->uri);

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
        $criteria = new Criteria(QuantificationPeer::DATABASE_NAME);
        $criteria->add(QuantificationPeer::QUANTIFICATION_ID, $this->quantification_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getQuantificationId();
    }

    /**
     * Generic method to set the primary key (quantification_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setQuantificationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getQuantificationId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Quantification (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAcquisitionId($this->getAcquisitionId());
        $copyObj->setOperatorId($this->getOperatorId());
        $copyObj->setProtocolId($this->getProtocolId());
        $copyObj->setAnalysisId($this->getAnalysisId());
        $copyObj->setQuantificationdate($this->getQuantificationdate());
        $copyObj->setName($this->getName());
        $copyObj->setUri($this->getUri());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getElementresults() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementresult($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantificationRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantificationRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
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

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setQuantificationId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Quantification Clone of current object.
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
     * @return QuantificationPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new QuantificationPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Acquisition object.
     *
     * @param             Acquisition $v
     * @return Quantification The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAcquisition(Acquisition $v = null)
    {
        if ($v === null) {
            $this->setAcquisitionId(NULL);
        } else {
            $this->setAcquisitionId($v->getAcquisitionId());
        }

        $this->aAcquisition = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Acquisition object, it will not be re-added.
        if ($v !== null) {
            $v->addQuantification($this);
        }


        return $this;
    }


    /**
     * Get the associated Acquisition object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Acquisition The associated Acquisition object.
     * @throws PropelException
     */
    public function getAcquisition(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAcquisition === null && ($this->acquisition_id !== null) && $doQuery) {
            $this->aAcquisition = AcquisitionQuery::create()->findPk($this->acquisition_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAcquisition->addQuantifications($this);
             */
        }

        return $this->aAcquisition;
    }

    /**
     * Declares an association between this object and a Analysis object.
     *
     * @param             Analysis $v
     * @return Quantification The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAnalysis(Analysis $v = null)
    {
        if ($v === null) {
            $this->setAnalysisId(NULL);
        } else {
            $this->setAnalysisId($v->getAnalysisId());
        }

        $this->aAnalysis = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Analysis object, it will not be re-added.
        if ($v !== null) {
            $v->addQuantification($this);
        }


        return $this;
    }


    /**
     * Get the associated Analysis object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Analysis The associated Analysis object.
     * @throws PropelException
     */
    public function getAnalysis(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAnalysis === null && ($this->analysis_id !== null) && $doQuery) {
            $this->aAnalysis = AnalysisQuery::create()->findPk($this->analysis_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAnalysis->addQuantifications($this);
             */
        }

        return $this->aAnalysis;
    }

    /**
     * Declares an association between this object and a Contact object.
     *
     * @param             Contact $v
     * @return Quantification The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(Contact $v = null)
    {
        if ($v === null) {
            $this->setOperatorId(NULL);
        } else {
            $this->setOperatorId($v->getContactId());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Contact object, it will not be re-added.
        if ($v !== null) {
            $v->addQuantification($this);
        }


        return $this;
    }


    /**
     * Get the associated Contact object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Contact The associated Contact object.
     * @throws PropelException
     */
    public function getContact(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aContact === null && ($this->operator_id !== null) && $doQuery) {
            $this->aContact = ContactQuery::create()->findPk($this->operator_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addQuantifications($this);
             */
        }

        return $this->aContact;
    }

    /**
     * Declares an association between this object and a Protocol object.
     *
     * @param             Protocol $v
     * @return Quantification The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProtocol(Protocol $v = null)
    {
        if ($v === null) {
            $this->setProtocolId(NULL);
        } else {
            $this->setProtocolId($v->getProtocolId());
        }

        $this->aProtocol = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Protocol object, it will not be re-added.
        if ($v !== null) {
            $v->addQuantification($this);
        }


        return $this;
    }


    /**
     * Get the associated Protocol object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Protocol The associated Protocol object.
     * @throws PropelException
     */
    public function getProtocol(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProtocol === null && ($this->protocol_id !== null) && $doQuery) {
            $this->aProtocol = ProtocolQuery::create()->findPk($this->protocol_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProtocol->addQuantifications($this);
             */
        }

        return $this->aProtocol;
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
        if ('Elementresult' == $relationName) {
            $this->initElementresults();
        }
        if ('QuantificationRelationshipRelatedByObjectId' == $relationName) {
            $this->initQuantificationRelationshipsRelatedByObjectId();
        }
        if ('QuantificationRelationshipRelatedBySubjectId' == $relationName) {
            $this->initQuantificationRelationshipsRelatedBySubjectId();
        }
        if ('Quantificationprop' == $relationName) {
            $this->initQuantificationprops();
        }
        if ('Quantificationresult' == $relationName) {
            $this->initQuantificationresults();
        }
    }

    /**
     * Clears out the collElementresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Quantification The current object (for fluent API support)
     * @see        addElementresults()
     */
    public function clearElementresults()
    {
        $this->collElementresults = null; // important to set this to null since that means it is uninitialized
        $this->collElementresultsPartial = null;

        return $this;
    }

    /**
     * reset is the collElementresults collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementresults($v = true)
    {
        $this->collElementresultsPartial = $v;
    }

    /**
     * Initializes the collElementresults collection.
     *
     * By default this just sets the collElementresults collection to an empty array (like clearcollElementresults());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementresults($overrideExisting = true)
    {
        if (null !== $this->collElementresults && !$overrideExisting) {
            return;
        }
        $this->collElementresults = new PropelObjectCollection();
        $this->collElementresults->setModel('Elementresult');
    }

    /**
     * Gets an array of Elementresult objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Quantification is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Elementresult[] List of Elementresult objects
     * @throws PropelException
     */
    public function getElementresults($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementresultsPartial && !$this->isNew();
        if (null === $this->collElementresults || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementresults) {
                // return empty collection
                $this->initElementresults();
            } else {
                $collElementresults = ElementresultQuery::create(null, $criteria)
                    ->filterByQuantification($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementresultsPartial && count($collElementresults)) {
                      $this->initElementresults(false);

                      foreach($collElementresults as $obj) {
                        if (false == $this->collElementresults->contains($obj)) {
                          $this->collElementresults->append($obj);
                        }
                      }

                      $this->collElementresultsPartial = true;
                    }

                    $collElementresults->getInternalIterator()->rewind();
                    return $collElementresults;
                }

                if($partial && $this->collElementresults) {
                    foreach($this->collElementresults as $obj) {
                        if($obj->isNew()) {
                            $collElementresults[] = $obj;
                        }
                    }
                }

                $this->collElementresults = $collElementresults;
                $this->collElementresultsPartial = false;
            }
        }

        return $this->collElementresults;
    }

    /**
     * Sets a collection of Elementresult objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementresults A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Quantification The current object (for fluent API support)
     */
    public function setElementresults(PropelCollection $elementresults, PropelPDO $con = null)
    {
        $elementresultsToDelete = $this->getElementresults(new Criteria(), $con)->diff($elementresults);

        $this->elementresultsScheduledForDeletion = unserialize(serialize($elementresultsToDelete));

        foreach ($elementresultsToDelete as $elementresultRemoved) {
            $elementresultRemoved->setQuantification(null);
        }

        $this->collElementresults = null;
        foreach ($elementresults as $elementresult) {
            $this->addElementresult($elementresult);
        }

        $this->collElementresults = $elementresults;
        $this->collElementresultsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Elementresult objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Elementresult objects.
     * @throws PropelException
     */
    public function countElementresults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementresultsPartial && !$this->isNew();
        if (null === $this->collElementresults || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementresults) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementresults());
            }
            $query = ElementresultQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuantification($this)
                ->count($con);
        }

        return count($this->collElementresults);
    }

    /**
     * Method called to associate a Elementresult object to this object
     * through the Elementresult foreign key attribute.
     *
     * @param    Elementresult $l Elementresult
     * @return Quantification The current object (for fluent API support)
     */
    public function addElementresult(Elementresult $l)
    {
        if ($this->collElementresults === null) {
            $this->initElementresults();
            $this->collElementresultsPartial = true;
        }
        if (!in_array($l, $this->collElementresults->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementresult($l);
        }

        return $this;
    }

    /**
     * @param	Elementresult $elementresult The elementresult object to add.
     */
    protected function doAddElementresult($elementresult)
    {
        $this->collElementresults[]= $elementresult;
        $elementresult->setQuantification($this);
    }

    /**
     * @param	Elementresult $elementresult The elementresult object to remove.
     * @return Quantification The current object (for fluent API support)
     */
    public function removeElementresult($elementresult)
    {
        if ($this->getElementresults()->contains($elementresult)) {
            $this->collElementresults->remove($this->collElementresults->search($elementresult));
            if (null === $this->elementresultsScheduledForDeletion) {
                $this->elementresultsScheduledForDeletion = clone $this->collElementresults;
                $this->elementresultsScheduledForDeletion->clear();
            }
            $this->elementresultsScheduledForDeletion[]= clone $elementresult;
            $elementresult->setQuantification(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related Elementresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Elementresult[] List of Elementresult objects
     */
    public function getElementresultsJoinElement($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultQuery::create(null, $criteria);
        $query->joinWith('Element', $join_behavior);

        return $this->getElementresults($query, $con);
    }

    /**
     * Clears out the collQuantificationRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Quantification The current object (for fluent API support)
     * @see        addQuantificationRelationshipsRelatedByObjectId()
     */
    public function clearQuantificationRelationshipsRelatedByObjectId()
    {
        $this->collQuantificationRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantificationRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantificationRelationshipsRelatedByObjectId($v = true)
    {
        $this->collQuantificationRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collQuantificationRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collQuantificationRelationshipsRelatedByObjectId collection to an empty array (like clearcollQuantificationRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantificationRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collQuantificationRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collQuantificationRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collQuantificationRelationshipsRelatedByObjectId->setModel('QuantificationRelationship');
    }

    /**
     * Gets an array of QuantificationRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Quantification is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     * @throws PropelException
     */
    public function getQuantificationRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initQuantificationRelationshipsRelatedByObjectId();
            } else {
                $collQuantificationRelationshipsRelatedByObjectId = QuantificationRelationshipQuery::create(null, $criteria)
                    ->filterByQuantificationRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationRelationshipsRelatedByObjectIdPartial && count($collQuantificationRelationshipsRelatedByObjectId)) {
                      $this->initQuantificationRelationshipsRelatedByObjectId(false);

                      foreach($collQuantificationRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collQuantificationRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collQuantificationRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collQuantificationRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collQuantificationRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collQuantificationRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collQuantificationRelationshipsRelatedByObjectId) {
                    foreach($this->collQuantificationRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collQuantificationRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collQuantificationRelationshipsRelatedByObjectId = $collQuantificationRelationshipsRelatedByObjectId;
                $this->collQuantificationRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collQuantificationRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of QuantificationRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantificationRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationRelationshipsRelatedByObjectId(PropelCollection $quantificationRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $quantificationRelationshipsRelatedByObjectIdToDelete = $this->getQuantificationRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($quantificationRelationshipsRelatedByObjectId);

        $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($quantificationRelationshipsRelatedByObjectIdToDelete));

        foreach ($quantificationRelationshipsRelatedByObjectIdToDelete as $quantificationRelationshipRelatedByObjectIdRemoved) {
            $quantificationRelationshipRelatedByObjectIdRemoved->setQuantificationRelatedByObjectId(null);
        }

        $this->collQuantificationRelationshipsRelatedByObjectId = null;
        foreach ($quantificationRelationshipsRelatedByObjectId as $quantificationRelationshipRelatedByObjectId) {
            $this->addQuantificationRelationshipRelatedByObjectId($quantificationRelationshipRelatedByObjectId);
        }

        $this->collQuantificationRelationshipsRelatedByObjectId = $quantificationRelationshipsRelatedByObjectId;
        $this->collQuantificationRelationshipsRelatedByObjectIdPartial = false;

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
    public function countQuantificationRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantificationRelationshipsRelatedByObjectId());
            }
            $query = QuantificationRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuantificationRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collQuantificationRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a QuantificationRelationship object to this object
     * through the QuantificationRelationship foreign key attribute.
     *
     * @param    QuantificationRelationship $l QuantificationRelationship
     * @return Quantification The current object (for fluent API support)
     */
    public function addQuantificationRelationshipRelatedByObjectId(QuantificationRelationship $l)
    {
        if ($this->collQuantificationRelationshipsRelatedByObjectId === null) {
            $this->initQuantificationRelationshipsRelatedByObjectId();
            $this->collQuantificationRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collQuantificationRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantificationRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	QuantificationRelationshipRelatedByObjectId $quantificationRelationshipRelatedByObjectId The quantificationRelationshipRelatedByObjectId object to add.
     */
    protected function doAddQuantificationRelationshipRelatedByObjectId($quantificationRelationshipRelatedByObjectId)
    {
        $this->collQuantificationRelationshipsRelatedByObjectId[]= $quantificationRelationshipRelatedByObjectId;
        $quantificationRelationshipRelatedByObjectId->setQuantificationRelatedByObjectId($this);
    }

    /**
     * @param	QuantificationRelationshipRelatedByObjectId $quantificationRelationshipRelatedByObjectId The quantificationRelationshipRelatedByObjectId object to remove.
     * @return Quantification The current object (for fluent API support)
     */
    public function removeQuantificationRelationshipRelatedByObjectId($quantificationRelationshipRelatedByObjectId)
    {
        if ($this->getQuantificationRelationshipsRelatedByObjectId()->contains($quantificationRelationshipRelatedByObjectId)) {
            $this->collQuantificationRelationshipsRelatedByObjectId->remove($this->collQuantificationRelationshipsRelatedByObjectId->search($quantificationRelationshipRelatedByObjectId));
            if (null === $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collQuantificationRelationshipsRelatedByObjectId;
                $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->quantificationRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $quantificationRelationshipRelatedByObjectId;
            $quantificationRelationshipRelatedByObjectId->setQuantificationRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related QuantificationRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     */
    public function getQuantificationRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getQuantificationRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collQuantificationRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Quantification The current object (for fluent API support)
     * @see        addQuantificationRelationshipsRelatedBySubjectId()
     */
    public function clearQuantificationRelationshipsRelatedBySubjectId()
    {
        $this->collQuantificationRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantificationRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantificationRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collQuantificationRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collQuantificationRelationshipsRelatedBySubjectId collection to an empty array (like clearcollQuantificationRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantificationRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collQuantificationRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collQuantificationRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collQuantificationRelationshipsRelatedBySubjectId->setModel('QuantificationRelationship');
    }

    /**
     * Gets an array of QuantificationRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Quantification is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     * @throws PropelException
     */
    public function getQuantificationRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initQuantificationRelationshipsRelatedBySubjectId();
            } else {
                $collQuantificationRelationshipsRelatedBySubjectId = QuantificationRelationshipQuery::create(null, $criteria)
                    ->filterByQuantificationRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationRelationshipsRelatedBySubjectIdPartial && count($collQuantificationRelationshipsRelatedBySubjectId)) {
                      $this->initQuantificationRelationshipsRelatedBySubjectId(false);

                      foreach($collQuantificationRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collQuantificationRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collQuantificationRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collQuantificationRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collQuantificationRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collQuantificationRelationshipsRelatedBySubjectId) {
                    foreach($this->collQuantificationRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collQuantificationRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collQuantificationRelationshipsRelatedBySubjectId = $collQuantificationRelationshipsRelatedBySubjectId;
                $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collQuantificationRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of QuantificationRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantificationRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationRelationshipsRelatedBySubjectId(PropelCollection $quantificationRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $quantificationRelationshipsRelatedBySubjectIdToDelete = $this->getQuantificationRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($quantificationRelationshipsRelatedBySubjectId);

        $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($quantificationRelationshipsRelatedBySubjectIdToDelete));

        foreach ($quantificationRelationshipsRelatedBySubjectIdToDelete as $quantificationRelationshipRelatedBySubjectIdRemoved) {
            $quantificationRelationshipRelatedBySubjectIdRemoved->setQuantificationRelatedBySubjectId(null);
        }

        $this->collQuantificationRelationshipsRelatedBySubjectId = null;
        foreach ($quantificationRelationshipsRelatedBySubjectId as $quantificationRelationshipRelatedBySubjectId) {
            $this->addQuantificationRelationshipRelatedBySubjectId($quantificationRelationshipRelatedBySubjectId);
        }

        $this->collQuantificationRelationshipsRelatedBySubjectId = $quantificationRelationshipsRelatedBySubjectId;
        $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = false;

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
    public function countQuantificationRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collQuantificationRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantificationRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantificationRelationshipsRelatedBySubjectId());
            }
            $query = QuantificationRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByQuantificationRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collQuantificationRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a QuantificationRelationship object to this object
     * through the QuantificationRelationship foreign key attribute.
     *
     * @param    QuantificationRelationship $l QuantificationRelationship
     * @return Quantification The current object (for fluent API support)
     */
    public function addQuantificationRelationshipRelatedBySubjectId(QuantificationRelationship $l)
    {
        if ($this->collQuantificationRelationshipsRelatedBySubjectId === null) {
            $this->initQuantificationRelationshipsRelatedBySubjectId();
            $this->collQuantificationRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collQuantificationRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantificationRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	QuantificationRelationshipRelatedBySubjectId $quantificationRelationshipRelatedBySubjectId The quantificationRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddQuantificationRelationshipRelatedBySubjectId($quantificationRelationshipRelatedBySubjectId)
    {
        $this->collQuantificationRelationshipsRelatedBySubjectId[]= $quantificationRelationshipRelatedBySubjectId;
        $quantificationRelationshipRelatedBySubjectId->setQuantificationRelatedBySubjectId($this);
    }

    /**
     * @param	QuantificationRelationshipRelatedBySubjectId $quantificationRelationshipRelatedBySubjectId The quantificationRelationshipRelatedBySubjectId object to remove.
     * @return Quantification The current object (for fluent API support)
     */
    public function removeQuantificationRelationshipRelatedBySubjectId($quantificationRelationshipRelatedBySubjectId)
    {
        if ($this->getQuantificationRelationshipsRelatedBySubjectId()->contains($quantificationRelationshipRelatedBySubjectId)) {
            $this->collQuantificationRelationshipsRelatedBySubjectId->remove($this->collQuantificationRelationshipsRelatedBySubjectId->search($quantificationRelationshipRelatedBySubjectId));
            if (null === $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collQuantificationRelationshipsRelatedBySubjectId;
                $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->quantificationRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $quantificationRelationshipRelatedBySubjectId;
            $quantificationRelationshipRelatedBySubjectId->setQuantificationRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related QuantificationRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|QuantificationRelationship[] List of QuantificationRelationship objects
     */
    public function getQuantificationRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getQuantificationRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collQuantificationprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Quantification The current object (for fluent API support)
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
     * If this Quantification is new, it will return
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
                    ->filterByQuantification($this)
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
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationprops(PropelCollection $quantificationprops, PropelPDO $con = null)
    {
        $quantificationpropsToDelete = $this->getQuantificationprops(new Criteria(), $con)->diff($quantificationprops);

        $this->quantificationpropsScheduledForDeletion = unserialize(serialize($quantificationpropsToDelete));

        foreach ($quantificationpropsToDelete as $quantificationpropRemoved) {
            $quantificationpropRemoved->setQuantification(null);
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
                ->filterByQuantification($this)
                ->count($con);
        }

        return count($this->collQuantificationprops);
    }

    /**
     * Method called to associate a Quantificationprop object to this object
     * through the Quantificationprop foreign key attribute.
     *
     * @param    Quantificationprop $l Quantificationprop
     * @return Quantification The current object (for fluent API support)
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
        $quantificationprop->setQuantification($this);
    }

    /**
     * @param	Quantificationprop $quantificationprop The quantificationprop object to remove.
     * @return Quantification The current object (for fluent API support)
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
            $quantificationprop->setQuantification(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related Quantificationprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantificationprop[] List of Quantificationprop objects
     */
    public function getQuantificationpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getQuantificationprops($query, $con);
    }

    /**
     * Clears out the collQuantificationresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Quantification The current object (for fluent API support)
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
     * If this Quantification is new, it will return
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
                    ->filterByQuantification($this)
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
     * @return Quantification The current object (for fluent API support)
     */
    public function setQuantificationresults(PropelCollection $quantificationresults, PropelPDO $con = null)
    {
        $quantificationresultsToDelete = $this->getQuantificationresults(new Criteria(), $con)->diff($quantificationresults);

        $this->quantificationresultsScheduledForDeletion = unserialize(serialize($quantificationresultsToDelete));

        foreach ($quantificationresultsToDelete as $quantificationresultRemoved) {
            $quantificationresultRemoved->setQuantification(null);
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
                ->filterByQuantification($this)
                ->count($con);
        }

        return count($this->collQuantificationresults);
    }

    /**
     * Method called to associate a Quantificationresult object to this object
     * through the Quantificationresult foreign key attribute.
     *
     * @param    Quantificationresult $l Quantificationresult
     * @return Quantification The current object (for fluent API support)
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
        $quantificationresult->setQuantification($this);
    }

    /**
     * @param	Quantificationresult $quantificationresult The quantificationresult object to remove.
     * @return Quantification The current object (for fluent API support)
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
            $quantificationresult->setQuantification(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
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
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
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
     * Otherwise if this Quantification is new, it will return
     * an empty collection; or if this Quantification has previously
     * been saved, it will retrieve related Quantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Quantification.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->quantification_id = null;
        $this->acquisition_id = null;
        $this->operator_id = null;
        $this->protocol_id = null;
        $this->analysis_id = null;
        $this->quantificationdate = null;
        $this->name = null;
        $this->uri = null;
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
            if ($this->collElementresults) {
                foreach ($this->collElementresults as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationRelationshipsRelatedByObjectId) {
                foreach ($this->collQuantificationRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantificationRelationshipsRelatedBySubjectId) {
                foreach ($this->collQuantificationRelationshipsRelatedBySubjectId as $o) {
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
            if ($this->aAcquisition instanceof Persistent) {
              $this->aAcquisition->clearAllReferences($deep);
            }
            if ($this->aAnalysis instanceof Persistent) {
              $this->aAnalysis->clearAllReferences($deep);
            }
            if ($this->aContact instanceof Persistent) {
              $this->aContact->clearAllReferences($deep);
            }
            if ($this->aProtocol instanceof Persistent) {
              $this->aProtocol->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collElementresults instanceof PropelCollection) {
            $this->collElementresults->clearIterator();
        }
        $this->collElementresults = null;
        if ($this->collQuantificationRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collQuantificationRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collQuantificationRelationshipsRelatedByObjectId = null;
        if ($this->collQuantificationRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collQuantificationRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collQuantificationRelationshipsRelatedBySubjectId = null;
        if ($this->collQuantificationprops instanceof PropelCollection) {
            $this->collQuantificationprops->clearIterator();
        }
        $this->collQuantificationprops = null;
        if ($this->collQuantificationresults instanceof PropelCollection) {
            $this->collQuantificationresults->clearIterator();
        }
        $this->collQuantificationresults = null;
        $this->aAcquisition = null;
        $this->aAnalysis = null;
        $this->aContact = null;
        $this->aProtocol = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(QuantificationPeer::DEFAULT_STRING_FORMAT);
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
