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
use cli_db\propel\Analysis;
use cli_db\propel\AnalysisPeer;
use cli_db\propel\AnalysisQuery;
use cli_db\propel\Analysisfeature;
use cli_db\propel\Analysisprop;
use cli_db\propel\Expressionresult;
use cli_db\propel\Quantification;

/**
 * Base class that represents a query for the 'analysis' table.
 *
 *
 *
 * @method AnalysisQuery orderByAnalysisId($order = Criteria::ASC) Order by the analysis_id column
 * @method AnalysisQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method AnalysisQuery orderByDescription($order = Criteria::ASC) Order by the description column
 * @method AnalysisQuery orderByProgram($order = Criteria::ASC) Order by the program column
 * @method AnalysisQuery orderByProgramversion($order = Criteria::ASC) Order by the programversion column
 * @method AnalysisQuery orderByAlgorithm($order = Criteria::ASC) Order by the algorithm column
 * @method AnalysisQuery orderBySourcename($order = Criteria::ASC) Order by the sourcename column
 * @method AnalysisQuery orderBySourceversion($order = Criteria::ASC) Order by the sourceversion column
 * @method AnalysisQuery orderBySourceuri($order = Criteria::ASC) Order by the sourceuri column
 * @method AnalysisQuery orderByTimeexecuted($order = Criteria::ASC) Order by the timeexecuted column
 *
 * @method AnalysisQuery groupByAnalysisId() Group by the analysis_id column
 * @method AnalysisQuery groupByName() Group by the name column
 * @method AnalysisQuery groupByDescription() Group by the description column
 * @method AnalysisQuery groupByProgram() Group by the program column
 * @method AnalysisQuery groupByProgramversion() Group by the programversion column
 * @method AnalysisQuery groupByAlgorithm() Group by the algorithm column
 * @method AnalysisQuery groupBySourcename() Group by the sourcename column
 * @method AnalysisQuery groupBySourceversion() Group by the sourceversion column
 * @method AnalysisQuery groupBySourceuri() Group by the sourceuri column
 * @method AnalysisQuery groupByTimeexecuted() Group by the timeexecuted column
 *
 * @method AnalysisQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method AnalysisQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method AnalysisQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method AnalysisQuery leftJoinAnalysisfeature($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisfeature relation
 * @method AnalysisQuery rightJoinAnalysisfeature($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisfeature relation
 * @method AnalysisQuery innerJoinAnalysisfeature($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisfeature relation
 *
 * @method AnalysisQuery leftJoinAnalysisprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Analysisprop relation
 * @method AnalysisQuery rightJoinAnalysisprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Analysisprop relation
 * @method AnalysisQuery innerJoinAnalysisprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Analysisprop relation
 *
 * @method AnalysisQuery leftJoinExpressionresult($relationAlias = null) Adds a LEFT JOIN clause to the query using the Expressionresult relation
 * @method AnalysisQuery rightJoinExpressionresult($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Expressionresult relation
 * @method AnalysisQuery innerJoinExpressionresult($relationAlias = null) Adds a INNER JOIN clause to the query using the Expressionresult relation
 *
 * @method AnalysisQuery leftJoinQuantification($relationAlias = null) Adds a LEFT JOIN clause to the query using the Quantification relation
 * @method AnalysisQuery rightJoinQuantification($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Quantification relation
 * @method AnalysisQuery innerJoinQuantification($relationAlias = null) Adds a INNER JOIN clause to the query using the Quantification relation
 *
 * @method Analysis findOne(PropelPDO $con = null) Return the first Analysis matching the query
 * @method Analysis findOneOrCreate(PropelPDO $con = null) Return the first Analysis matching the query, or a new Analysis object populated from the query conditions when no match is found
 *
 * @method Analysis findOneByName(string $name) Return the first Analysis filtered by the name column
 * @method Analysis findOneByDescription(string $description) Return the first Analysis filtered by the description column
 * @method Analysis findOneByProgram(string $program) Return the first Analysis filtered by the program column
 * @method Analysis findOneByProgramversion(string $programversion) Return the first Analysis filtered by the programversion column
 * @method Analysis findOneByAlgorithm(string $algorithm) Return the first Analysis filtered by the algorithm column
 * @method Analysis findOneBySourcename(string $sourcename) Return the first Analysis filtered by the sourcename column
 * @method Analysis findOneBySourceversion(string $sourceversion) Return the first Analysis filtered by the sourceversion column
 * @method Analysis findOneBySourceuri(string $sourceuri) Return the first Analysis filtered by the sourceuri column
 * @method Analysis findOneByTimeexecuted(string $timeexecuted) Return the first Analysis filtered by the timeexecuted column
 *
 * @method array findByAnalysisId(int $analysis_id) Return Analysis objects filtered by the analysis_id column
 * @method array findByName(string $name) Return Analysis objects filtered by the name column
 * @method array findByDescription(string $description) Return Analysis objects filtered by the description column
 * @method array findByProgram(string $program) Return Analysis objects filtered by the program column
 * @method array findByProgramversion(string $programversion) Return Analysis objects filtered by the programversion column
 * @method array findByAlgorithm(string $algorithm) Return Analysis objects filtered by the algorithm column
 * @method array findBySourcename(string $sourcename) Return Analysis objects filtered by the sourcename column
 * @method array findBySourceversion(string $sourceversion) Return Analysis objects filtered by the sourceversion column
 * @method array findBySourceuri(string $sourceuri) Return Analysis objects filtered by the sourceuri column
 * @method array findByTimeexecuted(string $timeexecuted) Return Analysis objects filtered by the timeexecuted column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseAnalysisQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseAnalysisQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Analysis', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new AnalysisQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   AnalysisQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return AnalysisQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof AnalysisQuery) {
            return $criteria;
        }
        $query = new AnalysisQuery();
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
     * @return   Analysis|Analysis[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = AnalysisPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(AnalysisPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Analysis A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByAnalysisId($key, $con = null)
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
     * @return                 Analysis A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "analysis_id", "name", "description", "program", "programversion", "algorithm", "sourcename", "sourceversion", "sourceuri", "timeexecuted" FROM "analysis" WHERE "analysis_id" = :p0';
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
            $obj = new Analysis();
            $obj->hydrate($row);
            AnalysisPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Analysis|Analysis[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Analysis[]|mixed the list of results, formatted by the current formatter
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
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the analysis_id column
     *
     * Example usage:
     * <code>
     * $query->filterByAnalysisId(1234); // WHERE analysis_id = 1234
     * $query->filterByAnalysisId(array(12, 34)); // WHERE analysis_id IN (12, 34)
     * $query->filterByAnalysisId(array('min' => 12)); // WHERE analysis_id >= 12
     * $query->filterByAnalysisId(array('max' => 12)); // WHERE analysis_id <= 12
     * </code>
     *
     * @param     mixed $analysisId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByAnalysisId($analysisId = null, $comparison = null)
    {
        if (is_array($analysisId)) {
            $useMinMax = false;
            if (isset($analysisId['min'])) {
                $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysisId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($analysisId['max'])) {
                $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysisId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysisId, $comparison);
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
     * @return AnalysisQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AnalysisPeer::NAME, $name, $comparison);
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
     * @return AnalysisQuery The current query, for fluid interface
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

        return $this->addUsingAlias(AnalysisPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query on the program column
     *
     * Example usage:
     * <code>
     * $query->filterByProgram('fooValue');   // WHERE program = 'fooValue'
     * $query->filterByProgram('%fooValue%'); // WHERE program LIKE '%fooValue%'
     * </code>
     *
     * @param     string $program The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByProgram($program = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($program)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $program)) {
                $program = str_replace('*', '%', $program);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::PROGRAM, $program, $comparison);
    }

    /**
     * Filter the query on the programversion column
     *
     * Example usage:
     * <code>
     * $query->filterByProgramversion('fooValue');   // WHERE programversion = 'fooValue'
     * $query->filterByProgramversion('%fooValue%'); // WHERE programversion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $programversion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByProgramversion($programversion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($programversion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $programversion)) {
                $programversion = str_replace('*', '%', $programversion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::PROGRAMVERSION, $programversion, $comparison);
    }

    /**
     * Filter the query on the algorithm column
     *
     * Example usage:
     * <code>
     * $query->filterByAlgorithm('fooValue');   // WHERE algorithm = 'fooValue'
     * $query->filterByAlgorithm('%fooValue%'); // WHERE algorithm LIKE '%fooValue%'
     * </code>
     *
     * @param     string $algorithm The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByAlgorithm($algorithm = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($algorithm)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $algorithm)) {
                $algorithm = str_replace('*', '%', $algorithm);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::ALGORITHM, $algorithm, $comparison);
    }

    /**
     * Filter the query on the sourcename column
     *
     * Example usage:
     * <code>
     * $query->filterBySourcename('fooValue');   // WHERE sourcename = 'fooValue'
     * $query->filterBySourcename('%fooValue%'); // WHERE sourcename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourcename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterBySourcename($sourcename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourcename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourcename)) {
                $sourcename = str_replace('*', '%', $sourcename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::SOURCENAME, $sourcename, $comparison);
    }

    /**
     * Filter the query on the sourceversion column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceversion('fooValue');   // WHERE sourceversion = 'fooValue'
     * $query->filterBySourceversion('%fooValue%'); // WHERE sourceversion LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourceversion The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterBySourceversion($sourceversion = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourceversion)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourceversion)) {
                $sourceversion = str_replace('*', '%', $sourceversion);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::SOURCEVERSION, $sourceversion, $comparison);
    }

    /**
     * Filter the query on the sourceuri column
     *
     * Example usage:
     * <code>
     * $query->filterBySourceuri('fooValue');   // WHERE sourceuri = 'fooValue'
     * $query->filterBySourceuri('%fooValue%'); // WHERE sourceuri LIKE '%fooValue%'
     * </code>
     *
     * @param     string $sourceuri The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterBySourceuri($sourceuri = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($sourceuri)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $sourceuri)) {
                $sourceuri = str_replace('*', '%', $sourceuri);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::SOURCEURI, $sourceuri, $comparison);
    }

    /**
     * Filter the query on the timeexecuted column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeexecuted('2011-03-14'); // WHERE timeexecuted = '2011-03-14'
     * $query->filterByTimeexecuted('now'); // WHERE timeexecuted = '2011-03-14'
     * $query->filterByTimeexecuted(array('max' => 'yesterday')); // WHERE timeexecuted > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeexecuted The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function filterByTimeexecuted($timeexecuted = null, $comparison = null)
    {
        if (is_array($timeexecuted)) {
            $useMinMax = false;
            if (isset($timeexecuted['min'])) {
                $this->addUsingAlias(AnalysisPeer::TIMEEXECUTED, $timeexecuted['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeexecuted['max'])) {
                $this->addUsingAlias(AnalysisPeer::TIMEEXECUTED, $timeexecuted['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(AnalysisPeer::TIMEEXECUTED, $timeexecuted, $comparison);
    }

    /**
     * Filter the query by a related Analysisfeature object
     *
     * @param   Analysisfeature|PropelObjectCollection $analysisfeature  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisfeature($analysisfeature, $comparison = null)
    {
        if ($analysisfeature instanceof Analysisfeature) {
            return $this
                ->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysisfeature->getAnalysisId(), $comparison);
        } elseif ($analysisfeature instanceof PropelObjectCollection) {
            return $this
                ->useAnalysisfeatureQuery()
                ->filterByPrimaryKeys($analysisfeature->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnalysisfeature() only accepts arguments of type Analysisfeature or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisfeature relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function joinAnalysisfeature($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisfeature');

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
            $this->addJoinObject($join, 'Analysisfeature');
        }

        return $this;
    }

    /**
     * Use the Analysisfeature relation Analysisfeature object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysisfeatureQuery A secondary query class using the current class as primary query
     */
    public function useAnalysisfeatureQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisfeature($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisfeature', '\cli_db\propel\AnalysisfeatureQuery');
    }

    /**
     * Filter the query by a related Analysisprop object
     *
     * @param   Analysisprop|PropelObjectCollection $analysisprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAnalysisprop($analysisprop, $comparison = null)
    {
        if ($analysisprop instanceof Analysisprop) {
            return $this
                ->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysisprop->getAnalysisId(), $comparison);
        } elseif ($analysisprop instanceof PropelObjectCollection) {
            return $this
                ->useAnalysispropQuery()
                ->filterByPrimaryKeys($analysisprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAnalysisprop() only accepts arguments of type Analysisprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Analysisprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function joinAnalysisprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Analysisprop');

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
            $this->addJoinObject($join, 'Analysisprop');
        }

        return $this;
    }

    /**
     * Use the Analysisprop relation Analysisprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AnalysispropQuery A secondary query class using the current class as primary query
     */
    public function useAnalysispropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAnalysisprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Analysisprop', '\cli_db\propel\AnalysispropQuery');
    }

    /**
     * Filter the query by a related Expressionresult object
     *
     * @param   Expressionresult|PropelObjectCollection $expressionresult  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByExpressionresult($expressionresult, $comparison = null)
    {
        if ($expressionresult instanceof Expressionresult) {
            return $this
                ->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $expressionresult->getAnalysisId(), $comparison);
        } elseif ($expressionresult instanceof PropelObjectCollection) {
            return $this
                ->useExpressionresultQuery()
                ->filterByPrimaryKeys($expressionresult->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByExpressionresult() only accepts arguments of type Expressionresult or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Expressionresult relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function joinExpressionresult($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Expressionresult');

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
            $this->addJoinObject($join, 'Expressionresult');
        }

        return $this;
    }

    /**
     * Use the Expressionresult relation Expressionresult object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ExpressionresultQuery A secondary query class using the current class as primary query
     */
    public function useExpressionresultQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinExpressionresult($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Expressionresult', '\cli_db\propel\ExpressionresultQuery');
    }

    /**
     * Filter the query by a related Quantification object
     *
     * @param   Quantification|PropelObjectCollection $quantification  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 AnalysisQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByQuantification($quantification, $comparison = null)
    {
        if ($quantification instanceof Quantification) {
            return $this
                ->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $quantification->getAnalysisId(), $comparison);
        } elseif ($quantification instanceof PropelObjectCollection) {
            return $this
                ->useQuantificationQuery()
                ->filterByPrimaryKeys($quantification->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByQuantification() only accepts arguments of type Quantification or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Quantification relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function joinQuantification($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Quantification');

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
            $this->addJoinObject($join, 'Quantification');
        }

        return $this;
    }

    /**
     * Use the Quantification relation Quantification object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\QuantificationQuery A secondary query class using the current class as primary query
     */
    public function useQuantificationQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinQuantification($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Quantification', '\cli_db\propel\QuantificationQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Analysis $analysis Object to remove from the list of results
     *
     * @return AnalysisQuery The current query, for fluid interface
     */
    public function prune($analysis = null)
    {
        if ($analysis) {
            $this->addUsingAlias(AnalysisPeer::ANALYSIS_ID, $analysis->getAnalysisId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
