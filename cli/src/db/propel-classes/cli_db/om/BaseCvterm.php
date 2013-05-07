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
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\BiomaterialRelationshipQuery;
use cli_db\propel\Biomaterialprop;
use cli_db\propel\BiomaterialpropQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Cv;
use cli_db\propel\CvQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermPeer;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\FeatureCvtermpropQuery;
use cli_db\propel\FeatureQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubQuery;
use cli_db\propel\PubRelationship;
use cli_db\propel\PubRelationshipQuery;
use cli_db\propel\Pubprop;
use cli_db\propel\PubpropQuery;
use cli_db\propel\Synonym;
use cli_db\propel\SynonymQuery;

/**
 * Base class that represents a row from the 'cvterm' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvterm extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\CvtermPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        CvtermPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the cvterm_id field.
     * @var        int
     */
    protected $cvterm_id;

    /**
     * The value for the cv_id field.
     * @var        int
     */
    protected $cv_id;

    /**
     * The value for the name field.
     * @var        string
     */
    protected $name;

    /**
     * The value for the definition field.
     * @var        string
     */
    protected $definition;

    /**
     * The value for the dbxref_id field.
     * @var        int
     */
    protected $dbxref_id;

    /**
     * The value for the is_obsolete field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_obsolete;

    /**
     * The value for the is_relationshiptype field.
     * Note: this column has a database default value of: 0
     * @var        int
     */
    protected $is_relationshiptype;

    /**
     * @var        Cv
     */
    protected $aCv;

    /**
     * @var        PropelObjectCollection|BiomaterialRelationship[] Collection to store aggregation of BiomaterialRelationship objects.
     */
    protected $collBiomaterialRelationships;
    protected $collBiomaterialRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Biomaterialprop[] Collection to store aggregation of Biomaterialprop objects.
     */
    protected $collBiomaterialprops;
    protected $collBiomaterialpropsPartial;

    /**
     * @var        PropelObjectCollection|Contact[] Collection to store aggregation of Contact objects.
     */
    protected $collContacts;
    protected $collContactsPartial;

    /**
     * @var        PropelObjectCollection|Feature[] Collection to store aggregation of Feature objects.
     */
    protected $collFeatures;
    protected $collFeaturesPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvterm[] Collection to store aggregation of FeatureCvterm objects.
     */
    protected $collFeatureCvterms;
    protected $collFeatureCvtermsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermprop[] Collection to store aggregation of FeatureCvtermprop objects.
     */
    protected $collFeatureCvtermprops;
    protected $collFeatureCvtermpropsPartial;

    /**
     * @var        PropelObjectCollection|Protocol[] Collection to store aggregation of Protocol objects.
     */
    protected $collProtocols;
    protected $collProtocolsPartial;

    /**
     * @var        PropelObjectCollection|Pub[] Collection to store aggregation of Pub objects.
     */
    protected $collPubs;
    protected $collPubsPartial;

    /**
     * @var        PropelObjectCollection|PubRelationship[] Collection to store aggregation of PubRelationship objects.
     */
    protected $collPubRelationships;
    protected $collPubRelationshipsPartial;

    /**
     * @var        PropelObjectCollection|Pubprop[] Collection to store aggregation of Pubprop objects.
     */
    protected $collPubprops;
    protected $collPubpropsPartial;

    /**
     * @var        PropelObjectCollection|Synonym[] Collection to store aggregation of Synonym objects.
     */
    protected $collSynonyms;
    protected $collSynonymsPartial;

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
    protected $biomaterialRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $biomaterialpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $contactsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featuresScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $protocolsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubRelationshipsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $synonymsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_obsolete = 0;
        $this->is_relationshiptype = 0;
    }

    /**
     * Initializes internal state of BaseCvterm object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
    }

    /**
     * Get the [cvterm_id] column value.
     *
     * @return int
     */
    public function getCvtermId()
    {
        return $this->cvterm_id;
    }

    /**
     * Get the [cv_id] column value.
     *
     * @return int
     */
    public function getCvId()
    {
        return $this->cv_id;
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
     * Get the [definition] column value.
     *
     * @return string
     */
    public function getDefinition()
    {
        return $this->definition;
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
     * Get the [is_obsolete] column value.
     *
     * @return int
     */
    public function getIsObsolete()
    {
        return $this->is_obsolete;
    }

    /**
     * Get the [is_relationshiptype] column value.
     *
     * @return int
     */
    public function getIsRelationshiptype()
    {
        return $this->is_relationshiptype;
    }

    /**
     * Set the value of [cvterm_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvtermId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cvterm_id !== $v) {
            $this->cvterm_id = $v;
            $this->modifiedColumns[] = CvtermPeer::CVTERM_ID;
        }


        return $this;
    } // setCvtermId()

    /**
     * Set the value of [cv_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setCvId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->cv_id !== $v) {
            $this->cv_id = $v;
            $this->modifiedColumns[] = CvtermPeer::CV_ID;
        }

        if ($this->aCv !== null && $this->aCv->getCvId() !== $v) {
            $this->aCv = null;
        }


        return $this;
    } // setCvId()

    /**
     * Set the value of [name] column.
     *
     * @param string $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = CvtermPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [definition] column.
     *
     * @param string $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setDefinition($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->definition !== $v) {
            $this->definition = $v;
            $this->modifiedColumns[] = CvtermPeer::DEFINITION;
        }


        return $this;
    } // setDefinition()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = CvtermPeer::DBXREF_ID;
        }


        return $this;
    } // setDbxrefId()

    /**
     * Set the value of [is_obsolete] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setIsObsolete($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_obsolete !== $v) {
            $this->is_obsolete = $v;
            $this->modifiedColumns[] = CvtermPeer::IS_OBSOLETE;
        }


        return $this;
    } // setIsObsolete()

    /**
     * Set the value of [is_relationshiptype] column.
     *
     * @param int $v new value
     * @return Cvterm The current object (for fluent API support)
     */
    public function setIsRelationshiptype($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->is_relationshiptype !== $v) {
            $this->is_relationshiptype = $v;
            $this->modifiedColumns[] = CvtermPeer::IS_RELATIONSHIPTYPE;
        }


        return $this;
    } // setIsRelationshiptype()

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
            if ($this->is_obsolete !== 0) {
                return false;
            }

            if ($this->is_relationshiptype !== 0) {
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

            $this->cvterm_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->cv_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->name = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->definition = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->dbxref_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->is_obsolete = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->is_relationshiptype = ($row[$startcol + 6] !== null) ? (int) $row[$startcol + 6] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 7; // 7 = CvtermPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Cvterm object", $e);
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

        if ($this->aCv !== null && $this->cv_id !== $this->aCv->getCvId()) {
            $this->aCv = null;
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
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = CvtermPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCv = null;
            $this->collBiomaterialRelationships = null;

            $this->collBiomaterialprops = null;

            $this->collContacts = null;

            $this->collFeatures = null;

            $this->collFeatureCvterms = null;

            $this->collFeatureCvtermprops = null;

            $this->collProtocols = null;

            $this->collPubs = null;

            $this->collPubRelationships = null;

            $this->collPubprops = null;

            $this->collSynonyms = null;

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
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = CvtermQuery::create()
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
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                CvtermPeer::addInstanceToPool($this);
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

            if ($this->aCv !== null) {
                if ($this->aCv->isModified() || $this->aCv->isNew()) {
                    $affectedRows += $this->aCv->save($con);
                }
                $this->setCv($this->aCv);
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

            if ($this->biomaterialRelationshipsScheduledForDeletion !== null) {
                if (!$this->biomaterialRelationshipsScheduledForDeletion->isEmpty()) {
                    BiomaterialRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialRelationships !== null) {
                foreach ($this->collBiomaterialRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->biomaterialpropsScheduledForDeletion !== null) {
                if (!$this->biomaterialpropsScheduledForDeletion->isEmpty()) {
                    BiomaterialpropQuery::create()
                        ->filterByPrimaryKeys($this->biomaterialpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->biomaterialpropsScheduledForDeletion = null;
                }
            }

            if ($this->collBiomaterialprops !== null) {
                foreach ($this->collBiomaterialprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->contactsScheduledForDeletion !== null) {
                if (!$this->contactsScheduledForDeletion->isEmpty()) {
                    foreach ($this->contactsScheduledForDeletion as $contact) {
                        // need to save related object because we set the relation to null
                        $contact->save($con);
                    }
                    $this->contactsScheduledForDeletion = null;
                }
            }

            if ($this->collContacts !== null) {
                foreach ($this->collContacts as $referrerFK) {
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

            if ($this->featureCvtermsScheduledForDeletion !== null) {
                if (!$this->featureCvtermsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvterms !== null) {
                foreach ($this->collFeatureCvterms as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureCvtermpropsScheduledForDeletion !== null) {
                if (!$this->featureCvtermpropsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermpropQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermpropsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermprops !== null) {
                foreach ($this->collFeatureCvtermprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->protocolsScheduledForDeletion !== null) {
                if (!$this->protocolsScheduledForDeletion->isEmpty()) {
                    ProtocolQuery::create()
                        ->filterByPrimaryKeys($this->protocolsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

            if ($this->pubsScheduledForDeletion !== null) {
                if (!$this->pubsScheduledForDeletion->isEmpty()) {
                    PubQuery::create()
                        ->filterByPrimaryKeys($this->pubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubsScheduledForDeletion = null;
                }
            }

            if ($this->collPubs !== null) {
                foreach ($this->collPubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubRelationshipsScheduledForDeletion !== null) {
                if (!$this->pubRelationshipsScheduledForDeletion->isEmpty()) {
                    PubRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->pubRelationshipsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubRelationshipsScheduledForDeletion = null;
                }
            }

            if ($this->collPubRelationships !== null) {
                foreach ($this->collPubRelationships as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubpropsScheduledForDeletion !== null) {
                if (!$this->pubpropsScheduledForDeletion->isEmpty()) {
                    PubpropQuery::create()
                        ->filterByPrimaryKeys($this->pubpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubpropsScheduledForDeletion = null;
                }
            }

            if ($this->collPubprops !== null) {
                foreach ($this->collPubprops as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->synonymsScheduledForDeletion !== null) {
                if (!$this->synonymsScheduledForDeletion->isEmpty()) {
                    SynonymQuery::create()
                        ->filterByPrimaryKeys($this->synonymsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->synonymsScheduledForDeletion = null;
                }
            }

            if ($this->collSynonyms !== null) {
                foreach ($this->collSynonyms as $referrerFK) {
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

        $this->modifiedColumns[] = CvtermPeer::CVTERM_ID;
        if (null !== $this->cvterm_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . CvtermPeer::CVTERM_ID . ')');
        }
        if (null === $this->cvterm_id) {
            try {
                $stmt = $con->query("SELECT nextval('cvterm_cvterm_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->cvterm_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(CvtermPeer::CVTERM_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cvterm_id"';
        }
        if ($this->isColumnModified(CvtermPeer::CV_ID)) {
            $modifiedColumns[':p' . $index++]  = '"cv_id"';
        }
        if ($this->isColumnModified(CvtermPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(CvtermPeer::DEFINITION)) {
            $modifiedColumns[':p' . $index++]  = '"definition"';
        }
        if ($this->isColumnModified(CvtermPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(CvtermPeer::IS_OBSOLETE)) {
            $modifiedColumns[':p' . $index++]  = '"is_obsolete"';
        }
        if ($this->isColumnModified(CvtermPeer::IS_RELATIONSHIPTYPE)) {
            $modifiedColumns[':p' . $index++]  = '"is_relationshiptype"';
        }

        $sql = sprintf(
            'INSERT INTO "cvterm" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"cvterm_id"':
                        $stmt->bindValue($identifier, $this->cvterm_id, PDO::PARAM_INT);
                        break;
                    case '"cv_id"':
                        $stmt->bindValue($identifier, $this->cv_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"definition"':
                        $stmt->bindValue($identifier, $this->definition, PDO::PARAM_STR);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"is_obsolete"':
                        $stmt->bindValue($identifier, $this->is_obsolete, PDO::PARAM_INT);
                        break;
                    case '"is_relationshiptype"':
                        $stmt->bindValue($identifier, $this->is_relationshiptype, PDO::PARAM_INT);
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

            if ($this->aCv !== null) {
                if (!$this->aCv->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCv->getValidationFailures());
                }
            }


            if (($retval = CvtermPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collBiomaterialRelationships !== null) {
                    foreach ($this->collBiomaterialRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collBiomaterialprops !== null) {
                    foreach ($this->collBiomaterialprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collContacts !== null) {
                    foreach ($this->collContacts as $referrerFK) {
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

                if ($this->collFeatureCvterms !== null) {
                    foreach ($this->collFeatureCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvtermprops !== null) {
                    foreach ($this->collFeatureCvtermprops as $referrerFK) {
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

                if ($this->collPubs !== null) {
                    foreach ($this->collPubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubRelationships !== null) {
                    foreach ($this->collPubRelationships as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubprops !== null) {
                    foreach ($this->collPubprops as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collSynonyms !== null) {
                    foreach ($this->collSynonyms as $referrerFK) {
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
        $pos = CvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getCvtermId();
                break;
            case 1:
                return $this->getCvId();
                break;
            case 2:
                return $this->getName();
                break;
            case 3:
                return $this->getDefinition();
                break;
            case 4:
                return $this->getDbxrefId();
                break;
            case 5:
                return $this->getIsObsolete();
                break;
            case 6:
                return $this->getIsRelationshiptype();
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
        if (isset($alreadyDumpedObjects['Cvterm'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Cvterm'][$this->getPrimaryKey()] = true;
        $keys = CvtermPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getCvtermId(),
            $keys[1] => $this->getCvId(),
            $keys[2] => $this->getName(),
            $keys[3] => $this->getDefinition(),
            $keys[4] => $this->getDbxrefId(),
            $keys[5] => $this->getIsObsolete(),
            $keys[6] => $this->getIsRelationshiptype(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCv) {
                $result['Cv'] = $this->aCv->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collBiomaterialRelationships) {
                $result['BiomaterialRelationships'] = $this->collBiomaterialRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collBiomaterialprops) {
                $result['Biomaterialprops'] = $this->collBiomaterialprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collContacts) {
                $result['Contacts'] = $this->collContacts->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatures) {
                $result['Features'] = $this->collFeatures->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvterms) {
                $result['FeatureCvterms'] = $this->collFeatureCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermprops) {
                $result['FeatureCvtermprops'] = $this->collFeatureCvtermprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collProtocols) {
                $result['Protocols'] = $this->collProtocols->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubs) {
                $result['Pubs'] = $this->collPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubRelationships) {
                $result['PubRelationships'] = $this->collPubRelationships->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubprops) {
                $result['Pubprops'] = $this->collPubprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collSynonyms) {
                $result['Synonyms'] = $this->collSynonyms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = CvtermPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setCvtermId($value);
                break;
            case 1:
                $this->setCvId($value);
                break;
            case 2:
                $this->setName($value);
                break;
            case 3:
                $this->setDefinition($value);
                break;
            case 4:
                $this->setDbxrefId($value);
                break;
            case 5:
                $this->setIsObsolete($value);
                break;
            case 6:
                $this->setIsRelationshiptype($value);
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
        $keys = CvtermPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setCvtermId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setCvId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setName($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setDefinition($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setDbxrefId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIsObsolete($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setIsRelationshiptype($arr[$keys[6]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(CvtermPeer::DATABASE_NAME);

        if ($this->isColumnModified(CvtermPeer::CVTERM_ID)) $criteria->add(CvtermPeer::CVTERM_ID, $this->cvterm_id);
        if ($this->isColumnModified(CvtermPeer::CV_ID)) $criteria->add(CvtermPeer::CV_ID, $this->cv_id);
        if ($this->isColumnModified(CvtermPeer::NAME)) $criteria->add(CvtermPeer::NAME, $this->name);
        if ($this->isColumnModified(CvtermPeer::DEFINITION)) $criteria->add(CvtermPeer::DEFINITION, $this->definition);
        if ($this->isColumnModified(CvtermPeer::DBXREF_ID)) $criteria->add(CvtermPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(CvtermPeer::IS_OBSOLETE)) $criteria->add(CvtermPeer::IS_OBSOLETE, $this->is_obsolete);
        if ($this->isColumnModified(CvtermPeer::IS_RELATIONSHIPTYPE)) $criteria->add(CvtermPeer::IS_RELATIONSHIPTYPE, $this->is_relationshiptype);

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
        $criteria = new Criteria(CvtermPeer::DATABASE_NAME);
        $criteria->add(CvtermPeer::CVTERM_ID, $this->cvterm_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getCvtermId();
    }

    /**
     * Generic method to set the primary key (cvterm_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setCvtermId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getCvtermId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Cvterm (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setCvId($this->getCvId());
        $copyObj->setName($this->getName());
        $copyObj->setDefinition($this->getDefinition());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setIsObsolete($this->getIsObsolete());
        $copyObj->setIsRelationshiptype($this->getIsRelationshiptype());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getBiomaterialRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getBiomaterialprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addBiomaterialprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getContacts() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addContact($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatures() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeature($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getProtocols() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addProtocol($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubRelationships() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubRelationship($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getSynonyms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addSynonym($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setCvtermId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Cvterm Clone of current object.
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
     * @return CvtermPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new CvtermPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cv object.
     *
     * @param             Cv $v
     * @return Cvterm The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCv(Cv $v = null)
    {
        if ($v === null) {
            $this->setCvId(NULL);
        } else {
            $this->setCvId($v->getCvId());
        }

        $this->aCv = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cv object, it will not be re-added.
        if ($v !== null) {
            $v->addCvterm($this);
        }


        return $this;
    }


    /**
     * Get the associated Cv object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Cv The associated Cv object.
     * @throws PropelException
     */
    public function getCv(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCv === null && ($this->cv_id !== null) && $doQuery) {
            $this->aCv = CvQuery::create()->findPk($this->cv_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCv->addCvterms($this);
             */
        }

        return $this->aCv;
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
        if ('BiomaterialRelationship' == $relationName) {
            $this->initBiomaterialRelationships();
        }
        if ('Biomaterialprop' == $relationName) {
            $this->initBiomaterialprops();
        }
        if ('Contact' == $relationName) {
            $this->initContacts();
        }
        if ('Feature' == $relationName) {
            $this->initFeatures();
        }
        if ('FeatureCvterm' == $relationName) {
            $this->initFeatureCvterms();
        }
        if ('FeatureCvtermprop' == $relationName) {
            $this->initFeatureCvtermprops();
        }
        if ('Protocol' == $relationName) {
            $this->initProtocols();
        }
        if ('Pub' == $relationName) {
            $this->initPubs();
        }
        if ('PubRelationship' == $relationName) {
            $this->initPubRelationships();
        }
        if ('Pubprop' == $relationName) {
            $this->initPubprops();
        }
        if ('Synonym' == $relationName) {
            $this->initSynonyms();
        }
    }

    /**
     * Clears out the collBiomaterialRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addBiomaterialRelationships()
     */
    public function clearBiomaterialRelationships()
    {
        $this->collBiomaterialRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialRelationships($v = true)
    {
        $this->collBiomaterialRelationshipsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialRelationships collection.
     *
     * By default this just sets the collBiomaterialRelationships collection to an empty array (like clearcollBiomaterialRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialRelationships($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialRelationships && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialRelationships = new PropelObjectCollection();
        $this->collBiomaterialRelationships->setModel('BiomaterialRelationship');
    }

    /**
     * Gets an array of BiomaterialRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     * @throws PropelException
     */
    public function getBiomaterialRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationships) {
                // return empty collection
                $this->initBiomaterialRelationships();
            } else {
                $collBiomaterialRelationships = BiomaterialRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialRelationshipsPartial && count($collBiomaterialRelationships)) {
                      $this->initBiomaterialRelationships(false);

                      foreach($collBiomaterialRelationships as $obj) {
                        if (false == $this->collBiomaterialRelationships->contains($obj)) {
                          $this->collBiomaterialRelationships->append($obj);
                        }
                      }

                      $this->collBiomaterialRelationshipsPartial = true;
                    }

                    $collBiomaterialRelationships->getInternalIterator()->rewind();
                    return $collBiomaterialRelationships;
                }

                if($partial && $this->collBiomaterialRelationships) {
                    foreach($this->collBiomaterialRelationships as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialRelationships[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialRelationships = $collBiomaterialRelationships;
                $this->collBiomaterialRelationshipsPartial = false;
            }
        }

        return $this->collBiomaterialRelationships;
    }

    /**
     * Sets a collection of BiomaterialRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setBiomaterialRelationships(PropelCollection $biomaterialRelationships, PropelPDO $con = null)
    {
        $biomaterialRelationshipsToDelete = $this->getBiomaterialRelationships(new Criteria(), $con)->diff($biomaterialRelationships);

        $this->biomaterialRelationshipsScheduledForDeletion = unserialize(serialize($biomaterialRelationshipsToDelete));

        foreach ($biomaterialRelationshipsToDelete as $biomaterialRelationshipRemoved) {
            $biomaterialRelationshipRemoved->setCvterm(null);
        }

        $this->collBiomaterialRelationships = null;
        foreach ($biomaterialRelationships as $biomaterialRelationship) {
            $this->addBiomaterialRelationship($biomaterialRelationship);
        }

        $this->collBiomaterialRelationships = $biomaterialRelationships;
        $this->collBiomaterialRelationshipsPartial = false;

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
    public function countBiomaterialRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialRelationshipsPartial && !$this->isNew();
        if (null === $this->collBiomaterialRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialRelationships());
            }
            $query = BiomaterialRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collBiomaterialRelationships);
    }

    /**
     * Method called to associate a BiomaterialRelationship object to this object
     * through the BiomaterialRelationship foreign key attribute.
     *
     * @param    BiomaterialRelationship $l BiomaterialRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addBiomaterialRelationship(BiomaterialRelationship $l)
    {
        if ($this->collBiomaterialRelationships === null) {
            $this->initBiomaterialRelationships();
            $this->collBiomaterialRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialRelationship($l);
        }

        return $this;
    }

    /**
     * @param	BiomaterialRelationship $biomaterialRelationship The biomaterialRelationship object to add.
     */
    protected function doAddBiomaterialRelationship($biomaterialRelationship)
    {
        $this->collBiomaterialRelationships[]= $biomaterialRelationship;
        $biomaterialRelationship->setCvterm($this);
    }

    /**
     * @param	BiomaterialRelationship $biomaterialRelationship The biomaterialRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeBiomaterialRelationship($biomaterialRelationship)
    {
        if ($this->getBiomaterialRelationships()->contains($biomaterialRelationship)) {
            $this->collBiomaterialRelationships->remove($this->collBiomaterialRelationships->search($biomaterialRelationship));
            if (null === $this->biomaterialRelationshipsScheduledForDeletion) {
                $this->biomaterialRelationshipsScheduledForDeletion = clone $this->collBiomaterialRelationships;
                $this->biomaterialRelationshipsScheduledForDeletion->clear();
            }
            $this->biomaterialRelationshipsScheduledForDeletion[]= clone $biomaterialRelationship;
            $biomaterialRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsJoinBiomaterialRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('BiomaterialRelatedByObjectId', $join_behavior);

        return $this->getBiomaterialRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related BiomaterialRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|BiomaterialRelationship[] List of BiomaterialRelationship objects
     */
    public function getBiomaterialRelationshipsJoinBiomaterialRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialRelationshipQuery::create(null, $criteria);
        $query->joinWith('BiomaterialRelatedBySubjectId', $join_behavior);

        return $this->getBiomaterialRelationships($query, $con);
    }

    /**
     * Clears out the collBiomaterialprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addBiomaterialprops()
     */
    public function clearBiomaterialprops()
    {
        $this->collBiomaterialprops = null; // important to set this to null since that means it is uninitialized
        $this->collBiomaterialpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collBiomaterialprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialBiomaterialprops($v = true)
    {
        $this->collBiomaterialpropsPartial = $v;
    }

    /**
     * Initializes the collBiomaterialprops collection.
     *
     * By default this just sets the collBiomaterialprops collection to an empty array (like clearcollBiomaterialprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initBiomaterialprops($overrideExisting = true)
    {
        if (null !== $this->collBiomaterialprops && !$overrideExisting) {
            return;
        }
        $this->collBiomaterialprops = new PropelObjectCollection();
        $this->collBiomaterialprops->setModel('Biomaterialprop');
    }

    /**
     * Gets an array of Biomaterialprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Biomaterialprop[] List of Biomaterialprop objects
     * @throws PropelException
     */
    public function getBiomaterialprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialpropsPartial && !$this->isNew();
        if (null === $this->collBiomaterialprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialprops) {
                // return empty collection
                $this->initBiomaterialprops();
            } else {
                $collBiomaterialprops = BiomaterialpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collBiomaterialpropsPartial && count($collBiomaterialprops)) {
                      $this->initBiomaterialprops(false);

                      foreach($collBiomaterialprops as $obj) {
                        if (false == $this->collBiomaterialprops->contains($obj)) {
                          $this->collBiomaterialprops->append($obj);
                        }
                      }

                      $this->collBiomaterialpropsPartial = true;
                    }

                    $collBiomaterialprops->getInternalIterator()->rewind();
                    return $collBiomaterialprops;
                }

                if($partial && $this->collBiomaterialprops) {
                    foreach($this->collBiomaterialprops as $obj) {
                        if($obj->isNew()) {
                            $collBiomaterialprops[] = $obj;
                        }
                    }
                }

                $this->collBiomaterialprops = $collBiomaterialprops;
                $this->collBiomaterialpropsPartial = false;
            }
        }

        return $this->collBiomaterialprops;
    }

    /**
     * Sets a collection of Biomaterialprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $biomaterialprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setBiomaterialprops(PropelCollection $biomaterialprops, PropelPDO $con = null)
    {
        $biomaterialpropsToDelete = $this->getBiomaterialprops(new Criteria(), $con)->diff($biomaterialprops);

        $this->biomaterialpropsScheduledForDeletion = unserialize(serialize($biomaterialpropsToDelete));

        foreach ($biomaterialpropsToDelete as $biomaterialpropRemoved) {
            $biomaterialpropRemoved->setCvterm(null);
        }

        $this->collBiomaterialprops = null;
        foreach ($biomaterialprops as $biomaterialprop) {
            $this->addBiomaterialprop($biomaterialprop);
        }

        $this->collBiomaterialprops = $biomaterialprops;
        $this->collBiomaterialpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Biomaterialprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Biomaterialprop objects.
     * @throws PropelException
     */
    public function countBiomaterialprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collBiomaterialpropsPartial && !$this->isNew();
        if (null === $this->collBiomaterialprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collBiomaterialprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getBiomaterialprops());
            }
            $query = BiomaterialpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collBiomaterialprops);
    }

    /**
     * Method called to associate a Biomaterialprop object to this object
     * through the Biomaterialprop foreign key attribute.
     *
     * @param    Biomaterialprop $l Biomaterialprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addBiomaterialprop(Biomaterialprop $l)
    {
        if ($this->collBiomaterialprops === null) {
            $this->initBiomaterialprops();
            $this->collBiomaterialpropsPartial = true;
        }
        if (!in_array($l, $this->collBiomaterialprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddBiomaterialprop($l);
        }

        return $this;
    }

    /**
     * @param	Biomaterialprop $biomaterialprop The biomaterialprop object to add.
     */
    protected function doAddBiomaterialprop($biomaterialprop)
    {
        $this->collBiomaterialprops[]= $biomaterialprop;
        $biomaterialprop->setCvterm($this);
    }

    /**
     * @param	Biomaterialprop $biomaterialprop The biomaterialprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeBiomaterialprop($biomaterialprop)
    {
        if ($this->getBiomaterialprops()->contains($biomaterialprop)) {
            $this->collBiomaterialprops->remove($this->collBiomaterialprops->search($biomaterialprop));
            if (null === $this->biomaterialpropsScheduledForDeletion) {
                $this->biomaterialpropsScheduledForDeletion = clone $this->collBiomaterialprops;
                $this->biomaterialpropsScheduledForDeletion->clear();
            }
            $this->biomaterialpropsScheduledForDeletion[]= clone $biomaterialprop;
            $biomaterialprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Biomaterialprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Biomaterialprop[] List of Biomaterialprop objects
     */
    public function getBiomaterialpropsJoinBiomaterial($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = BiomaterialpropQuery::create(null, $criteria);
        $query->joinWith('Biomaterial', $join_behavior);

        return $this->getBiomaterialprops($query, $con);
    }

    /**
     * Clears out the collContacts collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addContacts()
     */
    public function clearContacts()
    {
        $this->collContacts = null; // important to set this to null since that means it is uninitialized
        $this->collContactsPartial = null;

        return $this;
    }

    /**
     * reset is the collContacts collection loaded partially
     *
     * @return void
     */
    public function resetPartialContacts($v = true)
    {
        $this->collContactsPartial = $v;
    }

    /**
     * Initializes the collContacts collection.
     *
     * By default this just sets the collContacts collection to an empty array (like clearcollContacts());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initContacts($overrideExisting = true)
    {
        if (null !== $this->collContacts && !$overrideExisting) {
            return;
        }
        $this->collContacts = new PropelObjectCollection();
        $this->collContacts->setModel('Contact');
    }

    /**
     * Gets an array of Contact objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Contact[] List of Contact objects
     * @throws PropelException
     */
    public function getContacts($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                // return empty collection
                $this->initContacts();
            } else {
                $collContacts = ContactQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collContactsPartial && count($collContacts)) {
                      $this->initContacts(false);

                      foreach($collContacts as $obj) {
                        if (false == $this->collContacts->contains($obj)) {
                          $this->collContacts->append($obj);
                        }
                      }

                      $this->collContactsPartial = true;
                    }

                    $collContacts->getInternalIterator()->rewind();
                    return $collContacts;
                }

                if($partial && $this->collContacts) {
                    foreach($this->collContacts as $obj) {
                        if($obj->isNew()) {
                            $collContacts[] = $obj;
                        }
                    }
                }

                $this->collContacts = $collContacts;
                $this->collContactsPartial = false;
            }
        }

        return $this->collContacts;
    }

    /**
     * Sets a collection of Contact objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $contacts A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setContacts(PropelCollection $contacts, PropelPDO $con = null)
    {
        $contactsToDelete = $this->getContacts(new Criteria(), $con)->diff($contacts);

        $this->contactsScheduledForDeletion = unserialize(serialize($contactsToDelete));

        foreach ($contactsToDelete as $contactRemoved) {
            $contactRemoved->setCvterm(null);
        }

        $this->collContacts = null;
        foreach ($contacts as $contact) {
            $this->addContact($contact);
        }

        $this->collContacts = $contacts;
        $this->collContactsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Contact objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Contact objects.
     * @throws PropelException
     */
    public function countContacts(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collContactsPartial && !$this->isNew();
        if (null === $this->collContacts || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collContacts) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getContacts());
            }
            $query = ContactQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collContacts);
    }

    /**
     * Method called to associate a Contact object to this object
     * through the Contact foreign key attribute.
     *
     * @param    Contact $l Contact
     * @return Cvterm The current object (for fluent API support)
     */
    public function addContact(Contact $l)
    {
        if ($this->collContacts === null) {
            $this->initContacts();
            $this->collContactsPartial = true;
        }
        if (!in_array($l, $this->collContacts->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddContact($l);
        }

        return $this;
    }

    /**
     * @param	Contact $contact The contact object to add.
     */
    protected function doAddContact($contact)
    {
        $this->collContacts[]= $contact;
        $contact->setCvterm($this);
    }

    /**
     * @param	Contact $contact The contact object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeContact($contact)
    {
        if ($this->getContacts()->contains($contact)) {
            $this->collContacts->remove($this->collContacts->search($contact));
            if (null === $this->contactsScheduledForDeletion) {
                $this->contactsScheduledForDeletion = clone $this->collContacts;
                $this->contactsScheduledForDeletion->clear();
            }
            $this->contactsScheduledForDeletion[]= $contact;
            $contact->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collFeatures collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
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
     * If this Cvterm is new, it will return
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
                    ->filterByCvterm($this)
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
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatures(PropelCollection $features, PropelPDO $con = null)
    {
        $featuresToDelete = $this->getFeatures(new Criteria(), $con)->diff($features);

        $this->featuresScheduledForDeletion = unserialize(serialize($featuresToDelete));

        foreach ($featuresToDelete as $featureRemoved) {
            $featureRemoved->setCvterm(null);
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
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatures);
    }

    /**
     * Method called to associate a Feature object to this object
     * through the Feature foreign key attribute.
     *
     * @param    Feature $l Feature
     * @return Cvterm The current object (for fluent API support)
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
        $feature->setCvterm($this);
    }

    /**
     * @param	Feature $feature The feature object to remove.
     * @return Cvterm The current object (for fluent API support)
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
            $feature->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
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
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Features from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
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
     * Clears out the collFeatureCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureCvterms()
     */
    public function clearFeatureCvterms()
    {
        $this->collFeatureCvterms = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvterms collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvterms($v = true)
    {
        $this->collFeatureCvtermsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvterms collection.
     *
     * By default this just sets the collFeatureCvterms collection to an empty array (like clearcollFeatureCvterms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvterms($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvterms && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvterms = new PropelObjectCollection();
        $this->collFeatureCvterms->setModel('FeatureCvterm');
    }

    /**
     * Gets an array of FeatureCvterm objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     * @throws PropelException
     */
    public function getFeatureCvterms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermsPartial && !$this->isNew();
        if (null === $this->collFeatureCvterms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvterms) {
                // return empty collection
                $this->initFeatureCvterms();
            } else {
                $collFeatureCvterms = FeatureCvtermQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermsPartial && count($collFeatureCvterms)) {
                      $this->initFeatureCvterms(false);

                      foreach($collFeatureCvterms as $obj) {
                        if (false == $this->collFeatureCvterms->contains($obj)) {
                          $this->collFeatureCvterms->append($obj);
                        }
                      }

                      $this->collFeatureCvtermsPartial = true;
                    }

                    $collFeatureCvterms->getInternalIterator()->rewind();
                    return $collFeatureCvterms;
                }

                if($partial && $this->collFeatureCvterms) {
                    foreach($this->collFeatureCvterms as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvterms[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvterms = $collFeatureCvterms;
                $this->collFeatureCvtermsPartial = false;
            }
        }

        return $this->collFeatureCvterms;
    }

    /**
     * Sets a collection of FeatureCvterm objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvterms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureCvterms(PropelCollection $featureCvterms, PropelPDO $con = null)
    {
        $featureCvtermsToDelete = $this->getFeatureCvterms(new Criteria(), $con)->diff($featureCvterms);

        $this->featureCvtermsScheduledForDeletion = unserialize(serialize($featureCvtermsToDelete));

        foreach ($featureCvtermsToDelete as $featureCvtermRemoved) {
            $featureCvtermRemoved->setCvterm(null);
        }

        $this->collFeatureCvterms = null;
        foreach ($featureCvterms as $featureCvterm) {
            $this->addFeatureCvterm($featureCvterm);
        }

        $this->collFeatureCvterms = $featureCvterms;
        $this->collFeatureCvtermsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvterm objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvterm objects.
     * @throws PropelException
     */
    public function countFeatureCvterms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermsPartial && !$this->isNew();
        if (null === $this->collFeatureCvterms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvterms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvterms());
            }
            $query = FeatureCvtermQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvterms);
    }

    /**
     * Method called to associate a FeatureCvterm object to this object
     * through the FeatureCvterm foreign key attribute.
     *
     * @param    FeatureCvterm $l FeatureCvterm
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureCvterm(FeatureCvterm $l)
    {
        if ($this->collFeatureCvterms === null) {
            $this->initFeatureCvterms();
            $this->collFeatureCvtermsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvterms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvterm($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to add.
     */
    protected function doAddFeatureCvterm($featureCvterm)
    {
        $this->collFeatureCvterms[]= $featureCvterm;
        $featureCvterm->setCvterm($this);
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureCvterm($featureCvterm)
    {
        if ($this->getFeatureCvterms()->contains($featureCvterm)) {
            $this->collFeatureCvterms->remove($this->collFeatureCvterms->search($featureCvterm));
            if (null === $this->featureCvtermsScheduledForDeletion) {
                $this->featureCvtermsScheduledForDeletion = clone $this->collFeatureCvterms;
                $this->featureCvtermsScheduledForDeletion->clear();
            }
            $this->featureCvtermsScheduledForDeletion[]= clone $featureCvterm;
            $featureCvterm->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }

    /**
     * Clears out the collFeatureCvtermprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addFeatureCvtermprops()
     */
    public function clearFeatureCvtermprops()
    {
        $this->collFeatureCvtermprops = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermprops($v = true)
    {
        $this->collFeatureCvtermpropsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermprops collection.
     *
     * By default this just sets the collFeatureCvtermprops collection to an empty array (like clearcollFeatureCvtermprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermprops($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermprops && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermprops = new PropelObjectCollection();
        $this->collFeatureCvtermprops->setModel('FeatureCvtermprop');
    }

    /**
     * Gets an array of FeatureCvtermprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermprop[] List of FeatureCvtermprop objects
     * @throws PropelException
     */
    public function getFeatureCvtermprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermpropsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermprops) {
                // return empty collection
                $this->initFeatureCvtermprops();
            } else {
                $collFeatureCvtermprops = FeatureCvtermpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermpropsPartial && count($collFeatureCvtermprops)) {
                      $this->initFeatureCvtermprops(false);

                      foreach($collFeatureCvtermprops as $obj) {
                        if (false == $this->collFeatureCvtermprops->contains($obj)) {
                          $this->collFeatureCvtermprops->append($obj);
                        }
                      }

                      $this->collFeatureCvtermpropsPartial = true;
                    }

                    $collFeatureCvtermprops->getInternalIterator()->rewind();
                    return $collFeatureCvtermprops;
                }

                if($partial && $this->collFeatureCvtermprops) {
                    foreach($this->collFeatureCvtermprops as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermprops[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermprops = $collFeatureCvtermprops;
                $this->collFeatureCvtermpropsPartial = false;
            }
        }

        return $this->collFeatureCvtermprops;
    }

    /**
     * Sets a collection of FeatureCvtermprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setFeatureCvtermprops(PropelCollection $featureCvtermprops, PropelPDO $con = null)
    {
        $featureCvtermpropsToDelete = $this->getFeatureCvtermprops(new Criteria(), $con)->diff($featureCvtermprops);

        $this->featureCvtermpropsScheduledForDeletion = unserialize(serialize($featureCvtermpropsToDelete));

        foreach ($featureCvtermpropsToDelete as $featureCvtermpropRemoved) {
            $featureCvtermpropRemoved->setCvterm(null);
        }

        $this->collFeatureCvtermprops = null;
        foreach ($featureCvtermprops as $featureCvtermprop) {
            $this->addFeatureCvtermprop($featureCvtermprop);
        }

        $this->collFeatureCvtermprops = $featureCvtermprops;
        $this->collFeatureCvtermpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermprop objects.
     * @throws PropelException
     */
    public function countFeatureCvtermprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermpropsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermprops());
            }
            $query = FeatureCvtermpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermprops);
    }

    /**
     * Method called to associate a FeatureCvtermprop object to this object
     * through the FeatureCvtermprop foreign key attribute.
     *
     * @param    FeatureCvtermprop $l FeatureCvtermprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addFeatureCvtermprop(FeatureCvtermprop $l)
    {
        if ($this->collFeatureCvtermprops === null) {
            $this->initFeatureCvtermprops();
            $this->collFeatureCvtermpropsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermprop($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermprop $featureCvtermprop The featureCvtermprop object to add.
     */
    protected function doAddFeatureCvtermprop($featureCvtermprop)
    {
        $this->collFeatureCvtermprops[]= $featureCvtermprop;
        $featureCvtermprop->setCvterm($this);
    }

    /**
     * @param	FeatureCvtermprop $featureCvtermprop The featureCvtermprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeFeatureCvtermprop($featureCvtermprop)
    {
        if ($this->getFeatureCvtermprops()->contains($featureCvtermprop)) {
            $this->collFeatureCvtermprops->remove($this->collFeatureCvtermprops->search($featureCvtermprop));
            if (null === $this->featureCvtermpropsScheduledForDeletion) {
                $this->featureCvtermpropsScheduledForDeletion = clone $this->collFeatureCvtermprops;
                $this->featureCvtermpropsScheduledForDeletion->clear();
            }
            $this->featureCvtermpropsScheduledForDeletion[]= clone $featureCvtermprop;
            $featureCvtermprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related FeatureCvtermprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermprop[] List of FeatureCvtermprop objects
     */
    public function getFeatureCvtermpropsJoinFeatureCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermpropQuery::create(null, $criteria);
        $query->joinWith('FeatureCvterm', $join_behavior);

        return $this->getFeatureCvtermprops($query, $con);
    }

    /**
     * Clears out the collProtocols collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
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
     * If this Cvterm is new, it will return
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
                    ->filterByCvterm($this)
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
     * @return Cvterm The current object (for fluent API support)
     */
    public function setProtocols(PropelCollection $protocols, PropelPDO $con = null)
    {
        $protocolsToDelete = $this->getProtocols(new Criteria(), $con)->diff($protocols);

        $this->protocolsScheduledForDeletion = unserialize(serialize($protocolsToDelete));

        foreach ($protocolsToDelete as $protocolRemoved) {
            $protocolRemoved->setCvterm(null);
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
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collProtocols);
    }

    /**
     * Method called to associate a Protocol object to this object
     * through the Protocol foreign key attribute.
     *
     * @param    Protocol $l Protocol
     * @return Cvterm The current object (for fluent API support)
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
        $protocol->setCvterm($this);
    }

    /**
     * @param	Protocol $protocol The protocol object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeProtocol($protocol)
    {
        if ($this->getProtocols()->contains($protocol)) {
            $this->collProtocols->remove($this->collProtocols->search($protocol));
            if (null === $this->protocolsScheduledForDeletion) {
                $this->protocolsScheduledForDeletion = clone $this->collProtocols;
                $this->protocolsScheduledForDeletion->clear();
            }
            $this->protocolsScheduledForDeletion[]= clone $protocol;
            $protocol->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubs()
     */
    public function clearPubs()
    {
        $this->collPubs = null; // important to set this to null since that means it is uninitialized
        $this->collPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubs($v = true)
    {
        $this->collPubsPartial = $v;
    }

    /**
     * Initializes the collPubs collection.
     *
     * By default this just sets the collPubs collection to an empty array (like clearcollPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubs($overrideExisting = true)
    {
        if (null !== $this->collPubs && !$overrideExisting) {
            return;
        }
        $this->collPubs = new PropelObjectCollection();
        $this->collPubs->setModel('Pub');
    }

    /**
     * Gets an array of Pub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Pub[] List of Pub objects
     * @throws PropelException
     */
    public function getPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubsPartial && !$this->isNew();
        if (null === $this->collPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubs) {
                // return empty collection
                $this->initPubs();
            } else {
                $collPubs = PubQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubsPartial && count($collPubs)) {
                      $this->initPubs(false);

                      foreach($collPubs as $obj) {
                        if (false == $this->collPubs->contains($obj)) {
                          $this->collPubs->append($obj);
                        }
                      }

                      $this->collPubsPartial = true;
                    }

                    $collPubs->getInternalIterator()->rewind();
                    return $collPubs;
                }

                if($partial && $this->collPubs) {
                    foreach($this->collPubs as $obj) {
                        if($obj->isNew()) {
                            $collPubs[] = $obj;
                        }
                    }
                }

                $this->collPubs = $collPubs;
                $this->collPubsPartial = false;
            }
        }

        return $this->collPubs;
    }

    /**
     * Sets a collection of Pub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubs(PropelCollection $pubs, PropelPDO $con = null)
    {
        $pubsToDelete = $this->getPubs(new Criteria(), $con)->diff($pubs);

        $this->pubsScheduledForDeletion = unserialize(serialize($pubsToDelete));

        foreach ($pubsToDelete as $pubRemoved) {
            $pubRemoved->setCvterm(null);
        }

        $this->collPubs = null;
        foreach ($pubs as $pub) {
            $this->addPub($pub);
        }

        $this->collPubs = $pubs;
        $this->collPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Pub objects.
     * @throws PropelException
     */
    public function countPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubsPartial && !$this->isNew();
        if (null === $this->collPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubs());
            }
            $query = PubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubs);
    }

    /**
     * Method called to associate a Pub object to this object
     * through the Pub foreign key attribute.
     *
     * @param    Pub $l Pub
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPub(Pub $l)
    {
        if ($this->collPubs === null) {
            $this->initPubs();
            $this->collPubsPartial = true;
        }
        if (!in_array($l, $this->collPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPub($l);
        }

        return $this;
    }

    /**
     * @param	Pub $pub The pub object to add.
     */
    protected function doAddPub($pub)
    {
        $this->collPubs[]= $pub;
        $pub->setCvterm($this);
    }

    /**
     * @param	Pub $pub The pub object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePub($pub)
    {
        if ($this->getPubs()->contains($pub)) {
            $this->collPubs->remove($this->collPubs->search($pub));
            if (null === $this->pubsScheduledForDeletion) {
                $this->pubsScheduledForDeletion = clone $this->collPubs;
                $this->pubsScheduledForDeletion->clear();
            }
            $this->pubsScheduledForDeletion[]= clone $pub;
            $pub->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears out the collPubRelationships collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubRelationships()
     */
    public function clearPubRelationships()
    {
        $this->collPubRelationships = null; // important to set this to null since that means it is uninitialized
        $this->collPubRelationshipsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubRelationships collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubRelationships($v = true)
    {
        $this->collPubRelationshipsPartial = $v;
    }

    /**
     * Initializes the collPubRelationships collection.
     *
     * By default this just sets the collPubRelationships collection to an empty array (like clearcollPubRelationships());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubRelationships($overrideExisting = true)
    {
        if (null !== $this->collPubRelationships && !$overrideExisting) {
            return;
        }
        $this->collPubRelationships = new PropelObjectCollection();
        $this->collPubRelationships->setModel('PubRelationship');
    }

    /**
     * Gets an array of PubRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     * @throws PropelException
     */
    public function getPubRelationships($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsPartial && !$this->isNew();
        if (null === $this->collPubRelationships || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubRelationships) {
                // return empty collection
                $this->initPubRelationships();
            } else {
                $collPubRelationships = PubRelationshipQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubRelationshipsPartial && count($collPubRelationships)) {
                      $this->initPubRelationships(false);

                      foreach($collPubRelationships as $obj) {
                        if (false == $this->collPubRelationships->contains($obj)) {
                          $this->collPubRelationships->append($obj);
                        }
                      }

                      $this->collPubRelationshipsPartial = true;
                    }

                    $collPubRelationships->getInternalIterator()->rewind();
                    return $collPubRelationships;
                }

                if($partial && $this->collPubRelationships) {
                    foreach($this->collPubRelationships as $obj) {
                        if($obj->isNew()) {
                            $collPubRelationships[] = $obj;
                        }
                    }
                }

                $this->collPubRelationships = $collPubRelationships;
                $this->collPubRelationshipsPartial = false;
            }
        }

        return $this->collPubRelationships;
    }

    /**
     * Sets a collection of PubRelationship objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubRelationships A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubRelationships(PropelCollection $pubRelationships, PropelPDO $con = null)
    {
        $pubRelationshipsToDelete = $this->getPubRelationships(new Criteria(), $con)->diff($pubRelationships);

        $this->pubRelationshipsScheduledForDeletion = unserialize(serialize($pubRelationshipsToDelete));

        foreach ($pubRelationshipsToDelete as $pubRelationshipRemoved) {
            $pubRelationshipRemoved->setCvterm(null);
        }

        $this->collPubRelationships = null;
        foreach ($pubRelationships as $pubRelationship) {
            $this->addPubRelationship($pubRelationship);
        }

        $this->collPubRelationships = $pubRelationships;
        $this->collPubRelationshipsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related PubRelationship objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related PubRelationship objects.
     * @throws PropelException
     */
    public function countPubRelationships(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsPartial && !$this->isNew();
        if (null === $this->collPubRelationships || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubRelationships) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubRelationships());
            }
            $query = PubRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubRelationships);
    }

    /**
     * Method called to associate a PubRelationship object to this object
     * through the PubRelationship foreign key attribute.
     *
     * @param    PubRelationship $l PubRelationship
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPubRelationship(PubRelationship $l)
    {
        if ($this->collPubRelationships === null) {
            $this->initPubRelationships();
            $this->collPubRelationshipsPartial = true;
        }
        if (!in_array($l, $this->collPubRelationships->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubRelationship($l);
        }

        return $this;
    }

    /**
     * @param	PubRelationship $pubRelationship The pubRelationship object to add.
     */
    protected function doAddPubRelationship($pubRelationship)
    {
        $this->collPubRelationships[]= $pubRelationship;
        $pubRelationship->setCvterm($this);
    }

    /**
     * @param	PubRelationship $pubRelationship The pubRelationship object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePubRelationship($pubRelationship)
    {
        if ($this->getPubRelationships()->contains($pubRelationship)) {
            $this->collPubRelationships->remove($this->collPubRelationships->search($pubRelationship));
            if (null === $this->pubRelationshipsScheduledForDeletion) {
                $this->pubRelationshipsScheduledForDeletion = clone $this->collPubRelationships;
                $this->pubRelationshipsScheduledForDeletion->clear();
            }
            $this->pubRelationshipsScheduledForDeletion[]= clone $pubRelationship;
            $pubRelationship->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related PubRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsJoinPubRelatedByObjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('PubRelatedByObjectId', $join_behavior);

        return $this->getPubRelationships($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related PubRelationships from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsJoinPubRelatedBySubjectId($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('PubRelatedBySubjectId', $join_behavior);

        return $this->getPubRelationships($query, $con);
    }

    /**
     * Clears out the collPubprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addPubprops()
     */
    public function clearPubprops()
    {
        $this->collPubprops = null; // important to set this to null since that means it is uninitialized
        $this->collPubpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubprops($v = true)
    {
        $this->collPubpropsPartial = $v;
    }

    /**
     * Initializes the collPubprops collection.
     *
     * By default this just sets the collPubprops collection to an empty array (like clearcollPubprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubprops($overrideExisting = true)
    {
        if (null !== $this->collPubprops && !$overrideExisting) {
            return;
        }
        $this->collPubprops = new PropelObjectCollection();
        $this->collPubprops->setModel('Pubprop');
    }

    /**
     * Gets an array of Pubprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Pubprop[] List of Pubprop objects
     * @throws PropelException
     */
    public function getPubprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubpropsPartial && !$this->isNew();
        if (null === $this->collPubprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubprops) {
                // return empty collection
                $this->initPubprops();
            } else {
                $collPubprops = PubpropQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubpropsPartial && count($collPubprops)) {
                      $this->initPubprops(false);

                      foreach($collPubprops as $obj) {
                        if (false == $this->collPubprops->contains($obj)) {
                          $this->collPubprops->append($obj);
                        }
                      }

                      $this->collPubpropsPartial = true;
                    }

                    $collPubprops->getInternalIterator()->rewind();
                    return $collPubprops;
                }

                if($partial && $this->collPubprops) {
                    foreach($this->collPubprops as $obj) {
                        if($obj->isNew()) {
                            $collPubprops[] = $obj;
                        }
                    }
                }

                $this->collPubprops = $collPubprops;
                $this->collPubpropsPartial = false;
            }
        }

        return $this->collPubprops;
    }

    /**
     * Sets a collection of Pubprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setPubprops(PropelCollection $pubprops, PropelPDO $con = null)
    {
        $pubpropsToDelete = $this->getPubprops(new Criteria(), $con)->diff($pubprops);

        $this->pubpropsScheduledForDeletion = unserialize(serialize($pubpropsToDelete));

        foreach ($pubpropsToDelete as $pubpropRemoved) {
            $pubpropRemoved->setCvterm(null);
        }

        $this->collPubprops = null;
        foreach ($pubprops as $pubprop) {
            $this->addPubprop($pubprop);
        }

        $this->collPubprops = $pubprops;
        $this->collPubpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pubprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Pubprop objects.
     * @throws PropelException
     */
    public function countPubprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubpropsPartial && !$this->isNew();
        if (null === $this->collPubprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubprops());
            }
            $query = PubpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collPubprops);
    }

    /**
     * Method called to associate a Pubprop object to this object
     * through the Pubprop foreign key attribute.
     *
     * @param    Pubprop $l Pubprop
     * @return Cvterm The current object (for fluent API support)
     */
    public function addPubprop(Pubprop $l)
    {
        if ($this->collPubprops === null) {
            $this->initPubprops();
            $this->collPubpropsPartial = true;
        }
        if (!in_array($l, $this->collPubprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubprop($l);
        }

        return $this;
    }

    /**
     * @param	Pubprop $pubprop The pubprop object to add.
     */
    protected function doAddPubprop($pubprop)
    {
        $this->collPubprops[]= $pubprop;
        $pubprop->setCvterm($this);
    }

    /**
     * @param	Pubprop $pubprop The pubprop object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removePubprop($pubprop)
    {
        if ($this->getPubprops()->contains($pubprop)) {
            $this->collPubprops->remove($this->collPubprops->search($pubprop));
            if (null === $this->pubpropsScheduledForDeletion) {
                $this->pubpropsScheduledForDeletion = clone $this->collPubprops;
                $this->pubpropsScheduledForDeletion->clear();
            }
            $this->pubpropsScheduledForDeletion[]= clone $pubprop;
            $pubprop->setCvterm(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Cvterm is new, it will return
     * an empty collection; or if this Cvterm has previously
     * been saved, it will retrieve related Pubprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Cvterm.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Pubprop[] List of Pubprop objects
     */
    public function getPubpropsJoinPub($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubpropQuery::create(null, $criteria);
        $query->joinWith('Pub', $join_behavior);

        return $this->getPubprops($query, $con);
    }

    /**
     * Clears out the collSynonyms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Cvterm The current object (for fluent API support)
     * @see        addSynonyms()
     */
    public function clearSynonyms()
    {
        $this->collSynonyms = null; // important to set this to null since that means it is uninitialized
        $this->collSynonymsPartial = null;

        return $this;
    }

    /**
     * reset is the collSynonyms collection loaded partially
     *
     * @return void
     */
    public function resetPartialSynonyms($v = true)
    {
        $this->collSynonymsPartial = $v;
    }

    /**
     * Initializes the collSynonyms collection.
     *
     * By default this just sets the collSynonyms collection to an empty array (like clearcollSynonyms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initSynonyms($overrideExisting = true)
    {
        if (null !== $this->collSynonyms && !$overrideExisting) {
            return;
        }
        $this->collSynonyms = new PropelObjectCollection();
        $this->collSynonyms->setModel('Synonym');
    }

    /**
     * Gets an array of Synonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Cvterm is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Synonym[] List of Synonym objects
     * @throws PropelException
     */
    public function getSynonyms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collSynonymsPartial && !$this->isNew();
        if (null === $this->collSynonyms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collSynonyms) {
                // return empty collection
                $this->initSynonyms();
            } else {
                $collSynonyms = SynonymQuery::create(null, $criteria)
                    ->filterByCvterm($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collSynonymsPartial && count($collSynonyms)) {
                      $this->initSynonyms(false);

                      foreach($collSynonyms as $obj) {
                        if (false == $this->collSynonyms->contains($obj)) {
                          $this->collSynonyms->append($obj);
                        }
                      }

                      $this->collSynonymsPartial = true;
                    }

                    $collSynonyms->getInternalIterator()->rewind();
                    return $collSynonyms;
                }

                if($partial && $this->collSynonyms) {
                    foreach($this->collSynonyms as $obj) {
                        if($obj->isNew()) {
                            $collSynonyms[] = $obj;
                        }
                    }
                }

                $this->collSynonyms = $collSynonyms;
                $this->collSynonymsPartial = false;
            }
        }

        return $this->collSynonyms;
    }

    /**
     * Sets a collection of Synonym objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $synonyms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Cvterm The current object (for fluent API support)
     */
    public function setSynonyms(PropelCollection $synonyms, PropelPDO $con = null)
    {
        $synonymsToDelete = $this->getSynonyms(new Criteria(), $con)->diff($synonyms);

        $this->synonymsScheduledForDeletion = unserialize(serialize($synonymsToDelete));

        foreach ($synonymsToDelete as $synonymRemoved) {
            $synonymRemoved->setCvterm(null);
        }

        $this->collSynonyms = null;
        foreach ($synonyms as $synonym) {
            $this->addSynonym($synonym);
        }

        $this->collSynonyms = $synonyms;
        $this->collSynonymsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Synonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Synonym objects.
     * @throws PropelException
     */
    public function countSynonyms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collSynonymsPartial && !$this->isNew();
        if (null === $this->collSynonyms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collSynonyms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getSynonyms());
            }
            $query = SynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByCvterm($this)
                ->count($con);
        }

        return count($this->collSynonyms);
    }

    /**
     * Method called to associate a Synonym object to this object
     * through the Synonym foreign key attribute.
     *
     * @param    Synonym $l Synonym
     * @return Cvterm The current object (for fluent API support)
     */
    public function addSynonym(Synonym $l)
    {
        if ($this->collSynonyms === null) {
            $this->initSynonyms();
            $this->collSynonymsPartial = true;
        }
        if (!in_array($l, $this->collSynonyms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddSynonym($l);
        }

        return $this;
    }

    /**
     * @param	Synonym $synonym The synonym object to add.
     */
    protected function doAddSynonym($synonym)
    {
        $this->collSynonyms[]= $synonym;
        $synonym->setCvterm($this);
    }

    /**
     * @param	Synonym $synonym The synonym object to remove.
     * @return Cvterm The current object (for fluent API support)
     */
    public function removeSynonym($synonym)
    {
        if ($this->getSynonyms()->contains($synonym)) {
            $this->collSynonyms->remove($this->collSynonyms->search($synonym));
            if (null === $this->synonymsScheduledForDeletion) {
                $this->synonymsScheduledForDeletion = clone $this->collSynonyms;
                $this->synonymsScheduledForDeletion->clear();
            }
            $this->synonymsScheduledForDeletion[]= clone $synonym;
            $synonym->setCvterm(null);
        }

        return $this;
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->cvterm_id = null;
        $this->cv_id = null;
        $this->name = null;
        $this->definition = null;
        $this->dbxref_id = null;
        $this->is_obsolete = null;
        $this->is_relationshiptype = null;
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
            if ($this->collBiomaterialRelationships) {
                foreach ($this->collBiomaterialRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collBiomaterialprops) {
                foreach ($this->collBiomaterialprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collContacts) {
                foreach ($this->collContacts as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatures) {
                foreach ($this->collFeatures as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvterms) {
                foreach ($this->collFeatureCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermprops) {
                foreach ($this->collFeatureCvtermprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collProtocols) {
                foreach ($this->collProtocols as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubs) {
                foreach ($this->collPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubRelationships) {
                foreach ($this->collPubRelationships as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubprops) {
                foreach ($this->collPubprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collSynonyms) {
                foreach ($this->collSynonyms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCv instanceof Persistent) {
              $this->aCv->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collBiomaterialRelationships instanceof PropelCollection) {
            $this->collBiomaterialRelationships->clearIterator();
        }
        $this->collBiomaterialRelationships = null;
        if ($this->collBiomaterialprops instanceof PropelCollection) {
            $this->collBiomaterialprops->clearIterator();
        }
        $this->collBiomaterialprops = null;
        if ($this->collContacts instanceof PropelCollection) {
            $this->collContacts->clearIterator();
        }
        $this->collContacts = null;
        if ($this->collFeatures instanceof PropelCollection) {
            $this->collFeatures->clearIterator();
        }
        $this->collFeatures = null;
        if ($this->collFeatureCvterms instanceof PropelCollection) {
            $this->collFeatureCvterms->clearIterator();
        }
        $this->collFeatureCvterms = null;
        if ($this->collFeatureCvtermprops instanceof PropelCollection) {
            $this->collFeatureCvtermprops->clearIterator();
        }
        $this->collFeatureCvtermprops = null;
        if ($this->collProtocols instanceof PropelCollection) {
            $this->collProtocols->clearIterator();
        }
        $this->collProtocols = null;
        if ($this->collPubs instanceof PropelCollection) {
            $this->collPubs->clearIterator();
        }
        $this->collPubs = null;
        if ($this->collPubRelationships instanceof PropelCollection) {
            $this->collPubRelationships->clearIterator();
        }
        $this->collPubRelationships = null;
        if ($this->collPubprops instanceof PropelCollection) {
            $this->collPubprops->clearIterator();
        }
        $this->collPubprops = null;
        if ($this->collSynonyms instanceof PropelCollection) {
            $this->collSynonyms->clearIterator();
        }
        $this->collSynonyms = null;
        $this->aCv = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(CvtermPeer::DEFAULT_STRING_FORMAT);
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
