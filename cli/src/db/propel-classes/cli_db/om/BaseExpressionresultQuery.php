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
use cli_db\propel\Analysis;
use cli_db\propel\Expressionresult;
use cli_db\propel\ExpressionresultPeer;
use cli_db\propel\ExpressionresultQuantificationresult;
use cli_db\propel\ExpressionresultQuery;

/**
 * Base class that represents a query for the 'expressionresult' table.
 *
 *
 *
 * @method ExpressionresultQuery orderByExpressionresultId($order = Criteria::ASC) Order by the expressionresult_id column
 * @method ExpressionresultQuery orderByAnalysisId($order = Criteria::ASC) Order by the analysis_id column
 * @method ExpressionresultQuery orderByBasemean($order = Criteria::ASC) Order by the baseMean column
 * @method ExpressionresultQuery orderByBasemeana($order = Criteria::ASC) Order by the baseMeanA column
 * @method ExpressionresultQuery orderByBasemeanb($order = Criteria::ASC) Order by the baseMeanB column
 * @method ExpressionresultQuery orderByFoldchange($order = Criteria::ASC) Order by the foldChange column
 * @method ExpressionresultQuery orderByLog2foldchange($order = Criteria::ASC) Order by the log2foldChange column
 * @method ExpressionresultQuery orderByPval($order = Criteria::ASC) Order by the pval column
 * @method ExpressionresultQuery orderByPvaladj($order = Criteria::ASC) Order by the pvaladj column
 *
 * @method ExpressionresultQuery groupByExpressionresultId() Group by the expressionresult_id column
 * @method ExpressionresultQuery groupByAnalysisId() Group by the analysis_id column
 * @method ExpressionresultQuery groupByBasemean() Group by the baseMean column
 * @method ExpressionresultQuery groupByBasemeana() Group by the baseMeanA column
 * @method ExpressionresultQuery groupByBasemeanb() Group by the baseMeanB column
 * @method ExpressionresultQuery groupByFoldchange() Group by the foldChange column
 * @method ExpressionresultQuery groupByLog2foldchange() Group by the log2foldChange column
 * @method ExpressionresultQuery groupByPval() Group by the pval column
 * @method ExpressionresultQuery groupByPvaladj() Group by the pvaladj column
 *
 * @method ExpressionresultQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ExpressionresultQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ExpressionresultQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ExpressionresultQuery leftJoinAnalysis($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysis relation
 * @method ExpressionresultQuery rightJoinAnalysis($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysis relation
 * @method ExpressionresultQuery innerJoinAnalysis($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysis relation
 *
 * @method ExpressionresultQuery leftJoinExpressionresultQuantificationresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExpressionresultQuantificationresult relation
 * @method ExpressionresultQuery rightJoinExpressionresultQuantificationresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExpressionresultQuantificationresult relation
 * @method ExpressionresultQuery innerJoinExpressionresultQuantificationresult($relationAlias = null) Adds a INNER JOIN clause to the query using the ExpressionresultQuantificationresult relation
 *
 * @method Expressionresult findOne(PropelPDO $con = null) Return the first Expressionresult matching the query
 * @method Expressionresult findOneOrCreate(PropelPDO $con = null) Return the first Expressionresult matching the query, or a new Expressionresult object populated from the query conditions when no match is found
 *
 * @method Expressionresult findOneByAnalysisId(int $analysis_id) Return the first Expressionresult filtered by the analysis_id column
 * @method Expressionresult findOneByBasemean(double $baseMean) Return the first Expressionresult filtered by the baseMean column
 * @method Expressionresult findOneByBasemeana(double $baseMeanA) Return the first Expressionresult filtered by the baseMeanA column
 * @method Expressionresult findOneByBasemeanb(double $baseMeanB) Return the first Expressionresult filtered by the baseMeanB column
 * @method Expressionresult findOneByFoldchange(double $foldChange) Return the first Expressionresult filtered by the foldChange column
 * @method Expressionresult findOneByLog2foldchange(double $log2foldChange) Return the first Expressionresult filtered by the log2foldChange column
 * @method Expressionresult findOneByPval(double $pval) Return the first Expressionresult filtered by the pval column
 * @method Expressionresult findOneByPvaladj(double $pvaladj) Return the first Expressionresult filtered by the pvaladj column
 *
 * @method array findByExpressionresultId(int $expressionresult_id) Return Expressionresult objects filtered by the expressionresult_id column
 * @method array findByAnalysisId(int $analysis_id) Return Expressionresult objects filtered by the analysis_id column
 * @method array findByBasemean(double $baseMean) Return Expressionresult objects filtered by the baseMean column
 * @method array findByBasemeana(double $baseMeanA) Return Expressionresult objects filtered by the baseMeanA column
 * @method array findByBasemeanb(double $baseMeanB) Return Expressionresult objects filtered by the baseMeanB column
 * @method array findByFoldchange(double $foldChange) Return Expressionresult objects filtered by the foldChange column
 * @method array findByLog2foldchange(double $log2foldChange) Return Expressionresult objects filtered by the log2foldChange column
 * @method array findByPval(double $pval) Return Expressionresult objects filtered by the pval column
 * @method array findByPvaladj(double $pvaladj) Return Expressionresult objects filtered by the pvaladj column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseExpressionresultQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseExpressionresultQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Expressionresult', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ExpressionresultQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ExpressionresultQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ExpressionresultQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ExpressionresultQuery) {
            return $criteria;
        }
        $query = new ExpressionresultQuery();
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
     * @return   Expressionresult|Expressionresult[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ExpressionresultPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ExpressionresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Expressionresult A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByExpressionresultId($key, $con = null)
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
     * @return                 Expressionresult A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "expressionresult_id", "analysis_id", "baseMean", "baseMeanA", "baseMeanB", "foldChange", "log2foldChange", "pval", "pvaladj" FROM "expressionresult" WHERE "expressionresult_id" = :p0';
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
            $obj = new Expressionresult();
            $obj->hydrate($row);
            ExpressionresultPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Expressionresult|Expressionresult[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Expressionresult[]|mixed the list of results, formatted by the current formatter
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
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the expressionresult_id column
     *
     * Example usage:
     * <code>
     * $query->filterByExpressionresultId(1234); // WHERE expressionresult_id = 1234
     * $query->filterByExpressionresultId(array(12, 34)); // WHERE expressionresult_id IN (12, 34)
     * $query->filterByExpressionresultId(array('min' => 12)); // WHERE expressionresult_id >= 12
     * $query->filterByExpressionresultId(array('max' => 12)); // WHERE expressionresult_id <= 12
     * </code>
     *
     * @param     mixed $expressionresultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByExpressionresultId($expressionresultId = null, $comparison = null)
    {
        if (is_array($expressionresultId)) {
            $useMinMax = false;
            if (isset($expressionresultId['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $expressionresultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($expressionresultId['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $expressionresultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $expressionresultId, $comparison);
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
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByAnalysisId($analysisId = null, $comparison = null)
    {
        if (is_array($analysisId)) {
            $useMinMax = false;
            if (isset($analysisId['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::ANALYSIS_ID, $analysisId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisId['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::ANALYSIS_ID, $analysisId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::ANALYSIS_ID, $analysisId, $comparison);
    }

    /**
     * Filter the query on the baseMean column
     *
     * Example usage:
     * <code>
     * $query->filterByBasemean(1234); // WHERE baseMean = 1234
     * $query->filterByBasemean(array(12, 34)); // WHERE baseMean IN (12, 34)
     * $query->filterByBasemean(array('min' => 12)); // WHERE baseMean >= 12
     * $query->filterByBasemean(array('max' => 12)); // WHERE baseMean <= 12
     * </code>
     *
     * @param     mixed $basemean The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByBasemean($basemean = null, $comparison = null)
    {
        if (is_array($basemean)) {
            $useMinMax = false;
            if (isset($basemean['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEAN, $basemean['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basemean['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEAN, $basemean['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::BASEMEAN, $basemean, $comparison);
    }

    /**
     * Filter the query on the baseMeanA column
     *
     * Example usage:
     * <code>
     * $query->filterByBasemeana(1234); // WHERE baseMeanA = 1234
     * $query->filterByBasemeana(array(12, 34)); // WHERE baseMeanA IN (12, 34)
     * $query->filterByBasemeana(array('min' => 12)); // WHERE baseMeanA >= 12
     * $query->filterByBasemeana(array('max' => 12)); // WHERE baseMeanA <= 12
     * </code>
     *
     * @param     mixed $basemeana The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByBasemeana($basemeana = null, $comparison = null)
    {
        if (is_array($basemeana)) {
            $useMinMax = false;
            if (isset($basemeana['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEANA, $basemeana['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basemeana['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEANA, $basemeana['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::BASEMEANA, $basemeana, $comparison);
    }

    /**
     * Filter the query on the baseMeanB column
     *
     * Example usage:
     * <code>
     * $query->filterByBasemeanb(1234); // WHERE baseMeanB = 1234
     * $query->filterByBasemeanb(array(12, 34)); // WHERE baseMeanB IN (12, 34)
     * $query->filterByBasemeanb(array('min' => 12)); // WHERE baseMeanB >= 12
     * $query->filterByBasemeanb(array('max' => 12)); // WHERE baseMeanB <= 12
     * </code>
     *
     * @param     mixed $basemeanb The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByBasemeanb($basemeanb = null, $comparison = null)
    {
        if (is_array($basemeanb)) {
            $useMinMax = false;
            if (isset($basemeanb['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEANB, $basemeanb['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($basemeanb['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::BASEMEANB, $basemeanb['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::BASEMEANB, $basemeanb, $comparison);
    }

    /**
     * Filter the query on the foldChange column
     *
     * Example usage:
     * <code>
     * $query->filterByFoldchange(1234); // WHERE foldChange = 1234
     * $query->filterByFoldchange(array(12, 34)); // WHERE foldChange IN (12, 34)
     * $query->filterByFoldchange(array('min' => 12)); // WHERE foldChange >= 12
     * $query->filterByFoldchange(array('max' => 12)); // WHERE foldChange <= 12
     * </code>
     *
     * @param     mixed $foldchange The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByFoldchange($foldchange = null, $comparison = null)
    {
        if (is_array($foldchange)) {
            $useMinMax = false;
            if (isset($foldchange['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::FOLDCHANGE, $foldchange['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($foldchange['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::FOLDCHANGE, $foldchange['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::FOLDCHANGE, $foldchange, $comparison);
    }

    /**
     * Filter the query on the log2foldChange column
     *
     * Example usage:
     * <code>
     * $query->filterByLog2foldchange(1234); // WHERE log2foldChange = 1234
     * $query->filterByLog2foldchange(array(12, 34)); // WHERE log2foldChange IN (12, 34)
     * $query->filterByLog2foldchange(array('min' => 12)); // WHERE log2foldChange >= 12
     * $query->filterByLog2foldchange(array('max' => 12)); // WHERE log2foldChange <= 12
     * </code>
     *
     * @param     mixed $log2foldchange The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByLog2foldchange($log2foldchange = null, $comparison = null)
    {
        if (is_array($log2foldchange)) {
            $useMinMax = false;
            if (isset($log2foldchange['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::LOG2FOLDCHANGE, $log2foldchange['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($log2foldchange['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::LOG2FOLDCHANGE, $log2foldchange['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::LOG2FOLDCHANGE, $log2foldchange, $comparison);
    }

    /**
     * Filter the query on the pval column
     *
     * Example usage:
     * <code>
     * $query->filterByPval(1234); // WHERE pval = 1234
     * $query->filterByPval(array(12, 34)); // WHERE pval IN (12, 34)
     * $query->filterByPval(array('min' => 12)); // WHERE pval >= 12
     * $query->filterByPval(array('max' => 12)); // WHERE pval <= 12
     * </code>
     *
     * @param     mixed $pval The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByPval($pval = null, $comparison = null)
    {
        if (is_array($pval)) {
            $useMinMax = false;
            if (isset($pval['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::PVAL, $pval['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pval['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::PVAL, $pval['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::PVAL, $pval, $comparison);
    }

    /**
     * Filter the query on the pvaladj column
     *
     * Example usage:
     * <code>
     * $query->filterByPvaladj(1234); // WHERE pvaladj = 1234
     * $query->filterByPvaladj(array(12, 34)); // WHERE pvaladj IN (12, 34)
     * $query->filterByPvaladj(array('min' => 12)); // WHERE pvaladj >= 12
     * $query->filterByPvaladj(array('max' => 12)); // WHERE pvaladj <= 12
     * </code>
     *
     * @param     mixed $pvaladj The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function filterByPvaladj($pvaladj = null, $comparison = null)
    {
        if (is_array($pvaladj)) {
            $useMinMax = false;
            if (isset($pvaladj['min'])) {
                $this->addUsingAlias(ExpressionresultPeer::PVALADJ, $pvaladj['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pvaladj['max'])) {
                $this->addUsingAlias(ExpressionresultPeer::PVALADJ, $pvaladj['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ExpressionresultPeer::PVALADJ, $pvaladj, $comparison);
    }

    /**
     * Filter the query by a related Analysis object
     *
     * @param   Analysis|PropelObjectCollection $analysis The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ExpressionresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysis($analysis, $comparison = null)
    {
        if ($analysis instanceof Analysis) {
            return $this
                ->addUsingAlias(ExpressionresultPeer::ANALYSIS_ID, $analysis->getAnalysisId(), $comparison);
        } elseif ($analysis instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ExpressionresultPeer::ANALYSIS_ID, $analysis->toKeyValue('PrimaryKey', 'AnalysisId'), $comparison);
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
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function joinAnalysis($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useAnalysisQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinAnalysis($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysis', '\cli_db\propel\AnalysisQuery');
    }

    /**
     * Filter the query by a related ExpressionresultQuantificationresult object
     *
     * @param   ExpressionresultQuantificationresult|PropelObjectCollection $expressionresultQuantificationresult  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ExpressionresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExpressionresultQuantificationresult($expressionresultQuantificationresult, $comparison = null)
    {
        if ($expressionresultQuantificationresult instanceof ExpressionresultQuantificationresult) {
            return $this
                ->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $expressionresultQuantificationresult->getExpressionresultId(), $comparison);
        } elseif ($expressionresultQuantificationresult instanceof PropelObjectCollection) {
            return $this
                ->useExpressionresultQuantificationresultQuery()
                ->filterByPrimaryKeys($expressionresultQuantificationresult->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExpressionresultQuantificationresult() only accepts arguments of type ExpressionresultQuantificationresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ExpressionresultQuantificationresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function joinExpressionresultQuantificationresult($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ExpressionresultQuantificationresult');

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
            $this->addJoinObject($join, 'ExpressionresultQuantificationresult');
        }

        return $this;
    }

    /**
     * Use the ExpressionresultQuantificationresult relation ExpressionresultQuantificationresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ExpressionresultQuantificationresultQuery A secondary query class using the current class as primary query
     */
    public function useExpressionresultQuantificationresultQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExpressionresultQuantificationresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ExpressionresultQuantificationresult', '\cli_db\propel\ExpressionresultQuantificationresultQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Expressionresult $expressionresult Object to remove from the list of results
     *
     * @return ExpressionresultQuery The current query, for fluid interface
     */
    public function prune($expressionresult = null)
    {
        if ($expressionresult) {
            $this->addUsingAlias(ExpressionresultPeer::EXPRESSIONRESULT_ID, $expressionresult->getExpressionresultId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
