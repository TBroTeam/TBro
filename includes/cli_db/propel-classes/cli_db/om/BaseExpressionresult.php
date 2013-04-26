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
use cli_db\propel\Expressionresult;
use cli_db\propel\ExpressionresultPeer;
use cli_db\propel\ExpressionresultQuantificationresult;
use cli_db\propel\ExpressionresultQuantificationresultQuery;
use cli_db\propel\ExpressionresultQuery;

/**
 * Base class that represents a row from the 'expressionresult' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseExpressionresult extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ExpressionresultPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ExpressionresultPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the expressionresult_id field.
     * @var        int
     */
    protected $expressionresult_id;

    /**
     * The value for the analysis_id field.
     * @var        int
     */
    protected $analysis_id;

    /**
     * The value for the basemean field.
     * @var        double
     */
    protected $basemean;

    /**
     * The value for the basemeana field.
     * @var        double
     */
    protected $basemeana;

    /**
     * The value for the basemeanb field.
     * @var        double
     */
    protected $basemeanb;

    /**
     * The value for the foldchange field.
     * @var        double
     */
    protected $foldchange;

    /**
     * The value for the log2foldchange field.
     * @var        double
     */
    protected $log2foldchange;

    /**
     * The value for the pval field.
     * @var        double
     */
    protected $pval;

    /**
     * The value for the pvaladj field.
     * @var        double
     */
    protected $pvaladj;

    /**
     * @var        Analysis
     */
    protected $aAnalysis;

    /**
     * @var        PropelObjectCollection|ExpressionresultQuantificationresult[] Collection to store aggregation of ExpressionresultQuantificationresult objects.
     */
    protected $collExpressionresultQuantificationresults;
    protected $collExpressionresultQuantificationresultsPartial;

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
    protected $expressionresultQuantificationresultsScheduledForDeletion = null;

    /**
     * Get the [expressionresult_id] column value.
     *
     * @return int
     */
    public function getExpressionresultId()
    {
        return $this->expressionresult_id;
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
     * Get the [basemean] column value.
     *
     * @return double
     */
    public function getBasemean()
    {
        return $this->basemean;
    }

    /**
     * Get the [basemeana] column value.
     *
     * @return double
     */
    public function getBasemeana()
    {
        return $this->basemeana;
    }

    /**
     * Get the [basemeanb] column value.
     *
     * @return double
     */
    public function getBasemeanb()
    {
        return $this->basemeanb;
    }

    /**
     * Get the [foldchange] column value.
     *
     * @return double
     */
    public function getFoldchange()
    {
        return $this->foldchange;
    }

    /**
     * Get the [log2foldchange] column value.
     *
     * @return double
     */
    public function getLog2foldchange()
    {
        return $this->log2foldchange;
    }

    /**
     * Get the [pval] column value.
     *
     * @return double
     */
    public function getPval()
    {
        return $this->pval;
    }

    /**
     * Get the [pvaladj] column value.
     *
     * @return double
     */
    public function getPvaladj()
    {
        return $this->pvaladj;
    }

    /**
     * Set the value of [expressionresult_id] column.
     *
     * @param int $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setExpressionresultId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->expressionresult_id !== $v) {
            $this->expressionresult_id = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::EXPRESSIONRESULT_ID;
        }


        return $this;
    } // setExpressionresultId()

    /**
     * Set the value of [analysis_id] column.
     *
     * @param int $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setAnalysisId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->analysis_id !== $v) {
            $this->analysis_id = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::ANALYSIS_ID;
        }

        if ($this->aAnalysis !== null && $this->aAnalysis->getAnalysisId() !== $v) {
            $this->aAnalysis = null;
        }


        return $this;
    } // setAnalysisId()

    /**
     * Set the value of [basemean] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setBasemean($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->basemean !== $v) {
            $this->basemean = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::BASEMEAN;
        }


        return $this;
    } // setBasemean()

    /**
     * Set the value of [basemeana] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setBasemeana($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->basemeana !== $v) {
            $this->basemeana = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::BASEMEANA;
        }


        return $this;
    } // setBasemeana()

    /**
     * Set the value of [basemeanb] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setBasemeanb($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->basemeanb !== $v) {
            $this->basemeanb = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::BASEMEANB;
        }


        return $this;
    } // setBasemeanb()

    /**
     * Set the value of [foldchange] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setFoldchange($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->foldchange !== $v) {
            $this->foldchange = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::FOLDCHANGE;
        }


        return $this;
    } // setFoldchange()

    /**
     * Set the value of [log2foldchange] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setLog2foldchange($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->log2foldchange !== $v) {
            $this->log2foldchange = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::LOG2FOLDCHANGE;
        }


        return $this;
    } // setLog2foldchange()

    /**
     * Set the value of [pval] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setPval($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->pval !== $v) {
            $this->pval = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::PVAL;
        }


        return $this;
    } // setPval()

    /**
     * Set the value of [pvaladj] column.
     *
     * @param double $v new value
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setPvaladj($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (double) $v;
        }

        if ($this->pvaladj !== $v) {
            $this->pvaladj = $v;
            $this->modifiedColumns[] = ExpressionresultPeer::PVALADJ;
        }


        return $this;
    } // setPvaladj()

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

            $this->expressionresult_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->analysis_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->basemean = ($row[$startcol + 2] !== null) ? (double) $row[$startcol + 2] : null;
            $this->basemeana = ($row[$startcol + 3] !== null) ? (double) $row[$startcol + 3] : null;
            $this->basemeanb = ($row[$startcol + 4] !== null) ? (double) $row[$startcol + 4] : null;
            $this->foldchange = ($row[$startcol + 5] !== null) ? (double) $row[$startcol + 5] : null;
            $this->log2foldchange = ($row[$startcol + 6] !== null) ? (double) $row[$startcol + 6] : null;
            $this->pval = ($row[$startcol + 7] !== null) ? (double) $row[$startcol + 7] : null;
            $this->pvaladj = ($row[$startcol + 8] !== null) ? (double) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 9; // 9 = ExpressionresultPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Expressionresult object", $e);
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
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ExpressionresultPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aAnalysis = null;
            $this->collExpressionresultQuantificationresults = null;

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
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ExpressionresultQuery::create()
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
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ExpressionresultPeer::addInstanceToPool($this);
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

            if ($this->expressionresultQuantificationresultsScheduledForDeletion !== null) {
                if (!$this->expressionresultQuantificationresultsScheduledForDeletion->isEmpty()) {
                    foreach ($this->expressionresultQuantificationresultsScheduledForDeletion as $expressionresultQuantificationresult) {
                        // need to save related object because we set the relation to null
                        $expressionresultQuantificationresult->save($con);
                    }
                    $this->expressionresultQuantificationresultsScheduledForDeletion = null;
                }
            }

            if ($this->collExpressionresultQuantificationresults !== null) {
                foreach ($this->collExpressionresultQuantificationresults as $referrerFK) {
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

        $this->modifiedColumns[] = ExpressionresultPeer::EXPRESSIONRESULT_ID;
        if (null !== $this->expressionresult_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ExpressionresultPeer::EXPRESSIONRESULT_ID . ')');
        }
        if (null === $this->expressionresult_id) {
            try {
                $stmt = $con->query("SELECT nextval('expressionresult_expressionresult_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->expressionresult_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ExpressionresultPeer::EXPRESSIONRESULT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"expressionresult_id"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::ANALYSIS_ID)) {
            $modifiedColumns[':p' . $index++]  = '"analysis_id"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEAN)) {
            $modifiedColumns[':p' . $index++]  = '"baseMean"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEANA)) {
            $modifiedColumns[':p' . $index++]  = '"baseMeanA"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEANB)) {
            $modifiedColumns[':p' . $index++]  = '"baseMeanB"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::FOLDCHANGE)) {
            $modifiedColumns[':p' . $index++]  = '"foldChange"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::LOG2FOLDCHANGE)) {
            $modifiedColumns[':p' . $index++]  = '"log2foldChange"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::PVAL)) {
            $modifiedColumns[':p' . $index++]  = '"pval"';
        }
        if ($this->isColumnModified(ExpressionresultPeer::PVALADJ)) {
            $modifiedColumns[':p' . $index++]  = '"pvaladj"';
        }

        $sql = sprintf(
            'INSERT INTO "expressionresult" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"expressionresult_id"':
                        $stmt->bindValue($identifier, $this->expressionresult_id, PDO::PARAM_INT);
                        break;
                    case '"analysis_id"':
                        $stmt->bindValue($identifier, $this->analysis_id, PDO::PARAM_INT);
                        break;
                    case '"baseMean"':
                        $stmt->bindValue($identifier, $this->basemean, PDO::PARAM_STR);
                        break;
                    case '"baseMeanA"':
                        $stmt->bindValue($identifier, $this->basemeana, PDO::PARAM_STR);
                        break;
                    case '"baseMeanB"':
                        $stmt->bindValue($identifier, $this->basemeanb, PDO::PARAM_STR);
                        break;
                    case '"foldChange"':
                        $stmt->bindValue($identifier, $this->foldchange, PDO::PARAM_STR);
                        break;
                    case '"log2foldChange"':
                        $stmt->bindValue($identifier, $this->log2foldchange, PDO::PARAM_STR);
                        break;
                    case '"pval"':
                        $stmt->bindValue($identifier, $this->pval, PDO::PARAM_STR);
                        break;
                    case '"pvaladj"':
                        $stmt->bindValue($identifier, $this->pvaladj, PDO::PARAM_STR);
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


            if (($retval = ExpressionresultPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collExpressionresultQuantificationresults !== null) {
                    foreach ($this->collExpressionresultQuantificationresults as $referrerFK) {
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
        $pos = ExpressionresultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getExpressionresultId();
                break;
            case 1:
                return $this->getAnalysisId();
                break;
            case 2:
                return $this->getBasemean();
                break;
            case 3:
                return $this->getBasemeana();
                break;
            case 4:
                return $this->getBasemeanb();
                break;
            case 5:
                return $this->getFoldchange();
                break;
            case 6:
                return $this->getLog2foldchange();
                break;
            case 7:
                return $this->getPval();
                break;
            case 8:
                return $this->getPvaladj();
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
        if (isset($alreadyDumpedObjects['Expressionresult'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Expressionresult'][$this->getPrimaryKey()] = true;
        $keys = ExpressionresultPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getExpressionresultId(),
            $keys[1] => $this->getAnalysisId(),
            $keys[2] => $this->getBasemean(),
            $keys[3] => $this->getBasemeana(),
            $keys[4] => $this->getBasemeanb(),
            $keys[5] => $this->getFoldchange(),
            $keys[6] => $this->getLog2foldchange(),
            $keys[7] => $this->getPval(),
            $keys[8] => $this->getPvaladj(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aAnalysis) {
                $result['Analysis'] = $this->aAnalysis->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collExpressionresultQuantificationresults) {
                $result['ExpressionresultQuantificationresults'] = $this->collExpressionresultQuantificationresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ExpressionresultPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setExpressionresultId($value);
                break;
            case 1:
                $this->setAnalysisId($value);
                break;
            case 2:
                $this->setBasemean($value);
                break;
            case 3:
                $this->setBasemeana($value);
                break;
            case 4:
                $this->setBasemeanb($value);
                break;
            case 5:
                $this->setFoldchange($value);
                break;
            case 6:
                $this->setLog2foldchange($value);
                break;
            case 7:
                $this->setPval($value);
                break;
            case 8:
                $this->setPvaladj($value);
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
        $keys = ExpressionresultPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setExpressionresultId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAnalysisId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBasemean($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setBasemeana($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setBasemeanb($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setFoldchange($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setLog2foldchange($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPval($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setPvaladj($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);

        if ($this->isColumnModified(ExpressionresultPeer::EXPRESSIONRESULT_ID)) $criteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, $this->expressionresult_id);
        if ($this->isColumnModified(ExpressionresultPeer::ANALYSIS_ID)) $criteria->add(ExpressionresultPeer::ANALYSIS_ID, $this->analysis_id);
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEAN)) $criteria->add(ExpressionresultPeer::BASEMEAN, $this->basemean);
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEANA)) $criteria->add(ExpressionresultPeer::BASEMEANA, $this->basemeana);
        if ($this->isColumnModified(ExpressionresultPeer::BASEMEANB)) $criteria->add(ExpressionresultPeer::BASEMEANB, $this->basemeanb);
        if ($this->isColumnModified(ExpressionresultPeer::FOLDCHANGE)) $criteria->add(ExpressionresultPeer::FOLDCHANGE, $this->foldchange);
        if ($this->isColumnModified(ExpressionresultPeer::LOG2FOLDCHANGE)) $criteria->add(ExpressionresultPeer::LOG2FOLDCHANGE, $this->log2foldchange);
        if ($this->isColumnModified(ExpressionresultPeer::PVAL)) $criteria->add(ExpressionresultPeer::PVAL, $this->pval);
        if ($this->isColumnModified(ExpressionresultPeer::PVALADJ)) $criteria->add(ExpressionresultPeer::PVALADJ, $this->pvaladj);

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
        $criteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);
        $criteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, $this->expressionresult_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getExpressionresultId();
    }

    /**
     * Generic method to set the primary key (expressionresult_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setExpressionresultId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getExpressionresultId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Expressionresult (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAnalysisId($this->getAnalysisId());
        $copyObj->setBasemean($this->getBasemean());
        $copyObj->setBasemeana($this->getBasemeana());
        $copyObj->setBasemeanb($this->getBasemeanb());
        $copyObj->setFoldchange($this->getFoldchange());
        $copyObj->setLog2foldchange($this->getLog2foldchange());
        $copyObj->setPval($this->getPval());
        $copyObj->setPvaladj($this->getPvaladj());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getExpressionresultQuantificationresults() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addExpressionresultQuantificationresult($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setExpressionresultId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Expressionresult Clone of current object.
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
     * @return ExpressionresultPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ExpressionresultPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Analysis object.
     *
     * @param             Analysis $v
     * @return Expressionresult The current object (for fluent API support)
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
            $v->addExpressionresult($this);
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
                $this->aAnalysis->addExpressionresults($this);
             */
        }

        return $this->aAnalysis;
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
        if ('ExpressionresultQuantificationresult' == $relationName) {
            $this->initExpressionresultQuantificationresults();
        }
    }

    /**
     * Clears out the collExpressionresultQuantificationresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Expressionresult The current object (for fluent API support)
     * @see        addExpressionresultQuantificationresults()
     */
    public function clearExpressionresultQuantificationresults()
    {
        $this->collExpressionresultQuantificationresults = null; // important to set this to null since that means it is uninitialized
        $this->collExpressionresultQuantificationresultsPartial = null;

        return $this;
    }

    /**
     * reset is the collExpressionresultQuantificationresults collection loaded partially
     *
     * @return void
     */
    public function resetPartialExpressionresultQuantificationresults($v = true)
    {
        $this->collExpressionresultQuantificationresultsPartial = $v;
    }

    /**
     * Initializes the collExpressionresultQuantificationresults collection.
     *
     * By default this just sets the collExpressionresultQuantificationresults collection to an empty array (like clearcollExpressionresultQuantificationresults());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initExpressionresultQuantificationresults($overrideExisting = true)
    {
        if (null !== $this->collExpressionresultQuantificationresults && !$overrideExisting) {
            return;
        }
        $this->collExpressionresultQuantificationresults = new PropelObjectCollection();
        $this->collExpressionresultQuantificationresults->setModel('ExpressionresultQuantificationresult');
    }

    /**
     * Gets an array of ExpressionresultQuantificationresult objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Expressionresult is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ExpressionresultQuantificationresult[] List of ExpressionresultQuantificationresult objects
     * @throws PropelException
     */
    public function getExpressionresultQuantificationresults($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collExpressionresultQuantificationresultsPartial && !$this->isNew();
        if (null === $this->collExpressionresultQuantificationresults || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collExpressionresultQuantificationresults) {
                // return empty collection
                $this->initExpressionresultQuantificationresults();
            } else {
                $collExpressionresultQuantificationresults = ExpressionresultQuantificationresultQuery::create(null, $criteria)
                    ->filterByExpressionresult($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collExpressionresultQuantificationresultsPartial && count($collExpressionresultQuantificationresults)) {
                      $this->initExpressionresultQuantificationresults(false);

                      foreach($collExpressionresultQuantificationresults as $obj) {
                        if (false == $this->collExpressionresultQuantificationresults->contains($obj)) {
                          $this->collExpressionresultQuantificationresults->append($obj);
                        }
                      }

                      $this->collExpressionresultQuantificationresultsPartial = true;
                    }

                    $collExpressionresultQuantificationresults->getInternalIterator()->rewind();
                    return $collExpressionresultQuantificationresults;
                }

                if($partial && $this->collExpressionresultQuantificationresults) {
                    foreach($this->collExpressionresultQuantificationresults as $obj) {
                        if($obj->isNew()) {
                            $collExpressionresultQuantificationresults[] = $obj;
                        }
                    }
                }

                $this->collExpressionresultQuantificationresults = $collExpressionresultQuantificationresults;
                $this->collExpressionresultQuantificationresultsPartial = false;
            }
        }

        return $this->collExpressionresultQuantificationresults;
    }

    /**
     * Sets a collection of ExpressionresultQuantificationresult objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $expressionresultQuantificationresults A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Expressionresult The current object (for fluent API support)
     */
    public function setExpressionresultQuantificationresults(PropelCollection $expressionresultQuantificationresults, PropelPDO $con = null)
    {
        $expressionresultQuantificationresultsToDelete = $this->getExpressionresultQuantificationresults(new Criteria(), $con)->diff($expressionresultQuantificationresults);

        $this->expressionresultQuantificationresultsScheduledForDeletion = unserialize(serialize($expressionresultQuantificationresultsToDelete));

        foreach ($expressionresultQuantificationresultsToDelete as $expressionresultQuantificationresultRemoved) {
            $expressionresultQuantificationresultRemoved->setExpressionresult(null);
        }

        $this->collExpressionresultQuantificationresults = null;
        foreach ($expressionresultQuantificationresults as $expressionresultQuantificationresult) {
            $this->addExpressionresultQuantificationresult($expressionresultQuantificationresult);
        }

        $this->collExpressionresultQuantificationresults = $expressionresultQuantificationresults;
        $this->collExpressionresultQuantificationresultsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ExpressionresultQuantificationresult objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ExpressionresultQuantificationresult objects.
     * @throws PropelException
     */
    public function countExpressionresultQuantificationresults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collExpressionresultQuantificationresultsPartial && !$this->isNew();
        if (null === $this->collExpressionresultQuantificationresults || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collExpressionresultQuantificationresults) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getExpressionresultQuantificationresults());
            }
            $query = ExpressionresultQuantificationresultQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByExpressionresult($this)
                ->count($con);
        }

        return count($this->collExpressionresultQuantificationresults);
    }

    /**
     * Method called to associate a ExpressionresultQuantificationresult object to this object
     * through the ExpressionresultQuantificationresult foreign key attribute.
     *
     * @param    ExpressionresultQuantificationresult $l ExpressionresultQuantificationresult
     * @return Expressionresult The current object (for fluent API support)
     */
    public function addExpressionresultQuantificationresult(ExpressionresultQuantificationresult $l)
    {
        if ($this->collExpressionresultQuantificationresults === null) {
            $this->initExpressionresultQuantificationresults();
            $this->collExpressionresultQuantificationresultsPartial = true;
        }
        if (!in_array($l, $this->collExpressionresultQuantificationresults->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddExpressionresultQuantificationresult($l);
        }

        return $this;
    }

    /**
     * @param	ExpressionresultQuantificationresult $expressionresultQuantificationresult The expressionresultQuantificationresult object to add.
     */
    protected function doAddExpressionresultQuantificationresult($expressionresultQuantificationresult)
    {
        $this->collExpressionresultQuantificationresults[]= $expressionresultQuantificationresult;
        $expressionresultQuantificationresult->setExpressionresult($this);
    }

    /**
     * @param	ExpressionresultQuantificationresult $expressionresultQuantificationresult The expressionresultQuantificationresult object to remove.
     * @return Expressionresult The current object (for fluent API support)
     */
    public function removeExpressionresultQuantificationresult($expressionresultQuantificationresult)
    {
        if ($this->getExpressionresultQuantificationresults()->contains($expressionresultQuantificationresult)) {
            $this->collExpressionresultQuantificationresults->remove($this->collExpressionresultQuantificationresults->search($expressionresultQuantificationresult));
            if (null === $this->expressionresultQuantificationresultsScheduledForDeletion) {
                $this->expressionresultQuantificationresultsScheduledForDeletion = clone $this->collExpressionresultQuantificationresults;
                $this->expressionresultQuantificationresultsScheduledForDeletion->clear();
            }
            $this->expressionresultQuantificationresultsScheduledForDeletion[]= $expressionresultQuantificationresult;
            $expressionresultQuantificationresult->setExpressionresult(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Expressionresult is new, it will return
     * an empty collection; or if this Expressionresult has previously
     * been saved, it will retrieve related ExpressionresultQuantificationresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Expressionresult.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ExpressionresultQuantificationresult[] List of ExpressionresultQuantificationresult objects
     */
    public function getExpressionresultQuantificationresultsJoinQuantificationresult($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ExpressionresultQuantificationresultQuery::create(null, $criteria);
        $query->joinWith('Quantificationresult', $join_behavior);

        return $this->getExpressionresultQuantificationresults($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->expressionresult_id = null;
        $this->analysis_id = null;
        $this->basemean = null;
        $this->basemeana = null;
        $this->basemeanb = null;
        $this->foldchange = null;
        $this->log2foldchange = null;
        $this->pval = null;
        $this->pvaladj = null;
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
            if ($this->collExpressionresultQuantificationresults) {
                foreach ($this->collExpressionresultQuantificationresults as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aAnalysis instanceof Persistent) {
              $this->aAnalysis->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collExpressionresultQuantificationresults instanceof PropelCollection) {
            $this->collExpressionresultQuantificationresults->clearIterator();
        }
        $this->collExpressionresultQuantificationresults = null;
        $this->aAnalysis = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ExpressionresultPeer::DEFAULT_STRING_FORMAT);
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
