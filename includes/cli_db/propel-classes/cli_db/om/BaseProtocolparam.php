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
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Protocolparam;
use cli_db\propel\ProtocolparamPeer;
use cli_db\propel\ProtocolparamQuery;

/**
 * Base class that represents a row from the 'protocolparam' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProtocolparam extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ProtocolparamPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProtocolparamPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the protocolparam_id field.
     * @var        int
     */
    protected $protocolparam_id;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the datatype_id field.
     * @var        int
     */
    protected $datatype_id;

    /**
     * The value for the unittype_id field.
     * @var        int
     */
    protected $unittype_id;

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
     * @var        Cvterm
     */
    protected $aCvtermRelatedByDatatypeId;

    /**
     * @var        Protocol
     */
    protected $aProtocol;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedByUnittypeId;

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
     * Initializes internal state of BaseProtocolparam object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [protocolparam_id] column value.
     *
     * @return int
     */
    public function getProtocolparamId()
    {
        return $this->protocolparam_id;
    }

    /**
     * Get the [protocol_id] column value.
     *
     * @return int
     */
    public function getProtocolId()
    {
        return $this->protocol_id;
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
     * Get the [datatype_id] column value.
     *
     * @return int
     */
    public function getDatatypeId()
    {
        return $this->datatype_id;
    }

    /**
     * Get the [unittype_id] column value.
     *
     * @return int
     */
    public function getUnittypeId()
    {
        return $this->unittype_id;
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
     * Set the value of [protocolparam_id] column.
     *
     * @param int $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setProtocolparamId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocolparam_id !== $v) {
            $this->protocolparam_id = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::PROTOCOLPARAM_ID;
        }


        return $this;
    } // setProtocolparamId()

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::PROTOCOL_ID;
        }

        if ($this->aProtocol !== null && $this->aProtocol->getProtocolId() !== $v) {
            $this->aProtocol = null;
        }


        return $this;
    } // setProtocolId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [datatype_id] column.
     *
     * @param int $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setDatatypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->datatype_id !== $v) {
            $this->datatype_id = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::DATATYPE_ID;
        }

        if ($this->aCvtermRelatedByDatatypeId !== null && $this->aCvtermRelatedByDatatypeId->getCvtermId() !== $v) {
            $this->aCvtermRelatedByDatatypeId = null;
        }


        return $this;
    } // setDatatypeId()

    /**
     * Set the value of [unittype_id] column.
     *
     * @param int $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setUnittypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->unittype_id !== $v) {
            $this->unittype_id = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::UNITTYPE_ID;
        }

        if ($this->aCvtermRelatedByUnittypeId !== null && $this->aCvtermRelatedByUnittypeId->getCvtermId() !== $v) {
            $this->aCvtermRelatedByUnittypeId = null;
        }


        return $this;
    } // setUnittypeId()

    /**
     * Set the value of [value] column.
     *
     * @param string $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setValue($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->value !== $v) {
            $this->value = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::VALUE;
        }


        return $this;
    } // setValue()

    /**
     * Set the value of [rank] column.
     *
     * @param int $v new value
     * @return Protocolparam The current object (for fluent API support)
     */
    public function setRank($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->rank !== $v) {
            $this->rank = $v;
            $this->modifiedColumns[] = ProtocolparamPeer::RANK;
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

            $this->protocolparam_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->protocol_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->datatype_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->unittype_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->value = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->rank = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = ProtocolparamPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Protocolparam object", $e);
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

        if ($this->aProtocol !== null && $this->protocol_id !== $this->aProtocol->getProtocolId()) {
            $this->aProtocol = null;
        }
        if ($this->aCvtermRelatedByDatatypeId !== null && $this->datatype_id !== $this->aCvtermRelatedByDatatypeId->getCvtermId()) {
            $this->aCvtermRelatedByDatatypeId = null;
        }
        if ($this->aCvtermRelatedByUnittypeId !== null && $this->unittype_id !== $this->aCvtermRelatedByUnittypeId->getCvtermId()) {
            $this->aCvtermRelatedByUnittypeId = null;
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
            $con = Propel::getConnection(ProtocolparamPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProtocolparamPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCvtermRelatedByDatatypeId = null;
            $this->aProtocol = null;
            $this->aCvtermRelatedByUnittypeId = null;
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
            $con = Propel::getConnection(ProtocolparamPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProtocolparamQuery::create()
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
            $con = Propel::getConnection(ProtocolparamPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProtocolparamPeer::addInstanceToPool($this);
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

            if ($this->aCvtermRelatedByDatatypeId !== null) {
                if ($this->aCvtermRelatedByDatatypeId->isModified() || $this->aCvtermRelatedByDatatypeId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedByDatatypeId->save($con);
                }
                $this->setCvtermRelatedByDatatypeId($this->aCvtermRelatedByDatatypeId);
            }

            if ($this->aProtocol !== null) {
                if ($this->aProtocol->isModified() || $this->aProtocol->isNew()) {
                    $affectedRows += $this->aProtocol->save($con);
                }
                $this->setProtocol($this->aProtocol);
            }

            if ($this->aCvtermRelatedByUnittypeId !== null) {
                if ($this->aCvtermRelatedByUnittypeId->isModified() || $this->aCvtermRelatedByUnittypeId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedByUnittypeId->save($con);
                }
                $this->setCvtermRelatedByUnittypeId($this->aCvtermRelatedByUnittypeId);
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

        $this->modifiedColumns[] = ProtocolparamPeer::PROTOCOLPARAM_ID;
        if (null !== $this->protocolparam_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProtocolparamPeer::PROTOCOLPARAM_ID . ')');
        }
        if (null === $this->protocolparam_id) {
            try {
                $stmt = $con->query("SELECT nextval('protocolparam_protocolparam_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->protocolparam_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProtocolparamPeer::PROTOCOLPARAM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocolparam_id"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::DATATYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"datatype_id"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::UNITTYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"unittype_id"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::VALUE)) {
            $modifiedColumns[':p' . $index++]  = '"value"';
        }
        if ($this->isColumnModified(ProtocolparamPeer::RANK)) {
            $modifiedColumns[':p' . $index++]  = '"rank"';
        }

        $sql = sprintf(
            'INSERT INTO "protocolparam" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"protocolparam_id"':
                        $stmt->bindValue($identifier, $this->protocolparam_id, PDO::PARAM_INT);
                        break;
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"datatype_id"':
                        $stmt->bindValue($identifier, $this->datatype_id, PDO::PARAM_INT);
                        break;
                    case '"unittype_id"':
                        $stmt->bindValue($identifier, $this->unittype_id, PDO::PARAM_INT);
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

            if ($this->aCvtermRelatedByDatatypeId !== null) {
                if (!$this->aCvtermRelatedByDatatypeId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedByDatatypeId->getValidationFailures());
                }
            }

            if ($this->aProtocol !== null) {
                if (!$this->aProtocol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProtocol->getValidationFailures());
                }
            }

            if ($this->aCvtermRelatedByUnittypeId !== null) {
                if (!$this->aCvtermRelatedByUnittypeId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedByUnittypeId->getValidationFailures());
                }
            }


            if (($retval = ProtocolparamPeer::doValidate($this, $columns)) !== true) {
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
        $pos = ProtocolparamPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getProtocolparamId();
                break;
            case 1:
                return $this->getProtocolId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getDatatypeId();
                break;
            case 4:
                return $this->getUnittypeId();
                break;
            case 5:
                return $this->getValue();
                break;
            case 6:
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
        if (isset($alreadyDumpedObjects['Protocolparam'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Protocolparam'][$this->getPrimaryKey()] = true;
        $keys = ProtocolparamPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getProtocolparamId(),
            $keys[1] => $this->getProtocolId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDatatypeId(),
            $keys[4] => $this->getUnittypeId(),
            $keys[5] => $this->getValue(),
            $keys[6] => $this->getRank(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCvtermRelatedByDatatypeId) {
                $result['CvtermRelatedByDatatypeId'] = $this->aCvtermRelatedByDatatypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProtocol) {
                $result['Protocol'] = $this->aProtocol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvtermRelatedByUnittypeId) {
                $result['CvtermRelatedByUnittypeId'] = $this->aCvtermRelatedByUnittypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = ProtocolparamPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setProtocolparamId($value);
                break;
            case 1:
                $this->setProtocolId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setDatatypeId($value);
                break;
            case 4:
                $this->setUnittypeId($value);
                break;
            case 5:
                $this->setValue($value);
                break;
            case 6:
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
        $keys = ProtocolparamPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setProtocolparamId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setProtocolId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDatatypeId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setUnittypeId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setValue($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setRank($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProtocolparamPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProtocolparamPeer::PROTOCOLPARAM_ID)) $criteria->add(ProtocolparamPeer::PROTOCOLPARAM_ID, $this->protocolparam_id);
        if ($this->isColumnModified(ProtocolparamPeer::PROTOCOL_ID)) $criteria->add(ProtocolparamPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(ProtocolparamPeer::NAME)) $criteria->add(ProtocolparamPeer::NAME, $this->name);
        if ($this->isColumnModified(ProtocolparamPeer::DATATYPE_ID)) $criteria->add(ProtocolparamPeer::DATATYPE_ID, $this->datatype_id);
        if ($this->isColumnModified(ProtocolparamPeer::UNITTYPE_ID)) $criteria->add(ProtocolparamPeer::UNITTYPE_ID, $this->unittype_id);
        if ($this->isColumnModified(ProtocolparamPeer::VALUE)) $criteria->add(ProtocolparamPeer::VALUE, $this->value);
        if ($this->isColumnModified(ProtocolparamPeer::RANK)) $criteria->add(ProtocolparamPeer::RANK, $this->rank);

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
        $criteria = new Criteria(ProtocolparamPeer::DATABASE_NAME);
        $criteria->add(ProtocolparamPeer::PROTOCOLPARAM_ID, $this->protocolparam_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getProtocolparamId();
    }

    /**
     * Generic method to set the primary key (protocolparam_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setProtocolparamId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getProtocolparamId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Protocolparam (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setProtocolId($this->getProtocolId());
        $copyObj->setName($this->getName());
        $copyObj->setDatatypeId($this->getDatatypeId());
        $copyObj->setUnittypeId($this->getUnittypeId());
        $copyObj->setValue($this->getValue());
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
            $copyObj->setProtocolparamId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Protocolparam Clone of current object.
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
     * @return ProtocolparamPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProtocolparamPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Protocolparam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedByDatatypeId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setDatatypeId(NULL);
        } else {
            $this->setDatatypeId($v->getCvtermId());
        }

        $this->aCvtermRelatedByDatatypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addProtocolparamRelatedByDatatypeId($this);
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
    public function getCvtermRelatedByDatatypeId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedByDatatypeId === null && ($this->datatype_id !== null) && $doQuery) {
            $this->aCvtermRelatedByDatatypeId = CvtermQuery::create()->findPk($this->datatype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedByDatatypeId->addProtocolparamsRelatedByDatatypeId($this);
             */
        }

        return $this->aCvtermRelatedByDatatypeId;
    }

    /**
     * Declares an association between this object and a Protocol object.
     *
     * @param             Protocol $v
     * @return Protocolparam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProtocol(Protocol $v = null)
    {
        if ($v === null) {
            $this->setProtocolId(NULL);
        } else {
            $this->setProtocolId($v->getProtocolId());
        }

        $this->aProtocol = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Protocol object, it will not be re-added.
        if ($v !== null) {
            $v->addProtocolparam($this);
        }


        return $this;
    }


    /**
     * Get the associated Protocol object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Protocol The associated Protocol object.
     * @throws PropelException
     */
    public function getProtocol(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProtocol === null && ($this->protocol_id !== null) && $doQuery) {
            $this->aProtocol = ProtocolQuery::create()->findPk($this->protocol_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProtocol->addProtocolparams($this);
             */
        }

        return $this->aProtocol;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Protocolparam The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedByUnittypeId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setUnittypeId(NULL);
        } else {
            $this->setUnittypeId($v->getCvtermId());
        }

        $this->aCvtermRelatedByUnittypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addProtocolparamRelatedByUnittypeId($this);
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
    public function getCvtermRelatedByUnittypeId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedByUnittypeId === null && ($this->unittype_id !== null) && $doQuery) {
            $this->aCvtermRelatedByUnittypeId = CvtermQuery::create()->findPk($this->unittype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedByUnittypeId->addProtocolparamsRelatedByUnittypeId($this);
             */
        }

        return $this->aCvtermRelatedByUnittypeId;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->protocolparam_id = null;
        $this->protocol_id = null;
        $this->name = null;
        $this->datatype_id = null;
        $this->unittype_id = null;
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
            if ($this->aCvtermRelatedByDatatypeId instanceof Persistent) {
              $this->aCvtermRelatedByDatatypeId->clearAllReferences($deep);
            }
            if ($this->aProtocol instanceof Persistent) {
              $this->aProtocol->clearAllReferences($deep);
            }
            if ($this->aCvtermRelatedByUnittypeId instanceof Persistent) {
              $this->aCvtermRelatedByUnittypeId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aCvtermRelatedByDatatypeId = null;
        $this->aProtocol = null;
        $this->aCvtermRelatedByUnittypeId = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProtocolparamPeer::DEFAULT_STRING_FORMAT);
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
