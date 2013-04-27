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
use cli_db\propel\Feature;
use cli_db\propel\FeatureQuery;
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocPeer;
use cli_db\propel\FeaturelocPub;
use cli_db\propel\FeaturelocPubQuery;
use cli_db\propel\FeaturelocQuery;

/**
 * Base class that represents a row from the 'featureloc' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureloc extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeaturelocPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeaturelocPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the featureloc_id field.
     * @var        int
     */
    protected $featureloc_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the srcfeature_id field.
     * @var        int
     */
    protected $srcfeature_id;

    /**
     * The value for the fmin field.
     * @var        int
     */
    protected $fmin;

    /**
     * The value for the is_fmin_partial field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_fmin_partial;

    /**
     * The value for the fmax field.
     * @var        int
     */
    protected $fmax;

    /**
     * The value for the is_fmax_partial field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_fmax_partial;

    /**
     * The value for the strand field.
     * @var        int
     */
    protected $strand;

    /**
     * The value for the phase field.
     * @var        int
     */
    protected $phase;

    /**
     * The value for the residue_info field.
     * @var        string
     */
    protected $residue_info;

    /**
     * The value for the locgroup field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $locgroup;

    /**
     * The value for the rank field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $rank;

    /**
     * @var        Feature
     */
    protected $aFeatureRelatedByFeatureId;

    /**
     * @var        Feature
     */
    protected $aFeatureRelatedBySrcfeatureId;

    /**
     * @var        PropelObjectCollection|FeaturelocPub[] Collection to store aggregation of FeaturelocPub objects.
     */
    protected $collFeaturelocPubs;
    protected $collFeaturelocPubsPartial;

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
    protected $featurelocPubsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_fmin_partial = false;
        $this->is_fmax_partial = false;
        $this->locgroup = 0;
        $this->rank = 0;
    }

    /**
     * Initializes internal state of BaseFeatureloc object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [featureloc_id] column value.
     *
     * @return int
     */
    public function getFeaturelocId()
    {
        return $this->featureloc_id;
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
     * Get the [srcfeature_id] column value.
     *
     * @return int
     */
    public function getSrcfeatureId()
    {
        return $this->srcfeature_id;
    }

    /**
     * Get the [fmin] column value.
     *
     * @return int
     */
    public function getFmin()
    {
        return $this->fmin;
    }

    /**
     * Get the [is_fmin_partial] column value.
     *
     * @return boolean
     */
    public function getIsFminPartial()
    {
        return $this->is_fmin_partial;
    }

    /**
     * Get the [fmax] column value.
     *
     * @return int
     */
    public function getFmax()
    {
        return $this->fmax;
    }

    /**
     * Get the [is_fmax_partial] column value.
     *
     * @return boolean
     */
    public function getIsFmaxPartial()
    {
        return $this->is_fmax_partial;
    }

    /**
     * Get the [strand] column value.
     *
     * @return int
     */
    public function getStrand()
    {
        return $this->strand;
    }

    /**
     * Get the [phase] column value.
     *
     * @return int
     */
    public function getPhase()
    {
        return $this->phase;
    }

    /**
     * Get the [residue_info] column value.
     *
     * @return string
     */
    public function getResidueInfo()
    {
        return $this->residue_info;
    }

    /**
     * Get the [locgroup] column value.
     *
     * @return int
     */
    public function getLocgroup()
    {
        return $this->locgroup;
    }

    /**
     * Get the [rank] column value.
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set the value of [featureloc_id] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setFeaturelocId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->featureloc_id !== $v) {
            $this->featureloc_id = $v;
            $this->modifiedColumns[] = FeaturelocPeer::FEATURELOC_ID;
        }


        return $this;
    } // setFeaturelocId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = FeaturelocPeer::FEATURE_ID;
        }

        if ($this->aFeatureRelatedByFeatureId !== null && $this->aFeatureRelatedByFeatureId->getFeatureId() !== $v) {
            $this->aFeatureRelatedByFeatureId = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [srcfeature_id] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setSrcfeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->srcfeature_id !== $v) {
            $this->srcfeature_id = $v;
            $this->modifiedColumns[] = FeaturelocPeer::SRCFEATURE_ID;
        }

        if ($this->aFeatureRelatedBySrcfeatureId !== null && $this->aFeatureRelatedBySrcfeatureId->getFeatureId() !== $v) {
            $this->aFeatureRelatedBySrcfeatureId = null;
        }


        return $this;
    } // setSrcfeatureId()

    /**
     * Set the value of [fmin] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setFmin($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->fmin !== $v) {
            $this->fmin = $v;
            $this->modifiedColumns[] = FeaturelocPeer::FMIN;
        }


        return $this;
    } // setFmin()

    /**
     * Sets the value of the [is_fmin_partial] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setIsFminPartial($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_fmin_partial !== $v) {
            $this->is_fmin_partial = $v;
            $this->modifiedColumns[] = FeaturelocPeer::IS_FMIN_PARTIAL;
        }


        return $this;
    } // setIsFminPartial()

    /**
     * Set the value of [fmax] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setFmax($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->fmax !== $v) {
            $this->fmax = $v;
            $this->modifiedColumns[] = FeaturelocPeer::FMAX;
        }


        return $this;
    } // setFmax()

    /**
     * Sets the value of the [is_fmax_partial] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setIsFmaxPartial($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_fmax_partial !== $v) {
            $this->is_fmax_partial = $v;
            $this->modifiedColumns[] = FeaturelocPeer::IS_FMAX_PARTIAL;
        }


        return $this;
    } // setIsFmaxPartial()

    /**
     * Set the value of [strand] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setStrand($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->strand !== $v) {
            $this->strand = $v;
            $this->modifiedColumns[] = FeaturelocPeer::STRAND;
        }


        return $this;
    } // setStrand()

    /**
     * Set the value of [phase] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setPhase($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->phase !== $v) {
            $this->phase = $v;
            $this->modifiedColumns[] = FeaturelocPeer::PHASE;
        }


        return $this;
    } // setPhase()

    /**
     * Set the value of [residue_info] column.
     *
     * @param string $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setResidueInfo($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->residue_info !== $v) {
            $this->residue_info = $v;
            $this->modifiedColumns[] = FeaturelocPeer::RESIDUE_INFO;
        }


        return $this;
    } // setResidueInfo()

    /**
     * Set the value of [locgroup] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setLocgroup($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->locgroup !== $v) {
            $this->locgroup = $v;
            $this->modifiedColumns[] = FeaturelocPeer::LOCGROUP;
        }


        return $this;
    } // setLocgroup()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return Featureloc The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = FeaturelocPeer::RANK;
        }


        return $this;
    } // setRank()

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
            if ($this->is_fmin_partial !== false) {
                return false;
            }

            if ($this->is_fmax_partial !== false) {
                return false;
            }

            if ($this->locgroup !== 0) {
                return false;
            }

            if ($this->rank !== 0) {
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

            $this->featureloc_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->feature_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->srcfeature_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->fmin = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->is_fmin_partial = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->fmax = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->is_fmax_partial = ($row[$startcol + 6] !== null) ? (boolean) $row[$startcol + 6] : null;
            $this->strand = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->phase = ($row[$startcol + 8] !== null) ? (int) $row[$startcol + 8] : null;
            $this->residue_info = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->locgroup = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->rank = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 12; // 12 = FeaturelocPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Featureloc object", $e);
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

        if ($this->aFeatureRelatedByFeatureId !== null && $this->feature_id !== $this->aFeatureRelatedByFeatureId->getFeatureId()) {
            $this->aFeatureRelatedByFeatureId = null;
        }
        if ($this->aFeatureRelatedBySrcfeatureId !== null && $this->srcfeature_id !== $this->aFeatureRelatedBySrcfeatureId->getFeatureId()) {
            $this->aFeatureRelatedBySrcfeatureId = null;
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
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeaturelocPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFeatureRelatedByFeatureId = null;
            $this->aFeatureRelatedBySrcfeatureId = null;
            $this->collFeaturelocPubs = null;

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
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeaturelocQuery::create()
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
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeaturelocPeer::addInstanceToPool($this);
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

            if ($this->aFeatureRelatedByFeatureId !== null) {
                if ($this->aFeatureRelatedByFeatureId->isModified() || $this->aFeatureRelatedByFeatureId->isNew()) {
                    $affectedRows += $this->aFeatureRelatedByFeatureId->save($con);
                }
                $this->setFeatureRelatedByFeatureId($this->aFeatureRelatedByFeatureId);
            }

            if ($this->aFeatureRelatedBySrcfeatureId !== null) {
                if ($this->aFeatureRelatedBySrcfeatureId->isModified() || $this->aFeatureRelatedBySrcfeatureId->isNew()) {
                    $affectedRows += $this->aFeatureRelatedBySrcfeatureId->save($con);
                }
                $this->setFeatureRelatedBySrcfeatureId($this->aFeatureRelatedBySrcfeatureId);
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

            if ($this->featurelocPubsScheduledForDeletion !== null) {
                if (!$this->featurelocPubsScheduledForDeletion->isEmpty()) {
                    FeaturelocPubQuery::create()
                        ->filterByPrimaryKeys($this->featurelocPubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurelocPubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturelocPubs !== null) {
                foreach ($this->collFeaturelocPubs as $referrerFK) {
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

        $this->modifiedColumns[] = FeaturelocPeer::FEATURELOC_ID;
        if (null !== $this->featureloc_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeaturelocPeer::FEATURELOC_ID . ')');
        }
        if (null === $this->featureloc_id) {
            try {
                $stmt = $con->query("SELECT nextval('featureloc_featureloc_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->featureloc_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeaturelocPeer::FEATURELOC_ID)) {
            $modifiedColumns[':p' . $index++]  = '"featureloc_id"';
        }
        if ($this->isColumnModified(FeaturelocPeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(FeaturelocPeer::SRCFEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"srcfeature_id"';
        }
        if ($this->isColumnModified(FeaturelocPeer::FMIN)) {
            $modifiedColumns[':p' . $index++]  = '"fmin"';
        }
        if ($this->isColumnModified(FeaturelocPeer::IS_FMIN_PARTIAL)) {
            $modifiedColumns[':p' . $index++]  = '"is_fmin_partial"';
        }
        if ($this->isColumnModified(FeaturelocPeer::FMAX)) {
            $modifiedColumns[':p' . $index++]  = '"fmax"';
        }
        if ($this->isColumnModified(FeaturelocPeer::IS_FMAX_PARTIAL)) {
            $modifiedColumns[':p' . $index++]  = '"is_fmax_partial"';
        }
        if ($this->isColumnModified(FeaturelocPeer::STRAND)) {
            $modifiedColumns[':p' . $index++]  = '"strand"';
        }
        if ($this->isColumnModified(FeaturelocPeer::PHASE)) {
            $modifiedColumns[':p' . $index++]  = '"phase"';
        }
        if ($this->isColumnModified(FeaturelocPeer::RESIDUE_INFO)) {
            $modifiedColumns[':p' . $index++]  = '"residue_info"';
        }
        if ($this->isColumnModified(FeaturelocPeer::LOCGROUP)) {
            $modifiedColumns[':p' . $index++]  = '"locgroup"';
        }
        if ($this->isColumnModified(FeaturelocPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "featureloc" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"featureloc_id"':
                        $stmt->bindValue($identifier, $this->featureloc_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"srcfeature_id"':
                        $stmt->bindValue($identifier, $this->srcfeature_id, PDO::PARAM_INT);
                        break;
                    case '"fmin"':
                        $stmt->bindValue($identifier, $this->fmin, PDO::PARAM_INT);
                        break;
                    case '"is_fmin_partial"':
                        $stmt->bindValue($identifier, $this->is_fmin_partial, PDO::PARAM_BOOL);
                        break;
                    case '"fmax"':
                        $stmt->bindValue($identifier, $this->fmax, PDO::PARAM_INT);
                        break;
                    case '"is_fmax_partial"':
                        $stmt->bindValue($identifier, $this->is_fmax_partial, PDO::PARAM_BOOL);
                        break;
                    case '"strand"':
                        $stmt->bindValue($identifier, $this->strand, PDO::PARAM_INT);
                        break;
                    case '"phase"':
                        $stmt->bindValue($identifier, $this->phase, PDO::PARAM_INT);
                        break;
                    case '"residue_info"':
                        $stmt->bindValue($identifier, $this->residue_info, PDO::PARAM_STR);
                        break;
                    case '"locgroup"':
                        $stmt->bindValue($identifier, $this->locgroup, PDO::PARAM_INT);
                        break;
                    case '"rank"':
                        $stmt->bindValue($identifier, $this->rank, PDO::PARAM_INT);
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

            if ($this->aFeatureRelatedByFeatureId !== null) {
                if (!$this->aFeatureRelatedByFeatureId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeatureRelatedByFeatureId->getValidationFailures());
                }
            }

            if ($this->aFeatureRelatedBySrcfeatureId !== null) {
                if (!$this->aFeatureRelatedBySrcfeatureId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeatureRelatedBySrcfeatureId->getValidationFailures());
                }
            }


            if (($retval = FeaturelocPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collFeaturelocPubs !== null) {
                    foreach ($this->collFeaturelocPubs as $referrerFK) {
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
        $pos = FeaturelocPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeaturelocId();
                break;
            case 1:
                return $this->getFeatureId();
                break;
            case 2:
                return $this->getSrcfeatureId();
                break;
            case 3:
                return $this->getFmin();
                break;
            case 4:
                return $this->getIsFminPartial();
                break;
            case 5:
                return $this->getFmax();
                break;
            case 6:
                return $this->getIsFmaxPartial();
                break;
            case 7:
                return $this->getStrand();
                break;
            case 8:
                return $this->getPhase();
                break;
            case 9:
                return $this->getResidueInfo();
                break;
            case 10:
                return $this->getLocgroup();
                break;
            case 11:
                return $this->getRank();
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
        if (isset($alreadyDumpedObjects['Featureloc'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Featureloc'][$this->getPrimaryKey()] = true;
        $keys = FeaturelocPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeaturelocId(),
            $keys[1] => $this->getFeatureId(),
            $keys[2] => $this->getSrcfeatureId(),
            $keys[3] => $this->getFmin(),
            $keys[4] => $this->getIsFminPartial(),
            $keys[5] => $this->getFmax(),
            $keys[6] => $this->getIsFmaxPartial(),
            $keys[7] => $this->getStrand(),
            $keys[8] => $this->getPhase(),
            $keys[9] => $this->getResidueInfo(),
            $keys[10] => $this->getLocgroup(),
            $keys[11] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aFeatureRelatedByFeatureId) {
                $result['FeatureRelatedByFeatureId'] = $this->aFeatureRelatedByFeatureId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFeatureRelatedBySrcfeatureId) {
                $result['FeatureRelatedBySrcfeatureId'] = $this->aFeatureRelatedBySrcfeatureId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFeaturelocPubs) {
                $result['FeaturelocPubs'] = $this->collFeaturelocPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FeaturelocPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeaturelocId($value);
                break;
            case 1:
                $this->setFeatureId($value);
                break;
            case 2:
                $this->setSrcfeatureId($value);
                break;
            case 3:
                $this->setFmin($value);
                break;
            case 4:
                $this->setIsFminPartial($value);
                break;
            case 5:
                $this->setFmax($value);
                break;
            case 6:
                $this->setIsFmaxPartial($value);
                break;
            case 7:
                $this->setStrand($value);
                break;
            case 8:
                $this->setPhase($value);
                break;
            case 9:
                $this->setResidueInfo($value);
                break;
            case 10:
                $this->setLocgroup($value);
                break;
            case 11:
                $this->setRank($value);
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
        $keys = FeaturelocPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeaturelocId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeatureId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setSrcfeatureId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setFmin($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsFminPartial($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFmax($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsFmaxPartial($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setStrand($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPhase($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setResidueInfo($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setLocgroup($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setRank($arr[$keys[11]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeaturelocPeer::DATABASE_NAME);

        if ($this->isColumnModified(FeaturelocPeer::FEATURELOC_ID)) $criteria->add(FeaturelocPeer::FEATURELOC_ID, $this->featureloc_id);
        if ($this->isColumnModified(FeaturelocPeer::FEATURE_ID)) $criteria->add(FeaturelocPeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(FeaturelocPeer::SRCFEATURE_ID)) $criteria->add(FeaturelocPeer::SRCFEATURE_ID, $this->srcfeature_id);
        if ($this->isColumnModified(FeaturelocPeer::FMIN)) $criteria->add(FeaturelocPeer::FMIN, $this->fmin);
        if ($this->isColumnModified(FeaturelocPeer::IS_FMIN_PARTIAL)) $criteria->add(FeaturelocPeer::IS_FMIN_PARTIAL, $this->is_fmin_partial);
        if ($this->isColumnModified(FeaturelocPeer::FMAX)) $criteria->add(FeaturelocPeer::FMAX, $this->fmax);
        if ($this->isColumnModified(FeaturelocPeer::IS_FMAX_PARTIAL)) $criteria->add(FeaturelocPeer::IS_FMAX_PARTIAL, $this->is_fmax_partial);
        if ($this->isColumnModified(FeaturelocPeer::STRAND)) $criteria->add(FeaturelocPeer::STRAND, $this->strand);
        if ($this->isColumnModified(FeaturelocPeer::PHASE)) $criteria->add(FeaturelocPeer::PHASE, $this->phase);
        if ($this->isColumnModified(FeaturelocPeer::RESIDUE_INFO)) $criteria->add(FeaturelocPeer::RESIDUE_INFO, $this->residue_info);
        if ($this->isColumnModified(FeaturelocPeer::LOCGROUP)) $criteria->add(FeaturelocPeer::LOCGROUP, $this->locgroup);
        if ($this->isColumnModified(FeaturelocPeer::RANK)) $criteria->add(FeaturelocPeer::RANK, $this->rank);

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
        $criteria = new Criteria(FeaturelocPeer::DATABASE_NAME);
        $criteria->add(FeaturelocPeer::FEATURELOC_ID, $this->featureloc_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeaturelocId();
    }

    /**
     * Generic method to set the primary key (featureloc_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeaturelocId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeaturelocId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Featureloc (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setSrcfeatureId($this->getSrcfeatureId());
        $copyObj->setFmin($this->getFmin());
        $copyObj->setIsFminPartial($this->getIsFminPartial());
        $copyObj->setFmax($this->getFmax());
        $copyObj->setIsFmaxPartial($this->getIsFmaxPartial());
        $copyObj->setStrand($this->getStrand());
        $copyObj->setPhase($this->getPhase());
        $copyObj->setResidueInfo($this->getResidueInfo());
        $copyObj->setLocgroup($this->getLocgroup());
        $copyObj->setRank($this->getRank());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getFeaturelocPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturelocPub($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setFeaturelocId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Featureloc Clone of current object.
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
     * @return FeaturelocPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeaturelocPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return Featureloc The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFeatureRelatedByFeatureId(Feature $v = null)
    {
        if ($v === null) {
            $this->setFeatureId(NULL);
        } else {
            $this->setFeatureId($v->getFeatureId());
        }

        $this->aFeatureRelatedByFeatureId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Feature object, it will not be re-added.
        if ($v !== null) {
            $v->addFeaturelocRelatedByFeatureId($this);
        }


        return $this;
    }


    /**
     * Get the associated Feature object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Feature The associated Feature object.
     * @throws PropelException
     */
    public function getFeatureRelatedByFeatureId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFeatureRelatedByFeatureId === null && ($this->feature_id !== null) && $doQuery) {
            $this->aFeatureRelatedByFeatureId = FeatureQuery::create()->findPk($this->feature_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFeatureRelatedByFeatureId->addFeaturelocsRelatedByFeatureId($this);
             */
        }

        return $this->aFeatureRelatedByFeatureId;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return Featureloc The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFeatureRelatedBySrcfeatureId(Feature $v = null)
    {
        if ($v === null) {
            $this->setSrcfeatureId(NULL);
        } else {
            $this->setSrcfeatureId($v->getFeatureId());
        }

        $this->aFeatureRelatedBySrcfeatureId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Feature object, it will not be re-added.
        if ($v !== null) {
            $v->addFeaturelocRelatedBySrcfeatureId($this);
        }


        return $this;
    }


    /**
     * Get the associated Feature object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Feature The associated Feature object.
     * @throws PropelException
     */
    public function getFeatureRelatedBySrcfeatureId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFeatureRelatedBySrcfeatureId === null && ($this->srcfeature_id !== null) && $doQuery) {
            $this->aFeatureRelatedBySrcfeatureId = FeatureQuery::create()->findPk($this->srcfeature_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFeatureRelatedBySrcfeatureId->addFeaturelocsRelatedBySrcfeatureId($this);
             */
        }

        return $this->aFeatureRelatedBySrcfeatureId;
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
        if ('FeaturelocPub' == $relationName) {
            $this->initFeaturelocPubs();
        }
    }

    /**
     * Clears out the collFeaturelocPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Featureloc The current object (for fluent API support)
     * @see        addFeaturelocPubs()
     */
    public function clearFeaturelocPubs()
    {
        $this->collFeaturelocPubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturelocPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturelocPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturelocPubs($v = true)
    {
        $this->collFeaturelocPubsPartial = $v;
    }

    /**
     * Initializes the collFeaturelocPubs collection.
     *
     * By default this just sets the collFeaturelocPubs collection to an empty array (like clearcollFeaturelocPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturelocPubs($overrideExisting = true)
    {
        if (null !== $this->collFeaturelocPubs && !$overrideExisting) {
            return;
        }
        $this->collFeaturelocPubs = new PropelObjectCollection();
        $this->collFeaturelocPubs->setModel('FeaturelocPub');
    }

    /**
     * Gets an array of FeaturelocPub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Featureloc is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeaturelocPub[] List of FeaturelocPub objects
     * @throws PropelException
     */
    public function getFeaturelocPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocPubsPartial && !$this->isNew();
        if (null === $this->collFeaturelocPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocPubs) {
                // return empty collection
                $this->initFeaturelocPubs();
            } else {
                $collFeaturelocPubs = FeaturelocPubQuery::create(null, $criteria)
                    ->filterByFeatureloc($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturelocPubsPartial && count($collFeaturelocPubs)) {
                      $this->initFeaturelocPubs(false);

                      foreach($collFeaturelocPubs as $obj) {
                        if (false == $this->collFeaturelocPubs->contains($obj)) {
                          $this->collFeaturelocPubs->append($obj);
                        }
                      }

                      $this->collFeaturelocPubsPartial = true;
                    }

                    $collFeaturelocPubs->getInternalIterator()->rewind();
                    return $collFeaturelocPubs;
                }

                if($partial && $this->collFeaturelocPubs) {
                    foreach($this->collFeaturelocPubs as $obj) {
                        if($obj->isNew()) {
                            $collFeaturelocPubs[] = $obj;
                        }
                    }
                }

                $this->collFeaturelocPubs = $collFeaturelocPubs;
                $this->collFeaturelocPubsPartial = false;
            }
        }

        return $this->collFeaturelocPubs;
    }

    /**
     * Sets a collection of FeaturelocPub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurelocPubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Featureloc The current object (for fluent API support)
     */
    public function setFeaturelocPubs(PropelCollection $featurelocPubs, PropelPDO $con = null)
    {
        $featurelocPubsToDelete = $this->getFeaturelocPubs(new Criteria(), $con)->diff($featurelocPubs);

        $this->featurelocPubsScheduledForDeletion = unserialize(serialize($featurelocPubsToDelete));

        foreach ($featurelocPubsToDelete as $featurelocPubRemoved) {
            $featurelocPubRemoved->setFeatureloc(null);
        }

        $this->collFeaturelocPubs = null;
        foreach ($featurelocPubs as $featurelocPub) {
            $this->addFeaturelocPub($featurelocPub);
        }

        $this->collFeaturelocPubs = $featurelocPubs;
        $this->collFeaturelocPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeaturelocPub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeaturelocPub objects.
     * @throws PropelException
     */
    public function countFeaturelocPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturelocPubsPartial && !$this->isNew();
        if (null === $this->collFeaturelocPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturelocPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturelocPubs());
            }
            $query = FeaturelocPubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureloc($this)
                ->count($con);
        }

        return count($this->collFeaturelocPubs);
    }

    /**
     * Method called to associate a FeaturelocPub object to this object
     * through the FeaturelocPub foreign key attribute.
     *
     * @param    FeaturelocPub $l FeaturelocPub
     * @return Featureloc The current object (for fluent API support)
     */
    public function addFeaturelocPub(FeaturelocPub $l)
    {
        if ($this->collFeaturelocPubs === null) {
            $this->initFeaturelocPubs();
            $this->collFeaturelocPubsPartial = true;
        }
        if (!in_array($l, $this->collFeaturelocPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturelocPub($l);
        }

        return $this;
    }

    /**
     * @param	FeaturelocPub $featurelocPub The featurelocPub object to add.
     */
    protected function doAddFeaturelocPub($featurelocPub)
    {
        $this->collFeaturelocPubs[]= $featurelocPub;
        $featurelocPub->setFeatureloc($this);
    }

    /**
     * @param	FeaturelocPub $featurelocPub The featurelocPub object to remove.
     * @return Featureloc The current object (for fluent API support)
     */
    public function removeFeaturelocPub($featurelocPub)
    {
        if ($this->getFeaturelocPubs()->contains($featurelocPub)) {
            $this->collFeaturelocPubs->remove($this->collFeaturelocPubs->search($featurelocPub));
            if (null === $this->featurelocPubsScheduledForDeletion) {
                $this->featurelocPubsScheduledForDeletion = clone $this->collFeaturelocPubs;
                $this->featurelocPubsScheduledForDeletion->clear();
            }
            $this->featurelocPubsScheduledForDeletion[]= clone $featurelocPub;
            $featurelocPub->setFeatureloc(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Featureloc is new, it will return
     * an empty collection; or if this Featureloc has previously
     * been saved, it will retrieve related FeaturelocPubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Featureloc.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeaturelocPub[] List of FeaturelocPub objects
     */
    public function getFeaturelocPubsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturelocPubQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeaturelocPubs($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->featureloc_id = null;
        $this->feature_id = null;
        $this->srcfeature_id = null;
        $this->fmin = null;
        $this->is_fmin_partial = null;
        $this->fmax = null;
        $this->is_fmax_partial = null;
        $this->strand = null;
        $this->phase = null;
        $this->residue_info = null;
        $this->locgroup = null;
        $this->rank = null;
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
            if ($this->collFeaturelocPubs) {
                foreach ($this->collFeaturelocPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aFeatureRelatedByFeatureId instanceof Persistent) {
              $this->aFeatureRelatedByFeatureId->clearAllReferences($deep);
            }
            if ($this->aFeatureRelatedBySrcfeatureId instanceof Persistent) {
              $this->aFeatureRelatedBySrcfeatureId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collFeaturelocPubs instanceof PropelCollection) {
            $this->collFeaturelocPubs->clearIterator();
        }
        $this->collFeaturelocPubs = null;
        $this->aFeatureRelatedByFeatureId = null;
        $this->aFeatureRelatedBySrcfeatureId = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeaturelocPeer::DEFAULT_STRING_FORMAT);
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
