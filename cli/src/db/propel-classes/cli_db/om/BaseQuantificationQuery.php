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
use cli_db\propel\Analysis;
use cli_db\propel\Contact;
use cli_db\propel\Protocol;
use cli_db\propel\Quantification;
use cli_db\propel\QuantificationPeer;
use cli_db\propel\QuantificationQuery;

/**
 * Base class that represents a query for the 'quantification' table.
 *
 *
 *
 * @method QuantificationQuery orderByQuantificationId($order = Criteria::ASC) Order by the quantification_id column
 * @method QuantificationQuery orderByAcquisitionId($order = Criteria::ASC) Order by the acquisition_id column
 * @method QuantificationQuery orderByOperatorId($order = Criteria::ASC) Order by the operator_id column
 * @method QuantificationQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method QuantificationQuery orderByAnalysisId($order = Criteria::ASC) Order by the analysis_id column
 * @method QuantificationQuery orderByQuantificationdate($order = Criteria::ASC) Order by the quantificationdate column
 * @method QuantificationQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method QuantificationQuery orderByUri($order = Criteria::ASC) Order by the uri column
 *
 * @method QuantificationQuery groupByQuantificationId() Group by the quantification_id column
 * @method QuantificationQuery groupByAcquisitionId() Group by the acquisition_id column
 * @method QuantificationQuery groupByOperatorId() Group by the operator_id column
 * @method QuantificationQuery groupByProtocolId() Group by the protocol_id column
 * @method QuantificationQuery groupByAnalysisId() Group by the analysis_id column
 * @method QuantificationQuery groupByQuantificationdate() Group by the quantificationdate column
 * @method QuantificationQuery groupByName() Group by the name column
 * @method QuantificationQuery groupByUri() Group by the uri column
 *
 * @method QuantificationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method QuantificationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method QuantificationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method QuantificationQuery leftJoinAcquisition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisition relation
 * @method QuantificationQuery rightJoinAcquisition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisition relation
 * @method QuantificationQuery innerJoinAcquisition($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisition relation
 *
 * @method QuantificationQuery leftJoinAnalysis($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysis relation
 * @method QuantificationQuery rightJoinAnalysis($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysis relation
 * @method QuantificationQuery innerJoinAnalysis($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysis relation
 *
 * @method QuantificationQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method QuantificationQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method QuantificationQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method QuantificationQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method QuantificationQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method QuantificationQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method Quantification findOne(PropelPDO $con = null) Return the first Quantification matching the query
 * @method Quantification findOneOrCreate(PropelPDO $con = null) Return the first Quantification matching the query, or a new Quantification object populated from the query conditions when no match is found
 *
 * @method Quantification findOneByAcquisitionId(int $acquisition_id) Return the first Quantification filtered by the acquisition_id column
 * @method Quantification findOneByOperatorId(int $operator_id) Return the first Quantification filtered by the operator_id column
 * @method Quantification findOneByProtocolId(int $protocol_id) Return the first Quantification filtered by the protocol_id column
 * @method Quantification findOneByAnalysisId(int $analysis_id) Return the first Quantification filtered by the analysis_id column
 * @method Quantification findOneByQuantificationdate(string $quantificationdate) Return the first Quantification filtered by the quantificationdate column
 * @method Quantification findOneByName(string $name) Return the first Quantification filtered by the name column
 * @method Quantification findOneByUri(string $uri) Return the first Quantification filtered by the uri column
 *
 * @method array findByQuantificationId(int $quantification_id) Return Quantification objects filtered by the quantification_id column
 * @method array findByAcquisitionId(int $acquisition_id) Return Quantification objects filtered by the acquisition_id column
 * @method array findByOperatorId(int $operator_id) Return Quantification objects filtered by the operator_id column
 * @method array findByProtocolId(int $protocol_id) Return Quantification objects filtered by the protocol_id column
 * @method array findByAnalysisId(int $analysis_id) Return Quantification objects filtered by the analysis_id column
 * @method array findByQuantificationdate(string $quantificationdate) Return Quantification objects filtered by the quantificationdate column
 * @method array findByName(string $name) Return Quantification objects filtered by the name column
 * @method array findByUri(string $uri) Return Quantification objects filtered by the uri column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseQuantificationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseQuantificationQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Quantification', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new QuantificationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   QuantificationQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return QuantificationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof QuantificationQuery) {
            return $criteria;
        }
        $query = new QuantificationQuery();
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
     * @return   Quantification|Quantification[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = QuantificationPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(QuantificationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Quantification A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByQuantificationId($key, $con = null)
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
     * @return                 Quantification A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "quantification_id", "acquisition_id", "operator_id", "protocol_id", "analysis_id", "quantificationdate", "name", "uri" FROM "quantification" WHERE "quantification_id" = :p0';
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
            $obj = new Quantification();
            $obj->hydrate($row);
            QuantificationPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Quantification|Quantification[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Quantification[]|mixed the list of results, formatted by the current formatter
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
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the quantification_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationId(1234); // WHERE quantification_id = 1234
     * $query->filterByQuantificationId(array(12, 34)); // WHERE quantification_id IN (12, 34)
     * $query->filterByQuantificationId(array('min' => 12)); // WHERE quantification_id >= 12
     * $query->filterByQuantificationId(array('max' => 12)); // WHERE quantification_id <= 12
     * </code>
     *
     * @param     mixed $quantificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByQuantificationId($quantificationId = null, $comparison = null)
    {
        if (is_array($quantificationId)) {
            $useMinMax = false;
            if (isset($quantificationId['min'])) {
                $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $quantificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationId['max'])) {
                $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $quantificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $quantificationId, $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByAcquisitionId($acquisitionId = null, $comparison = null)
    {
        if (is_array($acquisitionId)) {
            $useMinMax = false;
            if (isset($acquisitionId['min'])) {
                $this->addUsingAlias(QuantificationPeer::ACQUISITION_ID, $acquisitionId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($acquisitionId['max'])) {
                $this->addUsingAlias(QuantificationPeer::ACQUISITION_ID, $acquisitionId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::ACQUISITION_ID, $acquisitionId, $comparison);
    }

    /**
     * Filter the query on the operator_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOperatorId(1234); // WHERE operator_id = 1234
     * $query->filterByOperatorId(array(12, 34)); // WHERE operator_id IN (12, 34)
     * $query->filterByOperatorId(array('min' => 12)); // WHERE operator_id >= 12
     * $query->filterByOperatorId(array('max' => 12)); // WHERE operator_id <= 12
     * </code>
     *
     * @see       filterByContact()
     *
     * @param     mixed $operatorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByOperatorId($operatorId = null, $comparison = null)
    {
        if (is_array($operatorId)) {
            $useMinMax = false;
            if (isset($operatorId['min'])) {
                $this->addUsingAlias(QuantificationPeer::OPERATOR_ID, $operatorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($operatorId['max'])) {
                $this->addUsingAlias(QuantificationPeer::OPERATOR_ID, $operatorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::OPERATOR_ID, $operatorId, $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(QuantificationPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(QuantificationPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::PROTOCOL_ID, $protocolId, $comparison);
    }

    /**
     * Filter the query on the analysis_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysisId(1234); // WHERE analysis_id = 1234
     * $query->filterByAnalysisId(array(12, 34)); // WHERE analysis_id IN (12, 34)
     * $query->filterByAnalysisId(array('min' => 12)); // WHERE analysis_id >= 12
     * $query->filterByAnalysisId(array('max' => 12)); // WHERE analysis_id <= 12
     * </code>
     *
     * @see       filterByAnalysis()
     *
     * @param     mixed $analysisId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByAnalysisId($analysisId = null, $comparison = null)
    {
        if (is_array($analysisId)) {
            $useMinMax = false;
            if (isset($analysisId['min'])) {
                $this->addUsingAlias(QuantificationPeer::ANALYSIS_ID, $analysisId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisId['max'])) {
                $this->addUsingAlias(QuantificationPeer::ANALYSIS_ID, $analysisId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::ANALYSIS_ID, $analysisId, $comparison);
    }

    /**
     * Filter the query on the quantificationdate column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationdate('2011-03-14'); // WHERE quantificationdate = '2011-03-14'
     * $query->filterByQuantificationdate('now'); // WHERE quantificationdate = '2011-03-14'
     * $query->filterByQuantificationdate(array('max' => 'yesterday')); // WHERE quantificationdate > '2011-03-13'
     * </code>
     *
     * @param     mixed $quantificationdate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function filterByQuantificationdate($quantificationdate = null, $comparison = null)
    {
        if (is_array($quantificationdate)) {
            $useMinMax = false;
            if (isset($quantificationdate['min'])) {
                $this->addUsingAlias(QuantificationPeer::QUANTIFICATIONDATE, $quantificationdate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationdate['max'])) {
                $this->addUsingAlias(QuantificationPeer::QUANTIFICATIONDATE, $quantificationdate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationPeer::QUANTIFICATIONDATE, $quantificationdate, $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
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

        return $this->addUsingAlias(QuantificationPeer::NAME, $name, $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
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

        return $this->addUsingAlias(QuantificationPeer::URI, $uri, $comparison);
    }

    /**
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisition($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(QuantificationPeer::ACQUISITION_ID, $acquisition->getAcquisitionId(), $comparison);
        } elseif ($acquisition instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationPeer::ACQUISITION_ID, $acquisition->toKeyValue('PrimaryKey', 'AcquisitionId'), $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
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
     * Filter the query by a related Analysis object
     *
     * @param   Analysis|PropelObjectCollection $analysis The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysis($analysis, $comparison = null)
    {
        if ($analysis instanceof Analysis) {
            return $this
                ->addUsingAlias(QuantificationPeer::ANALYSIS_ID, $analysis->getAnalysisId(), $comparison);
        } elseif ($analysis instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationPeer::ANALYSIS_ID, $analysis->toKeyValue('PrimaryKey', 'AnalysisId'), $comparison);
        } else {
            throw new PropelException('filterByAnalysis() only accepts arguments of type Analysis or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysis relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function joinAnalysis($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysis');

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
            $this->addJoinObject($join, 'Analysis');
        }

        return $this;
    }

    /**
     * Use the Analysis relation Analysis object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysis($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysis', '\cli_db\propel\AnalysisQuery');
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(QuantificationPeer::OPERATOR_ID, $contact->getContactId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationPeer::OPERATOR_ID, $contact->toKeyValue('PrimaryKey', 'ContactId'), $comparison);
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type Contact or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

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
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\cli_db\propel\ContactQuery');
    }

    /**
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(QuantificationPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
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
     * @return QuantificationQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Quantification $quantification Object to remove from the list of results
     *
     * @return QuantificationQuery The current query, for fluid interface
     */
    public function prune($quantification = null)
    {
        if ($quantification) {
            $this->addUsingAlias(QuantificationPeer::QUANTIFICATION_ID, $quantification->getQuantificationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
