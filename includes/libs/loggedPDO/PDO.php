<?php

/**
 * @author Lorenz Weber <mail@phryneas.de>
 * @copyright (c) 2013, Lorenz Weber
 * @package loggedPDO
 * 
 * The MIT License (MIT)
 * 
 * @copyright (c) 2013, Lorenz Weber
 * 
 * Permission is hereby granted, free of charge, to any person obtaining a copy
 * of this software and associated documentation files (the "Software"), to deal
 * in the Software without restriction, including without limitation the rights
 * to use, copy, modify, merge, publish, distribute, sublicense, and/or sell
 * copies of the Software, and to permit persons to whom the Software is
 * furnished to do so, subject to the following conditions:
 *
 * The above copyright notice and this permission notice shall be included in
 * all copies or substantial portions of the Software.
 *
 * THE SOFTWARE IS PROVIDED "AS IS", WITHOUT WARRANTY OF ANY KIND, EXPRESS OR
 * IMPLIED, INCLUDING BUT NOT LIMITED TO THE WARRANTIES OF MERCHANTABILITY,
 * FITNESS FOR A PARTICULAR PURPOSE AND NONINFRINGEMENT. IN NO EVENT SHALL THE
 * AUTHORS OR COPYRIGHT HOLDERS BE LIABLE FOR ANY CLAIM, DAMAGES OR OTHER
 * LIABILITY, WHETHER IN AN ACTION OF CONTRACT, TORT OR OTHERWISE, ARISING FROM,
 * OUT OF OR IN CONNECTION WITH THE SOFTWARE OR THE USE OR OTHER DEALINGS IN
 * THE SOFTWARE.
 */

namespace LoggedPDO;

if (!@include_once 'Log.php')
    throw new \Exception("Failure including Log.php\nplease install PEAR::Log or check your include_path\n");


require_once __DIR__ . DIRECTORY_SEPARATOR . 'PDOStatement.php';

/**
 * Class extending the php PDO Class for logging purpose
 * 
 * @uses Log.php
 * 
 * simple usage:
 * <code>
 * require_once 'loggedPDO/PDO.php';
 * $logger = Log::factory('console', '', 'PDO');
 * $pdo = new \LoggedPDO\PDO($connstr, DB_USERNAME, DB_PASSWORD, null, $logger);
 * </code>
 * 
 * users of a firebug logger might alternatively like the Log_firebugJSON class
 * <code>
 * require_once 'loggedPDO/Log_firebugJSON.php';
 * $logger = Log::factory('console', '', 'PDO');
 * </code>
 * 
 * 
 * {@inheritdoc}
 */
class PDO extends \PDO {

    /**
     * PEAR Log object that will be used for logging
     * @var \Log 
     */
    public $log;
    private $logFullTime;
    private $logCount;
    public static $LOG_QUERY = "query";
    public static $LOG_TIME = "time";
    public static $LOG_TYPE = "method";
    public static $LOG_PARAMS = "parameters";

    /**
     * If true, parameters will be inserted into query for logging.
     * If false, query and parameters will be logged separately.
     * @var boolean 
     */
    public $log_replace_params = true;

    /**
     * {@inheritdoc}
     * 
     * @param \Log $log a PEAR Log object that will be used for logging
     * @throws \Exception if there is no PEAR Log object specified
     */
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

    /**
     * {@inheritdoc}
     */
    public function prepare($statement, $driver_options = array()) {
        $pdostatement = parent::prepare($statement, $driver_options);

        $pdostatement->pdo = $this;
        return $pdostatement;
    }

    /**
     * {@inheritdoc}
     */
    public function query($statement) {
        $start = microtime(true);
        $pdostatement = parent::query($statement);
        $time = microtime(true) - $start;
        $this->log($statement, round($time * 1000, 3));

        $pdostatement->pdo = $this;
        return $pdostatement;
    }

    /**
     * {@inheritdoc}
     */
    public function exec($statement) {
        $start = microtime(true);
        parent::exec($statement);
        $time = microtime(true) - $start;
        $this->log($statement, round($time * 1000, 3));
    }

    /**
     * Returns the assigned PEAR logger
     * @return \Log
     */
    public function getLogger() {
        return $this->log;
    }

    /**
     * Log a query.
     * @param type $query Logged Query
     * @param type $time Time used by query
     * @param type $params Params, only if $log_replace_params is true
     */
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
                array(sprintf('query took %s ms', $time), $log)
                , PEAR_LOG_DEBUG);
    }

    /**
     * Get time spent by all logged querys until now.
     * @return float
     */
    public function getFullTime() {
        return $this->logFullTime;
    }

    /**
     * Get count of querys executed until now.
     * @return integer
     */
    public function getQueryCount() {
        return $this->logCount;
    }

}

?>
