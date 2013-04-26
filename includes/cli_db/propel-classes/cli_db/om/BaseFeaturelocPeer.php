<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\FeaturePeer;
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocPeer;
use cli_db\propel\FeaturelocPubPeer;
use cli_db\propel\map\FeaturelocTableMap;

/**
 * Base static class for performing query and update operations on the 'featureloc' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseFeaturelocPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'featureloc';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Featureloc';

    /** the related TableMap class for this table */
    const TM_CLASS = 'FeaturelocTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 12;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 12;

    /** the column name for the featureloc_id field */
    const FEATURELOC_ID = 'featureloc.featureloc_id';

    /** the column name for the feature_id field */
    const FEATURE_ID = 'featureloc.feature_id';

    /** the column name for the srcfeature_id field */
    const SRCFEATURE_ID = 'featureloc.srcfeature_id';

    /** the column name for the fmin field */
    const FMIN = 'featureloc.fmin';

    /** the column name for the is_fmin_partial field */
    const IS_FMIN_PARTIAL = 'featureloc.is_fmin_partial';

    /** the column name for the fmax field */
    const FMAX = 'featureloc.fmax';

    /** the column name for the is_fmax_partial field */
    const IS_FMAX_PARTIAL = 'featureloc.is_fmax_partial';

    /** the column name for the strand field */
    const STRAND = 'featureloc.strand';

    /** the column name for the phase field */
    const PHASE = 'featureloc.phase';

    /** the column name for the residue_info field */
    const RESIDUE_INFO = 'featureloc.residue_info';

    /** the column name for the locgroup field */
    const LOCGROUP = 'featureloc.locgroup';

    /** the column name for the rank field */
    const RANK = 'featureloc.rank';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Featureloc objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Featureloc[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. FeaturelocPeer::$fieldNames[FeaturelocPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('FeaturelocId', 'FeatureId', 'SrcfeatureId', 'Fmin', 'IsFminPartial', 'Fmax', 'IsFmaxPartial', 'Strand', 'Phase', 'ResidueInfo', 'Locgroup', 'Rank', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('featurelocId', 'featureId', 'srcfeatureId', 'fmin', 'isFminPartial', 'fmax', 'isFmaxPartial', 'strand', 'phase', 'residueInfo', 'locgroup', 'rank', ),
        BasePeer::TYPE_COLNAME => array (FeaturelocPeer::FEATURELOC_ID, FeaturelocPeer::FEATURE_ID, FeaturelocPeer::SRCFEATURE_ID, FeaturelocPeer::FMIN, FeaturelocPeer::IS_FMIN_PARTIAL, FeaturelocPeer::FMAX, FeaturelocPeer::IS_FMAX_PARTIAL, FeaturelocPeer::STRAND, FeaturelocPeer::PHASE, FeaturelocPeer::RESIDUE_INFO, FeaturelocPeer::LOCGROUP, FeaturelocPeer::RANK, ),
        BasePeer::TYPE_RAW_COLNAME => array ('FEATURELOC_ID', 'FEATURE_ID', 'SRCFEATURE_ID', 'FMIN', 'IS_FMIN_PARTIAL', 'FMAX', 'IS_FMAX_PARTIAL', 'STRAND', 'PHASE', 'RESIDUE_INFO', 'LOCGROUP', 'RANK', ),
        BasePeer::TYPE_FIELDNAME => array ('featureloc_id', 'feature_id', 'srcfeature_id', 'fmin', 'is_fmin_partial', 'fmax', 'is_fmax_partial', 'strand', 'phase', 'residue_info', 'locgroup', 'rank', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. FeaturelocPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('FeaturelocId' => 0, 'FeatureId' => 1, 'SrcfeatureId' => 2, 'Fmin' => 3, 'IsFminPartial' => 4, 'Fmax' => 5, 'IsFmaxPartial' => 6, 'Strand' => 7, 'Phase' => 8, 'ResidueInfo' => 9, 'Locgroup' => 10, 'Rank' => 11, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('featurelocId' => 0, 'featureId' => 1, 'srcfeatureId' => 2, 'fmin' => 3, 'isFminPartial' => 4, 'fmax' => 5, 'isFmaxPartial' => 6, 'strand' => 7, 'phase' => 8, 'residueInfo' => 9, 'locgroup' => 10, 'rank' => 11, ),
        BasePeer::TYPE_COLNAME => array (FeaturelocPeer::FEATURELOC_ID => 0, FeaturelocPeer::FEATURE_ID => 1, FeaturelocPeer::SRCFEATURE_ID => 2, FeaturelocPeer::FMIN => 3, FeaturelocPeer::IS_FMIN_PARTIAL => 4, FeaturelocPeer::FMAX => 5, FeaturelocPeer::IS_FMAX_PARTIAL => 6, FeaturelocPeer::STRAND => 7, FeaturelocPeer::PHASE => 8, FeaturelocPeer::RESIDUE_INFO => 9, FeaturelocPeer::LOCGROUP => 10, FeaturelocPeer::RANK => 11, ),
        BasePeer::TYPE_RAW_COLNAME => array ('FEATURELOC_ID' => 0, 'FEATURE_ID' => 1, 'SRCFEATURE_ID' => 2, 'FMIN' => 3, 'IS_FMIN_PARTIAL' => 4, 'FMAX' => 5, 'IS_FMAX_PARTIAL' => 6, 'STRAND' => 7, 'PHASE' => 8, 'RESIDUE_INFO' => 9, 'LOCGROUP' => 10, 'RANK' => 11, ),
        BasePeer::TYPE_FIELDNAME => array ('featureloc_id' => 0, 'feature_id' => 1, 'srcfeature_id' => 2, 'fmin' => 3, 'is_fmin_partial' => 4, 'fmax' => 5, 'is_fmax_partial' => 6, 'strand' => 7, 'phase' => 8, 'residue_info' => 9, 'locgroup' => 10, 'rank' => 11, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, )
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
        $toNames = FeaturelocPeer::getFieldNames($toType);
        $key = isset(FeaturelocPeer::$fieldKeys[$fromType][$name]) ? FeaturelocPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(FeaturelocPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, FeaturelocPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return FeaturelocPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. FeaturelocPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(FeaturelocPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(FeaturelocPeer::FEATURELOC_ID);
            $criteria->addSelectColumn(FeaturelocPeer::FEATURE_ID);
            $criteria->addSelectColumn(FeaturelocPeer::SRCFEATURE_ID);
            $criteria->addSelectColumn(FeaturelocPeer::FMIN);
            $criteria->addSelectColumn(FeaturelocPeer::IS_FMIN_PARTIAL);
            $criteria->addSelectColumn(FeaturelocPeer::FMAX);
            $criteria->addSelectColumn(FeaturelocPeer::IS_FMAX_PARTIAL);
            $criteria->addSelectColumn(FeaturelocPeer::STRAND);
            $criteria->addSelectColumn(FeaturelocPeer::PHASE);
            $criteria->addSelectColumn(FeaturelocPeer::RESIDUE_INFO);
            $criteria->addSelectColumn(FeaturelocPeer::LOCGROUP);
            $criteria->addSelectColumn(FeaturelocPeer::RANK);
        } else {
            $criteria->addSelectColumn($alias . '.featureloc_id');
            $criteria->addSelectColumn($alias . '.feature_id');
            $criteria->addSelectColumn($alias . '.srcfeature_id');
            $criteria->addSelectColumn($alias . '.fmin');
            $criteria->addSelectColumn($alias . '.is_fmin_partial');
            $criteria->addSelectColumn($alias . '.fmax');
            $criteria->addSelectColumn($alias . '.is_fmax_partial');
            $criteria->addSelectColumn($alias . '.strand');
            $criteria->addSelectColumn($alias . '.phase');
            $criteria->addSelectColumn($alias . '.residue_info');
            $criteria->addSelectColumn($alias . '.locgroup');
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
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Featureloc
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = FeaturelocPeer::doSelect($critcopy, $con);
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
        return FeaturelocPeer::populateObjects(FeaturelocPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            FeaturelocPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

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
     * @param      Featureloc $obj A Featureloc object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getFeaturelocId();
            } // if key === null
            FeaturelocPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Featureloc object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Featureloc) {
                $key = (string) $value->getFeaturelocId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Featureloc object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(FeaturelocPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Featureloc Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(FeaturelocPeer::$instances[$key])) {
                return FeaturelocPeer::$instances[$key];
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
        foreach (FeaturelocPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        FeaturelocPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to featureloc
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in FeaturelocPubPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeaturelocPubPeer::clearInstancePool();
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
        $cls = FeaturelocPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = FeaturelocPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                FeaturelocPeer::addInstanceToPool($obj, $key);
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
     * @return array (Featureloc object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = FeaturelocPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = FeaturelocPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + FeaturelocPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = FeaturelocPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            FeaturelocPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related FeatureRelatedByFeatureId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinFeatureRelatedByFeatureId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(FeaturelocPeer::FEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related FeatureRelatedBySrcfeatureId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinFeatureRelatedBySrcfeatureId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(FeaturelocPeer::SRCFEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

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
     * Selects a collection of Featureloc objects pre-filled with their Feature objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Featureloc objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinFeatureRelatedByFeatureId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);
        }

        FeaturelocPeer::addSelectColumns($criteria);
        $startcol = FeaturelocPeer::NUM_HYDRATE_COLUMNS;
        FeaturePeer::addSelectColumns($criteria);

        $criteria->addJoin(FeaturelocPeer::FEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = FeaturelocPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = FeaturelocPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                FeaturelocPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = FeaturePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = FeaturePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = FeaturePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    FeaturePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Featureloc) to $obj2 (Feature)
                $obj2->addFeaturelocRelatedByFeatureId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Featureloc objects pre-filled with their Feature objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Featureloc objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinFeatureRelatedBySrcfeatureId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);
        }

        FeaturelocPeer::addSelectColumns($criteria);
        $startcol = FeaturelocPeer::NUM_HYDRATE_COLUMNS;
        FeaturePeer::addSelectColumns($criteria);

        $criteria->addJoin(FeaturelocPeer::SRCFEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = FeaturelocPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = FeaturelocPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                FeaturelocPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = FeaturePeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = FeaturePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = FeaturePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    FeaturePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Featureloc) to $obj2 (Feature)
                $obj2->addFeaturelocRelatedBySrcfeatureId($obj1);

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
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(FeaturelocPeer::FEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

        $criteria->addJoin(FeaturelocPeer::SRCFEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

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
     * Selects a collection of Featureloc objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Featureloc objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);
        }

        FeaturelocPeer::addSelectColumns($criteria);
        $startcol2 = FeaturelocPeer::NUM_HYDRATE_COLUMNS;

        FeaturePeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + FeaturePeer::NUM_HYDRATE_COLUMNS;

        FeaturePeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + FeaturePeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(FeaturelocPeer::FEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

        $criteria->addJoin(FeaturelocPeer::SRCFEATURE_ID, FeaturePeer::FEATURE_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = FeaturelocPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = FeaturelocPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                FeaturelocPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Feature rows

            $key2 = FeaturePeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = FeaturePeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = FeaturePeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    FeaturePeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Featureloc) to the collection in $obj2 (Feature)
                $obj2->addFeaturelocRelatedByFeatureId($obj1);
            } // if joined row not null

            // Add objects for joined Feature rows

            $key3 = FeaturePeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = FeaturePeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = FeaturePeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    FeaturePeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Featureloc) to the collection in $obj3 (Feature)
                $obj3->addFeaturelocRelatedBySrcfeatureId($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related FeatureRelatedByFeatureId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptFeatureRelatedByFeatureId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

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
     * Returns the number of rows matching criteria, joining the related FeatureRelatedBySrcfeatureId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptFeatureRelatedBySrcfeatureId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            FeaturelocPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

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
     * Selects a collection of Featureloc objects pre-filled with all related objects except FeatureRelatedByFeatureId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Featureloc objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptFeatureRelatedByFeatureId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);
        }

        FeaturelocPeer::addSelectColumns($criteria);
        $startcol2 = FeaturelocPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = FeaturelocPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = FeaturelocPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                FeaturelocPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Featureloc objects pre-filled with all related objects except FeatureRelatedBySrcfeatureId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Featureloc objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptFeatureRelatedBySrcfeatureId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);
        }

        FeaturelocPeer::addSelectColumns($criteria);
        $startcol2 = FeaturelocPeer::NUM_HYDRATE_COLUMNS;


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = FeaturelocPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = FeaturelocPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = FeaturelocPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                FeaturelocPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

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
        return Propel::getDatabaseMap(FeaturelocPeer::DATABASE_NAME)->getTable(FeaturelocPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseFeaturelocPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseFeaturelocPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new FeaturelocTableMap());
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
        return FeaturelocPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Featureloc or Criteria object.
     *
     * @param      mixed $values Criteria or Featureloc object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Featureloc object
        }

        if ($criteria->containsKey(FeaturelocPeer::FEATURELOC_ID) && $criteria->keyContainsValue(FeaturelocPeer::FEATURELOC_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.FeaturelocPeer::FEATURELOC_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Featureloc or Criteria object.
     *
     * @param      mixed $values Criteria or Featureloc object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(FeaturelocPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(FeaturelocPeer::FEATURELOC_ID);
            $value = $criteria->remove(FeaturelocPeer::FEATURELOC_ID);
            if ($value) {
                $selectCriteria->add(FeaturelocPeer::FEATURELOC_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(FeaturelocPeer::TABLE_NAME);
            }

        } else { // $values is Featureloc object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the featureloc table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(FeaturelocPeer::TABLE_NAME, $con, FeaturelocPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            FeaturelocPeer::clearInstancePool();
            FeaturelocPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Featureloc or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Featureloc object or primary key or array of primary keys
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
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            FeaturelocPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Featureloc) { // it's a model object
            // invalidate the cache for this single object
            FeaturelocPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(FeaturelocPeer::DATABASE_NAME);
            $criteria->add(FeaturelocPeer::FEATURELOC_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                FeaturelocPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(FeaturelocPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            FeaturelocPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Featureloc object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Featureloc $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(FeaturelocPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(FeaturelocPeer::TABLE_NAME);

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

        return BasePeer::doValidate(FeaturelocPeer::DATABASE_NAME, FeaturelocPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Featureloc
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = FeaturelocPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(FeaturelocPeer::DATABASE_NAME);
        $criteria->add(FeaturelocPeer::FEATURELOC_ID, $pk);

        $v = FeaturelocPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Featureloc[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(FeaturelocPeer::DATABASE_NAME);
            $criteria->add(FeaturelocPeer::FEATURELOC_ID, $pks, Criteria::IN);
            $objs = FeaturelocPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseFeaturelocPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseFeaturelocPeer::buildTableMap();

