<?php

namespace cli_db\propel\om;

use \BasePeer;
use \Criteria;
use \PDO;
use \PDOStatement;
use \Propel;
use \PropelException;
use \PropelPDO;
use cli_db\propel\AcquisitionRelationshipPeer;
use cli_db\propel\AcquisitionpropPeer;
use cli_db\propel\AnalysisfeaturepropPeer;
use cli_db\propel\AnalysispropPeer;
use cli_db\propel\ArraydesignPeer;
use cli_db\propel\ArraydesignpropPeer;
use cli_db\propel\AssaypropPeer;
use cli_db\propel\BiomaterialTreatmentPeer;
use cli_db\propel\BiomaterialpropPeer;
use cli_db\propel\ContactRelationshipPeer;
use cli_db\propel\ControlPeer;
use cli_db\propel\CvPeer;
use cli_db\propel\Cvterm;
use cli_db\propel\CvtermDbxrefPeer;
use cli_db\propel\CvtermPeer;
use cli_db\propel\CvtermRelationshipPeer;
use cli_db\propel\CvtermpathPeer;
use cli_db\propel\CvtermpropPeer;
use cli_db\propel\CvtermsynonymPeer;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\ElementPeer;
use cli_db\propel\FeatureCvtermPeer;
use cli_db\propel\FeatureCvtermpropPeer;
use cli_db\propel\FeaturePeer;
use cli_db\propel\FeaturePubpropPeer;
use cli_db\propel\FeatureRelationshipPeer;
use cli_db\propel\FeatureRelationshippropPeer;
use cli_db\propel\FeaturepropPeer;
use cli_db\propel\OrganismpropPeer;
use cli_db\propel\ProjectpropPeer;
use cli_db\propel\ProtocolPeer;
use cli_db\propel\ProtocolparamPeer;
use cli_db\propel\PubPeer;
use cli_db\propel\PubRelationshipPeer;
use cli_db\propel\PubpropPeer;
use cli_db\propel\QuantificationRelationshipPeer;
use cli_db\propel\QuantificationpropPeer;
use cli_db\propel\StudydesignpropPeer;
use cli_db\propel\StudyfactorPeer;
use cli_db\propel\StudypropFeaturePeer;
use cli_db\propel\StudypropPeer;
use cli_db\propel\SynonymPeer;
use cli_db\propel\TreatmentPeer;
use cli_db\propel\map\CvtermTableMap;

/**
 * Base static class for performing query and update operations on the 'cvterm' table.
 *
 *
 *
 * @package propel.generator.cli_db.om
 */
abstract class BaseCvtermPeer
{

    /** the default database name for this class */
    const DATABASE_NAME = 'cli_db';

    /** the table name for this class */
    const TABLE_NAME = 'cvterm';

    /** the related Propel class for this table */
    const OM_CLASS = 'cli_db\\propel\\Cvterm';

    /** the related TableMap class for this table */
    const TM_CLASS = 'CvtermTableMap';

    /** The total number of columns. */
    const NUM_COLUMNS = 7;

    /** The number of lazy-loaded columns. */
    const NUM_LAZY_LOAD_COLUMNS = 0;

    /** The number of columns to hydrate (NUM_COLUMNS - NUM_LAZY_LOAD_COLUMNS) */
    const NUM_HYDRATE_COLUMNS = 7;

    /** the column name for the cvterm_id field */
    const CVTERM_ID = 'cvterm.cvterm_id';

    /** the column name for the cv_id field */
    const CV_ID = 'cvterm.cv_id';

    /** the column name for the name field */
    const NAME = 'cvterm.name';

    /** the column name for the definition field */
    const DEFINITION = 'cvterm.definition';

    /** the column name for the dbxref_id field */
    const DBXREF_ID = 'cvterm.dbxref_id';

    /** the column name for the is_obsolete field */
    const IS_OBSOLETE = 'cvterm.is_obsolete';

    /** the column name for the is_relationshiptype field */
    const IS_RELATIONSHIPTYPE = 'cvterm.is_relationshiptype';

