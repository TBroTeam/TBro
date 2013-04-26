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
use cli_db\propel\AcquisitionPeer;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\AcquisitionRelationshipQuery;
use cli_db\propel\Acquisitionprop;
use cli_db\propel\AcquisitionpropQuery;
use cli_db\propel\Assay;
use cli_db\propel\AssayQuery;
use cli_db\propel\Channel;
use cli_db\propel\ChannelQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationQuery;

/**
 * Base class that represents a row from the 'acquisition' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAcquisition extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\AcquisitionPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AcquisitionPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the acquisition_id field.
     * @var        int
     */
    protected $acquisition_id;

    /**
     * The value for the assay_id field.
     * @var        int
     */
    protected $assay_id;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

    /**
     * The value for the channel_id field.
     * @var        int
     */
    protected $channel_id;

    /**
     * The value for the acquisitiondate field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $acquisitiondate;

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
     * @var        Assay
     */
    protected $aAssay;

    /**
     * @var        Channel
     */
    protected $aChannel;

    /**
     * @var        Protocol
     */
    protected $aProtocol;

    /**
     * @var        PropelObjectCollection|AcquisitionRelationship[] Collection to store aggregation of AcquisitionRelationship objects.
     */
    protected $collAcquisitionRelationshipsRelatedByObjectId;
    protected $collAcquisitionRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|AcquisitionRelationship[] Collection to store aggregation of AcquisitionRelationship objects.
     */
    protected $collAcquisitionRelationshipsRelatedBySubjectId;
    protected $collAcquisitionRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|Acquisitionprop[] Collection to store aggregation of Acquisitionprop objects.
     */
    protected $collAcquisitionprops;
    protected $collAcquisitionpropsPartial;

    /**
     * @var        PropelObjectCollection|Quantification[] Collection to store aggregation of Quantification objects.
     */
    protected $collQuantifications;
    protected $collQuantificationsPartial;

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
    protected $acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $acquisitionpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationsScheduledForDeletion = null;

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
     * Initializes internal state of BaseAcquisition object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [assay_id] column value.
     *
     * @return int
     */
    public function getAssayId()
    {
        return $this->assay_id;
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
     * Get the [channel_id] column value.
     *
     * @return int
     */
    public function getChannelId()
    {
        return $this->channel_id;
    }

    /**
     * Get the [optionally formatted] temporal [acquisitiondate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAcquisitiondate($format = 'Y-m-d H:i:s')
    {
        if ($this->acquisitiondate === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->acquisitiondate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->acquisitiondate, true), $x);
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
     * Set the value of [acquisition_id] column.
     *
     * @param int $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAcquisitionId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->acquisition_id !== $v) {
            $this->acquisition_id = $v;
            $this->modifiedColumns[] = AcquisitionPeer::ACQUISITION_ID;
        }


        return $this;
    } // setAcquisitionId()

    /**
     * Set the value of [assay_id] column.
     *
     * @param int $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAssayId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->assay_id !== $v) {
            $this->assay_id = $v;
            $this->modifiedColumns[] = AcquisitionPeer::ASSAY_ID;
        }

        if ($this->aAssay !== null && $this->aAssay->getAssayId() !== $v) {
            $this->aAssay = null;
        }


        return $this;
    } // setAssayId()

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = AcquisitionPeer::PROTOCOL_ID;
        }

        if ($this->aProtocol !== null && $this->aProtocol->getProtocolId() !== $v) {
            $this->aProtocol = null;
        }


        return $this;
    } // setProtocolId()

    /**
     * Set the value of [channel_id] column.
     *
     * @param int $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setChannelId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->channel_id !== $v) {
            $this->channel_id = $v;
            $this->modifiedColumns[] = AcquisitionPeer::CHANNEL_ID;
        }

        if ($this->aChannel !== null && $this->aChannel->getChannelId() !== $v) {
            $this->aChannel = null;
        }


        return $this;
    } // setChannelId()

    /**
     * Sets the value of [acquisitiondate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAcquisitiondate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->acquisitiondate !== null || $dt !== null) {
            $currentDateAsString = ($this->acquisitiondate !== null && $tmpDt = new DateTime($this->acquisitiondate)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->acquisitiondate = $newDateAsString;
                $this->modifiedColumns[] = AcquisitionPeer::ACQUISITIONDATE;
            }
        } // if either are not null


        return $this;
    } // setAcquisitiondate()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AcquisitionPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [uri] column.
     *
     * @param string $v new value
     * @return Acquisition The current object (for fluent API support)
     */
    public function setUri($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->uri !== $v) {
            $this->uri = $v;
            $this->modifiedColumns[] = AcquisitionPeer::URI;
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

            $this->acquisition_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->assay_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->protocol_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->channel_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->acquisitiondate = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->name = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->uri = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = AcquisitionPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Acquisition object", $e);
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

        if ($this->aAssay !== null && $this->assay_id !== $this->aAssay->getAssayId()) {
            $this->aAssay = null;
        }
        if ($this->aProtocol !== null && $this->protocol_id !== $this->aProtocol->getProtocolId()) {
            $this->aProtocol = null;
        }
        if ($this->aChannel !== null && $this->channel_id !== $this->aChannel->getChannelId()) {
            $this->aChannel = null;
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
            $con = Propel::getConnection(AcquisitionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AcquisitionPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAssay = null;
            $this->aChannel = null;
            $this->aProtocol = null;
            $this->collAcquisitionRelationshipsRelatedByObjectId = null;

            $this->collAcquisitionRelationshipsRelatedBySubjectId = null;

            $this->collAcquisitionprops = null;

            $this->collQuantifications = null;

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
            $con = Propel::getConnection(AcquisitionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AcquisitionQuery::create()
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
            $con = Propel::getConnection(AcquisitionPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AcquisitionPeer::addInstanceToPool($this);
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

            if ($this->aAssay !== null) {
                if ($this->aAssay->isModified() || $this->aAssay->isNew()) {
                    $affectedRows += $this->aAssay->save($con);
                }
                $this->setAssay($this->aAssay);
            }

            if ($this->aChannel !== null) {
                if ($this->aChannel->isModified() || $this->aChannel->isNew()) {
                    $affectedRows += $this->aChannel->save($con);
                }
                $this->setChannel($this->aChannel);
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

            if ($this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    AcquisitionRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitionRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collAcquisitionRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    AcquisitionRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitionRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collAcquisitionRelationshipsRelatedBySubjectId as $referrerFK) {
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

            if ($this->quantificationsScheduledForDeletion !== null) {
                if (!$this->quantificationsScheduledForDeletion->isEmpty()) {
                    QuantificationQuery::create()
                        ->filterByPrimaryKeys($this->quantificationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationsScheduledForDeletion = null;
                }
            }

            if ($this->collQuantifications !== null) {
                foreach ($this->collQuantifications as $referrerFK) {
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

        $this->modifiedColumns[] = AcquisitionPeer::ACQUISITION_ID;
        if (null !== $this->acquisition_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AcquisitionPeer::ACQUISITION_ID . ')');
        }
        if (null === $this->acquisition_id) {
            try {
                $stmt = $con->query("SELECT nextval('acquisition_acquisition_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->acquisition_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AcquisitionPeer::ACQUISITION_ID)) {
            $modifiedColumns[':p' . $index++]  = '"acquisition_id"';
        }
        if ($this->isColumnModified(AcquisitionPeer::ASSAY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"assay_id"';
        }
        if ($this->isColumnModified(AcquisitionPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(AcquisitionPeer::CHANNEL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"channel_id"';
        }
        if ($this->isColumnModified(AcquisitionPeer::ACQUISITIONDATE)) {
            $modifiedColumns[':p' . $index++]  = '"acquisitiondate"';
        }
        if ($this->isColumnModified(AcquisitionPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(AcquisitionPeer::URI)) {
            $modifiedColumns[':p' . $index++]  = '"uri"';
        }

        $sql = sprintf(
            'INSERT INTO "acquisition" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"acquisition_id"':
                        $stmt->bindValue($identifier, $this->acquisition_id, PDO::PARAM_INT);
                        break;
                    case '"assay_id"':
                        $stmt->bindValue($identifier, $this->assay_id, PDO::PARAM_INT);
                        break;
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"channel_id"':
                        $stmt->bindValue($identifier, $this->channel_id, PDO::PARAM_INT);
                        break;
                    case '"acquisitiondate"':
                        $stmt->bindValue($identifier, $this->acquisitiondate, PDO::PARAM_STR);
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

            if ($this->aAssay !== null) {
                if (!$this->aAssay->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAssay->getValidationFailures());
                }
            }

            if ($this->aChannel !== null) {
                if (!$this->aChannel->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aChannel->getValidationFailures());
                }
            }

            if ($this->aProtocol !== null) {
                if (!$this->aProtocol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProtocol->getValidationFailures());
                }
            }


            if (($retval = AcquisitionPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAcquisitionRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collAcquisitionRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAcquisitionRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collAcquisitionRelationshipsRelatedBySubjectId as $referrerFK) {
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

                if ($this->collQuantifications !== null) {
                    foreach ($this->collQuantifications as $referrerFK) {
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
        $pos = AcquisitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAcquisitionId();
                break;
            case 1:
                return $this->getAssayId();
                break;
            case 2:
                return $this->getProtocolId();
                break;
            case 3:
                return $this->getChannelId();
                break;
            case 4:
                return $this->getAcquisitiondate();
                break;
            case 5:
                return $this->getName();
                break;
            case 6:
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
        if (isset($alreadyDumpedObjects['Acquisition'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Acquisition'][$this->getPrimaryKey()] = true;
        $keys = AcquisitionPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAcquisitionId(),
            $keys[1] => $this->getAssayId(),
            $keys[2] => $this->getProtocolId(),
            $keys[3] => $this->getChannelId(),
            $keys[4] => $this->getAcquisitiondate(),
            $keys[5] => $this->getName(),
            $keys[6] => $this->getUri(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAssay) {
                $result['Assay'] = $this->aAssay->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aChannel) {
                $result['Channel'] = $this->aChannel->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProtocol) {
                $result['Protocol'] = $this->aProtocol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAcquisitionRelationshipsRelatedByObjectId) {
                $result['AcquisitionRelationshipsRelatedByObjectId'] = $this->collAcquisitionRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAcquisitionRelationshipsRelatedBySubjectId) {
                $result['AcquisitionRelationshipsRelatedBySubjectId'] = $this->collAcquisitionRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAcquisitionprops) {
                $result['Acquisitionprops'] = $this->collAcquisitionprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantifications) {
                $result['Quantifications'] = $this->collQuantifications->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AcquisitionPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAcquisitionId($value);
                break;
            case 1:
                $this->setAssayId($value);
                break;
            case 2:
                $this->setProtocolId($value);
                break;
            case 3:
                $this->setChannelId($value);
                break;
            case 4:
                $this->setAcquisitiondate($value);
                break;
            case 5:
                $this->setName($value);
                break;
            case 6:
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
        $keys = AcquisitionPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setAcquisitionId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAssayId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setProtocolId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setChannelId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setAcquisitiondate($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setName($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setUri($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AcquisitionPeer::DATABASE_NAME);

        if ($this->isColumnModified(AcquisitionPeer::ACQUISITION_ID)) $criteria->add(AcquisitionPeer::ACQUISITION_ID, $this->acquisition_id);
        if ($this->isColumnModified(AcquisitionPeer::ASSAY_ID)) $criteria->add(AcquisitionPeer::ASSAY_ID, $this->assay_id);
        if ($this->isColumnModified(AcquisitionPeer::PROTOCOL_ID)) $criteria->add(AcquisitionPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(AcquisitionPeer::CHANNEL_ID)) $criteria->add(AcquisitionPeer::CHANNEL_ID, $this->channel_id);
        if ($this->isColumnModified(AcquisitionPeer::ACQUISITIONDATE)) $criteria->add(AcquisitionPeer::ACQUISITIONDATE, $this->acquisitiondate);
        if ($this->isColumnModified(AcquisitionPeer::NAME)) $criteria->add(AcquisitionPeer::NAME, $this->name);
        if ($this->isColumnModified(AcquisitionPeer::URI)) $criteria->add(AcquisitionPeer::URI, $this->uri);

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
        $criteria = new Criteria(AcquisitionPeer::DATABASE_NAME);
        $criteria->add(AcquisitionPeer::ACQUISITION_ID, $this->acquisition_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getAcquisitionId();
    }

    /**
     * Generic method to set the primary key (acquisition_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAcquisitionId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getAcquisitionId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Acquisition (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAssayId($this->getAssayId());
        $copyObj->setProtocolId($this->getProtocolId());
        $copyObj->setChannelId($this->getChannelId());
        $copyObj->setAcquisitiondate($this->getAcquisitiondate());
        $copyObj->setName($this->getName());
        $copyObj->setUri($this->getUri());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAcquisitionRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisitionRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAcquisitionRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisitionRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAcquisitionprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisitionprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantifications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantification($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAcquisitionId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Acquisition Clone of current object.
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
     * @return AcquisitionPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AcquisitionPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Assay object.
     *
     * @param             Assay $v
     * @return Acquisition The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAssay(Assay $v = null)
    {
        if ($v === null) {
            $this->setAssayId(NULL);
        } else {
            $this->setAssayId($v->getAssayId());
        }

        $this->aAssay = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Assay object, it will not be re-added.
        if ($v !== null) {
            $v->addAcquisition($this);
        }


        return $this;
    }


    /**
     * Get the associated Assay object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Assay The associated Assay object.
     * @throws PropelException
     */
    public function getAssay(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAssay === null && ($this->assay_id !== null) && $doQuery) {
            $this->aAssay = AssayQuery::create()->findPk($this->assay_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAssay->addAcquisitions($this);
             */
        }

        return $this->aAssay;
    }

    /**
     * Declares an association between this object and a Channel object.
     *
     * @param             Channel $v
     * @return Acquisition The current object (for fluent API support)
     * @throws PropelException
     */
    public function setChannel(Channel $v = null)
    {
        if ($v === null) {
            $this->setChannelId(NULL);
        } else {
            $this->setChannelId($v->getChannelId());
        }

        $this->aChannel = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Channel object, it will not be re-added.
        if ($v !== null) {
            $v->addAcquisition($this);
        }


        return $this;
    }


    /**
     * Get the associated Channel object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Channel The associated Channel object.
     * @throws PropelException
     */
    public function getChannel(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aChannel === null && ($this->channel_id !== null) && $doQuery) {
            $this->aChannel = ChannelQuery::create()->findPk($this->channel_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aChannel->addAcquisitions($this);
             */
        }

        return $this->aChannel;
    }

    /**
     * Declares an association between this object and a Protocol object.
     *
     * @param             Protocol $v
     * @return Acquisition The current object (for fluent API support)
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
            $v->addAcquisition($this);
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
                $this->aProtocol->addAcquisitions($this);
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
        if ('AcquisitionRelationshipRelatedByObjectId' == $relationName) {
            $this->initAcquisitionRelationshipsRelatedByObjectId();
        }
        if ('AcquisitionRelationshipRelatedBySubjectId' == $relationName) {
            $this->initAcquisitionRelationshipsRelatedBySubjectId();
        }
        if ('Acquisitionprop' == $relationName) {
            $this->initAcquisitionprops();
        }
        if ('Quantification' == $relationName) {
            $this->initQuantifications();
        }
    }

    /**
     * Clears out the collAcquisitionRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Acquisition The current object (for fluent API support)
     * @see        addAcquisitionRelationshipsRelatedByObjectId()
     */
    public function clearAcquisitionRelationshipsRelatedByObjectId()
    {
        $this->collAcquisitionRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitionRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitionRelationshipsRelatedByObjectId($v = true)
    {
        $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collAcquisitionRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collAcquisitionRelationshipsRelatedByObjectId collection to an empty array (like clearcollAcquisitionRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitionRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collAcquisitionRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collAcquisitionRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collAcquisitionRelationshipsRelatedByObjectId->setModel('AcquisitionRelationship');
    }

    /**
     * Gets an array of AcquisitionRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Acquisition is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     * @throws PropelException
     */
    public function getAcquisitionRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initAcquisitionRelationshipsRelatedByObjectId();
            } else {
                $collAcquisitionRelationshipsRelatedByObjectId = AcquisitionRelationshipQuery::create(null, $criteria)
                    ->filterByAcquisitionRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionRelationshipsRelatedByObjectIdPartial && count($collAcquisitionRelationshipsRelatedByObjectId)) {
                      $this->initAcquisitionRelationshipsRelatedByObjectId(false);

                      foreach($collAcquisitionRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collAcquisitionRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collAcquisitionRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collAcquisitionRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collAcquisitionRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collAcquisitionRelationshipsRelatedByObjectId) {
                    foreach($this->collAcquisitionRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitionRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collAcquisitionRelationshipsRelatedByObjectId = $collAcquisitionRelationshipsRelatedByObjectId;
                $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collAcquisitionRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of AcquisitionRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitionRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAcquisitionRelationshipsRelatedByObjectId(PropelCollection $acquisitionRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $acquisitionRelationshipsRelatedByObjectIdToDelete = $this->getAcquisitionRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($acquisitionRelationshipsRelatedByObjectId);

        $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($acquisitionRelationshipsRelatedByObjectIdToDelete));

        foreach ($acquisitionRelationshipsRelatedByObjectIdToDelete as $acquisitionRelationshipRelatedByObjectIdRemoved) {
            $acquisitionRelationshipRelatedByObjectIdRemoved->setAcquisitionRelatedByObjectId(null);
        }

        $this->collAcquisitionRelationshipsRelatedByObjectId = null;
        foreach ($acquisitionRelationshipsRelatedByObjectId as $acquisitionRelationshipRelatedByObjectId) {
            $this->addAcquisitionRelationshipRelatedByObjectId($acquisitionRelationshipRelatedByObjectId);
        }

        $this->collAcquisitionRelationshipsRelatedByObjectId = $acquisitionRelationshipsRelatedByObjectId;
        $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = false;

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
    public function countAcquisitionRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitionRelationshipsRelatedByObjectId());
            }
            $query = AcquisitionRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAcquisitionRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collAcquisitionRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a AcquisitionRelationship object to this object
     * through the AcquisitionRelationship foreign key attribute.
     *
     * @param    AcquisitionRelationship $l AcquisitionRelationship
     * @return Acquisition The current object (for fluent API support)
     */
    public function addAcquisitionRelationshipRelatedByObjectId(AcquisitionRelationship $l)
    {
        if ($this->collAcquisitionRelationshipsRelatedByObjectId === null) {
            $this->initAcquisitionRelationshipsRelatedByObjectId();
            $this->collAcquisitionRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collAcquisitionRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisitionRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	AcquisitionRelationshipRelatedByObjectId $acquisitionRelationshipRelatedByObjectId The acquisitionRelationshipRelatedByObjectId object to add.
     */
    protected function doAddAcquisitionRelationshipRelatedByObjectId($acquisitionRelationshipRelatedByObjectId)
    {
        $this->collAcquisitionRelationshipsRelatedByObjectId[]= $acquisitionRelationshipRelatedByObjectId;
        $acquisitionRelationshipRelatedByObjectId->setAcquisitionRelatedByObjectId($this);
    }

    /**
     * @param	AcquisitionRelationshipRelatedByObjectId $acquisitionRelationshipRelatedByObjectId The acquisitionRelationshipRelatedByObjectId object to remove.
     * @return Acquisition The current object (for fluent API support)
     */
    public function removeAcquisitionRelationshipRelatedByObjectId($acquisitionRelationshipRelatedByObjectId)
    {
        if ($this->getAcquisitionRelationshipsRelatedByObjectId()->contains($acquisitionRelationshipRelatedByObjectId)) {
            $this->collAcquisitionRelationshipsRelatedByObjectId->remove($this->collAcquisitionRelationshipsRelatedByObjectId->search($acquisitionRelationshipRelatedByObjectId));
            if (null === $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collAcquisitionRelationshipsRelatedByObjectId;
                $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->acquisitionRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $acquisitionRelationshipRelatedByObjectId;
            $acquisitionRelationshipRelatedByObjectId->setAcquisitionRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related AcquisitionRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     */
    public function getAcquisitionRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getAcquisitionRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collAcquisitionRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Acquisition The current object (for fluent API support)
     * @see        addAcquisitionRelationshipsRelatedBySubjectId()
     */
    public function clearAcquisitionRelationshipsRelatedBySubjectId()
    {
        $this->collAcquisitionRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitionRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitionRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collAcquisitionRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collAcquisitionRelationshipsRelatedBySubjectId collection to an empty array (like clearcollAcquisitionRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitionRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collAcquisitionRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collAcquisitionRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collAcquisitionRelationshipsRelatedBySubjectId->setModel('AcquisitionRelationship');
    }

    /**
     * Gets an array of AcquisitionRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Acquisition is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     * @throws PropelException
     */
    public function getAcquisitionRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initAcquisitionRelationshipsRelatedBySubjectId();
            } else {
                $collAcquisitionRelationshipsRelatedBySubjectId = AcquisitionRelationshipQuery::create(null, $criteria)
                    ->filterByAcquisitionRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial && count($collAcquisitionRelationshipsRelatedBySubjectId)) {
                      $this->initAcquisitionRelationshipsRelatedBySubjectId(false);

                      foreach($collAcquisitionRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collAcquisitionRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collAcquisitionRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collAcquisitionRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collAcquisitionRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collAcquisitionRelationshipsRelatedBySubjectId) {
                    foreach($this->collAcquisitionRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitionRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collAcquisitionRelationshipsRelatedBySubjectId = $collAcquisitionRelationshipsRelatedBySubjectId;
                $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collAcquisitionRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of AcquisitionRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitionRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAcquisitionRelationshipsRelatedBySubjectId(PropelCollection $acquisitionRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $acquisitionRelationshipsRelatedBySubjectIdToDelete = $this->getAcquisitionRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($acquisitionRelationshipsRelatedBySubjectId);

        $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($acquisitionRelationshipsRelatedBySubjectIdToDelete));

        foreach ($acquisitionRelationshipsRelatedBySubjectIdToDelete as $acquisitionRelationshipRelatedBySubjectIdRemoved) {
            $acquisitionRelationshipRelatedBySubjectIdRemoved->setAcquisitionRelatedBySubjectId(null);
        }

        $this->collAcquisitionRelationshipsRelatedBySubjectId = null;
        foreach ($acquisitionRelationshipsRelatedBySubjectId as $acquisitionRelationshipRelatedBySubjectId) {
            $this->addAcquisitionRelationshipRelatedBySubjectId($acquisitionRelationshipRelatedBySubjectId);
        }

        $this->collAcquisitionRelationshipsRelatedBySubjectId = $acquisitionRelationshipsRelatedBySubjectId;
        $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = false;

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
    public function countAcquisitionRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collAcquisitionRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitionRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitionRelationshipsRelatedBySubjectId());
            }
            $query = AcquisitionRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAcquisitionRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collAcquisitionRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a AcquisitionRelationship object to this object
     * through the AcquisitionRelationship foreign key attribute.
     *
     * @param    AcquisitionRelationship $l AcquisitionRelationship
     * @return Acquisition The current object (for fluent API support)
     */
    public function addAcquisitionRelationshipRelatedBySubjectId(AcquisitionRelationship $l)
    {
        if ($this->collAcquisitionRelationshipsRelatedBySubjectId === null) {
            $this->initAcquisitionRelationshipsRelatedBySubjectId();
            $this->collAcquisitionRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collAcquisitionRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisitionRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	AcquisitionRelationshipRelatedBySubjectId $acquisitionRelationshipRelatedBySubjectId The acquisitionRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddAcquisitionRelationshipRelatedBySubjectId($acquisitionRelationshipRelatedBySubjectId)
    {
        $this->collAcquisitionRelationshipsRelatedBySubjectId[]= $acquisitionRelationshipRelatedBySubjectId;
        $acquisitionRelationshipRelatedBySubjectId->setAcquisitionRelatedBySubjectId($this);
    }

    /**
     * @param	AcquisitionRelationshipRelatedBySubjectId $acquisitionRelationshipRelatedBySubjectId The acquisitionRelationshipRelatedBySubjectId object to remove.
     * @return Acquisition The current object (for fluent API support)
     */
    public function removeAcquisitionRelationshipRelatedBySubjectId($acquisitionRelationshipRelatedBySubjectId)
    {
        if ($this->getAcquisitionRelationshipsRelatedBySubjectId()->contains($acquisitionRelationshipRelatedBySubjectId)) {
            $this->collAcquisitionRelationshipsRelatedBySubjectId->remove($this->collAcquisitionRelationshipsRelatedBySubjectId->search($acquisitionRelationshipRelatedBySubjectId));
            if (null === $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collAcquisitionRelationshipsRelatedBySubjectId;
                $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->acquisitionRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $acquisitionRelationshipRelatedBySubjectId;
            $acquisitionRelationshipRelatedBySubjectId->setAcquisitionRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related AcquisitionRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AcquisitionRelationship[] List of AcquisitionRelationship objects
     */
    public function getAcquisitionRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getAcquisitionRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collAcquisitionprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Acquisition The current object (for fluent API support)
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
     * If this Acquisition is new, it will return
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
                    ->filterByAcquisition($this)
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
     * @return Acquisition The current object (for fluent API support)
     */
    public function setAcquisitionprops(PropelCollection $acquisitionprops, PropelPDO $con = null)
    {
        $acquisitionpropsToDelete = $this->getAcquisitionprops(new Criteria(), $con)->diff($acquisitionprops);

        $this->acquisitionpropsScheduledForDeletion = unserialize(serialize($acquisitionpropsToDelete));

        foreach ($acquisitionpropsToDelete as $acquisitionpropRemoved) {
            $acquisitionpropRemoved->setAcquisition(null);
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
                ->filterByAcquisition($this)
                ->count($con);
        }

        return count($this->collAcquisitionprops);
    }

    /**
     * Method called to associate a Acquisitionprop object to this object
     * through the Acquisitionprop foreign key attribute.
     *
     * @param    Acquisitionprop $l Acquisitionprop
     * @return Acquisition The current object (for fluent API support)
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
        $acquisitionprop->setAcquisition($this);
    }

    /**
     * @param	Acquisitionprop $acquisitionprop The acquisitionprop object to remove.
     * @return Acquisition The current object (for fluent API support)
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
            $acquisitionprop->setAcquisition(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related Acquisitionprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisitionprop[] List of Acquisitionprop objects
     */
    public function getAcquisitionpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getAcquisitionprops($query, $con);
    }

    /**
     * Clears out the collQuantifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Acquisition The current object (for fluent API support)
     * @see        addQuantifications()
     */
    public function clearQuantifications()
    {
        $this->collQuantifications = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationsPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantifications collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantifications($v = true)
    {
        $this->collQuantificationsPartial = $v;
    }

    /**
     * Initializes the collQuantifications collection.
     *
     * By default this just sets the collQuantifications collection to an empty array (like clearcollQuantifications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantifications($overrideExisting = true)
    {
        if (null !== $this->collQuantifications && !$overrideExisting) {
            return;
        }
        $this->collQuantifications = new PropelObjectCollection();
        $this->collQuantifications->setModel('Quantification');
    }

    /**
     * Gets an array of Quantification objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Acquisition is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     * @throws PropelException
     */
    public function getQuantifications($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationsPartial && !$this->isNew();
        if (null === $this->collQuantifications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantifications) {
                // return empty collection
                $this->initQuantifications();
            } else {
                $collQuantifications = QuantificationQuery::create(null, $criteria)
                    ->filterByAcquisition($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationsPartial && count($collQuantifications)) {
                      $this->initQuantifications(false);

                      foreach($collQuantifications as $obj) {
                        if (false == $this->collQuantifications->contains($obj)) {
                          $this->collQuantifications->append($obj);
                        }
                      }

                      $this->collQuantificationsPartial = true;
                    }

                    $collQuantifications->getInternalIterator()->rewind();
                    return $collQuantifications;
                }

                if($partial && $this->collQuantifications) {
                    foreach($this->collQuantifications as $obj) {
                        if($obj->isNew()) {
                            $collQuantifications[] = $obj;
                        }
                    }
                }

                $this->collQuantifications = $collQuantifications;
                $this->collQuantificationsPartial = false;
            }
        }

        return $this->collQuantifications;
    }

    /**
     * Sets a collection of Quantification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantifications A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Acquisition The current object (for fluent API support)
     */
    public function setQuantifications(PropelCollection $quantifications, PropelPDO $con = null)
    {
        $quantificationsToDelete = $this->getQuantifications(new Criteria(), $con)->diff($quantifications);

        $this->quantificationsScheduledForDeletion = unserialize(serialize($quantificationsToDelete));

        foreach ($quantificationsToDelete as $quantificationRemoved) {
            $quantificationRemoved->setAcquisition(null);
        }

        $this->collQuantifications = null;
        foreach ($quantifications as $quantification) {
            $this->addQuantification($quantification);
        }

        $this->collQuantifications = $quantifications;
        $this->collQuantificationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Quantification objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Quantification objects.
     * @throws PropelException
     */
    public function countQuantifications(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationsPartial && !$this->isNew();
        if (null === $this->collQuantifications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantifications) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantifications());
            }
            $query = QuantificationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAcquisition($this)
                ->count($con);
        }

        return count($this->collQuantifications);
    }

    /**
     * Method called to associate a Quantification object to this object
     * through the Quantification foreign key attribute.
     *
     * @param    Quantification $l Quantification
     * @return Acquisition The current object (for fluent API support)
     */
    public function addQuantification(Quantification $l)
    {
        if ($this->collQuantifications === null) {
            $this->initQuantifications();
            $this->collQuantificationsPartial = true;
        }
        if (!in_array($l, $this->collQuantifications->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantification($l);
        }

        return $this;
    }

    /**
     * @param	Quantification $quantification The quantification object to add.
     */
    protected function doAddQuantification($quantification)
    {
        $this->collQuantifications[]= $quantification;
        $quantification->setAcquisition($this);
    }

    /**
     * @param	Quantification $quantification The quantification object to remove.
     * @return Acquisition The current object (for fluent API support)
     */
    public function removeQuantification($quantification)
    {
        if ($this->getQuantifications()->contains($quantification)) {
            $this->collQuantifications->remove($this->collQuantifications->search($quantification));
            if (null === $this->quantificationsScheduledForDeletion) {
                $this->quantificationsScheduledForDeletion = clone $this->collQuantifications;
                $this->quantificationsScheduledForDeletion->clear();
            }
            $this->quantificationsScheduledForDeletion[]= clone $quantification;
            $quantification->setAcquisition(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinAnalysis($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Analysis', $join_behavior);

        return $this->getQuantifications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getQuantifications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Acquisition is new, it will return
     * an empty collection; or if this Acquisition has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Acquisition.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getQuantifications($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->acquisition_id = null;
        $this->assay_id = null;
        $this->protocol_id = null;
        $this->channel_id = null;
        $this->acquisitiondate = null;
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
            if ($this->collAcquisitionRelationshipsRelatedByObjectId) {
                foreach ($this->collAcquisitionRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAcquisitionRelationshipsRelatedBySubjectId) {
                foreach ($this->collAcquisitionRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAcquisitionprops) {
                foreach ($this->collAcquisitionprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantifications) {
                foreach ($this->collQuantifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAssay instanceof Persistent) {
              $this->aAssay->clearAllReferences($deep);
            }
            if ($this->aChannel instanceof Persistent) {
              $this->aChannel->clearAllReferences($deep);
            }
            if ($this->aProtocol instanceof Persistent) {
              $this->aProtocol->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAcquisitionRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collAcquisitionRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collAcquisitionRelationshipsRelatedByObjectId = null;
        if ($this->collAcquisitionRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collAcquisitionRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collAcquisitionRelationshipsRelatedBySubjectId = null;
        if ($this->collAcquisitionprops instanceof PropelCollection) {
            $this->collAcquisitionprops->clearIterator();
        }
        $this->collAcquisitionprops = null;
        if ($this->collQuantifications instanceof PropelCollection) {
            $this->collQuantifications->clearIterator();
        }
        $this->collQuantifications = null;
        $this->aAssay = null;
        $this->aChannel = null;
        $this->aProtocol = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AcquisitionPeer::DEFAULT_STRING_FORMAT);
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
