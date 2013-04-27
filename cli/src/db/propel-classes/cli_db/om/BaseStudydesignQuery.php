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
use cli_db\propel\Study;
use cli_db\propel\Studydesign;
use cli_db\propel\StudydesignPeer;
use cli_db\propel\StudydesignQuery;
use cli_db\propel\Studydesignprop;
use cli_db\propel\Studyfactor;

/**
 * Base class that represents a query for the 'studydesign' table.
 *
 *
 *
 * @method StudydesignQuery orderByStudydesignId($order = Criteria::ASC) Order by the studydesign_id column
 * @method StudydesignQuery orderByStudyId($order = Criteria::ASC) Order by the study_id column
 * @method StudydesignQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method StudydesignQuery groupByStudydesignId() Group by the studydesign_id column
 * @method StudydesignQuery groupByStudyId() Group by the study_id column
 * @method StudydesignQuery groupByDescription() Group by the description column
 *
 * @method StudydesignQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudydesignQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudydesignQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudydesignQuery leftJoinStudy($relationAlias = null) Adds a LEFT JOIN clause to the query using the Study relation
 * @method StudydesignQuery rightJoinStudy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Study relation
 * @method StudydesignQuery innerJoinStudy($relationAlias = null) Adds a INNER JOIN clause to the query using the Study relation
 *
 * @method StudydesignQuery leftJoinStudydesignprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studydesignprop relation
 * @method StudydesignQuery rightJoinStudydesignprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studydesignprop relation
 * @method StudydesignQuery innerJoinStudydesignprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Studydesignprop relation
 *
 * @method StudydesignQuery leftJoinStudyfactor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyfactor relation
 * @method StudydesignQuery rightJoinStudyfactor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyfactor relation
 * @method StudydesignQuery innerJoinStudyfactor($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyfactor relation
 *
 * @method Studydesign findOne(PropelPDO $con = null) Return the first Studydesign matching the query
 * @method Studydesign findOneOrCreate(PropelPDO $con = null) Return the first Studydesign matching the query, or a new Studydesign object populated from the query conditions when no match is found
 *
 * @method Studydesign findOneByStudyId(int $study_id) Return the first Studydesign filtered by the study_id column
 * @method Studydesign findOneByDescription(string $description) Return the first Studydesign filtered by the description column
 *
 * @method array findByStudydesignId(int $studydesign_id) Return Studydesign objects filtered by the studydesign_id column
 * @method array findByStudyId(int $study_id) Return Studydesign objects filtered by the study_id column
 * @method array findByDescription(string $description) Return Studydesign objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudydesignQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudydesignQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Studydesign', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudydesignQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudydesignQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudydesignQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudydesignQuery) {
            return $criteria;
        }
        $query = new StudydesignQuery();
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
     * @return   Studydesign|Studydesign[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudydesignPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudydesignPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Studydesign A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudydesignId($key, $con = null)
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
     * @return                 Studydesign A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studydesign_id", "study_id", "description" FROM "studydesign" WHERE "studydesign_id" = :p0';
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
            $obj = new Studydesign();
            $obj->hydrate($row);
            StudydesignPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Studydesign|Studydesign[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Studydesign[]|mixed the list of results, formatted by the current formatter
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
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studydesign_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudydesignId(1234); // WHERE studydesign_id = 1234
     * $query->filterByStudydesignId(array(12, 34)); // WHERE studydesign_id IN (12, 34)
     * $query->filterByStudydesignId(array('min' => 12)); // WHERE studydesign_id >= 12
     * $query->filterByStudydesignId(array('max' => 12)); // WHERE studydesign_id <= 12
     * </code>
     *
     * @param     mixed $studydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function filterByStudydesignId($studydesignId = null, $comparison = null)
    {
        if (is_array($studydesignId)) {
            $useMinMax = false;
            if (isset($studydesignId['min'])) {
                $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studydesignId['max'])) {
                $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studydesignId, $comparison);
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
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function filterByStudyId($studyId = null, $comparison = null)
    {
        if (is_array($studyId)) {
            $useMinMax = false;
            if (isset($studyId['min'])) {
                $this->addUsingAlias(StudydesignPeer::STUDY_ID, $studyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyId['max'])) {
                $this->addUsingAlias(StudydesignPeer::STUDY_ID, $studyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudydesignPeer::STUDY_ID, $studyId, $comparison);
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
     * @return StudydesignQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudydesignPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Study object
     *
     * @param   Study|PropelObjectCollection $study The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudy($study, $comparison = null)
    {
        if ($study instanceof Study) {
            return $this
                ->addUsingAlias(StudydesignPeer::STUDY_ID, $study->getStudyId(), $comparison);
        } elseif ($study instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudydesignPeer::STUDY_ID, $study->toKeyValue('PrimaryKey', 'StudyId'), $comparison);
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
     * @return StudydesignQuery The current query, for fluid interface
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
     * Filter the query by a related Studydesignprop object
     *
     * @param   Studydesignprop|PropelObjectCollection $studydesignprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudydesignprop($studydesignprop, $comparison = null)
    {
        if ($studydesignprop instanceof Studydesignprop) {
            return $this
                ->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studydesignprop->getStudydesignId(), $comparison);
        } elseif ($studydesignprop instanceof PropelObjectCollection) {
            return $this
                ->useStudydesignpropQuery()
                ->filterByPrimaryKeys($studydesignprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudydesignprop() only accepts arguments of type Studydesignprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studydesignprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function joinStudydesignprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studydesignprop');

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
            $this->addJoinObject($join, 'Studydesignprop');
        }

        return $this;
    }

    /**
     * Use the Studydesignprop relation Studydesignprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudydesignpropQuery A secondary query class using the current class as primary query
     */
    public function useStudydesignpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudydesignprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studydesignprop', '\cli_db\propel\StudydesignpropQuery');
    }

    /**
     * Filter the query by a related Studyfactor object
     *
     * @param   Studyfactor|PropelObjectCollection $studyfactor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudydesignQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyfactor($studyfactor, $comparison = null)
    {
        if ($studyfactor instanceof Studyfactor) {
            return $this
                ->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studyfactor->getStudydesignId(), $comparison);
        } elseif ($studyfactor instanceof PropelObjectCollection) {
            return $this
                ->useStudyfactorQuery()
                ->filterByPrimaryKeys($studyfactor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyfactor() only accepts arguments of type Studyfactor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyfactor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function joinStudyfactor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyfactor');

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
            $this->addJoinObject($join, 'Studyfactor');
        }

        return $this;
    }

    /**
     * Use the Studyfactor relation Studyfactor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyfactorQuery A secondary query class using the current class as primary query
     */
    public function useStudyfactorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyfactor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyfactor', '\cli_db\propel\StudyfactorQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Studydesign $studydesign Object to remove from the list of results
     *
     * @return StudydesignQuery The current query, for fluid interface
     */
    public function prune($studydesign = null)
    {
        if ($studydesign) {
            $this->addUsingAlias(StudydesignPeer::STUDYDESIGN_ID, $studydesign->getStudydesignId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
