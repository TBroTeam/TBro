<?php

/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class DBActions_Biomaterial_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_biomaterial() {
        return array(
            array('phpUnitTestName1', 'phpUnitDescription1', 'GO:PhpUnitTest1')
        );
    }

    /**
     * @dataProvider provider_biomaterial
     */
    public function testInit($name, $description, $dbxref)  {
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'list'));
        $this->assertEquals(0, preg_match("/$name/", ob_get_clean()));
    }

    /**
     * @depends testInit
     * @dataProvider provider_biomaterial
     */
    public function testCreate($name, $description, $dbxref)  {
        $this->expectOutputRegex("/$name\t$description\t$dbxref/");
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'create', '--name', $name, '--description', $description, '--dbxref', $dbxref));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_biomaterial
     */
    public function testShow($name, $description, $dbxref)  {
        $this->expectOutputRegex("/$name\t$description\t$dbxref/");
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'show', '--name', $name));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_biomaterial
     */
    public function testList($name, $description, $dbxref)  {
        $this->expectOutputRegex("/$name/");
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'list'));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_biomaterial
     * @expectedException PDOException
     */
    public function testCreateDuplicate($name, $description, $dbxref)  {
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'create', '--name', $name, '--description', $description."_different"));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_biomaterial
     */
    public function testEdit($name, $description, $dbxref)  {
        $this->expectOutputRegex("/$name\t${description}_2/");
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'edit', '--name', $name, '--description', $description . '_2'));
    }

    /**
     * @dataProvider provider_biomaterial
     */
    public function testDelete($name, $description, $dbxref)  {
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'biomaterial', '--action', 'delete', '--name', $name, '--noinput'));
    }

}

?>
