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
use cli_db\propel\Study;
use cli_db\propel\StudyQuery;
use cli_db\propel\Studydesign;
use cli_db\propel\StudydesignPeer;
use cli_db\propel\StudydesignQuery;
use cli_db\propel\Studydesignprop;
use cli_db\propel\StudydesignpropQuery;
use cli_db\propel\Studyfactor;
use cli_db\propel\StudyfactorQuery;

/**
 * Base class that represents a row from the 'studydesign' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudydesign extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\StudydesignPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        StudydesignPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the studydesign_id field.
     * @var        int
     */
    protected $studydesign_id;

    /**
     * The value for the study_id field.
     * @var        int
     */
    protected $study_id;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * @var        Study
     */
    protected $aStudy;

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
    protected $studydesignpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studyfactorsScheduledForDeletion = null;

    /**
     * Get the [studydesign_id] column value.
     *
     * @return int
     */
    public function getStudydesignId()
    {
        return $this->studydesign_id;
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
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of [studydesign_id] column.
     *
     * @param int $v new value
     * @return Studydesign The current object (for fluent API support)
     */
    public function setStudydesignId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->studydesign_id !== $v) {
            $this->studydesign_id = $v;
            $this->modifiedColumns[] = StudydesignPeer::STUDYDESIGN_ID;
        }


        return $this;
    } // setStudydesignId()

    /**
     * Set the value of [study_id] column.
     *
     * @param int $v new value
     * @return Studydesign The current object (for fluent API support)
     */
    public function setStudyId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->study_id !== $v) {
            $this->study_id = $v;
            $this->modifiedColumns[] = StudydesignPeer::STUDY_ID;
        }

        if ($this->aStudy !== null && $this->aStudy->getStudyId() !== $v) {
            $this->aStudy = null;
        }


        return $this;
    } // setStudyId()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Studydesign The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = StudydesignPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

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

            $this->studydesign_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->study_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = StudydesignPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Studydesign object", $e);
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
            $con = Propel::getConnection(StudydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = StudydesignPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aStudy = null;
            $this->collStudydesignprops = null;

            $this->collStudyfactors = null;

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
            $con = Propel::getConnection(StudydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = StudydesignQuery::create()
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
            $con = Propel::getConnection(StudydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                StudydesignPeer::addInstanceToPool($this);
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
                    StudyfactorQuery::create()
                        ->filterByPrimaryKeys($this->studyfactorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[] = StudydesignPeer::STUDYDESIGN_ID;
        if (null !== $this->studydesign_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StudydesignPeer::STUDYDESIGN_ID . ')');
        }
        if (null === $this->studydesign_id) {
            try {
                $stmt = $con->query("SELECT nextval('studydesign_studydesign_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->studydesign_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StudydesignPeer::STUDYDESIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = '"studydesign_id"';
        }
        if ($this->isColumnModified(StudydesignPeer::STUDY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"study_id"';
        }
        if ($this->isColumnModified(StudydesignPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "studydesign" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"studydesign_id"':
                        $stmt->bindValue($identifier, $this->studydesign_id, PDO::PARAM_INT);
                        break;
                    case '"study_id"':
                        $stmt->bindValue($identifier, $this->study_id, PDO::PARAM_INT);
                        break;
                    case '"description"':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
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


            if (($retval = StudydesignPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = StudydesignPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getStudydesignId();
                break;
            case 1:
                return $this->getStudyId();
                break;
            case 2:
                return $this->getDescription();
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
        if (isset($alreadyDumpedObjects['Studydesign'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Studydesign'][$this->getPrimaryKey()] = true;
        $keys = StudydesignPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getStudydesignId(),
            $keys[1] => $this->getStudyId(),
            $keys[2] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aStudy) {
                $result['Study'] = $this->aStudy->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collStudydesignprops) {
                $result['Studydesignprops'] = $this->collStudydesignprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudyfactors) {
                $result['Studyfactors'] = $this->collStudyfactors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = StudydesignPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setStudydesignId($value);
                break;
            case 1:
                $this->setStudyId($value);
                break;
            case 2:
                $this->setDescription($value);
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
        $keys = StudydesignPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setStudydesignId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setStudyId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StudydesignPeer::DATABASE_NAME);

        if ($this->isColumnModified(StudydesignPeer::STUDYDESIGN_ID)) $criteria->add(StudydesignPeer::STUDYDESIGN_ID, $this->studydesign_id);
        if ($this->isColumnModified(StudydesignPeer::STUDY_ID)) $criteria->add(StudydesignPeer::STUDY_ID, $this->study_id);
        if ($this->isColumnModified(StudydesignPeer::DESCRIPTION)) $criteria->add(StudydesignPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(StudydesignPeer::DATABASE_NAME);
        $criteria->add(StudydesignPeer::STUDYDESIGN_ID, $this->studydesign_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getStudydesignId();
    }

    /**
     * Generic method to set the primary key (studydesign_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setStudydesignId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getStudydesignId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Studydesign (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStudyId($this->getStudyId());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

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

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setStudydesignId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Studydesign Clone of current object.
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
     * @return StudydesignPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new StudydesignPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Study object.
     *
     * @param             Study $v
     * @return Studydesign The current object (for fluent API support)
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
            $v->addStudydesign($this);
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
                $this->aStudy->addStudydesigns($this);
             */
        }

        return $this->aStudy;
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
        if ('Studydesignprop' == $relationName) {
            $this->initStudydesignprops();
        }
        if ('Studyfactor' == $relationName) {
            $this->initStudyfactors();
        }
    }

    /**
     * Clears out the collStudydesignprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Studydesign The current object (for fluent API support)
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
     * If this Studydesign is new, it will return
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
                    ->filterByStudydesign($this)
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
     * @return Studydesign The current object (for fluent API support)
     */
    public function setStudydesignprops(PropelCollection $studydesignprops, PropelPDO $con = null)
    {
        $studydesignpropsToDelete = $this->getStudydesignprops(new Criteria(), $con)->diff($studydesignprops);

        $this->studydesignpropsScheduledForDeletion = unserialize(serialize($studydesignpropsToDelete));

        foreach ($studydesignpropsToDelete as $studydesignpropRemoved) {
            $studydesignpropRemoved->setStudydesign(null);
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
                ->filterByStudydesign($this)
                ->count($con);
        }

        return count($this->collStudydesignprops);
    }

    /**
     * Method called to associate a Studydesignprop object to this object
     * through the Studydesignprop foreign key attribute.
     *
     * @param    Studydesignprop $l Studydesignprop
     * @return Studydesign The current object (for fluent API support)
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
        $studydesignprop->setStudydesign($this);
    }

    /**
     * @param	Studydesignprop $studydesignprop The studydesignprop object to remove.
     * @return Studydesign The current object (for fluent API support)
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
            $studydesignprop->setStudydesign(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Studydesign is new, it will return
     * an empty collection; or if this Studydesign has previously
     * been saved, it will retrieve related Studydesignprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Studydesign.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studydesignprop[] List of Studydesignprop objects
     */
    public function getStudydesignpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudydesignpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getStudydesignprops($query, $con);
    }

    /**
     * Clears out the collStudyfactors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Studydesign The current object (for fluent API support)
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
     * If this Studydesign is new, it will return
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
                    ->filterByStudydesign($this)
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
     * @return Studydesign The current object (for fluent API support)
     */
    public function setStudyfactors(PropelCollection $studyfactors, PropelPDO $con = null)
    {
        $studyfactorsToDelete = $this->getStudyfactors(new Criteria(), $con)->diff($studyfactors);

        $this->studyfactorsScheduledForDeletion = unserialize(serialize($studyfactorsToDelete));

        foreach ($studyfactorsToDelete as $studyfactorRemoved) {
            $studyfactorRemoved->setStudydesign(null);
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
                ->filterByStudydesign($this)
                ->count($con);
        }

        return count($this->collStudyfactors);
    }

    /**
     * Method called to associate a Studyfactor object to this object
     * through the Studyfactor foreign key attribute.
     *
     * @param    Studyfactor $l Studyfactor
     * @return Studydesign The current object (for fluent API support)
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
        $studyfactor->setStudydesign($this);
    }

    /**
     * @param	Studyfactor $studyfactor The studyfactor object to remove.
     * @return Studydesign The current object (for fluent API support)
     */
    public function removeStudyfactor($studyfactor)
    {
        if ($this->getStudyfactors()->contains($studyfactor)) {
            $this->collStudyfactors->remove($this->collStudyfactors->search($studyfactor));
            if (null === $this->studyfactorsScheduledForDeletion) {
                $this->studyfactorsScheduledForDeletion = clone $this->collStudyfactors;
                $this->studyfactorsScheduledForDeletion->clear();
            }
            $this->studyfactorsScheduledForDeletion[]= clone $studyfactor;
            $studyfactor->setStudydesign(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Studydesign is new, it will return
     * an empty collection; or if this Studydesign has previously
     * been saved, it will retrieve related Studyfactors from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Studydesign.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studyfactor[] List of Studyfactor objects
     */
    public function getStudyfactorsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyfactorQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getStudyfactors($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->studydesign_id = null;
        $this->study_id = null;
        $this->description = null;
        $this->alreadyInSave = false;
        $this->alreadyInValidation = false;
        $this->alreadyInClearAllReferencesDeep = false;
        $this->clearAllReferences();
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
            if ($this->aStudy instanceof Persistent) {
              $this->aStudy->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collStudydesignprops instanceof PropelCollection) {
            $this->collStudydesignprops->clearIterator();
        }
        $this->collStudydesignprops = null;
        if ($this->collStudyfactors instanceof PropelCollection) {
            $this->collStudyfactors->clearIterator();
        }
        $this->collStudyfactors = null;
        $this->aStudy = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StudydesignPeer::DEFAULT_STRING_FORMAT);
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
