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
use cli_db\propel\Organism;
use cli_db\propel\Organismprop;
use cli_db\propel\OrganismpropPeer;
use cli_db\propel\OrganismpropQuery;

/**
 * Base class that represents a query for the 'organismprop' table.
 *
 *
 *
 * @method OrganismpropQuery orderByOrganismpropId($order = Criteria::ASC) Order by the organismprop_id column
 * @method OrganismpropQuery orderByOrganismId($order = Criteria::ASC) Order by the organism_id column
 * @method OrganismpropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method OrganismpropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method OrganismpropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method OrganismpropQuery groupByOrganismpropId() Group by the organismprop_id column
 * @method OrganismpropQuery groupByOrganismId() Group by the organism_id column
 * @method OrganismpropQuery groupByTypeId() Group by the type_id column
 * @method OrganismpropQuery groupByValue() Group by the value column
 * @method OrganismpropQuery groupByRank() Group by the rank column
 *
 * @method OrganismpropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method OrganismpropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method OrganismpropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method OrganismpropQuery leftJoinOrganism($relationAlias = null) Adds a LEFT JOIN clause to the query using the Organism relation
 * @method OrganismpropQuery rightJoinOrganism($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Organism relation
 * @method OrganismpropQuery innerJoinOrganism($relationAlias = null) Adds a INNER JOIN clause to the query using the Organism relation
 *
 * @method OrganismpropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method OrganismpropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method OrganismpropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method Organismprop findOne(PropelPDO $con = null) Return the first Organismprop matching the query
 * @method Organismprop findOneOrCreate(PropelPDO $con = null) Return the first Organismprop matching the query, or a new Organismprop object populated from the query conditions when no match is found
 *
 * @method Organismprop findOneByOrganismId(int $organism_id) Return the first Organismprop filtered by the organism_id column
 * @method Organismprop findOneByTypeId(int $type_id) Return the first Organismprop filtered by the type_id column
 * @method Organismprop findOneByValue(string $value) Return the first Organismprop filtered by the value column
 * @method Organismprop findOneByRank(int $rank) Return the first Organismprop filtered by the rank column
 *
 * @method array findByOrganismpropId(int $organismprop_id) Return Organismprop objects filtered by the organismprop_id column
 * @method array findByOrganismId(int $organism_id) Return Organismprop objects filtered by the organism_id column
 * @method array findByTypeId(int $type_id) Return Organismprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Organismprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Organismprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseOrganismpropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseOrganismpropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Organismprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new OrganismpropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   OrganismpropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return OrganismpropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof OrganismpropQuery) {
            return $criteria;
        }
        $query = new OrganismpropQuery();
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
     * @return   Organismprop|Organismprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrganismpropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(OrganismpropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Organismprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByOrganismpropId($key, $con = null)
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
     * @return                 Organismprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "organismprop_id", "organism_id", "type_id", "value", "rank" FROM "organismprop" WHERE "organismprop_id" = :p0';
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
            $obj = new Organismprop();
            $obj->hydrate($row);
            OrganismpropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Organismprop|Organismprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Organismprop[]|mixed the list of results, formatted by the current formatter
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
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the organismprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrganismpropId(1234); // WHERE organismprop_id = 1234
     * $query->filterByOrganismpropId(array(12, 34)); // WHERE organismprop_id IN (12, 34)
     * $query->filterByOrganismpropId(array('min' => 12)); // WHERE organismprop_id >= 12
     * $query->filterByOrganismpropId(array('max' => 12)); // WHERE organismprop_id <= 12
     * </code>
     *
     * @param     mixed $organismpropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByOrganismpropId($organismpropId = null, $comparison = null)
    {
        if (is_array($organismpropId)) {
            $useMinMax = false;
            if (isset($organismpropId['min'])) {
                $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $organismpropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismpropId['max'])) {
                $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $organismpropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $organismpropId, $comparison);
    }

    /**
     * Filter the query on the organism_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrganismId(1234); // WHERE organism_id = 1234
     * $query->filterByOrganismId(array(12, 34)); // WHERE organism_id IN (12, 34)
     * $query->filterByOrganismId(array('min' => 12)); // WHERE organism_id >= 12
     * $query->filterByOrganismId(array('max' => 12)); // WHERE organism_id <= 12
     * </code>
     *
     * @see       filterByOrganism()
     *
     * @param     mixed $organismId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByOrganismId($organismId = null, $comparison = null)
    {
        if (is_array($organismId)) {
            $useMinMax = false;
            if (isset($organismId['min'])) {
                $this->addUsingAlias(OrganismpropPeer::ORGANISM_ID, $organismId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismId['max'])) {
                $this->addUsingAlias(OrganismpropPeer::ORGANISM_ID, $organismId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismpropPeer::ORGANISM_ID, $organismId, $comparison);
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
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(OrganismpropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(OrganismpropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismpropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return OrganismpropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(OrganismpropPeer::VALUE, $value, $comparison);
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
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(OrganismpropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(OrganismpropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismpropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Organism object
     *
     * @param   Organism|PropelObjectCollection $organism The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OrganismpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOrganism($organism, $comparison = null)
    {
        if ($organism instanceof Organism) {
            return $this
                ->addUsingAlias(OrganismpropPeer::ORGANISM_ID, $organism->getOrganismId(), $comparison);
        } elseif ($organism instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrganismpropPeer::ORGANISM_ID, $organism->toKeyValue('PrimaryKey', 'OrganismId'), $comparison);
        } else {
            throw new PropelException('filterByOrganism() only accepts arguments of type Organism or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Organism relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function joinOrganism($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Organism');

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
            $this->addJoinObject($join, 'Organism');
        }

        return $this;
    }

    /**
     * Use the Organism relation Organism object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\OrganismQuery A secondary query class using the current class as primary query
     */
    public function useOrganismQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrganism($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Organism', '\cli_db\propel\OrganismQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OrganismpropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(OrganismpropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrganismpropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return OrganismpropQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Organismprop $organismprop Object to remove from the list of results
     *
     * @return OrganismpropQuery The current query, for fluid interface
     */
    public function prune($organismprop = null)
    {
        if ($organismprop) {
            $this->addUsingAlias(OrganismpropPeer::ORGANISMPROP_ID, $organismprop->getOrganismpropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
