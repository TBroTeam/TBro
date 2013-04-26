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
use cli_db\propel\Magedocumentation;
use cli_db\propel\Mageml;
use cli_db\propel\MagemlPeer;
use cli_db\propel\MagemlQuery;

/**
 * Base class that represents a query for the 'mageml' table.
 *
 *
 *
 * @method MagemlQuery orderByMagemlId($order = Criteria::ASC) Order by the mageml_id column
 * @method MagemlQuery orderByMagePackage($order = Criteria::ASC) Order by the mage_package column
 * @method MagemlQuery orderByMageMl($order = Criteria::ASC) Order by the mage_ml column
 *
 * @method MagemlQuery groupByMagemlId() Group by the mageml_id column
 * @method MagemlQuery groupByMagePackage() Group by the mage_package column
 * @method MagemlQuery groupByMageMl() Group by the mage_ml column
 *
 * @method MagemlQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MagemlQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MagemlQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MagemlQuery leftJoinMagedocumentation($relationAlias = null) Adds a LEFT JOIN clause to the query using the Magedocumentation relation
 * @method MagemlQuery rightJoinMagedocumentation($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Magedocumentation relation
 * @method MagemlQuery innerJoinMagedocumentation($relationAlias = null) Adds a INNER JOIN clause to the query using the Magedocumentation relation
 *
 * @method Mageml findOne(PropelPDO $con = null) Return the first Mageml matching the query
 * @method Mageml findOneOrCreate(PropelPDO $con = null) Return the first Mageml matching the query, or a new Mageml object populated from the query conditions when no match is found
 *
 * @method Mageml findOneByMagePackage(string $mage_package) Return the first Mageml filtered by the mage_package column
 * @method Mageml findOneByMageMl(string $mage_ml) Return the first Mageml filtered by the mage_ml column
 *
 * @method array findByMagemlId(int $mageml_id) Return Mageml objects filtered by the mageml_id column
 * @method array findByMagePackage(string $mage_package) Return Mageml objects filtered by the mage_package column
 * @method array findByMageMl(string $mage_ml) Return Mageml objects filtered by the mage_ml column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseMagemlQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMagemlQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Mageml', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MagemlQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MagemlQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MagemlQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MagemlQuery) {
            return $criteria;
        }
        $query = new MagemlQuery();
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
     * @return   Mageml|Mageml[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MagemlPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MagemlPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Mageml A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByMagemlId($key, $con = null)
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
     * @return                 Mageml A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "mageml_id", "mage_package", "mage_ml" FROM "mageml" WHERE "mageml_id" = :p0';
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
            $obj = new Mageml();
            $obj->hydrate($row);
            MagemlPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Mageml|Mageml[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Mageml[]|mixed the list of results, formatted by the current formatter
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
     * @return MagemlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MagemlPeer::MAGEML_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MagemlPeer::MAGEML_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the mageml_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMagemlId(1234); // WHERE mageml_id = 1234
     * $query->filterByMagemlId(array(12, 34)); // WHERE mageml_id IN (12, 34)
     * $query->filterByMagemlId(array('min' => 12)); // WHERE mageml_id >= 12
     * $query->filterByMagemlId(array('max' => 12)); // WHERE mageml_id <= 12
     * </code>
     *
     * @param     mixed $magemlId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function filterByMagemlId($magemlId = null, $comparison = null)
    {
        if (is_array($magemlId)) {
            $useMinMax = false;
            if (isset($magemlId['min'])) {
                $this->addUsingAlias(MagemlPeer::MAGEML_ID, $magemlId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($magemlId['max'])) {
                $this->addUsingAlias(MagemlPeer::MAGEML_ID, $magemlId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MagemlPeer::MAGEML_ID, $magemlId, $comparison);
    }

    /**
     * Filter the query on the mage_package column
     *
     * Example usage:
     * <code>
     * $query->filterByMagePackage('fooValue');   // WHERE mage_package = 'fooValue'
     * $query->filterByMagePackage('%fooValue%'); // WHERE mage_package LIKE '%fooValue%'
     * </code>
     *
     * @param     string $magePackage The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function filterByMagePackage($magePackage = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($magePackage)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $magePackage)) {
                $magePackage = str_replace('*', '%', $magePackage);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MagemlPeer::MAGE_PACKAGE, $magePackage, $comparison);
    }

    /**
     * Filter the query on the mage_ml column
     *
     * Example usage:
     * <code>
     * $query->filterByMageMl('fooValue');   // WHERE mage_ml = 'fooValue'
     * $query->filterByMageMl('%fooValue%'); // WHERE mage_ml LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mageMl The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function filterByMageMl($mageMl = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mageMl)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mageMl)) {
                $mageMl = str_replace('*', '%', $mageMl);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MagemlPeer::MAGE_ML, $mageMl, $comparison);
    }

    /**
     * Filter the query by a related Magedocumentation object
     *
     * @param   Magedocumentation|PropelObjectCollection $magedocumentation  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MagemlQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMagedocumentation($magedocumentation, $comparison = null)
    {
        if ($magedocumentation instanceof Magedocumentation) {
            return $this
                ->addUsingAlias(MagemlPeer::MAGEML_ID, $magedocumentation->getMagemlId(), $comparison);
        } elseif ($magedocumentation instanceof PropelObjectCollection) {
            return $this
                ->useMagedocumentationQuery()
                ->filterByPrimaryKeys($magedocumentation->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByMagedocumentation() only accepts arguments of type Magedocumentation or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Magedocumentation relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function joinMagedocumentation($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Magedocumentation');

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
            $this->addJoinObject($join, 'Magedocumentation');
        }

        return $this;
    }

    /**
     * Use the Magedocumentation relation Magedocumentation object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\MagedocumentationQuery A secondary query class using the current class as primary query
     */
    public function useMagedocumentationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMagedocumentation($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Magedocumentation', '\cli_db\propel\MagedocumentationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Mageml $mageml Object to remove from the list of results
     *
     * @return MagemlQuery The current query, for fluid interface
     */
    public function prune($mageml = null)
    {
        if ($mageml) {
            $this->addUsingAlias(MagemlPeer::MAGEML_ID, $mageml->getMagemlId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
