<?php

#modified code from http://www.coderholic.com/php-database-query-logging-with-pdo/

/**
 * Extends PDO and logs all queries that are executed and how long
 * they take, including queries issued via prepared statements
 */
class LoggedPDO extends PDO {

    const LOGLEVEL_LONG = 1;
    const LOGLEVEL_SHORT = 2;

    public function __construct($dsn, $username = null, $password = null) {
        parent::__construct($dsn, $username, $password);
    }

    public static $logLevel = self::LOGLEVEL_SHORT;
    public static $logTail = 100; #-1 for full log
    public static $logImmediately = false;
    private static $log = array();
    private static $logFullTime = 0;
    private static $logCount = 0;

    /**
     * Print out the log when we're destructed. I'm assuming this will
     * be at the end of the page. If not you might want to remove this
     * destructor and manually call LoggedPDO::printLog();
     */
    public function __destruct() {
        if ($this->logLevel == self::LOGLEVEL_SHORT) {
            self::printShortLog();
        }
        else {
            self::printFullLog();
        }
    }

    public function query($query) {
        $start = microtime(true);
        $result = parent::query($query);
        $time = microtime(true) - $start;
        LoggedPDO::log($query, round($time * 1000, 3), 'Q');
        return $result;
    }

    /**
     * @return LoggedPDOStatement
     */
    public function prepare($query) {
        return new LoggedPDOStatement(parent::prepare($query));
    }

    public static function log($query, $time, $type) {
        self::$logFullTime+=$time;
        self::$logCount++;
        if (self::$logImmediately)
            self::showLogLine($query, $time, $type);
        if (self::$logTail == 0)
            return;
        if (self::$logTail > 0 && count(self::$log) > self::$logTail)
            array_shift(self::$log);
        self::$log[] = array('query' => $query, 'time' => $time, 'type' => $type);
    }

    public static function showLogLine($query, $time, $type) {
        echo $time . "\t" . $type . "\t" . $query . "\n";
    }

    public static function printFullLog() {
        echo "\ntime\ttype\tquery\n";
        foreach (self::$log as $entry) {
            self::showLogLine($entry['query'], $entry['time'], $entry['type']);
        }
        echo self::$logFullTime . "\t\tfor " . self::$logCount . " queries\n";
    }

    public static function printShortLog() {
        $totalTime = 0;
        echo "\ntime\ttquery\n";
        echo self::$logFullTime . "\tfor " . self::$logCount . " queries\n";
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
            if (!is_int($pname)) {
#replace named query parameter with $pvalue
                $query = str_replace($pname, "'" . $pvalue . "'", $query);
            }
            else {
#replace $pname'th questionmark with $pvalue
#as boundParams are sorted, this is always the first questionmark
#but we have to watch for skipped numbers
                if ($pname != $last_paramid + 1) {
                    throw new ErrorException("parameter " . ($last_paramid + 1) . " has been skipped!" . $pname);
                } else
                    $last_paramid++;
                $query = str_replace("?", "'" . $pvalue . "'", $query);
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
        LoggedPDO::log($query, round($time * 1000, 3), 'PS');

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
        if ($function_name == 'bindParam' || $function_name == 'bindValue') {
            $parname = $parameters[0];
            if (is_string($parname) && strpos($parname, ':') === false) {
                $parname = ':' . $parameters[0];
            }
            if ($function_name == 'bindParam') {
                $this->boundParams[$parname] = &$parameters[1];
            }
            else {
                $this->boundParams[$parname] = $parameters[1];
            }
        }

        return call_user_func_array(array($this->statement, $function_name),
                        $parameters);
    }

}

?>
