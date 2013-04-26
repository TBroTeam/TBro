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
use cli_db\propel\AssayProject;
use cli_db\propel\Project;
use cli_db\propel\ProjectContact;
use cli_db\propel\ProjectPeer;
use cli_db\propel\ProjectPub;
use cli_db\propel\ProjectQuery;
use cli_db\propel\ProjectRelationship;
use cli_db\propel\Projectprop;

/**
 * Base class that represents a query for the 'project' table.
 *
 *
 *
 * @method ProjectQuery orderByProjectId($order = Criteria::ASC) Order by the project_id column
 * @method ProjectQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method ProjectQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method ProjectQuery groupByProjectId() Group by the project_id column
 * @method ProjectQuery groupByName() Group by the name column
 * @method ProjectQuery groupByDescription() Group by the description column
 *
 * @method ProjectQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method ProjectQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method ProjectQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method ProjectQuery leftJoinAssayProject($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssayProject relation
 * @method ProjectQuery rightJoinAssayProject($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssayProject relation
 * @method ProjectQuery innerJoinAssayProject($relationAlias = null) Adds a INNER JOIN clause to the query using the AssayProject relation
 *
 * @method ProjectQuery leftJoinProjectContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectContact relation
 * @method ProjectQuery rightJoinProjectContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectContact relation
 * @method ProjectQuery innerJoinProjectContact($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectContact relation
 *
 * @method ProjectQuery leftJoinProjectPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectPub relation
 * @method ProjectQuery rightJoinProjectPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectPub relation
 * @method ProjectQuery innerJoinProjectPub($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectPub relation
 *
 * @method ProjectQuery leftJoinProjectRelationshipRelatedByObjectProjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectRelationshipRelatedByObjectProjectId relation
 * @method ProjectQuery rightJoinProjectRelationshipRelatedByObjectProjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectRelationshipRelatedByObjectProjectId relation
 * @method ProjectQuery innerJoinProjectRelationshipRelatedByObjectProjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectRelationshipRelatedByObjectProjectId relation
 *
 * @method ProjectQuery leftJoinProjectRelationshipRelatedBySubjectProjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the ProjectRelationshipRelatedBySubjectProjectId relation
 * @method ProjectQuery rightJoinProjectRelationshipRelatedBySubjectProjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the ProjectRelationshipRelatedBySubjectProjectId relation
 * @method ProjectQuery innerJoinProjectRelationshipRelatedBySubjectProjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the ProjectRelationshipRelatedBySubjectProjectId relation
 *
 * @method ProjectQuery leftJoinProjectprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Projectprop relation
 * @method ProjectQuery rightJoinProjectprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Projectprop relation
 * @method ProjectQuery innerJoinProjectprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Projectprop relation
 *
 * @method Project findOne(PropelPDO $con = null) Return the first Project matching the query
 * @method Project findOneOrCreate(PropelPDO $con = null) Return the first Project matching the query, or a new Project object populated from the query conditions when no match is found
 *
 * @method Project findOneByName(string $name) Return the first Project filtered by the name column
 * @method Project findOneByDescription(string $description) Return the first Project filtered by the description column
 *
 * @method array findByProjectId(int $project_id) Return Project objects filtered by the project_id column
 * @method array findByName(string $name) Return Project objects filtered by the name column
 * @method array findByDescription(string $description) Return Project objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseProjectQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseProjectQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Project', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new ProjectQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   ProjectQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return ProjectQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof ProjectQuery) {
            return $criteria;
        }
        $query = new ProjectQuery();
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
     * @return   Project|Project[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = ProjectPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(ProjectPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Project A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByProjectId($key, $con = null)
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
     * @return                 Project A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "project_id", "name", "description" FROM "project" WHERE "project_id" = :p0';
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
            $obj = new Project();
            $obj->hydrate($row);
            ProjectPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Project|Project[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Project[]|mixed the list of results, formatted by the current formatter
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
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(ProjectPeer::PROJECT_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(ProjectPeer::PROJECT_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the project_id column
     *
     * Example usage:
     * <code>
     * $query->filterByProjectId(1234); // WHERE project_id = 1234
     * $query->filterByProjectId(array(12, 34)); // WHERE project_id IN (12, 34)
     * $query->filterByProjectId(array('min' => 12)); // WHERE project_id >= 12
     * $query->filterByProjectId(array('max' => 12)); // WHERE project_id <= 12
     * </code>
     *
     * @param     mixed $projectId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function filterByProjectId($projectId = null, $comparison = null)
    {
        if (is_array($projectId)) {
            $useMinMax = false;
            if (isset($projectId['min'])) {
                $this->addUsingAlias(ProjectPeer::PROJECT_ID, $projectId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($projectId['max'])) {
                $this->addUsingAlias(ProjectPeer::PROJECT_ID, $projectId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(ProjectPeer::PROJECT_ID, $projectId, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::NAME, $name, $comparison);
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
     * @return ProjectQuery The current query, for fluid interface
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

        return $this->addUsingAlias(ProjectPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related AssayProject object
     *
     * @param   AssayProject|PropelObjectCollection $assayProject  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssayProject($assayProject, $comparison = null)
    {
        if ($assayProject instanceof AssayProject) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $assayProject->getProjectId(), $comparison);
        } elseif ($assayProject instanceof PropelObjectCollection) {
            return $this
                ->useAssayProjectQuery()
                ->filterByPrimaryKeys($assayProject->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssayProject() only accepts arguments of type AssayProject or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssayProject relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinAssayProject($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssayProject');

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
            $this->addJoinObject($join, 'AssayProject');
        }

        return $this;
    }

    /**
     * Use the AssayProject relation AssayProject object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssayProjectQuery A secondary query class using the current class as primary query
     */
    public function useAssayProjectQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssayProject($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssayProject', '\cli_db\propel\AssayProjectQuery');
    }

    /**
     * Filter the query by a related ProjectContact object
     *
     * @param   ProjectContact|PropelObjectCollection $projectContact  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectContact($projectContact, $comparison = null)
    {
        if ($projectContact instanceof ProjectContact) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $projectContact->getProjectId(), $comparison);
        } elseif ($projectContact instanceof PropelObjectCollection) {
            return $this
                ->useProjectContactQuery()
                ->filterByPrimaryKeys($projectContact->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectContact() only accepts arguments of type ProjectContact or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectContact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectContact($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectContact');

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
            $this->addJoinObject($join, 'ProjectContact');
        }

        return $this;
    }

    /**
     * Use the ProjectContact relation ProjectContact object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectContactQuery A secondary query class using the current class as primary query
     */
    public function useProjectContactQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectContact', '\cli_db\propel\ProjectContactQuery');
    }

    /**
     * Filter the query by a related ProjectPub object
     *
     * @param   ProjectPub|PropelObjectCollection $projectPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectPub($projectPub, $comparison = null)
    {
        if ($projectPub instanceof ProjectPub) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $projectPub->getProjectId(), $comparison);
        } elseif ($projectPub instanceof PropelObjectCollection) {
            return $this
                ->useProjectPubQuery()
                ->filterByPrimaryKeys($projectPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectPub() only accepts arguments of type ProjectPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectPub');

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
            $this->addJoinObject($join, 'ProjectPub');
        }

        return $this;
    }

    /**
     * Use the ProjectPub relation ProjectPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectPubQuery A secondary query class using the current class as primary query
     */
    public function useProjectPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectPub', '\cli_db\propel\ProjectPubQuery');
    }

    /**
     * Filter the query by a related ProjectRelationship object
     *
     * @param   ProjectRelationship|PropelObjectCollection $projectRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectRelationshipRelatedByObjectProjectId($projectRelationship, $comparison = null)
    {
        if ($projectRelationship instanceof ProjectRelationship) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $projectRelationship->getObjectProjectId(), $comparison);
        } elseif ($projectRelationship instanceof PropelObjectCollection) {
            return $this
                ->useProjectRelationshipRelatedByObjectProjectIdQuery()
                ->filterByPrimaryKeys($projectRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectRelationshipRelatedByObjectProjectId() only accepts arguments of type ProjectRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectRelationshipRelatedByObjectProjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectRelationshipRelatedByObjectProjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectRelationshipRelatedByObjectProjectId');

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
            $this->addJoinObject($join, 'ProjectRelationshipRelatedByObjectProjectId');
        }

        return $this;
    }

    /**
     * Use the ProjectRelationshipRelatedByObjectProjectId relation ProjectRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useProjectRelationshipRelatedByObjectProjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectRelationshipRelatedByObjectProjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectRelationshipRelatedByObjectProjectId', '\cli_db\propel\ProjectRelationshipQuery');
    }

    /**
     * Filter the query by a related ProjectRelationship object
     *
     * @param   ProjectRelationship|PropelObjectCollection $projectRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectRelationshipRelatedBySubjectProjectId($projectRelationship, $comparison = null)
    {
        if ($projectRelationship instanceof ProjectRelationship) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $projectRelationship->getSubjectProjectId(), $comparison);
        } elseif ($projectRelationship instanceof PropelObjectCollection) {
            return $this
                ->useProjectRelationshipRelatedBySubjectProjectIdQuery()
                ->filterByPrimaryKeys($projectRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectRelationshipRelatedBySubjectProjectId() only accepts arguments of type ProjectRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the ProjectRelationshipRelatedBySubjectProjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectRelationshipRelatedBySubjectProjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('ProjectRelationshipRelatedBySubjectProjectId');

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
            $this->addJoinObject($join, 'ProjectRelationshipRelatedBySubjectProjectId');
        }

        return $this;
    }

    /**
     * Use the ProjectRelationshipRelatedBySubjectProjectId relation ProjectRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useProjectRelationshipRelatedBySubjectProjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectRelationshipRelatedBySubjectProjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'ProjectRelationshipRelatedBySubjectProjectId', '\cli_db\propel\ProjectRelationshipQuery');
    }

    /**
     * Filter the query by a related Projectprop object
     *
     * @param   Projectprop|PropelObjectCollection $projectprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 ProjectQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByProjectprop($projectprop, $comparison = null)
    {
        if ($projectprop instanceof Projectprop) {
            return $this
                ->addUsingAlias(ProjectPeer::PROJECT_ID, $projectprop->getProjectId(), $comparison);
        } elseif ($projectprop instanceof PropelObjectCollection) {
            return $this
                ->useProjectpropQuery()
                ->filterByPrimaryKeys($projectprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByProjectprop() only accepts arguments of type Projectprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Projectprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function joinProjectprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Projectprop');

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
            $this->addJoinObject($join, 'Projectprop');
        }

        return $this;
    }

    /**
     * Use the Projectprop relation Projectprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ProjectpropQuery A secondary query class using the current class as primary query
     */
    public function useProjectpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinProjectprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Projectprop', '\cli_db\propel\ProjectpropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Project $project Object to remove from the list of results
     *
     * @return ProjectQuery The current query, for fluid interface
     */
    public function prune($project = null)
    {
        if ($project) {
            $this->addUsingAlias(ProjectPeer::PROJECT_ID, $project->getProjectId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
