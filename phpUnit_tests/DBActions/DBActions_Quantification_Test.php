<?php

/**
 * @backupGlobals disabled
 */
class DBActions_Quantification_Test extends PHPUnit_Framework_TestCase {

    static $file = "../../importer/db.php";
    static $data;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    /*
      edit
      requires
      --name <string>
      optional
      --acquisition_id <int:acquisition_id>
      --analsysis_id <int:analysis_id>
      --quantificationdate <timestamp>
      --uri <string> */

    public function provider_quantification() {
        return array(
            array(__CLASS__ . 'Name1', '2015-12-31', __CLASS__ . 'URI1',)
        );
    }

    public static function initDependencies() {
        $ex = null;
        self::$data = array();
        try {
            require_once('DBActions_Acquisition_Test.php');
            self::$data['acquisitiontest'] = new DBActions_Acquisition_Test();
            $paq = self::$data['acquisitiontest']->provider_acquisition();
            self::$data['acquisitiontest_data'] = $paq[0];
            call_user_func_array(array(self::$data['acquisitiontest'], 'testInit'), self::$data['acquisitiontest_data']);
            call_user_func_array(array(self::$data['acquisitiontest'], 'testCreate'), self::$data['acquisitiontest_data']);
        } catch (Exception $e) {
            $ex = $e;
        }
        try {
            require_once('DBActions_Analysis_Test.php');
            self::$data['analysistest'] = new DBActions_Analysis_Test();
            $pan = self::$data['analysistest']->provider_analysis();
            self::$data['analysistest_data'] = $pan[0];
            call_user_func_array(array(self::$data['analysistest'], 'testInit'), self::$data['analysistest_data']);
            call_user_func_array(array(self::$data['analysistest'], 'testCreate'), self::$data['analysistest_data']);
        } catch (Exception $e) {
            $ex = $e;
        }
        if ($ex != null)
            throw $ex;
    }

    public static function clearDependencies() {
        call_user_func_array(array(self::$data['acquisitiontest'], 'testDelete'), self::$data['acquisitiontest_data']);
        call_user_func_array(array(self::$data['analysistest'], 'testDelete'), self::$data['analysistest_data']);
    }

    /**
     * @dataProvider provider_quantification
     */
    public function testInit($name, $quantificationdate, $uri) {
        try {
            self::initDependencies();
        } catch (Exception $e) {
            
        }
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'quantification', '--action', 'list'));
        $this->assertEquals(0, preg_match("/$name/", ob_get_clean()));
    }

    /**
     * @depends testInit
     * @dataProvider provider_quantification
     */
    public function testCreate($name, $quantificationdate, $uri) {
        $this->expectOutputRegex("/$name\t" . DBActions_Acquisition_Test::$id . "\t" . DBActions_Analysis_Test::$id . "\t$quantificationdate [^\t]*\t$uri/");
        $this->cliExecute(array(self::$file, '--table', 'quantification', '--action', 'create', '--name', $name, '--acquisition_id', DBActions_Acquisition_Test::$id, '--analysis_id', DBActions_Analysis_Test::$id, '--quantificationdate', $quantificationdate, '--uri', $uri));
    }

    /**
     * @dataProvider provider_quantification
     */
    public function testDelete($name, $quantificationdate, $uri) {
        self::clearDependencies();
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'quantification', '--action', 'delete', '--name', $name, '--noinput'));
    }

}

?>
