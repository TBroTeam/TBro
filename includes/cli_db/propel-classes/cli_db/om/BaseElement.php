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
use cli_db\propel\Arraydesign;
use cli_db\propel\ArraydesignQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Element;
use cli_db\propel\ElementPeer;
use cli_db\propel\ElementQuery;
use cli_db\propel\ElementRelationship;
use cli_db\propel\ElementRelationshipQuery;
use cli_db\propel\Elementresult;
use cli_db\propel\ElementresultQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureQuery;

/**
 * Base class that represents a row from the 'element' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseElement extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ElementPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ElementPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the element_id field.
     * @var        int
     */
    protected $element_id;

    /**
     * The value for the feature_id field.
     * @var        int
     */
    protected $feature_id;

    /**
     * The value for the arraydesign_id field.
     * @var        int
     */
    protected $arraydesign_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * @var        Arraydesign
     */
    protected $aArraydesign;

    /**
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        Feature
     */
    protected $aFeature;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|ElementRelationship[] Collection to store aggregation of ElementRelationship objects.
     */
    protected $collElementRelationshipsRelatedByObjectId;
    protected $collElementRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|ElementRelationship[] Collection to store aggregation of ElementRelationship objects.
     */
    protected $collElementRelationshipsRelatedBySubjectId;
    protected $collElementRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|Elementresult[] Collection to store aggregation of Elementresult objects.
     */
    protected $collElementresults;
    protected $collElementresultsPartial;

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
    protected $elementRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementresultsScheduledForDeletion = null;

    /**
     * Get the [element_id] column value.
     *
     * @return int
     */
    public function getElementId()
    {
        return $this->element_id;
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
     * Get the [arraydesign_id] column value.
     *
     * @return int
     */
    public function getArraydesignId()
    {
        return $this->arraydesign_id;
    }

    /**
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
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
     * Set the value of [element_id] column.
     *
     * @param int $v new value
     * @return Element The current object (for fluent API support)
     */
    public function setElementId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->element_id !== $v) {
            $this->element_id = $v;
            $this->modifiedColumns[] = ElementPeer::ELEMENT_ID;
        }


        return $this;
    } // setElementId()

    /**
     * Set the value of [feature_id] column.
     *
     * @param int $v new value
     * @return Element The current object (for fluent API support)
     */
    public function setFeatureId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->feature_id !== $v) {
            $this->feature_id = $v;
            $this->modifiedColumns[] = ElementPeer::FEATURE_ID;
        }

        if ($this->aFeature !== null && $this->aFeature->getFeatureId() !== $v) {
            $this->aFeature = null;
        }


        return $this;
    } // setFeatureId()

    /**
     * Set the value of [arraydesign_id] column.
     *
     * @param int $v new value
     * @return Element The current object (for fluent API support)
     */
    public function setArraydesignId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->arraydesign_id !== $v) {
            $this->arraydesign_id = $v;
            $this->modifiedColumns[] = ElementPeer::ARRAYDESIGN_ID;
        }

        if ($this->aArraydesign !== null && $this->aArraydesign->getArraydesignId() !== $v) {
            $this->aArraydesign = null;
        }


        return $this;
    } // setArraydesignId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Element The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = ElementPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Element The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = ElementPeer::DBXREF_ID;
        }

        if ($this->aDbxref !== null && $this->aDbxref->getDbxrefId() !== $v) {
            $this->aDbxref = null;
        }


        return $this;
    } // setDbxrefId()

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

            $this->element_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->feature_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->arraydesign_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->type_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->dbxref_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = ElementPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Element object", $e);
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
        if ($this->aArraydesign !== null && $this->arraydesign_id !== $this->aArraydesign->getArraydesignId()) {
            $this->aArraydesign = null;
        }
        if ($this->aCvterm !== null && $this->type_id !== $this->aCvterm->getCvtermId()) {
            $this->aCvterm = null;
        }
        if ($this->aDbxref !== null && $this->dbxref_id !== $this->aDbxref->getDbxrefId()) {
            $this->aDbxref = null;
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
            $con = Propel::getConnection(ElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ElementPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aArraydesign = null;
            $this->aDbxref = null;
            $this->aFeature = null;
            $this->aCvterm = null;
            $this->collElementRelationshipsRelatedByObjectId = null;

            $this->collElementRelationshipsRelatedBySubjectId = null;

            $this->collElementresults = null;

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
            $con = Propel::getConnection(ElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ElementQuery::create()
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
            $con = Propel::getConnection(ElementPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ElementPeer::addInstanceToPool($this);
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

            if ($this->aArraydesign !== null) {
                if ($this->aArraydesign->isModified() || $this->aArraydesign->isNew()) {
                    $affectedRows += $this->aArraydesign->save($con);
                }
                $this->setArraydesign($this->aArraydesign);
            }

            if ($this->aDbxref !== null) {
                if ($this->aDbxref->isModified() || $this->aDbxref->isNew()) {
                    $affectedRows += $this->aDbxref->save($con);
                }
                $this->setDbxref($this->aDbxref);
            }

            if ($this->aFeature !== null) {
                if ($this->aFeature->isModified() || $this->aFeature->isNew()) {
                    $affectedRows += $this->aFeature->save($con);
                }
                $this->setFeature($this->aFeature);
            }

            if ($this->aCvterm !== null) {
                if ($this->aCvterm->isModified() || $this->aCvterm->isNew()) {
                    $affectedRows += $this->aCvterm->save($con);
                }
                $this->setCvterm($this->aCvterm);
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

            if ($this->elementRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->elementRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    ElementRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collElementRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collElementRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    ElementRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collElementRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collElementRelationshipsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementresultsScheduledForDeletion !== null) {
                if (!$this->elementresultsScheduledForDeletion->isEmpty()) {
                    ElementresultQuery::create()
                        ->filterByPrimaryKeys($this->elementresultsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->elementresultsScheduledForDeletion = null;
                }
            }

            if ($this->collElementresults !== null) {
                foreach ($this->collElementresults as $referrerFK) {
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

        $this->modifiedColumns[] = ElementPeer::ELEMENT_ID;
        if (null !== $this->element_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ElementPeer::ELEMENT_ID . ')');
        }
        if (null === $this->element_id) {
            try {
                $stmt = $con->query("SELECT nextval('element_element_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->element_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ElementPeer::ELEMENT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"element_id"';
        }
        if ($this->isColumnModified(ElementPeer::FEATURE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"feature_id"';
        }
        if ($this->isColumnModified(ElementPeer::ARRAYDESIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = '"arraydesign_id"';
        }
        if ($this->isColumnModified(ElementPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(ElementPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }

        $sql = sprintf(
            'INSERT INTO "element" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"element_id"':
                        $stmt->bindValue($identifier, $this->element_id, PDO::PARAM_INT);
                        break;
                    case '"feature_id"':
                        $stmt->bindValue($identifier, $this->feature_id, PDO::PARAM_INT);
                        break;
                    case '"arraydesign_id"':
                        $stmt->bindValue($identifier, $this->arraydesign_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
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

            if ($this->aArraydesign !== null) {
                if (!$this->aArraydesign->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aArraydesign->getValidationFailures());
                }
            }

            if ($this->aDbxref !== null) {
                if (!$this->aDbxref->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDbxref->getValidationFailures());
                }
            }

            if ($this->aFeature !== null) {
                if (!$this->aFeature->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aFeature->getValidationFailures());
                }
            }

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = ElementPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collElementRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collElementRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElementRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collElementRelationshipsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElementresults !== null) {
                    foreach ($this->collElementresults as $referrerFK) {
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
        $pos = ElementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getElementId();
                break;
            case 1:
                return $this->getFeatureId();
                break;
            case 2:
                return $this->getArraydesignId();
                break;
            case 3:
                return $this->getTypeId();
                break;
            case 4:
                return $this->getDbxrefId();
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
        if (isset($alreadyDumpedObjects['Element'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Element'][$this->getPrimaryKey()] = true;
        $keys = ElementPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getElementId(),
            $keys[1] => $this->getFeatureId(),
            $keys[2] => $this->getArraydesignId(),
            $keys[3] => $this->getTypeId(),
            $keys[4] => $this->getDbxrefId(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aArraydesign) {
                $result['Arraydesign'] = $this->aArraydesign->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aFeature) {
                $result['Feature'] = $this->aFeature->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collElementRelationshipsRelatedByObjectId) {
                $result['ElementRelationshipsRelatedByObjectId'] = $this->collElementRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementRelationshipsRelatedBySubjectId) {
                $result['ElementRelationshipsRelatedBySubjectId'] = $this->collElementRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElementresults) {
                $result['Elementresults'] = $this->collElementresults->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ElementPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setElementId($value);
                break;
            case 1:
                $this->setFeatureId($value);
                break;
            case 2:
                $this->setArraydesignId($value);
                break;
            case 3:
                $this->setTypeId($value);
                break;
            case 4:
                $this->setDbxrefId($value);
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
        $keys = ElementPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setElementId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setFeatureId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setArraydesignId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setTypeId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDbxrefId($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ElementPeer::DATABASE_NAME);

        if ($this->isColumnModified(ElementPeer::ELEMENT_ID)) $criteria->add(ElementPeer::ELEMENT_ID, $this->element_id);
        if ($this->isColumnModified(ElementPeer::FEATURE_ID)) $criteria->add(ElementPeer::FEATURE_ID, $this->feature_id);
        if ($this->isColumnModified(ElementPeer::ARRAYDESIGN_ID)) $criteria->add(ElementPeer::ARRAYDESIGN_ID, $this->arraydesign_id);
        if ($this->isColumnModified(ElementPeer::TYPE_ID)) $criteria->add(ElementPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(ElementPeer::DBXREF_ID)) $criteria->add(ElementPeer::DBXREF_ID, $this->dbxref_id);

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
        $criteria = new Criteria(ElementPeer::DATABASE_NAME);
        $criteria->add(ElementPeer::ELEMENT_ID, $this->element_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getElementId();
    }

    /**
     * Generic method to set the primary key (element_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setElementId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getElementId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Element (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setFeatureId($this->getFeatureId());
        $copyObj->setArraydesignId($this->getArraydesignId());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setDbxrefId($this->getDbxrefId());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getElementRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElementresults() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElementresult($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setElementId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Element Clone of current object.
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
     * @return ElementPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ElementPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Arraydesign object.
     *
     * @param             Arraydesign $v
     * @return Element The current object (for fluent API support)
     * @throws PropelException
     */
    public function setArraydesign(Arraydesign $v = null)
    {
        if ($v === null) {
            $this->setArraydesignId(NULL);
        } else {
            $this->setArraydesignId($v->getArraydesignId());
        }

        $this->aArraydesign = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Arraydesign object, it will not be re-added.
        if ($v !== null) {
            $v->addElement($this);
        }


        return $this;
    }


    /**
     * Get the associated Arraydesign object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Arraydesign The associated Arraydesign object.
     * @throws PropelException
     */
    public function getArraydesign(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aArraydesign === null && ($this->arraydesign_id !== null) && $doQuery) {
            $this->aArraydesign = ArraydesignQuery::create()->findPk($this->arraydesign_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aArraydesign->addElements($this);
             */
        }

        return $this->aArraydesign;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Element The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDbxref(Dbxref $v = null)
    {
        if ($v === null) {
            $this->setDbxrefId(NULL);
        } else {
            $this->setDbxrefId($v->getDbxrefId());
        }

        $this->aDbxref = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Dbxref object, it will not be re-added.
        if ($v !== null) {
            $v->addElement($this);
        }


        return $this;
    }


    /**
     * Get the associated Dbxref object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Dbxref The associated Dbxref object.
     * @throws PropelException
     */
    public function getDbxref(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aDbxref === null && ($this->dbxref_id !== null) && $doQuery) {
            $this->aDbxref = DbxrefQuery::create()->findPk($this->dbxref_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDbxref->addElements($this);
             */
        }

        return $this->aDbxref;
    }

    /**
     * Declares an association between this object and a Feature object.
     *
     * @param             Feature $v
     * @return Element The current object (for fluent API support)
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
            $v->addElement($this);
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
                $this->aFeature->addElements($this);
             */
        }

        return $this->aFeature;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Element The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvterm(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setTypeId(NULL);
        } else {
            $this->setTypeId($v->getCvtermId());
        }

        $this->aCvterm = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addElement($this);
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
    public function getCvterm(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvterm === null && ($this->type_id !== null) && $doQuery) {
            $this->aCvterm = CvtermQuery::create()->findPk($this->type_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvterm->addElements($this);
             */
        }

        return $this->aCvterm;
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
        if ('ElementRelationshipRelatedByObjectId' == $relationName) {
            $this->initElementRelationshipsRelatedByObjectId();
        }
        if ('ElementRelationshipRelatedBySubjectId' == $relationName) {
            $this->initElementRelationshipsRelatedBySubjectId();
        }
        if ('Elementresult' == $relationName) {
            $this->initElementresults();
        }
    }

    /**
     * Clears out the collElementRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Element The current object (for fluent API support)
     * @see        addElementRelationshipsRelatedByObjectId()
     */
    public function clearElementRelationshipsRelatedByObjectId()
    {
        $this->collElementRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collElementRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collElementRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementRelationshipsRelatedByObjectId($v = true)
    {
        $this->collElementRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collElementRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collElementRelationshipsRelatedByObjectId collection to an empty array (like clearcollElementRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collElementRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collElementRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collElementRelationshipsRelatedByObjectId->setModel('ElementRelationship');
    }

    /**
     * Gets an array of ElementRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Element is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     * @throws PropelException
     */
    public function getElementRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collElementRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initElementRelationshipsRelatedByObjectId();
            } else {
                $collElementRelationshipsRelatedByObjectId = ElementRelationshipQuery::create(null, $criteria)
                    ->filterByElementRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementRelationshipsRelatedByObjectIdPartial && count($collElementRelationshipsRelatedByObjectId)) {
                      $this->initElementRelationshipsRelatedByObjectId(false);

                      foreach($collElementRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collElementRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collElementRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collElementRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collElementRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collElementRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collElementRelationshipsRelatedByObjectId) {
                    foreach($this->collElementRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collElementRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collElementRelationshipsRelatedByObjectId = $collElementRelationshipsRelatedByObjectId;
                $this->collElementRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collElementRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of ElementRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Element The current object (for fluent API support)
     */
    public function setElementRelationshipsRelatedByObjectId(PropelCollection $elementRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $elementRelationshipsRelatedByObjectIdToDelete = $this->getElementRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($elementRelationshipsRelatedByObjectId);

        $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($elementRelationshipsRelatedByObjectIdToDelete));

        foreach ($elementRelationshipsRelatedByObjectIdToDelete as $elementRelationshipRelatedByObjectIdRemoved) {
            $elementRelationshipRelatedByObjectIdRemoved->setElementRelatedByObjectId(null);
        }

        $this->collElementRelationshipsRelatedByObjectId = null;
        foreach ($elementRelationshipsRelatedByObjectId as $elementRelationshipRelatedByObjectId) {
            $this->addElementRelationshipRelatedByObjectId($elementRelationshipRelatedByObjectId);
        }

        $this->collElementRelationshipsRelatedByObjectId = $elementRelationshipsRelatedByObjectId;
        $this->collElementRelationshipsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementRelationship objects.
     * @throws PropelException
     */
    public function countElementRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collElementRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementRelationshipsRelatedByObjectId());
            }
            $query = ElementRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElementRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collElementRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a ElementRelationship object to this object
     * through the ElementRelationship foreign key attribute.
     *
     * @param    ElementRelationship $l ElementRelationship
     * @return Element The current object (for fluent API support)
     */
    public function addElementRelationshipRelatedByObjectId(ElementRelationship $l)
    {
        if ($this->collElementRelationshipsRelatedByObjectId === null) {
            $this->initElementRelationshipsRelatedByObjectId();
            $this->collElementRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collElementRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	ElementRelationshipRelatedByObjectId $elementRelationshipRelatedByObjectId The elementRelationshipRelatedByObjectId object to add.
     */
    protected function doAddElementRelationshipRelatedByObjectId($elementRelationshipRelatedByObjectId)
    {
        $this->collElementRelationshipsRelatedByObjectId[]= $elementRelationshipRelatedByObjectId;
        $elementRelationshipRelatedByObjectId->setElementRelatedByObjectId($this);
    }

    /**
     * @param	ElementRelationshipRelatedByObjectId $elementRelationshipRelatedByObjectId The elementRelationshipRelatedByObjectId object to remove.
     * @return Element The current object (for fluent API support)
     */
    public function removeElementRelationshipRelatedByObjectId($elementRelationshipRelatedByObjectId)
    {
        if ($this->getElementRelationshipsRelatedByObjectId()->contains($elementRelationshipRelatedByObjectId)) {
            $this->collElementRelationshipsRelatedByObjectId->remove($this->collElementRelationshipsRelatedByObjectId->search($elementRelationshipRelatedByObjectId));
            if (null === $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collElementRelationshipsRelatedByObjectId;
                $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->elementRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $elementRelationshipRelatedByObjectId;
            $elementRelationshipRelatedByObjectId->setElementRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Element is new, it will return
     * an empty collection; or if this Element has previously
     * been saved, it will retrieve related ElementRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Element.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     */
    public function getElementRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElementRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collElementRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Element The current object (for fluent API support)
     * @see        addElementRelationshipsRelatedBySubjectId()
     */
    public function clearElementRelationshipsRelatedBySubjectId()
    {
        $this->collElementRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collElementRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collElementRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collElementRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collElementRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collElementRelationshipsRelatedBySubjectId collection to an empty array (like clearcollElementRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collElementRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collElementRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collElementRelationshipsRelatedBySubjectId->setModel('ElementRelationship');
    }

    /**
     * Gets an array of ElementRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Element is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     * @throws PropelException
     */
    public function getElementRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collElementRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initElementRelationshipsRelatedBySubjectId();
            } else {
                $collElementRelationshipsRelatedBySubjectId = ElementRelationshipQuery::create(null, $criteria)
                    ->filterByElementRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementRelationshipsRelatedBySubjectIdPartial && count($collElementRelationshipsRelatedBySubjectId)) {
                      $this->initElementRelationshipsRelatedBySubjectId(false);

                      foreach($collElementRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collElementRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collElementRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collElementRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collElementRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collElementRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collElementRelationshipsRelatedBySubjectId) {
                    foreach($this->collElementRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collElementRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collElementRelationshipsRelatedBySubjectId = $collElementRelationshipsRelatedBySubjectId;
                $this->collElementRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collElementRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of ElementRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Element The current object (for fluent API support)
     */
    public function setElementRelationshipsRelatedBySubjectId(PropelCollection $elementRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $elementRelationshipsRelatedBySubjectIdToDelete = $this->getElementRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($elementRelationshipsRelatedBySubjectId);

        $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($elementRelationshipsRelatedBySubjectIdToDelete));

        foreach ($elementRelationshipsRelatedBySubjectIdToDelete as $elementRelationshipRelatedBySubjectIdRemoved) {
            $elementRelationshipRelatedBySubjectIdRemoved->setElementRelatedBySubjectId(null);
        }

        $this->collElementRelationshipsRelatedBySubjectId = null;
        foreach ($elementRelationshipsRelatedBySubjectId as $elementRelationshipRelatedBySubjectId) {
            $this->addElementRelationshipRelatedBySubjectId($elementRelationshipRelatedBySubjectId);
        }

        $this->collElementRelationshipsRelatedBySubjectId = $elementRelationshipsRelatedBySubjectId;
        $this->collElementRelationshipsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ElementRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ElementRelationship objects.
     * @throws PropelException
     */
    public function countElementRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collElementRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementRelationshipsRelatedBySubjectId());
            }
            $query = ElementRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElementRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collElementRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a ElementRelationship object to this object
     * through the ElementRelationship foreign key attribute.
     *
     * @param    ElementRelationship $l ElementRelationship
     * @return Element The current object (for fluent API support)
     */
    public function addElementRelationshipRelatedBySubjectId(ElementRelationship $l)
    {
        if ($this->collElementRelationshipsRelatedBySubjectId === null) {
            $this->initElementRelationshipsRelatedBySubjectId();
            $this->collElementRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collElementRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	ElementRelationshipRelatedBySubjectId $elementRelationshipRelatedBySubjectId The elementRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddElementRelationshipRelatedBySubjectId($elementRelationshipRelatedBySubjectId)
    {
        $this->collElementRelationshipsRelatedBySubjectId[]= $elementRelationshipRelatedBySubjectId;
        $elementRelationshipRelatedBySubjectId->setElementRelatedBySubjectId($this);
    }

    /**
     * @param	ElementRelationshipRelatedBySubjectId $elementRelationshipRelatedBySubjectId The elementRelationshipRelatedBySubjectId object to remove.
     * @return Element The current object (for fluent API support)
     */
    public function removeElementRelationshipRelatedBySubjectId($elementRelationshipRelatedBySubjectId)
    {
        if ($this->getElementRelationshipsRelatedBySubjectId()->contains($elementRelationshipRelatedBySubjectId)) {
            $this->collElementRelationshipsRelatedBySubjectId->remove($this->collElementRelationshipsRelatedBySubjectId->search($elementRelationshipRelatedBySubjectId));
            if (null === $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collElementRelationshipsRelatedBySubjectId;
                $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->elementRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $elementRelationshipRelatedBySubjectId;
            $elementRelationshipRelatedBySubjectId->setElementRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Element is new, it will return
     * an empty collection; or if this Element has previously
     * been saved, it will retrieve related ElementRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Element.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ElementRelationship[] List of ElementRelationship objects
     */
    public function getElementRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElementRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collElementresults collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Element The current object (for fluent API support)
     * @see        addElementresults()
     */
    public function clearElementresults()
    {
        $this->collElementresults = null; // important to set this to null since that means it is uninitialized
        $this->collElementresultsPartial = null;

        return $this;
    }

    /**
     * reset is the collElementresults collection loaded partially
     *
     * @return void
     */
    public function resetPartialElementresults($v = true)
    {
        $this->collElementresultsPartial = $v;
    }

    /**
     * Initializes the collElementresults collection.
     *
     * By default this just sets the collElementresults collection to an empty array (like clearcollElementresults());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElementresults($overrideExisting = true)
    {
        if (null !== $this->collElementresults && !$overrideExisting) {
            return;
        }
        $this->collElementresults = new PropelObjectCollection();
        $this->collElementresults->setModel('Elementresult');
    }

    /**
     * Gets an array of Elementresult objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Element is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Elementresult[] List of Elementresult objects
     * @throws PropelException
     */
    public function getElementresults($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementresultsPartial && !$this->isNew();
        if (null === $this->collElementresults || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElementresults) {
                // return empty collection
                $this->initElementresults();
            } else {
                $collElementresults = ElementresultQuery::create(null, $criteria)
                    ->filterByElement($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementresultsPartial && count($collElementresults)) {
                      $this->initElementresults(false);

                      foreach($collElementresults as $obj) {
                        if (false == $this->collElementresults->contains($obj)) {
                          $this->collElementresults->append($obj);
                        }
                      }

                      $this->collElementresultsPartial = true;
                    }

                    $collElementresults->getInternalIterator()->rewind();
                    return $collElementresults;
                }

                if($partial && $this->collElementresults) {
                    foreach($this->collElementresults as $obj) {
                        if($obj->isNew()) {
                            $collElementresults[] = $obj;
                        }
                    }
                }

                $this->collElementresults = $collElementresults;
                $this->collElementresultsPartial = false;
            }
        }

        return $this->collElementresults;
    }

    /**
     * Sets a collection of Elementresult objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elementresults A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Element The current object (for fluent API support)
     */
    public function setElementresults(PropelCollection $elementresults, PropelPDO $con = null)
    {
        $elementresultsToDelete = $this->getElementresults(new Criteria(), $con)->diff($elementresults);

        $this->elementresultsScheduledForDeletion = unserialize(serialize($elementresultsToDelete));

        foreach ($elementresultsToDelete as $elementresultRemoved) {
            $elementresultRemoved->setElement(null);
        }

        $this->collElementresults = null;
        foreach ($elementresults as $elementresult) {
            $this->addElementresult($elementresult);
        }

        $this->collElementresults = $elementresults;
        $this->collElementresultsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Elementresult objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Elementresult objects.
     * @throws PropelException
     */
    public function countElementresults(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementresultsPartial && !$this->isNew();
        if (null === $this->collElementresults || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElementresults) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElementresults());
            }
            $query = ElementresultQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByElement($this)
                ->count($con);
        }

        return count($this->collElementresults);
    }

    /**
     * Method called to associate a Elementresult object to this object
     * through the Elementresult foreign key attribute.
     *
     * @param    Elementresult $l Elementresult
     * @return Element The current object (for fluent API support)
     */
    public function addElementresult(Elementresult $l)
    {
        if ($this->collElementresults === null) {
            $this->initElementresults();
            $this->collElementresultsPartial = true;
        }
        if (!in_array($l, $this->collElementresults->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElementresult($l);
        }

        return $this;
    }

    /**
     * @param	Elementresult $elementresult The elementresult object to add.
     */
    protected function doAddElementresult($elementresult)
    {
        $this->collElementresults[]= $elementresult;
        $elementresult->setElement($this);
    }

    /**
     * @param	Elementresult $elementresult The elementresult object to remove.
     * @return Element The current object (for fluent API support)
     */
    public function removeElementresult($elementresult)
    {
        if ($this->getElementresults()->contains($elementresult)) {
            $this->collElementresults->remove($this->collElementresults->search($elementresult));
            if (null === $this->elementresultsScheduledForDeletion) {
                $this->elementresultsScheduledForDeletion = clone $this->collElementresults;
                $this->elementresultsScheduledForDeletion->clear();
            }
            $this->elementresultsScheduledForDeletion[]= clone $elementresult;
            $elementresult->setElement(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Element is new, it will return
     * an empty collection; or if this Element has previously
     * been saved, it will retrieve related Elementresults from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Element.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Elementresult[] List of Elementresult objects
     */
    public function getElementresultsJoinQuantification($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementresultQuery::create(null, $criteria);
        $query->joinWith('Quantification', $join_behavior);

        return $this->getElementresults($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->element_id = null;
        $this->feature_id = null;
        $this->arraydesign_id = null;
        $this->type_id = null;
        $this->dbxref_id = null;
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
            if ($this->collElementRelationshipsRelatedByObjectId) {
                foreach ($this->collElementRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementRelationshipsRelatedBySubjectId) {
                foreach ($this->collElementRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElementresults) {
                foreach ($this->collElementresults as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aArraydesign instanceof Persistent) {
              $this->aArraydesign->clearAllReferences($deep);
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }
            if ($this->aFeature instanceof Persistent) {
              $this->aFeature->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collElementRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collElementRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collElementRelationshipsRelatedByObjectId = null;
        if ($this->collElementRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collElementRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collElementRelationshipsRelatedBySubjectId = null;
        if ($this->collElementresults instanceof PropelCollection) {
            $this->collElementresults->clearIterator();
        }
        $this->collElementresults = null;
        $this->aArraydesign = null;
        $this->aDbxref = null;
        $this->aFeature = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ElementPeer::DEFAULT_STRING_FORMAT);
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
