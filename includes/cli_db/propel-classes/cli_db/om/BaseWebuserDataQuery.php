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
use cli_db\propel\WebuserData;
use cli_db\propel\WebuserDataPeer;
use cli_db\propel\WebuserDataQuery;

/**
 * Base class that represents a query for the 'webuser_data' table.
 *
 *
 *
 * @method WebuserDataQuery orderByIdentity($order = Criteria::ASC) Order by the identity column
 * @method WebuserDataQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method WebuserDataQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method WebuserDataQuery orderByWebuserDataId($order = Criteria::ASC) Order by the webuser_data_id column
 *
 * @method WebuserDataQuery groupByIdentity() Group by the identity column
 * @method WebuserDataQuery groupByTypeId() Group by the type_id column
 * @method WebuserDataQuery groupByValue() Group by the value column
 * @method WebuserDataQuery groupByWebuserDataId() Group by the webuser_data_id column
 *
 * @method WebuserDataQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method WebuserDataQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method WebuserDataQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method WebuserDataQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method WebuserDataQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method WebuserDataQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method WebuserData findOne(PropelPDO $con = null) Return the first WebuserData matching the query
 * @method WebuserData findOneOrCreate(PropelPDO $con = null) Return the first WebuserData matching the query, or a new WebuserData object populated from the query conditions when no match is found
 *
 * @method WebuserData findOneByIdentity(string $identity) Return the first WebuserData filtered by the identity column
 * @method WebuserData findOneByTypeId(int $type_id) Return the first WebuserData filtered by the type_id column
 * @method WebuserData findOneByValue(string $value) Return the first WebuserData filtered by the value column
 *
 * @method array findByIdentity(string $identity) Return WebuserData objects filtered by the identity column
 * @method array findByTypeId(int $type_id) Return WebuserData objects filtered by the type_id column
 * @method array findByValue(string $value) Return WebuserData objects filtered by the value column
 * @method array findByWebuserDataId(int $webuser_data_id) Return WebuserData objects filtered by the webuser_data_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseWebuserDataQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseWebuserDataQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\WebuserData', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new WebuserDataQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   WebuserDataQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return WebuserDataQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof WebuserDataQuery) {
            return $criteria;
        }
        $query = new WebuserDataQuery();
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
     * @return   WebuserData|WebuserData[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = WebuserDataPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(WebuserDataPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 WebuserData A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByWebuserDataId($key, $con = null)
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
     * @return                 WebuserData A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "identity", "type_id", "value", "webuser_data_id" FROM "webuser_data" WHERE "webuser_data_id" = :p0';
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
            $obj = new WebuserData();
            $obj->hydrate($row);
            WebuserDataPeer::addInstanceToPool($obj, (string) $key);
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
     * @return WebuserData|WebuserData[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|WebuserData[]|mixed the list of results, formatted by the current formatter
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
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the identity column
     *
     * Example usage:
     * <code>
     * $query->filterByIdentity('fooValue');   // WHERE identity = 'fooValue'
     * $query->filterByIdentity('%fooValue%'); // WHERE identity LIKE '%fooValue%'
     * </code>
     *
     * @param     string $identity The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function filterByIdentity($identity = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($identity)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $identity)) {
                $identity = str_replace('*', '%', $identity);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(WebuserDataPeer::IDENTITY, $identity, $comparison);
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
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(WebuserDataPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(WebuserDataPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebuserDataPeer::TYPE_ID, $typeId, $comparison);
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
     * @return WebuserDataQuery The current query, for fluid interface
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

        return $this->addUsingAlias(WebuserDataPeer::VALUE, $value, $comparison);
    }

    /**
     * Filter the query on the webuser_data_id column
     *
     * Example usage:
     * <code>
     * $query->filterByWebuserDataId(1234); // WHERE webuser_data_id = 1234
     * $query->filterByWebuserDataId(array(12, 34)); // WHERE webuser_data_id IN (12, 34)
     * $query->filterByWebuserDataId(array('min' => 12)); // WHERE webuser_data_id >= 12
     * $query->filterByWebuserDataId(array('max' => 12)); // WHERE webuser_data_id <= 12
     * </code>
     *
     * @param     mixed $webuserDataId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function filterByWebuserDataId($webuserDataId = null, $comparison = null)
    {
        if (is_array($webuserDataId)) {
            $useMinMax = false;
            if (isset($webuserDataId['min'])) {
                $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $webuserDataId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($webuserDataId['max'])) {
                $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $webuserDataId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $webuserDataId, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 WebuserDataQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(WebuserDataPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(WebuserDataPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return WebuserDataQuery The current query, for fluid interface
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
     * @param   WebuserData $webuserData Object to remove from the list of results
     *
     * @return WebuserDataQuery The current query, for fluid interface
     */
    public function prune($webuserData = null)
    {
        if ($webuserData) {
            $this->addUsingAlias(WebuserDataPeer::WEBUSER_DATA_ID, $webuserData->getWebuserDataId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
