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
use cli_db\propel\Cv;
use cli_db\propel\CvPeer;
use cli_db\propel\CvQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'cv' table.
 *
 *
 *
 * @method CvQuery orderByCvId($order = Criteria::ASC) Order by the cv_id column
 * @method CvQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method CvQuery orderByDefinition($order = Criteria::ASC) Order by the definition column
 *
 * @method CvQuery groupByCvId() Group by the cv_id column
 * @method CvQuery groupByName() Group by the name column
 * @method CvQuery groupByDefinition() Group by the definition column
 *
 * @method CvQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method CvQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method CvQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method CvQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method CvQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method CvQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Cv findOne(PropelPDO $con = null) Return the first Cv matching the query
 * @method Cv findOneOrCreate(PropelPDO $con = null) Return the first Cv matching the query, or a new Cv object populated from the query conditions when no match is found
 *
 * @method Cv findOneByName(string $name) Return the first Cv filtered by the name column
 * @method Cv findOneByDefinition(string $definition) Return the first Cv filtered by the definition column
 *
 * @method array findByCvId(int $cv_id) Return Cv objects filtered by the cv_id column
 * @method array findByName(string $name) Return Cv objects filtered by the name column
 * @method array findByDefinition(string $definition) Return Cv objects filtered by the definition column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseCvQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseCvQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Cv', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new CvQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   CvQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return CvQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof CvQuery) {
            return $criteria;
        }
        $query = new CvQuery();
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
     * @return   Cv|Cv[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = CvPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(CvPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Cv A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByCvId($key, $con = null)
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
     * @return                 Cv A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "cv_id", "name", "definition" FROM "cv" WHERE "cv_id" = :p0';
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
            $obj = new Cv();
            $obj->hydrate($row);
            CvPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Cv|Cv[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Cv[]|mixed the list of results, formatted by the current formatter
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
     * @return CvQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(CvPeer::CV_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return CvQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(CvPeer::CV_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the cv_id column
     *
     * Example usage:
     * <code>
     * $query->filterByCvId(1234); // WHERE cv_id = 1234
     * $query->filterByCvId(array(12, 34)); // WHERE cv_id IN (12, 34)
     * $query->filterByCvId(array('min' => 12)); // WHERE cv_id >= 12
     * $query->filterByCvId(array('max' => 12)); // WHERE cv_id <= 12
     * </code>
     *
     * @param     mixed $cvId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvQuery The current query, for fluid interface
     */
    public function filterByCvId($cvId = null, $comparison = null)
    {
        if (is_array($cvId)) {
            $useMinMax = false;
            if (isset($cvId['min'])) {
                $this->addUsingAlias(CvPeer::CV_ID, $cvId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($cvId['max'])) {
                $this->addUsingAlias(CvPeer::CV_ID, $cvId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(CvPeer::CV_ID, $cvId, $comparison);
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
     * @return CvQuery The current query, for fluid interface
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

        return $this->addUsingAlias(CvPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the definition column
     *
     * Example usage:
     * <code>
     * $query->filterByDefinition('fooValue');   // WHERE definition = 'fooValue'
     * $query->filterByDefinition('%fooValue%'); // WHERE definition LIKE '%fooValue%'
     * </code>
     *
     * @param     string $definition The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return CvQuery The current query, for fluid interface
     */
    public function filterByDefinition($definition = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($definition)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $definition)) {
                $definition = str_replace('*', '%', $definition);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(CvPeer::DEFINITION, $definition, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 CvQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(CvPeer::CV_ID, $cvterm->getCvId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            return $this
                ->useCvtermQuery()
                ->filterByPrimaryKeys($cvterm->getPrimaryKeys())
                ->endUse();
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
     * @return CvQuery The current query, for fluid interface
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
     * @param   Cv $cv Object to remove from the list of results
     *
     * @return CvQuery The current query, for fluid interface
     */
    public function prune($cv = null)
    {
        if ($cv) {
            $this->addUsingAlias(CvPeer::CV_ID, $cv->getCvId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
