<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AnalysisPeer;
use cli_db\propel\Expressionresult;
use cli_db\propel\ExpressionresultPeer;
use cli_db\propel\map\ExpressionresultTableMap;

/**
 * Base static class for performing query and update operations on the 'expressionresult' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseExpressionresultPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'expressionresult';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Expressionresult';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ExpressionresultTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 9;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 9;

    /** the column name for the expressionresult_id field */
    const EXPRESSIONRESULT_ID = 'expressionresult.expressionresult_id';

    /** the column name for the analysis_id field */
    const ANALYSIS_ID = 'expressionresult.analysis_id';

    /** the column name for the baseMean field */
    const BASEMEAN = 'expressionresult.baseMean';

    /** the column name for the baseMeanA field */
    const BASEMEANA = 'expressionresult.baseMeanA';

    /** the column name for the baseMeanB field */
    const BASEMEANB = 'expressionresult.baseMeanB';

    /** the column name for the foldChange field */
    const FOLDCHANGE = 'expressionresult.foldChange';

    /** the column name for the log2foldChange field */
    const LOG2FOLDCHANGE = 'expressionresult.log2foldChange';

    /** the column name for the pval field */
    const PVAL = 'expressionresult.pval';

    /** the column name for the pvaladj field */
    const PVALADJ = 'expressionresult.pvaladj';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Expressionresult objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Expressionresult[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ExpressionresultPeer::$fieldNames[ExpressionresultPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('ExpressionresultId', 'AnalysisId', 'Basemean', 'Basemeana', 'Basemeanb', 'Foldchange', 'Log2foldchange', 'Pval', 'Pvaladj', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('expressionresultId', 'analysisId', 'basemean', 'basemeana', 'basemeanb', 'foldchange', 'log2foldchange', 'pval', 'pvaladj', ),
        BasePeer::TYPE_COLNAME => array (ExpressionresultPeer::EXPRESSIONRESULT_ID, ExpressionresultPeer::ANALYSIS_ID, ExpressionresultPeer::BASEMEAN, ExpressionresultPeer::BASEMEANA, ExpressionresultPeer::BASEMEANB, ExpressionresultPeer::FOLDCHANGE, ExpressionresultPeer::LOG2FOLDCHANGE, ExpressionresultPeer::PVAL, ExpressionresultPeer::PVALADJ, ),
        BasePeer::TYPE_RAW_COLNAME => array ('EXPRESSIONRESULT_ID', 'ANALYSIS_ID', 'BASEMEAN', 'BASEMEANA', 'BASEMEANB', 'FOLDCHANGE', 'LOG2FOLDCHANGE', 'PVAL', 'PVALADJ', ),
        BasePeer::TYPE_FIELDNAME => array ('expressionresult_id', 'analysis_id', 'baseMean', 'baseMeanA', 'baseMeanB', 'foldChange', 'log2foldChange', 'pval', 'pvaladj', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ExpressionresultPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('ExpressionresultId' => 0, 'AnalysisId' => 1, 'Basemean' => 2, 'Basemeana' => 3, 'Basemeanb' => 4, 'Foldchange' => 5, 'Log2foldchange' => 6, 'Pval' => 7, 'Pvaladj' => 8, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('expressionresultId' => 0, 'analysisId' => 1, 'basemean' => 2, 'basemeana' => 3, 'basemeanb' => 4, 'foldchange' => 5, 'log2foldchange' => 6, 'pval' => 7, 'pvaladj' => 8, ),
        BasePeer::TYPE_COLNAME => array (ExpressionresultPeer::EXPRESSIONRESULT_ID => 0, ExpressionresultPeer::ANALYSIS_ID => 1, ExpressionresultPeer::BASEMEAN => 2, ExpressionresultPeer::BASEMEANA => 3, ExpressionresultPeer::BASEMEANB => 4, ExpressionresultPeer::FOLDCHANGE => 5, ExpressionresultPeer::LOG2FOLDCHANGE => 6, ExpressionresultPeer::PVAL => 7, ExpressionresultPeer::PVALADJ => 8, ),
        BasePeer::TYPE_RAW_COLNAME => array ('EXPRESSIONRESULT_ID' => 0, 'ANALYSIS_ID' => 1, 'BASEMEAN' => 2, 'BASEMEANA' => 3, 'BASEMEANB' => 4, 'FOLDCHANGE' => 5, 'LOG2FOLDCHANGE' => 6, 'PVAL' => 7, 'PVALADJ' => 8, ),
        BasePeer::TYPE_FIELDNAME => array ('expressionresult_id' => 0, 'analysis_id' => 1, 'baseMean' => 2, 'baseMeanA' => 3, 'baseMeanB' => 4, 'foldChange' => 5, 'log2foldChange' => 6, 'pval' => 7, 'pvaladj' => 8, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, )
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
        $toNames = ExpressionresultPeer::getFieldNames($toType);
        $key = isset(ExpressionresultPeer::$fieldKeys[$fromType][$name]) ? ExpressionresultPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ExpressionresultPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, ExpressionresultPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ExpressionresultPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. ExpressionresultPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ExpressionresultPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(ExpressionresultPeer::EXPRESSIONRESULT_ID);
            $criteria->addSelectColumn(ExpressionresultPeer::ANALYSIS_ID);
            $criteria->addSelectColumn(ExpressionresultPeer::BASEMEAN);
            $criteria->addSelectColumn(ExpressionresultPeer::BASEMEANA);
            $criteria->addSelectColumn(ExpressionresultPeer::BASEMEANB);
            $criteria->addSelectColumn(ExpressionresultPeer::FOLDCHANGE);
            $criteria->addSelectColumn(ExpressionresultPeer::LOG2FOLDCHANGE);
            $criteria->addSelectColumn(ExpressionresultPeer::PVAL);
            $criteria->addSelectColumn(ExpressionresultPeer::PVALADJ);
        } else {
            $criteria->addSelectColumn($alias . '.expressionresult_id');
            $criteria->addSelectColumn($alias . '.analysis_id');
            $criteria->addSelectColumn($alias . '.baseMean');
            $criteria->addSelectColumn($alias . '.baseMeanA');
            $criteria->addSelectColumn($alias . '.baseMeanB');
            $criteria->addSelectColumn($alias . '.foldChange');
            $criteria->addSelectColumn($alias . '.log2foldChange');
            $criteria->addSelectColumn($alias . '.pval');
            $criteria->addSelectColumn($alias . '.pvaladj');
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
        $criteria->setPrimaryTableName(ExpressionresultPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ExpressionresultPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Expressionresult
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ExpressionresultPeer::doSelect($critcopy, $con);
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
        return ExpressionresultPeer::populateObjects(ExpressionresultPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ExpressionresultPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

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
     * @param      Expressionresult $obj A Expressionresult object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getExpressionresultId();
            } // if key === null
            ExpressionresultPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Expressionresult object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Expressionresult) {
                $key = (string) $value->getExpressionresultId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Expressionresult object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ExpressionresultPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Expressionresult Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ExpressionresultPeer::$instances[$key])) {
                return ExpressionresultPeer::$instances[$key];
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
        foreach (ExpressionresultPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        ExpressionresultPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to expressionresult
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
        $cls = ExpressionresultPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ExpressionresultPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ExpressionresultPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ExpressionresultPeer::addInstanceToPool($obj, $key);
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
     * @return array (Expressionresult object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ExpressionresultPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ExpressionresultPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ExpressionresultPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ExpressionresultPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ExpressionresultPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Analysis table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAnalysis(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ExpressionresultPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ExpressionresultPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ExpressionresultPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

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
     * Selects a collection of Expressionresult objects pre-filled with their Analysis objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Expressionresult objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAnalysis(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);
        }

        ExpressionresultPeer::addSelectColumns($criteria);
        $startcol = ExpressionresultPeer::NUM_HYDRATE_COLUMNS;
        AnalysisPeer::addSelectColumns($criteria);

        $criteria->addJoin(ExpressionresultPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ExpressionresultPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ExpressionresultPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ExpressionresultPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ExpressionresultPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AnalysisPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AnalysisPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AnalysisPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AnalysisPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Expressionresult) to $obj2 (Analysis)
                $obj2->addExpressionresult($obj1);

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
        $criteria->setPrimaryTableName(ExpressionresultPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ExpressionresultPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ExpressionresultPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

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
     * Selects a collection of Expressionresult objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Expressionresult objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);
        }

        ExpressionresultPeer::addSelectColumns($criteria);
        $startcol2 = ExpressionresultPeer::NUM_HYDRATE_COLUMNS;

        AnalysisPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AnalysisPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ExpressionresultPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ExpressionresultPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ExpressionresultPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ExpressionresultPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ExpressionresultPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Analysis rows

            $key2 = AnalysisPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AnalysisPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AnalysisPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AnalysisPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Expressionresult) to the collection in $obj2 (Analysis)
                $obj2->addExpressionresult($obj1);
            } // if joined row not null

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
        return Propel::getDatabaseMap(ExpressionresultPeer::DATABASE_NAME)->getTable(ExpressionresultPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseExpressionresultPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseExpressionresultPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new ExpressionresultTableMap());
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
        return ExpressionresultPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Expressionresult or Criteria object.
     *
     * @param      mixed $values Criteria or Expressionresult object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Expressionresult object
        }

        if ($criteria->containsKey(ExpressionresultPeer::EXPRESSIONRESULT_ID) && $criteria->keyContainsValue(ExpressionresultPeer::EXPRESSIONRESULT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ExpressionresultPeer::EXPRESSIONRESULT_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Expressionresult or Criteria object.
     *
     * @param      mixed $values Criteria or Expressionresult object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ExpressionresultPeer::EXPRESSIONRESULT_ID);
            $value = $criteria->remove(ExpressionresultPeer::EXPRESSIONRESULT_ID);
            if ($value) {
                $selectCriteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ExpressionresultPeer::TABLE_NAME);
            }

        } else { // $values is Expressionresult object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the expressionresult table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ExpressionresultPeer::TABLE_NAME, $con, ExpressionresultPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ExpressionresultPeer::clearInstancePool();
            ExpressionresultPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Expressionresult or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Expressionresult object or primary key or array of primary keys
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
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ExpressionresultPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Expressionresult) { // it's a model object
            // invalidate the cache for this single object
            ExpressionresultPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);
            $criteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ExpressionresultPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ExpressionresultPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ExpressionresultPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Expressionresult object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Expressionresult $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ExpressionresultPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ExpressionresultPeer::TABLE_NAME);

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

        return BasePeer::doValidate(ExpressionresultPeer::DATABASE_NAME, ExpressionresultPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Expressionresult
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ExpressionresultPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);
        $criteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, $pk);

        $v = ExpressionresultPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Expressionresult[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ExpressionresultPeer::DATABASE_NAME);
            $criteria->add(ExpressionresultPeer::EXPRESSIONRESULT_ID, $pks, Criteria::IN);
            $objs = ExpressionresultPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseExpressionresultPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseExpressionresultPeer::buildTableMap();

