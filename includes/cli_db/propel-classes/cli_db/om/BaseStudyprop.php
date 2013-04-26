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
use cli_db\propel\Study;
use cli_db\propel\StudyQuery;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropFeature;
use cli_db\propel\StudypropFeatureQuery;
use cli_db\propel\StudypropPeer;
use cli_db\propel\StudypropQuery;

/**
 * Base class that represents a row from the 'studyprop' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyprop extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\StudypropPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        StudypropPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the studyprop_id field.
     * @var        int
     */
    protected $studyprop_id;

    /**
     * The value for the study_id field.
     * @var        int
     */
    protected $study_id;

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
     * @var        Study
     */
    protected $aStudy;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

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
    protected $studypropFeaturesScheduledForDeletion = null;

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
     * Initializes internal state of BaseStudyprop object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [studyprop_id] column value.
     *
     * @return int
     */
    public function getStudypropId()
    {
        return $this->studyprop_id;
    }

    /**
     * Get the [study_id] column value.
     *
     * @return int
     */
    public function getStudyId()
    {
        return $this->study_id;
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
     * Set the value of [studyprop_id] column.
     *
     * @param int $v new value
     * @return Studyprop The current object (for fluent API support)
     */
    public function setStudypropId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->studyprop_id !== $v) {
            $this->studyprop_id = $v;
            $this->modifiedColumns[] = StudypropPeer::STUDYPROP_ID;
        }


        return $this;
    } // setStudypropId()

    /**
     * Set the value of [study_id] column.
     *
     * @param int $v new value
     * @return Studyprop The current object (for fluent API support)
     */
    public function setStudyId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->study_id !== $v) {
            $this->study_id = $v;
            $this->modifiedColumns[] = StudypropPeer::STUDY_ID;
        }

        if ($this->aStudy !== null && $this->aStudy->getStudyId() !== $v) {
            $this->aStudy = null;
        }


        return $this;
    } // setStudyId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Studyprop The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = StudypropPeer::TYPE_ID;
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
     * @return Studyprop The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[] = StudypropPeer::VALUE;
        }


        return $this;
    } // setValue()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return Studyprop The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = StudypropPeer::RANK;
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

            $this->studyprop_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->study_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->value = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->rank = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = StudypropPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Studyprop object", $e);
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

        if ($this->aStudy !== null && $this->study_id !== $this->aStudy->getStudyId()) {
            $this->aStudy = null;
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
            $con = Propel::getConnection(StudypropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = StudypropPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aStudy = null;
            $this->aCvterm = null;
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
            $con = Propel::getConnection(StudypropPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = StudypropQuery::create()
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
            $con = Propel::getConnection(StudypropPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                StudypropPeer::addInstanceToPool($this);
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

            if ($this->aStudy !== null) {
                if ($this->aStudy->isModified() || $this->aStudy->isNew()) {
                    $affectedRows += $this->aStudy->save($con);
                }
                $this->setStudy($this->aStudy);
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

        $this->modifiedColumns[] = StudypropPeer::STUDYPROP_ID;
        if (null !== $this->studyprop_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StudypropPeer::STUDYPROP_ID . ')');
        }
        if (null === $this->studyprop_id) {
            try {
                $stmt = $con->query("SELECT nextval('studyprop_studyprop_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->studyprop_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StudypropPeer::STUDYPROP_ID)) {
            $modifiedColumns[':p' . $index++]  = '"studyprop_id"';
        }
        if ($this->isColumnModified(StudypropPeer::STUDY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"study_id"';
        }
        if ($this->isColumnModified(StudypropPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(StudypropPeer::VALUE)) {
            $modifiedColumns[':p' . $index++]  = '"value"';
        }
        if ($this->isColumnModified(StudypropPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "studyprop" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"studyprop_id"':
                        $stmt->bindValue($identifier, $this->studyprop_id, PDO::PARAM_INT);
                        break;
                    case '"study_id"':
                        $stmt->bindValue($identifier, $this->study_id, PDO::PARAM_INT);
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

            if ($this->aStudy !== null) {
                if (!$this->aStudy->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aStudy->getValidationFailures());
                }
            }

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = StudypropPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = StudypropPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getStudypropId();
                break;
            case 1:
                return $this->getStudyId();
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
        if (isset($alreadyDumpedObjects['Studyprop'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Studyprop'][$this->getPrimaryKey()] = true;
        $keys = StudypropPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getStudypropId(),
            $keys[1] => $this->getStudyId(),
            $keys[2] => $this->getTypeId(),
            $keys[3] => $this->getValue(),
            $keys[4] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aStudy) {
                $result['Study'] = $this->aStudy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = StudypropPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setStudypropId($value);
                break;
            case 1:
                $this->setStudyId($value);
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
        $keys = StudypropPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setStudypropId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setStudyId($arr[$keys[1]]);
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
        $criteria = new Criteria(StudypropPeer::DATABASE_NAME);

        if ($this->isColumnModified(StudypropPeer::STUDYPROP_ID)) $criteria->add(StudypropPeer::STUDYPROP_ID, $this->studyprop_id);
        if ($this->isColumnModified(StudypropPeer::STUDY_ID)) $criteria->add(StudypropPeer::STUDY_ID, $this->study_id);
        if ($this->isColumnModified(StudypropPeer::TYPE_ID)) $criteria->add(StudypropPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(StudypropPeer::VALUE)) $criteria->add(StudypropPeer::VALUE, $this->value);
        if ($this->isColumnModified(StudypropPeer::RANK)) $criteria->add(StudypropPeer::RANK, $this->rank);

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
        $criteria = new Criteria(StudypropPeer::DATABASE_NAME);
        $criteria->add(StudypropPeer::STUDYPROP_ID, $this->studyprop_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getStudypropId();
    }

    /**
     * Generic method to set the primary key (studyprop_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setStudypropId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getStudypropId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Studyprop (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStudyId($this->getStudyId());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setValue($this->getValue());
        $copyObj->setRank($this->getRank());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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
            $copyObj->setStudypropId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Studyprop Clone of current object.
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
     * @return StudypropPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new StudypropPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Study object.
     *
     * @param             Study $v
     * @return Studyprop The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStudy(Study $v = null)
    {
        if ($v === null) {
            $this->setStudyId(NULL);
        } else {
            $this->setStudyId($v->getStudyId());
        }

        $this->aStudy = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Study object, it will not be re-added.
        if ($v !== null) {
            $v->addStudyprop($this);
        }


        return $this;
    }


    /**
     * Get the associated Study object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Study The associated Study object.
     * @throws PropelException
     */
    public function getStudy(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aStudy === null && ($this->study_id !== null) && $doQuery) {
            $this->aStudy = StudyQuery::create()->findPk($this->study_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStudy->addStudyprops($this);
             */
        }

        return $this->aStudy;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Studyprop The current object (for fluent API support)
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
            $v->addStudyprop($this);
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
                $this->aCvterm->addStudyprops($this);
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
        if ('StudypropFeature' == $relationName) {
            $this->initStudypropFeatures();
        }
    }

    /**
     * Clears out the collStudypropFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Studyprop The current object (for fluent API support)
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
     * If this Studyprop is new, it will return
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
                    ->filterByStudyprop($this)
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
     * @return Studyprop The current object (for fluent API support)
     */
    public function setStudypropFeatures(PropelCollection $studypropFeatures, PropelPDO $con = null)
    {
        $studypropFeaturesToDelete = $this->getStudypropFeatures(new Criteria(), $con)->diff($studypropFeatures);

        $this->studypropFeaturesScheduledForDeletion = unserialize(serialize($studypropFeaturesToDelete));

        foreach ($studypropFeaturesToDelete as $studypropFeatureRemoved) {
            $studypropFeatureRemoved->setStudyprop(null);
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
                ->filterByStudyprop($this)
                ->count($con);
        }

        return count($this->collStudypropFeatures);
    }

    /**
     * Method called to associate a StudypropFeature object to this object
     * through the StudypropFeature foreign key attribute.
     *
     * @param    StudypropFeature $l StudypropFeature
     * @return Studyprop The current object (for fluent API support)
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
        $studypropFeature->setStudyprop($this);
    }

    /**
     * @param	StudypropFeature $studypropFeature The studypropFeature object to remove.
     * @return Studyprop The current object (for fluent API support)
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
            $studypropFeature->setStudyprop(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Studyprop is new, it will return
     * an empty collection; or if this Studyprop has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Studyprop.
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
     * Otherwise if this Studyprop is new, it will return
     * an empty collection; or if this Studyprop has previously
     * been saved, it will retrieve related StudypropFeatures from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Studyprop.
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
        $this->studyprop_id = null;
        $this->study_id = null;
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
            if ($this->collStudypropFeatures) {
                foreach ($this->collStudypropFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aStudy instanceof Persistent) {
              $this->aStudy->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collStudypropFeatures instanceof PropelCollection) {
            $this->collStudypropFeatures->clearIterator();
        }
        $this->collStudypropFeatures = null;
        $this->aStudy = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StudypropPeer::DEFAULT_STRING_FORMAT);
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
