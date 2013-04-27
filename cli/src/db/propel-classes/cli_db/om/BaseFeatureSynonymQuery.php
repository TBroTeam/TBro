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
use cli_db\propel\Feature;
use cli_db\propel\FeatureSynonym;
use cli_db\propel\FeatureSynonymPeer;
use cli_db\propel\FeatureSynonymQuery;
use cli_db\propel\Pub;
use cli_db\propel\Synonym;

/**
 * Base class that represents a query for the 'feature_synonym' table.
 *
 *
 *
 * @method FeatureSynonymQuery orderByFeatureSynonymId($order = Criteria::ASC) Order by the feature_synonym_id column
 * @method FeatureSynonymQuery orderBySynonymId($order = Criteria::ASC) Order by the synonym_id column
 * @method FeatureSynonymQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method FeatureSynonymQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method FeatureSynonymQuery orderByIsCurrent($order = Criteria::ASC) Order by the is_current column
 * @method FeatureSynonymQuery orderByIsInternal($order = Criteria::ASC) Order by the is_internal column
 *
 * @method FeatureSynonymQuery groupByFeatureSynonymId() Group by the feature_synonym_id column
 * @method FeatureSynonymQuery groupBySynonymId() Group by the synonym_id column
 * @method FeatureSynonymQuery groupByFeatureId() Group by the feature_id column
 * @method FeatureSynonymQuery groupByPubId() Group by the pub_id column
 * @method FeatureSynonymQuery groupByIsCurrent() Group by the is_current column
 * @method FeatureSynonymQuery groupByIsInternal() Group by the is_internal column
 *
 * @method FeatureSynonymQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureSynonymQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureSynonymQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureSynonymQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method FeatureSynonymQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method FeatureSynonymQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method FeatureSynonymQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method FeatureSynonymQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method FeatureSynonymQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method FeatureSynonymQuery leftJoinSynonym($relationAlias = null) Adds a LEFT JOIN clause to the query using the Synonym relation
 * @method FeatureSynonymQuery rightJoinSynonym($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Synonym relation
 * @method FeatureSynonymQuery innerJoinSynonym($relationAlias = null) Adds a INNER JOIN clause to the query using the Synonym relation
 *
 * @method FeatureSynonym findOne(PropelPDO $con = null) Return the first FeatureSynonym matching the query
 * @method FeatureSynonym findOneOrCreate(PropelPDO $con = null) Return the first FeatureSynonym matching the query, or a new FeatureSynonym object populated from the query conditions when no match is found
 *
 * @method FeatureSynonym findOneBySynonymId(int $synonym_id) Return the first FeatureSynonym filtered by the synonym_id column
 * @method FeatureSynonym findOneByFeatureId(int $feature_id) Return the first FeatureSynonym filtered by the feature_id column
 * @method FeatureSynonym findOneByPubId(int $pub_id) Return the first FeatureSynonym filtered by the pub_id column
 * @method FeatureSynonym findOneByIsCurrent(boolean $is_current) Return the first FeatureSynonym filtered by the is_current column
 * @method FeatureSynonym findOneByIsInternal(boolean $is_internal) Return the first FeatureSynonym filtered by the is_internal column
 *
 * @method array findByFeatureSynonymId(int $feature_synonym_id) Return FeatureSynonym objects filtered by the feature_synonym_id column
 * @method array findBySynonymId(int $synonym_id) Return FeatureSynonym objects filtered by the synonym_id column
 * @method array findByFeatureId(int $feature_id) Return FeatureSynonym objects filtered by the feature_id column
 * @method array findByPubId(int $pub_id) Return FeatureSynonym objects filtered by the pub_id column
 * @method array findByIsCurrent(boolean $is_current) Return FeatureSynonym objects filtered by the is_current column
 * @method array findByIsInternal(boolean $is_internal) Return FeatureSynonym objects filtered by the is_internal column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureSynonymQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureSynonymQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureSynonym', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureSynonymQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureSynonymQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureSynonymQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureSynonymQuery) {
            return $criteria;
        }
        $query = new FeatureSynonymQuery();
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
     * @return   FeatureSynonym|FeatureSynonym[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureSynonymPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureSynonymPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureSynonym A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureSynonymId($key, $con = null)
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
     * @return                 FeatureSynonym A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_synonym_id", "synonym_id", "feature_id", "pub_id", "is_current", "is_internal" FROM "feature_synonym" WHERE "feature_synonym_id" = :p0';
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
            $obj = new FeatureSynonym();
            $obj->hydrate($row);
            FeatureSynonymPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureSynonym|FeatureSynonym[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureSynonym[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_synonym_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureSynonymId(1234); // WHERE feature_synonym_id = 1234
     * $query->filterByFeatureSynonymId(array(12, 34)); // WHERE feature_synonym_id IN (12, 34)
     * $query->filterByFeatureSynonymId(array('min' => 12)); // WHERE feature_synonym_id >= 12
     * $query->filterByFeatureSynonymId(array('max' => 12)); // WHERE feature_synonym_id <= 12
     * </code>
     *
     * @param     mixed $featureSynonymId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByFeatureSynonymId($featureSynonymId = null, $comparison = null)
    {
        if (is_array($featureSynonymId)) {
            $useMinMax = false;
            if (isset($featureSynonymId['min'])) {
                $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $featureSynonymId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureSynonymId['max'])) {
                $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $featureSynonymId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $featureSynonymId, $comparison);
    }

    /**
     * Filter the query on the synonym_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySynonymId(1234); // WHERE synonym_id = 1234
     * $query->filterBySynonymId(array(12, 34)); // WHERE synonym_id IN (12, 34)
     * $query->filterBySynonymId(array('min' => 12)); // WHERE synonym_id >= 12
     * $query->filterBySynonymId(array('max' => 12)); // WHERE synonym_id <= 12
     * </code>
     *
     * @see       filterBySynonym()
     *
     * @param     mixed $synonymId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterBySynonymId($synonymId = null, $comparison = null)
    {
        if (is_array($synonymId)) {
            $useMinMax = false;
            if (isset($synonymId['min'])) {
                $this->addUsingAlias(FeatureSynonymPeer::SYNONYM_ID, $synonymId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($synonymId['max'])) {
                $this->addUsingAlias(FeatureSynonymPeer::SYNONYM_ID, $synonymId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureSynonymPeer::SYNONYM_ID, $synonymId, $comparison);
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
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(FeatureSynonymPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(FeatureSynonymPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureSynonymPeer::FEATURE_ID, $featureId, $comparison);
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
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(FeatureSynonymPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(FeatureSynonymPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureSynonymPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query on the is_current column
     *
     * Example usage:
     * <code>
     * $query->filterByIsCurrent(true); // WHERE is_current = true
     * $query->filterByIsCurrent('yes'); // WHERE is_current = true
     * </code>
     *
     * @param     boolean|string $isCurrent The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByIsCurrent($isCurrent = null, $comparison = null)
    {
        if (is_string($isCurrent)) {
            $isCurrent = in_array(strtolower($isCurrent), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeatureSynonymPeer::IS_CURRENT, $isCurrent, $comparison);
    }

    /**
     * Filter the query on the is_internal column
     *
     * Example usage:
     * <code>
     * $query->filterByIsInternal(true); // WHERE is_internal = true
     * $query->filterByIsInternal('yes'); // WHERE is_internal = true
     * </code>
     *
     * @param     boolean|string $isInternal The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function filterByIsInternal($isInternal = null, $comparison = null)
    {
        if (is_string($isInternal)) {
            $isInternal = in_array(strtolower($isInternal), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeatureSynonymPeer::IS_INTERNAL, $isInternal, $comparison);
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureSynonymQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeatureSynonymPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureSynonymPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
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
     * @return FeatureSynonymQuery The current query, for fluid interface
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
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureSynonymQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(FeatureSynonymPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureSynonymPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return FeatureSynonymQuery The current query, for fluid interface
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
     * Filter the query by a related Synonym object
     *
     * @param   Synonym|PropelObjectCollection $synonym The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureSynonymQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterBySynonym($synonym, $comparison = null)
    {
        if ($synonym instanceof Synonym) {
            return $this
                ->addUsingAlias(FeatureSynonymPeer::SYNONYM_ID, $synonym->getSynonymId(), $comparison);
        } elseif ($synonym instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureSynonymPeer::SYNONYM_ID, $synonym->toKeyValue('PrimaryKey', 'SynonymId'), $comparison);
        } else {
            throw new PropelException('filterBySynonym() only accepts arguments of type Synonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Synonym relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function joinSynonym($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Synonym');

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
            $this->addJoinObject($join, 'Synonym');
        }

        return $this;
    }

    /**
     * Use the Synonym relation Synonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\SynonymQuery A secondary query class using the current class as primary query
     */
    public function useSynonymQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinSynonym($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Synonym', '\cli_db\propel\SynonymQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureSynonym $featureSynonym Object to remove from the list of results
     *
     * @return FeatureSynonymQuery The current query, for fluid interface
     */
    public function prune($featureSynonym = null)
    {
        if ($featureSynonym) {
            $this->addUsingAlias(FeatureSynonymPeer::FEATURE_SYNONYM_ID, $featureSynonym->getFeatureSynonymId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
