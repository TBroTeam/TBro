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
use cli_db\propel\Acquisition;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\AcquisitionRelationshipPeer;
use cli_db\propel\AcquisitionRelationshipQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'acquisition_relationship' table.
 *
 *
 *
 * @method AcquisitionRelationshipQuery orderByAcquisitionRelationshipId($order = Criteria::ASC) Order by the acquisition_relationship_id column
 * @method AcquisitionRelationshipQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method AcquisitionRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method AcquisitionRelationshipQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method AcquisitionRelationshipQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method AcquisitionRelationshipQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AcquisitionRelationshipQuery groupByAcquisitionRelationshipId() Group by the acquisition_relationship_id column
 * @method AcquisitionRelationshipQuery groupBySubjectId() Group by the subject_id column
 * @method AcquisitionRelationshipQuery groupByTypeId() Group by the type_id column
 * @method AcquisitionRelationshipQuery groupByObjectId() Group by the object_id column
 * @method AcquisitionRelationshipQuery groupByValue() Group by the value column
 * @method AcquisitionRelationshipQuery groupByRank() Group by the rank column
 *
 * @method AcquisitionRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AcquisitionRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AcquisitionRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AcquisitionRelationshipQuery leftJoinAcquisitionRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AcquisitionRelatedByObjectId relation
 * @method AcquisitionRelationshipQuery rightJoinAcquisitionRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AcquisitionRelatedByObjectId relation
 * @method AcquisitionRelationshipQuery innerJoinAcquisitionRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the AcquisitionRelatedByObjectId relation
 *
 * @method AcquisitionRelationshipQuery leftJoinAcquisitionRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AcquisitionRelatedBySubjectId relation
 * @method AcquisitionRelationshipQuery rightJoinAcquisitionRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AcquisitionRelatedBySubjectId relation
 * @method AcquisitionRelationshipQuery innerJoinAcquisitionRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the AcquisitionRelatedBySubjectId relation
 *
 * @method AcquisitionRelationshipQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method AcquisitionRelationshipQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method AcquisitionRelationshipQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method AcquisitionRelationship findOne(PropelPDO $con = null) Return the first AcquisitionRelationship matching the query
 * @method AcquisitionRelationship findOneOrCreate(PropelPDO $con = null) Return the first AcquisitionRelationship matching the query, or a new AcquisitionRelationship object populated from the query conditions when no match is found
 *
 * @method AcquisitionRelationship findOneBySubjectId(int $subject_id) Return the first AcquisitionRelationship filtered by the subject_id column
 * @method AcquisitionRelationship findOneByTypeId(int $type_id) Return the first AcquisitionRelationship filtered by the type_id column
 * @method AcquisitionRelationship findOneByObjectId(int $object_id) Return the first AcquisitionRelationship filtered by the object_id column
 * @method AcquisitionRelationship findOneByValue(string $value) Return the first AcquisitionRelationship filtered by the value column
 * @method AcquisitionRelationship findOneByRank(int $rank) Return the first AcquisitionRelationship filtered by the rank column
 *
 * @method array findByAcquisitionRelationshipId(int $acquisition_relationship_id) Return AcquisitionRelationship objects filtered by the acquisition_relationship_id column
 * @method array findBySubjectId(int $subject_id) Return AcquisitionRelationship objects filtered by the subject_id column
 * @method array findByTypeId(int $type_id) Return AcquisitionRelationship objects filtered by the type_id column
 * @method array findByObjectId(int $object_id) Return AcquisitionRelationship objects filtered by the object_id column
 * @method array findByValue(string $value) Return AcquisitionRelationship objects filtered by the value column
 * @method array findByRank(int $rank) Return AcquisitionRelationship objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAcquisitionRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAcquisitionRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\AcquisitionRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AcquisitionRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AcquisitionRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AcquisitionRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AcquisitionRelationshipQuery) {
            return $criteria;
        }
        $query = new AcquisitionRelationshipQuery();
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
     * @return   AcquisitionRelationship|AcquisitionRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AcquisitionRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AcquisitionRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAcquisitionRelationshipId($key, $con = null)
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
     * @return                 AcquisitionRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "acquisition_relationship_id", "subject_id", "type_id", "object_id", "value", "rank" FROM "acquisition_relationship" WHERE "acquisition_relationship_id" = :p0';
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
            $obj = new AcquisitionRelationship();
            $obj->hydrate($row);
            AcquisitionRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AcquisitionRelationship|AcquisitionRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AcquisitionRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the acquisition_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAcquisitionRelationshipId(1234); // WHERE acquisition_relationship_id = 1234
     * $query->filterByAcquisitionRelationshipId(array(12, 34)); // WHERE acquisition_relationship_id IN (12, 34)
     * $query->filterByAcquisitionRelationshipId(array('min' => 12)); // WHERE acquisition_relationship_id >= 12
     * $query->filterByAcquisitionRelationshipId(array('max' => 12)); // WHERE acquisition_relationship_id <= 12
     * </code>
     *
     * @param     mixed $acquisitionRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByAcquisitionRelationshipId($acquisitionRelationshipId = null, $comparison = null)
    {
        if (is_array($acquisitionRelationshipId)) {
            $useMinMax = false;
            if (isset($acquisitionRelationshipId['min'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $acquisitionRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitionRelationshipId['max'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $acquisitionRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $acquisitionRelationshipId, $comparison);
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
     * @see       filterByAcquisitionRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionRelationshipPeer::SUBJECT_ID, $subjectId, $comparison);
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
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionRelationshipPeer::TYPE_ID, $typeId, $comparison);
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
     * @see       filterByAcquisitionRelatedByObjectId()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionRelationshipPeer::OBJECT_ID, $objectId, $comparison);
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
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AcquisitionRelationshipPeer::VALUE, $value, $comparison);
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
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AcquisitionRelationshipPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionRelationshipPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionRelatedByObjectId($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::OBJECT_ID, $acquisition->getAcquisitionId(), $comparison);
        } elseif ($acquisition instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::OBJECT_ID, $acquisition->toKeyValue('PrimaryKey', 'AcquisitionId'), $comparison);
        } else {
            throw new PropelException('filterByAcquisitionRelatedByObjectId() only accepts arguments of type Acquisition or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AcquisitionRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function joinAcquisitionRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AcquisitionRelatedByObjectId');

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
            $this->addJoinObject($join, 'AcquisitionRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the AcquisitionRelatedByObjectId relation Acquisition object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AcquisitionRelatedByObjectId', '\cli_db\propel\AcquisitionQuery');
    }

    /**
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionRelatedBySubjectId($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::SUBJECT_ID, $acquisition->getAcquisitionId(), $comparison);
        } elseif ($acquisition instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::SUBJECT_ID, $acquisition->toKeyValue('PrimaryKey', 'AcquisitionId'), $comparison);
        } else {
            throw new PropelException('filterByAcquisitionRelatedBySubjectId() only accepts arguments of type Acquisition or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AcquisitionRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function joinAcquisitionRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AcquisitionRelatedBySubjectId');

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
            $this->addJoinObject($join, 'AcquisitionRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the AcquisitionRelatedBySubjectId relation Acquisition object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AcquisitionRelatedBySubjectId', '\cli_db\propel\AcquisitionQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
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
     * @param   AcquisitionRelationship $acquisitionRelationship Object to remove from the list of results
     *
     * @return AcquisitionRelationshipQuery The current query, for fluid interface
     */
    public function prune($acquisitionRelationship = null)
    {
        if ($acquisitionRelationship) {
            $this->addUsingAlias(AcquisitionRelationshipPeer::ACQUISITION_RELATIONSHIP_ID, $acquisitionRelationship->getAcquisitionRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
