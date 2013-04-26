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
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureCvtermDbxrefQuery;
use cli_db\propel\FeatureCvtermPeer;
use cli_db\propel\FeatureCvtermPub;
use cli_db\propel\FeatureCvtermPubQuery;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\FeatureCvtermpropQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;

/**
 * Base class that represents a row from the 'feature_cvterm' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureCvterm extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeatureCvtermPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeatureCvtermPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the feature_cvterm_id field.
     * @var        int
     */
    protected $feature_cvterm_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the cvterm_id field.
     * @var        int
     */
    protected $cvterm_id;

    /**
     * The value for the pub_id field.
     * @var        int
     */
    protected $pub_id;

    /**
     * The value for the is_not field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_not;

    /**
     * The value for the rank field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $rank;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        Feature
     */
    protected $aFeature;

    /**
     * @var        Pub
     */
    protected $aPub;

    /**
     * @var        PropelObjectCollection|FeatureCvtermDbxref[] Collection to store aggregation of FeatureCvtermDbxref objects.
     */
    protected $collFeatureCvtermDbxrefs;
    protected $collFeatureCvtermDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermPub[] Collection to store aggregation of FeatureCvtermPub objects.
     */
    protected $collFeatureCvtermPubs;
    protected $collFeatureCvtermPubsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermprop[] Collection to store aggregation of FeatureCvtermprop objects.
     */
    protected $collFeatureCvtermprops;
    protected $collFeatureCvtermpropsPartial;

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
    protected $featureCvtermDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermPubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermpropsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_not = false;
        $this->rank = 0;
    }

    /**
     * Initializes internal state of BaseFeatureCvterm object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [feature_cvterm_id] column value.
     *
     * @return int
     */
    public function getFeatureCvtermId()
    {
        return $this->feature_cvterm_id;
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
     * Get the [cvterm_id] column value.
     *
     * @return int
     */
    public function getCvtermId()
    {
        return $this->cvterm_id;
    }

    /**
     * Get the [pub_id] column value.
     *
     * @return int
     */
    public function getPubId()
    {
        return $this->pub_id;
    }

    /**
     * Get the [is_not] column value.
     *
     * @return boolean
     */
    public function getIsNot()
    {
        return $this->is_not;
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
     * Set the value of [feature_cvterm_id] column.
     *
     * @param int $v new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_cvterm_id !== $v) {
            $this->feature_cvterm_id = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::FEATURE_CVTERM_ID;
        }


        return $this;
    } // setFeatureCvtermId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::FEATURE_ID;
        }

        if ($this->aFeature !== null && $this->aFeature->getFeatureId() !== $v) {
            $this->aFeature = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [cvterm_id] column.
     *
     * @param int $v new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setCvtermId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cvterm_id !== $v) {
            $this->cvterm_id = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::CVTERM_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setCvtermId()

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::PUB_ID;
        }

        if ($this->aPub !== null && $this->aPub->getPubId() !== $v) {
            $this->aPub = null;
        }


        return $this;
    } // setPubId()

    /**
     * Sets the value of the [is_not] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setIsNot($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_not !== $v) {
            $this->is_not = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::IS_NOT;
        }


        return $this;
    } // setIsNot()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = FeatureCvtermPeer::RANK;
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
            if ($this->is_not !== false) {
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

            $this->feature_cvterm_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->feature_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->cvterm_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->pub_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->is_not = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->rank = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = FeatureCvtermPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating FeatureCvterm object", $e);
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

        if ($this->aFeature !== null && $this->feature_id !== $this->aFeature->getFeatureId()) {
            $this->aFeature = null;
        }
        if ($this->aCvterm !== null && $this->cvterm_id !== $this->aCvterm->getCvtermId()) {
            $this->aCvterm = null;
        }
        if ($this->aPub !== null && $this->pub_id !== $this->aPub->getPubId()) {
            $this->aPub = null;
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
            $con = Propel::getConnection(FeatureCvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeatureCvtermPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCvterm = null;
            $this->aFeature = null;
            $this->aPub = null;
            $this->collFeatureCvtermDbxrefs = null;

            $this->collFeatureCvtermPubs = null;

            $this->collFeatureCvtermprops = null;

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
            $con = Propel::getConnection(FeatureCvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeatureCvtermQuery::create()
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
            $con = Propel::getConnection(FeatureCvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeatureCvtermPeer::addInstanceToPool($this);
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

            if ($this->aCvterm !== null) {
                if ($this->aCvterm->isModified() || $this->aCvterm->isNew()) {
                    $affectedRows += $this->aCvterm->save($con);
                }
                $this->setCvterm($this->aCvterm);
            }

            if ($this->aFeature !== null) {
                if ($this->aFeature->isModified() || $this->aFeature->isNew()) {
                    $affectedRows += $this->aFeature->save($con);
                }
                $this->setFeature($this->aFeature);
            }

            if ($this->aPub !== null) {
                if ($this->aPub->isModified() || $this->aPub->isNew()) {
                    $affectedRows += $this->aPub->save($con);
                }
                $this->setPub($this->aPub);
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

            if ($this->featureCvtermDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureCvtermDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermDbxrefs !== null) {
                foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureCvtermPubsScheduledForDeletion !== null) {
                if (!$this->featureCvtermPubsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermPubQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermPubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermPubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermPubs !== null) {
                foreach ($this->collFeatureCvtermPubs as $referrerFK) {
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

        $this->modifiedColumns[] = FeatureCvtermPeer::FEATURE_CVTERM_ID;
        if (null !== $this->feature_cvterm_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeatureCvtermPeer::FEATURE_CVTERM_ID . ')');
        }
        if (null === $this->feature_cvterm_id) {
            try {
                $stmt = $con->query("SELECT nextval('feature_cvterm_feature_cvterm_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->feature_cvterm_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeatureCvtermPeer::FEATURE_CVTERM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_cvterm_id"';
        }
        if ($this->isColumnModified(FeatureCvtermPeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(FeatureCvtermPeer::CVTERM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cvterm_id"';
        }
        if ($this->isColumnModified(FeatureCvtermPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }
        if ($this->isColumnModified(FeatureCvtermPeer::IS_NOT)) {
            $modifiedColumns[':p' . $index++]  = '"is_not"';
        }
        if ($this->isColumnModified(FeatureCvtermPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "feature_cvterm" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"feature_cvterm_id"':
                        $stmt->bindValue($identifier, $this->feature_cvterm_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"cvterm_id"':
                        $stmt->bindValue($identifier, $this->cvterm_id, PDO::PARAM_INT);
                        break;
                    case '"pub_id"':
                        $stmt->bindValue($identifier, $this->pub_id, PDO::PARAM_INT);
                        break;
                    case '"is_not"':
                        $stmt->bindValue($identifier, $this->is_not, PDO::PARAM_BOOL);
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

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }

            if ($this->aFeature !== null) {
                if (!$this->aFeature->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeature->getValidationFailures());
                }
            }

            if ($this->aPub !== null) {
                if (!$this->aPub->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPub->getValidationFailures());
                }
            }


            if (($retval = FeatureCvtermPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collFeatureCvtermDbxrefs !== null) {
                    foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvtermPubs !== null) {
                    foreach ($this->collFeatureCvtermPubs as $referrerFK) {
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
        $pos = FeatureCvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeatureCvtermId();
                break;
            case 1:
                return $this->getFeatureId();
                break;
            case 2:
                return $this->getCvtermId();
                break;
            case 3:
                return $this->getPubId();
                break;
            case 4:
                return $this->getIsNot();
                break;
            case 5:
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
        if (isset($alreadyDumpedObjects['FeatureCvterm'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FeatureCvterm'][$this->getPrimaryKey()] = true;
        $keys = FeatureCvtermPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeatureCvtermId(),
            $keys[1] => $this->getFeatureId(),
            $keys[2] => $this->getCvtermId(),
            $keys[3] => $this->getPubId(),
            $keys[4] => $this->getIsNot(),
            $keys[5] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFeature) {
                $result['Feature'] = $this->aFeature->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPub) {
                $result['Pub'] = $this->aPub->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFeatureCvtermDbxrefs) {
                $result['FeatureCvtermDbxrefs'] = $this->collFeatureCvtermDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermPubs) {
                $result['FeatureCvtermPubs'] = $this->collFeatureCvtermPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermprops) {
                $result['FeatureCvtermprops'] = $this->collFeatureCvtermprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FeatureCvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeatureCvtermId($value);
                break;
            case 1:
                $this->setFeatureId($value);
                break;
            case 2:
                $this->setCvtermId($value);
                break;
            case 3:
                $this->setPubId($value);
                break;
            case 4:
                $this->setIsNot($value);
                break;
            case 5:
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
        $keys = FeatureCvtermPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeatureCvtermId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeatureId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setCvtermId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPubId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsNot($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setRank($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeatureCvtermPeer::DATABASE_NAME);

        if ($this->isColumnModified(FeatureCvtermPeer::FEATURE_CVTERM_ID)) $criteria->add(FeatureCvtermPeer::FEATURE_CVTERM_ID, $this->feature_cvterm_id);
        if ($this->isColumnModified(FeatureCvtermPeer::FEATURE_ID)) $criteria->add(FeatureCvtermPeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(FeatureCvtermPeer::CVTERM_ID)) $criteria->add(FeatureCvtermPeer::CVTERM_ID, $this->cvterm_id);
        if ($this->isColumnModified(FeatureCvtermPeer::PUB_ID)) $criteria->add(FeatureCvtermPeer::PUB_ID, $this->pub_id);
        if ($this->isColumnModified(FeatureCvtermPeer::IS_NOT)) $criteria->add(FeatureCvtermPeer::IS_NOT, $this->is_not);
        if ($this->isColumnModified(FeatureCvtermPeer::RANK)) $criteria->add(FeatureCvtermPeer::RANK, $this->rank);

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
        $criteria = new Criteria(FeatureCvtermPeer::DATABASE_NAME);
        $criteria->add(FeatureCvtermPeer::FEATURE_CVTERM_ID, $this->feature_cvterm_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeatureCvtermId();
    }

    /**
     * Generic method to set the primary key (feature_cvterm_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeatureCvtermId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeatureCvtermId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of FeatureCvterm (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setCvtermId($this->getCvtermId());
        $copyObj->setPubId($this->getPubId());
        $copyObj->setIsNot($this->getIsNot());
        $copyObj->setRank($this->getRank());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getFeatureCvtermDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermPub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setFeatureCvtermId(NULL); // this is a auto-increment column, so set to default value
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
     * @return FeatureCvterm Clone of current object.
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
     * @return FeatureCvtermPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeatureCvtermPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return FeatureCvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvterm(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setCvtermId(NULL);
        } else {
            $this->setCvtermId($v->getCvtermId());
        }

        $this->aCvterm = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addFeatureCvterm($this);
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
        if ($this->aCvterm === null && ($this->cvterm_id !== null) && $doQuery) {
            $this->aCvterm = CvtermQuery::create()->findPk($this->cvterm_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvterm->addFeatureCvterms($this);
             */
        }

        return $this->aCvterm;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return FeatureCvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFeature(Feature $v = null)
    {
        if ($v === null) {
            $this->setFeatureId(NULL);
        } else {
            $this->setFeatureId($v->getFeatureId());
        }

        $this->aFeature = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Feature object, it will not be re-added.
        if ($v !== null) {
            $v->addFeatureCvterm($this);
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
    public function getFeature(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFeature === null && ($this->feature_id !== null) && $doQuery) {
            $this->aFeature = FeatureQuery::create()->findPk($this->feature_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFeature->addFeatureCvterms($this);
             */
        }

        return $this->aFeature;
    }

    /**
     * Declares an association between this object and a Pub object.
     *
     * @param             Pub $v
     * @return FeatureCvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setPub(Pub $v = null)
    {
        if ($v === null) {
            $this->setPubId(NULL);
        } else {
            $this->setPubId($v->getPubId());
        }

        $this->aPub = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Pub object, it will not be re-added.
        if ($v !== null) {
            $v->addFeatureCvterm($this);
        }


        return $this;
    }


    /**
     * Get the associated Pub object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Pub The associated Pub object.
     * @throws PropelException
     */
    public function getPub(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aPub === null && ($this->pub_id !== null) && $doQuery) {
            $this->aPub = PubQuery::create()->findPk($this->pub_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aPub->addFeatureCvterms($this);
             */
        }

        return $this->aPub;
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
        if ('FeatureCvtermDbxref' == $relationName) {
            $this->initFeatureCvtermDbxrefs();
        }
        if ('FeatureCvtermPub' == $relationName) {
            $this->initFeatureCvtermPubs();
        }
        if ('FeatureCvtermprop' == $relationName) {
            $this->initFeatureCvtermprops();
        }
    }

    /**
     * Clears out the collFeatureCvtermDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return FeatureCvterm The current object (for fluent API support)
     * @see        addFeatureCvtermDbxrefs()
     */
    public function clearFeatureCvtermDbxrefs()
    {
        $this->collFeatureCvtermDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermDbxrefs($v = true)
    {
        $this->collFeatureCvtermDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermDbxrefs collection.
     *
     * By default this just sets the collFeatureCvtermDbxrefs collection to an empty array (like clearcollFeatureCvtermDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermDbxrefs = new PropelObjectCollection();
        $this->collFeatureCvtermDbxrefs->setModel('FeatureCvtermDbxref');
    }

    /**
     * Gets an array of FeatureCvtermDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this FeatureCvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     * @throws PropelException
     */
    public function getFeatureCvtermDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                // return empty collection
                $this->initFeatureCvtermDbxrefs();
            } else {
                $collFeatureCvtermDbxrefs = FeatureCvtermDbxrefQuery::create(null, $criteria)
                    ->filterByFeatureCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermDbxrefsPartial && count($collFeatureCvtermDbxrefs)) {
                      $this->initFeatureCvtermDbxrefs(false);

                      foreach($collFeatureCvtermDbxrefs as $obj) {
                        if (false == $this->collFeatureCvtermDbxrefs->contains($obj)) {
                          $this->collFeatureCvtermDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureCvtermDbxrefsPartial = true;
                    }

                    $collFeatureCvtermDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureCvtermDbxrefs;
                }

                if($partial && $this->collFeatureCvtermDbxrefs) {
                    foreach($this->collFeatureCvtermDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermDbxrefs = $collFeatureCvtermDbxrefs;
                $this->collFeatureCvtermDbxrefsPartial = false;
            }
        }

        return $this->collFeatureCvtermDbxrefs;
    }

    /**
     * Sets a collection of FeatureCvtermDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermDbxrefs(PropelCollection $featureCvtermDbxrefs, PropelPDO $con = null)
    {
        $featureCvtermDbxrefsToDelete = $this->getFeatureCvtermDbxrefs(new Criteria(), $con)->diff($featureCvtermDbxrefs);

        $this->featureCvtermDbxrefsScheduledForDeletion = unserialize(serialize($featureCvtermDbxrefsToDelete));

        foreach ($featureCvtermDbxrefsToDelete as $featureCvtermDbxrefRemoved) {
            $featureCvtermDbxrefRemoved->setFeatureCvterm(null);
        }

        $this->collFeatureCvtermDbxrefs = null;
        foreach ($featureCvtermDbxrefs as $featureCvtermDbxref) {
            $this->addFeatureCvtermDbxref($featureCvtermDbxref);
        }

        $this->collFeatureCvtermDbxrefs = $featureCvtermDbxrefs;
        $this->collFeatureCvtermDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermDbxref objects.
     * @throws PropelException
     */
    public function countFeatureCvtermDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermDbxrefs());
            }
            $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermDbxrefs);
    }

    /**
     * Method called to associate a FeatureCvtermDbxref object to this object
     * through the FeatureCvtermDbxref foreign key attribute.
     *
     * @param    FeatureCvtermDbxref $l FeatureCvtermDbxref
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function addFeatureCvtermDbxref(FeatureCvtermDbxref $l)
    {
        if ($this->collFeatureCvtermDbxrefs === null) {
            $this->initFeatureCvtermDbxrefs();
            $this->collFeatureCvtermDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to add.
     */
    protected function doAddFeatureCvtermDbxref($featureCvtermDbxref)
    {
        $this->collFeatureCvtermDbxrefs[]= $featureCvtermDbxref;
        $featureCvtermDbxref->setFeatureCvterm($this);
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to remove.
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function removeFeatureCvtermDbxref($featureCvtermDbxref)
    {
        if ($this->getFeatureCvtermDbxrefs()->contains($featureCvtermDbxref)) {
            $this->collFeatureCvtermDbxrefs->remove($this->collFeatureCvtermDbxrefs->search($featureCvtermDbxref));
            if (null === $this->featureCvtermDbxrefsScheduledForDeletion) {
                $this->featureCvtermDbxrefsScheduledForDeletion = clone $this->collFeatureCvtermDbxrefs;
                $this->featureCvtermDbxrefsScheduledForDeletion->clear();
            }
            $this->featureCvtermDbxrefsScheduledForDeletion[]= clone $featureCvtermDbxref;
            $featureCvtermDbxref->setFeatureCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FeatureCvterm is new, it will return
     * an empty collection; or if this FeatureCvterm has previously
     * been saved, it will retrieve related FeatureCvtermDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FeatureCvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     */
    public function getFeatureCvtermDbxrefsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getFeatureCvtermDbxrefs($query, $con);
    }

    /**
     * Clears out the collFeatureCvtermPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return FeatureCvterm The current object (for fluent API support)
     * @see        addFeatureCvtermPubs()
     */
    public function clearFeatureCvtermPubs()
    {
        $this->collFeatureCvtermPubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermPubs($v = true)
    {
        $this->collFeatureCvtermPubsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermPubs collection.
     *
     * By default this just sets the collFeatureCvtermPubs collection to an empty array (like clearcollFeatureCvtermPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermPubs($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermPubs && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermPubs = new PropelObjectCollection();
        $this->collFeatureCvtermPubs->setModel('FeatureCvtermPub');
    }

    /**
     * Gets an array of FeatureCvtermPub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this FeatureCvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermPub[] List of FeatureCvtermPub objects
     * @throws PropelException
     */
    public function getFeatureCvtermPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermPubsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermPubs) {
                // return empty collection
                $this->initFeatureCvtermPubs();
            } else {
                $collFeatureCvtermPubs = FeatureCvtermPubQuery::create(null, $criteria)
                    ->filterByFeatureCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermPubsPartial && count($collFeatureCvtermPubs)) {
                      $this->initFeatureCvtermPubs(false);

                      foreach($collFeatureCvtermPubs as $obj) {
                        if (false == $this->collFeatureCvtermPubs->contains($obj)) {
                          $this->collFeatureCvtermPubs->append($obj);
                        }
                      }

                      $this->collFeatureCvtermPubsPartial = true;
                    }

                    $collFeatureCvtermPubs->getInternalIterator()->rewind();
                    return $collFeatureCvtermPubs;
                }

                if($partial && $this->collFeatureCvtermPubs) {
                    foreach($this->collFeatureCvtermPubs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermPubs[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermPubs = $collFeatureCvtermPubs;
                $this->collFeatureCvtermPubsPartial = false;
            }
        }

        return $this->collFeatureCvtermPubs;
    }

    /**
     * Sets a collection of FeatureCvtermPub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermPubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermPubs(PropelCollection $featureCvtermPubs, PropelPDO $con = null)
    {
        $featureCvtermPubsToDelete = $this->getFeatureCvtermPubs(new Criteria(), $con)->diff($featureCvtermPubs);

        $this->featureCvtermPubsScheduledForDeletion = unserialize(serialize($featureCvtermPubsToDelete));

        foreach ($featureCvtermPubsToDelete as $featureCvtermPubRemoved) {
            $featureCvtermPubRemoved->setFeatureCvterm(null);
        }

        $this->collFeatureCvtermPubs = null;
        foreach ($featureCvtermPubs as $featureCvtermPub) {
            $this->addFeatureCvtermPub($featureCvtermPub);
        }

        $this->collFeatureCvtermPubs = $featureCvtermPubs;
        $this->collFeatureCvtermPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermPub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermPub objects.
     * @throws PropelException
     */
    public function countFeatureCvtermPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermPubsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermPubs());
            }
            $query = FeatureCvtermPubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermPubs);
    }

    /**
     * Method called to associate a FeatureCvtermPub object to this object
     * through the FeatureCvtermPub foreign key attribute.
     *
     * @param    FeatureCvtermPub $l FeatureCvtermPub
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function addFeatureCvtermPub(FeatureCvtermPub $l)
    {
        if ($this->collFeatureCvtermPubs === null) {
            $this->initFeatureCvtermPubs();
            $this->collFeatureCvtermPubsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermPub($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermPub $featureCvtermPub The featureCvtermPub object to add.
     */
    protected function doAddFeatureCvtermPub($featureCvtermPub)
    {
        $this->collFeatureCvtermPubs[]= $featureCvtermPub;
        $featureCvtermPub->setFeatureCvterm($this);
    }

    /**
     * @param	FeatureCvtermPub $featureCvtermPub The featureCvtermPub object to remove.
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function removeFeatureCvtermPub($featureCvtermPub)
    {
        if ($this->getFeatureCvtermPubs()->contains($featureCvtermPub)) {
            $this->collFeatureCvtermPubs->remove($this->collFeatureCvtermPubs->search($featureCvtermPub));
            if (null === $this->featureCvtermPubsScheduledForDeletion) {
                $this->featureCvtermPubsScheduledForDeletion = clone $this->collFeatureCvtermPubs;
                $this->featureCvtermPubsScheduledForDeletion->clear();
            }
            $this->featureCvtermPubsScheduledForDeletion[]= clone $featureCvtermPub;
            $featureCvtermPub->setFeatureCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FeatureCvterm is new, it will return
     * an empty collection; or if this FeatureCvterm has previously
     * been saved, it will retrieve related FeatureCvtermPubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FeatureCvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermPub[] List of FeatureCvtermPub objects
     */
    public function getFeatureCvtermPubsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermPubQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeatureCvtermPubs($query, $con);
    }

    /**
     * Clears out the collFeatureCvtermprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return FeatureCvterm The current object (for fluent API support)
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
     * If this FeatureCvterm is new, it will return
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
                    ->filterByFeatureCvterm($this)
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
     * @return FeatureCvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermprops(PropelCollection $featureCvtermprops, PropelPDO $con = null)
    {
        $featureCvtermpropsToDelete = $this->getFeatureCvtermprops(new Criteria(), $con)->diff($featureCvtermprops);

        $this->featureCvtermpropsScheduledForDeletion = unserialize(serialize($featureCvtermpropsToDelete));

        foreach ($featureCvtermpropsToDelete as $featureCvtermpropRemoved) {
            $featureCvtermpropRemoved->setFeatureCvterm(null);
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
                ->filterByFeatureCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermprops);
    }

    /**
     * Method called to associate a FeatureCvtermprop object to this object
     * through the FeatureCvtermprop foreign key attribute.
     *
     * @param    FeatureCvtermprop $l FeatureCvtermprop
     * @return FeatureCvterm The current object (for fluent API support)
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
        $featureCvtermprop->setFeatureCvterm($this);
    }

    /**
     * @param	FeatureCvtermprop $featureCvtermprop The featureCvtermprop object to remove.
     * @return FeatureCvterm The current object (for fluent API support)
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
            $featureCvtermprop->setFeatureCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this FeatureCvterm is new, it will return
     * an empty collection; or if this FeatureCvterm has previously
     * been saved, it will retrieve related FeatureCvtermprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in FeatureCvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermprop[] List of FeatureCvtermprop objects
     */
    public function getFeatureCvtermpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureCvtermprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->feature_cvterm_id = null;
        $this->feature_id = null;
        $this->cvterm_id = null;
        $this->pub_id = null;
        $this->is_not = null;
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
            if ($this->collFeatureCvtermDbxrefs) {
                foreach ($this->collFeatureCvtermDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermPubs) {
                foreach ($this->collFeatureCvtermPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermprops) {
                foreach ($this->collFeatureCvtermprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }
            if ($this->aFeature instanceof Persistent) {
              $this->aFeature->clearAllReferences($deep);
            }
            if ($this->aPub instanceof Persistent) {
              $this->aPub->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collFeatureCvtermDbxrefs instanceof PropelCollection) {
            $this->collFeatureCvtermDbxrefs->clearIterator();
        }
        $this->collFeatureCvtermDbxrefs = null;
        if ($this->collFeatureCvtermPubs instanceof PropelCollection) {
            $this->collFeatureCvtermPubs->clearIterator();
        }
        $this->collFeatureCvtermPubs = null;
        if ($this->collFeatureCvtermprops instanceof PropelCollection) {
            $this->collFeatureCvtermprops->clearIterator();
        }
        $this->collFeatureCvtermprops = null;
        $this->aCvterm = null;
        $this->aFeature = null;
        $this->aPub = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeatureCvtermPeer::DEFAULT_STRING_FORMAT);
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
