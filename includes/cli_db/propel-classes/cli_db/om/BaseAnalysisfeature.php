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
use cli_db\propel\Analysis;
use cli_db\propel\AnalysisQuery;
use cli_db\propel\Analysisfeature;
use cli_db\propel\AnalysisfeaturePeer;
use cli_db\propel\AnalysisfeatureQuery;
use cli_db\propel\Analysisfeatureprop;
use cli_db\propel\AnalysisfeaturepropQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureQuery;

/**
 * Base class that represents a row from the 'analysisfeature' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysisfeature extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\AnalysisfeaturePeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        AnalysisfeaturePeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the analysisfeature_id field.
     * @var        int
     */
    protected $analysisfeature_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the analysis_id field.
     * @var        int
     */
    protected $analysis_id;

    /**
     * The value for the rawscore field.
     * @var        double
     */
    protected $rawscore;

    /**
     * The value for the normscore field.
     * @var        double
     */
    protected $normscore;

    /**
     * The value for the significance field.
     * @var        double
     */
    protected $significance;

    /**
     * The value for the identity field.
     * @var        double
     */
    protected $identity;

    /**
     * @var        Analysis
     */
    protected $aAnalysis;

    /**
     * @var        Feature
     */
    protected $aFeature;

    /**
     * @var        PropelObjectCollection|Analysisfeatureprop[] Collection to store aggregation of Analysisfeatureprop objects.
     */
    protected $collAnalysisfeatureprops;
    protected $collAnalysisfeaturepropsPartial;

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
    protected $analysisfeaturepropsScheduledForDeletion = null;

    /**
     * Get the [analysisfeature_id] column value.
     *
     * @return int
     */
    public function getAnalysisfeatureId()
    {
        return $this->analysisfeature_id;
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
     * Get the [analysis_id] column value.
     *
     * @return int
     */
    public function getAnalysisId()
    {
        return $this->analysis_id;
    }

    /**
     * Get the [rawscore] column value.
     *
     * @return double
     */
    public function getRawscore()
    {
        return $this->rawscore;
    }

    /**
     * Get the [normscore] column value.
     *
     * @return double
     */
    public function getNormscore()
    {
        return $this->normscore;
    }

    /**
     * Get the [significance] column value.
     *
     * @return double
     */
    public function getSignificance()
    {
        return $this->significance;
    }

    /**
     * Get the [identity] column value.
     *
     * @return double
     */
    public function getIdentity()
    {
        return $this->identity;
    }

    /**
     * Set the value of [analysisfeature_id] column.
     *
     * @param int $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setAnalysisfeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->analysisfeature_id !== $v) {
            $this->analysisfeature_id = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::ANALYSISFEATURE_ID;
        }


        return $this;
    } // setAnalysisfeatureId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::FEATURE_ID;
        }

        if ($this->aFeature !== null && $this->aFeature->getFeatureId() !== $v) {
            $this->aFeature = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [analysis_id] column.
     *
     * @param int $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setAnalysisId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->analysis_id !== $v) {
            $this->analysis_id = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::ANALYSIS_ID;
        }

        if ($this->aAnalysis !== null && $this->aAnalysis->getAnalysisId() !== $v) {
            $this->aAnalysis = null;
        }


        return $this;
    } // setAnalysisId()

    /**
     * Set the value of [rawscore] column.
     *
     * @param double $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setRawscore($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->rawscore !== $v) {
            $this->rawscore = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::RAWSCORE;
        }


        return $this;
    } // setRawscore()

    /**
     * Set the value of [normscore] column.
     *
     * @param double $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setNormscore($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->normscore !== $v) {
            $this->normscore = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::NORMSCORE;
        }


        return $this;
    } // setNormscore()

    /**
     * Set the value of [significance] column.
     *
     * @param double $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setSignificance($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->significance !== $v) {
            $this->significance = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::SIGNIFICANCE;
        }


        return $this;
    } // setSignificance()

    /**
     * Set the value of [identity] column.
     *
     * @param double $v new value
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setIdentity($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->identity !== $v) {
            $this->identity = $v;
            $this->modifiedColumns[] = AnalysisfeaturePeer::IDENTITY;
        }


        return $this;
    } // setIdentity()

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

            $this->analysisfeature_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->feature_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->analysis_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->rawscore = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
            $this->normscore = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
            $this->significance = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
            $this->identity = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = AnalysisfeaturePeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Analysisfeature object", $e);
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

        if ($this->aFeature !== null && $this->feature_id !== $this->aFeature->getFeatureId()) {
            $this->aFeature = null;
        }
        if ($this->aAnalysis !== null && $this->analysis_id !== $this->aAnalysis->getAnalysisId()) {
            $this->aAnalysis = null;
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
            $con = Propel::getConnection(AnalysisfeaturePeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = AnalysisfeaturePeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAnalysis = null;
            $this->aFeature = null;
            $this->collAnalysisfeatureprops = null;

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
            $con = Propel::getConnection(AnalysisfeaturePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = AnalysisfeatureQuery::create()
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
            $con = Propel::getConnection(AnalysisfeaturePeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                AnalysisfeaturePeer::addInstanceToPool($this);
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

            if ($this->aAnalysis !== null) {
                if ($this->aAnalysis->isModified() || $this->aAnalysis->isNew()) {
                    $affectedRows += $this->aAnalysis->save($con);
                }
                $this->setAnalysis($this->aAnalysis);
            }

            if ($this->aFeature !== null) {
                if ($this->aFeature->isModified() || $this->aFeature->isNew()) {
                    $affectedRows += $this->aFeature->save($con);
                }
                $this->setFeature($this->aFeature);
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

            if ($this->analysisfeaturepropsScheduledForDeletion !== null) {
                if (!$this->analysisfeaturepropsScheduledForDeletion->isEmpty()) {
                    AnalysisfeaturepropQuery::create()
                        ->filterByPrimaryKeys($this->analysisfeaturepropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->analysisfeaturepropsScheduledForDeletion = null;
                }
            }

            if ($this->collAnalysisfeatureprops !== null) {
                foreach ($this->collAnalysisfeatureprops as $referrerFK) {
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

        $this->modifiedColumns[] = AnalysisfeaturePeer::ANALYSISFEATURE_ID;
        if (null !== $this->analysisfeature_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . AnalysisfeaturePeer::ANALYSISFEATURE_ID . ')');
        }
        if (null === $this->analysisfeature_id) {
            try {
                $stmt = $con->query("SELECT nextval('analysisfeature_analysisfeature_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->analysisfeature_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(AnalysisfeaturePeer::ANALYSISFEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"analysisfeature_id"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::ANALYSIS_ID)) {
            $modifiedColumns[':p' . $index++]  = '"analysis_id"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::RAWSCORE)) {
            $modifiedColumns[':p' . $index++]  = '"rawscore"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::NORMSCORE)) {
            $modifiedColumns[':p' . $index++]  = '"normscore"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::SIGNIFICANCE)) {
            $modifiedColumns[':p' . $index++]  = '"significance"';
        }
        if ($this->isColumnModified(AnalysisfeaturePeer::IDENTITY)) {
            $modifiedColumns[':p' . $index++]  = '"identity"';
        }

        $sql = sprintf(
            'INSERT INTO "analysisfeature" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"analysisfeature_id"':
                        $stmt->bindValue($identifier, $this->analysisfeature_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"analysis_id"':
                        $stmt->bindValue($identifier, $this->analysis_id, PDO::PARAM_INT);
                        break;
                    case '"rawscore"':
                        $stmt->bindValue($identifier, $this->rawscore, PDO::PARAM_STR);
                        break;
                    case '"normscore"':
                        $stmt->bindValue($identifier, $this->normscore, PDO::PARAM_STR);
                        break;
                    case '"significance"':
                        $stmt->bindValue($identifier, $this->significance, PDO::PARAM_STR);
                        break;
                    case '"identity"':
                        $stmt->bindValue($identifier, $this->identity, PDO::PARAM_STR);
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

            if ($this->aAnalysis !== null) {
                if (!$this->aAnalysis->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aAnalysis->getValidationFailures());
                }
            }

            if ($this->aFeature !== null) {
                if (!$this->aFeature->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeature->getValidationFailures());
                }
            }


            if (($retval = AnalysisfeaturePeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAnalysisfeatureprops !== null) {
                    foreach ($this->collAnalysisfeatureprops as $referrerFK) {
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
        $pos = AnalysisfeaturePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getAnalysisfeatureId();
                break;
            case 1:
                return $this->getFeatureId();
                break;
            case 2:
                return $this->getAnalysisId();
                break;
            case 3:
                return $this->getRawscore();
                break;
            case 4:
                return $this->getNormscore();
                break;
            case 5:
                return $this->getSignificance();
                break;
            case 6:
                return $this->getIdentity();
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
        if (isset($alreadyDumpedObjects['Analysisfeature'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Analysisfeature'][$this->getPrimaryKey()] = true;
        $keys = AnalysisfeaturePeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getAnalysisfeatureId(),
            $keys[1] => $this->getFeatureId(),
            $keys[2] => $this->getAnalysisId(),
            $keys[3] => $this->getRawscore(),
            $keys[4] => $this->getNormscore(),
            $keys[5] => $this->getSignificance(),
            $keys[6] => $this->getIdentity(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAnalysis) {
                $result['Analysis'] = $this->aAnalysis->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFeature) {
                $result['Feature'] = $this->aFeature->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAnalysisfeatureprops) {
                $result['Analysisfeatureprops'] = $this->collAnalysisfeatureprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = AnalysisfeaturePeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setAnalysisfeatureId($value);
                break;
            case 1:
                $this->setFeatureId($value);
                break;
            case 2:
                $this->setAnalysisId($value);
                break;
            case 3:
                $this->setRawscore($value);
                break;
            case 4:
                $this->setNormscore($value);
                break;
            case 5:
                $this->setSignificance($value);
                break;
            case 6:
                $this->setIdentity($value);
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
        $keys = AnalysisfeaturePeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setAnalysisfeatureId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeatureId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAnalysisId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setRawscore($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setNormscore($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setSignificance($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIdentity($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(AnalysisfeaturePeer::DATABASE_NAME);

        if ($this->isColumnModified(AnalysisfeaturePeer::ANALYSISFEATURE_ID)) $criteria->add(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $this->analysisfeature_id);
        if ($this->isColumnModified(AnalysisfeaturePeer::FEATURE_ID)) $criteria->add(AnalysisfeaturePeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(AnalysisfeaturePeer::ANALYSIS_ID)) $criteria->add(AnalysisfeaturePeer::ANALYSIS_ID, $this->analysis_id);
        if ($this->isColumnModified(AnalysisfeaturePeer::RAWSCORE)) $criteria->add(AnalysisfeaturePeer::RAWSCORE, $this->rawscore);
        if ($this->isColumnModified(AnalysisfeaturePeer::NORMSCORE)) $criteria->add(AnalysisfeaturePeer::NORMSCORE, $this->normscore);
        if ($this->isColumnModified(AnalysisfeaturePeer::SIGNIFICANCE)) $criteria->add(AnalysisfeaturePeer::SIGNIFICANCE, $this->significance);
        if ($this->isColumnModified(AnalysisfeaturePeer::IDENTITY)) $criteria->add(AnalysisfeaturePeer::IDENTITY, $this->identity);

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
        $criteria = new Criteria(AnalysisfeaturePeer::DATABASE_NAME);
        $criteria->add(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $this->analysisfeature_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getAnalysisfeatureId();
    }

    /**
     * Generic method to set the primary key (analysisfeature_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setAnalysisfeatureId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getAnalysisfeatureId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Analysisfeature (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setAnalysisId($this->getAnalysisId());
        $copyObj->setRawscore($this->getRawscore());
        $copyObj->setNormscore($this->getNormscore());
        $copyObj->setSignificance($this->getSignificance());
        $copyObj->setIdentity($this->getIdentity());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAnalysisfeatureprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAnalysisfeatureprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setAnalysisfeatureId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Analysisfeature Clone of current object.
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
     * @return AnalysisfeaturePeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new AnalysisfeaturePeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Analysis object.
     *
     * @param             Analysis $v
     * @return Analysisfeature The current object (for fluent API support)
     * @throws PropelException
     */
    public function setAnalysis(Analysis $v = null)
    {
        if ($v === null) {
            $this->setAnalysisId(NULL);
        } else {
            $this->setAnalysisId($v->getAnalysisId());
        }

        $this->aAnalysis = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Analysis object, it will not be re-added.
        if ($v !== null) {
            $v->addAnalysisfeature($this);
        }


        return $this;
    }


    /**
     * Get the associated Analysis object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Analysis The associated Analysis object.
     * @throws PropelException
     */
    public function getAnalysis(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aAnalysis === null && ($this->analysis_id !== null) && $doQuery) {
            $this->aAnalysis = AnalysisQuery::create()->findPk($this->analysis_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aAnalysis->addAnalysisfeatures($this);
             */
        }

        return $this->aAnalysis;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return Analysisfeature The current object (for fluent API support)
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
            $v->addAnalysisfeature($this);
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
                $this->aFeature->addAnalysisfeatures($this);
             */
        }

        return $this->aFeature;
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
        if ('Analysisfeatureprop' == $relationName) {
            $this->initAnalysisfeatureprops();
        }
    }

    /**
     * Clears out the collAnalysisfeatureprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Analysisfeature The current object (for fluent API support)
     * @see        addAnalysisfeatureprops()
     */
    public function clearAnalysisfeatureprops()
    {
        $this->collAnalysisfeatureprops = null; // important to set this to null since that means it is uninitialized
        $this->collAnalysisfeaturepropsPartial = null;

        return $this;
    }

    /**
     * reset is the collAnalysisfeatureprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialAnalysisfeatureprops($v = true)
    {
        $this->collAnalysisfeaturepropsPartial = $v;
    }

    /**
     * Initializes the collAnalysisfeatureprops collection.
     *
     * By default this just sets the collAnalysisfeatureprops collection to an empty array (like clearcollAnalysisfeatureprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAnalysisfeatureprops($overrideExisting = true)
    {
        if (null !== $this->collAnalysisfeatureprops && !$overrideExisting) {
            return;
        }
        $this->collAnalysisfeatureprops = new PropelObjectCollection();
        $this->collAnalysisfeatureprops->setModel('Analysisfeatureprop');
    }

    /**
     * Gets an array of Analysisfeatureprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Analysisfeature is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Analysisfeatureprop[] List of Analysisfeatureprop objects
     * @throws PropelException
     */
    public function getAnalysisfeatureprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturepropsPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatureprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatureprops) {
                // return empty collection
                $this->initAnalysisfeatureprops();
            } else {
                $collAnalysisfeatureprops = AnalysisfeaturepropQuery::create(null, $criteria)
                    ->filterByAnalysisfeature($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAnalysisfeaturepropsPartial && count($collAnalysisfeatureprops)) {
                      $this->initAnalysisfeatureprops(false);

                      foreach($collAnalysisfeatureprops as $obj) {
                        if (false == $this->collAnalysisfeatureprops->contains($obj)) {
                          $this->collAnalysisfeatureprops->append($obj);
                        }
                      }

                      $this->collAnalysisfeaturepropsPartial = true;
                    }

                    $collAnalysisfeatureprops->getInternalIterator()->rewind();
                    return $collAnalysisfeatureprops;
                }

                if($partial && $this->collAnalysisfeatureprops) {
                    foreach($this->collAnalysisfeatureprops as $obj) {
                        if($obj->isNew()) {
                            $collAnalysisfeatureprops[] = $obj;
                        }
                    }
                }

                $this->collAnalysisfeatureprops = $collAnalysisfeatureprops;
                $this->collAnalysisfeaturepropsPartial = false;
            }
        }

        return $this->collAnalysisfeatureprops;
    }

    /**
     * Sets a collection of Analysisfeatureprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $analysisfeatureprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function setAnalysisfeatureprops(PropelCollection $analysisfeatureprops, PropelPDO $con = null)
    {
        $analysisfeaturepropsToDelete = $this->getAnalysisfeatureprops(new Criteria(), $con)->diff($analysisfeatureprops);

        $this->analysisfeaturepropsScheduledForDeletion = unserialize(serialize($analysisfeaturepropsToDelete));

        foreach ($analysisfeaturepropsToDelete as $analysisfeaturepropRemoved) {
            $analysisfeaturepropRemoved->setAnalysisfeature(null);
        }

        $this->collAnalysisfeatureprops = null;
        foreach ($analysisfeatureprops as $analysisfeatureprop) {
            $this->addAnalysisfeatureprop($analysisfeatureprop);
        }

        $this->collAnalysisfeatureprops = $analysisfeatureprops;
        $this->collAnalysisfeaturepropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Analysisfeatureprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Analysisfeatureprop objects.
     * @throws PropelException
     */
    public function countAnalysisfeatureprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAnalysisfeaturepropsPartial && !$this->isNew();
        if (null === $this->collAnalysisfeatureprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAnalysisfeatureprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAnalysisfeatureprops());
            }
            $query = AnalysisfeaturepropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByAnalysisfeature($this)
                ->count($con);
        }

        return count($this->collAnalysisfeatureprops);
    }

    /**
     * Method called to associate a Analysisfeatureprop object to this object
     * through the Analysisfeatureprop foreign key attribute.
     *
     * @param    Analysisfeatureprop $l Analysisfeatureprop
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function addAnalysisfeatureprop(Analysisfeatureprop $l)
    {
        if ($this->collAnalysisfeatureprops === null) {
            $this->initAnalysisfeatureprops();
            $this->collAnalysisfeaturepropsPartial = true;
        }
        if (!in_array($l, $this->collAnalysisfeatureprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAnalysisfeatureprop($l);
        }

        return $this;
    }

    /**
     * @param	Analysisfeatureprop $analysisfeatureprop The analysisfeatureprop object to add.
     */
    protected function doAddAnalysisfeatureprop($analysisfeatureprop)
    {
        $this->collAnalysisfeatureprops[]= $analysisfeatureprop;
        $analysisfeatureprop->setAnalysisfeature($this);
    }

    /**
     * @param	Analysisfeatureprop $analysisfeatureprop The analysisfeatureprop object to remove.
     * @return Analysisfeature The current object (for fluent API support)
     */
    public function removeAnalysisfeatureprop($analysisfeatureprop)
    {
        if ($this->getAnalysisfeatureprops()->contains($analysisfeatureprop)) {
            $this->collAnalysisfeatureprops->remove($this->collAnalysisfeatureprops->search($analysisfeatureprop));
            if (null === $this->analysisfeaturepropsScheduledForDeletion) {
                $this->analysisfeaturepropsScheduledForDeletion = clone $this->collAnalysisfeatureprops;
                $this->analysisfeaturepropsScheduledForDeletion->clear();
            }
            $this->analysisfeaturepropsScheduledForDeletion[]= clone $analysisfeatureprop;
            $analysisfeatureprop->setAnalysisfeature(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Analysisfeature is new, it will return
     * an empty collection; or if this Analysisfeature has previously
     * been saved, it will retrieve related Analysisfeatureprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Analysisfeature.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Analysisfeatureprop[] List of Analysisfeatureprop objects
     */
    public function getAnalysisfeaturepropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AnalysisfeaturepropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getAnalysisfeatureprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->analysisfeature_id = null;
        $this->feature_id = null;
        $this->analysis_id = null;
        $this->rawscore = null;
        $this->normscore = null;
        $this->significance = null;
        $this->identity = null;
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
            if ($this->collAnalysisfeatureprops) {
                foreach ($this->collAnalysisfeatureprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAnalysis instanceof Persistent) {
              $this->aAnalysis->clearAllReferences($deep);
            }
            if ($this->aFeature instanceof Persistent) {
              $this->aFeature->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAnalysisfeatureprops instanceof PropelCollection) {
            $this->collAnalysisfeatureprops->clearIterator();
        }
        $this->collAnalysisfeatureprops = null;
        $this->aAnalysis = null;
        $this->aFeature = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(AnalysisfeaturePeer::DEFAULT_STRING_FORMAT);
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
