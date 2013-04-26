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
use cli_db\propel\CvtermRelationship;
use cli_db\propel\CvtermRelationshipPeer;
use cli_db\propel\CvtermRelationshipQuery;

/**
 * Base class that represents a query for the 'cvterm_relationship' table.
 *
 *
 *
 * @method CvtermRelationshipQuery orderByCvtermRelationshipId($order = Criteria::ASC) Order by the cvterm_relationship_id column
 * @method CvtermRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method CvtermRelationshipQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method CvtermRelationshipQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 *
 * @method CvtermRelationshipQuery groupByCvtermRelationshipId() Group by the cvterm_relationship_id column
 * @method CvtermRelationshipQuery groupByTypeId() Group by the type_id column
 * @method CvtermRelationshipQuery groupBySubjectId() Group by the subject_id column
 * @method CvtermRelationshipQuery groupByObjectId() Group by the object_id column
 *
 * @method CvtermRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvtermRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvtermRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvtermRelationshipQuery leftJoinCvtermRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByObjectId relation
 * @method CvtermRelationshipQuery rightJoinCvtermRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByObjectId relation
 * @method CvtermRelationshipQuery innerJoinCvtermRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByObjectId relation
 *
 * @method CvtermRelationshipQuery leftJoinCvtermRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedBySubjectId relation
 * @method CvtermRelationshipQuery rightJoinCvtermRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedBySubjectId relation
 * @method CvtermRelationshipQuery innerJoinCvtermRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedBySubjectId relation
 *
 * @method CvtermRelationshipQuery leftJoinCvtermRelatedByTypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByTypeId relation
 * @method CvtermRelationshipQuery rightJoinCvtermRelatedByTypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByTypeId relation
 * @method CvtermRelationshipQuery innerJoinCvtermRelatedByTypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByTypeId relation
 *
 * @method CvtermRelationship findOne(PropelPDO $con = null) Return the first CvtermRelationship matching the query
 * @method CvtermRelationship findOneOrCreate(PropelPDO $con = null) Return the first CvtermRelationship matching the query, or a new CvtermRelationship object populated from the query conditions when no match is found
 *
 * @method CvtermRelationship findOneByTypeId(int $type_id) Return the first CvtermRelationship filtered by the type_id column
 * @method CvtermRelationship findOneBySubjectId(int $subject_id) Return the first CvtermRelationship filtered by the subject_id column
 * @method CvtermRelationship findOneByObjectId(int $object_id) Return the first CvtermRelationship filtered by the object_id column
 *
 * @method array findByCvtermRelationshipId(int $cvterm_relationship_id) Return CvtermRelationship objects filtered by the cvterm_relationship_id column
 * @method array findByTypeId(int $type_id) Return CvtermRelationship objects filtered by the type_id column
 * @method array findBySubjectId(int $subject_id) Return CvtermRelationship objects filtered by the subject_id column
 * @method array findByObjectId(int $object_id) Return CvtermRelationship objects filtered by the object_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvtermRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\CvtermRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvtermRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvtermRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvtermRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvtermRelationshipQuery) {
            return $criteria;
        }
        $query = new CvtermRelationshipQuery();
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
     * @return   CvtermRelationship|CvtermRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvtermRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvtermRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 CvtermRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvtermRelationshipId($key, $con = null)
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
     * @return                 CvtermRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cvterm_relationship_id", "type_id", "subject_id", "object_id" FROM "cvterm_relationship" WHERE "cvterm_relationship_id" = :p0';
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
            $obj = new CvtermRelationship();
            $obj->hydrate($row);
            CvtermRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return CvtermRelationship|CvtermRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|CvtermRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cvterm_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermRelationshipId(1234); // WHERE cvterm_relationship_id = 1234
     * $query->filterByCvtermRelationshipId(array(12, 34)); // WHERE cvterm_relationship_id IN (12, 34)
     * $query->filterByCvtermRelationshipId(array('min' => 12)); // WHERE cvterm_relationship_id >= 12
     * $query->filterByCvtermRelationshipId(array('max' => 12)); // WHERE cvterm_relationship_id <= 12
     * </code>
     *
     * @param     mixed $cvtermRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterByCvtermRelationshipId($cvtermRelationshipId = null, $comparison = null)
    {
        if (is_array($cvtermRelationshipId)) {
            $useMinMax = false;
            if (isset($cvtermRelationshipId['min'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $cvtermRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermRelationshipId['max'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $cvtermRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $cvtermRelationshipId, $comparison);
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
     * @see       filterByCvtermRelatedByTypeId()
     *
     * @param     mixed $typeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermRelationshipPeer::TYPE_ID, $typeId, $comparison);
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
     * @see       filterByCvtermRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermRelationshipPeer::SUBJECT_ID, $subjectId, $comparison);
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
     * @see       filterByCvtermRelatedByObjectId()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(CvtermRelationshipPeer::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermRelationshipPeer::OBJECT_ID, $objectId, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByObjectId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermRelationshipPeer::OBJECT_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermRelationshipPeer::OBJECT_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByObjectId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByObjectId');

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
            $this->addJoinObject($join, 'CvtermRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByObjectId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByObjectId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedBySubjectId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermRelationshipPeer::SUBJECT_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermRelationshipPeer::SUBJECT_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedBySubjectId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedBySubjectId');

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
            $this->addJoinObject($join, 'CvtermRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedBySubjectId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedBySubjectId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByTypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByTypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByTypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByTypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByTypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedByTypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByTypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByTypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedByTypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByTypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   CvtermRelationship $cvtermRelationship Object to remove from the list of results
     *
     * @return CvtermRelationshipQuery The current query, for fluid interface
     */
    public function prune($cvtermRelationship = null)
    {
        if ($cvtermRelationship) {
            $this->addUsingAlias(CvtermRelationshipPeer::CVTERM_RELATIONSHIP_ID, $cvtermRelationship->getCvtermRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
