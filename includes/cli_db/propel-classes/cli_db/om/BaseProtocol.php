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
use cli_db\propel\Acquisition;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\Arraydesign;
use cli_db\propel\ArraydesignQuery;
use cli_db\propel\Assay;
use cli_db\propel\AssayQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolPeer;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Protocolparam;
use cli_db\propel\ProtocolparamQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationQuery;
use cli_db\propel\Treatment;
use cli_db\propel\TreatmentQuery;

/**
 * Base class that represents a row from the 'protocol' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProtocol extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ProtocolPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ProtocolPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

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
     * The value for the uri field.
     * @var        string
     */
    protected $uri;

    /**
     * The value for the protocoldescription field.
     * @var        string
     */
    protected $protocoldescription;

    /**
     * The value for the hardwaredescription field.
     * @var        string
     */
    protected $hardwaredescription;

    /**
     * The value for the softwaredescription field.
     * @var        string
     */
    protected $softwaredescription;

    /**
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        Pub
     */
    protected $aPub;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|Acquisition[] Collection to store aggregation of Acquisition objects.
     */
    protected $collAcquisitions;
    protected $collAcquisitionsPartial;

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
     * @var        PropelObjectCollection|Protocolparam[] Collection to store aggregation of Protocolparam objects.
     */
    protected $collProtocolparams;
    protected $collProtocolparamsPartial;

    /**
     * @var        PropelObjectCollection|Quantification[] Collection to store aggregation of Quantification objects.
     */
    protected $collQuantifications;
    protected $collQuantificationsPartial;

    /**
     * @var        PropelObjectCollection|Treatment[] Collection to store aggregation of Treatment objects.
     */
    protected $collTreatments;
    protected $collTreatmentsPartial;

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
    protected $acquisitionsScheduledForDeletion = null;

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
    protected $protocolparamsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $quantificationsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $treatmentsScheduledForDeletion = null;

    /**
     * Get the [protocol_id] column value.
     *
     * @return int
     */
    public function getProtocolId()
    {
        return $this->protocol_id;
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
     * Get the [uri] column value.
     *
     * @return string
     */
    public function getUri()
    {
        return $this->uri;
    }

    /**
     * Get the [protocoldescription] column value.
     *
     * @return string
     */
    public function getProtocoldescription()
    {
        return $this->protocoldescription;
    }

    /**
     * Get the [hardwaredescription] column value.
     *
     * @return string
     */
    public function getHardwaredescription()
    {
        return $this->hardwaredescription;
    }

    /**
     * Get the [softwaredescription] column value.
     *
     * @return string
     */
    public function getSoftwaredescription()
    {
        return $this->softwaredescription;
    }

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = ProtocolPeer::PROTOCOL_ID;
        }


        return $this;
    } // setProtocolId()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = ProtocolPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = ProtocolPeer::PUB_ID;
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
     * @return Protocol The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = ProtocolPeer::DBXREF_ID;
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
     * @return Protocol The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ProtocolPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [uri] column.
     *
     * @param string $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setUri($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->uri !== $v) {
            $this->uri = $v;
            $this->modifiedColumns[] = ProtocolPeer::URI;
        }


        return $this;
    } // setUri()

    /**
     * Set the value of [protocoldescription] column.
     *
     * @param string $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setProtocoldescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->protocoldescription !== $v) {
            $this->protocoldescription = $v;
            $this->modifiedColumns[] = ProtocolPeer::PROTOCOLDESCRIPTION;
        }


        return $this;
    } // setProtocoldescription()

    /**
     * Set the value of [hardwaredescription] column.
     *
     * @param string $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setHardwaredescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->hardwaredescription !== $v) {
            $this->hardwaredescription = $v;
            $this->modifiedColumns[] = ProtocolPeer::HARDWAREDESCRIPTION;
        }


        return $this;
    } // setHardwaredescription()

    /**
     * Set the value of [softwaredescription] column.
     *
     * @param string $v new value
     * @return Protocol The current object (for fluent API support)
     */
    public function setSoftwaredescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->softwaredescription !== $v) {
            $this->softwaredescription = $v;
            $this->modifiedColumns[] = ProtocolPeer::SOFTWAREDESCRIPTION;
        }


        return $this;
    } // setSoftwaredescription()

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

            $this->protocol_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->type_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->pub_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->dbxref_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->uri = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->protocoldescription = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->hardwaredescription = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->softwaredescription = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 9; // 9 = ProtocolPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Protocol object", $e);
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
            $con = Propel::getConnection(ProtocolPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ProtocolPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDbxref = null;
            $this->aPub = null;
            $this->aCvterm = null;
            $this->collAcquisitions = null;

            $this->collArraydesigns = null;

            $this->collAssays = null;

            $this->collProtocolparams = null;

            $this->collQuantifications = null;

            $this->collTreatments = null;

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
            $con = Propel::getConnection(ProtocolPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ProtocolQuery::create()
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
            $con = Propel::getConnection(ProtocolPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ProtocolPeer::addInstanceToPool($this);
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

            if ($this->acquisitionsScheduledForDeletion !== null) {
                if (!$this->acquisitionsScheduledForDeletion->isEmpty()) {
                    foreach ($this->acquisitionsScheduledForDeletion as $acquisition) {
                        // need to save related object because we set the relation to null
                        $acquisition->save($con);
                    }
                    $this->acquisitionsScheduledForDeletion = null;
                }
            }

            if ($this->collAcquisitions !== null) {
                foreach ($this->collAcquisitions as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->arraydesignsScheduledForDeletion !== null) {
                if (!$this->arraydesignsScheduledForDeletion->isEmpty()) {
                    foreach ($this->arraydesignsScheduledForDeletion as $arraydesign) {
                        // need to save related object because we set the relation to null
                        $arraydesign->save($con);
                    }
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
                    foreach ($this->assaysScheduledForDeletion as $assay) {
                        // need to save related object because we set the relation to null
                        $assay->save($con);
                    }
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

            if ($this->protocolparamsScheduledForDeletion !== null) {
                if (!$this->protocolparamsScheduledForDeletion->isEmpty()) {
                    ProtocolparamQuery::create()
                        ->filterByPrimaryKeys($this->protocolparamsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->protocolparamsScheduledForDeletion = null;
                }
            }

            if ($this->collProtocolparams !== null) {
                foreach ($this->collProtocolparams as $referrerFK) {
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

            if ($this->treatmentsScheduledForDeletion !== null) {
                if (!$this->treatmentsScheduledForDeletion->isEmpty()) {
                    foreach ($this->treatmentsScheduledForDeletion as $treatment) {
                        // need to save related object because we set the relation to null
                        $treatment->save($con);
                    }
                    $this->treatmentsScheduledForDeletion = null;
                }
            }

            if ($this->collTreatments !== null) {
                foreach ($this->collTreatments as $referrerFK) {
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

        $this->modifiedColumns[] = ProtocolPeer::PROTOCOL_ID;
        if (null !== $this->protocol_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ProtocolPeer::PROTOCOL_ID . ')');
        }
        if (null === $this->protocol_id) {
            try {
                $stmt = $con->query("SELECT nextval('protocol_protocol_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->protocol_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ProtocolPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(ProtocolPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(ProtocolPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }
        if ($this->isColumnModified(ProtocolPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(ProtocolPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ProtocolPeer::URI)) {
            $modifiedColumns[':p' . $index++]  = '"uri"';
        }
        if ($this->isColumnModified(ProtocolPeer::PROTOCOLDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"protocoldescription"';
        }
        if ($this->isColumnModified(ProtocolPeer::HARDWAREDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"hardwaredescription"';
        }
        if ($this->isColumnModified(ProtocolPeer::SOFTWAREDESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"softwaredescription"';
        }

        $sql = sprintf(
            'INSERT INTO "protocol" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
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
                    case '"uri"':
                        $stmt->bindValue($identifier, $this->uri, PDO::PARAM_STR);
                        break;
                    case '"protocoldescription"':
                        $stmt->bindValue($identifier, $this->protocoldescription, PDO::PARAM_STR);
                        break;
                    case '"hardwaredescription"':
                        $stmt->bindValue($identifier, $this->hardwaredescription, PDO::PARAM_STR);
                        break;
                    case '"softwaredescription"':
                        $stmt->bindValue($identifier, $this->softwaredescription, PDO::PARAM_STR);
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

            if ($this->aCvterm !== null) {
                if (!$this->aCvterm->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvterm->getValidationFailures());
                }
            }


            if (($retval = ProtocolPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collAcquisitions !== null) {
                    foreach ($this->collAcquisitions as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
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

                if ($this->collProtocolparams !== null) {
                    foreach ($this->collProtocolparams as $referrerFK) {
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

                if ($this->collTreatments !== null) {
                    foreach ($this->collTreatments as $referrerFK) {
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
        $pos = ProtocolPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getProtocolId();
                break;
            case 1:
                return $this->getTypeId();
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
                return $this->getUri();
                break;
            case 6:
                return $this->getProtocoldescription();
                break;
            case 7:
                return $this->getHardwaredescription();
                break;
            case 8:
                return $this->getSoftwaredescription();
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
        if (isset($alreadyDumpedObjects['Protocol'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Protocol'][$this->getPrimaryKey()] = true;
        $keys = ProtocolPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getProtocolId(),
            $keys[1] => $this->getTypeId(),
            $keys[2] => $this->getPubId(),
            $keys[3] => $this->getDbxrefId(),
            $keys[4] => $this->getName(),
            $keys[5] => $this->getUri(),
            $keys[6] => $this->getProtocoldescription(),
            $keys[7] => $this->getHardwaredescription(),
            $keys[8] => $this->getSoftwaredescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aPub) {
                $result['Pub'] = $this->aPub->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collAcquisitions) {
                $result['Acquisitions'] = $this->collAcquisitions->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collArraydesigns) {
                $result['Arraydesigns'] = $this->collArraydesigns->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssays) {
                $result['Assays'] = $this->collAssays->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocolparams) {
                $result['Protocolparams'] = $this->collProtocolparams->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collQuantifications) {
                $result['Quantifications'] = $this->collQuantifications->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collTreatments) {
                $result['Treatments'] = $this->collTreatments->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ProtocolPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setProtocolId($value);
                break;
            case 1:
                $this->setTypeId($value);
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
                $this->setUri($value);
                break;
            case 6:
                $this->setProtocoldescription($value);
                break;
            case 7:
                $this->setHardwaredescription($value);
                break;
            case 8:
                $this->setSoftwaredescription($value);
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
        $keys = ProtocolPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setProtocolId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTypeId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPubId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDbxrefId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setUri($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setProtocoldescription($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setHardwaredescription($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setSoftwaredescription($arr[$keys[8]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ProtocolPeer::DATABASE_NAME);

        if ($this->isColumnModified(ProtocolPeer::PROTOCOL_ID)) $criteria->add(ProtocolPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(ProtocolPeer::TYPE_ID)) $criteria->add(ProtocolPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(ProtocolPeer::PUB_ID)) $criteria->add(ProtocolPeer::PUB_ID, $this->pub_id);
        if ($this->isColumnModified(ProtocolPeer::DBXREF_ID)) $criteria->add(ProtocolPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(ProtocolPeer::NAME)) $criteria->add(ProtocolPeer::NAME, $this->name);
        if ($this->isColumnModified(ProtocolPeer::URI)) $criteria->add(ProtocolPeer::URI, $this->uri);
        if ($this->isColumnModified(ProtocolPeer::PROTOCOLDESCRIPTION)) $criteria->add(ProtocolPeer::PROTOCOLDESCRIPTION, $this->protocoldescription);
        if ($this->isColumnModified(ProtocolPeer::HARDWAREDESCRIPTION)) $criteria->add(ProtocolPeer::HARDWAREDESCRIPTION, $this->hardwaredescription);
        if ($this->isColumnModified(ProtocolPeer::SOFTWAREDESCRIPTION)) $criteria->add(ProtocolPeer::SOFTWAREDESCRIPTION, $this->softwaredescription);

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
        $criteria = new Criteria(ProtocolPeer::DATABASE_NAME);
        $criteria->add(ProtocolPeer::PROTOCOL_ID, $this->protocol_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getProtocolId();
    }

    /**
     * Generic method to set the primary key (protocol_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setProtocolId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getProtocolId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Protocol (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setPubId($this->getPubId());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setName($this->getName());
        $copyObj->setUri($this->getUri());
        $copyObj->setProtocoldescription($this->getProtocoldescription());
        $copyObj->setHardwaredescription($this->getHardwaredescription());
        $copyObj->setSoftwaredescription($this->getSoftwaredescription());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getAcquisitions() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAcquisition($relObj->copy($deepCopy));
                }
            }

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

            foreach ($this->getProtocolparams() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocolparam($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getQuantifications() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addQuantification($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getTreatments() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addTreatment($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setProtocolId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Protocol Clone of current object.
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
     * @return ProtocolPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ProtocolPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Protocol The current object (for fluent API support)
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
            $v->addProtocol($this);
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
                $this->aDbxref->addProtocols($this);
             */
        }

        return $this->aDbxref;
    }

    /**
     * Declares an association between this object and a Pub object.
     *
     * @param             Pub $v
     * @return Protocol The current object (for fluent API support)
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
            $v->addProtocol($this);
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
                $this->aPub->addProtocols($this);
             */
        }

        return $this->aPub;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Protocol The current object (for fluent API support)
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
            $v->addProtocol($this);
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
                $this->aCvterm->addProtocols($this);
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
        if ('Acquisition' == $relationName) {
            $this->initAcquisitions();
        }
        if ('Arraydesign' == $relationName) {
            $this->initArraydesigns();
        }
        if ('Assay' == $relationName) {
            $this->initAssays();
        }
        if ('Protocolparam' == $relationName) {
            $this->initProtocolparams();
        }
        if ('Quantification' == $relationName) {
            $this->initQuantifications();
        }
        if ('Treatment' == $relationName) {
            $this->initTreatments();
        }
    }

    /**
     * Clears out the collAcquisitions collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Protocol The current object (for fluent API support)
     * @see        addAcquisitions()
     */
    public function clearAcquisitions()
    {
        $this->collAcquisitions = null; // important to set this to null since that means it is uninitialized
        $this->collAcquisitionsPartial = null;

        return $this;
    }

    /**
     * reset is the collAcquisitions collection loaded partially
     *
     * @return void
     */
    public function resetPartialAcquisitions($v = true)
    {
        $this->collAcquisitionsPartial = $v;
    }

    /**
     * Initializes the collAcquisitions collection.
     *
     * By default this just sets the collAcquisitions collection to an empty array (like clearcollAcquisitions());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initAcquisitions($overrideExisting = true)
    {
        if (null !== $this->collAcquisitions && !$overrideExisting) {
            return;
        }
        $this->collAcquisitions = new PropelObjectCollection();
        $this->collAcquisitions->setModel('Acquisition');
    }

    /**
     * Gets an array of Acquisition objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Protocol is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     * @throws PropelException
     */
    public function getAcquisitions($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionsPartial && !$this->isNew();
        if (null === $this->collAcquisitions || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collAcquisitions) {
                // return empty collection
                $this->initAcquisitions();
            } else {
                $collAcquisitions = AcquisitionQuery::create(null, $criteria)
                    ->filterByProtocol($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collAcquisitionsPartial && count($collAcquisitions)) {
                      $this->initAcquisitions(false);

                      foreach($collAcquisitions as $obj) {
                        if (false == $this->collAcquisitions->contains($obj)) {
                          $this->collAcquisitions->append($obj);
                        }
                      }

                      $this->collAcquisitionsPartial = true;
                    }

                    $collAcquisitions->getInternalIterator()->rewind();
                    return $collAcquisitions;
                }

                if($partial && $this->collAcquisitions) {
                    foreach($this->collAcquisitions as $obj) {
                        if($obj->isNew()) {
                            $collAcquisitions[] = $obj;
                        }
                    }
                }

                $this->collAcquisitions = $collAcquisitions;
                $this->collAcquisitionsPartial = false;
            }
        }

        return $this->collAcquisitions;
    }

    /**
     * Sets a collection of Acquisition objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $acquisitions A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Protocol The current object (for fluent API support)
     */
    public function setAcquisitions(PropelCollection $acquisitions, PropelPDO $con = null)
    {
        $acquisitionsToDelete = $this->getAcquisitions(new Criteria(), $con)->diff($acquisitions);

        $this->acquisitionsScheduledForDeletion = unserialize(serialize($acquisitionsToDelete));

        foreach ($acquisitionsToDelete as $acquisitionRemoved) {
            $acquisitionRemoved->setProtocol(null);
        }

        $this->collAcquisitions = null;
        foreach ($acquisitions as $acquisition) {
            $this->addAcquisition($acquisition);
        }

        $this->collAcquisitions = $acquisitions;
        $this->collAcquisitionsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Acquisition objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Acquisition objects.
     * @throws PropelException
     */
    public function countAcquisitions(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collAcquisitionsPartial && !$this->isNew();
        if (null === $this->collAcquisitions || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collAcquisitions) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getAcquisitions());
            }
            $query = AcquisitionQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collAcquisitions);
    }

    /**
     * Method called to associate a Acquisition object to this object
     * through the Acquisition foreign key attribute.
     *
     * @param    Acquisition $l Acquisition
     * @return Protocol The current object (for fluent API support)
     */
    public function addAcquisition(Acquisition $l)
    {
        if ($this->collAcquisitions === null) {
            $this->initAcquisitions();
            $this->collAcquisitionsPartial = true;
        }
        if (!in_array($l, $this->collAcquisitions->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddAcquisition($l);
        }

        return $this;
    }

    /**
     * @param	Acquisition $acquisition The acquisition object to add.
     */
    protected function doAddAcquisition($acquisition)
    {
        $this->collAcquisitions[]= $acquisition;
        $acquisition->setProtocol($this);
    }

    /**
     * @param	Acquisition $acquisition The acquisition object to remove.
     * @return Protocol The current object (for fluent API support)
     */
    public function removeAcquisition($acquisition)
    {
        if ($this->getAcquisitions()->contains($acquisition)) {
            $this->collAcquisitions->remove($this->collAcquisitions->search($acquisition));
            if (null === $this->acquisitionsScheduledForDeletion) {
                $this->acquisitionsScheduledForDeletion = clone $this->collAcquisitions;
                $this->acquisitionsScheduledForDeletion->clear();
            }
            $this->acquisitionsScheduledForDeletion[]= $acquisition;
            $acquisition->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Acquisitions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     */
    public function getAcquisitionsJoinAssay($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionQuery::create(null, $criteria);
        $query->joinWith('Assay', $join_behavior);

        return $this->getAcquisitions($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Acquisitions from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Acquisition[] List of Acquisition objects
     */
    public function getAcquisitionsJoinChannel($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AcquisitionQuery::create(null, $criteria);
        $query->joinWith('Channel', $join_behavior);

        return $this->getAcquisitions($query, $con);
    }

    /**
     * Clears out the collArraydesigns collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Protocol The current object (for fluent API support)
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
     * If this Protocol is new, it will return
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
                    ->filterByProtocol($this)
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
     * @return Protocol The current object (for fluent API support)
     */
    public function setArraydesigns(PropelCollection $arraydesigns, PropelPDO $con = null)
    {
        $arraydesignsToDelete = $this->getArraydesigns(new Criteria(), $con)->diff($arraydesigns);

        $this->arraydesignsScheduledForDeletion = unserialize(serialize($arraydesignsToDelete));

        foreach ($arraydesignsToDelete as $arraydesignRemoved) {
            $arraydesignRemoved->setProtocol(null);
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
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collArraydesigns);
    }

    /**
     * Method called to associate a Arraydesign object to this object
     * through the Arraydesign foreign key attribute.
     *
     * @param    Arraydesign $l Arraydesign
     * @return Protocol The current object (for fluent API support)
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
        $arraydesign->setProtocol($this);
    }

    /**
     * @param	Arraydesign $arraydesign The arraydesign object to remove.
     * @return Protocol The current object (for fluent API support)
     */
    public function removeArraydesign($arraydesign)
    {
        if ($this->getArraydesigns()->contains($arraydesign)) {
            $this->collArraydesigns->remove($this->collArraydesigns->search($arraydesign));
            if (null === $this->arraydesignsScheduledForDeletion) {
                $this->arraydesignsScheduledForDeletion = clone $this->collArraydesigns;
                $this->arraydesignsScheduledForDeletion->clear();
            }
            $this->arraydesignsScheduledForDeletion[]= $arraydesign;
            $arraydesign->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesign[] List of Arraydesign objects
     */
    public function getArraydesignsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getArraydesigns($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * @return Protocol The current object (for fluent API support)
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
     * If this Protocol is new, it will return
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
                    ->filterByProtocol($this)
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
     * @return Protocol The current object (for fluent API support)
     */
    public function setAssays(PropelCollection $assays, PropelPDO $con = null)
    {
        $assaysToDelete = $this->getAssays(new Criteria(), $con)->diff($assays);

        $this->assaysScheduledForDeletion = unserialize(serialize($assaysToDelete));

        foreach ($assaysToDelete as $assayRemoved) {
            $assayRemoved->setProtocol(null);
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
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collAssays);
    }

    /**
     * Method called to associate a Assay object to this object
     * through the Assay foreign key attribute.
     *
     * @param    Assay $l Assay
     * @return Protocol The current object (for fluent API support)
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
        $assay->setProtocol($this);
    }

    /**
     * @param	Assay $assay The assay object to remove.
     * @return Protocol The current object (for fluent API support)
     */
    public function removeAssay($assay)
    {
        if ($this->getAssays()->contains($assay)) {
            $this->collAssays->remove($this->collAssays->search($assay));
            if (null === $this->assaysScheduledForDeletion) {
                $this->assaysScheduledForDeletion = clone $this->collAssays;
                $this->assaysScheduledForDeletion->clear();
            }
            $this->assaysScheduledForDeletion[]= $assay;
            $assay->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Assay[] List of Assay objects
     */
    public function getAssaysJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = AssayQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getAssays($query, $con);
    }

    /**
     * Clears out the collProtocolparams collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Protocol The current object (for fluent API support)
     * @see        addProtocolparams()
     */
    public function clearProtocolparams()
    {
        $this->collProtocolparams = null; // important to set this to null since that means it is uninitialized
        $this->collProtocolparamsPartial = null;

        return $this;
    }

    /**
     * reset is the collProtocolparams collection loaded partially
     *
     * @return void
     */
    public function resetPartialProtocolparams($v = true)
    {
        $this->collProtocolparamsPartial = $v;
    }

    /**
     * Initializes the collProtocolparams collection.
     *
     * By default this just sets the collProtocolparams collection to an empty array (like clearcollProtocolparams());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProtocolparams($overrideExisting = true)
    {
        if (null !== $this->collProtocolparams && !$overrideExisting) {
            return;
        }
        $this->collProtocolparams = new PropelObjectCollection();
        $this->collProtocolparams->setModel('Protocolparam');
    }

    /**
     * Gets an array of Protocolparam objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Protocol is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     * @throws PropelException
     */
    public function getProtocolparams($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsPartial && !$this->isNew();
        if (null === $this->collProtocolparams || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProtocolparams) {
                // return empty collection
                $this->initProtocolparams();
            } else {
                $collProtocolparams = ProtocolparamQuery::create(null, $criteria)
                    ->filterByProtocol($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProtocolparamsPartial && count($collProtocolparams)) {
                      $this->initProtocolparams(false);

                      foreach($collProtocolparams as $obj) {
                        if (false == $this->collProtocolparams->contains($obj)) {
                          $this->collProtocolparams->append($obj);
                        }
                      }

                      $this->collProtocolparamsPartial = true;
                    }

                    $collProtocolparams->getInternalIterator()->rewind();
                    return $collProtocolparams;
                }

                if($partial && $this->collProtocolparams) {
                    foreach($this->collProtocolparams as $obj) {
                        if($obj->isNew()) {
                            $collProtocolparams[] = $obj;
                        }
                    }
                }

                $this->collProtocolparams = $collProtocolparams;
                $this->collProtocolparamsPartial = false;
            }
        }

        return $this->collProtocolparams;
    }

    /**
     * Sets a collection of Protocolparam objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $protocolparams A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Protocol The current object (for fluent API support)
     */
    public function setProtocolparams(PropelCollection $protocolparams, PropelPDO $con = null)
    {
        $protocolparamsToDelete = $this->getProtocolparams(new Criteria(), $con)->diff($protocolparams);

        $this->protocolparamsScheduledForDeletion = unserialize(serialize($protocolparamsToDelete));

        foreach ($protocolparamsToDelete as $protocolparamRemoved) {
            $protocolparamRemoved->setProtocol(null);
        }

        $this->collProtocolparams = null;
        foreach ($protocolparams as $protocolparam) {
            $this->addProtocolparam($protocolparam);
        }

        $this->collProtocolparams = $protocolparams;
        $this->collProtocolparamsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Protocolparam objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Protocolparam objects.
     * @throws PropelException
     */
    public function countProtocolparams(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProtocolparamsPartial && !$this->isNew();
        if (null === $this->collProtocolparams || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProtocolparams) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProtocolparams());
            }
            $query = ProtocolparamQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collProtocolparams);
    }

    /**
     * Method called to associate a Protocolparam object to this object
     * through the Protocolparam foreign key attribute.
     *
     * @param    Protocolparam $l Protocolparam
     * @return Protocol The current object (for fluent API support)
     */
    public function addProtocolparam(Protocolparam $l)
    {
        if ($this->collProtocolparams === null) {
            $this->initProtocolparams();
            $this->collProtocolparamsPartial = true;
        }
        if (!in_array($l, $this->collProtocolparams->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProtocolparam($l);
        }

        return $this;
    }

    /**
     * @param	Protocolparam $protocolparam The protocolparam object to add.
     */
    protected function doAddProtocolparam($protocolparam)
    {
        $this->collProtocolparams[]= $protocolparam;
        $protocolparam->setProtocol($this);
    }

    /**
     * @param	Protocolparam $protocolparam The protocolparam object to remove.
     * @return Protocol The current object (for fluent API support)
     */
    public function removeProtocolparam($protocolparam)
    {
        if ($this->getProtocolparams()->contains($protocolparam)) {
            $this->collProtocolparams->remove($this->collProtocolparams->search($protocolparam));
            if (null === $this->protocolparamsScheduledForDeletion) {
                $this->protocolparamsScheduledForDeletion = clone $this->collProtocolparams;
                $this->protocolparamsScheduledForDeletion->clear();
            }
            $this->protocolparamsScheduledForDeletion[]= clone $protocolparam;
            $protocolparam->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Protocolparams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     */
    public function getProtocolparamsJoinCvtermRelatedByDatatypeId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolparamQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedByDatatypeId', $join_behavior);

        return $this->getProtocolparams($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Protocolparams from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocolparam[] List of Protocolparam objects
     */
    public function getProtocolparamsJoinCvtermRelatedByUnittypeId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolparamQuery::create(null, $criteria);
        $query->joinWith('CvtermRelatedByUnittypeId', $join_behavior);

        return $this->getProtocolparams($query, $con);
    }

    /**
     * Clears out the collQuantifications collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Protocol The current object (for fluent API support)
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
     * If this Protocol is new, it will return
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
                    ->filterByProtocol($this)
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
     * @return Protocol The current object (for fluent API support)
     */
    public function setQuantifications(PropelCollection $quantifications, PropelPDO $con = null)
    {
        $quantificationsToDelete = $this->getQuantifications(new Criteria(), $con)->diff($quantifications);

        $this->quantificationsScheduledForDeletion = unserialize(serialize($quantificationsToDelete));

        foreach ($quantificationsToDelete as $quantificationRemoved) {
            $quantificationRemoved->setProtocol(null);
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
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collQuantifications);
    }

    /**
     * Method called to associate a Quantification object to this object
     * through the Quantification foreign key attribute.
     *
     * @param    Quantification $l Quantification
     * @return Protocol The current object (for fluent API support)
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
        $quantification->setProtocol($this);
    }

    /**
     * @param	Quantification $quantification The quantification object to remove.
     * @return Protocol The current object (for fluent API support)
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
            $quantification->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
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
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Quantifications from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Quantification[] List of Quantification objects
     */
    public function getQuantificationsJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = QuantificationQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getQuantifications($query, $con);
    }

    /**
     * Clears out the collTreatments collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Protocol The current object (for fluent API support)
     * @see        addTreatments()
     */
    public function clearTreatments()
    {
        $this->collTreatments = null; // important to set this to null since that means it is uninitialized
        $this->collTreatmentsPartial = null;

        return $this;
    }

    /**
     * reset is the collTreatments collection loaded partially
     *
     * @return void
     */
    public function resetPartialTreatments($v = true)
    {
        $this->collTreatmentsPartial = $v;
    }

    /**
     * Initializes the collTreatments collection.
     *
     * By default this just sets the collTreatments collection to an empty array (like clearcollTreatments());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initTreatments($overrideExisting = true)
    {
        if (null !== $this->collTreatments && !$overrideExisting) {
            return;
        }
        $this->collTreatments = new PropelObjectCollection();
        $this->collTreatments->setModel('Treatment');
    }

    /**
     * Gets an array of Treatment objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Protocol is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     * @throws PropelException
     */
    public function getTreatments($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collTreatmentsPartial && !$this->isNew();
        if (null === $this->collTreatments || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collTreatments) {
                // return empty collection
                $this->initTreatments();
            } else {
                $collTreatments = TreatmentQuery::create(null, $criteria)
                    ->filterByProtocol($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collTreatmentsPartial && count($collTreatments)) {
                      $this->initTreatments(false);

                      foreach($collTreatments as $obj) {
                        if (false == $this->collTreatments->contains($obj)) {
                          $this->collTreatments->append($obj);
                        }
                      }

                      $this->collTreatmentsPartial = true;
                    }

                    $collTreatments->getInternalIterator()->rewind();
                    return $collTreatments;
                }

                if($partial && $this->collTreatments) {
                    foreach($this->collTreatments as $obj) {
                        if($obj->isNew()) {
                            $collTreatments[] = $obj;
                        }
                    }
                }

                $this->collTreatments = $collTreatments;
                $this->collTreatmentsPartial = false;
            }
        }

        return $this->collTreatments;
    }

    /**
     * Sets a collection of Treatment objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $treatments A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Protocol The current object (for fluent API support)
     */
    public function setTreatments(PropelCollection $treatments, PropelPDO $con = null)
    {
        $treatmentsToDelete = $this->getTreatments(new Criteria(), $con)->diff($treatments);

        $this->treatmentsScheduledForDeletion = unserialize(serialize($treatmentsToDelete));

        foreach ($treatmentsToDelete as $treatmentRemoved) {
            $treatmentRemoved->setProtocol(null);
        }

        $this->collTreatments = null;
        foreach ($treatments as $treatment) {
            $this->addTreatment($treatment);
        }

        $this->collTreatments = $treatments;
        $this->collTreatmentsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Treatment objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Treatment objects.
     * @throws PropelException
     */
    public function countTreatments(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collTreatmentsPartial && !$this->isNew();
        if (null === $this->collTreatments || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collTreatments) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getTreatments());
            }
            $query = TreatmentQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByProtocol($this)
                ->count($con);
        }

        return count($this->collTreatments);
    }

    /**
     * Method called to associate a Treatment object to this object
     * through the Treatment foreign key attribute.
     *
     * @param    Treatment $l Treatment
     * @return Protocol The current object (for fluent API support)
     */
    public function addTreatment(Treatment $l)
    {
        if ($this->collTreatments === null) {
            $this->initTreatments();
            $this->collTreatmentsPartial = true;
        }
        if (!in_array($l, $this->collTreatments->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddTreatment($l);
        }

        return $this;
    }

    /**
     * @param	Treatment $treatment The treatment object to add.
     */
    protected function doAddTreatment($treatment)
    {
        $this->collTreatments[]= $treatment;
        $treatment->setProtocol($this);
    }

    /**
     * @param	Treatment $treatment The treatment object to remove.
     * @return Protocol The current object (for fluent API support)
     */
    public function removeTreatment($treatment)
    {
        if ($this->getTreatments()->contains($treatment)) {
            $this->collTreatments->remove($this->collTreatments->search($treatment));
            if (null === $this->treatmentsScheduledForDeletion) {
                $this->treatmentsScheduledForDeletion = clone $this->collTreatments;
                $this->treatmentsScheduledForDeletion->clear();
            }
            $this->treatmentsScheduledForDeletion[]= $treatment;
            $treatment->setProtocol(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Treatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     */
    public function getTreatmentsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TreatmentQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getTreatments($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Protocol is new, it will return
     * an empty collection; or if this Protocol has previously
     * been saved, it will retrieve related Treatments from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Protocol.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Treatment[] List of Treatment objects
     */
    public function getTreatmentsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = TreatmentQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getTreatments($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->protocol_id = null;
        $this->type_id = null;
        $this->pub_id = null;
        $this->dbxref_id = null;
        $this->name = null;
        $this->uri = null;
        $this->protocoldescription = null;
        $this->hardwaredescription = null;
        $this->softwaredescription = null;
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
            if ($this->collAcquisitions) {
                foreach ($this->collAcquisitions as $o) {
                    $o->clearAllReferences($deep);
                }
            }
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
            if ($this->collProtocolparams) {
                foreach ($this->collProtocolparams as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collQuantifications) {
                foreach ($this->collQuantifications as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collTreatments) {
                foreach ($this->collTreatments as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }
            if ($this->aPub instanceof Persistent) {
              $this->aPub->clearAllReferences($deep);
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collAcquisitions instanceof PropelCollection) {
            $this->collAcquisitions->clearIterator();
        }
        $this->collAcquisitions = null;
        if ($this->collArraydesigns instanceof PropelCollection) {
            $this->collArraydesigns->clearIterator();
        }
        $this->collArraydesigns = null;
        if ($this->collAssays instanceof PropelCollection) {
            $this->collAssays->clearIterator();
        }
        $this->collAssays = null;
        if ($this->collProtocolparams instanceof PropelCollection) {
            $this->collProtocolparams->clearIterator();
        }
        $this->collProtocolparams = null;
        if ($this->collQuantifications instanceof PropelCollection) {
            $this->collQuantifications->clearIterator();
        }
        $this->collQuantifications = null;
        if ($this->collTreatments instanceof PropelCollection) {
            $this->collTreatments->clearIterator();
        }
        $this->collTreatments = null;
        $this->aDbxref = null;
        $this->aPub = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ProtocolPeer::DEFAULT_STRING_FORMAT);
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
