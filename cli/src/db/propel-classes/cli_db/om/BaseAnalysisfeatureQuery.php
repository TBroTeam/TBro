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
use cli_db\propel\Analysisfeature;
use cli_db\propel\AnalysisfeaturePeer;
use cli_db\propel\AnalysisfeatureQuery;
use cli_db\propel\Analysisfeatureprop;
use cli_db\propel\Feature;

/**
 * Base class that represents a query for the 'analysisfeature' table.
 *
 *
 *
 * @method AnalysisfeatureQuery orderByAnalysisfeatureId($order = Criteria::ASC) Order by the analysisfeature_id column
 * @method AnalysisfeatureQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method AnalysisfeatureQuery orderByAnalysisId($order = Criteria::ASC) Order by the analysis_id column
 * @method AnalysisfeatureQuery orderByRawscore($order = Criteria::ASC) Order by the rawscore column
 * @method AnalysisfeatureQuery orderByNormscore($order = Criteria::ASC) Order by the normscore column
 * @method AnalysisfeatureQuery orderBySignificance($order = Criteria::ASC) Order by the significance column
 * @method AnalysisfeatureQuery orderByIdentity($order = Criteria::ASC) Order by the identity column
 *
 * @method AnalysisfeatureQuery groupByAnalysisfeatureId() Group by the analysisfeature_id column
 * @method AnalysisfeatureQuery groupByFeatureId() Group by the feature_id column
 * @method AnalysisfeatureQuery groupByAnalysisId() Group by the analysis_id column
 * @method AnalysisfeatureQuery groupByRawscore() Group by the rawscore column
 * @method AnalysisfeatureQuery groupByNormscore() Group by the normscore column
 * @method AnalysisfeatureQuery groupBySignificance() Group by the significance column
 * @method AnalysisfeatureQuery groupByIdentity() Group by the identity column
 *
 * @method AnalysisfeatureQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AnalysisfeatureQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AnalysisfeatureQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AnalysisfeatureQuery leftJoinAnalysis($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysis relation
 * @method AnalysisfeatureQuery rightJoinAnalysis($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysis relation
 * @method AnalysisfeatureQuery innerJoinAnalysis($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysis relation
 *
 * @method AnalysisfeatureQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method AnalysisfeatureQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method AnalysisfeatureQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method AnalysisfeatureQuery leftJoinAnalysisfeatureprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisfeatureprop relation
 * @method AnalysisfeatureQuery rightJoinAnalysisfeatureprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisfeatureprop relation
 * @method AnalysisfeatureQuery innerJoinAnalysisfeatureprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisfeatureprop relation
 *
 * @method Analysisfeature findOne(PropelPDO $con = null) Return the first Analysisfeature matching the query
 * @method Analysisfeature findOneOrCreate(PropelPDO $con = null) Return the first Analysisfeature matching the query, or a new Analysisfeature object populated from the query conditions when no match is found
 *
 * @method Analysisfeature findOneByFeatureId(int $feature_id) Return the first Analysisfeature filtered by the feature_id column
 * @method Analysisfeature findOneByAnalysisId(int $analysis_id) Return the first Analysisfeature filtered by the analysis_id column
 * @method Analysisfeature findOneByRawscore(double $rawscore) Return the first Analysisfeature filtered by the rawscore column
 * @method Analysisfeature findOneByNormscore(double $normscore) Return the first Analysisfeature filtered by the normscore column
 * @method Analysisfeature findOneBySignificance(double $significance) Return the first Analysisfeature filtered by the significance column
 * @method Analysisfeature findOneByIdentity(double $identity) Return the first Analysisfeature filtered by the identity column
 *
 * @method array findByAnalysisfeatureId(int $analysisfeature_id) Return Analysisfeature objects filtered by the analysisfeature_id column
 * @method array findByFeatureId(int $feature_id) Return Analysisfeature objects filtered by the feature_id column
 * @method array findByAnalysisId(int $analysis_id) Return Analysisfeature objects filtered by the analysis_id column
 * @method array findByRawscore(double $rawscore) Return Analysisfeature objects filtered by the rawscore column
 * @method array findByNormscore(double $normscore) Return Analysisfeature objects filtered by the normscore column
 * @method array findBySignificance(double $significance) Return Analysisfeature objects filtered by the significance column
 * @method array findByIdentity(double $identity) Return Analysisfeature objects filtered by the identity column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysisfeatureQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAnalysisfeatureQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Analysisfeature', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AnalysisfeatureQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AnalysisfeatureQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AnalysisfeatureQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AnalysisfeatureQuery) {
            return $criteria;
        }
        $query = new AnalysisfeatureQuery();
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
     * @return   Analysisfeature|Analysisfeature[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnalysisfeaturePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AnalysisfeaturePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Analysisfeature A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAnalysisfeatureId($key, $con = null)
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
     * @return                 Analysisfeature A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "analysisfeature_id", "feature_id", "analysis_id", "rawscore", "normscore", "significance", "identity" FROM "analysisfeature" WHERE "analysisfeature_id" = :p0';
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
            $obj = new Analysisfeature();
            $obj->hydrate($row);
            AnalysisfeaturePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Analysisfeature|Analysisfeature[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Analysisfeature[]|mixed the list of results, formatted by the current formatter
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
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $keys, Criteria::IN);
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
     * @param     mixed $analysisfeatureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByAnalysisfeatureId($analysisfeatureId = null, $comparison = null)
    {
        if (is_array($analysisfeatureId)) {
            $useMinMax = false;
            if (isset($analysisfeatureId['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $analysisfeatureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisfeatureId['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $analysisfeatureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $analysisfeatureId, $comparison);
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
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::FEATURE_ID, $featureId, $comparison);
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
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByAnalysisId($analysisId = null, $comparison = null)
    {
        if (is_array($analysisId)) {
            $useMinMax = false;
            if (isset($analysisId['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::ANALYSIS_ID, $analysisId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisId['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::ANALYSIS_ID, $analysisId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::ANALYSIS_ID, $analysisId, $comparison);
    }

    /**
     * Filter the query on the rawscore column
     *
     * Example usage:
     * <code>
     * $query->filterByRawscore(1234); // WHERE rawscore = 1234
     * $query->filterByRawscore(array(12, 34)); // WHERE rawscore IN (12, 34)
     * $query->filterByRawscore(array('min' => 12)); // WHERE rawscore >= 12
     * $query->filterByRawscore(array('max' => 12)); // WHERE rawscore <= 12
     * </code>
     *
     * @param     mixed $rawscore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByRawscore($rawscore = null, $comparison = null)
    {
        if (is_array($rawscore)) {
            $useMinMax = false;
            if (isset($rawscore['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::RAWSCORE, $rawscore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rawscore['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::RAWSCORE, $rawscore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::RAWSCORE, $rawscore, $comparison);
    }

    /**
     * Filter the query on the normscore column
     *
     * Example usage:
     * <code>
     * $query->filterByNormscore(1234); // WHERE normscore = 1234
     * $query->filterByNormscore(array(12, 34)); // WHERE normscore IN (12, 34)
     * $query->filterByNormscore(array('min' => 12)); // WHERE normscore >= 12
     * $query->filterByNormscore(array('max' => 12)); // WHERE normscore <= 12
     * </code>
     *
     * @param     mixed $normscore The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByNormscore($normscore = null, $comparison = null)
    {
        if (is_array($normscore)) {
            $useMinMax = false;
            if (isset($normscore['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::NORMSCORE, $normscore['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($normscore['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::NORMSCORE, $normscore['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::NORMSCORE, $normscore, $comparison);
    }

    /**
     * Filter the query on the significance column
     *
     * Example usage:
     * <code>
     * $query->filterBySignificance(1234); // WHERE significance = 1234
     * $query->filterBySignificance(array(12, 34)); // WHERE significance IN (12, 34)
     * $query->filterBySignificance(array('min' => 12)); // WHERE significance >= 12
     * $query->filterBySignificance(array('max' => 12)); // WHERE significance <= 12
     * </code>
     *
     * @param     mixed $significance The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterBySignificance($significance = null, $comparison = null)
    {
        if (is_array($significance)) {
            $useMinMax = false;
            if (isset($significance['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::SIGNIFICANCE, $significance['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($significance['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::SIGNIFICANCE, $significance['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::SIGNIFICANCE, $significance, $comparison);
    }

    /**
     * Filter the query on the identity column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentity(1234); // WHERE identity = 1234
     * $query->filterByIdentity(array(12, 34)); // WHERE identity IN (12, 34)
     * $query->filterByIdentity(array('min' => 12)); // WHERE identity >= 12
     * $query->filterByIdentity(array('max' => 12)); // WHERE identity <= 12
     * </code>
     *
     * @param     mixed $identity The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function filterByIdentity($identity = null, $comparison = null)
    {
        if (is_array($identity)) {
            $useMinMax = false;
            if (isset($identity['min'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::IDENTITY, $identity['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($identity['max'])) {
                $this->addUsingAlias(AnalysisfeaturePeer::IDENTITY, $identity['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisfeaturePeer::IDENTITY, $identity, $comparison);
    }

    /**
     * Filter the query by a related Analysis object
     *
     * @param   Analysis|PropelObjectCollection $analysis The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisfeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysis($analysis, $comparison = null)
    {
        if ($analysis instanceof Analysis) {
            return $this
                ->addUsingAlias(AnalysisfeaturePeer::ANALYSIS_ID, $analysis->getAnalysisId(), $comparison);
        } elseif ($analysis instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysisfeaturePeer::ANALYSIS_ID, $analysis->toKeyValue('PrimaryKey', 'AnalysisId'), $comparison);
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
     * @return AnalysisfeatureQuery The current query, for fluid interface
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
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisfeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(AnalysisfeaturePeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AnalysisfeaturePeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
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
     * @return AnalysisfeatureQuery The current query, for fluid interface
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
     * Filter the query by a related Analysisfeatureprop object
     *
     * @param   Analysisfeatureprop|PropelObjectCollection $analysisfeatureprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisfeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisfeatureprop($analysisfeatureprop, $comparison = null)
    {
        if ($analysisfeatureprop instanceof Analysisfeatureprop) {
            return $this
                ->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $analysisfeatureprop->getAnalysisfeatureId(), $comparison);
        } elseif ($analysisfeatureprop instanceof PropelObjectCollection) {
            return $this
                ->useAnalysisfeaturepropQuery()
                ->filterByPrimaryKeys($analysisfeatureprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnalysisfeatureprop() only accepts arguments of type Analysisfeatureprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisfeatureprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function joinAnalysisfeatureprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisfeatureprop');

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
            $this->addJoinObject($join, 'Analysisfeatureprop');
        }

        return $this;
    }

    /**
     * Use the Analysisfeatureprop relation Analysisfeatureprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisfeaturepropQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisfeaturepropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisfeatureprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisfeatureprop', '\cli_db\propel\AnalysisfeaturepropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Analysisfeature $analysisfeature Object to remove from the list of results
     *
     * @return AnalysisfeatureQuery The current query, for fluid interface
     */
    public function prune($analysisfeature = null)
    {
        if ($analysisfeature) {
            $this->addUsingAlias(AnalysisfeaturePeer::ANALYSISFEATURE_ID, $analysisfeature->getAnalysisfeatureId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
