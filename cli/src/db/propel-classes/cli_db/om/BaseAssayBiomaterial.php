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
use cli_db\propel\Assay;
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayBiomaterialPeer;
use cli_db\propel\AssayBiomaterialQuery;
use cli_db\propel\AssayQuery;
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialQuery;

/**
 * Base class that represents a row from the 'assay_biomaterial' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAssayBiomaterial extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\AssayBiomaterialPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AssayBiomaterialPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the assay_biomaterial_id field.
     * @var        int
     */
    protected $assay_biomaterial_id;

    /**
     * The value for the assay_id field.
     * @var        int
     */
    protected $assay_id;

    /**
     * The value for the biomaterial_id field.
     * @var        int
     */
    protected $biomaterial_id;

    /**
     * The value for the channel_id field.
     * @var        int
     */
    protected $channel_id;

    /**
     * The value for the rank field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $rank;

    /**
     * @var        Assay
     */
    protected $aAssay;

    /**
     * @var        Biomaterial
     */
    protected $aBiomaterial;

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
     * Initializes internal state of BaseAssayBiomaterial object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [assay_biomaterial_id] column value.
     *
     * @return int
     */
    public function getAssayBiomaterialId()
    {
        return $this->assay_biomaterial_id;
    }

    /**
     * Get the [assay_id] column value.
     *
     * @return int
     */
    public function getAssayId()
    {
        return $this->assay_id;
    }

    /**
     * Get the [biomaterial_id] column value.
     *
     * @return int
     */
    public function getBiomaterialId()
    {
        return $this->biomaterial_id;
    }

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
     * Get the [rank] column value.
     *
     * @return int
     */
    public function getRank()
    {
        return $this->rank;
    }

    /**
     * Set the value of [assay_biomaterial_id] column.
     *
     * @param int $v new value
     * @return AssayBiomaterial The current object (for fluent API support)
     */
    public function setAssayBiomaterialId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->assay_biomaterial_id !== $v) {
            $this->assay_biomaterial_id = $v;
            $this->modifiedColumns[] = AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID;
        }


        return $this;
    } // setAssayBiomaterialId()

    /**
     * Set the value of [assay_id] column.
     *
     * @param int $v new value
     * @return AssayBiomaterial The current object (for fluent API support)
     */
    public function setAssayId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->assay_id !== $v) {
            $this->assay_id = $v;
            $this->modifiedColumns[] = AssayBiomaterialPeer::ASSAY_ID;
        }

        if ($this->aAssay !== null && $this->aAssay->getAssayId() !== $v) {
            $this->aAssay = null;
        }


        return $this;
    } // setAssayId()

    /**
     * Set the value of [biomaterial_id] column.
     *
     * @param int $v new value
     * @return AssayBiomaterial The current object (for fluent API support)
     */
    public function setBiomaterialId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->biomaterial_id !== $v) {
            $this->biomaterial_id = $v;
            $this->modifiedColumns[] = AssayBiomaterialPeer::BIOMATERIAL_ID;
        }

        if ($this->aBiomaterial !== null && $this->aBiomaterial->getBiomaterialId() !== $v) {
            $this->aBiomaterial = null;
        }


        return $this;
    } // setBiomaterialId()

    /**
     * Set the value of [channel_id] column.
     *
     * @param int $v new value
     * @return AssayBiomaterial The current object (for fluent API support)
     */
    public function setChannelId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->channel_id !== $v) {
            $this->channel_id = $v;
            $this->modifiedColumns[] = AssayBiomaterialPeer::CHANNEL_ID;
        }


        return $this;
    } // setChannelId()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return AssayBiomaterial The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = AssayBiomaterialPeer::RANK;
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

            $this->assay_biomaterial_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->assay_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->biomaterial_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->channel_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->rank = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = AssayBiomaterialPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating AssayBiomaterial object", $e);
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

        if ($this->aAssay !== null && $this->assay_id !== $this->aAssay->getAssayId()) {
            $this->aAssay = null;
        }
        if ($this->aBiomaterial !== null && $this->biomaterial_id !== $this->aBiomaterial->getBiomaterialId()) {
            $this->aBiomaterial = null;
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
            $con = Propel::getConnection(AssayBiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AssayBiomaterialPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAssay = null;
            $this->aBiomaterial = null;
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
            $con = Propel::getConnection(AssayBiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AssayBiomaterialQuery::create()
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
            $con = Propel::getConnection(AssayBiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AssayBiomaterialPeer::addInstanceToPool($this);
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

            if ($this->aAssay !== null) {
                if ($this->aAssay->isModified() || $this->aAssay->isNew()) {
                    $affectedRows += $this->aAssay->save($con);
                }
                $this->setAssay($this->aAssay);
            }

            if ($this->aBiomaterial !== null) {
                if ($this->aBiomaterial->isModified() || $this->aBiomaterial->isNew()) {
                    $affectedRows += $this->aBiomaterial->save($con);
                }
                $this->setBiomaterial($this->aBiomaterial);
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

        $this->modifiedColumns[] = AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID;
        if (null !== $this->assay_biomaterial_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID . ')');
        }
        if (null === $this->assay_biomaterial_id) {
            try {
                $stmt = $con->query("SELECT nextval('assay_biomaterial_assay_biomaterial_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->assay_biomaterial_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"assay_biomaterial_id"';
        }
        if ($this->isColumnModified(AssayBiomaterialPeer::ASSAY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"assay_id"';
        }
        if ($this->isColumnModified(AssayBiomaterialPeer::BIOMATERIAL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"biomaterial_id"';
        }
        if ($this->isColumnModified(AssayBiomaterialPeer::CHANNEL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"channel_id"';
        }
        if ($this->isColumnModified(AssayBiomaterialPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "assay_biomaterial" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"assay_biomaterial_id"':
                        $stmt->bindValue($identifier, $this->assay_biomaterial_id, PDO::PARAM_INT);
                        break;
                    case '"assay_id"':
                        $stmt->bindValue($identifier, $this->assay_id, PDO::PARAM_INT);
                        break;
                    case '"biomaterial_id"':
                        $stmt->bindValue($identifier, $this->biomaterial_id, PDO::PARAM_INT);
                        break;
                    case '"channel_id"':
                        $stmt->bindValue($identifier, $this->channel_id, PDO::PARAM_INT);
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

            if ($this->aAssay !== null) {
                if (!$this->aAssay->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAssay->getValidationFailures());
                }
            }

            if ($this->aBiomaterial !== null) {
                if (!$this->aBiomaterial->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aBiomaterial->getValidationFailures());
                }
            }


            if (($retval = AssayBiomaterialPeer::doValidate($this, $columns)) !== true) {
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
        $pos = AssayBiomaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAssayBiomaterialId();
                break;
            case 1:
                return $this->getAssayId();
                break;
            case 2:
                return $this->getBiomaterialId();
                break;
            case 3:
                return $this->getChannelId();
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
        if (isset($alreadyDumpedObjects['AssayBiomaterial'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['AssayBiomaterial'][$this->getPrimaryKey()] = true;
        $keys = AssayBiomaterialPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAssayBiomaterialId(),
            $keys[1] => $this->getAssayId(),
            $keys[2] => $this->getBiomaterialId(),
            $keys[3] => $this->getChannelId(),
            $keys[4] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAssay) {
                $result['Assay'] = $this->aAssay->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aBiomaterial) {
                $result['Biomaterial'] = $this->aBiomaterial->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = AssayBiomaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAssayBiomaterialId($value);
                break;
            case 1:
                $this->setAssayId($value);
                break;
            case 2:
                $this->setBiomaterialId($value);
                break;
            case 3:
                $this->setChannelId($value);
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
        $keys = AssayBiomaterialPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setAssayBiomaterialId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAssayId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBiomaterialId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setChannelId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setRank($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AssayBiomaterialPeer::DATABASE_NAME);

        if ($this->isColumnModified(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID)) $criteria->add(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $this->assay_biomaterial_id);
        if ($this->isColumnModified(AssayBiomaterialPeer::ASSAY_ID)) $criteria->add(AssayBiomaterialPeer::ASSAY_ID, $this->assay_id);
        if ($this->isColumnModified(AssayBiomaterialPeer::BIOMATERIAL_ID)) $criteria->add(AssayBiomaterialPeer::BIOMATERIAL_ID, $this->biomaterial_id);
        if ($this->isColumnModified(AssayBiomaterialPeer::CHANNEL_ID)) $criteria->add(AssayBiomaterialPeer::CHANNEL_ID, $this->channel_id);
        if ($this->isColumnModified(AssayBiomaterialPeer::RANK)) $criteria->add(AssayBiomaterialPeer::RANK, $this->rank);

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
        $criteria = new Criteria(AssayBiomaterialPeer::DATABASE_NAME);
        $criteria->add(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $this->assay_biomaterial_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getAssayBiomaterialId();
    }

    /**
     * Generic method to set the primary key (assay_biomaterial_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAssayBiomaterialId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getAssayBiomaterialId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of AssayBiomaterial (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAssayId($this->getAssayId());
        $copyObj->setBiomaterialId($this->getBiomaterialId());
        $copyObj->setChannelId($this->getChannelId());
        $copyObj->setRank($this->getRank());

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
            $copyObj->setAssayBiomaterialId(NULL); // this is a auto-increment column, so set to default value
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
     * @return AssayBiomaterial Clone of current object.
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
     * @return AssayBiomaterialPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AssayBiomaterialPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Assay object.
     *
     * @param             Assay $v
     * @return AssayBiomaterial The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAssay(Assay $v = null)
    {
        if ($v === null) {
            $this->setAssayId(NULL);
        } else {
            $this->setAssayId($v->getAssayId());
        }

        $this->aAssay = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Assay object, it will not be re-added.
        if ($v !== null) {
            $v->addAssayBiomaterial($this);
        }


        return $this;
    }


    /**
     * Get the associated Assay object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Assay The associated Assay object.
     * @throws PropelException
     */
    public function getAssay(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAssay === null && ($this->assay_id !== null) && $doQuery) {
            $this->aAssay = AssayQuery::create()->findPk($this->assay_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAssay->addAssayBiomaterials($this);
             */
        }

        return $this->aAssay;
    }

    /**
     * Declares an association between this object and a Biomaterial object.
     *
     * @param             Biomaterial $v
     * @return AssayBiomaterial The current object (for fluent API support)
     * @throws PropelException
     */
    public function setBiomaterial(Biomaterial $v = null)
    {
        if ($v === null) {
            $this->setBiomaterialId(NULL);
        } else {
            $this->setBiomaterialId($v->getBiomaterialId());
        }

        $this->aBiomaterial = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Biomaterial object, it will not be re-added.
        if ($v !== null) {
            $v->addAssayBiomaterial($this);
        }


        return $this;
    }


    /**
     * Get the associated Biomaterial object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Biomaterial The associated Biomaterial object.
     * @throws PropelException
     */
    public function getBiomaterial(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aBiomaterial === null && ($this->biomaterial_id !== null) && $doQuery) {
            $this->aBiomaterial = BiomaterialQuery::create()->findPk($this->biomaterial_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aBiomaterial->addAssayBiomaterials($this);
             */
        }

        return $this->aBiomaterial;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->assay_biomaterial_id = null;
        $this->assay_id = null;
        $this->biomaterial_id = null;
        $this->channel_id = null;
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
            if ($this->aAssay instanceof Persistent) {
              $this->aAssay->clearAllReferences($deep);
            }
            if ($this->aBiomaterial instanceof Persistent) {
              $this->aBiomaterial->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aAssay = null;
        $this->aBiomaterial = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AssayBiomaterialPeer::DEFAULT_STRING_FORMAT);
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
