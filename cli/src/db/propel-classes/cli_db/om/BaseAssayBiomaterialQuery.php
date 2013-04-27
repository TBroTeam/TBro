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
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayBiomaterialPeer;
use cli_db\propel\AssayBiomaterialQuery;
use cli_db\propel\Biomaterial;
use cli_db\propel\Channel;

/**
 * Base class that represents a query for the 'assay_biomaterial' table.
 *
 *
 *
 * @method AssayBiomaterialQuery orderByAssayBiomaterialId($order = Criteria::ASC) Order by the assay_biomaterial_id column
 * @method AssayBiomaterialQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 * @method AssayBiomaterialQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method AssayBiomaterialQuery orderByChannelId($order = Criteria::ASC) Order by the channel_id column
 * @method AssayBiomaterialQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method AssayBiomaterialQuery groupByAssayBiomaterialId() Group by the assay_biomaterial_id column
 * @method AssayBiomaterialQuery groupByAssayId() Group by the assay_id column
 * @method AssayBiomaterialQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method AssayBiomaterialQuery groupByChannelId() Group by the channel_id column
 * @method AssayBiomaterialQuery groupByRank() Group by the rank column
 *
 * @method AssayBiomaterialQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AssayBiomaterialQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AssayBiomaterialQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AssayBiomaterialQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method AssayBiomaterialQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method AssayBiomaterialQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method AssayBiomaterialQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method AssayBiomaterialQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method AssayBiomaterialQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method AssayBiomaterialQuery leftJoinChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Channel relation
 * @method AssayBiomaterialQuery rightJoinChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Channel relation
 * @method AssayBiomaterialQuery innerJoinChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the Channel relation
 *
 * @method AssayBiomaterial findOne(PropelPDO $con = null) Return the first AssayBiomaterial matching the query
 * @method AssayBiomaterial findOneOrCreate(PropelPDO $con = null) Return the first AssayBiomaterial matching the query, or a new AssayBiomaterial object populated from the query conditions when no match is found
 *
 * @method AssayBiomaterial findOneByAssayId(int $assay_id) Return the first AssayBiomaterial filtered by the assay_id column
 * @method AssayBiomaterial findOneByBiomaterialId(int $biomaterial_id) Return the first AssayBiomaterial filtered by the biomaterial_id column
 * @method AssayBiomaterial findOneByChannelId(int $channel_id) Return the first AssayBiomaterial filtered by the channel_id column
 * @method AssayBiomaterial findOneByRank(int $rank) Return the first AssayBiomaterial filtered by the rank column
 *
 * @method array findByAssayBiomaterialId(int $assay_biomaterial_id) Return AssayBiomaterial objects filtered by the assay_biomaterial_id column
 * @method array findByAssayId(int $assay_id) Return AssayBiomaterial objects filtered by the assay_id column
 * @method array findByBiomaterialId(int $biomaterial_id) Return AssayBiomaterial objects filtered by the biomaterial_id column
 * @method array findByChannelId(int $channel_id) Return AssayBiomaterial objects filtered by the channel_id column
 * @method array findByRank(int $rank) Return AssayBiomaterial objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAssayBiomaterialQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAssayBiomaterialQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\AssayBiomaterial', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AssayBiomaterialQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AssayBiomaterialQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AssayBiomaterialQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AssayBiomaterialQuery) {
            return $criteria;
        }
        $query = new AssayBiomaterialQuery();
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
     * @return   AssayBiomaterial|AssayBiomaterial[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AssayBiomaterialPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AssayBiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 AssayBiomaterial A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAssayBiomaterialId($key, $con = null)
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
     * @return                 AssayBiomaterial A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "assay_biomaterial_id", "assay_id", "biomaterial_id", "channel_id", "rank" FROM "assay_biomaterial" WHERE "assay_biomaterial_id" = :p0';
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
            $obj = new AssayBiomaterial();
            $obj->hydrate($row);
            AssayBiomaterialPeer::addInstanceToPool($obj, (string) $key);
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
     * @return AssayBiomaterial|AssayBiomaterial[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|AssayBiomaterial[]|mixed the list of results, formatted by the current formatter
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the assay_biomaterial_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAssayBiomaterialId(1234); // WHERE assay_biomaterial_id = 1234
     * $query->filterByAssayBiomaterialId(array(12, 34)); // WHERE assay_biomaterial_id IN (12, 34)
     * $query->filterByAssayBiomaterialId(array('min' => 12)); // WHERE assay_biomaterial_id >= 12
     * $query->filterByAssayBiomaterialId(array('max' => 12)); // WHERE assay_biomaterial_id <= 12
     * </code>
     *
     * @param     mixed $assayBiomaterialId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByAssayBiomaterialId($assayBiomaterialId = null, $comparison = null)
    {
        if (is_array($assayBiomaterialId)) {
            $useMinMax = false;
            if (isset($assayBiomaterialId['min'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $assayBiomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayBiomaterialId['max'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $assayBiomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $assayBiomaterialId, $comparison);
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_ID, $assayId, $comparison);
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayBiomaterialPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
    }

    /**
     * Filter the query on the channel_id column
     *
     * Example usage:
     * <code>
     * $query->filterByChannelId(1234); // WHERE channel_id = 1234
     * $query->filterByChannelId(array(12, 34)); // WHERE channel_id IN (12, 34)
     * $query->filterByChannelId(array('min' => 12)); // WHERE channel_id >= 12
     * $query->filterByChannelId(array('max' => 12)); // WHERE channel_id <= 12
     * </code>
     *
     * @see       filterByChannel()
     *
     * @param     mixed $channelId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByChannelId($channelId = null, $comparison = null)
    {
        if (is_array($channelId)) {
            $useMinMax = false;
            if (isset($channelId['min'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::CHANNEL_ID, $channelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($channelId['max'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::CHANNEL_ID, $channelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayBiomaterialPeer::CHANNEL_ID, $channelId, $comparison);
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(AssayBiomaterialPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayBiomaterialPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayBiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(AssayBiomaterialPeer::ASSAY_ID, $assay->getAssayId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssayBiomaterialPeer::ASSAY_ID, $assay->toKeyValue('PrimaryKey', 'AssayId'), $comparison);
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
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
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayBiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(AssayBiomaterialPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssayBiomaterialPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
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
     * @return AssayBiomaterialQuery The current query, for fluid interface
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
     * Filter the query by a related Channel object
     *
     * @param   Channel|PropelObjectCollection $channel The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayBiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByChannel($channel, $comparison = null)
    {
        if ($channel instanceof Channel) {
            return $this
                ->addUsingAlias(AssayBiomaterialPeer::CHANNEL_ID, $channel->getChannelId(), $comparison);
        } elseif ($channel instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssayBiomaterialPeer::CHANNEL_ID, $channel->toKeyValue('PrimaryKey', 'ChannelId'), $comparison);
        } else {
            throw new PropelException('filterByChannel() only accepts arguments of type Channel or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Channel relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function joinChannel($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Channel');

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
            $this->addJoinObject($join, 'Channel');
        }

        return $this;
    }

    /**
     * Use the Channel relation Channel object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ChannelQuery A secondary query class using the current class as primary query
     */
    public function useChannelQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinChannel($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Channel', '\cli_db\propel\ChannelQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   AssayBiomaterial $assayBiomaterial Object to remove from the list of results
     *
     * @return AssayBiomaterialQuery The current query, for fluid interface
     */
    public function prune($assayBiomaterial = null)
    {
        if ($assayBiomaterial) {
            $this->addUsingAlias(AssayBiomaterialPeer::ASSAY_BIOMATERIAL_ID, $assayBiomaterial->getAssayBiomaterialId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