    /** The default string format for model objects of the related table **/
    const DEFAULT_STRING_FORMAT = 'YAML';

    /**
     * An identiy map to hold any loaded instances of Cvterm objects.
     * This must be public so that other peer classes can access this when hydrating from JOIN
     * queries.
     * @var        array Cvterm[]
     */
    public static $instances = array();


    /**
     * holds an array of fieldnames
     *
     * first dimension keys are the type constants
     * e.g. CvtermPeer::$fieldNames[CvtermPeer::TYPE_PHPNAME][0] = 'Id'
     */
    protected static $fieldNames = array (
        BasePeer::TYPE_PHPNAME => array ('CvtermId', 'CvId', 'Name', 'Definition', 'DbxrefId', 'IsObsolete', 'IsRelationshiptype', ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('cvtermId', 'cvId', 'name', 'definition', 'dbxrefId', 'isObsolete', 'isRelationshiptype', ),
        BasePeer::TYPE_COLNAME => array (CvtermPeer::CVTERM_ID, CvtermPeer::CV_ID, CvtermPeer::NAME, CvtermPeer::DEFINITION, CvtermPeer::DBXREF_ID, CvtermPeer::IS_OBSOLETE, CvtermPeer::IS_RELATIONSHIPTYPE, ),
        BasePeer::TYPE_RAW_COLNAME => array ('CVTERM_ID', 'CV_ID', 'NAME', 'DEFINITION', 'DBXREF_ID', 'IS_OBSOLETE', 'IS_RELATIONSHIPTYPE', ),
        BasePeer::TYPE_FIELDNAME => array ('cvterm_id', 'cv_id', 'name', 'definition', 'dbxref_id', 'is_obsolete', 'is_relationshiptype', ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
    );

    /**
     * holds an array of keys for quick access to the fieldnames array
     *
     * first dimension keys are the type constants
     * e.g. CvtermPeer::$fieldNames[BasePeer::TYPE_PHPNAME]['Id'] = 0
     */
    protected static $fieldKeys = array (
        BasePeer::TYPE_PHPNAME => array ('CvtermId' => 0, 'CvId' => 1, 'Name' => 2, 'Definition' => 3, 'DbxrefId' => 4, 'IsObsolete' => 5, 'IsRelationshiptype' => 6, ),
        BasePeer::TYPE_STUDLYPHPNAME => array ('cvtermId' => 0, 'cvId' => 1, 'name' => 2, 'definition' => 3, 'dbxrefId' => 4, 'isObsolete' => 5, 'isRelationshiptype' => 6, ),
        BasePeer::TYPE_COLNAME => array (CvtermPeer::CVTERM_ID => 0, CvtermPeer::CV_ID => 1, CvtermPeer::NAME => 2, CvtermPeer::DEFINITION => 3, CvtermPeer::DBXREF_ID => 4, CvtermPeer::IS_OBSOLETE => 5, CvtermPeer::IS_RELATIONSHIPTYPE => 6, ),
        BasePeer::TYPE_RAW_COLNAME => array ('CVTERM_ID' => 0, 'CV_ID' => 1, 'NAME' => 2, 'DEFINITION' => 3, 'DBXREF_ID' => 4, 'IS_OBSOLETE' => 5, 'IS_RELATIONSHIPTYPE' => 6, ),
        BasePeer::TYPE_FIELDNAME => array ('cvterm_id' => 0, 'cv_id' => 1, 'name' => 2, 'definition' => 3, 'dbxref_id' => 4, 'is_obsolete' => 5, 'is_relationshiptype' => 6, ),
        BasePeer::TYPE_NUM => array (0, 1, 2, 3, 4, 5, 6, )
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
        $toNames = CvtermPeer::getFieldNames($toType);
        $key = isset(CvtermPeer::$fieldKeys[$fromType][$name]) ? CvtermPeer::$fieldKeys[$fromType][$name] : null;
        if ($key === null) {
            throw new PropelException("'$name' could not be found in the field names of type '$fromType'. These are: " . print_r(CvtermPeer::$fieldKeys[$fromType], true));
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
        if (!array_key_exists($type, CvtermPeer::$fieldNames)) {
            throw new PropelException('Method getFieldNames() expects the parameter $type to be one of the class constants BasePeer::TYPE_PHPNAME, BasePeer::TYPE_STUDLYPHPNAME, BasePeer::TYPE_COLNAME, BasePeer::TYPE_FIELDNAME, BasePeer::TYPE_NUM. ' . $type . ' was given.');
        }

        return CvtermPeer::$fieldNames[$type];
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
     * @param      string $column The column name for current table. (i.e. CvtermPeer::COLUMN_NAME).
     * @return string
     */
    public static function alias($alias, $column)
    {
        return str_replace(CvtermPeer::TABLE_NAME.'.', $alias.'.', $column);
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
            $criteria->addSelectColumn(CvtermPeer::CVTERM_ID);
            $criteria->addSelectColumn(CvtermPeer::CV_ID);
            $criteria->addSelectColumn(CvtermPeer::NAME);
            $criteria->addSelectColumn(CvtermPeer::DEFINITION);
            $criteria->addSelectColumn(CvtermPeer::DBXREF_ID);
            $criteria->addSelectColumn(CvtermPeer::IS_OBSOLETE);
            $criteria->addSelectColumn(CvtermPeer::IS_RELATIONSHIPTYPE);
        } else {
            $criteria->addSelectColumn($alias . '.cvterm_id');
            $criteria->addSelectColumn($alias . '.cv_id');
            $criteria->addSelectColumn($alias . '.name');
            $criteria->addSelectColumn($alias . '.definition');
            $criteria->addSelectColumn($alias . '.dbxref_id');
            $criteria->addSelectColumn($alias . '.is_obsolete');
            $criteria->addSelectColumn($alias . '.is_relationshiptype');
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
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count
        $criteria->setDbName(CvtermPeer::DATABASE_NAME); // Set the correct dbName

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Cvterm
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectOne(Criteria $criteria, PropelPDO $con = null)
    {
        $critcopy = clone $criteria;
        $critcopy->setLimit(1);
        $objects = CvtermPeer::doSelect($critcopy, $con);
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
        return CvtermPeer::populateObjects(CvtermPeer::doSelectStmt($criteria, $con));
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
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        if (!$criteria->hasSelectClause()) {
            $criteria = clone $criteria;
            CvtermPeer::addSelectColumns($criteria);
        }

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

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
     * @param      Cvterm $obj A Cvterm object.
     * @param      string $key (optional) key to use for instance map (for performance boost if key was already calculated externally).
     */
    public static function addInstanceToPool($obj, $key = null)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if ($key === null) {
                $key = (string) $obj->getCvtermId();
            } // if key === null
            CvtermPeer::$instances[$key] = $obj;
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
     * @param      mixed $value A Cvterm object or a primary key value.
     *
     * @return void
     * @throws PropelException - if the value is invalid.
     */
    public static function removeInstanceFromPool($value)
    {
        if (Propel::isInstancePoolingEnabled() && $value !== null) {
            if (is_object($value) && $value instanceof Cvterm) {
                $key = (string) $value->getCvtermId();
            } elseif (is_scalar($value)) {
                // assume we've been passed a primary key
                $key = (string) $value;
            } else {
                $e = new PropelException("Invalid value passed to removeInstanceFromPool().  Expected primary key or Cvterm object; got " . (is_object($value) ? get_class($value) . ' object.' : var_export($value,true)));
                throw $e;
            }

            unset(CvtermPeer::$instances[$key]);
        }
    } // removeInstanceFromPool()

    /**
     * Retrieves a string version of the primary key from the DB resultset row that can be used to uniquely identify a row in this table.
     *
     * For tables with a single-column primary key, that simple pkey value will be returned.  For tables with
     * a multi-column primary key, a serialize()d version of the primary key will be returned.
     *
     * @param      string $key The key (@see getPrimaryKeyHash()) for this instance.
     * @return   Cvterm Found object or null if 1) no instance exists for specified key or 2) instance pooling has been disabled.
     * @see        getPrimaryKeyHash()
     */
    public static function getInstanceFromPool($key)
    {
        if (Propel::isInstancePoolingEnabled()) {
            if (isset(CvtermPeer::$instances[$key])) {
                return CvtermPeer::$instances[$key];
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
        foreach (CvtermPeer::$instances as $instance)
        {
          $instance->clearAllReferences(true);
        }
      }
        CvtermPeer::$instances = array();
    }

    /**
     * Method to invalidate the instance pool of all tables related to cvterm
     * by a foreign key with ON DELETE CASCADE
     */
    public static function clearRelatedInstancePool()
    {
        // Invalidate objects in AcquisitionRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AcquisitionRelationshipPeer::clearInstancePool();
        // Invalidate objects in AcquisitionpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AcquisitionpropPeer::clearInstancePool();
        // Invalidate objects in AnalysisfeaturepropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AnalysisfeaturepropPeer::clearInstancePool();
        // Invalidate objects in AnalysispropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AnalysispropPeer::clearInstancePool();
        // Invalidate objects in ArraydesignPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArraydesignPeer::clearInstancePool();
        // Invalidate objects in ArraydesignPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArraydesignPeer::clearInstancePool();
        // Invalidate objects in ArraydesignpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ArraydesignpropPeer::clearInstancePool();
        // Invalidate objects in AssaypropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        AssaypropPeer::clearInstancePool();
        // Invalidate objects in BiomaterialTreatmentPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BiomaterialTreatmentPeer::clearInstancePool();
        // Invalidate objects in BiomaterialpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        BiomaterialpropPeer::clearInstancePool();
        // Invalidate objects in ContactRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ContactRelationshipPeer::clearInstancePool();
        // Invalidate objects in ControlPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ControlPeer::clearInstancePool();
        // Invalidate objects in CvtermDbxrefPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermDbxrefPeer::clearInstancePool();
        // Invalidate objects in CvtermRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermRelationshipPeer::clearInstancePool();
        // Invalidate objects in CvtermRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermRelationshipPeer::clearInstancePool();
        // Invalidate objects in CvtermRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermRelationshipPeer::clearInstancePool();
        // Invalidate objects in CvtermpathPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermpathPeer::clearInstancePool();
        // Invalidate objects in CvtermpathPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermpathPeer::clearInstancePool();
        // Invalidate objects in CvtermpathPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermpathPeer::clearInstancePool();
        // Invalidate objects in CvtermpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermpropPeer::clearInstancePool();
        // Invalidate objects in CvtermpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermpropPeer::clearInstancePool();
        // Invalidate objects in CvtermsynonymPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermsynonymPeer::clearInstancePool();
        // Invalidate objects in CvtermsynonymPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        CvtermsynonymPeer::clearInstancePool();
        // Invalidate objects in ElementPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ElementPeer::clearInstancePool();
        // Invalidate objects in FeaturePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeaturePeer::clearInstancePool();
        // Invalidate objects in FeatureCvtermPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeatureCvtermPeer::clearInstancePool();
        // Invalidate objects in FeatureCvtermpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeatureCvtermpropPeer::clearInstancePool();
        // Invalidate objects in FeaturePubpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeaturePubpropPeer::clearInstancePool();
        // Invalidate objects in FeatureRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeatureRelationshipPeer::clearInstancePool();
        // Invalidate objects in FeatureRelationshippropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeatureRelationshippropPeer::clearInstancePool();
        // Invalidate objects in FeaturepropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        FeaturepropPeer::clearInstancePool();
        // Invalidate objects in OrganismpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        OrganismpropPeer::clearInstancePool();
        // Invalidate objects in ProjectpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProjectpropPeer::clearInstancePool();
        // Invalidate objects in ProtocolPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProtocolPeer::clearInstancePool();
        // Invalidate objects in ProtocolparamPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProtocolparamPeer::clearInstancePool();
        // Invalidate objects in ProtocolparamPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        ProtocolparamPeer::clearInstancePool();
        // Invalidate objects in PubPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PubPeer::clearInstancePool();
        // Invalidate objects in PubRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PubRelationshipPeer::clearInstancePool();
        // Invalidate objects in PubpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        PubpropPeer::clearInstancePool();
        // Invalidate objects in QuantificationRelationshipPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        QuantificationRelationshipPeer::clearInstancePool();
        // Invalidate objects in QuantificationpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        QuantificationpropPeer::clearInstancePool();
        // Invalidate objects in StudydesignpropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StudydesignpropPeer::clearInstancePool();
        // Invalidate objects in StudyfactorPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StudyfactorPeer::clearInstancePool();
        // Invalidate objects in StudypropPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StudypropPeer::clearInstancePool();
        // Invalidate objects in StudypropFeaturePeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        StudypropFeaturePeer::clearInstancePool();
        // Invalidate objects in SynonymPeer instance pool,
        // since one or more of them may be deleted by ON DELETE CASCADE/SETNULL rule.
        SynonymPeer::clearInstancePool();
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
        $cls = CvtermPeer::getOMClass();
        // populate the object(s)
        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj = CvtermPeer::getInstanceFromPool($key))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj->hydrate($row, 0, true); // rehydrate
                $results[] = $obj;
            } else {
                $obj = new $cls();
                $obj->hydrate($row);
                $results[] = $obj;
                CvtermPeer::addInstanceToPool($obj, $key);
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
     * @return array (Cvterm object, last column rank)
     */
    public static function populateObject($row, $startcol = 0)
    {
        $key = CvtermPeer::getPrimaryKeyHashFromRow($row, $startcol);
        if (null !== ($obj = CvtermPeer::getInstanceFromPool($key))) {
            // We no longer rehydrate the object, since this can cause data loss.
            // See http://www.propelorm.org/ticket/509
            // $obj->hydrate($row, $startcol, true); // rehydrate
            $col = $startcol + CvtermPeer::NUM_HYDRATE_COLUMNS;
        } else {
            $cls = CvtermPeer::OM_CLASS;
            $obj = new $cls();
            $col = $obj->hydrate($row, $startcol);
            CvtermPeer::addInstanceToPool($obj, $key);
        }

        return array($obj, $col);
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cv table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinCv(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Selects a collection of Cvterm objects pre-filled with their Cv objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Cvterm objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinCv(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CvtermPeer::DATABASE_NAME);
        }

        CvtermPeer::addSelectColumns($criteria);
        $startcol = CvtermPeer::NUM_HYDRATE_COLUMNS;
        CvPeer::addSelectColumns($criteria);

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CvtermPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CvtermPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CvtermPeer::addInstanceToPool($obj1, $key1);
            } // if $obj1 already loaded

            $key2 = CvPeer::getPrimaryKeyHashFromRow($row, $startcol);
            if ($key2 !== null) {
                $obj2 = CvPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CvPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol);
                    CvPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 already loaded

                // Add the $obj1 (Cvterm) to $obj2 (Cv)
                $obj2->addCvterm($obj1);

            } // if joined row was not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Cvterm objects pre-filled with their Dbxref objects.
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Cvterm objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinDbxref(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CvtermPeer::DATABASE_NAME);
        }

        CvtermPeer::addSelectColumns($criteria);
        $startcol = CvtermPeer::NUM_HYDRATE_COLUMNS;
        DbxrefPeer::addSelectColumns($criteria);

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CvtermPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {

                $cls = CvtermPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CvtermPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Cvterm) to $obj2 (Dbxref)
                $obj2->addCvterm($obj1);

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
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY won't ever affect the count

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
     * Selects a collection of Cvterm objects pre-filled with all related objects.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Cvterm objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAll(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CvtermPeer::DATABASE_NAME);
        }

        CvtermPeer::addSelectColumns($criteria);
        $startcol2 = CvtermPeer::NUM_HYDRATE_COLUMNS;

        CvPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CvPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol4 = $startcol3 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CvtermPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CvtermPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CvtermPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

            // Add objects for joined Cv rows

            $key2 = CvPeer::getPrimaryKeyHashFromRow($row, $startcol2);
            if ($key2 !== null) {
                $obj2 = CvPeer::getInstanceFromPool($key2);
                if (!$obj2) {

                    $cls = CvPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CvPeer::addInstanceToPool($obj2, $key2);
                } // if obj2 loaded

                // Add the $obj1 (Cvterm) to the collection in $obj2 (Cv)
                $obj2->addCvterm($obj1);
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

                // Add the $obj1 (Cvterm) to the collection in $obj3 (Dbxref)
                $obj3->addCvterm($obj1);
            } // if joined row not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Returns the number of rows matching criteria, joining the related Cv table
     *
     * @param      Criteria $criteria
     * @param      boolean $distinct Whether to select only distinct columns; deprecated: use Criteria->setDistinct() instead.
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return int Number of matching rows.
     */
    public static function doCountJoinAllExceptCv(Criteria $criteria, $distinct = false, PropelPDO $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        // we're going to modify criteria, so copy it first
        $criteria = clone $criteria;

        // We need to set the primary table name, since in the case that there are no WHERE columns
        // it will be impossible for the BasePeer::createSelectSql() method to determine which
        // tables go into the FROM clause.
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);

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
        $criteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);

        if ($distinct && !in_array(Criteria::DISTINCT, $criteria->getSelectModifiers())) {
            $criteria->setDistinct();
        }

        if (!$criteria->hasSelectClause()) {
            CvtermPeer::addSelectColumns($criteria);
        }

        $criteria->clearOrderByColumns(); // ORDER BY should not affect count

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);

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
     * Selects a collection of Cvterm objects pre-filled with all related objects except Cv.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Cvterm objects.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doSelectJoinAllExceptCv(Criteria $criteria, $con = null, $join_behavior = Criteria::LEFT_JOIN)
    {
        $criteria = clone $criteria;

        // Set the correct dbName if it has not been overridden
        // $criteria->getDbName() will return the same object if not set to another value
        // so == check is okay and faster
        if ($criteria->getDbName() == Propel::getDefaultDB()) {
            $criteria->setDbName(CvtermPeer::DATABASE_NAME);
        }

        CvtermPeer::addSelectColumns($criteria);
        $startcol2 = CvtermPeer::NUM_HYDRATE_COLUMNS;

        DbxrefPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + DbxrefPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CvtermPeer::DBXREF_ID, DbxrefPeer::DBXREF_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CvtermPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CvtermPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CvtermPeer::addInstanceToPool($obj1, $key1);
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

                // Add the $obj1 (Cvterm) to the collection in $obj2 (Dbxref)
                $obj2->addCvterm($obj1);

            } // if joined row is not null

            $results[] = $obj1;
        }
        $stmt->closeCursor();

        return $results;
    }


