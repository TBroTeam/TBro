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
use cli_db\propel\Control;
use cli_db\propel\ControlQuery;
use cli_db\propel\Magedocumentation;
use cli_db\propel\MagedocumentationQuery;
use cli_db\propel\Tableinfo;
use cli_db\propel\TableinfoPeer;
use cli_db\propel\TableinfoQuery;

/**
 * Base class that represents a row from the 'tableinfo' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseTableinfo extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\TableinfoPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        TableinfoPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the tableinfo_id field.
     * @var        int
     */
    protected $tableinfo_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the primary_key_column field.
     * @var        string
     */
    protected $primary_key_column;

    /**
     * The value for the is_view field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_view;

    /**
     * The value for the view_on_table_id field.
     * @var        int
     */
    protected $view_on_table_id;

    /**
     * The value for the superclass_table_id field.
     * @var        int
     */
    protected $superclass_table_id;

    /**
     * The value for the is_updateable field.
     * Note: this column has a database default value of: 1
     * @var        int
     */
    protected $is_updateable;

    /**
     * The value for the modification_date field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $modification_date;

    /**
     * @var        PropelObjectCollection|Control[] Collection to store aggregation of Control objects.
     */
    protected $collControls;
    protected $collControlsPartial;

    /**
     * @var        PropelObjectCollection|Magedocumentation[] Collection to store aggregation of Magedocumentation objects.
     */
    protected $collMagedocumentations;
    protected $collMagedocumentationsPartial;

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
    protected $controlsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $magedocumentationsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_view = 0;
        $this->is_updateable = 1;
    }

    /**
     * Initializes internal state of BaseTableinfo object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [name] column value.
     *
     * @return string
     */
    public function getName()
    {
        return $this->name;
    }

    /**
     * Get the [primary_key_column] column value.
     *
     * @return string
     */
    public function getPrimaryKeyColumn()
    {
        return $this->primary_key_column;
    }

    /**
     * Get the [is_view] column value.
     *
     * @return int
     */
    public function getIsView()
    {
        return $this->is_view;
    }

    /**
     * Get the [view_on_table_id] column value.
     *
     * @return int
     */
    public function getViewOnTableId()
    {
        return $this->view_on_table_id;
    }

    /**
     * Get the [superclass_table_id] column value.
     *
     * @return int
     */
    public function getSuperclassTableId()
    {
        return $this->superclass_table_id;
    }

    /**
     * Get the [is_updateable] column value.
     *
     * @return int
     */
    public function getIsUpdateable()
    {
        return $this->is_updateable;
    }

    /**
     * Get the [optionally formatted] temporal [modification_date] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getModificationDate($format = '%x')
    {
        if ($this->modification_date === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->modification_date);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->modification_date, true), $x);
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
     * Set the value of [tableinfo_id] column.
     *
     * @param int $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setTableinfoId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->tableinfo_id !== $v) {
            $this->tableinfo_id = $v;
            $this->modifiedColumns[] = TableinfoPeer::TABLEINFO_ID;
        }


        return $this;
    } // setTableinfoId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = TableinfoPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [primary_key_column] column.
     *
     * @param string $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setPrimaryKeyColumn($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->primary_key_column !== $v) {
            $this->primary_key_column = $v;
            $this->modifiedColumns[] = TableinfoPeer::PRIMARY_KEY_COLUMN;
        }


        return $this;
    } // setPrimaryKeyColumn()

    /**
     * Set the value of [is_view] column.
     *
     * @param int $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setIsView($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_view !== $v) {
            $this->is_view = $v;
            $this->modifiedColumns[] = TableinfoPeer::IS_VIEW;
        }


        return $this;
    } // setIsView()

    /**
     * Set the value of [view_on_table_id] column.
     *
     * @param int $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setViewOnTableId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->view_on_table_id !== $v) {
            $this->view_on_table_id = $v;
            $this->modifiedColumns[] = TableinfoPeer::VIEW_ON_TABLE_ID;
        }


        return $this;
    } // setViewOnTableId()

    /**
     * Set the value of [superclass_table_id] column.
     *
     * @param int $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setSuperclassTableId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->superclass_table_id !== $v) {
            $this->superclass_table_id = $v;
            $this->modifiedColumns[] = TableinfoPeer::SUPERCLASS_TABLE_ID;
        }


        return $this;
    } // setSuperclassTableId()

    /**
     * Set the value of [is_updateable] column.
     *
     * @param int $v new value
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setIsUpdateable($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_updateable !== $v) {
            $this->is_updateable = $v;
            $this->modifiedColumns[] = TableinfoPeer::IS_UPDATEABLE;
        }


        return $this;
    } // setIsUpdateable()

    /**
     * Sets the value of [modification_date] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setModificationDate($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->modification_date !== null || $dt !== null) {
            $currentDateAsString = ($this->modification_date !== null && $tmpDt = new DateTime($this->modification_date)) ? $tmpDt->format('Y-m-d') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->modification_date = $newDateAsString;
                $this->modifiedColumns[] = TableinfoPeer::MODIFICATION_DATE;
            }
        } // if either are not null


        return $this;
    } // setModificationDate()

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
            if ($this->is_view !== 0) {
                return false;
            }

            if ($this->is_updateable !== 1) {
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

            $this->tableinfo_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->primary_key_column = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->is_view = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->view_on_table_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->superclass_table_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->is_updateable = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->modification_date = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 8; // 8 = TableinfoPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Tableinfo object", $e);
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
            $con = Propel::getConnection(TableinfoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = TableinfoPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collControls = null;

            $this->collMagedocumentations = null;

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
            $con = Propel::getConnection(TableinfoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = TableinfoQuery::create()
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
            $con = Propel::getConnection(TableinfoPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                TableinfoPeer::addInstanceToPool($this);
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

            if ($this->controlsScheduledForDeletion !== null) {
                if (!$this->controlsScheduledForDeletion->isEmpty()) {
                    ControlQuery::create()
                        ->filterByPrimaryKeys($this->controlsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->controlsScheduledForDeletion = null;
                }
            }

            if ($this->collControls !== null) {
                foreach ($this->collControls as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->magedocumentationsScheduledForDeletion !== null) {
                if (!$this->magedocumentationsScheduledForDeletion->isEmpty()) {
                    MagedocumentationQuery::create()
                        ->filterByPrimaryKeys($this->magedocumentationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->magedocumentationsScheduledForDeletion = null;
                }
            }

            if ($this->collMagedocumentations !== null) {
                foreach ($this->collMagedocumentations as $referrerFK) {
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

        $this->modifiedColumns[] = TableinfoPeer::TABLEINFO_ID;
        if (null !== $this->tableinfo_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . TableinfoPeer::TABLEINFO_ID . ')');
        }
        if (null === $this->tableinfo_id) {
            try {
                $stmt = $con->query("SELECT nextval('tableinfo_tableinfo_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->tableinfo_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(TableinfoPeer::TABLEINFO_ID)) {
            $modifiedColumns[':p' . $index++]  = '"tableinfo_id"';
        }
        if ($this->isColumnModified(TableinfoPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(TableinfoPeer::PRIMARY_KEY_COLUMN)) {
            $modifiedColumns[':p' . $index++]  = '"primary_key_column"';
        }
        if ($this->isColumnModified(TableinfoPeer::IS_VIEW)) {
            $modifiedColumns[':p' . $index++]  = '"is_view"';
        }
        if ($this->isColumnModified(TableinfoPeer::VIEW_ON_TABLE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"view_on_table_id"';
        }
        if ($this->isColumnModified(TableinfoPeer::SUPERCLASS_TABLE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"superclass_table_id"';
        }
        if ($this->isColumnModified(TableinfoPeer::IS_UPDATEABLE)) {
            $modifiedColumns[':p' . $index++]  = '"is_updateable"';
        }
        if ($this->isColumnModified(TableinfoPeer::MODIFICATION_DATE)) {
            $modifiedColumns[':p' . $index++]  = '"modification_date"';
        }

        $sql = sprintf(
            'INSERT INTO "tableinfo" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"tableinfo_id"':
                        $stmt->bindValue($identifier, $this->tableinfo_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"primary_key_column"':
                        $stmt->bindValue($identifier, $this->primary_key_column, PDO::PARAM_STR);
                        break;
                    case '"is_view"':
                        $stmt->bindValue($identifier, $this->is_view, PDO::PARAM_INT);
                        break;
                    case '"view_on_table_id"':
                        $stmt->bindValue($identifier, $this->view_on_table_id, PDO::PARAM_INT);
                        break;
                    case '"superclass_table_id"':
                        $stmt->bindValue($identifier, $this->superclass_table_id, PDO::PARAM_INT);
                        break;
                    case '"is_updateable"':
                        $stmt->bindValue($identifier, $this->is_updateable, PDO::PARAM_INT);
                        break;
                    case '"modification_date"':
                        $stmt->bindValue($identifier, $this->modification_date, PDO::PARAM_STR);
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


            if (($retval = TableinfoPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collControls !== null) {
                    foreach ($this->collControls as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collMagedocumentations !== null) {
                    foreach ($this->collMagedocumentations as $referrerFK) {
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
        $pos = TableinfoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getTableinfoId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getPrimaryKeyColumn();
                break;
            case 3:
                return $this->getIsView();
                break;
            case 4:
                return $this->getViewOnTableId();
                break;
            case 5:
                return $this->getSuperclassTableId();
                break;
            case 6:
                return $this->getIsUpdateable();
                break;
            case 7:
                return $this->getModificationDate();
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
        if (isset($alreadyDumpedObjects['Tableinfo'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Tableinfo'][$this->getPrimaryKey()] = true;
        $keys = TableinfoPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getTableinfoId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getPrimaryKeyColumn(),
            $keys[3] => $this->getIsView(),
            $keys[4] => $this->getViewOnTableId(),
            $keys[5] => $this->getSuperclassTableId(),
            $keys[6] => $this->getIsUpdateable(),
            $keys[7] => $this->getModificationDate(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collControls) {
                $result['Controls'] = $this->collControls->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collMagedocumentations) {
                $result['Magedocumentations'] = $this->collMagedocumentations->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = TableinfoPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setTableinfoId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setPrimaryKeyColumn($value);
                break;
            case 3:
                $this->setIsView($value);
                break;
            case 4:
                $this->setViewOnTableId($value);
                break;
            case 5:
                $this->setSuperclassTableId($value);
                break;
            case 6:
                $this->setIsUpdateable($value);
                break;
            case 7:
                $this->setModificationDate($value);
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
        $keys = TableinfoPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setTableinfoId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPrimaryKeyColumn($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setIsView($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setViewOnTableId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSuperclassTableId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsUpdateable($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setModificationDate($arr[$keys[7]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(TableinfoPeer::DATABASE_NAME);

        if ($this->isColumnModified(TableinfoPeer::TABLEINFO_ID)) $criteria->add(TableinfoPeer::TABLEINFO_ID, $this->tableinfo_id);
        if ($this->isColumnModified(TableinfoPeer::NAME)) $criteria->add(TableinfoPeer::NAME, $this->name);
        if ($this->isColumnModified(TableinfoPeer::PRIMARY_KEY_COLUMN)) $criteria->add(TableinfoPeer::PRIMARY_KEY_COLUMN, $this->primary_key_column);
        if ($this->isColumnModified(TableinfoPeer::IS_VIEW)) $criteria->add(TableinfoPeer::IS_VIEW, $this->is_view);
        if ($this->isColumnModified(TableinfoPeer::VIEW_ON_TABLE_ID)) $criteria->add(TableinfoPeer::VIEW_ON_TABLE_ID, $this->view_on_table_id);
        if ($this->isColumnModified(TableinfoPeer::SUPERCLASS_TABLE_ID)) $criteria->add(TableinfoPeer::SUPERCLASS_TABLE_ID, $this->superclass_table_id);
        if ($this->isColumnModified(TableinfoPeer::IS_UPDATEABLE)) $criteria->add(TableinfoPeer::IS_UPDATEABLE, $this->is_updateable);
        if ($this->isColumnModified(TableinfoPeer::MODIFICATION_DATE)) $criteria->add(TableinfoPeer::MODIFICATION_DATE, $this->modification_date);

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
        $criteria = new Criteria(TableinfoPeer::DATABASE_NAME);
        $criteria->add(TableinfoPeer::TABLEINFO_ID, $this->tableinfo_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getTableinfoId();
    }

    /**
     * Generic method to set the primary key (tableinfo_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setTableinfoId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getTableinfoId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Tableinfo (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setPrimaryKeyColumn($this->getPrimaryKeyColumn());
        $copyObj->setIsView($this->getIsView());
        $copyObj->setViewOnTableId($this->getViewOnTableId());
        $copyObj->setSuperclassTableId($this->getSuperclassTableId());
        $copyObj->setIsUpdateable($this->getIsUpdateable());
        $copyObj->setModificationDate($this->getModificationDate());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getControls() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addControl($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getMagedocumentations() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addMagedocumentation($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setTableinfoId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Tableinfo Clone of current object.
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
     * @return TableinfoPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new TableinfoPeer();
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
        if ('Control' == $relationName) {
            $this->initControls();
        }
        if ('Magedocumentation' == $relationName) {
            $this->initMagedocumentations();
        }
    }

    /**
     * Clears out the collControls collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Tableinfo The current object (for fluent API support)
     * @see        addControls()
     */
    public function clearControls()
    {
        $this->collControls = null; // important to set this to null since that means it is uninitialized
        $this->collControlsPartial = null;

        return $this;
    }

    /**
     * reset is the collControls collection loaded partially
     *
     * @return void
     */
    public function resetPartialControls($v = true)
    {
        $this->collControlsPartial = $v;
    }

    /**
     * Initializes the collControls collection.
     *
     * By default this just sets the collControls collection to an empty array (like clearcollControls());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initControls($overrideExisting = true)
    {
        if (null !== $this->collControls && !$overrideExisting) {
            return;
        }
        $this->collControls = new PropelObjectCollection();
        $this->collControls->setModel('Control');
    }

    /**
     * Gets an array of Control objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Tableinfo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Control[] List of Control objects
     * @throws PropelException
     */
    public function getControls($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collControlsPartial && !$this->isNew();
        if (null === $this->collControls || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collControls) {
                // return empty collection
                $this->initControls();
            } else {
                $collControls = ControlQuery::create(null, $criteria)
                    ->filterByTableinfo($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collControlsPartial && count($collControls)) {
                      $this->initControls(false);

                      foreach($collControls as $obj) {
                        if (false == $this->collControls->contains($obj)) {
                          $this->collControls->append($obj);
                        }
                      }

                      $this->collControlsPartial = true;
                    }

                    $collControls->getInternalIterator()->rewind();
                    return $collControls;
                }

                if($partial && $this->collControls) {
                    foreach($this->collControls as $obj) {
                        if($obj->isNew()) {
                            $collControls[] = $obj;
                        }
                    }
                }

                $this->collControls = $collControls;
                $this->collControlsPartial = false;
            }
        }

        return $this->collControls;
    }

    /**
     * Sets a collection of Control objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $controls A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setControls(PropelCollection $controls, PropelPDO $con = null)
    {
        $controlsToDelete = $this->getControls(new Criteria(), $con)->diff($controls);

        $this->controlsScheduledForDeletion = unserialize(serialize($controlsToDelete));

        foreach ($controlsToDelete as $controlRemoved) {
            $controlRemoved->setTableinfo(null);
        }

        $this->collControls = null;
        foreach ($controls as $control) {
            $this->addControl($control);
        }

        $this->collControls = $controls;
        $this->collControlsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Control objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Control objects.
     * @throws PropelException
     */
    public function countControls(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collControlsPartial && !$this->isNew();
        if (null === $this->collControls || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collControls) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getControls());
            }
            $query = ControlQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTableinfo($this)
                ->count($con);
        }

        return count($this->collControls);
    }

    /**
     * Method called to associate a Control object to this object
     * through the Control foreign key attribute.
     *
     * @param    Control $l Control
     * @return Tableinfo The current object (for fluent API support)
     */
    public function addControl(Control $l)
    {
        if ($this->collControls === null) {
            $this->initControls();
            $this->collControlsPartial = true;
        }
        if (!in_array($l, $this->collControls->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddControl($l);
        }

        return $this;
    }

    /**
     * @param	Control $control The control object to add.
     */
    protected function doAddControl($control)
    {
        $this->collControls[]= $control;
        $control->setTableinfo($this);
    }

    /**
     * @param	Control $control The control object to remove.
     * @return Tableinfo The current object (for fluent API support)
     */
    public function removeControl($control)
    {
        if ($this->getControls()->contains($control)) {
            $this->collControls->remove($this->collControls->search($control));
            if (null === $this->controlsScheduledForDeletion) {
                $this->controlsScheduledForDeletion = clone $this->collControls;
                $this->controlsScheduledForDeletion->clear();
            }
            $this->controlsScheduledForDeletion[]= clone $control;
            $control->setTableinfo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tableinfo is new, it will return
     * an empty collection; or if this Tableinfo has previously
     * been saved, it will retrieve related Controls from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tableinfo.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Control[] List of Control objects
     */
    public function getControlsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ControlQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getControls($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tableinfo is new, it will return
     * an empty collection; or if this Tableinfo has previously
     * been saved, it will retrieve related Controls from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tableinfo.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Control[] List of Control objects
     */
    public function getControlsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ControlQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getControls($query, $con);
    }

    /**
     * Clears out the collMagedocumentations collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Tableinfo The current object (for fluent API support)
     * @see        addMagedocumentations()
     */
    public function clearMagedocumentations()
    {
        $this->collMagedocumentations = null; // important to set this to null since that means it is uninitialized
        $this->collMagedocumentationsPartial = null;

        return $this;
    }

    /**
     * reset is the collMagedocumentations collection loaded partially
     *
     * @return void
     */
    public function resetPartialMagedocumentations($v = true)
    {
        $this->collMagedocumentationsPartial = $v;
    }

    /**
     * Initializes the collMagedocumentations collection.
     *
     * By default this just sets the collMagedocumentations collection to an empty array (like clearcollMagedocumentations());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initMagedocumentations($overrideExisting = true)
    {
        if (null !== $this->collMagedocumentations && !$overrideExisting) {
            return;
        }
        $this->collMagedocumentations = new PropelObjectCollection();
        $this->collMagedocumentations->setModel('Magedocumentation');
    }

    /**
     * Gets an array of Magedocumentation objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Tableinfo is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Magedocumentation[] List of Magedocumentation objects
     * @throws PropelException
     */
    public function getMagedocumentations($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collMagedocumentationsPartial && !$this->isNew();
        if (null === $this->collMagedocumentations || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collMagedocumentations) {
                // return empty collection
                $this->initMagedocumentations();
            } else {
                $collMagedocumentations = MagedocumentationQuery::create(null, $criteria)
                    ->filterByTableinfo($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collMagedocumentationsPartial && count($collMagedocumentations)) {
                      $this->initMagedocumentations(false);

                      foreach($collMagedocumentations as $obj) {
                        if (false == $this->collMagedocumentations->contains($obj)) {
                          $this->collMagedocumentations->append($obj);
                        }
                      }

                      $this->collMagedocumentationsPartial = true;
                    }

                    $collMagedocumentations->getInternalIterator()->rewind();
                    return $collMagedocumentations;
                }

                if($partial && $this->collMagedocumentations) {
                    foreach($this->collMagedocumentations as $obj) {
                        if($obj->isNew()) {
                            $collMagedocumentations[] = $obj;
                        }
                    }
                }

                $this->collMagedocumentations = $collMagedocumentations;
                $this->collMagedocumentationsPartial = false;
            }
        }

        return $this->collMagedocumentations;
    }

    /**
     * Sets a collection of Magedocumentation objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $magedocumentations A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Tableinfo The current object (for fluent API support)
     */
    public function setMagedocumentations(PropelCollection $magedocumentations, PropelPDO $con = null)
    {
        $magedocumentationsToDelete = $this->getMagedocumentations(new Criteria(), $con)->diff($magedocumentations);

        $this->magedocumentationsScheduledForDeletion = unserialize(serialize($magedocumentationsToDelete));

        foreach ($magedocumentationsToDelete as $magedocumentationRemoved) {
            $magedocumentationRemoved->setTableinfo(null);
        }

        $this->collMagedocumentations = null;
        foreach ($magedocumentations as $magedocumentation) {
            $this->addMagedocumentation($magedocumentation);
        }

        $this->collMagedocumentations = $magedocumentations;
        $this->collMagedocumentationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Magedocumentation objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Magedocumentation objects.
     * @throws PropelException
     */
    public function countMagedocumentations(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collMagedocumentationsPartial && !$this->isNew();
        if (null === $this->collMagedocumentations || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collMagedocumentations) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getMagedocumentations());
            }
            $query = MagedocumentationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByTableinfo($this)
                ->count($con);
        }

        return count($this->collMagedocumentations);
    }

    /**
     * Method called to associate a Magedocumentation object to this object
     * through the Magedocumentation foreign key attribute.
     *
     * @param    Magedocumentation $l Magedocumentation
     * @return Tableinfo The current object (for fluent API support)
     */
    public function addMagedocumentation(Magedocumentation $l)
    {
        if ($this->collMagedocumentations === null) {
            $this->initMagedocumentations();
            $this->collMagedocumentationsPartial = true;
        }
        if (!in_array($l, $this->collMagedocumentations->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddMagedocumentation($l);
        }

        return $this;
    }

    /**
     * @param	Magedocumentation $magedocumentation The magedocumentation object to add.
     */
    protected function doAddMagedocumentation($magedocumentation)
    {
        $this->collMagedocumentations[]= $magedocumentation;
        $magedocumentation->setTableinfo($this);
    }

    /**
     * @param	Magedocumentation $magedocumentation The magedocumentation object to remove.
     * @return Tableinfo The current object (for fluent API support)
     */
    public function removeMagedocumentation($magedocumentation)
    {
        if ($this->getMagedocumentations()->contains($magedocumentation)) {
            $this->collMagedocumentations->remove($this->collMagedocumentations->search($magedocumentation));
            if (null === $this->magedocumentationsScheduledForDeletion) {
                $this->magedocumentationsScheduledForDeletion = clone $this->collMagedocumentations;
                $this->magedocumentationsScheduledForDeletion->clear();
            }
            $this->magedocumentationsScheduledForDeletion[]= clone $magedocumentation;
            $magedocumentation->setTableinfo(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Tableinfo is new, it will return
     * an empty collection; or if this Tableinfo has previously
     * been saved, it will retrieve related Magedocumentations from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Tableinfo.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Magedocumentation[] List of Magedocumentation objects
     */
    public function getMagedocumentationsJoinMageml($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = MagedocumentationQuery::create(null, $criteria);
        $query->joinWith('Mageml', $join_behavior);

        return $this->getMagedocumentations($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->tableinfo_id = null;
        $this->name = null;
        $this->primary_key_column = null;
        $this->is_view = null;
        $this->view_on_table_id = null;
        $this->superclass_table_id = null;
        $this->is_updateable = null;
        $this->modification_date = null;
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
            if ($this->collControls) {
                foreach ($this->collControls as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collMagedocumentations) {
                foreach ($this->collMagedocumentations as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collControls instanceof PropelCollection) {
            $this->collControls->clearIterator();
        }
        $this->collControls = null;
        if ($this->collMagedocumentations instanceof PropelCollection) {
            $this->collMagedocumentations->clearIterator();
        }
        $this->collMagedocumentations = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(TableinfoPeer::DEFAULT_STRING_FORMAT);
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
