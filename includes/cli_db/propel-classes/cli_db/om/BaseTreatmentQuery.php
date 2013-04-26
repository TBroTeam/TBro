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
use cli_db\propel\Cvterm;
use cli_db\propel\Protocol;
use cli_db\propel\Treatment;
use cli_db\propel\TreatmentPeer;
use cli_db\propel\TreatmentQuery;

/**
 * Base class that represents a query for the 'treatment' table.
 *
 *
 *
 * @method TreatmentQuery orderByTreatmentId($order = Criteria::ASC) Order by the treatment_id column
 * @method TreatmentQuery orderByRank($order = Criteria::ASC) Order by the rank column
 * @method TreatmentQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method TreatmentQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method TreatmentQuery orderByProtocolId($order = Criteria::ASC) Order by the protocol_id column
 * @method TreatmentQuery orderByName($order = Criteria::ASC) Order by the name column
 *
 * @method TreatmentQuery groupByTreatmentId() Group by the treatment_id column
 * @method TreatmentQuery groupByRank() Group by the rank column
 * @method TreatmentQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method TreatmentQuery groupByTypeId() Group by the type_id column
 * @method TreatmentQuery groupByProtocolId() Group by the protocol_id column
 * @method TreatmentQuery groupByName() Group by the name column
 *
 * @method TreatmentQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method TreatmentQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method TreatmentQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method TreatmentQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method TreatmentQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method TreatmentQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method TreatmentQuery leftJoinProtocol($relationAlias = null) Adds a LEFT JOIN clause to the query using the Protocol relation
 * @method TreatmentQuery rightJoinProtocol($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Protocol relation
 * @method TreatmentQuery innerJoinProtocol($relationAlias = null) Adds a INNER JOIN clause to the query using the Protocol relation
 *
 * @method TreatmentQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method TreatmentQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method TreatmentQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method TreatmentQuery leftJoinBiomaterialTreatment($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialTreatment relation
 * @method TreatmentQuery rightJoinBiomaterialTreatment($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialTreatment relation
 * @method TreatmentQuery innerJoinBiomaterialTreatment($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialTreatment relation
 *
 * @method Treatment findOne(PropelPDO $con = null) Return the first Treatment matching the query
 * @method Treatment findOneOrCreate(PropelPDO $con = null) Return the first Treatment matching the query, or a new Treatment object populated from the query conditions when no match is found
 *
 * @method Treatment findOneByRank(int $rank) Return the first Treatment filtered by the rank column
 * @method Treatment findOneByBiomaterialId(int $biomaterial_id) Return the first Treatment filtered by the biomaterial_id column
 * @method Treatment findOneByTypeId(int $type_id) Return the first Treatment filtered by the type_id column
 * @method Treatment findOneByProtocolId(int $protocol_id) Return the first Treatment filtered by the protocol_id column
 * @method Treatment findOneByName(string $name) Return the first Treatment filtered by the name column
 *
 * @method array findByTreatmentId(int $treatment_id) Return Treatment objects filtered by the treatment_id column
 * @method array findByRank(int $rank) Return Treatment objects filtered by the rank column
 * @method array findByBiomaterialId(int $biomaterial_id) Return Treatment objects filtered by the biomaterial_id column
 * @method array findByTypeId(int $type_id) Return Treatment objects filtered by the type_id column
 * @method array findByProtocolId(int $protocol_id) Return Treatment objects filtered by the protocol_id column
 * @method array findByName(string $name) Return Treatment objects filtered by the name column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseTreatmentQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseTreatmentQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Treatment', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new TreatmentQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   TreatmentQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return TreatmentQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof TreatmentQuery) {
            return $criteria;
        }
        $query = new TreatmentQuery();
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
     * @return   Treatment|Treatment[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = TreatmentPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(TreatmentPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Treatment A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByTreatmentId($key, $con = null)
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
     * @return                 Treatment A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "treatment_id", "rank", "biomaterial_id", "type_id", "protocol_id", "name" FROM "treatment" WHERE "treatment_id" = :p0';
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
            $obj = new Treatment();
            $obj->hydrate($row);
            TreatmentPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Treatment|Treatment[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Treatment[]|mixed the list of results, formatted by the current formatter
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
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $keys, Criteria::IN);
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
     * @param     mixed $treatmentId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByTreatmentId($treatmentId = null, $comparison = null)
    {
        if (is_array($treatmentId)) {
            $useMinMax = false;
            if (isset($treatmentId['min'])) {
                $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $treatmentId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($treatmentId['max'])) {
                $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $treatmentId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $treatmentId, $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(TreatmentPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(TreatmentPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TreatmentPeer::RANK, $rank, $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(TreatmentPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(TreatmentPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TreatmentPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(TreatmentPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(TreatmentPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TreatmentPeer::TYPE_ID, $typeId, $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function filterByProtocolId($protocolId = null, $comparison = null)
    {
        if (is_array($protocolId)) {
            $useMinMax = false;
            if (isset($protocolId['min'])) {
                $this->addUsingAlias(TreatmentPeer::PROTOCOL_ID, $protocolId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($protocolId['max'])) {
                $this->addUsingAlias(TreatmentPeer::PROTOCOL_ID, $protocolId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(TreatmentPeer::PROTOCOL_ID, $protocolId, $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
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

        return $this->addUsingAlias(TreatmentPeer::NAME, $name, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(TreatmentPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TreatmentPeer::BIOMATERIAL_ID, $biomaterial->toKeyValue('PrimaryKey', 'BiomaterialId'), $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
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
     * Filter the query by a related Protocol object
     *
     * @param   Protocol|PropelObjectCollection $protocol The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProtocol($protocol, $comparison = null)
    {
        if ($protocol instanceof Protocol) {
            return $this
                ->addUsingAlias(TreatmentPeer::PROTOCOL_ID, $protocol->getProtocolId(), $comparison);
        } elseif ($protocol instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TreatmentPeer::PROTOCOL_ID, $protocol->toKeyValue('PrimaryKey', 'ProtocolId'), $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
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
     * @return                 TreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(TreatmentPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(TreatmentPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return TreatmentQuery The current query, for fluid interface
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
     * Filter the query by a related BiomaterialTreatment object
     *
     * @param   BiomaterialTreatment|PropelObjectCollection $biomaterialTreatment  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 TreatmentQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialTreatment($biomaterialTreatment, $comparison = null)
    {
        if ($biomaterialTreatment instanceof BiomaterialTreatment) {
            return $this
                ->addUsingAlias(TreatmentPeer::TREATMENT_ID, $biomaterialTreatment->getTreatmentId(), $comparison);
        } elseif ($biomaterialTreatment instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialTreatmentQuery()
                ->filterByPrimaryKeys($biomaterialTreatment->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialTreatment() only accepts arguments of type BiomaterialTreatment or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialTreatment relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function joinBiomaterialTreatment($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialTreatment');

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
            $this->addJoinObject($join, 'BiomaterialTreatment');
        }

        return $this;
    }

    /**
     * Use the BiomaterialTreatment relation BiomaterialTreatment object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialTreatmentQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialTreatmentQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialTreatment($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialTreatment', '\cli_db\propel\BiomaterialTreatmentQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Treatment $treatment Object to remove from the list of results
     *
     * @return TreatmentQuery The current query, for fluid interface
     */
    public function prune($treatment = null)
    {
        if ($treatment) {
            $this->addUsingAlias(TreatmentPeer::TREATMENT_ID, $treatment->getTreatmentId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
