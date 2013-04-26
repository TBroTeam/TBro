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
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureCvtermDbxrefPeer;
use cli_db\propel\FeatureCvtermDbxrefQuery;

/**
 * Base class that represents a query for the 'feature_cvterm_dbxref' table.
 *
 *
 *
 * @method FeatureCvtermDbxrefQuery orderByFeatureCvtermDbxrefId($order = Criteria::ASC) Order by the feature_cvterm_dbxref_id column
 * @method FeatureCvtermDbxrefQuery orderByFeatureCvtermId($order = Criteria::ASC) Order by the feature_cvterm_id column
 * @method FeatureCvtermDbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 *
 * @method FeatureCvtermDbxrefQuery groupByFeatureCvtermDbxrefId() Group by the feature_cvterm_dbxref_id column
 * @method FeatureCvtermDbxrefQuery groupByFeatureCvtermId() Group by the feature_cvterm_id column
 * @method FeatureCvtermDbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 *
 * @method FeatureCvtermDbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureCvtermDbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureCvtermDbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureCvtermDbxrefQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method FeatureCvtermDbxrefQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method FeatureCvtermDbxrefQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method FeatureCvtermDbxrefQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermDbxrefQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureCvtermDbxrefQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method FeatureCvtermDbxref findOne(PropelPDO $con = null) Return the first FeatureCvtermDbxref matching the query
 * @method FeatureCvtermDbxref findOneOrCreate(PropelPDO $con = null) Return the first FeatureCvtermDbxref matching the query, or a new FeatureCvtermDbxref object populated from the query conditions when no match is found
 *
 * @method FeatureCvtermDbxref findOneByFeatureCvtermId(int $feature_cvterm_id) Return the first FeatureCvtermDbxref filtered by the feature_cvterm_id column
 * @method FeatureCvtermDbxref findOneByDbxrefId(int $dbxref_id) Return the first FeatureCvtermDbxref filtered by the dbxref_id column
 *
 * @method array findByFeatureCvtermDbxrefId(int $feature_cvterm_dbxref_id) Return FeatureCvtermDbxref objects filtered by the feature_cvterm_dbxref_id column
 * @method array findByFeatureCvtermId(int $feature_cvterm_id) Return FeatureCvtermDbxref objects filtered by the feature_cvterm_id column
 * @method array findByDbxrefId(int $dbxref_id) Return FeatureCvtermDbxref objects filtered by the dbxref_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureCvtermDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureCvtermDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\FeatureCvtermDbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureCvtermDbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureCvtermDbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureCvtermDbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureCvtermDbxrefQuery) {
            return $criteria;
        }
        $query = new FeatureCvtermDbxrefQuery();
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
     * @return   FeatureCvtermDbxref|FeatureCvtermDbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeatureCvtermDbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeatureCvtermDbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 FeatureCvtermDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureCvtermDbxrefId($key, $con = null)
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
     * @return                 FeatureCvtermDbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_cvterm_dbxref_id", "feature_cvterm_id", "dbxref_id" FROM "feature_cvterm_dbxref" WHERE "feature_cvterm_dbxref_id" = :p0';
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
            $obj = new FeatureCvtermDbxref();
            $obj->hydrate($row);
            FeatureCvtermDbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return FeatureCvtermDbxref|FeatureCvtermDbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|FeatureCvtermDbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_cvterm_dbxref_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureCvtermDbxrefId(1234); // WHERE feature_cvterm_dbxref_id = 1234
     * $query->filterByFeatureCvtermDbxrefId(array(12, 34)); // WHERE feature_cvterm_dbxref_id IN (12, 34)
     * $query->filterByFeatureCvtermDbxrefId(array('min' => 12)); // WHERE feature_cvterm_dbxref_id >= 12
     * $query->filterByFeatureCvtermDbxrefId(array('max' => 12)); // WHERE feature_cvterm_dbxref_id <= 12
     * </code>
     *
     * @param     mixed $featureCvtermDbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermDbxrefId($featureCvtermDbxrefId = null, $comparison = null)
    {
        if (is_array($featureCvtermDbxrefId)) {
            $useMinMax = false;
            if (isset($featureCvtermDbxrefId['min'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $featureCvtermDbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermDbxrefId['max'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $featureCvtermDbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $featureCvtermDbxrefId, $comparison);
    }

    /**
     * Filter the query on the feature_cvterm_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureCvtermId(1234); // WHERE feature_cvterm_id = 1234
     * $query->filterByFeatureCvtermId(array(12, 34)); // WHERE feature_cvterm_id IN (12, 34)
     * $query->filterByFeatureCvtermId(array('min' => 12)); // WHERE feature_cvterm_id >= 12
     * $query->filterByFeatureCvtermId(array('max' => 12)); // WHERE feature_cvterm_id <= 12
     * </code>
     *
     * @see       filterByFeatureCvterm()
     *
     * @param     mixed $featureCvtermId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByFeatureCvtermId($featureCvtermId = null, $comparison = null)
    {
        if (is_array($featureCvtermId)) {
            $useMinMax = false;
            if (isset($featureCvtermId['min'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_ID, $featureCvtermId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureCvtermId['max'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_ID, $featureCvtermId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_ID, $featureCvtermId, $comparison);
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
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(FeatureCvtermDbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeatureCvtermDbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(FeatureCvtermDbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermDbxrefPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureCvtermDbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_ID, $featureCvterm->getFeatureCvtermId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_ID, $featureCvterm->toKeyValue('PrimaryKey', 'FeatureCvtermId'), $comparison);
        } else {
            throw new PropelException('filterByFeatureCvterm() only accepts arguments of type FeatureCvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function joinFeatureCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvterm');

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
            $this->addJoinObject($join, 'FeatureCvterm');
        }

        return $this;
    }

    /**
     * Use the FeatureCvterm relation FeatureCvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvterm', '\cli_db\propel\FeatureCvtermQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   FeatureCvtermDbxref $featureCvtermDbxref Object to remove from the list of results
     *
     * @return FeatureCvtermDbxrefQuery The current query, for fluid interface
     */
    public function prune($featureCvtermDbxref = null)
    {
        if ($featureCvtermDbxref) {
            $this->addUsingAlias(FeatureCvtermDbxrefPeer::FEATURE_CVTERM_DBXREF_ID, $featureCvtermDbxref->getFeatureCvtermDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
