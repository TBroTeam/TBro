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
use cli_db\propel\AssayBiomaterial;
use cli_db\propel\Biomaterial;
use cli_db\propel\BiomaterialPeer;
use cli_db\propel\BiomaterialQuery;
use cli_db\propel\BiomaterialRelationship;
use cli_db\propel\Biomaterialprop;
use cli_db\propel\Contact;
use cli_db\propel\Organism;

/**
 * Base class that represents a query for the 'biomaterial' table.
 *
 *
 *
 * @method BiomaterialQuery orderByBiomaterialId($order = Criteria::ASC) Order by the biomaterial_id column
 * @method BiomaterialQuery orderByTaxonId($order = Criteria::ASC) Order by the taxon_id column
 * @method BiomaterialQuery orderByBiosourceproviderId($order = Criteria::ASC) Order by the biosourceprovider_id column
 * @method BiomaterialQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method BiomaterialQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method BiomaterialQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method BiomaterialQuery groupByBiomaterialId() Group by the biomaterial_id column
 * @method BiomaterialQuery groupByTaxonId() Group by the taxon_id column
 * @method BiomaterialQuery groupByBiosourceproviderId() Group by the biosourceprovider_id column
 * @method BiomaterialQuery groupByDbxrefId() Group by the dbxref_id column
 * @method BiomaterialQuery groupByName() Group by the name column
 * @method BiomaterialQuery groupByDescription() Group by the description column
 *
 * @method BiomaterialQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method BiomaterialQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method BiomaterialQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method BiomaterialQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method BiomaterialQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method BiomaterialQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method BiomaterialQuery leftJoinOrganism($relationAlias = null) Adds a LEFT JOIN clause to the query using the Organism relation
 * @method BiomaterialQuery rightJoinOrganism($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Organism relation
 * @method BiomaterialQuery innerJoinOrganism($relationAlias = null) Adds a INNER JOIN clause to the query using the Organism relation
 *
 * @method BiomaterialQuery leftJoinAssayBiomaterial($relationAlias = null) Adds a LEFT JOIN clause to the query using the AssayBiomaterial relation
 * @method BiomaterialQuery rightJoinAssayBiomaterial($relationAlias = null) Adds a RIGHT JOIN clause to the query using the AssayBiomaterial relation
 * @method BiomaterialQuery innerJoinAssayBiomaterial($relationAlias = null) Adds a INNER JOIN clause to the query using the AssayBiomaterial relation
 *
 * @method BiomaterialQuery leftJoinBiomaterialRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialRelationshipRelatedByObjectId relation
 * @method BiomaterialQuery rightJoinBiomaterialRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialRelationshipRelatedByObjectId relation
 * @method BiomaterialQuery innerJoinBiomaterialRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialRelationshipRelatedByObjectId relation
 *
 * @method BiomaterialQuery leftJoinBiomaterialRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the BiomaterialRelationshipRelatedBySubjectId relation
 * @method BiomaterialQuery rightJoinBiomaterialRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the BiomaterialRelationshipRelatedBySubjectId relation
 * @method BiomaterialQuery innerJoinBiomaterialRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the BiomaterialRelationshipRelatedBySubjectId relation
 *
 * @method BiomaterialQuery leftJoinBiomaterialprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Biomaterialprop relation
 * @method BiomaterialQuery rightJoinBiomaterialprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Biomaterialprop relation
 * @method BiomaterialQuery innerJoinBiomaterialprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Biomaterialprop relation
 *
 * @method Biomaterial findOne(PropelPDO $con = null) Return the first Biomaterial matching the query
 * @method Biomaterial findOneOrCreate(PropelPDO $con = null) Return the first Biomaterial matching the query, or a new Biomaterial object populated from the query conditions when no match is found
 *
 * @method Biomaterial findOneByTaxonId(int $taxon_id) Return the first Biomaterial filtered by the taxon_id column
 * @method Biomaterial findOneByBiosourceproviderId(int $biosourceprovider_id) Return the first Biomaterial filtered by the biosourceprovider_id column
 * @method Biomaterial findOneByDbxrefId(int $dbxref_id) Return the first Biomaterial filtered by the dbxref_id column
 * @method Biomaterial findOneByName(string $name) Return the first Biomaterial filtered by the name column
 * @method Biomaterial findOneByDescription(string $description) Return the first Biomaterial filtered by the description column
 *
 * @method array findByBiomaterialId(int $biomaterial_id) Return Biomaterial objects filtered by the biomaterial_id column
 * @method array findByTaxonId(int $taxon_id) Return Biomaterial objects filtered by the taxon_id column
 * @method array findByBiosourceproviderId(int $biosourceprovider_id) Return Biomaterial objects filtered by the biosourceprovider_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Biomaterial objects filtered by the dbxref_id column
 * @method array findByName(string $name) Return Biomaterial objects filtered by the name column
 * @method array findByDescription(string $description) Return Biomaterial objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseBiomaterialQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseBiomaterialQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Biomaterial', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new BiomaterialQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   BiomaterialQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return BiomaterialQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof BiomaterialQuery) {
            return $criteria;
        }
        $query = new BiomaterialQuery();
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
     * @return   Biomaterial|Biomaterial[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = BiomaterialPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(BiomaterialPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Biomaterial A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByBiomaterialId($key, $con = null)
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
     * @return                 Biomaterial A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "biomaterial_id", "taxon_id", "biosourceprovider_id", "dbxref_id", "name", "description" FROM "biomaterial" WHERE "biomaterial_id" = :p0';
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
            $obj = new Biomaterial();
            $obj->hydrate($row);
            BiomaterialPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Biomaterial|Biomaterial[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Biomaterial[]|mixed the list of results, formatted by the current formatter
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
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the biomaterial_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiomaterialId(1234); // WHERE biomaterial_id = 1234
     * $query->filterByBiomaterialId(array(12, 34)); // WHERE biomaterial_id IN (12, 34)
     * $query->filterByBiomaterialId(array('min' => 12)); // WHERE biomaterial_id >= 12
     * $query->filterByBiomaterialId(array('max' => 12)); // WHERE biomaterial_id <= 12
     * </code>
     *
     * @param     mixed $biomaterialId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByBiomaterialId($biomaterialId = null, $comparison = null)
    {
        if (is_array($biomaterialId)) {
            $useMinMax = false;
            if (isset($biomaterialId['min'])) {
                $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biomaterialId['max'])) {
                $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialId, $comparison);
    }

    /**
     * Filter the query on the taxon_id column
     *
     * Example usage:
     * <code>
     * $query->filterByTaxonId(1234); // WHERE taxon_id = 1234
     * $query->filterByTaxonId(array(12, 34)); // WHERE taxon_id IN (12, 34)
     * $query->filterByTaxonId(array('min' => 12)); // WHERE taxon_id >= 12
     * $query->filterByTaxonId(array('max' => 12)); // WHERE taxon_id <= 12
     * </code>
     *
     * @see       filterByOrganism()
     *
     * @param     mixed $taxonId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByTaxonId($taxonId = null, $comparison = null)
    {
        if (is_array($taxonId)) {
            $useMinMax = false;
            if (isset($taxonId['min'])) {
                $this->addUsingAlias(BiomaterialPeer::TAXON_ID, $taxonId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($taxonId['max'])) {
                $this->addUsingAlias(BiomaterialPeer::TAXON_ID, $taxonId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialPeer::TAXON_ID, $taxonId, $comparison);
    }

    /**
     * Filter the query on the biosourceprovider_id column
     *
     * Example usage:
     * <code>
     * $query->filterByBiosourceproviderId(1234); // WHERE biosourceprovider_id = 1234
     * $query->filterByBiosourceproviderId(array(12, 34)); // WHERE biosourceprovider_id IN (12, 34)
     * $query->filterByBiosourceproviderId(array('min' => 12)); // WHERE biosourceprovider_id >= 12
     * $query->filterByBiosourceproviderId(array('max' => 12)); // WHERE biosourceprovider_id <= 12
     * </code>
     *
     * @see       filterByContact()
     *
     * @param     mixed $biosourceproviderId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByBiosourceproviderId($biosourceproviderId = null, $comparison = null)
    {
        if (is_array($biosourceproviderId)) {
            $useMinMax = false;
            if (isset($biosourceproviderId['min'])) {
                $this->addUsingAlias(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $biosourceproviderId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($biosourceproviderId['max'])) {
                $this->addUsingAlias(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $biosourceproviderId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $biosourceproviderId, $comparison);
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
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(BiomaterialPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(BiomaterialPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(BiomaterialPeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @return BiomaterialQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BiomaterialPeer::NAME, $name, $comparison);
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
     * @return BiomaterialQuery The current query, for fluid interface
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

        return $this->addUsingAlias(BiomaterialPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $contact->getContactId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialPeer::BIOSOURCEPROVIDER_ID, $contact->toKeyValue('PrimaryKey', 'ContactId'), $comparison);
        } else {
            throw new PropelException('filterByContact() only accepts arguments of type Contact or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Contact relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Contact');

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
            $this->addJoinObject($join, 'Contact');
        }

        return $this;
    }

    /**
     * Use the Contact relation Contact object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\ContactQuery A secondary query class using the current class as primary query
     */
    public function useContactQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\cli_db\propel\ContactQuery');
    }

    /**
     * Filter the query by a related Organism object
     *
     * @param   Organism|PropelObjectCollection $organism The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOrganism($organism, $comparison = null)
    {
        if ($organism instanceof Organism) {
            return $this
                ->addUsingAlias(BiomaterialPeer::TAXON_ID, $organism->getOrganismId(), $comparison);
        } elseif ($organism instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(BiomaterialPeer::TAXON_ID, $organism->toKeyValue('PrimaryKey', 'OrganismId'), $comparison);
        } else {
            throw new PropelException('filterByOrganism() only accepts arguments of type Organism or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Organism relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinOrganism($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Organism');

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
            $this->addJoinObject($join, 'Organism');
        }

        return $this;
    }

    /**
     * Use the Organism relation Organism object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\OrganismQuery A secondary query class using the current class as primary query
     */
    public function useOrganismQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinOrganism($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Organism', '\cli_db\propel\OrganismQuery');
    }

    /**
     * Filter the query by a related AssayBiomaterial object
     *
     * @param   AssayBiomaterial|PropelObjectCollection $assayBiomaterial  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByAssayBiomaterial($assayBiomaterial, $comparison = null)
    {
        if ($assayBiomaterial instanceof AssayBiomaterial) {
            return $this
                ->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $assayBiomaterial->getBiomaterialId(), $comparison);
        } elseif ($assayBiomaterial instanceof PropelObjectCollection) {
            return $this
                ->useAssayBiomaterialQuery()
                ->filterByPrimaryKeys($assayBiomaterial->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByAssayBiomaterial() only accepts arguments of type AssayBiomaterial or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the AssayBiomaterial relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinAssayBiomaterial($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('AssayBiomaterial');

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
            $this->addJoinObject($join, 'AssayBiomaterial');
        }

        return $this;
    }

    /**
     * Use the AssayBiomaterial relation AssayBiomaterial object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\AssayBiomaterialQuery A secondary query class using the current class as primary query
     */
    public function useAssayBiomaterialQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinAssayBiomaterial($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'AssayBiomaterial', '\cli_db\propel\AssayBiomaterialQuery');
    }

    /**
     * Filter the query by a related BiomaterialRelationship object
     *
     * @param   BiomaterialRelationship|PropelObjectCollection $biomaterialRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialRelationshipRelatedByObjectId($biomaterialRelationship, $comparison = null)
    {
        if ($biomaterialRelationship instanceof BiomaterialRelationship) {
            return $this
                ->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialRelationship->getObjectId(), $comparison);
        } elseif ($biomaterialRelationship instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($biomaterialRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialRelationshipRelatedByObjectId() only accepts arguments of type BiomaterialRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinBiomaterialRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialRelationshipRelatedByObjectId');

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
            $this->addJoinObject($join, 'BiomaterialRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the BiomaterialRelationshipRelatedByObjectId relation BiomaterialRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialRelationshipRelatedByObjectId', '\cli_db\propel\BiomaterialRelationshipQuery');
    }

    /**
     * Filter the query by a related BiomaterialRelationship object
     *
     * @param   BiomaterialRelationship|PropelObjectCollection $biomaterialRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialRelationshipRelatedBySubjectId($biomaterialRelationship, $comparison = null)
    {
        if ($biomaterialRelationship instanceof BiomaterialRelationship) {
            return $this
                ->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialRelationship->getSubjectId(), $comparison);
        } elseif ($biomaterialRelationship instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($biomaterialRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialRelationshipRelatedBySubjectId() only accepts arguments of type BiomaterialRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the BiomaterialRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinBiomaterialRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('BiomaterialRelationshipRelatedBySubjectId');

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
            $this->addJoinObject($join, 'BiomaterialRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the BiomaterialRelationshipRelatedBySubjectId relation BiomaterialRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialRelationshipQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'BiomaterialRelationshipRelatedBySubjectId', '\cli_db\propel\BiomaterialRelationshipQuery');
    }

    /**
     * Filter the query by a related Biomaterialprop object
     *
     * @param   Biomaterialprop|PropelObjectCollection $biomaterialprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 BiomaterialQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByBiomaterialprop($biomaterialprop, $comparison = null)
    {
        if ($biomaterialprop instanceof Biomaterialprop) {
            return $this
                ->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterialprop->getBiomaterialId(), $comparison);
        } elseif ($biomaterialprop instanceof PropelObjectCollection) {
            return $this
                ->useBiomaterialpropQuery()
                ->filterByPrimaryKeys($biomaterialprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByBiomaterialprop() only accepts arguments of type Biomaterialprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Biomaterialprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function joinBiomaterialprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Biomaterialprop');

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
            $this->addJoinObject($join, 'Biomaterialprop');
        }

        return $this;
    }

    /**
     * Use the Biomaterialprop relation Biomaterialprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\BiomaterialpropQuery A secondary query class using the current class as primary query
     */
    public function useBiomaterialpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinBiomaterialprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Biomaterialprop', '\cli_db\propel\BiomaterialpropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Biomaterial $biomaterial Object to remove from the list of results
     *
     * @return BiomaterialQuery The current query, for fluid interface
     */
    public function prune($biomaterial = null)
    {
        if ($biomaterial) {
            $this->addUsingAlias(BiomaterialPeer::BIOMATERIAL_ID, $biomaterial->getBiomaterialId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
