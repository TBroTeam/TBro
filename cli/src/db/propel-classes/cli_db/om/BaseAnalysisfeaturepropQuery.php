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
use cli_db\propel\Analysisfeature;
use cli_db\propel\Analysisfeatureprop;
use cli_db\propel\AnalysisfeaturepropPeer;
use cli_db\propel\AnalysisfeaturepropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'analysisfeatureprop' table.
 *
 *
 *
 * @method AnalysisfeaturepropQuery orderByAnalysisfeaturepropId($order = Criteria::ASC) Order by the analysisfeatureprop_id column
 * @method AnalysisfeaturepropQuery orderByAnalysisfeatureId($order = Criteria::ASC) Order by the analysisfeature_id column
 * @method AnalysisfeaturepropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method AnalysisfeaturepropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method AnalysisfeaturepropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AnalysisfeaturepropQuery groupByAnalysisfeaturepropId() Group by the analysisfeatureprop_id column
 * @method AnalysisfeaturepropQuery groupByAnalysisfeatureId() Group by the analysisfeature_id column
 * @method AnalysisfeaturepropQuery groupByTypeId() Group by the type_id column
 * @method AnalysisfeaturepropQuery groupByValue() Group by the value column
 * @method AnalysisfeaturepropQuery groupByRank() Group by the rank column
 *
 * @method AnalysisfeaturepropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AnalysisfeaturepropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AnalysisfeaturepropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AnalysisfeaturepropQuery leftJoinAnalysisfeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisfeature relation
 * @method AnalysisfeaturepropQuery rightJoinAnalysisfeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisfeature relation
 * @method AnalysisfeaturepropQuery innerJoinAnalysisfeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisfeature relation
 *
 * @method AnalysisfeaturepropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method AnalysisfeaturepropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method AnalysisfeaturepropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Analysisfeatureprop findOne(PropelPDO $con = null) Return the first Analysisfeatureprop matching the query
 * @method Analysisfeatureprop findOneOrCreate(PropelPDO $con = null) Return the first Analysisfeatureprop matching the query, or a new Analysisfeatureprop object populated from the query conditions when no match is found
 *
 * @method Analysisfeatureprop findOneByAnalysisfeatureId(int $analysisfeature_id) Return the first Analysisfeatureprop filtered by the analysisfeature_id column
 * @method Analysisfeatureprop findOneByTypeId(int $type_id) Return the first Analysisfeatureprop filtered by the type_id column
 * @method Analysisfeatureprop findOneByValue(string $value) Return the first Analysisfeatureprop filtered by the value column
 * @method Analysisfeatureprop findOneByRank(int $rank) Return the first Analysisfeatureprop filtered by the rank column
 *
 * @method array findByAnalysisfeaturepropId(int $analysisfeatureprop_id) Return Analysisfeatureprop objects filtered by the analysisfeatureprop_id column
 * @method array findByAnalysisfeatureId(int $analysisfeature_id) Return Analysisfeatureprop objects filtered by the analysisfeature_id column
 * @method array findByTypeId(int $type_id) Return Analysisfeatureprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Analysisfeatureprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Analysisfeatureprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysisfeaturepropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAnalysisfeaturepropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Analysisfeatureprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AnalysisfeaturepropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AnalysisfeaturepropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AnalysisfeaturepropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AnalysisfeaturepropQuery) {
            return $criteria;
        }
        $query = new AnalysisfeaturepropQuery();
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
     * @return   Analysisfeatureprop|Analysisfeatureprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnalysisfeaturepropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AnalysisfeaturepropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Analysisfeatureprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAnalysisfeaturepropId($key, $con = null)
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
     * @return                 Analysisfeatureprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "analysisfeatureprop_id", "analysisfeature_id", "type_id", "value", "rank" FROM "analysisfeatureprop" WHERE "analysisfeatureprop_id" = :p0';
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
            $obj = new Analysisfeatureprop();
            $obj->hydrate($row);
            AnalysisfeaturepropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Analysisfeatureprop|Analysisfeatureprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Analysisfeatureprop[]|mixed the list of results, formatted by the current formatter
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
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the analysisfeatureprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysisfeaturepropId(1234); // WHERE analysisfeatureprop_id = 1234
     * $query->filterByAnalysisfeaturepropId(array(12, 34)); // WHERE analysisfeatureprop_id IN (12, 34)
     * $query->filterByAnalysisfeaturepropId(array('min' => 12)); // WHERE analysisfeatureprop_id >= 12
     * $query->filterByAnalysisfeaturepropId(array('max' => 12)); // WHERE analysisfeatureprop_id <= 12
     * </code>
     *
     * @param     mixed $analysisfeaturepropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByAnalysisfeaturepropId($analysisfeaturepropId = null, $comparison = null)
    {
        if (is_array($analysisfeaturepropId)) {
            $useMinMax = false;
            if (isset($analysisfeaturepropId['min'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $analysisfeaturepropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisfeaturepropId['max'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $analysisfeaturepropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $analysisfeaturepropId, $comparison);
    }

    /**
     * Filter the query on the analysisfeature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysisfeatureId(1234); // WHERE analysisfeature_id = 1234
     * $query->filterByAnalysisfeatureId(array(12, 34)); // WHERE analysisfeature_id IN (12, 34)
     * $query->filterByAnalysisfeatureId(array('min' => 12)); // WHERE analysisfeature_id >= 12
     * $query->filterByAnalysisfeatureId(array('max' => 12)); // WHERE analysisfeature_id <= 12
     * </code>
     *
     * @see       filterByAnalysisfeature()
     *
     * @param     mixed $analysisfeatureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByAnalysisfeatureId($analysisfeatureId = null, $comparison = null)
    {
        if (is_array($analysisfeatureId)) {
            $useMinMax = false;
            if (isset($analysisfeatureId['min'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATURE_ID, $analysisfeatureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisfeatureId['max'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATURE_ID, $analysisfeatureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATURE_ID, $analysisfeatureId, $comparison);
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
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturepropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AnalysisfeaturepropPeer::VALUE, $value, $comparison);
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
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AnalysisfeaturepropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturepropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Analysisfeature object
     *
     * @param   Analysisfeature|PropelObjectCollection $analysisfeature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisfeaturepropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisfeature($analysisfeature, $comparison = null)
    {
        if ($analysisfeature instanceof Analysisfeature) {
            return $this
                ->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATURE_ID, $analysisfeature->getAnalysisfeatureId(), $comparison);
        } elseif ($analysisfeature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATURE_ID, $analysisfeature->toKeyValue('PrimaryKey', 'AnalysisfeatureId'), $comparison);
        } else {
            throw new PropelException('filterByAnalysisfeature() only accepts arguments of type Analysisfeature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisfeature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function joinAnalysisfeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisfeature');

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
            $this->addJoinObject($join, 'Analysisfeature');
        }

        return $this;
    }

    /**
     * Use the Analysisfeature relation Analysisfeature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisfeatureQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisfeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisfeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisfeature', '\cli_db\propel\AnalysisfeatureQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisfeaturepropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(AnalysisfeaturepropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysisfeaturepropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
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
     * @param   Analysisfeatureprop $analysisfeatureprop Object to remove from the list of results
     *
     * @return AnalysisfeaturepropQuery The current query, for fluid interface
     */
    public function prune($analysisfeatureprop = null)
    {
        if ($analysisfeatureprop) {
            $this->addUsingAlias(AnalysisfeaturepropPeer::ANALYSISFEATUREPROP_ID, $analysisfeatureprop->getAnalysisfeaturepropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
