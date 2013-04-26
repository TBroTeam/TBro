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
use cli_db\propel\Element;
use cli_db\propel\ElementQuery;
use cli_db\propel\Elementresult;
use cli_db\propel\ElementresultPeer;
use cli_db\propel\ElementresultQuery;
use cli_db\propel\ElementresultRelationship;
use cli_db\propel\ElementresultRelationshipQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationQuery;

/**
 * Base class that represents a row from the 'elementresult' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseElementresult extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ElementresultPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ElementresultPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the elementresult_id field.
     * @var        int
     */
    protected $elementresult_id;

    /**
     * The value for the element_id field.
     * @var        int
     */
    protected $element_id;

    /**
     * The value for the quantification_id field.
     * @var        int
     */
    protected $quantification_id;

    /**
     * The value for the signal field.
     * @var        double
     */
    protected $signal;

    /**
     * @var        Element
     */
    protected $aElement;

    /**
     * @var        Quantification
     */
    protected $aQuantification;

    /**
     * @var        PropelObjectCollection|ElementresultRelationship[] Collection to store aggregation of ElementresultRelationship objects.
     */
    protected $collElementresultRelationshipsRelatedByObjectId;
    protected $collElementresultRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|ElementresultRelationship[] Collection to store aggregation of ElementresultRelationship objects.
     */
    protected $collElementresultRelationshipsRelatedBySubjectId;
    protected $collElementresultRelationshipsRelatedBySubjectIdPartial;

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
    protected $elementresultRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * Get the [elementresult_id] column value.
     *
     * @return int
     */
    public function getElementresultId()
    {
        return $this->elementresult_id;
    }

    /**
     * Get the [element_id] column value.
     *
     * @return int
     */
    public function getElementId()
    {
        return $this->element_id;
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
     * Get the [signal] column value.
     *
     * @return double
     */
    public function getSignal()
    {
        return $this->signal;
    }

    /**
     * Set the value of [elementresult_id] column.
     *
     * @param int $v new value
     * @return Elementresult The current object (for fluent API support)
     */
    public function setElementresultId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->elementresult_id !== $v) {
            $this->elementresult_id = $v;
            $this->modifiedColumns[] = ElementresultPeer::ELEMENTRESULT_ID;
        }


        return $this;
    } // setElementresultId()

    /**
     * Set the value of [element_id] column.
     *
     * @param int $v new value
     * @return Elementresult The current object (for fluent API support)
     */
    public function setElementId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->element_id !== $v) {
            $this->element_id = $v;
            $this->modifiedColumns[] = ElementresultPeer::ELEMENT_ID;
        }

        if ($this->aElement !== null && $this->aElement->getElementId() !== $v) {
            $this->aElement = null;
        }


        return $this;
    } // setElementId()

    /**
     * Set the value of [quantification_id] column.
     *
     * @param int $v new value
     * @return Elementresult The current object (for fluent API support)
     */
    public function setQuantificationId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->quantification_id !== $v) {
            $this->quantification_id = $v;
            $this->modifiedColumns[] = ElementresultPeer::QUANTIFICATION_ID;
        }

        if ($this->aQuantification !== null && $this->aQuantification->getQuantificationId() !== $v) {
            $this->aQuantification = null;
        }


        return $this;
    } // setQuantificationId()

    /**
     * Set the value of [signal] column.
     *
     * @param double $v new value
     * @return Elementresult The current object (for fluent API support)
     */
    public function setSignal($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->signal !== $v) {
            $this->signal = $v;
            $this->modifiedColumns[] = ElementresultPeer::SIGNAL;
        }


        return $this;
    } // setSignal()

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

            $this->elementresult_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->element_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->quantification_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->signal = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 4; // 4 = ElementresultPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Elementresult object", $e);
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

        if ($this->aElement !== null && $this->element_id !== $this->aElement->getElementId()) {
            $this->aElement = null;
        }
        if ($this->aQuantification !== null && $this->quantification_id !== $this->aQuantification->getQuantificationId()) {
            $this->aQuantification = null;
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
            $con = Propel::getConnection(ElementresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ElementresultPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aElement = null;
            $this->aQuantification = null;
            $this->collElementresultRelationshipsRelatedByObjectId = null;

            $this->collElementresultRelationshipsRelatedBySubjectId = null;

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
            $con = Propel::getConnection(ElementresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ElementresultQuery::create()
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
            $con = Propel::getConnection(ElementresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ElementresultPeer::addInstanceToPool($this);
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

            if ($this->aElement !== null) {
                if ($this->aElement->isModified() || $this->aElement->isNew()) {
                    $affectedRows += $this->aElement->save($con);
                }
                $this->setElement($this->aElement);
            }

            if ($this->aQuantification !== null) {
                if ($this->aQuantification->isModified() || $this->aQuantification->isNew()) {
                    $affectedRows += $this->aQuantification->save($con);
                }
                $this->setQuantification($this->aQuantification);
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

            if ($this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    ElementresultRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collElementresultRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collElementresultRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    ElementresultRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collElementresultRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collElementresultRelationshipsRelatedBySubjectId as $referrerFK) {
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

        $this->modifiedColumns[] = ElementresultPeer::ELEMENTRESULT_ID;
        if (null !== $this->elementresult_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ElementresultPeer::ELEMENTRESULT_ID . ')');
        }
        if (null === $this->elementresult_id) {
            try {
                $stmt = $con->query("SELECT nextval('elementresult_elementresult_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->elementresult_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ElementresultPeer::ELEMENTRESULT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"elementresult_id"';
        }
        if ($this->isColumnModified(ElementresultPeer::ELEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"element_id"';
        }
        if ($this->isColumnModified(ElementresultPeer::QUANTIFICATION_ID)) {
            $modifiedColumns[':p' . $index++]  = '"quantification_id"';
        }
        if ($this->isColumnModified(ElementresultPeer::SIGNAL)) {
            $modifiedColumns[':p' . $index++]  = '"signal"';
        }

        $sql = sprintf(
            'INSERT INTO "elementresult" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"elementresult_id"':
                        $stmt->bindValue($identifier, $this->elementresult_id, PDO::PARAM_INT);
                        break;
                    case '"element_id"':
                        $stmt->bindValue($identifier, $this->element_id, PDO::PARAM_INT);
                        break;
                    case '"quantification_id"':
                        $stmt->bindValue($identifier, $this->quantification_id, PDO::PARAM_INT);
                        break;
                    case '"signal"':
                        $stmt->bindValue($identifier, $this->signal, PDO::PARAM_STR);
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

            if ($this->aElement !== null) {
                if (!$this->aElement->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aElement->getValidationFailures());
                }
            }

            if ($this->aQuantification !== null) {
                if (!$this->aQuantification->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aQuantification->getValidationFailures());
                }
            }


            if (($retval = ElementresultPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collElementresultRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collElementresultRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElementresultRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collElementresultRelationshipsRelatedBySubjectId as $referrerFK) {
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
        $pos = ElementresultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getElementresultId();
                break;
            case 1:
                return $this->getElementId();
                break;
            case 2:
                return $this->getQuantificationId();
                break;
            case 3:
                return $this->getSignal();
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
        if (isset($alreadyDumpedObjects['Elementresult'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Elementresult'][$this->getPrimaryKey()] = true;
        $keys = ElementresultPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getElementresultId(),
            $keys[1] => $this->getElementId(),
            $keys[2] => $this->getQuantificationId(),
            $keys[3] => $this->getSignal(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aElement) {
                $result['Element'] = $this->aElement->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aQuantification) {
                $result['Quantification'] = $this->aQuantification->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collElementresultRelationshipsRelatedByObjectId) {
                $result['ElementresultRelationshipsRelatedByObjectId'] = $this->collElementresultRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementresultRelationshipsRelatedBySubjectId) {
                $result['ElementresultRelationshipsRelatedBySubjectId'] = $this->collElementresultRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ElementresultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setElementresultId($value);
                break;
            case 1:
                $this->setElementId($value);
                break;
            case 2:
                $this->setQuantificationId($value);
                break;
            case 3:
                $this->setSignal($value);
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
        $keys = ElementresultPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setElementresultId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setElementId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setQuantificationId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSignal($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ElementresultPeer::DATABASE_NAME);

        if ($this->isColumnModified(ElementresultPeer::ELEMENTRESULT_ID)) $criteria->add(ElementresultPeer::ELEMENTRESULT_ID, $this->elementresult_id);
        if ($this->isColumnModified(ElementresultPeer::ELEMENT_ID)) $criteria->add(ElementresultPeer::ELEMENT_ID, $this->element_id);
        if ($this->isColumnModified(ElementresultPeer::QUANTIFICATION_ID)) $criteria->add(ElementresultPeer::QUANTIFICATION_ID, $this->quantification_id);
        if ($this->isColumnModified(ElementresultPeer::SIGNAL)) $criteria->add(ElementresultPeer::SIGNAL, $this->signal);

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
        $criteria = new Criteria(ElementresultPeer::DATABASE_NAME);
        $criteria->add(ElementresultPeer::ELEMENTRESULT_ID, $this->elementresult_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getElementresultId();
    }

    /**
     * Generic method to set the primary key (elementresult_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setElementresultId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getElementresultId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Elementresult (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setElementId($this->getElementId());
        $copyObj->setQuantificationId($this->getQuantificationId());
        $copyObj->setSignal($this->getSignal());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getElementresultRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementresultRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementresultRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementresultRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setElementresultId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Elementresult Clone of current object.
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
     * @return ElementresultPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ElementresultPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Element object.
     *
     * @param             Element $v
     * @return Elementresult The current object (for fluent API support)
     * @throws PropelException
     */
    public function setElement(Element $v = null)
    {
        if ($v === null) {
            $this->setElementId(NULL);
        } else {
            $this->setElementId($v->getElementId());
        }

        $this->aElement = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Element object, it will not be re-added.
        if ($v !== null) {
            $v->addElementresult($this);
        }


        return $this;
    }


    /**
     * Get the associated Element object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Element The associated Element object.
     * @throws PropelException
     */
    public function getElement(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aElement === null && ($this->element_id !== null) && $doQuery) {
            $this->aElement = ElementQuery::create()->findPk($this->element_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aElement->addElementresults($this);
             */
        }

        return $this->aElement;
    }

    /**
     * Declares an association between this object and a Quantification object.
     *
     * @param             Quantification $v
     * @return Elementresult The current object (for fluent API support)
     * @throws PropelException
     */
    public function setQuantification(Quantification $v = null)
    {
        if ($v === null) {
            $this->setQuantificationId(NULL);
        } else {
            $this->setQuantificationId($v->getQuantificationId());
        }

        $this->aQuantification = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Quantification object, it will not be re-added.
        if ($v !== null) {
            $v->addElementresult($this);
        }


        return $this;
    }


    /**
     * Get the associated Quantification object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Quantification The associated Quantification object.
     * @throws PropelException
     */
    public function getQuantification(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aQuantification === null && ($this->quantification_id !== null) && $doQuery) {
            $this->aQuantification = QuantificationQuery::create()->findPk($this->quantification_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aQuantification->addElementresults($this);
             */
        }

        return $this->aQuantification;
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
        if ('ElementresultRelationshipRelatedByObjectId' == $relationName) {
            $this->initElementresultRelationshipsRelatedByObjectId();
        }
        if ('ElementresultRelationshipRelatedBySubjectId' == $relationName) {
            $this->initElementresultRelationshipsRelatedBySubjectId();
        }
    }

    /**
     * Clears out the collElementresultRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Elementresult The current object (for fluent API support)
     * @see        addElementresultRelationshipsRelatedByObjectId()
     */
    public function clearElementresultRelationshipsRelatedByObjectId()
    {
        $this->collElementresultRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collElementresultRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collElementresultRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementresultRelationshipsRelatedByObjectId($v = true)
    {
        $this->collElementresultRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collElementresultRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collElementresultRelationshipsRelatedByObjectId collection to an empty array (like clearcollElementresultRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementresultRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collElementresultRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collElementresultRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collElementresultRelationshipsRelatedByObjectId->setModel('ElementresultRelationship');
    }

    /**
     * Gets an array of ElementresultRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Elementresult is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     * @throws PropelException
     */
    public function getElementresultRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collElementresultRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initElementresultRelationshipsRelatedByObjectId();
            } else {
                $collElementresultRelationshipsRelatedByObjectId = ElementresultRelationshipQuery::create(null, $criteria)
                    ->filterByElementresultRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementresultRelationshipsRelatedByObjectIdPartial && count($collElementresultRelationshipsRelatedByObjectId)) {
                      $this->initElementresultRelationshipsRelatedByObjectId(false);

                      foreach($collElementresultRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collElementresultRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collElementresultRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collElementresultRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collElementresultRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collElementresultRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collElementresultRelationshipsRelatedByObjectId) {
                    foreach($this->collElementresultRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collElementresultRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collElementresultRelationshipsRelatedByObjectId = $collElementresultRelationshipsRelatedByObjectId;
                $this->collElementresultRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collElementresultRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of ElementresultRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementresultRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Elementresult The current object (for fluent API support)
     */
    public function setElementresultRelationshipsRelatedByObjectId(PropelCollection $elementresultRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $elementresultRelationshipsRelatedByObjectIdToDelete = $this->getElementresultRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($elementresultRelationshipsRelatedByObjectId);

        $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($elementresultRelationshipsRelatedByObjectIdToDelete));

        foreach ($elementresultRelationshipsRelatedByObjectIdToDelete as $elementresultRelationshipRelatedByObjectIdRemoved) {
            $elementresultRelationshipRelatedByObjectIdRemoved->setElementresultRelatedByObjectId(null);
        }

        $this->collElementresultRelationshipsRelatedByObjectId = null;
        foreach ($elementresultRelationshipsRelatedByObjectId as $elementresultRelationshipRelatedByObjectId) {
            $this->addElementresultRelationshipRelatedByObjectId($elementresultRelationshipRelatedByObjectId);
        }

        $this->collElementresultRelationshipsRelatedByObjectId = $elementresultRelationshipsRelatedByObjectId;
        $this->collElementresultRelationshipsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementresultRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementresultRelationship objects.
     * @throws PropelException
     */
    public function countElementresultRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collElementresultRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementresultRelationshipsRelatedByObjectId());
            }
            $query = ElementresultRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElementresultRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collElementresultRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a ElementresultRelationship object to this object
     * through the ElementresultRelationship foreign key attribute.
     *
     * @param    ElementresultRelationship $l ElementresultRelationship
     * @return Elementresult The current object (for fluent API support)
     */
    public function addElementresultRelationshipRelatedByObjectId(ElementresultRelationship $l)
    {
        if ($this->collElementresultRelationshipsRelatedByObjectId === null) {
            $this->initElementresultRelationshipsRelatedByObjectId();
            $this->collElementresultRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collElementresultRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementresultRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	ElementresultRelationshipRelatedByObjectId $elementresultRelationshipRelatedByObjectId The elementresultRelationshipRelatedByObjectId object to add.
     */
    protected function doAddElementresultRelationshipRelatedByObjectId($elementresultRelationshipRelatedByObjectId)
    {
        $this->collElementresultRelationshipsRelatedByObjectId[]= $elementresultRelationshipRelatedByObjectId;
        $elementresultRelationshipRelatedByObjectId->setElementresultRelatedByObjectId($this);
    }

    /**
     * @param	ElementresultRelationshipRelatedByObjectId $elementresultRelationshipRelatedByObjectId The elementresultRelationshipRelatedByObjectId object to remove.
     * @return Elementresult The current object (for fluent API support)
     */
    public function removeElementresultRelationshipRelatedByObjectId($elementresultRelationshipRelatedByObjectId)
    {
        if ($this->getElementresultRelationshipsRelatedByObjectId()->contains($elementresultRelationshipRelatedByObjectId)) {
            $this->collElementresultRelationshipsRelatedByObjectId->remove($this->collElementresultRelationshipsRelatedByObjectId->search($elementresultRelationshipRelatedByObjectId));
            if (null === $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collElementresultRelationshipsRelatedByObjectId;
                $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->elementresultRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $elementresultRelationshipRelatedByObjectId;
            $elementresultRelationshipRelatedByObjectId->setElementresultRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Elementresult is new, it will return
     * an empty collection; or if this Elementresult has previously
     * been saved, it will retrieve related ElementresultRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Elementresult.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     */
    public function getElementresultRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElementresultRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collElementresultRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Elementresult The current object (for fluent API support)
     * @see        addElementresultRelationshipsRelatedBySubjectId()
     */
    public function clearElementresultRelationshipsRelatedBySubjectId()
    {
        $this->collElementresultRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collElementresultRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collElementresultRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementresultRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collElementresultRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collElementresultRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collElementresultRelationshipsRelatedBySubjectId collection to an empty array (like clearcollElementresultRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementresultRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collElementresultRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collElementresultRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collElementresultRelationshipsRelatedBySubjectId->setModel('ElementresultRelationship');
    }

    /**
     * Gets an array of ElementresultRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Elementresult is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     * @throws PropelException
     */
    public function getElementresultRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collElementresultRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initElementresultRelationshipsRelatedBySubjectId();
            } else {
                $collElementresultRelationshipsRelatedBySubjectId = ElementresultRelationshipQuery::create(null, $criteria)
                    ->filterByElementresultRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementresultRelationshipsRelatedBySubjectIdPartial && count($collElementresultRelationshipsRelatedBySubjectId)) {
                      $this->initElementresultRelationshipsRelatedBySubjectId(false);

                      foreach($collElementresultRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collElementresultRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collElementresultRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collElementresultRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collElementresultRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collElementresultRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collElementresultRelationshipsRelatedBySubjectId) {
                    foreach($this->collElementresultRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collElementresultRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collElementresultRelationshipsRelatedBySubjectId = $collElementresultRelationshipsRelatedBySubjectId;
                $this->collElementresultRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collElementresultRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of ElementresultRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementresultRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Elementresult The current object (for fluent API support)
     */
    public function setElementresultRelationshipsRelatedBySubjectId(PropelCollection $elementresultRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $elementresultRelationshipsRelatedBySubjectIdToDelete = $this->getElementresultRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($elementresultRelationshipsRelatedBySubjectId);

        $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($elementresultRelationshipsRelatedBySubjectIdToDelete));

        foreach ($elementresultRelationshipsRelatedBySubjectIdToDelete as $elementresultRelationshipRelatedBySubjectIdRemoved) {
            $elementresultRelationshipRelatedBySubjectIdRemoved->setElementresultRelatedBySubjectId(null);
        }

        $this->collElementresultRelationshipsRelatedBySubjectId = null;
        foreach ($elementresultRelationshipsRelatedBySubjectId as $elementresultRelationshipRelatedBySubjectId) {
            $this->addElementresultRelationshipRelatedBySubjectId($elementresultRelationshipRelatedBySubjectId);
        }

        $this->collElementresultRelationshipsRelatedBySubjectId = $elementresultRelationshipsRelatedBySubjectId;
        $this->collElementresultRelationshipsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementresultRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementresultRelationship objects.
     * @throws PropelException
     */
    public function countElementresultRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementresultRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collElementresultRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementresultRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementresultRelationshipsRelatedBySubjectId());
            }
            $query = ElementresultRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElementresultRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collElementresultRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a ElementresultRelationship object to this object
     * through the ElementresultRelationship foreign key attribute.
     *
     * @param    ElementresultRelationship $l ElementresultRelationship
     * @return Elementresult The current object (for fluent API support)
     */
    public function addElementresultRelationshipRelatedBySubjectId(ElementresultRelationship $l)
    {
        if ($this->collElementresultRelationshipsRelatedBySubjectId === null) {
            $this->initElementresultRelationshipsRelatedBySubjectId();
            $this->collElementresultRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collElementresultRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementresultRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	ElementresultRelationshipRelatedBySubjectId $elementresultRelationshipRelatedBySubjectId The elementresultRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddElementresultRelationshipRelatedBySubjectId($elementresultRelationshipRelatedBySubjectId)
    {
        $this->collElementresultRelationshipsRelatedBySubjectId[]= $elementresultRelationshipRelatedBySubjectId;
        $elementresultRelationshipRelatedBySubjectId->setElementresultRelatedBySubjectId($this);
    }

    /**
     * @param	ElementresultRelationshipRelatedBySubjectId $elementresultRelationshipRelatedBySubjectId The elementresultRelationshipRelatedBySubjectId object to remove.
     * @return Elementresult The current object (for fluent API support)
     */
    public function removeElementresultRelationshipRelatedBySubjectId($elementresultRelationshipRelatedBySubjectId)
    {
        if ($this->getElementresultRelationshipsRelatedBySubjectId()->contains($elementresultRelationshipRelatedBySubjectId)) {
            $this->collElementresultRelationshipsRelatedBySubjectId->remove($this->collElementresultRelationshipsRelatedBySubjectId->search($elementresultRelationshipRelatedBySubjectId));
            if (null === $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collElementresultRelationshipsRelatedBySubjectId;
                $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->elementresultRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $elementresultRelationshipRelatedBySubjectId;
            $elementresultRelationshipRelatedBySubjectId->setElementresultRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Elementresult is new, it will return
     * an empty collection; or if this Elementresult has previously
     * been saved, it will retrieve related ElementresultRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Elementresult.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementresultRelationship[] List of ElementresultRelationship objects
     */
    public function getElementresultRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElementresultRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->elementresult_id = null;
        $this->element_id = null;
        $this->quantification_id = null;
        $this->signal = null;
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
            if ($this->collElementresultRelationshipsRelatedByObjectId) {
                foreach ($this->collElementresultRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementresultRelationshipsRelatedBySubjectId) {
                foreach ($this->collElementresultRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aElement instanceof Persistent) {
              $this->aElement->clearAllReferences($deep);
            }
            if ($this->aQuantification instanceof Persistent) {
              $this->aQuantification->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collElementresultRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collElementresultRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collElementresultRelationshipsRelatedByObjectId = null;
        if ($this->collElementresultRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collElementresultRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collElementresultRelationshipsRelatedBySubjectId = null;
        $this->aElement = null;
        $this->aQuantification = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ElementresultPeer::DEFAULT_STRING_FORMAT);
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
