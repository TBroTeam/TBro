<?php

#modified code from http://www.coderholic.com/php-database-query-logging-with-pdo/

/**
 * Extends PDO and logs all queries that are executed and how long
 * they take, including queries issued via prepared statements
 */
class LoggedPDO extends PDO {

    public static $log = array();

    const LOGLEVEL_LONG = 1;
    const LOGLEVEL_SHORT = 2;
    
    public function __construct($dsn, $username = null, $password = null) {
        parent::__construct($dsn, $username, $password);
    }

    public $logLevel = self::LOGLEVEL_SHORT;

    /**
     * Print out the log when we're destructed. I'm assuming this will
     * be at the end of the page. If not you might want to remove this
     * destructor and manually call LoggedPDO::printLog();
     */
    public function __destruct() {
        if ($this->logLevel == self::LOGLEVEL_SHORT) {
            self::printShortLog();
        } else {
            self::printFullLog();
        }
    }

    public function query($query) {
        $start = microtime(true);
        $result = parent::query($query);
        $time = microtime(true) - $start;
        LoggedPDO::$log[] = array('query' => $query,
            'time' => round($time * 1000, 3), 'type' => 'Q');
        return $result;
    }

    /**
     * @return LoggedPDOStatement
     */
    public function prepare($query) {
        return new LoggedPDOStatement(parent::prepare($query));
    }

    public static function printFullLog() {
        $totalTime = 0;
        echo "\ntime\ttype\tquery\n";
        foreach (self::$log as $entry) {
            $totalTime += $entry['time'];
            echo $entry['time'] . "\t" . $entry['type'] . "\t" . $entry['query'] . "\n";
        }
        echo $totalTime . "\t\tfor " . count(self::$log) . " queries\n";
    }

    public static function printShortLog() {
        $totalTime = 0;
        echo "\ntime\ttquery\n";
        foreach (self::$log as $entry) {
            $totalTime += $entry['time'];
        }
        echo $totalTime . "\tfor " . count(self::$log) . " queries\n";
    }

}

/**
 * PDOStatement decorator that logs when a PDOStatement is
 * executed, and the time it took to run
 * @see LoggedPDO
 */
class LoggedPDOStatement {

    /**
     * The PDOStatement we decorate
     */
    private $statement;
    private $boundParams = array();

    public function __construct(PDOStatement $statement) {
        $this->statement = $statement;
    }

    /**
     * When execute is called record the time it takes and
     * then log the query
     * @return PDO result set
     */
    public function execute() {
        $query = $this->statement->queryString;
        ksort($this->boundParams);
        $last_paramid = 0;
        foreach ($this->boundParams as $pname => $pvalue) {
            if (is_string($pname)) {
#replace named query parameter with $pvalue
                $query = str_replace($pname, '"' . $pvalue . '"', $query);
            } else if (is_int($pname)) {
#replace $pname'th questionmark with $pvalue
#as boundParams are sorted, this is always the first questionmark
#but we have to watch for skipped numbers
                if ($pname != $last_paramid + 1) {
                    throw new ErrorException("parameter " . ($last_paramid + 1) . " has been skipped!" . $pname);
                } else
                    $last_paramid++;
                $pos = strpos($query, '?');
            }
        }

        $start = microtime(true);
        $ex = null;
        try {

            $result = $this->statement->execute();
        } catch (Exception $e) {
            $ex = $e;
        }
        $time = microtime(true) - $start;
        LoggedPDO::$log[] = array('query' => $query,
            'time' => round($time * 1000, 3), 'type' => 'PS');

        if ($ex != null)
            throw $ex;
        return $result;
    }

    /**
     * Other than execute pass all other calls to the PDOStatement object
     * @param string $function_name
     * @param array $parameters arguments
     */
    public function __call($function_name, $parameters) {
        if ($function_name == 'bindParam') {
            $parname = $parameters[0];
            if (is_string($parname) && strpos($parname, ':') === FALSE) {
                $parname = ':' . $parameters[0];
            }
            $this->boundParams[$parname] = &$parameters[1];
        }
        if ($function_name == 'bindValue') {
            $this->boundParams[$parameters[0]] = $parameters[1];
        }

        return call_user_func_array(array($this->statement, $function_name), $parameters);
    }

}

?>
