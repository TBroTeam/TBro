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
use cli_db\propel\Assayprop;
use cli_db\propel\AssaypropPeer;
use cli_db\propel\AssaypropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'assayprop' table.
 *
 *
 *
 * @method AssaypropQuery orderByAssaypropId($order = Criteria::ASC) Order by the assayprop_id column
 * @method AssaypropQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 * @method AssaypropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method AssaypropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method AssaypropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AssaypropQuery groupByAssaypropId() Group by the assayprop_id column
 * @method AssaypropQuery groupByAssayId() Group by the assay_id column
 * @method AssaypropQuery groupByTypeId() Group by the type_id column
 * @method AssaypropQuery groupByValue() Group by the value column
 * @method AssaypropQuery groupByRank() Group by the rank column
 *
 * @method AssaypropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AssaypropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AssaypropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AssaypropQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method AssaypropQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method AssaypropQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method AssaypropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method AssaypropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method AssaypropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Assayprop findOne(PropelPDO $con = null) Return the first Assayprop matching the query
 * @method Assayprop findOneOrCreate(PropelPDO $con = null) Return the first Assayprop matching the query, or a new Assayprop object populated from the query conditions when no match is found
 *
 * @method Assayprop findOneByAssayId(int $assay_id) Return the first Assayprop filtered by the assay_id column
 * @method Assayprop findOneByTypeId(int $type_id) Return the first Assayprop filtered by the type_id column
 * @method Assayprop findOneByValue(string $value) Return the first Assayprop filtered by the value column
 * @method Assayprop findOneByRank(int $rank) Return the first Assayprop filtered by the rank column
 *
 * @method array findByAssaypropId(int $assayprop_id) Return Assayprop objects filtered by the assayprop_id column
 * @method array findByAssayId(int $assay_id) Return Assayprop objects filtered by the assay_id column
 * @method array findByTypeId(int $type_id) Return Assayprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Assayprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Assayprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAssaypropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAssaypropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Assayprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AssaypropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AssaypropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AssaypropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AssaypropQuery) {
            return $criteria;
        }
        $query = new AssaypropQuery();
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
     * @return   Assayprop|Assayprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AssaypropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AssaypropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Assayprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAssaypropId($key, $con = null)
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
     * @return                 Assayprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "assayprop_id", "assay_id", "type_id", "value", "rank" FROM "assayprop" WHERE "assayprop_id" = :p0';
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
            $obj = new Assayprop();
            $obj->hydrate($row);
            AssaypropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Assayprop|Assayprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Assayprop[]|mixed the list of results, formatted by the current formatter
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
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the assayprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAssaypropId(1234); // WHERE assayprop_id = 1234
     * $query->filterByAssaypropId(array(12, 34)); // WHERE assayprop_id IN (12, 34)
     * $query->filterByAssaypropId(array('min' => 12)); // WHERE assayprop_id >= 12
     * $query->filterByAssaypropId(array('max' => 12)); // WHERE assayprop_id <= 12
     * </code>
     *
     * @param     mixed $assaypropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByAssaypropId($assaypropId = null, $comparison = null)
    {
        if (is_array($assaypropId)) {
            $useMinMax = false;
            if (isset($assaypropId['min'])) {
                $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $assaypropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assaypropId['max'])) {
                $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $assaypropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $assaypropId, $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(AssaypropPeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(AssaypropPeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssaypropPeer::ASSAY_ID, $assayId, $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(AssaypropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(AssaypropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssaypropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AssaypropPeer::VALUE, $value, $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AssaypropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AssaypropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssaypropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssaypropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(AssaypropPeer::ASSAY_ID, $assay->getAssayId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssaypropPeer::ASSAY_ID, $assay->toKeyValue('PrimaryKey', 'AssayId'), $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssaypropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(AssaypropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssaypropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return AssaypropQuery The current query, for fluid interface
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
     * @param   Assayprop $assayprop Object to remove from the list of results
     *
     * @return AssaypropQuery The current query, for fluid interface
     */
    public function prune($assayprop = null)
    {
        if ($assayprop) {
            $this->addUsingAlias(AssaypropPeer::ASSAYPROP_ID, $assayprop->getAssaypropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
