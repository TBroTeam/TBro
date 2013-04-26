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
use cli_db\propel\Contact;
use cli_db\propel\Dbxref;
use cli_db\propel\Pub;
use cli_db\propel\Study;
use cli_db\propel\StudyAssay;
use cli_db\propel\StudyPeer;
use cli_db\propel\StudyQuery;
use cli_db\propel\Studydesign;
use cli_db\propel\Studyprop;

/**
 * Base class that represents a query for the 'study' table.
 *
 *
 *
 * @method StudyQuery orderByStudyId($order = Criteria::ASC) Order by the study_id column
 * @method StudyQuery orderByContactId($order = Criteria::ASC) Order by the contact_id column
 * @method StudyQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method StudyQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method StudyQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method StudyQuery orderByDescription($order = Criteria::ASC) Order by the description column
 *
 * @method StudyQuery groupByStudyId() Group by the study_id column
 * @method StudyQuery groupByContactId() Group by the contact_id column
 * @method StudyQuery groupByPubId() Group by the pub_id column
 * @method StudyQuery groupByDbxrefId() Group by the dbxref_id column
 * @method StudyQuery groupByName() Group by the name column
 * @method StudyQuery groupByDescription() Group by the description column
 *
 * @method StudyQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method StudyQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method StudyQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method StudyQuery leftJoinContact($relationAlias = null) Adds a LEFT JOIN clause to the query using the Contact relation
 * @method StudyQuery rightJoinContact($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Contact relation
 * @method StudyQuery innerJoinContact($relationAlias = null) Adds a INNER JOIN clause to the query using the Contact relation
 *
 * @method StudyQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method StudyQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method StudyQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method StudyQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method StudyQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method StudyQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method StudyQuery leftJoinStudyAssay($relationAlias = null) Adds a LEFT JOIN clause to the query using the StudyAssay relation
 * @method StudyQuery rightJoinStudyAssay($relationAlias = null) Adds a RIGHT JOIN clause to the query using the StudyAssay relation
 * @method StudyQuery innerJoinStudyAssay($relationAlias = null) Adds a INNER JOIN clause to the query using the StudyAssay relation
 *
 * @method StudyQuery leftJoinStudydesign($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studydesign relation
 * @method StudyQuery rightJoinStudydesign($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studydesign relation
 * @method StudyQuery innerJoinStudydesign($relationAlias = null) Adds a INNER JOIN clause to the query using the Studydesign relation
 *
 * @method StudyQuery leftJoinStudyprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Studyprop relation
 * @method StudyQuery rightJoinStudyprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Studyprop relation
 * @method StudyQuery innerJoinStudyprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Studyprop relation
 *
 * @method Study findOne(PropelPDO $con = null) Return the first Study matching the query
 * @method Study findOneOrCreate(PropelPDO $con = null) Return the first Study matching the query, or a new Study object populated from the query conditions when no match is found
 *
 * @method Study findOneByContactId(int $contact_id) Return the first Study filtered by the contact_id column
 * @method Study findOneByPubId(int $pub_id) Return the first Study filtered by the pub_id column
 * @method Study findOneByDbxrefId(int $dbxref_id) Return the first Study filtered by the dbxref_id column
 * @method Study findOneByName(string $name) Return the first Study filtered by the name column
 * @method Study findOneByDescription(string $description) Return the first Study filtered by the description column
 *
 * @method array findByStudyId(int $study_id) Return Study objects filtered by the study_id column
 * @method array findByContactId(int $contact_id) Return Study objects filtered by the contact_id column
 * @method array findByPubId(int $pub_id) Return Study objects filtered by the pub_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Study objects filtered by the dbxref_id column
 * @method array findByName(string $name) Return Study objects filtered by the name column
 * @method array findByDescription(string $description) Return Study objects filtered by the description column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseStudyQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseStudyQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Study', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new StudyQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   StudyQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return StudyQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof StudyQuery) {
            return $criteria;
        }
        $query = new StudyQuery();
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
     * @return   Study|Study[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = StudyPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(StudyPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Study A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByStudyId($key, $con = null)
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
     * @return                 Study A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "study_id", "contact_id", "pub_id", "dbxref_id", "name", "description" FROM "study" WHERE "study_id" = :p0';
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
            $obj = new Study();
            $obj->hydrate($row);
            StudyPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Study|Study[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Study[]|mixed the list of results, formatted by the current formatter
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
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(StudyPeer::STUDY_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(StudyPeer::STUDY_ID, $keys, Criteria::IN);
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
     * @param     mixed $studyId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByStudyId($studyId = null, $comparison = null)
    {
        if (is_array($studyId)) {
            $useMinMax = false;
            if (isset($studyId['min'])) {
                $this->addUsingAlias(StudyPeer::STUDY_ID, $studyId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($studyId['max'])) {
                $this->addUsingAlias(StudyPeer::STUDY_ID, $studyId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyPeer::STUDY_ID, $studyId, $comparison);
    }

    /**
     * Filter the query on the contact_id column
     *
     * Example usage:
     * <code>
     * $query->filterByContactId(1234); // WHERE contact_id = 1234
     * $query->filterByContactId(array(12, 34)); // WHERE contact_id IN (12, 34)
     * $query->filterByContactId(array('min' => 12)); // WHERE contact_id >= 12
     * $query->filterByContactId(array('max' => 12)); // WHERE contact_id <= 12
     * </code>
     *
     * @see       filterByContact()
     *
     * @param     mixed $contactId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByContactId($contactId = null, $comparison = null)
    {
        if (is_array($contactId)) {
            $useMinMax = false;
            if (isset($contactId['min'])) {
                $this->addUsingAlias(StudyPeer::CONTACT_ID, $contactId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($contactId['max'])) {
                $this->addUsingAlias(StudyPeer::CONTACT_ID, $contactId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyPeer::CONTACT_ID, $contactId, $comparison);
    }

    /**
     * Filter the query on the pub_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPubId(1234); // WHERE pub_id = 1234
     * $query->filterByPubId(array(12, 34)); // WHERE pub_id IN (12, 34)
     * $query->filterByPubId(array('min' => 12)); // WHERE pub_id >= 12
     * $query->filterByPubId(array('max' => 12)); // WHERE pub_id <= 12
     * </code>
     *
     * @see       filterByPub()
     *
     * @param     mixed $pubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(StudyPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(StudyPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyPeer::PUB_ID, $pubId, $comparison);
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
     * @see       filterByDbxref()
     *
     * @param     mixed $dbxrefId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(StudyPeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(StudyPeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(StudyPeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @return StudyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudyPeer::NAME, $name, $comparison);
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
     * @return StudyQuery The current query, for fluid interface
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

        return $this->addUsingAlias(StudyPeer::DESCRIPTION, $description, $comparison);
    }

    /**
     * Filter the query by a related Contact object
     *
     * @param   Contact|PropelObjectCollection $contact The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByContact($contact, $comparison = null)
    {
        if ($contact instanceof Contact) {
            return $this
                ->addUsingAlias(StudyPeer::CONTACT_ID, $contact->getContactId(), $comparison);
        } elseif ($contact instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyPeer::CONTACT_ID, $contact->toKeyValue('PrimaryKey', 'ContactId'), $comparison);
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
     * @return StudyQuery The current query, for fluid interface
     */
    public function joinContact($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useContactQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinContact($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Contact', '\cli_db\propel\ContactQuery');
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(StudyPeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyPeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
        } else {
            throw new PropelException('filterByDbxref() only accepts arguments of type Dbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Dbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function joinDbxref($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Dbxref');

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
            $this->addJoinObject($join, 'Dbxref');
        }

        return $this;
    }

    /**
     * Use the Dbxref relation Dbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\DbxrefQuery A secondary query class using the current class as primary query
     */
    public function useDbxrefQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Dbxref', '\cli_db\propel\DbxrefQuery');
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(StudyPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(StudyPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
        } else {
            throw new PropelException('filterByPub() only accepts arguments of type Pub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pub');

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
            $this->addJoinObject($join, 'Pub');
        }

        return $this;
    }

    /**
     * Use the Pub relation Pub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubQuery A secondary query class using the current class as primary query
     */
    public function usePubQuery($relationAlias = null, $joinType = Criteria::LEFT_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Filter the query by a related StudyAssay object
     *
     * @param   StudyAssay|PropelObjectCollection $studyAssay  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyAssay($studyAssay, $comparison = null)
    {
        if ($studyAssay instanceof StudyAssay) {
            return $this
                ->addUsingAlias(StudyPeer::STUDY_ID, $studyAssay->getStudyId(), $comparison);
        } elseif ($studyAssay instanceof PropelObjectCollection) {
            return $this
                ->useStudyAssayQuery()
                ->filterByPrimaryKeys($studyAssay->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyAssay() only accepts arguments of type StudyAssay or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the StudyAssay relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function joinStudyAssay($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('StudyAssay');

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
            $this->addJoinObject($join, 'StudyAssay');
        }

        return $this;
    }

    /**
     * Use the StudyAssay relation StudyAssay object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudyAssayQuery A secondary query class using the current class as primary query
     */
    public function useStudyAssayQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyAssay($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'StudyAssay', '\cli_db\propel\StudyAssayQuery');
    }

    /**
     * Filter the query by a related Studydesign object
     *
     * @param   Studydesign|PropelObjectCollection $studydesign  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudydesign($studydesign, $comparison = null)
    {
        if ($studydesign instanceof Studydesign) {
            return $this
                ->addUsingAlias(StudyPeer::STUDY_ID, $studydesign->getStudyId(), $comparison);
        } elseif ($studydesign instanceof PropelObjectCollection) {
            return $this
                ->useStudydesignQuery()
                ->filterByPrimaryKeys($studydesign->getPrimaryKeys())
                ->endUse();
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
     * @return StudyQuery The current query, for fluid interface
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
     * Filter the query by a related Studyprop object
     *
     * @param   Studyprop|PropelObjectCollection $studyprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 StudyQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByStudyprop($studyprop, $comparison = null)
    {
        if ($studyprop instanceof Studyprop) {
            return $this
                ->addUsingAlias(StudyPeer::STUDY_ID, $studyprop->getStudyId(), $comparison);
        } elseif ($studyprop instanceof PropelObjectCollection) {
            return $this
                ->useStudypropQuery()
                ->filterByPrimaryKeys($studyprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByStudyprop() only accepts arguments of type Studyprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Studyprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function joinStudyprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Studyprop');

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
            $this->addJoinObject($join, 'Studyprop');
        }

        return $this;
    }

    /**
     * Use the Studyprop relation Studyprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\StudypropQuery A secondary query class using the current class as primary query
     */
    public function useStudypropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinStudyprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Studyprop', '\cli_db\propel\StudypropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Study $study Object to remove from the list of results
     *
     * @return StudyQuery The current query, for fluid interface
     */
    public function prune($study = null)
    {
        if ($study) {
            $this->addUsingAlias(StudyPeer::STUDY_ID, $study->getStudyId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
