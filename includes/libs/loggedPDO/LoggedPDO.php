<?php

namespace LoggedPDO;

// we're using the PEAR Log package
require_once 'Log.php';

class PDO extends \PDO {

    public $log;
    private $logFullTime;
    private $logCount;
    public static $LOG_QUERY = "query";
    public static $LOG_TIME = "time";
    public static $LOG_TYPE = "method";
    public static $LOG_PARAMS = "parameters";
    public $log_replace_params = true;

    public function __construct($dsn, $username = null, $password = null, $options = null, \Log $log = null) {
        if ($log == null) {
            throw new \Exception("We need a PEAR Log object, parameter order has just been kept due to consistency.\n"
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
        $this->log($statement, round($time * 1000, 3));

        $pdostatement->pdo = $this;
        return $pdostatement;
    }

    public function exec($statement) {
        $start = microtime(true);
        parent::exec($statement);
        $time = microtime(true) - $start;
        $this->log($statement, round($time * 1000, 3));
    }

    public function log($query, $time, $params = null) {
        $this->logFullTime+=$time;
        $this->logCount++;

        $trace = debug_backtrace();
        $stackdepth = 1;
        $called_from = sprintf('%1$s->%2$s in %3$s on line %4$d'
                , $trace[$stackdepth]['class']
                , $trace[$stackdepth]['function']
                , $trace[$stackdepth]['file']
                , $trace[$stackdepth]['line']
        );


        $log = array(
            self::$LOG_TIME => $time,
            self::$LOG_QUERY => $query,
            self::$LOG_TYPE => $called_from);
        if ($this->log_replace_params == false) {
            $log[self::$LOG_PARAMS] = $params;
        }

        $this->log->log(
                $log
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

    private static $PDO_PLACEHOLDER_NONE = 0;
    private static $PDO_PLACEHOLDER_NAMED = 1;
    private static $PDO_PLACEHOLDER_POSITIONAL = 2;

    /**
     * When execute is called record the time it takes and
     * then log the query
     * parameters will be replaced and logged, but if your query is really weird, this might fail.
     * hence the second parameter
     * @return PDO result set
     */
    public function execute($bound_input_params = null) {
        $query = $this->queryString;

        if ($bound_input_params == null) {
            $params = $this->boundParams;
        } else {
            $params = $bound_input_params;
        }

        if ($this->pdo->log_replace_params) {
            $query_type = self::$PDO_PLACEHOLDER_NONE;
            if (preg_match('/[^:?][?][^:?]/', $query)) {
                $query_type |= self::$PDO_PLACEHOLDER_POSITIONAL;
            }

            if (preg_match('/[^:?][:]([0-9A-Za-z]+)/', $query)) {
                $query_type |= self::$PDO_PLACEHOLDER_NAMED;
            }

            if ($query_type == (self::$PDO_PLACEHOLDER_NAMED | self::$PDO_PLACEHOLDER_POSITIONAL)) {
                throw new \PDOException('mixed named and positional parameters');
            }

            foreach ($params as $pname => $pvalue) {
                if ($query_type == self::$PDO_PLACEHOLDER_POSITIONAL)
                    $query = preg_replace("/\?/", $this->pdo->quote($pvalue), $query, 1);
                else if ($query_type == self::$PDO_PLACEHOLDER_NAMED)
                    $query = preg_replace("/($pname)/", $this->pdo->quote($pvalue), $query, 1);
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

        $this->pdo->log($query, round($time * 1000, 3), $params);


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
