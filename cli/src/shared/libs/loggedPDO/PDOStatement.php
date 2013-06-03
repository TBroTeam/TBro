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

/**
 * extended PDOStatement that logs query, parameters and run time on execution.
 * @see \LoggedPDO\PDO
 */
class PDOStatement extends \PDOStatement {

    /**
     * The respective \LoggedPDO\PDO instance that created this statement. Will be set by \LoggedPDO\PDO on creation.
     */
    public $pdo;
    private $boundParams = array();

    private function __construct() {
        
    }

    private static $PDO_PLACEHOLDER_NONE = 0;
    private static $PDO_PLACEHOLDER_NAMED = 1;
    private static $PDO_PLACEHOLDER_POSITIONAL = 2;

    /**
     * {@inheritdoc}
     * When execute is called record the time it takes and then log the query
     * Parameters will be replaced and logged, but if your query is really weird, this might fail.
     * in this case
     * @see \LoggedPDO\PDO::$log_replace_params
     */
    public function execute($bound_input_params = null) {
        $query = $this->queryString;

        if ($bound_input_params == null) {
            $params = $this->boundParams;
        }
        else {
            $params = $bound_input_params;
        }

        if ($this->pdo->log_replace_params) {
            $query_type = self::$PDO_PLACEHOLDER_NONE;
            if (preg_match('/[^:?][?][^:?]/', $query) || preg_match('/[^:?][?]/', $query)) {
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
        } catch (PDOException $e) {
            $ex = $e;
        }
        $time = microtime(true) - $start;

        $this->pdo->log($query, round($time * 1000, 3), $params);


        if ($ex != null)
            throw $ex;
        return $result;
    }

    /**
     * {@inheritdoc}
     */
    public function bindParam($parameter, &$variable, $data_type = PDO::PARAM_STR, $length = null, $driver_options = null) {
        if (is_string($parameter) && strpos($parameter, ':') === false)
            $this->boundParams[':' . $parameter] = &$variable;
        else
            $this->boundParams[$parameter] = &$variable;

        return parent::bindParam($parameter, $variable, $data_type, $length, $driver_options);
    }

    /**
     * {@inheritdoc}
     */
    public function bindValue($parameter, $value, $data_type = PDO::PARAM_STR) {
        if (is_string($parameter) && strpos($parameter, ':') === false)
            $this->boundParams[':' . $parameter] = $value;
        else
            $this->boundParams[$parameter] = $value;

        return parent::bindValue($parameter, $value, $data_type);
    }

}

?>
