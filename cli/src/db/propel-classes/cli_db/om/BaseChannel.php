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
use cli_db\propel\Acquisition;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayBiomaterialQuery;
use cli_db\propel\Channel;
use cli_db\propel\ChannelPeer;
use cli_db\propel\ChannelQuery;

/**
 * Base class that represents a row from the 'channel' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseChannel extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ChannelPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ChannelPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the channel_id field.
     * @var        int
     */
    protected $channel_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the definition field.
     * @var        string
     */
    protected $definition;

    /**
     * @var        PropelObjectCollection|Acquisition[] Collection to store aggregation of Acquisition objects.
     */
    protected $collAcquisitions;
    protected $collAcquisitionsPartial;

    /**
     * @var        PropelObjectCollection|AssayBiomaterial[] Collection to store aggregation of AssayBiomaterial objects.
     */
    protected $collAssayBiomaterials;
    protected $collAssayBiomaterialsPartial;

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
    protected $acquisitionsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assayBiomaterialsScheduledForDeletion = null;

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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [definition] column value.
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
    }

    /**
     * Set the value of [channel_id] column.
     *
     * @param int $v new value
     * @return Channel The current object (for fluent API support)
     */
    public function setChannelId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->channel_id !== $v) {
            $this->channel_id = $v;
            $this->modifiedColumns[] = ChannelPeer::CHANNEL_ID;
        }


        return $this;
    } // setChannelId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Channel The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ChannelPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [definition] column.
     *
     * @param string $v new value
     * @return Channel The current object (for fluent API support)
     */
    public function setDefinition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->definition !== $v) {
            $this->definition = $v;
            $this->modifiedColumns[] = ChannelPeer::DEFINITION;
        }


        return $this;
    } // setDefinition()

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

            $this->channel_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->definition = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = ChannelPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Channel object", $e);
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
            $con = Propel::getConnection(ChannelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ChannelPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAcquisitions = null;

            $this->collAssayBiomaterials = null;

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
            $con = Propel::getConnection(ChannelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ChannelQuery::create()
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
            $con = Propel::getConnection(ChannelPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ChannelPeer::addInstanceToPool($this);
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

            if ($this->acquisitionsScheduledForDeletion !== null) {
                if (!$this->acquisitionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->acquisitionsScheduledForDeletion as $acquisition) {
                        // need to save related object because we set the relation to null
                        $acquisition->save($con);
                    }
                    $this->acquisitionsScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitions !== null) {
                foreach ($this->collAcquisitions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assayBiomaterialsScheduledForDeletion !== null) {
                if (!$this->assayBiomaterialsScheduledForDeletion->isEmpty()) {
                    foreach ($this->assayBiomaterialsScheduledForDeletion as $assayBiomaterial) {
                        // need to save related object because we set the relation to null
                        $assayBiomaterial->save($con);
                    }
                    $this->assayBiomaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collAssayBiomaterials !== null) {
                foreach ($this->collAssayBiomaterials as $referrerFK) {
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

        $this->modifiedColumns[] = ChannelPeer::CHANNEL_ID;
        if (null !== $this->channel_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ChannelPeer::CHANNEL_ID . ')');
        }
        if (null === $this->channel_id) {
            try {
                $stmt = $con->query("SELECT nextval('channel_channel_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->channel_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ChannelPeer::CHANNEL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"channel_id"';
        }
        if ($this->isColumnModified(ChannelPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ChannelPeer::DEFINITION)) {
            $modifiedColumns[':p' . $index++]  = '"definition"';
        }

        $sql = sprintf(
            'INSERT INTO "channel" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"channel_id"':
                        $stmt->bindValue($identifier, $this->channel_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"definition"':
                        $stmt->bindValue($identifier, $this->definition, PDO::PARAM_STR);
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


            if (($retval = ChannelPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAcquisitions !== null) {
                    foreach ($this->collAcquisitions as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssayBiomaterials !== null) {
                    foreach ($this->collAssayBiomaterials as $referrerFK) {
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
        $pos = ChannelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getChannelId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDefinition();
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
        if (isset($alreadyDumpedObjects['Channel'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Channel'][$this->getPrimaryKey()] = true;
        $keys = ChannelPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getChannelId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDefinition(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collAcquisitions) {
                $result['Acquisitions'] = $this->collAcquisitions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssayBiomaterials) {
                $result['AssayBiomaterials'] = $this->collAssayBiomaterials->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ChannelPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setChannelId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDefinition($value);
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
        $keys = ChannelPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setChannelId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDefinition($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ChannelPeer::DATABASE_NAME);

        if ($this->isColumnModified(ChannelPeer::CHANNEL_ID)) $criteria->add(ChannelPeer::CHANNEL_ID, $this->channel_id);
        if ($this->isColumnModified(ChannelPeer::NAME)) $criteria->add(ChannelPeer::NAME, $this->name);
        if ($this->isColumnModified(ChannelPeer::DEFINITION)) $criteria->add(ChannelPeer::DEFINITION, $this->definition);

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
        $criteria = new Criteria(ChannelPeer::DATABASE_NAME);
        $criteria->add(ChannelPeer::CHANNEL_ID, $this->channel_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getChannelId();
    }

    /**
     * Generic method to set the primary key (channel_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setChannelId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getChannelId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Channel (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDefinition($this->getDefinition());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAcquisitions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisition($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssayBiomaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssayBiomaterial($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setChannelId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Channel Clone of current object.
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
     * @return ChannelPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ChannelPeer();
        }

        return self::$peer;
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
        if ('Acquisition' == $relationName) {
            $this->initAcquisitions();
        }
        if ('AssayBiomaterial' == $relationName) {
            $this->initAssayBiomaterials();
        }
    }

    /**
     * Clears out the collAcquisitions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Channel The current object (for fluent API support)
     * @see        addAcquisitions()
     */
    public function clearAcquisitions()
    {
        $this->collAcquisitions = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionsPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitions collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitions($v = true)
    {
        $this->collAcquisitionsPartial = $v;
    }

    /**
     * Initializes the collAcquisitions collection.
     *
     * By default this just sets the collAcquisitions collection to an empty array (like clearcollAcquisitions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitions($overrideExisting = true)
    {
        if (null !== $this->collAcquisitions && !$overrideExisting) {
            return;
        }
        $this->collAcquisitions = new PropelObjectCollection();
        $this->collAcquisitions->setModel('Acquisition');
    }

    /**
     * Gets an array of Acquisition objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Channel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     * @throws PropelException
     */
    public function getAcquisitions($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionsPartial && !$this->isNew();
        if (null === $this->collAcquisitions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitions) {
                // return empty collection
                $this->initAcquisitions();
            } else {
                $collAcquisitions = AcquisitionQuery::create(null, $criteria)
                    ->filterByChannel($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionsPartial && count($collAcquisitions)) {
                      $this->initAcquisitions(false);

                      foreach($collAcquisitions as $obj) {
                        if (false == $this->collAcquisitions->contains($obj)) {
                          $this->collAcquisitions->append($obj);
                        }
                      }

                      $this->collAcquisitionsPartial = true;
                    }

                    $collAcquisitions->getInternalIterator()->rewind();
                    return $collAcquisitions;
                }

                if($partial && $this->collAcquisitions) {
                    foreach($this->collAcquisitions as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitions[] = $obj;
                        }
                    }
                }

                $this->collAcquisitions = $collAcquisitions;
                $this->collAcquisitionsPartial = false;
            }
        }

        return $this->collAcquisitions;
    }

    /**
     * Sets a collection of Acquisition objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitions A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Channel The current object (for fluent API support)
     */
    public function setAcquisitions(PropelCollection $acquisitions, PropelPDO $con = null)
    {
        $acquisitionsToDelete = $this->getAcquisitions(new Criteria(), $con)->diff($acquisitions);

        $this->acquisitionsScheduledForDeletion = unserialize(serialize($acquisitionsToDelete));

        foreach ($acquisitionsToDelete as $acquisitionRemoved) {
            $acquisitionRemoved->setChannel(null);
        }

        $this->collAcquisitions = null;
        foreach ($acquisitions as $acquisition) {
            $this->addAcquisition($acquisition);
        }

        $this->collAcquisitions = $acquisitions;
        $this->collAcquisitionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Acquisition objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Acquisition objects.
     * @throws PropelException
     */
    public function countAcquisitions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionsPartial && !$this->isNew();
        if (null === $this->collAcquisitions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitions) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitions());
            }
            $query = AcquisitionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChannel($this)
                ->count($con);
        }

        return count($this->collAcquisitions);
    }

    /**
     * Method called to associate a Acquisition object to this object
     * through the Acquisition foreign key attribute.
     *
     * @param    Acquisition $l Acquisition
     * @return Channel The current object (for fluent API support)
     */
    public function addAcquisition(Acquisition $l)
    {
        if ($this->collAcquisitions === null) {
            $this->initAcquisitions();
            $this->collAcquisitionsPartial = true;
        }
        if (!in_array($l, $this->collAcquisitions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisition($l);
        }

        return $this;
    }

    /**
     * @param	Acquisition $acquisition The acquisition object to add.
     */
    protected function doAddAcquisition($acquisition)
    {
        $this->collAcquisitions[]= $acquisition;
        $acquisition->setChannel($this);
    }

    /**
     * @param	Acquisition $acquisition The acquisition object to remove.
     * @return Channel The current object (for fluent API support)
     */
    public function removeAcquisition($acquisition)
    {
        if ($this->getAcquisitions()->contains($acquisition)) {
            $this->collAcquisitions->remove($this->collAcquisitions->search($acquisition));
            if (null === $this->acquisitionsScheduledForDeletion) {
                $this->acquisitionsScheduledForDeletion = clone $this->collAcquisitions;
                $this->acquisitionsScheduledForDeletion->clear();
            }
            $this->acquisitionsScheduledForDeletion[]= $acquisition;
            $acquisition->setChannel(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related Acquisitions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     */
    public function getAcquisitionsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAcquisitions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related Acquisitions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     */
    public function getAcquisitionsJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getAcquisitions($query, $con);
    }

    /**
     * Clears out the collAssayBiomaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Channel The current object (for fluent API support)
     * @see        addAssayBiomaterials()
     */
    public function clearAssayBiomaterials()
    {
        $this->collAssayBiomaterials = null; // important to set this to null since that means it is uninitialized
        $this->collAssayBiomaterialsPartial = null;

        return $this;
    }

    /**
     * reset is the collAssayBiomaterials collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssayBiomaterials($v = true)
    {
        $this->collAssayBiomaterialsPartial = $v;
    }

    /**
     * Initializes the collAssayBiomaterials collection.
     *
     * By default this just sets the collAssayBiomaterials collection to an empty array (like clearcollAssayBiomaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssayBiomaterials($overrideExisting = true)
    {
        if (null !== $this->collAssayBiomaterials && !$overrideExisting) {
            return;
        }
        $this->collAssayBiomaterials = new PropelObjectCollection();
        $this->collAssayBiomaterials->setModel('AssayBiomaterial');
    }

    /**
     * Gets an array of AssayBiomaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Channel is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssayBiomaterial[] List of AssayBiomaterial objects
     * @throws PropelException
     */
    public function getAssayBiomaterials($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssayBiomaterialsPartial && !$this->isNew();
        if (null === $this->collAssayBiomaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssayBiomaterials) {
                // return empty collection
                $this->initAssayBiomaterials();
            } else {
                $collAssayBiomaterials = AssayBiomaterialQuery::create(null, $criteria)
                    ->filterByChannel($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssayBiomaterialsPartial && count($collAssayBiomaterials)) {
                      $this->initAssayBiomaterials(false);

                      foreach($collAssayBiomaterials as $obj) {
                        if (false == $this->collAssayBiomaterials->contains($obj)) {
                          $this->collAssayBiomaterials->append($obj);
                        }
                      }

                      $this->collAssayBiomaterialsPartial = true;
                    }

                    $collAssayBiomaterials->getInternalIterator()->rewind();
                    return $collAssayBiomaterials;
                }

                if($partial && $this->collAssayBiomaterials) {
                    foreach($this->collAssayBiomaterials as $obj) {
                        if($obj->isNew()) {
                            $collAssayBiomaterials[] = $obj;
                        }
                    }
                }

                $this->collAssayBiomaterials = $collAssayBiomaterials;
                $this->collAssayBiomaterialsPartial = false;
            }
        }

        return $this->collAssayBiomaterials;
    }

    /**
     * Sets a collection of AssayBiomaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assayBiomaterials A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Channel The current object (for fluent API support)
     */
    public function setAssayBiomaterials(PropelCollection $assayBiomaterials, PropelPDO $con = null)
    {
        $assayBiomaterialsToDelete = $this->getAssayBiomaterials(new Criteria(), $con)->diff($assayBiomaterials);

        $this->assayBiomaterialsScheduledForDeletion = unserialize(serialize($assayBiomaterialsToDelete));

        foreach ($assayBiomaterialsToDelete as $assayBiomaterialRemoved) {
            $assayBiomaterialRemoved->setChannel(null);
        }

        $this->collAssayBiomaterials = null;
        foreach ($assayBiomaterials as $assayBiomaterial) {
            $this->addAssayBiomaterial($assayBiomaterial);
        }

        $this->collAssayBiomaterials = $assayBiomaterials;
        $this->collAssayBiomaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssayBiomaterial objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AssayBiomaterial objects.
     * @throws PropelException
     */
    public function countAssayBiomaterials(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssayBiomaterialsPartial && !$this->isNew();
        if (null === $this->collAssayBiomaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssayBiomaterials) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAssayBiomaterials());
            }
            $query = AssayBiomaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByChannel($this)
                ->count($con);
        }

        return count($this->collAssayBiomaterials);
    }

    /**
     * Method called to associate a AssayBiomaterial object to this object
     * through the AssayBiomaterial foreign key attribute.
     *
     * @param    AssayBiomaterial $l AssayBiomaterial
     * @return Channel The current object (for fluent API support)
     */
    public function addAssayBiomaterial(AssayBiomaterial $l)
    {
        if ($this->collAssayBiomaterials === null) {
            $this->initAssayBiomaterials();
            $this->collAssayBiomaterialsPartial = true;
        }
        if (!in_array($l, $this->collAssayBiomaterials->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssayBiomaterial($l);
        }

        return $this;
    }

    /**
     * @param	AssayBiomaterial $assayBiomaterial The assayBiomaterial object to add.
     */
    protected function doAddAssayBiomaterial($assayBiomaterial)
    {
        $this->collAssayBiomaterials[]= $assayBiomaterial;
        $assayBiomaterial->setChannel($this);
    }

    /**
     * @param	AssayBiomaterial $assayBiomaterial The assayBiomaterial object to remove.
     * @return Channel The current object (for fluent API support)
     */
    public function removeAssayBiomaterial($assayBiomaterial)
    {
        if ($this->getAssayBiomaterials()->contains($assayBiomaterial)) {
            $this->collAssayBiomaterials->remove($this->collAssayBiomaterials->search($assayBiomaterial));
            if (null === $this->assayBiomaterialsScheduledForDeletion) {
                $this->assayBiomaterialsScheduledForDeletion = clone $this->collAssayBiomaterials;
                $this->assayBiomaterialsScheduledForDeletion->clear();
            }
            $this->assayBiomaterialsScheduledForDeletion[]= $assayBiomaterial;
            $assayBiomaterial->setChannel(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related AssayBiomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssayBiomaterial[] List of AssayBiomaterial objects
     */
    public function getAssayBiomaterialsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayBiomaterialQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAssayBiomaterials($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Channel is new, it will return
     * an empty collection; or if this Channel has previously
     * been saved, it will retrieve related AssayBiomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Channel.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssayBiomaterial[] List of AssayBiomaterial objects
     */
    public function getAssayBiomaterialsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayBiomaterialQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getAssayBiomaterials($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->channel_id = null;
        $this->name = null;
        $this->definition = null;
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
            if ($this->collAcquisitions) {
                foreach ($this->collAcquisitions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssayBiomaterials) {
                foreach ($this->collAssayBiomaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAcquisitions instanceof PropelCollection) {
            $this->collAcquisitions->clearIterator();
        }
        $this->collAcquisitions = null;
        if ($this->collAssayBiomaterials instanceof PropelCollection) {
            $this->collAssayBiomaterials->clearIterator();
        }
        $this->collAssayBiomaterials = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ChannelPeer::DEFAULT_STRING_FORMAT);
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
