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
use cli_db\propel\Biomaterial;
use cli_db\propel\Organism;
use cli_db\propel\OrganismPeer;
use cli_db\propel\OrganismQuery;

/**
 * Base class that represents a query for the 'organism' table.
 *
 *
 *
 * @method OrganismQuery orderByOrganismId($order = Criteria::ASC) Order by the organism_id column
 * @method OrganismQuery orderByAbbreviation($order = Criteria::ASC) Order by the abbreviation column
 * @method OrganismQuery orderByGenus($order = Criteria::ASC) Order by the genus column
 * @method OrganismQuery orderBySpecies($order = Criteria::ASC) Order by the species column
 * @method OrganismQuery orderByCommonName($order = Criteria::ASC) Order by the common_name column
 * @method OrganismQuery orderByComment($order = Criteria::ASC) Order by the comment column
 *
 * @method OrganismQuery groupByOrganismId() Group by the organism_id column
 * @method OrganismQuery groupByAbbreviation() Group by the abbreviation column
 * @method OrganismQuery groupByGenus() Group by the genus column
 * @method OrganismQuery groupBySpecies() Group by the species column
 * @method OrganismQuery groupByCommonName() Group by the common_name column
 * @method OrganismQuery groupByComment() Group by the comment column
 *
 * @method OrganismQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method OrganismQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method OrganismQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method OrganismQuery leftJoinBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterial relation
 * @method OrganismQuery rightJoinBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterial relation
 * @method OrganismQuery innerJoinBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterial relation
 *
 * @method Organism findOne(PropelPDO $con = null) Return the first Organism matching the query
 * @method Organism findOneOrCreate(PropelPDO $con = null) Return the first Organism matching the query, or a new Organism object populated from the query conditions when no match is found
 *
 * @method Organism findOneByAbbreviation(string $abbreviation) Return the first Organism filtered by the abbreviation column
 * @method Organism findOneByGenus(string $genus) Return the first Organism filtered by the genus column
 * @method Organism findOneBySpecies(string $species) Return the first Organism filtered by the species column
 * @method Organism findOneByCommonName(string $common_name) Return the first Organism filtered by the common_name column
 * @method Organism findOneByComment(string $comment) Return the first Organism filtered by the comment column
 *
 * @method array findByOrganismId(int $organism_id) Return Organism objects filtered by the organism_id column
 * @method array findByAbbreviation(string $abbreviation) Return Organism objects filtered by the abbreviation column
 * @method array findByGenus(string $genus) Return Organism objects filtered by the genus column
 * @method array findBySpecies(string $species) Return Organism objects filtered by the species column
 * @method array findByCommonName(string $common_name) Return Organism objects filtered by the common_name column
 * @method array findByComment(string $comment) Return Organism objects filtered by the comment column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseOrganismQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseOrganismQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Organism', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new OrganismQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   OrganismQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return OrganismQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof OrganismQuery) {
            return $criteria;
        }
        $query = new OrganismQuery();
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
     * @return   Organism|Organism[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = OrganismPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(OrganismPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Organism A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByOrganismId($key, $con = null)
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
     * @return                 Organism A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "organism_id", "abbreviation", "genus", "species", "common_name", "comment" FROM "organism" WHERE "organism_id" = :p0';
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
            $obj = new Organism();
            $obj->hydrate($row);
            OrganismPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Organism|Organism[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Organism[]|mixed the list of results, formatted by the current formatter
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
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the organism_id column
     *
     * Example usage:
     * <code>
     * $query->filterByOrganismId(1234); // WHERE organism_id = 1234
     * $query->filterByOrganismId(array(12, 34)); // WHERE organism_id IN (12, 34)
     * $query->filterByOrganismId(array('min' => 12)); // WHERE organism_id >= 12
     * $query->filterByOrganismId(array('max' => 12)); // WHERE organism_id <= 12
     * </code>
     *
     * @param     mixed $organismId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByOrganismId($organismId = null, $comparison = null)
    {
        if (is_array($organismId)) {
            $useMinMax = false;
            if (isset($organismId['min'])) {
                $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $organismId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismId['max'])) {
                $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $organismId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $organismId, $comparison);
    }

    /**
     * Filter the query on the abbreviation column
     *
     * Example usage:
     * <code>
     * $query->filterByAbbreviation('fooValue');   // WHERE abbreviation = 'fooValue'
     * $query->filterByAbbreviation('%fooValue%'); // WHERE abbreviation LIKE '%fooValue%'
     * </code>
     *
     * @param     string $abbreviation The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByAbbreviation($abbreviation = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($abbreviation)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $abbreviation)) {
                $abbreviation = str_replace('*', '%', $abbreviation);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrganismPeer::ABBREVIATION, $abbreviation, $comparison);
    }

    /**
     * Filter the query on the genus column
     *
     * Example usage:
     * <code>
     * $query->filterByGenus('fooValue');   // WHERE genus = 'fooValue'
     * $query->filterByGenus('%fooValue%'); // WHERE genus LIKE '%fooValue%'
     * </code>
     *
     * @param     string $genus The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByGenus($genus = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($genus)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $genus)) {
                $genus = str_replace('*', '%', $genus);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrganismPeer::GENUS, $genus, $comparison);
    }

    /**
     * Filter the query on the species column
     *
     * Example usage:
     * <code>
     * $query->filterBySpecies('fooValue');   // WHERE species = 'fooValue'
     * $query->filterBySpecies('%fooValue%'); // WHERE species LIKE '%fooValue%'
     * </code>
     *
     * @param     string $species The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterBySpecies($species = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($species)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $species)) {
                $species = str_replace('*', '%', $species);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrganismPeer::SPECIES, $species, $comparison);
    }

    /**
     * Filter the query on the common_name column
     *
     * Example usage:
     * <code>
     * $query->filterByCommonName('fooValue');   // WHERE common_name = 'fooValue'
     * $query->filterByCommonName('%fooValue%'); // WHERE common_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $commonName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByCommonName($commonName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($commonName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $commonName)) {
                $commonName = str_replace('*', '%', $commonName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrganismPeer::COMMON_NAME, $commonName, $comparison);
    }

    /**
     * Filter the query on the comment column
     *
     * Example usage:
     * <code>
     * $query->filterByComment('fooValue');   // WHERE comment = 'fooValue'
     * $query->filterByComment('%fooValue%'); // WHERE comment LIKE '%fooValue%'
     * </code>
     *
     * @param     string $comment The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function filterByComment($comment = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($comment)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $comment)) {
                $comment = str_replace('*', '%', $comment);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(OrganismPeer::COMMENT, $comment, $comparison);
    }

    /**
     * Filter the query by a related Biomaterial object
     *
     * @param   Biomaterial|PropelObjectCollection $biomaterial  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 OrganismQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterial($biomaterial, $comparison = null)
    {
        if ($biomaterial instanceof Biomaterial) {
            return $this
                ->addUsingAlias(OrganismPeer::ORGANISM_ID, $biomaterial->getTaxonId(), $comparison);
        } elseif ($biomaterial instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialQuery()
                ->filterByPrimaryKeys($biomaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterial() only accepts arguments of type Biomaterial or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biomaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function joinBiomaterial($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biomaterial');

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
            $this->addJoinObject($join, 'Biomaterial');
        }

        return $this;
    }

    /**
     * Use the Biomaterial relation Biomaterial object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinBiomaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biomaterial', '\cli_db\propel\BiomaterialQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Organism $organism Object to remove from the list of results
     *
     * @return OrganismQuery The current query, for fluid interface
     */
    public function prune($organism = null)
    {
        if ($organism) {
            $this->addUsingAlias(OrganismPeer::ORGANISM_ID, $organism->getOrganismId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
