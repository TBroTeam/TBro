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
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipPub;
use cli_db\propel\FeatureRelationshipPubPeer;
use cli_db\propel\FeatureRelationshipPubQuery;
use cli_db\propel\Pub;

/**
 * Base class that represents a query for the 'feature_relationship_pub' table.
 *
 *
 *
 * @method FeatureRelationshipPubQuery orderByFeatureRelationshipPubId($order = Criteria::ASC) Order by the feature_relationship_pub_id column
 * @method FeatureRelationshipPubQuery orderByFeatureRelationshipId($order = Criteria::ASC) Order by the feature_relationship_id column
 * @method FeatureRelationshipPubQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 *
 * @method FeatureRelationshipPubQuery groupByFeatureRelationshipPubId() Group by the feature_relationship_pub_id column
 * @method FeatureRelationshipPubQuery groupByFeatureRelationshipId() Group by the feature_relationship_id column
 * @method FeatureRelationshipPubQuery groupByPubId() Group by the pub_id column
 *
 * @method FeatureRelationshipPubQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureRelationshipPubQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureRelationshipPubQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureRelationshipPubQuery leftJoinFeatureRelationship($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationship relation
 * @method FeatureRelationshipPubQuery rightJoinFeatureRelationship($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationship relation
 * @method FeatureRelationshipPubQuery innerJoinFeatureRelationship($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationship relation
 *
 * @method FeatureRelationshipPubQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeatureRelationshipPubQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeatureRelationshipPubQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeatureRelationshipPub findOne(PropelPDO $con = null) Return the first FeatureRelationshipPub matching the query
 * @method FeatureRelationshipPub findOneOrCreate(PropelPDO $con = null) Return the first FeatureRelationshipPub matching the query, or a new FeatureRelationshipPub object populated from the query conditions when no match is found
 *
 * @method FeatureRelationshipPub findOneByFeatureRelationshipId(int $feature_relationship_id) Return the first FeatureRelationshipPub filtered by the feature_relationship_id column
 * @method FeatureRelationshipPub findOneByPubId(int $pub_id) Return the first FeatureRelationshipPub filtered by the pub_id column
 *
 * @method array findByFeatureRelationshipPubId(int $feature_relationship_pub_id) Return FeatureRelationshipPub objects filtered by the feature_relationship_pub_id column
 * @method array findByFeatureRelationshipId(int $feature_relationship_id) Return FeatureRelationshipPub objects filtered by the feature_relationship_id column
 * @method array findByPubId(int $pub_id) Return FeatureRelationshipPub objects filtered by the pub_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureRelationshipPubQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureRelationshipPubQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureRelationshipPub', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureRelationshipPubQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureRelationshipPubQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureRelationshipPubQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureRelationshipPubQuery) {
            return $criteria;
        }
        $query = new FeatureRelationshipPubQuery();
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
     * @return   FeatureRelationshipPub|FeatureRelationshipPub[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureRelationshipPubPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureRelationshipPubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureRelationshipPub A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureRelationshipPubId($key, $con = null)
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
     * @return                 FeatureRelationshipPub A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_relationship_pub_id", "feature_relationship_id", "pub_id" FROM "feature_relationship_pub" WHERE "feature_relationship_pub_id" = :p0';
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
            $obj = new FeatureRelationshipPub();
            $obj->hydrate($row);
            FeatureRelationshipPubPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureRelationshipPub|FeatureRelationshipPub[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureRelationshipPub[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_relationship_pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureRelationshipPubId(1234); // WHERE feature_relationship_pub_id = 1234
     * $query->filterByFeatureRelationshipPubId(array(12, 34)); // WHERE feature_relationship_pub_id IN (12, 34)
     * $query->filterByFeatureRelationshipPubId(array('min' => 12)); // WHERE feature_relationship_pub_id >= 12
     * $query->filterByFeatureRelationshipPubId(array('max' => 12)); // WHERE feature_relationship_pub_id <= 12
     * </code>
     *
     * @param     mixed $featureRelationshipPubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function filterByFeatureRelationshipPubId($featureRelationshipPubId = null, $comparison = null)
    {
        if (is_array($featureRelationshipPubId)) {
            $useMinMax = false;
            if (isset($featureRelationshipPubId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $featureRelationshipPubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureRelationshipPubId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $featureRelationshipPubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $featureRelationshipPubId, $comparison);
    }

    /**
     * Filter the query on the feature_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureRelationshipId(1234); // WHERE feature_relationship_id = 1234
     * $query->filterByFeatureRelationshipId(array(12, 34)); // WHERE feature_relationship_id IN (12, 34)
     * $query->filterByFeatureRelationshipId(array('min' => 12)); // WHERE feature_relationship_id >= 12
     * $query->filterByFeatureRelationshipId(array('max' => 12)); // WHERE feature_relationship_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelationship()
     *
     * @param     mixed $featureRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function filterByFeatureRelationshipId($featureRelationshipId = null, $comparison = null)
    {
        if (is_array($featureRelationshipId)) {
            $useMinMax = false;
            if (isset($featureRelationshipId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureRelationshipId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId, $comparison);
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
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPubPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPubPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query by a related FeatureRelationship object
     *
     * @param   FeatureRelationship|PropelObjectCollection $featureRelationship The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationship($featureRelationship, $comparison = null)
    {
        if ($featureRelationship instanceof FeatureRelationship) {
            return $this
                ->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_ID, $featureRelationship->getFeatureRelationshipId(), $comparison);
        } elseif ($featureRelationship instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_ID, $featureRelationship->toKeyValue('PrimaryKey', 'FeatureRelationshipId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelationship() only accepts arguments of type FeatureRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationship relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function joinFeatureRelationship($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationship');

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
            $this->addJoinObject($join, 'FeatureRelationship');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationship relation FeatureRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshipQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationship($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationship', '\cli_db\propel\FeatureRelationshipQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeatureRelationshipPubPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshipPubPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
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
     * @param   FeatureRelationshipPub $featureRelationshipPub Object to remove from the list of results
     *
     * @return FeatureRelationshipPubQuery The current query, for fluid interface
     */
    public function prune($featureRelationshipPub = null)
    {
        if ($featureRelationshipPub) {
            $this->addUsingAlias(FeatureRelationshipPubPeer::FEATURE_RELATIONSHIP_PUB_ID, $featureRelationshipPub->getFeatureRelationshipPubId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
