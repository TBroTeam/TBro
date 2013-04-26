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
use cli_db\propel\Biomaterial;
use cli_db\propel\Cvterm;
use cli_db\propel\ExpressionresultQuantificationresult;
use cli_db\propel\Feature;
use cli_db\propel\Quantification;
use cli_db\propel\Quantificationresult;
use cli_db\propel\QuantificationresultPeer;
use cli_db\propel\QuantificationresultQuery;

/**
 * Base class that represents a query for the 'quantificationresult' table.
 *
 *
 *
 * @method QuantificationresultQuery orderByQuantificationresultId($order = Criteria::ASC) Order by the quantificationresult_id column
 * @method QuantificationresultQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method QuantificationresultQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method QuantificationresultQuery orderByQuantificationId($order = Criteria::ASC) Order by the quantification_id column
 * @method QuantificationresultQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method QuantificationresultQuery orderByValue($order = Criteria::ASC) Order by the value column
 *
 * @method QuantificationresultQuery groupByQuantificationresultId() Group by the quantificationresult_id column
 * @method QuantificationresultQuery groupByFeatureId() Group by the feature_id column
 * @method QuantificationresultQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method QuantificationresultQuery groupByQuantificationId() Group by the quantification_id column
 * @method QuantificationresultQuery groupByTypeId() Group by the type_id column
 * @method QuantificationresultQuery groupByValue() Group by the value column
 *
 * @method QuantificationresultQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method QuantificationresultQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method QuantificationresultQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method QuantificationresultQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method QuantificationresultQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method QuantificationresultQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method QuantificationresultQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method QuantificationresultQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method QuantificationresultQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method QuantificationresultQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method QuantificationresultQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method QuantificationresultQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method QuantificationresultQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method QuantificationresultQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method QuantificationresultQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method QuantificationresultQuery leftJoinExpressionresultQuantificationresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the ExpressionresultQuantificationresult relation
 * @method QuantificationresultQuery rightJoinExpressionresultQuantificationresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ExpressionresultQuantificationresult relation
 * @method QuantificationresultQuery innerJoinExpressionresultQuantificationresult($relationAlias = null) Adds a INNER JOIN clause to the query using the ExpressionresultQuantificationresult relation
 *
 * @method Quantificationresult findOne(PropelPDO $con = null) Return the first Quantificationresult matching the query
 * @method Quantificationresult findOneOrCreate(PropelPDO $con = null) Return the first Quantificationresult matching the query, or a new Quantificationresult object populated from the query conditions when no match is found
 *
 * @method Quantificationresult findOneByFeatureId(int $feature_id) Return the first Quantificationresult filtered by the feature_id column
 * @method Quantificationresult findOneByBiomaterialId(int $biomaterial_id) Return the first Quantificationresult filtered by the biomaterial_id column
 * @method Quantificationresult findOneByQuantificationId(int $quantification_id) Return the first Quantificationresult filtered by the quantification_id column
 * @method Quantificationresult findOneByTypeId(int $type_id) Return the first Quantificationresult filtered by the type_id column
 * @method Quantificationresult findOneByValue(double $value) Return the first Quantificationresult filtered by the value column
 *
 * @method array findByQuantificationresultId(int $quantificationresult_id) Return Quantificationresult objects filtered by the quantificationresult_id column
 * @method array findByFeatureId(int $feature_id) Return Quantificationresult objects filtered by the feature_id column
 * @method array findByBiomaterialId(int $biomaterial_id) Return Quantificationresult objects filtered by the biomaterial_id column
 * @method array findByQuantificationId(int $quantification_id) Return Quantificationresult objects filtered by the quantification_id column
 * @method array findByTypeId(int $type_id) Return Quantificationresult objects filtered by the type_id column
 * @method array findByValue(double $value) Return Quantificationresult objects filtered by the value column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseQuantificationresultQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseQuantificationresultQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Quantificationresult', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new QuantificationresultQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   QuantificationresultQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return QuantificationresultQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof QuantificationresultQuery) {
            return $criteria;
        }
        $query = new QuantificationresultQuery();
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
     * @return   Quantificationresult|Quantificationresult[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = QuantificationresultPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(QuantificationresultPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Quantificationresult A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByQuantificationresultId($key, $con = null)
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
     * @return                 Quantificationresult A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "quantificationresult_id", "feature_id", "biomaterial_id", "quantification_id", "type_id", "value" FROM "quantificationresult" WHERE "quantificationresult_id" = :p0';
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
            $obj = new Quantificationresult();
            $obj->hydrate($row);
            QuantificationresultPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Quantificationresult|Quantificationresult[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Quantificationresult[]|mixed the list of results, formatted by the current formatter
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
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the quantificationresult_id column
     *
     * Example usage:
     * <code>
     * $query->filterByQuantificationresultId(1234); // WHERE quantificationresult_id = 1234
     * $query->filterByQuantificationresultId(array(12, 34)); // WHERE quantificationresult_id IN (12, 34)
     * $query->filterByQuantificationresultId(array('min' => 12)); // WHERE quantificationresult_id >= 12
     * $query->filterByQuantificationresultId(array('max' => 12)); // WHERE quantificationresult_id <= 12
     * </code>
     *
     * @param     mixed $quantificationresultId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByQuantificationresultId($quantificationresultId = null, $comparison = null)
    {
        if (is_array($quantificationresultId)) {
            $useMinMax = false;
            if (isset($quantificationresultId['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationresultId['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresultId, $comparison);
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
     * @see       filterByFeature()
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::FEATURE_ID, $featureId, $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
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
     * @see       filterByQuantification()
     *
     * @param     mixed $quantificationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByQuantificationId($quantificationId = null, $comparison = null)
    {
        if (is_array($quantificationId)) {
            $useMinMax = false;
            if (isset($quantificationId['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATION_ID, $quantificationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($quantificationId['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATION_ID, $quantificationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATION_ID, $quantificationId, $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the value column
     *
     * Example usage:
     * <code>
     * $query->filterByValue(1234); // WHERE value = 1234
     * $query->filterByValue(array(12, 34)); // WHERE value IN (12, 34)
     * $query->filterByValue(array('min' => 12)); // WHERE value >= 12
     * $query->filterByValue(array('max' => 12)); // WHERE value <= 12
     * </code>
     *
     * @param     mixed $value The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(QuantificationresultPeer::VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(QuantificationresultPeer::VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(QuantificationresultPeer::VALUE, $value, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(QuantificationresultPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationresultPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
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
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(QuantificationresultPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationresultPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
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
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(QuantificationresultPeer::FEATURE_ID, $feature->getFeatureId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationresultPeer::FEATURE_ID, $feature->toKeyValue('PrimaryKey', 'FeatureId'), $comparison);
        } else {
            throw new PropelException('filterByFeature() only accepts arguments of type Feature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Feature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Feature');

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
            $this->addJoinObject($join, 'Feature');
        }

        return $this;
    }

    /**
     * Use the Feature relation Feature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureQuery A secondary query class using the current class as primary query
     */
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(QuantificationresultPeer::QUANTIFICATION_ID, $quantification->getQuantificationId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(QuantificationresultPeer::QUANTIFICATION_ID, $quantification->toKeyValue('PrimaryKey', 'QuantificationId'), $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
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
     * Filter the query by a related ExpressionresultQuantificationresult object
     *
     * @param   ExpressionresultQuantificationresult|PropelObjectCollection $expressionresultQuantificationresult  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 QuantificationresultQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExpressionresultQuantificationresult($expressionresultQuantificationresult, $comparison = null)
    {
        if ($expressionresultQuantificationresult instanceof ExpressionresultQuantificationresult) {
            return $this
                ->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $expressionresultQuantificationresult->getQuantificationresultId(), $comparison);
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
     * @return QuantificationresultQuery The current query, for fluid interface
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
     * @param   Quantificationresult $quantificationresult Object to remove from the list of results
     *
     * @return QuantificationresultQuery The current query, for fluid interface
     */
    public function prune($quantificationresult = null)
    {
        if ($quantificationresult) {
            $this->addUsingAlias(QuantificationresultPeer::QUANTIFICATIONRESULT_ID, $quantificationresult->getQuantificationresultId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
