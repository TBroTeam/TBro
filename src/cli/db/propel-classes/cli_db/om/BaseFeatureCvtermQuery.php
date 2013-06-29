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
use cli_db\propel\Cvterm;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureCvtermPeer;
use cli_db\propel\FeatureCvtermPub;
use cli_db\propel\FeatureCvtermQuery;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\Pub;

/**
 * Base class that represents a query for the 'feature_cvterm' table.
 *
 *
 *
 * @method FeatureCvtermQuery orderByFeatureCvtermId($order = Criteria::ASC) Order by the feature_cvterm_id column
 * @method FeatureCvtermQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method FeatureCvtermQuery orderByCvtermId($order = Criteria::ASC) Order by the cvterm_id column
 * @method FeatureCvtermQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method FeatureCvtermQuery orderByIsNot($order = Criteria::ASC) Order by the is_not column
 * @method FeatureCvtermQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method FeatureCvtermQuery groupByFeatureCvtermId() Group by the feature_cvterm_id column
 * @method FeatureCvtermQuery groupByFeatureId() Group by the feature_id column
 * @method FeatureCvtermQuery groupByCvtermId() Group by the cvterm_id column
 * @method FeatureCvtermQuery groupByPubId() Group by the pub_id column
 * @method FeatureCvtermQuery groupByIsNot() Group by the is_not column
 * @method FeatureCvtermQuery groupByRank() Group by the rank column
 *
 * @method FeatureCvtermQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureCvtermQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureCvtermQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureCvtermQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method FeatureCvtermQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method FeatureCvtermQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method FeatureCvtermQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method FeatureCvtermQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method FeatureCvtermQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method FeatureCvtermQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeatureCvtermQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeatureCvtermQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeatureCvtermQuery leftJoinFeatureCvtermDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermDbxref relation
 * @method FeatureCvtermQuery rightJoinFeatureCvtermDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermDbxref relation
 * @method FeatureCvtermQuery innerJoinFeatureCvtermDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermDbxref relation
 *
 * @method FeatureCvtermQuery leftJoinFeatureCvtermPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermPub relation
 * @method FeatureCvtermQuery rightJoinFeatureCvtermPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermPub relation
 * @method FeatureCvtermQuery innerJoinFeatureCvtermPub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermPub relation
 *
 * @method FeatureCvtermQuery leftJoinFeatureCvtermprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermprop relation
 * @method FeatureCvtermQuery rightJoinFeatureCvtermprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermprop relation
 * @method FeatureCvtermQuery innerJoinFeatureCvtermprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermprop relation
 *
 * @method FeatureCvterm findOne(PropelPDO $con = null) Return the first FeatureCvterm matching the query
 * @method FeatureCvterm findOneOrCreate(PropelPDO $con = null) Return the first FeatureCvterm matching the query, or a new FeatureCvterm object populated from the query conditions when no match is found
 *
 * @method FeatureCvterm findOneByFeatureId(int $feature_id) Return the first FeatureCvterm filtered by the feature_id column
 * @method FeatureCvterm findOneByCvtermId(int $cvterm_id) Return the first FeatureCvterm filtered by the cvterm_id column
 * @method FeatureCvterm findOneByPubId(int $pub_id) Return the first FeatureCvterm filtered by the pub_id column
 * @method FeatureCvterm findOneByIsNot(boolean $is_not) Return the first FeatureCvterm filtered by the is_not column
 * @method FeatureCvterm findOneByRank(int $rank) Return the first FeatureCvterm filtered by the rank column
 *
 * @method array findByFeatureCvtermId(int $feature_cvterm_id) Return FeatureCvterm objects filtered by the feature_cvterm_id column
 * @method array findByFeatureId(int $feature_id) Return FeatureCvterm objects filtered by the feature_id column
 * @method array findByCvtermId(int $cvterm_id) Return FeatureCvterm objects filtered by the cvterm_id column
 * @method array findByPubId(int $pub_id) Return FeatureCvterm objects filtered by the pub_id column
 * @method array findByIsNot(boolean $is_not) Return FeatureCvterm objects filtered by the is_not column
 * @method array findByRank(int $rank) Return FeatureCvterm objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureCvtermQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureCvtermQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureCvterm', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureCvtermQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureCvtermQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureCvtermQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureCvtermQuery) {
            return $criteria;
        }
        $query = new FeatureCvtermQuery();
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
     * @return   FeatureCvterm|FeatureCvterm[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureCvtermPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureCvtermPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureCvterm A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureCvtermId($key, $con = null)
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
     * @return                 FeatureCvterm A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_cvterm_id", "feature_id", "cvterm_id", "pub_id", "is_not", "rank" FROM "feature_cvterm" WHERE "feature_cvterm_id" = :p0';
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
            $obj = new FeatureCvterm();
            $obj->hydrate($row);
            FeatureCvtermPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureCvterm|FeatureCvterm[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureCvterm[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureCvtermId(1234); // WHERE feature_cvterm_id = 1234
     * $query->filterByFeatureCvtermId(array(12, 34)); // WHERE feature_cvterm_id IN (12, 34)
     * $query->filterByFeatureCvtermId(array('min' => 12)); // WHERE feature_cvterm_id >= 12
     * $query->filterByFeatureCvtermId(array('max' => 12)); // WHERE feature_cvterm_id <= 12
     * </code>
     *
     * @param     mixed $featureCvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermId($featureCvtermId = null, $comparison = null)
    {
        if (is_array($featureCvtermId)) {
            $useMinMax = false;
            if (isset($featureCvtermId['min'])) {
                $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermId['max'])) {
                $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermId, $comparison);
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
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(FeatureCvtermPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(FeatureCvtermPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPeer::FEATURE_ID, $featureId, $comparison);
    }

    /**
     * Filter the query on the cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermId(1234); // WHERE cvterm_id = 1234
     * $query->filterByCvtermId(array(12, 34)); // WHERE cvterm_id IN (12, 34)
     * $query->filterByCvtermId(array('min' => 12)); // WHERE cvterm_id >= 12
     * $query->filterByCvtermId(array('max' => 12)); // WHERE cvterm_id <= 12
     * </code>
     *
     * @see       filterByCvterm()
     *
     * @param     mixed $cvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByCvtermId($cvtermId = null, $comparison = null)
    {
        if (is_array($cvtermId)) {
            $useMinMax = false;
            if (isset($cvtermId['min'])) {
                $this->addUsingAlias(FeatureCvtermPeer::CVTERM_ID, $cvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermId['max'])) {
                $this->addUsingAlias(FeatureCvtermPeer::CVTERM_ID, $cvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPeer::CVTERM_ID, $cvtermId, $comparison);
    }

    /**
     * Filter the query on the pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPubId(1234); // WHERE pub_id = 1234
     * $query->filterByPubId(array(12, 34)); // WHERE pub_id IN (12, 34)
     * $query->filterByPubId(array('min' => 12)); // WHERE pub_id >= 12
     * $query->filterByPubId(array('max' => 12)); // WHERE pub_id <= 12
     * </code>
     *
     * @see       filterByPub()
     *
     * @param     mixed $pubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeatureCvtermPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeatureCvtermPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query on the is_not column
     *
     * Example usage:
     * <code>
     * $query->filterByIsNot(true); // WHERE is_not = true
     * $query->filterByIsNot('yes'); // WHERE is_not = true
     * </code>
     *
     * @param     boolean|string $isNot The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByIsNot($isNot = null, $comparison = null)
    {
        if (is_string($isNot)) {
            $isNot = in_array(strtolower($isNot), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeatureCvtermPeer::IS_NOT, $isNot, $comparison);
    }

    /**
     * Filter the query on the rank column
     *
     * Example usage:
     * <code>
     * $query->filterByRank(1234); // WHERE rank = 1234
     * $query->filterByRank(array(12, 34)); // WHERE rank IN (12, 34)
     * $query->filterByRank(array('min' => 12)); // WHERE rank >= 12
     * $query->filterByRank(array('max' => 12)); // WHERE rank <= 12
     * </code>
     *
     * @param     mixed $rank The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(FeatureCvtermPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(FeatureCvtermPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::CVTERM_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermPeer::CVTERM_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvterm() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Cvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function joinCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Cvterm');

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
            $this->addJoinObject($join, 'Cvterm');
        }

        return $this;
    }

    /**
     * Use the Cvterm relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cvterm', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
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
     * @return FeatureCvtermQuery The current query, for fluid interface
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
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
        } else {
            throw new PropelException('filterByPub() only accepts arguments of type Pub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pub');

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
            $this->addJoinObject($join, 'Pub');
        }

        return $this;
    }

    /**
     * Use the Pub relation Pub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubQuery A secondary query class using the current class as primary query
     */
    public function usePubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermDbxref object
     *
     * @param   FeatureCvtermDbxref|PropelObjectCollection $featureCvtermDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermDbxref($featureCvtermDbxref, $comparison = null)
    {
        if ($featureCvtermDbxref instanceof FeatureCvtermDbxref) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermDbxref->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvtermDbxref instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermDbxrefQuery()
                ->filterByPrimaryKeys($featureCvtermDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermDbxref() only accepts arguments of type FeatureCvtermDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermDbxref');

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
            $this->addJoinObject($join, 'FeatureCvtermDbxref');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermDbxref relation FeatureCvtermDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermDbxrefQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermDbxref', '\cli_db\propel\FeatureCvtermDbxrefQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermPub object
     *
     * @param   FeatureCvtermPub|PropelObjectCollection $featureCvtermPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermPub($featureCvtermPub, $comparison = null)
    {
        if ($featureCvtermPub instanceof FeatureCvtermPub) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermPub->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvtermPub instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermPubQuery()
                ->filterByPrimaryKeys($featureCvtermPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermPub() only accepts arguments of type FeatureCvtermPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermPub');

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
            $this->addJoinObject($join, 'FeatureCvtermPub');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermPub relation FeatureCvtermPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermPubQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermPub', '\cli_db\propel\FeatureCvtermPubQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermprop object
     *
     * @param   FeatureCvtermprop|PropelObjectCollection $featureCvtermprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermprop($featureCvtermprop, $comparison = null)
    {
        if ($featureCvtermprop instanceof FeatureCvtermprop) {
            return $this
                ->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvtermprop->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvtermprop instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermpropQuery()
                ->filterByPrimaryKeys($featureCvtermprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermprop() only accepts arguments of type FeatureCvtermprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermprop');

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
            $this->addJoinObject($join, 'FeatureCvtermprop');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermprop relation FeatureCvtermprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermpropQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermprop', '\cli_db\propel\FeatureCvtermpropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureCvterm $featureCvterm Object to remove from the list of results
     *
     * @return FeatureCvtermQuery The current query, for fluid interface
     */
    public function prune($featureCvterm = null)
    {
        if ($featureCvterm) {
            $this->addUsingAlias(FeatureCvtermPeer::FEATURE_CVTERM_ID, $featureCvterm->getFeatureCvtermId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
