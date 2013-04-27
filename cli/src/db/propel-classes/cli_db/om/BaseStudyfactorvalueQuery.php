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
use cli_db\propel\Assay;
use cli_db\propel\Studyfactor;
use cli_db\propel\Studyfactorvalue;
use cli_db\propel\StudyfactorvaluePeer;
use cli_db\propel\StudyfactorvalueQuery;

/**
 * Base class that represents a query for the 'studyfactorvalue' table.
 *
 *
 *
 * @method StudyfactorvalueQuery orderByStudyfactorvalueId($order = Criteria::ASC) Order by the studyfactorvalue_id column
 * @method StudyfactorvalueQuery orderByStudyfactorId($order = Criteria::ASC) Order by the studyfactor_id column
 * @method StudyfactorvalueQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 * @method StudyfactorvalueQuery orderByFactorvalue($order = Criteria::ASC) Order by the factorvalue column
 * @method StudyfactorvalueQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method StudyfactorvalueQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method StudyfactorvalueQuery groupByStudyfactorvalueId() Group by the studyfactorvalue_id column
 * @method StudyfactorvalueQuery groupByStudyfactorId() Group by the studyfactor_id column
 * @method StudyfactorvalueQuery groupByAssayId() Group by the assay_id column
 * @method StudyfactorvalueQuery groupByFactorvalue() Group by the factorvalue column
 * @method StudyfactorvalueQuery groupByName() Group by the name column
 * @method StudyfactorvalueQuery groupByRank() Group by the rank column
 *
 * @method StudyfactorvalueQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudyfactorvalueQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudyfactorvalueQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudyfactorvalueQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method StudyfactorvalueQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method StudyfactorvalueQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method StudyfactorvalueQuery leftJoinStudyfactor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyfactor relation
 * @method StudyfactorvalueQuery rightJoinStudyfactor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyfactor relation
 * @method StudyfactorvalueQuery innerJoinStudyfactor($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyfactor relation
 *
 * @method Studyfactorvalue findOne(PropelPDO $con = null) Return the first Studyfactorvalue matching the query
 * @method Studyfactorvalue findOneOrCreate(PropelPDO $con = null) Return the first Studyfactorvalue matching the query, or a new Studyfactorvalue object populated from the query conditions when no match is found
 *
 * @method Studyfactorvalue findOneByStudyfactorId(int $studyfactor_id) Return the first Studyfactorvalue filtered by the studyfactor_id column
 * @method Studyfactorvalue findOneByAssayId(int $assay_id) Return the first Studyfactorvalue filtered by the assay_id column
 * @method Studyfactorvalue findOneByFactorvalue(string $factorvalue) Return the first Studyfactorvalue filtered by the factorvalue column
 * @method Studyfactorvalue findOneByName(string $name) Return the first Studyfactorvalue filtered by the name column
 * @method Studyfactorvalue findOneByRank(int $rank) Return the first Studyfactorvalue filtered by the rank column
 *
 * @method array findByStudyfactorvalueId(int $studyfactorvalue_id) Return Studyfactorvalue objects filtered by the studyfactorvalue_id column
 * @method array findByStudyfactorId(int $studyfactor_id) Return Studyfactorvalue objects filtered by the studyfactor_id column
 * @method array findByAssayId(int $assay_id) Return Studyfactorvalue objects filtered by the assay_id column
 * @method array findByFactorvalue(string $factorvalue) Return Studyfactorvalue objects filtered by the factorvalue column
 * @method array findByName(string $name) Return Studyfactorvalue objects filtered by the name column
 * @method array findByRank(int $rank) Return Studyfactorvalue objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyfactorvalueQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudyfactorvalueQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Studyfactorvalue', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudyfactorvalueQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudyfactorvalueQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudyfactorvalueQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudyfactorvalueQuery) {
            return $criteria;
        }
        $query = new StudyfactorvalueQuery();
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
     * @return   Studyfactorvalue|Studyfactorvalue[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudyfactorvaluePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudyfactorvaluePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Studyfactorvalue A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudyfactorvalueId($key, $con = null)
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
     * @return                 Studyfactorvalue A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studyfactorvalue_id", "studyfactor_id", "assay_id", "factorvalue", "name", "rank" FROM "studyfactorvalue" WHERE "studyfactorvalue_id" = :p0';
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
            $obj = new Studyfactorvalue();
            $obj->hydrate($row);
            StudyfactorvaluePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Studyfactorvalue|Studyfactorvalue[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Studyfactorvalue[]|mixed the list of results, formatted by the current formatter
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
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studyfactorvalue_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudyfactorvalueId(1234); // WHERE studyfactorvalue_id = 1234
     * $query->filterByStudyfactorvalueId(array(12, 34)); // WHERE studyfactorvalue_id IN (12, 34)
     * $query->filterByStudyfactorvalueId(array('min' => 12)); // WHERE studyfactorvalue_id >= 12
     * $query->filterByStudyfactorvalueId(array('max' => 12)); // WHERE studyfactorvalue_id <= 12
     * </code>
     *
     * @param     mixed $studyfactorvalueId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByStudyfactorvalueId($studyfactorvalueId = null, $comparison = null)
    {
        if (is_array($studyfactorvalueId)) {
            $useMinMax = false;
            if (isset($studyfactorvalueId['min'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $studyfactorvalueId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyfactorvalueId['max'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $studyfactorvalueId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $studyfactorvalueId, $comparison);
    }

    /**
     * Filter the query on the studyfactor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudyfactorId(1234); // WHERE studyfactor_id = 1234
     * $query->filterByStudyfactorId(array(12, 34)); // WHERE studyfactor_id IN (12, 34)
     * $query->filterByStudyfactorId(array('min' => 12)); // WHERE studyfactor_id >= 12
     * $query->filterByStudyfactorId(array('max' => 12)); // WHERE studyfactor_id <= 12
     * </code>
     *
     * @see       filterByStudyfactor()
     *
     * @param     mixed $studyfactorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByStudyfactorId($studyfactorId = null, $comparison = null)
    {
        if (is_array($studyfactorId)) {
            $useMinMax = false;
            if (isset($studyfactorId['min'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTOR_ID, $studyfactorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyfactorId['max'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTOR_ID, $studyfactorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTOR_ID, $studyfactorId, $comparison);
    }

    /**
     * Filter the query on the assay_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAssayId(1234); // WHERE assay_id = 1234
     * $query->filterByAssayId(array(12, 34)); // WHERE assay_id IN (12, 34)
     * $query->filterByAssayId(array('min' => 12)); // WHERE assay_id >= 12
     * $query->filterByAssayId(array('max' => 12)); // WHERE assay_id <= 12
     * </code>
     *
     * @see       filterByAssay()
     *
     * @param     mixed $assayId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::ASSAY_ID, $assayId, $comparison);
    }

    /**
     * Filter the query on the factorvalue column
     *
     * Example usage:
     * <code>
     * $query->filterByFactorvalue('fooValue');   // WHERE factorvalue = 'fooValue'
     * $query->filterByFactorvalue('%fooValue%'); // WHERE factorvalue LIKE '%fooValue%'
     * </code>
     *
     * @param     string $factorvalue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByFactorvalue($factorvalue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($factorvalue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $factorvalue)) {
                $factorvalue = str_replace('*', '%', $factorvalue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::FACTORVALUE, $factorvalue, $comparison);
    }

    /**
     * Filter the query on the name column
     *
     * Example usage:
     * <code>
     * $query->filterByName('fooValue');   // WHERE name = 'fooValue'
     * $query->filterByName('%fooValue%'); // WHERE name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $name The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByName($name = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($name)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $name)) {
                $name = str_replace('*', '%', $name);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::NAME, $name, $comparison);
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
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(StudyfactorvaluePeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorvaluePeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyfactorvalueQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(StudyfactorvaluePeer::ASSAY_ID, $assay->getAssayId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyfactorvaluePeer::ASSAY_ID, $assay->toKeyValue('PrimaryKey', 'AssayId'), $comparison);
        } else {
            throw new PropelException('filterByAssay() only accepts arguments of type Assay or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Assay relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function joinAssay($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Assay');

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
            $this->addJoinObject($join, 'Assay');
        }

        return $this;
    }

    /**
     * Use the Assay relation Assay object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssayQuery A secondary query class using the current class as primary query
     */
    public function useAssayQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssay($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Assay', '\cli_db\propel\AssayQuery');
    }

    /**
     * Filter the query by a related Studyfactor object
     *
     * @param   Studyfactor|PropelObjectCollection $studyfactor The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyfactorvalueQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyfactor($studyfactor, $comparison = null)
    {
        if ($studyfactor instanceof Studyfactor) {
            return $this
                ->addUsingAlias(StudyfactorvaluePeer::STUDYFACTOR_ID, $studyfactor->getStudyfactorId(), $comparison);
        } elseif ($studyfactor instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyfactorvaluePeer::STUDYFACTOR_ID, $studyfactor->toKeyValue('PrimaryKey', 'StudyfactorId'), $comparison);
        } else {
            throw new PropelException('filterByStudyfactor() only accepts arguments of type Studyfactor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyfactor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function joinStudyfactor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyfactor');

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
            $this->addJoinObject($join, 'Studyfactor');
        }

        return $this;
    }

    /**
     * Use the Studyfactor relation Studyfactor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyfactorQuery A secondary query class using the current class as primary query
     */
    public function useStudyfactorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyfactor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyfactor', '\cli_db\propel\StudyfactorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Studyfactorvalue $studyfactorvalue Object to remove from the list of results
     *
     * @return StudyfactorvalueQuery The current query, for fluid interface
     */
    public function prune($studyfactorvalue = null)
    {
        if ($studyfactorvalue) {
            $this->addUsingAlias(StudyfactorvaluePeer::STUDYFACTORVALUE_ID, $studyfactorvalue->getStudyfactorvalueId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
