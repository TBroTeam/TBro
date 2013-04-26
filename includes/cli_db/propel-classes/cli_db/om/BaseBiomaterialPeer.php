<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AssayBiomaterialPeer;
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialDbxrefPeer;
use cli_db\propel\BiomaterialPeer;
use cli_db\propel\BiomaterialTreatmentPeer;
use cli_db\propel\BiomaterialpropPeer;
use cli_db\propel\ContactPeer;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\OrganismPeer;
use cli_db\propel\TreatmentPeer;
use cli_db\propel\map\BiomaterialTableMap;

/**
 * Base static class for performing query and update operations on the 'biomaterial' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseBiomaterialPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'biomaterial';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Biomaterial';

    /** the related TableMap class for this table */
    const TM_CLASS = 'BiomaterialTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 6;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 6;

    /** the column name for the biomaterial_id field */
    const BIOMATERIAL_ID = 'biomaterial.biomaterial_id';

    /** the column name for the taxon_id field */
    const TAXON_ID = 'biomaterial.taxon_id';

    /** the column name for the biosourceprovider_id field */
    const BIOSOURCEPROVIDER_ID = 'biomaterial.biosourceprovider_id';

    /** the column name for the dbxref_id field */
    const DBXREF_ID = 'biomaterial.dbxref_id';

    /** the column name for the name field */
    const NAME = 'biomaterial.name';

    /** the column name for the description field */
    const DESCRIPTION = 'biomaterial.description';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Biomaterial objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Biomaterial[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialPeer::$fieldNames[BiomaterialPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialId', 'TaxonId', 'BiosourceproviderId', 'DbxrefId', 'Name', 'Description', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialId', 'taxonId', 'biosourceproviderId', 'dbxrefId', 'name', 'description', ),
        BasePeer::TYPE_COLNAME => array (BiomaterialPeer::BIOMATERIAL_ID, BiomaterialPeer::TAXON_ID, BiomaterialPeer::BIOSOURCEPROVIDER_ID, BiomaterialPeer::DBXREF_ID, BiomaterialPeer::NAME, BiomaterialPeer::DESCRIPTION, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_ID', 'TAXON_ID', 'BIOSOURCEPROVIDER_ID', 'DBXREF_ID', 'NAME', 'DESCRIPTION', ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_id', 'taxon_id', 'biosourceprovider_id', 'dbxref_id', 'name', 'description', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. BiomaterialPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('BiomaterialId' => 0, 'TaxonId' => 1, 'BiosourceproviderId' => 2, 'DbxrefId' => 3, 'Name' => 4, 'Description' => 5, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('biomaterialId' => 0, 'taxonId' => 1, 'biosourceproviderId' => 2, 'dbxrefId' => 3, 'name' => 4, 'description' => 5, ),
        BasePeer::TYPE_COLNAME => array (BiomaterialPeer::BIOMATERIAL_ID => 0, BiomaterialPeer::TAXON_ID => 1, BiomaterialPeer::BIOSOURCEPROVIDER_ID => 2, BiomaterialPeer::DBXREF_ID => 3, BiomaterialPeer::NAME => 4, BiomaterialPeer::DESCRIPTION => 5, ),
        BasePeer::TYPE_RAW_COLNAME => array ('BIOMATERIAL_ID' => 0, 'TAXON_ID' => 1, 'BIOSOURCEPROVIDER_ID' => 2, 'DBXREF_ID' => 3, 'NAME' => 4, 'DESCRIPTION' => 5, ),
        BasePeer::TYPE_FIELDNAME => array ('biomaterial_id' => 0, 'taxon_id' => 1, 'biosourceprovider_id' => 2, 'dbxref_id' => 3, 'name' => 4, 'description' => 5, ),
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
        $toNames = BiomaterialPeer::getFieldNames($toType);
        $key = isset(BiomaterialPeer::$fieldKeys[$fromType][$name]) ? BiomaterialPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(BiomaterialPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, BiomaterialPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return BiomaterialPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. BiomaterialPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(BiomaterialPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(BiomaterialPeer::BIOMATERIAL_ID);
            $criteria->addSelectColumn(BiomaterialPeer::TAXON_ID);
            $criteria->addSelectColumn(BiomaterialPeer::BIOSOURCEPROVIDER_ID);
            $criteria->addSelectColumn(BiomaterialPeer::DBXREF_ID);
            $criteria->addSelectColumn(BiomaterialPeer::NAME);
            $criteria->addSelectColumn(BiomaterialPeer::DESCRIPTION);
        } else {
            $criteria->addSelectColumn($alias . '.biomaterial_id');
            $criteria->addSelectColumn($alias . '.taxon_id');
            $criteria->addSelectColumn($alias . '.biosourceprovider_id');
            $criteria->addSelectColumn($alias . '.dbxref_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.description');
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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Biomaterial
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = BiomaterialPeer::doSelect($critcopy, $con);
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
        return BiomaterialPeer::populateObjects(BiomaterialPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            BiomaterialPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

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
     * @param      Biomaterial $obj A Biomaterial object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getBiomaterialId();
            } // if key === null
            BiomaterialPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Biomaterial object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Biomaterial) {
                $key = (string) $value->getBiomaterialId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Biomaterial object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(BiomaterialPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Biomaterial Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(BiomaterialPeer::$instances[$key])) {
                return BiomaterialPeer::$instances[$key];
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
        foreach (BiomaterialPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        BiomaterialPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to biomaterial
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in AssayBiomaterialPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AssayBiomaterialPeer::clearInstancePool();
        // Invalidate objects in BiomaterialDbxrefPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BiomaterialDbxrefPeer::clearInstancePool();
        // Invalidate objects in BiomaterialTreatmentPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BiomaterialTreatmentPeer::clearInstancePool();
        // Invalidate objects in BiomaterialpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BiomaterialpropPeer::clearInstancePool();
        // Invalidate objects in TreatmentPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        TreatmentPeer::clearInstancePool();
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
        $cls = BiomaterialPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = BiomaterialPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                BiomaterialPeer::addInstanceToPool($obj, $key);
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
     * @return array (Biomaterial object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = BiomaterialPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = BiomaterialPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + BiomaterialPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = BiomaterialPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            BiomaterialPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Organism table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinOrganism(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

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
     * Selects a collection of Biomaterial objects pre-filled with their Contact objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinContact(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol = BiomaterialPeer::NUM_HYDRATE_COLUMNS;
        ContactPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Biomaterial) to $obj2 (Contact)
                $obj2->addBiomaterial($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Biomaterial objects pre-filled with their Dbxref objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinDbxref(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol = BiomaterialPeer::NUM_HYDRATE_COLUMNS;
        DbxrefPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Biomaterial) to $obj2 (Dbxref)
                $obj2->addBiomaterial($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Biomaterial objects pre-filled with their Organism objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinOrganism(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol = BiomaterialPeer::NUM_HYDRATE_COLUMNS;
        OrganismPeer::addSelectColumns($criteria);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = OrganismPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = OrganismPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = OrganismPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    OrganismPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Biomaterial) to $obj2 (Organism)
                $obj2->addBiomaterial($obj1);

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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

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
     * Selects a collection of Biomaterial objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContactPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        OrganismPeer::addSelectColumns($criteria);
        $startcol5 = $startcol4 + OrganismPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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
                } // if obj2 loaded

                // Add the $obj1 (Biomaterial) to the collection in $obj2 (Contact)
                $obj2->addBiomaterial($obj1);
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

                // Add the $obj1 (Biomaterial) to the collection in $obj3 (Dbxref)
                $obj3->addBiomaterial($obj1);
            } // if joined row not null

            // Add objects for joined Organism rows

            $key4 = OrganismPeer::getPrimaryKeyHashFromRow($row, $startcol4);
            if ($key4 !== null) {
                $obj4 = OrganismPeer::getInstanceFromPool($key4);
                if (!$obj4) {

                    $cls = OrganismPeer::getOMClass();

                    $obj4 = new $cls();
                    $obj4->hydrate($row, $startcol4);
                    OrganismPeer::addInstanceToPool($obj4, $key4);
                } // if obj4 loaded

                // Add the $obj1 (Biomaterial) to the collection in $obj4 (Organism)
                $obj4->addBiomaterial($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);

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
     * Returns the number of rows matching criteria, joining the related Organism table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptOrganism(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            BiomaterialPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Selects a collection of Biomaterial objects pre-filled with all related objects except Contact.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
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
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        OrganismPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + OrganismPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Biomaterial) to the collection in $obj2 (Dbxref)
                $obj2->addBiomaterial($obj1);

            } // if joined row is not null

                // Add objects for joined Organism rows

                $key3 = OrganismPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = OrganismPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = OrganismPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    OrganismPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Biomaterial) to the collection in $obj3 (Organism)
                $obj3->addBiomaterial($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Biomaterial objects pre-filled with all related objects except Dbxref.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
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
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContactPeer::NUM_HYDRATE_COLUMNS;

        OrganismPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + OrganismPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::TAXON_ID, OrganismPeer::ORGANISM_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Biomaterial) to the collection in $obj2 (Contact)
                $obj2->addBiomaterial($obj1);

            } // if joined row is not null

                // Add objects for joined Organism rows

                $key3 = OrganismPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = OrganismPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = OrganismPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    OrganismPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Biomaterial) to the collection in $obj3 (Organism)
                $obj3->addBiomaterial($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Biomaterial objects pre-filled with all related objects except Organism.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Biomaterial objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptOrganism(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);
        }

        BiomaterialPeer::addSelectColumns($criteria);
        $startcol2 = BiomaterialPeer::NUM_HYDRATE_COLUMNS;

        ContactPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + ContactPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(BiomaterialPeer::BIOSOURCEPROVIDER_ID, ContactPeer::CONTACT_ID, $join_behavior);

        $criteria->addJoin(BiomaterialPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = BiomaterialPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = BiomaterialPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = BiomaterialPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                BiomaterialPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Biomaterial) to the collection in $obj2 (Contact)
                $obj2->addBiomaterial($obj1);

            } // if joined row is not null

                // Add objects for joined Dbxref rows

                $key3 = DbxrefPeer::getPrimaryKeyHashFromRow($row, $startcol3);
                if ($key3 !== null) {
                    $obj3 = DbxrefPeer::getInstanceFromPool($key3);
                    if (!$obj3) {

                        $cls = DbxrefPeer::getOMClass();

                    $obj3 = new $cls();
                    $obj3->hydrate($row, $startcol3);
                    DbxrefPeer::addInstanceToPool($obj3, $key3);
                } // if $obj3 already loaded

                // Add the $obj1 (Biomaterial) to the collection in $obj3 (Dbxref)
                $obj3->addBiomaterial($obj1);

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
        return Propel::getDatabaseMap(BiomaterialPeer::DATABASE_NAME)->getTable(BiomaterialPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseBiomaterialPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseBiomaterialPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new BiomaterialTableMap());
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
        return BiomaterialPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Biomaterial or Criteria object.
     *
     * @param      mixed $values Criteria or Biomaterial object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Biomaterial object
        }

        if ($criteria->containsKey(BiomaterialPeer::BIOMATERIAL_ID) && $criteria->keyContainsValue(BiomaterialPeer::BIOMATERIAL_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.BiomaterialPeer::BIOMATERIAL_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Biomaterial or Criteria object.
     *
     * @param      mixed $values Criteria or Biomaterial object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(BiomaterialPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(BiomaterialPeer::BIOMATERIAL_ID);
            $value = $criteria->remove(BiomaterialPeer::BIOMATERIAL_ID);
            if ($value) {
                $selectCriteria->add(BiomaterialPeer::BIOMATERIAL_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(BiomaterialPeer::TABLE_NAME);
            }

        } else { // $values is Biomaterial object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the biomaterial table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(BiomaterialPeer::TABLE_NAME, $con, BiomaterialPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            BiomaterialPeer::clearInstancePool();
            BiomaterialPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Biomaterial or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Biomaterial object or primary key or array of primary keys
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
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            BiomaterialPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Biomaterial) { // it's a model object
            // invalidate the cache for this single object
            BiomaterialPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(BiomaterialPeer::DATABASE_NAME);
            $criteria->add(BiomaterialPeer::BIOMATERIAL_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                BiomaterialPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(BiomaterialPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            BiomaterialPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Biomaterial object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Biomaterial $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(BiomaterialPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(BiomaterialPeer::TABLE_NAME);

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

        return BasePeer::doValidate(BiomaterialPeer::DATABASE_NAME, BiomaterialPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Biomaterial
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = BiomaterialPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(BiomaterialPeer::DATABASE_NAME);
        $criteria->add(BiomaterialPeer::BIOMATERIAL_ID, $pk);

        $v = BiomaterialPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Biomaterial[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(BiomaterialPeer::DATABASE_NAME);
            $criteria->add(BiomaterialPeer::BIOMATERIAL_ID, $pks, Criteria::IN);
            $objs = BiomaterialPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseBiomaterialPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseBiomaterialPeer::buildTableMap();

