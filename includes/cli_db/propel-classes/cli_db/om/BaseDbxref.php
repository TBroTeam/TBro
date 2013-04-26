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
use cli_db\propel\BiomaterialDbxref;
use cli_db\propel\BiomaterialDbxrefQuery;
use cli_db\propel\BiomaterialQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermDbxref;
use cli_db\propel\CvtermDbxrefQuery;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Db;
use cli_db\propel\DbQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Dbxrefprop;
use cli_db\propel\DbxrefpropQuery;
use cli_db\propel\Element;
use cli_db\propel\ElementQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureCvtermDbxrefQuery;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\FeatureDbxrefQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\OrganismDbxref;
use cli_db\propel\OrganismDbxrefQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\PubDbxref;
use cli_db\propel\PubDbxrefQuery;
use cli_db\propel\Study;
use cli_db\propel\StudyQuery;

/**
 * Base class that represents a row from the 'dbxref' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseDbxref extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\DbxrefPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        DbxrefPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * The value for the db_id field.
     * @var        int
     */
    protected $db_id;

    /**
     * The value for the accession field.
     * @var        string
     */
    protected $accession;

    /**
     * The value for the version field.
     * Note: this column has a database default value of: ''
     * @var        string
     */
    protected $version;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * @var        Db
     */
    protected $aDb;

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
     * @var        PropelObjectCollection|BiomaterialDbxref[] Collection to store aggregation of BiomaterialDbxref objects.
     */
    protected $collBiomaterialDbxrefs;
    protected $collBiomaterialDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|Cvterm[] Collection to store aggregation of Cvterm objects.
     */
    protected $collCvterms;
    protected $collCvtermsPartial;

    /**
     * @var        PropelObjectCollection|CvtermDbxref[] Collection to store aggregation of CvtermDbxref objects.
     */
    protected $collCvtermDbxrefs;
    protected $collCvtermDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|Dbxrefprop[] Collection to store aggregation of Dbxrefprop objects.
     */
    protected $collDbxrefprops;
    protected $collDbxrefpropsPartial;

    /**
     * @var        PropelObjectCollection|Element[] Collection to store aggregation of Element objects.
     */
    protected $collElements;
    protected $collElementsPartial;

    /**
     * @var        PropelObjectCollection|Feature[] Collection to store aggregation of Feature objects.
     */
    protected $collFeatures;
    protected $collFeaturesPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermDbxref[] Collection to store aggregation of FeatureCvtermDbxref objects.
     */
    protected $collFeatureCvtermDbxrefs;
    protected $collFeatureCvtermDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|FeatureDbxref[] Collection to store aggregation of FeatureDbxref objects.
     */
    protected $collFeatureDbxrefs;
    protected $collFeatureDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|OrganismDbxref[] Collection to store aggregation of OrganismDbxref objects.
     */
    protected $collOrganismDbxrefs;
    protected $collOrganismDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|Protocol[] Collection to store aggregation of Protocol objects.
     */
    protected $collProtocols;
    protected $collProtocolsPartial;

    /**
     * @var        PropelObjectCollection|PubDbxref[] Collection to store aggregation of PubDbxref objects.
     */
    protected $collPubDbxrefs;
    protected $collPubDbxrefsPartial;

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
    protected $biomaterialDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $cvtermDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $dbxrefpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $organismDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $protocolsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $studysScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->version = '';
    }

    /**
     * Initializes internal state of BaseDbxref object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [db_id] column value.
     *
     * @return int
     */
    public function getDbId()
    {
        return $this->db_id;
    }

    /**
     * Get the [accession] column value.
     *
     * @return string
     */
    public function getAccession()
    {
        return $this->accession;
    }

    /**
     * Get the [version] column value.
     *
     * @return string
     */
    public function getVersion()
    {
        return $this->version;
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
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = DbxrefPeer::DBXREF_ID;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [db_id] column.
     *
     * @param int $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDbId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->db_id !== $v) {
            $this->db_id = $v;
            $this->modifiedColumns[] = DbxrefPeer::DB_ID;
        }

        if ($this->aDb !== null && $this->aDb->getDbId() !== $v) {
            $this->aDb = null;
        }


        return $this;
    } // setDbId()

    /**
     * Set the value of [accession] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setAccession($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->accession !== $v) {
            $this->accession = $v;
            $this->modifiedColumns[] = DbxrefPeer::ACCESSION;
        }


        return $this;
    } // setAccession()

    /**
     * Set the value of [version] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[] = DbxrefPeer::VERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = DbxrefPeer::DESCRIPTION;
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
            if ($this->version !== '') {
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

            $this->dbxref_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->db_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->accession = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->version = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->description = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 5; // 5 = DbxrefPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Dbxref object", $e);
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

        if ($this->aDb !== null && $this->db_id !== $this->aDb->getDbId()) {
            $this->aDb = null;
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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = DbxrefPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDb = null;
            $this->collArraydesigns = null;

            $this->collAssays = null;

            $this->collBiomaterials = null;

            $this->collBiomaterialDbxrefs = null;

            $this->collCvterms = null;

            $this->collCvtermDbxrefs = null;

            $this->collDbxrefprops = null;

            $this->collElements = null;

            $this->collFeatures = null;

            $this->collFeatureCvtermDbxrefs = null;

            $this->collFeatureDbxrefs = null;

            $this->collOrganismDbxrefs = null;

            $this->collProtocols = null;

            $this->collPubDbxrefs = null;

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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = DbxrefQuery::create()
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
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                DbxrefPeer::addInstanceToPool($this);
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

            if ($this->aDb !== null) {
                if ($this->aDb->isModified() || $this->aDb->isNew()) {
                    $affectedRows += $this->aDb->save($con);
                }
                $this->setDb($this->aDb);
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

            if ($this->biomaterialDbxrefsScheduledForDeletion !== null) {
                if (!$this->biomaterialDbxrefsScheduledForDeletion->isEmpty()) {
                    BiomaterialDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialDbxrefs !== null) {
                foreach ($this->collBiomaterialDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermsScheduledForDeletion !== null) {
                if (!$this->cvtermsScheduledForDeletion->isEmpty()) {
                    CvtermQuery::create()
                        ->filterByPrimaryKeys($this->cvtermsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermsScheduledForDeletion = null;
                }
            }

            if ($this->collCvterms !== null) {
                foreach ($this->collCvterms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->cvtermDbxrefsScheduledForDeletion !== null) {
                if (!$this->cvtermDbxrefsScheduledForDeletion->isEmpty()) {
                    CvtermDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->cvtermDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->cvtermDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collCvtermDbxrefs !== null) {
                foreach ($this->collCvtermDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->dbxrefpropsScheduledForDeletion !== null) {
                if (!$this->dbxrefpropsScheduledForDeletion->isEmpty()) {
                    DbxrefpropQuery::create()
                        ->filterByPrimaryKeys($this->dbxrefpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->dbxrefpropsScheduledForDeletion = null;
                }
            }

            if ($this->collDbxrefprops !== null) {
                foreach ($this->collDbxrefprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->elementsScheduledForDeletion !== null) {
                if (!$this->elementsScheduledForDeletion->isEmpty()) {
                    foreach ($this->elementsScheduledForDeletion as $element) {
                        // need to save related object because we set the relation to null
                        $element->save($con);
                    }
                    $this->elementsScheduledForDeletion = null;
                }
            }

            if ($this->collElements !== null) {
                foreach ($this->collElements as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featuresScheduledForDeletion !== null) {
                if (!$this->featuresScheduledForDeletion->isEmpty()) {
                    foreach ($this->featuresScheduledForDeletion as $feature) {
                        // need to save related object because we set the relation to null
                        $feature->save($con);
                    }
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

            if ($this->featureCvtermDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureCvtermDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermDbxrefs !== null) {
                foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureDbxrefsScheduledForDeletion !== null) {
                if (!$this->featureDbxrefsScheduledForDeletion->isEmpty()) {
                    FeatureDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->featureDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureDbxrefs !== null) {
                foreach ($this->collFeatureDbxrefs as $referrerFK) {
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

            if ($this->protocolsScheduledForDeletion !== null) {
                if (!$this->protocolsScheduledForDeletion->isEmpty()) {
                    foreach ($this->protocolsScheduledForDeletion as $protocol) {
                        // need to save related object because we set the relation to null
                        $protocol->save($con);
                    }
                    $this->protocolsScheduledForDeletion = null;
                }
            }

            if ($this->collProtocols !== null) {
                foreach ($this->collProtocols as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubDbxrefsScheduledForDeletion !== null) {
                if (!$this->pubDbxrefsScheduledForDeletion->isEmpty()) {
                    PubDbxrefQuery::create()
                        ->filterByPrimaryKeys($this->pubDbxrefsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubDbxrefsScheduledForDeletion = null;
                }
            }

            if ($this->collPubDbxrefs !== null) {
                foreach ($this->collPubDbxrefs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->studysScheduledForDeletion !== null) {
                if (!$this->studysScheduledForDeletion->isEmpty()) {
                    foreach ($this->studysScheduledForDeletion as $study) {
                        // need to save related object because we set the relation to null
                        $study->save($con);
                    }
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

        $this->modifiedColumns[] = DbxrefPeer::DBXREF_ID;
        if (null !== $this->dbxref_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . DbxrefPeer::DBXREF_ID . ')');
        }
        if (null === $this->dbxref_id) {
            try {
                $stmt = $con->query("SELECT nextval('dbxref_dbxref_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->dbxref_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(DbxrefPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(DbxrefPeer::DB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"db_id"';
        }
        if ($this->isColumnModified(DbxrefPeer::ACCESSION)) {
            $modifiedColumns[':p' . $index++]  = '"accession"';
        }
        if ($this->isColumnModified(DbxrefPeer::VERSION)) {
            $modifiedColumns[':p' . $index++]  = '"version"';
        }
        if ($this->isColumnModified(DbxrefPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }

        $sql = sprintf(
            'INSERT INTO "dbxref" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"db_id"':
                        $stmt->bindValue($identifier, $this->db_id, PDO::PARAM_INT);
                        break;
                    case '"accession"':
                        $stmt->bindValue($identifier, $this->accession, PDO::PARAM_STR);
                        break;
                    case '"version"':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
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

            if ($this->aDb !== null) {
                if (!$this->aDb->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aDb->getValidationFailures());
                }
            }


            if (($retval = DbxrefPeer::doValidate($this, $columns)) !== true) {
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

                if ($this->collBiomaterialDbxrefs !== null) {
                    foreach ($this->collBiomaterialDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvterms !== null) {
                    foreach ($this->collCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collCvtermDbxrefs !== null) {
                    foreach ($this->collCvtermDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collDbxrefprops !== null) {
                    foreach ($this->collDbxrefprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collElements !== null) {
                    foreach ($this->collElements as $referrerFK) {
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

                if ($this->collFeatureCvtermDbxrefs !== null) {
                    foreach ($this->collFeatureCvtermDbxrefs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureDbxrefs !== null) {
                    foreach ($this->collFeatureDbxrefs as $referrerFK) {
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

                if ($this->collProtocols !== null) {
                    foreach ($this->collProtocols as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubDbxrefs !== null) {
                    foreach ($this->collPubDbxrefs as $referrerFK) {
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
        $pos = DbxrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getDbxrefId();
                break;
            case 1:
                return $this->getDbId();
                break;
            case 2:
                return $this->getAccession();
                break;
            case 3:
                return $this->getVersion();
                break;
            case 4:
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
        if (isset($alreadyDumpedObjects['Dbxref'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Dbxref'][$this->getPrimaryKey()] = true;
        $keys = DbxrefPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getDbxrefId(),
            $keys[1] => $this->getDbId(),
            $keys[2] => $this->getAccession(),
            $keys[3] => $this->getVersion(),
            $keys[4] => $this->getDescription(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aDb) {
                $result['Db'] = $this->aDb->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
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
            if (null !== $this->collBiomaterialDbxrefs) {
                $result['BiomaterialDbxrefs'] = $this->collBiomaterialDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvterms) {
                $result['Cvterms'] = $this->collCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collCvtermDbxrefs) {
                $result['CvtermDbxrefs'] = $this->collCvtermDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collDbxrefprops) {
                $result['Dbxrefprops'] = $this->collDbxrefprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElements) {
                $result['Elements'] = $this->collElements->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatures) {
                $result['Features'] = $this->collFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermDbxrefs) {
                $result['FeatureCvtermDbxrefs'] = $this->collFeatureCvtermDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureDbxrefs) {
                $result['FeatureDbxrefs'] = $this->collFeatureDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collOrganismDbxrefs) {
                $result['OrganismDbxrefs'] = $this->collOrganismDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocols) {
                $result['Protocols'] = $this->collProtocols->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubDbxrefs) {
                $result['PubDbxrefs'] = $this->collPubDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = DbxrefPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setDbxrefId($value);
                break;
            case 1:
                $this->setDbId($value);
                break;
            case 2:
                $this->setAccession($value);
                break;
            case 3:
                $this->setVersion($value);
                break;
            case 4:
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
        $keys = DbxrefPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setDbxrefId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setDbId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setAccession($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVersion($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDescription($arr[$keys[4]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(DbxrefPeer::DATABASE_NAME);

        if ($this->isColumnModified(DbxrefPeer::DBXREF_ID)) $criteria->add(DbxrefPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(DbxrefPeer::DB_ID)) $criteria->add(DbxrefPeer::DB_ID, $this->db_id);
        if ($this->isColumnModified(DbxrefPeer::ACCESSION)) $criteria->add(DbxrefPeer::ACCESSION, $this->accession);
        if ($this->isColumnModified(DbxrefPeer::VERSION)) $criteria->add(DbxrefPeer::VERSION, $this->version);
        if ($this->isColumnModified(DbxrefPeer::DESCRIPTION)) $criteria->add(DbxrefPeer::DESCRIPTION, $this->description);

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
        $criteria = new Criteria(DbxrefPeer::DATABASE_NAME);
        $criteria->add(DbxrefPeer::DBXREF_ID, $this->dbxref_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getDbxrefId();
    }

    /**
     * Generic method to set the primary key (dbxref_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setDbxrefId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getDbxrefId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Dbxref (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setDbId($this->getDbId());
        $copyObj->setAccession($this->getAccession());
        $copyObj->setVersion($this->getVersion());
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

            foreach ($this->getBiomaterialDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getCvtermDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addCvtermDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getDbxrefprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addDbxrefprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElement($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getOrganismDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addOrganismDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProtocols() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocol($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubDbxref($relObj->copy($deepCopy));
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
            $copyObj->setDbxrefId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Dbxref Clone of current object.
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
     * @return DbxrefPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new DbxrefPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Db object.
     *
     * @param             Db $v
     * @return Dbxref The current object (for fluent API support)
     * @throws PropelException
     */
    public function setDb(Db $v = null)
    {
        if ($v === null) {
            $this->setDbId(NULL);
        } else {
            $this->setDbId($v->getDbId());
        }

        $this->aDb = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Db object, it will not be re-added.
        if ($v !== null) {
            $v->addDbxref($this);
        }


        return $this;
    }


    /**
     * Get the associated Db object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Db The associated Db object.
     * @throws PropelException
     */
    public function getDb(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aDb === null && ($this->db_id !== null) && $doQuery) {
            $this->aDb = DbQuery::create()->findPk($this->db_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aDb->addDbxrefs($this);
             */
        }

        return $this->aDb;
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
        if ('BiomaterialDbxref' == $relationName) {
            $this->initBiomaterialDbxrefs();
        }
        if ('Cvterm' == $relationName) {
            $this->initCvterms();
        }
        if ('CvtermDbxref' == $relationName) {
            $this->initCvtermDbxrefs();
        }
        if ('Dbxrefprop' == $relationName) {
            $this->initDbxrefprops();
        }
        if ('Element' == $relationName) {
            $this->initElements();
        }
        if ('Feature' == $relationName) {
            $this->initFeatures();
        }
        if ('FeatureCvtermDbxref' == $relationName) {
            $this->initFeatureCvtermDbxrefs();
        }
        if ('FeatureDbxref' == $relationName) {
            $this->initFeatureDbxrefs();
        }
        if ('OrganismDbxref' == $relationName) {
            $this->initOrganismDbxrefs();
        }
        if ('Protocol' == $relationName) {
            $this->initProtocols();
        }
        if ('PubDbxref' == $relationName) {
            $this->initPubDbxrefs();
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
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setArraydesigns(PropelCollection $arraydesigns, PropelPDO $con = null)
    {
        $arraydesignsToDelete = $this->getArraydesigns(new Criteria(), $con)->diff($arraydesigns);

        $this->arraydesignsScheduledForDeletion = unserialize(serialize($arraydesignsToDelete));

        foreach ($arraydesignsToDelete as $arraydesignRemoved) {
            $arraydesignRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collArraydesigns);
    }

    /**
     * Method called to associate a Arraydesign object to this object
     * through the Arraydesign foreign key attribute.
     *
     * @param    Arraydesign $l Arraydesign
     * @return Dbxref The current object (for fluent API support)
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
        $arraydesign->setDbxref($this);
    }

    /**
     * @param	Arraydesign $arraydesign The arraydesign object to remove.
     * @return Dbxref The current object (for fluent API support)
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
            $arraydesign->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Arraydesigns from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setAssays(PropelCollection $assays, PropelPDO $con = null)
    {
        $assaysToDelete = $this->getAssays(new Criteria(), $con)->diff($assays);

        $this->assaysScheduledForDeletion = unserialize(serialize($assaysToDelete));

        foreach ($assaysToDelete as $assayRemoved) {
            $assayRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collAssays);
    }

    /**
     * Method called to associate a Assay object to this object
     * through the Assay foreign key attribute.
     *
     * @param    Assay $l Assay
     * @return Dbxref The current object (for fluent API support)
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
        $assay->setDbxref($this);
    }

    /**
     * @param	Assay $assay The assay object to remove.
     * @return Dbxref The current object (for fluent API support)
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
            $assay->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setBiomaterials(PropelCollection $biomaterials, PropelPDO $con = null)
    {
        $biomaterialsToDelete = $this->getBiomaterials(new Criteria(), $con)->diff($biomaterials);

        $this->biomaterialsScheduledForDeletion = unserialize(serialize($biomaterialsToDelete));

        foreach ($biomaterialsToDelete as $biomaterialRemoved) {
            $biomaterialRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collBiomaterials);
    }

    /**
     * Method called to associate a Biomaterial object to this object
     * through the Biomaterial foreign key attribute.
     *
     * @param    Biomaterial $l Biomaterial
     * @return Dbxref The current object (for fluent API support)
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
        $biomaterial->setDbxref($this);
    }

    /**
     * @param	Biomaterial $biomaterial The biomaterial object to remove.
     * @return Dbxref The current object (for fluent API support)
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
            $biomaterial->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Biomaterials from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Clears out the collBiomaterialDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addBiomaterialDbxrefs()
     */
    public function clearBiomaterialDbxrefs()
    {
        $this->collBiomaterialDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialDbxrefs($v = true)
    {
        $this->collBiomaterialDbxrefsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialDbxrefs collection.
     *
     * By default this just sets the collBiomaterialDbxrefs collection to an empty array (like clearcollBiomaterialDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialDbxrefs = new PropelObjectCollection();
        $this->collBiomaterialDbxrefs->setModel('BiomaterialDbxref');
    }

    /**
     * Gets an array of BiomaterialDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialDbxref[] List of BiomaterialDbxref objects
     * @throws PropelException
     */
    public function getBiomaterialDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialDbxrefsPartial && !$this->isNew();
        if (null === $this->collBiomaterialDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialDbxrefs) {
                // return empty collection
                $this->initBiomaterialDbxrefs();
            } else {
                $collBiomaterialDbxrefs = BiomaterialDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialDbxrefsPartial && count($collBiomaterialDbxrefs)) {
                      $this->initBiomaterialDbxrefs(false);

                      foreach($collBiomaterialDbxrefs as $obj) {
                        if (false == $this->collBiomaterialDbxrefs->contains($obj)) {
                          $this->collBiomaterialDbxrefs->append($obj);
                        }
                      }

                      $this->collBiomaterialDbxrefsPartial = true;
                    }

                    $collBiomaterialDbxrefs->getInternalIterator()->rewind();
                    return $collBiomaterialDbxrefs;
                }

                if($partial && $this->collBiomaterialDbxrefs) {
                    foreach($this->collBiomaterialDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialDbxrefs = $collBiomaterialDbxrefs;
                $this->collBiomaterialDbxrefsPartial = false;
            }
        }

        return $this->collBiomaterialDbxrefs;
    }

    /**
     * Sets a collection of BiomaterialDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setBiomaterialDbxrefs(PropelCollection $biomaterialDbxrefs, PropelPDO $con = null)
    {
        $biomaterialDbxrefsToDelete = $this->getBiomaterialDbxrefs(new Criteria(), $con)->diff($biomaterialDbxrefs);

        $this->biomaterialDbxrefsScheduledForDeletion = unserialize(serialize($biomaterialDbxrefsToDelete));

        foreach ($biomaterialDbxrefsToDelete as $biomaterialDbxrefRemoved) {
            $biomaterialDbxrefRemoved->setDbxref(null);
        }

        $this->collBiomaterialDbxrefs = null;
        foreach ($biomaterialDbxrefs as $biomaterialDbxref) {
            $this->addBiomaterialDbxref($biomaterialDbxref);
        }

        $this->collBiomaterialDbxrefs = $biomaterialDbxrefs;
        $this->collBiomaterialDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related BiomaterialDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related BiomaterialDbxref objects.
     * @throws PropelException
     */
    public function countBiomaterialDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialDbxrefsPartial && !$this->isNew();
        if (null === $this->collBiomaterialDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialDbxrefs());
            }
            $query = BiomaterialDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collBiomaterialDbxrefs);
    }

    /**
     * Method called to associate a BiomaterialDbxref object to this object
     * through the BiomaterialDbxref foreign key attribute.
     *
     * @param    BiomaterialDbxref $l BiomaterialDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addBiomaterialDbxref(BiomaterialDbxref $l)
    {
        if ($this->collBiomaterialDbxrefs === null) {
            $this->initBiomaterialDbxrefs();
            $this->collBiomaterialDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialDbxref($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialDbxref $biomaterialDbxref The biomaterialDbxref object to add.
     */
    protected function doAddBiomaterialDbxref($biomaterialDbxref)
    {
        $this->collBiomaterialDbxrefs[]= $biomaterialDbxref;
        $biomaterialDbxref->setDbxref($this);
    }

    /**
     * @param	BiomaterialDbxref $biomaterialDbxref The biomaterialDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeBiomaterialDbxref($biomaterialDbxref)
    {
        if ($this->getBiomaterialDbxrefs()->contains($biomaterialDbxref)) {
            $this->collBiomaterialDbxrefs->remove($this->collBiomaterialDbxrefs->search($biomaterialDbxref));
            if (null === $this->biomaterialDbxrefsScheduledForDeletion) {
                $this->biomaterialDbxrefsScheduledForDeletion = clone $this->collBiomaterialDbxrefs;
                $this->biomaterialDbxrefsScheduledForDeletion->clear();
            }
            $this->biomaterialDbxrefsScheduledForDeletion[]= clone $biomaterialDbxref;
            $biomaterialDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related BiomaterialDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialDbxref[] List of BiomaterialDbxref objects
     */
    public function getBiomaterialDbxrefsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialDbxrefQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getBiomaterialDbxrefs($query, $con);
    }

    /**
     * Clears out the collCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addCvterms()
     */
    public function clearCvterms()
    {
        $this->collCvterms = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvterms collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvterms($v = true)
    {
        $this->collCvtermsPartial = $v;
    }

    /**
     * Initializes the collCvterms collection.
     *
     * By default this just sets the collCvterms collection to an empty array (like clearcollCvterms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvterms($overrideExisting = true)
    {
        if (null !== $this->collCvterms && !$overrideExisting) {
            return;
        }
        $this->collCvterms = new PropelObjectCollection();
        $this->collCvterms->setModel('Cvterm');
    }

    /**
     * Gets an array of Cvterm objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Cvterm[] List of Cvterm objects
     * @throws PropelException
     */
    public function getCvterms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsPartial && !$this->isNew();
        if (null === $this->collCvterms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvterms) {
                // return empty collection
                $this->initCvterms();
            } else {
                $collCvterms = CvtermQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermsPartial && count($collCvterms)) {
                      $this->initCvterms(false);

                      foreach($collCvterms as $obj) {
                        if (false == $this->collCvterms->contains($obj)) {
                          $this->collCvterms->append($obj);
                        }
                      }

                      $this->collCvtermsPartial = true;
                    }

                    $collCvterms->getInternalIterator()->rewind();
                    return $collCvterms;
                }

                if($partial && $this->collCvterms) {
                    foreach($this->collCvterms as $obj) {
                        if($obj->isNew()) {
                            $collCvterms[] = $obj;
                        }
                    }
                }

                $this->collCvterms = $collCvterms;
                $this->collCvtermsPartial = false;
            }
        }

        return $this->collCvterms;
    }

    /**
     * Sets a collection of Cvterm objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvterms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setCvterms(PropelCollection $cvterms, PropelPDO $con = null)
    {
        $cvtermsToDelete = $this->getCvterms(new Criteria(), $con)->diff($cvterms);

        $this->cvtermsScheduledForDeletion = unserialize(serialize($cvtermsToDelete));

        foreach ($cvtermsToDelete as $cvtermRemoved) {
            $cvtermRemoved->setDbxref(null);
        }

        $this->collCvterms = null;
        foreach ($cvterms as $cvterm) {
            $this->addCvterm($cvterm);
        }

        $this->collCvterms = $cvterms;
        $this->collCvtermsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Cvterm objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Cvterm objects.
     * @throws PropelException
     */
    public function countCvterms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermsPartial && !$this->isNew();
        if (null === $this->collCvterms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvterms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvterms());
            }
            $query = CvtermQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collCvterms);
    }

    /**
     * Method called to associate a Cvterm object to this object
     * through the Cvterm foreign key attribute.
     *
     * @param    Cvterm $l Cvterm
     * @return Dbxref The current object (for fluent API support)
     */
    public function addCvterm(Cvterm $l)
    {
        if ($this->collCvterms === null) {
            $this->initCvterms();
            $this->collCvtermsPartial = true;
        }
        if (!in_array($l, $this->collCvterms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvterm($l);
        }

        return $this;
    }

    /**
     * @param	Cvterm $cvterm The cvterm object to add.
     */
    protected function doAddCvterm($cvterm)
    {
        $this->collCvterms[]= $cvterm;
        $cvterm->setDbxref($this);
    }

    /**
     * @param	Cvterm $cvterm The cvterm object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeCvterm($cvterm)
    {
        if ($this->getCvterms()->contains($cvterm)) {
            $this->collCvterms->remove($this->collCvterms->search($cvterm));
            if (null === $this->cvtermsScheduledForDeletion) {
                $this->cvtermsScheduledForDeletion = clone $this->collCvterms;
                $this->cvtermsScheduledForDeletion->clear();
            }
            $this->cvtermsScheduledForDeletion[]= clone $cvterm;
            $cvterm->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Cvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Cvterm[] List of Cvterm objects
     */
    public function getCvtermsJoinCv($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermQuery::create(null, $criteria);
        $query->joinWith('Cv', $join_behavior);

        return $this->getCvterms($query, $con);
    }

    /**
     * Clears out the collCvtermDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addCvtermDbxrefs()
     */
    public function clearCvtermDbxrefs()
    {
        $this->collCvtermDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collCvtermDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collCvtermDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialCvtermDbxrefs($v = true)
    {
        $this->collCvtermDbxrefsPartial = $v;
    }

    /**
     * Initializes the collCvtermDbxrefs collection.
     *
     * By default this just sets the collCvtermDbxrefs collection to an empty array (like clearcollCvtermDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initCvtermDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collCvtermDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collCvtermDbxrefs = new PropelObjectCollection();
        $this->collCvtermDbxrefs->setModel('CvtermDbxref');
    }

    /**
     * Gets an array of CvtermDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|CvtermDbxref[] List of CvtermDbxref objects
     * @throws PropelException
     */
    public function getCvtermDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collCvtermDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collCvtermDbxrefs) {
                // return empty collection
                $this->initCvtermDbxrefs();
            } else {
                $collCvtermDbxrefs = CvtermDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collCvtermDbxrefsPartial && count($collCvtermDbxrefs)) {
                      $this->initCvtermDbxrefs(false);

                      foreach($collCvtermDbxrefs as $obj) {
                        if (false == $this->collCvtermDbxrefs->contains($obj)) {
                          $this->collCvtermDbxrefs->append($obj);
                        }
                      }

                      $this->collCvtermDbxrefsPartial = true;
                    }

                    $collCvtermDbxrefs->getInternalIterator()->rewind();
                    return $collCvtermDbxrefs;
                }

                if($partial && $this->collCvtermDbxrefs) {
                    foreach($this->collCvtermDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collCvtermDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collCvtermDbxrefs = $collCvtermDbxrefs;
                $this->collCvtermDbxrefsPartial = false;
            }
        }

        return $this->collCvtermDbxrefs;
    }

    /**
     * Sets a collection of CvtermDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $cvtermDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setCvtermDbxrefs(PropelCollection $cvtermDbxrefs, PropelPDO $con = null)
    {
        $cvtermDbxrefsToDelete = $this->getCvtermDbxrefs(new Criteria(), $con)->diff($cvtermDbxrefs);

        $this->cvtermDbxrefsScheduledForDeletion = unserialize(serialize($cvtermDbxrefsToDelete));

        foreach ($cvtermDbxrefsToDelete as $cvtermDbxrefRemoved) {
            $cvtermDbxrefRemoved->setDbxref(null);
        }

        $this->collCvtermDbxrefs = null;
        foreach ($cvtermDbxrefs as $cvtermDbxref) {
            $this->addCvtermDbxref($cvtermDbxref);
        }

        $this->collCvtermDbxrefs = $cvtermDbxrefs;
        $this->collCvtermDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related CvtermDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related CvtermDbxref objects.
     * @throws PropelException
     */
    public function countCvtermDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collCvtermDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collCvtermDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getCvtermDbxrefs());
            }
            $query = CvtermDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collCvtermDbxrefs);
    }

    /**
     * Method called to associate a CvtermDbxref object to this object
     * through the CvtermDbxref foreign key attribute.
     *
     * @param    CvtermDbxref $l CvtermDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addCvtermDbxref(CvtermDbxref $l)
    {
        if ($this->collCvtermDbxrefs === null) {
            $this->initCvtermDbxrefs();
            $this->collCvtermDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collCvtermDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddCvtermDbxref($l);
        }

        return $this;
    }

    /**
     * @param	CvtermDbxref $cvtermDbxref The cvtermDbxref object to add.
     */
    protected function doAddCvtermDbxref($cvtermDbxref)
    {
        $this->collCvtermDbxrefs[]= $cvtermDbxref;
        $cvtermDbxref->setDbxref($this);
    }

    /**
     * @param	CvtermDbxref $cvtermDbxref The cvtermDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeCvtermDbxref($cvtermDbxref)
    {
        if ($this->getCvtermDbxrefs()->contains($cvtermDbxref)) {
            $this->collCvtermDbxrefs->remove($this->collCvtermDbxrefs->search($cvtermDbxref));
            if (null === $this->cvtermDbxrefsScheduledForDeletion) {
                $this->cvtermDbxrefsScheduledForDeletion = clone $this->collCvtermDbxrefs;
                $this->cvtermDbxrefsScheduledForDeletion->clear();
            }
            $this->cvtermDbxrefsScheduledForDeletion[]= clone $cvtermDbxref;
            $cvtermDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related CvtermDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|CvtermDbxref[] List of CvtermDbxref objects
     */
    public function getCvtermDbxrefsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = CvtermDbxrefQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getCvtermDbxrefs($query, $con);
    }

    /**
     * Clears out the collDbxrefprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addDbxrefprops()
     */
    public function clearDbxrefprops()
    {
        $this->collDbxrefprops = null; // important to set this to null since that means it is uninitialized
        $this->collDbxrefpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collDbxrefprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialDbxrefprops($v = true)
    {
        $this->collDbxrefpropsPartial = $v;
    }

    /**
     * Initializes the collDbxrefprops collection.
     *
     * By default this just sets the collDbxrefprops collection to an empty array (like clearcollDbxrefprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initDbxrefprops($overrideExisting = true)
    {
        if (null !== $this->collDbxrefprops && !$overrideExisting) {
            return;
        }
        $this->collDbxrefprops = new PropelObjectCollection();
        $this->collDbxrefprops->setModel('Dbxrefprop');
    }

    /**
     * Gets an array of Dbxrefprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Dbxrefprop[] List of Dbxrefprop objects
     * @throws PropelException
     */
    public function getDbxrefprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collDbxrefpropsPartial && !$this->isNew();
        if (null === $this->collDbxrefprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collDbxrefprops) {
                // return empty collection
                $this->initDbxrefprops();
            } else {
                $collDbxrefprops = DbxrefpropQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collDbxrefpropsPartial && count($collDbxrefprops)) {
                      $this->initDbxrefprops(false);

                      foreach($collDbxrefprops as $obj) {
                        if (false == $this->collDbxrefprops->contains($obj)) {
                          $this->collDbxrefprops->append($obj);
                        }
                      }

                      $this->collDbxrefpropsPartial = true;
                    }

                    $collDbxrefprops->getInternalIterator()->rewind();
                    return $collDbxrefprops;
                }

                if($partial && $this->collDbxrefprops) {
                    foreach($this->collDbxrefprops as $obj) {
                        if($obj->isNew()) {
                            $collDbxrefprops[] = $obj;
                        }
                    }
                }

                $this->collDbxrefprops = $collDbxrefprops;
                $this->collDbxrefpropsPartial = false;
            }
        }

        return $this->collDbxrefprops;
    }

    /**
     * Sets a collection of Dbxrefprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $dbxrefprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setDbxrefprops(PropelCollection $dbxrefprops, PropelPDO $con = null)
    {
        $dbxrefpropsToDelete = $this->getDbxrefprops(new Criteria(), $con)->diff($dbxrefprops);

        $this->dbxrefpropsScheduledForDeletion = unserialize(serialize($dbxrefpropsToDelete));

        foreach ($dbxrefpropsToDelete as $dbxrefpropRemoved) {
            $dbxrefpropRemoved->setDbxref(null);
        }

        $this->collDbxrefprops = null;
        foreach ($dbxrefprops as $dbxrefprop) {
            $this->addDbxrefprop($dbxrefprop);
        }

        $this->collDbxrefprops = $dbxrefprops;
        $this->collDbxrefpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Dbxrefprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Dbxrefprop objects.
     * @throws PropelException
     */
    public function countDbxrefprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collDbxrefpropsPartial && !$this->isNew();
        if (null === $this->collDbxrefprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collDbxrefprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getDbxrefprops());
            }
            $query = DbxrefpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collDbxrefprops);
    }

    /**
     * Method called to associate a Dbxrefprop object to this object
     * through the Dbxrefprop foreign key attribute.
     *
     * @param    Dbxrefprop $l Dbxrefprop
     * @return Dbxref The current object (for fluent API support)
     */
    public function addDbxrefprop(Dbxrefprop $l)
    {
        if ($this->collDbxrefprops === null) {
            $this->initDbxrefprops();
            $this->collDbxrefpropsPartial = true;
        }
        if (!in_array($l, $this->collDbxrefprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddDbxrefprop($l);
        }

        return $this;
    }

    /**
     * @param	Dbxrefprop $dbxrefprop The dbxrefprop object to add.
     */
    protected function doAddDbxrefprop($dbxrefprop)
    {
        $this->collDbxrefprops[]= $dbxrefprop;
        $dbxrefprop->setDbxref($this);
    }

    /**
     * @param	Dbxrefprop $dbxrefprop The dbxrefprop object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeDbxrefprop($dbxrefprop)
    {
        if ($this->getDbxrefprops()->contains($dbxrefprop)) {
            $this->collDbxrefprops->remove($this->collDbxrefprops->search($dbxrefprop));
            if (null === $this->dbxrefpropsScheduledForDeletion) {
                $this->dbxrefpropsScheduledForDeletion = clone $this->collDbxrefprops;
                $this->dbxrefpropsScheduledForDeletion->clear();
            }
            $this->dbxrefpropsScheduledForDeletion[]= clone $dbxrefprop;
            $dbxrefprop->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Dbxrefprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Dbxrefprop[] List of Dbxrefprop objects
     */
    public function getDbxrefpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = DbxrefpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getDbxrefprops($query, $con);
    }

    /**
     * Clears out the collElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addElements()
     */
    public function clearElements()
    {
        $this->collElements = null; // important to set this to null since that means it is uninitialized
        $this->collElementsPartial = null;

        return $this;
    }

    /**
     * reset is the collElements collection loaded partially
     *
     * @return void
     */
    public function resetPartialElements($v = true)
    {
        $this->collElementsPartial = $v;
    }

    /**
     * Initializes the collElements collection.
     *
     * By default this just sets the collElements collection to an empty array (like clearcollElements());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initElements($overrideExisting = true)
    {
        if (null !== $this->collElements && !$overrideExisting) {
            return;
        }
        $this->collElements = new PropelObjectCollection();
        $this->collElements->setModel('Element');
    }

    /**
     * Gets an array of Element objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Element[] List of Element objects
     * @throws PropelException
     */
    public function getElements($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                // return empty collection
                $this->initElements();
            } else {
                $collElements = ElementQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collElementsPartial && count($collElements)) {
                      $this->initElements(false);

                      foreach($collElements as $obj) {
                        if (false == $this->collElements->contains($obj)) {
                          $this->collElements->append($obj);
                        }
                      }

                      $this->collElementsPartial = true;
                    }

                    $collElements->getInternalIterator()->rewind();
                    return $collElements;
                }

                if($partial && $this->collElements) {
                    foreach($this->collElements as $obj) {
                        if($obj->isNew()) {
                            $collElements[] = $obj;
                        }
                    }
                }

                $this->collElements = $collElements;
                $this->collElementsPartial = false;
            }
        }

        return $this->collElements;
    }

    /**
     * Sets a collection of Element objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $elements A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setElements(PropelCollection $elements, PropelPDO $con = null)
    {
        $elementsToDelete = $this->getElements(new Criteria(), $con)->diff($elements);

        $this->elementsScheduledForDeletion = unserialize(serialize($elementsToDelete));

        foreach ($elementsToDelete as $elementRemoved) {
            $elementRemoved->setDbxref(null);
        }

        $this->collElements = null;
        foreach ($elements as $element) {
            $this->addElement($element);
        }

        $this->collElements = $elements;
        $this->collElementsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Element objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Element objects.
     * @throws PropelException
     */
    public function countElements(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collElementsPartial && !$this->isNew();
        if (null === $this->collElements || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collElements) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getElements());
            }
            $query = ElementQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collElements);
    }

    /**
     * Method called to associate a Element object to this object
     * through the Element foreign key attribute.
     *
     * @param    Element $l Element
     * @return Dbxref The current object (for fluent API support)
     */
    public function addElement(Element $l)
    {
        if ($this->collElements === null) {
            $this->initElements();
            $this->collElementsPartial = true;
        }
        if (!in_array($l, $this->collElements->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddElement($l);
        }

        return $this;
    }

    /**
     * @param	Element $element The element object to add.
     */
    protected function doAddElement($element)
    {
        $this->collElements[]= $element;
        $element->setDbxref($this);
    }

    /**
     * @param	Element $element The element object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeElement($element)
    {
        if ($this->getElements()->contains($element)) {
            $this->collElements->remove($this->collElements->search($element));
            if (null === $this->elementsScheduledForDeletion) {
                $this->elementsScheduledForDeletion = clone $this->collElements;
                $this->elementsScheduledForDeletion->clear();
            }
            $this->elementsScheduledForDeletion[]= $element;
            $element->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinArraydesign($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Arraydesign', $join_behavior);

        return $this->getElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getElements($query, $con);
    }

    /**
     * Clears out the collFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatures(PropelCollection $features, PropelPDO $con = null)
    {
        $featuresToDelete = $this->getFeatures(new Criteria(), $con)->diff($features);

        $this->featuresScheduledForDeletion = unserialize(serialize($featuresToDelete));

        foreach ($featuresToDelete as $featureRemoved) {
            $featureRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatures);
    }

    /**
     * Method called to associate a Feature object to this object
     * through the Feature foreign key attribute.
     *
     * @param    Feature $l Feature
     * @return Dbxref The current object (for fluent API support)
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
        $feature->setDbxref($this);
    }

    /**
     * @param	Feature $feature The feature object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeature($feature)
    {
        if ($this->getFeatures()->contains($feature)) {
            $this->collFeatures->remove($this->collFeatures->search($feature));
            if (null === $this->featuresScheduledForDeletion) {
                $this->featuresScheduledForDeletion = clone $this->collFeatures;
                $this->featuresScheduledForDeletion->clear();
            }
            $this->featuresScheduledForDeletion[]= $feature;
            $feature->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Feature[] List of Feature objects
     */
    public function getFeaturesJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getFeatures($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
     * Clears out the collFeatureCvtermDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addFeatureCvtermDbxrefs()
     */
    public function clearFeatureCvtermDbxrefs()
    {
        $this->collFeatureCvtermDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermDbxrefs($v = true)
    {
        $this->collFeatureCvtermDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermDbxrefs collection.
     *
     * By default this just sets the collFeatureCvtermDbxrefs collection to an empty array (like clearcollFeatureCvtermDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermDbxrefs = new PropelObjectCollection();
        $this->collFeatureCvtermDbxrefs->setModel('FeatureCvtermDbxref');
    }

    /**
     * Gets an array of FeatureCvtermDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     * @throws PropelException
     */
    public function getFeatureCvtermDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                // return empty collection
                $this->initFeatureCvtermDbxrefs();
            } else {
                $collFeatureCvtermDbxrefs = FeatureCvtermDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermDbxrefsPartial && count($collFeatureCvtermDbxrefs)) {
                      $this->initFeatureCvtermDbxrefs(false);

                      foreach($collFeatureCvtermDbxrefs as $obj) {
                        if (false == $this->collFeatureCvtermDbxrefs->contains($obj)) {
                          $this->collFeatureCvtermDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureCvtermDbxrefsPartial = true;
                    }

                    $collFeatureCvtermDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureCvtermDbxrefs;
                }

                if($partial && $this->collFeatureCvtermDbxrefs) {
                    foreach($this->collFeatureCvtermDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermDbxrefs = $collFeatureCvtermDbxrefs;
                $this->collFeatureCvtermDbxrefsPartial = false;
            }
        }

        return $this->collFeatureCvtermDbxrefs;
    }

    /**
     * Sets a collection of FeatureCvtermDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatureCvtermDbxrefs(PropelCollection $featureCvtermDbxrefs, PropelPDO $con = null)
    {
        $featureCvtermDbxrefsToDelete = $this->getFeatureCvtermDbxrefs(new Criteria(), $con)->diff($featureCvtermDbxrefs);

        $this->featureCvtermDbxrefsScheduledForDeletion = unserialize(serialize($featureCvtermDbxrefsToDelete));

        foreach ($featureCvtermDbxrefsToDelete as $featureCvtermDbxrefRemoved) {
            $featureCvtermDbxrefRemoved->setDbxref(null);
        }

        $this->collFeatureCvtermDbxrefs = null;
        foreach ($featureCvtermDbxrefs as $featureCvtermDbxref) {
            $this->addFeatureCvtermDbxref($featureCvtermDbxref);
        }

        $this->collFeatureCvtermDbxrefs = $featureCvtermDbxrefs;
        $this->collFeatureCvtermDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermDbxref objects.
     * @throws PropelException
     */
    public function countFeatureCvtermDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermDbxrefs());
            }
            $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermDbxrefs);
    }

    /**
     * Method called to associate a FeatureCvtermDbxref object to this object
     * through the FeatureCvtermDbxref foreign key attribute.
     *
     * @param    FeatureCvtermDbxref $l FeatureCvtermDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addFeatureCvtermDbxref(FeatureCvtermDbxref $l)
    {
        if ($this->collFeatureCvtermDbxrefs === null) {
            $this->initFeatureCvtermDbxrefs();
            $this->collFeatureCvtermDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to add.
     */
    protected function doAddFeatureCvtermDbxref($featureCvtermDbxref)
    {
        $this->collFeatureCvtermDbxrefs[]= $featureCvtermDbxref;
        $featureCvtermDbxref->setDbxref($this);
    }

    /**
     * @param	FeatureCvtermDbxref $featureCvtermDbxref The featureCvtermDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeatureCvtermDbxref($featureCvtermDbxref)
    {
        if ($this->getFeatureCvtermDbxrefs()->contains($featureCvtermDbxref)) {
            $this->collFeatureCvtermDbxrefs->remove($this->collFeatureCvtermDbxrefs->search($featureCvtermDbxref));
            if (null === $this->featureCvtermDbxrefsScheduledForDeletion) {
                $this->featureCvtermDbxrefsScheduledForDeletion = clone $this->collFeatureCvtermDbxrefs;
                $this->featureCvtermDbxrefsScheduledForDeletion->clear();
            }
            $this->featureCvtermDbxrefsScheduledForDeletion[]= clone $featureCvtermDbxref;
            $featureCvtermDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related FeatureCvtermDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermDbxref[] List of FeatureCvtermDbxref objects
     */
    public function getFeatureCvtermDbxrefsJoinFeatureCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermDbxrefQuery::create(null, $criteria);
        $query->joinWith('FeatureCvterm', $join_behavior);

        return $this->getFeatureCvtermDbxrefs($query, $con);
    }

    /**
     * Clears out the collFeatureDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addFeatureDbxrefs()
     */
    public function clearFeatureDbxrefs()
    {
        $this->collFeatureDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureDbxrefs($v = true)
    {
        $this->collFeatureDbxrefsPartial = $v;
    }

    /**
     * Initializes the collFeatureDbxrefs collection.
     *
     * By default this just sets the collFeatureDbxrefs collection to an empty array (like clearcollFeatureDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collFeatureDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collFeatureDbxrefs = new PropelObjectCollection();
        $this->collFeatureDbxrefs->setModel('FeatureDbxref');
    }

    /**
     * Gets an array of FeatureDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     * @throws PropelException
     */
    public function getFeatureDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                // return empty collection
                $this->initFeatureDbxrefs();
            } else {
                $collFeatureDbxrefs = FeatureDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureDbxrefsPartial && count($collFeatureDbxrefs)) {
                      $this->initFeatureDbxrefs(false);

                      foreach($collFeatureDbxrefs as $obj) {
                        if (false == $this->collFeatureDbxrefs->contains($obj)) {
                          $this->collFeatureDbxrefs->append($obj);
                        }
                      }

                      $this->collFeatureDbxrefsPartial = true;
                    }

                    $collFeatureDbxrefs->getInternalIterator()->rewind();
                    return $collFeatureDbxrefs;
                }

                if($partial && $this->collFeatureDbxrefs) {
                    foreach($this->collFeatureDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collFeatureDbxrefs = $collFeatureDbxrefs;
                $this->collFeatureDbxrefsPartial = false;
            }
        }

        return $this->collFeatureDbxrefs;
    }

    /**
     * Sets a collection of FeatureDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setFeatureDbxrefs(PropelCollection $featureDbxrefs, PropelPDO $con = null)
    {
        $featureDbxrefsToDelete = $this->getFeatureDbxrefs(new Criteria(), $con)->diff($featureDbxrefs);

        $this->featureDbxrefsScheduledForDeletion = unserialize(serialize($featureDbxrefsToDelete));

        foreach ($featureDbxrefsToDelete as $featureDbxrefRemoved) {
            $featureDbxrefRemoved->setDbxref(null);
        }

        $this->collFeatureDbxrefs = null;
        foreach ($featureDbxrefs as $featureDbxref) {
            $this->addFeatureDbxref($featureDbxref);
        }

        $this->collFeatureDbxrefs = $featureDbxrefs;
        $this->collFeatureDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureDbxref objects.
     * @throws PropelException
     */
    public function countFeatureDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureDbxrefsPartial && !$this->isNew();
        if (null === $this->collFeatureDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureDbxrefs());
            }
            $query = FeatureDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collFeatureDbxrefs);
    }

    /**
     * Method called to associate a FeatureDbxref object to this object
     * through the FeatureDbxref foreign key attribute.
     *
     * @param    FeatureDbxref $l FeatureDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addFeatureDbxref(FeatureDbxref $l)
    {
        if ($this->collFeatureDbxrefs === null) {
            $this->initFeatureDbxrefs();
            $this->collFeatureDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collFeatureDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureDbxref($l);
        }

        return $this;
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to add.
     */
    protected function doAddFeatureDbxref($featureDbxref)
    {
        $this->collFeatureDbxrefs[]= $featureDbxref;
        $featureDbxref->setDbxref($this);
    }

    /**
     * @param	FeatureDbxref $featureDbxref The featureDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeFeatureDbxref($featureDbxref)
    {
        if ($this->getFeatureDbxrefs()->contains($featureDbxref)) {
            $this->collFeatureDbxrefs->remove($this->collFeatureDbxrefs->search($featureDbxref));
            if (null === $this->featureDbxrefsScheduledForDeletion) {
                $this->featureDbxrefsScheduledForDeletion = clone $this->collFeatureDbxrefs;
                $this->featureDbxrefsScheduledForDeletion->clear();
            }
            $this->featureDbxrefsScheduledForDeletion[]= clone $featureDbxref;
            $featureDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related FeatureDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureDbxref[] List of FeatureDbxref objects
     */
    public function getFeatureDbxrefsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureDbxrefQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureDbxrefs($query, $con);
    }

    /**
     * Clears out the collOrganismDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setOrganismDbxrefs(PropelCollection $organismDbxrefs, PropelPDO $con = null)
    {
        $organismDbxrefsToDelete = $this->getOrganismDbxrefs(new Criteria(), $con)->diff($organismDbxrefs);

        $this->organismDbxrefsScheduledForDeletion = unserialize(serialize($organismDbxrefsToDelete));

        foreach ($organismDbxrefsToDelete as $organismDbxrefRemoved) {
            $organismDbxrefRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collOrganismDbxrefs);
    }

    /**
     * Method called to associate a OrganismDbxref object to this object
     * through the OrganismDbxref foreign key attribute.
     *
     * @param    OrganismDbxref $l OrganismDbxref
     * @return Dbxref The current object (for fluent API support)
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
        $organismDbxref->setDbxref($this);
    }

    /**
     * @param	OrganismDbxref $organismDbxref The organismDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
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
            $organismDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related OrganismDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|OrganismDbxref[] List of OrganismDbxref objects
     */
    public function getOrganismDbxrefsJoinOrganism($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = OrganismDbxrefQuery::create(null, $criteria);
        $query->joinWith('Organism', $join_behavior);

        return $this->getOrganismDbxrefs($query, $con);
    }

    /**
     * Clears out the collProtocols collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addProtocols()
     */
    public function clearProtocols()
    {
        $this->collProtocols = null; // important to set this to null since that means it is uninitialized
        $this->collProtocolsPartial = null;

        return $this;
    }

    /**
     * reset is the collProtocols collection loaded partially
     *
     * @return void
     */
    public function resetPartialProtocols($v = true)
    {
        $this->collProtocolsPartial = $v;
    }

    /**
     * Initializes the collProtocols collection.
     *
     * By default this just sets the collProtocols collection to an empty array (like clearcollProtocols());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initProtocols($overrideExisting = true)
    {
        if (null !== $this->collProtocols && !$overrideExisting) {
            return;
        }
        $this->collProtocols = new PropelObjectCollection();
        $this->collProtocols->setModel('Protocol');
    }

    /**
     * Gets an array of Protocol objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     * @throws PropelException
     */
    public function getProtocols($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collProtocolsPartial && !$this->isNew();
        if (null === $this->collProtocols || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collProtocols) {
                // return empty collection
                $this->initProtocols();
            } else {
                $collProtocols = ProtocolQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collProtocolsPartial && count($collProtocols)) {
                      $this->initProtocols(false);

                      foreach($collProtocols as $obj) {
                        if (false == $this->collProtocols->contains($obj)) {
                          $this->collProtocols->append($obj);
                        }
                      }

                      $this->collProtocolsPartial = true;
                    }

                    $collProtocols->getInternalIterator()->rewind();
                    return $collProtocols;
                }

                if($partial && $this->collProtocols) {
                    foreach($this->collProtocols as $obj) {
                        if($obj->isNew()) {
                            $collProtocols[] = $obj;
                        }
                    }
                }

                $this->collProtocols = $collProtocols;
                $this->collProtocolsPartial = false;
            }
        }

        return $this->collProtocols;
    }

    /**
     * Sets a collection of Protocol objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $protocols A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setProtocols(PropelCollection $protocols, PropelPDO $con = null)
    {
        $protocolsToDelete = $this->getProtocols(new Criteria(), $con)->diff($protocols);

        $this->protocolsScheduledForDeletion = unserialize(serialize($protocolsToDelete));

        foreach ($protocolsToDelete as $protocolRemoved) {
            $protocolRemoved->setDbxref(null);
        }

        $this->collProtocols = null;
        foreach ($protocols as $protocol) {
            $this->addProtocol($protocol);
        }

        $this->collProtocols = $protocols;
        $this->collProtocolsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Protocol objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Protocol objects.
     * @throws PropelException
     */
    public function countProtocols(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collProtocolsPartial && !$this->isNew();
        if (null === $this->collProtocols || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collProtocols) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getProtocols());
            }
            $query = ProtocolQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collProtocols);
    }

    /**
     * Method called to associate a Protocol object to this object
     * through the Protocol foreign key attribute.
     *
     * @param    Protocol $l Protocol
     * @return Dbxref The current object (for fluent API support)
     */
    public function addProtocol(Protocol $l)
    {
        if ($this->collProtocols === null) {
            $this->initProtocols();
            $this->collProtocolsPartial = true;
        }
        if (!in_array($l, $this->collProtocols->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddProtocol($l);
        }

        return $this;
    }

    /**
     * @param	Protocol $protocol The protocol object to add.
     */
    protected function doAddProtocol($protocol)
    {
        $this->collProtocols[]= $protocol;
        $protocol->setDbxref($this);
    }

    /**
     * @param	Protocol $protocol The protocol object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeProtocol($protocol)
    {
        if ($this->getProtocols()->contains($protocol)) {
            $this->collProtocols->remove($this->collProtocols->search($protocol));
            if (null === $this->protocolsScheduledForDeletion) {
                $this->protocolsScheduledForDeletion = clone $this->collProtocols;
                $this->protocolsScheduledForDeletion->clear();
            }
            $this->protocolsScheduledForDeletion[]= $protocol;
            $protocol->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Protocols from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     */
    public function getProtocolsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getProtocols($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Protocols from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Protocol[] List of Protocol objects
     */
    public function getProtocolsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ProtocolQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getProtocols($query, $con);
    }

    /**
     * Clears out the collPubDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
     * @see        addPubDbxrefs()
     */
    public function clearPubDbxrefs()
    {
        $this->collPubDbxrefs = null; // important to set this to null since that means it is uninitialized
        $this->collPubDbxrefsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubDbxrefs collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubDbxrefs($v = true)
    {
        $this->collPubDbxrefsPartial = $v;
    }

    /**
     * Initializes the collPubDbxrefs collection.
     *
     * By default this just sets the collPubDbxrefs collection to an empty array (like clearcollPubDbxrefs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubDbxrefs($overrideExisting = true)
    {
        if (null !== $this->collPubDbxrefs && !$overrideExisting) {
            return;
        }
        $this->collPubDbxrefs = new PropelObjectCollection();
        $this->collPubDbxrefs->setModel('PubDbxref');
    }

    /**
     * Gets an array of PubDbxref objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Dbxref is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubDbxref[] List of PubDbxref objects
     * @throws PropelException
     */
    public function getPubDbxrefs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubDbxrefsPartial && !$this->isNew();
        if (null === $this->collPubDbxrefs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubDbxrefs) {
                // return empty collection
                $this->initPubDbxrefs();
            } else {
                $collPubDbxrefs = PubDbxrefQuery::create(null, $criteria)
                    ->filterByDbxref($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubDbxrefsPartial && count($collPubDbxrefs)) {
                      $this->initPubDbxrefs(false);

                      foreach($collPubDbxrefs as $obj) {
                        if (false == $this->collPubDbxrefs->contains($obj)) {
                          $this->collPubDbxrefs->append($obj);
                        }
                      }

                      $this->collPubDbxrefsPartial = true;
                    }

                    $collPubDbxrefs->getInternalIterator()->rewind();
                    return $collPubDbxrefs;
                }

                if($partial && $this->collPubDbxrefs) {
                    foreach($this->collPubDbxrefs as $obj) {
                        if($obj->isNew()) {
                            $collPubDbxrefs[] = $obj;
                        }
                    }
                }

                $this->collPubDbxrefs = $collPubDbxrefs;
                $this->collPubDbxrefsPartial = false;
            }
        }

        return $this->collPubDbxrefs;
    }

    /**
     * Sets a collection of PubDbxref objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubDbxrefs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Dbxref The current object (for fluent API support)
     */
    public function setPubDbxrefs(PropelCollection $pubDbxrefs, PropelPDO $con = null)
    {
        $pubDbxrefsToDelete = $this->getPubDbxrefs(new Criteria(), $con)->diff($pubDbxrefs);

        $this->pubDbxrefsScheduledForDeletion = unserialize(serialize($pubDbxrefsToDelete));

        foreach ($pubDbxrefsToDelete as $pubDbxrefRemoved) {
            $pubDbxrefRemoved->setDbxref(null);
        }

        $this->collPubDbxrefs = null;
        foreach ($pubDbxrefs as $pubDbxref) {
            $this->addPubDbxref($pubDbxref);
        }

        $this->collPubDbxrefs = $pubDbxrefs;
        $this->collPubDbxrefsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PubDbxref objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PubDbxref objects.
     * @throws PropelException
     */
    public function countPubDbxrefs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubDbxrefsPartial && !$this->isNew();
        if (null === $this->collPubDbxrefs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubDbxrefs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubDbxrefs());
            }
            $query = PubDbxrefQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collPubDbxrefs);
    }

    /**
     * Method called to associate a PubDbxref object to this object
     * through the PubDbxref foreign key attribute.
     *
     * @param    PubDbxref $l PubDbxref
     * @return Dbxref The current object (for fluent API support)
     */
    public function addPubDbxref(PubDbxref $l)
    {
        if ($this->collPubDbxrefs === null) {
            $this->initPubDbxrefs();
            $this->collPubDbxrefsPartial = true;
        }
        if (!in_array($l, $this->collPubDbxrefs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubDbxref($l);
        }

        return $this;
    }

    /**
     * @param	PubDbxref $pubDbxref The pubDbxref object to add.
     */
    protected function doAddPubDbxref($pubDbxref)
    {
        $this->collPubDbxrefs[]= $pubDbxref;
        $pubDbxref->setDbxref($this);
    }

    /**
     * @param	PubDbxref $pubDbxref The pubDbxref object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removePubDbxref($pubDbxref)
    {
        if ($this->getPubDbxrefs()->contains($pubDbxref)) {
            $this->collPubDbxrefs->remove($this->collPubDbxrefs->search($pubDbxref));
            if (null === $this->pubDbxrefsScheduledForDeletion) {
                $this->pubDbxrefsScheduledForDeletion = clone $this->collPubDbxrefs;
                $this->pubDbxrefsScheduledForDeletion->clear();
            }
            $this->pubDbxrefsScheduledForDeletion[]= clone $pubDbxref;
            $pubDbxref->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related PubDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubDbxref[] List of PubDbxref objects
     */
    public function getPubDbxrefsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubDbxrefQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getPubDbxrefs($query, $con);
    }

    /**
     * Clears out the collStudys collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Dbxref The current object (for fluent API support)
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
     * If this Dbxref is new, it will return
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
                    ->filterByDbxref($this)
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
     * @return Dbxref The current object (for fluent API support)
     */
    public function setStudys(PropelCollection $studys, PropelPDO $con = null)
    {
        $studysToDelete = $this->getStudys(new Criteria(), $con)->diff($studys);

        $this->studysScheduledForDeletion = unserialize(serialize($studysToDelete));

        foreach ($studysToDelete as $studyRemoved) {
            $studyRemoved->setDbxref(null);
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
                ->filterByDbxref($this)
                ->count($con);
        }

        return count($this->collStudys);
    }

    /**
     * Method called to associate a Study object to this object
     * through the Study foreign key attribute.
     *
     * @param    Study $l Study
     * @return Dbxref The current object (for fluent API support)
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
        $study->setDbxref($this);
    }

    /**
     * @param	Study $study The study object to remove.
     * @return Dbxref The current object (for fluent API support)
     */
    public function removeStudy($study)
    {
        if ($this->getStudys()->contains($study)) {
            $this->collStudys->remove($this->collStudys->search($study));
            if (null === $this->studysScheduledForDeletion) {
                $this->studysScheduledForDeletion = clone $this->collStudys;
                $this->studysScheduledForDeletion->clear();
            }
            $this->studysScheduledForDeletion[]= $study;
            $study->setDbxref(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Studys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Study[] List of Study objects
     */
    public function getStudysJoinContact($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = StudyQuery::create(null, $criteria);
        $query->joinWith('Contact', $join_behavior);

        return $this->getStudys($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Dbxref is new, it will return
     * an empty collection; or if this Dbxref has previously
     * been saved, it will retrieve related Studys from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Dbxref.
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
        $this->dbxref_id = null;
        $this->db_id = null;
        $this->accession = null;
        $this->version = null;
        $this->description = null;
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
            if ($this->collBiomaterialDbxrefs) {
                foreach ($this->collBiomaterialDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvterms) {
                foreach ($this->collCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collCvtermDbxrefs) {
                foreach ($this->collCvtermDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collDbxrefprops) {
                foreach ($this->collDbxrefprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElements) {
                foreach ($this->collElements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatures) {
                foreach ($this->collFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermDbxrefs) {
                foreach ($this->collFeatureCvtermDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureDbxrefs) {
                foreach ($this->collFeatureDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collOrganismDbxrefs) {
                foreach ($this->collOrganismDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProtocols) {
                foreach ($this->collProtocols as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubDbxrefs) {
                foreach ($this->collPubDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collStudys) {
                foreach ($this->collStudys as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aDb instanceof Persistent) {
              $this->aDb->clearAllReferences($deep);
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
        if ($this->collBiomaterialDbxrefs instanceof PropelCollection) {
            $this->collBiomaterialDbxrefs->clearIterator();
        }
        $this->collBiomaterialDbxrefs = null;
        if ($this->collCvterms instanceof PropelCollection) {
            $this->collCvterms->clearIterator();
        }
        $this->collCvterms = null;
        if ($this->collCvtermDbxrefs instanceof PropelCollection) {
            $this->collCvtermDbxrefs->clearIterator();
        }
        $this->collCvtermDbxrefs = null;
        if ($this->collDbxrefprops instanceof PropelCollection) {
            $this->collDbxrefprops->clearIterator();
        }
        $this->collDbxrefprops = null;
        if ($this->collElements instanceof PropelCollection) {
            $this->collElements->clearIterator();
        }
        $this->collElements = null;
        if ($this->collFeatures instanceof PropelCollection) {
            $this->collFeatures->clearIterator();
        }
        $this->collFeatures = null;
        if ($this->collFeatureCvtermDbxrefs instanceof PropelCollection) {
            $this->collFeatureCvtermDbxrefs->clearIterator();
        }
        $this->collFeatureCvtermDbxrefs = null;
        if ($this->collFeatureDbxrefs instanceof PropelCollection) {
            $this->collFeatureDbxrefs->clearIterator();
        }
        $this->collFeatureDbxrefs = null;
        if ($this->collOrganismDbxrefs instanceof PropelCollection) {
            $this->collOrganismDbxrefs->clearIterator();
        }
        $this->collOrganismDbxrefs = null;
        if ($this->collProtocols instanceof PropelCollection) {
            $this->collProtocols->clearIterator();
        }
        $this->collProtocols = null;
        if ($this->collPubDbxrefs instanceof PropelCollection) {
            $this->collPubDbxrefs->clearIterator();
        }
        $this->collPubDbxrefs = null;
        if ($this->collStudys instanceof PropelCollection) {
            $this->collStudys->clearIterator();
        }
        $this->collStudys = null;
        $this->aDb = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(DbxrefPeer::DEFAULT_STRING_FORMAT);
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