    /**
     * Selects a collection of Cvterm objects pre-filled with all related objects except Dbxref.
     *
     * @param      Criteria  $criteria
     * @param      PropelPDO $con
     * @param      String    $join_behavior the type of joins to use, defaults to Criteria::LEFT_JOIN
     * @return array           Array of Cvterm objects.
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
            $criteria->setDbName(CvtermPeer::DATABASE_NAME);
        }

        CvtermPeer::addSelectColumns($criteria);
        $startcol2 = CvtermPeer::NUM_HYDRATE_COLUMNS;

        CvPeer::addSelectColumns($criteria);
        $startcol3 = $startcol2 + CvPeer::NUM_HYDRATE_COLUMNS;

        $criteria->addJoin(CvtermPeer::CV_ID, CvPeer::CV_ID, $join_behavior);


        $stmt = BasePeer::doSelect($criteria, $con);
        $results = array();

        while ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $key1 = CvtermPeer::getPrimaryKeyHashFromRow($row, 0);
            if (null !== ($obj1 = CvtermPeer::getInstanceFromPool($key1))) {
                // We no longer rehydrate the object, since this can cause data loss.
                // See http://www.propelorm.org/ticket/509
                // $obj1->hydrate($row, 0, true); // rehydrate
            } else {
                $cls = CvtermPeer::getOMClass();

                $obj1 = new $cls();
                $obj1->hydrate($row);
                CvtermPeer::addInstanceToPool($obj1, $key1);
            } // if obj1 already loaded

                // Add objects for joined Cv rows

                $key2 = CvPeer::getPrimaryKeyHashFromRow($row, $startcol2);
                if ($key2 !== null) {
                    $obj2 = CvPeer::getInstanceFromPool($key2);
                    if (!$obj2) {

                        $cls = CvPeer::getOMClass();

                    $obj2 = new $cls();
                    $obj2->hydrate($row, $startcol2);
                    CvPeer::addInstanceToPool($obj2, $key2);
                } // if $obj2 already loaded

                // Add the $obj1 (Cvterm) to the collection in $obj2 (Cv)
                $obj2->addCvterm($obj1);

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
        return Propel::getDatabaseMap(CvtermPeer::DATABASE_NAME)->getTable(CvtermPeer::TABLE_NAME);
    }

    /**
     * Add a TableMap instance to the database for this peer class.
     */
    public static function buildTableMap()
    {
      $dbMap = Propel::getDatabaseMap(BaseCvtermPeer::DATABASE_NAME);
      if (!$dbMap->hasTable(BaseCvtermPeer::TABLE_NAME)) {
        $dbMap->addTableObject(new CvtermTableMap());
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
        return CvtermPeer::OM_CLASS;
    }

    /**
     * Performs an INSERT on the database, given a Cvterm or Criteria object.
     *
     * @param      mixed $values Criteria or Cvterm object containing data that is used to create the INSERT statement.
     * @param      PropelPDO $con the PropelPDO connection to use
     * @return mixed           The new primary key.
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doInsert($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity
        } else {
            $criteria = $values->buildCriteria(); // build Criteria from Cvterm object
        }

        if ($criteria->containsKey(CvtermPeer::CVTERM_ID) && $criteria->keyContainsValue(CvtermPeer::CVTERM_ID) ) {
            throw new PropelException('Cannot insert a value for auto-increment primary key ('.CvtermPeer::CVTERM_ID.')');
        }


        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

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
     * Performs an UPDATE on the database, given a Cvterm or Criteria object.
     *
     * @param      mixed $values Criteria or Cvterm object containing data that is used to create the UPDATE statement.
     * @param      PropelPDO $con The connection to use (specify PropelPDO connection object to exert more control over transactions).
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function doUpdate($values, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        $selectCriteria = new Criteria(CvtermPeer::DATABASE_NAME);

        if ($values instanceof Criteria) {
            $criteria = clone $values; // rename for clarity

            $comparison = $criteria->getComparison(CvtermPeer::CVTERM_ID);
            $value = $criteria->remove(CvtermPeer::CVTERM_ID);
            if ($value) {
                $selectCriteria->add(CvtermPeer::CVTERM_ID, $value, $comparison);
            } else {
                $selectCriteria->setPrimaryTableName(CvtermPeer::TABLE_NAME);
            }

        } else { // $values is Cvterm object
            $criteria = $values->buildCriteria(); // gets full criteria
            $selectCriteria = $values->buildPkeyCriteria(); // gets criteria w/ primary key(s)
        }

        // set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        return BasePeer::doUpdate($selectCriteria, $criteria, $con);
    }

    /**
     * Deletes all rows from the cvterm table.
     *
     * @param      PropelPDO $con the connection to use
     * @return int             The number of affected rows (if supported by underlying database driver).
     * @throws PropelException
     */
    public static function doDeleteAll(PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }
        $affectedRows = 0; // initialize var to track total num of affected rows
        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();
            $affectedRows += BasePeer::doDeleteAll(CvtermPeer::TABLE_NAME, $con, CvtermPeer::DATABASE_NAME);
            // Because this db requires some delete cascade/set null emulation, we have to
            // clear the cached instance *after* the emulation has happened (since
            // instances get re-added by the select statement contained therein).
            CvtermPeer::clearInstancePool();
            CvtermPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Performs a DELETE on the database, given a Cvterm or Criteria object OR a primary key value.
     *
     * @param      mixed $values Criteria or Cvterm object or primary key or array of primary keys
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
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_WRITE);
        }

        if ($values instanceof Criteria) {
            // invalidate the cache for all objects of this type, since we have no
            // way of knowing (without running a query) what objects should be invalidated
            // from the cache based on this Criteria.
            CvtermPeer::clearInstancePool();
            // rename for clarity
            $criteria = clone $values;
        } elseif ($values instanceof Cvterm) { // it's a model object
            // invalidate the cache for this single object
            CvtermPeer::removeInstanceFromPool($values);
            // create criteria based on pk values
            $criteria = $values->buildPkeyCriteria();
        } else { // it's a primary key, or an array of pks
            $criteria = new Criteria(CvtermPeer::DATABASE_NAME);
            $criteria->add(CvtermPeer::CVTERM_ID, (array) $values, Criteria::IN);
            // invalidate the cache for this object(s)
            foreach ((array) $values as $singleval) {
                CvtermPeer::removeInstanceFromPool($singleval);
            }
        }

        // Set the correct dbName
        $criteria->setDbName(CvtermPeer::DATABASE_NAME);

        $affectedRows = 0; // initialize var to track total num of affected rows

        try {
            // use transaction because $criteria could contain info
            // for more than one table or we could emulating ON DELETE CASCADE, etc.
            $con->beginTransaction();

            $affectedRows += BasePeer::doDelete($criteria, $con);
            CvtermPeer::clearRelatedInstancePool();
            $con->commit();

            return $affectedRows;
        } catch (PropelException $e) {
            $con->rollBack();
            throw $e;
        }
    }

    /**
     * Validates all modified columns of given Cvterm object.
     * If parameter $columns is either a single column name or an array of column names
     * than only those columns are validated.
     *
     * NOTICE: This does not apply to primary or foreign keys for now.
     *
     * @param      Cvterm $obj The object to validate.
     * @param      mixed $cols Column name or array of column names.
     *
     * @return mixed TRUE if all columns are valid or the error message of the first invalid column.
     */
    public static function doValidate($obj, $cols = null)
    {
        $columns = array();

        if ($cols) {
            $dbMap = Propel::getDatabaseMap(CvtermPeer::DATABASE_NAME);
            $tableMap = $dbMap->getTable(CvtermPeer::TABLE_NAME);

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

        return BasePeer::doValidate(CvtermPeer::DATABASE_NAME, CvtermPeer::TABLE_NAME, $columns);
    }

    /**
     * Retrieve a single object by pkey.
     *
     * @param      int $pk the primary key.
     * @param      PropelPDO $con the connection to use
     * @return Cvterm
     */
    public static function retrieveByPK($pk, PropelPDO $con = null)
    {

        if (null !== ($obj = CvtermPeer::getInstanceFromPool((string) $pk))) {
            return $obj;
        }

        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $criteria = new Criteria(CvtermPeer::DATABASE_NAME);
        $criteria->add(CvtermPeer::CVTERM_ID, $pk);

        $v = CvtermPeer::doSelect($criteria, $con);

        return !empty($v) > 0 ? $v[0] : null;
    }

    /**
     * Retrieve multiple objects by pkey.
     *
     * @param      array $pks List of primary keys
     * @param      PropelPDO $con the connection to use
     * @return Cvterm[]
     * @throws PropelException Any exceptions caught during processing will be
     *		 rethrown wrapped into a PropelException.
     */
    public static function retrieveByPKs($pks, PropelPDO $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection(CvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }

        $objs = null;
        if (empty($pks)) {
            $objs = array();
        } else {
            $criteria = new Criteria(CvtermPeer::DATABASE_NAME);
            $criteria->add(CvtermPeer::CVTERM_ID, $pks, Criteria::IN);
            $objs = CvtermPeer::doSelect($criteria, $con);
        }

        return $objs;
    }

} // BaseCvtermPeer

// This is the static code needed to register the TableMap for this table with the main Propel class.
//
BaseCvtermPeer::buildTableMap();

