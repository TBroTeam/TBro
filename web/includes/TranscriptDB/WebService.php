<?php

require_once 'TranscriptDB/db.php';

abstract class WebService {

    abstract public function execute($data);

    public static function output($dataArray) {
        echo json_encode($dataArray, JSON_PRETTY_PRINT);
    }

    public static function factory($servicePath) {
        $serviceBasePath = __DIR__ . DIRECTORY_SEPARATOR . 'webservices';

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
