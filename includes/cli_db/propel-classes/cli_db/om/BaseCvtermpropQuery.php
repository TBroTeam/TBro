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
use cli_db\propel\Cvtermprop;
use cli_db\propel\CvtermpropPeer;
use cli_db\propel\CvtermpropQuery;

/**
 * Base class that represents a query for the 'cvtermprop' table.
 *
 *
 *
 * @method CvtermpropQuery orderByCvtermpropId($order = Criteria::ASC) Order by the cvtermprop_id column
 * @method CvtermpropQuery orderByCvtermId($order = Criteria::ASC) Order by the cvterm_id column
 * @method CvtermpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method CvtermpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method CvtermpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method CvtermpropQuery groupByCvtermpropId() Group by the cvtermprop_id column
 * @method CvtermpropQuery groupByCvtermId() Group by the cvterm_id column
 * @method CvtermpropQuery groupByTypeId() Group by the type_id column
 * @method CvtermpropQuery groupByValue() Group by the value column
 * @method CvtermpropQuery groupByRank() Group by the rank column
 *
 * @method CvtermpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvtermpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvtermpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvtermpropQuery leftJoinCvtermRelatedByCvtermId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByCvtermId relation
 * @method CvtermpropQuery rightJoinCvtermRelatedByCvtermId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByCvtermId relation
 * @method CvtermpropQuery innerJoinCvtermRelatedByCvtermId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByCvtermId relation
 *
 * @method CvtermpropQuery leftJoinCvtermRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByTypeId relation
 * @method CvtermpropQuery rightJoinCvtermRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByTypeId relation
 * @method CvtermpropQuery innerJoinCvtermRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByTypeId relation
 *
 * @method Cvtermprop findOne(PropelPDO $con = null) Return the first Cvtermprop matching the query
 * @method Cvtermprop findOneOrCreate(PropelPDO $con = null) Return the first Cvtermprop matching the query, or a new Cvtermprop object populated from the query conditions when no match is found
 *
 * @method Cvtermprop findOneByCvtermId(int $cvterm_id) Return the first Cvtermprop filtered by the cvterm_id column
 * @method Cvtermprop findOneByTypeId(int $type_id) Return the first Cvtermprop filtered by the type_id column
 * @method Cvtermprop findOneByValue(string $value) Return the first Cvtermprop filtered by the value column
 * @method Cvtermprop findOneByRank(int $rank) Return the first Cvtermprop filtered by the rank column
 *
 * @method array findByCvtermpropId(int $cvtermprop_id) Return Cvtermprop objects filtered by the cvtermprop_id column
 * @method array findByCvtermId(int $cvterm_id) Return Cvtermprop objects filtered by the cvterm_id column
 * @method array findByTypeId(int $type_id) Return Cvtermprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Cvtermprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Cvtermprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvtermpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Cvtermprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvtermpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvtermpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvtermpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvtermpropQuery) {
            return $criteria;
        }
        $query = new CvtermpropQuery();
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
     * @return   Cvtermprop|Cvtermprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvtermpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvtermpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Cvtermprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvtermpropId($key, $con = null)
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
     * @return                 Cvtermprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cvtermprop_id", "cvterm_id", "type_id", "value", "rank" FROM "cvtermprop" WHERE "cvtermprop_id" = :p0';
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
            $obj = new Cvtermprop();
            $obj->hydrate($row);
            CvtermpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Cvtermprop|Cvtermprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Cvtermprop[]|mixed the list of results, formatted by the current formatter
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
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cvtermprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermpropId(1234); // WHERE cvtermprop_id = 1234
     * $query->filterByCvtermpropId(array(12, 34)); // WHERE cvtermprop_id IN (12, 34)
     * $query->filterByCvtermpropId(array('min' => 12)); // WHERE cvtermprop_id >= 12
     * $query->filterByCvtermpropId(array('max' => 12)); // WHERE cvtermprop_id <= 12
     * </code>
     *
     * @param     mixed $cvtermpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByCvtermpropId($cvtermpropId = null, $comparison = null)
    {
        if (is_array($cvtermpropId)) {
            $useMinMax = false;
            if (isset($cvtermpropId['min'])) {
                $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $cvtermpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermpropId['max'])) {
                $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $cvtermpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $cvtermpropId, $comparison);
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
     * @see       filterByCvtermRelatedByCvtermId()
     *
     * @param     mixed $cvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByCvtermId($cvtermId = null, $comparison = null)
    {
        if (is_array($cvtermId)) {
            $useMinMax = false;
            if (isset($cvtermId['min'])) {
                $this->addUsingAlias(CvtermpropPeer::CVTERM_ID, $cvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermId['max'])) {
                $this->addUsingAlias(CvtermpropPeer::CVTERM_ID, $cvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermpropPeer::CVTERM_ID, $cvtermId, $comparison);
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
     * @see       filterByCvtermRelatedByTypeId()
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(CvtermpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(CvtermpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return CvtermpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CvtermpropPeer::VALUE, $value, $comparison);
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
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(CvtermpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(CvtermpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByCvtermId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermpropPeer::CVTERM_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermpropPeer::CVTERM_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByCvtermId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByCvtermId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByCvtermId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByCvtermId');

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
            $this->addJoinObject($join, 'CvtermRelatedByCvtermId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByCvtermId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByCvtermIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedByCvtermId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByCvtermId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByTypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByTypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByTypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByTypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByTypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Cvtermprop $cvtermprop Object to remove from the list of results
     *
     * @return CvtermpropQuery The current query, for fluid interface
     */
    public function prune($cvtermprop = null)
    {
        if ($cvtermprop) {
            $this->addUsingAlias(CvtermpropPeer::CVTERMPROP_ID, $cvtermprop->getCvtermpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
