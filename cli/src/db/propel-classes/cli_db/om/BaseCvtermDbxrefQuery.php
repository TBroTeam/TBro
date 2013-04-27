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
use cli_db\propel\CvtermDbxref;
use cli_db\propel\CvtermDbxrefPeer;
use cli_db\propel\CvtermDbxrefQuery;
use cli_db\propel\Dbxref;

/**
 * Base class that represents a query for the 'cvterm_dbxref' table.
 *
 *
 *
 * @method CvtermDbxrefQuery orderByCvtermDbxrefId($order = Criteria::ASC) Order by the cvterm_dbxref_id column
 * @method CvtermDbxrefQuery orderByCvtermId($order = Criteria::ASC) Order by the cvterm_id column
 * @method CvtermDbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method CvtermDbxrefQuery orderByIsForDefinition($order = Criteria::ASC) Order by the is_for_definition column
 *
 * @method CvtermDbxrefQuery groupByCvtermDbxrefId() Group by the cvterm_dbxref_id column
 * @method CvtermDbxrefQuery groupByCvtermId() Group by the cvterm_id column
 * @method CvtermDbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 * @method CvtermDbxrefQuery groupByIsForDefinition() Group by the is_for_definition column
 *
 * @method CvtermDbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvtermDbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvtermDbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvtermDbxrefQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method CvtermDbxrefQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method CvtermDbxrefQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method CvtermDbxrefQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method CvtermDbxrefQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method CvtermDbxrefQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method CvtermDbxref findOne(PropelPDO $con = null) Return the first CvtermDbxref matching the query
 * @method CvtermDbxref findOneOrCreate(PropelPDO $con = null) Return the first CvtermDbxref matching the query, or a new CvtermDbxref object populated from the query conditions when no match is found
 *
 * @method CvtermDbxref findOneByCvtermId(int $cvterm_id) Return the first CvtermDbxref filtered by the cvterm_id column
 * @method CvtermDbxref findOneByDbxrefId(int $dbxref_id) Return the first CvtermDbxref filtered by the dbxref_id column
 * @method CvtermDbxref findOneByIsForDefinition(int $is_for_definition) Return the first CvtermDbxref filtered by the is_for_definition column
 *
 * @method array findByCvtermDbxrefId(int $cvterm_dbxref_id) Return CvtermDbxref objects filtered by the cvterm_dbxref_id column
 * @method array findByCvtermId(int $cvterm_id) Return CvtermDbxref objects filtered by the cvterm_id column
 * @method array findByDbxrefId(int $dbxref_id) Return CvtermDbxref objects filtered by the dbxref_id column
 * @method array findByIsForDefinition(int $is_for_definition) Return CvtermDbxref objects filtered by the is_for_definition column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvtermDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvtermDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\CvtermDbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvtermDbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvtermDbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvtermDbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvtermDbxrefQuery) {
            return $criteria;
        }
        $query = new CvtermDbxrefQuery();
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
     * @return   CvtermDbxref|CvtermDbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvtermDbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvtermDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 CvtermDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvtermDbxrefId($key, $con = null)
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
     * @return                 CvtermDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cvterm_dbxref_id", "cvterm_id", "dbxref_id", "is_for_definition" FROM "cvterm_dbxref" WHERE "cvterm_dbxref_id" = :p0';
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
            $obj = new CvtermDbxref();
            $obj->hydrate($row);
            CvtermDbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return CvtermDbxref|CvtermDbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|CvtermDbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cvterm_dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermDbxrefId(1234); // WHERE cvterm_dbxref_id = 1234
     * $query->filterByCvtermDbxrefId(array(12, 34)); // WHERE cvterm_dbxref_id IN (12, 34)
     * $query->filterByCvtermDbxrefId(array('min' => 12)); // WHERE cvterm_dbxref_id >= 12
     * $query->filterByCvtermDbxrefId(array('max' => 12)); // WHERE cvterm_dbxref_id <= 12
     * </code>
     *
     * @param     mixed $cvtermDbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByCvtermDbxrefId($cvtermDbxrefId = null, $comparison = null)
    {
        if (is_array($cvtermDbxrefId)) {
            $useMinMax = false;
            if (isset($cvtermDbxrefId['min'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $cvtermDbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermDbxrefId['max'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $cvtermDbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $cvtermDbxrefId, $comparison);
    }

    /**
     * Filter the query on the cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvtermId(1234); // WHERE cvterm_id = 1234
     * $query->filterByCvtermId(array(12, 34)); // WHERE cvterm_id IN (12, 34)
     * $query->filterByCvtermId(array('min' => 12)); // WHERE cvterm_id >= 12
     * $query->filterByCvtermId(array('max' => 12)); // WHERE cvterm_id <= 12
     * </code>
     *
     * @see       filterByCvterm()
     *
     * @param     mixed $cvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByCvtermId($cvtermId = null, $comparison = null)
    {
        if (is_array($cvtermId)) {
            $useMinMax = false;
            if (isset($cvtermId['min'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_ID, $cvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvtermId['max'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_ID, $cvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_ID, $cvtermId, $comparison);
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
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermDbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query on the is_for_definition column
     *
     * Example usage:
     * <code>
     * $query->filterByIsForDefinition(1234); // WHERE is_for_definition = 1234
     * $query->filterByIsForDefinition(array(12, 34)); // WHERE is_for_definition IN (12, 34)
     * $query->filterByIsForDefinition(array('min' => 12)); // WHERE is_for_definition >= 12
     * $query->filterByIsForDefinition(array('max' => 12)); // WHERE is_for_definition <= 12
     * </code>
     *
     * @param     mixed $isForDefinition The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByIsForDefinition($isForDefinition = null, $comparison = null)
    {
        if (is_array($isForDefinition)) {
            $useMinMax = false;
            if (isset($isForDefinition['min'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::IS_FOR_DEFINITION, $isForDefinition['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($isForDefinition['max'])) {
                $this->addUsingAlias(CvtermDbxrefPeer::IS_FOR_DEFINITION, $isForDefinition['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvtermDbxrefPeer::IS_FOR_DEFINITION, $isForDefinition, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvtermDbxrefPeer::CVTERM_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermDbxrefPeer::CVTERM_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return CvtermDbxrefQuery The current query, for fluid interface
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
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvtermDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(CvtermDbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(CvtermDbxrefPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   CvtermDbxref $cvtermDbxref Object to remove from the list of results
     *
     * @return CvtermDbxrefQuery The current query, for fluid interface
     */
    public function prune($cvtermDbxref = null)
    {
        if ($cvtermDbxref) {
            $this->addUsingAlias(CvtermDbxrefPeer::CVTERM_DBXREF_ID, $cvtermDbxref->getCvtermDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
