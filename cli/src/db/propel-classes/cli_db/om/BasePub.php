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
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermPub;
use cli_db\propel\FeatureCvtermPubQuery;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeaturePub;
use cli_db\propel\FeaturePubQuery;
use cli_db\propel\FeatureSynonym;
use cli_db\propel\FeatureSynonymQuery;
use cli_db\propel\Pub;
use cli_db\propel\PubDbxref;
use cli_db\propel\PubDbxrefQuery;
use cli_db\propel\PubPeer;
use cli_db\propel\PubQuery;
use cli_db\propel\PubRelationship;
use cli_db\propel\PubRelationshipQuery;
use cli_db\propel\Pubauthor;
use cli_db\propel\PubauthorQuery;
use cli_db\propel\Pubprop;
use cli_db\propel\PubpropQuery;

/**
 * Base class that represents a row from the 'pub' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BasePub extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\PubPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        PubPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the pub_id field.
     * @var        int
     */
    protected $pub_id;

    /**
     * The value for the title field.
     * @var        string
     */
    protected $title;

    /**
     * The value for the volumetitle field.
     * @var        string
     */
    protected $volumetitle;

    /**
     * The value for the volume field.
     * @var        string
     */
    protected $volume;

    /**
     * The value for the series_name field.
     * @var        string
     */
    protected $series_name;

    /**
     * The value for the issue field.
     * @var        string
     */
    protected $issue;

    /**
     * The value for the pyear field.
     * @var        string
     */
    protected $pyear;

    /**
     * The value for the pages field.
     * @var        string
     */
    protected $pages;

    /**
     * The value for the miniref field.
     * @var        string
     */
    protected $miniref;

    /**
     * The value for the uniquename field.
     * @var        string
     */
    protected $uniquename;

    /**
     * The value for the type_id field.
     * @var        int
     */
    protected $type_id;

    /**
     * The value for the is_obsolete field.
     * Note: this column has a database default value of: false
     * @var        boolean
     */
    protected $is_obsolete;

    /**
     * The value for the publisher field.
     * @var        string
     */
    protected $publisher;

    /**
     * The value for the pubplace field.
     * @var        string
     */
    protected $pubplace;

    /**
     * @var        Cvterm
     */
    protected $aCvterm;

    /**
     * @var        PropelObjectCollection|FeatureCvterm[] Collection to store aggregation of FeatureCvterm objects.
     */
    protected $collFeatureCvterms;
    protected $collFeatureCvtermsPartial;

    /**
     * @var        PropelObjectCollection|FeatureCvtermPub[] Collection to store aggregation of FeatureCvtermPub objects.
     */
    protected $collFeatureCvtermPubs;
    protected $collFeatureCvtermPubsPartial;

    /**
     * @var        PropelObjectCollection|FeaturePub[] Collection to store aggregation of FeaturePub objects.
     */
    protected $collFeaturePubs;
    protected $collFeaturePubsPartial;

    /**
     * @var        PropelObjectCollection|FeatureSynonym[] Collection to store aggregation of FeatureSynonym objects.
     */
    protected $collFeatureSynonyms;
    protected $collFeatureSynonymsPartial;

    /**
     * @var        PropelObjectCollection|PubDbxref[] Collection to store aggregation of PubDbxref objects.
     */
    protected $collPubDbxrefs;
    protected $collPubDbxrefsPartial;

    /**
     * @var        PropelObjectCollection|PubRelationship[] Collection to store aggregation of PubRelationship objects.
     */
    protected $collPubRelationshipsRelatedByObjectId;
    protected $collPubRelationshipsRelatedByObjectIdPartial;

    /**
     * @var        PropelObjectCollection|PubRelationship[] Collection to store aggregation of PubRelationship objects.
     */
    protected $collPubRelationshipsRelatedBySubjectId;
    protected $collPubRelationshipsRelatedBySubjectIdPartial;

    /**
     * @var        PropelObjectCollection|Pubauthor[] Collection to store aggregation of Pubauthor objects.
     */
    protected $collPubauthors;
    protected $collPubauthorsPartial;

    /**
     * @var        PropelObjectCollection|Pubprop[] Collection to store aggregation of Pubprop objects.
     */
    protected $collPubprops;
    protected $collPubpropsPartial;

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
    protected $featureCvtermsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureCvtermPubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featurePubsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $featureSynonymsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubDbxrefsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubRelationshipsRelatedByObjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubRelationshipsRelatedBySubjectIdScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubauthorsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $pubpropsScheduledForDeletion = null;

    /**
     * Applies default values to this object.
     * This method should be called from the object's constructor (or
     * equivalent initialization method).
     * @see        __construct()
     */
    public function applyDefaultValues()
    {
        $this->is_obsolete = false;
    }

    /**
     * Initializes internal state of BasePub object.
     * @see        applyDefaults()
     */
    public function __construct()
    {
        parent::__construct();
        $this->applyDefaultValues();
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
     * Get the [title] column value.
     *
     * @return string
     */
    public function getTitle()
    {
        return $this->title;
    }

    /**
     * Get the [volumetitle] column value.
     *
     * @return string
     */
    public function getVolumetitle()
    {
        return $this->volumetitle;
    }

    /**
     * Get the [volume] column value.
     *
     * @return string
     */
    public function getVolume()
    {
        return $this->volume;
    }

    /**
     * Get the [series_name] column value.
     *
     * @return string
     */
    public function getSeriesName()
    {
        return $this->series_name;
    }

    /**
     * Get the [issue] column value.
     *
     * @return string
     */
    public function getIssue()
    {
        return $this->issue;
    }

    /**
     * Get the [pyear] column value.
     *
     * @return string
     */
    public function getPyear()
    {
        return $this->pyear;
    }

    /**
     * Get the [pages] column value.
     *
     * @return string
     */
    public function getPages()
    {
        return $this->pages;
    }

    /**
     * Get the [miniref] column value.
     *
     * @return string
     */
    public function getMiniref()
    {
        return $this->miniref;
    }

    /**
     * Get the [uniquename] column value.
     *
     * @return string
     */
    public function getUniquename()
    {
        return $this->uniquename;
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
     * Get the [is_obsolete] column value.
     *
     * @return boolean
     */
    public function getIsObsolete()
    {
        return $this->is_obsolete;
    }

    /**
     * Get the [publisher] column value.
     *
     * @return string
     */
    public function getPublisher()
    {
        return $this->publisher;
    }

    /**
     * Get the [pubplace] column value.
     *
     * @return string
     */
    public function getPubplace()
    {
        return $this->pubplace;
    }

    /**
     * Set the value of [pub_id] column.
     *
     * @param int $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setPubId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->pub_id !== $v) {
            $this->pub_id = $v;
            $this->modifiedColumns[] = PubPeer::PUB_ID;
        }


        return $this;
    } // setPubId()

    /**
     * Set the value of [title] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setTitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->title !== $v) {
            $this->title = $v;
            $this->modifiedColumns[] = PubPeer::TITLE;
        }


        return $this;
    } // setTitle()

    /**
     * Set the value of [volumetitle] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setVolumetitle($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->volumetitle !== $v) {
            $this->volumetitle = $v;
            $this->modifiedColumns[] = PubPeer::VOLUMETITLE;
        }


        return $this;
    } // setVolumetitle()

    /**
     * Set the value of [volume] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setVolume($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->volume !== $v) {
            $this->volume = $v;
            $this->modifiedColumns[] = PubPeer::VOLUME;
        }


        return $this;
    } // setVolume()

    /**
     * Set the value of [series_name] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setSeriesName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->series_name !== $v) {
            $this->series_name = $v;
            $this->modifiedColumns[] = PubPeer::SERIES_NAME;
        }


        return $this;
    } // setSeriesName()

    /**
     * Set the value of [issue] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setIssue($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->issue !== $v) {
            $this->issue = $v;
            $this->modifiedColumns[] = PubPeer::ISSUE;
        }


        return $this;
    } // setIssue()

    /**
     * Set the value of [pyear] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setPyear($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->pyear !== $v) {
            $this->pyear = $v;
            $this->modifiedColumns[] = PubPeer::PYEAR;
        }


        return $this;
    } // setPyear()

    /**
     * Set the value of [pages] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setPages($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->pages !== $v) {
            $this->pages = $v;
            $this->modifiedColumns[] = PubPeer::PAGES;
        }


        return $this;
    } // setPages()

    /**
     * Set the value of [miniref] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setMiniref($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->miniref !== $v) {
            $this->miniref = $v;
            $this->modifiedColumns[] = PubPeer::MINIREF;
        }


        return $this;
    } // setMiniref()

    /**
     * Set the value of [uniquename] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setUniquename($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->uniquename !== $v) {
            $this->uniquename = $v;
            $this->modifiedColumns[] = PubPeer::UNIQUENAME;
        }


        return $this;
    } // setUniquename()

    /**
     * Set the value of [type_id] column.
     *
     * @param int $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setTypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->type_id !== $v) {
            $this->type_id = $v;
            $this->modifiedColumns[] = PubPeer::TYPE_ID;
        }

        if ($this->aCvterm !== null && $this->aCvterm->getCvtermId() !== $v) {
            $this->aCvterm = null;
        }


        return $this;
    } // setTypeId()

    /**
     * Sets the value of the [is_obsolete] column.
     * Non-boolean arguments are converted using the following rules:
     *   * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *   * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     * Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     *
     * @param boolean|integer|string $v The new value
     * @return Pub The current object (for fluent API support)
     */
    public function setIsObsolete($v)
    {
        if ($v !== null) {
            if (is_string($v)) {
                $v = in_array(strtolower($v), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
            } else {
                $v = (boolean) $v;
            }
        }

        if ($this->is_obsolete !== $v) {
            $this->is_obsolete = $v;
            $this->modifiedColumns[] = PubPeer::IS_OBSOLETE;
        }


        return $this;
    } // setIsObsolete()

    /**
     * Set the value of [publisher] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setPublisher($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->publisher !== $v) {
            $this->publisher = $v;
            $this->modifiedColumns[] = PubPeer::PUBLISHER;
        }


        return $this;
    } // setPublisher()

    /**
     * Set the value of [pubplace] column.
     *
     * @param string $v new value
     * @return Pub The current object (for fluent API support)
     */
    public function setPubplace($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->pubplace !== $v) {
            $this->pubplace = $v;
            $this->modifiedColumns[] = PubPeer::PUBPLACE;
        }


        return $this;
    } // setPubplace()

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
            if ($this->is_obsolete !== false) {
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

            $this->pub_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->title = ($row[$startcol + 1] !== null) ? (string) $row[$startcol + 1] : null;
            $this->volumetitle = ($row[$startcol + 2] !== null) ? (string) $row[$startcol + 2] : null;
            $this->volume = ($row[$startcol + 3] !== null) ? (string) $row[$startcol + 3] : null;
            $this->series_name = ($row[$startcol + 4] !== null) ? (string) $row[$startcol + 4] : null;
            $this->issue = ($row[$startcol + 5] !== null) ? (string) $row[$startcol + 5] : null;
            $this->pyear = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->pages = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->miniref = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->uniquename = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->type_id = ($row[$startcol + 10] !== null) ? (int) $row[$startcol + 10] : null;
            $this->is_obsolete = ($row[$startcol + 11] !== null) ? (boolean) $row[$startcol + 11] : null;
            $this->publisher = ($row[$startcol + 12] !== null) ? (string) $row[$startcol + 12] : null;
            $this->pubplace = ($row[$startcol + 13] !== null) ? (string) $row[$startcol + 13] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 14; // 14 = PubPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Pub object", $e);
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
            $con = Propel::getConnection(PubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = PubPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aCvterm = null;
            $this->collFeatureCvterms = null;

            $this->collFeatureCvtermPubs = null;

            $this->collFeaturePubs = null;

            $this->collFeatureSynonyms = null;

            $this->collPubDbxrefs = null;

            $this->collPubRelationshipsRelatedByObjectId = null;

            $this->collPubRelationshipsRelatedBySubjectId = null;

            $this->collPubauthors = null;

            $this->collPubprops = null;

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
            $con = Propel::getConnection(PubPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = PubQuery::create()
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
            $con = Propel::getConnection(PubPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                PubPeer::addInstanceToPool($this);
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

            if ($this->featureCvtermPubsScheduledForDeletion !== null) {
                if (!$this->featureCvtermPubsScheduledForDeletion->isEmpty()) {
                    FeatureCvtermPubQuery::create()
                        ->filterByPrimaryKeys($this->featureCvtermPubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureCvtermPubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureCvtermPubs !== null) {
                foreach ($this->collFeatureCvtermPubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featurePubsScheduledForDeletion !== null) {
                if (!$this->featurePubsScheduledForDeletion->isEmpty()) {
                    FeaturePubQuery::create()
                        ->filterByPrimaryKeys($this->featurePubsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featurePubsScheduledForDeletion = null;
                }
            }

            if ($this->collFeaturePubs !== null) {
                foreach ($this->collFeaturePubs as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->featureSynonymsScheduledForDeletion !== null) {
                if (!$this->featureSynonymsScheduledForDeletion->isEmpty()) {
                    FeatureSynonymQuery::create()
                        ->filterByPrimaryKeys($this->featureSynonymsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->featureSynonymsScheduledForDeletion = null;
                }
            }

            if ($this->collFeatureSynonyms !== null) {
                foreach ($this->collFeatureSynonyms as $referrerFK) {
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

            if ($this->pubRelationshipsRelatedByObjectIdScheduledForDeletion !== null) {
                if (!$this->pubRelationshipsRelatedByObjectIdScheduledForDeletion->isEmpty()) {
                    PubRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->pubRelationshipsRelatedByObjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collPubRelationshipsRelatedByObjectId !== null) {
                foreach ($this->collPubRelationshipsRelatedByObjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion !== null) {
                if (!$this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion->isEmpty()) {
                    PubRelationshipQuery::create()
                        ->filterByPrimaryKeys($this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion = null;
                }
            }

            if ($this->collPubRelationshipsRelatedBySubjectId !== null) {
                foreach ($this->collPubRelationshipsRelatedBySubjectId as $referrerFK) {
                    if (!$referrerFK->isDeleted() && ($referrerFK->isNew() || $referrerFK->isModified())) {
                        $affectedRows += $referrerFK->save($con);
                    }
                }
            }

            if ($this->pubauthorsScheduledForDeletion !== null) {
                if (!$this->pubauthorsScheduledForDeletion->isEmpty()) {
                    PubauthorQuery::create()
                        ->filterByPrimaryKeys($this->pubauthorsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->pubauthorsScheduledForDeletion = null;
                }
            }

            if ($this->collPubauthors !== null) {
                foreach ($this->collPubauthors as $referrerFK) {
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

        $this->modifiedColumns[] = PubPeer::PUB_ID;
        if (null !== $this->pub_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . PubPeer::PUB_ID . ')');
        }
        if (null === $this->pub_id) {
            try {
                $stmt = $con->query("SELECT nextval('pub_pub_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->pub_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(PubPeer::PUB_ID)) {
            $modifiedColumns[':p' . $index++]  = '"pub_id"';
        }
        if ($this->isColumnModified(PubPeer::TITLE)) {
            $modifiedColumns[':p' . $index++]  = '"title"';
        }
        if ($this->isColumnModified(PubPeer::VOLUMETITLE)) {
            $modifiedColumns[':p' . $index++]  = '"volumetitle"';
        }
        if ($this->isColumnModified(PubPeer::VOLUME)) {
            $modifiedColumns[':p' . $index++]  = '"volume"';
        }
        if ($this->isColumnModified(PubPeer::SERIES_NAME)) {
            $modifiedColumns[':p' . $index++]  = '"series_name"';
        }
        if ($this->isColumnModified(PubPeer::ISSUE)) {
            $modifiedColumns[':p' . $index++]  = '"issue"';
        }
        if ($this->isColumnModified(PubPeer::PYEAR)) {
            $modifiedColumns[':p' . $index++]  = '"pyear"';
        }
        if ($this->isColumnModified(PubPeer::PAGES)) {
            $modifiedColumns[':p' . $index++]  = '"pages"';
        }
        if ($this->isColumnModified(PubPeer::MINIREF)) {
            $modifiedColumns[':p' . $index++]  = '"miniref"';
        }
        if ($this->isColumnModified(PubPeer::UNIQUENAME)) {
            $modifiedColumns[':p' . $index++]  = '"uniquename"';
        }
        if ($this->isColumnModified(PubPeer::TYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"type_id"';
        }
        if ($this->isColumnModified(PubPeer::IS_OBSOLETE)) {
            $modifiedColumns[':p' . $index++]  = '"is_obsolete"';
        }
        if ($this->isColumnModified(PubPeer::PUBLISHER)) {
            $modifiedColumns[':p' . $index++]  = '"publisher"';
        }
        if ($this->isColumnModified(PubPeer::PUBPLACE)) {
            $modifiedColumns[':p' . $index++]  = '"pubplace"';
        }

        $sql = sprintf(
            'INSERT INTO "pub" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"pub_id"':
                        $stmt->bindValue($identifier, $this->pub_id, PDO::PARAM_INT);
                        break;
                    case '"title"':
                        $stmt->bindValue($identifier, $this->title, PDO::PARAM_STR);
                        break;
                    case '"volumetitle"':
                        $stmt->bindValue($identifier, $this->volumetitle, PDO::PARAM_STR);
                        break;
                    case '"volume"':
                        $stmt->bindValue($identifier, $this->volume, PDO::PARAM_STR);
                        break;
                    case '"series_name"':
                        $stmt->bindValue($identifier, $this->series_name, PDO::PARAM_STR);
                        break;
                    case '"issue"':
                        $stmt->bindValue($identifier, $this->issue, PDO::PARAM_STR);
                        break;
                    case '"pyear"':
                        $stmt->bindValue($identifier, $this->pyear, PDO::PARAM_STR);
                        break;
                    case '"pages"':
                        $stmt->bindValue($identifier, $this->pages, PDO::PARAM_STR);
                        break;
                    case '"miniref"':
                        $stmt->bindValue($identifier, $this->miniref, PDO::PARAM_STR);
                        break;
                    case '"uniquename"':
                        $stmt->bindValue($identifier, $this->uniquename, PDO::PARAM_STR);
                        break;
                    case '"type_id"':
                        $stmt->bindValue($identifier, $this->type_id, PDO::PARAM_INT);
                        break;
                    case '"is_obsolete"':
                        $stmt->bindValue($identifier, $this->is_obsolete, PDO::PARAM_BOOL);
                        break;
                    case '"publisher"':
                        $stmt->bindValue($identifier, $this->publisher, PDO::PARAM_STR);
                        break;
                    case '"pubplace"':
                        $stmt->bindValue($identifier, $this->pubplace, PDO::PARAM_STR);
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


            if (($retval = PubPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collFeatureCvterms !== null) {
                    foreach ($this->collFeatureCvterms as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureCvtermPubs !== null) {
                    foreach ($this->collFeatureCvtermPubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeaturePubs !== null) {
                    foreach ($this->collFeaturePubs as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collFeatureSynonyms !== null) {
                    foreach ($this->collFeatureSynonyms as $referrerFK) {
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

                if ($this->collPubRelationshipsRelatedByObjectId !== null) {
                    foreach ($this->collPubRelationshipsRelatedByObjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubRelationshipsRelatedBySubjectId !== null) {
                    foreach ($this->collPubRelationshipsRelatedBySubjectId as $referrerFK) {
                        if (!$referrerFK->validate($columns)) {
                            $failureMap = array_merge($failureMap, $referrerFK->getValidationFailures());
                        }
                    }
                }

                if ($this->collPubauthors !== null) {
                    foreach ($this->collPubauthors as $referrerFK) {
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
        $pos = PubPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getPubId();
                break;
            case 1:
                return $this->getTitle();
                break;
            case 2:
                return $this->getVolumetitle();
                break;
            case 3:
                return $this->getVolume();
                break;
            case 4:
                return $this->getSeriesName();
                break;
            case 5:
                return $this->getIssue();
                break;
            case 6:
                return $this->getPyear();
                break;
            case 7:
                return $this->getPages();
                break;
            case 8:
                return $this->getMiniref();
                break;
            case 9:
                return $this->getUniquename();
                break;
            case 10:
                return $this->getTypeId();
                break;
            case 11:
                return $this->getIsObsolete();
                break;
            case 12:
                return $this->getPublisher();
                break;
            case 13:
                return $this->getPubplace();
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
        if (isset($alreadyDumpedObjects['Pub'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Pub'][$this->getPrimaryKey()] = true;
        $keys = PubPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getPubId(),
            $keys[1] => $this->getTitle(),
            $keys[2] => $this->getVolumetitle(),
            $keys[3] => $this->getVolume(),
            $keys[4] => $this->getSeriesName(),
            $keys[5] => $this->getIssue(),
            $keys[6] => $this->getPyear(),
            $keys[7] => $this->getPages(),
            $keys[8] => $this->getMiniref(),
            $keys[9] => $this->getUniquename(),
            $keys[10] => $this->getTypeId(),
            $keys[11] => $this->getIsObsolete(),
            $keys[12] => $this->getPublisher(),
            $keys[13] => $this->getPubplace(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aCvterm) {
                $result['Cvterm'] = $this->aCvterm->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collFeatureCvterms) {
                $result['FeatureCvterms'] = $this->collFeatureCvterms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureCvtermPubs) {
                $result['FeatureCvtermPubs'] = $this->collFeatureCvtermPubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeaturePubs) {
                $result['FeaturePubs'] = $this->collFeaturePubs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collFeatureSynonyms) {
                $result['FeatureSynonyms'] = $this->collFeatureSynonyms->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubDbxrefs) {
                $result['PubDbxrefs'] = $this->collPubDbxrefs->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubRelationshipsRelatedByObjectId) {
                $result['PubRelationshipsRelatedByObjectId'] = $this->collPubRelationshipsRelatedByObjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubRelationshipsRelatedBySubjectId) {
                $result['PubRelationshipsRelatedBySubjectId'] = $this->collPubRelationshipsRelatedBySubjectId->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubauthors) {
                $result['Pubauthors'] = $this->collPubauthors->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collPubprops) {
                $result['Pubprops'] = $this->collPubprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = PubPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setPubId($value);
                break;
            case 1:
                $this->setTitle($value);
                break;
            case 2:
                $this->setVolumetitle($value);
                break;
            case 3:
                $this->setVolume($value);
                break;
            case 4:
                $this->setSeriesName($value);
                break;
            case 5:
                $this->setIssue($value);
                break;
            case 6:
                $this->setPyear($value);
                break;
            case 7:
                $this->setPages($value);
                break;
            case 8:
                $this->setMiniref($value);
                break;
            case 9:
                $this->setUniquename($value);
                break;
            case 10:
                $this->setTypeId($value);
                break;
            case 11:
                $this->setIsObsolete($value);
                break;
            case 12:
                $this->setPublisher($value);
                break;
            case 13:
                $this->setPubplace($value);
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
        $keys = PubPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setPubId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setTitle($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setVolumetitle($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setVolume($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setSeriesName($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setIssue($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setPyear($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setPages($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setMiniref($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setUniquename($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setTypeId($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setIsObsolete($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setPublisher($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setPubplace($arr[$keys[13]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(PubPeer::DATABASE_NAME);

        if ($this->isColumnModified(PubPeer::PUB_ID)) $criteria->add(PubPeer::PUB_ID, $this->pub_id);
        if ($this->isColumnModified(PubPeer::TITLE)) $criteria->add(PubPeer::TITLE, $this->title);
        if ($this->isColumnModified(PubPeer::VOLUMETITLE)) $criteria->add(PubPeer::VOLUMETITLE, $this->volumetitle);
        if ($this->isColumnModified(PubPeer::VOLUME)) $criteria->add(PubPeer::VOLUME, $this->volume);
        if ($this->isColumnModified(PubPeer::SERIES_NAME)) $criteria->add(PubPeer::SERIES_NAME, $this->series_name);
        if ($this->isColumnModified(PubPeer::ISSUE)) $criteria->add(PubPeer::ISSUE, $this->issue);
        if ($this->isColumnModified(PubPeer::PYEAR)) $criteria->add(PubPeer::PYEAR, $this->pyear);
        if ($this->isColumnModified(PubPeer::PAGES)) $criteria->add(PubPeer::PAGES, $this->pages);
        if ($this->isColumnModified(PubPeer::MINIREF)) $criteria->add(PubPeer::MINIREF, $this->miniref);
        if ($this->isColumnModified(PubPeer::UNIQUENAME)) $criteria->add(PubPeer::UNIQUENAME, $this->uniquename);
        if ($this->isColumnModified(PubPeer::TYPE_ID)) $criteria->add(PubPeer::TYPE_ID, $this->type_id);
        if ($this->isColumnModified(PubPeer::IS_OBSOLETE)) $criteria->add(PubPeer::IS_OBSOLETE, $this->is_obsolete);
        if ($this->isColumnModified(PubPeer::PUBLISHER)) $criteria->add(PubPeer::PUBLISHER, $this->publisher);
        if ($this->isColumnModified(PubPeer::PUBPLACE)) $criteria->add(PubPeer::PUBPLACE, $this->pubplace);

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
        $criteria = new Criteria(PubPeer::DATABASE_NAME);
        $criteria->add(PubPeer::PUB_ID, $this->pub_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getPubId();
    }

    /**
     * Generic method to set the primary key (pub_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setPubId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getPubId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Pub (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setTitle($this->getTitle());
        $copyObj->setVolumetitle($this->getVolumetitle());
        $copyObj->setVolume($this->getVolume());
        $copyObj->setSeriesName($this->getSeriesName());
        $copyObj->setIssue($this->getIssue());
        $copyObj->setPyear($this->getPyear());
        $copyObj->setPages($this->getPages());
        $copyObj->setMiniref($this->getMiniref());
        $copyObj->setUniquename($this->getUniquename());
        $copyObj->setTypeId($this->getTypeId());
        $copyObj->setIsObsolete($this->getIsObsolete());
        $copyObj->setPublisher($this->getPublisher());
        $copyObj->setPubplace($this->getPubplace());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getFeatureCvterms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvterm($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureCvtermPubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureCvtermPub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeaturePubs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeaturePub($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getFeatureSynonyms() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addFeatureSynonym($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubDbxrefs() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubDbxref($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubRelationshipsRelatedByObjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubRelationshipRelatedByObjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubRelationshipsRelatedBySubjectId() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubRelationshipRelatedBySubjectId($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubauthors() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubauthor($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getPubprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addPubprop($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setPubId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Pub Clone of current object.
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
     * @return PubPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new PubPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Pub The current object (for fluent API support)
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
            $v->addPub($this);
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
                $this->aCvterm->addPubs($this);
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
        if ('FeatureCvterm' == $relationName) {
            $this->initFeatureCvterms();
        }
        if ('FeatureCvtermPub' == $relationName) {
            $this->initFeatureCvtermPubs();
        }
        if ('FeaturePub' == $relationName) {
            $this->initFeaturePubs();
        }
        if ('FeatureSynonym' == $relationName) {
            $this->initFeatureSynonyms();
        }
        if ('PubDbxref' == $relationName) {
            $this->initPubDbxrefs();
        }
        if ('PubRelationshipRelatedByObjectId' == $relationName) {
            $this->initPubRelationshipsRelatedByObjectId();
        }
        if ('PubRelationshipRelatedBySubjectId' == $relationName) {
            $this->initPubRelationshipsRelatedBySubjectId();
        }
        if ('Pubauthor' == $relationName) {
            $this->initPubauthors();
        }
        if ('Pubprop' == $relationName) {
            $this->initPubprops();
        }
    }

    /**
     * Clears out the collFeatureCvterms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
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
     * If this Pub is new, it will return
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
                    ->filterByPub($this)
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
     * @return Pub The current object (for fluent API support)
     */
    public function setFeatureCvterms(PropelCollection $featureCvterms, PropelPDO $con = null)
    {
        $featureCvtermsToDelete = $this->getFeatureCvterms(new Criteria(), $con)->diff($featureCvterms);

        $this->featureCvtermsScheduledForDeletion = unserialize(serialize($featureCvtermsToDelete));

        foreach ($featureCvtermsToDelete as $featureCvtermRemoved) {
            $featureCvtermRemoved->setPub(null);
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
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collFeatureCvterms);
    }

    /**
     * Method called to associate a FeatureCvterm object to this object
     * through the FeatureCvterm foreign key attribute.
     *
     * @param    FeatureCvterm $l FeatureCvterm
     * @return Pub The current object (for fluent API support)
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
        $featureCvterm->setPub($this);
    }

    /**
     * @param	FeatureCvterm $featureCvterm The featureCvterm object to remove.
     * @return Pub The current object (for fluent API support)
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
            $featureCvterm->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvterm[] List of FeatureCvterm objects
     */
    public function getFeatureCvtermsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getFeatureCvterms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeatureCvterms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
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
     * Clears out the collFeatureCvtermPubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addFeatureCvtermPubs()
     */
    public function clearFeatureCvtermPubs()
    {
        $this->collFeatureCvtermPubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureCvtermPubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureCvtermPubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureCvtermPubs($v = true)
    {
        $this->collFeatureCvtermPubsPartial = $v;
    }

    /**
     * Initializes the collFeatureCvtermPubs collection.
     *
     * By default this just sets the collFeatureCvtermPubs collection to an empty array (like clearcollFeatureCvtermPubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureCvtermPubs($overrideExisting = true)
    {
        if (null !== $this->collFeatureCvtermPubs && !$overrideExisting) {
            return;
        }
        $this->collFeatureCvtermPubs = new PropelObjectCollection();
        $this->collFeatureCvtermPubs->setModel('FeatureCvtermPub');
    }

    /**
     * Gets an array of FeatureCvtermPub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureCvtermPub[] List of FeatureCvtermPub objects
     * @throws PropelException
     */
    public function getFeatureCvtermPubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermPubsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermPubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermPubs) {
                // return empty collection
                $this->initFeatureCvtermPubs();
            } else {
                $collFeatureCvtermPubs = FeatureCvtermPubQuery::create(null, $criteria)
                    ->filterByPub($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureCvtermPubsPartial && count($collFeatureCvtermPubs)) {
                      $this->initFeatureCvtermPubs(false);

                      foreach($collFeatureCvtermPubs as $obj) {
                        if (false == $this->collFeatureCvtermPubs->contains($obj)) {
                          $this->collFeatureCvtermPubs->append($obj);
                        }
                      }

                      $this->collFeatureCvtermPubsPartial = true;
                    }

                    $collFeatureCvtermPubs->getInternalIterator()->rewind();
                    return $collFeatureCvtermPubs;
                }

                if($partial && $this->collFeatureCvtermPubs) {
                    foreach($this->collFeatureCvtermPubs as $obj) {
                        if($obj->isNew()) {
                            $collFeatureCvtermPubs[] = $obj;
                        }
                    }
                }

                $this->collFeatureCvtermPubs = $collFeatureCvtermPubs;
                $this->collFeatureCvtermPubsPartial = false;
            }
        }

        return $this->collFeatureCvtermPubs;
    }

    /**
     * Sets a collection of FeatureCvtermPub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureCvtermPubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setFeatureCvtermPubs(PropelCollection $featureCvtermPubs, PropelPDO $con = null)
    {
        $featureCvtermPubsToDelete = $this->getFeatureCvtermPubs(new Criteria(), $con)->diff($featureCvtermPubs);

        $this->featureCvtermPubsScheduledForDeletion = unserialize(serialize($featureCvtermPubsToDelete));

        foreach ($featureCvtermPubsToDelete as $featureCvtermPubRemoved) {
            $featureCvtermPubRemoved->setPub(null);
        }

        $this->collFeatureCvtermPubs = null;
        foreach ($featureCvtermPubs as $featureCvtermPub) {
            $this->addFeatureCvtermPub($featureCvtermPub);
        }

        $this->collFeatureCvtermPubs = $featureCvtermPubs;
        $this->collFeatureCvtermPubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureCvtermPub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureCvtermPub objects.
     * @throws PropelException
     */
    public function countFeatureCvtermPubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureCvtermPubsPartial && !$this->isNew();
        if (null === $this->collFeatureCvtermPubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureCvtermPubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureCvtermPubs());
            }
            $query = FeatureCvtermPubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collFeatureCvtermPubs);
    }

    /**
     * Method called to associate a FeatureCvtermPub object to this object
     * through the FeatureCvtermPub foreign key attribute.
     *
     * @param    FeatureCvtermPub $l FeatureCvtermPub
     * @return Pub The current object (for fluent API support)
     */
    public function addFeatureCvtermPub(FeatureCvtermPub $l)
    {
        if ($this->collFeatureCvtermPubs === null) {
            $this->initFeatureCvtermPubs();
            $this->collFeatureCvtermPubsPartial = true;
        }
        if (!in_array($l, $this->collFeatureCvtermPubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureCvtermPub($l);
        }

        return $this;
    }

    /**
     * @param	FeatureCvtermPub $featureCvtermPub The featureCvtermPub object to add.
     */
    protected function doAddFeatureCvtermPub($featureCvtermPub)
    {
        $this->collFeatureCvtermPubs[]= $featureCvtermPub;
        $featureCvtermPub->setPub($this);
    }

    /**
     * @param	FeatureCvtermPub $featureCvtermPub The featureCvtermPub object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removeFeatureCvtermPub($featureCvtermPub)
    {
        if ($this->getFeatureCvtermPubs()->contains($featureCvtermPub)) {
            $this->collFeatureCvtermPubs->remove($this->collFeatureCvtermPubs->search($featureCvtermPub));
            if (null === $this->featureCvtermPubsScheduledForDeletion) {
                $this->featureCvtermPubsScheduledForDeletion = clone $this->collFeatureCvtermPubs;
                $this->featureCvtermPubsScheduledForDeletion->clear();
            }
            $this->featureCvtermPubsScheduledForDeletion[]= clone $featureCvtermPub;
            $featureCvtermPub->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeatureCvtermPubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureCvtermPub[] List of FeatureCvtermPub objects
     */
    public function getFeatureCvtermPubsJoinFeatureCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureCvtermPubQuery::create(null, $criteria);
        $query->joinWith('FeatureCvterm', $join_behavior);

        return $this->getFeatureCvtermPubs($query, $con);
    }

    /**
     * Clears out the collFeaturePubs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addFeaturePubs()
     */
    public function clearFeaturePubs()
    {
        $this->collFeaturePubs = null; // important to set this to null since that means it is uninitialized
        $this->collFeaturePubsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeaturePubs collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeaturePubs($v = true)
    {
        $this->collFeaturePubsPartial = $v;
    }

    /**
     * Initializes the collFeaturePubs collection.
     *
     * By default this just sets the collFeaturePubs collection to an empty array (like clearcollFeaturePubs());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeaturePubs($overrideExisting = true)
    {
        if (null !== $this->collFeaturePubs && !$overrideExisting) {
            return;
        }
        $this->collFeaturePubs = new PropelObjectCollection();
        $this->collFeaturePubs->setModel('FeaturePub');
    }

    /**
     * Gets an array of FeaturePub objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeaturePub[] List of FeaturePub objects
     * @throws PropelException
     */
    public function getFeaturePubs($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubsPartial && !$this->isNew();
        if (null === $this->collFeaturePubs || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubs) {
                // return empty collection
                $this->initFeaturePubs();
            } else {
                $collFeaturePubs = FeaturePubQuery::create(null, $criteria)
                    ->filterByPub($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeaturePubsPartial && count($collFeaturePubs)) {
                      $this->initFeaturePubs(false);

                      foreach($collFeaturePubs as $obj) {
                        if (false == $this->collFeaturePubs->contains($obj)) {
                          $this->collFeaturePubs->append($obj);
                        }
                      }

                      $this->collFeaturePubsPartial = true;
                    }

                    $collFeaturePubs->getInternalIterator()->rewind();
                    return $collFeaturePubs;
                }

                if($partial && $this->collFeaturePubs) {
                    foreach($this->collFeaturePubs as $obj) {
                        if($obj->isNew()) {
                            $collFeaturePubs[] = $obj;
                        }
                    }
                }

                $this->collFeaturePubs = $collFeaturePubs;
                $this->collFeaturePubsPartial = false;
            }
        }

        return $this->collFeaturePubs;
    }

    /**
     * Sets a collection of FeaturePub objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featurePubs A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setFeaturePubs(PropelCollection $featurePubs, PropelPDO $con = null)
    {
        $featurePubsToDelete = $this->getFeaturePubs(new Criteria(), $con)->diff($featurePubs);

        $this->featurePubsScheduledForDeletion = unserialize(serialize($featurePubsToDelete));

        foreach ($featurePubsToDelete as $featurePubRemoved) {
            $featurePubRemoved->setPub(null);
        }

        $this->collFeaturePubs = null;
        foreach ($featurePubs as $featurePub) {
            $this->addFeaturePub($featurePub);
        }

        $this->collFeaturePubs = $featurePubs;
        $this->collFeaturePubsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeaturePub objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeaturePub objects.
     * @throws PropelException
     */
    public function countFeaturePubs(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeaturePubsPartial && !$this->isNew();
        if (null === $this->collFeaturePubs || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeaturePubs) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeaturePubs());
            }
            $query = FeaturePubQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collFeaturePubs);
    }

    /**
     * Method called to associate a FeaturePub object to this object
     * through the FeaturePub foreign key attribute.
     *
     * @param    FeaturePub $l FeaturePub
     * @return Pub The current object (for fluent API support)
     */
    public function addFeaturePub(FeaturePub $l)
    {
        if ($this->collFeaturePubs === null) {
            $this->initFeaturePubs();
            $this->collFeaturePubsPartial = true;
        }
        if (!in_array($l, $this->collFeaturePubs->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeaturePub($l);
        }

        return $this;
    }

    /**
     * @param	FeaturePub $featurePub The featurePub object to add.
     */
    protected function doAddFeaturePub($featurePub)
    {
        $this->collFeaturePubs[]= $featurePub;
        $featurePub->setPub($this);
    }

    /**
     * @param	FeaturePub $featurePub The featurePub object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removeFeaturePub($featurePub)
    {
        if ($this->getFeaturePubs()->contains($featurePub)) {
            $this->collFeaturePubs->remove($this->collFeaturePubs->search($featurePub));
            if (null === $this->featurePubsScheduledForDeletion) {
                $this->featurePubsScheduledForDeletion = clone $this->collFeaturePubs;
                $this->featurePubsScheduledForDeletion->clear();
            }
            $this->featurePubsScheduledForDeletion[]= clone $featurePub;
            $featurePub->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeaturePubs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeaturePub[] List of FeaturePub objects
     */
    public function getFeaturePubsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeaturePubQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeaturePubs($query, $con);
    }

    /**
     * Clears out the collFeatureSynonyms collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addFeatureSynonyms()
     */
    public function clearFeatureSynonyms()
    {
        $this->collFeatureSynonyms = null; // important to set this to null since that means it is uninitialized
        $this->collFeatureSynonymsPartial = null;

        return $this;
    }

    /**
     * reset is the collFeatureSynonyms collection loaded partially
     *
     * @return void
     */
    public function resetPartialFeatureSynonyms($v = true)
    {
        $this->collFeatureSynonymsPartial = $v;
    }

    /**
     * Initializes the collFeatureSynonyms collection.
     *
     * By default this just sets the collFeatureSynonyms collection to an empty array (like clearcollFeatureSynonyms());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initFeatureSynonyms($overrideExisting = true)
    {
        if (null !== $this->collFeatureSynonyms && !$overrideExisting) {
            return;
        }
        $this->collFeatureSynonyms = new PropelObjectCollection();
        $this->collFeatureSynonyms->setModel('FeatureSynonym');
    }

    /**
     * Gets an array of FeatureSynonym objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     * @throws PropelException
     */
    public function getFeatureSynonyms($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collFeatureSynonymsPartial && !$this->isNew();
        if (null === $this->collFeatureSynonyms || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collFeatureSynonyms) {
                // return empty collection
                $this->initFeatureSynonyms();
            } else {
                $collFeatureSynonyms = FeatureSynonymQuery::create(null, $criteria)
                    ->filterByPub($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collFeatureSynonymsPartial && count($collFeatureSynonyms)) {
                      $this->initFeatureSynonyms(false);

                      foreach($collFeatureSynonyms as $obj) {
                        if (false == $this->collFeatureSynonyms->contains($obj)) {
                          $this->collFeatureSynonyms->append($obj);
                        }
                      }

                      $this->collFeatureSynonymsPartial = true;
                    }

                    $collFeatureSynonyms->getInternalIterator()->rewind();
                    return $collFeatureSynonyms;
                }

                if($partial && $this->collFeatureSynonyms) {
                    foreach($this->collFeatureSynonyms as $obj) {
                        if($obj->isNew()) {
                            $collFeatureSynonyms[] = $obj;
                        }
                    }
                }

                $this->collFeatureSynonyms = $collFeatureSynonyms;
                $this->collFeatureSynonymsPartial = false;
            }
        }

        return $this->collFeatureSynonyms;
    }

    /**
     * Sets a collection of FeatureSynonym objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $featureSynonyms A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setFeatureSynonyms(PropelCollection $featureSynonyms, PropelPDO $con = null)
    {
        $featureSynonymsToDelete = $this->getFeatureSynonyms(new Criteria(), $con)->diff($featureSynonyms);

        $this->featureSynonymsScheduledForDeletion = unserialize(serialize($featureSynonymsToDelete));

        foreach ($featureSynonymsToDelete as $featureSynonymRemoved) {
            $featureSynonymRemoved->setPub(null);
        }

        $this->collFeatureSynonyms = null;
        foreach ($featureSynonyms as $featureSynonym) {
            $this->addFeatureSynonym($featureSynonym);
        }

        $this->collFeatureSynonyms = $featureSynonyms;
        $this->collFeatureSynonymsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related FeatureSynonym objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related FeatureSynonym objects.
     * @throws PropelException
     */
    public function countFeatureSynonyms(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collFeatureSynonymsPartial && !$this->isNew();
        if (null === $this->collFeatureSynonyms || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collFeatureSynonyms) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getFeatureSynonyms());
            }
            $query = FeatureSynonymQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collFeatureSynonyms);
    }

    /**
     * Method called to associate a FeatureSynonym object to this object
     * through the FeatureSynonym foreign key attribute.
     *
     * @param    FeatureSynonym $l FeatureSynonym
     * @return Pub The current object (for fluent API support)
     */
    public function addFeatureSynonym(FeatureSynonym $l)
    {
        if ($this->collFeatureSynonyms === null) {
            $this->initFeatureSynonyms();
            $this->collFeatureSynonymsPartial = true;
        }
        if (!in_array($l, $this->collFeatureSynonyms->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddFeatureSynonym($l);
        }

        return $this;
    }

    /**
     * @param	FeatureSynonym $featureSynonym The featureSynonym object to add.
     */
    protected function doAddFeatureSynonym($featureSynonym)
    {
        $this->collFeatureSynonyms[]= $featureSynonym;
        $featureSynonym->setPub($this);
    }

    /**
     * @param	FeatureSynonym $featureSynonym The featureSynonym object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removeFeatureSynonym($featureSynonym)
    {
        if ($this->getFeatureSynonyms()->contains($featureSynonym)) {
            $this->collFeatureSynonyms->remove($this->collFeatureSynonyms->search($featureSynonym));
            if (null === $this->featureSynonymsScheduledForDeletion) {
                $this->featureSynonymsScheduledForDeletion = clone $this->collFeatureSynonyms;
                $this->featureSynonymsScheduledForDeletion->clear();
            }
            $this->featureSynonymsScheduledForDeletion[]= clone $featureSynonym;
            $featureSynonym->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeatureSynonyms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     */
    public function getFeatureSynonymsJoinFeature($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureSynonymQuery::create(null, $criteria);
        $query->joinWith('Feature', $join_behavior);

        return $this->getFeatureSynonyms($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related FeatureSynonyms from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|FeatureSynonym[] List of FeatureSynonym objects
     */
    public function getFeatureSynonymsJoinSynonym($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = FeatureSynonymQuery::create(null, $criteria);
        $query->joinWith('Synonym', $join_behavior);

        return $this->getFeatureSynonyms($query, $con);
    }

    /**
     * Clears out the collPubDbxrefs collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
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
     * If this Pub is new, it will return
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
                    ->filterByPub($this)
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
     * @return Pub The current object (for fluent API support)
     */
    public function setPubDbxrefs(PropelCollection $pubDbxrefs, PropelPDO $con = null)
    {
        $pubDbxrefsToDelete = $this->getPubDbxrefs(new Criteria(), $con)->diff($pubDbxrefs);

        $this->pubDbxrefsScheduledForDeletion = unserialize(serialize($pubDbxrefsToDelete));

        foreach ($pubDbxrefsToDelete as $pubDbxrefRemoved) {
            $pubDbxrefRemoved->setPub(null);
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
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collPubDbxrefs);
    }

    /**
     * Method called to associate a PubDbxref object to this object
     * through the PubDbxref foreign key attribute.
     *
     * @param    PubDbxref $l PubDbxref
     * @return Pub The current object (for fluent API support)
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
        $pubDbxref->setPub($this);
    }

    /**
     * @param	PubDbxref $pubDbxref The pubDbxref object to remove.
     * @return Pub The current object (for fluent API support)
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
            $pubDbxref->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related PubDbxrefs from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubDbxref[] List of PubDbxref objects
     */
    public function getPubDbxrefsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubDbxrefQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getPubDbxrefs($query, $con);
    }

    /**
     * Clears out the collPubRelationshipsRelatedByObjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addPubRelationshipsRelatedByObjectId()
     */
    public function clearPubRelationshipsRelatedByObjectId()
    {
        $this->collPubRelationshipsRelatedByObjectId = null; // important to set this to null since that means it is uninitialized
        $this->collPubRelationshipsRelatedByObjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collPubRelationshipsRelatedByObjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubRelationshipsRelatedByObjectId($v = true)
    {
        $this->collPubRelationshipsRelatedByObjectIdPartial = $v;
    }

    /**
     * Initializes the collPubRelationshipsRelatedByObjectId collection.
     *
     * By default this just sets the collPubRelationshipsRelatedByObjectId collection to an empty array (like clearcollPubRelationshipsRelatedByObjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubRelationshipsRelatedByObjectId($overrideExisting = true)
    {
        if (null !== $this->collPubRelationshipsRelatedByObjectId && !$overrideExisting) {
            return;
        }
        $this->collPubRelationshipsRelatedByObjectId = new PropelObjectCollection();
        $this->collPubRelationshipsRelatedByObjectId->setModel('PubRelationship');
    }

    /**
     * Gets an array of PubRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     * @throws PropelException
     */
    public function getPubRelationshipsRelatedByObjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collPubRelationshipsRelatedByObjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubRelationshipsRelatedByObjectId) {
                // return empty collection
                $this->initPubRelationshipsRelatedByObjectId();
            } else {
                $collPubRelationshipsRelatedByObjectId = PubRelationshipQuery::create(null, $criteria)
                    ->filterByPubRelatedByObjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubRelationshipsRelatedByObjectIdPartial && count($collPubRelationshipsRelatedByObjectId)) {
                      $this->initPubRelationshipsRelatedByObjectId(false);

                      foreach($collPubRelationshipsRelatedByObjectId as $obj) {
                        if (false == $this->collPubRelationshipsRelatedByObjectId->contains($obj)) {
                          $this->collPubRelationshipsRelatedByObjectId->append($obj);
                        }
                      }

                      $this->collPubRelationshipsRelatedByObjectIdPartial = true;
                    }

                    $collPubRelationshipsRelatedByObjectId->getInternalIterator()->rewind();
                    return $collPubRelationshipsRelatedByObjectId;
                }

                if($partial && $this->collPubRelationshipsRelatedByObjectId) {
                    foreach($this->collPubRelationshipsRelatedByObjectId as $obj) {
                        if($obj->isNew()) {
                            $collPubRelationshipsRelatedByObjectId[] = $obj;
                        }
                    }
                }

                $this->collPubRelationshipsRelatedByObjectId = $collPubRelationshipsRelatedByObjectId;
                $this->collPubRelationshipsRelatedByObjectIdPartial = false;
            }
        }

        return $this->collPubRelationshipsRelatedByObjectId;
    }

    /**
     * Sets a collection of PubRelationshipRelatedByObjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubRelationshipsRelatedByObjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setPubRelationshipsRelatedByObjectId(PropelCollection $pubRelationshipsRelatedByObjectId, PropelPDO $con = null)
    {
        $pubRelationshipsRelatedByObjectIdToDelete = $this->getPubRelationshipsRelatedByObjectId(new Criteria(), $con)->diff($pubRelationshipsRelatedByObjectId);

        $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion = unserialize(serialize($pubRelationshipsRelatedByObjectIdToDelete));

        foreach ($pubRelationshipsRelatedByObjectIdToDelete as $pubRelationshipRelatedByObjectIdRemoved) {
            $pubRelationshipRelatedByObjectIdRemoved->setPubRelatedByObjectId(null);
        }

        $this->collPubRelationshipsRelatedByObjectId = null;
        foreach ($pubRelationshipsRelatedByObjectId as $pubRelationshipRelatedByObjectId) {
            $this->addPubRelationshipRelatedByObjectId($pubRelationshipRelatedByObjectId);
        }

        $this->collPubRelationshipsRelatedByObjectId = $pubRelationshipsRelatedByObjectId;
        $this->collPubRelationshipsRelatedByObjectIdPartial = false;

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
    public function countPubRelationshipsRelatedByObjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsRelatedByObjectIdPartial && !$this->isNew();
        if (null === $this->collPubRelationshipsRelatedByObjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubRelationshipsRelatedByObjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubRelationshipsRelatedByObjectId());
            }
            $query = PubRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPubRelatedByObjectId($this)
                ->count($con);
        }

        return count($this->collPubRelationshipsRelatedByObjectId);
    }

    /**
     * Method called to associate a PubRelationship object to this object
     * through the PubRelationship foreign key attribute.
     *
     * @param    PubRelationship $l PubRelationship
     * @return Pub The current object (for fluent API support)
     */
    public function addPubRelationshipRelatedByObjectId(PubRelationship $l)
    {
        if ($this->collPubRelationshipsRelatedByObjectId === null) {
            $this->initPubRelationshipsRelatedByObjectId();
            $this->collPubRelationshipsRelatedByObjectIdPartial = true;
        }
        if (!in_array($l, $this->collPubRelationshipsRelatedByObjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubRelationshipRelatedByObjectId($l);
        }

        return $this;
    }

    /**
     * @param	PubRelationshipRelatedByObjectId $pubRelationshipRelatedByObjectId The pubRelationshipRelatedByObjectId object to add.
     */
    protected function doAddPubRelationshipRelatedByObjectId($pubRelationshipRelatedByObjectId)
    {
        $this->collPubRelationshipsRelatedByObjectId[]= $pubRelationshipRelatedByObjectId;
        $pubRelationshipRelatedByObjectId->setPubRelatedByObjectId($this);
    }

    /**
     * @param	PubRelationshipRelatedByObjectId $pubRelationshipRelatedByObjectId The pubRelationshipRelatedByObjectId object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removePubRelationshipRelatedByObjectId($pubRelationshipRelatedByObjectId)
    {
        if ($this->getPubRelationshipsRelatedByObjectId()->contains($pubRelationshipRelatedByObjectId)) {
            $this->collPubRelationshipsRelatedByObjectId->remove($this->collPubRelationshipsRelatedByObjectId->search($pubRelationshipRelatedByObjectId));
            if (null === $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion) {
                $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion = clone $this->collPubRelationshipsRelatedByObjectId;
                $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion->clear();
            }
            $this->pubRelationshipsRelatedByObjectIdScheduledForDeletion[]= clone $pubRelationshipRelatedByObjectId;
            $pubRelationshipRelatedByObjectId->setPubRelatedByObjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related PubRelationshipsRelatedByObjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsRelatedByObjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getPubRelationshipsRelatedByObjectId($query, $con);
    }

    /**
     * Clears out the collPubRelationshipsRelatedBySubjectId collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addPubRelationshipsRelatedBySubjectId()
     */
    public function clearPubRelationshipsRelatedBySubjectId()
    {
        $this->collPubRelationshipsRelatedBySubjectId = null; // important to set this to null since that means it is uninitialized
        $this->collPubRelationshipsRelatedBySubjectIdPartial = null;

        return $this;
    }

    /**
     * reset is the collPubRelationshipsRelatedBySubjectId collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubRelationshipsRelatedBySubjectId($v = true)
    {
        $this->collPubRelationshipsRelatedBySubjectIdPartial = $v;
    }

    /**
     * Initializes the collPubRelationshipsRelatedBySubjectId collection.
     *
     * By default this just sets the collPubRelationshipsRelatedBySubjectId collection to an empty array (like clearcollPubRelationshipsRelatedBySubjectId());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubRelationshipsRelatedBySubjectId($overrideExisting = true)
    {
        if (null !== $this->collPubRelationshipsRelatedBySubjectId && !$overrideExisting) {
            return;
        }
        $this->collPubRelationshipsRelatedBySubjectId = new PropelObjectCollection();
        $this->collPubRelationshipsRelatedBySubjectId->setModel('PubRelationship');
    }

    /**
     * Gets an array of PubRelationship objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     * @throws PropelException
     */
    public function getPubRelationshipsRelatedBySubjectId($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collPubRelationshipsRelatedBySubjectId || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubRelationshipsRelatedBySubjectId) {
                // return empty collection
                $this->initPubRelationshipsRelatedBySubjectId();
            } else {
                $collPubRelationshipsRelatedBySubjectId = PubRelationshipQuery::create(null, $criteria)
                    ->filterByPubRelatedBySubjectId($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubRelationshipsRelatedBySubjectIdPartial && count($collPubRelationshipsRelatedBySubjectId)) {
                      $this->initPubRelationshipsRelatedBySubjectId(false);

                      foreach($collPubRelationshipsRelatedBySubjectId as $obj) {
                        if (false == $this->collPubRelationshipsRelatedBySubjectId->contains($obj)) {
                          $this->collPubRelationshipsRelatedBySubjectId->append($obj);
                        }
                      }

                      $this->collPubRelationshipsRelatedBySubjectIdPartial = true;
                    }

                    $collPubRelationshipsRelatedBySubjectId->getInternalIterator()->rewind();
                    return $collPubRelationshipsRelatedBySubjectId;
                }

                if($partial && $this->collPubRelationshipsRelatedBySubjectId) {
                    foreach($this->collPubRelationshipsRelatedBySubjectId as $obj) {
                        if($obj->isNew()) {
                            $collPubRelationshipsRelatedBySubjectId[] = $obj;
                        }
                    }
                }

                $this->collPubRelationshipsRelatedBySubjectId = $collPubRelationshipsRelatedBySubjectId;
                $this->collPubRelationshipsRelatedBySubjectIdPartial = false;
            }
        }

        return $this->collPubRelationshipsRelatedBySubjectId;
    }

    /**
     * Sets a collection of PubRelationshipRelatedBySubjectId objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubRelationshipsRelatedBySubjectId A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setPubRelationshipsRelatedBySubjectId(PropelCollection $pubRelationshipsRelatedBySubjectId, PropelPDO $con = null)
    {
        $pubRelationshipsRelatedBySubjectIdToDelete = $this->getPubRelationshipsRelatedBySubjectId(new Criteria(), $con)->diff($pubRelationshipsRelatedBySubjectId);

        $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion = unserialize(serialize($pubRelationshipsRelatedBySubjectIdToDelete));

        foreach ($pubRelationshipsRelatedBySubjectIdToDelete as $pubRelationshipRelatedBySubjectIdRemoved) {
            $pubRelationshipRelatedBySubjectIdRemoved->setPubRelatedBySubjectId(null);
        }

        $this->collPubRelationshipsRelatedBySubjectId = null;
        foreach ($pubRelationshipsRelatedBySubjectId as $pubRelationshipRelatedBySubjectId) {
            $this->addPubRelationshipRelatedBySubjectId($pubRelationshipRelatedBySubjectId);
        }

        $this->collPubRelationshipsRelatedBySubjectId = $pubRelationshipsRelatedBySubjectId;
        $this->collPubRelationshipsRelatedBySubjectIdPartial = false;

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
    public function countPubRelationshipsRelatedBySubjectId(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubRelationshipsRelatedBySubjectIdPartial && !$this->isNew();
        if (null === $this->collPubRelationshipsRelatedBySubjectId || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubRelationshipsRelatedBySubjectId) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubRelationshipsRelatedBySubjectId());
            }
            $query = PubRelationshipQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPubRelatedBySubjectId($this)
                ->count($con);
        }

        return count($this->collPubRelationshipsRelatedBySubjectId);
    }

    /**
     * Method called to associate a PubRelationship object to this object
     * through the PubRelationship foreign key attribute.
     *
     * @param    PubRelationship $l PubRelationship
     * @return Pub The current object (for fluent API support)
     */
    public function addPubRelationshipRelatedBySubjectId(PubRelationship $l)
    {
        if ($this->collPubRelationshipsRelatedBySubjectId === null) {
            $this->initPubRelationshipsRelatedBySubjectId();
            $this->collPubRelationshipsRelatedBySubjectIdPartial = true;
        }
        if (!in_array($l, $this->collPubRelationshipsRelatedBySubjectId->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubRelationshipRelatedBySubjectId($l);
        }

        return $this;
    }

    /**
     * @param	PubRelationshipRelatedBySubjectId $pubRelationshipRelatedBySubjectId The pubRelationshipRelatedBySubjectId object to add.
     */
    protected function doAddPubRelationshipRelatedBySubjectId($pubRelationshipRelatedBySubjectId)
    {
        $this->collPubRelationshipsRelatedBySubjectId[]= $pubRelationshipRelatedBySubjectId;
        $pubRelationshipRelatedBySubjectId->setPubRelatedBySubjectId($this);
    }

    /**
     * @param	PubRelationshipRelatedBySubjectId $pubRelationshipRelatedBySubjectId The pubRelationshipRelatedBySubjectId object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removePubRelationshipRelatedBySubjectId($pubRelationshipRelatedBySubjectId)
    {
        if ($this->getPubRelationshipsRelatedBySubjectId()->contains($pubRelationshipRelatedBySubjectId)) {
            $this->collPubRelationshipsRelatedBySubjectId->remove($this->collPubRelationshipsRelatedBySubjectId->search($pubRelationshipRelatedBySubjectId));
            if (null === $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion) {
                $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion = clone $this->collPubRelationshipsRelatedBySubjectId;
                $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion->clear();
            }
            $this->pubRelationshipsRelatedBySubjectIdScheduledForDeletion[]= clone $pubRelationshipRelatedBySubjectId;
            $pubRelationshipRelatedBySubjectId->setPubRelatedBySubjectId(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related PubRelationshipsRelatedBySubjectId from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|PubRelationship[] List of PubRelationship objects
     */
    public function getPubRelationshipsRelatedBySubjectIdJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubRelationshipQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getPubRelationshipsRelatedBySubjectId($query, $con);
    }

    /**
     * Clears out the collPubauthors collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
     * @see        addPubauthors()
     */
    public function clearPubauthors()
    {
        $this->collPubauthors = null; // important to set this to null since that means it is uninitialized
        $this->collPubauthorsPartial = null;

        return $this;
    }

    /**
     * reset is the collPubauthors collection loaded partially
     *
     * @return void
     */
    public function resetPartialPubauthors($v = true)
    {
        $this->collPubauthorsPartial = $v;
    }

    /**
     * Initializes the collPubauthors collection.
     *
     * By default this just sets the collPubauthors collection to an empty array (like clearcollPubauthors());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initPubauthors($overrideExisting = true)
    {
        if (null !== $this->collPubauthors && !$overrideExisting) {
            return;
        }
        $this->collPubauthors = new PropelObjectCollection();
        $this->collPubauthors->setModel('Pubauthor');
    }

    /**
     * Gets an array of Pubauthor objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Pub is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Pubauthor[] List of Pubauthor objects
     * @throws PropelException
     */
    public function getPubauthors($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collPubauthorsPartial && !$this->isNew();
        if (null === $this->collPubauthors || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collPubauthors) {
                // return empty collection
                $this->initPubauthors();
            } else {
                $collPubauthors = PubauthorQuery::create(null, $criteria)
                    ->filterByPub($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collPubauthorsPartial && count($collPubauthors)) {
                      $this->initPubauthors(false);

                      foreach($collPubauthors as $obj) {
                        if (false == $this->collPubauthors->contains($obj)) {
                          $this->collPubauthors->append($obj);
                        }
                      }

                      $this->collPubauthorsPartial = true;
                    }

                    $collPubauthors->getInternalIterator()->rewind();
                    return $collPubauthors;
                }

                if($partial && $this->collPubauthors) {
                    foreach($this->collPubauthors as $obj) {
                        if($obj->isNew()) {
                            $collPubauthors[] = $obj;
                        }
                    }
                }

                $this->collPubauthors = $collPubauthors;
                $this->collPubauthorsPartial = false;
            }
        }

        return $this->collPubauthors;
    }

    /**
     * Sets a collection of Pubauthor objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $pubauthors A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Pub The current object (for fluent API support)
     */
    public function setPubauthors(PropelCollection $pubauthors, PropelPDO $con = null)
    {
        $pubauthorsToDelete = $this->getPubauthors(new Criteria(), $con)->diff($pubauthors);

        $this->pubauthorsScheduledForDeletion = unserialize(serialize($pubauthorsToDelete));

        foreach ($pubauthorsToDelete as $pubauthorRemoved) {
            $pubauthorRemoved->setPub(null);
        }

        $this->collPubauthors = null;
        foreach ($pubauthors as $pubauthor) {
            $this->addPubauthor($pubauthor);
        }

        $this->collPubauthors = $pubauthors;
        $this->collPubauthorsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Pubauthor objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Pubauthor objects.
     * @throws PropelException
     */
    public function countPubauthors(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collPubauthorsPartial && !$this->isNew();
        if (null === $this->collPubauthors || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collPubauthors) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getPubauthors());
            }
            $query = PubauthorQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collPubauthors);
    }

    /**
     * Method called to associate a Pubauthor object to this object
     * through the Pubauthor foreign key attribute.
     *
     * @param    Pubauthor $l Pubauthor
     * @return Pub The current object (for fluent API support)
     */
    public function addPubauthor(Pubauthor $l)
    {
        if ($this->collPubauthors === null) {
            $this->initPubauthors();
            $this->collPubauthorsPartial = true;
        }
        if (!in_array($l, $this->collPubauthors->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddPubauthor($l);
        }

        return $this;
    }

    /**
     * @param	Pubauthor $pubauthor The pubauthor object to add.
     */
    protected function doAddPubauthor($pubauthor)
    {
        $this->collPubauthors[]= $pubauthor;
        $pubauthor->setPub($this);
    }

    /**
     * @param	Pubauthor $pubauthor The pubauthor object to remove.
     * @return Pub The current object (for fluent API support)
     */
    public function removePubauthor($pubauthor)
    {
        if ($this->getPubauthors()->contains($pubauthor)) {
            $this->collPubauthors->remove($this->collPubauthors->search($pubauthor));
            if (null === $this->pubauthorsScheduledForDeletion) {
                $this->pubauthorsScheduledForDeletion = clone $this->collPubauthors;
                $this->pubauthorsScheduledForDeletion->clear();
            }
            $this->pubauthorsScheduledForDeletion[]= clone $pubauthor;
            $pubauthor->setPub(null);
        }

        return $this;
    }

    /**
     * Clears out the collPubprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Pub The current object (for fluent API support)
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
     * If this Pub is new, it will return
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
                    ->filterByPub($this)
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
     * @return Pub The current object (for fluent API support)
     */
    public function setPubprops(PropelCollection $pubprops, PropelPDO $con = null)
    {
        $pubpropsToDelete = $this->getPubprops(new Criteria(), $con)->diff($pubprops);

        $this->pubpropsScheduledForDeletion = unserialize(serialize($pubpropsToDelete));

        foreach ($pubpropsToDelete as $pubpropRemoved) {
            $pubpropRemoved->setPub(null);
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
                ->filterByPub($this)
                ->count($con);
        }

        return count($this->collPubprops);
    }

    /**
     * Method called to associate a Pubprop object to this object
     * through the Pubprop foreign key attribute.
     *
     * @param    Pubprop $l Pubprop
     * @return Pub The current object (for fluent API support)
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
        $pubprop->setPub($this);
    }

    /**
     * @param	Pubprop $pubprop The pubprop object to remove.
     * @return Pub The current object (for fluent API support)
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
            $pubprop->setPub(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Pub is new, it will return
     * an empty collection; or if this Pub has previously
     * been saved, it will retrieve related Pubprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Pub.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Pubprop[] List of Pubprop objects
     */
    public function getPubpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = PubpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getPubprops($query, $con);
    }

    /**
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->pub_id = null;
        $this->title = null;
        $this->volumetitle = null;
        $this->volume = null;
        $this->series_name = null;
        $this->issue = null;
        $this->pyear = null;
        $this->pages = null;
        $this->miniref = null;
        $this->uniquename = null;
        $this->type_id = null;
        $this->is_obsolete = null;
        $this->publisher = null;
        $this->pubplace = null;
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
            if ($this->collFeatureCvterms) {
                foreach ($this->collFeatureCvterms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureCvtermPubs) {
                foreach ($this->collFeatureCvtermPubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeaturePubs) {
                foreach ($this->collFeaturePubs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collFeatureSynonyms) {
                foreach ($this->collFeatureSynonyms as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubDbxrefs) {
                foreach ($this->collPubDbxrefs as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubRelationshipsRelatedByObjectId) {
                foreach ($this->collPubRelationshipsRelatedByObjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubRelationshipsRelatedBySubjectId) {
                foreach ($this->collPubRelationshipsRelatedBySubjectId as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubauthors) {
                foreach ($this->collPubauthors as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collPubprops) {
                foreach ($this->collPubprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aCvterm instanceof Persistent) {
              $this->aCvterm->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collFeatureCvterms instanceof PropelCollection) {
            $this->collFeatureCvterms->clearIterator();
        }
        $this->collFeatureCvterms = null;
        if ($this->collFeatureCvtermPubs instanceof PropelCollection) {
            $this->collFeatureCvtermPubs->clearIterator();
        }
        $this->collFeatureCvtermPubs = null;
        if ($this->collFeaturePubs instanceof PropelCollection) {
            $this->collFeaturePubs->clearIterator();
        }
        $this->collFeaturePubs = null;
        if ($this->collFeatureSynonyms instanceof PropelCollection) {
            $this->collFeatureSynonyms->clearIterator();
        }
        $this->collFeatureSynonyms = null;
        if ($this->collPubDbxrefs instanceof PropelCollection) {
            $this->collPubDbxrefs->clearIterator();
        }
        $this->collPubDbxrefs = null;
        if ($this->collPubRelationshipsRelatedByObjectId instanceof PropelCollection) {
            $this->collPubRelationshipsRelatedByObjectId->clearIterator();
        }
        $this->collPubRelationshipsRelatedByObjectId = null;
        if ($this->collPubRelationshipsRelatedBySubjectId instanceof PropelCollection) {
            $this->collPubRelationshipsRelatedBySubjectId->clearIterator();
        }
        $this->collPubRelationshipsRelatedBySubjectId = null;
        if ($this->collPubauthors instanceof PropelCollection) {
            $this->collPubauthors->clearIterator();
        }
        $this->collPubauthors = null;
        if ($this->collPubprops instanceof PropelCollection) {
            $this->collPubprops->clearIterator();
        }
        $this->collPubprops = null;
        $this->aCvterm = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(PubPeer::DEFAULT_STRING_FORMAT);
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
