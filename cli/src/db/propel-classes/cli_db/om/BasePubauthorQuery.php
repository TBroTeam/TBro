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
use cli_db\propel\Pub;
use cli_db\propel\Pubauthor;
use cli_db\propel\PubauthorPeer;
use cli_db\propel\PubauthorQuery;

/**
 * Base class that represents a query for the 'pubauthor' table.
 *
 *
 *
 * @method PubauthorQuery orderByPubauthorId($order = Criteria::ASC) Order by the pubauthor_id column
 * @method PubauthorQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method PubauthorQuery orderByRank($order = Criteria::ASC) Order by the rank column
 * @method PubauthorQuery orderByEditor($order = Criteria::ASC) Order by the editor column
 * @method PubauthorQuery orderBySurname($order = Criteria::ASC) Order by the surname column
 * @method PubauthorQuery orderByGivennames($order = Criteria::ASC) Order by the givennames column
 * @method PubauthorQuery orderBySuffix($order = Criteria::ASC) Order by the suffix column
 *
 * @method PubauthorQuery groupByPubauthorId() Group by the pubauthor_id column
 * @method PubauthorQuery groupByPubId() Group by the pub_id column
 * @method PubauthorQuery groupByRank() Group by the rank column
 * @method PubauthorQuery groupByEditor() Group by the editor column
 * @method PubauthorQuery groupBySurname() Group by the surname column
 * @method PubauthorQuery groupByGivennames() Group by the givennames column
 * @method PubauthorQuery groupBySuffix() Group by the suffix column
 *
 * @method PubauthorQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PubauthorQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PubauthorQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PubauthorQuery leftJoinPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pub relation
 * @method PubauthorQuery rightJoinPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pub relation
 * @method PubauthorQuery innerJoinPub($relationAlias = null) Adds a INNER JOIN clause to the query using the Pub relation
 *
 * @method Pubauthor findOne(PropelPDO $con = null) Return the first Pubauthor matching the query
 * @method Pubauthor findOneOrCreate(PropelPDO $con = null) Return the first Pubauthor matching the query, or a new Pubauthor object populated from the query conditions when no match is found
 *
 * @method Pubauthor findOneByPubId(int $pub_id) Return the first Pubauthor filtered by the pub_id column
 * @method Pubauthor findOneByRank(int $rank) Return the first Pubauthor filtered by the rank column
 * @method Pubauthor findOneByEditor(boolean $editor) Return the first Pubauthor filtered by the editor column
 * @method Pubauthor findOneBySurname(string $surname) Return the first Pubauthor filtered by the surname column
 * @method Pubauthor findOneByGivennames(string $givennames) Return the first Pubauthor filtered by the givennames column
 * @method Pubauthor findOneBySuffix(string $suffix) Return the first Pubauthor filtered by the suffix column
 *
 * @method array findByPubauthorId(int $pubauthor_id) Return Pubauthor objects filtered by the pubauthor_id column
 * @method array findByPubId(int $pub_id) Return Pubauthor objects filtered by the pub_id column
 * @method array findByRank(int $rank) Return Pubauthor objects filtered by the rank column
 * @method array findByEditor(boolean $editor) Return Pubauthor objects filtered by the editor column
 * @method array findBySurname(string $surname) Return Pubauthor objects filtered by the surname column
 * @method array findByGivennames(string $givennames) Return Pubauthor objects filtered by the givennames column
 * @method array findBySuffix(string $suffix) Return Pubauthor objects filtered by the suffix column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BasePubauthorQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePubauthorQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Pubauthor', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PubauthorQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PubauthorQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PubauthorQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PubauthorQuery) {
            return $criteria;
        }
        $query = new PubauthorQuery();
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
     * @return   Pubauthor|Pubauthor[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PubauthorPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PubauthorPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Pubauthor A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByPubauthorId($key, $con = null)
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
     * @return                 Pubauthor A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "pubauthor_id", "pub_id", "rank", "editor", "surname", "givennames", "suffix" FROM "pubauthor" WHERE "pubauthor_id" = :p0';
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
            $obj = new Pubauthor();
            $obj->hydrate($row);
            PubauthorPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Pubauthor|Pubauthor[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Pubauthor[]|mixed the list of results, formatted by the current formatter
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
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the pubauthor_id column
     *
     * Example usage:
     * <code>
     * $query->filterByPubauthorId(1234); // WHERE pubauthor_id = 1234
     * $query->filterByPubauthorId(array(12, 34)); // WHERE pubauthor_id IN (12, 34)
     * $query->filterByPubauthorId(array('min' => 12)); // WHERE pubauthor_id >= 12
     * $query->filterByPubauthorId(array('max' => 12)); // WHERE pubauthor_id <= 12
     * </code>
     *
     * @param     mixed $pubauthorId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByPubauthorId($pubauthorId = null, $comparison = null)
    {
        if (is_array($pubauthorId)) {
            $useMinMax = false;
            if (isset($pubauthorId['min'])) {
                $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $pubauthorId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubauthorId['max'])) {
                $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $pubauthorId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $pubauthorId, $comparison);
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
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(PubauthorPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(PubauthorPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::PUB_ID, $pubId, $comparison);
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
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByRank($rank = null, $comparison = null)
    {
        if (is_array($rank)) {
            $useMinMax = false;
            if (isset($rank['min'])) {
                $this->addUsingAlias(PubauthorPeer::RANK, $rank['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($rank['max'])) {
                $this->addUsingAlias(PubauthorPeer::RANK, $rank['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::RANK, $rank, $comparison);
    }

    /**
     * Filter the query on the editor column
     *
     * Example usage:
     * <code>
     * $query->filterByEditor(true); // WHERE editor = true
     * $query->filterByEditor('yes'); // WHERE editor = true
     * </code>
     *
     * @param     boolean|string $editor The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByEditor($editor = null, $comparison = null)
    {
        if (is_string($editor)) {
            $editor = in_array(strtolower($editor), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PubauthorPeer::EDITOR, $editor, $comparison);
    }

    /**
     * Filter the query on the surname column
     *
     * Example usage:
     * <code>
     * $query->filterBySurname('fooValue');   // WHERE surname = 'fooValue'
     * $query->filterBySurname('%fooValue%'); // WHERE surname LIKE '%fooValue%'
     * </code>
     *
     * @param     string $surname The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterBySurname($surname = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($surname)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $surname)) {
                $surname = str_replace('*', '%', $surname);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::SURNAME, $surname, $comparison);
    }

    /**
     * Filter the query on the givennames column
     *
     * Example usage:
     * <code>
     * $query->filterByGivennames('fooValue');   // WHERE givennames = 'fooValue'
     * $query->filterByGivennames('%fooValue%'); // WHERE givennames LIKE '%fooValue%'
     * </code>
     *
     * @param     string $givennames The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterByGivennames($givennames = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($givennames)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $givennames)) {
                $givennames = str_replace('*', '%', $givennames);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::GIVENNAMES, $givennames, $comparison);
    }

    /**
     * Filter the query on the suffix column
     *
     * Example usage:
     * <code>
     * $query->filterBySuffix('fooValue');   // WHERE suffix = 'fooValue'
     * $query->filterBySuffix('%fooValue%'); // WHERE suffix LIKE '%fooValue%'
     * </code>
     *
     * @param     string $suffix The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function filterBySuffix($suffix = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($suffix)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $suffix)) {
                $suffix = str_replace('*', '%', $suffix);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubauthorPeer::SUFFIX, $suffix, $comparison);
    }

    /**
     * Filter the query by a related Pub object
     *
     * @param   Pub|PropelObjectCollection $pub The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubauthorQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPub($pub, $comparison = null)
    {
        if ($pub instanceof Pub) {
            return $this
                ->addUsingAlias(PubauthorPeer::PUB_ID, $pub->getPubId(), $comparison);
        } elseif ($pub instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PubauthorPeer::PUB_ID, $pub->toKeyValue('PrimaryKey', 'PubId'), $comparison);
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
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function joinPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function usePubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pub', '\cli_db\propel\PubQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Pubauthor $pubauthor Object to remove from the list of results
     *
     * @return PubauthorQuery The current query, for fluid interface
     */
    public function prune($pubauthor = null)
    {
        if ($pubauthor) {
            $this->addUsingAlias(PubauthorPeer::PUBAUTHOR_ID, $pubauthor->getPubauthorId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
