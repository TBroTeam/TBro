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
use cli_db\propel\Arraydesign;
use cli_db\propel\Cvterm;
use cli_db\propel\Dbxref;
use cli_db\propel\Element;
use cli_db\propel\ElementPeer;
use cli_db\propel\ElementQuery;
use cli_db\propel\ElementRelationship;
use cli_db\propel\Elementresult;
use cli_db\propel\Feature;

/**
 * Base class that represents a query for the 'element' table.
 *
 *
 *
 * @method ElementQuery orderByElementId($order = Criteria::ASC) Order by the element_id column
 * @method ElementQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method ElementQuery orderByArraydesignId($order = Criteria::ASC) Order by the arraydesign_id column
 * @method ElementQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method ElementQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 *
 * @method ElementQuery groupByElementId() Group by the element_id column
 * @method ElementQuery groupByFeatureId() Group by the feature_id column
 * @method ElementQuery groupByArraydesignId() Group by the arraydesign_id column
 * @method ElementQuery groupByTypeId() Group by the type_id column
 * @method ElementQuery groupByDbxrefId() Group by the dbxref_id column
 *
 * @method ElementQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ElementQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ElementQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ElementQuery leftJoinArraydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arraydesign relation
 * @method ElementQuery rightJoinArraydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arraydesign relation
 * @method ElementQuery innerJoinArraydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Arraydesign relation
 *
 * @method ElementQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method ElementQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method ElementQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method ElementQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method ElementQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method ElementQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method ElementQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method ElementQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method ElementQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method ElementQuery leftJoinElementRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementRelationshipRelatedByObjectId relation
 * @method ElementQuery rightJoinElementRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementRelationshipRelatedByObjectId relation
 * @method ElementQuery innerJoinElementRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementRelationshipRelatedByObjectId relation
 *
 * @method ElementQuery leftJoinElementRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ElementRelationshipRelatedBySubjectId relation
 * @method ElementQuery rightJoinElementRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ElementRelationshipRelatedBySubjectId relation
 * @method ElementQuery innerJoinElementRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ElementRelationshipRelatedBySubjectId relation
 *
 * @method ElementQuery leftJoinElementresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the Elementresult relation
 * @method ElementQuery rightJoinElementresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Elementresult relation
 * @method ElementQuery innerJoinElementresult($relationAlias = null) Adds a INNER JOIN clause to the query using the Elementresult relation
 *
 * @method Element findOne(PropelPDO $con = null) Return the first Element matching the query
 * @method Element findOneOrCreate(PropelPDO $con = null) Return the first Element matching the query, or a new Element object populated from the query conditions when no match is found
 *
 * @method Element findOneByFeatureId(int $feature_id) Return the first Element filtered by the feature_id column
 * @method Element findOneByArraydesignId(int $arraydesign_id) Return the first Element filtered by the arraydesign_id column
 * @method Element findOneByTypeId(int $type_id) Return the first Element filtered by the type_id column
 * @method Element findOneByDbxrefId(int $dbxref_id) Return the first Element filtered by the dbxref_id column
 *
 * @method array findByElementId(int $element_id) Return Element objects filtered by the element_id column
 * @method array findByFeatureId(int $feature_id) Return Element objects filtered by the feature_id column
 * @method array findByArraydesignId(int $arraydesign_id) Return Element objects filtered by the arraydesign_id column
 * @method array findByTypeId(int $type_id) Return Element objects filtered by the type_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Element objects filtered by the dbxref_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseElementQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseElementQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Element', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ElementQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ElementQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ElementQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ElementQuery) {
            return $criteria;
        }
        $query = new ElementQuery();
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
     * @return   Element|Element[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ElementPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ElementPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Element A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByElementId($key, $con = null)
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
     * @return                 Element A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "element_id", "feature_id", "arraydesign_id", "type_id", "dbxref_id" FROM "element" WHERE "element_id" = :p0';
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
            $obj = new Element();
            $obj->hydrate($row);
            ElementPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Element|Element[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Element[]|mixed the list of results, formatted by the current formatter
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
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ElementPeer::ELEMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ElementPeer::ELEMENT_ID, $keys, Criteria::IN);
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
     * @param     mixed $elementId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByElementId($elementId = null, $comparison = null)
    {
        if (is_array($elementId)) {
            $useMinMax = false;
            if (isset($elementId['min'])) {
                $this->addUsingAlias(ElementPeer::ELEMENT_ID, $elementId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($elementId['max'])) {
                $this->addUsingAlias(ElementPeer::ELEMENT_ID, $elementId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementPeer::ELEMENT_ID, $elementId, $comparison);
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
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(ElementPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(ElementPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementPeer::FEATURE_ID, $featureId, $comparison);
    }

    /**
     * Filter the query on the arraydesign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArraydesignId(1234); // WHERE arraydesign_id = 1234
     * $query->filterByArraydesignId(array(12, 34)); // WHERE arraydesign_id IN (12, 34)
     * $query->filterByArraydesignId(array('min' => 12)); // WHERE arraydesign_id >= 12
     * $query->filterByArraydesignId(array('max' => 12)); // WHERE arraydesign_id <= 12
     * </code>
     *
     * @see       filterByArraydesign()
     *
     * @param     mixed $arraydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByArraydesignId($arraydesignId = null, $comparison = null)
    {
        if (is_array($arraydesignId)) {
            $useMinMax = false;
            if (isset($arraydesignId['min'])) {
                $this->addUsingAlias(ElementPeer::ARRAYDESIGN_ID, $arraydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arraydesignId['max'])) {
                $this->addUsingAlias(ElementPeer::ARRAYDESIGN_ID, $arraydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementPeer::ARRAYDESIGN_ID, $arraydesignId, $comparison);
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
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(ElementPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(ElementPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDbxrefId(1234); // WHERE dbxref_id = 1234
     * $query->filterByDbxrefId(array(12, 34)); // WHERE dbxref_id IN (12, 34)
     * $query->filterByDbxrefId(array('min' => 12)); // WHERE dbxref_id >= 12
     * $query->filterByDbxrefId(array('max' => 12)); // WHERE dbxref_id <= 12
     * </code>
     *
     * @see       filterByDbxref()
     *
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(ElementPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(ElementPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ElementPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query by a related Arraydesign object
     *
     * @param   Arraydesign|PropelObjectCollection $arraydesign The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesign($arraydesign, $comparison = null)
    {
        if ($arraydesign instanceof Arraydesign) {
            return $this
                ->addUsingAlias(ElementPeer::ARRAYDESIGN_ID, $arraydesign->getArraydesignId(), $comparison);
        } elseif ($arraydesign instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementPeer::ARRAYDESIGN_ID, $arraydesign->toKeyValue('PrimaryKey', 'ArraydesignId'), $comparison);
        } else {
            throw new PropelException('filterByArraydesign() only accepts arguments of type Arraydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arraydesign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinArraydesign($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arraydesign');

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
            $this->addJoinObject($join, 'Arraydesign');
        }

        return $this;
    }

    /**
     * Use the Arraydesign relation Arraydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArraydesign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arraydesign', '\cli_db\propel\ArraydesignQuery');
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(ElementPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
        } else {
            throw new PropelException('filterByDbxref() only accepts arguments of type Dbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Dbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Dbxref');

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
            $this->addJoinObject($join, 'Dbxref');
        }

        return $this;
    }

    /**
     * Use the Dbxref relation Dbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbxrefQuery A secondary query class using the current class as primary query
     */
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(ElementPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
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
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ElementPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ElementPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return ElementQuery The current query, for fluid interface
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
     * Filter the query by a related ElementRelationship object
     *
     * @param   ElementRelationship|PropelObjectCollection $elementRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementRelationshipRelatedByObjectId($elementRelationship, $comparison = null)
    {
        if ($elementRelationship instanceof ElementRelationship) {
            return $this
                ->addUsingAlias(ElementPeer::ELEMENT_ID, $elementRelationship->getObjectId(), $comparison);
        } elseif ($elementRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($elementRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementRelationshipRelatedByObjectId() only accepts arguments of type ElementRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinElementRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementRelationshipRelatedByObjectId');

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
            $this->addJoinObject($join, 'ElementRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the ElementRelationshipRelatedByObjectId relation ElementRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementRelationshipRelatedByObjectId', '\cli_db\propel\ElementRelationshipQuery');
    }

    /**
     * Filter the query by a related ElementRelationship object
     *
     * @param   ElementRelationship|PropelObjectCollection $elementRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementRelationshipRelatedBySubjectId($elementRelationship, $comparison = null)
    {
        if ($elementRelationship instanceof ElementRelationship) {
            return $this
                ->addUsingAlias(ElementPeer::ELEMENT_ID, $elementRelationship->getSubjectId(), $comparison);
        } elseif ($elementRelationship instanceof PropelObjectCollection) {
            return $this
                ->useElementRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($elementRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementRelationshipRelatedBySubjectId() only accepts arguments of type ElementRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ElementRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinElementRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ElementRelationshipRelatedBySubjectId');

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
            $this->addJoinObject($join, 'ElementRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the ElementRelationshipRelatedBySubjectId relation ElementRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useElementRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ElementRelationshipRelatedBySubjectId', '\cli_db\propel\ElementRelationshipQuery');
    }

    /**
     * Filter the query by a related Elementresult object
     *
     * @param   Elementresult|PropelObjectCollection $elementresult  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ElementQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElementresult($elementresult, $comparison = null)
    {
        if ($elementresult instanceof Elementresult) {
            return $this
                ->addUsingAlias(ElementPeer::ELEMENT_ID, $elementresult->getElementId(), $comparison);
        } elseif ($elementresult instanceof PropelObjectCollection) {
            return $this
                ->useElementresultQuery()
                ->filterByPrimaryKeys($elementresult->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElementresult() only accepts arguments of type Elementresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Elementresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function joinElementresult($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Elementresult');

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
            $this->addJoinObject($join, 'Elementresult');
        }

        return $this;
    }

    /**
     * Use the Elementresult relation Elementresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementresultQuery A secondary query class using the current class as primary query
     */
    public function useElementresultQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElementresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Elementresult', '\cli_db\propel\ElementresultQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Element $element Object to remove from the list of results
     *
     * @return ElementQuery The current query, for fluid interface
     */
    public function prune($element = null)
    {
        if ($element) {
            $this->addUsingAlias(ElementPeer::ELEMENT_ID, $element->getElementId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
