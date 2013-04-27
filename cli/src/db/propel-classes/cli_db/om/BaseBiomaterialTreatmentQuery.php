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
use cli_db\propel\BiomaterialTreatment;
use cli_db\propel\BiomaterialTreatmentPeer;
use cli_db\propel\BiomaterialTreatmentQuery;
use cli_db\propel\Cvterm;
use cli_db\propel\Treatment;

/**
 * Base class that represents a query for the 'biomaterial_treatment' table.
 *
 *
 *
 * @method BiomaterialTreatmentQuery orderByBiomaterialTreatmentId($order = Criteria::ASC) Order by the biomaterial_treatment_id column
 * @method BiomaterialTreatmentQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method BiomaterialTreatmentQuery orderByTreatmentId($order = Criteria::ASC) Order by the treatment_id column
 * @method BiomaterialTreatmentQuery orderByUnittypeId($order = Criteria::ASC) Order by the unittype_id column
 * @method BiomaterialTreatmentQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method BiomaterialTreatmentQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method BiomaterialTreatmentQuery groupByBiomaterialTreatmentId() Group by the biomaterial_treatment_id column
 * @method BiomaterialTreatmentQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method BiomaterialTreatmentQuery groupByTreatmentId() Group by the treatment_id column
 * @method BiomaterialTreatmentQuery groupByUnittypeId() Group by the unittype_id column
 * @method BiomaterialTreatmentQuery groupByValue() Group by the value column
 * @method BiomaterialTreatmentQuery groupByRank() Group by the rank column
 *
 * @method BiomaterialTreatmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BiomaterialTreatmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BiomaterialTreatmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BiomaterialTreatmentQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialTreatmentQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method BiomaterialTreatmentQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method BiomaterialTreatmentQuery leftJoinTreatment($relationAlias = null) Adds a LEFT JOIN clause to the query using the Treatment relation
 * @method BiomaterialTreatmentQuery rightJoinTreatment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Treatment relation
 * @method BiomaterialTreatmentQuery innerJoinTreatment($relationAlias = null) Adds a INNER JOIN clause to the query using the Treatment relation
 *
 * @method BiomaterialTreatmentQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method BiomaterialTreatmentQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method BiomaterialTreatmentQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method BiomaterialTreatment findOne(PropelPDO $con = null) Return the first BiomaterialTreatment matching the query
 * @method BiomaterialTreatment findOneOrCreate(PropelPDO $con = null) Return the first BiomaterialTreatment matching the query, or a new BiomaterialTreatment object populated from the query conditions when no match is found
 *
 * @method BiomaterialTreatment findOneByBiomaterialId(int $biomaterial_id) Return the first BiomaterialTreatment filtered by the biomaterial_id column
 * @method BiomaterialTreatment findOneByTreatmentId(int $treatment_id) Return the first BiomaterialTreatment filtered by the treatment_id column
 * @method BiomaterialTreatment findOneByUnittypeId(int $unittype_id) Return the first BiomaterialTreatment filtered by the unittype_id column
 * @method BiomaterialTreatment findOneByValue(double $value) Return the first BiomaterialTreatment filtered by the value column
 * @method BiomaterialTreatment findOneByRank(int $rank) Return the first BiomaterialTreatment filtered by the rank column
 *
 * @method array findByBiomaterialTreatmentId(int $biomaterial_treatment_id) Return BiomaterialTreatment objects filtered by the biomaterial_treatment_id column
 * @method array findByBiomaterialId(int $biomaterial_id) Return BiomaterialTreatment objects filtered by the biomaterial_id column
 * @method array findByTreatmentId(int $treatment_id) Return BiomaterialTreatment objects filtered by the treatment_id column
 * @method array findByUnittypeId(int $unittype_id) Return BiomaterialTreatment objects filtered by the unittype_id column
 * @method array findByValue(double $value) Return BiomaterialTreatment objects filtered by the value column
 * @method array findByRank(int $rank) Return BiomaterialTreatment objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseBiomaterialTreatmentQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBiomaterialTreatmentQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\BiomaterialTreatment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BiomaterialTreatmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BiomaterialTreatmentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BiomaterialTreatmentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BiomaterialTreatmentQuery) {
            return $criteria;
        }
        $query = new BiomaterialTreatmentQuery();
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
     * @return   BiomaterialTreatment|BiomaterialTreatment[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BiomaterialTreatmentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialTreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 BiomaterialTreatment A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByBiomaterialTreatmentId($key, $con = null)
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
     * @return                 BiomaterialTreatment A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "biomaterial_treatment_id", "biomaterial_id", "treatment_id", "unittype_id", "value", "rank" FROM "biomaterial_treatment" WHERE "biomaterial_treatment_id" = :p0';
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
            $obj = new BiomaterialTreatment();
            $obj->hydrate($row);
            BiomaterialTreatmentPeer::addInstanceToPool($obj, (string) $key);
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
     * @return BiomaterialTreatment|BiomaterialTreatment[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|BiomaterialTreatment[]|mixed the list of results, formatted by the current formatter
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the biomaterial_treatment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiomaterialTreatmentId(1234); // WHERE biomaterial_treatment_id = 1234
     * $query->filterByBiomaterialTreatmentId(array(12, 34)); // WHERE biomaterial_treatment_id IN (12, 34)
     * $query->filterByBiomaterialTreatmentId(array('min' => 12)); // WHERE biomaterial_treatment_id >= 12
     * $query->filterByBiomaterialTreatmentId(array('max' => 12)); // WHERE biomaterial_treatment_id <= 12
     * </code>
     *
     * @param     mixed $biomaterialTreatmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByBiomaterialTreatmentId($biomaterialTreatmentId = null, $comparison = null)
    {
        if (is_array($biomaterialTreatmentId)) {
            $useMinMax = false;
            if (isset($biomaterialTreatmentId['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $biomaterialTreatmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialTreatmentId['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $biomaterialTreatmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $biomaterialTreatmentId, $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
    }

    /**
     * Filter the query on the treatment_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTreatmentId(1234); // WHERE treatment_id = 1234
     * $query->filterByTreatmentId(array(12, 34)); // WHERE treatment_id IN (12, 34)
     * $query->filterByTreatmentId(array('min' => 12)); // WHERE treatment_id >= 12
     * $query->filterByTreatmentId(array('max' => 12)); // WHERE treatment_id <= 12
     * </code>
     *
     * @see       filterByTreatment()
     *
     * @param     mixed $treatmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByTreatmentId($treatmentId = null, $comparison = null)
    {
        if (is_array($treatmentId)) {
            $useMinMax = false;
            if (isset($treatmentId['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::TREATMENT_ID, $treatmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($treatmentId['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::TREATMENT_ID, $treatmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::TREATMENT_ID, $treatmentId, $comparison);
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
     * @see       filterByCvterm()
     *
     * @param     mixed $unittypeId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByUnittypeId($unittypeId = null, $comparison = null)
    {
        if (is_array($unittypeId)) {
            $useMinMax = false;
            if (isset($unittypeId['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::UNITTYPE_ID, $unittypeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($unittypeId['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::UNITTYPE_ID, $unittypeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::UNITTYPE_ID, $unittypeId, $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByValue($value = null, $comparison = null)
    {
        if (is_array($value)) {
            $useMinMax = false;
            if (isset($value['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::VALUE, $value['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($value['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::VALUE, $value['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::VALUE, $value, $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(BiomaterialTreatmentPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialTreatmentPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialTreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
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
     * Filter the query by a related Treatment object
     *
     * @param   Treatment|PropelObjectCollection $treatment The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialTreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTreatment($treatment, $comparison = null)
    {
        if ($treatment instanceof Treatment) {
            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::TREATMENT_ID, $treatment->getTreatmentId(), $comparison);
        } elseif ($treatment instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::TREATMENT_ID, $treatment->toKeyValue('PrimaryKey', 'TreatmentId'), $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function joinTreatment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useTreatmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTreatment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Treatment', '\cli_db\propel\TreatmentQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialTreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::UNITTYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialTreatmentPeer::UNITTYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function joinCvterm($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useCvtermQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Cvterm', '\cli_db\propel\CvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   BiomaterialTreatment $biomaterialTreatment Object to remove from the list of results
     *
     * @return BiomaterialTreatmentQuery The current query, for fluid interface
     */
    public function prune($biomaterialTreatment = null)
    {
        if ($biomaterialTreatment) {
            $this->addUsingAlias(BiomaterialTreatmentPeer::BIOMATERIAL_TREATMENT_ID, $biomaterialTreatment->getBiomaterialTreatmentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
