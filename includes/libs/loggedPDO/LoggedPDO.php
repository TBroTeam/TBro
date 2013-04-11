<?php

namespace LoggedPDO;

// we're using the PEAR Log package
require_once 'Log.php';

class PDO extends \PDO {

    public $log;
    private $logFullTime;
    private $logCount;
    public static $QUERY_TYPE_QUERY = "PDO->query";
    public static $QUERY_TYPE_EXEC = "PDO->exec";
    public static $QUERY_TYPE_STATEMENT_EXECUTE = "PDOStatement->execute";
    public static $LOG_QUERY = "query";
    public static $LOG_TIME = "time";
    public static $LOG_TYPE = "method";

    public function __construct($dsn, $username = null, $password = null, $options = null, \Log $log = null) {
        if ($log == null) {
            throw new \Exception("We need a PEAR Log object, parameter order has just been kept due to consistency, last element is NOT optional.\n"
            . "Please call this class as.\n"
            . "new \LoggedPDO\PDO(\$dsn, null, null, null, \$log);.\n"
            . "if you have no \$username, \$password or \$options to specify.");
        }
        parent::__construct($dsn, $username, $password, $options);
        $this->log = $log;
        $this->setAttribute(\PDO::ATTR_STATEMENT_CLASS, array('\LoggedPDO\PDOStatement', array()));
    }

    public function __destruct() {
        
    }

    public function prepare($statement, $driver_options = array()) {
        $pdostatement = parent::prepare($statement, $driver_options);

        $pdostatement->pdo = $this;
        return $pdostatement;
    }

    public function query($statement) {
        $start = microtime(true);
        $pdostatement = parent::query($statement);
        $time = microtime(true) - $start;
        $this->log($statement, round($time * 1000, 3), self::$QUERY_TYPE_QUERY);

        $pdostatement->pdo = $this;
        return $pdostatement;
    }

    public function exec($statement) {
        $start = microtime(true);
        parent::exec($statement);
        $time = microtime(true) - $start;
        $this->log($statement, round($time * 1000, 3), self::$QUERY_TYPE_EXEC);
    }

    public function getLogger() {
        return $this->log;
    }

    public function log($query, $time, $type) {
        $this->logFullTime+=$time;
        $this->logCount++;

        $this->log->log(
                array(sprintf('query took %s ms', $time), array(self::$LOG_QUERY => $query, self::$LOG_TIME => $time, self::$LOG_TYPE => $type))
                , PEAR_LOG_DEBUG);
    }

}

/**
 * PDOStatement decorator that logs when a PDOStatement is
 * executed, and the time it took to run
 * @see LoggedPDO
 */
class PDOStatement extends \PDOStatement {

    /**
     * The PDOStatement we decorate
     */
    public $pdo;
    private $boundParams = array();

    private function __construct() {
        
    }

    /**
     * When execute is called record the time it takes and
     * then log the query
     * @return PDO result set
     */
    public function execute($bound_input_params = null) {
        $query = $this->queryString;
        ksort($this->boundParams);
        $last_paramid = 0;
        foreach ($this->boundParams as $pname => $pvalue) {
            if (!is_int($pname)) {
#replace named query parameter with $pvalue
                $query = str_replace($pname, $x = "'" . $pvalue . "'", $query);
            }
            else {
#replace $pname'th questionmark with $pvalue
#as boundParams are sorted, this is always the first questionmark
#but we have to watch for skipped numbers
                if ($pname != $last_paramid + 1) {
                    throw new ErrorException("parameter " . ($last_paramid + 1) . " has been skipped!" . $pname);
                }
                else
                    $last_paramid++;
                $query = preg_replace("/\?/", "'" . $pvalue . "'", $query, 1);
            }
        }

        $start = microtime(true);
        $ex = null;
        try {

            $result = parent::execute($bound_input_params);
        } catch (Exception $e) {
            $ex = $e;
        }
        $time = microtime(true) - $start;
        $this->pdo->log($query, round($time * 1000, 3), PDO::$QUERY_TYPE_STATEMENT_EXECUTE);

        if ($ex != null)
            throw $ex;
        return $result;
    }

    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null) {

        if (is_string($parameter) && strpos($parameter, ':') === false)
            $this->boundParams[':' . $parameter] = &$variable;
        else
            $this->boundParams[$parameter] = &$variable;

        return parent::bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR) {
        if (is_string($parameter) && strpos($parameter, ':') === false)
            $this->boundParams[':' . $parameter] = $value;
        else
            $this->boundParams[$parameter] = $value;

        return parent::bindValue($parameter, $value, $data_type);
    }

}

?>
