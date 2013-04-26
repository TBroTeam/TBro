<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\BiomaterialDbxref;
use cli_db\propel\BiomaterialDbxrefPeer;
use cli_db\propel\BiomaterialPeer;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\map\BiomaterialDbxrefTableMap;

/**
 * Base static class for performing query and update operations on the 'biomaterial_dbxref' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseBiomaterialDbxrefPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'biomaterial_dbxref';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\BiomaterialDbxref';

    /** the related TableMap class for this table */
    const TM_CLASS = 'BiomaterialDbxrefTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 3;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 3;

    /** the column name for the biomaterial_dbxref_id field */
    const BIOMATERIAL_DBXREF_ID = 'biomaterial_dbxref.biomaterial_dbxref_id';

    /** the column name for the biomaterial_id field */
    const BIOMATERIAL_ID = 'biomaterial_dbxref.biomaterial_id';

    /** the column name for the dbxref_id field */
    const DBXREF_ID = 'biomaterial_dbxref.dbxref_id';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of BiomaterialDbxref objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array BiomaterialDbxref[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialDbxrefPeer::$fieldNames[BiomaterialDbxrefPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialDbxrefId', 'BiomaterialId', 'DbxrefId', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialDbxrefId', 'biomaterialId', 'dbxrefId', ),
        BasePeer::TYPE_COLNAME => array (BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialDbxrefPeer::DBXREF_ID, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_DBXREF_ID', 'BIOMATERIAL_ID', 'DBXREF_ID', ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_dbxref_id', 'biomaterial_id', 'dbxref_id', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialDbxrefPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialDbxrefId' => 0, 'BiomaterialId' => 1, 'DbxrefId' => 2, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialDbxrefId' => 0, 'biomaterialId' => 1, 'dbxrefId' => 2, ),
        BasePeer::TYPE_COLNAME => array (BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID => 0, BiomaterialDbxrefPeer::BIOMATERIAL_ID => 1, BiomaterialDbxrefPeer::DBXREF_ID => 2, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_DBXREF_ID' => 0, 'BIOMATERIAL_ID' => 1, 'DBXREF_ID' => 2, ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_dbxref_id' => 0, 'biomaterial_id' => 1, 'dbxref_id' => 2, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, )
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
        $toNames = BiomaterialDbxrefPeer::getFieldNames($toType);
        $key = isset(BiomaterialDbxrefPeer::$fieldKeys[$fromType][$name]) ? BiomaterialDbxrefPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BiomaterialDbxrefPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BiomaterialDbxrefPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BiomaterialDbxrefPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BiomaterialDbxrefPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BiomaterialDbxrefPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID);
            $criteria->addSelectColumn(BiomaterialDbxrefPeer::BIOMATERIAL_ID);
            $criteria->addSelectColumn(BiomaterialDbxrefPeer::DBXREF_ID);
        } else {
            $criteria->addSelectColumn($alias . '.biomaterial_dbxref_id');
            $criteria->addSelectColumn($alias . '.biomaterial_id');
            $criteria->addSelectColumn($alias . '.dbxref_id');
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
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BiomaterialDbxref
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BiomaterialDbxrefPeer::doSelect($critcopy, $con);
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
        return BiomaterialDbxrefPeer::populateObjects(BiomaterialDbxrefPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

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
     * @param      BiomaterialDbxref $obj A BiomaterialDbxref object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getBiomaterialDbxrefId();
            } // if key === null
            BiomaterialDbxrefPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A BiomaterialDbxref object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof BiomaterialDbxref) {
                $key = (string) $value->getBiomaterialDbxrefId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or BiomaterialDbxref object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BiomaterialDbxrefPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   BiomaterialDbxref Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BiomaterialDbxrefPeer::$instances[$key])) {
                return BiomaterialDbxrefPeer::$instances[$key];
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
        foreach (BiomaterialDbxrefPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        BiomaterialDbxrefPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to biomaterial_dbxref
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
        $cls = BiomaterialDbxrefPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BiomaterialDbxrefPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BiomaterialDbxrefPeer::addInstanceToPool($obj, $key);
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
     * @return array (BiomaterialDbxref object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BiomaterialDbxrefPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BiomaterialDbxrefPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BiomaterialDbxrefPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Biomaterial table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinBiomaterial(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Dbxref table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinDbxref(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Selects a collection of BiomaterialDbxref objects pre-filled with their Biomaterial objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialDbxref objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBiomaterial(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);
        }

        BiomaterialDbxrefPeer::addSelectColumns($criteria);
        $startcol = BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;
        BiomaterialPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialDbxrefPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialDbxrefPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialDbxrefPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = BiomaterialPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BiomaterialPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    BiomaterialPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BiomaterialDbxref) to $obj2 (Biomaterial)
                $obj2->addBiomaterialDbxref($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialDbxref objects pre-filled with their Dbxref objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialDbxref objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinDbxref(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);
        }

        BiomaterialDbxrefPeer::addSelectColumns($criteria);
        $startcol = BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;
        DbxrefPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialDbxrefPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialDbxrefPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialDbxrefPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = DbxrefPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = DbxrefPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = DbxrefPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    DbxrefPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BiomaterialDbxref) to $obj2 (Dbxref)
                $obj2->addBiomaterialDbxref($obj1);

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
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Selects a collection of BiomaterialDbxref objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialDbxref objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);
        }

        BiomaterialDbxrefPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialDbxrefPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialDbxrefPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialDbxrefPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Biomaterial rows

            $key2 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = BiomaterialPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = BiomaterialPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BiomaterialPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (BiomaterialDbxref) to the collection in $obj2 (Biomaterial)
                $obj2->addBiomaterialDbxref($obj1);
            } // if joined row not null

            // Add objects for joined Dbxref rows

            $key3 = DbxrefPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = DbxrefPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = DbxrefPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    DbxrefPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (BiomaterialDbxref) to the collection in $obj3 (Dbxref)
                $obj3->addBiomaterialDbxref($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Biomaterial table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptBiomaterial(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Dbxref table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptDbxref(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialDbxrefPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

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
     * Selects a collection of BiomaterialDbxref objects pre-filled with all related objects except Biomaterial.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialDbxref objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptBiomaterial(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);
        }

        BiomaterialDbxrefPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialDbxrefPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialDbxrefPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialDbxrefPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialDbxrefPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Dbxref rows

                $key2 = DbxrefPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = DbxrefPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = DbxrefPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    DbxrefPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BiomaterialDbxref) to the collection in $obj2 (Dbxref)
                $obj2->addBiomaterialDbxref($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialDbxref objects pre-filled with all related objects except Dbxref.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialDbxref objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptDbxref(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);
        }

        BiomaterialDbxrefPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialDbxrefPeer::NUM_HYDRATE_COLUMNS;

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialDbxrefPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialDbxrefPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialDbxrefPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialDbxrefPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialDbxrefPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Biomaterial rows

                $key2 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = BiomaterialPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = BiomaterialPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    BiomaterialPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BiomaterialDbxref) to the collection in $obj2 (Biomaterial)
                $obj2->addBiomaterialDbxref($obj1);

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
        return Propel::getDatabaseMap(BiomaterialDbxrefPeer::DATABASE_NAME)->getTable(BiomaterialDbxrefPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBiomaterialDbxrefPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBiomaterialDbxrefPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new BiomaterialDbxrefTableMap());
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
        return BiomaterialDbxrefPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a BiomaterialDbxref or Criteria object.
     *
     * @param      mixed $values Criteria or BiomaterialDbxref object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from BiomaterialDbxref object
        }

        if ($criteria->containsKey(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID) && $criteria->keyContainsValue(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a BiomaterialDbxref or Criteria object.
     *
     * @param      mixed $values Criteria or BiomaterialDbxref object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BiomaterialDbxrefPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID);
            $value = $criteria->remove(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID);
            if ($value) {
                $selectCriteria->add(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BiomaterialDbxrefPeer::TABLE_NAME);
            }

        } else { // $values is BiomaterialDbxref object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the biomaterial_dbxref table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BiomaterialDbxrefPeer::TABLE_NAME, $con, BiomaterialDbxrefPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BiomaterialDbxrefPeer::clearInstancePool();
            BiomaterialDbxrefPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a BiomaterialDbxref or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or BiomaterialDbxref object or primary key or array of primary keys
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
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BiomaterialDbxrefPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof BiomaterialDbxref) { // it's a model object
            // invalidate the cache for this single object
            BiomaterialDbxrefPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BiomaterialDbxrefPeer::DATABASE_NAME);
            $criteria->add(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BiomaterialDbxrefPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialDbxrefPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BiomaterialDbxrefPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given BiomaterialDbxref object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      BiomaterialDbxref $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BiomaterialDbxrefPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BiomaterialDbxrefPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BiomaterialDbxrefPeer::DATABASE_NAME, BiomaterialDbxrefPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return BiomaterialDbxref
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BiomaterialDbxrefPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BiomaterialDbxrefPeer::DATABASE_NAME);
        $criteria->add(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $pk);

        $v = BiomaterialDbxrefPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return BiomaterialDbxref[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BiomaterialDbxrefPeer::DATABASE_NAME);
            $criteria->add(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $pks, Criteria::IN);
            $objs = BiomaterialDbxrefPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBiomaterialDbxrefPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBiomaterialDbxrefPeer::buildTableMap();

