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
use cli_db\propel\AssayProject;
use cli_db\propel\AssayProjectQuery;
use cli_db\propel\Project;
use cli_db\propel\ProjectContact;
use cli_db\propel\ProjectContactQuery;
use cli_db\propel\ProjectPeer;
use cli_db\propel\ProjectPub;
use cli_db\propel\ProjectPubQuery;
use cli_db\propel\ProjectQuery;
use cli_db\propel\ProjectRelationship;
use cli_db\propel\ProjectRelationshipQuery;
use cli_db\propel\Projectprop;
use cli_db\propel\ProjectpropQuery;

/**
 * Base class that represents a row from the 'project' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProject extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ProjectPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProjectPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the project_id field.
     * @var        int
     */
    protected $project_id;

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
     * @var        PropelObjectCollection|AssayProject[] Collection to store aggregation of AssayProject objects.
     */
    protected $collAssayProjects;
    protected $collAssayProjectsPartial;

    /**
     * @var        PropelObjectCollection|ProjectContact[] Collection to store aggregation of ProjectContact objects.
     */
    protected $collProjectContacts;
    protected $collProjectContactsPartial;

    /**
     * @var        PropelObjectCollection|ProjectPub[] Collection to store aggregation of ProjectPub objects.
     */
    protected $collProjectPubs;
    protected $collProjectPubsPartial;

    /**
     * @var        PropelObjectCollection|ProjectRelationship[] Collection to store aggregation of ProjectRelationship objects.
     */
    protected $collProjectRelationshipsRelatedByObjectProjectId;
    protected $collProjectRelationshipsRelatedByObjectProjectIdPartial;

    /**
     * @var        PropelObjectCollection|ProjectRelationship[] Collection to store aggregation of ProjectRelationship objects.
     */
    protected $collProjectRelationshipsRelatedBySubjectProjectId;
    protected $collProjectRelationshipsRelatedBySubjectProjectIdPartial;

    /**
     * @var        PropelObjectCollection|Projectprop[] Collection to store aggregation of Projectprop objects.
     */
    protected $collProjectprops;
    protected $collProjectpropsPartial;

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
    protected $assayProjectsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectContactsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectPubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $projectpropsScheduledForDeletion = null;

    /**
     * Get the [project_id] column value.
     *
     * @return int
     */
    public function getProjectId()
    {
        return $this->project_id;
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
     * Set the value of [project_id] column.
     *
     * @param int $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setProjectId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->project_id !== $v) {
            $this->project_id = $v;
            $this->modifiedColumns[] = ProjectPeer::PROJECT_ID;
        }


        return $this;
    } // setProjectId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProjectPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Project The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ProjectPeer::DESCRIPTION;
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

            $this->project_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->name = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->description = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 3; // 3 = ProjectPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Project object", $e);
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProjectPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collAssayProjects = null;

            $this->collProjectContacts = null;

            $this->collProjectPubs = null;

            $this->collProjectRelationshipsRelatedByObjectProjectId = null;

            $this->collProjectRelationshipsRelatedBySubjectProjectId = null;

            $this->collProjectprops = null;

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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProjectQuery::create()
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
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProjectPeer::addInstanceToPool($this);
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

            if ($this->assayProjectsScheduledForDeletion !== null) {
                if (!$this->assayProjectsScheduledForDeletion->isEmpty()) {
                    AssayProjectQuery::create()
                        ->filterByPrimaryKeys($this->assayProjectsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assayProjectsScheduledForDeletion = null;
                }
            }

            if ($this->collAssayProjects !== null) {
                foreach ($this->collAssayProjects as $referrerFK) {
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

            if ($this->projectPubsScheduledForDeletion !== null) {
                if (!$this->projectPubsScheduledForDeletion->isEmpty()) {
                    ProjectPubQuery::create()
                        ->filterByPrimaryKeys($this->projectPubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectPubsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectPubs !== null) {
                foreach ($this->collProjectPubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion !== null) {
                if (!$this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion->isEmpty()) {
                    ProjectRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collProjectRelationshipsRelatedByObjectProjectId !== null) {
                foreach ($this->collProjectRelationshipsRelatedByObjectProjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion !== null) {
                if (!$this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion->isEmpty()) {
                    ProjectRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collProjectRelationshipsRelatedBySubjectProjectId !== null) {
                foreach ($this->collProjectRelationshipsRelatedBySubjectProjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->projectpropsScheduledForDeletion !== null) {
                if (!$this->projectpropsScheduledForDeletion->isEmpty()) {
                    ProjectpropQuery::create()
                        ->filterByPrimaryKeys($this->projectpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->projectpropsScheduledForDeletion = null;
                }
            }

            if ($this->collProjectprops !== null) {
                foreach ($this->collProjectprops as $referrerFK) {
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

        $this->modifiedColumns[] = ProjectPeer::PROJECT_ID;
        if (null !== $this->project_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProjectPeer::PROJECT_ID . ')');
        }
        if (null === $this->project_id) {
            try {
                $stmt = $con->query("SELECT nextval('project_project_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->project_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProjectPeer::PROJECT_ID)) {
            $modifiedColumns[':p' . $index++]  = '"project_id"';
        }
        if ($this->isColumnModified(ProjectPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ProjectPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "project" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"project_id"':
                        $stmt->bindValue($identifier, $this->project_id, PDO::PARAM_INT);
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


            if (($retval = ProjectPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAssayProjects !== null) {
                    foreach ($this->collAssayProjects as $referrerFK) {
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

                if ($this->collProjectPubs !== null) {
                    foreach ($this->collProjectPubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectRelationshipsRelatedByObjectProjectId !== null) {
                    foreach ($this->collProjectRelationshipsRelatedByObjectProjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectRelationshipsRelatedBySubjectProjectId !== null) {
                    foreach ($this->collProjectRelationshipsRelatedBySubjectProjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collProjectprops !== null) {
                    foreach ($this->collProjectprops as $referrerFK) {
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getProjectId();
                break;
            case 1:
                return $this->getName();
                break;
            case 2:
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
        if (isset($alreadyDumpedObjects['Project'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Project'][$this->getPrimaryKey()] = true;
        $keys = ProjectPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getProjectId(),
            $keys[1] => $this->getName(),
            $keys[2] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collAssayProjects) {
                $result['AssayProjects'] = $this->collAssayProjects->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectContacts) {
                $result['ProjectContacts'] = $this->collProjectContacts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectPubs) {
                $result['ProjectPubs'] = $this->collProjectPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectRelationshipsRelatedByObjectProjectId) {
                $result['ProjectRelationshipsRelatedByObjectProjectId'] = $this->collProjectRelationshipsRelatedByObjectProjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectRelationshipsRelatedBySubjectProjectId) {
                $result['ProjectRelationshipsRelatedBySubjectProjectId'] = $this->collProjectRelationshipsRelatedBySubjectProjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProjectprops) {
                $result['Projectprops'] = $this->collProjectprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProjectPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setProjectId($value);
                break;
            case 1:
                $this->setName($value);
                break;
            case 2:
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
        $keys = ProjectPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setProjectId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setName($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setDescription($arr[$keys[2]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProjectPeer::PROJECT_ID)) $criteria->add(ProjectPeer::PROJECT_ID, $this->project_id);
        if ($this->isColumnModified(ProjectPeer::NAME)) $criteria->add(ProjectPeer::NAME, $this->name);
        if ($this->isColumnModified(ProjectPeer::DESCRIPTION)) $criteria->add(ProjectPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(ProjectPeer::DATABASE_NAME);
        $criteria->add(ProjectPeer::PROJECT_ID, $this->project_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getProjectId();
    }

    /**
     * Generic method to set the primary key (project_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setProjectId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getProjectId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Project (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAssayProjects() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssayProject($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectContacts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectContact($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectPub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectRelationshipsRelatedByObjectProjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectRelationshipRelatedByObjectProjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectRelationshipsRelatedBySubjectProjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectRelationshipRelatedBySubjectProjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProjectprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProjectprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setProjectId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Project Clone of current object.
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
     * @return ProjectPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProjectPeer();
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
        if ('AssayProject' == $relationName) {
            $this->initAssayProjects();
        }
        if ('ProjectContact' == $relationName) {
            $this->initProjectContacts();
        }
        if ('ProjectPub' == $relationName) {
            $this->initProjectPubs();
        }
        if ('ProjectRelationshipRelatedByObjectProjectId' == $relationName) {
            $this->initProjectRelationshipsRelatedByObjectProjectId();
        }
        if ('ProjectRelationshipRelatedBySubjectProjectId' == $relationName) {
            $this->initProjectRelationshipsRelatedBySubjectProjectId();
        }
        if ('Projectprop' == $relationName) {
            $this->initProjectprops();
        }
    }

    /**
     * Clears out the collAssayProjects collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addAssayProjects()
     */
    public function clearAssayProjects()
    {
        $this->collAssayProjects = null; // important to set this to null since that means it is uninitialized
        $this->collAssayProjectsPartial = null;

        return $this;
    }

    /**
     * reset is the collAssayProjects collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssayProjects($v = true)
    {
        $this->collAssayProjectsPartial = $v;
    }

    /**
     * Initializes the collAssayProjects collection.
     *
     * By default this just sets the collAssayProjects collection to an empty array (like clearcollAssayProjects());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssayProjects($overrideExisting = true)
    {
        if (null !== $this->collAssayProjects && !$overrideExisting) {
            return;
        }
        $this->collAssayProjects = new PropelObjectCollection();
        $this->collAssayProjects->setModel('AssayProject');
    }

    /**
     * Gets an array of AssayProject objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssayProject[] List of AssayProject objects
     * @throws PropelException
     */
    public function getAssayProjects($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssayProjectsPartial && !$this->isNew();
        if (null === $this->collAssayProjects || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssayProjects) {
                // return empty collection
                $this->initAssayProjects();
            } else {
                $collAssayProjects = AssayProjectQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssayProjectsPartial && count($collAssayProjects)) {
                      $this->initAssayProjects(false);

                      foreach($collAssayProjects as $obj) {
                        if (false == $this->collAssayProjects->contains($obj)) {
                          $this->collAssayProjects->append($obj);
                        }
                      }

                      $this->collAssayProjectsPartial = true;
                    }

                    $collAssayProjects->getInternalIterator()->rewind();
                    return $collAssayProjects;
                }

                if($partial && $this->collAssayProjects) {
                    foreach($this->collAssayProjects as $obj) {
                        if($obj->isNew()) {
                            $collAssayProjects[] = $obj;
                        }
                    }
                }

                $this->collAssayProjects = $collAssayProjects;
                $this->collAssayProjectsPartial = false;
            }
        }

        return $this->collAssayProjects;
    }

    /**
     * Sets a collection of AssayProject objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assayProjects A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setAssayProjects(PropelCollection $assayProjects, PropelPDO $con = null)
    {
        $assayProjectsToDelete = $this->getAssayProjects(new Criteria(), $con)->diff($assayProjects);

        $this->assayProjectsScheduledForDeletion = unserialize(serialize($assayProjectsToDelete));

        foreach ($assayProjectsToDelete as $assayProjectRemoved) {
            $assayProjectRemoved->setProject(null);
        }

        $this->collAssayProjects = null;
        foreach ($assayProjects as $assayProject) {
            $this->addAssayProject($assayProject);
        }

        $this->collAssayProjects = $assayProjects;
        $this->collAssayProjectsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssayProject objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AssayProject objects.
     * @throws PropelException
     */
    public function countAssayProjects(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssayProjectsPartial && !$this->isNew();
        if (null === $this->collAssayProjects || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssayProjects) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAssayProjects());
            }
            $query = AssayProjectQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collAssayProjects);
    }

    /**
     * Method called to associate a AssayProject object to this object
     * through the AssayProject foreign key attribute.
     *
     * @param    AssayProject $l AssayProject
     * @return Project The current object (for fluent API support)
     */
    public function addAssayProject(AssayProject $l)
    {
        if ($this->collAssayProjects === null) {
            $this->initAssayProjects();
            $this->collAssayProjectsPartial = true;
        }
        if (!in_array($l, $this->collAssayProjects->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssayProject($l);
        }

        return $this;
    }

    /**
     * @param	AssayProject $assayProject The assayProject object to add.
     */
    protected function doAddAssayProject($assayProject)
    {
        $this->collAssayProjects[]= $assayProject;
        $assayProject->setProject($this);
    }

    /**
     * @param	AssayProject $assayProject The assayProject object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeAssayProject($assayProject)
    {
        if ($this->getAssayProjects()->contains($assayProject)) {
            $this->collAssayProjects->remove($this->collAssayProjects->search($assayProject));
            if (null === $this->assayProjectsScheduledForDeletion) {
                $this->assayProjectsScheduledForDeletion = clone $this->collAssayProjects;
                $this->assayProjectsScheduledForDeletion->clear();
            }
            $this->assayProjectsScheduledForDeletion[]= clone $assayProject;
            $assayProject->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related AssayProjects from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssayProject[] List of AssayProject objects
     */
    public function getAssayProjectsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayProjectQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAssayProjects($query, $con);
    }

    /**
     * Clears out the collProjectContacts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
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
     * If this Project is new, it will return
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
                    ->filterByProject($this)
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
     * @return Project The current object (for fluent API support)
     */
    public function setProjectContacts(PropelCollection $projectContacts, PropelPDO $con = null)
    {
        $projectContactsToDelete = $this->getProjectContacts(new Criteria(), $con)->diff($projectContacts);

        $this->projectContactsScheduledForDeletion = unserialize(serialize($projectContactsToDelete));

        foreach ($projectContactsToDelete as $projectContactRemoved) {
            $projectContactRemoved->setProject(null);
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
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collProjectContacts);
    }

    /**
     * Method called to associate a ProjectContact object to this object
     * through the ProjectContact foreign key attribute.
     *
     * @param    ProjectContact $l ProjectContact
     * @return Project The current object (for fluent API support)
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
        $projectContact->setProject($this);
    }

    /**
     * @param	ProjectContact $projectContact The projectContact object to remove.
     * @return Project The current object (for fluent API support)
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
            $projectContact->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectContacts from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectContact[] List of ProjectContact objects
     */
    public function getProjectContactsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectContactQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getProjectContacts($query, $con);
    }

    /**
     * Clears out the collProjectPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addProjectPubs()
     */
    public function clearProjectPubs()
    {
        $this->collProjectPubs = null; // important to set this to null since that means it is uninitialized
        $this->collProjectPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectPubs($v = true)
    {
        $this->collProjectPubsPartial = $v;
    }

    /**
     * Initializes the collProjectPubs collection.
     *
     * By default this just sets the collProjectPubs collection to an empty array (like clearcollProjectPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectPubs($overrideExisting = true)
    {
        if (null !== $this->collProjectPubs && !$overrideExisting) {
            return;
        }
        $this->collProjectPubs = new PropelObjectCollection();
        $this->collProjectPubs->setModel('ProjectPub');
    }

    /**
     * Gets an array of ProjectPub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectPub[] List of ProjectPub objects
     * @throws PropelException
     */
    public function getProjectPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectPubsPartial && !$this->isNew();
        if (null === $this->collProjectPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectPubs) {
                // return empty collection
                $this->initProjectPubs();
            } else {
                $collProjectPubs = ProjectPubQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectPubsPartial && count($collProjectPubs)) {
                      $this->initProjectPubs(false);

                      foreach($collProjectPubs as $obj) {
                        if (false == $this->collProjectPubs->contains($obj)) {
                          $this->collProjectPubs->append($obj);
                        }
                      }

                      $this->collProjectPubsPartial = true;
                    }

                    $collProjectPubs->getInternalIterator()->rewind();
                    return $collProjectPubs;
                }

                if($partial && $this->collProjectPubs) {
                    foreach($this->collProjectPubs as $obj) {
                        if($obj->isNew()) {
                            $collProjectPubs[] = $obj;
                        }
                    }
                }

                $this->collProjectPubs = $collProjectPubs;
                $this->collProjectPubsPartial = false;
            }
        }

        return $this->collProjectPubs;
    }

    /**
     * Sets a collection of ProjectPub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectPubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setProjectPubs(PropelCollection $projectPubs, PropelPDO $con = null)
    {
        $projectPubsToDelete = $this->getProjectPubs(new Criteria(), $con)->diff($projectPubs);

        $this->projectPubsScheduledForDeletion = unserialize(serialize($projectPubsToDelete));

        foreach ($projectPubsToDelete as $projectPubRemoved) {
            $projectPubRemoved->setProject(null);
        }

        $this->collProjectPubs = null;
        foreach ($projectPubs as $projectPub) {
            $this->addProjectPub($projectPub);
        }

        $this->collProjectPubs = $projectPubs;
        $this->collProjectPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectPub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectPub objects.
     * @throws PropelException
     */
    public function countProjectPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectPubsPartial && !$this->isNew();
        if (null === $this->collProjectPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectPubs());
            }
            $query = ProjectPubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collProjectPubs);
    }

    /**
     * Method called to associate a ProjectPub object to this object
     * through the ProjectPub foreign key attribute.
     *
     * @param    ProjectPub $l ProjectPub
     * @return Project The current object (for fluent API support)
     */
    public function addProjectPub(ProjectPub $l)
    {
        if ($this->collProjectPubs === null) {
            $this->initProjectPubs();
            $this->collProjectPubsPartial = true;
        }
        if (!in_array($l, $this->collProjectPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectPub($l);
        }

        return $this;
    }

    /**
     * @param	ProjectPub $projectPub The projectPub object to add.
     */
    protected function doAddProjectPub($projectPub)
    {
        $this->collProjectPubs[]= $projectPub;
        $projectPub->setProject($this);
    }

    /**
     * @param	ProjectPub $projectPub The projectPub object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeProjectPub($projectPub)
    {
        if ($this->getProjectPubs()->contains($projectPub)) {
            $this->collProjectPubs->remove($this->collProjectPubs->search($projectPub));
            if (null === $this->projectPubsScheduledForDeletion) {
                $this->projectPubsScheduledForDeletion = clone $this->collProjectPubs;
                $this->projectPubsScheduledForDeletion->clear();
            }
            $this->projectPubsScheduledForDeletion[]= clone $projectPub;
            $projectPub->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectPubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectPub[] List of ProjectPub objects
     */
    public function getProjectPubsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectPubQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getProjectPubs($query, $con);
    }

    /**
     * Clears out the collProjectRelationshipsRelatedByObjectProjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addProjectRelationshipsRelatedByObjectProjectId()
     */
    public function clearProjectRelationshipsRelatedByObjectProjectId()
    {
        $this->collProjectRelationshipsRelatedByObjectProjectId = null; // important to set this to null since that means it is uninitialized
        $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectRelationshipsRelatedByObjectProjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectRelationshipsRelatedByObjectProjectId($v = true)
    {
        $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = $v;
    }

    /**
     * Initializes the collProjectRelationshipsRelatedByObjectProjectId collection.
     *
     * By default this just sets the collProjectRelationshipsRelatedByObjectProjectId collection to an empty array (like clearcollProjectRelationshipsRelatedByObjectProjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectRelationshipsRelatedByObjectProjectId($overrideExisting = true)
    {
        if (null !== $this->collProjectRelationshipsRelatedByObjectProjectId && !$overrideExisting) {
            return;
        }
        $this->collProjectRelationshipsRelatedByObjectProjectId = new PropelObjectCollection();
        $this->collProjectRelationshipsRelatedByObjectProjectId->setModel('ProjectRelationship');
    }

    /**
     * Gets an array of ProjectRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     * @throws PropelException
     */
    public function getProjectRelationshipsRelatedByObjectProjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsRelatedByObjectProjectIdPartial && !$this->isNew();
        if (null === $this->collProjectRelationshipsRelatedByObjectProjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationshipsRelatedByObjectProjectId) {
                // return empty collection
                $this->initProjectRelationshipsRelatedByObjectProjectId();
            } else {
                $collProjectRelationshipsRelatedByObjectProjectId = ProjectRelationshipQuery::create(null, $criteria)
                    ->filterByProjectRelatedByObjectProjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectRelationshipsRelatedByObjectProjectIdPartial && count($collProjectRelationshipsRelatedByObjectProjectId)) {
                      $this->initProjectRelationshipsRelatedByObjectProjectId(false);

                      foreach($collProjectRelationshipsRelatedByObjectProjectId as $obj) {
                        if (false == $this->collProjectRelationshipsRelatedByObjectProjectId->contains($obj)) {
                          $this->collProjectRelationshipsRelatedByObjectProjectId->append($obj);
                        }
                      }

                      $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = true;
                    }

                    $collProjectRelationshipsRelatedByObjectProjectId->getInternalIterator()->rewind();
                    return $collProjectRelationshipsRelatedByObjectProjectId;
                }

                if($partial && $this->collProjectRelationshipsRelatedByObjectProjectId) {
                    foreach($this->collProjectRelationshipsRelatedByObjectProjectId as $obj) {
                        if($obj->isNew()) {
                            $collProjectRelationshipsRelatedByObjectProjectId[] = $obj;
                        }
                    }
                }

                $this->collProjectRelationshipsRelatedByObjectProjectId = $collProjectRelationshipsRelatedByObjectProjectId;
                $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = false;
            }
        }

        return $this->collProjectRelationshipsRelatedByObjectProjectId;
    }

    /**
     * Sets a collection of ProjectRelationshipRelatedByObjectProjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectRelationshipsRelatedByObjectProjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setProjectRelationshipsRelatedByObjectProjectId(PropelCollection $projectRelationshipsRelatedByObjectProjectId, PropelPDO $con = null)
    {
        $projectRelationshipsRelatedByObjectProjectIdToDelete = $this->getProjectRelationshipsRelatedByObjectProjectId(new Criteria(), $con)->diff($projectRelationshipsRelatedByObjectProjectId);

        $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion = unserialize(serialize($projectRelationshipsRelatedByObjectProjectIdToDelete));

        foreach ($projectRelationshipsRelatedByObjectProjectIdToDelete as $projectRelationshipRelatedByObjectProjectIdRemoved) {
            $projectRelationshipRelatedByObjectProjectIdRemoved->setProjectRelatedByObjectProjectId(null);
        }

        $this->collProjectRelationshipsRelatedByObjectProjectId = null;
        foreach ($projectRelationshipsRelatedByObjectProjectId as $projectRelationshipRelatedByObjectProjectId) {
            $this->addProjectRelationshipRelatedByObjectProjectId($projectRelationshipRelatedByObjectProjectId);
        }

        $this->collProjectRelationshipsRelatedByObjectProjectId = $projectRelationshipsRelatedByObjectProjectId;
        $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectRelationship objects.
     * @throws PropelException
     */
    public function countProjectRelationshipsRelatedByObjectProjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsRelatedByObjectProjectIdPartial && !$this->isNew();
        if (null === $this->collProjectRelationshipsRelatedByObjectProjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationshipsRelatedByObjectProjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectRelationshipsRelatedByObjectProjectId());
            }
            $query = ProjectRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProjectRelatedByObjectProjectId($this)
                ->count($con);
        }

        return count($this->collProjectRelationshipsRelatedByObjectProjectId);
    }

    /**
     * Method called to associate a ProjectRelationship object to this object
     * through the ProjectRelationship foreign key attribute.
     *
     * @param    ProjectRelationship $l ProjectRelationship
     * @return Project The current object (for fluent API support)
     */
    public function addProjectRelationshipRelatedByObjectProjectId(ProjectRelationship $l)
    {
        if ($this->collProjectRelationshipsRelatedByObjectProjectId === null) {
            $this->initProjectRelationshipsRelatedByObjectProjectId();
            $this->collProjectRelationshipsRelatedByObjectProjectIdPartial = true;
        }
        if (!in_array($l, $this->collProjectRelationshipsRelatedByObjectProjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectRelationshipRelatedByObjectProjectId($l);
        }

        return $this;
    }

    /**
     * @param	ProjectRelationshipRelatedByObjectProjectId $projectRelationshipRelatedByObjectProjectId The projectRelationshipRelatedByObjectProjectId object to add.
     */
    protected function doAddProjectRelationshipRelatedByObjectProjectId($projectRelationshipRelatedByObjectProjectId)
    {
        $this->collProjectRelationshipsRelatedByObjectProjectId[]= $projectRelationshipRelatedByObjectProjectId;
        $projectRelationshipRelatedByObjectProjectId->setProjectRelatedByObjectProjectId($this);
    }

    /**
     * @param	ProjectRelationshipRelatedByObjectProjectId $projectRelationshipRelatedByObjectProjectId The projectRelationshipRelatedByObjectProjectId object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeProjectRelationshipRelatedByObjectProjectId($projectRelationshipRelatedByObjectProjectId)
    {
        if ($this->getProjectRelationshipsRelatedByObjectProjectId()->contains($projectRelationshipRelatedByObjectProjectId)) {
            $this->collProjectRelationshipsRelatedByObjectProjectId->remove($this->collProjectRelationshipsRelatedByObjectProjectId->search($projectRelationshipRelatedByObjectProjectId));
            if (null === $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion) {
                $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion = clone $this->collProjectRelationshipsRelatedByObjectProjectId;
                $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion->clear();
            }
            $this->projectRelationshipsRelatedByObjectProjectIdScheduledForDeletion[]= clone $projectRelationshipRelatedByObjectProjectId;
            $projectRelationshipRelatedByObjectProjectId->setProjectRelatedByObjectProjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectRelationshipsRelatedByObjectProjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     */
    public function getProjectRelationshipsRelatedByObjectProjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getProjectRelationshipsRelatedByObjectProjectId($query, $con);
    }

    /**
     * Clears out the collProjectRelationshipsRelatedBySubjectProjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addProjectRelationshipsRelatedBySubjectProjectId()
     */
    public function clearProjectRelationshipsRelatedBySubjectProjectId()
    {
        $this->collProjectRelationshipsRelatedBySubjectProjectId = null; // important to set this to null since that means it is uninitialized
        $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectRelationshipsRelatedBySubjectProjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectRelationshipsRelatedBySubjectProjectId($v = true)
    {
        $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = $v;
    }

    /**
     * Initializes the collProjectRelationshipsRelatedBySubjectProjectId collection.
     *
     * By default this just sets the collProjectRelationshipsRelatedBySubjectProjectId collection to an empty array (like clearcollProjectRelationshipsRelatedBySubjectProjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectRelationshipsRelatedBySubjectProjectId($overrideExisting = true)
    {
        if (null !== $this->collProjectRelationshipsRelatedBySubjectProjectId && !$overrideExisting) {
            return;
        }
        $this->collProjectRelationshipsRelatedBySubjectProjectId = new PropelObjectCollection();
        $this->collProjectRelationshipsRelatedBySubjectProjectId->setModel('ProjectRelationship');
    }

    /**
     * Gets an array of ProjectRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     * @throws PropelException
     */
    public function getProjectRelationshipsRelatedBySubjectProjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial && !$this->isNew();
        if (null === $this->collProjectRelationshipsRelatedBySubjectProjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationshipsRelatedBySubjectProjectId) {
                // return empty collection
                $this->initProjectRelationshipsRelatedBySubjectProjectId();
            } else {
                $collProjectRelationshipsRelatedBySubjectProjectId = ProjectRelationshipQuery::create(null, $criteria)
                    ->filterByProjectRelatedBySubjectProjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial && count($collProjectRelationshipsRelatedBySubjectProjectId)) {
                      $this->initProjectRelationshipsRelatedBySubjectProjectId(false);

                      foreach($collProjectRelationshipsRelatedBySubjectProjectId as $obj) {
                        if (false == $this->collProjectRelationshipsRelatedBySubjectProjectId->contains($obj)) {
                          $this->collProjectRelationshipsRelatedBySubjectProjectId->append($obj);
                        }
                      }

                      $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = true;
                    }

                    $collProjectRelationshipsRelatedBySubjectProjectId->getInternalIterator()->rewind();
                    return $collProjectRelationshipsRelatedBySubjectProjectId;
                }

                if($partial && $this->collProjectRelationshipsRelatedBySubjectProjectId) {
                    foreach($this->collProjectRelationshipsRelatedBySubjectProjectId as $obj) {
                        if($obj->isNew()) {
                            $collProjectRelationshipsRelatedBySubjectProjectId[] = $obj;
                        }
                    }
                }

                $this->collProjectRelationshipsRelatedBySubjectProjectId = $collProjectRelationshipsRelatedBySubjectProjectId;
                $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = false;
            }
        }

        return $this->collProjectRelationshipsRelatedBySubjectProjectId;
    }

    /**
     * Sets a collection of ProjectRelationshipRelatedBySubjectProjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectRelationshipsRelatedBySubjectProjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setProjectRelationshipsRelatedBySubjectProjectId(PropelCollection $projectRelationshipsRelatedBySubjectProjectId, PropelPDO $con = null)
    {
        $projectRelationshipsRelatedBySubjectProjectIdToDelete = $this->getProjectRelationshipsRelatedBySubjectProjectId(new Criteria(), $con)->diff($projectRelationshipsRelatedBySubjectProjectId);

        $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion = unserialize(serialize($projectRelationshipsRelatedBySubjectProjectIdToDelete));

        foreach ($projectRelationshipsRelatedBySubjectProjectIdToDelete as $projectRelationshipRelatedBySubjectProjectIdRemoved) {
            $projectRelationshipRelatedBySubjectProjectIdRemoved->setProjectRelatedBySubjectProjectId(null);
        }

        $this->collProjectRelationshipsRelatedBySubjectProjectId = null;
        foreach ($projectRelationshipsRelatedBySubjectProjectId as $projectRelationshipRelatedBySubjectProjectId) {
            $this->addProjectRelationshipRelatedBySubjectProjectId($projectRelationshipRelatedBySubjectProjectId);
        }

        $this->collProjectRelationshipsRelatedBySubjectProjectId = $projectRelationshipsRelatedBySubjectProjectId;
        $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related ProjectRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related ProjectRelationship objects.
     * @throws PropelException
     */
    public function countProjectRelationshipsRelatedBySubjectProjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial && !$this->isNew();
        if (null === $this->collProjectRelationshipsRelatedBySubjectProjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectRelationshipsRelatedBySubjectProjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectRelationshipsRelatedBySubjectProjectId());
            }
            $query = ProjectRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProjectRelatedBySubjectProjectId($this)
                ->count($con);
        }

        return count($this->collProjectRelationshipsRelatedBySubjectProjectId);
    }

    /**
     * Method called to associate a ProjectRelationship object to this object
     * through the ProjectRelationship foreign key attribute.
     *
     * @param    ProjectRelationship $l ProjectRelationship
     * @return Project The current object (for fluent API support)
     */
    public function addProjectRelationshipRelatedBySubjectProjectId(ProjectRelationship $l)
    {
        if ($this->collProjectRelationshipsRelatedBySubjectProjectId === null) {
            $this->initProjectRelationshipsRelatedBySubjectProjectId();
            $this->collProjectRelationshipsRelatedBySubjectProjectIdPartial = true;
        }
        if (!in_array($l, $this->collProjectRelationshipsRelatedBySubjectProjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectRelationshipRelatedBySubjectProjectId($l);
        }

        return $this;
    }

    /**
     * @param	ProjectRelationshipRelatedBySubjectProjectId $projectRelationshipRelatedBySubjectProjectId The projectRelationshipRelatedBySubjectProjectId object to add.
     */
    protected function doAddProjectRelationshipRelatedBySubjectProjectId($projectRelationshipRelatedBySubjectProjectId)
    {
        $this->collProjectRelationshipsRelatedBySubjectProjectId[]= $projectRelationshipRelatedBySubjectProjectId;
        $projectRelationshipRelatedBySubjectProjectId->setProjectRelatedBySubjectProjectId($this);
    }

    /**
     * @param	ProjectRelationshipRelatedBySubjectProjectId $projectRelationshipRelatedBySubjectProjectId The projectRelationshipRelatedBySubjectProjectId object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeProjectRelationshipRelatedBySubjectProjectId($projectRelationshipRelatedBySubjectProjectId)
    {
        if ($this->getProjectRelationshipsRelatedBySubjectProjectId()->contains($projectRelationshipRelatedBySubjectProjectId)) {
            $this->collProjectRelationshipsRelatedBySubjectProjectId->remove($this->collProjectRelationshipsRelatedBySubjectProjectId->search($projectRelationshipRelatedBySubjectProjectId));
            if (null === $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion) {
                $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion = clone $this->collProjectRelationshipsRelatedBySubjectProjectId;
                $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion->clear();
            }
            $this->projectRelationshipsRelatedBySubjectProjectIdScheduledForDeletion[]= clone $projectRelationshipRelatedBySubjectProjectId;
            $projectRelationshipRelatedBySubjectProjectId->setProjectRelatedBySubjectProjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related ProjectRelationshipsRelatedBySubjectProjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|ProjectRelationship[] List of ProjectRelationship objects
     */
    public function getProjectRelationshipsRelatedBySubjectProjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getProjectRelationshipsRelatedBySubjectProjectId($query, $con);
    }

    /**
     * Clears out the collProjectprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Project The current object (for fluent API support)
     * @see        addProjectprops()
     */
    public function clearProjectprops()
    {
        $this->collProjectprops = null; // important to set this to null since that means it is uninitialized
        $this->collProjectpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collProjectprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialProjectprops($v = true)
    {
        $this->collProjectpropsPartial = $v;
    }

    /**
     * Initializes the collProjectprops collection.
     *
     * By default this just sets the collProjectprops collection to an empty array (like clearcollProjectprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProjectprops($overrideExisting = true)
    {
        if (null !== $this->collProjectprops && !$overrideExisting) {
            return;
        }
        $this->collProjectprops = new PropelObjectCollection();
        $this->collProjectprops->setModel('Projectprop');
    }

    /**
     * Gets an array of Projectprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Project is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Projectprop[] List of Projectprop objects
     * @throws PropelException
     */
    public function getProjectprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProjectpropsPartial && !$this->isNew();
        if (null === $this->collProjectprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProjectprops) {
                // return empty collection
                $this->initProjectprops();
            } else {
                $collProjectprops = ProjectpropQuery::create(null, $criteria)
                    ->filterByProject($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProjectpropsPartial && count($collProjectprops)) {
                      $this->initProjectprops(false);

                      foreach($collProjectprops as $obj) {
                        if (false == $this->collProjectprops->contains($obj)) {
                          $this->collProjectprops->append($obj);
                        }
                      }

                      $this->collProjectpropsPartial = true;
                    }

                    $collProjectprops->getInternalIterator()->rewind();
                    return $collProjectprops;
                }

                if($partial && $this->collProjectprops) {
                    foreach($this->collProjectprops as $obj) {
                        if($obj->isNew()) {
                            $collProjectprops[] = $obj;
                        }
                    }
                }

                $this->collProjectprops = $collProjectprops;
                $this->collProjectpropsPartial = false;
            }
        }

        return $this->collProjectprops;
    }

    /**
     * Sets a collection of Projectprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $projectprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Project The current object (for fluent API support)
     */
    public function setProjectprops(PropelCollection $projectprops, PropelPDO $con = null)
    {
        $projectpropsToDelete = $this->getProjectprops(new Criteria(), $con)->diff($projectprops);

        $this->projectpropsScheduledForDeletion = unserialize(serialize($projectpropsToDelete));

        foreach ($projectpropsToDelete as $projectpropRemoved) {
            $projectpropRemoved->setProject(null);
        }

        $this->collProjectprops = null;
        foreach ($projectprops as $projectprop) {
            $this->addProjectprop($projectprop);
        }

        $this->collProjectprops = $projectprops;
        $this->collProjectpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Projectprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Projectprop objects.
     * @throws PropelException
     */
    public function countProjectprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProjectpropsPartial && !$this->isNew();
        if (null === $this->collProjectprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProjectprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProjectprops());
            }
            $query = ProjectpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProject($this)
                ->count($con);
        }

        return count($this->collProjectprops);
    }

    /**
     * Method called to associate a Projectprop object to this object
     * through the Projectprop foreign key attribute.
     *
     * @param    Projectprop $l Projectprop
     * @return Project The current object (for fluent API support)
     */
    public function addProjectprop(Projectprop $l)
    {
        if ($this->collProjectprops === null) {
            $this->initProjectprops();
            $this->collProjectpropsPartial = true;
        }
        if (!in_array($l, $this->collProjectprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProjectprop($l);
        }

        return $this;
    }

    /**
     * @param	Projectprop $projectprop The projectprop object to add.
     */
    protected function doAddProjectprop($projectprop)
    {
        $this->collProjectprops[]= $projectprop;
        $projectprop->setProject($this);
    }

    /**
     * @param	Projectprop $projectprop The projectprop object to remove.
     * @return Project The current object (for fluent API support)
     */
    public function removeProjectprop($projectprop)
    {
        if ($this->getProjectprops()->contains($projectprop)) {
            $this->collProjectprops->remove($this->collProjectprops->search($projectprop));
            if (null === $this->projectpropsScheduledForDeletion) {
                $this->projectpropsScheduledForDeletion = clone $this->collProjectprops;
                $this->projectpropsScheduledForDeletion->clear();
            }
            $this->projectpropsScheduledForDeletion[]= clone $projectprop;
            $projectprop->setProject(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Project is new, it will return
     * an empty collection; or if this Project has previously
     * been saved, it will retrieve related Projectprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Project.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Projectprop[] List of Projectprop objects
     */
    public function getProjectpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProjectpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getProjectprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->project_id = null;
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
            if ($this->collAssayProjects) {
                foreach ($this->collAssayProjects as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectContacts) {
                foreach ($this->collProjectContacts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectPubs) {
                foreach ($this->collProjectPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectRelationshipsRelatedByObjectProjectId) {
                foreach ($this->collProjectRelationshipsRelatedByObjectProjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectRelationshipsRelatedBySubjectProjectId) {
                foreach ($this->collProjectRelationshipsRelatedBySubjectProjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProjectprops) {
                foreach ($this->collProjectprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAssayProjects instanceof PropelCollection) {
            $this->collAssayProjects->clearIterator();
        }
        $this->collAssayProjects = null;
        if ($this->collProjectContacts instanceof PropelCollection) {
            $this->collProjectContacts->clearIterator();
        }
        $this->collProjectContacts = null;
        if ($this->collProjectPubs instanceof PropelCollection) {
            $this->collProjectPubs->clearIterator();
        }
        $this->collProjectPubs = null;
        if ($this->collProjectRelationshipsRelatedByObjectProjectId instanceof PropelCollection) {
            $this->collProjectRelationshipsRelatedByObjectProjectId->clearIterator();
        }
        $this->collProjectRelationshipsRelatedByObjectProjectId = null;
        if ($this->collProjectRelationshipsRelatedBySubjectProjectId instanceof PropelCollection) {
            $this->collProjectRelationshipsRelatedBySubjectProjectId->clearIterator();
        }
        $this->collProjectRelationshipsRelatedBySubjectProjectId = null;
        if ($this->collProjectprops instanceof PropelCollection) {
            $this->collProjectprops->clearIterator();
        }
        $this->collProjectprops = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProjectPeer::DEFAULT_STRING_FORMAT);
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
