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
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureCvtermPub;
use cli_db\propel\FeaturePub;
use cli_db\propel\FeatureSynonym;
use cli_db\propel\Pub;
use cli_db\propel\PubDbxref;
use cli_db\propel\PubPeer;
use cli_db\propel\PubQuery;
use cli_db\propel\PubRelationship;
use cli_db\propel\Pubauthor;
use cli_db\propel\Pubprop;

/**
 * Base class that represents a query for the 'pub' table.
 *
 *
 *
 * @method PubQuery orderByPubId($order = Criteria::ASC) Order by the pub_id column
 * @method PubQuery orderByTitle($order = Criteria::ASC) Order by the title column
 * @method PubQuery orderByVolumetitle($order = Criteria::ASC) Order by the volumetitle column
 * @method PubQuery orderByVolume($order = Criteria::ASC) Order by the volume column
 * @method PubQuery orderBySeriesName($order = Criteria::ASC) Order by the series_name column
 * @method PubQuery orderByIssue($order = Criteria::ASC) Order by the issue column
 * @method PubQuery orderByPyear($order = Criteria::ASC) Order by the pyear column
 * @method PubQuery orderByPages($order = Criteria::ASC) Order by the pages column
 * @method PubQuery orderByMiniref($order = Criteria::ASC) Order by the miniref column
 * @method PubQuery orderByUniquename($order = Criteria::ASC) Order by the uniquename column
 * @method PubQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method PubQuery orderByIsObsolete($order = Criteria::ASC) Order by the is_obsolete column
 * @method PubQuery orderByPublisher($order = Criteria::ASC) Order by the publisher column
 * @method PubQuery orderByPubplace($order = Criteria::ASC) Order by the pubplace column
 *
 * @method PubQuery groupByPubId() Group by the pub_id column
 * @method PubQuery groupByTitle() Group by the title column
 * @method PubQuery groupByVolumetitle() Group by the volumetitle column
 * @method PubQuery groupByVolume() Group by the volume column
 * @method PubQuery groupBySeriesName() Group by the series_name column
 * @method PubQuery groupByIssue() Group by the issue column
 * @method PubQuery groupByPyear() Group by the pyear column
 * @method PubQuery groupByPages() Group by the pages column
 * @method PubQuery groupByMiniref() Group by the miniref column
 * @method PubQuery groupByUniquename() Group by the uniquename column
 * @method PubQuery groupByTypeId() Group by the type_id column
 * @method PubQuery groupByIsObsolete() Group by the is_obsolete column
 * @method PubQuery groupByPublisher() Group by the publisher column
 * @method PubQuery groupByPubplace() Group by the pubplace column
 *
 * @method PubQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method PubQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method PubQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method PubQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method PubQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method PubQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method PubQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method PubQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method PubQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method PubQuery leftJoinFeatureCvtermPub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvtermPub relation
 * @method PubQuery rightJoinFeatureCvtermPub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvtermPub relation
 * @method PubQuery innerJoinFeatureCvtermPub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvtermPub relation
 *
 * @method PubQuery leftJoinFeaturePub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeaturePub relation
 * @method PubQuery rightJoinFeaturePub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeaturePub relation
 * @method PubQuery innerJoinFeaturePub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeaturePub relation
 *
 * @method PubQuery leftJoinFeatureSynonym($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureSynonym relation
 * @method PubQuery rightJoinFeatureSynonym($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureSynonym relation
 * @method PubQuery innerJoinFeatureSynonym($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureSynonym relation
 *
 * @method PubQuery leftJoinPubDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubDbxref relation
 * @method PubQuery rightJoinPubDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubDbxref relation
 * @method PubQuery innerJoinPubDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the PubDbxref relation
 *
 * @method PubQuery leftJoinPubRelationshipRelatedByObjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubRelationshipRelatedByObjectId relation
 * @method PubQuery rightJoinPubRelationshipRelatedByObjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubRelationshipRelatedByObjectId relation
 * @method PubQuery innerJoinPubRelationshipRelatedByObjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the PubRelationshipRelatedByObjectId relation
 *
 * @method PubQuery leftJoinPubRelationshipRelatedBySubjectId($relationAlias = null) Adds a LEFT JOIN clause to the query using the PubRelationshipRelatedBySubjectId relation
 * @method PubQuery rightJoinPubRelationshipRelatedBySubjectId($relationAlias = null) Adds a RIGHT JOIN clause to the query using the PubRelationshipRelatedBySubjectId relation
 * @method PubQuery innerJoinPubRelationshipRelatedBySubjectId($relationAlias = null) Adds a INNER JOIN clause to the query using the PubRelationshipRelatedBySubjectId relation
 *
 * @method PubQuery leftJoinPubauthor($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pubauthor relation
 * @method PubQuery rightJoinPubauthor($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pubauthor relation
 * @method PubQuery innerJoinPubauthor($relationAlias = null) Adds a INNER JOIN clause to the query using the Pubauthor relation
 *
 * @method PubQuery leftJoinPubprop($relationAlias = null) Adds a LEFT JOIN clause to the query using the Pubprop relation
 * @method PubQuery rightJoinPubprop($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Pubprop relation
 * @method PubQuery innerJoinPubprop($relationAlias = null) Adds a INNER JOIN clause to the query using the Pubprop relation
 *
 * @method Pub findOne(PropelPDO $con = null) Return the first Pub matching the query
 * @method Pub findOneOrCreate(PropelPDO $con = null) Return the first Pub matching the query, or a new Pub object populated from the query conditions when no match is found
 *
 * @method Pub findOneByTitle(string $title) Return the first Pub filtered by the title column
 * @method Pub findOneByVolumetitle(string $volumetitle) Return the first Pub filtered by the volumetitle column
 * @method Pub findOneByVolume(string $volume) Return the first Pub filtered by the volume column
 * @method Pub findOneBySeriesName(string $series_name) Return the first Pub filtered by the series_name column
 * @method Pub findOneByIssue(string $issue) Return the first Pub filtered by the issue column
 * @method Pub findOneByPyear(string $pyear) Return the first Pub filtered by the pyear column
 * @method Pub findOneByPages(string $pages) Return the first Pub filtered by the pages column
 * @method Pub findOneByMiniref(string $miniref) Return the first Pub filtered by the miniref column
 * @method Pub findOneByUniquename(string $uniquename) Return the first Pub filtered by the uniquename column
 * @method Pub findOneByTypeId(int $type_id) Return the first Pub filtered by the type_id column
 * @method Pub findOneByIsObsolete(boolean $is_obsolete) Return the first Pub filtered by the is_obsolete column
 * @method Pub findOneByPublisher(string $publisher) Return the first Pub filtered by the publisher column
 * @method Pub findOneByPubplace(string $pubplace) Return the first Pub filtered by the pubplace column
 *
 * @method array findByPubId(int $pub_id) Return Pub objects filtered by the pub_id column
 * @method array findByTitle(string $title) Return Pub objects filtered by the title column
 * @method array findByVolumetitle(string $volumetitle) Return Pub objects filtered by the volumetitle column
 * @method array findByVolume(string $volume) Return Pub objects filtered by the volume column
 * @method array findBySeriesName(string $series_name) Return Pub objects filtered by the series_name column
 * @method array findByIssue(string $issue) Return Pub objects filtered by the issue column
 * @method array findByPyear(string $pyear) Return Pub objects filtered by the pyear column
 * @method array findByPages(string $pages) Return Pub objects filtered by the pages column
 * @method array findByMiniref(string $miniref) Return Pub objects filtered by the miniref column
 * @method array findByUniquename(string $uniquename) Return Pub objects filtered by the uniquename column
 * @method array findByTypeId(int $type_id) Return Pub objects filtered by the type_id column
 * @method array findByIsObsolete(boolean $is_obsolete) Return Pub objects filtered by the is_obsolete column
 * @method array findByPublisher(string $publisher) Return Pub objects filtered by the publisher column
 * @method array findByPubplace(string $pubplace) Return Pub objects filtered by the pubplace column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BasePubQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BasePubQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Pub', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new PubQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   PubQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return PubQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof PubQuery) {
            return $criteria;
        }
        $query = new PubQuery();
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
     * @return   Pub|Pub[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = PubPeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(PubPeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Pub A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByPubId($key, $con = null)
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
     * @return                 Pub A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "pub_id", "title", "volumetitle", "volume", "series_name", "issue", "pyear", "pages", "miniref", "uniquename", "type_id", "is_obsolete", "publisher", "pubplace" FROM "pub" WHERE "pub_id" = :p0';
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
            $obj = new Pub();
            $obj->hydrate($row);
            PubPeer::addInstanceToPool($obj, (string) $key);
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
     * @return Pub|Pub[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Pub[]|mixed the list of results, formatted by the current formatter
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
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(PubPeer::PUB_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(PubPeer::PUB_ID, $keys, Criteria::IN);
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
     * @param     mixed $pubId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPubId($pubId = null, $comparison = null)
    {
        if (is_array($pubId)) {
            $useMinMax = false;
            if (isset($pubId['min'])) {
                $this->addUsingAlias(PubPeer::PUB_ID, $pubId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($pubId['max'])) {
                $this->addUsingAlias(PubPeer::PUB_ID, $pubId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubPeer::PUB_ID, $pubId, $comparison);
    }

    /**
     * Filter the query on the title column
     *
     * Example usage:
     * <code>
     * $query->filterByTitle('fooValue');   // WHERE title = 'fooValue'
     * $query->filterByTitle('%fooValue%'); // WHERE title LIKE '%fooValue%'
     * </code>
     *
     * @param     string $title The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByTitle($title = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($title)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $title)) {
                $title = str_replace('*', '%', $title);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::TITLE, $title, $comparison);
    }

    /**
     * Filter the query on the volumetitle column
     *
     * Example usage:
     * <code>
     * $query->filterByVolumetitle('fooValue');   // WHERE volumetitle = 'fooValue'
     * $query->filterByVolumetitle('%fooValue%'); // WHERE volumetitle LIKE '%fooValue%'
     * </code>
     *
     * @param     string $volumetitle The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByVolumetitle($volumetitle = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($volumetitle)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $volumetitle)) {
                $volumetitle = str_replace('*', '%', $volumetitle);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::VOLUMETITLE, $volumetitle, $comparison);
    }

    /**
     * Filter the query on the volume column
     *
     * Example usage:
     * <code>
     * $query->filterByVolume('fooValue');   // WHERE volume = 'fooValue'
     * $query->filterByVolume('%fooValue%'); // WHERE volume LIKE '%fooValue%'
     * </code>
     *
     * @param     string $volume The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByVolume($volume = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($volume)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $volume)) {
                $volume = str_replace('*', '%', $volume);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::VOLUME, $volume, $comparison);
    }

    /**
     * Filter the query on the series_name column
     *
     * Example usage:
     * <code>
     * $query->filterBySeriesName('fooValue');   // WHERE series_name = 'fooValue'
     * $query->filterBySeriesName('%fooValue%'); // WHERE series_name LIKE '%fooValue%'
     * </code>
     *
     * @param     string $seriesName The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterBySeriesName($seriesName = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($seriesName)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $seriesName)) {
                $seriesName = str_replace('*', '%', $seriesName);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::SERIES_NAME, $seriesName, $comparison);
    }

    /**
     * Filter the query on the issue column
     *
     * Example usage:
     * <code>
     * $query->filterByIssue('fooValue');   // WHERE issue = 'fooValue'
     * $query->filterByIssue('%fooValue%'); // WHERE issue LIKE '%fooValue%'
     * </code>
     *
     * @param     string $issue The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByIssue($issue = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($issue)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $issue)) {
                $issue = str_replace('*', '%', $issue);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::ISSUE, $issue, $comparison);
    }

    /**
     * Filter the query on the pyear column
     *
     * Example usage:
     * <code>
     * $query->filterByPyear('fooValue');   // WHERE pyear = 'fooValue'
     * $query->filterByPyear('%fooValue%'); // WHERE pyear LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pyear The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPyear($pyear = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pyear)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pyear)) {
                $pyear = str_replace('*', '%', $pyear);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::PYEAR, $pyear, $comparison);
    }

    /**
     * Filter the query on the pages column
     *
     * Example usage:
     * <code>
     * $query->filterByPages('fooValue');   // WHERE pages = 'fooValue'
     * $query->filterByPages('%fooValue%'); // WHERE pages LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pages The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPages($pages = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pages)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pages)) {
                $pages = str_replace('*', '%', $pages);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::PAGES, $pages, $comparison);
    }

    /**
     * Filter the query on the miniref column
     *
     * Example usage:
     * <code>
     * $query->filterByMiniref('fooValue');   // WHERE miniref = 'fooValue'
     * $query->filterByMiniref('%fooValue%'); // WHERE miniref LIKE '%fooValue%'
     * </code>
     *
     * @param     string $miniref The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByMiniref($miniref = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($miniref)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $miniref)) {
                $miniref = str_replace('*', '%', $miniref);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::MINIREF, $miniref, $comparison);
    }

    /**
     * Filter the query on the uniquename column
     *
     * Example usage:
     * <code>
     * $query->filterByUniquename('fooValue');   // WHERE uniquename = 'fooValue'
     * $query->filterByUniquename('%fooValue%'); // WHERE uniquename LIKE '%fooValue%'
     * </code>
     *
     * @param     string $uniquename The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByUniquename($uniquename = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($uniquename)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $uniquename)) {
                $uniquename = str_replace('*', '%', $uniquename);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::UNIQUENAME, $uniquename, $comparison);
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
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(PubPeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(PubPeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(PubPeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the is_obsolete column
     *
     * Example usage:
     * <code>
     * $query->filterByIsObsolete(true); // WHERE is_obsolete = true
     * $query->filterByIsObsolete('yes'); // WHERE is_obsolete = true
     * </code>
     *
     * @param     boolean|string $isObsolete The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByIsObsolete($isObsolete = null, $comparison = null)
    {
        if (is_string($isObsolete)) {
            $isObsolete = in_array(strtolower($isObsolete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(PubPeer::IS_OBSOLETE, $isObsolete, $comparison);
    }

    /**
     * Filter the query on the publisher column
     *
     * Example usage:
     * <code>
     * $query->filterByPublisher('fooValue');   // WHERE publisher = 'fooValue'
     * $query->filterByPublisher('%fooValue%'); // WHERE publisher LIKE '%fooValue%'
     * </code>
     *
     * @param     string $publisher The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPublisher($publisher = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($publisher)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $publisher)) {
                $publisher = str_replace('*', '%', $publisher);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::PUBLISHER, $publisher, $comparison);
    }

    /**
     * Filter the query on the pubplace column
     *
     * Example usage:
     * <code>
     * $query->filterByPubplace('fooValue');   // WHERE pubplace = 'fooValue'
     * $query->filterByPubplace('%fooValue%'); // WHERE pubplace LIKE '%fooValue%'
     * </code>
     *
     * @param     string $pubplace The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function filterByPubplace($pubplace = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($pubplace)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $pubplace)) {
                $pubplace = str_replace('*', '%', $pubplace);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(PubPeer::PUBPLACE, $pubplace, $comparison);
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(PubPeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(PubPeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return PubQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureCvterm object
     *
     * @param   FeatureCvterm|PropelObjectCollection $featureCvterm  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $featureCvterm->getPubId(), $comparison);
        } elseif ($featureCvterm instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermQuery()
                ->filterByPrimaryKeys($featureCvterm->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvterm() only accepts arguments of type FeatureCvterm or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvterm relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinFeatureCvterm($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvterm');

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
            $this->addJoinObject($join, 'FeatureCvterm');
        }

        return $this;
    }

    /**
     * Use the FeatureCvterm relation FeatureCvterm object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvterm($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvterm', '\cli_db\propel\FeatureCvtermQuery');
    }

    /**
     * Filter the query by a related FeatureCvtermPub object
     *
     * @param   FeatureCvtermPub|PropelObjectCollection $featureCvtermPub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvtermPub($featureCvtermPub, $comparison = null)
    {
        if ($featureCvtermPub instanceof FeatureCvtermPub) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $featureCvtermPub->getPubId(), $comparison);
        } elseif ($featureCvtermPub instanceof PropelObjectCollection) {
            return $this
                ->useFeatureCvtermPubQuery()
                ->filterByPrimaryKeys($featureCvtermPub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureCvtermPub() only accepts arguments of type FeatureCvtermPub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureCvtermPub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinFeatureCvtermPub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureCvtermPub');

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
            $this->addJoinObject($join, 'FeatureCvtermPub');
        }

        return $this;
    }

    /**
     * Use the FeatureCvtermPub relation FeatureCvtermPub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureCvtermPubQuery A secondary query class using the current class as primary query
     */
    public function useFeatureCvtermPubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureCvtermPub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureCvtermPub', '\cli_db\propel\FeatureCvtermPubQuery');
    }

    /**
     * Filter the query by a related FeaturePub object
     *
     * @param   FeaturePub|PropelObjectCollection $featurePub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeaturePub($featurePub, $comparison = null)
    {
        if ($featurePub instanceof FeaturePub) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $featurePub->getPubId(), $comparison);
        } elseif ($featurePub instanceof PropelObjectCollection) {
            return $this
                ->useFeaturePubQuery()
                ->filterByPrimaryKeys($featurePub->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeaturePub() only accepts arguments of type FeaturePub or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeaturePub relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinFeaturePub($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeaturePub');

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
            $this->addJoinObject($join, 'FeaturePub');
        }

        return $this;
    }

    /**
     * Use the FeaturePub relation FeaturePub object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeaturePubQuery A secondary query class using the current class as primary query
     */
    public function useFeaturePubQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeaturePub($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeaturePub', '\cli_db\propel\FeaturePubQuery');
    }

    /**
     * Filter the query by a related FeatureSynonym object
     *
     * @param   FeatureSynonym|PropelObjectCollection $featureSynonym  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureSynonym($featureSynonym, $comparison = null)
    {
        if ($featureSynonym instanceof FeatureSynonym) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $featureSynonym->getPubId(), $comparison);
        } elseif ($featureSynonym instanceof PropelObjectCollection) {
            return $this
                ->useFeatureSynonymQuery()
                ->filterByPrimaryKeys($featureSynonym->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureSynonym() only accepts arguments of type FeatureSynonym or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureSynonym relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinFeatureSynonym($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureSynonym');

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
            $this->addJoinObject($join, 'FeatureSynonym');
        }

        return $this;
    }

    /**
     * Use the FeatureSynonym relation FeatureSynonym object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureSynonymQuery A secondary query class using the current class as primary query
     */
    public function useFeatureSynonymQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureSynonym($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureSynonym', '\cli_db\propel\FeatureSynonymQuery');
    }

    /**
     * Filter the query by a related PubDbxref object
     *
     * @param   PubDbxref|PropelObjectCollection $pubDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubDbxref($pubDbxref, $comparison = null)
    {
        if ($pubDbxref instanceof PubDbxref) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $pubDbxref->getPubId(), $comparison);
        } elseif ($pubDbxref instanceof PropelObjectCollection) {
            return $this
                ->usePubDbxrefQuery()
                ->filterByPrimaryKeys($pubDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubDbxref() only accepts arguments of type PubDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinPubDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubDbxref');

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
            $this->addJoinObject($join, 'PubDbxref');
        }

        return $this;
    }

    /**
     * Use the PubDbxref relation PubDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubDbxrefQuery A secondary query class using the current class as primary query
     */
    public function usePubDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubDbxref', '\cli_db\propel\PubDbxrefQuery');
    }

    /**
     * Filter the query by a related PubRelationship object
     *
     * @param   PubRelationship|PropelObjectCollection $pubRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubRelationshipRelatedByObjectId($pubRelationship, $comparison = null)
    {
        if ($pubRelationship instanceof PubRelationship) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $pubRelationship->getObjectId(), $comparison);
        } elseif ($pubRelationship instanceof PropelObjectCollection) {
            return $this
                ->usePubRelationshipRelatedByObjectIdQuery()
                ->filterByPrimaryKeys($pubRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubRelationshipRelatedByObjectId() only accepts arguments of type PubRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubRelationshipRelatedByObjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinPubRelationshipRelatedByObjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubRelationshipRelatedByObjectId');

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
            $this->addJoinObject($join, 'PubRelationshipRelatedByObjectId');
        }

        return $this;
    }

    /**
     * Use the PubRelationshipRelatedByObjectId relation PubRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubRelationshipQuery A secondary query class using the current class as primary query
     */
    public function usePubRelationshipRelatedByObjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubRelationshipRelatedByObjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubRelationshipRelatedByObjectId', '\cli_db\propel\PubRelationshipQuery');
    }

    /**
     * Filter the query by a related PubRelationship object
     *
     * @param   PubRelationship|PropelObjectCollection $pubRelationship  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubRelationshipRelatedBySubjectId($pubRelationship, $comparison = null)
    {
        if ($pubRelationship instanceof PubRelationship) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $pubRelationship->getSubjectId(), $comparison);
        } elseif ($pubRelationship instanceof PropelObjectCollection) {
            return $this
                ->usePubRelationshipRelatedBySubjectIdQuery()
                ->filterByPrimaryKeys($pubRelationship->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubRelationshipRelatedBySubjectId() only accepts arguments of type PubRelationship or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the PubRelationshipRelatedBySubjectId relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinPubRelationshipRelatedBySubjectId($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('PubRelationshipRelatedBySubjectId');

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
            $this->addJoinObject($join, 'PubRelationshipRelatedBySubjectId');
        }

        return $this;
    }

    /**
     * Use the PubRelationshipRelatedBySubjectId relation PubRelationship object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubRelationshipQuery A secondary query class using the current class as primary query
     */
    public function usePubRelationshipRelatedBySubjectIdQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubRelationshipRelatedBySubjectId($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'PubRelationshipRelatedBySubjectId', '\cli_db\propel\PubRelationshipQuery');
    }

    /**
     * Filter the query by a related Pubauthor object
     *
     * @param   Pubauthor|PropelObjectCollection $pubauthor  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubauthor($pubauthor, $comparison = null)
    {
        if ($pubauthor instanceof Pubauthor) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $pubauthor->getPubId(), $comparison);
        } elseif ($pubauthor instanceof PropelObjectCollection) {
            return $this
                ->usePubauthorQuery()
                ->filterByPrimaryKeys($pubauthor->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubauthor() only accepts arguments of type Pubauthor or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pubauthor relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinPubauthor($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pubauthor');

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
            $this->addJoinObject($join, 'Pubauthor');
        }

        return $this;
    }

    /**
     * Use the Pubauthor relation Pubauthor object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubauthorQuery A secondary query class using the current class as primary query
     */
    public function usePubauthorQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubauthor($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pubauthor', '\cli_db\propel\PubauthorQuery');
    }

    /**
     * Filter the query by a related Pubprop object
     *
     * @param   Pubprop|PropelObjectCollection $pubprop  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 PubQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByPubprop($pubprop, $comparison = null)
    {
        if ($pubprop instanceof Pubprop) {
            return $this
                ->addUsingAlias(PubPeer::PUB_ID, $pubprop->getPubId(), $comparison);
        } elseif ($pubprop instanceof PropelObjectCollection) {
            return $this
                ->usePubpropQuery()
                ->filterByPrimaryKeys($pubprop->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByPubprop() only accepts arguments of type Pubprop or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the Pubprop relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function joinPubprop($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('Pubprop');

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
            $this->addJoinObject($join, 'Pubprop');
        }

        return $this;
    }

    /**
     * Use the Pubprop relation Pubprop object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\PubpropQuery A secondary query class using the current class as primary query
     */
    public function usePubpropQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinPubprop($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Pubprop', '\cli_db\propel\PubpropQuery');
    }

    /**
     * Exclude object from result
     *
     * @param   Pub $pub Object to remove from the list of results
     *
     * @return PubQuery The current query, for fluid interface
     */
    public function prune($pub = null)
    {
        if ($pub) {
            $this->addUsingAlias(PubPeer::PUB_ID, $pub->getPubId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
