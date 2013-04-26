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
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocPub;
use cli_db\propel\FeaturelocPubPeer;
use cli_db\propel\FeaturelocPubQuery;
use cli_db\propel\Pub;

/**
 * Base class that represents a query for the 'featureloc_pub' table.
 *
 *
 *
 * @method FeaturelocPubQuery orderByFeaturelocPubId($order = Criteria::ASC) Order by the featureloc_pub_id column
 * @method FeaturelocPubQuery orderByFeaturelocId($order = Criteria::ASC) Order by the featureloc_id column
 * @method FeaturelocPubQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 *
 * @method FeaturelocPubQuery groupByFeaturelocPubId() Group by the featureloc_pub_id column
 * @method FeaturelocPubQuery groupByFeaturelocId() Group by the featureloc_id column
 * @method FeaturelocPubQuery groupByPubId() Group by the pub_id column
 *
 * @method FeaturelocPubQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeaturelocPubQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeaturelocPubQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeaturelocPubQuery leftJoinFeatureloc($relationAlias = null) Adds a LEFT JOIN clause to the query using the Featureloc relation
 * @method FeaturelocPubQuery rightJoinFeatureloc($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Featureloc relation
 * @method FeaturelocPubQuery innerJoinFeatureloc($relationAlias = null) Adds a INNER JOIN clause to the query using the Featureloc relation
 *
 * @method FeaturelocPubQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeaturelocPubQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeaturelocPubQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeaturelocPub findOne(PropelPDO $con = null) Return the first FeaturelocPub matching the query
 * @method FeaturelocPub findOneOrCreate(PropelPDO $con = null) Return the first FeaturelocPub matching the query, or a new FeaturelocPub object populated from the query conditions when no match is found
 *
 * @method FeaturelocPub findOneByFeaturelocId(int $featureloc_id) Return the first FeaturelocPub filtered by the featureloc_id column
 * @method FeaturelocPub findOneByPubId(int $pub_id) Return the first FeaturelocPub filtered by the pub_id column
 *
 * @method array findByFeaturelocPubId(int $featureloc_pub_id) Return FeaturelocPub objects filtered by the featureloc_pub_id column
 * @method array findByFeaturelocId(int $featureloc_id) Return FeaturelocPub objects filtered by the featureloc_id column
 * @method array findByPubId(int $pub_id) Return FeaturelocPub objects filtered by the pub_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeaturelocPubQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeaturelocPubQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeaturelocPub', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeaturelocPubQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeaturelocPubQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeaturelocPubQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeaturelocPubQuery) {
            return $criteria;
        }
        $query = new FeaturelocPubQuery();
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
     * @return   FeaturelocPub|FeaturelocPub[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeaturelocPubPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeaturelocPub A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeaturelocPubId($key, $con = null)
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
     * @return                 FeaturelocPub A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "featureloc_pub_id", "featureloc_id", "pub_id" FROM "featureloc_pub" WHERE "featureloc_pub_id" = :p0';
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
            $obj = new FeaturelocPub();
            $obj->hydrate($row);
            FeaturelocPubPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeaturelocPub|FeaturelocPub[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeaturelocPub[]|mixed the list of results, formatted by the current formatter
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
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the featureloc_pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeaturelocPubId(1234); // WHERE featureloc_pub_id = 1234
     * $query->filterByFeaturelocPubId(array(12, 34)); // WHERE featureloc_pub_id IN (12, 34)
     * $query->filterByFeaturelocPubId(array('min' => 12)); // WHERE featureloc_pub_id >= 12
     * $query->filterByFeaturelocPubId(array('max' => 12)); // WHERE featureloc_pub_id <= 12
     * </code>
     *
     * @param     mixed $featurelocPubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function filterByFeaturelocPubId($featurelocPubId = null, $comparison = null)
    {
        if (is_array($featurelocPubId)) {
            $useMinMax = false;
            if (isset($featurelocPubId['min'])) {
                $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $featurelocPubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featurelocPubId['max'])) {
                $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $featurelocPubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $featurelocPubId, $comparison);
    }

    /**
     * Filter the query on the featureloc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeaturelocId(1234); // WHERE featureloc_id = 1234
     * $query->filterByFeaturelocId(array(12, 34)); // WHERE featureloc_id IN (12, 34)
     * $query->filterByFeaturelocId(array('min' => 12)); // WHERE featureloc_id >= 12
     * $query->filterByFeaturelocId(array('max' => 12)); // WHERE featureloc_id <= 12
     * </code>
     *
     * @see       filterByFeatureloc()
     *
     * @param     mixed $featurelocId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function filterByFeaturelocId($featurelocId = null, $comparison = null)
    {
        if (is_array($featurelocId)) {
            $useMinMax = false;
            if (isset($featurelocId['min'])) {
                $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_ID, $featurelocId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featurelocId['max'])) {
                $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_ID, $featurelocId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_ID, $featurelocId, $comparison);
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
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeaturelocPubPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeaturelocPubPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPubPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query by a related Featureloc object
     *
     * @param   Featureloc|PropelObjectCollection $featureloc The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturelocPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureloc($featureloc, $comparison = null)
    {
        if ($featureloc instanceof Featureloc) {
            return $this
                ->addUsingAlias(FeaturelocPubPeer::FEATURELOC_ID, $featureloc->getFeaturelocId(), $comparison);
        } elseif ($featureloc instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturelocPubPeer::FEATURELOC_ID, $featureloc->toKeyValue('PrimaryKey', 'FeaturelocId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureloc() only accepts arguments of type Featureloc or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Featureloc relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function joinFeatureloc($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Featureloc');

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
            $this->addJoinObject($join, 'Featureloc');
        }

        return $this;
    }

    /**
     * Use the Featureloc relation Featureloc object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturelocQuery A secondary query class using the current class as primary query
     */
    public function useFeaturelocQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureloc($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Featureloc', '\cli_db\propel\FeaturelocQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturelocPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeaturelocPubPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturelocPubPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return FeaturelocPubQuery The current query, for fluid interface
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
     * @param   FeaturelocPub $featurelocPub Object to remove from the list of results
     *
     * @return FeaturelocPubQuery The current query, for fluid interface
     */
    public function prune($featurelocPub = null)
    {
        if ($featurelocPub) {
            $this->addUsingAlias(FeaturelocPubPeer::FEATURELOC_PUB_ID, $featurelocPub->getFeaturelocPubId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
