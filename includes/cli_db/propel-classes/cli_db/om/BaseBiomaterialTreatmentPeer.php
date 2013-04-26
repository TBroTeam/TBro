<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\BiomaterialPeer;
use cli_db\propel\BiomaterialTreatment;
use cli_db\propel\BiomaterialTreatmentPeer;
use cli_db\propel\CvtermPeer;
use cli_db\propel\TreatmentPeer;
use cli_db\propel\map\BiomaterialTreatmentTableMap;

/**
 * Base static class for performing query and update operations on the 'biomaterial_treatment' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseBiomaterialTreatmentPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'biomaterial_treatment';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\BiomaterialTreatment';

    /** the related TableMap class for this table */
    const TM_CLASS = 'BiomaterialTreatmentTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 6;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 6;

    /** the column name for the biomaterial_treatment_id field */
    const BIOMATERIAL_TREATMENT_ID = 'biomaterial_treatment.biomaterial_treatment_id';

    /** the column name for the biomaterial_id field */
    const BIOMATERIAL_ID = 'biomaterial_treatment.biomaterial_id';

    /** the column name for the treatment_id field */
    const TREATMENT_ID = 'biomaterial_treatment.treatment_id';

    /** the column name for the unittype_id field */
    const UNITTYPE_ID = 'biomaterial_treatment.unittype_id';

    /** the column name for the value field */
    const VALUE = 'biomaterial_treatment.value';

    /** the column name for the rank field */
    const RANK = 'biomaterial_treatment.rank';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of BiomaterialTreatment objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array BiomaterialTreatment[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialTreatmentPeer::$fieldNames[BiomaterialTreatmentPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialTreatmentId', 'BiomaterialId', 'TreatmentId', 'UnittypeId', 'Value', 'Rank', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialTreatmentId', 'biomaterialId', 'treatmentId', 'unittypeId', 'value', 'rank', ),
        BasePeer::TYPE_COLNAME => array (BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialTreatmentPeer::TREATMENT_ID, BiomaterialTreatmentPeer::UNITTYPE_ID, BiomaterialTreatmentPeer::VALUE, BiomaterialTreatmentPeer::RANK, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_TREATMENT_ID', 'BIOMATERIAL_ID', 'TREATMENT_ID', 'UNITTYPE_ID', 'VALUE', 'RANK', ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_treatment_id', 'biomaterial_id', 'treatment_id', 'unittype_id', 'value', 'rank', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialTreatmentPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialTreatmentId' => 0, 'BiomaterialId' => 1, 'TreatmentId' => 2, 'UnittypeId' => 3, 'Value' => 4, 'Rank' => 5, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialTreatmentId' => 0, 'biomaterialId' => 1, 'treatmentId' => 2, 'unittypeId' => 3, 'value' => 4, 'rank' => 5, ),
        BasePeer::TYPE_COLNAME => array (BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID => 0, BiomaterialTreatmentPeer::BIOMATERIAL_ID => 1, BiomaterialTreatmentPeer::TREATMENT_ID => 2, BiomaterialTreatmentPeer::UNITTYPE_ID => 3, BiomaterialTreatmentPeer::VALUE => 4, BiomaterialTreatmentPeer::RANK => 5, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_TREATMENT_ID' => 0, 'BIOMATERIAL_ID' => 1, 'TREATMENT_ID' => 2, 'UNITTYPE_ID' => 3, 'VALUE' => 4, 'RANK' => 5, ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_treatment_id' => 0, 'biomaterial_id' => 1, 'treatment_id' => 2, 'unittype_id' => 3, 'value' => 4, 'rank' => 5, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
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
        $toNames = BiomaterialTreatmentPeer::getFieldNames($toType);
        $key = isset(BiomaterialTreatmentPeer::$fieldKeys[$fromType][$name]) ? BiomaterialTreatmentPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BiomaterialTreatmentPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BiomaterialTreatmentPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BiomaterialTreatmentPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BiomaterialTreatmentPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BiomaterialTreatmentPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID);
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::BIOMATERIAL_ID);
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::TREATMENT_ID);
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::UNITTYPE_ID);
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::VALUE);
            $criteria->addSelectColumn(BiomaterialTreatmentPeer::RANK);
        } else {
            $criteria->addSelectColumn($alias . '.biomaterial_treatment_id');
            $criteria->addSelectColumn($alias . '.biomaterial_id');
            $criteria->addSelectColumn($alias . '.treatment_id');
            $criteria->addSelectColumn($alias . '.unittype_id');
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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BiomaterialTreatment
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BiomaterialTreatmentPeer::doSelect($critcopy, $con);
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
        return BiomaterialTreatmentPeer::populateObjects(BiomaterialTreatmentPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

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
     * @param      BiomaterialTreatment $obj A BiomaterialTreatment object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getBiomaterialTreatmentId();
            } // if key === null
            BiomaterialTreatmentPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A BiomaterialTreatment object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof BiomaterialTreatment) {
                $key = (string) $value->getBiomaterialTreatmentId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or BiomaterialTreatment object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BiomaterialTreatmentPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   BiomaterialTreatment Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BiomaterialTreatmentPeer::$instances[$key])) {
                return BiomaterialTreatmentPeer::$instances[$key];
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
        foreach (BiomaterialTreatmentPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        BiomaterialTreatmentPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to biomaterial_treatment
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
        $cls = BiomaterialTreatmentPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BiomaterialTreatmentPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BiomaterialTreatmentPeer::addInstanceToPool($obj, $key);
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
     * @return array (BiomaterialTreatment object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BiomaterialTreatmentPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BiomaterialTreatmentPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BiomaterialTreatmentPeer::addInstanceToPool($obj, $key);
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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Treatment table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinTreatment(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Selects a collection of BiomaterialTreatment objects pre-filled with their Biomaterial objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinBiomaterial(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;
        BiomaterialPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (BiomaterialTreatment) to $obj2 (Biomaterial)
                $obj2->addBiomaterialTreatment($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialTreatment objects pre-filled with their Treatment objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinTreatment(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;
        TreatmentPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = TreatmentPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = TreatmentPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = TreatmentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    TreatmentPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (BiomaterialTreatment) to $obj2 (Treatment)
                $obj2->addBiomaterialTreatment($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialTreatment objects pre-filled with their Cvterm objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCvterm(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;
        CvtermPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (BiomaterialTreatment) to $obj2 (Cvterm)
                $obj2->addBiomaterialTreatment($obj1);

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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Selects a collection of BiomaterialTreatment objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        TreatmentPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TreatmentPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj2 (Biomaterial)
                $obj2->addBiomaterialTreatment($obj1);
            } // if joined row not null

            // Add objects for joined Treatment rows

            $key3 = TreatmentPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = TreatmentPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = TreatmentPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TreatmentPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj3 (Treatment)
                $obj3->addBiomaterialTreatment($obj1);
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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj4 (Cvterm)
                $obj4->addBiomaterialTreatment($obj1);
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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Treatment table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptTreatment(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialTreatmentPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

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
     * Selects a collection of BiomaterialTreatment objects pre-filled with all related objects except Biomaterial.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
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
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;

        TreatmentPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + TreatmentPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Treatment rows

                $key2 = TreatmentPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = TreatmentPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = TreatmentPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    TreatmentPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj2 (Treatment)
                $obj2->addBiomaterialTreatment($obj1);

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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj3 (Cvterm)
                $obj3->addBiomaterialTreatment($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialTreatment objects pre-filled with all related objects except Treatment.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptTreatment(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::UNITTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj2 (Biomaterial)
                $obj2->addBiomaterialTreatment($obj1);

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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj3 (Cvterm)
                $obj3->addBiomaterialTreatment($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of BiomaterialTreatment objects pre-filled with all related objects except Cvterm.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of BiomaterialTreatment objects.
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
            $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);
        }

        BiomaterialTreatmentPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialTreatmentPeer::NUM_HYDRATE_COLUMNS;

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        TreatmentPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + TreatmentPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialTreatmentPeer::BIOMATERIAL_ID, BiomaterialPeer::BIOMATERIAL_ID, $join_behavior);

        $criteria->addJoin(BiomaterialTreatmentPeer::TREATMENT_ID, TreatmentPeer::TREATMENT_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialTreatmentPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialTreatmentPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialTreatmentPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialTreatmentPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj2 (Biomaterial)
                $obj2->addBiomaterialTreatment($obj1);

            } // if joined row is not null

                // Add objects for joined Treatment rows

                $key3 = TreatmentPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = TreatmentPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = TreatmentPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    TreatmentPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (BiomaterialTreatment) to the collection in $obj3 (Treatment)
                $obj3->addBiomaterialTreatment($obj1);

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
        return Propel::getDatabaseMap(BiomaterialTreatmentPeer::DATABASE_NAME)->getTable(BiomaterialTreatmentPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBiomaterialTreatmentPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBiomaterialTreatmentPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new BiomaterialTreatmentTableMap());
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
        return BiomaterialTreatmentPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a BiomaterialTreatment or Criteria object.
     *
     * @param      mixed $values Criteria or BiomaterialTreatment object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from BiomaterialTreatment object
        }

        if ($criteria->containsKey(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID) && $criteria->keyContainsValue(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a BiomaterialTreatment or Criteria object.
     *
     * @param      mixed $values Criteria or BiomaterialTreatment object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BiomaterialTreatmentPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID);
            $value = $criteria->remove(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID);
            if ($value) {
                $selectCriteria->add(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BiomaterialTreatmentPeer::TABLE_NAME);
            }

        } else { // $values is BiomaterialTreatment object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the biomaterial_treatment table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BiomaterialTreatmentPeer::TABLE_NAME, $con, BiomaterialTreatmentPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BiomaterialTreatmentPeer::clearInstancePool();
            BiomaterialTreatmentPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a BiomaterialTreatment or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or BiomaterialTreatment object or primary key or array of primary keys
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
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BiomaterialTreatmentPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof BiomaterialTreatment) { // it's a model object
            // invalidate the cache for this single object
            BiomaterialTreatmentPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BiomaterialTreatmentPeer::DATABASE_NAME);
            $criteria->add(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BiomaterialTreatmentPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialTreatmentPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BiomaterialTreatmentPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given BiomaterialTreatment object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      BiomaterialTreatment $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BiomaterialTreatmentPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BiomaterialTreatmentPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BiomaterialTreatmentPeer::DATABASE_NAME, BiomaterialTreatmentPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return BiomaterialTreatment
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BiomaterialTreatmentPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BiomaterialTreatmentPeer::DATABASE_NAME);
        $criteria->add(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $pk);

        $v = BiomaterialTreatmentPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return BiomaterialTreatment[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BiomaterialTreatmentPeer::DATABASE_NAME);
            $criteria->add(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $pks, Criteria::IN);
            $objs = BiomaterialTreatmentPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBiomaterialTreatmentPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBiomaterialTreatmentPeer::buildTableMap();

