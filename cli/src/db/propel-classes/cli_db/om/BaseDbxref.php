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
use cli_db\propel\Db;
use cli_db\propel\DbQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureCvtermDbxrefQuery;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\FeatureDbxrefQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\PubDbxref;
use cli_db\propel\PubDbxrefQuery;

/**
 * Base class that represents a row from the 'dbxref' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseDbxref extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\DbxrefPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        DbxrefPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * The value for the db_id field.
     * @var        int
     */
    protected $db_id;

    /**
     * The value for the accession field.
     * @var        string
     */
    protected $accession;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $version;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * @var        Db
     */
    protected $aDb;

    /**
     * @var        PropelObjectCollection|Feature[] Collection to store aggregation of Feature objects.
     */
    protected $collFeatures;
    protected $collFeaturesPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermDbxref[] Collection to store aggregation of FeatureCvtermDbxref objects.
     */
    protected $collFeatureCvtermDbxrefs;
    protected $collFeatureCvtermDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|FeatureDbxref[] Collection to store aggregation of FeatureDbxref objects.
     */
    protected $collFeatureDbxrefs;
    protected $collFeatureDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|PubDbxref[] Collection to store aggregation of PubDbxref objects.
     */
    protected $collPubDbxrefs;
    protected $collPubDbxrefsPartial;

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
    protected $featuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubDbxrefsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = '';
    }

    /**
     * Initializes internal state of BaseDbxref object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [db_id] column value.
     *
     * @return int
     */
    public function getDbId()
    {
        return $this->db_id;
    }

    /**
     * Get the [accession] column value.
     *
     * @return string
     */
    public function getAccession()
    {
        return $this->accession;
    }

    /**
     * Get the [version] column value.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
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
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = DbxrefPeer::DBXREF_ID;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [db_id] column.
     *
     * @param int $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDbId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->db_id !== $v) {
            $this->db_id = $v;
            $this->modifiedColumns[] = DbxrefPeer::DB_ID;
        }

        if ($this->aDb !== null && $this->aDb->getDbId() !== $v) {
            $this->aDb = null;
        }


        return $this;
    } // setDbId()

    /**
     * Set the value of [accession] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setAccession($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->accession !== $v) {
            $this->accession = $v;
            $this->modifiedColumns[] = DbxrefPeer::ACCESSION;
        }


        return $this;
    } // setAccession()

    /**
     * Set the value of [version] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[] = DbxrefPeer::VERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = DbxrefPeer::DESCRIPTION;
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
            if ($this->version !== '') {
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

            $this->dbxref_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->db_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->accession = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->version = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->description = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = DbxrefPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Dbxref object", $e);
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

        if ($this->aDb !== null && $this->db_id !== $this->aDb->getDbId()) {
            $this->aDb = null;
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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = DbxrefPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDb = null;
            $this->collFeatures = null;

            $this->collFeatureCvtermDbxrefs = null;

            $this->collFeatureDbxrefs = null;

            $this->collPubDbxrefs = null;

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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = DbxrefQuery::create()
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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                DbxrefPeer::addInstanceToPool($this);
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

            if ($this->aDb !== null) {
                if ($this->aDb->isModified() || $this->aDb->isNew()) {
                    $affectedRows += $this->aDb->save($con);
                }
                $this->setDb($this->aDb);
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

            if ($this->featuresScheduledForDeletion !== null) {
                if (!$this->featuresScheduledForDeletion->isEmpty()) {
                    foreach ($this->featuresScheduledForDeletion as $feature) {
                        // need to save related object because we set the relation to null
                        $feature->save($con);
                    }
                    $this->featuresScheduledForDeletion = null;
                }
            }

            if ($this->collFeatures !== null) {
                foreach ($this->collFeatures as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureCvtermDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureCvtermDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermDbxrefs !== null) {
                foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureDbxrefs !== null) {
                foreach ($this->collFeatureDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubDbxrefsScheduledForDeletion !== null) {
                if (!$this->pubDbxrefsScheduledForDeletion->isEmpty()) {
                    PubDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->pubDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collPubDbxrefs !== null) {
                foreach ($this->collPubDbxrefs as $referrerFK) {
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

        $this->modifiedColumns[] = DbxrefPeer::DBXREF_ID;
        if (null !== $this->dbxref_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DbxrefPeer::DBXREF_ID . ')');
        }
        if (null === $this->dbxref_id) {
            try {
                $stmt = $con->query("SELECT nextval('dbxref_dbxref_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->dbxref_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DbxrefPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(DbxrefPeer::DB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"db_id"';
        }
        if ($this->isColumnModified(DbxrefPeer::ACCESSION)) {
            $modifiedColumns[':p' . $index++]  = '"accession"';
        }
        if ($this->isColumnModified(DbxrefPeer::VERSION)) {
            $modifiedColumns[':p' . $index++]  = '"version"';
        }
        if ($this->isColumnModified(DbxrefPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "dbxref" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"db_id"':
                        $stmt->bindValue($identifier, $this->db_id, PDO::PARAM_INT);
                        break;
                    case '"accession"':
                        $stmt->bindValue($identifier, $this->accession, PDO::PARAM_STR);
                        break;
                    case '"version"':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
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

            if ($this->aDb !== null) {
                if (!$this->aDb->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDb->getValidationFailures());
                }
            }


            if (($retval = DbxrefPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collFeatures !== null) {
                    foreach ($this->collFeatures as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvtermDbxrefs !== null) {
                    foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureDbxrefs !== null) {
                    foreach ($this->collFeatureDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubDbxrefs !== null) {
                    foreach ($this->collPubDbxrefs as $referrerFK) {
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
        $pos = DbxrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getDbxrefId();
                break;
            case 1:
                return $this->getDbId();
                break;
            case 2:
                return $this->getAccession();
                break;
            case 3:
                return $this->getVersion();
                break;
            case 4:
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
        if (isset($alreadyDumpedObjects['Dbxref'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Dbxref'][$this->getPrimaryKey()] = true;
        $keys = DbxrefPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDbxrefId(),
            $keys[1] => $this->getDbId(),
            $keys[2] => $this->getAccession(),
            $keys[3] => $this->getVersion(),
            $keys[4] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aDb) {
                $result['Db'] = $this->aDb->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFeatures) {
                $result['Features'] = $this->collFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermDbxrefs) {
                $result['FeatureCvtermDbxrefs'] = $this->collFeatureCvtermDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureDbxrefs) {
                $result['FeatureDbxrefs'] = $this->collFeatureDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubDbxrefs) {
                $result['PubDbxrefs'] = $this->collPubDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = DbxrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setDbxrefId($value);
                break;
            case 1:
                $this->setDbId($value);
                break;
            case 2:
                $this->setAccession($value);
                break;
            case 3:
                $this->setVersion($value);
                break;
            case 4:
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
        $keys = DbxrefPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setDbxrefId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setDbId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAccession($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVersion($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(DbxrefPeer::DATABASE_NAME);

        if ($this->isColumnModified(DbxrefPeer::DBXREF_ID)) $criteria->add(DbxrefPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(DbxrefPeer::DB_ID)) $criteria->add(DbxrefPeer::DB_ID, $this->db_id);
        if ($this->isColumnModified(DbxrefPeer::ACCESSION)) $criteria->add(DbxrefPeer::ACCESSION, $this->accession);
        if ($this->isColumnModified(DbxrefPeer::VERSION)) $criteria->add(DbxrefPeer::VERSION, $this->version);
        if ($this->isColumnModified(DbxrefPeer::DESCRIPTION)) $criteria->add(DbxrefPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(DbxrefPeer::DATABASE_NAME);
        $criteria->add(DbxrefPeer::DBXREF_ID, $this->dbxref_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getDbxrefId();
    }

    /**
     * Generic method to set the primary key (dbxref_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setDbxrefId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getDbxrefId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Dbxref (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDbId($this->getDbId());
        $copyObj->setAccession($this->getAccession());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubDbxref($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setDbxrefId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Dbxref Clone of current object.
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
     * @return DbxrefPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new DbxrefPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Db object.
     *
     * @param             Db $v
     * @return Dbxref The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDb(Db $v = null)
    {
        if ($v === null) {
            $this->setDbId(NULL);
        } else {
            $this->setDbId($v->getDbId());
        }

        $this->aDb = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Db object, it will not be re-added.
        if ($v !== null) {
            $v->addDbxref($this);
        }


        return $this;
    }


    /**
     * Get the associated Db object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Db The associated Db object.
     * @throws PropelException
     */
    public function getDb(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aDb === null && ($this->db_id !== null) && $doQuery) {
            $this->aDb = DbQuery::create()->findPk($this->db_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDb->addDbxrefs($this);
             */
        }

        return $this->aDb;
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
        if ('Feature' == $relationName) {
            $this->initFeatures();
        }
        if ('FeatureCvtermDbxref' == $relationName) {
            $this->initFeatureCvtermDbxrefs();
        }
        if ('FeatureDbxref' == $relationName) {
            $this->initFeatureDbxrefs();
        }
        if ('PubDbxref' == $relationName) {
            $this->initPubDbxrefs();
        }
    }

    /**
     * Clears out the collFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addFeatures()
     */
    public function clearFeatures()
    {
        $this->collFeatures = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturesPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatures collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatures($v = true)
    {
        $this->collFeaturesPartial = $v;
    }

    /**
     * Initializes the collFeatures collection.
     *
     * By default this just sets the collFeatures collection to an empty array (like clearcollFeatures());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatures($overrideExisting = true)
    {
        if (null !== $this->collFeatures && !$overrideExisting) {
            return;
        }
        $this->collFeatures = new PropelObjectCollection();
        $this->collFeatures->setModel('Feature');
    }

    /**
     * Gets an array of Feature objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Feature[] List of Feature objects
     * @throws PropelException
     */
    public function getFeatures($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturesPartial && !$this->isNew();
        if (null === $this->collFeatures || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatures) {
                // return empty collection
                $this->initFeatures();
            } else {
                $collFeatures = FeatureQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturesPartial && count($collFeatures)) {
                      $this->initFeatures(false);

                      foreach($collFeatures as $obj) {
                        if (false == $this->collFeatures->contains($obj)) {
                          $this->collFeatures->append($obj);
                        }
                      }

                      $this->collFeaturesPartial = true;
                    }

                    $collFeatures->getInternalIterator()->rewind();
                    return $collFeatures;
                }

                if($partial && $this->collFeatures) {
                    foreach($this->collFeatures as $obj) {
                        if($obj->isNew()) {
                            $collFeatures[] = $obj;
                        }
                    }
                }

                $this->collFeatures = $collFeatures;
                $this->collFeaturesPartial = false;
            }
        }

        return $this->collFeatures;
    }

    /**
     * Sets a collection of Feature objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $features A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatures(PropelCollection $features, PropelPDO $con = null)
    {
        $featuresToDelete = $this->getFeatures(new Criteria(), $con)->diff($features);

        $this->featuresScheduledForDeletion = unserialize(serialize($featuresToDelete));

        foreach ($featuresToDelete as $featureRemoved) {
            $featureRemoved->setDbxref(null);
        }

        $this->collFeatures = null;
        foreach ($features as $feature) {
            $this->addFeature($feature);
        }

        $this->collFeatures = $features;
        $this->collFeaturesPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Feature objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Feature objects.
     * @throws PropelException
     */
    public function countFeatures(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturesPartial && !$this->isNew();
        if (null === $this->collFeatures || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatures) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatures());
            }
            $query = FeatureQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatures);
    }

    /**
     * Method called to associate a Feature object to this object
     * through the Feature foreign key attribute.
     *
     * @param    Feature $l Feature
     * @return Dbxref The current object (for fluent API support)
     */
    public function addFeature(Feature $l)
    {
        if ($this->collFeatures === null) {
            $this->initFeatures();
            $this->collFeaturesPartial = true;
        }
        if (!in_array($l, $this->collFeatures->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeature($l);
        }

        return $this;
    }

    /**
     * @param	Feature $feature The feature object to add.
     */
    protected function doAddFeature($feature)
    {
        $this->collFeatures[]= $feature;
        $feature->setDbxref($this);
    }

    /**
     * @param	Feature $feature The feature object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeature($feature)
    {
        if ($this->getFeatures()->contains($feature)) {
            $this->collFeatures->remove($this->collFeatures->search($feature));
            if (null === $this->featuresScheduledForDeletion) {
                $this->featuresScheduledForDeletion = clone $this->collFeatures;
                $this->featuresScheduledForDeletion->clear();
            }
            $this->featuresScheduledForDeletion[]= $feature;
            $feature->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getFeatures($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatures($query, $con);
    }

    /**
     * Clears out the collFeatureCvtermDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addFeatureCvtermDbxrefs()
     */
    public function clearFeatureCvtermDbxrefs()
    {
        $this->collFeatureCvtermDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermDbxrefs($v = true)
    {
        $this->collFeatureCvtermDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermDbxrefs collection.
     *
     * By default this just sets the collFeatureCvtermDbxrefs collection to an empty array (like clearcollFeatureCvtermDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermDbxrefs = new PropelObjectCollection();
        $this->collFeatureCvtermDbxrefs->setModel('FeatureCvtermDbxref');
    }

    /**
     * Gets an array of FeatureCvtermDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     * @throws PropelException
     */
    public function getFeatureCvtermDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                // return empty collection
                $this->initFeatureCvtermDbxrefs();
            } else {
                $collFeatureCvtermDbxrefs = FeatureCvtermDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermDbxrefsPartial && count($collFeatureCvtermDbxrefs)) {
                      $this->initFeatureCvtermDbxrefs(false);

                      foreach($collFeatureCvtermDbxrefs as $obj) {
                        if (false == $this->collFeatureCvtermDbxrefs->contains($obj)) {
                          $this->collFeatureCvtermDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureCvtermDbxrefsPartial = true;
                    }

                    $collFeatureCvtermDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureCvtermDbxrefs;
                }

                if($partial && $this->collFeatureCvtermDbxrefs) {
                    foreach($this->collFeatureCvtermDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermDbxrefs = $collFeatureCvtermDbxrefs;
                $this->collFeatureCvtermDbxrefsPartial = false;
            }
        }

        return $this->collFeatureCvtermDbxrefs;
    }

    /**
     * Sets a collection of FeatureCvtermDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatureCvtermDbxrefs(PropelCollection $featureCvtermDbxrefs, PropelPDO $con = null)
    {
        $featureCvtermDbxrefsToDelete = $this->getFeatureCvtermDbxrefs(new Criteria(), $con)->diff($featureCvtermDbxrefs);

        $this->featureCvtermDbxrefsScheduledForDeletion = unserialize(serialize($featureCvtermDbxrefsToDelete));

        foreach ($featureCvtermDbxrefsToDelete as $featureCvtermDbxrefRemoved) {
            $featureCvtermDbxrefRemoved->setDbxref(null);
        }

        $this->collFeatureCvtermDbxrefs = null;
        foreach ($featureCvtermDbxrefs as $featureCvtermDbxref) {
            $this->addFeatureCvtermDbxref($featureCvtermDbxref);
        }

        $this->collFeatureCvtermDbxrefs = $featureCvtermDbxrefs;
        $this->collFeatureCvtermDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermDbxref objects.
     * @throws PropelException
     */
    public function countFeatureCvtermDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermDbxrefs());
            }
            $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermDbxrefs);
    }

    /**
     * Method called to associate a FeatureCvtermDbxref object to this object
     * through the FeatureCvtermDbxref foreign key attribute.
     *
     * @param    FeatureCvtermDbxref $l FeatureCvtermDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addFeatureCvtermDbxref(FeatureCvtermDbxref $l)
    {
        if ($this->collFeatureCvtermDbxrefs === null) {
            $this->initFeatureCvtermDbxrefs();
            $this->collFeatureCvtermDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to add.
     */
    protected function doAddFeatureCvtermDbxref($featureCvtermDbxref)
    {
        $this->collFeatureCvtermDbxrefs[]= $featureCvtermDbxref;
        $featureCvtermDbxref->setDbxref($this);
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeatureCvtermDbxref($featureCvtermDbxref)
    {
        if ($this->getFeatureCvtermDbxrefs()->contains($featureCvtermDbxref)) {
            $this->collFeatureCvtermDbxrefs->remove($this->collFeatureCvtermDbxrefs->search($featureCvtermDbxref));
            if (null === $this->featureCvtermDbxrefsScheduledForDeletion) {
                $this->featureCvtermDbxrefsScheduledForDeletion = clone $this->collFeatureCvtermDbxrefs;
                $this->featureCvtermDbxrefsScheduledForDeletion->clear();
            }
            $this->featureCvtermDbxrefsScheduledForDeletion[]= clone $featureCvtermDbxref;
            $featureCvtermDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related FeatureCvtermDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     */
    public function getFeatureCvtermDbxrefsJoinFeatureCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
        $query->joinWith('FeatureCvterm', $join_behavior);

        return $this->getFeatureCvtermDbxrefs($query, $con);
    }

    /**
     * Clears out the collFeatureDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addFeatureDbxrefs()
     */
    public function clearFeatureDbxrefs()
    {
        $this->collFeatureDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureDbxrefs($v = true)
    {
        $this->collFeatureDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureDbxrefs collection.
     *
     * By default this just sets the collFeatureDbxrefs collection to an empty array (like clearcollFeatureDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureDbxrefs = new PropelObjectCollection();
        $this->collFeatureDbxrefs->setModel('FeatureDbxref');
    }

    /**
     * Gets an array of FeatureDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     * @throws PropelException
     */
    public function getFeatureDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                // return empty collection
                $this->initFeatureDbxrefs();
            } else {
                $collFeatureDbxrefs = FeatureDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureDbxrefsPartial && count($collFeatureDbxrefs)) {
                      $this->initFeatureDbxrefs(false);

                      foreach($collFeatureDbxrefs as $obj) {
                        if (false == $this->collFeatureDbxrefs->contains($obj)) {
                          $this->collFeatureDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureDbxrefsPartial = true;
                    }

                    $collFeatureDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureDbxrefs;
                }

                if($partial && $this->collFeatureDbxrefs) {
                    foreach($this->collFeatureDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureDbxrefs = $collFeatureDbxrefs;
                $this->collFeatureDbxrefsPartial = false;
            }
        }

        return $this->collFeatureDbxrefs;
    }

    /**
     * Sets a collection of FeatureDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatureDbxrefs(PropelCollection $featureDbxrefs, PropelPDO $con = null)
    {
        $featureDbxrefsToDelete = $this->getFeatureDbxrefs(new Criteria(), $con)->diff($featureDbxrefs);

        $this->featureDbxrefsScheduledForDeletion = unserialize(serialize($featureDbxrefsToDelete));

        foreach ($featureDbxrefsToDelete as $featureDbxrefRemoved) {
            $featureDbxrefRemoved->setDbxref(null);
        }

        $this->collFeatureDbxrefs = null;
        foreach ($featureDbxrefs as $featureDbxref) {
            $this->addFeatureDbxref($featureDbxref);
        }

        $this->collFeatureDbxrefs = $featureDbxrefs;
        $this->collFeatureDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureDbxref objects.
     * @throws PropelException
     */
    public function countFeatureDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureDbxrefs());
            }
            $query = FeatureDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatureDbxrefs);
    }

    /**
     * Method called to associate a FeatureDbxref object to this object
     * through the FeatureDbxref foreign key attribute.
     *
     * @param    FeatureDbxref $l FeatureDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addFeatureDbxref(FeatureDbxref $l)
    {
        if ($this->collFeatureDbxrefs === null) {
            $this->initFeatureDbxrefs();
            $this->collFeatureDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to add.
     */
    protected function doAddFeatureDbxref($featureDbxref)
    {
        $this->collFeatureDbxrefs[]= $featureDbxref;
        $featureDbxref->setDbxref($this);
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeatureDbxref($featureDbxref)
    {
        if ($this->getFeatureDbxrefs()->contains($featureDbxref)) {
            $this->collFeatureDbxrefs->remove($this->collFeatureDbxrefs->search($featureDbxref));
            if (null === $this->featureDbxrefsScheduledForDeletion) {
                $this->featureDbxrefsScheduledForDeletion = clone $this->collFeatureDbxrefs;
                $this->featureDbxrefsScheduledForDeletion->clear();
            }
            $this->featureDbxrefsScheduledForDeletion[]= clone $featureDbxref;
            $featureDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related FeatureDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     */
    public function getFeatureDbxrefsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureDbxrefQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureDbxrefs($query, $con);
    }

    /**
     * Clears out the collPubDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addPubDbxrefs()
     */
    public function clearPubDbxrefs()
    {
        $this->collPubDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collPubDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubDbxrefs($v = true)
    {
        $this->collPubDbxrefsPartial = $v;
    }

    /**
     * Initializes the collPubDbxrefs collection.
     *
     * By default this just sets the collPubDbxrefs collection to an empty array (like clearcollPubDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collPubDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collPubDbxrefs = new PropelObjectCollection();
        $this->collPubDbxrefs->setModel('PubDbxref');
    }

    /**
     * Gets an array of PubDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubDbxref[] List of PubDbxref objects
     * @throws PropelException
     */
    public function getPubDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubDbxrefsPartial && !$this->isNew();
        if (null === $this->collPubDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubDbxrefs) {
                // return empty collection
                $this->initPubDbxrefs();
            } else {
                $collPubDbxrefs = PubDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubDbxrefsPartial && count($collPubDbxrefs)) {
                      $this->initPubDbxrefs(false);

                      foreach($collPubDbxrefs as $obj) {
                        if (false == $this->collPubDbxrefs->contains($obj)) {
                          $this->collPubDbxrefs->append($obj);
                        }
                      }

                      $this->collPubDbxrefsPartial = true;
                    }

                    $collPubDbxrefs->getInternalIterator()->rewind();
                    return $collPubDbxrefs;
                }

                if($partial && $this->collPubDbxrefs) {
                    foreach($this->collPubDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collPubDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collPubDbxrefs = $collPubDbxrefs;
                $this->collPubDbxrefsPartial = false;
            }
        }

        return $this->collPubDbxrefs;
    }

    /**
     * Sets a collection of PubDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setPubDbxrefs(PropelCollection $pubDbxrefs, PropelPDO $con = null)
    {
        $pubDbxrefsToDelete = $this->getPubDbxrefs(new Criteria(), $con)->diff($pubDbxrefs);

        $this->pubDbxrefsScheduledForDeletion = unserialize(serialize($pubDbxrefsToDelete));

        foreach ($pubDbxrefsToDelete as $pubDbxrefRemoved) {
            $pubDbxrefRemoved->setDbxref(null);
        }

        $this->collPubDbxrefs = null;
        foreach ($pubDbxrefs as $pubDbxref) {
            $this->addPubDbxref($pubDbxref);
        }

        $this->collPubDbxrefs = $pubDbxrefs;
        $this->collPubDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PubDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PubDbxref objects.
     * @throws PropelException
     */
    public function countPubDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubDbxrefsPartial && !$this->isNew();
        if (null === $this->collPubDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubDbxrefs());
            }
            $query = PubDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collPubDbxrefs);
    }

    /**
     * Method called to associate a PubDbxref object to this object
     * through the PubDbxref foreign key attribute.
     *
     * @param    PubDbxref $l PubDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addPubDbxref(PubDbxref $l)
    {
        if ($this->collPubDbxrefs === null) {
            $this->initPubDbxrefs();
            $this->collPubDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collPubDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubDbxref($l);
        }

        return $this;
    }

    /**
     * @param	PubDbxref $pubDbxref The pubDbxref object to add.
     */
    protected function doAddPubDbxref($pubDbxref)
    {
        $this->collPubDbxrefs[]= $pubDbxref;
        $pubDbxref->setDbxref($this);
    }

    /**
     * @param	PubDbxref $pubDbxref The pubDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removePubDbxref($pubDbxref)
    {
        if ($this->getPubDbxrefs()->contains($pubDbxref)) {
            $this->collPubDbxrefs->remove($this->collPubDbxrefs->search($pubDbxref));
            if (null === $this->pubDbxrefsScheduledForDeletion) {
                $this->pubDbxrefsScheduledForDeletion = clone $this->collPubDbxrefs;
                $this->pubDbxrefsScheduledForDeletion->clear();
            }
            $this->pubDbxrefsScheduledForDeletion[]= clone $pubDbxref;
            $pubDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related PubDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubDbxref[] List of PubDbxref objects
     */
    public function getPubDbxrefsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubDbxrefQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getPubDbxrefs($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->dbxref_id = null;
        $this->db_id = null;
        $this->accession = null;
        $this->version = null;
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
            if ($this->collFeatures) {
                foreach ($this->collFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermDbxrefs) {
                foreach ($this->collFeatureCvtermDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureDbxrefs) {
                foreach ($this->collFeatureDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubDbxrefs) {
                foreach ($this->collPubDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aDb instanceof Persistent) {
              $this->aDb->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collFeatures instanceof PropelCollection) {
            $this->collFeatures->clearIterator();
        }
        $this->collFeatures = null;
        if ($this->collFeatureCvtermDbxrefs instanceof PropelCollection) {
            $this->collFeatureCvtermDbxrefs->clearIterator();
        }
        $this->collFeatureCvtermDbxrefs = null;
        if ($this->collFeatureDbxrefs instanceof PropelCollection) {
            $this->collFeatureDbxrefs->clearIterator();
        }
        $this->collFeatureDbxrefs = null;
        if ($this->collPubDbxrefs instanceof PropelCollection) {
            $this->collPubDbxrefs->clearIterator();
        }
        $this->collPubDbxrefs = null;
        $this->aDb = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DbxrefPeer::DEFAULT_STRING_FORMAT);
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
