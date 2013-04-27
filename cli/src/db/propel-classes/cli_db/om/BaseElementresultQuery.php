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
use cli_db\propel\Element;
use cli_db\propel\Elementresult;
use cli_db\propel\ElementresultPeer;
use cli_db\propel\ElementresultQuery;
use cli_db\propel\ElementresultRelationship;
use cli_db\propel\Quantification;

/**
 * Base class that represents a query for the 'elementresult' table.
 *
 *
 *
 * @method ElementresultQuery orderByElementresultId($order = Criteria::ASC) Order by the elementresult_id column
 * @method ElementresultQuery orderByElementId($order = Criteria::ASC) Order by the element_id column
 * @method ElementresultQuery orderByQuantificationId($order = Criteria::ASC) Order by the quantification_id column
 * @method ElementresultQuery orderBySignal($order = Criteria::ASC) Order by the signal column
 *
 * @method ElementresultQuery groupByElementresultId() Group by the elementresult_id column
 * @method ElementresultQuery groupByElementId() Group by the element_id column
 * @method ElementresultQuery groupByQuantificationId() Group by the quantification_id column
 * @method ElementresultQuery groupBySignal() Group by the signal column
 *
 * @method ElementresultQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ElementresultQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ElementresultQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ElementresultQuery leftJoinElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Element relation
 * @method ElementresultQuery rightJoinElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Element relation
 * @method ElementresultQuery innerJoinElement($relationAlias = null) Adds a INNER JOIN clause to the query using the Element relation
 *
 * @method ElementresultQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method ElementresultQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method ElementresultQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method ElementresultQuery leftJoinElementresultRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementresultRelationshipRelatedByObjectId relation
 * @method ElementresultQuery rightJoinElementresultRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementresultRelationshipRelatedByObjectId relation
 * @method ElementresultQuery innerJoinElementresultRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementresultRelationshipRelatedByObjectId relation
 *
 * @method ElementresultQuery leftJoinElementresultRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementresultRelationshipRelatedBySubjectId relation
 * @method ElementresultQuery rightJoinElementresultRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementresultRelationshipRelatedBySubjectId relation
 * @method ElementresultQuery innerJoinElementresultRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementresultRelationshipRelatedBySubjectId relation
 *
 * @method Elementresult findOne(PropelPDO $con = null) Return the first Elementresult matching the query
 * @method Elementresult findOneOrCreate(PropelPDO $con = null) Return the first Elementresult matching the query, or a new Elementresult object populated from the query conditions when no match is found
 *
 * @method Elementresult findOneByElementId(int $element_id) Return the first Elementresult filtered by the element_id column
 * @method Elementresult findOneByQuantificationId(int $quantification_id) Return the first Elementresult filtered by the quantification_id column
 * @method Elementresult findOneBySignal(double $signal) Return the first Elementresult filtered by the signal column
 *
 * @method array findByElementresultId(int $elementresult_id) Return Elementresult objects filtered by the elementresult_id column
 * @method array findByElementId(int $element_id) Return Elementresult objects filtered by the element_id column
 * @method array findByQuantificationId(int $quantification_id) Return Elementresult objects filtered by the quantification_id column
 * @method array findBySignal(double $signal) Return Elementresult objects filtered by the signal column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseElementresultQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseElementresultQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Elementresult', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ElementresultQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ElementresultQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ElementresultQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ElementresultQuery) {
            return $criteria;
        }
        $query = new ElementresultQuery();
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
     * @return   Elementresult|Elementresult[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ElementresultPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ElementresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Elementresult A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByElementresultId($key, $con = null)
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
     * @return                 Elementresult A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "elementresult_id", "element_id", "quantification_id", "signal" FROM "elementresult" WHERE "elementresult_id" = :p0';
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
            $obj = new Elementresult();
            $obj->hydrate($row);
            ElementresultPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Elementresult|Elementresult[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Elementresult[]|mixed the list of results, formatted by the current formatter
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
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the elementresult_id column
     *
     * Example usage:
     * <code>
     * $query->filterByElementresultId(1234); // WHERE elementresult_id = 1234
     * $query->filterByElementresultId(array(12, 34)); // WHERE elementresult_id IN (12, 34)
     * $query->filterByElementresultId(array('min' => 12)); // WHERE elementresult_id >= 12
     * $query->filterByElementresultId(array('max' => 12)); // WHERE elementresult_id <= 12
     * </code>
     *
     * @param     mixed $elementresultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterByElementresultId($elementresultId = null, $comparison = null)
    {
        if (is_array($elementresultId)) {
            $useMinMax = false;
            if (isset($elementresultId['min'])) {
                $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($elementresultId['max'])) {
                $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresultId, $comparison);
    }

    /**
     * Filter the query on the element_id column
     *
     * Example usage:
     * <code>
     * $query->filterByElementId(1234); // WHERE element_id = 1234
     * $query->filterByElementId(array(12, 34)); // WHERE element_id IN (12, 34)
     * $query->filterByElementId(array('min' => 12)); // WHERE element_id >= 12
     * $query->filterByElementId(array('max' => 12)); // WHERE element_id <= 12
     * </code>
     *
     * @see       filterByElement()
     *
     * @param     mixed $elementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterByElementId($elementId = null, $comparison = null)
    {
        if (is_array($elementId)) {
            $useMinMax = false;
            if (isset($elementId['min'])) {
                $this->addUsingAlias(ElementresultPeer::ELEMENT_ID, $elementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($elementId['max'])) {
                $this->addUsingAlias(ElementresultPeer::ELEMENT_ID, $elementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementresultPeer::ELEMENT_ID, $elementId, $comparison);
    }

    /**
     * Filter the query on the quantification_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationId(1234); // WHERE quantification_id = 1234
     * $query->filterByQuantificationId(array(12, 34)); // WHERE quantification_id IN (12, 34)
     * $query->filterByQuantificationId(array('min' => 12)); // WHERE quantification_id >= 12
     * $query->filterByQuantificationId(array('max' => 12)); // WHERE quantification_id <= 12
     * </code>
     *
     * @see       filterByQuantification()
     *
     * @param     mixed $quantificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterByQuantificationId($quantificationId = null, $comparison = null)
    {
        if (is_array($quantificationId)) {
            $useMinMax = false;
            if (isset($quantificationId['min'])) {
                $this->addUsingAlias(ElementresultPeer::QUANTIFICATION_ID, $quantificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationId['max'])) {
                $this->addUsingAlias(ElementresultPeer::QUANTIFICATION_ID, $quantificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementresultPeer::QUANTIFICATION_ID, $quantificationId, $comparison);
    }

    /**
     * Filter the query on the signal column
     *
     * Example usage:
     * <code>
     * $query->filterBySignal(1234); // WHERE signal = 1234
     * $query->filterBySignal(array(12, 34)); // WHERE signal IN (12, 34)
     * $query->filterBySignal(array('min' => 12)); // WHERE signal >= 12
     * $query->filterBySignal(array('max' => 12)); // WHERE signal <= 12
     * </code>
     *
     * @param     mixed $signal The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function filterBySignal($signal = null, $comparison = null)
    {
        if (is_array($signal)) {
            $useMinMax = false;
            if (isset($signal['min'])) {
                $this->addUsingAlias(ElementresultPeer::SIGNAL, $signal['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($signal['max'])) {
                $this->addUsingAlias(ElementresultPeer::SIGNAL, $signal['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementresultPeer::SIGNAL, $signal, $comparison);
    }

    /**
     * Filter the query by a related Element object
     *
     * @param   Element|PropelObjectCollection $element The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElement($element, $comparison = null)
    {
        if ($element instanceof Element) {
            return $this
                ->addUsingAlias(ElementresultPeer::ELEMENT_ID, $element->getElementId(), $comparison);
        } elseif ($element instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementresultPeer::ELEMENT_ID, $element->toKeyValue('PrimaryKey', 'ElementId'), $comparison);
        } else {
            throw new PropelException('filterByElement() only accepts arguments of type Element or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Element relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function joinElement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Element');

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
            $this->addJoinObject($join, 'Element');
        }

        return $this;
    }

    /**
     * Use the Element relation Element object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Element', '\cli_db\propel\ElementQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(ElementresultPeer::QUANTIFICATION_ID, $quantification->getQuantificationId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementresultPeer::QUANTIFICATION_ID, $quantification->toKeyValue('PrimaryKey', 'QuantificationId'), $comparison);
        } else {
            throw new PropelException('filterByQuantification() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function joinQuantification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantification');

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
            $this->addJoinObject($join, 'Quantification');
        }

        return $this;
    }

    /**
     * Use the Quantification relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantification', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Filter the query by a related ElementresultRelationship object
     *
     * @param   ElementresultRelationship|PropelObjectCollection $elementresultRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementresultRelationshipRelatedByObjectId($elementresultRelationship, $comparison = null)
    {
        if ($elementresultRelationship instanceof ElementresultRelationship) {
            return $this
                ->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresultRelationship->getObjectId(), $comparison);
        } elseif ($elementresultRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementresultRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($elementresultRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementresultRelationshipRelatedByObjectId() only accepts arguments of type ElementresultRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementresultRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function joinElementresultRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementresultRelationshipRelatedByObjectId');

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
            $this->addJoinObject($join, 'ElementresultRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the ElementresultRelationshipRelatedByObjectId relation ElementresultRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementresultRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementresultRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementresultRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementresultRelationshipRelatedByObjectId', '\cli_db\propel\ElementresultRelationshipQuery');
    }

    /**
     * Filter the query by a related ElementresultRelationship object
     *
     * @param   ElementresultRelationship|PropelObjectCollection $elementresultRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementresultRelationshipRelatedBySubjectId($elementresultRelationship, $comparison = null)
    {
        if ($elementresultRelationship instanceof ElementresultRelationship) {
            return $this
                ->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresultRelationship->getSubjectId(), $comparison);
        } elseif ($elementresultRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementresultRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($elementresultRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementresultRelationshipRelatedBySubjectId() only accepts arguments of type ElementresultRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementresultRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function joinElementresultRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementresultRelationshipRelatedBySubjectId');

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
            $this->addJoinObject($join, 'ElementresultRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the ElementresultRelationshipRelatedBySubjectId relation ElementresultRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementresultRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementresultRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementresultRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementresultRelationshipRelatedBySubjectId', '\cli_db\propel\ElementresultRelationshipQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Elementresult $elementresult Object to remove from the list of results
     *
     * @return ElementresultQuery The current query, for fluid interface
     */
    public function prune($elementresult = null)
    {
        if ($elementresult) {
            $this->addUsingAlias(ElementresultPeer::ELEMENTRESULT_ID, $elementresult->getElementresultId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
