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
use cli_db\propel\Feature;
use cli_db\propel\FeatureQuery;
use cli_db\propel\FeatureSynonym;
use cli_db\propel\FeatureSynonymPeer;
use cli_db\propel\FeatureSynonymQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;
use cli_db\propel\Synonym;
use cli_db\propel\SynonymQuery;

/**
 * Base class that represents a row from the 'feature_synonym' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureSynonym extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\FeatureSynonymPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        FeatureSynonymPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the feature_synonym_id field.
     * @var        int
     */
    protected $feature_synonym_id;

    /**
     * The value for the synonym_id field.
     * @var        int
     */
    protected $synonym_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the pub_id field.
     * @var        int
     */
    protected $pub_id;

    /**
     * The value for the is_current field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_current;

    /**
     * The value for the is_internal field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_internal;

    /**
     * @var        Feature
     */
    protected $aFeature;

    /**
     * @var        Pub
     */
    protected $aPub;

    /**
     * @var        Synonym
     */
    protected $aSynonym;

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
        $this->is_current = false;
        $this->is_internal = false;
    }

    /**
     * Initializes internal state of BaseFeatureSynonym object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [feature_synonym_id] column value.
     *
     * @return int
     */
    public function getFeatureSynonymId()
    {
        return $this->feature_synonym_id;
    }

    /**
     * Get the [synonym_id] column value.
     *
     * @return int
     */
    public function getSynonymId()
    {
        return $this->synonym_id;
    }

    /**
     * Get the [feature_id] column value.
     *
     * @return int
     */
    public function getFeatureId()
    {
        return $this->feature_id;
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
     * Get the [is_current] column value.
     *
     * @return boolean
     */
    public function getIsCurrent()
    {
        return $this->is_current;
    }

    /**
     * Get the [is_internal] column value.
     *
     * @return boolean
     */
    public function getIsInternal()
    {
        return $this->is_internal;
    }

    /**
     * Set the value of [feature_synonym_id] column.
     *
     * @param int $v new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setFeatureSynonymId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_synonym_id !== $v) {
            $this->feature_synonym_id = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::FEATURE_SYNONYM_ID;
        }


        return $this;
    } // setFeatureSynonymId()

    /**
     * Set the value of [synonym_id] column.
     *
     * @param int $v new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setSynonymId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->synonym_id !== $v) {
            $this->synonym_id = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::SYNONYM_ID;
        }

        if ($this->aSynonym !== null && $this->aSynonym->getSynonymId() !== $v) {
            $this->aSynonym = null;
        }


        return $this;
    } // setSynonymId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::FEATURE_ID;
        }

        if ($this->aFeature !== null && $this->aFeature->getFeatureId() !== $v) {
            $this->aFeature = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::PUB_ID;
        }

        if ($this->aPub !== null && $this->aPub->getPubId() !== $v) {
            $this->aPub = null;
        }


        return $this;
    } // setPubId()

    /**
     * Sets the value of the [is_current] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setIsCurrent($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_current !== $v) {
            $this->is_current = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::IS_CURRENT;
        }


        return $this;
    } // setIsCurrent()

    /**
     * Sets the value of the [is_internal] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return FeatureSynonym The current object (for fluent API support)
     */
    public function setIsInternal($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_internal !== $v) {
            $this->is_internal = $v;
            $this->modifiedColumns[] = FeatureSynonymPeer::IS_INTERNAL;
        }


        return $this;
    } // setIsInternal()

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
            if ($this->is_current !== false) {
                return false;
            }

            if ($this->is_internal !== false) {
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

            $this->feature_synonym_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->synonym_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->feature_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->pub_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->is_current = ($row[$startcol + 4] !== null) ? (boolean) $row[$startcol + 4] : null;
            $this->is_internal = ($row[$startcol + 5] !== null) ? (boolean) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = FeatureSynonymPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating FeatureSynonym object", $e);
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

        if ($this->aSynonym !== null && $this->synonym_id !== $this->aSynonym->getSynonymId()) {
            $this->aSynonym = null;
        }
        if ($this->aFeature !== null && $this->feature_id !== $this->aFeature->getFeatureId()) {
            $this->aFeature = null;
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
            $con = Propel::getConnection(FeatureSynonymPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = FeatureSynonymPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aFeature = null;
            $this->aPub = null;
            $this->aSynonym = null;
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
            $con = Propel::getConnection(FeatureSynonymPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = FeatureSynonymQuery::create()
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
            $con = Propel::getConnection(FeatureSynonymPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                FeatureSynonymPeer::addInstanceToPool($this);
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

            if ($this->aFeature !== null) {
                if ($this->aFeature->isModified() || $this->aFeature->isNew()) {
                    $affectedRows += $this->aFeature->save($con);
                }
                $this->setFeature($this->aFeature);
            }

            if ($this->aPub !== null) {
                if ($this->aPub->isModified() || $this->aPub->isNew()) {
                    $affectedRows += $this->aPub->save($con);
                }
                $this->setPub($this->aPub);
            }

            if ($this->aSynonym !== null) {
                if ($this->aSynonym->isModified() || $this->aSynonym->isNew()) {
                    $affectedRows += $this->aSynonym->save($con);
                }
                $this->setSynonym($this->aSynonym);
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

        $this->modifiedColumns[] = FeatureSynonymPeer::FEATURE_SYNONYM_ID;
        if (null !== $this->feature_synonym_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . FeatureSynonymPeer::FEATURE_SYNONYM_ID . ')');
        }
        if (null === $this->feature_synonym_id) {
            try {
                $stmt = $con->query("SELECT nextval('feature_synonym_feature_synonym_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->feature_synonym_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(FeatureSynonymPeer::FEATURE_SYNONYM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_synonym_id"';
        }
        if ($this->isColumnModified(FeatureSynonymPeer::SYNONYM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"synonym_id"';
        }
        if ($this->isColumnModified(FeatureSynonymPeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(FeatureSynonymPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }
        if ($this->isColumnModified(FeatureSynonymPeer::IS_CURRENT)) {
            $modifiedColumns[':p' . $index++]  = '"is_current"';
        }
        if ($this->isColumnModified(FeatureSynonymPeer::IS_INTERNAL)) {
            $modifiedColumns[':p' . $index++]  = '"is_internal"';
        }

        $sql = sprintf(
            'INSERT INTO "feature_synonym" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"feature_synonym_id"':
                        $stmt->bindValue($identifier, $this->feature_synonym_id, PDO::PARAM_INT);
                        break;
                    case '"synonym_id"':
                        $stmt->bindValue($identifier, $this->synonym_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"pub_id"':
                        $stmt->bindValue($identifier, $this->pub_id, PDO::PARAM_INT);
                        break;
                    case '"is_current"':
                        $stmt->bindValue($identifier, $this->is_current, PDO::PARAM_BOOL);
                        break;
                    case '"is_internal"':
                        $stmt->bindValue($identifier, $this->is_internal, PDO::PARAM_BOOL);
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

            if ($this->aFeature !== null) {
                if (!$this->aFeature->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeature->getValidationFailures());
                }
            }

            if ($this->aPub !== null) {
                if (!$this->aPub->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPub->getValidationFailures());
                }
            }

            if ($this->aSynonym !== null) {
                if (!$this->aSynonym->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aSynonym->getValidationFailures());
                }
            }


            if (($retval = FeatureSynonymPeer::doValidate($this, $columns)) !== true) {
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
        $pos = FeatureSynonymPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getFeatureSynonymId();
                break;
            case 1:
                return $this->getSynonymId();
                break;
            case 2:
                return $this->getFeatureId();
                break;
            case 3:
                return $this->getPubId();
                break;
            case 4:
                return $this->getIsCurrent();
                break;
            case 5:
                return $this->getIsInternal();
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
        if (isset($alreadyDumpedObjects['FeatureSynonym'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['FeatureSynonym'][$this->getPrimaryKey()] = true;
        $keys = FeatureSynonymPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getFeatureSynonymId(),
            $keys[1] => $this->getSynonymId(),
            $keys[2] => $this->getFeatureId(),
            $keys[3] => $this->getPubId(),
            $keys[4] => $this->getIsCurrent(),
            $keys[5] => $this->getIsInternal(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aFeature) {
                $result['Feature'] = $this->aFeature->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPub) {
                $result['Pub'] = $this->aPub->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aSynonym) {
                $result['Synonym'] = $this->aSynonym->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
        $pos = FeatureSynonymPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setFeatureSynonymId($value);
                break;
            case 1:
                $this->setSynonymId($value);
                break;
            case 2:
                $this->setFeatureId($value);
                break;
            case 3:
                $this->setPubId($value);
                break;
            case 4:
                $this->setIsCurrent($value);
                break;
            case 5:
                $this->setIsInternal($value);
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
        $keys = FeatureSynonymPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setFeatureSynonymId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setSynonymId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setFeatureId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setPubId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setIsCurrent($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIsInternal($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(FeatureSynonymPeer::DATABASE_NAME);

        if ($this->isColumnModified(FeatureSynonymPeer::FEATURE_SYNONYM_ID)) $criteria->add(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $this->feature_synonym_id);
        if ($this->isColumnModified(FeatureSynonymPeer::SYNONYM_ID)) $criteria->add(FeatureSynonymPeer::SYNONYM_ID, $this->synonym_id);
        if ($this->isColumnModified(FeatureSynonymPeer::FEATURE_ID)) $criteria->add(FeatureSynonymPeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(FeatureSynonymPeer::PUB_ID)) $criteria->add(FeatureSynonymPeer::PUB_ID, $this->pub_id);
        if ($this->isColumnModified(FeatureSynonymPeer::IS_CURRENT)) $criteria->add(FeatureSynonymPeer::IS_CURRENT, $this->is_current);
        if ($this->isColumnModified(FeatureSynonymPeer::IS_INTERNAL)) $criteria->add(FeatureSynonymPeer::IS_INTERNAL, $this->is_internal);

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
        $criteria = new Criteria(FeatureSynonymPeer::DATABASE_NAME);
        $criteria->add(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $this->feature_synonym_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getFeatureSynonymId();
    }

    /**
     * Generic method to set the primary key (feature_synonym_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setFeatureSynonymId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getFeatureSynonymId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of FeatureSynonym (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setSynonymId($this->getSynonymId());
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setPubId($this->getPubId());
        $copyObj->setIsCurrent($this->getIsCurrent());
        $copyObj->setIsInternal($this->getIsInternal());

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
            $copyObj->setFeatureSynonymId(NULL); // this is a auto-increment column, so set to default value
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
     * @return FeatureSynonym Clone of current object.
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
     * @return FeatureSynonymPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new FeatureSynonymPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return FeatureSynonym The current object (for fluent API support)
     * @throws PropelException
     */
    public function setFeature(Feature $v = null)
    {
        if ($v === null) {
            $this->setFeatureId(NULL);
        } else {
            $this->setFeatureId($v->getFeatureId());
        }

        $this->aFeature = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Feature object, it will not be re-added.
        if ($v !== null) {
            $v->addFeatureSynonym($this);
        }


        return $this;
    }


    /**
     * Get the associated Feature object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Feature The associated Feature object.
     * @throws PropelException
     */
    public function getFeature(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aFeature === null && ($this->feature_id !== null) && $doQuery) {
            $this->aFeature = FeatureQuery::create()->findPk($this->feature_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aFeature->addFeatureSynonyms($this);
             */
        }

        return $this->aFeature;
    }

    /**
     * Declares an association between this object and a Pub object.
     *
     * @param             Pub $v
     * @return FeatureSynonym The current object (for fluent API support)
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
            $v->addFeatureSynonym($this);
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
                $this->aPub->addFeatureSynonyms($this);
             */
        }

        return $this->aPub;
    }

    /**
     * Declares an association between this object and a Synonym object.
     *
     * @param             Synonym $v
     * @return FeatureSynonym The current object (for fluent API support)
     * @throws PropelException
     */
    public function setSynonym(Synonym $v = null)
    {
        if ($v === null) {
            $this->setSynonymId(NULL);
        } else {
            $this->setSynonymId($v->getSynonymId());
        }

        $this->aSynonym = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Synonym object, it will not be re-added.
        if ($v !== null) {
            $v->addFeatureSynonym($this);
        }


        return $this;
    }


    /**
     * Get the associated Synonym object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Synonym The associated Synonym object.
     * @throws PropelException
     */
    public function getSynonym(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aSynonym === null && ($this->synonym_id !== null) && $doQuery) {
            $this->aSynonym = SynonymQuery::create()->findPk($this->synonym_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aSynonym->addFeatureSynonyms($this);
             */
        }

        return $this->aSynonym;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->feature_synonym_id = null;
        $this->synonym_id = null;
        $this->feature_id = null;
        $this->pub_id = null;
        $this->is_current = null;
        $this->is_internal = null;
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
            if ($this->aFeature instanceof Persistent) {
              $this->aFeature->clearAllReferences($deep);
            }
            if ($this->aPub instanceof Persistent) {
              $this->aPub->clearAllReferences($deep);
            }
            if ($this->aSynonym instanceof Persistent) {
              $this->aSynonym->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        $this->aFeature = null;
        $this->aPub = null;
        $this->aSynonym = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(FeatureSynonymPeer::DEFAULT_STRING_FORMAT);
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
