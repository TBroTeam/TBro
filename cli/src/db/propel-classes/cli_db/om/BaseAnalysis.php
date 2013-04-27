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
use cli_db\propel\Analysis;
use cli_db\propel\AnalysisPeer;
use cli_db\propel\AnalysisQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationQuery;

/**
 * Base class that represents a row from the 'analysis' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysis extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\AnalysisPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AnalysisPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the analysis_id field.
     * @var        int
     */
    protected $analysis_id;

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
     * The value for the program field.
     * @var        string
     */
    protected $program;

    /**
     * The value for the programversion field.
     * @var        string
     */
    protected $programversion;

    /**
     * The value for the algorithm field.
     * @var        string
     */
    protected $algorithm;

    /**
     * The value for the sourcename field.
     * @var        string
     */
    protected $sourcename;

    /**
     * The value for the sourceversion field.
     * @var        string
     */
    protected $sourceversion;

    /**
     * The value for the sourceuri field.
     * @var        string
     */
    protected $sourceuri;

    /**
     * The value for the timeexecuted field.
     * Note: this column has a database default value of: (expression) now()
     * @var        string
     */
    protected $timeexecuted;

    /**
     * @var        PropelObjectCollection|Quantification[] Collection to store aggregation of Quantification objects.
     */
    protected $collQuantifications;
    protected $collQuantificationsPartial;

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
    protected $quantificationsScheduledForDeletion = null;

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
     * Initializes internal state of BaseAnalysis object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [analysis_id] column value.
     *
     * @return int
     */
    public function getAnalysisId()
    {
        return $this->analysis_id;
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
     * Get the [program] column value.
     *
     * @return string
     */
    public function getProgram()
    {
        return $this->program;
    }

    /**
     * Get the [programversion] column value.
     *
     * @return string
     */
    public function getProgramversion()
    {
        return $this->programversion;
    }

    /**
     * Get the [algorithm] column value.
     *
     * @return string
     */
    public function getAlgorithm()
    {
        return $this->algorithm;
    }

    /**
     * Get the [sourcename] column value.
     *
     * @return string
     */
    public function getSourcename()
    {
        return $this->sourcename;
    }

    /**
     * Get the [sourceversion] column value.
     *
     * @return string
     */
    public function getSourceversion()
    {
        return $this->sourceversion;
    }

    /**
     * Get the [sourceuri] column value.
     *
     * @return string
     */
    public function getSourceuri()
    {
        return $this->sourceuri;
    }

    /**
     * Get the [optionally formatted] temporal [timeexecuted] column value.
     *
     *
     * @param string $format The date/time format string (either date()-style or strftime()-style).
     *				 If format is null, then the raw DateTime object will be returned.
     * @return mixed Formatted date/time value as string or DateTime object (if format is null), null if column is null
     * @throws PropelException - if unable to parse/validate the date/time value.
     */
    public function getTimeexecuted($format = 'Y-m-d H:i:s')
    {
        if ($this->timeexecuted === null) {
            return null;
        }


        try {
            $dt = new DateTime($this->timeexecuted);
        } catch (Exception $x) {
            throw new PropelException("Internally stored date/time/timestamp value could not be converted to DateTime: " . var_export($this->timeexecuted, true), $x);
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
     * Set the value of [analysis_id] column.
     *
     * @param int $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setAnalysisId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->analysis_id !== $v) {
            $this->analysis_id = $v;
            $this->modifiedColumns[] = AnalysisPeer::ANALYSIS_ID;
        }


        return $this;
    } // setAnalysisId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = AnalysisPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = AnalysisPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [program] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setProgram($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->program !== $v) {
            $this->program = $v;
            $this->modifiedColumns[] = AnalysisPeer::PROGRAM;
        }


        return $this;
    } // setProgram()

    /**
     * Set the value of [programversion] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setProgramversion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->programversion !== $v) {
            $this->programversion = $v;
            $this->modifiedColumns[] = AnalysisPeer::PROGRAMVERSION;
        }


        return $this;
    } // setProgramversion()

    /**
     * Set the value of [algorithm] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setAlgorithm($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->algorithm !== $v) {
            $this->algorithm = $v;
            $this->modifiedColumns[] = AnalysisPeer::ALGORITHM;
        }


        return $this;
    } // setAlgorithm()

    /**
     * Set the value of [sourcename] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setSourcename($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->sourcename !== $v) {
            $this->sourcename = $v;
            $this->modifiedColumns[] = AnalysisPeer::SOURCENAME;
        }


        return $this;
    } // setSourcename()

    /**
     * Set the value of [sourceversion] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setSourceversion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->sourceversion !== $v) {
            $this->sourceversion = $v;
            $this->modifiedColumns[] = AnalysisPeer::SOURCEVERSION;
        }


        return $this;
    } // setSourceversion()

    /**
     * Set the value of [sourceuri] column.
     *
     * @param string $v new value
     * @return Analysis The current object (for fluent API support)
     */
    public function setSourceuri($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->sourceuri !== $v) {
            $this->sourceuri = $v;
            $this->modifiedColumns[] = AnalysisPeer::SOURCEURI;
        }


        return $this;
    } // setSourceuri()

    /**
     * Sets the value of [timeexecuted] column to a normalized version of the date/time value specified.
     *
     * @param mixed $v string, integer (timestamp), or DateTime value.
     *               Empty strings are treated as null.
     * @return Analysis The current object (for fluent API support)
     */
    public function setTimeexecuted($v)
    {
        $dt = PropelDateTime::newInstance($v, null, 'DateTime');
        if ($this->timeexecuted !== null || $dt !== null) {
            $currentDateAsString = ($this->timeexecuted !== null && $tmpDt = new DateTime($this->timeexecuted)) ? $tmpDt->format('Y-m-d H:i:s') : null;
            $newDateAsString = $dt ? $dt->format('Y-m-d H:i:s') : null;
            if ($currentDateAsString !== $newDateAsString) {
                $this->timeexecuted = $newDateAsString;
                $this->modifiedColumns[] = AnalysisPeer::TIMEEXECUTED;
            }
        } // if either are not null


        return $this;
    } // setTimeexecuted()

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

            $this->analysis_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->program = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->programversion = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->algorithm = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->sourcename = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->sourceversion = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->sourceuri = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->timeexecuted = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 10; // 10 = AnalysisPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Analysis object", $e);
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
            $con = Propel::getConnection(AnalysisPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AnalysisPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collQuantifications = null;

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
            $con = Propel::getConnection(AnalysisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AnalysisQuery::create()
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
            $con = Propel::getConnection(AnalysisPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AnalysisPeer::addInstanceToPool($this);
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

            if ($this->quantificationsScheduledForDeletion !== null) {
                if (!$this->quantificationsScheduledForDeletion->isEmpty()) {
                    QuantificationQuery::create()
                        ->filterByPrimaryKeys($this->quantificationsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->quantificationsScheduledForDeletion = null;
                }
            }

            if ($this->collQuantifications !== null) {
                foreach ($this->collQuantifications as $referrerFK) {
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

        $this->modifiedColumns[] = AnalysisPeer::ANALYSIS_ID;
        if (null !== $this->analysis_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AnalysisPeer::ANALYSIS_ID . ')');
        }
        if (null === $this->analysis_id) {
            try {
                $stmt = $con->query("SELECT nextval('analysis_analysis_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->analysis_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AnalysisPeer::ANALYSIS_ID)) {
            $modifiedColumns[':p' . $index++]  = '"analysis_id"';
        }
        if ($this->isColumnModified(AnalysisPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(AnalysisPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }
        if ($this->isColumnModified(AnalysisPeer::PROGRAM)) {
            $modifiedColumns[':p' . $index++]  = '"program"';
        }
        if ($this->isColumnModified(AnalysisPeer::PROGRAMVERSION)) {
            $modifiedColumns[':p' . $index++]  = '"programversion"';
        }
        if ($this->isColumnModified(AnalysisPeer::ALGORITHM)) {
            $modifiedColumns[':p' . $index++]  = '"algorithm"';
        }
        if ($this->isColumnModified(AnalysisPeer::SOURCENAME)) {
            $modifiedColumns[':p' . $index++]  = '"sourcename"';
        }
        if ($this->isColumnModified(AnalysisPeer::SOURCEVERSION)) {
            $modifiedColumns[':p' . $index++]  = '"sourceversion"';
        }
        if ($this->isColumnModified(AnalysisPeer::SOURCEURI)) {
            $modifiedColumns[':p' . $index++]  = '"sourceuri"';
        }
        if ($this->isColumnModified(AnalysisPeer::TIMEEXECUTED)) {
            $modifiedColumns[':p' . $index++]  = '"timeexecuted"';
        }

        $sql = sprintf(
            'INSERT INTO "analysis" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"analysis_id"':
                        $stmt->bindValue($identifier, $this->analysis_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"description"':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '"program"':
                        $stmt->bindValue($identifier, $this->program, PDO::PARAM_STR);
                        break;
                    case '"programversion"':
                        $stmt->bindValue($identifier, $this->programversion, PDO::PARAM_STR);
                        break;
                    case '"algorithm"':
                        $stmt->bindValue($identifier, $this->algorithm, PDO::PARAM_STR);
                        break;
                    case '"sourcename"':
                        $stmt->bindValue($identifier, $this->sourcename, PDO::PARAM_STR);
                        break;
                    case '"sourceversion"':
                        $stmt->bindValue($identifier, $this->sourceversion, PDO::PARAM_STR);
                        break;
                    case '"sourceuri"':
                        $stmt->bindValue($identifier, $this->sourceuri, PDO::PARAM_STR);
                        break;
                    case '"timeexecuted"':
                        $stmt->bindValue($identifier, $this->timeexecuted, PDO::PARAM_STR);
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


            if (($retval = AnalysisPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collQuantifications !== null) {
                    foreach ($this->collQuantifications as $referrerFK) {
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
        $pos = AnalysisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAnalysisId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
                return $this->getDescription();
                break;
            case 3:
                return $this->getProgram();
                break;
            case 4:
                return $this->getProgramversion();
                break;
            case 5:
                return $this->getAlgorithm();
                break;
            case 6:
                return $this->getSourcename();
                break;
            case 7:
                return $this->getSourceversion();
                break;
            case 8:
                return $this->getSourceuri();
                break;
            case 9:
                return $this->getTimeexecuted();
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
        if (isset($alreadyDumpedObjects['Analysis'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Analysis'][$this->getPrimaryKey()] = true;
        $keys = AnalysisPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAnalysisId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
            $keys[3] => $this->getProgram(),
            $keys[4] => $this->getProgramversion(),
            $keys[5] => $this->getAlgorithm(),
            $keys[6] => $this->getSourcename(),
            $keys[7] => $this->getSourceversion(),
            $keys[8] => $this->getSourceuri(),
            $keys[9] => $this->getTimeexecuted(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collQuantifications) {
                $result['Quantifications'] = $this->collQuantifications->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AnalysisPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAnalysisId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
                $this->setDescription($value);
                break;
            case 3:
                $this->setProgram($value);
                break;
            case 4:
                $this->setProgramversion($value);
                break;
            case 5:
                $this->setAlgorithm($value);
                break;
            case 6:
                $this->setSourcename($value);
                break;
            case 7:
                $this->setSourceversion($value);
                break;
            case 8:
                $this->setSourceuri($value);
                break;
            case 9:
                $this->setTimeexecuted($value);
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
        $keys = AnalysisPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setAnalysisId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setProgram($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setProgramversion($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setAlgorithm($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setSourcename($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setSourceversion($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setSourceuri($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setTimeexecuted($arr[$keys[9]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AnalysisPeer::DATABASE_NAME);

        if ($this->isColumnModified(AnalysisPeer::ANALYSIS_ID)) $criteria->add(AnalysisPeer::ANALYSIS_ID, $this->analysis_id);
        if ($this->isColumnModified(AnalysisPeer::NAME)) $criteria->add(AnalysisPeer::NAME, $this->name);
        if ($this->isColumnModified(AnalysisPeer::DESCRIPTION)) $criteria->add(AnalysisPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(AnalysisPeer::PROGRAM)) $criteria->add(AnalysisPeer::PROGRAM, $this->program);
        if ($this->isColumnModified(AnalysisPeer::PROGRAMVERSION)) $criteria->add(AnalysisPeer::PROGRAMVERSION, $this->programversion);
        if ($this->isColumnModified(AnalysisPeer::ALGORITHM)) $criteria->add(AnalysisPeer::ALGORITHM, $this->algorithm);
        if ($this->isColumnModified(AnalysisPeer::SOURCENAME)) $criteria->add(AnalysisPeer::SOURCENAME, $this->sourcename);
        if ($this->isColumnModified(AnalysisPeer::SOURCEVERSION)) $criteria->add(AnalysisPeer::SOURCEVERSION, $this->sourceversion);
        if ($this->isColumnModified(AnalysisPeer::SOURCEURI)) $criteria->add(AnalysisPeer::SOURCEURI, $this->sourceuri);
        if ($this->isColumnModified(AnalysisPeer::TIMEEXECUTED)) $criteria->add(AnalysisPeer::TIMEEXECUTED, $this->timeexecuted);

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
        $criteria = new Criteria(AnalysisPeer::DATABASE_NAME);
        $criteria->add(AnalysisPeer::ANALYSIS_ID, $this->analysis_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getAnalysisId();
    }

    /**
     * Generic method to set the primary key (analysis_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAnalysisId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getAnalysisId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Analysis (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setProgram($this->getProgram());
        $copyObj->setProgramversion($this->getProgramversion());
        $copyObj->setAlgorithm($this->getAlgorithm());
        $copyObj->setSourcename($this->getSourcename());
        $copyObj->setSourceversion($this->getSourceversion());
        $copyObj->setSourceuri($this->getSourceuri());
        $copyObj->setTimeexecuted($this->getTimeexecuted());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getQuantifications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantification($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAnalysisId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Analysis Clone of current object.
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
     * @return AnalysisPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AnalysisPeer();
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
        if ('Quantification' == $relationName) {
            $this->initQuantifications();
        }
    }

    /**
     * Clears out the collQuantifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Analysis The current object (for fluent API support)
     * @see        addQuantifications()
     */
    public function clearQuantifications()
    {
        $this->collQuantifications = null; // important to set this to null since that means it is uninitialized
        $this->collQuantificationsPartial = null;

        return $this;
    }

    /**
     * reset is the collQuantifications collection loaded partially
     *
     * @return void
     */
    public function resetPartialQuantifications($v = true)
    {
        $this->collQuantificationsPartial = $v;
    }

    /**
     * Initializes the collQuantifications collection.
     *
     * By default this just sets the collQuantifications collection to an empty array (like clearcollQuantifications());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initQuantifications($overrideExisting = true)
    {
        if (null !== $this->collQuantifications && !$overrideExisting) {
            return;
        }
        $this->collQuantifications = new PropelObjectCollection();
        $this->collQuantifications->setModel('Quantification');
    }

    /**
     * Gets an array of Quantification objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Analysis is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     * @throws PropelException
     */
    public function getQuantifications($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationsPartial && !$this->isNew();
        if (null === $this->collQuantifications || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collQuantifications) {
                // return empty collection
                $this->initQuantifications();
            } else {
                $collQuantifications = QuantificationQuery::create(null, $criteria)
                    ->filterByAnalysis($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collQuantificationsPartial && count($collQuantifications)) {
                      $this->initQuantifications(false);

                      foreach($collQuantifications as $obj) {
                        if (false == $this->collQuantifications->contains($obj)) {
                          $this->collQuantifications->append($obj);
                        }
                      }

                      $this->collQuantificationsPartial = true;
                    }

                    $collQuantifications->getInternalIterator()->rewind();
                    return $collQuantifications;
                }

                if($partial && $this->collQuantifications) {
                    foreach($this->collQuantifications as $obj) {
                        if($obj->isNew()) {
                            $collQuantifications[] = $obj;
                        }
                    }
                }

                $this->collQuantifications = $collQuantifications;
                $this->collQuantificationsPartial = false;
            }
        }

        return $this->collQuantifications;
    }

    /**
     * Sets a collection of Quantification objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $quantifications A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Analysis The current object (for fluent API support)
     */
    public function setQuantifications(PropelCollection $quantifications, PropelPDO $con = null)
    {
        $quantificationsToDelete = $this->getQuantifications(new Criteria(), $con)->diff($quantifications);

        $this->quantificationsScheduledForDeletion = unserialize(serialize($quantificationsToDelete));

        foreach ($quantificationsToDelete as $quantificationRemoved) {
            $quantificationRemoved->setAnalysis(null);
        }

        $this->collQuantifications = null;
        foreach ($quantifications as $quantification) {
            $this->addQuantification($quantification);
        }

        $this->collQuantifications = $quantifications;
        $this->collQuantificationsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Quantification objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Quantification objects.
     * @throws PropelException
     */
    public function countQuantifications(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collQuantificationsPartial && !$this->isNew();
        if (null === $this->collQuantifications || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collQuantifications) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getQuantifications());
            }
            $query = QuantificationQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAnalysis($this)
                ->count($con);
        }

        return count($this->collQuantifications);
    }

    /**
     * Method called to associate a Quantification object to this object
     * through the Quantification foreign key attribute.
     *
     * @param    Quantification $l Quantification
     * @return Analysis The current object (for fluent API support)
     */
    public function addQuantification(Quantification $l)
    {
        if ($this->collQuantifications === null) {
            $this->initQuantifications();
            $this->collQuantificationsPartial = true;
        }
        if (!in_array($l, $this->collQuantifications->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddQuantification($l);
        }

        return $this;
    }

    /**
     * @param	Quantification $quantification The quantification object to add.
     */
    protected function doAddQuantification($quantification)
    {
        $this->collQuantifications[]= $quantification;
        $quantification->setAnalysis($this);
    }

    /**
     * @param	Quantification $quantification The quantification object to remove.
     * @return Analysis The current object (for fluent API support)
     */
    public function removeQuantification($quantification)
    {
        if ($this->getQuantifications()->contains($quantification)) {
            $this->collQuantifications->remove($this->collQuantifications->search($quantification));
            if (null === $this->quantificationsScheduledForDeletion) {
                $this->quantificationsScheduledForDeletion = clone $this->collQuantifications;
                $this->quantificationsScheduledForDeletion->clear();
            }
            $this->quantificationsScheduledForDeletion[]= clone $quantification;
            $quantification->setAnalysis(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Analysis is new, it will return
     * an empty collection; or if this Analysis has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Analysis.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinAcquisition($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Acquisition', $join_behavior);

        return $this->getQuantifications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Analysis is new, it will return
     * an empty collection; or if this Analysis has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Analysis.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getQuantifications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Analysis is new, it will return
     * an empty collection; or if this Analysis has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Analysis.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getQuantifications($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->analysis_id = null;
        $this->name = null;
        $this->description = null;
        $this->program = null;
        $this->programversion = null;
        $this->algorithm = null;
        $this->sourcename = null;
        $this->sourceversion = null;
        $this->sourceuri = null;
        $this->timeexecuted = null;
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
            if ($this->collQuantifications) {
                foreach ($this->collQuantifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collQuantifications instanceof PropelCollection) {
            $this->collQuantifications->clearIterator();
        }
        $this->collQuantifications = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AnalysisPeer::DEFAULT_STRING_FORMAT);
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
