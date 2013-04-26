<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AssayPeer;
use cli_db\propel\Control;
use cli_db\propel\ControlPeer;
use cli_db\propel\CvtermPeer;
use cli_db\propel\TableinfoPeer;
use cli_db\propel\map\ControlTableMap;

/**
 * Base static class for performing query and update operations on the 'control' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseControlPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'control';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Control';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ControlTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 8;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    /** the column name for the control_id field */
    const CONTROL_ID = 'control.control_id';

    /** the column name for the type_id field */
    const TYPE_ID = 'control.type_id';

    /** the column name for the assay_id field */
    const ASSAY_ID = 'control.assay_id';

    /** the column name for the tableinfo_id field */
    const TABLEINFO_ID = 'control.tableinfo_id';

    /** the column name for the row_id field */
    const ROW_ID = 'control.row_id';

    /** the column name for the name field */
    const NAME = 'control.name';

    /** the column name for the value field */
    const VALUE = 'control.value';

    /** the column name for the rank field */
    const RANK = 'control.rank';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Control objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Control[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ControlPeer::$fieldNames[ControlPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('ControlId', 'TypeId', 'AssayId', 'TableinfoId', 'RowId', 'Name', 'Value', 'Rank', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('controlId', 'typeId', 'assayId', 'tableinfoId', 'rowId', 'name', 'value', 'rank', ),
        BasePeer::TYPE_COLNAME => array (ControlPeer::CONTROL_ID, ControlPeer::TYPE_ID, ControlPeer::ASSAY_ID, ControlPeer::TABLEINFO_ID, ControlPeer::ROW_ID, ControlPeer::NAME, ControlPeer::VALUE, ControlPeer::RANK, ),
        BasePeer::TYPE_RAW_COLNAME => array ('CONTROL_ID', 'TYPE_ID', 'ASSAY_ID', 'TABLEINFO_ID', 'ROW_ID', 'NAME', 'VALUE', 'RANK', ),
        BasePeer::TYPE_FIELDNAME => array ('control_id', 'type_id', 'assay_id', 'tableinfo_id', 'row_id', 'name', 'value', 'rank', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ControlPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('ControlId' => 0, 'TypeId' => 1, 'AssayId' => 2, 'TableinfoId' => 3, 'RowId' => 4, 'Name' => 5, 'Value' => 6, 'Rank' => 7, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('controlId' => 0, 'typeId' => 1, 'assayId' => 2, 'tableinfoId' => 3, 'rowId' => 4, 'name' => 5, 'value' => 6, 'rank' => 7, ),
        BasePeer::TYPE_COLNAME => array (ControlPeer::CONTROL_ID => 0, ControlPeer::TYPE_ID => 1, ControlPeer::ASSAY_ID => 2, ControlPeer::TABLEINFO_ID => 3, ControlPeer::ROW_ID => 4, ControlPeer::NAME => 5, ControlPeer::VALUE => 6, ControlPeer::RANK => 7, ),
        BasePeer::TYPE_RAW_COLNAME => array ('CONTROL_ID' => 0, 'TYPE_ID' => 1, 'ASSAY_ID' => 2, 'TABLEINFO_ID' => 3, 'ROW_ID' => 4, 'NAME' => 5, 'VALUE' => 6, 'RANK' => 7, ),
        BasePeer::TYPE_FIELDNAME => array ('control_id' => 0, 'type_id' => 1, 'assay_id' => 2, 'tableinfo_id' => 3, 'row_id' => 4, 'name' => 5, 'value' => 6, 'rank' => 7, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * Translates a fieldname to another type
     *
     * @param      string $name field name
     * @param      string $fromType One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                         BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @param      string $toType   One of the class type constants
     * @return string          translated name of the field.
     * @throws PropelException - if the specified name could not be found in the fieldname mappings.
     */
    public static function translateFieldName($name, $fromType, $toType)
    {
        $toNames = ControlPeer::getFieldNames($toType);
        $key = isset(ControlPeer::$fieldKeys[$fromType][$name]) ? ControlPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ControlPeer::$fieldKeys[$fromType], true));
        }

        return $toNames[$key];
    }

    /**
     * Returns an array of field names.
     *
     * @param      string $type The type of fieldnames to return:
     *                      One of the class type constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME
     *                      BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM
     * @return array           A list of field names
     * @throws PropelException - if the type is not valid.
     */
    public static function getFieldNames($type = BasePeer::TYPE_PHPNAME)
    {
        if (!array_key_exists($type, ControlPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ControlPeer::$fieldNames[$type];
    }

    /**
     * Convenience method which changes table.column to alias.column.
     *
     * Using this method you can maintain SQL abstraction while using column aliases.
     * <code>
     *		$c->addAlias("alias1", TablePeer::TABLE_NAME);
     *		$c->addJoin(TablePeer::alias("alias1", TablePeer::PRIMARY_KEY_COLUMN), TablePeer::PRIMARY_KEY_COLUMN);
     * </code>
     * @param      string $alias The alias for the current table.
     * @param      string $column The column name for current table. (i.e. ControlPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ControlPeer::TABLE_NAME.'.', $alias.'.', $column);
    }

    /**
     * Add all the columns needed to create a new object.
     *
     * Note: any columns that were marked with lazyLoad="true" in the
     * XML schema will not be added to the select list and only loaded
     * on demand.
     *
     * @param      Criteria $criteria object containing the columns to add.
     * @param      string   $alias    optional table alias
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function addSelectColumns(Criteria $criteria, $alias = null)
    {
        if (null === $alias) {
            $criteria->addSelectColumn(ControlPeer::CONTROL_ID);
            $criteria->addSelectColumn(ControlPeer::TYPE_ID);
            $criteria->addSelectColumn(ControlPeer::ASSAY_ID);
            $criteria->addSelectColumn(ControlPeer::TABLEINFO_ID);
            $criteria->addSelectColumn(ControlPeer::ROW_ID);
            $criteria->addSelectColumn(ControlPeer::NAME);
            $criteria->addSelectColumn(ControlPeer::VALUE);
            $criteria->addSelectColumn(ControlPeer::RANK);
        } else {
            $criteria->addSelectColumn($alias . '.control_id');
            $criteria->addSelectColumn($alias . '.type_id');
            $criteria->addSelectColumn($alias . '.assay_id');
            $criteria->addSelectColumn($alias . '.tableinfo_id');
            $criteria->addSelectColumn($alias . '.row_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.value');
            $criteria->addSelectColumn($alias . '.rank');
        }
    }

    /**
     * Returns the number of rows matching criteria.
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @return int Number of matching rows.
     */
    public static function doCount(Criteria $criteria, $distinct = false, PropelPDO $con = null)
    {
        // we may modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ControlPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        // BasePeer returns a PDOStatement
        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }
    /**
     * Selects one object from the DB.
     *
     * @param      Criteria $criteria object used to create the SELECT statement.
     * @param      PropelPDO $con
     * @return                 Control
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ControlPeer::doSelect($critcopy, $con);
        if ($objects) {
            return $objects[0];
        }

        return null;
    }
    /**
     * Selects several row from the DB.
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con
     * @return array           Array of selected Objects
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelect(Criteria $criteria, PropelPDO $con = null)
    {
        return ControlPeer::populateObjects(ControlPeer::doSelectStmt($criteria, $con));
    }
    /**
     * Prepares the Criteria object and uses the parent doSelect() method to execute a PDOStatement.
     *
     * Use this method directly if you want to work with an executed statement directly (for example
     * to perform your own object hydration).
     *
     * @param      Criteria $criteria The Criteria object used to build the SELECT statement.
     * @param      PropelPDO $con The connection to use
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return PDOStatement The executed PDOStatement object.
     * @see        BasePeer::doSelect()
     */
    public static function doSelectStmt(Criteria $criteria, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ControlPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        // BasePeer returns a PDOStatement
        return BasePeer::doSelect($criteria, $con);
    }
    /**
     * Adds an object to the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doSelect*()
     * methods in your stub classes -- you may need to explicitly add objects
     * to the cache in order to ensure that the same objects are always returned by doSelect*()
     * and retrieveByPK*() calls.
     *
     * @param      Control $obj A Control object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getControlId();
            } // if key === null
            ControlPeer::$instances[$key] = $obj;
        }
    }

    /**
     * Removes an object from the instance pool.
     *
     * Propel keeps cached copies of objects in an instance pool when they are retrieved
     * from the database.  In some cases -- especially when you override doDelete
     * methods in your stub classes -- you may need to explicitly remove objects
     * from the cache in order to prevent returning objects that no longer exist.
     *
     * @param      mixed $value A Control object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Control) {
                $key = (string) $value->getControlId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Control object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ControlPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Control Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ControlPeer::$instances[$key])) {
                return ControlPeer::$instances[$key];
            }
        }

        return null; // just to be explicit
    }

    /**
     * Clear the instance pool.
     *
     * @return void
     */
    public static function clearInstancePool($and_clear_all_references = false)
    {
      if ($and_clear_all_references)
      {
        foreach (ControlPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        ControlPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to control
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
    }

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return string A string version of PK or null if the components of primary key in result array are all null.
     */
    public static function getPrimaryKeyHashFromRow($row, $startcol = 0)
    {
        // If the PK cannot be derived from the row, return null.
        if ($row[$startcol] === null) {
            return null;
        }

        return (string) $row[$startcol];
    }

    /**
     * Retrieves the primary key from the DB resultset row
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, an array of the primary key columns will be returned.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @return mixed The primary key of the row
     */
    public static function getPrimaryKeyFromRow($row, $startcol = 0)
    {

        return (int) $row[$startcol];
    }

    /**
     * The returned array will contain objects of the default type or
     * objects that inherit from the default.
     *
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function populateObjects(PDOStatement $stmt)
    {
        $results = array();

        // set the class once to avoid overhead in the loop
        $cls = ControlPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ControlPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ControlPeer::addInstanceToPool($obj, $key);
            } // if key exists
        }
        $stmt->closeCursor();

        return $results;
    }
    /**
     * Populates an object of the default type or an object that inherit from the default.
     *
     * @param      array $row PropelPDO resultset row.
     * @param      int $startcol The 0-based offset for reading from the resultset row.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     * @return array (Control object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ControlPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ControlPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ControlPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ControlPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ControlPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Assay table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAssay(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Tableinfo table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinTableinfo(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cvterm table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCvterm(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Control objects pre-filled with their Assay objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAssay(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol = ControlPeer::NUM_HYDRATE_COLUMNS;
        AssayPeer::addSelectColumns($criteria);

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AssayPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AssayPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AssayPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AssayPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Control) to $obj2 (Assay)
                $obj2->addControl($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Control objects pre-filled with their Tableinfo objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinTableinfo(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol = ControlPeer::NUM_HYDRATE_COLUMNS;
        TableinfoPeer::addSelectColumns($criteria);

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = TableinfoPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = TableinfoPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TableinfoPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    TableinfoPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Control) to $obj2 (Tableinfo)
                $obj2->addControl($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Control objects pre-filled with their Cvterm objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCvterm(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol = ControlPeer::NUM_HYDRATE_COLUMNS;
        CvtermPeer::addSelectColumns($criteria);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CvtermPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CvtermPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CvtermPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Control) to $obj2 (Cvterm)
                $obj2->addControl($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining all related tables
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAll(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }

    /**
     * Selects a collection of Control objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol2 = ControlPeer::NUM_HYDRATE_COLUMNS;

        AssayPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssayPeer::NUM_HYDRATE_COLUMNS;

        TableinfoPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TableinfoPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Assay rows

            $key2 = AssayPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AssayPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AssayPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssayPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Control) to the collection in $obj2 (Assay)
                $obj2->addControl($obj1);
            } // if joined row not null

            // Add objects for joined Tableinfo rows

            $key3 = TableinfoPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = TableinfoPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = TableinfoPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TableinfoPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Control) to the collection in $obj3 (Tableinfo)
                $obj3->addControl($obj1);
            } // if joined row not null

            // Add objects for joined Cvterm rows

            $key4 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = CvtermPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = CvtermPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    CvtermPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Control) to the collection in $obj4 (Cvterm)
                $obj4->addControl($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Assay table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAssay(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Tableinfo table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptTableinfo(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cvterm table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCvterm(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ControlPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ControlPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $stmt = BasePeer::doCount($criteria, $con);

        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $count = (int) $row[0];
        } else {
            $count = 0; // no rows returned; we infer that means 0 matches.
        }
        $stmt->closeCursor();

        return $count;
    }


    /**
     * Selects a collection of Control objects pre-filled with all related objects except Assay.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAssay(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol2 = ControlPeer::NUM_HYDRATE_COLUMNS;

        TableinfoPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + TableinfoPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Tableinfo rows

                $key2 = TableinfoPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = TableinfoPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = TableinfoPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    TableinfoPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Control) to the collection in $obj2 (Tableinfo)
                $obj2->addControl($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key3 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CvtermPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CvtermPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CvtermPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Control) to the collection in $obj3 (Cvterm)
                $obj3->addControl($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Control objects pre-filled with all related objects except Tableinfo.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptTableinfo(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol2 = ControlPeer::NUM_HYDRATE_COLUMNS;

        AssayPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssayPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Assay rows

                $key2 = AssayPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssayPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssayPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssayPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Control) to the collection in $obj2 (Assay)
                $obj2->addControl($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key3 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = CvtermPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = CvtermPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    CvtermPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Control) to the collection in $obj3 (Cvterm)
                $obj3->addControl($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Control objects pre-filled with all related objects except Cvterm.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Control objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCvterm(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ControlPeer::DATABASE_NAME);
        }

        ControlPeer::addSelectColumns($criteria);
        $startcol2 = ControlPeer::NUM_HYDRATE_COLUMNS;

        AssayPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AssayPeer::NUM_HYDRATE_COLUMNS;

        TableinfoPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TableinfoPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ControlPeer::ASSAY_ID, AssayPeer::ASSAY_ID, $join_behavior);

        $criteria->addJoin(ControlPeer::TABLEINFO_ID, TableinfoPeer::TABLEINFO_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ControlPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ControlPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ControlPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ControlPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Assay rows

                $key2 = AssayPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AssayPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AssayPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AssayPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Control) to the collection in $obj2 (Assay)
                $obj2->addControl($obj1);

            } // if joined row is not null

                // Add objects for joined Tableinfo rows

                $key3 = TableinfoPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = TableinfoPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = TableinfoPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TableinfoPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Control) to the collection in $obj3 (Tableinfo)
                $obj3->addControl($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }

    /**
     * Returns the TableMap related to this peer.
     * This method is not needed for general use but a specific application could have a need.
     * @return TableMap
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function getTableMap()
    {
        return Propel::getDatabaseMap(ControlPeer::DATABASE_NAME)->getTable(ControlPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseControlPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseControlPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new ControlTableMap());
      }
    }

    /**
     * The class that the Peer will make instances of.
     *
     *
     * @return string ClassName
     */
    public static function getOMClass($row = 0, $colnum = 0)
    {
        return ControlPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Control or Criteria object.
     *
     * @param      mixed $values Criteria or Control object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Control object
        }

        if ($criteria->containsKey(ControlPeer::CONTROL_ID) && $criteria->keyContainsValue(ControlPeer::CONTROL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ControlPeer::CONTROL_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        try {
            // use transaction because $criteria could contain info
            // for more than one table (I guess, conceivably)
            $con->beginTransaction();
            $pk = BasePeer::doInsert($criteria, $con);
            $con->commit();
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }

        return $pk;
    }

    /**
     * Performs an UPDATE on the database, given a Control or Criteria object.
     *
     * @param      mixed $values Criteria or Control object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ControlPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ControlPeer::CONTROL_ID);
            $value = $criteria->remove(ControlPeer::CONTROL_ID);
            if ($value) {
                $selectCriteria->add(ControlPeer::CONTROL_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ControlPeer::TABLE_NAME);
            }

        } else { // $values is Control object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the control table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ControlPeer::TABLE_NAME, $con, ControlPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ControlPeer::clearInstancePool();
            ControlPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Control or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Control object or primary key or array of primary keys
     *              which is used to create the DELETE statement
     * @param      PropelPDO $con the connection to use
     * @return int The number of affected rows (if supported by underlying database driver).  This includes CASCADE-related rows
     *				if supported by native driver or if emulated using Propel.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
     public static function doDelete($values, PropelPDO $con = null)
     {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ControlPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Control) { // it's a model object
            // invalidate the cache for this single object
            ControlPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ControlPeer::DATABASE_NAME);
            $criteria->add(ControlPeer::CONTROL_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ControlPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ControlPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ControlPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Control object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Control $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ControlPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ControlPeer::TABLE_NAME);

            if (! is_array($cols)) {
                $cols = array($cols);
            }

            foreach ($cols as $colName) {
                if ($tableMap->hasColumn($colName)) {
                    $get = 'get' . $tableMap->getColumn($colName)->getPhpName();
                    $columns[$colName] = $obj->$get();
                }
            }
        } else {

        }

        return BasePeer::doValidate(ControlPeer::DATABASE_NAME, ControlPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Control
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ControlPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ControlPeer::DATABASE_NAME);
        $criteria->add(ControlPeer::CONTROL_ID, $pk);

        $v = ControlPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Control[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ControlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ControlPeer::DATABASE_NAME);
            $criteria->add(ControlPeer::CONTROL_ID, $pks, Criteria::IN);
            $objs = ControlPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseControlPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseControlPeer::buildTableMap();

