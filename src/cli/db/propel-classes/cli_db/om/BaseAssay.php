<?php

namespace cli_db\propel\om;

use \BaseObject;
use \BasePeer;
use \Criteria;
use \DateTime;
use \Exception;
use \PDO;
use \Persistent;
use \Propel;
use \PropelCollection;
use \PropelDateTime;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\Acquisition;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\Assay;
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayBiomaterialQuery;
use cli_db\propel\AssayPeer;
use cli_db\propel\AssayQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;

/**
 * Base class that represents a row from the 'assay' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAssay extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\AssayPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AssayPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the assay_id field.
     * @var        int
     */
    protected $assay_id;

    /**
     * The value for the arraydesign_id field.
     * @var        int
     */
    protected $arraydesign_id;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

    /**
     * The value for the assaydate field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $assaydate;

    /**
     * The value for the arrayidentifier field.
     * @var        string
     */
    protected $arrayidentifier;

    /**
     * The value for the arraybatchidentifier field.
     * @var        string
     */
    protected $arraybatchidentifier;

    /**
     * The value for the operator_id field.
     * @var        int
     */
    protected $operator_id;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

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
     * @var        Contact
     */
    protected $aContact;

    /**
     * @var        Protocol
     */
    protected $aProtocol;

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
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
    }

    /**
     * Initializes internal state of BaseAssay object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [arraydesign_id] column value.
     *
     * @return int
     */
    public function getArraydesignId()
    {
        return $this->arraydesign_id;
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
     * Get the [optionally formatted] temporal [assaydate] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getAssaydate($format = 'Y-m-d H:i:s')
    {
        if ($this->assaydate === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->assaydate);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->assaydate, true), $x);
        }

        if ($format === null) {
            // Because propel.useDateTimeClass is true, we return a DateTime object.
            return $dt;
        }

        if (strpos($format, '%') !== false) {
            return strftime($format, $dt->format('U'));
        }

        return $dt->format($format);

    }

    /**
     * Get the [arrayidentifier] column value.
     *
     * @return string
     */
    public function getArrayidentifier()
    {
        return $this->arrayidentifier;
    }

    /**
     * Get the [arraybatchidentifier] column value.
     *
     * @return string
     */
    public function getArraybatchidentifier()
    {
        return $this->arraybatchidentifier;
    }

    /**
     * Get the [operator_id] column value.
     *
     * @return int
     */
    public function getOperatorId()
    {
        return $this->operator_id;
    }

    /**
     * Get the [dbxref_id] column value.
     *
     * @return int
     */
    public function getDbxrefId()
    {
        return $this->dbxref_id;
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
     * Set the value of [assay_id] column.
     *
     * @param int $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setAssayId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->assay_id !== $v) {
            $this->assay_id = $v;
            $this->modifiedColumns[] = AssayPeer::ASSAY_ID;
        }


        return $this;
    } // setAssayId()

    /**
     * Set the value of [arraydesign_id] column.
     *
     * @param int $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setArraydesignId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->arraydesign_id !== $v) {
            $this->arraydesign_id = $v;
            $this->modifiedColumns[] = AssayPeer::ARRAYDESIGN_ID;
        }


        return $this;
    } // setArraydesignId()

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = AssayPeer::PROTOCOL_ID;
        }

        if ($this->aProtocol !== null && $this->aProtocol->getProtocolId() !== $v) {
            $this->aProtocol = null;
        }


        return $this;
    } // setProtocolId()

    /**
     * Sets the value of [assaydate] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Assay The current object (for fluent API support)
     */
    public function setAssaydate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->assaydate !== null || $dt !== null) {
            $currentDateAsString = ($this->assaydate !== null && $tmpDt = new DateTime($this->assaydate)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->assaydate = $newDateAsString;
                $this->modifiedColumns[] = AssayPeer::ASSAYDATE;
            }
        } // if either are not null


        return $this;
    } // setAssaydate()

    /**
     * Set the value of [arrayidentifier] column.
     *
     * @param string $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setArrayidentifier($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->arrayidentifier !== $v) {
            $this->arrayidentifier = $v;
            $this->modifiedColumns[] = AssayPeer::ARRAYIDENTIFIER;
        }


        return $this;
    } // setArrayidentifier()

    /**
     * Set the value of [arraybatchidentifier] column.
     *
     * @param string $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setArraybatchidentifier($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->arraybatchidentifier !== $v) {
            $this->arraybatchidentifier = $v;
            $this->modifiedColumns[] = AssayPeer::ARRAYBATCHIDENTIFIER;
        }


        return $this;
    } // setArraybatchidentifier()

    /**
     * Set the value of [operator_id] column.
     *
     * @param int $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setOperatorId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->operator_id !== $v) {
            $this->operator_id = $v;
            $this->modifiedColumns[] = AssayPeer::OPERATOR_ID;
        }

        if ($this->aContact !== null && $this->aContact->getContactId() !== $v) {
            $this->aContact = null;
        }


        return $this;
    } // setOperatorId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = AssayPeer::DBXREF_ID;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AssayPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Assay The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = AssayPeer::DESCRIPTION;
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

            $this->assay_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->arraydesign_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->protocol_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->assaydate = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->arrayidentifier = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->arraybatchidentifier = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->operator_id = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->dbxref_id = ($row[$startcol + 7] !== null) ? (int) $row[$startcol + 7] : null;
            $this->name = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->description = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 10; // 10 = AssayPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Assay object", $e);
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
        if ($this->aContact !== null && $this->operator_id !== $this->aContact->getContactId()) {
            $this->aContact = null;
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
            $con = Propel::getConnection(AssayPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AssayPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aContact = null;
            $this->aProtocol = null;
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
            $con = Propel::getConnection(AssayPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AssayQuery::create()
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
            $con = Propel::getConnection(AssayPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AssayPeer::addInstanceToPool($this);
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

            if ($this->aContact !== null) {
                if ($this->aContact->isModified() || $this->aContact->isNew()) {
                    $affectedRows += $this->aContact->save($con);
                }
                $this->setContact($this->aContact);
            }

            if ($this->aProtocol !== null) {
                if ($this->aProtocol->isModified() || $this->aProtocol->isNew()) {
                    $affectedRows += $this->aProtocol->save($con);
                }
                $this->setProtocol($this->aProtocol);
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

            if ($this->acquisitionsScheduledForDeletion !== null) {
                if (!$this->acquisitionsScheduledForDeletion->isEmpty()) {
                    AcquisitionQuery::create()
                        ->filterByPrimaryKeys($this->acquisitionsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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
                    AssayBiomaterialQuery::create()
                        ->filterByPrimaryKeys($this->assayBiomaterialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[] = AssayPeer::ASSAY_ID;
        if (null !== $this->assay_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AssayPeer::ASSAY_ID . ')');
        }
        if (null === $this->assay_id) {
            try {
                $stmt = $con->query("SELECT nextval('assay_assay_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->assay_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AssayPeer::ASSAY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"assay_id"';
        }
        if ($this->isColumnModified(AssayPeer::ARRAYDESIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = '"arraydesign_id"';
        }
        if ($this->isColumnModified(AssayPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(AssayPeer::ASSAYDATE)) {
            $modifiedColumns[':p' . $index++]  = '"assaydate"';
        }
        if ($this->isColumnModified(AssayPeer::ARRAYIDENTIFIER)) {
            $modifiedColumns[':p' . $index++]  = '"arrayidentifier"';
        }
        if ($this->isColumnModified(AssayPeer::ARRAYBATCHIDENTIFIER)) {
            $modifiedColumns[':p' . $index++]  = '"arraybatchidentifier"';
        }
        if ($this->isColumnModified(AssayPeer::OPERATOR_ID)) {
            $modifiedColumns[':p' . $index++]  = '"operator_id"';
        }
        if ($this->isColumnModified(AssayPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(AssayPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(AssayPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "assay" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"assay_id"':
                        $stmt->bindValue($identifier, $this->assay_id, PDO::PARAM_INT);
                        break;
                    case '"arraydesign_id"':
                        $stmt->bindValue($identifier, $this->arraydesign_id, PDO::PARAM_INT);
                        break;
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"assaydate"':
                        $stmt->bindValue($identifier, $this->assaydate, PDO::PARAM_STR);
                        break;
                    case '"arrayidentifier"':
                        $stmt->bindValue($identifier, $this->arrayidentifier, PDO::PARAM_STR);
                        break;
                    case '"arraybatchidentifier"':
                        $stmt->bindValue($identifier, $this->arraybatchidentifier, PDO::PARAM_STR);
                        break;
                    case '"operator_id"':
                        $stmt->bindValue($identifier, $this->operator_id, PDO::PARAM_INT);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
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

            if ($this->aContact !== null) {
                if (!$this->aContact->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aContact->getValidationFailures());
                }
            }

            if ($this->aProtocol !== null) {
                if (!$this->aProtocol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProtocol->getValidationFailures());
                }
            }


            if (($retval = AssayPeer::doValidate($this, $columns)) !== true) {
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
        $pos = AssayPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAssayId();
                break;
            case 1:
                return $this->getArraydesignId();
                break;
            case 2:
                return $this->getProtocolId();
                break;
            case 3:
                return $this->getAssaydate();
                break;
            case 4:
                return $this->getArrayidentifier();
                break;
            case 5:
                return $this->getArraybatchidentifier();
                break;
            case 6:
                return $this->getOperatorId();
                break;
            case 7:
                return $this->getDbxrefId();
                break;
            case 8:
                return $this->getName();
                break;
            case 9:
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
        if (isset($alreadyDumpedObjects['Assay'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Assay'][$this->getPrimaryKey()] = true;
        $keys = AssayPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAssayId(),
            $keys[1] => $this->getArraydesignId(),
            $keys[2] => $this->getProtocolId(),
            $keys[3] => $this->getAssaydate(),
            $keys[4] => $this->getArrayidentifier(),
            $keys[5] => $this->getArraybatchidentifier(),
            $keys[6] => $this->getOperatorId(),
            $keys[7] => $this->getDbxrefId(),
            $keys[8] => $this->getName(),
            $keys[9] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aContact) {
                $result['Contact'] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProtocol) {
                $result['Protocol'] = $this->aProtocol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
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
        $pos = AssayPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAssayId($value);
                break;
            case 1:
                $this->setArraydesignId($value);
                break;
            case 2:
                $this->setProtocolId($value);
                break;
            case 3:
                $this->setAssaydate($value);
                break;
            case 4:
                $this->setArrayidentifier($value);
                break;
            case 5:
                $this->setArraybatchidentifier($value);
                break;
            case 6:
                $this->setOperatorId($value);
                break;
            case 7:
                $this->setDbxrefId($value);
                break;
            case 8:
                $this->setName($value);
                break;
            case 9:
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
        $keys = AssayPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setAssayId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setArraydesignId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setProtocolId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setAssaydate($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setArrayidentifier($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setArraybatchidentifier($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setOperatorId($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setDbxrefId($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setName($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setDescription($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AssayPeer::DATABASE_NAME);

        if ($this->isColumnModified(AssayPeer::ASSAY_ID)) $criteria->add(AssayPeer::ASSAY_ID, $this->assay_id);
        if ($this->isColumnModified(AssayPeer::ARRAYDESIGN_ID)) $criteria->add(AssayPeer::ARRAYDESIGN_ID, $this->arraydesign_id);
        if ($this->isColumnModified(AssayPeer::PROTOCOL_ID)) $criteria->add(AssayPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(AssayPeer::ASSAYDATE)) $criteria->add(AssayPeer::ASSAYDATE, $this->assaydate);
        if ($this->isColumnModified(AssayPeer::ARRAYIDENTIFIER)) $criteria->add(AssayPeer::ARRAYIDENTIFIER, $this->arrayidentifier);
        if ($this->isColumnModified(AssayPeer::ARRAYBATCHIDENTIFIER)) $criteria->add(AssayPeer::ARRAYBATCHIDENTIFIER, $this->arraybatchidentifier);
        if ($this->isColumnModified(AssayPeer::OPERATOR_ID)) $criteria->add(AssayPeer::OPERATOR_ID, $this->operator_id);
        if ($this->isColumnModified(AssayPeer::DBXREF_ID)) $criteria->add(AssayPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(AssayPeer::NAME)) $criteria->add(AssayPeer::NAME, $this->name);
        if ($this->isColumnModified(AssayPeer::DESCRIPTION)) $criteria->add(AssayPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(AssayPeer::DATABASE_NAME);
        $criteria->add(AssayPeer::ASSAY_ID, $this->assay_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getAssayId();
    }

    /**
     * Generic method to set the primary key (assay_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAssayId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getAssayId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Assay (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setArraydesignId($this->getArraydesignId());
        $copyObj->setProtocolId($this->getProtocolId());
        $copyObj->setAssaydate($this->getAssaydate());
        $copyObj->setArrayidentifier($this->getArrayidentifier());
        $copyObj->setArraybatchidentifier($this->getArraybatchidentifier());
        $copyObj->setOperatorId($this->getOperatorId());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

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
            $copyObj->setAssayId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Assay Clone of current object.
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
     * @return AssayPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AssayPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Contact object.
     *
     * @param             Contact $v
     * @return Assay The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(Contact $v = null)
    {
        if ($v === null) {
            $this->setOperatorId(NULL);
        } else {
            $this->setOperatorId($v->getContactId());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Contact object, it will not be re-added.
        if ($v !== null) {
            $v->addAssay($this);
        }


        return $this;
    }


    /**
     * Get the associated Contact object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Contact The associated Contact object.
     * @throws PropelException
     */
    public function getContact(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aContact === null && ($this->operator_id !== null) && $doQuery) {
            $this->aContact = ContactQuery::create()->findPk($this->operator_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addAssays($this);
             */
        }

        return $this->aContact;
    }

    /**
     * Declares an association between this object and a Protocol object.
     *
     * @param             Protocol $v
     * @return Assay The current object (for fluent API support)
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
            $v->addAssay($this);
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
                $this->aProtocol->addAssays($this);
             */
        }

        return $this->aProtocol;
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
     * @return Assay The current object (for fluent API support)
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
     * If this Assay is new, it will return
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
                    ->filterByAssay($this)
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
     * @return Assay The current object (for fluent API support)
     */
    public function setAcquisitions(PropelCollection $acquisitions, PropelPDO $con = null)
    {
        $acquisitionsToDelete = $this->getAcquisitions(new Criteria(), $con)->diff($acquisitions);

        $this->acquisitionsScheduledForDeletion = unserialize(serialize($acquisitionsToDelete));

        foreach ($acquisitionsToDelete as $acquisitionRemoved) {
            $acquisitionRemoved->setAssay(null);
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
                ->filterByAssay($this)
                ->count($con);
        }

        return count($this->collAcquisitions);
    }

    /**
     * Method called to associate a Acquisition object to this object
     * through the Acquisition foreign key attribute.
     *
     * @param    Acquisition $l Acquisition
     * @return Assay The current object (for fluent API support)
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
        $acquisition->setAssay($this);
    }

    /**
     * @param	Acquisition $acquisition The acquisition object to remove.
     * @return Assay The current object (for fluent API support)
     */
    public function removeAcquisition($acquisition)
    {
        if ($this->getAcquisitions()->contains($acquisition)) {
            $this->collAcquisitions->remove($this->collAcquisitions->search($acquisition));
            if (null === $this->acquisitionsScheduledForDeletion) {
                $this->acquisitionsScheduledForDeletion = clone $this->collAcquisitions;
                $this->acquisitionsScheduledForDeletion->clear();
            }
            $this->acquisitionsScheduledForDeletion[]= clone $acquisition;
            $acquisition->setAssay(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Assay is new, it will return
     * an empty collection; or if this Assay has previously
     * been saved, it will retrieve related Acquisitions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Assay.
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
     * @return Assay The current object (for fluent API support)
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
     * If this Assay is new, it will return
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
                    ->filterByAssay($this)
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
     * @return Assay The current object (for fluent API support)
     */
    public function setAssayBiomaterials(PropelCollection $assayBiomaterials, PropelPDO $con = null)
    {
        $assayBiomaterialsToDelete = $this->getAssayBiomaterials(new Criteria(), $con)->diff($assayBiomaterials);

        $this->assayBiomaterialsScheduledForDeletion = unserialize(serialize($assayBiomaterialsToDelete));

        foreach ($assayBiomaterialsToDelete as $assayBiomaterialRemoved) {
            $assayBiomaterialRemoved->setAssay(null);
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
                ->filterByAssay($this)
                ->count($con);
        }

        return count($this->collAssayBiomaterials);
    }

    /**
     * Method called to associate a AssayBiomaterial object to this object
     * through the AssayBiomaterial foreign key attribute.
     *
     * @param    AssayBiomaterial $l AssayBiomaterial
     * @return Assay The current object (for fluent API support)
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
        $assayBiomaterial->setAssay($this);
    }

    /**
     * @param	AssayBiomaterial $assayBiomaterial The assayBiomaterial object to remove.
     * @return Assay The current object (for fluent API support)
     */
    public function removeAssayBiomaterial($assayBiomaterial)
    {
        if ($this->getAssayBiomaterials()->contains($assayBiomaterial)) {
            $this->collAssayBiomaterials->remove($this->collAssayBiomaterials->search($assayBiomaterial));
            if (null === $this->assayBiomaterialsScheduledForDeletion) {
                $this->assayBiomaterialsScheduledForDeletion = clone $this->collAssayBiomaterials;
                $this->assayBiomaterialsScheduledForDeletion->clear();
            }
            $this->assayBiomaterialsScheduledForDeletion[]= clone $assayBiomaterial;
            $assayBiomaterial->setAssay(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Assay is new, it will return
     * an empty collection; or if this Assay has previously
     * been saved, it will retrieve related AssayBiomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Assay.
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
        $this->assay_id = null;
        $this->arraydesign_id = null;
        $this->protocol_id = null;
        $this->assaydate = null;
        $this->arrayidentifier = null;
        $this->arraybatchidentifier = null;
        $this->operator_id = null;
        $this->dbxref_id = null;
        $this->name = null;
        $this->description = null;
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
            if ($this->aContact instanceof Persistent) {
              $this->aContact->clearAllReferences($deep);
            }
            if ($this->aProtocol instanceof Persistent) {
              $this->aProtocol->clearAllReferences($deep);
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
        $this->aContact = null;
        $this->aProtocol = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AssayPeer::DEFAULT_STRING_FORMAT);
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
