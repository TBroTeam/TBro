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
use cli_db\propel\Dbxref;
use cli_db\propel\Organism;
use cli_db\propel\OrganismDbxref;
use cli_db\propel\OrganismDbxrefPeer;
use cli_db\propel\OrganismDbxrefQuery;

/**
 * Base class that represents a query for the 'organism_dbxref' table.
 *
 *
 *
 * @method OrganismDbxrefQuery orderByOrganismDbxrefId($order = Criteria::ASC) Order by the organism_dbxref_id column
 * @method OrganismDbxrefQuery orderByOrganismId($order = Criteria::ASC) Order by the organism_id column
 * @method OrganismDbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 *
 * @method OrganismDbxrefQuery groupByOrganismDbxrefId() Group by the organism_dbxref_id column
 * @method OrganismDbxrefQuery groupByOrganismId() Group by the organism_id column
 * @method OrganismDbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 *
 * @method OrganismDbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method OrganismDbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method OrganismDbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method OrganismDbxrefQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method OrganismDbxrefQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method OrganismDbxrefQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method OrganismDbxrefQuery leftJoinOrganism($relationAlias = null) Adds a LEFT JOIN clause to the query using the Organism relation
 * @method OrganismDbxrefQuery rightJoinOrganism($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Organism relation
 * @method OrganismDbxrefQuery innerJoinOrganism($relationAlias = null) Adds a INNER JOIN clause to the query using the Organism relation
 *
 * @method OrganismDbxref findOne(PropelPDO $con = null) Return the first OrganismDbxref matching the query
 * @method OrganismDbxref findOneOrCreate(PropelPDO $con = null) Return the first OrganismDbxref matching the query, or a new OrganismDbxref object populated from the query conditions when no match is found
 *
 * @method OrganismDbxref findOneByOrganismId(int $organism_id) Return the first OrganismDbxref filtered by the organism_id column
 * @method OrganismDbxref findOneByDbxrefId(int $dbxref_id) Return the first OrganismDbxref filtered by the dbxref_id column
 *
 * @method array findByOrganismDbxrefId(int $organism_dbxref_id) Return OrganismDbxref objects filtered by the organism_dbxref_id column
 * @method array findByOrganismId(int $organism_id) Return OrganismDbxref objects filtered by the organism_id column
 * @method array findByDbxrefId(int $dbxref_id) Return OrganismDbxref objects filtered by the dbxref_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseOrganismDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseOrganismDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\OrganismDbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new OrganismDbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   OrganismDbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return OrganismDbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof OrganismDbxrefQuery) {
            return $criteria;
        }
        $query = new OrganismDbxrefQuery();
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
     * @return   OrganismDbxref|OrganismDbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrganismDbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(OrganismDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 OrganismDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByOrganismDbxrefId($key, $con = null)
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
     * @return                 OrganismDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "organism_dbxref_id", "organism_id", "dbxref_id" FROM "organism_dbxref" WHERE "organism_dbxref_id" = :p0';
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
            $obj = new OrganismDbxref();
            $obj->hydrate($row);
            OrganismDbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return OrganismDbxref|OrganismDbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|OrganismDbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the organism_dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrganismDbxrefId(1234); // WHERE organism_dbxref_id = 1234
     * $query->filterByOrganismDbxrefId(array(12, 34)); // WHERE organism_dbxref_id IN (12, 34)
     * $query->filterByOrganismDbxrefId(array('min' => 12)); // WHERE organism_dbxref_id >= 12
     * $query->filterByOrganismDbxrefId(array('max' => 12)); // WHERE organism_dbxref_id <= 12
     * </code>
     *
     * @param     mixed $organismDbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function filterByOrganismDbxrefId($organismDbxrefId = null, $comparison = null)
    {
        if (is_array($organismDbxrefId)) {
            $useMinMax = false;
            if (isset($organismDbxrefId['min'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $organismDbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismDbxrefId['max'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $organismDbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $organismDbxrefId, $comparison);
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
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function filterByOrganismId($organismId = null, $comparison = null)
    {
        if (is_array($organismId)) {
            $useMinMax = false;
            if (isset($organismId['min'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_ID, $organismId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismId['max'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_ID, $organismId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_ID, $organismId, $comparison);
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
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(OrganismDbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismDbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OrganismDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(OrganismDbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrganismDbxrefPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related Organism object
     *
     * @param   Organism|PropelObjectCollection $organism The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OrganismDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOrganism($organism, $comparison = null)
    {
        if ($organism instanceof Organism) {
            return $this
                ->addUsingAlias(OrganismDbxrefPeer::ORGANISM_ID, $organism->getOrganismId(), $comparison);
        } elseif ($organism instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(OrganismDbxrefPeer::ORGANISM_ID, $organism->toKeyValue('PrimaryKey', 'OrganismId'), $comparison);
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
     * @return OrganismDbxrefQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   OrganismDbxref $organismDbxref Object to remove from the list of results
     *
     * @return OrganismDbxrefQuery The current query, for fluid interface
     */
    public function prune($organismDbxref = null)
    {
        if ($organismDbxref) {
            $this->addUsingAlias(OrganismDbxrefPeer::ORGANISM_DBXREF_ID, $organismDbxref->getOrganismDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
