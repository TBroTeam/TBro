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
use cli_db\propel\Expressionresult;
use cli_db\propel\ExpressionresultQuantificationresult;
use cli_db\propel\ExpressionresultQuantificationresultPeer;
use cli_db\propel\ExpressionresultQuantificationresultQuery;
use cli_db\propel\Quantificationresult;

/**
 * Base class that represents a query for the 'expressionresult_quantificationresult' table.
 *
 *
 *
 * @method ExpressionresultQuantificationresultQuery orderById($order = Criteria::ASC) Order by the id column
 * @method ExpressionresultQuantificationresultQuery orderByExpressionresultId($order = Criteria::ASC) Order by the expressionresult_id column
 * @method ExpressionresultQuantificationresultQuery orderByQuantificationresultId($order = Criteria::ASC) Order by the quantificationresult_id column
 * @method ExpressionresultQuantificationresultQuery orderBySamplegroup($order = Criteria::ASC) Order by the samplegroup column
 *
 * @method ExpressionresultQuantificationresultQuery groupById() Group by the id column
 * @method ExpressionresultQuantificationresultQuery groupByExpressionresultId() Group by the expressionresult_id column
 * @method ExpressionresultQuantificationresultQuery groupByQuantificationresultId() Group by the quantificationresult_id column
 * @method ExpressionresultQuantificationresultQuery groupBySamplegroup() Group by the samplegroup column
 *
 * @method ExpressionresultQuantificationresultQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ExpressionresultQuantificationresultQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ExpressionresultQuantificationresultQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ExpressionresultQuantificationresultQuery leftJoinExpressionresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the Expressionresult relation
 * @method ExpressionresultQuantificationresultQuery rightJoinExpressionresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Expressionresult relation
 * @method ExpressionresultQuantificationresultQuery innerJoinExpressionresult($relationAlias = null) Adds a INNER JOIN clause to the query using the Expressionresult relation
 *
 * @method ExpressionresultQuantificationresultQuery leftJoinQuantificationresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantificationresult relation
 * @method ExpressionresultQuantificationresultQuery rightJoinQuantificationresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantificationresult relation
 * @method ExpressionresultQuantificationresultQuery innerJoinQuantificationresult($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantificationresult relation
 *
 * @method ExpressionresultQuantificationresult findOne(PropelPDO $con = null) Return the first ExpressionresultQuantificationresult matching the query
 * @method ExpressionresultQuantificationresult findOneOrCreate(PropelPDO $con = null) Return the first ExpressionresultQuantificationresult matching the query, or a new ExpressionresultQuantificationresult object populated from the query conditions when no match is found
 *
 * @method ExpressionresultQuantificationresult findOneByExpressionresultId(int $expressionresult_id) Return the first ExpressionresultQuantificationresult filtered by the expressionresult_id column
 * @method ExpressionresultQuantificationresult findOneByQuantificationresultId(int $quantificationresult_id) Return the first ExpressionresultQuantificationresult filtered by the quantificationresult_id column
 * @method ExpressionresultQuantificationresult findOneBySamplegroup(string $samplegroup) Return the first ExpressionresultQuantificationresult filtered by the samplegroup column
 *
 * @method array findById(int $id) Return ExpressionresultQuantificationresult objects filtered by the id column
 * @method array findByExpressionresultId(int $expressionresult_id) Return ExpressionresultQuantificationresult objects filtered by the expressionresult_id column
 * @method array findByQuantificationresultId(int $quantificationresult_id) Return ExpressionresultQuantificationresult objects filtered by the quantificationresult_id column
 * @method array findBySamplegroup(string $samplegroup) Return ExpressionresultQuantificationresult objects filtered by the samplegroup column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseExpressionresultQuantificationresultQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseExpressionresultQuantificationresultQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\ExpressionresultQuantificationresult', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ExpressionresultQuantificationresultQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ExpressionresultQuantificationresultQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ExpressionresultQuantificationresultQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ExpressionresultQuantificationresultQuery) {
            return $criteria;
        }
        $query = new ExpressionresultQuantificationresultQuery();
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
     * @return   ExpressionresultQuantificationresult|ExpressionresultQuantificationresult[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExpressionresultQuantificationresultPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultQuantificationresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ExpressionresultQuantificationresult A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneById($key, $con = null)
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
     * @return                 ExpressionresultQuantificationresult A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "id", "expressionresult_id", "quantificationresult_id", "samplegroup" FROM "expressionresult_quantificationresult" WHERE "id" = :p0';
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
            $obj = new ExpressionresultQuantificationresult();
            $obj->hydrate($row);
            ExpressionresultQuantificationresultPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ExpressionresultQuantificationresult|ExpressionresultQuantificationresult[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ExpressionresultQuantificationresult[]|mixed the list of results, formatted by the current formatter
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
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the id column
     *
     * Example usage:
     * <code>
     * $query->filterById(1234); // WHERE id = 1234
     * $query->filterById(array(12, 34)); // WHERE id IN (12, 34)
     * $query->filterById(array('min' => 12)); // WHERE id >= 12
     * $query->filterById(array('max' => 12)); // WHERE id <= 12
     * </code>
     *
     * @param     mixed $id The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterById($id = null, $comparison = null)
    {
        if (is_array($id)) {
            $useMinMax = false;
            if (isset($id['min'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $id['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($id['max'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $id['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $id, $comparison);
    }

    /**
     * Filter the query on the expressionresult_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExpressionresultId(1234); // WHERE expressionresult_id = 1234
     * $query->filterByExpressionresultId(array(12, 34)); // WHERE expressionresult_id IN (12, 34)
     * $query->filterByExpressionresultId(array('min' => 12)); // WHERE expressionresult_id >= 12
     * $query->filterByExpressionresultId(array('max' => 12)); // WHERE expressionresult_id <= 12
     * </code>
     *
     * @see       filterByExpressionresult()
     *
     * @param     mixed $expressionresultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterByExpressionresultId($expressionresultId = null, $comparison = null)
    {
        if (is_array($expressionresultId)) {
            $useMinMax = false;
            if (isset($expressionresultId['min'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::EXPRESSIONRESULT_ID, $expressionresultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expressionresultId['max'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::EXPRESSIONRESULT_ID, $expressionresultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::EXPRESSIONRESULT_ID, $expressionresultId, $comparison);
    }

    /**
     * Filter the query on the quantificationresult_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationresultId(1234); // WHERE quantificationresult_id = 1234
     * $query->filterByQuantificationresultId(array(12, 34)); // WHERE quantificationresult_id IN (12, 34)
     * $query->filterByQuantificationresultId(array('min' => 12)); // WHERE quantificationresult_id >= 12
     * $query->filterByQuantificationresultId(array('max' => 12)); // WHERE quantificationresult_id <= 12
     * </code>
     *
     * @see       filterByQuantificationresult()
     *
     * @param     mixed $quantificationresultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterByQuantificationresultId($quantificationresultId = null, $comparison = null)
    {
        if (is_array($quantificationresultId)) {
            $useMinMax = false;
            if (isset($quantificationresultId['min'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationresultId['max'])) {
                $this->addUsingAlias(ExpressionresultQuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId, $comparison);
    }

    /**
     * Filter the query on the samplegroup column
     *
     * Example usage:
     * <code>
     * $query->filterBySamplegroup('fooValue');   // WHERE samplegroup = 'fooValue'
     * $query->filterBySamplegroup('%fooValue%'); // WHERE samplegroup LIKE '%fooValue%'
     * </code>
     *
     * @param     string $samplegroup The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function filterBySamplegroup($samplegroup = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($samplegroup)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $samplegroup)) {
                $samplegroup = str_replace('*', '%', $samplegroup);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ExpressionresultQuantificationresultPeer::SAMPLEGROUP, $samplegroup, $comparison);
    }

    /**
     * Filter the query by a related Expressionresult object
     *
     * @param   Expressionresult|PropelObjectCollection $expressionresult The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ExpressionresultQuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExpressionresult($expressionresult, $comparison = null)
    {
        if ($expressionresult instanceof Expressionresult) {
            return $this
                ->addUsingAlias(ExpressionresultQuantificationresultPeer::EXPRESSIONRESULT_ID, $expressionresult->getExpressionresultId(), $comparison);
        } elseif ($expressionresult instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExpressionresultQuantificationresultPeer::EXPRESSIONRESULT_ID, $expressionresult->toKeyValue('PrimaryKey', 'ExpressionresultId'), $comparison);
        } else {
            throw new PropelException('filterByExpressionresult() only accepts arguments of type Expressionresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Expressionresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function joinExpressionresult($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Expressionresult');

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
            $this->addJoinObject($join, 'Expressionresult');
        }

        return $this;
    }

    /**
     * Use the Expressionresult relation Expressionresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ExpressionresultQuery A secondary query class using the current class as primary query
     */
    public function useExpressionresultQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExpressionresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Expressionresult', '\cli_db\propel\ExpressionresultQuery');
    }

    /**
     * Filter the query by a related Quantificationresult object
     *
     * @param   Quantificationresult|PropelObjectCollection $quantificationresult The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ExpressionresultQuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantificationresult($quantificationresult, $comparison = null)
    {
        if ($quantificationresult instanceof Quantificationresult) {
            return $this
                ->addUsingAlias(ExpressionresultQuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresult->getQuantificationresultId(), $comparison);
        } elseif ($quantificationresult instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExpressionresultQuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresult->toKeyValue('PrimaryKey', 'QuantificationresultId'), $comparison);
        } else {
            throw new PropelException('filterByQuantificationresult() only accepts arguments of type Quantificationresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantificationresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function joinQuantificationresult($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantificationresult');

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
            $this->addJoinObject($join, 'Quantificationresult');
        }

        return $this;
    }

    /**
     * Use the Quantificationresult relation Quantificationresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationresultQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationresultQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinQuantificationresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantificationresult', '\cli_db\propel\QuantificationresultQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   ExpressionresultQuantificationresult $expressionresultQuantificationresult Object to remove from the list of results
     *
     * @return ExpressionresultQuantificationresultQuery The current query, for fluid interface
     */
    public function prune($expressionresultQuantificationresult = null)
    {
        if ($expressionresultQuantificationresult) {
            $this->addUsingAlias(ExpressionresultQuantificationresultPeer::ID, $expressionresultQuantificationresult->getId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
