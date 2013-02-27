<?php

/**
 * @backupGlobals disabled
 */
class DBActions_Acquisition_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";
    static $data;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_acquisition() {
        return array(
            array(__CLASS__ . 'Name1', '2015-12-31', __CLASS__ . 'URI1',)
        );
    }

    public static function initDependencies() {
        $ex = null;
        try {
            self::$data = array();
            require_once('DBActions_Assay_Test.php');
            self::$data['assaytest'] = new DBActions_Assay_Test();
            $pb = self::$data['assaytest']->provider_assay();
            self::$data['assaytest_data'] = $pb[0];
            call_user_func_array(array(self::$data['assaytest'], 'testInit'), self::$data['assaytest_data']);
            call_user_func_array(array(self::$data['assaytest'], 'testCreate'), self::$data['assaytest_data']);
        } catch (Exception $e) {
            $ex = $e;
        }
        if ($ex != null)
            throw $ex;
    }

    public static function clearDependencies() {
        call_user_func_array(array(self::$data['assaytest'], 'testDelete'), self::$data['assaytest_data']);
    }

    /**
     * @dataProvider provider_acquisition
     */
    public function testInit($name, $acquisitiondate, $uri) {
        self::initDependencies();
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'acquisition', '--action', 'list'));
        $this->assertEquals(0, preg_match("/$name/", ob_get_clean()));
    }

    /**
     * @depends testInit
     * @dataProvider provider_acquisition
     */
    public function testCreate($name, $acquisitiondate, $uri) {
        $this->expectOutputRegex("/$name\t" . DBActions_Assay_Test::$id . "\t$acquisitiondate [^\t]*/");
        $this->cliExecute(array(self::$file, '--table', 'acquisition', '--action', 'create', '--name', $name, '--assay_id', DBActions_Assay_Test::$id, '--acquisitiondate', $acquisitiondate));
    }

    /**
     * @dataProvider provider_acquisition
     */
    public function testDelete($name, $acquisitiondate, $uri) {
        self::clearDependencies();
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'acquisition', '--action', 'delete', '--name', $name, '--noinput'));
    }

}

?>
