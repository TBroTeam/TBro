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
use cli_db\propel\Dbxref;
use cli_db\propel\Feature;
use cli_db\propel\FeatureCvterm;
use cli_db\propel\FeatureDbxref;
use cli_db\propel\FeaturePeer;
use cli_db\propel\FeaturePub;
use cli_db\propel\FeatureQuery;
use cli_db\propel\Organism;

/**
 * Base class that represents a query for the 'feature' table.
 *
 *
 *
 * @method FeatureQuery orderByFeatureId($order = Criteria::ASC) Order by the feature_id column
 * @method FeatureQuery orderByDbxrefId($order = Criteria::ASC) Order by the dbxref_id column
 * @method FeatureQuery orderByOrganismId($order = Criteria::ASC) Order by the organism_id column
 * @method FeatureQuery orderByName($order = Criteria::ASC) Order by the name column
 * @method FeatureQuery orderByUniquename($order = Criteria::ASC) Order by the uniquename column
 * @method FeatureQuery orderByResidues($order = Criteria::ASC) Order by the residues column
 * @method FeatureQuery orderBySeqlen($order = Criteria::ASC) Order by the seqlen column
 * @method FeatureQuery orderByMd5checksum($order = Criteria::ASC) Order by the md5checksum column
 * @method FeatureQuery orderByTypeId($order = Criteria::ASC) Order by the type_id column
 * @method FeatureQuery orderByIsAnalysis($order = Criteria::ASC) Order by the is_analysis column
 * @method FeatureQuery orderByIsObsolete($order = Criteria::ASC) Order by the is_obsolete column
 * @method FeatureQuery orderByTimeaccessioned($order = Criteria::ASC) Order by the timeaccessioned column
 * @method FeatureQuery orderByTimelastmodified($order = Criteria::ASC) Order by the timelastmodified column
 *
 * @method FeatureQuery groupByFeatureId() Group by the feature_id column
 * @method FeatureQuery groupByDbxrefId() Group by the dbxref_id column
 * @method FeatureQuery groupByOrganismId() Group by the organism_id column
 * @method FeatureQuery groupByName() Group by the name column
 * @method FeatureQuery groupByUniquename() Group by the uniquename column
 * @method FeatureQuery groupByResidues() Group by the residues column
 * @method FeatureQuery groupBySeqlen() Group by the seqlen column
 * @method FeatureQuery groupByMd5checksum() Group by the md5checksum column
 * @method FeatureQuery groupByTypeId() Group by the type_id column
 * @method FeatureQuery groupByIsAnalysis() Group by the is_analysis column
 * @method FeatureQuery groupByIsObsolete() Group by the is_obsolete column
 * @method FeatureQuery groupByTimeaccessioned() Group by the timeaccessioned column
 * @method FeatureQuery groupByTimelastmodified() Group by the timelastmodified column
 *
 * @method FeatureQuery leftJoin($relation) Adds a LEFT JOIN clause to the query
 * @method FeatureQuery rightJoin($relation) Adds a RIGHT JOIN clause to the query
 * @method FeatureQuery innerJoin($relation) Adds a INNER JOIN clause to the query
 *
 * @method FeatureQuery leftJoinDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the Dbxref relation
 * @method FeatureQuery rightJoinDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Dbxref relation
 * @method FeatureQuery innerJoinDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the Dbxref relation
 *
 * @method FeatureQuery leftJoinOrganism($relationAlias = null) Adds a LEFT JOIN clause to the query using the Organism relation
 * @method FeatureQuery rightJoinOrganism($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Organism relation
 * @method FeatureQuery innerJoinOrganism($relationAlias = null) Adds a INNER JOIN clause to the query using the Organism relation
 *
 * @method FeatureQuery leftJoinCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the Cvterm relation
 * @method FeatureQuery rightJoinCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the Cvterm relation
 * @method FeatureQuery innerJoinCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the Cvterm relation
 *
 * @method FeatureQuery leftJoinFeatureCvterm($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureQuery rightJoinFeatureCvterm($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureCvterm relation
 * @method FeatureQuery innerJoinFeatureCvterm($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureCvterm relation
 *
 * @method FeatureQuery leftJoinFeatureDbxref($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeatureDbxref relation
 * @method FeatureQuery rightJoinFeatureDbxref($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeatureDbxref relation
 * @method FeatureQuery innerJoinFeatureDbxref($relationAlias = null) Adds a INNER JOIN clause to the query using the FeatureDbxref relation
 *
 * @method FeatureQuery leftJoinFeaturePub($relationAlias = null) Adds a LEFT JOIN clause to the query using the FeaturePub relation
 * @method FeatureQuery rightJoinFeaturePub($relationAlias = null) Adds a RIGHT JOIN clause to the query using the FeaturePub relation
 * @method FeatureQuery innerJoinFeaturePub($relationAlias = null) Adds a INNER JOIN clause to the query using the FeaturePub relation
 *
 * @method Feature findOne(PropelPDO $con = null) Return the first Feature matching the query
 * @method Feature findOneOrCreate(PropelPDO $con = null) Return the first Feature matching the query, or a new Feature object populated from the query conditions when no match is found
 *
 * @method Feature findOneByDbxrefId(int $dbxref_id) Return the first Feature filtered by the dbxref_id column
 * @method Feature findOneByOrganismId(int $organism_id) Return the first Feature filtered by the organism_id column
 * @method Feature findOneByName(string $name) Return the first Feature filtered by the name column
 * @method Feature findOneByUniquename(string $uniquename) Return the first Feature filtered by the uniquename column
 * @method Feature findOneByResidues(string $residues) Return the first Feature filtered by the residues column
 * @method Feature findOneBySeqlen(int $seqlen) Return the first Feature filtered by the seqlen column
 * @method Feature findOneByMd5checksum(string $md5checksum) Return the first Feature filtered by the md5checksum column
 * @method Feature findOneByTypeId(int $type_id) Return the first Feature filtered by the type_id column
 * @method Feature findOneByIsAnalysis(boolean $is_analysis) Return the first Feature filtered by the is_analysis column
 * @method Feature findOneByIsObsolete(boolean $is_obsolete) Return the first Feature filtered by the is_obsolete column
 * @method Feature findOneByTimeaccessioned(string $timeaccessioned) Return the first Feature filtered by the timeaccessioned column
 * @method Feature findOneByTimelastmodified(string $timelastmodified) Return the first Feature filtered by the timelastmodified column
 *
 * @method array findByFeatureId(int $feature_id) Return Feature objects filtered by the feature_id column
 * @method array findByDbxrefId(int $dbxref_id) Return Feature objects filtered by the dbxref_id column
 * @method array findByOrganismId(int $organism_id) Return Feature objects filtered by the organism_id column
 * @method array findByName(string $name) Return Feature objects filtered by the name column
 * @method array findByUniquename(string $uniquename) Return Feature objects filtered by the uniquename column
 * @method array findByResidues(string $residues) Return Feature objects filtered by the residues column
 * @method array findBySeqlen(int $seqlen) Return Feature objects filtered by the seqlen column
 * @method array findByMd5checksum(string $md5checksum) Return Feature objects filtered by the md5checksum column
 * @method array findByTypeId(int $type_id) Return Feature objects filtered by the type_id column
 * @method array findByIsAnalysis(boolean $is_analysis) Return Feature objects filtered by the is_analysis column
 * @method array findByIsObsolete(boolean $is_obsolete) Return Feature objects filtered by the is_obsolete column
 * @method array findByTimeaccessioned(string $timeaccessioned) Return Feature objects filtered by the timeaccessioned column
 * @method array findByTimelastmodified(string $timelastmodified) Return Feature objects filtered by the timelastmodified column
 *
 * @package    propel.generator.cli_db.om
 */
