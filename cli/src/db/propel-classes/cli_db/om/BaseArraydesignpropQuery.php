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
use cli_db\propel\Arraydesign;
use cli_db\propel\Arraydesignprop;
use cli_db\propel\ArraydesignpropPeer;
use cli_db\propel\ArraydesignpropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'arraydesignprop' table.
 *
 *
 *
 * @method ArraydesignpropQuery orderByArraydesignpropId($order = Criteria::ASC) Order by the arraydesignprop_id column
 * @method ArraydesignpropQuery orderByArraydesignId($order = Criteria::ASC) Order by the arraydesign_id column
 * @method ArraydesignpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method ArraydesignpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method ArraydesignpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method ArraydesignpropQuery groupByArraydesignpropId() Group by the arraydesignprop_id column
 * @method ArraydesignpropQuery groupByArraydesignId() Group by the arraydesign_id column
 * @method ArraydesignpropQuery groupByTypeId() Group by the type_id column
 * @method ArraydesignpropQuery groupByValue() Group by the value column
 * @method ArraydesignpropQuery groupByRank() Group by the rank column
 *
 * @method ArraydesignpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ArraydesignpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ArraydesignpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ArraydesignpropQuery leftJoinArraydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arraydesign relation
 * @method ArraydesignpropQuery rightJoinArraydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arraydesign relation
 * @method ArraydesignpropQuery innerJoinArraydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Arraydesign relation
 *
 * @method ArraydesignpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method ArraydesignpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method ArraydesignpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Arraydesignprop findOne(PropelPDO $con = null) Return the first Arraydesignprop matching the query
 * @method Arraydesignprop findOneOrCreate(PropelPDO $con = null) Return the first Arraydesignprop matching the query, or a new Arraydesignprop object populated from the query conditions when no match is found
 *
 * @method Arraydesignprop findOneByArraydesignId(int $arraydesign_id) Return the first Arraydesignprop filtered by the arraydesign_id column
 * @method Arraydesignprop findOneByTypeId(int $type_id) Return the first Arraydesignprop filtered by the type_id column
 * @method Arraydesignprop findOneByValue(string $value) Return the first Arraydesignprop filtered by the value column
 * @method Arraydesignprop findOneByRank(int $rank) Return the first Arraydesignprop filtered by the rank column
 *
 * @method array findByArraydesignpropId(int $arraydesignprop_id) Return Arraydesignprop objects filtered by the arraydesignprop_id column
 * @method array findByArraydesignId(int $arraydesign_id) Return Arraydesignprop objects filtered by the arraydesign_id column
 * @method array findByTypeId(int $type_id) Return Arraydesignprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Arraydesignprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Arraydesignprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseArraydesignpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseArraydesignpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Arraydesignprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ArraydesignpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ArraydesignpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ArraydesignpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ArraydesignpropQuery) {
            return $criteria;
        }
        $query = new ArraydesignpropQuery();
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
     * @return   Arraydesignprop|Arraydesignprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArraydesignpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Arraydesignprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByArraydesignpropId($key, $con = null)
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
     * @return                 Arraydesignprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "arraydesignprop_id", "arraydesign_id", "type_id", "value", "rank" FROM "arraydesignprop" WHERE "arraydesignprop_id" = :p0';
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
            $obj = new Arraydesignprop();
            $obj->hydrate($row);
            ArraydesignpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Arraydesignprop|Arraydesignprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Arraydesignprop[]|mixed the list of results, formatted by the current formatter
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
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the arraydesignprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArraydesignpropId(1234); // WHERE arraydesignprop_id = 1234
     * $query->filterByArraydesignpropId(array(12, 34)); // WHERE arraydesignprop_id IN (12, 34)
     * $query->filterByArraydesignpropId(array('min' => 12)); // WHERE arraydesignprop_id >= 12
     * $query->filterByArraydesignpropId(array('max' => 12)); // WHERE arraydesignprop_id <= 12
     * </code>
     *
     * @param     mixed $arraydesignpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByArraydesignpropId($arraydesignpropId = null, $comparison = null)
    {
        if (is_array($arraydesignpropId)) {
            $useMinMax = false;
            if (isset($arraydesignpropId['min'])) {
                $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $arraydesignpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arraydesignpropId['max'])) {
                $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $arraydesignpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $arraydesignpropId, $comparison);
    }

    /**
     * Filter the query on the arraydesign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArraydesignId(1234); // WHERE arraydesign_id = 1234
     * $query->filterByArraydesignId(array(12, 34)); // WHERE arraydesign_id IN (12, 34)
     * $query->filterByArraydesignId(array('min' => 12)); // WHERE arraydesign_id >= 12
     * $query->filterByArraydesignId(array('max' => 12)); // WHERE arraydesign_id <= 12
     * </code>
     *
     * @see       filterByArraydesign()
     *
     * @param     mixed $arraydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByArraydesignId($arraydesignId = null, $comparison = null)
    {
        if (is_array($arraydesignId)) {
            $useMinMax = false;
            if (isset($arraydesignId['min'])) {
                $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGN_ID, $arraydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arraydesignId['max'])) {
                $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGN_ID, $arraydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGN_ID, $arraydesignId, $comparison);
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
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(ArraydesignpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(ArraydesignpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return ArraydesignpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArraydesignpropPeer::VALUE, $value, $comparison);
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
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(ArraydesignpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(ArraydesignpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Arraydesign object
     *
     * @param   Arraydesign|PropelObjectCollection $arraydesign The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesign($arraydesign, $comparison = null)
    {
        if ($arraydesign instanceof Arraydesign) {
            return $this
                ->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGN_ID, $arraydesign->getArraydesignId(), $comparison);
        } elseif ($arraydesign instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGN_ID, $arraydesign->toKeyValue('PrimaryKey', 'ArraydesignId'), $comparison);
        } else {
            throw new PropelException('filterByArraydesign() only accepts arguments of type Arraydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arraydesign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function joinArraydesign($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arraydesign');

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
            $this->addJoinObject($join, 'Arraydesign');
        }

        return $this;
    }

    /**
     * Use the Arraydesign relation Arraydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArraydesign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arraydesign', '\cli_db\propel\ArraydesignQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ArraydesignpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return ArraydesignpropQuery The current query, for fluid interface
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
     * @param   Arraydesignprop $arraydesignprop Object to remove from the list of results
     *
     * @return ArraydesignpropQuery The current query, for fluid interface
     */
    public function prune($arraydesignprop = null)
    {
        if ($arraydesignprop) {
            $this->addUsingAlias(ArraydesignpropPeer::ARRAYDESIGNPROP_ID, $arraydesignprop->getArraydesignpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
