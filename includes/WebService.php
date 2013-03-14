<?php

if (!defined('INC')) {
    define('INC', __DIR__);
}
require_once INC . '/db.php';
require_once INC . '/constants.php';

abstract class WebService {

    abstract public static function execute($data);

    public static function output($dataArray) {
        echo self::json_indent(json_encode($dataArray));
    }

    public static function factory($servicePath) {
        $serviceBasePath = INC . DIRECTORY_SEPARATOR . 'webservices';
        

        $path = explode('/', $servicePath);
        $filepath = $serviceBasePath . DIRECTORY_SEPARATOR . $path[0];
        $serviceNamespace = '\\webservices\\'.$path[0];
        $args = array();
        for ($i = 1; $i < count($path); $i++) {
            $classname = ucfirst($path[$i]);
            $filename = $filepath . DIRECTORY_SEPARATOR . $classname . '.php';
            if (file_exists($filename)) {
                for ($j = $i + 1; $j < count($path); $j++) {
                    $args['query' . ($j - $i)] = $path[$j];
                }
                break;
            }
            $filepath .= DIRECTORY_SEPARATOR . strtolower($path[$i]);
            $serviceNamespace .= '\\' . strtolower($path[$i]);
        }
        //case: no service file found
        if (!file_exists($filename)) {
            return array(null, null);
        }
        //case: service path tries to escape from basePath
        if (!(strpos(realpath($filename), realpath($serviceBasePath)) === 0)) {
            return array(null, null);
        }
        require_once $filename;
        //case: file does not contain web service class        
        $class = $serviceNamespace . '\\' . $classname;
        if (!class_exists($class)) {
            return array(null, null);
        }

        return array(new $class, $args);
    }

    /**
     * http://recursive-design.com/blog/2008/03/11/format-json-with-php/
     * Indents a flat JSON string to make it more human-readable.
     *
     * @param string $json The original JSON string to process.
     *
     * @return string Indented version of the original JSON string.
     */
    public static function json_indent($json) {

        $result = '';
        $pos = 0;
        $strLen = strlen($json);
        $indentStr = '  ';
        $newLine = "\n";
        $prevChar = '';
        $outOfQuotes = true;

        for ($i = 0; $i <= $strLen; $i++) {

            // Grab the next character in the string.
            $char = substr($json, $i, 1);

            // Are we inside a quoted string?
            if ($char == '"' && $prevChar != '\\') {
                $outOfQuotes = !$outOfQuotes;

                // If this character is the end of an element, 
                // output a new line and indent the next line.
            } else if (($char == '}' || $char == ']') && $outOfQuotes) {
                $result .= $newLine;
                $pos--;
                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            // Add the character to the result string.
            $result .= $char;

            // If the last character was the beginning of an element, 
            // output a new line and indent the next line.
            if (($char == ',' || $char == '{' || $char == '[') && $outOfQuotes) {
                $result .= $newLine;
                if ($char == '{' || $char == '[') {
                    $pos++;
                }

                for ($j = 0; $j < $pos; $j++) {
                    $result .= $indentStr;
                }
            }

            $prevChar = $char;
        }

        return $result;
    }

}

?>
