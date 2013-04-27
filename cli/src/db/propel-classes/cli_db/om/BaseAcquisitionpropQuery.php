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
use cli_db\propel\Acquisition;
use cli_db\propel\Acquisitionprop;
use cli_db\propel\AcquisitionpropPeer;
use cli_db\propel\AcquisitionpropQuery;
use cli_db\propel\Cvterm;

/**
 * Base class that represents a query for the 'acquisitionprop' table.
 *
 *
 *
 * @method AcquisitionpropQuery orderByAcquisitionpropId($order = Criteria::ASC) Order by the acquisitionprop_id column
 * @method AcquisitionpropQuery orderByAcquisitionId($order = Criteria::ASC) Order by the acquisition_id column
 * @method AcquisitionpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method AcquisitionpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method AcquisitionpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AcquisitionpropQuery groupByAcquisitionpropId() Group by the acquisitionprop_id column
 * @method AcquisitionpropQuery groupByAcquisitionId() Group by the acquisition_id column
 * @method AcquisitionpropQuery groupByTypeId() Group by the type_id column
 * @method AcquisitionpropQuery groupByValue() Group by the value column
 * @method AcquisitionpropQuery groupByRank() Group by the rank column
 *
 * @method AcquisitionpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AcquisitionpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AcquisitionpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AcquisitionpropQuery leftJoinAcquisition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisition relation
 * @method AcquisitionpropQuery rightJoinAcquisition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisition relation
 * @method AcquisitionpropQuery innerJoinAcquisition($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisition relation
 *
 * @method AcquisitionpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method AcquisitionpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method AcquisitionpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Acquisitionprop findOne(PropelPDO $con = null) Return the first Acquisitionprop matching the query
 * @method Acquisitionprop findOneOrCreate(PropelPDO $con = null) Return the first Acquisitionprop matching the query, or a new Acquisitionprop object populated from the query conditions when no match is found
 *
 * @method Acquisitionprop findOneByAcquisitionId(int $acquisition_id) Return the first Acquisitionprop filtered by the acquisition_id column
 * @method Acquisitionprop findOneByTypeId(int $type_id) Return the first Acquisitionprop filtered by the type_id column
 * @method Acquisitionprop findOneByValue(string $value) Return the first Acquisitionprop filtered by the value column
 * @method Acquisitionprop findOneByRank(int $rank) Return the first Acquisitionprop filtered by the rank column
 *
 * @method array findByAcquisitionpropId(int $acquisitionprop_id) Return Acquisitionprop objects filtered by the acquisitionprop_id column
 * @method array findByAcquisitionId(int $acquisition_id) Return Acquisitionprop objects filtered by the acquisition_id column
 * @method array findByTypeId(int $type_id) Return Acquisitionprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Acquisitionprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Acquisitionprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAcquisitionpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAcquisitionpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Acquisitionprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AcquisitionpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AcquisitionpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AcquisitionpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AcquisitionpropQuery) {
            return $criteria;
        }
        $query = new AcquisitionpropQuery();
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
     * @return   Acquisitionprop|Acquisitionprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AcquisitionpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Acquisitionprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAcquisitionpropId($key, $con = null)
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
     * @return                 Acquisitionprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "acquisitionprop_id", "acquisition_id", "type_id", "value", "rank" FROM "acquisitionprop" WHERE "acquisitionprop_id" = :p0';
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
            $obj = new Acquisitionprop();
            $obj->hydrate($row);
            AcquisitionpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Acquisitionprop|Acquisitionprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Acquisitionprop[]|mixed the list of results, formatted by the current formatter
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
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the acquisitionprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAcquisitionpropId(1234); // WHERE acquisitionprop_id = 1234
     * $query->filterByAcquisitionpropId(array(12, 34)); // WHERE acquisitionprop_id IN (12, 34)
     * $query->filterByAcquisitionpropId(array('min' => 12)); // WHERE acquisitionprop_id >= 12
     * $query->filterByAcquisitionpropId(array('max' => 12)); // WHERE acquisitionprop_id <= 12
     * </code>
     *
     * @param     mixed $acquisitionpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByAcquisitionpropId($acquisitionpropId = null, $comparison = null)
    {
        if (is_array($acquisitionpropId)) {
            $useMinMax = false;
            if (isset($acquisitionpropId['min'])) {
                $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $acquisitionpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitionpropId['max'])) {
                $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $acquisitionpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $acquisitionpropId, $comparison);
    }

    /**
     * Filter the query on the acquisition_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAcquisitionId(1234); // WHERE acquisition_id = 1234
     * $query->filterByAcquisitionId(array(12, 34)); // WHERE acquisition_id IN (12, 34)
     * $query->filterByAcquisitionId(array('min' => 12)); // WHERE acquisition_id >= 12
     * $query->filterByAcquisitionId(array('max' => 12)); // WHERE acquisition_id <= 12
     * </code>
     *
     * @see       filterByAcquisition()
     *
     * @param     mixed $acquisitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByAcquisitionId($acquisitionId = null, $comparison = null)
    {
        if (is_array($acquisitionId)) {
            $useMinMax = false;
            if (isset($acquisitionId['min'])) {
                $this->addUsingAlias(AcquisitionpropPeer::ACQUISITION_ID, $acquisitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitionId['max'])) {
                $this->addUsingAlias(AcquisitionpropPeer::ACQUISITION_ID, $acquisitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionpropPeer::ACQUISITION_ID, $acquisitionId, $comparison);
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
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(AcquisitionpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(AcquisitionpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return AcquisitionpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AcquisitionpropPeer::VALUE, $value, $comparison);
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
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AcquisitionpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AcquisitionpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisition($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(AcquisitionpropPeer::ACQUISITION_ID, $acquisition->getAcquisitionId(), $comparison);
        } elseif ($acquisition instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionpropPeer::ACQUISITION_ID, $acquisition->toKeyValue('PrimaryKey', 'AcquisitionId'), $comparison);
        } else {
            throw new PropelException('filterByAcquisition() only accepts arguments of type Acquisition or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Acquisition relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function joinAcquisition($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Acquisition');

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
            $this->addJoinObject($join, 'Acquisition');
        }

        return $this;
    }

    /**
     * Use the Acquisition relation Acquisition object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Acquisition', '\cli_db\propel\AcquisitionQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(AcquisitionpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return AcquisitionpropQuery The current query, for fluid interface
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
     * @param   Acquisitionprop $acquisitionprop Object to remove from the list of results
     *
     * @return AcquisitionpropQuery The current query, for fluid interface
     */
    public function prune($acquisitionprop = null)
    {
        if ($acquisitionprop) {
            $this->addUsingAlias(AcquisitionpropPeer::ACQUISITIONPROP_ID, $acquisitionprop->getAcquisitionpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
