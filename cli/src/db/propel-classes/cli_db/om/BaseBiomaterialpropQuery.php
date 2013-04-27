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
use cli_db\propel\Biomaterialprop;
use cli_db\propel\BiomaterialpropPeer;
use cli_db\propel\BiomaterialpropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'biomaterialprop' table.
 *
 *
 *
 * @method BiomaterialpropQuery orderByBiomaterialpropId($order = Criteria::ASC) Order by the biomaterialprop_id column
 * @method BiomaterialpropQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method BiomaterialpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method BiomaterialpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method BiomaterialpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method BiomaterialpropQuery groupByBiomaterialpropId() Group by the biomaterialprop_id column
 * @method BiomaterialpropQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method BiomaterialpropQuery groupByTypeId() Group by the type_id column
 * @method BiomaterialpropQuery groupByValue() Group by the value column
 * @method BiomaterialpropQuery groupByRank() Group by the rank column
 *
 * @method BiomaterialpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BiomaterialpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BiomaterialpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BiomaterialpropQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialpropQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialpropQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method BiomaterialpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method BiomaterialpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method BiomaterialpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Biomaterialprop findOne(PropelPDO $con = null) Return the first Biomaterialprop matching the query
 * @method Biomaterialprop findOneOrCreate(PropelPDO $con = null) Return the first Biomaterialprop matching the query, or a new Biomaterialprop object populated from the query conditions when no match is found
 *
 * @method Biomaterialprop findOneByBiomaterialId(int $biomaterial_id) Return the first Biomaterialprop filtered by the biomaterial_id column
 * @method Biomaterialprop findOneByTypeId(int $type_id) Return the first Biomaterialprop filtered by the type_id column
 * @method Biomaterialprop findOneByValue(string $value) Return the first Biomaterialprop filtered by the value column
 * @method Biomaterialprop findOneByRank(int $rank) Return the first Biomaterialprop filtered by the rank column
 *
 * @method array findByBiomaterialpropId(int $biomaterialprop_id) Return Biomaterialprop objects filtered by the biomaterialprop_id column
 * @method array findByBiomaterialId(int $biomaterial_id) Return Biomaterialprop objects filtered by the biomaterial_id column
 * @method array findByTypeId(int $type_id) Return Biomaterialprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Biomaterialprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Biomaterialprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseBiomaterialpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBiomaterialpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Biomaterialprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BiomaterialpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BiomaterialpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BiomaterialpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BiomaterialpropQuery) {
            return $criteria;
        }
        $query = new BiomaterialpropQuery();
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
     * @return   Biomaterialprop|Biomaterialprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BiomaterialpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Biomaterialprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByBiomaterialpropId($key, $con = null)
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
     * @return                 Biomaterialprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "biomaterialprop_id", "biomaterial_id", "type_id", "value", "rank" FROM "biomaterialprop" WHERE "biomaterialprop_id" = :p0';
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
            $obj = new Biomaterialprop();
            $obj->hydrate($row);
            BiomaterialpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Biomaterialprop|Biomaterialprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Biomaterialprop[]|mixed the list of results, formatted by the current formatter
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
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the biomaterialprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiomaterialpropId(1234); // WHERE biomaterialprop_id = 1234
     * $query->filterByBiomaterialpropId(array(12, 34)); // WHERE biomaterialprop_id IN (12, 34)
     * $query->filterByBiomaterialpropId(array('min' => 12)); // WHERE biomaterialprop_id >= 12
     * $query->filterByBiomaterialpropId(array('max' => 12)); // WHERE biomaterialprop_id <= 12
     * </code>
     *
     * @param     mixed $biomaterialpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByBiomaterialpropId($biomaterialpropId = null, $comparison = null)
    {
        if (is_array($biomaterialpropId)) {
            $useMinMax = false;
            if (isset($biomaterialpropId['min'])) {
                $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $biomaterialpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialpropId['max'])) {
                $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $biomaterialpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $biomaterialpropId, $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(BiomaterialpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(BiomaterialpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BiomaterialpropPeer::VALUE, $value, $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(BiomaterialpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(BiomaterialpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(BiomaterialpropPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialpropPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(BiomaterialpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return BiomaterialpropQuery The current query, for fluid interface
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
     * @param   Biomaterialprop $biomaterialprop Object to remove from the list of results
     *
     * @return BiomaterialpropQuery The current query, for fluid interface
     */
    public function prune($biomaterialprop = null)
    {
        if ($biomaterialprop) {
            $this->addUsingAlias(BiomaterialpropPeer::BIOMATERIALPROP_ID, $biomaterialprop->getBiomaterialpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
