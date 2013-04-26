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
use cli_db\propel\Element;
use cli_db\propel\ElementRelationship;
use cli_db\propel\ElementRelationshipPeer;
use cli_db\propel\ElementRelationshipQuery;

/**
 * Base class that represents a query for the 'element_relationship' table.
 *
 *
 *
 * @method ElementRelationshipQuery orderByElementRelationshipId($order = Criteria::ASC) Order by the element_relationship_id column
 * @method ElementRelationshipQuery orderBySubjectId($order = Criteria::ASC) Order by the subject_id column
 * @method ElementRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method ElementRelationshipQuery orderByObjectId($order = Criteria::ASC) Order by the object_id column
 * @method ElementRelationshipQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method ElementRelationshipQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method ElementRelationshipQuery groupByElementRelationshipId() Group by the element_relationship_id column
 * @method ElementRelationshipQuery groupBySubjectId() Group by the subject_id column
 * @method ElementRelationshipQuery groupByTypeId() Group by the type_id column
 * @method ElementRelationshipQuery groupByObjectId() Group by the object_id column
 * @method ElementRelationshipQuery groupByValue() Group by the value column
 * @method ElementRelationshipQuery groupByRank() Group by the rank column
 *
 * @method ElementRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ElementRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ElementRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ElementRelationshipQuery leftJoinElementRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementRelatedByObjectId relation
 * @method ElementRelationshipQuery rightJoinElementRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementRelatedByObjectId relation
 * @method ElementRelationshipQuery innerJoinElementRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementRelatedByObjectId relation
 *
 * @method ElementRelationshipQuery leftJoinElementRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementRelatedBySubjectId relation
 * @method ElementRelationshipQuery rightJoinElementRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementRelatedBySubjectId relation
 * @method ElementRelationshipQuery innerJoinElementRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementRelatedBySubjectId relation
 *
 * @method ElementRelationshipQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method ElementRelationshipQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method ElementRelationshipQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method ElementRelationship findOne(PropelPDO $con = null) Return the first ElementRelationship matching the query
 * @method ElementRelationship findOneOrCreate(PropelPDO $con = null) Return the first ElementRelationship matching the query, or a new ElementRelationship object populated from the query conditions when no match is found
 *
 * @method ElementRelationship findOneBySubjectId(int $subject_id) Return the first ElementRelationship filtered by the subject_id column
 * @method ElementRelationship findOneByTypeId(int $type_id) Return the first ElementRelationship filtered by the type_id column
 * @method ElementRelationship findOneByObjectId(int $object_id) Return the first ElementRelationship filtered by the object_id column
 * @method ElementRelationship findOneByValue(string $value) Return the first ElementRelationship filtered by the value column
 * @method ElementRelationship findOneByRank(int $rank) Return the first ElementRelationship filtered by the rank column
 *
 * @method array findByElementRelationshipId(int $element_relationship_id) Return ElementRelationship objects filtered by the element_relationship_id column
 * @method array findBySubjectId(int $subject_id) Return ElementRelationship objects filtered by the subject_id column
 * @method array findByTypeId(int $type_id) Return ElementRelationship objects filtered by the type_id column
 * @method array findByObjectId(int $object_id) Return ElementRelationship objects filtered by the object_id column
 * @method array findByValue(string $value) Return ElementRelationship objects filtered by the value column
 * @method array findByRank(int $rank) Return ElementRelationship objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseElementRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseElementRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\ElementRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ElementRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ElementRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ElementRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ElementRelationshipQuery) {
            return $criteria;
        }
        $query = new ElementRelationshipQuery();
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
     * @return   ElementRelationship|ElementRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ElementRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ElementRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ElementRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByElementRelationshipId($key, $con = null)
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
     * @return                 ElementRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "element_relationship_id", "subject_id", "type_id", "object_id", "value", "rank" FROM "element_relationship" WHERE "element_relationship_id" = :p0';
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
            $obj = new ElementRelationship();
            $obj->hydrate($row);
            ElementRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ElementRelationship|ElementRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ElementRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the element_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByElementRelationshipId(1234); // WHERE element_relationship_id = 1234
     * $query->filterByElementRelationshipId(array(12, 34)); // WHERE element_relationship_id IN (12, 34)
     * $query->filterByElementRelationshipId(array('min' => 12)); // WHERE element_relationship_id >= 12
     * $query->filterByElementRelationshipId(array('max' => 12)); // WHERE element_relationship_id <= 12
     * </code>
     *
     * @param     mixed $elementRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByElementRelationshipId($elementRelationshipId = null, $comparison = null)
    {
        if (is_array($elementRelationshipId)) {
            $useMinMax = false;
            if (isset($elementRelationshipId['min'])) {
                $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $elementRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($elementRelationshipId['max'])) {
                $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $elementRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $elementRelationshipId, $comparison);
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
     * @see       filterByElementRelatedBySubjectId()
     *
     * @param     mixed $subjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectId($subjectId = null, $comparison = null)
    {
        if (is_array($subjectId)) {
            $useMinMax = false;
            if (isset($subjectId['min'])) {
                $this->addUsingAlias(ElementRelationshipPeer::SUBJECT_ID, $subjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectId['max'])) {
                $this->addUsingAlias(ElementRelationshipPeer::SUBJECT_ID, $subjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementRelationshipPeer::SUBJECT_ID, $subjectId, $comparison);
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
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(ElementRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(ElementRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementRelationshipPeer::TYPE_ID, $typeId, $comparison);
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
     * @see       filterByElementRelatedByObjectId()
     *
     * @param     mixed $objectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectId($objectId = null, $comparison = null)
    {
        if (is_array($objectId)) {
            $useMinMax = false;
            if (isset($objectId['min'])) {
                $this->addUsingAlias(ElementRelationshipPeer::OBJECT_ID, $objectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectId['max'])) {
                $this->addUsingAlias(ElementRelationshipPeer::OBJECT_ID, $objectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementRelationshipPeer::OBJECT_ID, $objectId, $comparison);
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
     * @return ElementRelationshipQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ElementRelationshipPeer::VALUE, $value, $comparison);
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
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(ElementRelationshipPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(ElementRelationshipPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementRelationshipPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Element object
     *
     * @param   Element|PropelObjectCollection $element The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementRelatedByObjectId($element, $comparison = null)
    {
        if ($element instanceof Element) {
            return $this
                ->addUsingAlias(ElementRelationshipPeer::OBJECT_ID, $element->getElementId(), $comparison);
        } elseif ($element instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementRelationshipPeer::OBJECT_ID, $element->toKeyValue('PrimaryKey', 'ElementId'), $comparison);
        } else {
            throw new PropelException('filterByElementRelatedByObjectId() only accepts arguments of type Element or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function joinElementRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementRelatedByObjectId');

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
            $this->addJoinObject($join, 'ElementRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the ElementRelatedByObjectId relation Element object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementRelatedByObjectId', '\cli_db\propel\ElementQuery');
    }

    /**
     * Filter the query by a related Element object
     *
     * @param   Element|PropelObjectCollection $element The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementRelatedBySubjectId($element, $comparison = null)
    {
        if ($element instanceof Element) {
            return $this
                ->addUsingAlias(ElementRelationshipPeer::SUBJECT_ID, $element->getElementId(), $comparison);
        } elseif ($element instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementRelationshipPeer::SUBJECT_ID, $element->toKeyValue('PrimaryKey', 'ElementId'), $comparison);
        } else {
            throw new PropelException('filterByElementRelatedBySubjectId() only accepts arguments of type Element or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function joinElementRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementRelatedBySubjectId');

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
            $this->addJoinObject($join, 'ElementRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the ElementRelatedBySubjectId relation Element object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementRelatedBySubjectId', '\cli_db\propel\ElementQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ElementRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return ElementRelationshipQuery The current query, for fluid interface
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
     * @param   ElementRelationship $elementRelationship Object to remove from the list of results
     *
     * @return ElementRelationshipQuery The current query, for fluid interface
     */
    public function prune($elementRelationship = null)
    {
        if ($elementRelationship) {
            $this->addUsingAlias(ElementRelationshipPeer::ELEMENT_RELATIONSHIP_ID, $elementRelationship->getElementRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
