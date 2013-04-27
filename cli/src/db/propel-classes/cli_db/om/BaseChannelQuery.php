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
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\Channel;
use cli_db\propel\ChannelPeer;
use cli_db\propel\ChannelQuery;

/**
 * Base class that represents a query for the 'channel' table.
 *
 *
 *
 * @method ChannelQuery orderByChannelId($order = Criteria::ASC) Order by the channel_id column
 * @method ChannelQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ChannelQuery orderByDefinition($order = Criteria::ASC) Order by the definition column
 *
 * @method ChannelQuery groupByChannelId() Group by the channel_id column
 * @method ChannelQuery groupByName() Group by the name column
 * @method ChannelQuery groupByDefinition() Group by the definition column
 *
 * @method ChannelQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ChannelQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ChannelQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ChannelQuery leftJoinAcquisition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisition relation
 * @method ChannelQuery rightJoinAcquisition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisition relation
 * @method ChannelQuery innerJoinAcquisition($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisition relation
 *
 * @method ChannelQuery leftJoinAssayBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssayBiomaterial relation
 * @method ChannelQuery rightJoinAssayBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssayBiomaterial relation
 * @method ChannelQuery innerJoinAssayBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the AssayBiomaterial relation
 *
 * @method Channel findOne(PropelPDO $con = null) Return the first Channel matching the query
 * @method Channel findOneOrCreate(PropelPDO $con = null) Return the first Channel matching the query, or a new Channel object populated from the query conditions when no match is found
 *
 * @method Channel findOneByName(string $name) Return the first Channel filtered by the name column
 * @method Channel findOneByDefinition(string $definition) Return the first Channel filtered by the definition column
 *
 * @method array findByChannelId(int $channel_id) Return Channel objects filtered by the channel_id column
 * @method array findByName(string $name) Return Channel objects filtered by the name column
 * @method array findByDefinition(string $definition) Return Channel objects filtered by the definition column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseChannelQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseChannelQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Channel', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ChannelQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ChannelQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ChannelQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ChannelQuery) {
            return $criteria;
        }
        $query = new ChannelQuery();
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
     * @return   Channel|Channel[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ChannelPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ChannelPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Channel A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByChannelId($key, $con = null)
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
     * @return                 Channel A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "channel_id", "name", "definition" FROM "channel" WHERE "channel_id" = :p0';
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
            $obj = new Channel();
            $obj->hydrate($row);
            ChannelPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Channel|Channel[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Channel[]|mixed the list of results, formatted by the current formatter
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
     * @return ChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ChannelQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $keys, Criteria::IN);
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
     * @param     mixed $channelId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ChannelQuery The current query, for fluid interface
     */
    public function filterByChannelId($channelId = null, $comparison = null)
    {
        if (is_array($channelId)) {
            $useMinMax = false;
            if (isset($channelId['min'])) {
                $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $channelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($channelId['max'])) {
                $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $channelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $channelId, $comparison);
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
     * @return ChannelQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ChannelPeer::NAME, $name, $comparison);
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
     * @return ChannelQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ChannelPeer::DEFINITION, $definition, $comparison);
    }

    /**
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ChannelQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisition($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(ChannelPeer::CHANNEL_ID, $acquisition->getChannelId(), $comparison);
        } elseif ($acquisition instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionQuery()
                ->filterByPrimaryKeys($acquisition->getPrimaryKeys())
                ->endUse();
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
     * @return ChannelQuery The current query, for fluid interface
     */
    public function joinAcquisition($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAcquisitionQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAcquisition($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Acquisition', '\cli_db\propel\AcquisitionQuery');
    }

    /**
     * Filter the query by a related AssayBiomaterial object
     *
     * @param   AssayBiomaterial|PropelObjectCollection $assayBiomaterial  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ChannelQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssayBiomaterial($assayBiomaterial, $comparison = null)
    {
        if ($assayBiomaterial instanceof AssayBiomaterial) {
            return $this
                ->addUsingAlias(ChannelPeer::CHANNEL_ID, $assayBiomaterial->getChannelId(), $comparison);
        } elseif ($assayBiomaterial instanceof PropelObjectCollection) {
            return $this
                ->useAssayBiomaterialQuery()
                ->filterByPrimaryKeys($assayBiomaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssayBiomaterial() only accepts arguments of type AssayBiomaterial or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssayBiomaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ChannelQuery The current query, for fluid interface
     */
    public function joinAssayBiomaterial($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssayBiomaterial');

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
            $this->addJoinObject($join, 'AssayBiomaterial');
        }

        return $this;
    }

    /**
     * Use the AssayBiomaterial relation AssayBiomaterial object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssayBiomaterialQuery A secondary query class using the current class as primary query
     */
    public function useAssayBiomaterialQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssayBiomaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssayBiomaterial', '\cli_db\propel\AssayBiomaterialQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Channel $channel Object to remove from the list of results
     *
     * @return ChannelQuery The current query, for fluid interface
     */
    public function prune($channel = null)
    {
        if ($channel) {
            $this->addUsingAlias(ChannelPeer::CHANNEL_ID, $channel->getChannelId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
