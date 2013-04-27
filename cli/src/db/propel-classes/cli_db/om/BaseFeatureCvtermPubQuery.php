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
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermPub;
use cli_db\propel\FeatureCvtermPubPeer;
use cli_db\propel\FeatureCvtermPubQuery;
use cli_db\propel\Pub;

/**
 * Base class that represents a query for the 'feature_cvterm_pub' table.
 *
 *
 *
 * @method FeatureCvtermPubQuery orderByFeatureCvtermPubId($order = Criteria::ASC) Order by the feature_cvterm_pub_id column
 * @method FeatureCvtermPubQuery orderByFeatureCvtermId($order = Criteria::ASC) Order by the feature_cvterm_id column
 * @method FeatureCvtermPubQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 *
 * @method FeatureCvtermPubQuery groupByFeatureCvtermPubId() Group by the feature_cvterm_pub_id column
 * @method FeatureCvtermPubQuery groupByFeatureCvtermId() Group by the feature_cvterm_id column
 * @method FeatureCvtermPubQuery groupByPubId() Group by the pub_id column
 *
 * @method FeatureCvtermPubQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureCvtermPubQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureCvtermPubQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureCvtermPubQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermPubQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermPubQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method FeatureCvtermPubQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeatureCvtermPubQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeatureCvtermPubQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeatureCvtermPub findOne(PropelPDO $con = null) Return the first FeatureCvtermPub matching the query
 * @method FeatureCvtermPub findOneOrCreate(PropelPDO $con = null) Return the first FeatureCvtermPub matching the query, or a new FeatureCvtermPub object populated from the query conditions when no match is found
 *
 * @method FeatureCvtermPub findOneByFeatureCvtermId(int $feature_cvterm_id) Return the first FeatureCvtermPub filtered by the feature_cvterm_id column
 * @method FeatureCvtermPub findOneByPubId(int $pub_id) Return the first FeatureCvtermPub filtered by the pub_id column
 *
 * @method array findByFeatureCvtermPubId(int $feature_cvterm_pub_id) Return FeatureCvtermPub objects filtered by the feature_cvterm_pub_id column
 * @method array findByFeatureCvtermId(int $feature_cvterm_id) Return FeatureCvtermPub objects filtered by the feature_cvterm_id column
 * @method array findByPubId(int $pub_id) Return FeatureCvtermPub objects filtered by the pub_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureCvtermPubQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureCvtermPubQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureCvtermPub', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureCvtermPubQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureCvtermPubQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureCvtermPubQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureCvtermPubQuery) {
            return $criteria;
        }
        $query = new FeatureCvtermPubQuery();
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
     * @return   FeatureCvtermPub|FeatureCvtermPub[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureCvtermPubPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureCvtermPubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureCvtermPub A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureCvtermPubId($key, $con = null)
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
     * @return                 FeatureCvtermPub A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_cvterm_pub_id", "feature_cvterm_id", "pub_id" FROM "feature_cvterm_pub" WHERE "feature_cvterm_pub_id" = :p0';
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
            $obj = new FeatureCvtermPub();
            $obj->hydrate($row);
            FeatureCvtermPubPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureCvtermPub|FeatureCvtermPub[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureCvtermPub[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_cvterm_pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureCvtermPubId(1234); // WHERE feature_cvterm_pub_id = 1234
     * $query->filterByFeatureCvtermPubId(array(12, 34)); // WHERE feature_cvterm_pub_id IN (12, 34)
     * $query->filterByFeatureCvtermPubId(array('min' => 12)); // WHERE feature_cvterm_pub_id >= 12
     * $query->filterByFeatureCvtermPubId(array('max' => 12)); // WHERE feature_cvterm_pub_id <= 12
     * </code>
     *
     * @param     mixed $featureCvtermPubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermPubId($featureCvtermPubId = null, $comparison = null)
    {
        if (is_array($featureCvtermPubId)) {
            $useMinMax = false;
            if (isset($featureCvtermPubId['min'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $featureCvtermPubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermPubId['max'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $featureCvtermPubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $featureCvtermPubId, $comparison);
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
     * @see       filterByFeatureCvterm()
     *
     * @param     mixed $featureCvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermId($featureCvtermId = null, $comparison = null)
    {
        if (is_array($featureCvtermId)) {
            $useMinMax = false;
            if (isset($featureCvtermId['min'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_ID, $featureCvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermId['max'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_ID, $featureCvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_ID, $featureCvtermId, $comparison);
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
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeatureCvtermPubPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermPubPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_ID, $featureCvterm->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_ID, $featureCvterm->toKeyValue('PrimaryKey', 'FeatureCvtermId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureCvterm() only accepts arguments of type FeatureCvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function joinFeatureCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvterm');

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
            $this->addJoinObject($join, 'FeatureCvterm');
        }

        return $this;
    }

    /**
     * Use the FeatureCvterm relation FeatureCvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvterm', '\cli_db\propel\FeatureCvtermQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermPubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeatureCvtermPubPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermPubPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return FeatureCvtermPubQuery The current query, for fluid interface
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
     * @param   FeatureCvtermPub $featureCvtermPub Object to remove from the list of results
     *
     * @return FeatureCvtermPubQuery The current query, for fluid interface
     */
    public function prune($featureCvtermPub = null)
    {
        if ($featureCvtermPub) {
            $this->addUsingAlias(FeatureCvtermPubPeer::FEATURE_CVTERM_PUB_ID, $featureCvtermPub->getFeatureCvtermPubId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
