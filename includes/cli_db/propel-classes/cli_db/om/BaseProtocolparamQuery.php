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
use cli_db\propel\Protocol;
use cli_db\propel\Protocolparam;
use cli_db\propel\ProtocolparamPeer;
use cli_db\propel\ProtocolparamQuery;

/**
 * Base class that represents a query for the 'protocolparam' table.
 *
 *
 *
 * @method ProtocolparamQuery orderByProtocolparamId($order = Criteria::ASC) Order by the protocolparam_id column
 * @method ProtocolparamQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method ProtocolparamQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProtocolparamQuery orderByDatatypeId($order = Criteria::ASC) Order by the datatype_id column
 * @method ProtocolparamQuery orderByUnittypeId($order = Criteria::ASC) Order by the unittype_id column
 * @method ProtocolparamQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method ProtocolparamQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method ProtocolparamQuery groupByProtocolparamId() Group by the protocolparam_id column
 * @method ProtocolparamQuery groupByProtocolId() Group by the protocol_id column
 * @method ProtocolparamQuery groupByName() Group by the name column
 * @method ProtocolparamQuery groupByDatatypeId() Group by the datatype_id column
 * @method ProtocolparamQuery groupByUnittypeId() Group by the unittype_id column
 * @method ProtocolparamQuery groupByValue() Group by the value column
 * @method ProtocolparamQuery groupByRank() Group by the rank column
 *
 * @method ProtocolparamQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProtocolparamQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProtocolparamQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProtocolparamQuery leftJoinCvtermRelatedByDatatypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByDatatypeId relation
 * @method ProtocolparamQuery rightJoinCvtermRelatedByDatatypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByDatatypeId relation
 * @method ProtocolparamQuery innerJoinCvtermRelatedByDatatypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByDatatypeId relation
 *
 * @method ProtocolparamQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method ProtocolparamQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method ProtocolparamQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method ProtocolparamQuery leftJoinCvtermRelatedByUnittypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByUnittypeId relation
 * @method ProtocolparamQuery rightJoinCvtermRelatedByUnittypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByUnittypeId relation
 * @method ProtocolparamQuery innerJoinCvtermRelatedByUnittypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByUnittypeId relation
 *
 * @method Protocolparam findOne(PropelPDO $con = null) Return the first Protocolparam matching the query
 * @method Protocolparam findOneOrCreate(PropelPDO $con = null) Return the first Protocolparam matching the query, or a new Protocolparam object populated from the query conditions when no match is found
 *
 * @method Protocolparam findOneByProtocolId(int $protocol_id) Return the first Protocolparam filtered by the protocol_id column
 * @method Protocolparam findOneByName(string $name) Return the first Protocolparam filtered by the name column
 * @method Protocolparam findOneByDatatypeId(int $datatype_id) Return the first Protocolparam filtered by the datatype_id column
 * @method Protocolparam findOneByUnittypeId(int $unittype_id) Return the first Protocolparam filtered by the unittype_id column
 * @method Protocolparam findOneByValue(string $value) Return the first Protocolparam filtered by the value column
 * @method Protocolparam findOneByRank(int $rank) Return the first Protocolparam filtered by the rank column
 *
 * @method array findByProtocolparamId(int $protocolparam_id) Return Protocolparam objects filtered by the protocolparam_id column
 * @method array findByProtocolId(int $protocol_id) Return Protocolparam objects filtered by the protocol_id column
 * @method array findByName(string $name) Return Protocolparam objects filtered by the name column
 * @method array findByDatatypeId(int $datatype_id) Return Protocolparam objects filtered by the datatype_id column
 * @method array findByUnittypeId(int $unittype_id) Return Protocolparam objects filtered by the unittype_id column
 * @method array findByValue(string $value) Return Protocolparam objects filtered by the value column
 * @method array findByRank(int $rank) Return Protocolparam objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProtocolparamQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProtocolparamQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Protocolparam', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProtocolparamQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProtocolparamQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProtocolparamQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProtocolparamQuery) {
            return $criteria;
        }
        $query = new ProtocolparamQuery();
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
     * @return   Protocolparam|Protocolparam[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProtocolparamPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProtocolparamPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Protocolparam A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByProtocolparamId($key, $con = null)
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
     * @return                 Protocolparam A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "protocolparam_id", "protocol_id", "name", "datatype_id", "unittype_id", "value", "rank" FROM "protocolparam" WHERE "protocolparam_id" = :p0';
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
            $obj = new Protocolparam();
            $obj->hydrate($row);
            ProtocolparamPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Protocolparam|Protocolparam[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Protocolparam[]|mixed the list of results, formatted by the current formatter
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
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the protocolparam_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProtocolparamId(1234); // WHERE protocolparam_id = 1234
     * $query->filterByProtocolparamId(array(12, 34)); // WHERE protocolparam_id IN (12, 34)
     * $query->filterByProtocolparamId(array('min' => 12)); // WHERE protocolparam_id >= 12
     * $query->filterByProtocolparamId(array('max' => 12)); // WHERE protocolparam_id <= 12
     * </code>
     *
     * @param     mixed $protocolparamId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByProtocolparamId($protocolparamId = null, $comparison = null)
    {
        if (is_array($protocolparamId)) {
            $useMinMax = false;
            if (isset($protocolparamId['min'])) {
                $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $protocolparamId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolparamId['max'])) {
                $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $protocolparamId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $protocolparamId, $comparison);
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
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(ProtocolparamPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(ProtocolparamPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolparamPeer::PROTOCOL_ID, $protocolId, $comparison);
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
     * @return ProtocolparamQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProtocolparamPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the datatype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDatatypeId(1234); // WHERE datatype_id = 1234
     * $query->filterByDatatypeId(array(12, 34)); // WHERE datatype_id IN (12, 34)
     * $query->filterByDatatypeId(array('min' => 12)); // WHERE datatype_id >= 12
     * $query->filterByDatatypeId(array('max' => 12)); // WHERE datatype_id <= 12
     * </code>
     *
     * @see       filterByCvtermRelatedByDatatypeId()
     *
     * @param     mixed $datatypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByDatatypeId($datatypeId = null, $comparison = null)
    {
        if (is_array($datatypeId)) {
            $useMinMax = false;
            if (isset($datatypeId['min'])) {
                $this->addUsingAlias(ProtocolparamPeer::DATATYPE_ID, $datatypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($datatypeId['max'])) {
                $this->addUsingAlias(ProtocolparamPeer::DATATYPE_ID, $datatypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolparamPeer::DATATYPE_ID, $datatypeId, $comparison);
    }

    /**
     * Filter the query on the unittype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByUnittypeId(1234); // WHERE unittype_id = 1234
     * $query->filterByUnittypeId(array(12, 34)); // WHERE unittype_id IN (12, 34)
     * $query->filterByUnittypeId(array('min' => 12)); // WHERE unittype_id >= 12
     * $query->filterByUnittypeId(array('max' => 12)); // WHERE unittype_id <= 12
     * </code>
     *
     * @see       filterByCvtermRelatedByUnittypeId()
     *
     * @param     mixed $unittypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByUnittypeId($unittypeId = null, $comparison = null)
    {
        if (is_array($unittypeId)) {
            $useMinMax = false;
            if (isset($unittypeId['min'])) {
                $this->addUsingAlias(ProtocolparamPeer::UNITTYPE_ID, $unittypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unittypeId['max'])) {
                $this->addUsingAlias(ProtocolparamPeer::UNITTYPE_ID, $unittypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolparamPeer::UNITTYPE_ID, $unittypeId, $comparison);
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
     * @return ProtocolparamQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProtocolparamPeer::VALUE, $value, $comparison);
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
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(ProtocolparamPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(ProtocolparamPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolparamPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolparamQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByDatatypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ProtocolparamPeer::DATATYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolparamPeer::DATATYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByDatatypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByDatatypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByDatatypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByDatatypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedByDatatypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByDatatypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByDatatypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvtermRelatedByDatatypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByDatatypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolparamQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(ProtocolparamPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolparamPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
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
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function joinProtocol($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useProtocolQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProtocol($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Protocol', '\cli_db\propel\ProtocolQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolparamQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByUnittypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ProtocolparamPeer::UNITTYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolparamPeer::UNITTYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByUnittypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByUnittypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByUnittypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByUnittypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedByUnittypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByUnittypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByUnittypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvtermRelatedByUnittypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByUnittypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Protocolparam $protocolparam Object to remove from the list of results
     *
     * @return ProtocolparamQuery The current query, for fluid interface
     */
    public function prune($protocolparam = null)
    {
        if ($protocolparam) {
            $this->addUsingAlias(ProtocolparamPeer::PROTOCOLPARAM_ID, $protocolparam->getProtocolparamId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
