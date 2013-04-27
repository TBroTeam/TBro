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
use cli_db\propel\ArraydesignPeer;
use cli_db\propel\ArraydesignQuery;
use cli_db\propel\Arraydesignprop;
use cli_db\propel\ArraydesignpropQuery;
use cli_db\propel\Assay;
use cli_db\propel\AssayQuery;
use cli_db\propel\Contact;
use cli_db\propel\ContactQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermQuery;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Element;
use cli_db\propel\ElementQuery;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolQuery;

/**
 * Base class that represents a row from the 'arraydesign' table.
 *
 *
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseArraydesign extends BaseObject implements Persistent
{
    /**
     * Peer class name
     */
    const PEER = 'cli_db\\propel\\ArraydesignPeer';

    /**
     * The Peer class.
     * Instance provides a convenient way of calling static methods on a class
     * that calling code may not be able to identify.
     * @var        ArraydesignPeer
     */
    protected static $peer;

    /**
     * The flag var to prevent infinit loop in deep copy
     * @var       boolean
     */
    protected $startCopy = false;

    /**
     * The value for the arraydesign_id field.
     * @var        int
     */
    protected $arraydesign_id;

    /**
     * The value for the manufacturer_id field.
     * @var        int
     */
    protected $manufacturer_id;

    /**
     * The value for the platformtype_id field.
     * @var        int
     */
    protected $platformtype_id;

    /**
     * The value for the substratetype_id field.
     * @var        int
     */
    protected $substratetype_id;

    /**
     * The value for the protocol_id field.
     * @var        int
     */
    protected $protocol_id;

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
     * The value for the version field.
     * @var        string
     */
    protected $version;

    /**
     * The value for the description field.
     * @var        string
     */
    protected $description;

    /**
     * The value for the array_dimensions field.
     * @var        string
     */
    protected $array_dimensions;

    /**
     * The value for the element_dimensions field.
     * @var        string
     */
    protected $element_dimensions;

    /**
     * The value for the num_of_elements field.
     * @var        int
     */
    protected $num_of_elements;

    /**
     * The value for the num_array_columns field.
     * @var        int
     */
    protected $num_array_columns;

    /**
     * The value for the num_array_rows field.
     * @var        int
     */
    protected $num_array_rows;

    /**
     * The value for the num_grid_columns field.
     * @var        int
     */
    protected $num_grid_columns;

    /**
     * The value for the num_grid_rows field.
     * @var        int
     */
    protected $num_grid_rows;

    /**
     * The value for the num_sub_columns field.
     * @var        int
     */
    protected $num_sub_columns;

    /**
     * The value for the num_sub_rows field.
     * @var        int
     */
    protected $num_sub_rows;

    /**
     * @var        Dbxref
     */
    protected $aDbxref;

    /**
     * @var        Contact
     */
    protected $aContact;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedByPlatformtypeId;

    /**
     * @var        Protocol
     */
    protected $aProtocol;

    /**
     * @var        Cvterm
     */
    protected $aCvtermRelatedBySubstratetypeId;

    /**
     * @var        PropelObjectCollection|Arraydesignprop[] Collection to store aggregation of Arraydesignprop objects.
     */
    protected $collArraydesignprops;
    protected $collArraydesignpropsPartial;

    /**
     * @var        PropelObjectCollection|Assay[] Collection to store aggregation of Assay objects.
     */
    protected $collAssays;
    protected $collAssaysPartial;

    /**
     * @var        PropelObjectCollection|Element[] Collection to store aggregation of Element objects.
     */
    protected $collElements;
    protected $collElementsPartial;

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
    protected $arraydesignpropsScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $assaysScheduledForDeletion = null;

    /**
     * An array of objects scheduled for deletion.
     * @var		PropelObjectCollection
     */
    protected $elementsScheduledForDeletion = null;

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
     * Get the [manufacturer_id] column value.
     *
     * @return int
     */
    public function getManufacturerId()
    {
        return $this->manufacturer_id;
    }

    /**
     * Get the [platformtype_id] column value.
     *
     * @return int
     */
    public function getPlatformtypeId()
    {
        return $this->platformtype_id;
    }

    /**
     * Get the [substratetype_id] column value.
     *
     * @return int
     */
    public function getSubstratetypeId()
    {
        return $this->substratetype_id;
    }

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
     * Get the [array_dimensions] column value.
     *
     * @return string
     */
    public function getArrayDimensions()
    {
        return $this->array_dimensions;
    }

    /**
     * Get the [element_dimensions] column value.
     *
     * @return string
     */
    public function getElementDimensions()
    {
        return $this->element_dimensions;
    }

    /**
     * Get the [num_of_elements] column value.
     *
     * @return int
     */
    public function getNumOfElements()
    {
        return $this->num_of_elements;
    }

    /**
     * Get the [num_array_columns] column value.
     *
     * @return int
     */
    public function getNumArrayColumns()
    {
        return $this->num_array_columns;
    }

    /**
     * Get the [num_array_rows] column value.
     *
     * @return int
     */
    public function getNumArrayRows()
    {
        return $this->num_array_rows;
    }

    /**
     * Get the [num_grid_columns] column value.
     *
     * @return int
     */
    public function getNumGridColumns()
    {
        return $this->num_grid_columns;
    }

    /**
     * Get the [num_grid_rows] column value.
     *
     * @return int
     */
    public function getNumGridRows()
    {
        return $this->num_grid_rows;
    }

    /**
     * Get the [num_sub_columns] column value.
     *
     * @return int
     */
    public function getNumSubColumns()
    {
        return $this->num_sub_columns;
    }

    /**
     * Get the [num_sub_rows] column value.
     *
     * @return int
     */
    public function getNumSubRows()
    {
        return $this->num_sub_rows;
    }

    /**
     * Set the value of [arraydesign_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setArraydesignId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->arraydesign_id !== $v) {
            $this->arraydesign_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::ARRAYDESIGN_ID;
        }


        return $this;
    } // setArraydesignId()

    /**
     * Set the value of [manufacturer_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setManufacturerId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->manufacturer_id !== $v) {
            $this->manufacturer_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::MANUFACTURER_ID;
        }

        if ($this->aContact !== null && $this->aContact->getContactId() !== $v) {
            $this->aContact = null;
        }


        return $this;
    } // setManufacturerId()

    /**
     * Set the value of [platformtype_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setPlatformtypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->platformtype_id !== $v) {
            $this->platformtype_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::PLATFORMTYPE_ID;
        }

        if ($this->aCvtermRelatedByPlatformtypeId !== null && $this->aCvtermRelatedByPlatformtypeId->getCvtermId() !== $v) {
            $this->aCvtermRelatedByPlatformtypeId = null;
        }


        return $this;
    } // setPlatformtypeId()

    /**
     * Set the value of [substratetype_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setSubstratetypeId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->substratetype_id !== $v) {
            $this->substratetype_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::SUBSTRATETYPE_ID;
        }

        if ($this->aCvtermRelatedBySubstratetypeId !== null && $this->aCvtermRelatedBySubstratetypeId->getCvtermId() !== $v) {
            $this->aCvtermRelatedBySubstratetypeId = null;
        }


        return $this;
    } // setSubstratetypeId()

    /**
     * Set the value of [protocol_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setProtocolId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->protocol_id !== $v) {
            $this->protocol_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::PROTOCOL_ID;
        }

        if ($this->aProtocol !== null && $this->aProtocol->getProtocolId() !== $v) {
            $this->aProtocol = null;
        }


        return $this;
    } // setProtocolId()

    /**
     * Set the value of [dbxref_id] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setDbxrefId($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->dbxref_id !== $v) {
            $this->dbxref_id = $v;
            $this->modifiedColumns[] = ArraydesignPeer::DBXREF_ID;
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
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setName($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->name !== $v) {
            $this->name = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NAME;
        }


        return $this;
    } // setName()

    /**
     * Set the value of [version] column.
     *
     * @param string $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setVersion($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->version !== $v) {
            $this->version = $v;
            $this->modifiedColumns[] = ArraydesignPeer::VERSION;
        }


        return $this;
    } // setVersion()

    /**
     * Set the value of [description] column.
     *
     * @param string $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setDescription($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->description !== $v) {
            $this->description = $v;
            $this->modifiedColumns[] = ArraydesignPeer::DESCRIPTION;
        }


        return $this;
    } // setDescription()

    /**
     * Set the value of [array_dimensions] column.
     *
     * @param string $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setArrayDimensions($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->array_dimensions !== $v) {
            $this->array_dimensions = $v;
            $this->modifiedColumns[] = ArraydesignPeer::ARRAY_DIMENSIONS;
        }


        return $this;
    } // setArrayDimensions()

    /**
     * Set the value of [element_dimensions] column.
     *
     * @param string $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setElementDimensions($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (string) $v;
        }

        if ($this->element_dimensions !== $v) {
            $this->element_dimensions = $v;
            $this->modifiedColumns[] = ArraydesignPeer::ELEMENT_DIMENSIONS;
        }


        return $this;
    } // setElementDimensions()

    /**
     * Set the value of [num_of_elements] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumOfElements($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_of_elements !== $v) {
            $this->num_of_elements = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_OF_ELEMENTS;
        }


        return $this;
    } // setNumOfElements()

    /**
     * Set the value of [num_array_columns] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumArrayColumns($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_array_columns !== $v) {
            $this->num_array_columns = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_ARRAY_COLUMNS;
        }


        return $this;
    } // setNumArrayColumns()

    /**
     * Set the value of [num_array_rows] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumArrayRows($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_array_rows !== $v) {
            $this->num_array_rows = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_ARRAY_ROWS;
        }


        return $this;
    } // setNumArrayRows()

    /**
     * Set the value of [num_grid_columns] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumGridColumns($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_grid_columns !== $v) {
            $this->num_grid_columns = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_GRID_COLUMNS;
        }


        return $this;
    } // setNumGridColumns()

    /**
     * Set the value of [num_grid_rows] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumGridRows($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_grid_rows !== $v) {
            $this->num_grid_rows = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_GRID_ROWS;
        }


        return $this;
    } // setNumGridRows()

    /**
     * Set the value of [num_sub_columns] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumSubColumns($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_sub_columns !== $v) {
            $this->num_sub_columns = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_SUB_COLUMNS;
        }


        return $this;
    } // setNumSubColumns()

    /**
     * Set the value of [num_sub_rows] column.
     *
     * @param int $v new value
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setNumSubRows($v)
    {
        if ($v !== null && is_numeric($v)) {
            $v = (int) $v;
        }

        if ($this->num_sub_rows !== $v) {
            $this->num_sub_rows = $v;
            $this->modifiedColumns[] = ArraydesignPeer::NUM_SUB_ROWS;
        }


        return $this;
    } // setNumSubRows()

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

            $this->arraydesign_id = ($row[$startcol + 0] !== null) ? (int) $row[$startcol + 0] : null;
            $this->manufacturer_id = ($row[$startcol + 1] !== null) ? (int) $row[$startcol + 1] : null;
            $this->platformtype_id = ($row[$startcol + 2] !== null) ? (int) $row[$startcol + 2] : null;
            $this->substratetype_id = ($row[$startcol + 3] !== null) ? (int) $row[$startcol + 3] : null;
            $this->protocol_id = ($row[$startcol + 4] !== null) ? (int) $row[$startcol + 4] : null;
            $this->dbxref_id = ($row[$startcol + 5] !== null) ? (int) $row[$startcol + 5] : null;
            $this->name = ($row[$startcol + 6] !== null) ? (string) $row[$startcol + 6] : null;
            $this->version = ($row[$startcol + 7] !== null) ? (string) $row[$startcol + 7] : null;
            $this->description = ($row[$startcol + 8] !== null) ? (string) $row[$startcol + 8] : null;
            $this->array_dimensions = ($row[$startcol + 9] !== null) ? (string) $row[$startcol + 9] : null;
            $this->element_dimensions = ($row[$startcol + 10] !== null) ? (string) $row[$startcol + 10] : null;
            $this->num_of_elements = ($row[$startcol + 11] !== null) ? (int) $row[$startcol + 11] : null;
            $this->num_array_columns = ($row[$startcol + 12] !== null) ? (int) $row[$startcol + 12] : null;
            $this->num_array_rows = ($row[$startcol + 13] !== null) ? (int) $row[$startcol + 13] : null;
            $this->num_grid_columns = ($row[$startcol + 14] !== null) ? (int) $row[$startcol + 14] : null;
            $this->num_grid_rows = ($row[$startcol + 15] !== null) ? (int) $row[$startcol + 15] : null;
            $this->num_sub_columns = ($row[$startcol + 16] !== null) ? (int) $row[$startcol + 16] : null;
            $this->num_sub_rows = ($row[$startcol + 17] !== null) ? (int) $row[$startcol + 17] : null;
            $this->resetModified();

            $this->setNew(false);

            if ($rehydrate) {
                $this->ensureConsistency();
            }
            $this->postHydrate($row, $startcol, $rehydrate);
            return $startcol + 18; // 18 = ArraydesignPeer::NUM_HYDRATE_COLUMNS.

        } catch (Exception $e) {
            throw new PropelException("Error populating Arraydesign object", $e);
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

        if ($this->aContact !== null && $this->manufacturer_id !== $this->aContact->getContactId()) {
            $this->aContact = null;
        }
        if ($this->aCvtermRelatedByPlatformtypeId !== null && $this->platformtype_id !== $this->aCvtermRelatedByPlatformtypeId->getCvtermId()) {
            $this->aCvtermRelatedByPlatformtypeId = null;
        }
        if ($this->aCvtermRelatedBySubstratetypeId !== null && $this->substratetype_id !== $this->aCvtermRelatedBySubstratetypeId->getCvtermId()) {
            $this->aCvtermRelatedBySubstratetypeId = null;
        }
        if ($this->aProtocol !== null && $this->protocol_id !== $this->aProtocol->getProtocolId()) {
            $this->aProtocol = null;
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
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        // We don't need to alter the object instance pool; we're just modifying this instance
        // already in the pool.

        $stmt = ArraydesignPeer::doSelectStmt($this->buildPkeyCriteria(), $con);
        $row = $stmt->fetch(PDO::FETCH_NUM);
        $stmt->closeCursor();
        if (!$row) {
            throw new PropelException('Cannot find matching row in the database to reload object values.');
        }
        $this->hydrate($row, 0, true); // rehydrate

        if ($deep) {  // also de-associate any related objects?

            $this->aDbxref = null;
            $this->aContact = null;
            $this->aCvtermRelatedByPlatformtypeId = null;
            $this->aProtocol = null;
            $this->aCvtermRelatedBySubstratetypeId = null;
            $this->collArraydesignprops = null;

            $this->collAssays = null;

            $this->collElements = null;

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
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $con->beginTransaction();
        try {
            $deleteQuery = ArraydesignQuery::create()
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
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
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
                ArraydesignPeer::addInstanceToPool($this);
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

            if ($this->aContact !== null) {
                if ($this->aContact->isModified() || $this->aContact->isNew()) {
                    $affectedRows += $this->aContact->save($con);
                }
                $this->setContact($this->aContact);
            }

            if ($this->aCvtermRelatedByPlatformtypeId !== null) {
                if ($this->aCvtermRelatedByPlatformtypeId->isModified() || $this->aCvtermRelatedByPlatformtypeId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedByPlatformtypeId->save($con);
                }
                $this->setCvtermRelatedByPlatformtypeId($this->aCvtermRelatedByPlatformtypeId);
            }

            if ($this->aProtocol !== null) {
                if ($this->aProtocol->isModified() || $this->aProtocol->isNew()) {
                    $affectedRows += $this->aProtocol->save($con);
                }
                $this->setProtocol($this->aProtocol);
            }

            if ($this->aCvtermRelatedBySubstratetypeId !== null) {
                if ($this->aCvtermRelatedBySubstratetypeId->isModified() || $this->aCvtermRelatedBySubstratetypeId->isNew()) {
                    $affectedRows += $this->aCvtermRelatedBySubstratetypeId->save($con);
                }
                $this->setCvtermRelatedBySubstratetypeId($this->aCvtermRelatedBySubstratetypeId);
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

            if ($this->arraydesignpropsScheduledForDeletion !== null) {
                if (!$this->arraydesignpropsScheduledForDeletion->isEmpty()) {
                    ArraydesignpropQuery::create()
                        ->filterByPrimaryKeys($this->arraydesignpropsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
                    $this->arraydesignpropsScheduledForDeletion = null;
                }
            }

            if ($this->collArraydesignprops !== null) {
                foreach ($this->collArraydesignprops as $referrerFK) {
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

            if ($this->elementsScheduledForDeletion !== null) {
                if (!$this->elementsScheduledForDeletion->isEmpty()) {
                    ElementQuery::create()
                        ->filterByPrimaryKeys($this->elementsScheduledForDeletion->getPrimaryKeys(false))
                        ->delete($con);
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

        $this->modifiedColumns[] = ArraydesignPeer::ARRAYDESIGN_ID;
        if (null !== $this->arraydesign_id) {
            throw new PropelException('Cannot insert a value for auto-increment primary key (' . ArraydesignPeer::ARRAYDESIGN_ID . ')');
        }
        if (null === $this->arraydesign_id) {
            try {
                $stmt = $con->query("SELECT nextval('arraydesign_arraydesign_id_seq')");
                $row = $stmt->fetch(PDO::FETCH_NUM);
                $this->arraydesign_id = $row[0];
            } catch (Exception $e) {
                throw new PropelException('Unable to get sequence id.', $e);
            }
        }


         // check the columns in natural order for more readable SQL queries
        if ($this->isColumnModified(ArraydesignPeer::ARRAYDESIGN_ID)) {
            $modifiedColumns[':p' . $index++]  = '"arraydesign_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::MANUFACTURER_ID)) {
            $modifiedColumns[':p' . $index++]  = '"manufacturer_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::PLATFORMTYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"platformtype_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::SUBSTRATETYPE_ID)) {
            $modifiedColumns[':p' . $index++]  = '"substratetype_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::PROTOCOL_ID)) {
            $modifiedColumns[':p' . $index++]  = '"protocol_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::DBXREF_ID)) {
            $modifiedColumns[':p' . $index++]  = '"dbxref_id"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NAME)) {
            $modifiedColumns[':p' . $index++]  = '"name"';
        }
        if ($this->isColumnModified(ArraydesignPeer::VERSION)) {
            $modifiedColumns[':p' . $index++]  = '"version"';
        }
        if ($this->isColumnModified(ArraydesignPeer::DESCRIPTION)) {
            $modifiedColumns[':p' . $index++]  = '"description"';
        }
        if ($this->isColumnModified(ArraydesignPeer::ARRAY_DIMENSIONS)) {
            $modifiedColumns[':p' . $index++]  = '"array_dimensions"';
        }
        if ($this->isColumnModified(ArraydesignPeer::ELEMENT_DIMENSIONS)) {
            $modifiedColumns[':p' . $index++]  = '"element_dimensions"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_OF_ELEMENTS)) {
            $modifiedColumns[':p' . $index++]  = '"num_of_elements"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_ARRAY_COLUMNS)) {
            $modifiedColumns[':p' . $index++]  = '"num_array_columns"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_ARRAY_ROWS)) {
            $modifiedColumns[':p' . $index++]  = '"num_array_rows"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_GRID_COLUMNS)) {
            $modifiedColumns[':p' . $index++]  = '"num_grid_columns"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_GRID_ROWS)) {
            $modifiedColumns[':p' . $index++]  = '"num_grid_rows"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_SUB_COLUMNS)) {
            $modifiedColumns[':p' . $index++]  = '"num_sub_columns"';
        }
        if ($this->isColumnModified(ArraydesignPeer::NUM_SUB_ROWS)) {
            $modifiedColumns[':p' . $index++]  = '"num_sub_rows"';
        }

        $sql = sprintf(
            'INSERT INTO "arraydesign" (%s) VALUES (%s)',
            implode(', ', $modifiedColumns),
            implode(', ', array_keys($modifiedColumns))
        );

        try {
            $stmt = $con->prepare($sql);
            foreach ($modifiedColumns as $identifier => $columnName) {
                switch ($columnName) {
                    case '"arraydesign_id"':
                        $stmt->bindValue($identifier, $this->arraydesign_id, PDO::PARAM_INT);
                        break;
                    case '"manufacturer_id"':
                        $stmt->bindValue($identifier, $this->manufacturer_id, PDO::PARAM_INT);
                        break;
                    case '"platformtype_id"':
                        $stmt->bindValue($identifier, $this->platformtype_id, PDO::PARAM_INT);
                        break;
                    case '"substratetype_id"':
                        $stmt->bindValue($identifier, $this->substratetype_id, PDO::PARAM_INT);
                        break;
                    case '"protocol_id"':
                        $stmt->bindValue($identifier, $this->protocol_id, PDO::PARAM_INT);
                        break;
                    case '"dbxref_id"':
                        $stmt->bindValue($identifier, $this->dbxref_id, PDO::PARAM_INT);
                        break;
                    case '"name"':
                        $stmt->bindValue($identifier, $this->name, PDO::PARAM_STR);
                        break;
                    case '"version"':
                        $stmt->bindValue($identifier, $this->version, PDO::PARAM_STR);
                        break;
                    case '"description"':
                        $stmt->bindValue($identifier, $this->description, PDO::PARAM_STR);
                        break;
                    case '"array_dimensions"':
                        $stmt->bindValue($identifier, $this->array_dimensions, PDO::PARAM_STR);
                        break;
                    case '"element_dimensions"':
                        $stmt->bindValue($identifier, $this->element_dimensions, PDO::PARAM_STR);
                        break;
                    case '"num_of_elements"':
                        $stmt->bindValue($identifier, $this->num_of_elements, PDO::PARAM_INT);
                        break;
                    case '"num_array_columns"':
                        $stmt->bindValue($identifier, $this->num_array_columns, PDO::PARAM_INT);
                        break;
                    case '"num_array_rows"':
                        $stmt->bindValue($identifier, $this->num_array_rows, PDO::PARAM_INT);
                        break;
                    case '"num_grid_columns"':
                        $stmt->bindValue($identifier, $this->num_grid_columns, PDO::PARAM_INT);
                        break;
                    case '"num_grid_rows"':
                        $stmt->bindValue($identifier, $this->num_grid_rows, PDO::PARAM_INT);
                        break;
                    case '"num_sub_columns"':
                        $stmt->bindValue($identifier, $this->num_sub_columns, PDO::PARAM_INT);
                        break;
                    case '"num_sub_rows"':
                        $stmt->bindValue($identifier, $this->num_sub_rows, PDO::PARAM_INT);
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

            if ($this->aContact !== null) {
                if (!$this->aContact->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aContact->getValidationFailures());
                }
            }

            if ($this->aCvtermRelatedByPlatformtypeId !== null) {
                if (!$this->aCvtermRelatedByPlatformtypeId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedByPlatformtypeId->getValidationFailures());
                }
            }

            if ($this->aProtocol !== null) {
                if (!$this->aProtocol->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aProtocol->getValidationFailures());
                }
            }

            if ($this->aCvtermRelatedBySubstratetypeId !== null) {
                if (!$this->aCvtermRelatedBySubstratetypeId->validate($columns)) {
                    $failureMap = array_merge($failureMap, $this->aCvtermRelatedBySubstratetypeId->getValidationFailures());
                }
            }


            if (($retval = ArraydesignPeer::doValidate($this, $columns)) !== true) {
                $failureMap = array_merge($failureMap, $retval);
            }


                if ($this->collArraydesignprops !== null) {
                    foreach ($this->collArraydesignprops as $referrerFK) {
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

                if ($this->collElements !== null) {
                    foreach ($this->collElements as $referrerFK) {
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
        $pos = ArraydesignPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);
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
                return $this->getArraydesignId();
                break;
            case 1:
                return $this->getManufacturerId();
                break;
            case 2:
                return $this->getPlatformtypeId();
                break;
            case 3:
                return $this->getSubstratetypeId();
                break;
            case 4:
                return $this->getProtocolId();
                break;
            case 5:
                return $this->getDbxrefId();
                break;
            case 6:
                return $this->getName();
                break;
            case 7:
                return $this->getVersion();
                break;
            case 8:
                return $this->getDescription();
                break;
            case 9:
                return $this->getArrayDimensions();
                break;
            case 10:
                return $this->getElementDimensions();
                break;
            case 11:
                return $this->getNumOfElements();
                break;
            case 12:
                return $this->getNumArrayColumns();
                break;
            case 13:
                return $this->getNumArrayRows();
                break;
            case 14:
                return $this->getNumGridColumns();
                break;
            case 15:
                return $this->getNumGridRows();
                break;
            case 16:
                return $this->getNumSubColumns();
                break;
            case 17:
                return $this->getNumSubRows();
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
        if (isset($alreadyDumpedObjects['Arraydesign'][$this->getPrimaryKey()])) {
            return '*RECURSION*';
        }
        $alreadyDumpedObjects['Arraydesign'][$this->getPrimaryKey()] = true;
        $keys = ArraydesignPeer::getFieldNames($keyType);
        $result = array(
            $keys[0] => $this->getArraydesignId(),
            $keys[1] => $this->getManufacturerId(),
            $keys[2] => $this->getPlatformtypeId(),
            $keys[3] => $this->getSubstratetypeId(),
            $keys[4] => $this->getProtocolId(),
            $keys[5] => $this->getDbxrefId(),
            $keys[6] => $this->getName(),
            $keys[7] => $this->getVersion(),
            $keys[8] => $this->getDescription(),
            $keys[9] => $this->getArrayDimensions(),
            $keys[10] => $this->getElementDimensions(),
            $keys[11] => $this->getNumOfElements(),
            $keys[12] => $this->getNumArrayColumns(),
            $keys[13] => $this->getNumArrayRows(),
            $keys[14] => $this->getNumGridColumns(),
            $keys[15] => $this->getNumGridRows(),
            $keys[16] => $this->getNumSubColumns(),
            $keys[17] => $this->getNumSubRows(),
        );
        if ($includeForeignObjects) {
            if (null !== $this->aDbxref) {
                $result['Dbxref'] = $this->aDbxref->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aContact) {
                $result['Contact'] = $this->aContact->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvtermRelatedByPlatformtypeId) {
                $result['CvtermRelatedByPlatformtypeId'] = $this->aCvtermRelatedByPlatformtypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aProtocol) {
                $result['Protocol'] = $this->aProtocol->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->aCvtermRelatedBySubstratetypeId) {
                $result['CvtermRelatedBySubstratetypeId'] = $this->aCvtermRelatedBySubstratetypeId->toArray($keyType, $includeLazyLoadColumns,  $alreadyDumpedObjects, true);
            }
            if (null !== $this->collArraydesignprops) {
                $result['Arraydesignprops'] = $this->collArraydesignprops->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collAssays) {
                $result['Assays'] = $this->collAssays->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
            }
            if (null !== $this->collElements) {
                $result['Elements'] = $this->collElements->toArray(null, true, $keyType, $includeLazyLoadColumns, $alreadyDumpedObjects);
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
        $pos = ArraydesignPeer::translateFieldName($name, $type, BasePeer::TYPE_NUM);

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
                $this->setArraydesignId($value);
                break;
            case 1:
                $this->setManufacturerId($value);
                break;
            case 2:
                $this->setPlatformtypeId($value);
                break;
            case 3:
                $this->setSubstratetypeId($value);
                break;
            case 4:
                $this->setProtocolId($value);
                break;
            case 5:
                $this->setDbxrefId($value);
                break;
            case 6:
                $this->setName($value);
                break;
            case 7:
                $this->setVersion($value);
                break;
            case 8:
                $this->setDescription($value);
                break;
            case 9:
                $this->setArrayDimensions($value);
                break;
            case 10:
                $this->setElementDimensions($value);
                break;
            case 11:
                $this->setNumOfElements($value);
                break;
            case 12:
                $this->setNumArrayColumns($value);
                break;
            case 13:
                $this->setNumArrayRows($value);
                break;
            case 14:
                $this->setNumGridColumns($value);
                break;
            case 15:
                $this->setNumGridRows($value);
                break;
            case 16:
                $this->setNumSubColumns($value);
                break;
            case 17:
                $this->setNumSubRows($value);
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
        $keys = ArraydesignPeer::getFieldNames($keyType);

        if (array_key_exists($keys[0], $arr)) $this->setArraydesignId($arr[$keys[0]]);
        if (array_key_exists($keys[1], $arr)) $this->setManufacturerId($arr[$keys[1]]);
        if (array_key_exists($keys[2], $arr)) $this->setPlatformtypeId($arr[$keys[2]]);
        if (array_key_exists($keys[3], $arr)) $this->setSubstratetypeId($arr[$keys[3]]);
        if (array_key_exists($keys[4], $arr)) $this->setProtocolId($arr[$keys[4]]);
        if (array_key_exists($keys[5], $arr)) $this->setDbxrefId($arr[$keys[5]]);
        if (array_key_exists($keys[6], $arr)) $this->setName($arr[$keys[6]]);
        if (array_key_exists($keys[7], $arr)) $this->setVersion($arr[$keys[7]]);
        if (array_key_exists($keys[8], $arr)) $this->setDescription($arr[$keys[8]]);
        if (array_key_exists($keys[9], $arr)) $this->setArrayDimensions($arr[$keys[9]]);
        if (array_key_exists($keys[10], $arr)) $this->setElementDimensions($arr[$keys[10]]);
        if (array_key_exists($keys[11], $arr)) $this->setNumOfElements($arr[$keys[11]]);
        if (array_key_exists($keys[12], $arr)) $this->setNumArrayColumns($arr[$keys[12]]);
        if (array_key_exists($keys[13], $arr)) $this->setNumArrayRows($arr[$keys[13]]);
        if (array_key_exists($keys[14], $arr)) $this->setNumGridColumns($arr[$keys[14]]);
        if (array_key_exists($keys[15], $arr)) $this->setNumGridRows($arr[$keys[15]]);
        if (array_key_exists($keys[16], $arr)) $this->setNumSubColumns($arr[$keys[16]]);
        if (array_key_exists($keys[17], $arr)) $this->setNumSubRows($arr[$keys[17]]);
    }

    /**
     * Build a Criteria object containing the values of all modified columns in this object.
     *
     * @return Criteria The Criteria object containing all modified values.
     */
    public function buildCriteria()
    {
        $criteria = new Criteria(ArraydesignPeer::DATABASE_NAME);

        if ($this->isColumnModified(ArraydesignPeer::ARRAYDESIGN_ID)) $criteria->add(ArraydesignPeer::ARRAYDESIGN_ID, $this->arraydesign_id);
        if ($this->isColumnModified(ArraydesignPeer::MANUFACTURER_ID)) $criteria->add(ArraydesignPeer::MANUFACTURER_ID, $this->manufacturer_id);
        if ($this->isColumnModified(ArraydesignPeer::PLATFORMTYPE_ID)) $criteria->add(ArraydesignPeer::PLATFORMTYPE_ID, $this->platformtype_id);
        if ($this->isColumnModified(ArraydesignPeer::SUBSTRATETYPE_ID)) $criteria->add(ArraydesignPeer::SUBSTRATETYPE_ID, $this->substratetype_id);
        if ($this->isColumnModified(ArraydesignPeer::PROTOCOL_ID)) $criteria->add(ArraydesignPeer::PROTOCOL_ID, $this->protocol_id);
        if ($this->isColumnModified(ArraydesignPeer::DBXREF_ID)) $criteria->add(ArraydesignPeer::DBXREF_ID, $this->dbxref_id);
        if ($this->isColumnModified(ArraydesignPeer::NAME)) $criteria->add(ArraydesignPeer::NAME, $this->name);
        if ($this->isColumnModified(ArraydesignPeer::VERSION)) $criteria->add(ArraydesignPeer::VERSION, $this->version);
        if ($this->isColumnModified(ArraydesignPeer::DESCRIPTION)) $criteria->add(ArraydesignPeer::DESCRIPTION, $this->description);
        if ($this->isColumnModified(ArraydesignPeer::ARRAY_DIMENSIONS)) $criteria->add(ArraydesignPeer::ARRAY_DIMENSIONS, $this->array_dimensions);
        if ($this->isColumnModified(ArraydesignPeer::ELEMENT_DIMENSIONS)) $criteria->add(ArraydesignPeer::ELEMENT_DIMENSIONS, $this->element_dimensions);
        if ($this->isColumnModified(ArraydesignPeer::NUM_OF_ELEMENTS)) $criteria->add(ArraydesignPeer::NUM_OF_ELEMENTS, $this->num_of_elements);
        if ($this->isColumnModified(ArraydesignPeer::NUM_ARRAY_COLUMNS)) $criteria->add(ArraydesignPeer::NUM_ARRAY_COLUMNS, $this->num_array_columns);
        if ($this->isColumnModified(ArraydesignPeer::NUM_ARRAY_ROWS)) $criteria->add(ArraydesignPeer::NUM_ARRAY_ROWS, $this->num_array_rows);
        if ($this->isColumnModified(ArraydesignPeer::NUM_GRID_COLUMNS)) $criteria->add(ArraydesignPeer::NUM_GRID_COLUMNS, $this->num_grid_columns);
        if ($this->isColumnModified(ArraydesignPeer::NUM_GRID_ROWS)) $criteria->add(ArraydesignPeer::NUM_GRID_ROWS, $this->num_grid_rows);
        if ($this->isColumnModified(ArraydesignPeer::NUM_SUB_COLUMNS)) $criteria->add(ArraydesignPeer::NUM_SUB_COLUMNS, $this->num_sub_columns);
        if ($this->isColumnModified(ArraydesignPeer::NUM_SUB_ROWS)) $criteria->add(ArraydesignPeer::NUM_SUB_ROWS, $this->num_sub_rows);

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
        $criteria = new Criteria(ArraydesignPeer::DATABASE_NAME);
        $criteria->add(ArraydesignPeer::ARRAYDESIGN_ID, $this->arraydesign_id);

        return $criteria;
    }

    /**
     * Returns the primary key for this object (row).
     * @return int
     */
    public function getPrimaryKey()
    {
        return $this->getArraydesignId();
    }

    /**
     * Generic method to set the primary key (arraydesign_id column).
     *
     * @param  int $key Primary key.
     * @return void
     */
    public function setPrimaryKey($key)
    {
        $this->setArraydesignId($key);
    }

    /**
     * Returns true if the primary key for this object is null.
     * @return boolean
     */
    public function isPrimaryKeyNull()
    {

        return null === $this->getArraydesignId();
    }

    /**
     * Sets contents of passed object to values from current object.
     *
     * If desired, this method can also make copies of all associated (fkey referrers)
     * objects.
     *
     * @param object $copyObj An object of Arraydesign (or compatible) type.
     * @param boolean $deepCopy Whether to also copy all rows that refer (by fkey) to the current row.
     * @param boolean $makeNew Whether to reset autoincrement PKs and make the object new.
     * @throws PropelException
     */
    public function copyInto($copyObj, $deepCopy = false, $makeNew = true)
    {
        $copyObj->setManufacturerId($this->getManufacturerId());
        $copyObj->setPlatformtypeId($this->getPlatformtypeId());
        $copyObj->setSubstratetypeId($this->getSubstratetypeId());
        $copyObj->setProtocolId($this->getProtocolId());
        $copyObj->setDbxrefId($this->getDbxrefId());
        $copyObj->setName($this->getName());
        $copyObj->setVersion($this->getVersion());
        $copyObj->setDescription($this->getDescription());
        $copyObj->setArrayDimensions($this->getArrayDimensions());
        $copyObj->setElementDimensions($this->getElementDimensions());
        $copyObj->setNumOfElements($this->getNumOfElements());
        $copyObj->setNumArrayColumns($this->getNumArrayColumns());
        $copyObj->setNumArrayRows($this->getNumArrayRows());
        $copyObj->setNumGridColumns($this->getNumGridColumns());
        $copyObj->setNumGridRows($this->getNumGridRows());
        $copyObj->setNumSubColumns($this->getNumSubColumns());
        $copyObj->setNumSubRows($this->getNumSubRows());

        if ($deepCopy && !$this->startCopy) {
            // important: temporarily setNew(false) because this affects the behavior of
            // the getter/setter methods for fkey referrer objects.
            $copyObj->setNew(false);
            // store object hash to prevent cycle
            $this->startCopy = true;

            foreach ($this->getArraydesignprops() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addArraydesignprop($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getAssays() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addAssay($relObj->copy($deepCopy));
                }
            }

            foreach ($this->getElements() as $relObj) {
                if ($relObj !== $this) {  // ensure that we don't try to copy a reference to ourselves
                    $copyObj->addElement($relObj->copy($deepCopy));
                }
            }

            //unflag object copy
            $this->startCopy = false;
        } // if ($deepCopy)

        if ($makeNew) {
            $copyObj->setNew(true);
            $copyObj->setArraydesignId(NULL); // this is a auto-increment column, so set to default value
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
     * @return Arraydesign Clone of current object.
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
     * @return ArraydesignPeer
     */
    public function getPeer()
    {
        if (self::$peer === null) {
            self::$peer = new ArraydesignPeer();
        }

        return self::$peer;
    }

    /**
     * Declares an association between this object and a Dbxref object.
     *
     * @param             Dbxref $v
     * @return Arraydesign The current object (for fluent API support)
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
            $v->addArraydesign($this);
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
                $this->aDbxref->addArraydesigns($this);
             */
        }

        return $this->aDbxref;
    }

    /**
     * Declares an association between this object and a Contact object.
     *
     * @param             Contact $v
     * @return Arraydesign The current object (for fluent API support)
     * @throws PropelException
     */
    public function setContact(Contact $v = null)
    {
        if ($v === null) {
            $this->setManufacturerId(NULL);
        } else {
            $this->setManufacturerId($v->getContactId());
        }

        $this->aContact = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Contact object, it will not be re-added.
        if ($v !== null) {
            $v->addArraydesign($this);
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
        if ($this->aContact === null && ($this->manufacturer_id !== null) && $doQuery) {
            $this->aContact = ContactQuery::create()->findPk($this->manufacturer_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aContact->addArraydesigns($this);
             */
        }

        return $this->aContact;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Arraydesign The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedByPlatformtypeId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setPlatformtypeId(NULL);
        } else {
            $this->setPlatformtypeId($v->getCvtermId());
        }

        $this->aCvtermRelatedByPlatformtypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addArraydesignRelatedByPlatformtypeId($this);
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
    public function getCvtermRelatedByPlatformtypeId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedByPlatformtypeId === null && ($this->platformtype_id !== null) && $doQuery) {
            $this->aCvtermRelatedByPlatformtypeId = CvtermQuery::create()->findPk($this->platformtype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedByPlatformtypeId->addArraydesignsRelatedByPlatformtypeId($this);
             */
        }

        return $this->aCvtermRelatedByPlatformtypeId;
    }

    /**
     * Declares an association between this object and a Protocol object.
     *
     * @param             Protocol $v
     * @return Arraydesign The current object (for fluent API support)
     * @throws PropelException
     */
    public function setProtocol(Protocol $v = null)
    {
        if ($v === null) {
            $this->setProtocolId(NULL);
        } else {
            $this->setProtocolId($v->getProtocolId());
        }

        $this->aProtocol = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Protocol object, it will not be re-added.
        if ($v !== null) {
            $v->addArraydesign($this);
        }


        return $this;
    }


    /**
     * Get the associated Protocol object
     *
     * @param PropelPDO $con Optional Connection object.
     * @param $doQuery Executes a query to get the object if required
     * @return Protocol The associated Protocol object.
     * @throws PropelException
     */
    public function getProtocol(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aProtocol === null && ($this->protocol_id !== null) && $doQuery) {
            $this->aProtocol = ProtocolQuery::create()->findPk($this->protocol_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aProtocol->addArraydesigns($this);
             */
        }

        return $this->aProtocol;
    }

    /**
     * Declares an association between this object and a Cvterm object.
     *
     * @param             Cvterm $v
     * @return Arraydesign The current object (for fluent API support)
     * @throws PropelException
     */
    public function setCvtermRelatedBySubstratetypeId(Cvterm $v = null)
    {
        if ($v === null) {
            $this->setSubstratetypeId(NULL);
        } else {
            $this->setSubstratetypeId($v->getCvtermId());
        }

        $this->aCvtermRelatedBySubstratetypeId = $v;

        // Add binding for other direction of this n:n relationship.
        // If this object has already been added to the Cvterm object, it will not be re-added.
        if ($v !== null) {
            $v->addArraydesignRelatedBySubstratetypeId($this);
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
    public function getCvtermRelatedBySubstratetypeId(PropelPDO $con = null, $doQuery = true)
    {
        if ($this->aCvtermRelatedBySubstratetypeId === null && ($this->substratetype_id !== null) && $doQuery) {
            $this->aCvtermRelatedBySubstratetypeId = CvtermQuery::create()->findPk($this->substratetype_id, $con);
            /* The following can be used additionally to
                guarantee the related object contains a reference
                to this object.  This level of coupling may, however, be
                undesirable since it could result in an only partially populated collection
                in the referenced object.
                $this->aCvtermRelatedBySubstratetypeId->addArraydesignsRelatedBySubstratetypeId($this);
             */
        }

        return $this->aCvtermRelatedBySubstratetypeId;
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
        if ('Arraydesignprop' == $relationName) {
            $this->initArraydesignprops();
        }
        if ('Assay' == $relationName) {
            $this->initAssays();
        }
        if ('Element' == $relationName) {
            $this->initElements();
        }
    }

    /**
     * Clears out the collArraydesignprops collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Arraydesign The current object (for fluent API support)
     * @see        addArraydesignprops()
     */
    public function clearArraydesignprops()
    {
        $this->collArraydesignprops = null; // important to set this to null since that means it is uninitialized
        $this->collArraydesignpropsPartial = null;

        return $this;
    }

    /**
     * reset is the collArraydesignprops collection loaded partially
     *
     * @return void
     */
    public function resetPartialArraydesignprops($v = true)
    {
        $this->collArraydesignpropsPartial = $v;
    }

    /**
     * Initializes the collArraydesignprops collection.
     *
     * By default this just sets the collArraydesignprops collection to an empty array (like clearcollArraydesignprops());
     * however, you may wish to override this method in your stub class to provide setting appropriate
     * to your application -- for example, setting the initial array to the values stored in database.
     *
     * @param boolean $overrideExisting If set to true, the method call initializes
     *                                        the collection even if it is not empty
     *
     * @return void
     */
    public function initArraydesignprops($overrideExisting = true)
    {
        if (null !== $this->collArraydesignprops && !$overrideExisting) {
            return;
        }
        $this->collArraydesignprops = new PropelObjectCollection();
        $this->collArraydesignprops->setModel('Arraydesignprop');
    }

    /**
     * Gets an array of Arraydesignprop objects which contain a foreign key that references this object.
     *
     * If the $criteria is not null, it is used to always fetch the results from the database.
     * Otherwise the results are fetched from the database the first time, then cached.
     * Next time the same method is called without $criteria, the cached collection is returned.
     * If this Arraydesign is new, it will return
     * an empty collection or the current collection; the criteria is ignored on a new object.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @return PropelObjectCollection|Arraydesignprop[] List of Arraydesignprop objects
     * @throws PropelException
     */
    public function getArraydesignprops($criteria = null, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignpropsPartial && !$this->isNew();
        if (null === $this->collArraydesignprops || null !== $criteria  || $partial) {
            if ($this->isNew() && null === $this->collArraydesignprops) {
                // return empty collection
                $this->initArraydesignprops();
            } else {
                $collArraydesignprops = ArraydesignpropQuery::create(null, $criteria)
                    ->filterByArraydesign($this)
                    ->find($con);
                if (null !== $criteria) {
                    if (false !== $this->collArraydesignpropsPartial && count($collArraydesignprops)) {
                      $this->initArraydesignprops(false);

                      foreach($collArraydesignprops as $obj) {
                        if (false == $this->collArraydesignprops->contains($obj)) {
                          $this->collArraydesignprops->append($obj);
                        }
                      }

                      $this->collArraydesignpropsPartial = true;
                    }

                    $collArraydesignprops->getInternalIterator()->rewind();
                    return $collArraydesignprops;
                }

                if($partial && $this->collArraydesignprops) {
                    foreach($this->collArraydesignprops as $obj) {
                        if($obj->isNew()) {
                            $collArraydesignprops[] = $obj;
                        }
                    }
                }

                $this->collArraydesignprops = $collArraydesignprops;
                $this->collArraydesignpropsPartial = false;
            }
        }

        return $this->collArraydesignprops;
    }

    /**
     * Sets a collection of Arraydesignprop objects related by a one-to-many relationship
     * to the current object.
     * It will also schedule objects for deletion based on a diff between old objects (aka persisted)
     * and new objects from the given Propel collection.
     *
     * @param PropelCollection $arraydesignprops A Propel collection.
     * @param PropelPDO $con Optional connection object
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setArraydesignprops(PropelCollection $arraydesignprops, PropelPDO $con = null)
    {
        $arraydesignpropsToDelete = $this->getArraydesignprops(new Criteria(), $con)->diff($arraydesignprops);

        $this->arraydesignpropsScheduledForDeletion = unserialize(serialize($arraydesignpropsToDelete));

        foreach ($arraydesignpropsToDelete as $arraydesignpropRemoved) {
            $arraydesignpropRemoved->setArraydesign(null);
        }

        $this->collArraydesignprops = null;
        foreach ($arraydesignprops as $arraydesignprop) {
            $this->addArraydesignprop($arraydesignprop);
        }

        $this->collArraydesignprops = $arraydesignprops;
        $this->collArraydesignpropsPartial = false;

        return $this;
    }

    /**
     * Returns the number of related Arraydesignprop objects.
     *
     * @param Criteria $criteria
     * @param boolean $distinct
     * @param PropelPDO $con
     * @return int             Count of related Arraydesignprop objects.
     * @throws PropelException
     */
    public function countArraydesignprops(Criteria $criteria = null, $distinct = false, PropelPDO $con = null)
    {
        $partial = $this->collArraydesignpropsPartial && !$this->isNew();
        if (null === $this->collArraydesignprops || null !== $criteria || $partial) {
            if ($this->isNew() && null === $this->collArraydesignprops) {
                return 0;
            }

            if($partial && !$criteria) {
                return count($this->getArraydesignprops());
            }
            $query = ArraydesignpropQuery::create(null, $criteria);
            if ($distinct) {
                $query->distinct();
            }

            return $query
                ->filterByArraydesign($this)
                ->count($con);
        }

        return count($this->collArraydesignprops);
    }

    /**
     * Method called to associate a Arraydesignprop object to this object
     * through the Arraydesignprop foreign key attribute.
     *
     * @param    Arraydesignprop $l Arraydesignprop
     * @return Arraydesign The current object (for fluent API support)
     */
    public function addArraydesignprop(Arraydesignprop $l)
    {
        if ($this->collArraydesignprops === null) {
            $this->initArraydesignprops();
            $this->collArraydesignpropsPartial = true;
        }
        if (!in_array($l, $this->collArraydesignprops->getArrayCopy(), true)) { // only add it if the **same** object is not already associated
            $this->doAddArraydesignprop($l);
        }

        return $this;
    }

    /**
     * @param	Arraydesignprop $arraydesignprop The arraydesignprop object to add.
     */
    protected function doAddArraydesignprop($arraydesignprop)
    {
        $this->collArraydesignprops[]= $arraydesignprop;
        $arraydesignprop->setArraydesign($this);
    }

    /**
     * @param	Arraydesignprop $arraydesignprop The arraydesignprop object to remove.
     * @return Arraydesign The current object (for fluent API support)
     */
    public function removeArraydesignprop($arraydesignprop)
    {
        if ($this->getArraydesignprops()->contains($arraydesignprop)) {
            $this->collArraydesignprops->remove($this->collArraydesignprops->search($arraydesignprop));
            if (null === $this->arraydesignpropsScheduledForDeletion) {
                $this->arraydesignpropsScheduledForDeletion = clone $this->collArraydesignprops;
                $this->arraydesignpropsScheduledForDeletion->clear();
            }
            $this->arraydesignpropsScheduledForDeletion[]= clone $arraydesignprop;
            $arraydesignprop->setArraydesign(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Arraydesignprops from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Arraydesignprop[] List of Arraydesignprop objects
     */
    public function getArraydesignpropsJoinCvterm($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ArraydesignpropQuery::create(null, $criteria);
        $query->joinWith('Cvterm', $join_behavior);

        return $this->getArraydesignprops($query, $con);
    }

    /**
     * Clears out the collAssays collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Arraydesign The current object (for fluent API support)
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
     * If this Arraydesign is new, it will return
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
                    ->filterByArraydesign($this)
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
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setAssays(PropelCollection $assays, PropelPDO $con = null)
    {
        $assaysToDelete = $this->getAssays(new Criteria(), $con)->diff($assays);

        $this->assaysScheduledForDeletion = unserialize(serialize($assaysToDelete));

        foreach ($assaysToDelete as $assayRemoved) {
            $assayRemoved->setArraydesign(null);
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
                ->filterByArraydesign($this)
                ->count($con);
        }

        return count($this->collAssays);
    }

    /**
     * Method called to associate a Assay object to this object
     * through the Assay foreign key attribute.
     *
     * @param    Assay $l Assay
     * @return Arraydesign The current object (for fluent API support)
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
        $assay->setArraydesign($this);
    }

    /**
     * @param	Assay $assay The assay object to remove.
     * @return Arraydesign The current object (for fluent API support)
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
            $assay->setArraydesign(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
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
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
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
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Assays from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
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
     * Clears out the collElements collection
     *
     * This does not modify the database; however, it will remove any associated objects, causing
     * them to be refetched by subsequent calls to accessor method.
     *
     * @return Arraydesign The current object (for fluent API support)
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
     * If this Arraydesign is new, it will return
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
                    ->filterByArraydesign($this)
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
     * @return Arraydesign The current object (for fluent API support)
     */
    public function setElements(PropelCollection $elements, PropelPDO $con = null)
    {
        $elementsToDelete = $this->getElements(new Criteria(), $con)->diff($elements);

        $this->elementsScheduledForDeletion = unserialize(serialize($elementsToDelete));

        foreach ($elementsToDelete as $elementRemoved) {
            $elementRemoved->setArraydesign(null);
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
                ->filterByArraydesign($this)
                ->count($con);
        }

        return count($this->collElements);
    }

    /**
     * Method called to associate a Element object to this object
     * through the Element foreign key attribute.
     *
     * @param    Element $l Element
     * @return Arraydesign The current object (for fluent API support)
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
        $element->setArraydesign($this);
    }

    /**
     * @param	Element $element The element object to remove.
     * @return Arraydesign The current object (for fluent API support)
     */
    public function removeElement($element)
    {
        if ($this->getElements()->contains($element)) {
            $this->collElements->remove($this->collElements->search($element));
            if (null === $this->elementsScheduledForDeletion) {
                $this->elementsScheduledForDeletion = clone $this->collElements;
                $this->elementsScheduledForDeletion->clear();
            }
            $this->elementsScheduledForDeletion[]= clone $element;
            $element->setArraydesign(null);
        }

        return $this;
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
     *
     * @param Criteria $criteria optional Criteria object to narrow the query
     * @param PropelPDO $con optional connection object
     * @param string $join_behavior optional join type to use (defaults to Criteria::LEFT_JOIN)
     * @return PropelObjectCollection|Element[] List of Element objects
     */
    public function getElementsJoinDbxref($criteria = null, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $query = ElementQuery::create(null, $criteria);
        $query->joinWith('Dbxref', $join_behavior);

        return $this->getElements($query, $con);
    }


    /**
     * If this collection has already been initialized with
     * an identical criteria, it returns the collection.
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
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
     * Otherwise if this Arraydesign is new, it will return
     * an empty collection; or if this Arraydesign has previously
     * been saved, it will retrieve related Elements from storage.
     *
     * This method is protected by default in order to keep the public
     * api reasonable.  You can provide public methods for those you
     * actually need in Arraydesign.
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
     * Clears the current object and sets all attributes to their default values
     */
    public function clear()
    {
        $this->arraydesign_id = null;
        $this->manufacturer_id = null;
        $this->platformtype_id = null;
        $this->substratetype_id = null;
        $this->protocol_id = null;
        $this->dbxref_id = null;
        $this->name = null;
        $this->version = null;
        $this->description = null;
        $this->array_dimensions = null;
        $this->element_dimensions = null;
        $this->num_of_elements = null;
        $this->num_array_columns = null;
        $this->num_array_rows = null;
        $this->num_grid_columns = null;
        $this->num_grid_rows = null;
        $this->num_sub_columns = null;
        $this->num_sub_rows = null;
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
            if ($this->collArraydesignprops) {
                foreach ($this->collArraydesignprops as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collAssays) {
                foreach ($this->collAssays as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->collElements) {
                foreach ($this->collElements as $o) {
                    $o->clearAllReferences($deep);
                }
            }
            if ($this->aDbxref instanceof Persistent) {
              $this->aDbxref->clearAllReferences($deep);
            }
            if ($this->aContact instanceof Persistent) {
              $this->aContact->clearAllReferences($deep);
            }
            if ($this->aCvtermRelatedByPlatformtypeId instanceof Persistent) {
              $this->aCvtermRelatedByPlatformtypeId->clearAllReferences($deep);
            }
            if ($this->aProtocol instanceof Persistent) {
              $this->aProtocol->clearAllReferences($deep);
            }
            if ($this->aCvtermRelatedBySubstratetypeId instanceof Persistent) {
              $this->aCvtermRelatedBySubstratetypeId->clearAllReferences($deep);
            }

            $this->alreadyInClearAllReferencesDeep = false;
        } // if ($deep)

        if ($this->collArraydesignprops instanceof PropelCollection) {
            $this->collArraydesignprops->clearIterator();
        }
        $this->collArraydesignprops = null;
        if ($this->collAssays instanceof PropelCollection) {
            $this->collAssays->clearIterator();
        }
        $this->collAssays = null;
        if ($this->collElements instanceof PropelCollection) {
            $this->collElements->clearIterator();
        }
        $this->collElements = null;
        $this->aDbxref = null;
        $this->aContact = null;
        $this->aCvtermRelatedByPlatformtypeId = null;
        $this->aProtocol = null;
        $this->aCvtermRelatedBySubstratetypeId = null;
    }

    /**
     * return the string representation of this object
     *
     * @return string
     */
    public function __toString()
    {
        return (string) $this->exportTo(ArraydesignPeer::DEFAULT_STRING_FORMAT);
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
