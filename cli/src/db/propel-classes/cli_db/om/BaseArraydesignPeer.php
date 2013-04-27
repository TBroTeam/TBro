<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\Arraydesign;
use cli_db\propel\ArraydesignPeer;
use cli_db\propel\ArraydesignpropPeer;
use cli_db\propel\AssayPeer;
use cli_db\propel\ContactPeer;
use cli_db\propel\CvtermPeer;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\ElementPeer;
use cli_db\propel\ProtocolPeer;
use cli_db\propel\map\ArraydesignTableMap;

/**
 * Base static class for performing query and update operations on the 'arraydesign' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseArraydesignPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'arraydesign';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Arraydesign';

    /** the related TableMap class for this table */
    const TM_CLASS = 'ArraydesignTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 18;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 18;

    /** the column name for the arraydesign_id field */
    const ARRAYDESIGN_ID = 'arraydesign.arraydesign_id';

    /** the column name for the manufacturer_id field */
    const MANUFACTURER_ID = 'arraydesign.manufacturer_id';

    /** the column name for the platformtype_id field */
    const PLATFORMTYPE_ID = 'arraydesign.platformtype_id';

    /** the column name for the substratetype_id field */
    const SUBSTRATETYPE_ID = 'arraydesign.substratetype_id';

    /** the column name for the protocol_id field */
    const PROTOCOL_ID = 'arraydesign.protocol_id';

    /** the column name for the dbxref_id field */
    const DBXREF_ID = 'arraydesign.dbxref_id';

    /** the column name for the name field */
    const NAME = 'arraydesign.name';

    /** the column name for the version field */
    const VERSION = 'arraydesign.version';

    /** the column name for the description field */
    const DESCRIPTION = 'arraydesign.description';

    /** the column name for the array_dimensions field */
    const ARRAY_DIMENSIONS = 'arraydesign.array_dimensions';

    /** the column name for the element_dimensions field */
    const ELEMENT_DIMENSIONS = 'arraydesign.element_dimensions';

    /** the column name for the num_of_elements field */
    const NUM_OF_ELEMENTS = 'arraydesign.num_of_elements';

    /** the column name for the num_array_columns field */
    const NUM_ARRAY_COLUMNS = 'arraydesign.num_array_columns';

    /** the column name for the num_array_rows field */
    const NUM_ARRAY_ROWS = 'arraydesign.num_array_rows';

    /** the column name for the num_grid_columns field */
    const NUM_GRID_COLUMNS = 'arraydesign.num_grid_columns';

    /** the column name for the num_grid_rows field */
    const NUM_GRID_ROWS = 'arraydesign.num_grid_rows';

    /** the column name for the num_sub_columns field */
    const NUM_SUB_COLUMNS = 'arraydesign.num_sub_columns';

    /** the column name for the num_sub_rows field */
    const NUM_SUB_ROWS = 'arraydesign.num_sub_rows';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Arraydesign objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Arraydesign[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. ArraydesignPeer::$fieldNames[ArraydesignPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('ArraydesignId', 'ManufacturerId', 'PlatformtypeId', 'SubstratetypeId', 'ProtocolId', 'DbxrefId', 'Name', 'Version', 'Description', 'ArrayDimensions', 'ElementDimensions', 'NumOfElements', 'NumArrayColumns', 'NumArrayRows', 'NumGridColumns', 'NumGridRows', 'NumSubColumns', 'NumSubRows', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('arraydesignId', 'manufacturerId', 'platformtypeId', 'substratetypeId', 'protocolId', 'dbxrefId', 'name', 'version', 'description', 'arrayDimensions', 'elementDimensions', 'numOfElements', 'numArrayColumns', 'numArrayRows', 'numGridColumns', 'numGridRows', 'numSubColumns', 'numSubRows', ),
        BasePeer::TYPE_COLNAME => array (ArraydesignPeer::ARRAYDESIGN_ID, ArraydesignPeer::MANUFACTURER_ID, ArraydesignPeer::PLATFORMTYPE_ID, ArraydesignPeer::SUBSTRATETYPE_ID, ArraydesignPeer::PROTOCOL_ID, ArraydesignPeer::DBXREF_ID, ArraydesignPeer::NAME, ArraydesignPeer::VERSION, ArraydesignPeer::DESCRIPTION, ArraydesignPeer::ARRAY_DIMENSIONS, ArraydesignPeer::ELEMENT_DIMENSIONS, ArraydesignPeer::NUM_OF_ELEMENTS, ArraydesignPeer::NUM_ARRAY_COLUMNS, ArraydesignPeer::NUM_ARRAY_ROWS, ArraydesignPeer::NUM_GRID_COLUMNS, ArraydesignPeer::NUM_GRID_ROWS, ArraydesignPeer::NUM_SUB_COLUMNS, ArraydesignPeer::NUM_SUB_ROWS, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ARRAYDESIGN_ID', 'MANUFACTURER_ID', 'PLATFORMTYPE_ID', 'SUBSTRATETYPE_ID', 'PROTOCOL_ID', 'DBXREF_ID', 'NAME', 'VERSION', 'DESCRIPTION', 'ARRAY_DIMENSIONS', 'ELEMENT_DIMENSIONS', 'NUM_OF_ELEMENTS', 'NUM_ARRAY_COLUMNS', 'NUM_ARRAY_ROWS', 'NUM_GRID_COLUMNS', 'NUM_GRID_ROWS', 'NUM_SUB_COLUMNS', 'NUM_SUB_ROWS', ),
        BasePeer::TYPE_FIELDNAME => array ('arraydesign_id', 'manufacturer_id', 'platformtype_id', 'substratetype_id', 'protocol_id', 'dbxref_id', 'name', 'version', 'description', 'array_dimensions', 'element_dimensions', 'num_of_elements', 'num_array_columns', 'num_array_rows', 'num_grid_columns', 'num_grid_rows', 'num_sub_columns', 'num_sub_rows', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. ArraydesignPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('ArraydesignId' => 0, 'ManufacturerId' => 1, 'PlatformtypeId' => 2, 'SubstratetypeId' => 3, 'ProtocolId' => 4, 'DbxrefId' => 5, 'Name' => 6, 'Version' => 7, 'Description' => 8, 'ArrayDimensions' => 9, 'ElementDimensions' => 10, 'NumOfElements' => 11, 'NumArrayColumns' => 12, 'NumArrayRows' => 13, 'NumGridColumns' => 14, 'NumGridRows' => 15, 'NumSubColumns' => 16, 'NumSubRows' => 17, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('arraydesignId' => 0, 'manufacturerId' => 1, 'platformtypeId' => 2, 'substratetypeId' => 3, 'protocolId' => 4, 'dbxrefId' => 5, 'name' => 6, 'version' => 7, 'description' => 8, 'arrayDimensions' => 9, 'elementDimensions' => 10, 'numOfElements' => 11, 'numArrayColumns' => 12, 'numArrayRows' => 13, 'numGridColumns' => 14, 'numGridRows' => 15, 'numSubColumns' => 16, 'numSubRows' => 17, ),
        BasePeer::TYPE_COLNAME => array (ArraydesignPeer::ARRAYDESIGN_ID => 0, ArraydesignPeer::MANUFACTURER_ID => 1, ArraydesignPeer::PLATFORMTYPE_ID => 2, ArraydesignPeer::SUBSTRATETYPE_ID => 3, ArraydesignPeer::PROTOCOL_ID => 4, ArraydesignPeer::DBXREF_ID => 5, ArraydesignPeer::NAME => 6, ArraydesignPeer::VERSION => 7, ArraydesignPeer::DESCRIPTION => 8, ArraydesignPeer::ARRAY_DIMENSIONS => 9, ArraydesignPeer::ELEMENT_DIMENSIONS => 10, ArraydesignPeer::NUM_OF_ELEMENTS => 11, ArraydesignPeer::NUM_ARRAY_COLUMNS => 12, ArraydesignPeer::NUM_ARRAY_ROWS => 13, ArraydesignPeer::NUM_GRID_COLUMNS => 14, ArraydesignPeer::NUM_GRID_ROWS => 15, ArraydesignPeer::NUM_SUB_COLUMNS => 16, ArraydesignPeer::NUM_SUB_ROWS => 17, ),
        BasePeer::TYPE_RAW_COLNAME => array ('ARRAYDESIGN_ID' => 0, 'MANUFACTURER_ID' => 1, 'PLATFORMTYPE_ID' => 2, 'SUBSTRATETYPE_ID' => 3, 'PROTOCOL_ID' => 4, 'DBXREF_ID' => 5, 'NAME' => 6, 'VERSION' => 7, 'DESCRIPTION' => 8, 'ARRAY_DIMENSIONS' => 9, 'ELEMENT_DIMENSIONS' => 10, 'NUM_OF_ELEMENTS' => 11, 'NUM_ARRAY_COLUMNS' => 12, 'NUM_ARRAY_ROWS' => 13, 'NUM_GRID_COLUMNS' => 14, 'NUM_GRID_ROWS' => 15, 'NUM_SUB_COLUMNS' => 16, 'NUM_SUB_ROWS' => 17, ),
        BasePeer::TYPE_FIELDNAME => array ('arraydesign_id' => 0, 'manufacturer_id' => 1, 'platformtype_id' => 2, 'substratetype_id' => 3, 'protocol_id' => 4, 'dbxref_id' => 5, 'name' => 6, 'version' => 7, 'description' => 8, 'array_dimensions' => 9, 'element_dimensions' => 10, 'num_of_elements' => 11, 'num_array_columns' => 12, 'num_array_rows' => 13, 'num_grid_columns' => 14, 'num_grid_rows' => 15, 'num_sub_columns' => 16, 'num_sub_rows' => 17, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, 7, 8, 9, 10, 11, 12, 13, 14, 15, 16, 17, )
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
        $toNames = ArraydesignPeer::getFieldNames($toType);
        $key = isset(ArraydesignPeer::$fieldKeys[$fromType][$name]) ? ArraydesignPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(ArraydesignPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, ArraydesignPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return ArraydesignPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. ArraydesignPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(ArraydesignPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(ArraydesignPeer::ARRAYDESIGN_ID);
            $criteria->addSelectColumn(ArraydesignPeer::MANUFACTURER_ID);
            $criteria->addSelectColumn(ArraydesignPeer::PLATFORMTYPE_ID);
            $criteria->addSelectColumn(ArraydesignPeer::SUBSTRATETYPE_ID);
            $criteria->addSelectColumn(ArraydesignPeer::PROTOCOL_ID);
            $criteria->addSelectColumn(ArraydesignPeer::DBXREF_ID);
            $criteria->addSelectColumn(ArraydesignPeer::NAME);
            $criteria->addSelectColumn(ArraydesignPeer::VERSION);
            $criteria->addSelectColumn(ArraydesignPeer::DESCRIPTION);
            $criteria->addSelectColumn(ArraydesignPeer::ARRAY_DIMENSIONS);
            $criteria->addSelectColumn(ArraydesignPeer::ELEMENT_DIMENSIONS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_OF_ELEMENTS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_ARRAY_COLUMNS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_ARRAY_ROWS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_GRID_COLUMNS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_GRID_ROWS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_SUB_COLUMNS);
            $criteria->addSelectColumn(ArraydesignPeer::NUM_SUB_ROWS);
        } else {
            $criteria->addSelectColumn($alias . '.arraydesign_id');
            $criteria->addSelectColumn($alias . '.manufacturer_id');
            $criteria->addSelectColumn($alias . '.platformtype_id');
            $criteria->addSelectColumn($alias . '.substratetype_id');
            $criteria->addSelectColumn($alias . '.protocol_id');
            $criteria->addSelectColumn($alias . '.dbxref_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.version');
            $criteria->addSelectColumn($alias . '.description');
            $criteria->addSelectColumn($alias . '.array_dimensions');
            $criteria->addSelectColumn($alias . '.element_dimensions');
            $criteria->addSelectColumn($alias . '.num_of_elements');
            $criteria->addSelectColumn($alias . '.num_array_columns');
            $criteria->addSelectColumn($alias . '.num_array_rows');
            $criteria->addSelectColumn($alias . '.num_grid_columns');
            $criteria->addSelectColumn($alias . '.num_grid_rows');
            $criteria->addSelectColumn($alias . '.num_sub_columns');
            $criteria->addSelectColumn($alias . '.num_sub_rows');
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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Arraydesign
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = ArraydesignPeer::doSelect($critcopy, $con);
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
        return ArraydesignPeer::populateObjects(ArraydesignPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            ArraydesignPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

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
     * @param      Arraydesign $obj A Arraydesign object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getArraydesignId();
            } // if key === null
            ArraydesignPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Arraydesign object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Arraydesign) {
                $key = (string) $value->getArraydesignId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Arraydesign object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(ArraydesignPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Arraydesign Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(ArraydesignPeer::$instances[$key])) {
                return ArraydesignPeer::$instances[$key];
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
        foreach (ArraydesignPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        ArraydesignPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to arraydesign
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in ArraydesignpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArraydesignpropPeer::clearInstancePool();
        // Invalidate objects in AssayPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AssayPeer::clearInstancePool();
        // Invalidate objects in ElementPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ElementPeer::clearInstancePool();
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
        $cls = ArraydesignPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = ArraydesignPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                ArraydesignPeer::addInstanceToPool($obj, $key);
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
     * @return array (Arraydesign object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = ArraydesignPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = ArraydesignPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = ArraydesignPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            ArraydesignPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CvtermRelatedByPlatformtypeId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCvtermRelatedByPlatformtypeId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CvtermRelatedBySubstratetypeId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCvtermRelatedBySubstratetypeId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Selects a collection of Arraydesign objects pre-filled with their Dbxref objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinDbxref(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol = ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        DbxrefPeer::addSelectColumns($criteria);

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with their Contact objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinContact(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol = ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        ContactPeer::addSelectColumns($criteria);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to $obj2 (Contact)
                $obj2->addArraydesign($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with their Cvterm objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCvtermRelatedByPlatformtypeId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol = ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        CvtermPeer::addSelectColumns($criteria);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to $obj2 (Cvterm)
                $obj2->addArraydesignRelatedByPlatformtypeId($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with their Protocol objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinProtocol(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol = ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        ProtocolPeer::addSelectColumns($criteria);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to $obj2 (Protocol)
                $obj2->addArraydesign($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with their Cvterm objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCvtermRelatedBySubstratetypeId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol = ArraydesignPeer::NUM_HYDRATE_COLUMNS;
        CvtermPeer::addSelectColumns($criteria);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to $obj2 (Cvterm)
                $obj2->addArraydesignRelatedBySubstratetypeId($obj1);

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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Selects a collection of Arraydesign objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol7 = $startcol6 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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
                } // if obj2 loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);
            } // if joined row not null

            // Add objects for joined Contact rows

            $key3 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol3);
            if ($key3 !== null) {
                $obj3 = ContactPeer::getInstanceFromPool($key3);
                if (!$obj3) {

                    $cls = ContactPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    ContactPeer::addInstanceToPool($obj3, $key3);
                } // if obj3 loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Contact)
                $obj3->addArraydesign($obj1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Cvterm)
                $obj4->addArraydesignRelatedByPlatformtypeId($obj1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj5 (Protocol)
                $obj5->addArraydesign($obj1);
            } // if joined row not null

            // Add objects for joined Cvterm rows

            $key6 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol6);
            if ($key6 !== null) {
                $obj6 = CvtermPeer::getInstanceFromPool($key6);
                if (!$obj6) {

                    $cls = CvtermPeer::getOMClass();

                    $obj6 = new $cls();
                    $obj6->hydrate($row, $startcol6);
                    CvtermPeer::addInstanceToPool($obj6, $key6);
                } // if obj6 loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj6 (Cvterm)
                $obj6->addArraydesignRelatedBySubstratetypeId($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CvtermRelatedByPlatformtypeId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCvtermRelatedByPlatformtypeId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related CvtermRelatedBySubstratetypeId table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCvtermRelatedBySubstratetypeId(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            ArraydesignPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

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
     * Selects a collection of Arraydesign objects pre-filled with all related objects except Dbxref.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
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
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContactPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Contact rows

                $key2 = ContactPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = ContactPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = ContactPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    ContactPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Contact)
                $obj2->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Cvterm)
                $obj3->addArraydesignRelatedByPlatformtypeId($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Protocol)
                $obj4->addArraydesign($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key5 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = CvtermPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = CvtermPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    CvtermPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj5 (Cvterm)
                $obj5->addArraydesignRelatedBySubstratetypeId($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with all related objects except Contact.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
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
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Cvterm)
                $obj3->addArraydesignRelatedByPlatformtypeId($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Protocol)
                $obj4->addArraydesign($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key5 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = CvtermPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = CvtermPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    CvtermPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj5 (Cvterm)
                $obj5->addArraydesignRelatedBySubstratetypeId($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with all related objects except CvtermRelatedByPlatformtypeId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCvtermRelatedByPlatformtypeId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Contact)
                $obj3->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Protocol)
                $obj4->addArraydesign($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with all related objects except Protocol.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
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
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        CvtermPeer::addSelectColumns($criteria);
        $startcol6 = $startcol5 + CvtermPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PLATFORMTYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::SUBSTRATETYPE_ID, CvtermPeer::CVTERM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Contact)
                $obj3->addArraydesign($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key4 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol4);
                if ($key4 !== null) {
                    $obj4 = CvtermPeer::getInstanceFromPool($key4);
                    if (!$obj4) {

                        $cls = CvtermPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    CvtermPeer::addInstanceToPool($obj4, $key4);
                } // if $obj4 already loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Cvterm)
                $obj4->addArraydesignRelatedByPlatformtypeId($obj1);

            } // if joined row is not null

                // Add objects for joined Cvterm rows

                $key5 = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol5);
                if ($key5 !== null) {
                    $obj5 = CvtermPeer::getInstanceFromPool($key5);
                    if (!$obj5) {

                        $cls = CvtermPeer::getOMClass();

                    $obj5 = new $cls();
                    $obj5->hydrate($row, $startcol5);
                    CvtermPeer::addInstanceToPool($obj5, $key5);
                } // if $obj5 already loaded

                // Add the $obj1 (Arraydesign) to the collection in $obj5 (Cvterm)
                $obj5->addArraydesignRelatedBySubstratetypeId($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Arraydesign objects pre-filled with all related objects except CvtermRelatedBySubstratetypeId.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Arraydesign objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCvtermRelatedBySubstratetypeId(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);
        }

        ArraydesignPeer::addSelectColumns($criteria);
        $startcol2 = ArraydesignPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + ContactPeer::NUM_HYDRATE_COLUMNS;

        ProtocolPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + ProtocolPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(ArraydesignPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::MANUFACTURER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(ArraydesignPeer::PROTOCOL_ID, ProtocolPeer::PROTOCOL_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = ArraydesignPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = ArraydesignPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = ArraydesignPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                ArraydesignPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Arraydesign) to the collection in $obj2 (Dbxref)
                $obj2->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj3 (Contact)
                $obj3->addArraydesign($obj1);

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

                // Add the $obj1 (Arraydesign) to the collection in $obj4 (Protocol)
                $obj4->addArraydesign($obj1);

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
        return Propel::getDatabaseMap(ArraydesignPeer::DATABASE_NAME)->getTable(ArraydesignPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseArraydesignPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseArraydesignPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new ArraydesignTableMap());
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
        return ArraydesignPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Arraydesign or Criteria object.
     *
     * @param      mixed $values Criteria or Arraydesign object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Arraydesign object
        }

        if ($criteria->containsKey(ArraydesignPeer::ARRAYDESIGN_ID) && $criteria->keyContainsValue(ArraydesignPeer::ARRAYDESIGN_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.ArraydesignPeer::ARRAYDESIGN_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Arraydesign or Criteria object.
     *
     * @param      mixed $values Criteria or Arraydesign object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(ArraydesignPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(ArraydesignPeer::ARRAYDESIGN_ID);
            $value = $criteria->remove(ArraydesignPeer::ARRAYDESIGN_ID);
            if ($value) {
                $selectCriteria->add(ArraydesignPeer::ARRAYDESIGN_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(ArraydesignPeer::TABLE_NAME);
            }

        } else { // $values is Arraydesign object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the arraydesign table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(ArraydesignPeer::TABLE_NAME, $con, ArraydesignPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            ArraydesignPeer::clearInstancePool();
            ArraydesignPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Arraydesign or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Arraydesign object or primary key or array of primary keys
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
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            ArraydesignPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Arraydesign) { // it's a model object
            // invalidate the cache for this single object
            ArraydesignPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(ArraydesignPeer::DATABASE_NAME);
            $criteria->add(ArraydesignPeer::ARRAYDESIGN_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                ArraydesignPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(ArraydesignPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            ArraydesignPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Arraydesign object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Arraydesign $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(ArraydesignPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(ArraydesignPeer::TABLE_NAME);

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

        return BasePeer::doValidate(ArraydesignPeer::DATABASE_NAME, ArraydesignPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Arraydesign
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = ArraydesignPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(ArraydesignPeer::DATABASE_NAME);
        $criteria->add(ArraydesignPeer::ARRAYDESIGN_ID, $pk);

        $v = ArraydesignPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Arraydesign[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(ArraydesignPeer::DATABASE_NAME);
            $criteria->add(ArraydesignPeer::ARRAYDESIGN_ID, $pks, Criteria::IN);
            $objs = ArraydesignPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseArraydesignPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseArraydesignPeer::buildTableMap();

