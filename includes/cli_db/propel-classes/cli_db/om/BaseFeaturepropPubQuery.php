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
use cli_db\propel\Featureprop;
use cli_db\propel\FeaturepropPub;
use cli_db\propel\FeaturepropPubPeer;
use cli_db\propel\FeaturepropPubQuery;
use cli_db\propel\Pub;

/**
 * Base class that represents a query for the 'featureprop_pub' table.
 *
 *
 *
 * @method FeaturepropPubQuery orderByFeaturepropPubId($order = Criteria::ASC) Order by the featureprop_pub_id column
 * @method FeaturepropPubQuery orderByFeaturepropId($order = Criteria::ASC) Order by the featureprop_id column
 * @method FeaturepropPubQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 *
 * @method FeaturepropPubQuery groupByFeaturepropPubId() Group by the featureprop_pub_id column
 * @method FeaturepropPubQuery groupByFeaturepropId() Group by the featureprop_id column
 * @method FeaturepropPubQuery groupByPubId() Group by the pub_id column
 *
 * @method FeaturepropPubQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeaturepropPubQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeaturepropPubQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeaturepropPubQuery leftJoinFeatureprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Featureprop relation
 * @method FeaturepropPubQuery rightJoinFeatureprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Featureprop relation
 * @method FeaturepropPubQuery innerJoinFeatureprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Featureprop relation
 *
 * @method FeaturepropPubQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeaturepropPubQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeaturepropPubQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeaturepropPub findOne(PropelPDO $con = null) Return the first FeaturepropPub matching the query
 * @method FeaturepropPub findOneOrCreate(PropelPDO $con = null) Return the first FeaturepropPub matching the query, or a new FeaturepropPub object populated from the query conditions when no match is found
 *
 * @method FeaturepropPub findOneByFeaturepropId(int $featureprop_id) Return the first FeaturepropPub filtered by the featureprop_id column
 * @method FeaturepropPub findOneByPubId(int $pub_id) Return the first FeaturepropPub filtered by the pub_id column
 *
 * @method array findByFeaturepropPubId(int $featureprop_pub_id) Return FeaturepropPub objects filtered by the featureprop_pub_id column
 * @method array findByFeaturepropId(int $featureprop_id) Return FeaturepropPub objects filtered by the featureprop_id column
 * @method array findByPubId(int $pub_id) Return FeaturepropPub objects filtered by the pub_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeaturepropPubQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeaturepropPubQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeaturepropPub', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeaturepropPubQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeaturepropPubQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeaturepropPubQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeaturepropPubQuery) {
            return $criteria;
        }
        $query = new FeaturepropPubQuery();
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
     * @return   FeaturepropPub|FeaturepropPub[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeaturepropPubPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeaturepropPubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeaturepropPub A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeaturepropPubId($key, $con = null)
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
     * @return                 FeaturepropPub A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "featureprop_pub_id", "featureprop_id", "pub_id" FROM "featureprop_pub" WHERE "featureprop_pub_id" = :p0';
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
            $obj = new FeaturepropPub();
            $obj->hydrate($row);
            FeaturepropPubPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeaturepropPub|FeaturepropPub[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeaturepropPub[]|mixed the list of results, formatted by the current formatter
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
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the featureprop_pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeaturepropPubId(1234); // WHERE featureprop_pub_id = 1234
     * $query->filterByFeaturepropPubId(array(12, 34)); // WHERE featureprop_pub_id IN (12, 34)
     * $query->filterByFeaturepropPubId(array('min' => 12)); // WHERE featureprop_pub_id >= 12
     * $query->filterByFeaturepropPubId(array('max' => 12)); // WHERE featureprop_pub_id <= 12
     * </code>
     *
     * @param     mixed $featurepropPubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function filterByFeaturepropPubId($featurepropPubId = null, $comparison = null)
    {
        if (is_array($featurepropPubId)) {
            $useMinMax = false;
            if (isset($featurepropPubId['min'])) {
                $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $featurepropPubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featurepropPubId['max'])) {
                $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $featurepropPubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $featurepropPubId, $comparison);
    }

    /**
     * Filter the query on the featureprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeaturepropId(1234); // WHERE featureprop_id = 1234
     * $query->filterByFeaturepropId(array(12, 34)); // WHERE featureprop_id IN (12, 34)
     * $query->filterByFeaturepropId(array('min' => 12)); // WHERE featureprop_id >= 12
     * $query->filterByFeaturepropId(array('max' => 12)); // WHERE featureprop_id <= 12
     * </code>
     *
     * @see       filterByFeatureprop()
     *
     * @param     mixed $featurepropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function filterByFeaturepropId($featurepropId = null, $comparison = null)
    {
        if (is_array($featurepropId)) {
            $useMinMax = false;
            if (isset($featurepropId['min'])) {
                $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_ID, $featurepropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featurepropId['max'])) {
                $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_ID, $featurepropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_ID, $featurepropId, $comparison);
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
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeaturepropPubPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeaturepropPubPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturepropPubPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query by a related Featureprop object
     *
     * @param   Featureprop|PropelObjectCollection $featureprop The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturepropPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureprop($featureprop, $comparison = null)
    {
        if ($featureprop instanceof Featureprop) {
            return $this
                ->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_ID, $featureprop->getFeaturepropId(), $comparison);
        } elseif ($featureprop instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_ID, $featureprop->toKeyValue('PrimaryKey', 'FeaturepropId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureprop() only accepts arguments of type Featureprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Featureprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function joinFeatureprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Featureprop');

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
            $this->addJoinObject($join, 'Featureprop');
        }

        return $this;
    }

    /**
     * Use the Featureprop relation Featureprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturepropQuery A secondary query class using the current class as primary query
     */
    public function useFeaturepropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Featureprop', '\cli_db\propel\FeaturepropQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturepropPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeaturepropPubPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturepropPubPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return FeaturepropPubQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   FeaturepropPub $featurepropPub Object to remove from the list of results
     *
     * @return FeaturepropPubQuery The current query, for fluid interface
     */
    public function prune($featurepropPub = null)
    {
        if ($featurepropPub) {
            $this->addUsingAlias(FeaturepropPubPeer::FEATUREPROP_PUB_ID, $featurepropPub->getFeaturepropPubId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
