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
use cli_db\propel\Pub;
use cli_db\propel\Pubprop;
use cli_db\propel\PubpropPeer;
use cli_db\propel\PubpropQuery;

/**
 * Base class that represents a query for the 'pubprop' table.
 *
 *
 *
 * @method PubpropQuery orderByPubpropId($order = Criteria::ASC) Order by the pubprop_id column
 * @method PubpropQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method PubpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method PubpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method PubpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method PubpropQuery groupByPubpropId() Group by the pubprop_id column
 * @method PubpropQuery groupByPubId() Group by the pub_id column
 * @method PubpropQuery groupByTypeId() Group by the type_id column
 * @method PubpropQuery groupByValue() Group by the value column
 * @method PubpropQuery groupByRank() Group by the rank column
 *
 * @method PubpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PubpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PubpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PubpropQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method PubpropQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method PubpropQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method PubpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method PubpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method PubpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Pubprop findOne(PropelPDO $con = null) Return the first Pubprop matching the query
 * @method Pubprop findOneOrCreate(PropelPDO $con = null) Return the first Pubprop matching the query, or a new Pubprop object populated from the query conditions when no match is found
 *
 * @method Pubprop findOneByPubId(int $pub_id) Return the first Pubprop filtered by the pub_id column
 * @method Pubprop findOneByTypeId(int $type_id) Return the first Pubprop filtered by the type_id column
 * @method Pubprop findOneByValue(string $value) Return the first Pubprop filtered by the value column
 * @method Pubprop findOneByRank(int $rank) Return the first Pubprop filtered by the rank column
 *
 * @method array findByPubpropId(int $pubprop_id) Return Pubprop objects filtered by the pubprop_id column
 * @method array findByPubId(int $pub_id) Return Pubprop objects filtered by the pub_id column
 * @method array findByTypeId(int $type_id) Return Pubprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Pubprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Pubprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BasePubpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePubpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Pubprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PubpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PubpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PubpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PubpropQuery) {
            return $criteria;
        }
        $query = new PubpropQuery();
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
     * @return   Pubprop|Pubprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PubpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PubpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Pubprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByPubpropId($key, $con = null)
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
     * @return                 Pubprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "pubprop_id", "pub_id", "type_id", "value", "rank" FROM "pubprop" WHERE "pubprop_id" = :p0';
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
            $obj = new Pubprop();
            $obj->hydrate($row);
            PubpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Pubprop|Pubprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Pubprop[]|mixed the list of results, formatted by the current formatter
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
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the pubprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPubpropId(1234); // WHERE pubprop_id = 1234
     * $query->filterByPubpropId(array(12, 34)); // WHERE pubprop_id IN (12, 34)
     * $query->filterByPubpropId(array('min' => 12)); // WHERE pubprop_id >= 12
     * $query->filterByPubpropId(array('max' => 12)); // WHERE pubprop_id <= 12
     * </code>
     *
     * @param     mixed $pubpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByPubpropId($pubpropId = null, $comparison = null)
    {
        if (is_array($pubpropId)) {
            $useMinMax = false;
            if (isset($pubpropId['min'])) {
                $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $pubpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubpropId['max'])) {
                $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $pubpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $pubpropId, $comparison);
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
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(PubpropPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(PubpropPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubpropPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query on the type_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTypeId(1234); // WHERE type_id = 1234
     * $query->filterByTypeId(array(12, 34)); // WHERE type_id IN (12, 34)
     * $query->filterByTypeId(array('min' => 12)); // WHERE type_id >= 12
     * $query->filterByTypeId(array('max' => 12)); // WHERE type_id <= 12
     * </code>
     *
     * @see       filterByCvterm()
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(PubpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(PubpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubpropPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue('fooValue');   // WHERE value = 'fooValue'
     * $query->filterByValue('%fooValue%'); // WHERE value LIKE '%fooValue%'
     * </code>
     *
     * @param     string $value The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($value)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $value)) {
                $value = str_replace('*', '%', $value);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubpropPeer::VALUE, $value, $comparison);
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
     * @return PubpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(PubpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(PubpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(PubpropPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PubpropPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return PubpropQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(PubpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PubpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return PubpropQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Pubprop $pubprop Object to remove from the list of results
     *
     * @return PubpropQuery The current query, for fluid interface
     */
    public function prune($pubprop = null)
    {
        if ($pubprop) {
            $this->addUsingAlias(PubpropPeer::PUBPROP_ID, $pubprop->getPubpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
