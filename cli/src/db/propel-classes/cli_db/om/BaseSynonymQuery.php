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
use cli_db\propel\FeatureSynonym;
use cli_db\propel\Synonym;
use cli_db\propel\SynonymPeer;
use cli_db\propel\SynonymQuery;

/**
 * Base class that represents a query for the 'synonym' table.
 *
 *
 *
 * @method SynonymQuery orderBySynonymId($order = Criteria::ASC) Order by the synonym_id column
 * @method SynonymQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method SynonymQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method SynonymQuery orderBySynonymSgml($order = Criteria::ASC) Order by the synonym_sgml column
 *
 * @method SynonymQuery groupBySynonymId() Group by the synonym_id column
 * @method SynonymQuery groupByName() Group by the name column
 * @method SynonymQuery groupByTypeId() Group by the type_id column
 * @method SynonymQuery groupBySynonymSgml() Group by the synonym_sgml column
 *
 * @method SynonymQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method SynonymQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method SynonymQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method SynonymQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method SynonymQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method SynonymQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method SynonymQuery leftJoinFeatureSynonym($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureSynonym relation
 * @method SynonymQuery rightJoinFeatureSynonym($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureSynonym relation
 * @method SynonymQuery innerJoinFeatureSynonym($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureSynonym relation
 *
 * @method Synonym findOne(PropelPDO $con = null) Return the first Synonym matching the query
 * @method Synonym findOneOrCreate(PropelPDO $con = null) Return the first Synonym matching the query, or a new Synonym object populated from the query conditions when no match is found
 *
 * @method Synonym findOneByName(string $name) Return the first Synonym filtered by the name column
 * @method Synonym findOneByTypeId(int $type_id) Return the first Synonym filtered by the type_id column
 * @method Synonym findOneBySynonymSgml(string $synonym_sgml) Return the first Synonym filtered by the synonym_sgml column
 *
 * @method array findBySynonymId(int $synonym_id) Return Synonym objects filtered by the synonym_id column
 * @method array findByName(string $name) Return Synonym objects filtered by the name column
 * @method array findByTypeId(int $type_id) Return Synonym objects filtered by the type_id column
 * @method array findBySynonymSgml(string $synonym_sgml) Return Synonym objects filtered by the synonym_sgml column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseSynonymQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseSynonymQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Synonym', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new SynonymQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   SynonymQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return SynonymQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof SynonymQuery) {
            return $criteria;
        }
        $query = new SynonymQuery();
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
     * @return   Synonym|Synonym[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = SynonymPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(SynonymPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Synonym A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneBySynonymId($key, $con = null)
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
     * @return                 Synonym A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "synonym_id", "name", "type_id", "synonym_sgml" FROM "synonym" WHERE "synonym_id" = :p0';
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
            $obj = new Synonym();
            $obj->hydrate($row);
            SynonymPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Synonym|Synonym[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Synonym[]|mixed the list of results, formatted by the current formatter
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
     * @return SynonymQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return SynonymQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the synonym_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySynonymId(1234); // WHERE synonym_id = 1234
     * $query->filterBySynonymId(array(12, 34)); // WHERE synonym_id IN (12, 34)
     * $query->filterBySynonymId(array('min' => 12)); // WHERE synonym_id >= 12
     * $query->filterBySynonymId(array('max' => 12)); // WHERE synonym_id <= 12
     * </code>
     *
     * @param     mixed $synonymId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SynonymQuery The current query, for fluid interface
     */
    public function filterBySynonymId($synonymId = null, $comparison = null)
    {
        if (is_array($synonymId)) {
            $useMinMax = false;
            if (isset($synonymId['min'])) {
                $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $synonymId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($synonymId['max'])) {
                $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $synonymId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $synonymId, $comparison);
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
     * @return SynonymQuery The current query, for fluid interface
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

        return $this->addUsingAlias(SynonymPeer::NAME, $name, $comparison);
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
     * @return SynonymQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(SynonymPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(SynonymPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(SynonymPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the synonym_sgml column
     *
     * Example usage:
     * <code>
     * $query->filterBySynonymSgml('fooValue');   // WHERE synonym_sgml = 'fooValue'
     * $query->filterBySynonymSgml('%fooValue%'); // WHERE synonym_sgml LIKE '%fooValue%'
     * </code>
     *
     * @param     string $synonymSgml The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return SynonymQuery The current query, for fluid interface
     */
    public function filterBySynonymSgml($synonymSgml = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($synonymSgml)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $synonymSgml)) {
                $synonymSgml = str_replace('*', '%', $synonymSgml);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(SynonymPeer::SYNONYM_SGML, $synonymSgml, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SynonymQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(SynonymPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(SynonymPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return SynonymQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureSynonym object
     *
     * @param   FeatureSynonym|PropelObjectCollection $featureSynonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 SynonymQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureSynonym($featureSynonym, $comparison = null)
    {
        if ($featureSynonym instanceof FeatureSynonym) {
            return $this
                ->addUsingAlias(SynonymPeer::SYNONYM_ID, $featureSynonym->getSynonymId(), $comparison);
        } elseif ($featureSynonym instanceof PropelObjectCollection) {
            return $this
                ->useFeatureSynonymQuery()
                ->filterByPrimaryKeys($featureSynonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureSynonym() only accepts arguments of type FeatureSynonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureSynonym relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return SynonymQuery The current query, for fluid interface
     */
    public function joinFeatureSynonym($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureSynonym');

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
            $this->addJoinObject($join, 'FeatureSynonym');
        }

        return $this;
    }

    /**
     * Use the FeatureSynonym relation FeatureSynonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureSynonymQuery A secondary query class using the current class as primary query
     */
    public function useFeatureSynonymQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureSynonym($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureSynonym', '\cli_db\propel\FeatureSynonymQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Synonym $synonym Object to remove from the list of results
     *
     * @return SynonymQuery The current query, for fluid interface
     */
    public function prune($synonym = null)
    {
        if ($synonym) {
            $this->addUsingAlias(SynonymPeer::SYNONYM_ID, $synonym->getSynonymId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
