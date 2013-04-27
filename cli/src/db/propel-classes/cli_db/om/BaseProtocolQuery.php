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
use cli_db\propel\Arraydesign;
use cli_db\propel\Assay;
use cli_db\propel\Cvterm;
use cli_db\propel\Dbxref;
use cli_db\propel\Protocol;
use cli_db\propel\ProtocolPeer;
use cli_db\propel\ProtocolQuery;
use cli_db\propel\Protocolparam;
use cli_db\propel\Pub;
use cli_db\propel\Quantification;
use cli_db\propel\Treatment;

/**
 * Base class that represents a query for the 'protocol' table.
 *
 *
 *
 * @method ProtocolQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method ProtocolQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method ProtocolQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method ProtocolQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method ProtocolQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProtocolQuery orderByUri($order = Criteria::ASC) Order by the uri column
 * @method ProtocolQuery orderByProtocoldescription($order = Criteria::ASC) Order by the protocoldescription column
 * @method ProtocolQuery orderByHardwaredescription($order = Criteria::ASC) Order by the hardwaredescription column
 * @method ProtocolQuery orderBySoftwaredescription($order = Criteria::ASC) Order by the softwaredescription column
 *
 * @method ProtocolQuery groupByProtocolId() Group by the protocol_id column
 * @method ProtocolQuery groupByTypeId() Group by the type_id column
 * @method ProtocolQuery groupByPubId() Group by the pub_id column
 * @method ProtocolQuery groupByDbxrefId() Group by the dbxref_id column
 * @method ProtocolQuery groupByName() Group by the name column
 * @method ProtocolQuery groupByUri() Group by the uri column
 * @method ProtocolQuery groupByProtocoldescription() Group by the protocoldescription column
 * @method ProtocolQuery groupByHardwaredescription() Group by the hardwaredescription column
 * @method ProtocolQuery groupBySoftwaredescription() Group by the softwaredescription column
 *
 * @method ProtocolQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProtocolQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProtocolQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProtocolQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method ProtocolQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method ProtocolQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method ProtocolQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method ProtocolQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method ProtocolQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method ProtocolQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method ProtocolQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method ProtocolQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method ProtocolQuery leftJoinAcquisition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisition relation
 * @method ProtocolQuery rightJoinAcquisition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisition relation
 * @method ProtocolQuery innerJoinAcquisition($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisition relation
 *
 * @method ProtocolQuery leftJoinArraydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arraydesign relation
 * @method ProtocolQuery rightJoinArraydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arraydesign relation
 * @method ProtocolQuery innerJoinArraydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Arraydesign relation
 *
 * @method ProtocolQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method ProtocolQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method ProtocolQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method ProtocolQuery leftJoinProtocolparam($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocolparam relation
 * @method ProtocolQuery rightJoinProtocolparam($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocolparam relation
 * @method ProtocolQuery innerJoinProtocolparam($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocolparam relation
 *
 * @method ProtocolQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method ProtocolQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method ProtocolQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method ProtocolQuery leftJoinTreatment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Treatment relation
 * @method ProtocolQuery rightJoinTreatment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Treatment relation
 * @method ProtocolQuery innerJoinTreatment($relationAlias = null) Adds a INNER JOIN clause to the query using the Treatment relation
 *
 * @method Protocol findOne(PropelPDO $con = null) Return the first Protocol matching the query
 * @method Protocol findOneOrCreate(PropelPDO $con = null) Return the first Protocol matching the query, or a new Protocol object populated from the query conditions when no match is found
 *
 * @method Protocol findOneByTypeId(int $type_id) Return the first Protocol filtered by the type_id column
 * @method Protocol findOneByPubId(int $pub_id) Return the first Protocol filtered by the pub_id column
 * @method Protocol findOneByDbxrefId(int $dbxref_id) Return the first Protocol filtered by the dbxref_id column
 * @method Protocol findOneByName(string $name) Return the first Protocol filtered by the name column
 * @method Protocol findOneByUri(string $uri) Return the first Protocol filtered by the uri column
 * @method Protocol findOneByProtocoldescription(string $protocoldescription) Return the first Protocol filtered by the protocoldescription column
 * @method Protocol findOneByHardwaredescription(string $hardwaredescription) Return the first Protocol filtered by the hardwaredescription column
 * @method Protocol findOneBySoftwaredescription(string $softwaredescription) Return the first Protocol filtered by the softwaredescription column
 *
 * @method array findByProtocolId(int $protocol_id) Return Protocol objects filtered by the protocol_id column
 * @method array findByTypeId(int $type_id) Return Protocol objects filtered by the type_id column
 * @method array findByPubId(int $pub_id) Return Protocol objects filtered by the pub_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Protocol objects filtered by the dbxref_id column
 * @method array findByName(string $name) Return Protocol objects filtered by the name column
 * @method array findByUri(string $uri) Return Protocol objects filtered by the uri column
 * @method array findByProtocoldescription(string $protocoldescription) Return Protocol objects filtered by the protocoldescription column
 * @method array findByHardwaredescription(string $hardwaredescription) Return Protocol objects filtered by the hardwaredescription column
 * @method array findBySoftwaredescription(string $softwaredescription) Return Protocol objects filtered by the softwaredescription column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProtocolQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProtocolQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Protocol', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProtocolQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProtocolQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProtocolQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProtocolQuery) {
            return $criteria;
        }
        $query = new ProtocolQuery();
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
     * @return   Protocol|Protocol[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProtocolPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProtocolPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Protocol A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByProtocolId($key, $con = null)
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
     * @return                 Protocol A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "protocol_id", "type_id", "pub_id", "dbxref_id", "name", "uri", "protocoldescription", "hardwaredescription", "softwaredescription" FROM "protocol" WHERE "protocol_id" = :p0';
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
            $obj = new Protocol();
            $obj->hydrate($row);
            ProtocolPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Protocol|Protocol[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Protocol[]|mixed the list of results, formatted by the current formatter
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $keys, Criteria::IN);
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
     * @param     mixed $protocolId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $protocolId, $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(ProtocolPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(ProtocolPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPubId(1234); // WHERE pub_id = 1234
     * $query->filterByPubId(array(12, 34)); // WHERE pub_id IN (12, 34)
     * $query->filterByPubId(array('min' => 12)); // WHERE pub_id >= 12
     * $query->filterByPubId(array('max' => 12)); // WHERE pub_id <= 12
     * </code>
     *
     * @see       filterByPub()
     *
     * @param     mixed $pubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(ProtocolPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(ProtocolPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::PUB_ID, $pubId, $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(ProtocolPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(ProtocolPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProtocolPeer::NAME, $name, $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProtocolPeer::URI, $uri, $comparison);
    }

    /**
     * Filter the query on the protocoldescription column
     *
     * Example usage:
     * <code>
     * $query->filterByProtocoldescription('fooValue');   // WHERE protocoldescription = 'fooValue'
     * $query->filterByProtocoldescription('%fooValue%'); // WHERE protocoldescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $protocoldescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByProtocoldescription($protocoldescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($protocoldescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $protocoldescription)) {
                $protocoldescription = str_replace('*', '%', $protocoldescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::PROTOCOLDESCRIPTION, $protocoldescription, $comparison);
    }

    /**
     * Filter the query on the hardwaredescription column
     *
     * Example usage:
     * <code>
     * $query->filterByHardwaredescription('fooValue');   // WHERE hardwaredescription = 'fooValue'
     * $query->filterByHardwaredescription('%fooValue%'); // WHERE hardwaredescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $hardwaredescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterByHardwaredescription($hardwaredescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($hardwaredescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $hardwaredescription)) {
                $hardwaredescription = str_replace('*', '%', $hardwaredescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::HARDWAREDESCRIPTION, $hardwaredescription, $comparison);
    }

    /**
     * Filter the query on the softwaredescription column
     *
     * Example usage:
     * <code>
     * $query->filterBySoftwaredescription('fooValue');   // WHERE softwaredescription = 'fooValue'
     * $query->filterBySoftwaredescription('%fooValue%'); // WHERE softwaredescription LIKE '%fooValue%'
     * </code>
     *
     * @param     string $softwaredescription The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function filterBySoftwaredescription($softwaredescription = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($softwaredescription)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $softwaredescription)) {
                $softwaredescription = str_replace('*', '%', $softwaredescription);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ProtocolPeer::SOFTWAREDESCRIPTION, $softwaredescription, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(ProtocolPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(ProtocolPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
        } else {
            throw new PropelException('filterByPub() only accepts arguments of type Pub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pub');

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
            $this->addJoinObject($join, 'Pub');
        }

        return $this;
    }

    /**
     * Use the Pub relation Pub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubQuery A secondary query class using the current class as primary query
     */
    public function usePubQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ProtocolPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProtocolPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
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
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisition($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $acquisition->getProtocolId(), $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
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
     * Filter the query by a related Arraydesign object
     *
     * @param   Arraydesign|PropelObjectCollection $arraydesign  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesign($arraydesign, $comparison = null)
    {
        if ($arraydesign instanceof Arraydesign) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $arraydesign->getProtocolId(), $comparison);
        } elseif ($arraydesign instanceof PropelObjectCollection) {
            return $this
                ->useArraydesignQuery()
                ->filterByPrimaryKeys($arraydesign->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArraydesign() only accepts arguments of type Arraydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arraydesign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinArraydesign($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arraydesign');

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
            $this->addJoinObject($join, 'Arraydesign');
        }

        return $this;
    }

    /**
     * Use the Arraydesign relation Arraydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinArraydesign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arraydesign', '\cli_db\propel\ArraydesignQuery');
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $assay->getProtocolId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            return $this
                ->useAssayQuery()
                ->filterByPrimaryKeys($assay->getPrimaryKeys())
                ->endUse();
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinAssay($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAssayQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAssay($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Assay', '\cli_db\propel\AssayQuery');
    }

    /**
     * Filter the query by a related Protocolparam object
     *
     * @param   Protocolparam|PropelObjectCollection $protocolparam  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocolparam($protocolparam, $comparison = null)
    {
        if ($protocolparam instanceof Protocolparam) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $protocolparam->getProtocolId(), $comparison);
        } elseif ($protocolparam instanceof PropelObjectCollection) {
            return $this
                ->useProtocolparamQuery()
                ->filterByPrimaryKeys($protocolparam->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProtocolparam() only accepts arguments of type Protocolparam or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Protocolparam relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinProtocolparam($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Protocolparam');

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
            $this->addJoinObject($join, 'Protocolparam');
        }

        return $this;
    }

    /**
     * Use the Protocolparam relation Protocolparam object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProtocolparamQuery A secondary query class using the current class as primary query
     */
    public function useProtocolparamQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProtocolparam($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Protocolparam', '\cli_db\propel\ProtocolparamQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $quantification->getProtocolId(), $comparison);
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
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinQuantification($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useQuantificationQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinQuantification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantification', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Filter the query by a related Treatment object
     *
     * @param   Treatment|PropelObjectCollection $treatment  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProtocolQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTreatment($treatment, $comparison = null)
    {
        if ($treatment instanceof Treatment) {
            return $this
                ->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $treatment->getProtocolId(), $comparison);
        } elseif ($treatment instanceof PropelObjectCollection) {
            return $this
                ->useTreatmentQuery()
                ->filterByPrimaryKeys($treatment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByTreatment() only accepts arguments of type Treatment or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Treatment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function joinTreatment($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Treatment');

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
            $this->addJoinObject($join, 'Treatment');
        }

        return $this;
    }

    /**
     * Use the Treatment relation Treatment object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\TreatmentQuery A secondary query class using the current class as primary query
     */
    public function useTreatmentQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinTreatment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Treatment', '\cli_db\propel\TreatmentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Protocol $protocol Object to remove from the list of results
     *
     * @return ProtocolQuery The current query, for fluid interface
     */
    public function prune($protocol = null)
    {
        if ($protocol) {
            $this->addUsingAlias(ProtocolPeer::PROTOCOL_ID, $protocol->getProtocolId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