abstract class BaseFeatureQuery extends ModelCriteria
{
    /**
     * Initializes internal state of BaseFeatureQuery object.
     *
     * @param     string $dbName The dabase name
     * @param     string $modelName The phpName of a model, e.g. 'Book'
     * @param     string $modelAlias The alias for the model in this query, e.g. 'b'
     */
    public function __construct($dbName = 'cli_db', $modelName = 'cli_db\\propel\\Feature', $modelAlias = null)
    {
        parent::__construct($dbName, $modelName, $modelAlias);
    }

    /**
     * Returns a new FeatureQuery object.
     *
     * @param     string $modelAlias The alias of a model in the query
     * @param   FeatureQuery|Criteria $criteria Optional Criteria to build the query from
     *
     * @return FeatureQuery
     */
    public static function create($modelAlias = null, $criteria = null)
    {
        if ($criteria instanceof FeatureQuery) {
            return $criteria;
        }
        $query = new FeatureQuery();
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
     * @return   Feature|Feature[]|mixed the result, formatted by the current formatter
     */
    public function findPk($key, $con = null)
    {
        if ($key === null) {
            return null;
        }
        if ((null !== ($obj = FeaturePeer::getInstanceFromPool((string) $key))) && !$this->formatter) {
            // the object is alredy in the instance pool
            return $obj;
        }
        if ($con === null) {
            $con = Propel::getConnection(FeaturePeer::DATABASE_NAME, Propel::CONNECTION_READ);
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
     * @return                 Feature A model object, or null if the key is not found
     * @throws PropelException
     */
     public function findOneByFeatureId($key, $con = null)
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
     * @return                 Feature A model object, or null if the key is not found
     * @throws PropelException
     */
    protected function findPkSimple($key, $con)
    {
        $sql = 'SELECT "feature_id", "dbxref_id", "organism_id", "name", "uniquename", "residues", "seqlen", "md5checksum", "type_id", "is_analysis", "is_obsolete", "timeaccessioned", "timelastmodified" FROM "feature" WHERE "feature_id" = :p0';
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
            $obj = new Feature();
            $obj->hydrate($row);
            FeaturePeer::addInstanceToPool($obj, (string) $key);
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
     * @return Feature|Feature[]|mixed the result, formatted by the current formatter
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
     * @return PropelObjectCollection|Feature[]|mixed the list of results, formatted by the current formatter
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
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKey($key)
    {

        return $this->addUsingAlias(FeaturePeer::FEATURE_ID, $key, Criteria::EQUAL);
    }

    /**
     * Filter the query by a list of primary keys
     *
     * @param     array $keys The list of primary key to use for the query
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByPrimaryKeys($keys)
    {

        return $this->addUsingAlias(FeaturePeer::FEATURE_ID, $keys, Criteria::IN);
    }

    /**
     * Filter the query on the feature_id column
     *
     * Example usage:
     * <code>
     * $query->filterByFeatureId(1234); // WHERE feature_id = 1234
     * $query->filterByFeatureId(array(12, 34)); // WHERE feature_id IN (12, 34)
     * $query->filterByFeatureId(array('min' => 12)); // WHERE feature_id >= 12
     * $query->filterByFeatureId(array('max' => 12)); // WHERE feature_id <= 12
     * </code>
     *
     * @param     mixed $featureId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByFeatureId($featureId = null, $comparison = null)
    {
        if (is_array($featureId)) {
            $useMinMax = false;
            if (isset($featureId['min'])) {
                $this->addUsingAlias(FeaturePeer::FEATURE_ID, $featureId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($featureId['max'])) {
                $this->addUsingAlias(FeaturePeer::FEATURE_ID, $featureId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::FEATURE_ID, $featureId, $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByDbxrefId($dbxrefId = null, $comparison = null)
    {
        if (is_array($dbxrefId)) {
            $useMinMax = false;
            if (isset($dbxrefId['min'])) {
                $this->addUsingAlias(FeaturePeer::DBXREF_ID, $dbxrefId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($dbxrefId['max'])) {
                $this->addUsingAlias(FeaturePeer::DBXREF_ID, $dbxrefId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::DBXREF_ID, $dbxrefId, $comparison);
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
     * @see       filterByOrganism()
     *
     * @param     mixed $organismId The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByOrganismId($organismId = null, $comparison = null)
    {
        if (is_array($organismId)) {
            $useMinMax = false;
            if (isset($organismId['min'])) {
                $this->addUsingAlias(FeaturePeer::ORGANISM_ID, $organismId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($organismId['max'])) {
                $this->addUsingAlias(FeaturePeer::ORGANISM_ID, $organismId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::ORGANISM_ID, $organismId, $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FeaturePeer::NAME, $name, $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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

        return $this->addUsingAlias(FeaturePeer::UNIQUENAME, $uniquename, $comparison);
    }

    /**
     * Filter the query on the residues column
     *
     * Example usage:
     * <code>
     * $query->filterByResidues('fooValue');   // WHERE residues = 'fooValue'
     * $query->filterByResidues('%fooValue%'); // WHERE residues LIKE '%fooValue%'
     * </code>
     *
     * @param     string $residues The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByResidues($residues = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($residues)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $residues)) {
                $residues = str_replace('*', '%', $residues);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeaturePeer::RESIDUES, $residues, $comparison);
    }

    /**
     * Filter the query on the seqlen column
     *
     * Example usage:
     * <code>
     * $query->filterBySeqlen(1234); // WHERE seqlen = 1234
     * $query->filterBySeqlen(array(12, 34)); // WHERE seqlen IN (12, 34)
     * $query->filterBySeqlen(array('min' => 12)); // WHERE seqlen >= 12
     * $query->filterBySeqlen(array('max' => 12)); // WHERE seqlen <= 12
     * </code>
     *
     * @param     mixed $seqlen The value to use as filter.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterBySeqlen($seqlen = null, $comparison = null)
    {
        if (is_array($seqlen)) {
            $useMinMax = false;
            if (isset($seqlen['min'])) {
                $this->addUsingAlias(FeaturePeer::SEQLEN, $seqlen['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($seqlen['max'])) {
                $this->addUsingAlias(FeaturePeer::SEQLEN, $seqlen['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::SEQLEN, $seqlen, $comparison);
    }

    /**
     * Filter the query on the md5checksum column
     *
     * Example usage:
     * <code>
     * $query->filterByMd5checksum('fooValue');   // WHERE md5checksum = 'fooValue'
     * $query->filterByMd5checksum('%fooValue%'); // WHERE md5checksum LIKE '%fooValue%'
     * </code>
     *
     * @param     string $md5checksum The value to use as filter.
     *              Accepts wildcards (* and % trigger a LIKE)
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByMd5checksum($md5checksum = null, $comparison = null)
    {
        if (null === $comparison) {
            if (is_array($md5checksum)) {
                $comparison = Criteria::IN;
            } elseif (preg_match('/[\%\*]/', $md5checksum)) {
                $md5checksum = str_replace('*', '%', $md5checksum);
                $comparison = Criteria::LIKE;
            }
        }

        return $this->addUsingAlias(FeaturePeer::MD5CHECKSUM, $md5checksum, $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByTypeId($typeId = null, $comparison = null)
    {
        if (is_array($typeId)) {
            $useMinMax = false;
            if (isset($typeId['min'])) {
                $this->addUsingAlias(FeaturePeer::TYPE_ID, $typeId['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($typeId['max'])) {
                $this->addUsingAlias(FeaturePeer::TYPE_ID, $typeId['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::TYPE_ID, $typeId, $comparison);
    }

    /**
     * Filter the query on the is_analysis column
     *
     * Example usage:
     * <code>
     * $query->filterByIsAnalysis(true); // WHERE is_analysis = true
     * $query->filterByIsAnalysis('yes'); // WHERE is_analysis = true
     * </code>
     *
     * @param     boolean|string $isAnalysis The value to use as filter.
     *              Non-boolean arguments are converted using the following rules:
     *                * 1, '1', 'true',  'on',  and 'yes' are converted to boolean true
     *                * 0, '0', 'false', 'off', and 'no'  are converted to boolean false
     *              Check on string values is case insensitive (so 'FaLsE' is seen as 'false').
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByIsAnalysis($isAnalysis = null, $comparison = null)
    {
        if (is_string($isAnalysis)) {
            $isAnalysis = in_array(strtolower($isAnalysis), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeaturePeer::IS_ANALYSIS, $isAnalysis, $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByIsObsolete($isObsolete = null, $comparison = null)
    {
        if (is_string($isObsolete)) {
            $isObsolete = in_array(strtolower($isObsolete), array('false', 'off', '-', 'no', 'n', '0', '')) ? false : true;
        }

        return $this->addUsingAlias(FeaturePeer::IS_OBSOLETE, $isObsolete, $comparison);
    }

    /**
     * Filter the query on the timeaccessioned column
     *
     * Example usage:
     * <code>
     * $query->filterByTimeaccessioned('2011-03-14'); // WHERE timeaccessioned = '2011-03-14'
     * $query->filterByTimeaccessioned('now'); // WHERE timeaccessioned = '2011-03-14'
     * $query->filterByTimeaccessioned(array('max' => 'yesterday')); // WHERE timeaccessioned > '2011-03-13'
     * </code>
     *
     * @param     mixed $timeaccessioned The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByTimeaccessioned($timeaccessioned = null, $comparison = null)
    {
        if (is_array($timeaccessioned)) {
            $useMinMax = false;
            if (isset($timeaccessioned['min'])) {
                $this->addUsingAlias(FeaturePeer::TIMEACCESSIONED, $timeaccessioned['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timeaccessioned['max'])) {
                $this->addUsingAlias(FeaturePeer::TIMEACCESSIONED, $timeaccessioned['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::TIMEACCESSIONED, $timeaccessioned, $comparison);
    }

    /**
     * Filter the query on the timelastmodified column
     *
     * Example usage:
     * <code>
     * $query->filterByTimelastmodified('2011-03-14'); // WHERE timelastmodified = '2011-03-14'
     * $query->filterByTimelastmodified('now'); // WHERE timelastmodified = '2011-03-14'
     * $query->filterByTimelastmodified(array('max' => 'yesterday')); // WHERE timelastmodified > '2011-03-13'
     * </code>
     *
     * @param     mixed $timelastmodified The value to use as filter.
     *              Values can be integers (unix timestamps), DateTime objects, or strings.
     *              Empty strings are treated as NULL.
     *              Use scalar values for equality.
     *              Use array values for in_array() equivalent.
     *              Use associative array('min' => $minValue, 'max' => $maxValue) for intervals.
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function filterByTimelastmodified($timelastmodified = null, $comparison = null)
    {
        if (is_array($timelastmodified)) {
            $useMinMax = false;
            if (isset($timelastmodified['min'])) {
                $this->addUsingAlias(FeaturePeer::TIMELASTMODIFIED, $timelastmodified['min'], Criteria::GREATER_EQUAL);
                $useMinMax = true;
            }
            if (isset($timelastmodified['max'])) {
                $this->addUsingAlias(FeaturePeer::TIMELASTMODIFIED, $timelastmodified['max'], Criteria::LESS_EQUAL);
                $useMinMax = true;
            }
            if ($useMinMax) {
                return $this;
            }
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }
        }

        return $this->addUsingAlias(FeaturePeer::TIMELASTMODIFIED, $timelastmodified, $comparison);
    }

    /**
     * Filter the query by a related Dbxref object
     *
     * @param   Dbxref|PropelObjectCollection $dbxref The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByDbxref($dbxref, $comparison = null)
    {
        if ($dbxref instanceof Dbxref) {
            return $this
                ->addUsingAlias(FeaturePeer::DBXREF_ID, $dbxref->getDbxrefId(), $comparison);
        } elseif ($dbxref instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturePeer::DBXREF_ID, $dbxref->toKeyValue('PrimaryKey', 'DbxrefId'), $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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
     * Filter the query by a related Organism object
     *
     * @param   Organism|PropelObjectCollection $organism The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByOrganism($organism, $comparison = null)
    {
        if ($organism instanceof Organism) {
            return $this
                ->addUsingAlias(FeaturePeer::ORGANISM_ID, $organism->getOrganismId(), $comparison);
        } elseif ($organism instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturePeer::ORGANISM_ID, $organism->toKeyValue('PrimaryKey', 'OrganismId'), $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
     */
    public function joinOrganism($relationAlias = null, $joinType = Criteria::INNER_JOIN)
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
    public function useOrganismQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinOrganism($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'Organism', '\cli_db\propel\OrganismQuery');
    }

    /**
     * Filter the query by a related Cvterm object
     *
     * @param   Cvterm|PropelObjectCollection $cvterm The related object(s) to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByCvterm($cvterm, $comparison = null)
    {
        if ($cvterm instanceof Cvterm) {
            return $this
                ->addUsingAlias(FeaturePeer::TYPE_ID, $cvterm->getCvtermId(), $comparison);
        } elseif ($cvterm instanceof PropelObjectCollection) {
            if (null === $comparison) {
                $comparison = Criteria::IN;
            }

            return $this
                ->addUsingAlias(FeaturePeer::TYPE_ID, $cvterm->toKeyValue('PrimaryKey', 'CvtermId'), $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureCvterm($featureCvterm, $comparison = null)
    {
        if ($featureCvterm instanceof FeatureCvterm) {
            return $this
                ->addUsingAlias(FeaturePeer::FEATURE_ID, $featureCvterm->getFeatureId(), $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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
     * Filter the query by a related FeatureDbxref object
     *
     * @param   FeatureDbxref|PropelObjectCollection $featureDbxref  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeatureDbxref($featureDbxref, $comparison = null)
    {
        if ($featureDbxref instanceof FeatureDbxref) {
            return $this
                ->addUsingAlias(FeaturePeer::FEATURE_ID, $featureDbxref->getFeatureId(), $comparison);
        } elseif ($featureDbxref instanceof PropelObjectCollection) {
            return $this
                ->useFeatureDbxrefQuery()
                ->filterByPrimaryKeys($featureDbxref->getPrimaryKeys())
                ->endUse();
        } else {
            throw new PropelException('filterByFeatureDbxref() only accepts arguments of type FeatureDbxref or PropelCollection');
        }
    }

    /**
     * Adds a JOIN clause to the query using the FeatureDbxref relation
     *
     * @param     string $relationAlias optional alias for the relation
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function joinFeatureDbxref($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        $tableMap = $this->getTableMap();
        $relationMap = $tableMap->getRelation('FeatureDbxref');

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
            $this->addJoinObject($join, 'FeatureDbxref');
        }

        return $this;
    }

    /**
     * Use the FeatureDbxref relation FeatureDbxref object
     *
     * @see       useQuery()
     *
     * @param     string $relationAlias optional alias for the relation,
     *                                   to be used as main alias in the secondary query
     * @param     string $joinType Accepted values are null, 'left join', 'right join', 'inner join'
     *
     * @return   \cli_db\propel\FeatureDbxrefQuery A secondary query class using the current class as primary query
     */
    public function useFeatureDbxrefQuery($relationAlias = null, $joinType = Criteria::INNER_JOIN)
    {
        return $this
            ->joinFeatureDbxref($relationAlias, $joinType)
            ->useQuery($relationAlias ? $relationAlias : 'FeatureDbxref', '\cli_db\propel\FeatureDbxrefQuery');
    }

    /**
     * Filter the query by a related FeaturePub object
     *
     * @param   FeaturePub|PropelObjectCollection $featurePub  the related object to use as filter
     * @param     string $comparison Operator to use for the column comparison, defaults to Criteria::EQUAL
     *
     * @return                 FeatureQuery The current query, for fluid interface
     * @throws PropelException - if the provided filter is invalid.
     */
    public function filterByFeaturePub($featurePub, $comparison = null)
    {
        if ($featurePub instanceof FeaturePub) {
            return $this
                ->addUsingAlias(FeaturePeer::FEATURE_ID, $featurePub->getFeatureId(), $comparison);
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
     * @return FeatureQuery The current query, for fluid interface
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
     * Exclude object from result
     *
     * @param   Feature $feature Object to remove from the list of results
     *
     * @return FeatureQuery The current query, for fluid interface
     */
    public function prune($feature = null)
    {
        if ($feature) {
            $this->addUsingAlias(FeaturePeer::FEATURE_ID, $feature->getFeatureId(), Criteria::NOT_EQUAL);
        }

        return $this;
    }

}
