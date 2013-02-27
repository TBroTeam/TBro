<?php

/**
 * @backupGlobals disabled
 */
class DBActions_Assay_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";
    static $data;
    static $id;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_assay() {
        return array(
            array(__CLASS__.'Name1', __CLASS__.'Description1', 'GO:'.__CLASS__.'1', '2015-12-31')
        );
    }

    public static function initDependencies() {
        $ex = null;
        try {
            self::$data = array();
            require_once('DBActions_Biomaterial_Test.php');
            self::$data['biotest'] = new DBActions_Biomaterial_Test();
            $pb = self::$data['biotest']->provider_biomaterial();
            self::$data['biotest_data'] = $pb[0];
            call_user_func_array(array(self::$data['biotest'], 'testInit'), self::$data['biotest_data']);
            call_user_func_array(array(self::$data['biotest'], 'testCreate'), self::$data['biotest_data']);
        } catch (Exception $e) {
            $ex = $e;
        }
        try {
            require_once('DBActions_Contact_Test.php');
            self::$data['contacttest'] = new DBActions_Contact_Test();
            $pc = self::$data['contacttest']->provider_contact();
            self::$data['contacttest_data'] = $pc[0];
            call_user_func_array(array(self::$data['contacttest'], 'testInit'), self::$data['contacttest_data']);
            call_user_func_array(array(self::$data['contacttest'], 'testCreate'), self::$data['contacttest_data']);
        } catch (Exception $e) {
            $ex = $e;
        }
        if ($ex != null)
            throw $ex;
    }

    public static function clearDependencies() {
        call_user_func_array(array(self::$data['biotest'], 'testDelete'), self::$data['biotest_data']);
        call_user_func_array(array(self::$data['contacttest'], 'testDelete'), self::$data['contacttest_data']);
    }

    /**
     * @dataProvider provider_assay
     */
    public function testInit($name, $description, $dbxref, $assaydate) {
        self::initDependencies();
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'assay', '--action', 'list'));
        $this->assertEquals(0, preg_match("/$name/", ob_get_clean()));
    }

    /**
     * @depends testInit
     * @dataProvider provider_assay
     */
    public function testCreate($name, $description, $dbxref, $assaydate) {
        $matches = array();
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'assay', '--action', 'create', '--name', $name, '--operator_id', DBActions_Contact_Test::$id, '--description', $description, '--dbxref', $dbxref, '--assaydate', $assaydate));
        $ret = preg_match("/^(?<id>\\d*)\t$name\t" . DBActions_Contact_Test::$id . "\t$description\t$assaydate [^\t]*\t$dbxref/m", ob_get_clean(), &$matches);
        self::$id= $matches['id'];
        $this->assertEquals(1, $ret);
    }

    /**
     * @depends testCreate
     * @dataProvider provider_assay
     */
    public function testLinkBiomaterial($name, $description, $dbxref, $assaydate) {
        $this->expectOutputRegex("/" . self::$data['biotest_data'][0] . "/");
        $this->cliExecute(array(self::$file, '--table', 'assay', '--action', 'edit', '--name', $name, '--link-biomaterial', self::$data['biotest_data'][0]));
    }
    
    /**
     * @dataProvider provider_assay
     */
    public function testUnlinkBiomaterial($name, $description, $dbxref, $assaydate) {
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'assay', '--action', 'edit', '--name', $name, '--unlink-biomaterial', self::$data['biotest_data'][0]));
        $this->assertEquals(0, preg_match("/" . self::$data['biotest_data'][0] . "\t/", ob_get_flush()));
    }

    /**
     * @dataProvider provider_assay
     */
    public function testDelete($name, $description, $dbxref, $assaydate) {
        self::clearDependencies();
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'assay', '--action', 'delete', '--name', $name, '--noinput'));
    }

}

?>
