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
use cli_db\propel\Magedocumentation;
use cli_db\propel\MagedocumentationPeer;
use cli_db\propel\MagedocumentationQuery;
use cli_db\propel\Mageml;
use cli_db\propel\MagemlQuery;
use cli_db\propel\Tableinfo;
use cli_db\propel\TableinfoQuery;

/**
 * Base class that represents a row from the 'magedocumentation' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseMagedocumentation extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\MagedocumentationPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        MagedocumentationPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the magedocumentation_id field.
     * @var        int
     */
    protected $magedocumentation_id;

    /**
     * The value for the mageml_id field.
     * @var        int
     */
    protected $mageml_id;

    /**
     * The value for the tableinfo_id field.
     * @var        int
     */
    protected $tableinfo_id;

    /**
     * The value for the row_id field.
     * @var        int
     */
    protected $row_id;

    /**
     * The value for the mageidentifier field.
     * @var        string
     */
    protected $mageidentifier;

    /**
     * @var        Mageml
     */
    protected $aMageml;

    /**
     * @var        Tableinfo
     */
    protected $aTableinfo;

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
     * Get the [magedocumentation_id] column value.
     *
     * @return int
     */
    public function getMagedocumentationId()
    {
        return $this->magedocumentation_id;
    }

    /**
     * Get the [mageml_id] column value.
     *
     * @return int
     */
    public function getMagemlId()
    {
        return $this->mageml_id;
    }

    /**
     * Get the [tableinfo_id] column value.
     *
     * @return int
     */
    public function getTableinfoId()
    {
        return $this->tableinfo_id;
    }

    /**
     * Get the [row_id] column value.
     *
     * @return int
     */
    public function getRowId()
    {
        return $this->row_id;
    }

    /**
     * Get the [mageidentifier] column value.
     *
     * @return string
     */
    public function getMageidentifier()
    {
        return $this->mageidentifier;
    }

    /**
     * Set the value of [magedocumentation_id] column.
     *
     * @param int $v new value
     * @return Magedocumentation The current object (for fluent API support)
     */
    public function setMagedocumentationId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->magedocumentation_id !== $v) {
            $this->magedocumentation_id = $v;
            $this->modifiedColumns[] = MagedocumentationPeer::MAGEDOCUMENTATION_ID;
        }


        return $this;
    } // setMagedocumentationId()

    /**
     * Set the value of [mageml_id] column.
     *
     * @param int $v new value
     * @return Magedocumentation The current object (for fluent API support)
     */
    public function setMagemlId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->mageml_id !== $v) {
            $this->mageml_id = $v;
            $this->modifiedColumns[] = MagedocumentationPeer::MAGEML_ID;
        }

        if ($this->aMageml !== null && $this->aMageml->getMagemlId() !== $v) {
            $this->aMageml = null;
        }


        return $this;
    } // setMagemlId()

    /**
     * Set the value of [tableinfo_id] column.
     *
     * @param int $v new value
     * @return Magedocumentation The current object (for fluent API support)
     */
    public function setTableinfoId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->tableinfo_id !== $v) {
            $this->tableinfo_id = $v;
            $this->modifiedColumns[] = MagedocumentationPeer::TABLEINFO_ID;
        }

        if ($this->aTableinfo !== null && $this->aTableinfo->getTableinfoId() !== $v) {
            $this->aTableinfo = null;
        }


        return $this;
    } // setTableinfoId()

    /**
     * Set the value of [row_id] column.
     *
     * @param int $v new value
     * @return Magedocumentation The current object (for fluent API support)
     */
    public function setRowId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->row_id !== $v) {
            $this->row_id = $v;
            $this->modifiedColumns[] = MagedocumentationPeer::ROW_ID;
        }


        return $this;
    } // setRowId()

    /**
     * Set the value of [mageidentifier] column.
     *
     * @param string $v new value
     * @return Magedocumentation The current object (for fluent API support)
     */
    public function setMageidentifier($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->mageidentifier !== $v) {
            $this->mageidentifier = $v;
            $this->modifiedColumns[] = MagedocumentationPeer::MAGEIDENTIFIER;
        }


        return $this;
    } // setMageidentifier()

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

            $this->magedocumentation_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->mageml_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->tableinfo_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->row_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->mageidentifier = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = MagedocumentationPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Magedocumentation object", $e);
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

        if ($this->aMageml !== null && $this->mageml_id !== $this->aMageml->getMagemlId()) {
            $this->aMageml = null;
        }
        if ($this->aTableinfo !== null && $this->tableinfo_id !== $this->aTableinfo->getTableinfoId()) {
            $this->aTableinfo = null;
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
            $con = Propel::getConnection(MagedocumentationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = MagedocumentationPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aMageml = null;
            $this->aTableinfo = null;
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
            $con = Propel::getConnection(MagedocumentationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = MagedocumentationQuery::create()
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
            $con = Propel::getConnection(MagedocumentationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                MagedocumentationPeer::addInstanceToPool($this);
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

            if ($this->aMageml !== null) {
                if ($this->aMageml->isModified() || $this->aMageml->isNew()) {
                    $affectedRows += $this->aMageml->save($con);
                }
                $this->setMageml($this->aMageml);
            }

            if ($this->aTableinfo !== null) {
                if ($this->aTableinfo->isModified() || $this->aTableinfo->isNew()) {
                    $affectedRows += $this->aTableinfo->save($con);
                }
                $this->setTableinfo($this->aTableinfo);
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

        $this->modifiedColumns[] = MagedocumentationPeer::MAGEDOCUMENTATION_ID;
        if (null !== $this->magedocumentation_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . MagedocumentationPeer::MAGEDOCUMENTATION_ID . ')');
        }
        if (null === $this->magedocumentation_id) {
            try {
                $stmt = $con->query("SELECT nextval('magedocumentation_magedocumentation_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->magedocumentation_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(MagedocumentationPeer::MAGEDOCUMENTATION_ID)) {
            $modifiedColumns[':p' . $index++]  = '"magedocumentation_id"';
        }
        if ($this->isColumnModified(MagedocumentationPeer::MAGEML_ID)) {
            $modifiedColumns[':p' . $index++]  = '"mageml_id"';
        }
        if ($this->isColumnModified(MagedocumentationPeer::TABLEINFO_ID)) {
            $modifiedColumns[':p' . $index++]  = '"tableinfo_id"';
        }
        if ($this->isColumnModified(MagedocumentationPeer::ROW_ID)) {
            $modifiedColumns[':p' . $index++]  = '"row_id"';
        }
        if ($this->isColumnModified(MagedocumentationPeer::MAGEIDENTIFIER)) {
            $modifiedColumns[':p' . $index++]  = '"mageidentifier"';
        }

        $sql = sprintf(
            'INSERT INTO "magedocumentation" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"magedocumentation_id"':
                        $stmt->bindValue($identifier, $this->magedocumentation_id, PDO::PARAM_INT);
                        break;
                    case '"mageml_id"':
                        $stmt->bindValue($identifier, $this->mageml_id, PDO::PARAM_INT);
                        break;
                    case '"tableinfo_id"':
                        $stmt->bindValue($identifier, $this->tableinfo_id, PDO::PARAM_INT);
                        break;
                    case '"row_id"':
                        $stmt->bindValue($identifier, $this->row_id, PDO::PARAM_INT);
                        break;
                    case '"mageidentifier"':
                        $stmt->bindValue($identifier, $this->mageidentifier, PDO::PARAM_STR);
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

            if ($this->aMageml !== null) {
                if (!$this->aMageml->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aMageml->getValidationFailures());
                }
            }

            if ($this->aTableinfo !== null) {
                if (!$this->aTableinfo->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aTableinfo->getValidationFailures());
                }
            }


            if (($retval = MagedocumentationPeer::doValidate($this, $columns)) !== true) {
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
        $pos = MagedocumentationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getMagedocumentationId();
                break;
            case 1:
                return $this->getMagemlId();
                break;
            case 2:
                return $this->getTableinfoId();
                break;
            case 3:
                return $this->getRowId();
                break;
            case 4:
                return $this->getMageidentifier();
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
        if (isset($alreadyDumpedObjects['Magedocumentation'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Magedocumentation'][$this->getPrimaryKey()] = true;
        $keys = MagedocumentationPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getMagedocumentationId(),
            $keys[1] => $this->getMagemlId(),
            $keys[2] => $this->getTableinfoId(),
            $keys[3] => $this->getRowId(),
            $keys[4] => $this->getMageidentifier(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aMageml) {
                $result['Mageml'] = $this->aMageml->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aTableinfo) {
                $result['Tableinfo'] = $this->aTableinfo->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = MagedocumentationPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setMagedocumentationId($value);
                break;
            case 1:
                $this->setMagemlId($value);
                break;
            case 2:
                $this->setTableinfoId($value);
                break;
            case 3:
                $this->setRowId($value);
                break;
            case 4:
                $this->setMageidentifier($value);
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
        $keys = MagedocumentationPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setMagedocumentationId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setMagemlId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setTableinfoId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setRowId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setMageidentifier($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(MagedocumentationPeer::DATABASE_NAME);

        if ($this->isColumnModified(MagedocumentationPeer::MAGEDOCUMENTATION_ID)) $criteria->add(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $this->magedocumentation_id);
        if ($this->isColumnModified(MagedocumentationPeer::MAGEML_ID)) $criteria->add(MagedocumentationPeer::MAGEML_ID, $this->mageml_id);
        if ($this->isColumnModified(MagedocumentationPeer::TABLEINFO_ID)) $criteria->add(MagedocumentationPeer::TABLEINFO_ID, $this->tableinfo_id);
        if ($this->isColumnModified(MagedocumentationPeer::ROW_ID)) $criteria->add(MagedocumentationPeer::ROW_ID, $this->row_id);
        if ($this->isColumnModified(MagedocumentationPeer::MAGEIDENTIFIER)) $criteria->add(MagedocumentationPeer::MAGEIDENTIFIER, $this->mageidentifier);

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
        $criteria = new Criteria(MagedocumentationPeer::DATABASE_NAME);
        $criteria->add(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $this->magedocumentation_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getMagedocumentationId();
    }

    /**
     * Generic method to set the primary key (magedocumentation_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setMagedocumentationId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getMagedocumentationId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Magedocumentation (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setMagemlId($this->getMagemlId());
        $copyObj->setTableinfoId($this->getTableinfoId());
        $copyObj->setRowId($this->getRowId());
        $copyObj->setMageidentifier($this->getMageidentifier());

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
            $copyObj->setMagedocumentationId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Magedocumentation Clone of current object.
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
     * @return MagedocumentationPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new MagedocumentationPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Mageml object.
     *
     * @param             Mageml $v
     * @return Magedocumentation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setMageml(Mageml $v = null)
    {
        if ($v === null) {
            $this->setMagemlId(NULL);
        } else {
            $this->setMagemlId($v->getMagemlId());
        }

        $this->aMageml = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Mageml object, it will not be re-added.
        if ($v !== null) {
            $v->addMagedocumentation($this);
        }


        return $this;
    }


    /**
     * Get the associated Mageml object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Mageml The associated Mageml object.
     * @throws PropelException
     */
    public function getMageml(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aMageml === null && ($this->mageml_id !== null) && $doQuery) {
            $this->aMageml = MagemlQuery::create()->findPk($this->mageml_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aMageml->addMagedocumentations($this);
             */
        }

        return $this->aMageml;
    }

    /**
     * Declares an association between this object and a Tableinfo object.
     *
     * @param             Tableinfo $v
     * @return Magedocumentation The current object (for fluent API support)
     * @throws PropelException
     */
    public function setTableinfo(Tableinfo $v = null)
    {
        if ($v === null) {
            $this->setTableinfoId(NULL);
        } else {
            $this->setTableinfoId($v->getTableinfoId());
        }

        $this->aTableinfo = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Tableinfo object, it will not be re-added.
        if ($v !== null) {
            $v->addMagedocumentation($this);
        }


        return $this;
    }


    /**
     * Get the associated Tableinfo object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Tableinfo The associated Tableinfo object.
     * @throws PropelException
     */
    public function getTableinfo(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aTableinfo === null && ($this->tableinfo_id !== null) && $doQuery) {
            $this->aTableinfo = TableinfoQuery::create()->findPk($this->tableinfo_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aTableinfo->addMagedocumentations($this);
             */
        }

        return $this->aTableinfo;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->magedocumentation_id = null;
        $this->mageml_id = null;
        $this->tableinfo_id = null;
        $this->row_id = null;
        $this->mageidentifier = null;
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
            if ($this->aMageml instanceof Persistent) {
              $this->aMageml->clearAllReferences($deep);
            }
            if ($this->aTableinfo instanceof Persistent) {
              $this->aTableinfo->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aMageml = null;
        $this->aTableinfo = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(MagedocumentationPeer::DEFAULT_STRING_FORMAT);
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
