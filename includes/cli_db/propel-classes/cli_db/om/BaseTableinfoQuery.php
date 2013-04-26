<?php

namespace cli_db\propel\om;

use \Criteria;
use \Exception;
use \ModelCriteria;
use \ModelJoin;
use \PDO;
use \Propel;
use \PropelCollection;
use \PropelException;
use \PropelObjectCollection;
use \PropelPDO;
use cli_db\propel\Control;
use cli_db\propel\Magedocumentation;
use cli_db\propel\Tableinfo;
use cli_db\propel\TableinfoPeer;
use cli_db\propel\TableinfoQuery;

/**
 * Base class that represents a query for the 'tableinfo' table.
 *
 *
 *
 * @method TableinfoQuery orderByTableinfoId($order = Criteria::ASC) Order by the tableinfo_id column
 * @method TableinfoQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method TableinfoQuery orderByPrimaryKeyColumn($order = Criteria::ASC) Order by the primary_key_column column
 * @method TableinfoQuery orderByIsView($order = Criteria::ASC) Order by the is_view column
 * @method TableinfoQuery orderByViewOnTableId($order = Criteria::ASC) Order by the view_on_table_id column
 * @method TableinfoQuery orderBySuperclassTableId($order = Criteria::ASC) Order by the superclass_table_id column
 * @method TableinfoQuery orderByIsUpdateable($order = Criteria::ASC) Order by the is_updateable column
 * @method TableinfoQuery orderByModificationDate($order = Criteria::ASC) Order by the modification_date column
 *
 * @method TableinfoQuery groupByTableinfoId() Group by the tableinfo_id column
 * @method TableinfoQuery groupByName() Group by the name column
 * @method TableinfoQuery groupByPrimaryKeyColumn() Group by the primary_key_column column
 * @method TableinfoQuery groupByIsView() Group by the is_view column
 * @method TableinfoQuery groupByViewOnTableId() Group by the view_on_table_id column
 * @method TableinfoQuery groupBySuperclassTableId() Group by the superclass_table_id column
 * @method TableinfoQuery groupByIsUpdateable() Group by the is_updateable column
 * @method TableinfoQuery groupByModificationDate() Group by the modification_date column
 *
 * @method TableinfoQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TableinfoQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TableinfoQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TableinfoQuery leftJoinControl($relationAlias = null) Adds a LEFT JOIN clause to the query using the Control relation
 * @method TableinfoQuery rightJoinControl($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Control relation
 * @method TableinfoQuery innerJoinControl($relationAlias = null) Adds a INNER JOIN clause to the query using the Control relation
 *
 * @method TableinfoQuery leftJoinMagedocumentation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Magedocumentation relation
 * @method TableinfoQuery rightJoinMagedocumentation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Magedocumentation relation
 * @method TableinfoQuery innerJoinMagedocumentation($relationAlias = null) Adds a INNER JOIN clause to the query using the Magedocumentation relation
 *
 * @method Tableinfo findOne(PropelPDO $con = null) Return the first Tableinfo matching the query
 * @method Tableinfo findOneOrCreate(PropelPDO $con = null) Return the first Tableinfo matching the query, or a new Tableinfo object populated from the query conditions when no match is found
 *
 * @method Tableinfo findOneByName(string $name) Return the first Tableinfo filtered by the name column
 * @method Tableinfo findOneByPrimaryKeyColumn(string $primary_key_column) Return the first Tableinfo filtered by the primary_key_column column
 * @method Tableinfo findOneByIsView(int $is_view) Return the first Tableinfo filtered by the is_view column
 * @method Tableinfo findOneByViewOnTableId(int $view_on_table_id) Return the first Tableinfo filtered by the view_on_table_id column
 * @method Tableinfo findOneBySuperclassTableId(int $superclass_table_id) Return the first Tableinfo filtered by the superclass_table_id column
 * @method Tableinfo findOneByIsUpdateable(int $is_updateable) Return the first Tableinfo filtered by the is_updateable column
 * @method Tableinfo findOneByModificationDate(string $modification_date) Return the first Tableinfo filtered by the modification_date column
 *
 * @method array findByTableinfoId(int $tableinfo_id) Return Tableinfo objects filtered by the tableinfo_id column
 * @method array findByName(string $name) Return Tableinfo objects filtered by the name column
 * @method array findByPrimaryKeyColumn(string $primary_key_column) Return Tableinfo objects filtered by the primary_key_column column
 * @method array findByIsView(int $is_view) Return Tableinfo objects filtered by the is_view column
 * @method array findByViewOnTableId(int $view_on_table_id) Return Tableinfo objects filtered by the view_on_table_id column
 * @method array findBySuperclassTableId(int $superclass_table_id) Return Tableinfo objects filtered by the superclass_table_id column
 * @method array findByIsUpdateable(int $is_updateable) Return Tableinfo objects filtered by the is_updateable column
 * @method array findByModificationDate(string $modification_date) Return Tableinfo objects filtered by the modification_date column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseTableinfoQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTableinfoQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Tableinfo', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TableinfoQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TableinfoQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TableinfoQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TableinfoQuery) {
            return $criteria;
        }
        $query = new TableinfoQuery();
        if (null !== $modelAlias) {
            $query->setModelAlias($modelAlias);
        }
        if ($criteria instanceof Criteria) {
            $query->mergeWith($criteria);
        }

        return $query;
    }

    /**
     * Find object by primary key.
     * Propel uses the instance pool to skip the database if the object exists.
     * Go fast if the query is untouched.
     *
     * <code>
     * $obj  = $c->findPk(12, $con);
     * </code>
     *
     * @param mixed $key Primary key to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return   Tableinfo|Tableinfo[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TableinfoPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TableinfoPeer::DATABASE_NAME, Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        if ($this->formatter || $this->modelAlias || $this->with || $this->select
         || $this->selectColumns || $this->asColumns || $this->selectModifiers
         || $this->map || $this->having || $this->joins) {
            return $this->findPkComplex($key, $con);
        } else {
            return $this->findPkSimple($key, $con);
        }
    }

    /**
     * Alias of findPk to use instance pooling
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Tableinfo A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByTableinfoId($key, $con = null)
     {
        return $this->findPk($key, $con);
     }

    /**
     * Find object by primary key using raw SQL to go fast.
     * Bypass doSelect() and the object formatter by using generated code.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return                 Tableinfo A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "tableinfo_id", "name", "primary_key_column", "is_view", "view_on_table_id", "superclass_table_id", "is_updateable", "modification_date" FROM "tableinfo" WHERE "tableinfo_id" = :p0';
        try {
            $stmt = $con->prepare($sql);
            $stmt->bindValue(':p0', $key, PDO::PARAM_INT);
            $stmt->execute();
        } catch (Exception $e) {
            Propel::log($e->getMessage(), Propel::LOG_ERR);
            throw new PropelException(sprintf('Unable to execute SELECT statement [%s]', $sql), $e);
        }
        $obj = null;
        if ($row = $stmt->fetch(PDO::FETCH_NUM)) {
            $obj = new Tableinfo();
            $obj->hydrate($row);
            TableinfoPeer::addInstanceToPool($obj, (string) $key);
        }
        $stmt->closeCursor();

        return $obj;
    }

    /**
     * Find object by primary key.
     *
     * @param     mixed $key Primary key to use for the query
     * @param     PropelPDO $con A connection object
     *
     * @return Tableinfo|Tableinfo[]|mixed the result, formatted by the current formatter
     */
    protected function findPkComplex($key, $con)
    {
        // As the query uses a PK condition, no limit(1) is necessary.
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKey($key)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->formatOne($stmt);
    }

    /**
     * Find objects by primary key
     * <code>
     * $objs = $c->findPks(array(12, 56, 832), $con);
     * </code>
     * @param     array $keys Primary keys to use for the query
     * @param     PropelPDO $con an optional connection object
     *
     * @return PropelObjectCollection|Tableinfo[]|mixed the list of results, formatted by the current formatter
     */
    public function findPks($keys, $con = null)
    {
        if ($con === null) {
            $con = Propel::getConnection($this->getDbName(), Propel::CONNECTION_READ);
        }
        $this->basePreSelect($con);
        $criteria = $this->isKeepQuery() ? clone $this : $this;
        $stmt = $criteria
            ->filterByPrimaryKeys($keys)
            ->doSelect($con);

        return $criteria->getFormatter()->init($criteria)->format($stmt);
    }

    /**
     * Filter the query by primary key
     *
     * @param     mixed $key Primary key to use for the query
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the tableinfo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTableinfoId(1234); // WHERE tableinfo_id = 1234
     * $query->filterByTableinfoId(array(12, 34)); // WHERE tableinfo_id IN (12, 34)
     * $query->filterByTableinfoId(array('min' => 12)); // WHERE tableinfo_id >= 12
     * $query->filterByTableinfoId(array('max' => 12)); // WHERE tableinfo_id <= 12
     * </code>
     *
     * @param     mixed $tableinfoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByTableinfoId($tableinfoId = null, $comparison = null)
    {
        if (is_array($tableinfoId)) {
            $useMinMax = false;
            if (isset($tableinfoId['min'])) {
                $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $tableinfoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tableinfoId['max'])) {
                $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $tableinfoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $tableinfoId, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the primary_key_column column
     *
     * Example usage:
     * <code>
     * $query->filterByPrimaryKeyColumn('fooValue');   // WHERE primary_key_column = 'fooValue'
     * $query->filterByPrimaryKeyColumn('%fooValue%'); // WHERE primary_key_column LIKE '%fooValue%'
     * </code>
     *
     * @param     string $primaryKeyColumn The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeyColumn($primaryKeyColumn = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($primaryKeyColumn)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $primaryKeyColumn)) {
                $primaryKeyColumn = str_replace('*', '%', $primaryKeyColumn);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::PRIMARY_KEY_COLUMN, $primaryKeyColumn, $comparison);
    }

    /**
     * Filter the query on the is_view column
     *
     * Example usage:
     * <code>
     * $query->filterByIsView(1234); // WHERE is_view = 1234
     * $query->filterByIsView(array(12, 34)); // WHERE is_view IN (12, 34)
     * $query->filterByIsView(array('min' => 12)); // WHERE is_view >= 12
     * $query->filterByIsView(array('max' => 12)); // WHERE is_view <= 12
     * </code>
     *
     * @param     mixed $isView The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByIsView($isView = null, $comparison = null)
    {
        if (is_array($isView)) {
            $useMinMax = false;
            if (isset($isView['min'])) {
                $this->addUsingAlias(TableinfoPeer::IS_VIEW, $isView['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isView['max'])) {
                $this->addUsingAlias(TableinfoPeer::IS_VIEW, $isView['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::IS_VIEW, $isView, $comparison);
    }

    /**
     * Filter the query on the view_on_table_id column
     *
     * Example usage:
     * <code>
     * $query->filterByViewOnTableId(1234); // WHERE view_on_table_id = 1234
     * $query->filterByViewOnTableId(array(12, 34)); // WHERE view_on_table_id IN (12, 34)
     * $query->filterByViewOnTableId(array('min' => 12)); // WHERE view_on_table_id >= 12
     * $query->filterByViewOnTableId(array('max' => 12)); // WHERE view_on_table_id <= 12
     * </code>
     *
     * @param     mixed $viewOnTableId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByViewOnTableId($viewOnTableId = null, $comparison = null)
    {
        if (is_array($viewOnTableId)) {
            $useMinMax = false;
            if (isset($viewOnTableId['min'])) {
                $this->addUsingAlias(TableinfoPeer::VIEW_ON_TABLE_ID, $viewOnTableId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($viewOnTableId['max'])) {
                $this->addUsingAlias(TableinfoPeer::VIEW_ON_TABLE_ID, $viewOnTableId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::VIEW_ON_TABLE_ID, $viewOnTableId, $comparison);
    }

    /**
     * Filter the query on the superclass_table_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySuperclassTableId(1234); // WHERE superclass_table_id = 1234
     * $query->filterBySuperclassTableId(array(12, 34)); // WHERE superclass_table_id IN (12, 34)
     * $query->filterBySuperclassTableId(array('min' => 12)); // WHERE superclass_table_id >= 12
     * $query->filterBySuperclassTableId(array('max' => 12)); // WHERE superclass_table_id <= 12
     * </code>
     *
     * @param     mixed $superclassTableId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterBySuperclassTableId($superclassTableId = null, $comparison = null)
    {
        if (is_array($superclassTableId)) {
            $useMinMax = false;
            if (isset($superclassTableId['min'])) {
                $this->addUsingAlias(TableinfoPeer::SUPERCLASS_TABLE_ID, $superclassTableId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($superclassTableId['max'])) {
                $this->addUsingAlias(TableinfoPeer::SUPERCLASS_TABLE_ID, $superclassTableId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::SUPERCLASS_TABLE_ID, $superclassTableId, $comparison);
    }

    /**
     * Filter the query on the is_updateable column
     *
     * Example usage:
     * <code>
     * $query->filterByIsUpdateable(1234); // WHERE is_updateable = 1234
     * $query->filterByIsUpdateable(array(12, 34)); // WHERE is_updateable IN (12, 34)
     * $query->filterByIsUpdateable(array('min' => 12)); // WHERE is_updateable >= 12
     * $query->filterByIsUpdateable(array('max' => 12)); // WHERE is_updateable <= 12
     * </code>
     *
     * @param     mixed $isUpdateable The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByIsUpdateable($isUpdateable = null, $comparison = null)
    {
        if (is_array($isUpdateable)) {
            $useMinMax = false;
            if (isset($isUpdateable['min'])) {
                $this->addUsingAlias(TableinfoPeer::IS_UPDATEABLE, $isUpdateable['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isUpdateable['max'])) {
                $this->addUsingAlias(TableinfoPeer::IS_UPDATEABLE, $isUpdateable['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::IS_UPDATEABLE, $isUpdateable, $comparison);
    }

    /**
     * Filter the query on the modification_date column
     *
     * Example usage:
     * <code>
     * $query->filterByModificationDate('2011-03-14'); // WHERE modification_date = '2011-03-14'
     * $query->filterByModificationDate('now'); // WHERE modification_date = '2011-03-14'
     * $query->filterByModificationDate(array('max' => 'yesterday')); // WHERE modification_date > '2011-03-13'
     * </code>
     *
     * @param     mixed $modificationDate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function filterByModificationDate($modificationDate = null, $comparison = null)
    {
        if (is_array($modificationDate)) {
            $useMinMax = false;
            if (isset($modificationDate['min'])) {
                $this->addUsingAlias(TableinfoPeer::MODIFICATION_DATE, $modificationDate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($modificationDate['max'])) {
                $this->addUsingAlias(TableinfoPeer::MODIFICATION_DATE, $modificationDate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TableinfoPeer::MODIFICATION_DATE, $modificationDate, $comparison);
    }

    /**
     * Filter the query by a related Control object
     *
     * @param   Control|PropelObjectCollection $control  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TableinfoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByControl($control, $comparison = null)
    {
        if ($control instanceof Control) {
            return $this
                ->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $control->getTableinfoId(), $comparison);
        } elseif ($control instanceof PropelObjectCollection) {
            return $this
                ->useControlQuery()
                ->filterByPrimaryKeys($control->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByControl() only accepts arguments of type Control or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Control relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function joinControl($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Control');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Control');
        }

        return $this;
    }

    /**
     * Use the Control relation Control object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ControlQuery A secondary query class using the current class as primary query
     */
    public function useControlQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinControl($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Control', '\cli_db\propel\ControlQuery');
    }

    /**
     * Filter the query by a related Magedocumentation object
     *
     * @param   Magedocumentation|PropelObjectCollection $magedocumentation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TableinfoQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMagedocumentation($magedocumentation, $comparison = null)
    {
        if ($magedocumentation instanceof Magedocumentation) {
            return $this
                ->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $magedocumentation->getTableinfoId(), $comparison);
        } elseif ($magedocumentation instanceof PropelObjectCollection) {
            return $this
                ->useMagedocumentationQuery()
                ->filterByPrimaryKeys($magedocumentation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMagedocumentation() only accepts arguments of type Magedocumentation or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Magedocumentation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function joinMagedocumentation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Magedocumentation');

        // create a ModelJoin object for this join
        $join = new ModelJoin();
        $join->setJoinType($joinType);
        $join->setRelationMap($relationMap, $this->useAliasInSQL ? $this->getModelAlias() : null, $relationAlias);
        if ($previousJoin = $this->getPreviousJoin()) {
            $join->setPreviousJoin($previousJoin);
        }

        // add the ModelJoin to the current object
        if ($relationAlias) {
            $this->addAlias($relationAlias, $relationMap->getRightTable()->getName());
            $this->addJoinObject($join, $relationAlias);
        } else {
            $this->addJoinObject($join, 'Magedocumentation');
        }

        return $this;
    }

    /**
     * Use the Magedocumentation relation Magedocumentation object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\MagedocumentationQuery A secondary query class using the current class as primary query
     */
    public function useMagedocumentationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMagedocumentation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Magedocumentation', '\cli_db\propel\MagedocumentationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Tableinfo $tableinfo Object to remove from the list of results
     *
     * @return TableinfoQuery The current query, for fluid interface
     */
    public function prune($tableinfo = null)
    {
        if ($tableinfo) {
            $this->addUsingAlias(TableinfoPeer::TABLEINFO_ID, $tableinfo->getTableinfoId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
