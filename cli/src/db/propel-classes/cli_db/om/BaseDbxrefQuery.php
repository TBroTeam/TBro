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
use cli_db\propel\Db;
use cli_db\propel\Dbxref;
use cli_db\propel\DbxrefPeer;
use cli_db\propel\DbxrefQuery;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvtermDbxref;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\PubDbxref;

/**
 * Base class that represents a query for the 'dbxref' table.
 *
 *
 *
 * @method DbxrefQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method DbxrefQuery orderByDbId($order = Criteria::ASC) Order by the db_id column
 * @method DbxrefQuery orderByAccession($order = Criteria::ASC) Order by the accession column
 * @method DbxrefQuery orderByVersion($order = Criteria::ASC) Order by the version column
 * @method DbxrefQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method DbxrefQuery groupByDbxrefId() Group by the dbxref_id column
 * @method DbxrefQuery groupByDbId() Group by the db_id column
 * @method DbxrefQuery groupByAccession() Group by the accession column
 * @method DbxrefQuery groupByVersion() Group by the version column
 * @method DbxrefQuery groupByDescription() Group by the description column
 *
 * @method DbxrefQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method DbxrefQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method DbxrefQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method DbxrefQuery leftJoinDb($relationAlias = null) Adds a LEFT JOIN clause to the query using the Db relation
 * @method DbxrefQuery rightJoinDb($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Db relation
 * @method DbxrefQuery innerJoinDb($relationAlias = null) Adds a INNER JOIN clause to the query using the Db relation
 *
 * @method DbxrefQuery leftJoinFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Feature relation
 * @method DbxrefQuery rightJoinFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Feature relation
 * @method DbxrefQuery innerJoinFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Feature relation
 *
 * @method DbxrefQuery leftJoinFeatureCvtermDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermDbxref relation
 * @method DbxrefQuery rightJoinFeatureCvtermDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermDbxref relation
 * @method DbxrefQuery innerJoinFeatureCvtermDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermDbxref relation
 *
 * @method DbxrefQuery leftJoinFeatureDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureDbxref relation
 * @method DbxrefQuery rightJoinFeatureDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureDbxref relation
 * @method DbxrefQuery innerJoinFeatureDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureDbxref relation
 *
 * @method DbxrefQuery leftJoinPubDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubDbxref relation
 * @method DbxrefQuery rightJoinPubDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubDbxref relation
 * @method DbxrefQuery innerJoinPubDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the PubDbxref relation
 *
 * @method Dbxref findOne(PropelPDO $con = null) Return the first Dbxref matching the query
 * @method Dbxref findOneOrCreate(PropelPDO $con = null) Return the first Dbxref matching the query, or a new Dbxref object populated from the query conditions when no match is found
 *
 * @method Dbxref findOneByDbId(int $db_id) Return the first Dbxref filtered by the db_id column
 * @method Dbxref findOneByAccession(string $accession) Return the first Dbxref filtered by the accession column
 * @method Dbxref findOneByVersion(string $version) Return the first Dbxref filtered by the version column
 * @method Dbxref findOneByDescription(string $description) Return the first Dbxref filtered by the description column
 *
 * @method array findByDbxrefId(int $dbxref_id) Return Dbxref objects filtered by the dbxref_id column
 * @method array findByDbId(int $db_id) Return Dbxref objects filtered by the db_id column
 * @method array findByAccession(string $accession) Return Dbxref objects filtered by the accession column
 * @method array findByVersion(string $version) Return Dbxref objects filtered by the version column
 * @method array findByDescription(string $description) Return Dbxref objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseDbxrefQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseDbxrefQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Dbxref', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new DbxrefQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   DbxrefQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return DbxrefQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof DbxrefQuery) {
            return $criteria;
        }
        $query = new DbxrefQuery();
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
     * @return   Dbxref|Dbxref[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = DbxrefPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(DbxrefPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Dbxref A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByDbxrefId($key, $con = null)
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
     * @return                 Dbxref A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "dbxref_id", "db_id", "accession", "version", "description" FROM "dbxref" WHERE "dbxref_id" = :p0';
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
            $obj = new Dbxref();
            $obj->hydrate($row);
            DbxrefPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Dbxref|Dbxref[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Dbxref[]|mixed the list of results, formatted by the current formatter
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
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $keys, Criteria::IN);
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
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $dbxrefId, $comparison);
    }

    /**
     * Filter the query on the db_id column
     *
     * Example usage:
     * <code>
     * $query->filterByDbId(1234); // WHERE db_id = 1234
     * $query->filterByDbId(array(12, 34)); // WHERE db_id IN (12, 34)
     * $query->filterByDbId(array('min' => 12)); // WHERE db_id >= 12
     * $query->filterByDbId(array('max' => 12)); // WHERE db_id <= 12
     * </code>
     *
     * @see       filterByDb()
     *
     * @param     mixed $dbId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByDbId($dbId = null, $comparison = null)
    {
        if (is_array($dbId)) {
            $useMinMax = false;
            if (isset($dbId['min'])) {
                $this->addUsingAlias(DbxrefPeer::DB_ID, $dbId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbId['max'])) {
                $this->addUsingAlias(DbxrefPeer::DB_ID, $dbId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(DbxrefPeer::DB_ID, $dbId, $comparison);
    }

    /**
     * Filter the query on the accession column
     *
     * Example usage:
     * <code>
     * $query->filterByAccession('fooValue');   // WHERE accession = 'fooValue'
     * $query->filterByAccession('%fooValue%'); // WHERE accession LIKE '%fooValue%'
     * </code>
     *
     * @param     string $accession The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByAccession($accession = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($accession)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $accession)) {
                $accession = str_replace('*', '%', $accession);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DbxrefPeer::ACCESSION, $accession, $comparison);
    }

    /**
     * Filter the query on the version column
     *
     * Example usage:
     * <code>
     * $query->filterByVersion('fooValue');   // WHERE version = 'fooValue'
     * $query->filterByVersion('%fooValue%'); // WHERE version LIKE '%fooValue%'
     * </code>
     *
     * @param     string $version The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByVersion($version = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($version)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $version)) {
                $version = str_replace('*', '%', $version);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DbxrefPeer::VERSION, $version, $comparison);
    }

    /**
     * Filter the query on the description column
     *
     * Example usage:
     * <code>
     * $query->filterByDescription('fooValue');   // WHERE description = 'fooValue'
     * $query->filterByDescription('%fooValue%'); // WHERE description LIKE '%fooValue%'
     * </code>
     *
     * @param     string $description The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function filterByDescription($description = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($description)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $description)) {
                $description = str_replace('*', '%', $description);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(DbxrefPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Db object
     *
     * @param   Db|PropelObjectCollection $db The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDb($db, $comparison = null)
    {
        if ($db instanceof Db) {
            return $this
                ->addUsingAlias(DbxrefPeer::DB_ID, $db->getDbId(), $comparison);
        } elseif ($db instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(DbxrefPeer::DB_ID, $db->toKeyValue('PrimaryKey', 'DbId'), $comparison);
        } else {
            throw new PropelException('filterByDb() only accepts arguments of type Db or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Db relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function joinDb($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Db');

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
            $this->addJoinObject($join, 'Db');
        }

        return $this;
    }

    /**
     * Use the Db relation Db object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbQuery A secondary query class using the current class as primary query
     */
    public function useDbQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinDb($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Db', '\cli_db\propel\DbQuery');
    }

    /**
     * Filter the query by a related Feature object
     *
     * @param   Feature|PropelObjectCollection $feature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeature($feature, $comparison = null)
    {
        if ($feature instanceof Feature) {
            return $this
                ->addUsingAlias(DbxrefPeer::DBXREF_ID, $feature->getDbxrefId(), $comparison);
        } elseif ($feature instanceof PropelObjectCollection) {
            return $this
                ->useFeatureQuery()
                ->filterByPrimaryKeys($feature->getPrimaryKeys())
                ->endUse();
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
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function joinFeature($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
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
    public function useFeatureQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Feature', '\cli_db\propel\FeatureQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermDbxref object
     *
     * @param   FeatureCvtermDbxref|PropelObjectCollection $featureCvtermDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermDbxref($featureCvtermDbxref, $comparison = null)
    {
        if ($featureCvtermDbxref instanceof FeatureCvtermDbxref) {
            return $this
                ->addUsingAlias(DbxrefPeer::DBXREF_ID, $featureCvtermDbxref->getDbxrefId(), $comparison);
        } elseif ($featureCvtermDbxref instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermDbxrefQuery()
                ->filterByPrimaryKeys($featureCvtermDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermDbxref() only accepts arguments of type FeatureCvtermDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermDbxref');

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
            $this->addJoinObject($join, 'FeatureCvtermDbxref');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermDbxref relation FeatureCvtermDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermDbxrefQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermDbxref', '\cli_db\propel\FeatureCvtermDbxrefQuery');
    }

    /**
     * Filter the query by a related FeatureDbxref object
     *
     * @param   FeatureDbxref|PropelObjectCollection $featureDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureDbxref($featureDbxref, $comparison = null)
    {
        if ($featureDbxref instanceof FeatureDbxref) {
            return $this
                ->addUsingAlias(DbxrefPeer::DBXREF_ID, $featureDbxref->getDbxrefId(), $comparison);
        } elseif ($featureDbxref instanceof PropelObjectCollection) {
            return $this
                ->useFeatureDbxrefQuery()
                ->filterByPrimaryKeys($featureDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureDbxref() only accepts arguments of type FeatureDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function joinFeatureDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureDbxref');

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
            $this->addJoinObject($join, 'FeatureDbxref');
        }

        return $this;
    }

    /**
     * Use the FeatureDbxref relation FeatureDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureDbxrefQuery A secondary query class using the current class as primary query
     */
    public function useFeatureDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureDbxref', '\cli_db\propel\FeatureDbxrefQuery');
    }

    /**
     * Filter the query by a related PubDbxref object
     *
     * @param   PubDbxref|PropelObjectCollection $pubDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 DbxrefQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubDbxref($pubDbxref, $comparison = null)
    {
        if ($pubDbxref instanceof PubDbxref) {
            return $this
                ->addUsingAlias(DbxrefPeer::DBXREF_ID, $pubDbxref->getDbxrefId(), $comparison);
        } elseif ($pubDbxref instanceof PropelObjectCollection) {
            return $this
                ->usePubDbxrefQuery()
                ->filterByPrimaryKeys($pubDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubDbxref() only accepts arguments of type PubDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function joinPubDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubDbxref');

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
            $this->addJoinObject($join, 'PubDbxref');
        }

        return $this;
    }

    /**
     * Use the PubDbxref relation PubDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubDbxrefQuery A secondary query class using the current class as primary query
     */
    public function usePubDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubDbxref', '\cli_db\propel\PubDbxrefQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Dbxref $dbxref Object to remove from the list of results
     *
     * @return DbxrefQuery The current query, for fluid interface
     */
    public function prune($dbxref = null)
    {
        if ($dbxref) {
            $this->addUsingAlias(DbxrefPeer::DBXREF_ID, $dbxref->getDbxrefId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
