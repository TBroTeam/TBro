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
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayBiomaterialQuery;
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialPeer;
use cli_db\propel\BiomaterialQuery;
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\BiomaterialRelationshipQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Organism;
use cli_db\propel\OrganismQuery;

/**
 * Base class that represents a row from the 'biomaterial' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseBiomaterial extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\BiomaterialPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        BiomaterialPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the biomaterial_id field.
     * @var        int
     */
    protected $biomaterial_id;

    /**
     * The value for the taxon_id field.
     * @var        int
     */
    protected $taxon_id;

    /**
     * The value for the biosourceprovider_id field.
     * @var        int
     */
    protected $biosourceprovider_id;

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
     * @var        Organism
     */
    protected $aOrganism;

    /**
     * @var        PropelObjectCollection|AssayBiomaterial[] Collection to store aggregation of AssayBiomaterial objects.
     */
    protected $collAssayBiomaterials;
    protected $collAssayBiomaterialsPartial;

    /**
     * @var        PropelObjectCollection|BiomaterialRelationship[] Collection to store aggregation of BiomaterialRelationship objects.
     */
    protected $collBiomaterialRelationshipsRelatedByObjectId;
    protected $collBiomaterialRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|BiomaterialRelationship[] Collection to store aggregation of BiomaterialRelationship objects.
     */
    protected $collBiomaterialRelationshipsRelatedBySubjectId;
    protected $collBiomaterialRelationshipsRelatedBySubjectIdPartial;

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
    protected $assayBiomaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * Get the [biomaterial_id] column value.
     *
     * @return int
     */
    public function getBiomaterialId()
    {
        return $this->biomaterial_id;
    }

    /**
     * Get the [taxon_id] column value.
     *
     * @return int
     */
    public function getTaxonId()
    {
        return $this->taxon_id;
    }

    /**
     * Get the [biosourceprovider_id] column value.
     *
     * @return int
     */
    public function getBiosourceproviderId()
    {
        return $this->biosourceprovider_id;
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
     * Set the value of [biomaterial_id] column.
     *
     * @param int $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setBiomaterialId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->biomaterial_id !== $v) {
            $this->biomaterial_id = $v;
            $this->modifiedColumns[] = BiomaterialPeer::BIOMATERIAL_ID;
        }


        return $this;
    } // setBiomaterialId()

    /**
     * Set the value of [taxon_id] column.
     *
     * @param int $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setTaxonId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->taxon_id !== $v) {
            $this->taxon_id = $v;
            $this->modifiedColumns[] = BiomaterialPeer::TAXON_ID;
        }

        if ($this->aOrganism !== null && $this->aOrganism->getOrganismId() !== $v) {
            $this->aOrganism = null;
        }


        return $this;
    } // setTaxonId()

    /**
     * Set the value of [biosourceprovider_id] column.
     *
     * @param int $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setBiosourceproviderId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->biosourceprovider_id !== $v) {
            $this->biosourceprovider_id = $v;
            $this->modifiedColumns[] = BiomaterialPeer::BIOSOURCEPROVIDER_ID;
        }

        if ($this->aContact !== null && $this->aContact->getContactId() !== $v) {
            $this->aContact = null;
        }


        return $this;
    } // setBiosourceproviderId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = BiomaterialPeer::DBXREF_ID;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = BiomaterialPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = BiomaterialPeer::DESCRIPTION;
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

            $this->biomaterial_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->taxon_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->biosourceprovider_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->dbxref_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->description = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = BiomaterialPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Biomaterial object", $e);
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

        if ($this->aOrganism !== null && $this->taxon_id !== $this->aOrganism->getOrganismId()) {
            $this->aOrganism = null;
        }
        if ($this->aContact !== null && $this->biosourceprovider_id !== $this->aContact->getContactId()) {
            $this->aContact = null;
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
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = BiomaterialPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aContact = null;
            $this->aOrganism = null;
            $this->collAssayBiomaterials = null;

            $this->collBiomaterialRelationshipsRelatedByObjectId = null;

            $this->collBiomaterialRelationshipsRelatedBySubjectId = null;

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
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = BiomaterialQuery::create()
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
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                BiomaterialPeer::addInstanceToPool($this);
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

            if ($this->aOrganism !== null) {
                if ($this->aOrganism->isModified() || $this->aOrganism->isNew()) {
                    $affectedRows += $this->aOrganism->save($con);
                }
                $this->setOrganism($this->aOrganism);
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

            if ($this->assayBiomaterialsScheduledForDeletion !== null) {
                if (!$this->assayBiomaterialsScheduledForDeletion->isEmpty()) {
                    AssayBiomaterialQuery::create()
                        ->filterByPrimaryKeys($this->assayBiomaterialsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->assayBiomaterialsScheduledForDeletion = null;
                }
            }

            if ($this->collAssayBiomaterials !== null) {
                foreach ($this->collAssayBiomaterials as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    BiomaterialRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collBiomaterialRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    BiomaterialRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collBiomaterialRelationshipsRelatedBySubjectId as $referrerFK) {
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

        $this->modifiedColumns[] = BiomaterialPeer::BIOMATERIAL_ID;
        if (null !== $this->biomaterial_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . BiomaterialPeer::BIOMATERIAL_ID . ')');
        }
        if (null === $this->biomaterial_id) {
            try {
                $stmt = $con->query("SELECT nextval('biomaterial_biomaterial_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->biomaterial_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(BiomaterialPeer::BIOMATERIAL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"biomaterial_id"';
        }
        if ($this->isColumnModified(BiomaterialPeer::TAXON_ID)) {
            $modifiedColumns[':p' . $index++]  = '"taxon_id"';
        }
        if ($this->isColumnModified(BiomaterialPeer::BIOSOURCEPROVIDER_ID)) {
            $modifiedColumns[':p' . $index++]  = '"biosourceprovider_id"';
        }
        if ($this->isColumnModified(BiomaterialPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(BiomaterialPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(BiomaterialPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "biomaterial" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"biomaterial_id"':
                        $stmt->bindValue($identifier, $this->biomaterial_id, PDO::PARAM_INT);
                        break;
                    case '"taxon_id"':
                        $stmt->bindValue($identifier, $this->taxon_id, PDO::PARAM_INT);
                        break;
                    case '"biosourceprovider_id"':
                        $stmt->bindValue($identifier, $this->biosourceprovider_id, PDO::PARAM_INT);
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

            if ($this->aOrganism !== null) {
                if (!$this->aOrganism->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aOrganism->getValidationFailures());
                }
            }


            if (($retval = BiomaterialPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAssayBiomaterials !== null) {
                    foreach ($this->collAssayBiomaterials as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collBiomaterialRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collBiomaterialRelationshipsRelatedBySubjectId as $referrerFK) {
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
        $pos = BiomaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getBiomaterialId();
                break;
            case 1:
                return $this->getTaxonId();
                break;
            case 2:
                return $this->getBiosourceproviderId();
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
        if (isset($alreadyDumpedObjects['Biomaterial'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Biomaterial'][$this->getPrimaryKey()] = true;
        $keys = BiomaterialPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getBiomaterialId(),
            $keys[1] => $this->getTaxonId(),
            $keys[2] => $this->getBiosourceproviderId(),
            $keys[3] => $this->getDbxrefId(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aContact) {
                $result['Contact'] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aOrganism) {
                $result['Organism'] = $this->aOrganism->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAssayBiomaterials) {
                $result['AssayBiomaterials'] = $this->collAssayBiomaterials->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialRelationshipsRelatedByObjectId) {
                $result['BiomaterialRelationshipsRelatedByObjectId'] = $this->collBiomaterialRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialRelationshipsRelatedBySubjectId) {
                $result['BiomaterialRelationshipsRelatedBySubjectId'] = $this->collBiomaterialRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = BiomaterialPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setBiomaterialId($value);
                break;
            case 1:
                $this->setTaxonId($value);
                break;
            case 2:
                $this->setBiosourceproviderId($value);
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
        $keys = BiomaterialPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setBiomaterialId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTaxonId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setBiosourceproviderId($arr[$keys[2]]);
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
        $criteria = new Criteria(BiomaterialPeer::DATABASE_NAME);

        if ($this->isColumnModified(BiomaterialPeer::BIOMATERIAL_ID)) $criteria->add(BiomaterialPeer::BIOMATERIAL_ID, $this->biomaterial_id);
        if ($this->isColumnModified(BiomaterialPeer::TAXON_ID)) $criteria->add(BiomaterialPeer::TAXON_ID, $this->taxon_id);
        if ($this->isColumnModified(BiomaterialPeer::BIOSOURCEPROVIDER_ID)) $criteria->add(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $this->biosourceprovider_id);
        if ($this->isColumnModified(BiomaterialPeer::DBXREF_ID)) $criteria->add(BiomaterialPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(BiomaterialPeer::NAME)) $criteria->add(BiomaterialPeer::NAME, $this->name);
        if ($this->isColumnModified(BiomaterialPeer::DESCRIPTION)) $criteria->add(BiomaterialPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(BiomaterialPeer::DATABASE_NAME);
        $criteria->add(BiomaterialPeer::BIOMATERIAL_ID, $this->biomaterial_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getBiomaterialId();
    }

    /**
     * Generic method to set the primary key (biomaterial_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setBiomaterialId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getBiomaterialId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Biomaterial (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTaxonId($this->getTaxonId());
        $copyObj->setBiosourceproviderId($this->getBiosourceproviderId());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setName($this->getName());
        $copyObj->setDescription($this->getDescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAssayBiomaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssayBiomaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setBiomaterialId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Biomaterial Clone of current object.
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
     * @return BiomaterialPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new BiomaterialPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Contact object.
     *
     * @param             Contact $v
     * @return Biomaterial The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(Contact $v = null)
    {
        if ($v === null) {
            $this->setBiosourceproviderId(NULL);
        } else {
            $this->setBiosourceproviderId($v->getContactId());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Contact object, it will not be re-added.
        if ($v !== null) {
            $v->addBiomaterial($this);
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
        if ($this->aContact === null && ($this->biosourceprovider_id !== null) && $doQuery) {
            $this->aContact = ContactQuery::create()->findPk($this->biosourceprovider_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addBiomaterials($this);
             */
        }

        return $this->aContact;
    }

    /**
     * Declares an association between this object and a Organism object.
     *
     * @param             Organism $v
     * @return Biomaterial The current object (for fluent API support)
     * @throws PropelException
     */
    public function setOrganism(Organism $v = null)
    {
        if ($v === null) {
            $this->setTaxonId(NULL);
        } else {
            $this->setTaxonId($v->getOrganismId());
        }

        $this->aOrganism = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Organism object, it will not be re-added.
        if ($v !== null) {
            $v->addBiomaterial($this);
        }


        return $this;
    }


    /**
     * Get the associated Organism object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Organism The associated Organism object.
     * @throws PropelException
     */
    public function getOrganism(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aOrganism === null && ($this->taxon_id !== null) && $doQuery) {
            $this->aOrganism = OrganismQuery::create()->findPk($this->taxon_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aOrganism->addBiomaterials($this);
             */
        }

        return $this->aOrganism;
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
        if ('AssayBiomaterial' == $relationName) {
            $this->initAssayBiomaterials();
        }
        if ('BiomaterialRelationshipRelatedByObjectId' == $relationName) {
            $this->initBiomaterialRelationshipsRelatedByObjectId();
        }
        if ('BiomaterialRelationshipRelatedBySubjectId' == $relationName) {
            $this->initBiomaterialRelationshipsRelatedBySubjectId();
        }
    }

    /**
     * Clears out the collAssayBiomaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Biomaterial The current object (for fluent API support)
     * @see        addAssayBiomaterials()
     */
    public function clearAssayBiomaterials()
    {
        $this->collAssayBiomaterials = null; // important to set this to null since that means it is uninitialized
        $this->collAssayBiomaterialsPartial = null;

        return $this;
    }

    /**
     * reset is the collAssayBiomaterials collection loaded partially
     *
     * @return void
     */
    public function resetPartialAssayBiomaterials($v = true)
    {
        $this->collAssayBiomaterialsPartial = $v;
    }

    /**
     * Initializes the collAssayBiomaterials collection.
     *
     * By default this just sets the collAssayBiomaterials collection to an empty array (like clearcollAssayBiomaterials());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAssayBiomaterials($overrideExisting = true)
    {
        if (null !== $this->collAssayBiomaterials && !$overrideExisting) {
            return;
        }
        $this->collAssayBiomaterials = new PropelObjectCollection();
        $this->collAssayBiomaterials->setModel('AssayBiomaterial');
    }

    /**
     * Gets an array of AssayBiomaterial objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Biomaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|AssayBiomaterial[] List of AssayBiomaterial objects
     * @throws PropelException
     */
    public function getAssayBiomaterials($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAssayBiomaterialsPartial && !$this->isNew();
        if (null === $this->collAssayBiomaterials || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAssayBiomaterials) {
                // return empty collection
                $this->initAssayBiomaterials();
            } else {
                $collAssayBiomaterials = AssayBiomaterialQuery::create(null, $criteria)
                    ->filterByBiomaterial($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAssayBiomaterialsPartial && count($collAssayBiomaterials)) {
                      $this->initAssayBiomaterials(false);

                      foreach($collAssayBiomaterials as $obj) {
                        if (false == $this->collAssayBiomaterials->contains($obj)) {
                          $this->collAssayBiomaterials->append($obj);
                        }
                      }

                      $this->collAssayBiomaterialsPartial = true;
                    }

                    $collAssayBiomaterials->getInternalIterator()->rewind();
                    return $collAssayBiomaterials;
                }

                if($partial && $this->collAssayBiomaterials) {
                    foreach($this->collAssayBiomaterials as $obj) {
                        if($obj->isNew()) {
                            $collAssayBiomaterials[] = $obj;
                        }
                    }
                }

                $this->collAssayBiomaterials = $collAssayBiomaterials;
                $this->collAssayBiomaterialsPartial = false;
            }
        }

        return $this->collAssayBiomaterials;
    }

    /**
     * Sets a collection of AssayBiomaterial objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $assayBiomaterials A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setAssayBiomaterials(PropelCollection $assayBiomaterials, PropelPDO $con = null)
    {
        $assayBiomaterialsToDelete = $this->getAssayBiomaterials(new Criteria(), $con)->diff($assayBiomaterials);

        $this->assayBiomaterialsScheduledForDeletion = unserialize(serialize($assayBiomaterialsToDelete));

        foreach ($assayBiomaterialsToDelete as $assayBiomaterialRemoved) {
            $assayBiomaterialRemoved->setBiomaterial(null);
        }

        $this->collAssayBiomaterials = null;
        foreach ($assayBiomaterials as $assayBiomaterial) {
            $this->addAssayBiomaterial($assayBiomaterial);
        }

        $this->collAssayBiomaterials = $assayBiomaterials;
        $this->collAssayBiomaterialsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related AssayBiomaterial objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related AssayBiomaterial objects.
     * @throws PropelException
     */
    public function countAssayBiomaterials(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAssayBiomaterialsPartial && !$this->isNew();
        if (null === $this->collAssayBiomaterials || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAssayBiomaterials) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAssayBiomaterials());
            }
            $query = AssayBiomaterialQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiomaterial($this)
                ->count($con);
        }

        return count($this->collAssayBiomaterials);
    }

    /**
     * Method called to associate a AssayBiomaterial object to this object
     * through the AssayBiomaterial foreign key attribute.
     *
     * @param    AssayBiomaterial $l AssayBiomaterial
     * @return Biomaterial The current object (for fluent API support)
     */
    public function addAssayBiomaterial(AssayBiomaterial $l)
    {
        if ($this->collAssayBiomaterials === null) {
            $this->initAssayBiomaterials();
            $this->collAssayBiomaterialsPartial = true;
        }
        if (!in_array($l, $this->collAssayBiomaterials->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAssayBiomaterial($l);
        }

        return $this;
    }

    /**
     * @param	AssayBiomaterial $assayBiomaterial The assayBiomaterial object to add.
     */
    protected function doAddAssayBiomaterial($assayBiomaterial)
    {
        $this->collAssayBiomaterials[]= $assayBiomaterial;
        $assayBiomaterial->setBiomaterial($this);
    }

    /**
     * @param	AssayBiomaterial $assayBiomaterial The assayBiomaterial object to remove.
     * @return Biomaterial The current object (for fluent API support)
     */
    public function removeAssayBiomaterial($assayBiomaterial)
    {
        if ($this->getAssayBiomaterials()->contains($assayBiomaterial)) {
            $this->collAssayBiomaterials->remove($this->collAssayBiomaterials->search($assayBiomaterial));
            if (null === $this->assayBiomaterialsScheduledForDeletion) {
                $this->assayBiomaterialsScheduledForDeletion = clone $this->collAssayBiomaterials;
                $this->assayBiomaterialsScheduledForDeletion->clear();
            }
            $this->assayBiomaterialsScheduledForDeletion[]= clone $assayBiomaterial;
            $assayBiomaterial->setBiomaterial(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biomaterial is new, it will return
     * an empty collection; or if this Biomaterial has previously
     * been saved, it will retrieve related AssayBiomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biomaterial.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|AssayBiomaterial[] List of AssayBiomaterial objects
     */
    public function getAssayBiomaterialsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayBiomaterialQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAssayBiomaterials($query, $con);
    }

    /**
     * Clears out the collBiomaterialRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Biomaterial The current object (for fluent API support)
     * @see        addBiomaterialRelationshipsRelatedByObjectId()
     */
    public function clearBiomaterialRelationshipsRelatedByObjectId()
    {
        $this->collBiomaterialRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialRelationshipsRelatedByObjectId($v = true)
    {
        $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collBiomaterialRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collBiomaterialRelationshipsRelatedByObjectId collection to an empty array (like clearcollBiomaterialRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collBiomaterialRelationshipsRelatedByObjectId->setModel('BiomaterialRelationship');
    }

    /**
     * Gets an array of BiomaterialRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Biomaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     * @throws PropelException
     */
    public function getBiomaterialRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initBiomaterialRelationshipsRelatedByObjectId();
            } else {
                $collBiomaterialRelationshipsRelatedByObjectId = BiomaterialRelationshipQuery::create(null, $criteria)
                    ->filterByBiomaterialRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialRelationshipsRelatedByObjectIdPartial && count($collBiomaterialRelationshipsRelatedByObjectId)) {
                      $this->initBiomaterialRelationshipsRelatedByObjectId(false);

                      foreach($collBiomaterialRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collBiomaterialRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collBiomaterialRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collBiomaterialRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collBiomaterialRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collBiomaterialRelationshipsRelatedByObjectId) {
                    foreach($this->collBiomaterialRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialRelationshipsRelatedByObjectId = $collBiomaterialRelationshipsRelatedByObjectId;
                $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collBiomaterialRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of BiomaterialRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setBiomaterialRelationshipsRelatedByObjectId(PropelCollection $biomaterialRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $biomaterialRelationshipsRelatedByObjectIdToDelete = $this->getBiomaterialRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($biomaterialRelationshipsRelatedByObjectId);

        $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($biomaterialRelationshipsRelatedByObjectIdToDelete));

        foreach ($biomaterialRelationshipsRelatedByObjectIdToDelete as $biomaterialRelationshipRelatedByObjectIdRemoved) {
            $biomaterialRelationshipRelatedByObjectIdRemoved->setBiomaterialRelatedByObjectId(null);
        }

        $this->collBiomaterialRelationshipsRelatedByObjectId = null;
        foreach ($biomaterialRelationshipsRelatedByObjectId as $biomaterialRelationshipRelatedByObjectId) {
            $this->addBiomaterialRelationshipRelatedByObjectId($biomaterialRelationshipRelatedByObjectId);
        }

        $this->collBiomaterialRelationshipsRelatedByObjectId = $biomaterialRelationshipsRelatedByObjectId;
        $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BiomaterialRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BiomaterialRelationship objects.
     * @throws PropelException
     */
    public function countBiomaterialRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialRelationshipsRelatedByObjectId());
            }
            $query = BiomaterialRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiomaterialRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collBiomaterialRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a BiomaterialRelationship object to this object
     * through the BiomaterialRelationship foreign key attribute.
     *
     * @param    BiomaterialRelationship $l BiomaterialRelationship
     * @return Biomaterial The current object (for fluent API support)
     */
    public function addBiomaterialRelationshipRelatedByObjectId(BiomaterialRelationship $l)
    {
        if ($this->collBiomaterialRelationshipsRelatedByObjectId === null) {
            $this->initBiomaterialRelationshipsRelatedByObjectId();
            $this->collBiomaterialRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialRelationshipRelatedByObjectId $biomaterialRelationshipRelatedByObjectId The biomaterialRelationshipRelatedByObjectId object to add.
     */
    protected function doAddBiomaterialRelationshipRelatedByObjectId($biomaterialRelationshipRelatedByObjectId)
    {
        $this->collBiomaterialRelationshipsRelatedByObjectId[]= $biomaterialRelationshipRelatedByObjectId;
        $biomaterialRelationshipRelatedByObjectId->setBiomaterialRelatedByObjectId($this);
    }

    /**
     * @param	BiomaterialRelationshipRelatedByObjectId $biomaterialRelationshipRelatedByObjectId The biomaterialRelationshipRelatedByObjectId object to remove.
     * @return Biomaterial The current object (for fluent API support)
     */
    public function removeBiomaterialRelationshipRelatedByObjectId($biomaterialRelationshipRelatedByObjectId)
    {
        if ($this->getBiomaterialRelationshipsRelatedByObjectId()->contains($biomaterialRelationshipRelatedByObjectId)) {
            $this->collBiomaterialRelationshipsRelatedByObjectId->remove($this->collBiomaterialRelationshipsRelatedByObjectId->search($biomaterialRelationshipRelatedByObjectId));
            if (null === $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collBiomaterialRelationshipsRelatedByObjectId;
                $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->biomaterialRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $biomaterialRelationshipRelatedByObjectId;
            $biomaterialRelationshipRelatedByObjectId->setBiomaterialRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biomaterial is new, it will return
     * an empty collection; or if this Biomaterial has previously
     * been saved, it will retrieve related BiomaterialRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biomaterial.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getBiomaterialRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collBiomaterialRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Biomaterial The current object (for fluent API support)
     * @see        addBiomaterialRelationshipsRelatedBySubjectId()
     */
    public function clearBiomaterialRelationshipsRelatedBySubjectId()
    {
        $this->collBiomaterialRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collBiomaterialRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collBiomaterialRelationshipsRelatedBySubjectId collection to an empty array (like clearcollBiomaterialRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collBiomaterialRelationshipsRelatedBySubjectId->setModel('BiomaterialRelationship');
    }

    /**
     * Gets an array of BiomaterialRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Biomaterial is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     * @throws PropelException
     */
    public function getBiomaterialRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initBiomaterialRelationshipsRelatedBySubjectId();
            } else {
                $collBiomaterialRelationshipsRelatedBySubjectId = BiomaterialRelationshipQuery::create(null, $criteria)
                    ->filterByBiomaterialRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial && count($collBiomaterialRelationshipsRelatedBySubjectId)) {
                      $this->initBiomaterialRelationshipsRelatedBySubjectId(false);

                      foreach($collBiomaterialRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collBiomaterialRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collBiomaterialRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collBiomaterialRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collBiomaterialRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collBiomaterialRelationshipsRelatedBySubjectId) {
                    foreach($this->collBiomaterialRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialRelationshipsRelatedBySubjectId = $collBiomaterialRelationshipsRelatedBySubjectId;
                $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collBiomaterialRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of BiomaterialRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Biomaterial The current object (for fluent API support)
     */
    public function setBiomaterialRelationshipsRelatedBySubjectId(PropelCollection $biomaterialRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $biomaterialRelationshipsRelatedBySubjectIdToDelete = $this->getBiomaterialRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($biomaterialRelationshipsRelatedBySubjectId);

        $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($biomaterialRelationshipsRelatedBySubjectIdToDelete));

        foreach ($biomaterialRelationshipsRelatedBySubjectIdToDelete as $biomaterialRelationshipRelatedBySubjectIdRemoved) {
            $biomaterialRelationshipRelatedBySubjectIdRemoved->setBiomaterialRelatedBySubjectId(null);
        }

        $this->collBiomaterialRelationshipsRelatedBySubjectId = null;
        foreach ($biomaterialRelationshipsRelatedBySubjectId as $biomaterialRelationshipRelatedBySubjectId) {
            $this->addBiomaterialRelationshipRelatedBySubjectId($biomaterialRelationshipRelatedBySubjectId);
        }

        $this->collBiomaterialRelationshipsRelatedBySubjectId = $biomaterialRelationshipsRelatedBySubjectId;
        $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BiomaterialRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BiomaterialRelationship objects.
     * @throws PropelException
     */
    public function countBiomaterialRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialRelationshipsRelatedBySubjectId());
            }
            $query = BiomaterialRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByBiomaterialRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collBiomaterialRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a BiomaterialRelationship object to this object
     * through the BiomaterialRelationship foreign key attribute.
     *
     * @param    BiomaterialRelationship $l BiomaterialRelationship
     * @return Biomaterial The current object (for fluent API support)
     */
    public function addBiomaterialRelationshipRelatedBySubjectId(BiomaterialRelationship $l)
    {
        if ($this->collBiomaterialRelationshipsRelatedBySubjectId === null) {
            $this->initBiomaterialRelationshipsRelatedBySubjectId();
            $this->collBiomaterialRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialRelationshipRelatedBySubjectId $biomaterialRelationshipRelatedBySubjectId The biomaterialRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddBiomaterialRelationshipRelatedBySubjectId($biomaterialRelationshipRelatedBySubjectId)
    {
        $this->collBiomaterialRelationshipsRelatedBySubjectId[]= $biomaterialRelationshipRelatedBySubjectId;
        $biomaterialRelationshipRelatedBySubjectId->setBiomaterialRelatedBySubjectId($this);
    }

    /**
     * @param	BiomaterialRelationshipRelatedBySubjectId $biomaterialRelationshipRelatedBySubjectId The biomaterialRelationshipRelatedBySubjectId object to remove.
     * @return Biomaterial The current object (for fluent API support)
     */
    public function removeBiomaterialRelationshipRelatedBySubjectId($biomaterialRelationshipRelatedBySubjectId)
    {
        if ($this->getBiomaterialRelationshipsRelatedBySubjectId()->contains($biomaterialRelationshipRelatedBySubjectId)) {
            $this->collBiomaterialRelationshipsRelatedBySubjectId->remove($this->collBiomaterialRelationshipsRelatedBySubjectId->search($biomaterialRelationshipRelatedBySubjectId));
            if (null === $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collBiomaterialRelationshipsRelatedBySubjectId;
                $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->biomaterialRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $biomaterialRelationshipRelatedBySubjectId;
            $biomaterialRelationshipRelatedBySubjectId->setBiomaterialRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Biomaterial is new, it will return
     * an empty collection; or if this Biomaterial has previously
     * been saved, it will retrieve related BiomaterialRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Biomaterial.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getBiomaterialRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->biomaterial_id = null;
        $this->taxon_id = null;
        $this->biosourceprovider_id = null;
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
            if ($this->collAssayBiomaterials) {
                foreach ($this->collAssayBiomaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialRelationshipsRelatedByObjectId) {
                foreach ($this->collBiomaterialRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialRelationshipsRelatedBySubjectId) {
                foreach ($this->collBiomaterialRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aContact instanceof Persistent) {
              $this->aContact->clearAllReferences($deep);
            }
            if ($this->aOrganism instanceof Persistent) {
              $this->aOrganism->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAssayBiomaterials instanceof PropelCollection) {
            $this->collAssayBiomaterials->clearIterator();
        }
        $this->collAssayBiomaterials = null;
        if ($this->collBiomaterialRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collBiomaterialRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collBiomaterialRelationshipsRelatedByObjectId = null;
        if ($this->collBiomaterialRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collBiomaterialRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collBiomaterialRelationshipsRelatedBySubjectId = null;
        $this->aContact = null;
        $this->aOrganism = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(BiomaterialPeer::DEFAULT_STRING_FORMAT);
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
