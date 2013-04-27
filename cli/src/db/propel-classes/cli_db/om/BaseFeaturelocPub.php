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
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocPub;
use cli_db\propel\FeaturelocPubPeer;
use cli_db\propel\FeaturelocPubQuery;
use cli_db\propel\FeaturelocQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;

/**
 * Base class that represents a row from the 'featureloc_pub' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeaturelocPub extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeaturelocPubPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeaturelocPubPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the featureloc_pub_id field.
     * @var        int
     */
    protected $featureloc_pub_id;

    /**
     * The value for the featureloc_id field.
     * @var        int
     */
    protected $featureloc_id;

    /**
     * The value for the pub_id field.
     * @var        int
     */
    protected $pub_id;

    /**
     * @var        Featureloc
     */
    protected $aFeatureloc;

    /**
     * @var        Pub
     */
    protected $aPub;

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
     * Get the [featureloc_pub_id] column value.
     *
     * @return int
     */
    public function getFeaturelocPubId()
    {
        return $this->featureloc_pub_id;
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
     * Get the [pub_id] column value.
     *
     * @return int
     */
    public function getPubId()
    {
        return $this->pub_id;
    }

    /**
     * Set the value of [featureloc_pub_id] column.
     *
     * @param int $v new value
     * @return FeaturelocPub The current object (for fluent API support)
     */
    public function setFeaturelocPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->featureloc_pub_id !== $v) {
            $this->featureloc_pub_id = $v;
            $this->modifiedColumns[] = FeaturelocPubPeer::FEATURELOC_PUB_ID;
        }


        return $this;
    } // setFeaturelocPubId()

    /**
     * Set the value of [featureloc_id] column.
     *
     * @param int $v new value
     * @return FeaturelocPub The current object (for fluent API support)
     */
    public function setFeaturelocId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->featureloc_id !== $v) {
            $this->featureloc_id = $v;
            $this->modifiedColumns[] = FeaturelocPubPeer::FEATURELOC_ID;
        }

        if ($this->aFeatureloc !== null && $this->aFeatureloc->getFeaturelocId() !== $v) {
            $this->aFeatureloc = null;
        }


        return $this;
    } // setFeaturelocId()

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return FeaturelocPub The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = FeaturelocPubPeer::PUB_ID;
        }

        if ($this->aPub !== null && $this->aPub->getPubId() !== $v) {
            $this->aPub = null;
        }


        return $this;
    } // setPubId()

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

            $this->featureloc_pub_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->featureloc_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->pub_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = FeaturelocPubPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating FeaturelocPub object", $e);
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

        if ($this->aFeatureloc !== null && $this->featureloc_id !== $this->aFeatureloc->getFeaturelocId()) {
            $this->aFeatureloc = null;
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
            $con = Propel::getConnection(FeaturelocPubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeaturelocPubPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFeatureloc = null;
            $this->aPub = null;
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
            $con = Propel::getConnection(FeaturelocPubPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeaturelocPubQuery::create()
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
            $con = Propel::getConnection(FeaturelocPubPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeaturelocPubPeer::addInstanceToPool($this);
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

            if ($this->aFeatureloc !== null) {
                if ($this->aFeatureloc->isModified() || $this->aFeatureloc->isNew()) {
                    $affectedRows += $this->aFeatureloc->save($con);
                }
                $this->setFeatureloc($this->aFeatureloc);
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

        $this->modifiedColumns[] = FeaturelocPubPeer::FEATURELOC_PUB_ID;
        if (null !== $this->featureloc_pub_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeaturelocPubPeer::FEATURELOC_PUB_ID . ')');
        }
        if (null === $this->featureloc_pub_id) {
            try {
                $stmt = $con->query("SELECT nextval('featureloc_pub_featureloc_pub_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->featureloc_pub_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeaturelocPubPeer::FEATURELOC_PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"featureloc_pub_id"';
        }
        if ($this->isColumnModified(FeaturelocPubPeer::FEATURELOC_ID)) {
            $modifiedColumns[':p' . $index++]  = '"featureloc_id"';
        }
        if ($this->isColumnModified(FeaturelocPubPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }

        $sql = sprintf(
            'INSERT INTO "featureloc_pub" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"featureloc_pub_id"':
                        $stmt->bindValue($identifier, $this->featureloc_pub_id, PDO::PARAM_INT);
                        break;
                    case '"featureloc_id"':
                        $stmt->bindValue($identifier, $this->featureloc_id, PDO::PARAM_INT);
                        break;
                    case '"pub_id"':
                        $stmt->bindValue($identifier, $this->pub_id, PDO::PARAM_INT);
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

            if ($this->aFeatureloc !== null) {
                if (!$this->aFeatureloc->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeatureloc->getValidationFailures());
                }
            }

            if ($this->aPub !== null) {
                if (!$this->aPub->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPub->getValidationFailures());
                }
            }


            if (($retval = FeaturelocPubPeer::doValidate($this, $columns)) !== true) {
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
        $pos = FeaturelocPubPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeaturelocPubId();
                break;
            case 1:
                return $this->getFeaturelocId();
                break;
            case 2:
                return $this->getPubId();
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
        if (isset($alreadyDumpedObjects['FeaturelocPub'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FeaturelocPub'][$this->getPrimaryKey()] = true;
        $keys = FeaturelocPubPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeaturelocPubId(),
            $keys[1] => $this->getFeaturelocId(),
            $keys[2] => $this->getPubId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aFeatureloc) {
                $result['Featureloc'] = $this->aFeatureloc->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPub) {
                $result['Pub'] = $this->aPub->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = FeaturelocPubPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeaturelocPubId($value);
                break;
            case 1:
                $this->setFeaturelocId($value);
                break;
            case 2:
                $this->setPubId($value);
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
        $keys = FeaturelocPubPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeaturelocPubId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeaturelocId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPubId($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeaturelocPubPeer::DATABASE_NAME);

        if ($this->isColumnModified(FeaturelocPubPeer::FEATURELOC_PUB_ID)) $criteria->add(FeaturelocPubPeer::FEATURELOC_PUB_ID, $this->featureloc_pub_id);
        if ($this->isColumnModified(FeaturelocPubPeer::FEATURELOC_ID)) $criteria->add(FeaturelocPubPeer::FEATURELOC_ID, $this->featureloc_id);
        if ($this->isColumnModified(FeaturelocPubPeer::PUB_ID)) $criteria->add(FeaturelocPubPeer::PUB_ID, $this->pub_id);

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
        $criteria = new Criteria(FeaturelocPubPeer::DATABASE_NAME);
        $criteria->add(FeaturelocPubPeer::FEATURELOC_PUB_ID, $this->featureloc_pub_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeaturelocPubId();
    }

    /**
     * Generic method to set the primary key (featureloc_pub_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeaturelocPubId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeaturelocPubId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of FeaturelocPub (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeaturelocId($this->getFeaturelocId());
        $copyObj->setPubId($this->getPubId());

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
            $copyObj->setFeaturelocPubId(NULL); // this is a auto-increment column, so set to default value
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
     * @return FeaturelocPub Clone of current object.
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
     * @return FeaturelocPubPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeaturelocPubPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Featureloc object.
     *
     * @param             Featureloc $v
     * @return FeaturelocPub The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFeatureloc(Featureloc $v = null)
    {
        if ($v === null) {
            $this->setFeaturelocId(NULL);
        } else {
            $this->setFeaturelocId($v->getFeaturelocId());
        }

        $this->aFeatureloc = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Featureloc object, it will not be re-added.
        if ($v !== null) {
            $v->addFeaturelocPub($this);
        }


        return $this;
    }


    /**
     * Get the associated Featureloc object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Featureloc The associated Featureloc object.
     * @throws PropelException
     */
    public function getFeatureloc(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFeatureloc === null && ($this->featureloc_id !== null) && $doQuery) {
            $this->aFeatureloc = FeaturelocQuery::create()->findPk($this->featureloc_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFeatureloc->addFeaturelocPubs($this);
             */
        }

        return $this->aFeatureloc;
    }

    /**
     * Declares an association between this object and a Pub object.
     *
     * @param             Pub $v
     * @return FeaturelocPub The current object (for fluent API support)
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
            $v->addFeaturelocPub($this);
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
                $this->aPub->addFeaturelocPubs($this);
             */
        }

        return $this->aPub;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->featureloc_pub_id = null;
        $this->featureloc_id = null;
        $this->pub_id = null;
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
            if ($this->aFeatureloc instanceof Persistent) {
              $this->aFeatureloc->clearAllReferences($deep);
            }
            if ($this->aPub instanceof Persistent) {
              $this->aPub->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aFeatureloc = null;
        $this->aPub = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeaturelocPubPeer::DEFAULT_STRING_FORMAT);
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
