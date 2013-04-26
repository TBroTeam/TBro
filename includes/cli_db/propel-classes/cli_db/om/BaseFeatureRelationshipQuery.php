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
use cli_db\propel\FeatureRelationship;
use cli_db\propel\FeatureRelationshipPeer;
use cli_db\propel\FeatureRelationshipPub;
use cli_db\propel\FeatureRelationshipQuery;
use cli_db\propel\FeatureRelationshipprop;

/**
 * Base class that represents a query for the 'feature_relationship' table.
 *
 *
 *
 * @method FeatureRelationshipQuery orderByFeatureRelationshipId($order = Criteria::ASC) Order by the feature_relationship_id column
 * @method FeatureRelationshipQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method FeatureRelationshipQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method FeatureRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method FeatureRelationshipQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method FeatureRelationshipQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method FeatureRelationshipQuery groupByFeatureRelationshipId() Group by the feature_relationship_id column
 * @method FeatureRelationshipQuery groupBySubjectId() Group by the subject_id column
 * @method FeatureRelationshipQuery groupByObjectId() Group by the object_id column
 * @method FeatureRelationshipQuery groupByTypeId() Group by the type_id column
 * @method FeatureRelationshipQuery groupByValue() Group by the value column
 * @method FeatureRelationshipQuery groupByRank() Group by the rank column
 *
 * @method FeatureRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureRelationshipQuery leftJoinFeatureRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelatedByObjectId relation
 * @method FeatureRelationshipQuery rightJoinFeatureRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelatedByObjectId relation
 * @method FeatureRelationshipQuery innerJoinFeatureRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelatedByObjectId relation
 *
 * @method FeatureRelationshipQuery leftJoinFeatureRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelatedBySubjectId relation
 * @method FeatureRelationshipQuery rightJoinFeatureRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelatedBySubjectId relation
 * @method FeatureRelationshipQuery innerJoinFeatureRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelatedBySubjectId relation
 *
 * @method FeatureRelationshipQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method FeatureRelationshipQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method FeatureRelationshipQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method FeatureRelationshipQuery leftJoinFeatureRelationshipPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationshipPub relation
 * @method FeatureRelationshipQuery rightJoinFeatureRelationshipPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationshipPub relation
 * @method FeatureRelationshipQuery innerJoinFeatureRelationshipPub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationshipPub relation
 *
 * @method FeatureRelationshipQuery leftJoinFeatureRelationshipprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelationshipprop relation
 * @method FeatureRelationshipQuery rightJoinFeatureRelationshipprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelationshipprop relation
 * @method FeatureRelationshipQuery innerJoinFeatureRelationshipprop($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelationshipprop relation
 *
 * @method FeatureRelationship findOne(PropelPDO $con = null) Return the first FeatureRelationship matching the query
 * @method FeatureRelationship findOneOrCreate(PropelPDO $con = null) Return the first FeatureRelationship matching the query, or a new FeatureRelationship object populated from the query conditions when no match is found
 *
 * @method FeatureRelationship findOneBySubjectId(int $subject_id) Return the first FeatureRelationship filtered by the subject_id column
 * @method FeatureRelationship findOneByObjectId(int $object_id) Return the first FeatureRelationship filtered by the object_id column
 * @method FeatureRelationship findOneByTypeId(int $type_id) Return the first FeatureRelationship filtered by the type_id column
 * @method FeatureRelationship findOneByValue(string $value) Return the first FeatureRelationship filtered by the value column
 * @method FeatureRelationship findOneByRank(int $rank) Return the first FeatureRelationship filtered by the rank column
 *
 * @method array findByFeatureRelationshipId(int $feature_relationship_id) Return FeatureRelationship objects filtered by the feature_relationship_id column
 * @method array findBySubjectId(int $subject_id) Return FeatureRelationship objects filtered by the subject_id column
 * @method array findByObjectId(int $object_id) Return FeatureRelationship objects filtered by the object_id column
 * @method array findByTypeId(int $type_id) Return FeatureRelationship objects filtered by the type_id column
 * @method array findByValue(string $value) Return FeatureRelationship objects filtered by the value column
 * @method array findByRank(int $rank) Return FeatureRelationship objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureRelationshipQuery) {
            return $criteria;
        }
        $query = new FeatureRelationshipQuery();
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
     * @return   FeatureRelationship|FeatureRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureRelationshipId($key, $con = null)
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
     * @return                 FeatureRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_relationship_id", "subject_id", "object_id", "type_id", "value", "rank" FROM "feature_relationship" WHERE "feature_relationship_id" = :p0';
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
            $obj = new FeatureRelationship();
            $obj->hydrate($row);
            FeatureRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureRelationship|FeatureRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureRelationshipId(1234); // WHERE feature_relationship_id = 1234
     * $query->filterByFeatureRelationshipId(array(12, 34)); // WHERE feature_relationship_id IN (12, 34)
     * $query->filterByFeatureRelationshipId(array('min' => 12)); // WHERE feature_relationship_id >= 12
     * $query->filterByFeatureRelationshipId(array('max' => 12)); // WHERE feature_relationship_id <= 12
     * </code>
     *
     * @param     mixed $featureRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByFeatureRelationshipId($featureRelationshipId = null, $comparison = null)
    {
        if (is_array($featureRelationshipId)) {
            $useMinMax = false;
            if (isset($featureRelationshipId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureRelationshipId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipId, $comparison);
    }

    /**
     * Filter the query on the subject_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectId(1234); // WHERE subject_id = 1234
     * $query->filterBySubjectId(array(12, 34)); // WHERE subject_id IN (12, 34)
     * $query->filterBySubjectId(array('min' => 12)); // WHERE subject_id >= 12
     * $query->filterBySubjectId(array('max' => 12)); // WHERE subject_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPeer::SUBJECT_ID, $subjectId, $comparison);
    }

    /**
     * Filter the query on the object_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectId(1234); // WHERE object_id = 1234
     * $query->filterByObjectId(array(12, 34)); // WHERE object_id IN (12, 34)
     * $query->filterByObjectId(array('min' => 12)); // WHERE object_id >= 12
     * $query->filterByObjectId(array('max' => 12)); // WHERE object_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelatedByObjectId()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPeer::OBJECT_ID, $objectId, $comparison);
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
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPeer::TYPE_ID, $typeId, $comparison);
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
     * @return FeatureRelationshipQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FeatureRelationshipPeer::VALUE, $value, $comparison);
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
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(FeatureRelationshipPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureRelationshipPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelatedByObjectId($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeatureRelationshipPeer::OBJECT_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshipPeer::OBJECT_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelatedByObjectId() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function joinFeatureRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelatedByObjectId');

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
            $this->addJoinObject($join, 'FeatureRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the FeatureRelatedByObjectId relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelatedByObjectId', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelatedBySubjectId($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeatureRelationshipPeer::SUBJECT_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshipPeer::SUBJECT_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelatedBySubjectId() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function joinFeatureRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelatedBySubjectId');

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
            $this->addJoinObject($join, 'FeatureRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the FeatureRelatedBySubjectId relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelatedBySubjectId', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(FeatureRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return FeatureRelationshipQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureRelationshipPub object
     *
     * @param   FeatureRelationshipPub|PropelObjectCollection $featureRelationshipPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationshipPub($featureRelationshipPub, $comparison = null)
    {
        if ($featureRelationshipPub instanceof FeatureRelationshipPub) {
            return $this
                ->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipPub->getFeatureRelationshipId(), $comparison);
        } elseif ($featureRelationshipPub instanceof PropelObjectCollection) {
            return $this
                ->useFeatureRelationshipPubQuery()
                ->filterByPrimaryKeys($featureRelationshipPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureRelationshipPub() only accepts arguments of type FeatureRelationshipPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationshipPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function joinFeatureRelationshipPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationshipPub');

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
            $this->addJoinObject($join, 'FeatureRelationshipPub');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationshipPub relation FeatureRelationshipPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshipPubQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshipPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationshipPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationshipPub', '\cli_db\propel\FeatureRelationshipPubQuery');
    }

    /**
     * Filter the query by a related FeatureRelationshipprop object
     *
     * @param   FeatureRelationshipprop|PropelObjectCollection $featureRelationshipprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelationshipprop($featureRelationshipprop, $comparison = null)
    {
        if ($featureRelationshipprop instanceof FeatureRelationshipprop) {
            return $this
                ->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationshipprop->getFeatureRelationshipId(), $comparison);
        } elseif ($featureRelationshipprop instanceof PropelObjectCollection) {
            return $this
                ->useFeatureRelationshippropQuery()
                ->filterByPrimaryKeys($featureRelationshipprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureRelationshipprop() only accepts arguments of type FeatureRelationshipprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelationshipprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function joinFeatureRelationshipprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelationshipprop');

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
            $this->addJoinObject($join, 'FeatureRelationshipprop');
        }

        return $this;
    }

    /**
     * Use the FeatureRelationshipprop relation FeatureRelationshipprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureRelationshippropQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelationshippropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelationshipprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelationshipprop', '\cli_db\propel\FeatureRelationshippropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureRelationship $featureRelationship Object to remove from the list of results
     *
     * @return FeatureRelationshipQuery The current query, for fluid interface
     */
    public function prune($featureRelationship = null)
    {
        if ($featureRelationship) {
            $this->addUsingAlias(FeatureRelationshipPeer::FEATURE_RELATIONSHIP_ID, $featureRelationship->getFeatureRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
