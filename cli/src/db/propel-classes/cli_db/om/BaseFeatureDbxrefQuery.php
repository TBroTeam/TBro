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
use cli_db\propel\Dbxref;
use cli_db\propel\Feature;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\FeatureDbxrefPeer;
use cli_db\propel\FeatureDbxrefQuery;

/**
 * Base class that represents a query for the 'feature_dbxref' table.
 *
 *
 *
 * @method FeatureDbxrefQuery orderByFeatureDbxrefId($order = Criteria::ASC) Order by the feature_dbxref_id column
 * @method FeatureDbxrefQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method FeatureDbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method FeatureDbxrefQuery orderByIsCurrent($order = Criteria::ASC) Order by the is_current column
 *
 * @method FeatureDbxrefQuery groupByFeatureDbxrefId() Group by the feature_dbxref_id column
 * @method FeatureDbxrefQuery groupByFeatureId() Group by the feature_id column
 * @method FeatureDbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 * @method FeatureDbxrefQuery groupByIsCurrent() Group by the is_current column
 *
 * @method FeatureDbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureDbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureDbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureDbxrefQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method FeatureDbxrefQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method FeatureDbxrefQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method FeatureDbxrefQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method FeatureDbxrefQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method FeatureDbxrefQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method FeatureDbxref findOne(PropelPDO $con = null) Return the first FeatureDbxref matching the query
 * @method FeatureDbxref findOneOrCreate(PropelPDO $con = null) Return the first FeatureDbxref matching the query, or a new FeatureDbxref object populated from the query conditions when no match is found
 *
 * @method FeatureDbxref findOneByFeatureId(int $feature_id) Return the first FeatureDbxref filtered by the feature_id column
 * @method FeatureDbxref findOneByDbxrefId(int $dbxref_id) Return the first FeatureDbxref filtered by the dbxref_id column
 * @method FeatureDbxref findOneByIsCurrent(boolean $is_current) Return the first FeatureDbxref filtered by the is_current column
 *
 * @method array findByFeatureDbxrefId(int $feature_dbxref_id) Return FeatureDbxref objects filtered by the feature_dbxref_id column
 * @method array findByFeatureId(int $feature_id) Return FeatureDbxref objects filtered by the feature_id column
 * @method array findByDbxrefId(int $dbxref_id) Return FeatureDbxref objects filtered by the dbxref_id column
 * @method array findByIsCurrent(boolean $is_current) Return FeatureDbxref objects filtered by the is_current column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureDbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureDbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureDbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureDbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureDbxrefQuery) {
            return $criteria;
        }
        $query = new FeatureDbxrefQuery();
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
     * @return   FeatureDbxref|FeatureDbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureDbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureDbxrefId($key, $con = null)
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
     * @return                 FeatureDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_dbxref_id", "feature_id", "dbxref_id", "is_current" FROM "feature_dbxref" WHERE "feature_dbxref_id" = :p0';
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
            $obj = new FeatureDbxref();
            $obj->hydrate($row);
            FeatureDbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureDbxref|FeatureDbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureDbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureDbxrefId(1234); // WHERE feature_dbxref_id = 1234
     * $query->filterByFeatureDbxrefId(array(12, 34)); // WHERE feature_dbxref_id IN (12, 34)
     * $query->filterByFeatureDbxrefId(array('min' => 12)); // WHERE feature_dbxref_id >= 12
     * $query->filterByFeatureDbxrefId(array('max' => 12)); // WHERE feature_dbxref_id <= 12
     * </code>
     *
     * @param     mixed $featureDbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByFeatureDbxrefId($featureDbxrefId = null, $comparison = null)
    {
        if (is_array($featureDbxrefId)) {
            $useMinMax = false;
            if (isset($featureDbxrefId['min'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $featureDbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureDbxrefId['max'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $featureDbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $featureDbxrefId, $comparison);
    }

    /**
     * Filter the query on the feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureId(1234); // WHERE feature_id = 1234
     * $query->filterByFeatureId(array(12, 34)); // WHERE feature_id IN (12, 34)
     * $query->filterByFeatureId(array('min' => 12)); // WHERE feature_id >= 12
     * $query->filterByFeatureId(array('max' => 12)); // WHERE feature_id <= 12
     * </code>
     *
     * @see       filterByFeature()
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_ID, $featureId, $comparison);
    }

    /**
     * Filter the query on the dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDbxrefId(1234); // WHERE dbxref_id = 1234
     * $query->filterByDbxrefId(array(12, 34)); // WHERE dbxref_id IN (12, 34)
     * $query->filterByDbxrefId(array('min' => 12)); // WHERE dbxref_id >= 12
     * $query->filterByDbxrefId(array('max' => 12)); // WHERE dbxref_id <= 12
     * </code>
     *
     * @see       filterByDbxref()
     *
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(FeatureDbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureDbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query on the is_current column
     *
     * Example usage:
     * <code>
     * $query->filterByIsCurrent(true); // WHERE is_current = true
     * $query->filterByIsCurrent('yes'); // WHERE is_current = true
     * </code>
     *
     * @param     boolean|string $isCurrent The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function filterByIsCurrent($isCurrent = null, $comparison = null)
    {
        if (is_string($isCurrent)) {
            $isCurrent = in_array(strtolower($isCurrent), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeatureDbxrefPeer::IS_CURRENT, $isCurrent, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(FeatureDbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureDbxrefPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
        } else {
            throw new PropelException('filterByDbxref() only accepts arguments of type Dbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Dbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Dbxref');

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
            $this->addJoinObject($join, 'Dbxref');
        }

        return $this;
    }

    /**
     * Use the Dbxref relation Dbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbxrefQuery A secondary query class using the current class as primary query
     */
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeatureDbxrefPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureDbxrefPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

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
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureDbxref $featureDbxref Object to remove from the list of results
     *
     * @return FeatureDbxrefQuery The current query, for fluid interface
     */
    public function prune($featureDbxref = null)
    {
        if ($featureDbxref) {
            $this->addUsingAlias(FeatureDbxrefPeer::FEATURE_DBXREF_ID, $featureDbxref->getFeatureDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
