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
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialDbxref;
use cli_db\propel\BiomaterialDbxrefPeer;
use cli_db\propel\BiomaterialDbxrefQuery;
use cli_db\propel\Dbxref;

/**
 * Base class that represents a query for the 'biomaterial_dbxref' table.
 *
 *
 *
 * @method BiomaterialDbxrefQuery orderByBiomaterialDbxrefId($order = Criteria::ASC) Order by the biomaterial_dbxref_id column
 * @method BiomaterialDbxrefQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method BiomaterialDbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 *
 * @method BiomaterialDbxrefQuery groupByBiomaterialDbxrefId() Group by the biomaterial_dbxref_id column
 * @method BiomaterialDbxrefQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method BiomaterialDbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 *
 * @method BiomaterialDbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BiomaterialDbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BiomaterialDbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BiomaterialDbxrefQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialDbxrefQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialDbxrefQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method BiomaterialDbxrefQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method BiomaterialDbxrefQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method BiomaterialDbxrefQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method BiomaterialDbxref findOne(PropelPDO $con = null) Return the first BiomaterialDbxref matching the query
 * @method BiomaterialDbxref findOneOrCreate(PropelPDO $con = null) Return the first BiomaterialDbxref matching the query, or a new BiomaterialDbxref object populated from the query conditions when no match is found
 *
 * @method BiomaterialDbxref findOneByBiomaterialId(int $biomaterial_id) Return the first BiomaterialDbxref filtered by the biomaterial_id column
 * @method BiomaterialDbxref findOneByDbxrefId(int $dbxref_id) Return the first BiomaterialDbxref filtered by the dbxref_id column
 *
 * @method array findByBiomaterialDbxrefId(int $biomaterial_dbxref_id) Return BiomaterialDbxref objects filtered by the biomaterial_dbxref_id column
 * @method array findByBiomaterialId(int $biomaterial_id) Return BiomaterialDbxref objects filtered by the biomaterial_id column
 * @method array findByDbxrefId(int $dbxref_id) Return BiomaterialDbxref objects filtered by the dbxref_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseBiomaterialDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBiomaterialDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\BiomaterialDbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BiomaterialDbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BiomaterialDbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BiomaterialDbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BiomaterialDbxrefQuery) {
            return $criteria;
        }
        $query = new BiomaterialDbxrefQuery();
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
     * @return   BiomaterialDbxref|BiomaterialDbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BiomaterialDbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BiomaterialDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByBiomaterialDbxrefId($key, $con = null)
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
     * @return                 BiomaterialDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "biomaterial_dbxref_id", "biomaterial_id", "dbxref_id" FROM "biomaterial_dbxref" WHERE "biomaterial_dbxref_id" = :p0';
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
            $obj = new BiomaterialDbxref();
            $obj->hydrate($row);
            BiomaterialDbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BiomaterialDbxref|BiomaterialDbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BiomaterialDbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the biomaterial_dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiomaterialDbxrefId(1234); // WHERE biomaterial_dbxref_id = 1234
     * $query->filterByBiomaterialDbxrefId(array(12, 34)); // WHERE biomaterial_dbxref_id IN (12, 34)
     * $query->filterByBiomaterialDbxrefId(array('min' => 12)); // WHERE biomaterial_dbxref_id >= 12
     * $query->filterByBiomaterialDbxrefId(array('max' => 12)); // WHERE biomaterial_dbxref_id <= 12
     * </code>
     *
     * @param     mixed $biomaterialDbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function filterByBiomaterialDbxrefId($biomaterialDbxrefId = null, $comparison = null)
    {
        if (is_array($biomaterialDbxrefId)) {
            $useMinMax = false;
            if (isset($biomaterialDbxrefId['min'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $biomaterialDbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialDbxrefId['max'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $biomaterialDbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $biomaterialDbxrefId, $comparison);
    }

    /**
     * Filter the query on the biomaterial_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiomaterialId(1234); // WHERE biomaterial_id = 1234
     * $query->filterByBiomaterialId(array(12, 34)); // WHERE biomaterial_id IN (12, 34)
     * $query->filterByBiomaterialId(array('min' => 12)); // WHERE biomaterial_id >= 12
     * $query->filterByBiomaterialId(array('max' => 12)); // WHERE biomaterial_id <= 12
     * </code>
     *
     * @see       filterByBiomaterial()
     *
     * @param     mixed $biomaterialId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
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
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(BiomaterialDbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialDbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
        } else {
            throw new PropelException('filterByBiomaterial() only accepts arguments of type Biomaterial or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biomaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function joinBiomaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biomaterial');

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
            $this->addJoinObject($join, 'Biomaterial');
        }

        return $this;
    }

    /**
     * Use the Biomaterial relation Biomaterial object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biomaterial', '\cli_db\propel\BiomaterialQuery');
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(BiomaterialDbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialDbxrefPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
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
     * @param   BiomaterialDbxref $biomaterialDbxref Object to remove from the list of results
     *
     * @return BiomaterialDbxrefQuery The current query, for fluid interface
     */
    public function prune($biomaterialDbxref = null)
    {
        if ($biomaterialDbxref) {
            $this->addUsingAlias(BiomaterialDbxrefPeer::BIOMATERIAL_DBXREF_ID, $biomaterialDbxref->getBiomaterialDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
