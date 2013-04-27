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
use cli_db\propel\Arraydesign;
use cli_db\propel\ArraydesignPeer;
use cli_db\propel\ArraydesignQuery;
use cli_db\propel\Arraydesignprop;
use cli_db\propel\Assay;
use cli_db\propel\Contact;
use cli_db\propel\Cvterm;
use cli_db\propel\Dbxref;
use cli_db\propel\Element;
use cli_db\propel\Protocol;

/**
 * Base class that represents a query for the 'arraydesign' table.
 *
 *
 *
 * @method ArraydesignQuery orderByArraydesignId($order = Criteria::ASC) Order by the arraydesign_id column
 * @method ArraydesignQuery orderByManufacturerId($order = Criteria::ASC) Order by the manufacturer_id column
 * @method ArraydesignQuery orderByPlatformtypeId($order = Criteria::ASC) Order by the platformtype_id column
 * @method ArraydesignQuery orderBySubstratetypeId($order = Criteria::ASC) Order by the substratetype_id column
 * @method ArraydesignQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method ArraydesignQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method ArraydesignQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ArraydesignQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method ArraydesignQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method ArraydesignQuery orderByArrayDimensions($order = Criteria::ASC) Order by the array_dimensions column
 * @method ArraydesignQuery orderByElementDimensions($order = Criteria::ASC) Order by the element_dimensions column
 * @method ArraydesignQuery orderByNumOfElements($order = Criteria::ASC) Order by the num_of_elements column
 * @method ArraydesignQuery orderByNumArrayColumns($order = Criteria::ASC) Order by the num_array_columns column
 * @method ArraydesignQuery orderByNumArrayRows($order = Criteria::ASC) Order by the num_array_rows column
 * @method ArraydesignQuery orderByNumGridColumns($order = Criteria::ASC) Order by the num_grid_columns column
 * @method ArraydesignQuery orderByNumGridRows($order = Criteria::ASC) Order by the num_grid_rows column
 * @method ArraydesignQuery orderByNumSubColumns($order = Criteria::ASC) Order by the num_sub_columns column
 * @method ArraydesignQuery orderByNumSubRows($order = Criteria::ASC) Order by the num_sub_rows column
 *
 * @method ArraydesignQuery groupByArraydesignId() Group by the arraydesign_id column
 * @method ArraydesignQuery groupByManufacturerId() Group by the manufacturer_id column
 * @method ArraydesignQuery groupByPlatformtypeId() Group by the platformtype_id column
 * @method ArraydesignQuery groupBySubstratetypeId() Group by the substratetype_id column
 * @method ArraydesignQuery groupByProtocolId() Group by the protocol_id column
 * @method ArraydesignQuery groupByDbxrefId() Group by the dbxref_id column
 * @method ArraydesignQuery groupByName() Group by the name column
 * @method ArraydesignQuery groupByVersion() Group by the version column
 * @method ArraydesignQuery groupByDescription() Group by the description column
 * @method ArraydesignQuery groupByArrayDimensions() Group by the array_dimensions column
 * @method ArraydesignQuery groupByElementDimensions() Group by the element_dimensions column
 * @method ArraydesignQuery groupByNumOfElements() Group by the num_of_elements column
 * @method ArraydesignQuery groupByNumArrayColumns() Group by the num_array_columns column
 * @method ArraydesignQuery groupByNumArrayRows() Group by the num_array_rows column
 * @method ArraydesignQuery groupByNumGridColumns() Group by the num_grid_columns column
 * @method ArraydesignQuery groupByNumGridRows() Group by the num_grid_rows column
 * @method ArraydesignQuery groupByNumSubColumns() Group by the num_sub_columns column
 * @method ArraydesignQuery groupByNumSubRows() Group by the num_sub_rows column
 *
 * @method ArraydesignQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ArraydesignQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ArraydesignQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ArraydesignQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method ArraydesignQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method ArraydesignQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method ArraydesignQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method ArraydesignQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method ArraydesignQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method ArraydesignQuery leftJoinCvtermRelatedByPlatformtypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedByPlatformtypeId relation
 * @method ArraydesignQuery rightJoinCvtermRelatedByPlatformtypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedByPlatformtypeId relation
 * @method ArraydesignQuery innerJoinCvtermRelatedByPlatformtypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedByPlatformtypeId relation
 *
 * @method ArraydesignQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method ArraydesignQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method ArraydesignQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method ArraydesignQuery leftJoinCvtermRelatedBySubstratetypeId($relationAlias = null) Adds a LEFT JOIN clause to the query using the CvtermRelatedBySubstratetypeId relation
 * @method ArraydesignQuery rightJoinCvtermRelatedBySubstratetypeId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the CvtermRelatedBySubstratetypeId relation
 * @method ArraydesignQuery innerJoinCvtermRelatedBySubstratetypeId($relationAlias = null) Adds a INNER JOIN clause to the query using the CvtermRelatedBySubstratetypeId relation
 *
 * @method ArraydesignQuery leftJoinArraydesignprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Arraydesignprop relation
 * @method ArraydesignQuery rightJoinArraydesignprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Arraydesignprop relation
 * @method ArraydesignQuery innerJoinArraydesignprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Arraydesignprop relation
 *
 * @method ArraydesignQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method ArraydesignQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method ArraydesignQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method ArraydesignQuery leftJoinElement($relationAlias = null) Adds a LEFT JOIN clause to the query using the Element relation
 * @method ArraydesignQuery rightJoinElement($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Element relation
 * @method ArraydesignQuery innerJoinElement($relationAlias = null) Adds a INNER JOIN clause to the query using the Element relation
 *
 * @method Arraydesign findOne(PropelPDO $con = null) Return the first Arraydesign matching the query
 * @method Arraydesign findOneOrCreate(PropelPDO $con = null) Return the first Arraydesign matching the query, or a new Arraydesign object populated from the query conditions when no match is found
 *
 * @method Arraydesign findOneByManufacturerId(int $manufacturer_id) Return the first Arraydesign filtered by the manufacturer_id column
 * @method Arraydesign findOneByPlatformtypeId(int $platformtype_id) Return the first Arraydesign filtered by the platformtype_id column
 * @method Arraydesign findOneBySubstratetypeId(int $substratetype_id) Return the first Arraydesign filtered by the substratetype_id column
 * @method Arraydesign findOneByProtocolId(int $protocol_id) Return the first Arraydesign filtered by the protocol_id column
 * @method Arraydesign findOneByDbxrefId(int $dbxref_id) Return the first Arraydesign filtered by the dbxref_id column
 * @method Arraydesign findOneByName(string $name) Return the first Arraydesign filtered by the name column
 * @method Arraydesign findOneByVersion(string $version) Return the first Arraydesign filtered by the version column
 * @method Arraydesign findOneByDescription(string $description) Return the first Arraydesign filtered by the description column
 * @method Arraydesign findOneByArrayDimensions(string $array_dimensions) Return the first Arraydesign filtered by the array_dimensions column
 * @method Arraydesign findOneByElementDimensions(string $element_dimensions) Return the first Arraydesign filtered by the element_dimensions column
 * @method Arraydesign findOneByNumOfElements(int $num_of_elements) Return the first Arraydesign filtered by the num_of_elements column
 * @method Arraydesign findOneByNumArrayColumns(int $num_array_columns) Return the first Arraydesign filtered by the num_array_columns column
 * @method Arraydesign findOneByNumArrayRows(int $num_array_rows) Return the first Arraydesign filtered by the num_array_rows column
 * @method Arraydesign findOneByNumGridColumns(int $num_grid_columns) Return the first Arraydesign filtered by the num_grid_columns column
 * @method Arraydesign findOneByNumGridRows(int $num_grid_rows) Return the first Arraydesign filtered by the num_grid_rows column
 * @method Arraydesign findOneByNumSubColumns(int $num_sub_columns) Return the first Arraydesign filtered by the num_sub_columns column
 * @method Arraydesign findOneByNumSubRows(int $num_sub_rows) Return the first Arraydesign filtered by the num_sub_rows column
 *
 * @method array findByArraydesignId(int $arraydesign_id) Return Arraydesign objects filtered by the arraydesign_id column
 * @method array findByManufacturerId(int $manufacturer_id) Return Arraydesign objects filtered by the manufacturer_id column
 * @method array findByPlatformtypeId(int $platformtype_id) Return Arraydesign objects filtered by the platformtype_id column
 * @method array findBySubstratetypeId(int $substratetype_id) Return Arraydesign objects filtered by the substratetype_id column
 * @method array findByProtocolId(int $protocol_id) Return Arraydesign objects filtered by the protocol_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Arraydesign objects filtered by the dbxref_id column
 * @method array findByName(string $name) Return Arraydesign objects filtered by the name column
 * @method array findByVersion(string $version) Return Arraydesign objects filtered by the version column
 * @method array findByDescription(string $description) Return Arraydesign objects filtered by the description column
 * @method array findByArrayDimensions(string $array_dimensions) Return Arraydesign objects filtered by the array_dimensions column
 * @method array findByElementDimensions(string $element_dimensions) Return Arraydesign objects filtered by the element_dimensions column
 * @method array findByNumOfElements(int $num_of_elements) Return Arraydesign objects filtered by the num_of_elements column
 * @method array findByNumArrayColumns(int $num_array_columns) Return Arraydesign objects filtered by the num_array_columns column
 * @method array findByNumArrayRows(int $num_array_rows) Return Arraydesign objects filtered by the num_array_rows column
 * @method array findByNumGridColumns(int $num_grid_columns) Return Arraydesign objects filtered by the num_grid_columns column
 * @method array findByNumGridRows(int $num_grid_rows) Return Arraydesign objects filtered by the num_grid_rows column
 * @method array findByNumSubColumns(int $num_sub_columns) Return Arraydesign objects filtered by the num_sub_columns column
 * @method array findByNumSubRows(int $num_sub_rows) Return Arraydesign objects filtered by the num_sub_rows column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseArraydesignQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseArraydesignQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Arraydesign', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ArraydesignQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ArraydesignQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ArraydesignQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ArraydesignQuery) {
            return $criteria;
        }
        $query = new ArraydesignQuery();
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
     * @return   Arraydesign|Arraydesign[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ArraydesignPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ArraydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Arraydesign A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByArraydesignId($key, $con = null)
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
     * @return                 Arraydesign A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "arraydesign_id", "manufacturer_id", "platformtype_id", "substratetype_id", "protocol_id", "dbxref_id", "name", "version", "description", "array_dimensions", "element_dimensions", "num_of_elements", "num_array_columns", "num_array_rows", "num_grid_columns", "num_grid_rows", "num_sub_columns", "num_sub_rows" FROM "arraydesign" WHERE "arraydesign_id" = :p0';
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
            $obj = new Arraydesign();
            $obj->hydrate($row);
            ArraydesignPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Arraydesign|Arraydesign[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Arraydesign[]|mixed the list of results, formatted by the current formatter
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
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $keys, Criteria::IN);
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
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByArraydesignId($arraydesignId = null, $comparison = null)
    {
        if (is_array($arraydesignId)) {
            $useMinMax = false;
            if (isset($arraydesignId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $arraydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($arraydesignId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $arraydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $arraydesignId, $comparison);
    }

    /**
     * Filter the query on the manufacturer_id column
     *
     * Example usage:
     * <code>
     * $query->filterByManufacturerId(1234); // WHERE manufacturer_id = 1234
     * $query->filterByManufacturerId(array(12, 34)); // WHERE manufacturer_id IN (12, 34)
     * $query->filterByManufacturerId(array('min' => 12)); // WHERE manufacturer_id >= 12
     * $query->filterByManufacturerId(array('max' => 12)); // WHERE manufacturer_id <= 12
     * </code>
     *
     * @see       filterByContact()
     *
     * @param     mixed $manufacturerId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByManufacturerId($manufacturerId = null, $comparison = null)
    {
        if (is_array($manufacturerId)) {
            $useMinMax = false;
            if (isset($manufacturerId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::MANUFACTURER_ID, $manufacturerId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($manufacturerId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::MANUFACTURER_ID, $manufacturerId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::MANUFACTURER_ID, $manufacturerId, $comparison);
    }

    /**
     * Filter the query on the platformtype_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPlatformtypeId(1234); // WHERE platformtype_id = 1234
     * $query->filterByPlatformtypeId(array(12, 34)); // WHERE platformtype_id IN (12, 34)
     * $query->filterByPlatformtypeId(array('min' => 12)); // WHERE platformtype_id >= 12
     * $query->filterByPlatformtypeId(array('max' => 12)); // WHERE platformtype_id <= 12
     * </code>
     *
     * @see       filterByCvtermRelatedByPlatformtypeId()
     *
     * @param     mixed $platformtypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByPlatformtypeId($platformtypeId = null, $comparison = null)
    {
        if (is_array($platformtypeId)) {
            $useMinMax = false;
            if (isset($platformtypeId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::PLATFORMTYPE_ID, $platformtypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($platformtypeId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::PLATFORMTYPE_ID, $platformtypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::PLATFORMTYPE_ID, $platformtypeId, $comparison);
    }

    /**
     * Filter the query on the substratetype_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubstratetypeId(1234); // WHERE substratetype_id = 1234
     * $query->filterBySubstratetypeId(array(12, 34)); // WHERE substratetype_id IN (12, 34)
     * $query->filterBySubstratetypeId(array('min' => 12)); // WHERE substratetype_id >= 12
     * $query->filterBySubstratetypeId(array('max' => 12)); // WHERE substratetype_id <= 12
     * </code>
     *
     * @see       filterByCvtermRelatedBySubstratetypeId()
     *
     * @param     mixed $substratetypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterBySubstratetypeId($substratetypeId = null, $comparison = null)
    {
        if (is_array($substratetypeId)) {
            $useMinMax = false;
            if (isset($substratetypeId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::SUBSTRATETYPE_ID, $substratetypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($substratetypeId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::SUBSTRATETYPE_ID, $substratetypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::SUBSTRATETYPE_ID, $substratetypeId, $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::PROTOCOL_ID, $protocolId, $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(ArraydesignPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(ArraydesignPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArraydesignPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue');   // WHERE version = 'fooValue'
     * $query->filterByVersion('%fooValue%'); // WHERE version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $version The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($version)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $version)) {
                $version = str_replace('*', '%', $version);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::VERSION, $version, $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ArraydesignPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the array_dimensions column
     *
     * Example usage:
     * <code>
     * $query->filterByArrayDimensions('fooValue');   // WHERE array_dimensions = 'fooValue'
     * $query->filterByArrayDimensions('%fooValue%'); // WHERE array_dimensions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $arrayDimensions The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByArrayDimensions($arrayDimensions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($arrayDimensions)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $arrayDimensions)) {
                $arrayDimensions = str_replace('*', '%', $arrayDimensions);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::ARRAY_DIMENSIONS, $arrayDimensions, $comparison);
    }

    /**
     * Filter the query on the element_dimensions column
     *
     * Example usage:
     * <code>
     * $query->filterByElementDimensions('fooValue');   // WHERE element_dimensions = 'fooValue'
     * $query->filterByElementDimensions('%fooValue%'); // WHERE element_dimensions LIKE '%fooValue%'
     * </code>
     *
     * @param     string $elementDimensions The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByElementDimensions($elementDimensions = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($elementDimensions)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $elementDimensions)) {
                $elementDimensions = str_replace('*', '%', $elementDimensions);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::ELEMENT_DIMENSIONS, $elementDimensions, $comparison);
    }

    /**
     * Filter the query on the num_of_elements column
     *
     * Example usage:
     * <code>
     * $query->filterByNumOfElements(1234); // WHERE num_of_elements = 1234
     * $query->filterByNumOfElements(array(12, 34)); // WHERE num_of_elements IN (12, 34)
     * $query->filterByNumOfElements(array('min' => 12)); // WHERE num_of_elements >= 12
     * $query->filterByNumOfElements(array('max' => 12)); // WHERE num_of_elements <= 12
     * </code>
     *
     * @param     mixed $numOfElements The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumOfElements($numOfElements = null, $comparison = null)
    {
        if (is_array($numOfElements)) {
            $useMinMax = false;
            if (isset($numOfElements['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_OF_ELEMENTS, $numOfElements['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numOfElements['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_OF_ELEMENTS, $numOfElements['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_OF_ELEMENTS, $numOfElements, $comparison);
    }

    /**
     * Filter the query on the num_array_columns column
     *
     * Example usage:
     * <code>
     * $query->filterByNumArrayColumns(1234); // WHERE num_array_columns = 1234
     * $query->filterByNumArrayColumns(array(12, 34)); // WHERE num_array_columns IN (12, 34)
     * $query->filterByNumArrayColumns(array('min' => 12)); // WHERE num_array_columns >= 12
     * $query->filterByNumArrayColumns(array('max' => 12)); // WHERE num_array_columns <= 12
     * </code>
     *
     * @param     mixed $numArrayColumns The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumArrayColumns($numArrayColumns = null, $comparison = null)
    {
        if (is_array($numArrayColumns)) {
            $useMinMax = false;
            if (isset($numArrayColumns['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_COLUMNS, $numArrayColumns['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numArrayColumns['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_COLUMNS, $numArrayColumns['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_COLUMNS, $numArrayColumns, $comparison);
    }

    /**
     * Filter the query on the num_array_rows column
     *
     * Example usage:
     * <code>
     * $query->filterByNumArrayRows(1234); // WHERE num_array_rows = 1234
     * $query->filterByNumArrayRows(array(12, 34)); // WHERE num_array_rows IN (12, 34)
     * $query->filterByNumArrayRows(array('min' => 12)); // WHERE num_array_rows >= 12
     * $query->filterByNumArrayRows(array('max' => 12)); // WHERE num_array_rows <= 12
     * </code>
     *
     * @param     mixed $numArrayRows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumArrayRows($numArrayRows = null, $comparison = null)
    {
        if (is_array($numArrayRows)) {
            $useMinMax = false;
            if (isset($numArrayRows['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_ROWS, $numArrayRows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numArrayRows['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_ROWS, $numArrayRows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_ARRAY_ROWS, $numArrayRows, $comparison);
    }

    /**
     * Filter the query on the num_grid_columns column
     *
     * Example usage:
     * <code>
     * $query->filterByNumGridColumns(1234); // WHERE num_grid_columns = 1234
     * $query->filterByNumGridColumns(array(12, 34)); // WHERE num_grid_columns IN (12, 34)
     * $query->filterByNumGridColumns(array('min' => 12)); // WHERE num_grid_columns >= 12
     * $query->filterByNumGridColumns(array('max' => 12)); // WHERE num_grid_columns <= 12
     * </code>
     *
     * @param     mixed $numGridColumns The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumGridColumns($numGridColumns = null, $comparison = null)
    {
        if (is_array($numGridColumns)) {
            $useMinMax = false;
            if (isset($numGridColumns['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_GRID_COLUMNS, $numGridColumns['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numGridColumns['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_GRID_COLUMNS, $numGridColumns['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_GRID_COLUMNS, $numGridColumns, $comparison);
    }

    /**
     * Filter the query on the num_grid_rows column
     *
     * Example usage:
     * <code>
     * $query->filterByNumGridRows(1234); // WHERE num_grid_rows = 1234
     * $query->filterByNumGridRows(array(12, 34)); // WHERE num_grid_rows IN (12, 34)
     * $query->filterByNumGridRows(array('min' => 12)); // WHERE num_grid_rows >= 12
     * $query->filterByNumGridRows(array('max' => 12)); // WHERE num_grid_rows <= 12
     * </code>
     *
     * @param     mixed $numGridRows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumGridRows($numGridRows = null, $comparison = null)
    {
        if (is_array($numGridRows)) {
            $useMinMax = false;
            if (isset($numGridRows['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_GRID_ROWS, $numGridRows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numGridRows['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_GRID_ROWS, $numGridRows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_GRID_ROWS, $numGridRows, $comparison);
    }

    /**
     * Filter the query on the num_sub_columns column
     *
     * Example usage:
     * <code>
     * $query->filterByNumSubColumns(1234); // WHERE num_sub_columns = 1234
     * $query->filterByNumSubColumns(array(12, 34)); // WHERE num_sub_columns IN (12, 34)
     * $query->filterByNumSubColumns(array('min' => 12)); // WHERE num_sub_columns >= 12
     * $query->filterByNumSubColumns(array('max' => 12)); // WHERE num_sub_columns <= 12
     * </code>
     *
     * @param     mixed $numSubColumns The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumSubColumns($numSubColumns = null, $comparison = null)
    {
        if (is_array($numSubColumns)) {
            $useMinMax = false;
            if (isset($numSubColumns['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_SUB_COLUMNS, $numSubColumns['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numSubColumns['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_SUB_COLUMNS, $numSubColumns['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_SUB_COLUMNS, $numSubColumns, $comparison);
    }

    /**
     * Filter the query on the num_sub_rows column
     *
     * Example usage:
     * <code>
     * $query->filterByNumSubRows(1234); // WHERE num_sub_rows = 1234
     * $query->filterByNumSubRows(array(12, 34)); // WHERE num_sub_rows IN (12, 34)
     * $query->filterByNumSubRows(array('min' => 12)); // WHERE num_sub_rows >= 12
     * $query->filterByNumSubRows(array('max' => 12)); // WHERE num_sub_rows <= 12
     * </code>
     *
     * @param     mixed $numSubRows The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function filterByNumSubRows($numSubRows = null, $comparison = null)
    {
        if (is_array($numSubRows)) {
            $useMinMax = false;
            if (isset($numSubRows['min'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_SUB_ROWS, $numSubRows['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($numSubRows['max'])) {
                $this->addUsingAlias(ArraydesignPeer::NUM_SUB_ROWS, $numSubRows['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ArraydesignPeer::NUM_SUB_ROWS, $numSubRows, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(ArraydesignPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(ArraydesignPeer::MANUFACTURER_ID, $contact->getContactId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignPeer::MANUFACTURER_ID, $contact->toKeyValue('PrimaryKey', 'ContactId'), $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedByPlatformtypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ArraydesignPeer::PLATFORMTYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignPeer::PLATFORMTYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedByPlatformtypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedByPlatformtypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedByPlatformtypeId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedByPlatformtypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedByPlatformtypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedByPlatformtypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedByPlatformtypeIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinCvtermRelatedByPlatformtypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedByPlatformtypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(ArraydesignPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvtermRelatedBySubstratetypeId($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ArraydesignPeer::SUBSTRATETYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ArraydesignPeer::SUBSTRATETYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
        } else {
            throw new PropelException('filterByCvtermRelatedBySubstratetypeId() only accepts arguments of type Cvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the CvtermRelatedBySubstratetypeId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function joinCvtermRelatedBySubstratetypeId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('CvtermRelatedBySubstratetypeId');

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
            $this->addJoinObject($join, 'CvtermRelatedBySubstratetypeId');
        }

        return $this;
    }

    /**
     * Use the CvtermRelatedBySubstratetypeId relation Cvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\CvtermQuery A secondary query class using the current class as primary query
     */
    public function useCvtermRelatedBySubstratetypeIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvtermRelatedBySubstratetypeId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'CvtermRelatedBySubstratetypeId', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Filter the query by a related Arraydesignprop object
     *
     * @param   Arraydesignprop|PropelObjectCollection $arraydesignprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByArraydesignprop($arraydesignprop, $comparison = null)
    {
        if ($arraydesignprop instanceof Arraydesignprop) {
            return $this
                ->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $arraydesignprop->getArraydesignId(), $comparison);
        } elseif ($arraydesignprop instanceof PropelObjectCollection) {
            return $this
                ->useArraydesignpropQuery()
                ->filterByPrimaryKeys($arraydesignprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByArraydesignprop() only accepts arguments of type Arraydesignprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Arraydesignprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function joinArraydesignprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Arraydesignprop');

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
            $this->addJoinObject($join, 'Arraydesignprop');
        }

        return $this;
    }

    /**
     * Use the Arraydesignprop relation Arraydesignprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ArraydesignpropQuery A secondary query class using the current class as primary query
     */
    public function useArraydesignpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinArraydesignprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Arraydesignprop', '\cli_db\propel\ArraydesignpropQuery');
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $assay->getArraydesignId(), $comparison);
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
     * @return ArraydesignQuery The current query, for fluid interface
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
     * Filter the query by a related Element object
     *
     * @param   Element|PropelObjectCollection $element  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ArraydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByElement($element, $comparison = null)
    {
        if ($element instanceof Element) {
            return $this
                ->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $element->getArraydesignId(), $comparison);
        } elseif ($element instanceof PropelObjectCollection) {
            return $this
                ->useElementQuery()
                ->filterByPrimaryKeys($element->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByElement() only accepts arguments of type Element or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Element relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function joinElement($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Element');

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
            $this->addJoinObject($join, 'Element');
        }

        return $this;
    }

    /**
     * Use the Element relation Element object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ElementQuery A secondary query class using the current class as primary query
     */
    public function useElementQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinElement($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Element', '\cli_db\propel\ElementQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Arraydesign $arraydesign Object to remove from the list of results
     *
     * @return ArraydesignQuery The current query, for fluid interface
     */
    public function prune($arraydesign = null)
    {
        if ($arraydesign) {
            $this->addUsingAlias(ArraydesignPeer::ARRAYDESIGN_ID, $arraydesign->getArraydesignId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
