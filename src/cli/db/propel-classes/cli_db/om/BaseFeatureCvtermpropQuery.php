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
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermprop;
use cli_db\propel\FeatureCvtermpropPeer;
use cli_db\propel\FeatureCvtermpropQuery;

/**
 * Base class that represents a query for the 'feature_cvtermprop' table.
 *
 *
 *
 * @method FeatureCvtermpropQuery orderByFeatureCvtermpropId($order = Criteria::ASC) Order by the feature_cvtermprop_id column
 * @method FeatureCvtermpropQuery orderByFeatureCvtermId($order = Criteria::ASC) Order by the feature_cvterm_id column
 * @method FeatureCvtermpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method FeatureCvtermpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method FeatureCvtermpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method FeatureCvtermpropQuery groupByFeatureCvtermpropId() Group by the feature_cvtermprop_id column
 * @method FeatureCvtermpropQuery groupByFeatureCvtermId() Group by the feature_cvterm_id column
 * @method FeatureCvtermpropQuery groupByTypeId() Group by the type_id column
 * @method FeatureCvtermpropQuery groupByValue() Group by the value column
 * @method FeatureCvtermpropQuery groupByRank() Group by the rank column
 *
 * @method FeatureCvtermpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureCvtermpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureCvtermpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureCvtermpropQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermpropQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermpropQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method FeatureCvtermpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method FeatureCvtermpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method FeatureCvtermpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method FeatureCvtermprop findOne(PropelPDO $con = null) Return the first FeatureCvtermprop matching the query
 * @method FeatureCvtermprop findOneOrCreate(PropelPDO $con = null) Return the first FeatureCvtermprop matching the query, or a new FeatureCvtermprop object populated from the query conditions when no match is found
 *
 * @method FeatureCvtermprop findOneByFeatureCvtermId(int $feature_cvterm_id) Return the first FeatureCvtermprop filtered by the feature_cvterm_id column
 * @method FeatureCvtermprop findOneByTypeId(int $type_id) Return the first FeatureCvtermprop filtered by the type_id column
 * @method FeatureCvtermprop findOneByValue(string $value) Return the first FeatureCvtermprop filtered by the value column
 * @method FeatureCvtermprop findOneByRank(int $rank) Return the first FeatureCvtermprop filtered by the rank column
 *
 * @method array findByFeatureCvtermpropId(int $feature_cvtermprop_id) Return FeatureCvtermprop objects filtered by the feature_cvtermprop_id column
 * @method array findByFeatureCvtermId(int $feature_cvterm_id) Return FeatureCvtermprop objects filtered by the feature_cvterm_id column
 * @method array findByTypeId(int $type_id) Return FeatureCvtermprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return FeatureCvtermprop objects filtered by the value column
 * @method array findByRank(int $rank) Return FeatureCvtermprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureCvtermpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureCvtermpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureCvtermprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureCvtermpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureCvtermpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureCvtermpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureCvtermpropQuery) {
            return $criteria;
        }
        $query = new FeatureCvtermpropQuery();
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
     * @return   FeatureCvtermprop|FeatureCvtermprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureCvtermpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureCvtermpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureCvtermprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureCvtermpropId($key, $con = null)
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
     * @return                 FeatureCvtermprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_cvtermprop_id", "feature_cvterm_id", "type_id", "value", "rank" FROM "feature_cvtermprop" WHERE "feature_cvtermprop_id" = :p0';
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
            $obj = new FeatureCvtermprop();
            $obj->hydrate($row);
            FeatureCvtermpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureCvtermprop|FeatureCvtermprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureCvtermprop[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_cvtermprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureCvtermpropId(1234); // WHERE feature_cvtermprop_id = 1234
     * $query->filterByFeatureCvtermpropId(array(12, 34)); // WHERE feature_cvtermprop_id IN (12, 34)
     * $query->filterByFeatureCvtermpropId(array('min' => 12)); // WHERE feature_cvtermprop_id >= 12
     * $query->filterByFeatureCvtermpropId(array('max' => 12)); // WHERE feature_cvtermprop_id <= 12
     * </code>
     *
     * @param     mixed $featureCvtermpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermpropId($featureCvtermpropId = null, $comparison = null)
    {
        if (is_array($featureCvtermpropId)) {
            $useMinMax = false;
            if (isset($featureCvtermpropId['min'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $featureCvtermpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermpropId['max'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $featureCvtermpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $featureCvtermpropId, $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermId($featureCvtermId = null, $comparison = null)
    {
        if (is_array($featureCvtermId)) {
            $useMinMax = false;
            if (isset($featureCvtermId['min'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERM_ID, $featureCvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermId['max'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERM_ID, $featureCvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERM_ID, $featureCvtermId, $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FeatureCvtermpropPeer::VALUE, $value, $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(FeatureCvtermpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERM_ID, $featureCvterm->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERM_ID, $featureCvterm->toKeyValue('PrimaryKey', 'FeatureCvtermId'), $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(FeatureCvtermpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return FeatureCvtermpropQuery The current query, for fluid interface
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
     * @param   FeatureCvtermprop $featureCvtermprop Object to remove from the list of results
     *
     * @return FeatureCvtermpropQuery The current query, for fluid interface
     */
    public function prune($featureCvtermprop = null)
    {
        if ($featureCvtermprop) {
            $this->addUsingAlias(FeatureCvtermpropPeer::FEATURE_CVTERMPROP_ID, $featureCvtermprop->getFeatureCvtermpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
