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
use cli_db\propel\Analysis;
use cli_db\propel\Analysisprop;
use cli_db\propel\AnalysispropPeer;
use cli_db\propel\AnalysispropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'analysisprop' table.
 *
 *
 *
 * @method AnalysispropQuery orderByAnalysispropId($order = Criteria::ASC) Order by the analysisprop_id column
 * @method AnalysispropQuery orderByAnalysisId($order = Criteria::ASC) Order by the analysis_id column
 * @method AnalysispropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method AnalysispropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method AnalysispropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AnalysispropQuery groupByAnalysispropId() Group by the analysisprop_id column
 * @method AnalysispropQuery groupByAnalysisId() Group by the analysis_id column
 * @method AnalysispropQuery groupByTypeId() Group by the type_id column
 * @method AnalysispropQuery groupByValue() Group by the value column
 * @method AnalysispropQuery groupByRank() Group by the rank column
 *
 * @method AnalysispropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AnalysispropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AnalysispropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AnalysispropQuery leftJoinAnalysis($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysis relation
 * @method AnalysispropQuery rightJoinAnalysis($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysis relation
 * @method AnalysispropQuery innerJoinAnalysis($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysis relation
 *
 * @method AnalysispropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method AnalysispropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method AnalysispropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Analysisprop findOne(PropelPDO $con = null) Return the first Analysisprop matching the query
 * @method Analysisprop findOneOrCreate(PropelPDO $con = null) Return the first Analysisprop matching the query, or a new Analysisprop object populated from the query conditions when no match is found
 *
 * @method Analysisprop findOneByAnalysisId(int $analysis_id) Return the first Analysisprop filtered by the analysis_id column
 * @method Analysisprop findOneByTypeId(int $type_id) Return the first Analysisprop filtered by the type_id column
 * @method Analysisprop findOneByValue(string $value) Return the first Analysisprop filtered by the value column
 * @method Analysisprop findOneByRank(int $rank) Return the first Analysisprop filtered by the rank column
 *
 * @method array findByAnalysispropId(int $analysisprop_id) Return Analysisprop objects filtered by the analysisprop_id column
 * @method array findByAnalysisId(int $analysis_id) Return Analysisprop objects filtered by the analysis_id column
 * @method array findByTypeId(int $type_id) Return Analysisprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Analysisprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Analysisprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysispropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAnalysispropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Analysisprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AnalysispropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AnalysispropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AnalysispropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AnalysispropQuery) {
            return $criteria;
        }
        $query = new AnalysispropQuery();
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
     * @return   Analysisprop|Analysisprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnalysispropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AnalysispropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Analysisprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAnalysispropId($key, $con = null)
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
     * @return                 Analysisprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "analysisprop_id", "analysis_id", "type_id", "value", "rank" FROM "analysisprop" WHERE "analysisprop_id" = :p0';
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
            $obj = new Analysisprop();
            $obj->hydrate($row);
            AnalysispropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Analysisprop|Analysisprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Analysisprop[]|mixed the list of results, formatted by the current formatter
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
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the analysisprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysispropId(1234); // WHERE analysisprop_id = 1234
     * $query->filterByAnalysispropId(array(12, 34)); // WHERE analysisprop_id IN (12, 34)
     * $query->filterByAnalysispropId(array('min' => 12)); // WHERE analysisprop_id >= 12
     * $query->filterByAnalysispropId(array('max' => 12)); // WHERE analysisprop_id <= 12
     * </code>
     *
     * @param     mixed $analysispropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByAnalysispropId($analysispropId = null, $comparison = null)
    {
        if (is_array($analysispropId)) {
            $useMinMax = false;
            if (isset($analysispropId['min'])) {
                $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $analysispropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysispropId['max'])) {
                $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $analysispropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $analysispropId, $comparison);
    }

    /**
     * Filter the query on the analysis_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysisId(1234); // WHERE analysis_id = 1234
     * $query->filterByAnalysisId(array(12, 34)); // WHERE analysis_id IN (12, 34)
     * $query->filterByAnalysisId(array('min' => 12)); // WHERE analysis_id >= 12
     * $query->filterByAnalysisId(array('max' => 12)); // WHERE analysis_id <= 12
     * </code>
     *
     * @see       filterByAnalysis()
     *
     * @param     mixed $analysisId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByAnalysisId($analysisId = null, $comparison = null)
    {
        if (is_array($analysisId)) {
            $useMinMax = false;
            if (isset($analysisId['min'])) {
                $this->addUsingAlias(AnalysispropPeer::ANALYSIS_ID, $analysisId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisId['max'])) {
                $this->addUsingAlias(AnalysispropPeer::ANALYSIS_ID, $analysisId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysispropPeer::ANALYSIS_ID, $analysisId, $comparison);
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
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(AnalysispropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(AnalysispropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysispropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return AnalysispropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AnalysispropPeer::VALUE, $value, $comparison);
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
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AnalysispropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AnalysispropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysispropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Analysis object
     *
     * @param   Analysis|PropelObjectCollection $analysis The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysispropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysis($analysis, $comparison = null)
    {
        if ($analysis instanceof Analysis) {
            return $this
                ->addUsingAlias(AnalysispropPeer::ANALYSIS_ID, $analysis->getAnalysisId(), $comparison);
        } elseif ($analysis instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysispropPeer::ANALYSIS_ID, $analysis->toKeyValue('PrimaryKey', 'AnalysisId'), $comparison);
        } else {
            throw new PropelException('filterByAnalysis() only accepts arguments of type Analysis or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysis relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function joinAnalysis($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysis');

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
            $this->addJoinObject($join, 'Analysis');
        }

        return $this;
    }

    /**
     * Use the Analysis relation Analysis object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysis($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysis', '\cli_db\propel\AnalysisQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysispropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(AnalysispropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysispropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return AnalysispropQuery The current query, for fluid interface
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
     * @param   Analysisprop $analysisprop Object to remove from the list of results
     *
     * @return AnalysispropQuery The current query, for fluid interface
     */
    public function prune($analysisprop = null)
    {
        if ($analysisprop) {
            $this->addUsingAlias(AnalysispropPeer::ANALYSISPROP_ID, $analysisprop->getAnalysispropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
