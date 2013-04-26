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
use cli_db\propel\Study;
use cli_db\propel\Studyprop;
use cli_db\propel\StudypropFeature;
use cli_db\propel\StudypropPeer;
use cli_db\propel\StudypropQuery;

/**
 * Base class that represents a query for the 'studyprop' table.
 *
 *
 *
 * @method StudypropQuery orderByStudypropId($order = Criteria::ASC) Order by the studyprop_id column
 * @method StudypropQuery orderByStudyId($order = Criteria::ASC) Order by the study_id column
 * @method StudypropQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method StudypropQuery orderByValue($order = Criteria::ASC) Order by the value column
 * @method StudypropQuery orderByRank($order = Criteria::ASC) Order by the rank column
 *
 * @method StudypropQuery groupByStudypropId() Group by the studyprop_id column
 * @method StudypropQuery groupByStudyId() Group by the study_id column
 * @method StudypropQuery groupByTypeId() Group by the type_id column
 * @method StudypropQuery groupByValue() Group by the value column
 * @method StudypropQuery groupByRank() Group by the rank column
 *
 * @method StudypropQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudypropQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudypropQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudypropQuery leftJoinStudy($relationAlias = null) Adds a LEFT JOIN clause to the query using the Study relation
 * @method StudypropQuery rightJoinStudy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Study relation
 * @method StudypropQuery innerJoinStudy($relationAlias = null) Adds a INNER JOIN clause to the query using the Study relation
 *
 * @method StudypropQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method StudypropQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method StudypropQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method StudypropQuery leftJoinStudypropFeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the StudypropFeature relation
 * @method StudypropQuery rightJoinStudypropFeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StudypropFeature relation
 * @method StudypropQuery innerJoinStudypropFeature($relationAlias = null) Adds a INNER JOIN clause to the query using the StudypropFeature relation
 *
 * @method Studyprop findOne(PropelPDO $con = null) Return the first Studyprop matching the query
 * @method Studyprop findOneOrCreate(PropelPDO $con = null) Return the first Studyprop matching the query, or a new Studyprop object populated from the query conditions when no match is found
 *
 * @method Studyprop findOneByStudyId(int $study_id) Return the first Studyprop filtered by the study_id column
 * @method Studyprop findOneByTypeId(int $type_id) Return the first Studyprop filtered by the type_id column
 * @method Studyprop findOneByValue(string $value) Return the first Studyprop filtered by the value column
 * @method Studyprop findOneByRank(int $rank) Return the first Studyprop filtered by the rank column
 *
 * @method array findByStudypropId(int $studyprop_id) Return Studyprop objects filtered by the studyprop_id column
 * @method array findByStudyId(int $study_id) Return Studyprop objects filtered by the study_id column
 * @method array findByTypeId(int $type_id) Return Studyprop objects filtered by the type_id column
 * @method array findByValue(string $value) Return Studyprop objects filtered by the value column
 * @method array findByRank(int $rank) Return Studyprop objects filtered by the rank column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudypropQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudypropQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Studyprop', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudypropQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudypropQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudypropQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudypropQuery) {
            return $criteria;
        }
        $query = new StudypropQuery();
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
     * @return   Studyprop|Studyprop[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudypropPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudypropPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Studyprop A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudypropId($key, $con = null)
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
     * @return                 Studyprop A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studyprop_id", "study_id", "type_id", "value", "rank" FROM "studyprop" WHERE "studyprop_id" = :p0';
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
            $obj = new Studyprop();
            $obj->hydrate($row);
            StudypropPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Studyprop|Studyprop[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Studyprop[]|mixed the list of results, formatted by the current formatter
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
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studyprop_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudypropId(1234); // WHERE studyprop_id = 1234
     * $query->filterByStudypropId(array(12, 34)); // WHERE studyprop_id IN (12, 34)
     * $query->filterByStudypropId(array('min' => 12)); // WHERE studyprop_id >= 12
     * $query->filterByStudypropId(array('max' => 12)); // WHERE studyprop_id <= 12
     * </code>
     *
     * @param     mixed $studypropId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByStudypropId($studypropId = null, $comparison = null)
    {
        if (is_array($studypropId)) {
            $useMinMax = false;
            if (isset($studypropId['min'])) {
                $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $studypropId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studypropId['max'])) {
                $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $studypropId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $studypropId, $comparison);
    }

    /**
     * Filter the query on the study_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudyId(1234); // WHERE study_id = 1234
     * $query->filterByStudyId(array(12, 34)); // WHERE study_id IN (12, 34)
     * $query->filterByStudyId(array('min' => 12)); // WHERE study_id >= 12
     * $query->filterByStudyId(array('max' => 12)); // WHERE study_id <= 12
     * </code>
     *
     * @see       filterByStudy()
     *
     * @param     mixed $studyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByStudyId($studyId = null, $comparison = null)
    {
        if (is_array($studyId)) {
            $useMinMax = false;
            if (isset($studyId['min'])) {
                $this->addUsingAlias(StudypropPeer::STUDY_ID, $studyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyId['max'])) {
                $this->addUsingAlias(StudypropPeer::STUDY_ID, $studyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropPeer::STUDY_ID, $studyId, $comparison);
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
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(StudypropPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(StudypropPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropPeer::TYPE_ID, $typeId, $comparison);
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
     * @return StudypropQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudypropPeer::VALUE, $value, $comparison);
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
     * @return StudypropQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(StudypropPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(StudypropPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudypropPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query by a related Study object
     *
     * @param   Study|PropelObjectCollection $study The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudy($study, $comparison = null)
    {
        if ($study instanceof Study) {
            return $this
                ->addUsingAlias(StudypropPeer::STUDY_ID, $study->getStudyId(), $comparison);
        } elseif ($study instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudypropPeer::STUDY_ID, $study->toKeyValue('PrimaryKey', 'StudyId'), $comparison);
        } else {
            throw new PropelException('filterByStudy() only accepts arguments of type Study or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Study relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function joinStudy($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Study');

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
            $this->addJoinObject($join, 'Study');
        }

        return $this;
    }

    /**
     * Use the Study relation Study object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyQuery A secondary query class using the current class as primary query
     */
    public function useStudyQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudy($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Study', '\cli_db\propel\StudyQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(StudypropPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudypropPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return StudypropQuery The current query, for fluid interface
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
     * Filter the query by a related StudypropFeature object
     *
     * @param   StudypropFeature|PropelObjectCollection $studypropFeature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudypropQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudypropFeature($studypropFeature, $comparison = null)
    {
        if ($studypropFeature instanceof StudypropFeature) {
            return $this
                ->addUsingAlias(StudypropPeer::STUDYPROP_ID, $studypropFeature->getStudypropId(), $comparison);
        } elseif ($studypropFeature instanceof PropelObjectCollection) {
            return $this
                ->useStudypropFeatureQuery()
                ->filterByPrimaryKeys($studypropFeature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudypropFeature() only accepts arguments of type StudypropFeature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StudypropFeature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function joinStudypropFeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StudypropFeature');

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
            $this->addJoinObject($join, 'StudypropFeature');
        }

        return $this;
    }

    /**
     * Use the StudypropFeature relation StudypropFeature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudypropFeatureQuery A secondary query class using the current class as primary query
     */
    public function useStudypropFeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudypropFeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StudypropFeature', '\cli_db\propel\StudypropFeatureQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Studyprop $studyprop Object to remove from the list of results
     *
     * @return StudypropQuery The current query, for fluid interface
     */
    public function prune($studyprop = null)
    {
        if ($studyprop) {
            $this->addUsingAlias(StudypropPeer::STUDYPROP_ID, $studyprop->getStudypropId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
