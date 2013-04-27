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
use cli_db\propel\Quantification;
use cli_db\propel\Quantificationprop;
use cli_db\propel\QuantificationpropPeer;
use cli_db\propel\QuantificationpropQuery;

/**
 * Base class that represents a query for the 'quantificationprop' table.
 *
 *
 *
 * @method QuantificationpropQuery orderByQuantificationpropId($order = Criteria::ASC) Order by the quantificationprop_id column
 * @method QuantificationpropQuery orderByQuantificationId($order = Criteria::ASC) Order by the quantification_id column
 * @method QuantificationpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method QuantificationpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method QuantificationpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method QuantificationpropQuery groupByQuantificationpropId() Group by the quantificationprop_id column
 * @method QuantificationpropQuery groupByQuantificationId() Group by the quantification_id column
 * @method QuantificationpropQuery groupByTypeId() Group by the type_id column
 * @method QuantificationpropQuery groupByValue() Group by the value column
 * @method QuantificationpropQuery groupByRank() Group by the rank column
 *
 * @method QuantificationpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method QuantificationpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method QuantificationpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method QuantificationpropQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method QuantificationpropQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method QuantificationpropQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method QuantificationpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method QuantificationpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method QuantificationpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Quantificationprop findOne(PropelPDO $con = null) Return the first Quantificationprop matching the query
 * @method Quantificationprop findOneOrCreate(PropelPDO $con = null) Return the first Quantificationprop matching the query, or a new Quantificationprop object populated from the query conditions when no match is found
 *
 * @method Quantificationprop findOneByQuantificationId(int $quantification_id) Return the first Quantificationprop filtered by the quantification_id column
 * @method Quantificationprop findOneByTypeId(int $type_id) Return the first Quantificationprop filtered by the type_id column
 * @method Quantificationprop findOneByValue(string $value) Return the first Quantificationprop filtered by the value column
 * @method Quantificationprop findOneByRank(int $rank) Return the first Quantificationprop filtered by the rank column
 *
 * @method array findByQuantificationpropId(int $quantificationprop_id) Return Quantificationprop objects filtered by the quantificationprop_id column
 * @method array findByQuantificationId(int $quantification_id) Return Quantificationprop objects filtered by the quantification_id column
 * @method array findByTypeId(int $type_id) Return Quantificationprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Quantificationprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Quantificationprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseQuantificationpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseQuantificationpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Quantificationprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new QuantificationpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   QuantificationpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return QuantificationpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof QuantificationpropQuery) {
            return $criteria;
        }
        $query = new QuantificationpropQuery();
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
     * @return   Quantificationprop|Quantificationprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = QuantificationpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(QuantificationpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Quantificationprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByQuantificationpropId($key, $con = null)
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
     * @return                 Quantificationprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "quantificationprop_id", "quantification_id", "type_id", "value", "rank" FROM "quantificationprop" WHERE "quantificationprop_id" = :p0';
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
            $obj = new Quantificationprop();
            $obj->hydrate($row);
            QuantificationpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Quantificationprop|Quantificationprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Quantificationprop[]|mixed the list of results, formatted by the current formatter
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
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the quantificationprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationpropId(1234); // WHERE quantificationprop_id = 1234
     * $query->filterByQuantificationpropId(array(12, 34)); // WHERE quantificationprop_id IN (12, 34)
     * $query->filterByQuantificationpropId(array('min' => 12)); // WHERE quantificationprop_id >= 12
     * $query->filterByQuantificationpropId(array('max' => 12)); // WHERE quantificationprop_id <= 12
     * </code>
     *
     * @param     mixed $quantificationpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByQuantificationpropId($quantificationpropId = null, $comparison = null)
    {
        if (is_array($quantificationpropId)) {
            $useMinMax = false;
            if (isset($quantificationpropId['min'])) {
                $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $quantificationpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationpropId['max'])) {
                $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $quantificationpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $quantificationpropId, $comparison);
    }

    /**
     * Filter the query on the quantification_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationId(1234); // WHERE quantification_id = 1234
     * $query->filterByQuantificationId(array(12, 34)); // WHERE quantification_id IN (12, 34)
     * $query->filterByQuantificationId(array('min' => 12)); // WHERE quantification_id >= 12
     * $query->filterByQuantificationId(array('max' => 12)); // WHERE quantification_id <= 12
     * </code>
     *
     * @see       filterByQuantification()
     *
     * @param     mixed $quantificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByQuantificationId($quantificationId = null, $comparison = null)
    {
        if (is_array($quantificationId)) {
            $useMinMax = false;
            if (isset($quantificationId['min'])) {
                $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATION_ID, $quantificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationId['max'])) {
                $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATION_ID, $quantificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATION_ID, $quantificationId, $comparison);
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
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(QuantificationpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(QuantificationpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return QuantificationpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(QuantificationpropPeer::VALUE, $value, $comparison);
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
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(QuantificationpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(QuantificationpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(QuantificationpropPeer::QUANTIFICATION_ID, $quantification->getQuantificationId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationpropPeer::QUANTIFICATION_ID, $quantification->toKeyValue('PrimaryKey', 'QuantificationId'), $comparison);
        } else {
            throw new PropelException('filterByQuantification() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function joinQuantification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantification');

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
            $this->addJoinObject($join, 'Quantification');
        }

        return $this;
    }

    /**
     * Use the Quantification relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantification', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(QuantificationpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return QuantificationpropQuery The current query, for fluid interface
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
     * @param   Quantificationprop $quantificationprop Object to remove from the list of results
     *
     * @return QuantificationpropQuery The current query, for fluid interface
     */
    public function prune($quantificationprop = null)
    {
        if ($quantificationprop) {
            $this->addUsingAlias(QuantificationpropPeer::QUANTIFICATIONPROP_ID, $quantificationprop->getQuantificationpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
