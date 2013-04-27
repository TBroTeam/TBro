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
use cli_db\propel\Feature;
use cli_db\propel\Featureloc;
use cli_db\propel\FeaturelocPeer;
use cli_db\propel\FeaturelocPub;
use cli_db\propel\FeaturelocQuery;

/**
 * Base class that represents a query for the 'featureloc' table.
 *
 *
 *
 * @method FeaturelocQuery orderByFeaturelocId($order = Criteria::ASC) Order by the featureloc_id column
 * @method FeaturelocQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method FeaturelocQuery orderBySrcfeatureId($order = Criteria::ASC) Order by the srcfeature_id column
 * @method FeaturelocQuery orderByFmin($order = Criteria::ASC) Order by the fmin column
 * @method FeaturelocQuery orderByIsFminPartial($order = Criteria::ASC) Order by the is_fmin_partial column
 * @method FeaturelocQuery orderByFmax($order = Criteria::ASC) Order by the fmax column
 * @method FeaturelocQuery orderByIsFmaxPartial($order = Criteria::ASC) Order by the is_fmax_partial column
 * @method FeaturelocQuery orderByStrand($order = Criteria::ASC) Order by the strand column
 * @method FeaturelocQuery orderByPhase($order = Criteria::ASC) Order by the phase column
 * @method FeaturelocQuery orderByResidueInfo($order = Criteria::ASC) Order by the residue_info column
 * @method FeaturelocQuery orderByLocgroup($order = Criteria::ASC) Order by the locgroup column
 * @method FeaturelocQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method FeaturelocQuery groupByFeaturelocId() Group by the featureloc_id column
 * @method FeaturelocQuery groupByFeatureId() Group by the feature_id column
 * @method FeaturelocQuery groupBySrcfeatureId() Group by the srcfeature_id column
 * @method FeaturelocQuery groupByFmin() Group by the fmin column
 * @method FeaturelocQuery groupByIsFminPartial() Group by the is_fmin_partial column
 * @method FeaturelocQuery groupByFmax() Group by the fmax column
 * @method FeaturelocQuery groupByIsFmaxPartial() Group by the is_fmax_partial column
 * @method FeaturelocQuery groupByStrand() Group by the strand column
 * @method FeaturelocQuery groupByPhase() Group by the phase column
 * @method FeaturelocQuery groupByResidueInfo() Group by the residue_info column
 * @method FeaturelocQuery groupByLocgroup() Group by the locgroup column
 * @method FeaturelocQuery groupByRank() Group by the rank column
 *
 * @method FeaturelocQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeaturelocQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeaturelocQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeaturelocQuery leftJoinFeatureRelatedByFeatureId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelatedByFeatureId relation
 * @method FeaturelocQuery rightJoinFeatureRelatedByFeatureId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelatedByFeatureId relation
 * @method FeaturelocQuery innerJoinFeatureRelatedByFeatureId($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelatedByFeatureId relation
 *
 * @method FeaturelocQuery leftJoinFeatureRelatedBySrcfeatureId($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureRelatedBySrcfeatureId relation
 * @method FeaturelocQuery rightJoinFeatureRelatedBySrcfeatureId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureRelatedBySrcfeatureId relation
 * @method FeaturelocQuery innerJoinFeatureRelatedBySrcfeatureId($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureRelatedBySrcfeatureId relation
 *
 * @method FeaturelocQuery leftJoinFeaturelocPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeaturelocPub relation
 * @method FeaturelocQuery rightJoinFeaturelocPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeaturelocPub relation
 * @method FeaturelocQuery innerJoinFeaturelocPub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeaturelocPub relation
 *
 * @method Featureloc findOne(PropelPDO $con = null) Return the first Featureloc matching the query
 * @method Featureloc findOneOrCreate(PropelPDO $con = null) Return the first Featureloc matching the query, or a new Featureloc object populated from the query conditions when no match is found
 *
 * @method Featureloc findOneByFeatureId(int $feature_id) Return the first Featureloc filtered by the feature_id column
 * @method Featureloc findOneBySrcfeatureId(int $srcfeature_id) Return the first Featureloc filtered by the srcfeature_id column
 * @method Featureloc findOneByFmin(int $fmin) Return the first Featureloc filtered by the fmin column
 * @method Featureloc findOneByIsFminPartial(boolean $is_fmin_partial) Return the first Featureloc filtered by the is_fmin_partial column
 * @method Featureloc findOneByFmax(int $fmax) Return the first Featureloc filtered by the fmax column
 * @method Featureloc findOneByIsFmaxPartial(boolean $is_fmax_partial) Return the first Featureloc filtered by the is_fmax_partial column
 * @method Featureloc findOneByStrand(int $strand) Return the first Featureloc filtered by the strand column
 * @method Featureloc findOneByPhase(int $phase) Return the first Featureloc filtered by the phase column
 * @method Featureloc findOneByResidueInfo(string $residue_info) Return the first Featureloc filtered by the residue_info column
 * @method Featureloc findOneByLocgroup(int $locgroup) Return the first Featureloc filtered by the locgroup column
 * @method Featureloc findOneByRank(int $rank) Return the first Featureloc filtered by the rank column
 *
 * @method array findByFeaturelocId(int $featureloc_id) Return Featureloc objects filtered by the featureloc_id column
 * @method array findByFeatureId(int $feature_id) Return Featureloc objects filtered by the feature_id column
 * @method array findBySrcfeatureId(int $srcfeature_id) Return Featureloc objects filtered by the srcfeature_id column
 * @method array findByFmin(int $fmin) Return Featureloc objects filtered by the fmin column
 * @method array findByIsFminPartial(boolean $is_fmin_partial) Return Featureloc objects filtered by the is_fmin_partial column
 * @method array findByFmax(int $fmax) Return Featureloc objects filtered by the fmax column
 * @method array findByIsFmaxPartial(boolean $is_fmax_partial) Return Featureloc objects filtered by the is_fmax_partial column
 * @method array findByStrand(int $strand) Return Featureloc objects filtered by the strand column
 * @method array findByPhase(int $phase) Return Featureloc objects filtered by the phase column
 * @method array findByResidueInfo(string $residue_info) Return Featureloc objects filtered by the residue_info column
 * @method array findByLocgroup(int $locgroup) Return Featureloc objects filtered by the locgroup column
 * @method array findByRank(int $rank) Return Featureloc objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeaturelocQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeaturelocQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Featureloc', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeaturelocQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeaturelocQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeaturelocQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeaturelocQuery) {
            return $criteria;
        }
        $query = new FeaturelocQuery();
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
     * @return   Featureloc|Featureloc[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeaturelocPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeaturelocPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Featureloc A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeaturelocId($key, $con = null)
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
     * @return                 Featureloc A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "featureloc_id", "feature_id", "srcfeature_id", "fmin", "is_fmin_partial", "fmax", "is_fmax_partial", "strand", "phase", "residue_info", "locgroup", "rank" FROM "featureloc" WHERE "featureloc_id" = :p0';
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
            $obj = new Featureloc();
            $obj->hydrate($row);
            FeaturelocPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Featureloc|Featureloc[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Featureloc[]|mixed the list of results, formatted by the current formatter
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
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the featureloc_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeaturelocId(1234); // WHERE featureloc_id = 1234
     * $query->filterByFeaturelocId(array(12, 34)); // WHERE featureloc_id IN (12, 34)
     * $query->filterByFeaturelocId(array('min' => 12)); // WHERE featureloc_id >= 12
     * $query->filterByFeaturelocId(array('max' => 12)); // WHERE featureloc_id <= 12
     * </code>
     *
     * @param     mixed $featurelocId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByFeaturelocId($featurelocId = null, $comparison = null)
    {
        if (is_array($featurelocId)) {
            $useMinMax = false;
            if (isset($featurelocId['min'])) {
                $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $featurelocId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featurelocId['max'])) {
                $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $featurelocId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $featurelocId, $comparison);
    }

    /**
     * Filter the query on the feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureId(1234); // WHERE feature_id = 1234
     * $query->filterByFeatureId(array(12, 34)); // WHERE feature_id IN (12, 34)
     * $query->filterByFeatureId(array('min' => 12)); // WHERE feature_id >= 12
     * $query->filterByFeatureId(array('max' => 12)); // WHERE feature_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelatedByFeatureId()
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(FeaturelocPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(FeaturelocPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::FEATURE_ID, $featureId, $comparison);
    }

    /**
     * Filter the query on the srcfeature_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySrcfeatureId(1234); // WHERE srcfeature_id = 1234
     * $query->filterBySrcfeatureId(array(12, 34)); // WHERE srcfeature_id IN (12, 34)
     * $query->filterBySrcfeatureId(array('min' => 12)); // WHERE srcfeature_id >= 12
     * $query->filterBySrcfeatureId(array('max' => 12)); // WHERE srcfeature_id <= 12
     * </code>
     *
     * @see       filterByFeatureRelatedBySrcfeatureId()
     *
     * @param     mixed $srcfeatureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterBySrcfeatureId($srcfeatureId = null, $comparison = null)
    {
        if (is_array($srcfeatureId)) {
            $useMinMax = false;
            if (isset($srcfeatureId['min'])) {
                $this->addUsingAlias(FeaturelocPeer::SRCFEATURE_ID, $srcfeatureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($srcfeatureId['max'])) {
                $this->addUsingAlias(FeaturelocPeer::SRCFEATURE_ID, $srcfeatureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::SRCFEATURE_ID, $srcfeatureId, $comparison);
    }

    /**
     * Filter the query on the fmin column
     *
     * Example usage:
     * <code>
     * $query->filterByFmin(1234); // WHERE fmin = 1234
     * $query->filterByFmin(array(12, 34)); // WHERE fmin IN (12, 34)
     * $query->filterByFmin(array('min' => 12)); // WHERE fmin >= 12
     * $query->filterByFmin(array('max' => 12)); // WHERE fmin <= 12
     * </code>
     *
     * @param     mixed $fmin The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByFmin($fmin = null, $comparison = null)
    {
        if (is_array($fmin)) {
            $useMinMax = false;
            if (isset($fmin['min'])) {
                $this->addUsingAlias(FeaturelocPeer::FMIN, $fmin['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fmin['max'])) {
                $this->addUsingAlias(FeaturelocPeer::FMIN, $fmin['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::FMIN, $fmin, $comparison);
    }

    /**
     * Filter the query on the is_fmin_partial column
     *
     * Example usage:
     * <code>
     * $query->filterByIsFminPartial(true); // WHERE is_fmin_partial = true
     * $query->filterByIsFminPartial('yes'); // WHERE is_fmin_partial = true
     * </code>
     *
     * @param     boolean|string $isFminPartial The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByIsFminPartial($isFminPartial = null, $comparison = null)
    {
        if (is_string($isFminPartial)) {
            $isFminPartial = in_array(strtolower($isFminPartial), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeaturelocPeer::IS_FMIN_PARTIAL, $isFminPartial, $comparison);
    }

    /**
     * Filter the query on the fmax column
     *
     * Example usage:
     * <code>
     * $query->filterByFmax(1234); // WHERE fmax = 1234
     * $query->filterByFmax(array(12, 34)); // WHERE fmax IN (12, 34)
     * $query->filterByFmax(array('min' => 12)); // WHERE fmax >= 12
     * $query->filterByFmax(array('max' => 12)); // WHERE fmax <= 12
     * </code>
     *
     * @param     mixed $fmax The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByFmax($fmax = null, $comparison = null)
    {
        if (is_array($fmax)) {
            $useMinMax = false;
            if (isset($fmax['min'])) {
                $this->addUsingAlias(FeaturelocPeer::FMAX, $fmax['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($fmax['max'])) {
                $this->addUsingAlias(FeaturelocPeer::FMAX, $fmax['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::FMAX, $fmax, $comparison);
    }

    /**
     * Filter the query on the is_fmax_partial column
     *
     * Example usage:
     * <code>
     * $query->filterByIsFmaxPartial(true); // WHERE is_fmax_partial = true
     * $query->filterByIsFmaxPartial('yes'); // WHERE is_fmax_partial = true
     * </code>
     *
     * @param     boolean|string $isFmaxPartial The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByIsFmaxPartial($isFmaxPartial = null, $comparison = null)
    {
        if (is_string($isFmaxPartial)) {
            $isFmaxPartial = in_array(strtolower($isFmaxPartial), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeaturelocPeer::IS_FMAX_PARTIAL, $isFmaxPartial, $comparison);
    }

    /**
     * Filter the query on the strand column
     *
     * Example usage:
     * <code>
     * $query->filterByStrand(1234); // WHERE strand = 1234
     * $query->filterByStrand(array(12, 34)); // WHERE strand IN (12, 34)
     * $query->filterByStrand(array('min' => 12)); // WHERE strand >= 12
     * $query->filterByStrand(array('max' => 12)); // WHERE strand <= 12
     * </code>
     *
     * @param     mixed $strand The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByStrand($strand = null, $comparison = null)
    {
        if (is_array($strand)) {
            $useMinMax = false;
            if (isset($strand['min'])) {
                $this->addUsingAlias(FeaturelocPeer::STRAND, $strand['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($strand['max'])) {
                $this->addUsingAlias(FeaturelocPeer::STRAND, $strand['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::STRAND, $strand, $comparison);
    }

    /**
     * Filter the query on the phase column
     *
     * Example usage:
     * <code>
     * $query->filterByPhase(1234); // WHERE phase = 1234
     * $query->filterByPhase(array(12, 34)); // WHERE phase IN (12, 34)
     * $query->filterByPhase(array('min' => 12)); // WHERE phase >= 12
     * $query->filterByPhase(array('max' => 12)); // WHERE phase <= 12
     * </code>
     *
     * @param     mixed $phase The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByPhase($phase = null, $comparison = null)
    {
        if (is_array($phase)) {
            $useMinMax = false;
            if (isset($phase['min'])) {
                $this->addUsingAlias(FeaturelocPeer::PHASE, $phase['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($phase['max'])) {
                $this->addUsingAlias(FeaturelocPeer::PHASE, $phase['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::PHASE, $phase, $comparison);
    }

    /**
     * Filter the query on the residue_info column
     *
     * Example usage:
     * <code>
     * $query->filterByResidueInfo('fooValue');   // WHERE residue_info = 'fooValue'
     * $query->filterByResidueInfo('%fooValue%'); // WHERE residue_info LIKE '%fooValue%'
     * </code>
     *
     * @param     string $residueInfo The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByResidueInfo($residueInfo = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($residueInfo)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $residueInfo)) {
                $residueInfo = str_replace('*', '%', $residueInfo);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::RESIDUE_INFO, $residueInfo, $comparison);
    }

    /**
     * Filter the query on the locgroup column
     *
     * Example usage:
     * <code>
     * $query->filterByLocgroup(1234); // WHERE locgroup = 1234
     * $query->filterByLocgroup(array(12, 34)); // WHERE locgroup IN (12, 34)
     * $query->filterByLocgroup(array('min' => 12)); // WHERE locgroup >= 12
     * $query->filterByLocgroup(array('max' => 12)); // WHERE locgroup <= 12
     * </code>
     *
     * @param     mixed $locgroup The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByLocgroup($locgroup = null, $comparison = null)
    {
        if (is_array($locgroup)) {
            $useMinMax = false;
            if (isset($locgroup['min'])) {
                $this->addUsingAlias(FeaturelocPeer::LOCGROUP, $locgroup['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($locgroup['max'])) {
                $this->addUsingAlias(FeaturelocPeer::LOCGROUP, $locgroup['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::LOCGROUP, $locgroup, $comparison);
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
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(FeaturelocPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(FeaturelocPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturelocPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturelocQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelatedByFeatureId($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeaturelocPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturelocPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelatedByFeatureId() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelatedByFeatureId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function joinFeatureRelatedByFeatureId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelatedByFeatureId');

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
            $this->addJoinObject($join, 'FeatureRelatedByFeatureId');
        }

        return $this;
    }

    /**
     * Use the FeatureRelatedByFeatureId relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelatedByFeatureIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureRelatedByFeatureId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelatedByFeatureId', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturelocQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureRelatedBySrcfeatureId($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(FeaturelocPeer::SRCFEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturelocPeer::SRCFEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureRelatedBySrcfeatureId() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureRelatedBySrcfeatureId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function joinFeatureRelatedBySrcfeatureId($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureRelatedBySrcfeatureId');

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
            $this->addJoinObject($join, 'FeatureRelatedBySrcfeatureId');
        }

        return $this;
    }

    /**
     * Use the FeatureRelatedBySrcfeatureId relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureRelatedBySrcfeatureIdQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFeatureRelatedBySrcfeatureId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureRelatedBySrcfeatureId', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related FeaturelocPub object
     *
     * @param   FeaturelocPub|PropelObjectCollection $featurelocPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeaturelocQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeaturelocPub($featurelocPub, $comparison = null)
    {
        if ($featurelocPub instanceof FeaturelocPub) {
            return $this
                ->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $featurelocPub->getFeaturelocId(), $comparison);
        } elseif ($featurelocPub instanceof PropelObjectCollection) {
            return $this
                ->useFeaturelocPubQuery()
                ->filterByPrimaryKeys($featurelocPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeaturelocPub() only accepts arguments of type FeaturelocPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeaturelocPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function joinFeaturelocPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeaturelocPub');

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
            $this->addJoinObject($join, 'FeaturelocPub');
        }

        return $this;
    }

    /**
     * Use the FeaturelocPub relation FeaturelocPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturelocPubQuery A secondary query class using the current class as primary query
     */
    public function useFeaturelocPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeaturelocPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeaturelocPub', '\cli_db\propel\FeaturelocPubQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Featureloc $featureloc Object to remove from the list of results
     *
     * @return FeaturelocQuery The current query, for fluid interface
     */
    public function prune($featureloc = null)
    {
        if ($featureloc) {
            $this->addUsingAlias(FeaturelocPeer::FEATURELOC_ID, $featureloc->getFeaturelocId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
