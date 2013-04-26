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
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;
use cli_db\propel\Study;
use cli_db\propel\StudyAssay;
use cli_db\propel\StudyAssayQuery;
use cli_db\propel\StudyPeer;
use cli_db\propel\StudyQuery;
use cli_db\propel\Studydesign;
use cli_db\propel\StudydesignQuery;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropQuery;

/**
 * Base class that represents a row from the 'study' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudy extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\StudyPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        StudyPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the study_id field.
     * @var        int
     */
    protected $study_id;

    /**
     * The value for the contact_id field.
     * @var        int
     */
    protected $contact_id;

    /**
     * The value for the pub_id field.
     * @var        int
     */
    protected $pub_id;

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
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        Pub
     */
    protected $aPub;

    /**
     * @var        PropelObjectCollection|StudyAssay[] Collection to store aggregation of StudyAssay objects.
     */
    protected $collStudyAssays;
    protected $collStudyAssaysPartial;

    /**
     * @var        PropelObjectCollection|Studydesign[] Collection to store aggregation of Studydesign objects.
     */
    protected $collStudydesigns;
    protected $collStudydesignsPartial;

    /**
     * @var        PropelObjectCollection|Studyprop[] Collection to store aggregation of Studyprop objects.
     */
    protected $collStudyprops;
    protected $collStudypropsPartial;

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
    protected $studyAssaysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studydesignsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studypropsScheduledForDeletion = null;

    /**
     * Get the [study_id] column value.
     *
     * @return int
     */
    public function getStudyId()
    {
        return $this->study_id;
    }

    /**
     * Get the [contact_id] column value.
     *
     * @return int
     */
    public function getContactId()
    {
        return $this->contact_id;
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
     * Set the value of [study_id] column.
     *
     * @param int $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setStudyId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->study_id !== $v) {
            $this->study_id = $v;
            $this->modifiedColumns[] = StudyPeer::STUDY_ID;
        }


        return $this;
    } // setStudyId()

    /**
     * Set the value of [contact_id] column.
     *
     * @param int $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setContactId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->contact_id !== $v) {
            $this->contact_id = $v;
            $this->modifiedColumns[] = StudyPeer::CONTACT_ID;
        }

        if ($this->aContact !== null && $this->aContact->getContactId() !== $v) {
            $this->aContact = null;
        }


        return $this;
    } // setContactId()

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = StudyPeer::PUB_ID;
        }

        if ($this->aPub !== null && $this->aPub->getPubId() !== $v) {
            $this->aPub = null;
        }


        return $this;
    } // setPubId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = StudyPeer::DBXREF_ID;
        }

        if ($this->aDbxref !== null && $this->aDbxref->getDbxrefId() !== $v) {
            $this->aDbxref = null;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = StudyPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Study The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = StudyPeer::DESCRIPTION;
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

            $this->study_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->contact_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->pub_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->dbxref_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = StudyPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Study object", $e);
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

        if ($this->aContact !== null && $this->contact_id !== $this->aContact->getContactId()) {
            $this->aContact = null;
        }
        if ($this->aPub !== null && $this->pub_id !== $this->aPub->getPubId()) {
            $this->aPub = null;
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
            $con = Propel::getConnection(StudyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = StudyPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aContact = null;
            $this->aDbxref = null;
            $this->aPub = null;
            $this->collStudyAssays = null;

            $this->collStudydesigns = null;

            $this->collStudyprops = null;

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
            $con = Propel::getConnection(StudyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = StudyQuery::create()
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
            $con = Propel::getConnection(StudyPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                StudyPeer::addInstanceToPool($this);
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

            if ($this->aDbxref !== null) {
                if ($this->aDbxref->isModified() || $this->aDbxref->isNew()) {
                    $affectedRows += $this->aDbxref->save($con);
                }
                $this->setDbxref($this->aDbxref);
            }

            if ($this->aPub !== null) {
                if ($this->aPub->isModified() || $this->aPub->isNew()) {
                    $affectedRows += $this->aPub->save($con);
                }
                $this->setPub($this->aPub);
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

            if ($this->studyAssaysScheduledForDeletion !== null) {
                if (!$this->studyAssaysScheduledForDeletion->isEmpty()) {
                    StudyAssayQuery::create()
                        ->filterByPrimaryKeys($this->studyAssaysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studyAssaysScheduledForDeletion = null;
                }
            }

            if ($this->collStudyAssays !== null) {
                foreach ($this->collStudyAssays as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studydesignsScheduledForDeletion !== null) {
                if (!$this->studydesignsScheduledForDeletion->isEmpty()) {
                    StudydesignQuery::create()
                        ->filterByPrimaryKeys($this->studydesignsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studydesignsScheduledForDeletion = null;
                }
            }

            if ($this->collStudydesigns !== null) {
                foreach ($this->collStudydesigns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studypropsScheduledForDeletion !== null) {
                if (!$this->studypropsScheduledForDeletion->isEmpty()) {
                    StudypropQuery::create()
                        ->filterByPrimaryKeys($this->studypropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studypropsScheduledForDeletion = null;
                }
            }

            if ($this->collStudyprops !== null) {
                foreach ($this->collStudyprops as $referrerFK) {
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

        $this->modifiedColumns[] = StudyPeer::STUDY_ID;
        if (null !== $this->study_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . StudyPeer::STUDY_ID . ')');
        }
        if (null === $this->study_id) {
            try {
                $stmt = $con->query("SELECT nextval('study_study_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->study_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(StudyPeer::STUDY_ID)) {
            $modifiedColumns[':p' . $index++]  = '"study_id"';
        }
        if ($this->isColumnModified(StudyPeer::CONTACT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"contact_id"';
        }
        if ($this->isColumnModified(StudyPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }
        if ($this->isColumnModified(StudyPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(StudyPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(StudyPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "study" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"study_id"':
                        $stmt->bindValue($identifier, $this->study_id, PDO::PARAM_INT);
                        break;
                    case '"contact_id"':
                        $stmt->bindValue($identifier, $this->contact_id, PDO::PARAM_INT);
                        break;
                    case '"pub_id"':
                        $stmt->bindValue($identifier, $this->pub_id, PDO::PARAM_INT);
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

            if ($this->aDbxref !== null) {
                if (!$this->aDbxref->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDbxref->getValidationFailures());
                }
            }

            if ($this->aPub !== null) {
                if (!$this->aPub->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aPub->getValidationFailures());
                }
            }


            if (($retval = StudyPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collStudyAssays !== null) {
                    foreach ($this->collStudyAssays as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudydesigns !== null) {
                    foreach ($this->collStudydesigns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudyprops !== null) {
                    foreach ($this->collStudyprops as $referrerFK) {
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
        $pos = StudyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getStudyId();
                break;
            case 1:
                return $this->getContactId();
                break;
            case 2:
                return $this->getPubId();
                break;
            case 3:
                return $this->getDbxrefId();
                break;
            case 4:
                return $this->getName();
                break;
            case 5:
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
        if (isset($alreadyDumpedObjects['Study'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Study'][$this->getPrimaryKey()] = true;
        $keys = StudyPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getStudyId(),
            $keys[1] => $this->getContactId(),
            $keys[2] => $this->getPubId(),
            $keys[3] => $this->getDbxrefId(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aContact) {
                $result['Contact'] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPub) {
                $result['Pub'] = $this->aPub->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collStudyAssays) {
                $result['StudyAssays'] = $this->collStudyAssays->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudydesigns) {
                $result['Studydesigns'] = $this->collStudydesigns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudyprops) {
                $result['Studyprops'] = $this->collStudyprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = StudyPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setStudyId($value);
                break;
            case 1:
                $this->setContactId($value);
                break;
            case 2:
                $this->setPubId($value);
                break;
            case 3:
                $this->setDbxrefId($value);
                break;
            case 4:
                $this->setName($value);
                break;
            case 5:
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
        $keys = StudyPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setStudyId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setContactId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPubId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDbxrefId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDescription($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(StudyPeer::DATABASE_NAME);

        if ($this->isColumnModified(StudyPeer::STUDY_ID)) $criteria->add(StudyPeer::STUDY_ID, $this->study_id);
        if ($this->isColumnModified(StudyPeer::CONTACT_ID)) $criteria->add(StudyPeer::CONTACT_ID, $this->contact_id);
        if ($this->isColumnModified(StudyPeer::PUB_ID)) $criteria->add(StudyPeer::PUB_ID, $this->pub_id);
        if ($this->isColumnModified(StudyPeer::DBXREF_ID)) $criteria->add(StudyPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(StudyPeer::NAME)) $criteria->add(StudyPeer::NAME, $this->name);
        if ($this->isColumnModified(StudyPeer::DESCRIPTION)) $criteria->add(StudyPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(StudyPeer::DATABASE_NAME);
        $criteria->add(StudyPeer::STUDY_ID, $this->study_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getStudyId();
    }

    /**
     * Generic method to set the primary key (study_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setStudyId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getStudyId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Study (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setContactId($this->getContactId());
        $copyObj->setPubId($this->getPubId());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getStudyAssays() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyAssay($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudydesigns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudydesign($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudyprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudyprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setStudyId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Study Clone of current object.
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
     * @return StudyPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new StudyPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Contact object.
     *
     * @param             Contact $v
     * @return Study The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(Contact $v = null)
    {
        if ($v === null) {
            $this->setContactId(NULL);
        } else {
            $this->setContactId($v->getContactId());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Contact object, it will not be re-added.
        if ($v !== null) {
            $v->addStudy($this);
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
        if ($this->aContact === null && ($this->contact_id !== null) && $doQuery) {
            $this->aContact = ContactQuery::create()->findPk($this->contact_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addStudys($this);
             */
        }

        return $this->aContact;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Study The current object (for fluent API support)
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
            $v->addStudy($this);
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
                $this->aDbxref->addStudys($this);
             */
        }

        return $this->aDbxref;
    }

    /**
     * Declares an association between this object and a Pub object.
     *
     * @param             Pub $v
     * @return Study The current object (for fluent API support)
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
            $v->addStudy($this);
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
                $this->aPub->addStudys($this);
             */
        }

        return $this->aPub;
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
        if ('StudyAssay' == $relationName) {
            $this->initStudyAssays();
        }
        if ('Studydesign' == $relationName) {
            $this->initStudydesigns();
        }
        if ('Studyprop' == $relationName) {
            $this->initStudyprops();
        }
    }

    /**
     * Clears out the collStudyAssays collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Study The current object (for fluent API support)
     * @see        addStudyAssays()
     */
    public function clearStudyAssays()
    {
        $this->collStudyAssays = null; // important to set this to null since that means it is uninitialized
        $this->collStudyAssaysPartial = null;

        return $this;
    }

    /**
     * reset is the collStudyAssays collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudyAssays($v = true)
    {
        $this->collStudyAssaysPartial = $v;
    }

    /**
     * Initializes the collStudyAssays collection.
     *
     * By default this just sets the collStudyAssays collection to an empty array (like clearcollStudyAssays());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyAssays($overrideExisting = true)
    {
        if (null !== $this->collStudyAssays && !$overrideExisting) {
            return;
        }
        $this->collStudyAssays = new PropelObjectCollection();
        $this->collStudyAssays->setModel('StudyAssay');
    }

    /**
     * Gets an array of StudyAssay objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Study is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|StudyAssay[] List of StudyAssay objects
     * @throws PropelException
     */
    public function getStudyAssays($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudyAssaysPartial && !$this->isNew();
        if (null === $this->collStudyAssays || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyAssays) {
                // return empty collection
                $this->initStudyAssays();
            } else {
                $collStudyAssays = StudyAssayQuery::create(null, $criteria)
                    ->filterByStudy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudyAssaysPartial && count($collStudyAssays)) {
                      $this->initStudyAssays(false);

                      foreach($collStudyAssays as $obj) {
                        if (false == $this->collStudyAssays->contains($obj)) {
                          $this->collStudyAssays->append($obj);
                        }
                      }

                      $this->collStudyAssaysPartial = true;
                    }

                    $collStudyAssays->getInternalIterator()->rewind();
                    return $collStudyAssays;
                }

                if($partial && $this->collStudyAssays) {
                    foreach($this->collStudyAssays as $obj) {
                        if($obj->isNew()) {
                            $collStudyAssays[] = $obj;
                        }
                    }
                }

                $this->collStudyAssays = $collStudyAssays;
                $this->collStudyAssaysPartial = false;
            }
        }

        return $this->collStudyAssays;
    }

    /**
     * Sets a collection of StudyAssay objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studyAssays A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Study The current object (for fluent API support)
     */
    public function setStudyAssays(PropelCollection $studyAssays, PropelPDO $con = null)
    {
        $studyAssaysToDelete = $this->getStudyAssays(new Criteria(), $con)->diff($studyAssays);

        $this->studyAssaysScheduledForDeletion = unserialize(serialize($studyAssaysToDelete));

        foreach ($studyAssaysToDelete as $studyAssayRemoved) {
            $studyAssayRemoved->setStudy(null);
        }

        $this->collStudyAssays = null;
        foreach ($studyAssays as $studyAssay) {
            $this->addStudyAssay($studyAssay);
        }

        $this->collStudyAssays = $studyAssays;
        $this->collStudyAssaysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related StudyAssay objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related StudyAssay objects.
     * @throws PropelException
     */
    public function countStudyAssays(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudyAssaysPartial && !$this->isNew();
        if (null === $this->collStudyAssays || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyAssays) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudyAssays());
            }
            $query = StudyAssayQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStudy($this)
                ->count($con);
        }

        return count($this->collStudyAssays);
    }

    /**
     * Method called to associate a StudyAssay object to this object
     * through the StudyAssay foreign key attribute.
     *
     * @param    StudyAssay $l StudyAssay
     * @return Study The current object (for fluent API support)
     */
    public function addStudyAssay(StudyAssay $l)
    {
        if ($this->collStudyAssays === null) {
            $this->initStudyAssays();
            $this->collStudyAssaysPartial = true;
        }
        if (!in_array($l, $this->collStudyAssays->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudyAssay($l);
        }

        return $this;
    }

    /**
     * @param	StudyAssay $studyAssay The studyAssay object to add.
     */
    protected function doAddStudyAssay($studyAssay)
    {
        $this->collStudyAssays[]= $studyAssay;
        $studyAssay->setStudy($this);
    }

    /**
     * @param	StudyAssay $studyAssay The studyAssay object to remove.
     * @return Study The current object (for fluent API support)
     */
    public function removeStudyAssay($studyAssay)
    {
        if ($this->getStudyAssays()->contains($studyAssay)) {
            $this->collStudyAssays->remove($this->collStudyAssays->search($studyAssay));
            if (null === $this->studyAssaysScheduledForDeletion) {
                $this->studyAssaysScheduledForDeletion = clone $this->collStudyAssays;
                $this->studyAssaysScheduledForDeletion->clear();
            }
            $this->studyAssaysScheduledForDeletion[]= clone $studyAssay;
            $studyAssay->setStudy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Study is new, it will return
     * an empty collection; or if this Study has previously
     * been saved, it will retrieve related StudyAssays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Study.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|StudyAssay[] List of StudyAssay objects
     */
    public function getStudyAssaysJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyAssayQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getStudyAssays($query, $con);
    }

    /**
     * Clears out the collStudydesigns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Study The current object (for fluent API support)
     * @see        addStudydesigns()
     */
    public function clearStudydesigns()
    {
        $this->collStudydesigns = null; // important to set this to null since that means it is uninitialized
        $this->collStudydesignsPartial = null;

        return $this;
    }

    /**
     * reset is the collStudydesigns collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudydesigns($v = true)
    {
        $this->collStudydesignsPartial = $v;
    }

    /**
     * Initializes the collStudydesigns collection.
     *
     * By default this just sets the collStudydesigns collection to an empty array (like clearcollStudydesigns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudydesigns($overrideExisting = true)
    {
        if (null !== $this->collStudydesigns && !$overrideExisting) {
            return;
        }
        $this->collStudydesigns = new PropelObjectCollection();
        $this->collStudydesigns->setModel('Studydesign');
    }

    /**
     * Gets an array of Studydesign objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Study is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studydesign[] List of Studydesign objects
     * @throws PropelException
     */
    public function getStudydesigns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudydesignsPartial && !$this->isNew();
        if (null === $this->collStudydesigns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudydesigns) {
                // return empty collection
                $this->initStudydesigns();
            } else {
                $collStudydesigns = StudydesignQuery::create(null, $criteria)
                    ->filterByStudy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudydesignsPartial && count($collStudydesigns)) {
                      $this->initStudydesigns(false);

                      foreach($collStudydesigns as $obj) {
                        if (false == $this->collStudydesigns->contains($obj)) {
                          $this->collStudydesigns->append($obj);
                        }
                      }

                      $this->collStudydesignsPartial = true;
                    }

                    $collStudydesigns->getInternalIterator()->rewind();
                    return $collStudydesigns;
                }

                if($partial && $this->collStudydesigns) {
                    foreach($this->collStudydesigns as $obj) {
                        if($obj->isNew()) {
                            $collStudydesigns[] = $obj;
                        }
                    }
                }

                $this->collStudydesigns = $collStudydesigns;
                $this->collStudydesignsPartial = false;
            }
        }

        return $this->collStudydesigns;
    }

    /**
     * Sets a collection of Studydesign objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studydesigns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Study The current object (for fluent API support)
     */
    public function setStudydesigns(PropelCollection $studydesigns, PropelPDO $con = null)
    {
        $studydesignsToDelete = $this->getStudydesigns(new Criteria(), $con)->diff($studydesigns);

        $this->studydesignsScheduledForDeletion = unserialize(serialize($studydesignsToDelete));

        foreach ($studydesignsToDelete as $studydesignRemoved) {
            $studydesignRemoved->setStudy(null);
        }

        $this->collStudydesigns = null;
        foreach ($studydesigns as $studydesign) {
            $this->addStudydesign($studydesign);
        }

        $this->collStudydesigns = $studydesigns;
        $this->collStudydesignsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studydesign objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studydesign objects.
     * @throws PropelException
     */
    public function countStudydesigns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudydesignsPartial && !$this->isNew();
        if (null === $this->collStudydesigns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudydesigns) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudydesigns());
            }
            $query = StudydesignQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStudy($this)
                ->count($con);
        }

        return count($this->collStudydesigns);
    }

    /**
     * Method called to associate a Studydesign object to this object
     * through the Studydesign foreign key attribute.
     *
     * @param    Studydesign $l Studydesign
     * @return Study The current object (for fluent API support)
     */
    public function addStudydesign(Studydesign $l)
    {
        if ($this->collStudydesigns === null) {
            $this->initStudydesigns();
            $this->collStudydesignsPartial = true;
        }
        if (!in_array($l, $this->collStudydesigns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudydesign($l);
        }

        return $this;
    }

    /**
     * @param	Studydesign $studydesign The studydesign object to add.
     */
    protected function doAddStudydesign($studydesign)
    {
        $this->collStudydesigns[]= $studydesign;
        $studydesign->setStudy($this);
    }

    /**
     * @param	Studydesign $studydesign The studydesign object to remove.
     * @return Study The current object (for fluent API support)
     */
    public function removeStudydesign($studydesign)
    {
        if ($this->getStudydesigns()->contains($studydesign)) {
            $this->collStudydesigns->remove($this->collStudydesigns->search($studydesign));
            if (null === $this->studydesignsScheduledForDeletion) {
                $this->studydesignsScheduledForDeletion = clone $this->collStudydesigns;
                $this->studydesignsScheduledForDeletion->clear();
            }
            $this->studydesignsScheduledForDeletion[]= clone $studydesign;
            $studydesign->setStudy(null);
        }

        return $this;
    }

    /**
     * Clears out the collStudyprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Study The current object (for fluent API support)
     * @see        addStudyprops()
     */
    public function clearStudyprops()
    {
        $this->collStudyprops = null; // important to set this to null since that means it is uninitialized
        $this->collStudypropsPartial = null;

        return $this;
    }

    /**
     * reset is the collStudyprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudyprops($v = true)
    {
        $this->collStudypropsPartial = $v;
    }

    /**
     * Initializes the collStudyprops collection.
     *
     * By default this just sets the collStudyprops collection to an empty array (like clearcollStudyprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudyprops($overrideExisting = true)
    {
        if (null !== $this->collStudyprops && !$overrideExisting) {
            return;
        }
        $this->collStudyprops = new PropelObjectCollection();
        $this->collStudyprops->setModel('Studyprop');
    }

    /**
     * Gets an array of Studyprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Study is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Studyprop[] List of Studyprop objects
     * @throws PropelException
     */
    public function getStudyprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudypropsPartial && !$this->isNew();
        if (null === $this->collStudyprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudyprops) {
                // return empty collection
                $this->initStudyprops();
            } else {
                $collStudyprops = StudypropQuery::create(null, $criteria)
                    ->filterByStudy($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudypropsPartial && count($collStudyprops)) {
                      $this->initStudyprops(false);

                      foreach($collStudyprops as $obj) {
                        if (false == $this->collStudyprops->contains($obj)) {
                          $this->collStudyprops->append($obj);
                        }
                      }

                      $this->collStudypropsPartial = true;
                    }

                    $collStudyprops->getInternalIterator()->rewind();
                    return $collStudyprops;
                }

                if($partial && $this->collStudyprops) {
                    foreach($this->collStudyprops as $obj) {
                        if($obj->isNew()) {
                            $collStudyprops[] = $obj;
                        }
                    }
                }

                $this->collStudyprops = $collStudyprops;
                $this->collStudypropsPartial = false;
            }
        }

        return $this->collStudyprops;
    }

    /**
     * Sets a collection of Studyprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studyprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Study The current object (for fluent API support)
     */
    public function setStudyprops(PropelCollection $studyprops, PropelPDO $con = null)
    {
        $studypropsToDelete = $this->getStudyprops(new Criteria(), $con)->diff($studyprops);

        $this->studypropsScheduledForDeletion = unserialize(serialize($studypropsToDelete));

        foreach ($studypropsToDelete as $studypropRemoved) {
            $studypropRemoved->setStudy(null);
        }

        $this->collStudyprops = null;
        foreach ($studyprops as $studyprop) {
            $this->addStudyprop($studyprop);
        }

        $this->collStudyprops = $studyprops;
        $this->collStudypropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Studyprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Studyprop objects.
     * @throws PropelException
     */
    public function countStudyprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudypropsPartial && !$this->isNew();
        if (null === $this->collStudyprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudyprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudyprops());
            }
            $query = StudypropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByStudy($this)
                ->count($con);
        }

        return count($this->collStudyprops);
    }

    /**
     * Method called to associate a Studyprop object to this object
     * through the Studyprop foreign key attribute.
     *
     * @param    Studyprop $l Studyprop
     * @return Study The current object (for fluent API support)
     */
    public function addStudyprop(Studyprop $l)
    {
        if ($this->collStudyprops === null) {
            $this->initStudyprops();
            $this->collStudypropsPartial = true;
        }
        if (!in_array($l, $this->collStudyprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudyprop($l);
        }

        return $this;
    }

    /**
     * @param	Studyprop $studyprop The studyprop object to add.
     */
    protected function doAddStudyprop($studyprop)
    {
        $this->collStudyprops[]= $studyprop;
        $studyprop->setStudy($this);
    }

    /**
     * @param	Studyprop $studyprop The studyprop object to remove.
     * @return Study The current object (for fluent API support)
     */
    public function removeStudyprop($studyprop)
    {
        if ($this->getStudyprops()->contains($studyprop)) {
            $this->collStudyprops->remove($this->collStudyprops->search($studyprop));
            if (null === $this->studypropsScheduledForDeletion) {
                $this->studypropsScheduledForDeletion = clone $this->collStudyprops;
                $this->studypropsScheduledForDeletion->clear();
            }
            $this->studypropsScheduledForDeletion[]= clone $studyprop;
            $studyprop->setStudy(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Study is new, it will return
     * an empty collection; or if this Study has previously
     * been saved, it will retrieve related Studyprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Study.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Studyprop[] List of Studyprop objects
     */
    public function getStudypropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudypropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getStudyprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->study_id = null;
        $this->contact_id = null;
        $this->pub_id = null;
        $this->dbxref_id = null;
        $this->name = null;
        $this->description = null;
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
            if ($this->collStudyAssays) {
                foreach ($this->collStudyAssays as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudydesigns) {
                foreach ($this->collStudydesigns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudyprops) {
                foreach ($this->collStudyprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aContact instanceof Persistent) {
              $this->aContact->clearAllReferences($deep);
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }
            if ($this->aPub instanceof Persistent) {
              $this->aPub->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collStudyAssays instanceof PropelCollection) {
            $this->collStudyAssays->clearIterator();
        }
        $this->collStudyAssays = null;
        if ($this->collStudydesigns instanceof PropelCollection) {
            $this->collStudydesigns->clearIterator();
        }
        $this->collStudydesigns = null;
        if ($this->collStudyprops instanceof PropelCollection) {
            $this->collStudyprops->clearIterator();
        }
        $this->collStudyprops = null;
        $this->aContact = null;
        $this->aDbxref = null;
        $this->aPub = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(StudyPeer::DEFAULT_STRING_FORMAT);
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
