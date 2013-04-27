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
use cli_db\propel\Studydesign;
use cli_db\propel\Studyfactor;
use cli_db\propel\StudyfactorPeer;
use cli_db\propel\StudyfactorQuery;
use cli_db\propel\Studyfactorvalue;

/**
 * Base class that represents a query for the 'studyfactor' table.
 *
 *
 *
 * @method StudyfactorQuery orderByStudyfactorId($order = Criteria::ASC) Order by the studyfactor_id column
 * @method StudyfactorQuery orderByStudydesignId($order = Criteria::ASC) Order by the studydesign_id column
 * @method StudyfactorQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method StudyfactorQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method StudyfactorQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method StudyfactorQuery groupByStudyfactorId() Group by the studyfactor_id column
 * @method StudyfactorQuery groupByStudydesignId() Group by the studydesign_id column
 * @method StudyfactorQuery groupByTypeId() Group by the type_id column
 * @method StudyfactorQuery groupByName() Group by the name column
 * @method StudyfactorQuery groupByDescription() Group by the description column
 *
 * @method StudyfactorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudyfactorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudyfactorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudyfactorQuery leftJoinStudydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studydesign relation
 * @method StudyfactorQuery rightJoinStudydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studydesign relation
 * @method StudyfactorQuery innerJoinStudydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Studydesign relation
 *
 * @method StudyfactorQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method StudyfactorQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method StudyfactorQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method StudyfactorQuery leftJoinStudyfactorvalue($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyfactorvalue relation
 * @method StudyfactorQuery rightJoinStudyfactorvalue($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyfactorvalue relation
 * @method StudyfactorQuery innerJoinStudyfactorvalue($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyfactorvalue relation
 *
 * @method Studyfactor findOne(PropelPDO $con = null) Return the first Studyfactor matching the query
 * @method Studyfactor findOneOrCreate(PropelPDO $con = null) Return the first Studyfactor matching the query, or a new Studyfactor object populated from the query conditions when no match is found
 *
 * @method Studyfactor findOneByStudydesignId(int $studydesign_id) Return the first Studyfactor filtered by the studydesign_id column
 * @method Studyfactor findOneByTypeId(int $type_id) Return the first Studyfactor filtered by the type_id column
 * @method Studyfactor findOneByName(string $name) Return the first Studyfactor filtered by the name column
 * @method Studyfactor findOneByDescription(string $description) Return the first Studyfactor filtered by the description column
 *
 * @method array findByStudyfactorId(int $studyfactor_id) Return Studyfactor objects filtered by the studyfactor_id column
 * @method array findByStudydesignId(int $studydesign_id) Return Studyfactor objects filtered by the studydesign_id column
 * @method array findByTypeId(int $type_id) Return Studyfactor objects filtered by the type_id column
 * @method array findByName(string $name) Return Studyfactor objects filtered by the name column
 * @method array findByDescription(string $description) Return Studyfactor objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyfactorQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudyfactorQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Studyfactor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudyfactorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudyfactorQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudyfactorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudyfactorQuery) {
            return $criteria;
        }
        $query = new StudyfactorQuery();
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
     * @return   Studyfactor|Studyfactor[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudyfactorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudyfactorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Studyfactor A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudyfactorId($key, $con = null)
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
     * @return                 Studyfactor A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "studyfactor_id", "studydesign_id", "type_id", "name", "description" FROM "studyfactor" WHERE "studyfactor_id" = :p0';
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
            $obj = new Studyfactor();
            $obj->hydrate($row);
            StudyfactorPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Studyfactor|Studyfactor[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Studyfactor[]|mixed the list of results, formatted by the current formatter
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
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the studyfactor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByStudyfactorId(1234); // WHERE studyfactor_id = 1234
     * $query->filterByStudyfactorId(array(12, 34)); // WHERE studyfactor_id IN (12, 34)
     * $query->filterByStudyfactorId(array('min' => 12)); // WHERE studyfactor_id >= 12
     * $query->filterByStudyfactorId(array('max' => 12)); // WHERE studyfactor_id <= 12
     * </code>
     *
     * @param     mixed $studyfactorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function filterByStudyfactorId($studyfactorId = null, $comparison = null)
    {
        if (is_array($studyfactorId)) {
            $useMinMax = false;
            if (isset($studyfactorId['min'])) {
                $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $studyfactorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyfactorId['max'])) {
                $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $studyfactorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $studyfactorId, $comparison);
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
     * @see       filterByStudydesign()
     *
     * @param     mixed $studydesignId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function filterByStudydesignId($studydesignId = null, $comparison = null)
    {
        if (is_array($studydesignId)) {
            $useMinMax = false;
            if (isset($studydesignId['min'])) {
                $this->addUsingAlias(StudyfactorPeer::STUDYDESIGN_ID, $studydesignId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studydesignId['max'])) {
                $this->addUsingAlias(StudyfactorPeer::STUDYDESIGN_ID, $studydesignId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorPeer::STUDYDESIGN_ID, $studydesignId, $comparison);
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
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(StudyfactorPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(StudyfactorPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyfactorPeer::TYPE_ID, $typeId, $comparison);
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
     * @return StudyfactorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudyfactorPeer::NAME, $name, $comparison);
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
     * @return StudyfactorQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudyfactorPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Studydesign object
     *
     * @param   Studydesign|PropelObjectCollection $studydesign The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyfactorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudydesign($studydesign, $comparison = null)
    {
        if ($studydesign instanceof Studydesign) {
            return $this
                ->addUsingAlias(StudyfactorPeer::STUDYDESIGN_ID, $studydesign->getStudydesignId(), $comparison);
        } elseif ($studydesign instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyfactorPeer::STUDYDESIGN_ID, $studydesign->toKeyValue('PrimaryKey', 'StudydesignId'), $comparison);
        } else {
            throw new PropelException('filterByStudydesign() only accepts arguments of type Studydesign or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studydesign relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function joinStudydesign($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studydesign');

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
            $this->addJoinObject($join, 'Studydesign');
        }

        return $this;
    }

    /**
     * Use the Studydesign relation Studydesign object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudydesignQuery A secondary query class using the current class as primary query
     */
    public function useStudydesignQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudydesign($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studydesign', '\cli_db\propel\StudydesignQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyfactorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(StudyfactorPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyfactorPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return StudyfactorQuery The current query, for fluid interface
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
     * Filter the query by a related Studyfactorvalue object
     *
     * @param   Studyfactorvalue|PropelObjectCollection $studyfactorvalue  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyfactorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyfactorvalue($studyfactorvalue, $comparison = null)
    {
        if ($studyfactorvalue instanceof Studyfactorvalue) {
            return $this
                ->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $studyfactorvalue->getStudyfactorId(), $comparison);
        } elseif ($studyfactorvalue instanceof PropelObjectCollection) {
            return $this
                ->useStudyfactorvalueQuery()
                ->filterByPrimaryKeys($studyfactorvalue->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyfactorvalue() only accepts arguments of type Studyfactorvalue or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyfactorvalue relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function joinStudyfactorvalue($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyfactorvalue');

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
            $this->addJoinObject($join, 'Studyfactorvalue');
        }

        return $this;
    }

    /**
     * Use the Studyfactorvalue relation Studyfactorvalue object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyfactorvalueQuery A secondary query class using the current class as primary query
     */
    public function useStudyfactorvalueQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyfactorvalue($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyfactorvalue', '\cli_db\propel\StudyfactorvalueQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Studyfactor $studyfactor Object to remove from the list of results
     *
     * @return StudyfactorQuery The current query, for fluid interface
     */
    public function prune($studyfactor = null)
    {
        if ($studyfactor) {
            $this->addUsingAlias(StudyfactorPeer::STUDYFACTOR_ID, $studyfactor->getStudyfactorId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
