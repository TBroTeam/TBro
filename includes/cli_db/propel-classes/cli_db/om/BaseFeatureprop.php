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
use cli_db\propel\FeatureQuery;
use cli_db\propel\Featureprop;
use cli_db\propel\FeaturepropPeer;
use cli_db\propel\FeaturepropPub;
use cli_db\propel\FeaturepropPubQuery;
use cli_db\propel\FeaturepropQuery;

/**
 * Base class that represents a row from the 'featureprop' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureprop extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeaturepropPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeaturepropPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the featureprop_id field.
     * @var        int
     */
    protected $featureprop_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the value field.
     * @var        string
     */
    protected $value;

    /**
     * The value for the rank field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $rank;

    /**
     * @var        Feature
     */
    protected $aFeature;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|FeaturepropPub[] Collection to store aggregation of FeaturepropPub objects.
     */
    protected $collFeaturepropPubs;
    protected $collFeaturepropPubsPartial;

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
    protected $featurepropPubsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->rank = 0;
    }

    /**
     * Initializes internal state of BaseFeatureprop object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [featureprop_id] column value.
     *
     * @return int
     */
    public function getFeaturepropId()
    {
        return $this->featureprop_id;
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
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
    }

    /**
     * Get the [value] column value.
     *
     * @return string
     */
    public function getValue()
    {
        return $this->value;
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
     * Set the value of [featureprop_id] column.
     *
     * @param int $v new value
     * @return Featureprop The current object (for fluent API support)
     */
    public function setFeaturepropId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->featureprop_id !== $v) {
            $this->featureprop_id = $v;
            $this->modifiedColumns[] = FeaturepropPeer::FEATUREPROP_ID;
        }


        return $this;
    } // setFeaturepropId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return Featureprop The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = FeaturepropPeer::FEATURE_ID;
        }

        if ($this->aFeature !== null && $this->aFeature->getFeatureId() !== $v) {
            $this->aFeature = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Featureprop The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = FeaturepropPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [value] column.
     *
     * @param string $v new value
     * @return Featureprop The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[] = FeaturepropPeer::VALUE;
        }


        return $this;
    } // setValue()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return Featureprop The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = FeaturepropPeer::RANK;
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

            $this->featureprop_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->feature_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->value = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->rank = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = FeaturepropPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Featureprop object", $e);
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
            $con = Propel::getConnection(FeaturepropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeaturepropPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFeature = null;
            $this->aCvterm = null;
            $this->collFeaturepropPubs = null;

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
            $con = Propel::getConnection(FeaturepropPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeaturepropQuery::create()
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
            $con = Propel::getConnection(FeaturepropPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeaturepropPeer::addInstanceToPool($this);
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

            if ($this->aFeature !== null) {
                if ($this->aFeature->isModified() || $this->aFeature->isNew()) {
                    $affectedRows += $this->aFeature->save($con);
                }
                $this->setFeature($this->aFeature);
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

            if ($this->featurepropPubsScheduledForDeletion !== null) {
                if (!$this->featurepropPubsScheduledForDeletion->isEmpty()) {
                    FeaturepropPubQuery::create()
                        ->filterByPrimaryKeys($this->featurepropPubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurepropPubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturepropPubs !== null) {
                foreach ($this->collFeaturepropPubs as $referrerFK) {
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

        $this->modifiedColumns[] = FeaturepropPeer::FEATUREPROP_ID;
        if (null !== $this->featureprop_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeaturepropPeer::FEATUREPROP_ID . ')');
        }
        if (null === $this->featureprop_id) {
            try {
                $stmt = $con->query("SELECT nextval('featureprop_featureprop_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->featureprop_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeaturepropPeer::FEATUREPROP_ID)) {
            $modifiedColumns[':p' . $index++]  = '"featureprop_id"';
        }
        if ($this->isColumnModified(FeaturepropPeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(FeaturepropPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(FeaturepropPeer::VALUE)) {
            $modifiedColumns[':p' . $index++]  = '"value"';
        }
        if ($this->isColumnModified(FeaturepropPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "featureprop" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"featureprop_id"':
                        $stmt->bindValue($identifier, $this->featureprop_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"value"':
                        $stmt->bindValue($identifier, $this->value, PDO::PARAM_STR);
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

            if ($this->aFeature !== null) {
                if (!$this->aFeature->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeature->getValidationFailures());
                }
            }

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = FeaturepropPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collFeaturepropPubs !== null) {
                    foreach ($this->collFeaturepropPubs as $referrerFK) {
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
        $pos = FeaturepropPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeaturepropId();
                break;
            case 1:
                return $this->getFeatureId();
                break;
            case 2:
                return $this->getTypeId();
                break;
            case 3:
                return $this->getValue();
                break;
            case 4:
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
        if (isset($alreadyDumpedObjects['Featureprop'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Featureprop'][$this->getPrimaryKey()] = true;
        $keys = FeaturepropPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeaturepropId(),
            $keys[1] => $this->getFeatureId(),
            $keys[2] => $this->getTypeId(),
            $keys[3] => $this->getValue(),
            $keys[4] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aFeature) {
                $result['Feature'] = $this->aFeature->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFeaturepropPubs) {
                $result['FeaturepropPubs'] = $this->collFeaturepropPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = FeaturepropPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeaturepropId($value);
                break;
            case 1:
                $this->setFeatureId($value);
                break;
            case 2:
                $this->setTypeId($value);
                break;
            case 3:
                $this->setValue($value);
                break;
            case 4:
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
        $keys = FeaturepropPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeaturepropId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeatureId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTypeId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setValue($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setRank($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeaturepropPeer::DATABASE_NAME);

        if ($this->isColumnModified(FeaturepropPeer::FEATUREPROP_ID)) $criteria->add(FeaturepropPeer::FEATUREPROP_ID, $this->featureprop_id);
        if ($this->isColumnModified(FeaturepropPeer::FEATURE_ID)) $criteria->add(FeaturepropPeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(FeaturepropPeer::TYPE_ID)) $criteria->add(FeaturepropPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(FeaturepropPeer::VALUE)) $criteria->add(FeaturepropPeer::VALUE, $this->value);
        if ($this->isColumnModified(FeaturepropPeer::RANK)) $criteria->add(FeaturepropPeer::RANK, $this->rank);

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
        $criteria = new Criteria(FeaturepropPeer::DATABASE_NAME);
        $criteria->add(FeaturepropPeer::FEATUREPROP_ID, $this->featureprop_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeaturepropId();
    }

    /**
     * Generic method to set the primary key (featureprop_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeaturepropId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeaturepropId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Featureprop (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setValue($this->getValue());
        $copyObj->setRank($this->getRank());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getFeaturepropPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturepropPub($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setFeaturepropId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Featureprop Clone of current object.
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
     * @return FeaturepropPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeaturepropPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return Featureprop The current object (for fluent API support)
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
            $v->addFeatureprop($this);
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
                $this->aFeature->addFeatureprops($this);
             */
        }

        return $this->aFeature;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Featureprop The current object (for fluent API support)
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
            $v->addFeatureprop($this);
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
                $this->aCvterm->addFeatureprops($this);
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
        if ('FeaturepropPub' == $relationName) {
            $this->initFeaturepropPubs();
        }
    }

    /**
     * Clears out the collFeaturepropPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Featureprop The current object (for fluent API support)
     * @see        addFeaturepropPubs()
     */
    public function clearFeaturepropPubs()
    {
        $this->collFeaturepropPubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturepropPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturepropPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturepropPubs($v = true)
    {
        $this->collFeaturepropPubsPartial = $v;
    }

    /**
     * Initializes the collFeaturepropPubs collection.
     *
     * By default this just sets the collFeaturepropPubs collection to an empty array (like clearcollFeaturepropPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturepropPubs($overrideExisting = true)
    {
        if (null !== $this->collFeaturepropPubs && !$overrideExisting) {
            return;
        }
        $this->collFeaturepropPubs = new PropelObjectCollection();
        $this->collFeaturepropPubs->setModel('FeaturepropPub');
    }

    /**
     * Gets an array of FeaturepropPub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Featureprop is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeaturepropPub[] List of FeaturepropPub objects
     * @throws PropelException
     */
    public function getFeaturepropPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturepropPubsPartial && !$this->isNew();
        if (null === $this->collFeaturepropPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturepropPubs) {
                // return empty collection
                $this->initFeaturepropPubs();
            } else {
                $collFeaturepropPubs = FeaturepropPubQuery::create(null, $criteria)
                    ->filterByFeatureprop($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturepropPubsPartial && count($collFeaturepropPubs)) {
                      $this->initFeaturepropPubs(false);

                      foreach($collFeaturepropPubs as $obj) {
                        if (false == $this->collFeaturepropPubs->contains($obj)) {
                          $this->collFeaturepropPubs->append($obj);
                        }
                      }

                      $this->collFeaturepropPubsPartial = true;
                    }

                    $collFeaturepropPubs->getInternalIterator()->rewind();
                    return $collFeaturepropPubs;
                }

                if($partial && $this->collFeaturepropPubs) {
                    foreach($this->collFeaturepropPubs as $obj) {
                        if($obj->isNew()) {
                            $collFeaturepropPubs[] = $obj;
                        }
                    }
                }

                $this->collFeaturepropPubs = $collFeaturepropPubs;
                $this->collFeaturepropPubsPartial = false;
            }
        }

        return $this->collFeaturepropPubs;
    }

    /**
     * Sets a collection of FeaturepropPub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurepropPubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Featureprop The current object (for fluent API support)
     */
    public function setFeaturepropPubs(PropelCollection $featurepropPubs, PropelPDO $con = null)
    {
        $featurepropPubsToDelete = $this->getFeaturepropPubs(new Criteria(), $con)->diff($featurepropPubs);

        $this->featurepropPubsScheduledForDeletion = unserialize(serialize($featurepropPubsToDelete));

        foreach ($featurepropPubsToDelete as $featurepropPubRemoved) {
            $featurepropPubRemoved->setFeatureprop(null);
        }

        $this->collFeaturepropPubs = null;
        foreach ($featurepropPubs as $featurepropPub) {
            $this->addFeaturepropPub($featurepropPub);
        }

        $this->collFeaturepropPubs = $featurepropPubs;
        $this->collFeaturepropPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeaturepropPub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeaturepropPub objects.
     * @throws PropelException
     */
    public function countFeaturepropPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturepropPubsPartial && !$this->isNew();
        if (null === $this->collFeaturepropPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturepropPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturepropPubs());
            }
            $query = FeaturepropPubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByFeatureprop($this)
                ->count($con);
        }

        return count($this->collFeaturepropPubs);
    }

    /**
     * Method called to associate a FeaturepropPub object to this object
     * through the FeaturepropPub foreign key attribute.
     *
     * @param    FeaturepropPub $l FeaturepropPub
     * @return Featureprop The current object (for fluent API support)
     */
    public function addFeaturepropPub(FeaturepropPub $l)
    {
        if ($this->collFeaturepropPubs === null) {
            $this->initFeaturepropPubs();
            $this->collFeaturepropPubsPartial = true;
        }
        if (!in_array($l, $this->collFeaturepropPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturepropPub($l);
        }

        return $this;
    }

    /**
     * @param	FeaturepropPub $featurepropPub The featurepropPub object to add.
     */
    protected function doAddFeaturepropPub($featurepropPub)
    {
        $this->collFeaturepropPubs[]= $featurepropPub;
        $featurepropPub->setFeatureprop($this);
    }

    /**
     * @param	FeaturepropPub $featurepropPub The featurepropPub object to remove.
     * @return Featureprop The current object (for fluent API support)
     */
    public function removeFeaturepropPub($featurepropPub)
    {
        if ($this->getFeaturepropPubs()->contains($featurepropPub)) {
            $this->collFeaturepropPubs->remove($this->collFeaturepropPubs->search($featurepropPub));
            if (null === $this->featurepropPubsScheduledForDeletion) {
                $this->featurepropPubsScheduledForDeletion = clone $this->collFeaturepropPubs;
                $this->featurepropPubsScheduledForDeletion->clear();
            }
            $this->featurepropPubsScheduledForDeletion[]= clone $featurepropPub;
            $featurepropPub->setFeatureprop(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Featureprop is new, it will return
     * an empty collection; or if this Featureprop has previously
     * been saved, it will retrieve related FeaturepropPubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Featureprop.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeaturepropPub[] List of FeaturepropPub objects
     */
    public function getFeaturepropPubsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturepropPubQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeaturepropPubs($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->featureprop_id = null;
        $this->feature_id = null;
        $this->type_id = null;
        $this->value = null;
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
            if ($this->collFeaturepropPubs) {
                foreach ($this->collFeaturepropPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aFeature instanceof Persistent) {
              $this->aFeature->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collFeaturepropPubs instanceof PropelCollection) {
            $this->collFeaturepropPubs->clearIterator();
        }
        $this->collFeaturepropPubs = null;
        $this->aFeature = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeaturepropPeer::DEFAULT_STRING_FORMAT);
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
