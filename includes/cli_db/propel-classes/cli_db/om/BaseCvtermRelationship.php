<?php

namespace cli_db\propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\CvtermRelationship;
use cli_db\propel\CvtermRelationshipPeer;
use cli_db\propel\CvtermRelationshipQuery;

/**
 * Base class that represents a row from the 'cvterm_relationship' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermRelationship extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\CvtermRelationshipPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CvtermRelationshipPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the cvterm_relationship_id field.
     * @var        int
     */
    protected $cvterm_relationship_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the subject_id field.
     * @var        int
     */
    protected $subject_id;

    /**
     * The value for the object_id field.
     * @var        int
     */
    protected $object_id;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedByObjectId;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedBySubjectId;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedByTypeId;

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
     * Get the [cvterm_relationship_id] column value.
     *
     * @return int
     */
    public function getCvtermRelationshipId()
    {
        return $this->cvterm_relationship_id;
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
     * Get the [subject_id] column value.
     *
     * @return int
     */
    public function getSubjectId()
    {
        return $this->subject_id;
    }

    /**
     * Get the [object_id] column value.
     *
     * @return int
     */
    public function getObjectId()
    {
        return $this->object_id;
    }

    /**
     * Set the value of [cvterm_relationship_id] column.
     *
     * @param int $v new value
     * @return CvtermRelationship The current object (for fluent API support)
     */
    public function setCvtermRelationshipId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cvterm_relationship_id !== $v) {
            $this->cvterm_relationship_id = $v;
            $this->modifiedColumns[] = CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID;
        }


        return $this;
    } // setCvtermRelationshipId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return CvtermRelationship The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = CvtermRelationshipPeer::TYPE_ID;
        }

        if ($this->aCvtermRelatedByTypeId !== null && $this->aCvtermRelatedByTypeId->getCvtermId() !== $v) {
            $this->aCvtermRelatedByTypeId = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [subject_id] column.
     *
     * @param int $v new value
     * @return CvtermRelationship The current object (for fluent API support)
     */
    public function setSubjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->subject_id !== $v) {
            $this->subject_id = $v;
            $this->modifiedColumns[] = CvtermRelationshipPeer::SUBJECT_ID;
        }

        if ($this->aCvtermRelatedBySubjectId !== null && $this->aCvtermRelatedBySubjectId->getCvtermId() !== $v) {
            $this->aCvtermRelatedBySubjectId = null;
        }


        return $this;
    } // setSubjectId()

    /**
     * Set the value of [object_id] column.
     *
     * @param int $v new value
     * @return CvtermRelationship The current object (for fluent API support)
     */
    public function setObjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->object_id !== $v) {
            $this->object_id = $v;
            $this->modifiedColumns[] = CvtermRelationshipPeer::OBJECT_ID;
        }

        if ($this->aCvtermRelatedByObjectId !== null && $this->aCvtermRelatedByObjectId->getCvtermId() !== $v) {
            $this->aCvtermRelatedByObjectId = null;
        }


        return $this;
    } // setObjectId()

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

            $this->cvterm_relationship_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->subject_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->object_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 4; // 4 = CvtermRelationshipPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating CvtermRelationship object", $e);
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

        if ($this->aCvtermRelatedByTypeId !== null && $this->type_id !== $this->aCvtermRelatedByTypeId->getCvtermId()) {
            $this->aCvtermRelatedByTypeId = null;
        }
        if ($this->aCvtermRelatedBySubjectId !== null && $this->subject_id !== $this->aCvtermRelatedBySubjectId->getCvtermId()) {
            $this->aCvtermRelatedBySubjectId = null;
        }
        if ($this->aCvtermRelatedByObjectId !== null && $this->object_id !== $this->aCvtermRelatedByObjectId->getCvtermId()) {
            $this->aCvtermRelatedByObjectId = null;
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
            $con = Propel::getConnection(CvtermRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CvtermRelationshipPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCvtermRelatedByObjectId = null;
            $this->aCvtermRelatedBySubjectId = null;
            $this->aCvtermRelatedByTypeId = null;
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
            $con = Propel::getConnection(CvtermRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CvtermRelationshipQuery::create()
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
            $con = Propel::getConnection(CvtermRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                CvtermRelationshipPeer::addInstanceToPool($this);
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

            if ($this->aCvtermRelatedByObjectId !== null) {
                if ($this->aCvtermRelatedByObjectId->isModified() || $this->aCvtermRelatedByObjectId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedByObjectId->save($con);
                }
                $this->setCvtermRelatedByObjectId($this->aCvtermRelatedByObjectId);
            }

            if ($this->aCvtermRelatedBySubjectId !== null) {
                if ($this->aCvtermRelatedBySubjectId->isModified() || $this->aCvtermRelatedBySubjectId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedBySubjectId->save($con);
                }
                $this->setCvtermRelatedBySubjectId($this->aCvtermRelatedBySubjectId);
            }

            if ($this->aCvtermRelatedByTypeId !== null) {
                if ($this->aCvtermRelatedByTypeId->isModified() || $this->aCvtermRelatedByTypeId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedByTypeId->save($con);
                }
                $this->setCvtermRelatedByTypeId($this->aCvtermRelatedByTypeId);
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

        $this->modifiedColumns[] = CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID;
        if (null !== $this->cvterm_relationship_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID . ')');
        }
        if (null === $this->cvterm_relationship_id) {
            try {
                $stmt = $con->query("SELECT nextval('cvterm_relationship_cvterm_relationship_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->cvterm_relationship_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cvterm_relationship_id"';
        }
        if ($this->isColumnModified(CvtermRelationshipPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(CvtermRelationshipPeer::SUBJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"subject_id"';
        }
        if ($this->isColumnModified(CvtermRelationshipPeer::OBJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"object_id"';
        }

        $sql = sprintf(
            'INSERT INTO "cvterm_relationship" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"cvterm_relationship_id"':
                        $stmt->bindValue($identifier, $this->cvterm_relationship_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"subject_id"':
                        $stmt->bindValue($identifier, $this->subject_id, PDO::PARAM_INT);
                        break;
                    case '"object_id"':
                        $stmt->bindValue($identifier, $this->object_id, PDO::PARAM_INT);
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

            if ($this->aCvtermRelatedByObjectId !== null) {
                if (!$this->aCvtermRelatedByObjectId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedByObjectId->getValidationFailures());
                }
            }

            if ($this->aCvtermRelatedBySubjectId !== null) {
                if (!$this->aCvtermRelatedBySubjectId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedBySubjectId->getValidationFailures());
                }
            }

            if ($this->aCvtermRelatedByTypeId !== null) {
                if (!$this->aCvtermRelatedByTypeId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedByTypeId->getValidationFailures());
                }
            }


            if (($retval = CvtermRelationshipPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
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
        $pos = CvtermRelationshipPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getCvtermRelationshipId();
                break;
            case 1:
                return $this->getTypeId();
                break;
            case 2:
                return $this->getSubjectId();
                break;
            case 3:
                return $this->getObjectId();
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
        if (isset($alreadyDumpedObjects['CvtermRelationship'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['CvtermRelationship'][$this->getPrimaryKey()] = true;
        $keys = CvtermRelationshipPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCvtermRelationshipId(),
            $keys[1] => $this->getTypeId(),
            $keys[2] => $this->getSubjectId(),
            $keys[3] => $this->getObjectId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCvtermRelatedByObjectId) {
                $result['CvtermRelatedByObjectId'] = $this->aCvtermRelatedByObjectId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvtermRelatedBySubjectId) {
                $result['CvtermRelatedBySubjectId'] = $this->aCvtermRelatedBySubjectId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvtermRelatedByTypeId) {
                $result['CvtermRelatedByTypeId'] = $this->aCvtermRelatedByTypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = CvtermRelationshipPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setCvtermRelationshipId($value);
                break;
            case 1:
                $this->setTypeId($value);
                break;
            case 2:
                $this->setSubjectId($value);
                break;
            case 3:
                $this->setObjectId($value);
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
        $keys = CvtermRelationshipPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setCvtermRelationshipId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setSubjectId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setObjectId($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CvtermRelationshipPeer::DATABASE_NAME);

        if ($this->isColumnModified(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID)) $criteria->add(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $this->cvterm_relationship_id);
        if ($this->isColumnModified(CvtermRelationshipPeer::TYPE_ID)) $criteria->add(CvtermRelationshipPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(CvtermRelationshipPeer::SUBJECT_ID)) $criteria->add(CvtermRelationshipPeer::SUBJECT_ID, $this->subject_id);
        if ($this->isColumnModified(CvtermRelationshipPeer::OBJECT_ID)) $criteria->add(CvtermRelationshipPeer::OBJECT_ID, $this->object_id);

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
        $criteria = new Criteria(CvtermRelationshipPeer::DATABASE_NAME);
        $criteria->add(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $this->cvterm_relationship_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCvtermRelationshipId();
    }

    /**
     * Generic method to set the primary key (cvterm_relationship_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCvtermRelationshipId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getCvtermRelationshipId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of CvtermRelationship (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setSubjectId($this->getSubjectId());
        $copyObj->setObjectId($this->getObjectId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCvtermRelationshipId(NULL); // this is a auto-increment column, so set to default value
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
     * @return CvtermRelationship Clone of current object.
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
     * @return CvtermRelationshipPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CvtermRelationshipPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return CvtermRelationship The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedByObjectId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setObjectId(NULL);
        } else {
            $this->setObjectId($v->getCvtermId());
        }

        $this->aCvtermRelatedByObjectId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addCvtermRelationshipRelatedByObjectId($this);
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
    public function getCvtermRelatedByObjectId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedByObjectId === null && ($this->object_id !== null) && $doQuery) {
            $this->aCvtermRelatedByObjectId = CvtermQuery::create()->findPk($this->object_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedByObjectId->addCvtermRelationshipsRelatedByObjectId($this);
             */
        }

        return $this->aCvtermRelatedByObjectId;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return CvtermRelationship The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedBySubjectId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setSubjectId(NULL);
        } else {
            $this->setSubjectId($v->getCvtermId());
        }

        $this->aCvtermRelatedBySubjectId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addCvtermRelationshipRelatedBySubjectId($this);
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
    public function getCvtermRelatedBySubjectId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedBySubjectId === null && ($this->subject_id !== null) && $doQuery) {
            $this->aCvtermRelatedBySubjectId = CvtermQuery::create()->findPk($this->subject_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedBySubjectId->addCvtermRelationshipsRelatedBySubjectId($this);
             */
        }

        return $this->aCvtermRelatedBySubjectId;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return CvtermRelationship The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedByTypeId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setTypeId(NULL);
        } else {
            $this->setTypeId($v->getCvtermId());
        }

        $this->aCvtermRelatedByTypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addCvtermRelationshipRelatedByTypeId($this);
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
    public function getCvtermRelatedByTypeId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedByTypeId === null && ($this->type_id !== null) && $doQuery) {
            $this->aCvtermRelatedByTypeId = CvtermQuery::create()->findPk($this->type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedByTypeId->addCvtermRelationshipsRelatedByTypeId($this);
             */
        }

        return $this->aCvtermRelatedByTypeId;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->cvterm_relationship_id = null;
        $this->type_id = null;
        $this->subject_id = null;
        $this->object_id = null;
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
            if ($this->aCvtermRelatedByObjectId instanceof Persistent) {
              $this->aCvtermRelatedByObjectId->clearAllReferences($deep);
            }
            if ($this->aCvtermRelatedBySubjectId instanceof Persistent) {
              $this->aCvtermRelatedBySubjectId->clearAllReferences($deep);
            }
            if ($this->aCvtermRelatedByTypeId instanceof Persistent) {
              $this->aCvtermRelatedByTypeId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aCvtermRelatedByObjectId = null;
        $this->aCvtermRelatedBySubjectId = null;
        $this->aCvtermRelatedByTypeId = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CvtermRelationshipPeer::DEFAULT_STRING_FORMAT);
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
