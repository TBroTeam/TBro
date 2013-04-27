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
use cli_db\propel\Project;
use cli_db\propel\ProjectRelationship;
use cli_db\propel\ProjectRelationshipPeer;
use cli_db\propel\ProjectRelationshipQuery;

/**
 * Base class that represents a query for the 'project_relationship' table.
 *
 *
 *
 * @method ProjectRelationshipQuery orderByProjectRelationshipId($order = Criteria::ASC) Order by the project_relationship_id column
 * @method ProjectRelationshipQuery orderBySubjectProjectId($order = Criteria::ASC) Order by the subject_project_id column
 * @method ProjectRelationshipQuery orderByObjectProjectId($order = Criteria::ASC) Order by the object_project_id column
 * @method ProjectRelationshipQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 *
 * @method ProjectRelationshipQuery groupByProjectRelationshipId() Group by the project_relationship_id column
 * @method ProjectRelationshipQuery groupBySubjectProjectId() Group by the subject_project_id column
 * @method ProjectRelationshipQuery groupByObjectProjectId() Group by the object_project_id column
 * @method ProjectRelationshipQuery groupByTypeId() Group by the type_id column
 *
 * @method ProjectRelationshipQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectRelationshipQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectRelationshipQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectRelationshipQuery leftJoinProjectRelatedByObjectProjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectRelatedByObjectProjectId relation
 * @method ProjectRelationshipQuery rightJoinProjectRelatedByObjectProjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectRelatedByObjectProjectId relation
 * @method ProjectRelationshipQuery innerJoinProjectRelatedByObjectProjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectRelatedByObjectProjectId relation
 *
 * @method ProjectRelationshipQuery leftJoinProjectRelatedBySubjectProjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectRelatedBySubjectProjectId relation
 * @method ProjectRelationshipQuery rightJoinProjectRelatedBySubjectProjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectRelatedBySubjectProjectId relation
 * @method ProjectRelationshipQuery innerJoinProjectRelatedBySubjectProjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectRelatedBySubjectProjectId relation
 *
 * @method ProjectRelationshipQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method ProjectRelationshipQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method ProjectRelationshipQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method ProjectRelationship findOne(PropelPDO $con = null) Return the first ProjectRelationship matching the query
 * @method ProjectRelationship findOneOrCreate(PropelPDO $con = null) Return the first ProjectRelationship matching the query, or a new ProjectRelationship object populated from the query conditions when no match is found
 *
 * @method ProjectRelationship findOneBySubjectProjectId(int $subject_project_id) Return the first ProjectRelationship filtered by the subject_project_id column
 * @method ProjectRelationship findOneByObjectProjectId(int $object_project_id) Return the first ProjectRelationship filtered by the object_project_id column
 * @method ProjectRelationship findOneByTypeId(int $type_id) Return the first ProjectRelationship filtered by the type_id column
 *
 * @method array findByProjectRelationshipId(int $project_relationship_id) Return ProjectRelationship objects filtered by the project_relationship_id column
 * @method array findBySubjectProjectId(int $subject_project_id) Return ProjectRelationship objects filtered by the subject_project_id column
 * @method array findByObjectProjectId(int $object_project_id) Return ProjectRelationship objects filtered by the object_project_id column
 * @method array findByTypeId(int $type_id) Return ProjectRelationship objects filtered by the type_id column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProjectRelationshipQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectRelationshipQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\ProjectRelationship', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectRelationshipQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectRelationshipQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectRelationshipQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectRelationshipQuery) {
            return $criteria;
        }
        $query = new ProjectRelationshipQuery();
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
     * @return   ProjectRelationship|ProjectRelationship[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectRelationshipPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectRelationshipPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 ProjectRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByProjectRelationshipId($key, $con = null)
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
     * @return                 ProjectRelationship A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "project_relationship_id", "subject_project_id", "object_project_id", "type_id" FROM "project_relationship" WHERE "project_relationship_id" = :p0';
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
            $obj = new ProjectRelationship();
            $obj->hydrate($row);
            ProjectRelationshipPeer::addInstanceToPool($obj, (string) $key);
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
     * @return ProjectRelationship|ProjectRelationship[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|ProjectRelationship[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the project_relationship_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectRelationshipId(1234); // WHERE project_relationship_id = 1234
     * $query->filterByProjectRelationshipId(array(12, 34)); // WHERE project_relationship_id IN (12, 34)
     * $query->filterByProjectRelationshipId(array('min' => 12)); // WHERE project_relationship_id >= 12
     * $query->filterByProjectRelationshipId(array('max' => 12)); // WHERE project_relationship_id <= 12
     * </code>
     *
     * @param     mixed $projectRelationshipId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterByProjectRelationshipId($projectRelationshipId = null, $comparison = null)
    {
        if (is_array($projectRelationshipId)) {
            $useMinMax = false;
            if (isset($projectRelationshipId['min'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $projectRelationshipId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectRelationshipId['max'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $projectRelationshipId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $projectRelationshipId, $comparison);
    }

    /**
     * Filter the query on the subject_project_id column
     *
     * Example usage:
     * <code>
     * $query->filterBySubjectProjectId(1234); // WHERE subject_project_id = 1234
     * $query->filterBySubjectProjectId(array(12, 34)); // WHERE subject_project_id IN (12, 34)
     * $query->filterBySubjectProjectId(array('min' => 12)); // WHERE subject_project_id >= 12
     * $query->filterBySubjectProjectId(array('max' => 12)); // WHERE subject_project_id <= 12
     * </code>
     *
     * @see       filterByProjectRelatedBySubjectProjectId()
     *
     * @param     mixed $subjectProjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterBySubjectProjectId($subjectProjectId = null, $comparison = null)
    {
        if (is_array($subjectProjectId)) {
            $useMinMax = false;
            if (isset($subjectProjectId['min'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::SUBJECT_PROJECT_ID, $subjectProjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($subjectProjectId['max'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::SUBJECT_PROJECT_ID, $subjectProjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectRelationshipPeer::SUBJECT_PROJECT_ID, $subjectProjectId, $comparison);
    }

    /**
     * Filter the query on the object_project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByObjectProjectId(1234); // WHERE object_project_id = 1234
     * $query->filterByObjectProjectId(array(12, 34)); // WHERE object_project_id IN (12, 34)
     * $query->filterByObjectProjectId(array('min' => 12)); // WHERE object_project_id >= 12
     * $query->filterByObjectProjectId(array('max' => 12)); // WHERE object_project_id <= 12
     * </code>
     *
     * @see       filterByProjectRelatedByObjectProjectId()
     *
     * @param     mixed $objectProjectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterByObjectProjectId($objectProjectId = null, $comparison = null)
    {
        if (is_array($objectProjectId)) {
            $useMinMax = false;
            if (isset($objectProjectId['min'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::OBJECT_PROJECT_ID, $objectProjectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($objectProjectId['max'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::OBJECT_PROJECT_ID, $objectProjectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectRelationshipPeer::OBJECT_PROJECT_ID, $objectProjectId, $comparison);
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
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(ProjectRelationshipPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectRelationshipPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectRelatedByObjectProjectId($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectRelationshipPeer::OBJECT_PROJECT_ID, $project->getProjectId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectRelationshipPeer::OBJECT_PROJECT_ID, $project->toKeyValue('PrimaryKey', 'ProjectId'), $comparison);
        } else {
            throw new PropelException('filterByProjectRelatedByObjectProjectId() only accepts arguments of type Project or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectRelatedByObjectProjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function joinProjectRelatedByObjectProjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectRelatedByObjectProjectId');

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
            $this->addJoinObject($join, 'ProjectRelatedByObjectProjectId');
        }

        return $this;
    }

    /**
     * Use the ProjectRelatedByObjectProjectId relation Project object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectRelatedByObjectProjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectRelatedByObjectProjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectRelatedByObjectProjectId', '\cli_db\propel\ProjectQuery');
    }

    /**
     * Filter the query by a related Project object
     *
     * @param   Project|PropelObjectCollection $project The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectRelatedBySubjectProjectId($project, $comparison = null)
    {
        if ($project instanceof Project) {
            return $this
                ->addUsingAlias(ProjectRelationshipPeer::SUBJECT_PROJECT_ID, $project->getProjectId(), $comparison);
        } elseif ($project instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectRelationshipPeer::SUBJECT_PROJECT_ID, $project->toKeyValue('PrimaryKey', 'ProjectId'), $comparison);
        } else {
            throw new PropelException('filterByProjectRelatedBySubjectProjectId() only accepts arguments of type Project or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectRelatedBySubjectProjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function joinProjectRelatedBySubjectProjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectRelatedBySubjectProjectId');

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
            $this->addJoinObject($join, 'ProjectRelatedBySubjectProjectId');
        }

        return $this;
    }

    /**
     * Use the ProjectRelatedBySubjectProjectId relation Project object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectQuery A secondary query class using the current class as primary query
     */
    public function useProjectRelatedBySubjectProjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectRelatedBySubjectProjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectRelatedBySubjectProjectId', '\cli_db\propel\ProjectQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectRelationshipQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(ProjectRelationshipPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(ProjectRelationshipPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return ProjectRelationshipQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   ProjectRelationship $projectRelationship Object to remove from the list of results
     *
     * @return ProjectRelationshipQuery The current query, for fluid interface
     */
    public function prune($projectRelationship = null)
    {
        if ($projectRelationship) {
            $this->addUsingAlias(ProjectRelationshipPeer::PROJECT_RELATIONSHIP_ID, $projectRelationship->getProjectRelationshipId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
