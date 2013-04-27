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
use cli_db\propel\Studydesign;
use cli_db\propel\StudydesignQuery;
use cli_db\propel\Studyfactor;
use cli_db\propel\StudyfactorPeer;
use cli_db\propel\StudyfactorQuery;
use cli_db\propel\Studyfactorvalue;
use cli_db\propel\StudyfactorvalueQuery;

/**
 * Base class that represents a row from the 'studyfactor' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyfactor extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\StudyfactorPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        StudyfactorPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the studyfactor_id field.
     * @var        int
     */
    protected $studyfactor_id;

    /**
     * The value for the studydesign_id field.
     * @var        int
     */
    protected $studydesign_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * @var        Studydesign
     */
    protected $aStudydesign;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|Studyfactorvalue[] Collection to store aggregation of Studyfactorvalue objects.
     */
    protected $collStudyfactorvalues;
    protected $collStudyfactorvaluesPartial;

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
    protected $studyfactorvaluesScheduledForDeletion = null;

    /**
     * Get the [studyfactor_id] column value.
     *
     * @return int
     */
    public function getStudyfactorId()
    {
        return $this->studyfactor_id;
    }

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
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
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
     * Get the [description] column value.
     *
     * @return string
     */
    public function getDescription()
    {
        return $this->description;
    }

    /**
     * Set the value of [studyfactor_id] column.
     *
     * @param int $v new value
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setStudyfactorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->studyfactor_id !== $v) {
            $this->studyfactor_id = $v;
            $this->modifiedColumns[] = StudyfactorPeer::STUDYFACTOR_ID;
        }


        return $this;
    } // setStudyfactorId()

    /**
     * Set the value of [studydesign_id] column.
     *
     * @param int $v new value
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setStudydesignId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->studydesign_id !== $v) {
            $this->studydesign_id = $v;
            $this->modifiedColumns[] = StudyfactorPeer::STUDYDESIGN_ID;
        }

        if ($this->aStudydesign !== null && $this->aStudydesign->getStudydesignId() !== $v) {
            $this->aStudydesign = null;
        }


        return $this;
    } // setStudydesignId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = StudyfactorPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = StudyfactorPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = StudyfactorPeer::DESCRIPTION;
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

            $this->studyfactor_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->studydesign_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->type_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->name = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->description = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = StudyfactorPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Studyfactor object", $e);
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

        if ($this->aStudydesign !== null && $this->studydesign_id !== $this->aStudydesign->getStudydesignId()) {
            $this->aStudydesign = null;
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
            $con = Propel::getConnection(StudyfactorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = StudyfactorPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aStudydesign = null;
            $this->aCvterm = null;
            $this->collStudyfactorvalues = null;

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
            $con = Propel::getConnection(StudyfactorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = StudyfactorQuery::create()
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
            $con = Propel::getConnection(StudyfactorPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                StudyfactorPeer::addInstanceToPool($this);
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

            if ($this->aStudydesign !== null) {
                if ($this->aStudydesign->isModified() || $this->aStudydesign->isNew()) {
                    $affectedRows += $this->aStudydesign->save($con);
                }
                $this->setStudydesign($this->aStudydesign);
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

            if ($this->studyfactorvaluesScheduledForDeletion !== null) {
                if (!$this->studyfactorvaluesScheduledForDeletion->isEmpty()) {
                    StudyfactorvalueQuery::create()
                        ->filterByPrimaryKeys($this->studyfactorvaluesScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studyfactorvaluesScheduledForDeletion = null;
                }
            }

            if ($this->collStudyfactorvalues !== null) {
                foreach ($this->collStudyfactorvalues as $referrerFK) {
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

        $this->modifiedColumns[] = StudyfactorPeer::STUDYFACTOR_ID;
        if (null !== $this->studyfactor_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StudyfactorPeer::STUDYFACTOR_ID . ')');
        }
        if (null === $this->studyfactor_id) {
            try {
                $stmt = $con->query("SELECT nextval('studyfactor_studyfactor_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->studyfactor_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StudyfactorPeer::STUDYFACTOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '"studyfactor_id"';
        }
        if ($this->isColumnModified(StudyfactorPeer::STUDYDESIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = '"studydesign_id"';
        }
        if ($this->isColumnModified(StudyfactorPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(StudyfactorPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(StudyfactorPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "studyfactor" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"studyfactor_id"':
                        $stmt->bindValue($identifier, $this->studyfactor_id, PDO::PARAM_INT);
                        break;
                    case '"studydesign_id"':
                        $stmt->bindValue($identifier, $this->studydesign_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
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

            if ($this->aStudydesign !== null) {
                if (!$this->aStudydesign->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aStudydesign->getValidationFailures());
                }
            }

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = StudyfactorPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collStudyfactorvalues !== null) {
                    foreach ($this->collStudyfactorvalues as $referrerFK) {
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
        $pos = StudyfactorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getStudyfactorId();
                break;
            case 1:
                return $this->getStudydesignId();
                break;
            case 2:
                return $this->getTypeId();
                break;
            case 3:
                return $this->getName();
                break;
            case 4:
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
        if (isset($alreadyDumpedObjects['Studyfactor'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Studyfactor'][$this->getPrimaryKey()] = true;
        $keys = StudyfactorPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getStudyfactorId(),
            $keys[1] => $this->getStudydesignId(),
            $keys[2] => $this->getTypeId(),
            $keys[3] => $this->getName(),
            $keys[4] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aStudydesign) {
                $result['Studydesign'] = $this->aStudydesign->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collStudyfactorvalues) {
                $result['Studyfactorvalues'] = $this->collStudyfactorvalues->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = StudyfactorPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setStudyfactorId($value);
                break;
            case 1:
                $this->setStudydesignId($value);
                break;
            case 2:
                $this->setTypeId($value);
                break;
            case 3:
                $this->setName($value);
                break;
            case 4:
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
        $keys = StudyfactorPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setStudyfactorId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setStudydesignId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTypeId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setName($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StudyfactorPeer::DATABASE_NAME);

        if ($this->isColumnModified(StudyfactorPeer::STUDYFACTOR_ID)) $criteria->add(StudyfactorPeer::STUDYFACTOR_ID, $this->studyfactor_id);
        if ($this->isColumnModified(StudyfactorPeer::STUDYDESIGN_ID)) $criteria->add(StudyfactorPeer::STUDYDESIGN_ID, $this->studydesign_id);
        if ($this->isColumnModified(StudyfactorPeer::TYPE_ID)) $criteria->add(StudyfactorPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(StudyfactorPeer::NAME)) $criteria->add(StudyfactorPeer::NAME, $this->name);
        if ($this->isColumnModified(StudyfactorPeer::DESCRIPTION)) $criteria->add(StudyfactorPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(StudyfactorPeer::DATABASE_NAME);
        $criteria->add(StudyfactorPeer::STUDYFACTOR_ID, $this->studyfactor_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getStudyfactorId();
    }

    /**
     * Generic method to set the primary key (studyfactor_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setStudyfactorId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getStudyfactorId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Studyfactor (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setStudydesignId($this->getStudydesignId());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getStudyfactorvalues() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyfactorvalue($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setStudyfactorId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Studyfactor Clone of current object.
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
     * @return StudyfactorPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new StudyfactorPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Studydesign object.
     *
     * @param             Studydesign $v
     * @return Studyfactor The current object (for fluent API support)
     * @throws PropelException
     */
    public function setStudydesign(Studydesign $v = null)
    {
        if ($v === null) {
            $this->setStudydesignId(NULL);
        } else {
            $this->setStudydesignId($v->getStudydesignId());
        }

        $this->aStudydesign = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Studydesign object, it will not be re-added.
        if ($v !== null) {
            $v->addStudyfactor($this);
        }


        return $this;
    }


    /**
     * Get the associated Studydesign object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Studydesign The associated Studydesign object.
     * @throws PropelException
     */
    public function getStudydesign(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aStudydesign === null && ($this->studydesign_id !== null) && $doQuery) {
            $this->aStudydesign = StudydesignQuery::create()->findPk($this->studydesign_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aStudydesign->addStudyfactors($this);
             */
        }

        return $this->aStudydesign;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Studyfactor The current object (for fluent API support)
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
            $v->addStudyfactor($this);
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
                $this->aCvterm->addStudyfactors($this);
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
        if ('Studyfactorvalue' == $relationName) {
            $this->initStudyfactorvalues();
        }
    }

    /**
     * Clears out the collStudyfactorvalues collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Studyfactor The current object (for fluent API support)
     * @see        addStudyfactorvalues()
     */
    public function clearStudyfactorvalues()
    {
        $this->collStudyfactorvalues = null; // important to set this to null since that means it is uninitialized
        $this->collStudyfactorvaluesPartial = null;

        return $this;
    }

    /**
     * reset is the collStudyfactorvalues collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudyfactorvalues($v = true)
    {
        $this->collStudyfactorvaluesPartial = $v;
    }

    /**
     * Initializes the collStudyfactorvalues collection.
     *
     * By default this just sets the collStudyfactorvalues collection to an empty array (like clearcollStudyfactorvalues());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyfactorvalues($overrideExisting = true)
    {
        if (null !== $this->collStudyfactorvalues && !$overrideExisting) {
            return;
        }
        $this->collStudyfactorvalues = new PropelObjectCollection();
        $this->collStudyfactorvalues->setModel('Studyfactorvalue');
    }

    /**
     * Gets an array of Studyfactorvalue objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Studyfactor is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studyfactorvalue[] List of Studyfactorvalue objects
     * @throws PropelException
     */
    public function getStudyfactorvalues($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudyfactorvaluesPartial && !$this->isNew();
        if (null === $this->collStudyfactorvalues || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyfactorvalues) {
                // return empty collection
                $this->initStudyfactorvalues();
            } else {
                $collStudyfactorvalues = StudyfactorvalueQuery::create(null, $criteria)
                    ->filterByStudyfactor($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudyfactorvaluesPartial && count($collStudyfactorvalues)) {
                      $this->initStudyfactorvalues(false);

                      foreach($collStudyfactorvalues as $obj) {
                        if (false == $this->collStudyfactorvalues->contains($obj)) {
                          $this->collStudyfactorvalues->append($obj);
                        }
                      }

                      $this->collStudyfactorvaluesPartial = true;
                    }

                    $collStudyfactorvalues->getInternalIterator()->rewind();
                    return $collStudyfactorvalues;
                }

                if($partial && $this->collStudyfactorvalues) {
                    foreach($this->collStudyfactorvalues as $obj) {
                        if($obj->isNew()) {
                            $collStudyfactorvalues[] = $obj;
                        }
                    }
                }

                $this->collStudyfactorvalues = $collStudyfactorvalues;
                $this->collStudyfactorvaluesPartial = false;
            }
        }

        return $this->collStudyfactorvalues;
    }

    /**
     * Sets a collection of Studyfactorvalue objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studyfactorvalues A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Studyfactor The current object (for fluent API support)
     */
    public function setStudyfactorvalues(PropelCollection $studyfactorvalues, PropelPDO $con = null)
    {
        $studyfactorvaluesToDelete = $this->getStudyfactorvalues(new Criteria(), $con)->diff($studyfactorvalues);

        $this->studyfactorvaluesScheduledForDeletion = unserialize(serialize($studyfactorvaluesToDelete));

        foreach ($studyfactorvaluesToDelete as $studyfactorvalueRemoved) {
            $studyfactorvalueRemoved->setStudyfactor(null);
        }

        $this->collStudyfactorvalues = null;
        foreach ($studyfactorvalues as $studyfactorvalue) {
            $this->addStudyfactorvalue($studyfactorvalue);
        }

        $this->collStudyfactorvalues = $studyfactorvalues;
        $this->collStudyfactorvaluesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studyfactorvalue objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studyfactorvalue objects.
     * @throws PropelException
     */
    public function countStudyfactorvalues(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudyfactorvaluesPartial && !$this->isNew();
        if (null === $this->collStudyfactorvalues || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyfactorvalues) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudyfactorvalues());
            }
            $query = StudyfactorvalueQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStudyfactor($this)
                ->count($con);
        }

        return count($this->collStudyfactorvalues);
    }

    /**
     * Method called to associate a Studyfactorvalue object to this object
     * through the Studyfactorvalue foreign key attribute.
     *
     * @param    Studyfactorvalue $l Studyfactorvalue
     * @return Studyfactor The current object (for fluent API support)
     */
    public function addStudyfactorvalue(Studyfactorvalue $l)
    {
        if ($this->collStudyfactorvalues === null) {
            $this->initStudyfactorvalues();
            $this->collStudyfactorvaluesPartial = true;
        }
        if (!in_array($l, $this->collStudyfactorvalues->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudyfactorvalue($l);
        }

        return $this;
    }

    /**
     * @param	Studyfactorvalue $studyfactorvalue The studyfactorvalue object to add.
     */
    protected function doAddStudyfactorvalue($studyfactorvalue)
    {
        $this->collStudyfactorvalues[]= $studyfactorvalue;
        $studyfactorvalue->setStudyfactor($this);
    }

    /**
     * @param	Studyfactorvalue $studyfactorvalue The studyfactorvalue object to remove.
     * @return Studyfactor The current object (for fluent API support)
     */
    public function removeStudyfactorvalue($studyfactorvalue)
    {
        if ($this->getStudyfactorvalues()->contains($studyfactorvalue)) {
            $this->collStudyfactorvalues->remove($this->collStudyfactorvalues->search($studyfactorvalue));
            if (null === $this->studyfactorvaluesScheduledForDeletion) {
                $this->studyfactorvaluesScheduledForDeletion = clone $this->collStudyfactorvalues;
                $this->studyfactorvaluesScheduledForDeletion->clear();
            }
            $this->studyfactorvaluesScheduledForDeletion[]= clone $studyfactorvalue;
            $studyfactorvalue->setStudyfactor(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Studyfactor is new, it will return
     * an empty collection; or if this Studyfactor has previously
     * been saved, it will retrieve related Studyfactorvalues from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Studyfactor.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studyfactorvalue[] List of Studyfactorvalue objects
     */
    public function getStudyfactorvaluesJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyfactorvalueQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getStudyfactorvalues($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->studyfactor_id = null;
        $this->studydesign_id = null;
        $this->type_id = null;
        $this->name = null;
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
            if ($this->collStudyfactorvalues) {
                foreach ($this->collStudyfactorvalues as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aStudydesign instanceof Persistent) {
              $this->aStudydesign->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collStudyfactorvalues instanceof PropelCollection) {
            $this->collStudyfactorvalues->clearIterator();
        }
        $this->collStudyfactorvalues = null;
        $this->aStudydesign = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StudyfactorPeer::DEFAULT_STRING_FORMAT);
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
