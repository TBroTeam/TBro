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
use cli_db\propel\MagedocumentationPeer;
use cli_db\propel\MagedocumentationQuery;
use cli_db\propel\Mageml;
use cli_db\propel\Tableinfo;

/**
 * Base class that represents a query for the 'magedocumentation' table.
 *
 *
 *
 * @method MagedocumentationQuery orderByMagedocumentationId($order = Criteria::ASC) Order by the magedocumentation_id column
 * @method MagedocumentationQuery orderByMagemlId($order = Criteria::ASC) Order by the mageml_id column
 * @method MagedocumentationQuery orderByTableinfoId($order = Criteria::ASC) Order by the tableinfo_id column
 * @method MagedocumentationQuery orderByRowId($order = Criteria::ASC) Order by the row_id column
 * @method MagedocumentationQuery orderByMageidentifier($order = Criteria::ASC) Order by the mageidentifier column
 *
 * @method MagedocumentationQuery groupByMagedocumentationId() Group by the magedocumentation_id column
 * @method MagedocumentationQuery groupByMagemlId() Group by the mageml_id column
 * @method MagedocumentationQuery groupByTableinfoId() Group by the tableinfo_id column
 * @method MagedocumentationQuery groupByRowId() Group by the row_id column
 * @method MagedocumentationQuery groupByMageidentifier() Group by the mageidentifier column
 *
 * @method MagedocumentationQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method MagedocumentationQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method MagedocumentationQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method MagedocumentationQuery leftJoinMageml($relationAlias = null) Adds a LEFT JOIN clause to the query using the Mageml relation
 * @method MagedocumentationQuery rightJoinMageml($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Mageml relation
 * @method MagedocumentationQuery innerJoinMageml($relationAlias = null) Adds a INNER JOIN clause to the query using the Mageml relation
 *
 * @method MagedocumentationQuery leftJoinTableinfo($relationAlias = null) Adds a LEFT JOIN clause to the query using the Tableinfo relation
 * @method MagedocumentationQuery rightJoinTableinfo($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Tableinfo relation
 * @method MagedocumentationQuery innerJoinTableinfo($relationAlias = null) Adds a INNER JOIN clause to the query using the Tableinfo relation
 *
 * @method Magedocumentation findOne(PropelPDO $con = null) Return the first Magedocumentation matching the query
 * @method Magedocumentation findOneOrCreate(PropelPDO $con = null) Return the first Magedocumentation matching the query, or a new Magedocumentation object populated from the query conditions when no match is found
 *
 * @method Magedocumentation findOneByMagemlId(int $mageml_id) Return the first Magedocumentation filtered by the mageml_id column
 * @method Magedocumentation findOneByTableinfoId(int $tableinfo_id) Return the first Magedocumentation filtered by the tableinfo_id column
 * @method Magedocumentation findOneByRowId(int $row_id) Return the first Magedocumentation filtered by the row_id column
 * @method Magedocumentation findOneByMageidentifier(string $mageidentifier) Return the first Magedocumentation filtered by the mageidentifier column
 *
 * @method array findByMagedocumentationId(int $magedocumentation_id) Return Magedocumentation objects filtered by the magedocumentation_id column
 * @method array findByMagemlId(int $mageml_id) Return Magedocumentation objects filtered by the mageml_id column
 * @method array findByTableinfoId(int $tableinfo_id) Return Magedocumentation objects filtered by the tableinfo_id column
 * @method array findByRowId(int $row_id) Return Magedocumentation objects filtered by the row_id column
 * @method array findByMageidentifier(string $mageidentifier) Return Magedocumentation objects filtered by the mageidentifier column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseMagedocumentationQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseMagedocumentationQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Magedocumentation', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new MagedocumentationQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   MagedocumentationQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return MagedocumentationQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof MagedocumentationQuery) {
            return $criteria;
        }
        $query = new MagedocumentationQuery();
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
     * @return   Magedocumentation|Magedocumentation[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = MagedocumentationPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(MagedocumentationPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Magedocumentation A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByMagedocumentationId($key, $con = null)
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
     * @return                 Magedocumentation A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "magedocumentation_id", "mageml_id", "tableinfo_id", "row_id", "mageidentifier" FROM "magedocumentation" WHERE "magedocumentation_id" = :p0';
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
            $obj = new Magedocumentation();
            $obj->hydrate($row);
            MagedocumentationPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Magedocumentation|Magedocumentation[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Magedocumentation[]|mixed the list of results, formatted by the current formatter
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
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the magedocumentation_id column
     *
     * Example usage:
     * <code>
     * $query->filterByMagedocumentationId(1234); // WHERE magedocumentation_id = 1234
     * $query->filterByMagedocumentationId(array(12, 34)); // WHERE magedocumentation_id IN (12, 34)
     * $query->filterByMagedocumentationId(array('min' => 12)); // WHERE magedocumentation_id >= 12
     * $query->filterByMagedocumentationId(array('max' => 12)); // WHERE magedocumentation_id <= 12
     * </code>
     *
     * @param     mixed $magedocumentationId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByMagedocumentationId($magedocumentationId = null, $comparison = null)
    {
        if (is_array($magedocumentationId)) {
            $useMinMax = false;
            if (isset($magedocumentationId['min'])) {
                $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $magedocumentationId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($magedocumentationId['max'])) {
                $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $magedocumentationId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $magedocumentationId, $comparison);
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
     * @see       filterByMageml()
     *
     * @param     mixed $magemlId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByMagemlId($magemlId = null, $comparison = null)
    {
        if (is_array($magemlId)) {
            $useMinMax = false;
            if (isset($magemlId['min'])) {
                $this->addUsingAlias(MagedocumentationPeer::MAGEML_ID, $magemlId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($magemlId['max'])) {
                $this->addUsingAlias(MagedocumentationPeer::MAGEML_ID, $magemlId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MagedocumentationPeer::MAGEML_ID, $magemlId, $comparison);
    }

    /**
     * Filter the query on the tableinfo_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTableinfoId(1234); // WHERE tableinfo_id = 1234
     * $query->filterByTableinfoId(array(12, 34)); // WHERE tableinfo_id IN (12, 34)
     * $query->filterByTableinfoId(array('min' => 12)); // WHERE tableinfo_id >= 12
     * $query->filterByTableinfoId(array('max' => 12)); // WHERE tableinfo_id <= 12
     * </code>
     *
     * @see       filterByTableinfo()
     *
     * @param     mixed $tableinfoId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByTableinfoId($tableinfoId = null, $comparison = null)
    {
        if (is_array($tableinfoId)) {
            $useMinMax = false;
            if (isset($tableinfoId['min'])) {
                $this->addUsingAlias(MagedocumentationPeer::TABLEINFO_ID, $tableinfoId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($tableinfoId['max'])) {
                $this->addUsingAlias(MagedocumentationPeer::TABLEINFO_ID, $tableinfoId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MagedocumentationPeer::TABLEINFO_ID, $tableinfoId, $comparison);
    }

    /**
     * Filter the query on the row_id column
     *
     * Example usage:
     * <code>
     * $query->filterByRowId(1234); // WHERE row_id = 1234
     * $query->filterByRowId(array(12, 34)); // WHERE row_id IN (12, 34)
     * $query->filterByRowId(array('min' => 12)); // WHERE row_id >= 12
     * $query->filterByRowId(array('max' => 12)); // WHERE row_id <= 12
     * </code>
     *
     * @param     mixed $rowId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByRowId($rowId = null, $comparison = null)
    {
        if (is_array($rowId)) {
            $useMinMax = false;
            if (isset($rowId['min'])) {
                $this->addUsingAlias(MagedocumentationPeer::ROW_ID, $rowId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rowId['max'])) {
                $this->addUsingAlias(MagedocumentationPeer::ROW_ID, $rowId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(MagedocumentationPeer::ROW_ID, $rowId, $comparison);
    }

    /**
     * Filter the query on the mageidentifier column
     *
     * Example usage:
     * <code>
     * $query->filterByMageidentifier('fooValue');   // WHERE mageidentifier = 'fooValue'
     * $query->filterByMageidentifier('%fooValue%'); // WHERE mageidentifier LIKE '%fooValue%'
     * </code>
     *
     * @param     string $mageidentifier The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function filterByMageidentifier($mageidentifier = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($mageidentifier)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $mageidentifier)) {
                $mageidentifier = str_replace('*', '%', $mageidentifier);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(MagedocumentationPeer::MAGEIDENTIFIER, $mageidentifier, $comparison);
    }

    /**
     * Filter the query by a related Mageml object
     *
     * @param   Mageml|PropelObjectCollection $mageml The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MagedocumentationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByMageml($mageml, $comparison = null)
    {
        if ($mageml instanceof Mageml) {
            return $this
                ->addUsingAlias(MagedocumentationPeer::MAGEML_ID, $mageml->getMagemlId(), $comparison);
        } elseif ($mageml instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MagedocumentationPeer::MAGEML_ID, $mageml->toKeyValue('PrimaryKey', 'MagemlId'), $comparison);
        } else {
            throw new PropelException('filterByMageml() only accepts arguments of type Mageml or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Mageml relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function joinMageml($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Mageml');

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
            $this->addJoinObject($join, 'Mageml');
        }

        return $this;
    }

    /**
     * Use the Mageml relation Mageml object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\MagemlQuery A secondary query class using the current class as primary query
     */
    public function useMagemlQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinMageml($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Mageml', '\cli_db\propel\MagemlQuery');
    }

    /**
     * Filter the query by a related Tableinfo object
     *
     * @param   Tableinfo|PropelObjectCollection $tableinfo The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 MagedocumentationQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByTableinfo($tableinfo, $comparison = null)
    {
        if ($tableinfo instanceof Tableinfo) {
            return $this
                ->addUsingAlias(MagedocumentationPeer::TABLEINFO_ID, $tableinfo->getTableinfoId(), $comparison);
        } elseif ($tableinfo instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(MagedocumentationPeer::TABLEINFO_ID, $tableinfo->toKeyValue('PrimaryKey', 'TableinfoId'), $comparison);
        } else {
            throw new PropelException('filterByTableinfo() only accepts arguments of type Tableinfo or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Tableinfo relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function joinTableinfo($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Tableinfo');

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
            $this->addJoinObject($join, 'Tableinfo');
        }

        return $this;
    }

    /**
     * Use the Tableinfo relation Tableinfo object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\TableinfoQuery A secondary query class using the current class as primary query
     */
    public function useTableinfoQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinTableinfo($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Tableinfo', '\cli_db\propel\TableinfoQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Magedocumentation $magedocumentation Object to remove from the list of results
     *
     * @return MagedocumentationQuery The current query, for fluid interface
     */
    public function prune($magedocumentation = null)
    {
        if ($magedocumentation) {
            $this->addUsingAlias(MagedocumentationPeer::MAGEDOCUMENTATION_ID, $magedocumentation->getMagedocumentationId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
