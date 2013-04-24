<?php

// we're using GetOptionKit from https://github.com/c9s/php-GetOptionKit
// install it via
// pear channel-discover pear.corneltek.com
// pear install corneltek/GetOptionKit
require 'GetOptionKit/SplClassLoader.php';

foreach (get_required_files() as $filename) {
    if (strpos($filename, 'GetOptionKit/SplClassLoader.php') !== FALSE) {
        $classLoader = new GetOptionKit\SplClassLoader('GetOptionKit', dirname($filename) . '/../');
        $classLoader->register();
        break;
    }
}


// we're using the PEAR Log package
require_once 'Log.php';

require_once __DIR__ . '/../constants.php';
require_once INC . '/libs/php-progress-bar.php';

abstract class AbstractImporter {

    abstract protected function calledFromShell();

    abstract function import($options);

    protected function sharedHelp() {
        $name = $this->getName();
        $filename = $_SERVER['SCRIPT_FILENAME'];

        $options = implode(PHP_EOL, $this->getopt->specs->outputOptions('OptionPrinter'));
        return <<<EOF
$name
----
usage: 
        $filename --help
        $filename [options] --organism_id <ID> --import_prefix <PREFIX> --file <filename>
            

$options


EOF;
    }

    abstract function help();

    abstract protected function getName();

    private $log;
    private $lineCount;
    private $announce_steps = 200;

    function __construct() {
        $this->log = Log::factory('console', '', 'Importer');
    }

    protected function dieOnError($error) {
        $this->log->log($error, PEAR_LOG_ERR);
        die();
    }

    protected function setLineCount($count) {
        $this->lineCount = $count;
    }

    protected function updateProgress($current_count) {
        if ($current_count % $this->announce_steps != 0)
            return;
        php_progress_bar_show_status($current_count, $this->lineCount, 80);
    }

    protected function require_parameter($options, $param_names) {
        foreach ($param_names as $param_name)
            if (!isset($options[$param_name])) {
                $this->dieOnError(sprintf('option --%s has to be set', $param_name));
            }
    }

    protected $longopts = array(
        "help",
        "debug",
        "file:",
        "organism_id:",
        "import_prefix:",
    );
    protected $options;
    private $getopt;

    protected function register_getopt($getopt) {
        $getopt->add('h|help', 'displays this page');
        $getopt->add('d|debug', 'enables debug mode (queries will be output to console)');

        $getopt->add('o|organism-id:=i', 'id of the organism this import is for');
        $getopt->add('p|import-prefix:=s', 'this will be used as prefix for all uniquenames and displayed in the "dataset" dropdown');
        $getopt->add('f|file+', 'specifies the file to import');
    }

    function fromShell() {

        $this->getopt = new GetOptionKit\GetOptionKit();
        $this->register_getopt($this->getopt);
        global $argv;
        try {
            $options = $this->getopt->parse($argv);
        } catch (Exception $e) {
            $this->dieOnError($e->getMessage());
        }

        $this->options = array();
        foreach ($options as $key => $values) {
            $this->options[$key] = $values;
        }

        if (isset($this->options['help'])) {
            die("\n\n" . $this->help() . "\n\n");
        }


        $this->require_parameter($this->options, array('file', 'organism-id', 'import-prefix'));

        define('DB_ORGANISM_ID', $this->options['organism-id']);
        define('IMPORT_PREFIX', $this->options['import-prefix']);

        foreach ($options['file']->value as $filename) {
            if (!file_exists($filename))
                $this->dieOnError(sprintf('file %s does not exist', $filename));
        }

        if (isset($this->options['debug'])) {
            define('DEBUG', true);
        } else {
            define('DEBUG', false);
        }

        require_once INC . '/db.php';
        global $db;
        $db->log = $this->log;

        $results = array();
        try {
            foreach ($options['file']->value as $filename) {
                $this->options['file'] = $filename;
                $results[] = $this->calledFromShell();
            }
        } catch (Exception $e) {
            $this->dieOnError($e->getMessage());
        }

        print "\n";

        foreach ($results as $result)
            foreach ($result as $key => $value) {
                printf("% -30s| %s\n", $key, $value);
            }
    }

}

/*
 * This is derived from OptionPrinter, which is part of the GetOptionKit package.
 * It has been modified to use another width for outputOptions, and to display the options left-handed
 * this is necessary due to a bug in OptionSpecCollection.php, Line 135 ($width is not passed through)
 *
 * (c) Yo-An Lin <cornelius.howl@gmail.com>
 *
 * For the full copyright and license information, please view the LICENSE
 * file that was distributed with this source code.
 *
 */

class OptionPrinter implements GetOptionKit\OptionPrinterInterface {

    public $specs;

    function __construct(GetOptionKit\OptionSpecCollection $specs) {
        $this->specs = $specs;
    }

    /**
     * render option descriptions
     *
     * @param integer $width column width
     * @return string output
     */
    function outputOptions($width = 35) {
        # echo "* Available options:\n";
        $lines = array();
        foreach ($this->specs->all() as $spec) {
            $c1 = $spec->getReadableSpec();
            if (strlen($c1) > $width) {
                $line = sprintf("% -{$width}s", $c1) . "\n" . $spec->description;  # wrap text
            } else {
                $line = sprintf("% -{$width}s   %s", $c1, $spec->description);
            }
            $lines[] = $line;
        }
        return $lines;
    }

    /**
     * print options descriptions to stdout
     *
     */
    function printOptions() {
        $lines = $this->outputOptions();
        echo join("\n", $lines);
    }

}

?>
