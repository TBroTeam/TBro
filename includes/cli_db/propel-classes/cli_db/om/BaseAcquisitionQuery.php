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
use cli_db\propel\AcquisitionPeer;
use cli_db\propel\AcquisitionQuery;
use cli_db\propel\AcquisitionRelationship;
use cli_db\propel\Acquisitionprop;
use cli_db\propel\Assay;
use cli_db\propel\Channel;
use cli_db\propel\Protocol;
use cli_db\propel\Quantification;

/**
 * Base class that represents a query for the 'acquisition' table.
 *
 *
 *
 * @method AcquisitionQuery orderByAcquisitionId($order = Criteria::ASC) Order by the acquisition_id column
 * @method AcquisitionQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 * @method AcquisitionQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method AcquisitionQuery orderByChannelId($order = Criteria::ASC) Order by the channel_id column
 * @method AcquisitionQuery orderByAcquisitiondate($order = Criteria::ASC) Order by the acquisitiondate column
 * @method AcquisitionQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AcquisitionQuery orderByUri($order = Criteria::ASC) Order by the uri column
 *
 * @method AcquisitionQuery groupByAcquisitionId() Group by the acquisition_id column
 * @method AcquisitionQuery groupByAssayId() Group by the assay_id column
 * @method AcquisitionQuery groupByProtocolId() Group by the protocol_id column
 * @method AcquisitionQuery groupByChannelId() Group by the channel_id column
 * @method AcquisitionQuery groupByAcquisitiondate() Group by the acquisitiondate column
 * @method AcquisitionQuery groupByName() Group by the name column
 * @method AcquisitionQuery groupByUri() Group by the uri column
 *
 * @method AcquisitionQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AcquisitionQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AcquisitionQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AcquisitionQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method AcquisitionQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method AcquisitionQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method AcquisitionQuery leftJoinChannel($relationAlias = null) Adds a LEFT JOIN clause to the query using the Channel relation
 * @method AcquisitionQuery rightJoinChannel($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Channel relation
 * @method AcquisitionQuery innerJoinChannel($relationAlias = null) Adds a INNER JOIN clause to the query using the Channel relation
 *
 * @method AcquisitionQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method AcquisitionQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method AcquisitionQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method AcquisitionQuery leftJoinAcquisitionRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AcquisitionRelationshipRelatedByObjectId relation
 * @method AcquisitionQuery rightJoinAcquisitionRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AcquisitionRelationshipRelatedByObjectId relation
 * @method AcquisitionQuery innerJoinAcquisitionRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the AcquisitionRelationshipRelatedByObjectId relation
 *
 * @method AcquisitionQuery leftJoinAcquisitionRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the AcquisitionRelationshipRelatedBySubjectId relation
 * @method AcquisitionQuery rightJoinAcquisitionRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AcquisitionRelationshipRelatedBySubjectId relation
 * @method AcquisitionQuery innerJoinAcquisitionRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the AcquisitionRelationshipRelatedBySubjectId relation
 *
 * @method AcquisitionQuery leftJoinAcquisitionprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisitionprop relation
 * @method AcquisitionQuery rightJoinAcquisitionprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisitionprop relation
 * @method AcquisitionQuery innerJoinAcquisitionprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisitionprop relation
 *
 * @method AcquisitionQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method AcquisitionQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method AcquisitionQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method Acquisition findOne(PropelPDO $con = null) Return the first Acquisition matching the query
 * @method Acquisition findOneOrCreate(PropelPDO $con = null) Return the first Acquisition matching the query, or a new Acquisition object populated from the query conditions when no match is found
 *
 * @method Acquisition findOneByAssayId(int $assay_id) Return the first Acquisition filtered by the assay_id column
 * @method Acquisition findOneByProtocolId(int $protocol_id) Return the first Acquisition filtered by the protocol_id column
 * @method Acquisition findOneByChannelId(int $channel_id) Return the first Acquisition filtered by the channel_id column
 * @method Acquisition findOneByAcquisitiondate(string $acquisitiondate) Return the first Acquisition filtered by the acquisitiondate column
 * @method Acquisition findOneByName(string $name) Return the first Acquisition filtered by the name column
 * @method Acquisition findOneByUri(string $uri) Return the first Acquisition filtered by the uri column
 *
 * @method array findByAcquisitionId(int $acquisition_id) Return Acquisition objects filtered by the acquisition_id column
 * @method array findByAssayId(int $assay_id) Return Acquisition objects filtered by the assay_id column
 * @method array findByProtocolId(int $protocol_id) Return Acquisition objects filtered by the protocol_id column
 * @method array findByChannelId(int $channel_id) Return Acquisition objects filtered by the channel_id column
 * @method array findByAcquisitiondate(string $acquisitiondate) Return Acquisition objects filtered by the acquisitiondate column
 * @method array findByName(string $name) Return Acquisition objects filtered by the name column
 * @method array findByUri(string $uri) Return Acquisition objects filtered by the uri column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAcquisitionQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAcquisitionQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Acquisition', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AcquisitionQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AcquisitionQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AcquisitionQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AcquisitionQuery) {
            return $criteria;
        }
        $query = new AcquisitionQuery();
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
     * @return   Acquisition|Acquisition[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AcquisitionPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AcquisitionPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Acquisition A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAcquisitionId($key, $con = null)
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
     * @return                 Acquisition A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "acquisition_id", "assay_id", "protocol_id", "channel_id", "acquisitiondate", "name", "uri" FROM "acquisition" WHERE "acquisition_id" = :p0';
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
            $obj = new Acquisition();
            $obj->hydrate($row);
            AcquisitionPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Acquisition|Acquisition[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Acquisition[]|mixed the list of results, formatted by the current formatter
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
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $keys, Criteria::IN);
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
     * @param     mixed $acquisitionId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByAcquisitionId($acquisitionId = null, $comparison = null)
    {
        if (is_array($acquisitionId)) {
            $useMinMax = false;
            if (isset($acquisitionId['min'])) {
                $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitionId['max'])) {
                $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionId, $comparison);
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
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(AcquisitionPeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(AcquisitionPeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::ASSAY_ID, $assayId, $comparison);
    }

    /**
     * Filter the query on the protocol_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProtocolId(1234); // WHERE protocol_id = 1234
     * $query->filterByProtocolId(array(12, 34)); // WHERE protocol_id IN (12, 34)
     * $query->filterByProtocolId(array('min' => 12)); // WHERE protocol_id >= 12
     * $query->filterByProtocolId(array('max' => 12)); // WHERE protocol_id <= 12
     * </code>
     *
     * @see       filterByProtocol()
     *
     * @param     mixed $protocolId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(AcquisitionPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(AcquisitionPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::PROTOCOL_ID, $protocolId, $comparison);
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
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByChannelId($channelId = null, $comparison = null)
    {
        if (is_array($channelId)) {
            $useMinMax = false;
            if (isset($channelId['min'])) {
                $this->addUsingAlias(AcquisitionPeer::CHANNEL_ID, $channelId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($channelId['max'])) {
                $this->addUsingAlias(AcquisitionPeer::CHANNEL_ID, $channelId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::CHANNEL_ID, $channelId, $comparison);
    }

    /**
     * Filter the query on the acquisitiondate column
     *
     * Example usage:
     * <code>
     * $query->filterByAcquisitiondate('2011-03-14'); // WHERE acquisitiondate = '2011-03-14'
     * $query->filterByAcquisitiondate('now'); // WHERE acquisitiondate = '2011-03-14'
     * $query->filterByAcquisitiondate(array('max' => 'yesterday')); // WHERE acquisitiondate > '2011-03-13'
     * </code>
     *
     * @param     mixed $acquisitiondate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByAcquisitiondate($acquisitiondate = null, $comparison = null)
    {
        if (is_array($acquisitiondate)) {
            $useMinMax = false;
            if (isset($acquisitiondate['min'])) {
                $this->addUsingAlias(AcquisitionPeer::ACQUISITIONDATE, $acquisitiondate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitiondate['max'])) {
                $this->addUsingAlias(AcquisitionPeer::ACQUISITIONDATE, $acquisitiondate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::ACQUISITIONDATE, $acquisitiondate, $comparison);
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
     * @return AcquisitionQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AcquisitionPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the uri column
     *
     * Example usage:
     * <code>
     * $query->filterByUri('fooValue');   // WHERE uri = 'fooValue'
     * $query->filterByUri('%fooValue%'); // WHERE uri LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uri The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function filterByUri($uri = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uri)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uri)) {
                $uri = str_replace('*', '%', $uri);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AcquisitionPeer::URI, $uri, $comparison);
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(AcquisitionPeer::ASSAY_ID, $assay->getAssayId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionPeer::ASSAY_ID, $assay->toKeyValue('PrimaryKey', 'AssayId'), $comparison);
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
     * @return AcquisitionQuery The current query, for fluid interface
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
     * Filter the query by a related Channel object
     *
     * @param   Channel|PropelObjectCollection $channel The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByChannel($channel, $comparison = null)
    {
        if ($channel instanceof Channel) {
            return $this
                ->addUsingAlias(AcquisitionPeer::CHANNEL_ID, $channel->getChannelId(), $comparison);
        } elseif ($channel instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionPeer::CHANNEL_ID, $channel->toKeyValue('PrimaryKey', 'ChannelId'), $comparison);
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
     * @return AcquisitionQuery The current query, for fluid interface
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
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(AcquisitionPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AcquisitionPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
        } else {
            throw new PropelException('filterByProtocol() only accepts arguments of type Protocol or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Protocol relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function joinProtocol($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Protocol');

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
            $this->addJoinObject($join, 'Protocol');
        }

        return $this;
    }

    /**
     * Use the Protocol relation Protocol object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolQuery A secondary query class using the current class as primary query
     */
    public function useProtocolQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinProtocol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Protocol', '\cli_db\propel\ProtocolQuery');
    }

    /**
     * Filter the query by a related AcquisitionRelationship object
     *
     * @param   AcquisitionRelationship|PropelObjectCollection $acquisitionRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionRelationshipRelatedByObjectId($acquisitionRelationship, $comparison = null)
    {
        if ($acquisitionRelationship instanceof AcquisitionRelationship) {
            return $this
                ->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionRelationship->getObjectId(), $comparison);
        } elseif ($acquisitionRelationship instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($acquisitionRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAcquisitionRelationshipRelatedByObjectId() only accepts arguments of type AcquisitionRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AcquisitionRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function joinAcquisitionRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AcquisitionRelationshipRelatedByObjectId');

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
            $this->addJoinObject($join, 'AcquisitionRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the AcquisitionRelationshipRelatedByObjectId relation AcquisitionRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AcquisitionRelationshipRelatedByObjectId', '\cli_db\propel\AcquisitionRelationshipQuery');
    }

    /**
     * Filter the query by a related AcquisitionRelationship object
     *
     * @param   AcquisitionRelationship|PropelObjectCollection $acquisitionRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionRelationshipRelatedBySubjectId($acquisitionRelationship, $comparison = null)
    {
        if ($acquisitionRelationship instanceof AcquisitionRelationship) {
            return $this
                ->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionRelationship->getSubjectId(), $comparison);
        } elseif ($acquisitionRelationship instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($acquisitionRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAcquisitionRelationshipRelatedBySubjectId() only accepts arguments of type AcquisitionRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AcquisitionRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function joinAcquisitionRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AcquisitionRelationshipRelatedBySubjectId');

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
            $this->addJoinObject($join, 'AcquisitionRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the AcquisitionRelationshipRelatedBySubjectId relation AcquisitionRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AcquisitionRelationshipRelatedBySubjectId', '\cli_db\propel\AcquisitionRelationshipQuery');
    }

    /**
     * Filter the query by a related Acquisitionprop object
     *
     * @param   Acquisitionprop|PropelObjectCollection $acquisitionprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisitionprop($acquisitionprop, $comparison = null)
    {
        if ($acquisitionprop instanceof Acquisitionprop) {
            return $this
                ->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisitionprop->getAcquisitionId(), $comparison);
        } elseif ($acquisitionprop instanceof PropelObjectCollection) {
            return $this
                ->useAcquisitionpropQuery()
                ->filterByPrimaryKeys($acquisitionprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAcquisitionprop() only accepts arguments of type Acquisitionprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Acquisitionprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function joinAcquisitionprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Acquisitionprop');

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
            $this->addJoinObject($join, 'Acquisitionprop');
        }

        return $this;
    }

    /**
     * Use the Acquisitionprop relation Acquisitionprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AcquisitionpropQuery A secondary query class using the current class as primary query
     */
    public function useAcquisitionpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAcquisitionprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Acquisitionprop', '\cli_db\propel\AcquisitionpropQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AcquisitionQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $quantification->getAcquisitionId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            return $this
                ->useQuantificationQuery()
                ->filterByPrimaryKeys($quantification->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuantification() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function joinQuantification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantification');

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
            $this->addJoinObject($join, 'Quantification');
        }

        return $this;
    }

    /**
     * Use the Quantification relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantification', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Acquisition $acquisition Object to remove from the list of results
     *
     * @return AcquisitionQuery The current query, for fluid interface
     */
    public function prune($acquisition = null)
    {
        if ($acquisition) {
            $this->addUsingAlias(AcquisitionPeer::ACQUISITION_ID, $acquisition->getAcquisitionId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
