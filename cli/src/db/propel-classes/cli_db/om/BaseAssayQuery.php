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
use cli_db\propel\Assay;
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\AssayPeer;
use cli_db\propel\AssayQuery;
use cli_db\propel\Contact;
use cli_db\propel\Protocol;

/**
 * Base class that represents a query for the 'assay' table.
 *
 *
 *
 * @method AssayQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 * @method AssayQuery orderByArraydesignId($order = Criteria::ASC) Order by the arraydesign_id column
 * @method AssayQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method AssayQuery orderByAssaydate($order = Criteria::ASC) Order by the assaydate column
 * @method AssayQuery orderByArrayidentifier($order = Criteria::ASC) Order by the arrayidentifier column
 * @method AssayQuery orderByArraybatchidentifier($order = Criteria::ASC) Order by the arraybatchidentifier column
 * @method AssayQuery orderByOperatorId($order = Criteria::ASC) Order by the operator_id column
 * @method AssayQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method AssayQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AssayQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method AssayQuery groupByAssayId() Group by the assay_id column
 * @method AssayQuery groupByArraydesignId() Group by the arraydesign_id column
 * @method AssayQuery groupByProtocolId() Group by the protocol_id column
 * @method AssayQuery groupByAssaydate() Group by the assaydate column
 * @method AssayQuery groupByArrayidentifier() Group by the arrayidentifier column
 * @method AssayQuery groupByArraybatchidentifier() Group by the arraybatchidentifier column
 * @method AssayQuery groupByOperatorId() Group by the operator_id column
 * @method AssayQuery groupByDbxrefId() Group by the dbxref_id column
 * @method AssayQuery groupByName() Group by the name column
 * @method AssayQuery groupByDescription() Group by the description column
 *
 * @method AssayQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AssayQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AssayQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AssayQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method AssayQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method AssayQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method AssayQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method AssayQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method AssayQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method AssayQuery leftJoinAcquisition($relationAlias = null) Adds a LEFT JOIN clause to the query using the Acquisition relation
 * @method AssayQuery rightJoinAcquisition($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Acquisition relation
 * @method AssayQuery innerJoinAcquisition($relationAlias = null) Adds a INNER JOIN clause to the query using the Acquisition relation
 *
 * @method AssayQuery leftJoinAssayBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssayBiomaterial relation
 * @method AssayQuery rightJoinAssayBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssayBiomaterial relation
 * @method AssayQuery innerJoinAssayBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the AssayBiomaterial relation
 *
 * @method Assay findOne(PropelPDO $con = null) Return the first Assay matching the query
 * @method Assay findOneOrCreate(PropelPDO $con = null) Return the first Assay matching the query, or a new Assay object populated from the query conditions when no match is found
 *
 * @method Assay findOneByArraydesignId(int $arraydesign_id) Return the first Assay filtered by the arraydesign_id column
 * @method Assay findOneByProtocolId(int $protocol_id) Return the first Assay filtered by the protocol_id column
 * @method Assay findOneByAssaydate(string $assaydate) Return the first Assay filtered by the assaydate column
 * @method Assay findOneByArrayidentifier(string $arrayidentifier) Return the first Assay filtered by the arrayidentifier column
 * @method Assay findOneByArraybatchidentifier(string $arraybatchidentifier) Return the first Assay filtered by the arraybatchidentifier column
 * @method Assay findOneByOperatorId(int $operator_id) Return the first Assay filtered by the operator_id column
 * @method Assay findOneByDbxrefId(int $dbxref_id) Return the first Assay filtered by the dbxref_id column
 * @method Assay findOneByName(string $name) Return the first Assay filtered by the name column
 * @method Assay findOneByDescription(string $description) Return the first Assay filtered by the description column
 *
 * @method array findByAssayId(int $assay_id) Return Assay objects filtered by the assay_id column
 * @method array findByArraydesignId(int $arraydesign_id) Return Assay objects filtered by the arraydesign_id column
 * @method array findByProtocolId(int $protocol_id) Return Assay objects filtered by the protocol_id column
 * @method array findByAssaydate(string $assaydate) Return Assay objects filtered by the assaydate column
 * @method array findByArrayidentifier(string $arrayidentifier) Return Assay objects filtered by the arrayidentifier column
 * @method array findByArraybatchidentifier(string $arraybatchidentifier) Return Assay objects filtered by the arraybatchidentifier column
 * @method array findByOperatorId(int $operator_id) Return Assay objects filtered by the operator_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Assay objects filtered by the dbxref_id column
 * @method array findByName(string $name) Return Assay objects filtered by the name column
 * @method array findByDescription(string $description) Return Assay objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAssayQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAssayQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Assay', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AssayQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AssayQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AssayQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AssayQuery) {
            return $criteria;
        }
        $query = new AssayQuery();
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
     * @return   Assay|Assay[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AssayPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AssayPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Assay A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAssayId($key, $con = null)
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
     * @return                 Assay A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "assay_id", "arraydesign_id", "protocol_id", "assaydate", "arrayidentifier", "arraybatchidentifier", "operator_id", "dbxref_id", "name", "description" FROM "assay" WHERE "assay_id" = :p0';
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
            $obj = new Assay();
            $obj->hydrate($row);
            AssayPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Assay|Assay[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Assay[]|mixed the list of results, formatted by the current formatter
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
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AssayPeer::ASSAY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AssayPeer::ASSAY_ID, $keys, Criteria::IN);
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
     * @param     mixed $assayId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(AssayPeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(AssayPeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::ASSAY_ID, $assayId, $comparison);
    }

    /**
     * Filter the query on the arraydesign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByArraydesignId(1234); // WHERE arraydesign_id = 1234
     * $query->filterByArraydesignId(array(12, 34)); // WHERE arraydesign_id IN (12, 34)
     * $query->filterByArraydesignId(array('min' => 12)); // WHERE arraydesign_id >= 12
     * $query->filterByArraydesignId(array('max' => 12)); // WHERE arraydesign_id <= 12
     * </code>
     *
     * @param     mixed $arraydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByArraydesignId($arraydesignId = null, $comparison = null)
    {
        if (is_array($arraydesignId)) {
            $useMinMax = false;
            if (isset($arraydesignId['min'])) {
                $this->addUsingAlias(AssayPeer::ARRAYDESIGN_ID, $arraydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arraydesignId['max'])) {
                $this->addUsingAlias(AssayPeer::ARRAYDESIGN_ID, $arraydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::ARRAYDESIGN_ID, $arraydesignId, $comparison);
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
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(AssayPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(AssayPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::PROTOCOL_ID, $protocolId, $comparison);
    }

    /**
     * Filter the query on the assaydate column
     *
     * Example usage:
     * <code>
     * $query->filterByAssaydate('2011-03-14'); // WHERE assaydate = '2011-03-14'
     * $query->filterByAssaydate('now'); // WHERE assaydate = '2011-03-14'
     * $query->filterByAssaydate(array('max' => 'yesterday')); // WHERE assaydate > '2011-03-13'
     * </code>
     *
     * @param     mixed $assaydate The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByAssaydate($assaydate = null, $comparison = null)
    {
        if (is_array($assaydate)) {
            $useMinMax = false;
            if (isset($assaydate['min'])) {
                $this->addUsingAlias(AssayPeer::ASSAYDATE, $assaydate['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assaydate['max'])) {
                $this->addUsingAlias(AssayPeer::ASSAYDATE, $assaydate['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::ASSAYDATE, $assaydate, $comparison);
    }

    /**
     * Filter the query on the arrayidentifier column
     *
     * Example usage:
     * <code>
     * $query->filterByArrayidentifier('fooValue');   // WHERE arrayidentifier = 'fooValue'
     * $query->filterByArrayidentifier('%fooValue%'); // WHERE arrayidentifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $arrayidentifier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByArrayidentifier($arrayidentifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($arrayidentifier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $arrayidentifier)) {
                $arrayidentifier = str_replace('*', '%', $arrayidentifier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AssayPeer::ARRAYIDENTIFIER, $arrayidentifier, $comparison);
    }

    /**
     * Filter the query on the arraybatchidentifier column
     *
     * Example usage:
     * <code>
     * $query->filterByArraybatchidentifier('fooValue');   // WHERE arraybatchidentifier = 'fooValue'
     * $query->filterByArraybatchidentifier('%fooValue%'); // WHERE arraybatchidentifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $arraybatchidentifier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByArraybatchidentifier($arraybatchidentifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($arraybatchidentifier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $arraybatchidentifier)) {
                $arraybatchidentifier = str_replace('*', '%', $arraybatchidentifier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AssayPeer::ARRAYBATCHIDENTIFIER, $arraybatchidentifier, $comparison);
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
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByOperatorId($operatorId = null, $comparison = null)
    {
        if (is_array($operatorId)) {
            $useMinMax = false;
            if (isset($operatorId['min'])) {
                $this->addUsingAlias(AssayPeer::OPERATOR_ID, $operatorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($operatorId['max'])) {
                $this->addUsingAlias(AssayPeer::OPERATOR_ID, $operatorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::OPERATOR_ID, $operatorId, $comparison);
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
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(AssayPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(AssayPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AssayPeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @return AssayQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AssayPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AssayPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(AssayPeer::OPERATOR_ID, $contact->getContactId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssayPeer::OPERATOR_ID, $contact->toKeyValue('PrimaryKey', 'ContactId'), $comparison);
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
     * @return AssayQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useContactQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
     * @return                 AssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(AssayPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(AssayPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
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
     * @return AssayQuery The current query, for fluid interface
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
     * Filter the query by a related Acquisition object
     *
     * @param   Acquisition|PropelObjectCollection $acquisition  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAcquisition($acquisition, $comparison = null)
    {
        if ($acquisition instanceof Acquisition) {
            return $this
                ->addUsingAlias(AssayPeer::ASSAY_ID, $acquisition->getAssayId(), $comparison);
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
     * @return AssayQuery The current query, for fluid interface
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
     * Filter the query by a related AssayBiomaterial object
     *
     * @param   AssayBiomaterial|PropelObjectCollection $assayBiomaterial  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssayBiomaterial($assayBiomaterial, $comparison = null)
    {
        if ($assayBiomaterial instanceof AssayBiomaterial) {
            return $this
                ->addUsingAlias(AssayPeer::ASSAY_ID, $assayBiomaterial->getAssayId(), $comparison);
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
     * @return AssayQuery The current query, for fluid interface
     */
    public function joinAssayBiomaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useAssayBiomaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssayBiomaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssayBiomaterial', '\cli_db\propel\AssayBiomaterialQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Assay $assay Object to remove from the list of results
     *
     * @return AssayQuery The current query, for fluid interface
     */
    public function prune($assay = null)
    {
        if ($assay) {
            $this->addUsingAlias(AssayPeer::ASSAY_ID, $assay->getAssayId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
