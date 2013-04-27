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
use cli_db\propel\Feature;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropFeature;
use cli_db\propel\StudypropFeaturePeer;
use cli_db\propel\StudypropFeatureQuery;

/**
 * Base class that represents a query for the 'studyprop_feature' table.
 *
 *
 *
 * @method StudypropFeatureQuery orderByStudypropFeatureId($order = Criteria::ASC) Order by the studyprop_feature_id column
 * @method StudypropFeatureQuery orderByStudypropId($order = Criteria::ASC) Order by the studyprop_id column
 * @method StudypropFeatureQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method StudypropFeatureQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 *
 * @method StudypropFeatureQuery groupByStudypropFeatureId() Group by the studyprop_feature_id column
 * @method StudypropFeatureQuery groupByStudypropId() Group by the studyprop_id column
 * @method StudypropFeatureQuery groupByFeatureId() Group by the feature_id column
 * @method StudypropFeatureQuery groupByTypeId() Group by the type_id column
 *
 * @method StudypropFeatureQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudypropFeatureQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudypropFeatureQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudypropFeatureQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method StudypropFeatureQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method StudypropFeatureQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method StudypropFeatureQuery leftJoinStudyprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyprop relation
 * @method StudypropFeatureQuery rightJoinStudyprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyprop relation
 * @method StudypropFeatureQuery innerJoinStudyprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyprop relation
 *
 * @method StudypropFeatureQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method StudypropFeatureQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method StudypropFeatureQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method StudypropFeature findOne(PropelPDO $con = null) Return the first StudypropFeature matching the query
 * @method StudypropFeature findOneOrCreate(PropelPDO $con = null) Return the first StudypropFeature matching the query, or a new StudypropFeature object populated from the query conditions when no match is found
 *
 * @method StudypropFeature findOneByStudypropId(int $studyprop_id) Return the first StudypropFeature filtered by the studyprop_id column
 * @method StudypropFeature findOneByFeatureId(int $feature_id) Return the first StudypropFeature filtered by the feature_id column
 * @method StudypropFeature findOneByTypeId(int $type_id) Return the first StudypropFeature filtered by the type_id column
 *
 * @method array findByStudypropFeatureId(int $studyprop_feature_id) Return StudypropFeature objects filtered by the studyprop_feature_id column
 * @method array findByStudypropId(int $studyprop_id) Return StudypropFeature objects filtered by the studyprop_id column
 * @method array findByFeatureId(int $feature_id) Return StudypropFeature objects filtered by the feature_id column
 * @method array findByTypeId(int $type_id) Return StudypropFeature objects filtered by the type_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudypropFeatureQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudypropFeatureQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\StudypropFeature', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudypropFeatureQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudypropFeatureQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudypropFeatureQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudypropFeatureQuery) {
            return $criteria;
        }
        $query = new StudypropFeatureQuery();
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
     * @return   StudypropFeature|StudypropFeature[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudypropFeaturePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudypropFeaturePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 StudypropFeature A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudypropFeatureId($key, $con = null)
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
     * @return                 StudypropFeature A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studyprop_feature_id", "studyprop_id", "feature_id", "type_id" FROM "studyprop_feature" WHERE "studyprop_feature_id" = :p0';
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
            $obj = new StudypropFeature();
            $obj->hydrate($row);
            StudypropFeaturePeer::addInstanceToPool($obj, (string) $key);
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
     * @return StudypropFeature|StudypropFeature[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|StudypropFeature[]|mixed the list of results, formatted by the current formatter
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
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studyprop_feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudypropFeatureId(1234); // WHERE studyprop_feature_id = 1234
     * $query->filterByStudypropFeatureId(array(12, 34)); // WHERE studyprop_feature_id IN (12, 34)
     * $query->filterByStudypropFeatureId(array('min' => 12)); // WHERE studyprop_feature_id >= 12
     * $query->filterByStudypropFeatureId(array('max' => 12)); // WHERE studyprop_feature_id <= 12
     * </code>
     *
     * @param     mixed $studypropFeatureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByStudypropFeatureId($studypropFeatureId = null, $comparison = null)
    {
        if (is_array($studypropFeatureId)) {
            $useMinMax = false;
            if (isset($studypropFeatureId['min'])) {
                $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $studypropFeatureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studypropFeatureId['max'])) {
                $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $studypropFeatureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $studypropFeatureId, $comparison);
    }

    /**
     * Filter the query on the studyprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudypropId(1234); // WHERE studyprop_id = 1234
     * $query->filterByStudypropId(array(12, 34)); // WHERE studyprop_id IN (12, 34)
     * $query->filterByStudypropId(array('min' => 12)); // WHERE studyprop_id >= 12
     * $query->filterByStudypropId(array('max' => 12)); // WHERE studyprop_id <= 12
     * </code>
     *
     * @see       filterByStudyprop()
     *
     * @param     mixed $studypropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByStudypropId($studypropId = null, $comparison = null)
    {
        if (is_array($studypropId)) {
            $useMinMax = false;
            if (isset($studypropId['min'])) {
                $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_ID, $studypropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studypropId['max'])) {
                $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_ID, $studypropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_ID, $studypropId, $comparison);
    }

    /**
     * Filter the query on the feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureId(1234); // WHERE feature_id = 1234
     * $query->filterByFeatureId(array(12, 34)); // WHERE feature_id IN (12, 34)
     * $query->filterByFeatureId(array('min' => 12)); // WHERE feature_id >= 12
     * $query->filterByFeatureId(array('max' => 12)); // WHERE feature_id <= 12
     * </code>
     *
     * @see       filterByFeature()
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(StudypropFeaturePeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(StudypropFeaturePeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropFeaturePeer::FEATURE_ID, $featureId, $comparison);
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
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(StudypropFeaturePeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(StudypropFeaturePeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropFeaturePeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropFeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(StudypropFeaturePeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudypropFeaturePeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

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
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Studyprop object
     *
     * @param   Studyprop|PropelObjectCollection $studyprop The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropFeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyprop($studyprop, $comparison = null)
    {
        if ($studyprop instanceof Studyprop) {
            return $this
                ->addUsingAlias(StudypropFeaturePeer::STUDYPROP_ID, $studyprop->getStudypropId(), $comparison);
        } elseif ($studyprop instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudypropFeaturePeer::STUDYPROP_ID, $studyprop->toKeyValue('PrimaryKey', 'StudypropId'), $comparison);
        } else {
            throw new PropelException('filterByStudyprop() only accepts arguments of type Studyprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function joinStudyprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyprop');

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
            $this->addJoinObject($join, 'Studyprop');
        }

        return $this;
    }

    /**
     * Use the Studyprop relation Studyprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudypropQuery A secondary query class using the current class as primary query
     */
    public function useStudypropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyprop', '\cli_db\propel\StudypropQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropFeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(StudypropFeaturePeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudypropFeaturePeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function joinCvterm($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useCvtermQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cvterm', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   StudypropFeature $studypropFeature Object to remove from the list of results
     *
     * @return StudypropFeatureQuery The current query, for fluid interface
     */
    public function prune($studypropFeature = null)
    {
        if ($studypropFeature) {
            $this->addUsingAlias(StudypropFeaturePeer::STUDYPROP_FEATURE_ID, $studypropFeature->getStudypropFeatureId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
