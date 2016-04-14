<?php

require_once 'TranscriptDB/db.php';

/**
 * Abstract Base class for all web services.
 */
abstract class WebService {

    /**
     * Executes the web service.
     * @param Array $data User-specified parameters. Usually, url parameters are included as $data[query1], $data[query2],... and $_GET and _POST are merged in
     */
    abstract public function execute($data);

    /**
     * ouputs $dataArray as (on php>=5.4 pretty) JSON
     * @param Array $dataArray
     */
    public static function output($dataArray) {
        if(!is_null($dataArray)){
            echo json_encode($dataArray, defined('JSON_PRETTY_PRINT')?JSON_PRETTY_PRINT:0);
        }
    }

    /**
     * factory method for all web services
     * creates an instance of the class called by querystring. additional parameters are returned in $parameters as query1, query2, etc.
     * e.g. 
     * <code>
     * WebService::factory('details/isoform/12345');
     * // => 
     * return array(new \webservices\details\Isoform(), array('query1'=>'12345'));
     * </code>
     * @param String $servicePath
     * @return list($instance, $parameters)
     */
    public static function factory($servicePath) {
        $serviceBasePath = __DIR__ . DIRECTORY_SEPARATOR . 'webservices';

        //search in ./$path[0]/.../($path[x])/ for ucfirst($path[x+1]).php.
        $path = explode('/', $servicePath);
        $filepath = $serviceBasePath . DIRECTORY_SEPARATOR . $path[0];
        $serviceNamespace = '\\webservices\\' . $path[0];
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
        if (!isset($filename) || !file_exists($filename)) {
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


}

?>
