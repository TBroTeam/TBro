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
use cli_db\propel\Assay;
use cli_db\propel\AssayQuery;
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactPeer;
use cli_db\propel\ContactQuery;
use cli_db\propel\ContactRelationship;
use cli_db\propel\ContactRelationshipQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\ProjectContact;
use cli_db\propel\ProjectContactQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationQuery;
use cli_db\propel\Study;
use cli_db\propel\StudyQuery;

/**
 * Base class that represents a row from the 'contact' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseContact extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ContactPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ContactPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the contact_id field.
     * @var        int
     */
    protected $contact_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

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
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|Arraydesign[] Collection to store aggregation of Arraydesign objects.
     */
    protected $collArraydesigns;
    protected $collArraydesignsPartial;

    /**
     * @var        PropelObjectCollection|Assay[] Collection to store aggregation of Assay objects.
     */
    protected $collAssays;
    protected $collAssaysPartial;

    /**
     * @var        PropelObjectCollection|Biomaterial[] Collection to store aggregation of Biomaterial objects.
     */
    protected $collBiomaterials;
    protected $collBiomaterialsPartial;

    /**
     * @var        PropelObjectCollection|ContactRelationship[] Collection to store aggregation of ContactRelationship objects.
     */
    protected $collContactRelationshipsRelatedByObjectId;
    protected $collContactRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|ContactRelationship[] Collection to store aggregation of ContactRelationship objects.
     */
    protected $collContactRelationshipsRelatedBySubjectId;
    protected $collContactRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|ProjectContact[] Collection to store aggregation of ProjectContact objects.
     */
    protected $collProjectContacts;
    protected $collProjectContactsPartial;

    /**
     * @var        PropelObjectCollection|Quantification[] Collection to store aggregation of Quantification objects.
     */
    protected $collQuantifications;
    protected $collQuantificationsPartial;

    /**
     * @var        PropelObjectCollection|Study[] Collection to store aggregation of Study objects.
     */
    protected $collStudys;
    protected $collStudysPartial;

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
    protected $arraydesignsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assaysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contactRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contactRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectContactsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studysScheduledForDeletion = null;

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
     * Get the [type_id] column value.
     *
     * @return int
     */
    public function getTypeId()
    {
        return $this->type_id;
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
     * Set the value of [contact_id] column.
     *
     * @param int $v new value
     * @return Contact The current object (for fluent API support)
     */
    public function setContactId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->contact_id !== $v) {
            $this->contact_id = $v;
            $this->modifiedColumns[] = ContactPeer::CONTACT_ID;
        }


        return $this;
    } // setContactId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Contact The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = ContactPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Contact The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ContactPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Contact The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ContactPeer::DESCRIPTION;
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

            $this->contact_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->description = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 4; // 4 = ContactPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Contact object", $e);
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

        if ($this->aCvterm !== null && $this->type_id !== $this->aCvterm->getCvtermId()) {
            $this->aCvterm = null;
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
            $con = Propel::getConnection(ContactPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ContactPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCvterm = null;
            $this->collArraydesigns = null;

            $this->collAssays = null;

            $this->collBiomaterials = null;

            $this->collContactRelationshipsRelatedByObjectId = null;

            $this->collContactRelationshipsRelatedBySubjectId = null;

            $this->collProjectContacts = null;

            $this->collQuantifications = null;

            $this->collStudys = null;

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
            $con = Propel::getConnection(ContactPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ContactQuery::create()
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
            $con = Propel::getConnection(ContactPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ContactPeer::addInstanceToPool($this);
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

            if ($this->arraydesignsScheduledForDeletion !== null) {
                if (!$this->arraydesignsScheduledForDeletion->isEmpty()) {
                    ArraydesignQuery::create()
                        ->filterByPrimaryKeys($this->arraydesignsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->arraydesignsScheduledForDeletion = null;
                }
            }

            if ($this->collArraydesigns !== null) {
                foreach ($this->collArraydesigns as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->assaysScheduledForDeletion !== null) {
                if (!$this->assaysScheduledForDeletion->isEmpty()) {
                    AssayQuery::create()
                        ->filterByPrimaryKeys($this->assaysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assaysScheduledForDeletion = null;
                }
            }

            if ($this->collAssays !== null) {
                foreach ($this->collAssays as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialsScheduledForDeletion !== null) {
                if (!$this->biomaterialsScheduledForDeletion->isEmpty()) {
                    foreach ($this->biomaterialsScheduledForDeletion as $biomaterial) {
                        // need to save related object because we set the relation to null
                        $biomaterial->save($con);
                    }
                    $this->biomaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterials !== null) {
                foreach ($this->collBiomaterials as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contactRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->contactRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    ContactRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->contactRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collContactRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collContactRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    ContactRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collContactRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collContactRelationshipsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectContactsScheduledForDeletion !== null) {
                if (!$this->projectContactsScheduledForDeletion->isEmpty()) {
                    ProjectContactQuery::create()
                        ->filterByPrimaryKeys($this->projectContactsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectContactsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectContacts !== null) {
                foreach ($this->collProjectContacts as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->quantificationsScheduledForDeletion !== null) {
                if (!$this->quantificationsScheduledForDeletion->isEmpty()) {
                    foreach ($this->quantificationsScheduledForDeletion as $quantification) {
                        // need to save related object because we set the relation to null
                        $quantification->save($con);
                    }
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

            if ($this->studysScheduledForDeletion !== null) {
                if (!$this->studysScheduledForDeletion->isEmpty()) {
                    StudyQuery::create()
                        ->filterByPrimaryKeys($this->studysScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->studysScheduledForDeletion = null;
                }
            }

            if ($this->collStudys !== null) {
                foreach ($this->collStudys as $referrerFK) {
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

        $this->modifiedColumns[] = ContactPeer::CONTACT_ID;
        if (null !== $this->contact_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ContactPeer::CONTACT_ID . ')');
        }
        if (null === $this->contact_id) {
            try {
                $stmt = $con->query("SELECT nextval('contact_contact_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->contact_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ContactPeer::CONTACT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"contact_id"';
        }
        if ($this->isColumnModified(ContactPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(ContactPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ContactPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "contact" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"contact_id"':
                        $stmt->bindValue($identifier, $this->contact_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
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

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = ContactPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collArraydesigns !== null) {
                    foreach ($this->collArraydesigns as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collAssays !== null) {
                    foreach ($this->collAssays as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterials !== null) {
                    foreach ($this->collBiomaterials as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContactRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collContactRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContactRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collContactRelationshipsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectContacts !== null) {
                    foreach ($this->collProjectContacts as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collQuantifications !== null) {
                    foreach ($this->collQuantifications as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collStudys !== null) {
                    foreach ($this->collStudys as $referrerFK) {
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
        $pos = ContactPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getContactId();
                break;
            case 1:
                return $this->getTypeId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
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
        if (isset($alreadyDumpedObjects['Contact'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Contact'][$this->getPrimaryKey()] = true;
        $keys = ContactPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getContactId(),
            $keys[1] => $this->getTypeId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collArraydesigns) {
                $result['Arraydesigns'] = $this->collArraydesigns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssays) {
                $result['Assays'] = $this->collAssays->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterials) {
                $result['Biomaterials'] = $this->collBiomaterials->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContactRelationshipsRelatedByObjectId) {
                $result['ContactRelationshipsRelatedByObjectId'] = $this->collContactRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContactRelationshipsRelatedBySubjectId) {
                $result['ContactRelationshipsRelatedBySubjectId'] = $this->collContactRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectContacts) {
                $result['ProjectContacts'] = $this->collProjectContacts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantifications) {
                $result['Quantifications'] = $this->collQuantifications->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collStudys) {
                $result['Studys'] = $this->collStudys->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ContactPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setContactId($value);
                break;
            case 1:
                $this->setTypeId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
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
        $keys = ContactPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setContactId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDescription($arr[$keys[3]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ContactPeer::DATABASE_NAME);

        if ($this->isColumnModified(ContactPeer::CONTACT_ID)) $criteria->add(ContactPeer::CONTACT_ID, $this->contact_id);
        if ($this->isColumnModified(ContactPeer::TYPE_ID)) $criteria->add(ContactPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(ContactPeer::NAME)) $criteria->add(ContactPeer::NAME, $this->name);
        if ($this->isColumnModified(ContactPeer::DESCRIPTION)) $criteria->add(ContactPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(ContactPeer::DATABASE_NAME);
        $criteria->add(ContactPeer::CONTACT_ID, $this->contact_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getContactId();
    }

    /**
     * Generic method to set the primary key (contact_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setContactId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getContactId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Contact (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getArraydesigns() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArraydesign($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssays() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssay($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContactRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContactRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContactRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContactRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectContacts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectContact($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantifications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getStudys() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addStudy($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setContactId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Contact Clone of current object.
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
     * @return ContactPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ContactPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Contact The current object (for fluent API support)
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
            $v->addContact($this);
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
                $this->aCvterm->addContacts($this);
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
        if ('Arraydesign' == $relationName) {
            $this->initArraydesigns();
        }
        if ('Assay' == $relationName) {
            $this->initAssays();
        }
        if ('Biomaterial' == $relationName) {
            $this->initBiomaterials();
        }
        if ('ContactRelationshipRelatedByObjectId' == $relationName) {
            $this->initContactRelationshipsRelatedByObjectId();
        }
        if ('ContactRelationshipRelatedBySubjectId' == $relationName) {
            $this->initContactRelationshipsRelatedBySubjectId();
        }
        if ('ProjectContact' == $relationName) {
            $this->initProjectContacts();
        }
        if ('Quantification' == $relationName) {
            $this->initQuantifications();
        }
        if ('Study' == $relationName) {
            $this->initStudys();
        }
    }

    /**
     * Clears out the collArraydesigns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addArraydesigns()
     */
    public function clearArraydesigns()
    {
        $this->collArraydesigns = null; // important to set this to null since that means it is uninitialized
        $this->collArraydesignsPartial = null;

        return $this;
    }

    /**
     * reset is the collArraydesigns collection loaded partially
     *
     * @return void
     */
    public function resetPartialArraydesigns($v = true)
    {
        $this->collArraydesignsPartial = $v;
    }

    /**
     * Initializes the collArraydesigns collection.
     *
     * By default this just sets the collArraydesigns collection to an empty array (like clearcollArraydesigns());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArraydesigns($overrideExisting = true)
    {
        if (null !== $this->collArraydesigns && !$overrideExisting) {
            return;
        }
        $this->collArraydesigns = new PropelObjectCollection();
        $this->collArraydesigns->setModel('Arraydesign');
    }

    /**
     * Gets an array of Arraydesign objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     * @throws PropelException
     */
    public function getArraydesigns($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsPartial && !$this->isNew();
        if (null === $this->collArraydesigns || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArraydesigns) {
                // return empty collection
                $this->initArraydesigns();
            } else {
                $collArraydesigns = ArraydesignQuery::create(null, $criteria)
                    ->filterByContact($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collArraydesignsPartial && count($collArraydesigns)) {
                      $this->initArraydesigns(false);

                      foreach($collArraydesigns as $obj) {
                        if (false == $this->collArraydesigns->contains($obj)) {
                          $this->collArraydesigns->append($obj);
                        }
                      }

                      $this->collArraydesignsPartial = true;
                    }

                    $collArraydesigns->getInternalIterator()->rewind();
                    return $collArraydesigns;
                }

                if($partial && $this->collArraydesigns) {
                    foreach($this->collArraydesigns as $obj) {
                        if($obj->isNew()) {
                            $collArraydesigns[] = $obj;
                        }
                    }
                }

                $this->collArraydesigns = $collArraydesigns;
                $this->collArraydesignsPartial = false;
            }
        }

        return $this->collArraydesigns;
    }

    /**
     * Sets a collection of Arraydesign objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $arraydesigns A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setArraydesigns(PropelCollection $arraydesigns, PropelPDO $con = null)
    {
        $arraydesignsToDelete = $this->getArraydesigns(new Criteria(), $con)->diff($arraydesigns);

        $this->arraydesignsScheduledForDeletion = unserialize(serialize($arraydesignsToDelete));

        foreach ($arraydesignsToDelete as $arraydesignRemoved) {
            $arraydesignRemoved->setContact(null);
        }

        $this->collArraydesigns = null;
        foreach ($arraydesigns as $arraydesign) {
            $this->addArraydesign($arraydesign);
        }

        $this->collArraydesigns = $arraydesigns;
        $this->collArraydesignsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arraydesign objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Arraydesign objects.
     * @throws PropelException
     */
    public function countArraydesigns(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignsPartial && !$this->isNew();
        if (null === $this->collArraydesigns || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArraydesigns) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getArraydesigns());
            }
            $query = ArraydesignQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collArraydesigns);
    }

    /**
     * Method called to associate a Arraydesign object to this object
     * through the Arraydesign foreign key attribute.
     *
     * @param    Arraydesign $l Arraydesign
     * @return Contact The current object (for fluent API support)
     */
    public function addArraydesign(Arraydesign $l)
    {
        if ($this->collArraydesigns === null) {
            $this->initArraydesigns();
            $this->collArraydesignsPartial = true;
        }
        if (!in_array($l, $this->collArraydesigns->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddArraydesign($l);
        }

        return $this;
    }

    /**
     * @param	Arraydesign $arraydesign The arraydesign object to add.
     */
    protected function doAddArraydesign($arraydesign)
    {
        $this->collArraydesigns[]= $arraydesign;
        $arraydesign->setContact($this);
    }

    /**
     * @param	Arraydesign $arraydesign The arraydesign object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeArraydesign($arraydesign)
    {
        if ($this->getArraydesigns()->contains($arraydesign)) {
            $this->collArraydesigns->remove($this->collArraydesigns->search($arraydesign));
            if (null === $this->arraydesignsScheduledForDeletion) {
                $this->arraydesignsScheduledForDeletion = clone $this->collArraydesigns;
                $this->arraydesignsScheduledForDeletion->clear();
            }
            $this->arraydesignsScheduledForDeletion[]= clone $arraydesign;
            $arraydesign->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getArraydesigns($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsJoinCvtermRelatedByPlatformtypeId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedByPlatformtypeId', $join_behavior);

        return $this->getArraydesigns($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getArraydesigns($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsJoinCvtermRelatedBySubstratetypeId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedBySubstratetypeId', $join_behavior);

        return $this->getArraydesigns($query, $con);
    }

    /**
     * Clears out the collAssays collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addAssays()
     */
    public function clearAssays()
    {
        $this->collAssays = null; // important to set this to null since that means it is uninitialized
        $this->collAssaysPartial = null;

        return $this;
    }

    /**
     * reset is the collAssays collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssays($v = true)
    {
        $this->collAssaysPartial = $v;
    }

    /**
     * Initializes the collAssays collection.
     *
     * By default this just sets the collAssays collection to an empty array (like clearcollAssays());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssays($overrideExisting = true)
    {
        if (null !== $this->collAssays && !$overrideExisting) {
            return;
        }
        $this->collAssays = new PropelObjectCollection();
        $this->collAssays->setModel('Assay');
    }

    /**
     * Gets an array of Assay objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Assay[] List of Assay objects
     * @throws PropelException
     */
    public function getAssays($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssaysPartial && !$this->isNew();
        if (null === $this->collAssays || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssays) {
                // return empty collection
                $this->initAssays();
            } else {
                $collAssays = AssayQuery::create(null, $criteria)
                    ->filterByContact($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssaysPartial && count($collAssays)) {
                      $this->initAssays(false);

                      foreach($collAssays as $obj) {
                        if (false == $this->collAssays->contains($obj)) {
                          $this->collAssays->append($obj);
                        }
                      }

                      $this->collAssaysPartial = true;
                    }

                    $collAssays->getInternalIterator()->rewind();
                    return $collAssays;
                }

                if($partial && $this->collAssays) {
                    foreach($this->collAssays as $obj) {
                        if($obj->isNew()) {
                            $collAssays[] = $obj;
                        }
                    }
                }

                $this->collAssays = $collAssays;
                $this->collAssaysPartial = false;
            }
        }

        return $this->collAssays;
    }

    /**
     * Sets a collection of Assay objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assays A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setAssays(PropelCollection $assays, PropelPDO $con = null)
    {
        $assaysToDelete = $this->getAssays(new Criteria(), $con)->diff($assays);

        $this->assaysScheduledForDeletion = unserialize(serialize($assaysToDelete));

        foreach ($assaysToDelete as $assayRemoved) {
            $assayRemoved->setContact(null);
        }

        $this->collAssays = null;
        foreach ($assays as $assay) {
            $this->addAssay($assay);
        }

        $this->collAssays = $assays;
        $this->collAssaysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Assay objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Assay objects.
     * @throws PropelException
     */
    public function countAssays(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssaysPartial && !$this->isNew();
        if (null === $this->collAssays || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssays) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAssays());
            }
            $query = AssayQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collAssays);
    }

    /**
     * Method called to associate a Assay object to this object
     * through the Assay foreign key attribute.
     *
     * @param    Assay $l Assay
     * @return Contact The current object (for fluent API support)
     */
    public function addAssay(Assay $l)
    {
        if ($this->collAssays === null) {
            $this->initAssays();
            $this->collAssaysPartial = true;
        }
        if (!in_array($l, $this->collAssays->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssay($l);
        }

        return $this;
    }

    /**
     * @param	Assay $assay The assay object to add.
     */
    protected function doAddAssay($assay)
    {
        $this->collAssays[]= $assay;
        $assay->setContact($this);
    }

    /**
     * @param	Assay $assay The assay object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeAssay($assay)
    {
        if ($this->getAssays()->contains($assay)) {
            $this->collAssays->remove($this->collAssays->search($assay));
            if (null === $this->assaysScheduledForDeletion) {
                $this->assaysScheduledForDeletion = clone $this->collAssays;
                $this->assaysScheduledForDeletion->clear();
            }
            $this->assaysScheduledForDeletion[]= clone $assay;
            $assay->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Assay[] List of Assay objects
     */
    public function getAssaysJoinArraydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayQuery::create(null, $criteria);
        $query->joinWith('Arraydesign', $join_behavior);

        return $this->getAssays($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Assay[] List of Assay objects
     */
    public function getAssaysJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getAssays($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Assay[] List of Assay objects
     */
    public function getAssaysJoinProtocol($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayQuery::create(null, $criteria);
        $query->joinWith('Protocol', $join_behavior);

        return $this->getAssays($query, $con);
    }

    /**
     * Clears out the collBiomaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addBiomaterials()
     */
    public function clearBiomaterials()
    {
        $this->collBiomaterials = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterials collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterials($v = true)
    {
        $this->collBiomaterialsPartial = $v;
    }

    /**
     * Initializes the collBiomaterials collection.
     *
     * By default this just sets the collBiomaterials collection to an empty array (like clearcollBiomaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterials($overrideExisting = true)
    {
        if (null !== $this->collBiomaterials && !$overrideExisting) {
            return;
        }
        $this->collBiomaterials = new PropelObjectCollection();
        $this->collBiomaterials->setModel('Biomaterial');
    }

    /**
     * Gets an array of Biomaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Biomaterial[] List of Biomaterial objects
     * @throws PropelException
     */
    public function getBiomaterials($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialsPartial && !$this->isNew();
        if (null === $this->collBiomaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterials) {
                // return empty collection
                $this->initBiomaterials();
            } else {
                $collBiomaterials = BiomaterialQuery::create(null, $criteria)
                    ->filterByContact($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialsPartial && count($collBiomaterials)) {
                      $this->initBiomaterials(false);

                      foreach($collBiomaterials as $obj) {
                        if (false == $this->collBiomaterials->contains($obj)) {
                          $this->collBiomaterials->append($obj);
                        }
                      }

                      $this->collBiomaterialsPartial = true;
                    }

                    $collBiomaterials->getInternalIterator()->rewind();
                    return $collBiomaterials;
                }

                if($partial && $this->collBiomaterials) {
                    foreach($this->collBiomaterials as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterials[] = $obj;
                        }
                    }
                }

                $this->collBiomaterials = $collBiomaterials;
                $this->collBiomaterialsPartial = false;
            }
        }

        return $this->collBiomaterials;
    }

    /**
     * Sets a collection of Biomaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterials A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setBiomaterials(PropelCollection $biomaterials, PropelPDO $con = null)
    {
        $biomaterialsToDelete = $this->getBiomaterials(new Criteria(), $con)->diff($biomaterials);

        $this->biomaterialsScheduledForDeletion = unserialize(serialize($biomaterialsToDelete));

        foreach ($biomaterialsToDelete as $biomaterialRemoved) {
            $biomaterialRemoved->setContact(null);
        }

        $this->collBiomaterials = null;
        foreach ($biomaterials as $biomaterial) {
            $this->addBiomaterial($biomaterial);
        }

        $this->collBiomaterials = $biomaterials;
        $this->collBiomaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Biomaterial objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Biomaterial objects.
     * @throws PropelException
     */
    public function countBiomaterials(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialsPartial && !$this->isNew();
        if (null === $this->collBiomaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterials) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterials());
            }
            $query = BiomaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collBiomaterials);
    }

    /**
     * Method called to associate a Biomaterial object to this object
     * through the Biomaterial foreign key attribute.
     *
     * @param    Biomaterial $l Biomaterial
     * @return Contact The current object (for fluent API support)
     */
    public function addBiomaterial(Biomaterial $l)
    {
        if ($this->collBiomaterials === null) {
            $this->initBiomaterials();
            $this->collBiomaterialsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterials->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterial($l);
        }

        return $this;
    }

    /**
     * @param	Biomaterial $biomaterial The biomaterial object to add.
     */
    protected function doAddBiomaterial($biomaterial)
    {
        $this->collBiomaterials[]= $biomaterial;
        $biomaterial->setContact($this);
    }

    /**
     * @param	Biomaterial $biomaterial The biomaterial object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeBiomaterial($biomaterial)
    {
        if ($this->getBiomaterials()->contains($biomaterial)) {
            $this->collBiomaterials->remove($this->collBiomaterials->search($biomaterial));
            if (null === $this->biomaterialsScheduledForDeletion) {
                $this->biomaterialsScheduledForDeletion = clone $this->collBiomaterials;
                $this->biomaterialsScheduledForDeletion->clear();
            }
            $this->biomaterialsScheduledForDeletion[]= $biomaterial;
            $biomaterial->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Biomaterial[] List of Biomaterial objects
     */
    public function getBiomaterialsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getBiomaterials($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Biomaterial[] List of Biomaterial objects
     */
    public function getBiomaterialsJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getBiomaterials($query, $con);
    }

    /**
     * Clears out the collContactRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addContactRelationshipsRelatedByObjectId()
     */
    public function clearContactRelationshipsRelatedByObjectId()
    {
        $this->collContactRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collContactRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collContactRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialContactRelationshipsRelatedByObjectId($v = true)
    {
        $this->collContactRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collContactRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collContactRelationshipsRelatedByObjectId collection to an empty array (like clearcollContactRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContactRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collContactRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collContactRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collContactRelationshipsRelatedByObjectId->setModel('ContactRelationship');
    }

    /**
     * Gets an array of ContactRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     * @throws PropelException
     */
    public function getContactRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collContactRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContactRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initContactRelationshipsRelatedByObjectId();
            } else {
                $collContactRelationshipsRelatedByObjectId = ContactRelationshipQuery::create(null, $criteria)
                    ->filterByContactRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContactRelationshipsRelatedByObjectIdPartial && count($collContactRelationshipsRelatedByObjectId)) {
                      $this->initContactRelationshipsRelatedByObjectId(false);

                      foreach($collContactRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collContactRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collContactRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collContactRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collContactRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collContactRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collContactRelationshipsRelatedByObjectId) {
                    foreach($this->collContactRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collContactRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collContactRelationshipsRelatedByObjectId = $collContactRelationshipsRelatedByObjectId;
                $this->collContactRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collContactRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of ContactRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contactRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setContactRelationshipsRelatedByObjectId(PropelCollection $contactRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $contactRelationshipsRelatedByObjectIdToDelete = $this->getContactRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($contactRelationshipsRelatedByObjectId);

        $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($contactRelationshipsRelatedByObjectIdToDelete));

        foreach ($contactRelationshipsRelatedByObjectIdToDelete as $contactRelationshipRelatedByObjectIdRemoved) {
            $contactRelationshipRelatedByObjectIdRemoved->setContactRelatedByObjectId(null);
        }

        $this->collContactRelationshipsRelatedByObjectId = null;
        foreach ($contactRelationshipsRelatedByObjectId as $contactRelationshipRelatedByObjectId) {
            $this->addContactRelationshipRelatedByObjectId($contactRelationshipRelatedByObjectId);
        }

        $this->collContactRelationshipsRelatedByObjectId = $contactRelationshipsRelatedByObjectId;
        $this->collContactRelationshipsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContactRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContactRelationship objects.
     * @throws PropelException
     */
    public function countContactRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collContactRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContactRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContactRelationshipsRelatedByObjectId());
            }
            $query = ContactRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContactRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collContactRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a ContactRelationship object to this object
     * through the ContactRelationship foreign key attribute.
     *
     * @param    ContactRelationship $l ContactRelationship
     * @return Contact The current object (for fluent API support)
     */
    public function addContactRelationshipRelatedByObjectId(ContactRelationship $l)
    {
        if ($this->collContactRelationshipsRelatedByObjectId === null) {
            $this->initContactRelationshipsRelatedByObjectId();
            $this->collContactRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collContactRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContactRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	ContactRelationshipRelatedByObjectId $contactRelationshipRelatedByObjectId The contactRelationshipRelatedByObjectId object to add.
     */
    protected function doAddContactRelationshipRelatedByObjectId($contactRelationshipRelatedByObjectId)
    {
        $this->collContactRelationshipsRelatedByObjectId[]= $contactRelationshipRelatedByObjectId;
        $contactRelationshipRelatedByObjectId->setContactRelatedByObjectId($this);
    }

    /**
     * @param	ContactRelationshipRelatedByObjectId $contactRelationshipRelatedByObjectId The contactRelationshipRelatedByObjectId object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeContactRelationshipRelatedByObjectId($contactRelationshipRelatedByObjectId)
    {
        if ($this->getContactRelationshipsRelatedByObjectId()->contains($contactRelationshipRelatedByObjectId)) {
            $this->collContactRelationshipsRelatedByObjectId->remove($this->collContactRelationshipsRelatedByObjectId->search($contactRelationshipRelatedByObjectId));
            if (null === $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collContactRelationshipsRelatedByObjectId;
                $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->contactRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $contactRelationshipRelatedByObjectId;
            $contactRelationshipRelatedByObjectId->setContactRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related ContactRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     */
    public function getContactRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContactRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getContactRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collContactRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addContactRelationshipsRelatedBySubjectId()
     */
    public function clearContactRelationshipsRelatedBySubjectId()
    {
        $this->collContactRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collContactRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collContactRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialContactRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collContactRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collContactRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collContactRelationshipsRelatedBySubjectId collection to an empty array (like clearcollContactRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContactRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collContactRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collContactRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collContactRelationshipsRelatedBySubjectId->setModel('ContactRelationship');
    }

    /**
     * Gets an array of ContactRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     * @throws PropelException
     */
    public function getContactRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collContactRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContactRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initContactRelationshipsRelatedBySubjectId();
            } else {
                $collContactRelationshipsRelatedBySubjectId = ContactRelationshipQuery::create(null, $criteria)
                    ->filterByContactRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContactRelationshipsRelatedBySubjectIdPartial && count($collContactRelationshipsRelatedBySubjectId)) {
                      $this->initContactRelationshipsRelatedBySubjectId(false);

                      foreach($collContactRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collContactRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collContactRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collContactRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collContactRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collContactRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collContactRelationshipsRelatedBySubjectId) {
                    foreach($this->collContactRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collContactRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collContactRelationshipsRelatedBySubjectId = $collContactRelationshipsRelatedBySubjectId;
                $this->collContactRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collContactRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of ContactRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contactRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setContactRelationshipsRelatedBySubjectId(PropelCollection $contactRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $contactRelationshipsRelatedBySubjectIdToDelete = $this->getContactRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($contactRelationshipsRelatedBySubjectId);

        $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($contactRelationshipsRelatedBySubjectIdToDelete));

        foreach ($contactRelationshipsRelatedBySubjectIdToDelete as $contactRelationshipRelatedBySubjectIdRemoved) {
            $contactRelationshipRelatedBySubjectIdRemoved->setContactRelatedBySubjectId(null);
        }

        $this->collContactRelationshipsRelatedBySubjectId = null;
        foreach ($contactRelationshipsRelatedBySubjectId as $contactRelationshipRelatedBySubjectId) {
            $this->addContactRelationshipRelatedBySubjectId($contactRelationshipRelatedBySubjectId);
        }

        $this->collContactRelationshipsRelatedBySubjectId = $contactRelationshipsRelatedBySubjectId;
        $this->collContactRelationshipsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ContactRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ContactRelationship objects.
     * @throws PropelException
     */
    public function countContactRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContactRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collContactRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContactRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContactRelationshipsRelatedBySubjectId());
            }
            $query = ContactRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContactRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collContactRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a ContactRelationship object to this object
     * through the ContactRelationship foreign key attribute.
     *
     * @param    ContactRelationship $l ContactRelationship
     * @return Contact The current object (for fluent API support)
     */
    public function addContactRelationshipRelatedBySubjectId(ContactRelationship $l)
    {
        if ($this->collContactRelationshipsRelatedBySubjectId === null) {
            $this->initContactRelationshipsRelatedBySubjectId();
            $this->collContactRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collContactRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContactRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	ContactRelationshipRelatedBySubjectId $contactRelationshipRelatedBySubjectId The contactRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddContactRelationshipRelatedBySubjectId($contactRelationshipRelatedBySubjectId)
    {
        $this->collContactRelationshipsRelatedBySubjectId[]= $contactRelationshipRelatedBySubjectId;
        $contactRelationshipRelatedBySubjectId->setContactRelatedBySubjectId($this);
    }

    /**
     * @param	ContactRelationshipRelatedBySubjectId $contactRelationshipRelatedBySubjectId The contactRelationshipRelatedBySubjectId object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeContactRelationshipRelatedBySubjectId($contactRelationshipRelatedBySubjectId)
    {
        if ($this->getContactRelationshipsRelatedBySubjectId()->contains($contactRelationshipRelatedBySubjectId)) {
            $this->collContactRelationshipsRelatedBySubjectId->remove($this->collContactRelationshipsRelatedBySubjectId->search($contactRelationshipRelatedBySubjectId));
            if (null === $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collContactRelationshipsRelatedBySubjectId;
                $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->contactRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $contactRelationshipRelatedBySubjectId;
            $contactRelationshipRelatedBySubjectId->setContactRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related ContactRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ContactRelationship[] List of ContactRelationship objects
     */
    public function getContactRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ContactRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getContactRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collProjectContacts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addProjectContacts()
     */
    public function clearProjectContacts()
    {
        $this->collProjectContacts = null; // important to set this to null since that means it is uninitialized
        $this->collProjectContactsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectContacts collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectContacts($v = true)
    {
        $this->collProjectContactsPartial = $v;
    }

    /**
     * Initializes the collProjectContacts collection.
     *
     * By default this just sets the collProjectContacts collection to an empty array (like clearcollProjectContacts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectContacts($overrideExisting = true)
    {
        if (null !== $this->collProjectContacts && !$overrideExisting) {
            return;
        }
        $this->collProjectContacts = new PropelObjectCollection();
        $this->collProjectContacts->setModel('ProjectContact');
    }

    /**
     * Gets an array of ProjectContact objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectContact[] List of ProjectContact objects
     * @throws PropelException
     */
    public function getProjectContacts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectContactsPartial && !$this->isNew();
        if (null === $this->collProjectContacts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectContacts) {
                // return empty collection
                $this->initProjectContacts();
            } else {
                $collProjectContacts = ProjectContactQuery::create(null, $criteria)
                    ->filterByContact($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectContactsPartial && count($collProjectContacts)) {
                      $this->initProjectContacts(false);

                      foreach($collProjectContacts as $obj) {
                        if (false == $this->collProjectContacts->contains($obj)) {
                          $this->collProjectContacts->append($obj);
                        }
                      }

                      $this->collProjectContactsPartial = true;
                    }

                    $collProjectContacts->getInternalIterator()->rewind();
                    return $collProjectContacts;
                }

                if($partial && $this->collProjectContacts) {
                    foreach($this->collProjectContacts as $obj) {
                        if($obj->isNew()) {
                            $collProjectContacts[] = $obj;
                        }
                    }
                }

                $this->collProjectContacts = $collProjectContacts;
                $this->collProjectContactsPartial = false;
            }
        }

        return $this->collProjectContacts;
    }

    /**
     * Sets a collection of ProjectContact objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectContacts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setProjectContacts(PropelCollection $projectContacts, PropelPDO $con = null)
    {
        $projectContactsToDelete = $this->getProjectContacts(new Criteria(), $con)->diff($projectContacts);

        $this->projectContactsScheduledForDeletion = unserialize(serialize($projectContactsToDelete));

        foreach ($projectContactsToDelete as $projectContactRemoved) {
            $projectContactRemoved->setContact(null);
        }

        $this->collProjectContacts = null;
        foreach ($projectContacts as $projectContact) {
            $this->addProjectContact($projectContact);
        }

        $this->collProjectContacts = $projectContacts;
        $this->collProjectContactsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectContact objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectContact objects.
     * @throws PropelException
     */
    public function countProjectContacts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectContactsPartial && !$this->isNew();
        if (null === $this->collProjectContacts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectContacts) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectContacts());
            }
            $query = ProjectContactQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collProjectContacts);
    }

    /**
     * Method called to associate a ProjectContact object to this object
     * through the ProjectContact foreign key attribute.
     *
     * @param    ProjectContact $l ProjectContact
     * @return Contact The current object (for fluent API support)
     */
    public function addProjectContact(ProjectContact $l)
    {
        if ($this->collProjectContacts === null) {
            $this->initProjectContacts();
            $this->collProjectContactsPartial = true;
        }
        if (!in_array($l, $this->collProjectContacts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectContact($l);
        }

        return $this;
    }

    /**
     * @param	ProjectContact $projectContact The projectContact object to add.
     */
    protected function doAddProjectContact($projectContact)
    {
        $this->collProjectContacts[]= $projectContact;
        $projectContact->setContact($this);
    }

    /**
     * @param	ProjectContact $projectContact The projectContact object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeProjectContact($projectContact)
    {
        if ($this->getProjectContacts()->contains($projectContact)) {
            $this->collProjectContacts->remove($this->collProjectContacts->search($projectContact));
            if (null === $this->projectContactsScheduledForDeletion) {
                $this->projectContactsScheduledForDeletion = clone $this->collProjectContacts;
                $this->projectContactsScheduledForDeletion->clear();
            }
            $this->projectContactsScheduledForDeletion[]= clone $projectContact;
            $projectContact->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related ProjectContacts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectContact[] List of ProjectContact objects
     */
    public function getProjectContactsJoinProject($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectContactQuery::create(null, $criteria);
        $query->joinWith('Project', $join_behavior);

        return $this->getProjectContacts($query, $con);
    }

    /**
     * Clears out the collQuantifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
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
     * If this Contact is new, it will return
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
                    ->filterByContact($this)
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
     * @return Contact The current object (for fluent API support)
     */
    public function setQuantifications(PropelCollection $quantifications, PropelPDO $con = null)
    {
        $quantificationsToDelete = $this->getQuantifications(new Criteria(), $con)->diff($quantifications);

        $this->quantificationsScheduledForDeletion = unserialize(serialize($quantificationsToDelete));

        foreach ($quantificationsToDelete as $quantificationRemoved) {
            $quantificationRemoved->setContact(null);
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
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collQuantifications);
    }

    /**
     * Method called to associate a Quantification object to this object
     * through the Quantification foreign key attribute.
     *
     * @param    Quantification $l Quantification
     * @return Contact The current object (for fluent API support)
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
        $quantification->setContact($this);
    }

    /**
     * @param	Quantification $quantification The quantification object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeQuantification($quantification)
    {
        if ($this->getQuantifications()->contains($quantification)) {
            $this->collQuantifications->remove($this->collQuantifications->search($quantification));
            if (null === $this->quantificationsScheduledForDeletion) {
                $this->quantificationsScheduledForDeletion = clone $this->collQuantifications;
                $this->quantificationsScheduledForDeletion->clear();
            }
            $this->quantificationsScheduledForDeletion[]= $quantification;
            $quantification->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
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
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinAnalysis($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Analysis', $join_behavior);

        return $this->getQuantifications($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
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
     * Clears out the collStudys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Contact The current object (for fluent API support)
     * @see        addStudys()
     */
    public function clearStudys()
    {
        $this->collStudys = null; // important to set this to null since that means it is uninitialized
        $this->collStudysPartial = null;

        return $this;
    }

    /**
     * reset is the collStudys collection loaded partially
     *
     * @return void
     */
    public function resetPartialStudys($v = true)
    {
        $this->collStudysPartial = $v;
    }

    /**
     * Initializes the collStudys collection.
     *
     * By default this just sets the collStudys collection to an empty array (like clearcollStudys());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initStudys($overrideExisting = true)
    {
        if (null !== $this->collStudys && !$overrideExisting) {
            return;
        }
        $this->collStudys = new PropelObjectCollection();
        $this->collStudys->setModel('Study');
    }

    /**
     * Gets an array of Study objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Contact is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Study[] List of Study objects
     * @throws PropelException
     */
    public function getStudys($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collStudysPartial && !$this->isNew();
        if (null === $this->collStudys || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collStudys) {
                // return empty collection
                $this->initStudys();
            } else {
                $collStudys = StudyQuery::create(null, $criteria)
                    ->filterByContact($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collStudysPartial && count($collStudys)) {
                      $this->initStudys(false);

                      foreach($collStudys as $obj) {
                        if (false == $this->collStudys->contains($obj)) {
                          $this->collStudys->append($obj);
                        }
                      }

                      $this->collStudysPartial = true;
                    }

                    $collStudys->getInternalIterator()->rewind();
                    return $collStudys;
                }

                if($partial && $this->collStudys) {
                    foreach($this->collStudys as $obj) {
                        if($obj->isNew()) {
                            $collStudys[] = $obj;
                        }
                    }
                }

                $this->collStudys = $collStudys;
                $this->collStudysPartial = false;
            }
        }

        return $this->collStudys;
    }

    /**
     * Sets a collection of Study objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $studys A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Contact The current object (for fluent API support)
     */
    public function setStudys(PropelCollection $studys, PropelPDO $con = null)
    {
        $studysToDelete = $this->getStudys(new Criteria(), $con)->diff($studys);

        $this->studysScheduledForDeletion = unserialize(serialize($studysToDelete));

        foreach ($studysToDelete as $studyRemoved) {
            $studyRemoved->setContact(null);
        }

        $this->collStudys = null;
        foreach ($studys as $study) {
            $this->addStudy($study);
        }

        $this->collStudys = $studys;
        $this->collStudysPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Study objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Study objects.
     * @throws PropelException
     */
    public function countStudys(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collStudysPartial && !$this->isNew();
        if (null === $this->collStudys || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collStudys) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getStudys());
            }
            $query = StudyQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByContact($this)
                ->count($con);
        }

        return count($this->collStudys);
    }

    /**
     * Method called to associate a Study object to this object
     * through the Study foreign key attribute.
     *
     * @param    Study $l Study
     * @return Contact The current object (for fluent API support)
     */
    public function addStudy(Study $l)
    {
        if ($this->collStudys === null) {
            $this->initStudys();
            $this->collStudysPartial = true;
        }
        if (!in_array($l, $this->collStudys->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddStudy($l);
        }

        return $this;
    }

    /**
     * @param	Study $study The study object to add.
     */
    protected function doAddStudy($study)
    {
        $this->collStudys[]= $study;
        $study->setContact($this);
    }

    /**
     * @param	Study $study The study object to remove.
     * @return Contact The current object (for fluent API support)
     */
    public function removeStudy($study)
    {
        if ($this->getStudys()->contains($study)) {
            $this->collStudys->remove($this->collStudys->search($study));
            if (null === $this->studysScheduledForDeletion) {
                $this->studysScheduledForDeletion = clone $this->collStudys;
                $this->studysScheduledForDeletion->clear();
            }
            $this->studysScheduledForDeletion[]= clone $study;
            $study->setContact(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Studys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Study[] List of Study objects
     */
    public function getStudysJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getStudys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Contact is new, it will return
     * an empty collection; or if this Contact has previously
     * been saved, it will retrieve related Studys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Contact.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Study[] List of Study objects
     */
    public function getStudysJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getStudys($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->contact_id = null;
        $this->type_id = null;
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
            if ($this->collArraydesigns) {
                foreach ($this->collArraydesigns as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssays) {
                foreach ($this->collAssays as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterials) {
                foreach ($this->collBiomaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContactRelationshipsRelatedByObjectId) {
                foreach ($this->collContactRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContactRelationshipsRelatedBySubjectId) {
                foreach ($this->collContactRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectContacts) {
                foreach ($this->collProjectContacts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantifications) {
                foreach ($this->collQuantifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudys) {
                foreach ($this->collStudys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collArraydesigns instanceof PropelCollection) {
            $this->collArraydesigns->clearIterator();
        }
        $this->collArraydesigns = null;
        if ($this->collAssays instanceof PropelCollection) {
            $this->collAssays->clearIterator();
        }
        $this->collAssays = null;
        if ($this->collBiomaterials instanceof PropelCollection) {
            $this->collBiomaterials->clearIterator();
        }
        $this->collBiomaterials = null;
        if ($this->collContactRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collContactRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collContactRelationshipsRelatedByObjectId = null;
        if ($this->collContactRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collContactRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collContactRelationshipsRelatedBySubjectId = null;
        if ($this->collProjectContacts instanceof PropelCollection) {
            $this->collProjectContacts->clearIterator();
        }
        $this->collProjectContacts = null;
        if ($this->collQuantifications instanceof PropelCollection) {
            $this->collQuantifications->clearIterator();
        }
        $this->collQuantifications = null;
        if ($this->collStudys instanceof PropelCollection) {
            $this->collStudys->clearIterator();
        }
        $this->collStudys = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ContactPeer::DEFAULT_STRING_FORMAT);
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
