<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AcquisitionPeer;
use cli_db\propel\AnalysisPeer;
use cli_db\propel\ContactPeer;
use cli_db\propel\ProtocolPeer;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationPeer;
use cli_db\propel\map\QuantificationTableMap;

/**
 * Base static class for performing query and update operations on the 'quantification' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseQuantificationPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'quantification';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Quantification';

    /** the related TableMap class for this table */
    const TM_CLASS = 'QuantificationTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 8;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 8;

    /** the column name for the quantification_id field */
    const QUANTIFICATION_ID = 'quantification.quantification_id';

    /** the column name for the acquisition_id field */
    const ACQUISITION_ID = 'quantification.acquisition_id';

    /** the column name for the operator_id field */
    const OPERATOR_ID = 'quantification.operator_id';

    /** the column name for the protocol_id field */
    const PROTOCOL_ID = 'quantification.protocol_id';

    /** the column name for the analysis_id field */
    const ANALYSIS_ID = 'quantification.analysis_id';

    /** the column name for the quantificationdate field */
    const QUANTIFICATIONDATE = 'quantification.quantificationdate';

    /** the column name for the name field */
    const NAME = 'quantification.name';

    /** the column name for the uri field */
    const URI = 'quantification.uri';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Quantification objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Quantification[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. QuantificationPeer::$fieldNames[QuantificationPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('QuantificationId', 'AcquisitionId', 'OperatorId', 'ProtocolId', 'AnalysisId', 'Quantificationdate', 'Name', 'Uri', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('quantificationId', 'acquisitionId', 'operatorId', 'protocolId', 'analysisId', 'quantificationdate', 'name', 'uri', ),
        BasePeer::TYPE_COLNAME => array (QuantificationPeer::QUANTIFICATION_ID, QuantificationPeer::ACQUISITION_ID, QuantificationPeer::OPERATOR_ID, QuantificationPeer::PROTOCOL_ID, QuantificationPeer::ANALYSIS_ID, QuantificationPeer::QUANTIFICATIONDATE, QuantificationPeer::NAME, QuantificationPeer::URI, ),
        BasePeer::TYPE_RAW_COLNAME => array ('QUANTIFICATION_ID', 'ACQUISITION_ID', 'OPERATOR_ID', 'PROTOCOL_ID', 'ANALYSIS_ID', 'QUANTIFICATIONDATE', 'NAME', 'URI', ),
        BasePeer::TYPE_FIELDNAME => array ('quantification_id', 'acquisition_id', 'operator_id', 'protocol_id', 'analysis_id', 'quantificationdate', 'name', 'uri', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. QuantificationPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('QuantificationId' => 0, 'AcquisitionId' => 1, 'OperatorId' => 2, 'ProtocolId' => 3, 'AnalysisId' => 4, 'Quantificationdate' => 5, 'Name' => 6, 'Uri' => 7, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('quantificationId' => 0, 'acquisitionId' => 1, 'operatorId' => 2, 'protocolId' => 3, 'analysisId' => 4, 'quantificationdate' => 5, 'name' => 6, 'uri' => 7, ),
        BasePeer::TYPE_COLNAME => array (QuantificationPeer::QUANTIFICATION_ID => 0, QuantificationPeer::ACQUISITION_ID => 1, QuantificationPeer::OPERATOR_ID => 2, QuantificationPeer::PROTOCOL_ID => 3, QuantificationPeer::ANALYSIS_ID => 4, QuantificationPeer::QUANTIFICATIONDATE => 5, QuantificationPeer::NAME => 6, QuantificationPeer::URI => 7, ),
        BasePeer::TYPE_RAW_COLNAME => array ('QUANTIFICATION_ID' => 0, 'ACQUISITION_ID' => 1, 'OPERATOR_ID' => 2, 'PROTOCOL_ID' => 3, 'ANALYSIS_ID' => 4, 'QUANTIFICATIONDATE' => 5, 'NAME' => 6, 'URI' => 7, ),
        BasePeer::TYPE_FIELDNAME => array ('quantification_id' => 0, 'acquisition_id' => 1, 'operator_id' => 2, 'protocol_id' => 3, 'analysis_id' => 4, 'quantificationdate' => 5, 'name' => 6, 'uri' => 7, ),
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
        $toNames = QuantificationPeer::getFieldNames($toType);
        $key = isset(QuantificationPeer::$fieldKeys[$fromType][$name]) ? QuantificationPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(QuantificationPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, QuantificationPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return QuantificationPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. QuantificationPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(QuantificationPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(QuantificationPeer::QUANTIFICATION_ID);
            $criteria->addSelectColumn(QuantificationPeer::ACQUISITION_ID);
            $criteria->addSelectColumn(QuantificationPeer::OPERATOR_ID);
            $criteria->addSelectColumn(QuantificationPeer::PROTOCOL_ID);
            $criteria->addSelectColumn(QuantificationPeer::ANALYSIS_ID);
            $criteria->addSelectColumn(QuantificationPeer::QUANTIFICATIONDATE);
            $criteria->addSelectColumn(QuantificationPeer::NAME);
            $criteria->addSelectColumn(QuantificationPeer::URI);
        } else {
            $criteria->addSelectColumn($alias . '.quantification_id');
            $criteria->addSelectColumn($alias . '.acquisition_id');
            $criteria->addSelectColumn($alias . '.operator_id');
            $criteria->addSelectColumn($alias . '.protocol_id');
            $criteria->addSelectColumn($alias . '.analysis_id');
            $criteria->addSelectColumn($alias . '.quantificationdate');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.uri');
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
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Quantification
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = QuantificationPeer::doSelect($critcopy, $con);
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
        return QuantificationPeer::populateObjects(QuantificationPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            QuantificationPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

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
     * @param      Quantification $obj A Quantification object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getQuantificationId();
            } // if key === null
            QuantificationPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Quantification object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Quantification) {
                $key = (string) $value->getQuantificationId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Quantification object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(QuantificationPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Quantification Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(QuantificationPeer::$instances[$key])) {
                return QuantificationPeer::$instances[$key];
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
        foreach (QuantificationPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        QuantificationPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to quantification
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
        $cls = QuantificationPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = QuantificationPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                QuantificationPeer::addInstanceToPool($obj, $key);
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
     * @return array (Quantification object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = QuantificationPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = QuantificationPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + QuantificationPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = QuantificationPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            QuantificationPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Acquisition table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAcquisition(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Contact table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinContact(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Protocol table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinProtocol(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Selects a collection of Quantification objects pre-filled with their Acquisition objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAcquisition(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol = QuantificationPeer::NUM_HYDRATE_COLUMNS;
        AcquisitionPeer::addSelectColumns($criteria);

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Quantification) to $obj2 (Acquisition)
                $obj2->addQuantification($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with their Analysis objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAnalysis(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol = QuantificationPeer::NUM_HYDRATE_COLUMNS;
        AnalysisPeer::addSelectColumns($criteria);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Quantification) to $obj2 (Analysis)
                $obj2->addQuantification($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with their Contact objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinContact(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol = QuantificationPeer::NUM_HYDRATE_COLUMNS;
        ContactPeer::addSelectColumns($criteria);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ContactPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ContactPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ContactPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Quantification) to $obj2 (Contact)
                $obj2->addQuantification($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with their Protocol objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinProtocol(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol = QuantificationPeer::NUM_HYDRATE_COLUMNS;
        ProtocolPeer::addSelectColumns($criteria);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = ProtocolPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = ProtocolPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = ProtocolPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    ProtocolPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Quantification) to $obj2 (Protocol)
                $obj2->addQuantification($obj1);

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
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Selects a collection of Quantification objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol2 = QuantificationPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        AnalysisPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AnalysisPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContactPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Acquisition rows

            $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Quantification) to the collection in $obj2 (Acquisition)
                $obj2->addQuantification($obj1);
            } // if joined row not null

            // Add objects for joined Analysis rows

            $key3 = AnalysisPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = AnalysisPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = AnalysisPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AnalysisPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Quantification) to the collection in $obj3 (Analysis)
                $obj3->addQuantification($obj1);
            } // if joined row not null

            // Add objects for joined Contact rows

            $key4 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = ContactPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = ContactPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContactPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Quantification) to the collection in $obj4 (Contact)
                $obj4->addQuantification($obj1);
            } // if joined row not null

            // Add objects for joined Protocol rows

            $key5 = ProtocolPeer::getPrimaryKeyHashFromRow($row, $startcol5);
            if ($key5 !== null) {
                $obj5 = ProtocolPeer::getInstanceFromPool($key5);
                if (!$obj5) {

                    $cls = ProtocolPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    ProtocolPeer::addInstanceToPool($obj5, $key5);
                } // if obj5 loaded

                // Add the $obj1 (Quantification) to the collection in $obj5 (Protocol)
                $obj5->addQuantification($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Acquisition table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAcquisition(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Analysis table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptAnalysis(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Contact table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptContact(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Protocol table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptProtocol(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            QuantificationPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

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
     * Selects a collection of Quantification objects pre-filled with all related objects except Acquisition.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAcquisition(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol2 = QuantificationPeer::NUM_HYDRATE_COLUMNS;

        AnalysisPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AnalysisPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
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
                } // if $obj2 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj2 (Analysis)
                $obj2->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Contact rows

                $key3 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ContactPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ContactPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ContactPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj3 (Contact)
                $obj3->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Protocol rows

                $key4 = ProtocolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProtocolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProtocolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProtocolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj4 (Protocol)
                $obj4->addQuantification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with all related objects except Analysis.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptAnalysis(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol2 = QuantificationPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Acquisition rows

                $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj2 (Acquisition)
                $obj2->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Contact rows

                $key3 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = ContactPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = ContactPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ContactPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj3 (Contact)
                $obj3->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Protocol rows

                $key4 = ProtocolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProtocolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProtocolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProtocolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj4 (Protocol)
                $obj4->addQuantification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with all related objects except Contact.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptContact(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol2 = QuantificationPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        AnalysisPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AnalysisPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Acquisition rows

                $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj2 (Acquisition)
                $obj2->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Analysis rows

                $key3 = AnalysisPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AnalysisPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AnalysisPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AnalysisPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj3 (Analysis)
                $obj3->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Protocol rows

                $key4 = ProtocolPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ProtocolPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ProtocolPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ProtocolPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj4 (Protocol)
                $obj4->addQuantification($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Quantification objects pre-filled with all related objects except Protocol.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Quantification objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptProtocol(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(QuantificationPeer::DATABASE_NAME);
        }

        QuantificationPeer::addSelectColumns($criteria);
        $startcol2 = QuantificationPeer::NUM_HYDRATE_COLUMNS;

        AcquisitionPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + AcquisitionPeer::NUM_HYDRATE_COLUMNS;

        AnalysisPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + AnalysisPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ContactPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(QuantificationPeer::ACQUISITION_ID, AcquisitionPeer::ACQUISITION_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::ANALYSIS_ID, AnalysisPeer::ANALYSIS_ID, $join_behavior);

        $criteria->addJoin(QuantificationPeer::OPERATOR_ID, ContactPeer::CONTACT_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = QuantificationPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = QuantificationPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = QuantificationPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                QuantificationPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Acquisition rows

                $key2 = AcquisitionPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = AcquisitionPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = AcquisitionPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    AcquisitionPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj2 (Acquisition)
                $obj2->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Analysis rows

                $key3 = AnalysisPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = AnalysisPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = AnalysisPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    AnalysisPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj3 (Analysis)
                $obj3->addQuantification($obj1);

            } // if joined row is not null

                // Add objects for joined Contact rows

                $key4 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = ContactPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = ContactPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    ContactPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Quantification) to the collection in $obj4 (Contact)
                $obj4->addQuantification($obj1);

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
        return Propel::getDatabaseMap(QuantificationPeer::DATABASE_NAME)->getTable(QuantificationPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseQuantificationPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseQuantificationPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new QuantificationTableMap());
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
        return QuantificationPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Quantification or Criteria object.
     *
     * @param      mixed $values Criteria or Quantification object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Quantification object
        }

        if ($criteria->containsKey(QuantificationPeer::QUANTIFICATION_ID) && $criteria->keyContainsValue(QuantificationPeer::QUANTIFICATION_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.QuantificationPeer::QUANTIFICATION_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Quantification or Criteria object.
     *
     * @param      mixed $values Criteria or Quantification object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(QuantificationPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(QuantificationPeer::QUANTIFICATION_ID);
            $value = $criteria->remove(QuantificationPeer::QUANTIFICATION_ID);
            if ($value) {
                $selectCriteria->add(QuantificationPeer::QUANTIFICATION_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(QuantificationPeer::TABLE_NAME);
            }

        } else { // $values is Quantification object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the quantification table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(QuantificationPeer::TABLE_NAME, $con, QuantificationPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            QuantificationPeer::clearInstancePool();
            QuantificationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Quantification or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Quantification object or primary key or array of primary keys
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
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            QuantificationPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Quantification) { // it's a model object
            // invalidate the cache for this single object
            QuantificationPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(QuantificationPeer::DATABASE_NAME);
            $criteria->add(QuantificationPeer::QUANTIFICATION_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                QuantificationPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(QuantificationPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            QuantificationPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Quantification object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Quantification $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(QuantificationPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(QuantificationPeer::TABLE_NAME);

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

        return BasePeer::doValidate(QuantificationPeer::DATABASE_NAME, QuantificationPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Quantification
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = QuantificationPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(QuantificationPeer::DATABASE_NAME);
        $criteria->add(QuantificationPeer::QUANTIFICATION_ID, $pk);

        $v = QuantificationPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Quantification[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(QuantificationPeer::DATABASE_NAME);
            $criteria->add(QuantificationPeer::QUANTIFICATION_ID, $pks, Criteria::IN);
            $objs = QuantificationPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseQuantificationPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseQuantificationPeer::buildTableMap();

