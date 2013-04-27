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
use cli_db\propel\Assay;
use cli_db\propel\Study;
use cli_db\propel\StudyAssay;
use cli_db\propel\StudyAssayPeer;
use cli_db\propel\StudyAssayQuery;

/**
 * Base class that represents a query for the 'study_assay' table.
 *
 *
 *
 * @method StudyAssayQuery orderByStudyAssayId($order = Criteria::ASC) Order by the study_assay_id column
 * @method StudyAssayQuery orderByStudyId($order = Criteria::ASC) Order by the study_id column
 * @method StudyAssayQuery orderByAssayId($order = Criteria::ASC) Order by the assay_id column
 *
 * @method StudyAssayQuery groupByStudyAssayId() Group by the study_assay_id column
 * @method StudyAssayQuery groupByStudyId() Group by the study_id column
 * @method StudyAssayQuery groupByAssayId() Group by the assay_id column
 *
 * @method StudyAssayQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudyAssayQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudyAssayQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudyAssayQuery leftJoinAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the Assay relation
 * @method StudyAssayQuery rightJoinAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Assay relation
 * @method StudyAssayQuery innerJoinAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the Assay relation
 *
 * @method StudyAssayQuery leftJoinStudy($relationAlias = null) Adds a LEFT JOIN clause to the query using the Study relation
 * @method StudyAssayQuery rightJoinStudy($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Study relation
 * @method StudyAssayQuery innerJoinStudy($relationAlias = null) Adds a INNER JOIN clause to the query using the Study relation
 *
 * @method StudyAssay findOne(PropelPDO $con = null) Return the first StudyAssay matching the query
 * @method StudyAssay findOneOrCreate(PropelPDO $con = null) Return the first StudyAssay matching the query, or a new StudyAssay object populated from the query conditions when no match is found
 *
 * @method StudyAssay findOneByStudyId(int $study_id) Return the first StudyAssay filtered by the study_id column
 * @method StudyAssay findOneByAssayId(int $assay_id) Return the first StudyAssay filtered by the assay_id column
 *
 * @method array findByStudyAssayId(int $study_assay_id) Return StudyAssay objects filtered by the study_assay_id column
 * @method array findByStudyId(int $study_id) Return StudyAssay objects filtered by the study_id column
 * @method array findByAssayId(int $assay_id) Return StudyAssay objects filtered by the assay_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyAssayQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudyAssayQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\StudyAssay', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudyAssayQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudyAssayQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudyAssayQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudyAssayQuery) {
            return $criteria;
        }
        $query = new StudyAssayQuery();
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
     * @return   StudyAssay|StudyAssay[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudyAssayPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudyAssayPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 StudyAssay A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudyAssayId($key, $con = null)
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
     * @return                 StudyAssay A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "study_assay_id", "study_id", "assay_id" FROM "study_assay" WHERE "study_assay_id" = :p0';
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
            $obj = new StudyAssay();
            $obj->hydrate($row);
            StudyAssayPeer::addInstanceToPool($obj, (string) $key);
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
     * @return StudyAssay|StudyAssay[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|StudyAssay[]|mixed the list of results, formatted by the current formatter
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
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the study_assay_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudyAssayId(1234); // WHERE study_assay_id = 1234
     * $query->filterByStudyAssayId(array(12, 34)); // WHERE study_assay_id IN (12, 34)
     * $query->filterByStudyAssayId(array('min' => 12)); // WHERE study_assay_id >= 12
     * $query->filterByStudyAssayId(array('max' => 12)); // WHERE study_assay_id <= 12
     * </code>
     *
     * @param     mixed $studyAssayId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function filterByStudyAssayId($studyAssayId = null, $comparison = null)
    {
        if (is_array($studyAssayId)) {
            $useMinMax = false;
            if (isset($studyAssayId['min'])) {
                $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $studyAssayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyAssayId['max'])) {
                $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $studyAssayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $studyAssayId, $comparison);
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
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function filterByStudyId($studyId = null, $comparison = null)
    {
        if (is_array($studyId)) {
            $useMinMax = false;
            if (isset($studyId['min'])) {
                $this->addUsingAlias(StudyAssayPeer::STUDY_ID, $studyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyId['max'])) {
                $this->addUsingAlias(StudyAssayPeer::STUDY_ID, $studyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyAssayPeer::STUDY_ID, $studyId, $comparison);
    }

    /**
     * Filter the query on the assay_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAssayId(1234); // WHERE assay_id = 1234
     * $query->filterByAssayId(array(12, 34)); // WHERE assay_id IN (12, 34)
     * $query->filterByAssayId(array('min' => 12)); // WHERE assay_id >= 12
     * $query->filterByAssayId(array('max' => 12)); // WHERE assay_id <= 12
     * </code>
     *
     * @see       filterByAssay()
     *
     * @param     mixed $assayId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function filterByAssayId($assayId = null, $comparison = null)
    {
        if (is_array($assayId)) {
            $useMinMax = false;
            if (isset($assayId['min'])) {
                $this->addUsingAlias(StudyAssayPeer::ASSAY_ID, $assayId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($assayId['max'])) {
                $this->addUsingAlias(StudyAssayPeer::ASSAY_ID, $assayId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyAssayPeer::ASSAY_ID, $assayId, $comparison);
    }

    /**
     * Filter the query by a related Assay object
     *
     * @param   Assay|PropelObjectCollection $assay The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyAssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssay($assay, $comparison = null)
    {
        if ($assay instanceof Assay) {
            return $this
                ->addUsingAlias(StudyAssayPeer::ASSAY_ID, $assay->getAssayId(), $comparison);
        } elseif ($assay instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyAssayPeer::ASSAY_ID, $assay->toKeyValue('PrimaryKey', 'AssayId'), $comparison);
        } else {
            throw new PropelException('filterByAssay() only accepts arguments of type Assay or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Assay relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function joinAssay($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Assay');

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
            $this->addJoinObject($join, 'Assay');
        }

        return $this;
    }

    /**
     * Use the Assay relation Assay object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssayQuery A secondary query class using the current class as primary query
     */
    public function useAssayQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssay($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Assay', '\cli_db\propel\AssayQuery');
    }

    /**
     * Filter the query by a related Study object
     *
     * @param   Study|PropelObjectCollection $study The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyAssayQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudy($study, $comparison = null)
    {
        if ($study instanceof Study) {
            return $this
                ->addUsingAlias(StudyAssayPeer::STUDY_ID, $study->getStudyId(), $comparison);
        } elseif ($study instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyAssayPeer::STUDY_ID, $study->toKeyValue('PrimaryKey', 'StudyId'), $comparison);
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
     * @return StudyAssayQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   StudyAssay $studyAssay Object to remove from the list of results
     *
     * @return StudyAssayQuery The current query, for fluid interface
     */
    public function prune($studyAssay = null)
    {
        if ($studyAssay) {
            $this->addUsingAlias(StudyAssayPeer::STUDY_ASSAY_ID, $studyAssay->getStudyAssayId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
