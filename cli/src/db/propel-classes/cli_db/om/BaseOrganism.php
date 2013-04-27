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
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureQuery;
use cli_db\propel\Organism;
use cli_db\propel\OrganismDbxref;
use cli_db\propel\OrganismDbxrefQuery;
use cli_db\propel\OrganismPeer;
use cli_db\propel\OrganismQuery;
use cli_db\propel\Organismprop;
use cli_db\propel\OrganismpropQuery;

/**
 * Base class that represents a row from the 'organism' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseOrganism extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\OrganismPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        OrganismPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the organism_id field.
     * @var        int
     */
    protected $organism_id;

    /**
     * The value for the abbreviation field.
     * @var        string
     */
    protected $abbreviation;

    /**
     * The value for the genus field.
     * @var        string
     */
    protected $genus;

    /**
     * The value for the species field.
     * @var        string
     */
    protected $species;

    /**
     * The value for the common_name field.
     * @var        string
     */
    protected $common_name;

    /**
     * The value for the comment field.
     * @var        string
     */
    protected $comment;

    /**
     * @var        PropelObjectCollection|Biomaterial[] Collection to store aggregation of Biomaterial objects.
     */
    protected $collBiomaterials;
    protected $collBiomaterialsPartial;

    /**
     * @var        PropelObjectCollection|Feature[] Collection to store aggregation of Feature objects.
     */
    protected $collFeatures;
    protected $collFeaturesPartial;

    /**
     * @var        PropelObjectCollection|OrganismDbxref[] Collection to store aggregation of OrganismDbxref objects.
     */
    protected $collOrganismDbxrefs;
    protected $collOrganismDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|Organismprop[] Collection to store aggregation of Organismprop objects.
     */
    protected $collOrganismprops;
    protected $collOrganismpropsPartial;

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
    protected $biomaterialsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $organismDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $organismpropsScheduledForDeletion = null;

    /**
     * Get the [organism_id] column value.
     *
     * @return int
     */
    public function getOrganismId()
    {
        return $this->organism_id;
    }

    /**
     * Get the [abbreviation] column value.
     *
     * @return string
     */
    public function getAbbreviation()
    {
        return $this->abbreviation;
    }

    /**
     * Get the [genus] column value.
     *
     * @return string
     */
    public function getGenus()
    {
        return $this->genus;
    }

    /**
     * Get the [species] column value.
     *
     * @return string
     */
    public function getSpecies()
    {
        return $this->species;
    }

    /**
     * Get the [common_name] column value.
     *
     * @return string
     */
    public function getCommonName()
    {
        return $this->common_name;
    }

    /**
     * Get the [comment] column value.
     *
     * @return string
     */
    public function getComment()
    {
        return $this->comment;
    }

    /**
     * Set the value of [organism_id] column.
     *
     * @param int $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setOrganismId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->organism_id !== $v) {
            $this->organism_id = $v;
            $this->modifiedColumns[] = OrganismPeer::ORGANISM_ID;
        }


        return $this;
    } // setOrganismId()

    /**
     * Set the value of [abbreviation] column.
     *
     * @param string $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setAbbreviation($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->abbreviation !== $v) {
            $this->abbreviation = $v;
            $this->modifiedColumns[] = OrganismPeer::ABBREVIATION;
        }


        return $this;
    } // setAbbreviation()

    /**
     * Set the value of [genus] column.
     *
     * @param string $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setGenus($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->genus !== $v) {
            $this->genus = $v;
            $this->modifiedColumns[] = OrganismPeer::GENUS;
        }


        return $this;
    } // setGenus()

    /**
     * Set the value of [species] column.
     *
     * @param string $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setSpecies($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->species !== $v) {
            $this->species = $v;
            $this->modifiedColumns[] = OrganismPeer::SPECIES;
        }


        return $this;
    } // setSpecies()

    /**
     * Set the value of [common_name] column.
     *
     * @param string $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setCommonName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->common_name !== $v) {
            $this->common_name = $v;
            $this->modifiedColumns[] = OrganismPeer::COMMON_NAME;
        }


        return $this;
    } // setCommonName()

    /**
     * Set the value of [comment] column.
     *
     * @param string $v new value
     * @return Organism The current object (for fluent API support)
     */
    public function setComment($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->comment !== $v) {
            $this->comment = $v;
            $this->modifiedColumns[] = OrganismPeer::COMMENT;
        }


        return $this;
    } // setComment()

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

            $this->organism_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->abbreviation = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->genus = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->species = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->common_name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->comment = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 6; // 6 = OrganismPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Organism object", $e);
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
            $con = Propel::getConnection(OrganismPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = OrganismPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->collBiomaterials = null;

            $this->collFeatures = null;

            $this->collOrganismDbxrefs = null;

            $this->collOrganismprops = null;

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
            $con = Propel::getConnection(OrganismPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = OrganismQuery::create()
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
            $con = Propel::getConnection(OrganismPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                OrganismPeer::addInstanceToPool($this);
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

            if ($this->featuresScheduledForDeletion !== null) {
                if (!$this->featuresScheduledForDeletion->isEmpty()) {
                    FeatureQuery::create()
                        ->filterByPrimaryKeys($this->featuresScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

            if ($this->organismDbxrefsScheduledForDeletion !== null) {
                if (!$this->organismDbxrefsScheduledForDeletion->isEmpty()) {
                    OrganismDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->organismDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->organismDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collOrganismDbxrefs !== null) {
                foreach ($this->collOrganismDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->organismpropsScheduledForDeletion !== null) {
                if (!$this->organismpropsScheduledForDeletion->isEmpty()) {
                    OrganismpropQuery::create()
                        ->filterByPrimaryKeys($this->organismpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->organismpropsScheduledForDeletion = null;
                }
            }

            if ($this->collOrganismprops !== null) {
                foreach ($this->collOrganismprops as $referrerFK) {
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

        $this->modifiedColumns[] = OrganismPeer::ORGANISM_ID;
        if (null !== $this->organism_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . OrganismPeer::ORGANISM_ID . ')');
        }
        if (null === $this->organism_id) {
            try {
                $stmt = $con->query("SELECT nextval('organism_organism_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->organism_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(OrganismPeer::ORGANISM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"organism_id"';
        }
        if ($this->isColumnModified(OrganismPeer::ABBREVIATION)) {
            $modifiedColumns[':p' . $index++]  = '"abbreviation"';
        }
        if ($this->isColumnModified(OrganismPeer::GENUS)) {
            $modifiedColumns[':p' . $index++]  = '"genus"';
        }
        if ($this->isColumnModified(OrganismPeer::SPECIES)) {
            $modifiedColumns[':p' . $index++]  = '"species"';
        }
        if ($this->isColumnModified(OrganismPeer::COMMON_NAME)) {
            $modifiedColumns[':p' . $index++]  = '"common_name"';
        }
        if ($this->isColumnModified(OrganismPeer::COMMENT)) {
            $modifiedColumns[':p' . $index++]  = '"comment"';
        }

        $sql = sprintf(
            'INSERT INTO "organism" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"organism_id"':
                        $stmt->bindValue($identifier, $this->organism_id, PDO::PARAM_INT);
                        break;
                    case '"abbreviation"':
                        $stmt->bindValue($identifier, $this->abbreviation, PDO::PARAM_STR);
                        break;
                    case '"genus"':
                        $stmt->bindValue($identifier, $this->genus, PDO::PARAM_STR);
                        break;
                    case '"species"':
                        $stmt->bindValue($identifier, $this->species, PDO::PARAM_STR);
                        break;
                    case '"common_name"':
                        $stmt->bindValue($identifier, $this->common_name, PDO::PARAM_STR);
                        break;
                    case '"comment"':
                        $stmt->bindValue($identifier, $this->comment, PDO::PARAM_STR);
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


            if (($retval = OrganismPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collBiomaterials !== null) {
                    foreach ($this->collBiomaterials as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatures !== null) {
                    foreach ($this->collFeatures as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collOrganismDbxrefs !== null) {
                    foreach ($this->collOrganismDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collOrganismprops !== null) {
                    foreach ($this->collOrganismprops as $referrerFK) {
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
        $pos = OrganismPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getOrganismId();
                break;
            case 1:
                return $this->getAbbreviation();
                break;
            case 2:
                return $this->getGenus();
                break;
            case 3:
                return $this->getSpecies();
                break;
            case 4:
                return $this->getCommonName();
                break;
            case 5:
                return $this->getComment();
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
        if (isset($alreadyDumpedObjects['Organism'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Organism'][$this->getPrimaryKey()] = true;
        $keys = OrganismPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getOrganismId(),
            $keys[1] => $this->getAbbreviation(),
            $keys[2] => $this->getGenus(),
            $keys[3] => $this->getSpecies(),
            $keys[4] => $this->getCommonName(),
            $keys[5] => $this->getComment(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->collBiomaterials) {
                $result['Biomaterials'] = $this->collBiomaterials->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatures) {
                $result['Features'] = $this->collFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrganismDbxrefs) {
                $result['OrganismDbxrefs'] = $this->collOrganismDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrganismprops) {
                $result['Organismprops'] = $this->collOrganismprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = OrganismPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setOrganismId($value);
                break;
            case 1:
                $this->setAbbreviation($value);
                break;
            case 2:
                $this->setGenus($value);
                break;
            case 3:
                $this->setSpecies($value);
                break;
            case 4:
                $this->setCommonName($value);
                break;
            case 5:
                $this->setComment($value);
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
        $keys = OrganismPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setOrganismId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setAbbreviation($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setGenus($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSpecies($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setCommonName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setComment($arr[$keys[5]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(OrganismPeer::DATABASE_NAME);

        if ($this->isColumnModified(OrganismPeer::ORGANISM_ID)) $criteria->add(OrganismPeer::ORGANISM_ID, $this->organism_id);
        if ($this->isColumnModified(OrganismPeer::ABBREVIATION)) $criteria->add(OrganismPeer::ABBREVIATION, $this->abbreviation);
        if ($this->isColumnModified(OrganismPeer::GENUS)) $criteria->add(OrganismPeer::GENUS, $this->genus);
        if ($this->isColumnModified(OrganismPeer::SPECIES)) $criteria->add(OrganismPeer::SPECIES, $this->species);
        if ($this->isColumnModified(OrganismPeer::COMMON_NAME)) $criteria->add(OrganismPeer::COMMON_NAME, $this->common_name);
        if ($this->isColumnModified(OrganismPeer::COMMENT)) $criteria->add(OrganismPeer::COMMENT, $this->comment);

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
        $criteria = new Criteria(OrganismPeer::DATABASE_NAME);
        $criteria->add(OrganismPeer::ORGANISM_ID, $this->organism_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getOrganismId();
    }

    /**
     * Generic method to set the primary key (organism_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setOrganismId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getOrganismId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Organism (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setAbbreviation($this->getAbbreviation());
        $copyObj->setGenus($this->getGenus());
        $copyObj->setSpecies($this->getSpecies());
        $copyObj->setCommonName($this->getCommonName());
        $copyObj->setComment($this->getComment());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getBiomaterials() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterial($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrganismDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrganismDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrganismprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrganismprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setOrganismId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Organism Clone of current object.
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
     * @return OrganismPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new OrganismPeer();
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
        if ('Biomaterial' == $relationName) {
            $this->initBiomaterials();
        }
        if ('Feature' == $relationName) {
            $this->initFeatures();
        }
        if ('OrganismDbxref' == $relationName) {
            $this->initOrganismDbxrefs();
        }
        if ('Organismprop' == $relationName) {
            $this->initOrganismprops();
        }
    }

    /**
     * Clears out the collBiomaterials collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Organism The current object (for fluent API support)
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
     * If this Organism is new, it will return
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
                    ->filterByOrganism($this)
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
     * @return Organism The current object (for fluent API support)
     */
    public function setBiomaterials(PropelCollection $biomaterials, PropelPDO $con = null)
    {
        $biomaterialsToDelete = $this->getBiomaterials(new Criteria(), $con)->diff($biomaterials);

        $this->biomaterialsScheduledForDeletion = unserialize(serialize($biomaterialsToDelete));

        foreach ($biomaterialsToDelete as $biomaterialRemoved) {
            $biomaterialRemoved->setOrganism(null);
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
                ->filterByOrganism($this)
                ->count($con);
        }

        return count($this->collBiomaterials);
    }

    /**
     * Method called to associate a Biomaterial object to this object
     * through the Biomaterial foreign key attribute.
     *
     * @param    Biomaterial $l Biomaterial
     * @return Organism The current object (for fluent API support)
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
        $biomaterial->setOrganism($this);
    }

    /**
     * @param	Biomaterial $biomaterial The biomaterial object to remove.
     * @return Organism The current object (for fluent API support)
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
            $biomaterial->setOrganism(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Biomaterial[] List of Biomaterial objects
     */
    public function getBiomaterialsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getBiomaterials($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
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
     * Clears out the collFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Organism The current object (for fluent API support)
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
     * If this Organism is new, it will return
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
                    ->filterByOrganism($this)
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
     * @return Organism The current object (for fluent API support)
     */
    public function setFeatures(PropelCollection $features, PropelPDO $con = null)
    {
        $featuresToDelete = $this->getFeatures(new Criteria(), $con)->diff($features);

        $this->featuresScheduledForDeletion = unserialize(serialize($featuresToDelete));

        foreach ($featuresToDelete as $featureRemoved) {
            $featureRemoved->setOrganism(null);
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
                ->filterByOrganism($this)
                ->count($con);
        }

        return count($this->collFeatures);
    }

    /**
     * Method called to associate a Feature object to this object
     * through the Feature foreign key attribute.
     *
     * @param    Feature $l Feature
     * @return Organism The current object (for fluent API support)
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
        $feature->setOrganism($this);
    }

    /**
     * @param	Feature $feature The feature object to remove.
     * @return Organism The current object (for fluent API support)
     */
    public function removeFeature($feature)
    {
        if ($this->getFeatures()->contains($feature)) {
            $this->collFeatures->remove($this->collFeatures->search($feature));
            if (null === $this->featuresScheduledForDeletion) {
                $this->featuresScheduledForDeletion = clone $this->collFeatures;
                $this->featuresScheduledForDeletion->clear();
            }
            $this->featuresScheduledForDeletion[]= clone $feature;
            $feature->setOrganism(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getFeatures($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
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
     * Clears out the collOrganismDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Organism The current object (for fluent API support)
     * @see        addOrganismDbxrefs()
     */
    public function clearOrganismDbxrefs()
    {
        $this->collOrganismDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collOrganismDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collOrganismDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialOrganismDbxrefs($v = true)
    {
        $this->collOrganismDbxrefsPartial = $v;
    }

    /**
     * Initializes the collOrganismDbxrefs collection.
     *
     * By default this just sets the collOrganismDbxrefs collection to an empty array (like clearcollOrganismDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrganismDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collOrganismDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collOrganismDbxrefs = new PropelObjectCollection();
        $this->collOrganismDbxrefs->setModel('OrganismDbxref');
    }

    /**
     * Gets an array of OrganismDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Organism is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|OrganismDbxref[] List of OrganismDbxref objects
     * @throws PropelException
     */
    public function getOrganismDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collOrganismDbxrefsPartial && !$this->isNew();
        if (null === $this->collOrganismDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrganismDbxrefs) {
                // return empty collection
                $this->initOrganismDbxrefs();
            } else {
                $collOrganismDbxrefs = OrganismDbxrefQuery::create(null, $criteria)
                    ->filterByOrganism($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collOrganismDbxrefsPartial && count($collOrganismDbxrefs)) {
                      $this->initOrganismDbxrefs(false);

                      foreach($collOrganismDbxrefs as $obj) {
                        if (false == $this->collOrganismDbxrefs->contains($obj)) {
                          $this->collOrganismDbxrefs->append($obj);
                        }
                      }

                      $this->collOrganismDbxrefsPartial = true;
                    }

                    $collOrganismDbxrefs->getInternalIterator()->rewind();
                    return $collOrganismDbxrefs;
                }

                if($partial && $this->collOrganismDbxrefs) {
                    foreach($this->collOrganismDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collOrganismDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collOrganismDbxrefs = $collOrganismDbxrefs;
                $this->collOrganismDbxrefsPartial = false;
            }
        }

        return $this->collOrganismDbxrefs;
    }

    /**
     * Sets a collection of OrganismDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $organismDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Organism The current object (for fluent API support)
     */
    public function setOrganismDbxrefs(PropelCollection $organismDbxrefs, PropelPDO $con = null)
    {
        $organismDbxrefsToDelete = $this->getOrganismDbxrefs(new Criteria(), $con)->diff($organismDbxrefs);

        $this->organismDbxrefsScheduledForDeletion = unserialize(serialize($organismDbxrefsToDelete));

        foreach ($organismDbxrefsToDelete as $organismDbxrefRemoved) {
            $organismDbxrefRemoved->setOrganism(null);
        }

        $this->collOrganismDbxrefs = null;
        foreach ($organismDbxrefs as $organismDbxref) {
            $this->addOrganismDbxref($organismDbxref);
        }

        $this->collOrganismDbxrefs = $organismDbxrefs;
        $this->collOrganismDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related OrganismDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related OrganismDbxref objects.
     * @throws PropelException
     */
    public function countOrganismDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collOrganismDbxrefsPartial && !$this->isNew();
        if (null === $this->collOrganismDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrganismDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getOrganismDbxrefs());
            }
            $query = OrganismDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrganism($this)
                ->count($con);
        }

        return count($this->collOrganismDbxrefs);
    }

    /**
     * Method called to associate a OrganismDbxref object to this object
     * through the OrganismDbxref foreign key attribute.
     *
     * @param    OrganismDbxref $l OrganismDbxref
     * @return Organism The current object (for fluent API support)
     */
    public function addOrganismDbxref(OrganismDbxref $l)
    {
        if ($this->collOrganismDbxrefs === null) {
            $this->initOrganismDbxrefs();
            $this->collOrganismDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collOrganismDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrganismDbxref($l);
        }

        return $this;
    }

    /**
     * @param	OrganismDbxref $organismDbxref The organismDbxref object to add.
     */
    protected function doAddOrganismDbxref($organismDbxref)
    {
        $this->collOrganismDbxrefs[]= $organismDbxref;
        $organismDbxref->setOrganism($this);
    }

    /**
     * @param	OrganismDbxref $organismDbxref The organismDbxref object to remove.
     * @return Organism The current object (for fluent API support)
     */
    public function removeOrganismDbxref($organismDbxref)
    {
        if ($this->getOrganismDbxrefs()->contains($organismDbxref)) {
            $this->collOrganismDbxrefs->remove($this->collOrganismDbxrefs->search($organismDbxref));
            if (null === $this->organismDbxrefsScheduledForDeletion) {
                $this->organismDbxrefsScheduledForDeletion = clone $this->collOrganismDbxrefs;
                $this->organismDbxrefsScheduledForDeletion->clear();
            }
            $this->organismDbxrefsScheduledForDeletion[]= clone $organismDbxref;
            $organismDbxref->setOrganism(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related OrganismDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|OrganismDbxref[] List of OrganismDbxref objects
     */
    public function getOrganismDbxrefsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = OrganismDbxrefQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getOrganismDbxrefs($query, $con);
    }

    /**
     * Clears out the collOrganismprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Organism The current object (for fluent API support)
     * @see        addOrganismprops()
     */
    public function clearOrganismprops()
    {
        $this->collOrganismprops = null; // important to set this to null since that means it is uninitialized
        $this->collOrganismpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collOrganismprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialOrganismprops($v = true)
    {
        $this->collOrganismpropsPartial = $v;
    }

    /**
     * Initializes the collOrganismprops collection.
     *
     * By default this just sets the collOrganismprops collection to an empty array (like clearcollOrganismprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initOrganismprops($overrideExisting = true)
    {
        if (null !== $this->collOrganismprops && !$overrideExisting) {
            return;
        }
        $this->collOrganismprops = new PropelObjectCollection();
        $this->collOrganismprops->setModel('Organismprop');
    }

    /**
     * Gets an array of Organismprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Organism is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Organismprop[] List of Organismprop objects
     * @throws PropelException
     */
    public function getOrganismprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collOrganismpropsPartial && !$this->isNew();
        if (null === $this->collOrganismprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collOrganismprops) {
                // return empty collection
                $this->initOrganismprops();
            } else {
                $collOrganismprops = OrganismpropQuery::create(null, $criteria)
                    ->filterByOrganism($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collOrganismpropsPartial && count($collOrganismprops)) {
                      $this->initOrganismprops(false);

                      foreach($collOrganismprops as $obj) {
                        if (false == $this->collOrganismprops->contains($obj)) {
                          $this->collOrganismprops->append($obj);
                        }
                      }

                      $this->collOrganismpropsPartial = true;
                    }

                    $collOrganismprops->getInternalIterator()->rewind();
                    return $collOrganismprops;
                }

                if($partial && $this->collOrganismprops) {
                    foreach($this->collOrganismprops as $obj) {
                        if($obj->isNew()) {
                            $collOrganismprops[] = $obj;
                        }
                    }
                }

                $this->collOrganismprops = $collOrganismprops;
                $this->collOrganismpropsPartial = false;
            }
        }

        return $this->collOrganismprops;
    }

    /**
     * Sets a collection of Organismprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $organismprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Organism The current object (for fluent API support)
     */
    public function setOrganismprops(PropelCollection $organismprops, PropelPDO $con = null)
    {
        $organismpropsToDelete = $this->getOrganismprops(new Criteria(), $con)->diff($organismprops);

        $this->organismpropsScheduledForDeletion = unserialize(serialize($organismpropsToDelete));

        foreach ($organismpropsToDelete as $organismpropRemoved) {
            $organismpropRemoved->setOrganism(null);
        }

        $this->collOrganismprops = null;
        foreach ($organismprops as $organismprop) {
            $this->addOrganismprop($organismprop);
        }

        $this->collOrganismprops = $organismprops;
        $this->collOrganismpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Organismprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Organismprop objects.
     * @throws PropelException
     */
    public function countOrganismprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collOrganismpropsPartial && !$this->isNew();
        if (null === $this->collOrganismprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collOrganismprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getOrganismprops());
            }
            $query = OrganismpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByOrganism($this)
                ->count($con);
        }

        return count($this->collOrganismprops);
    }

    /**
     * Method called to associate a Organismprop object to this object
     * through the Organismprop foreign key attribute.
     *
     * @param    Organismprop $l Organismprop
     * @return Organism The current object (for fluent API support)
     */
    public function addOrganismprop(Organismprop $l)
    {
        if ($this->collOrganismprops === null) {
            $this->initOrganismprops();
            $this->collOrganismpropsPartial = true;
        }
        if (!in_array($l, $this->collOrganismprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddOrganismprop($l);
        }

        return $this;
    }

    /**
     * @param	Organismprop $organismprop The organismprop object to add.
     */
    protected function doAddOrganismprop($organismprop)
    {
        $this->collOrganismprops[]= $organismprop;
        $organismprop->setOrganism($this);
    }

    /**
     * @param	Organismprop $organismprop The organismprop object to remove.
     * @return Organism The current object (for fluent API support)
     */
    public function removeOrganismprop($organismprop)
    {
        if ($this->getOrganismprops()->contains($organismprop)) {
            $this->collOrganismprops->remove($this->collOrganismprops->search($organismprop));
            if (null === $this->organismpropsScheduledForDeletion) {
                $this->organismpropsScheduledForDeletion = clone $this->collOrganismprops;
                $this->organismpropsScheduledForDeletion->clear();
            }
            $this->organismpropsScheduledForDeletion[]= clone $organismprop;
            $organismprop->setOrganism(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Organism is new, it will return
     * an empty collection; or if this Organism has previously
     * been saved, it will retrieve related Organismprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Organism.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Organismprop[] List of Organismprop objects
     */
    public function getOrganismpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = OrganismpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getOrganismprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->organism_id = null;
        $this->abbreviation = null;
        $this->genus = null;
        $this->species = null;
        $this->common_name = null;
        $this->comment = null;
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
            if ($this->collBiomaterials) {
                foreach ($this->collBiomaterials as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatures) {
                foreach ($this->collFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrganismDbxrefs) {
                foreach ($this->collOrganismDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrganismprops) {
                foreach ($this->collOrganismprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collBiomaterials instanceof PropelCollection) {
            $this->collBiomaterials->clearIterator();
        }
        $this->collBiomaterials = null;
        if ($this->collFeatures instanceof PropelCollection) {
            $this->collFeatures->clearIterator();
        }
        $this->collFeatures = null;
        if ($this->collOrganismDbxrefs instanceof PropelCollection) {
            $this->collOrganismDbxrefs->clearIterator();
        }
        $this->collOrganismDbxrefs = null;
        if ($this->collOrganismprops instanceof PropelCollection) {
            $this->collOrganismprops->clearIterator();
        }
        $this->collOrganismprops = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(OrganismPeer::DEFAULT_STRING_FORMAT);
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
