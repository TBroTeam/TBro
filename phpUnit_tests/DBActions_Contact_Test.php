<?php

/**
 * @backupGlobals disabled
 */
class DBActions_Contact_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_contact() {
        return array(
            array('phpUnitTestName1', 'phpUnitDescription1')
        );
    }

    /**
     * @dataProvider provider_contact
     */
    public function testInit($name, $description) {
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'list'));
        $this->assertEquals(0, preg_match("/$name/", ob_get_clean()));
    }

    /**
     * @depends testInit
     * @dataProvider provider_contact
     */
    public function testCreate($name, $description) {
        $this->expectOutputRegex("/$name\t$description/");
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'create', '--name', $name, '--description', $description));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_contact
     */
    public function testShow($name, $description) {
        $this->expectOutputRegex("/$name\t$description/");
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'show', '--name', $name));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_contact
     */
    public function testList($name, $description) {
        $this->expectOutputRegex("/$name/");
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'list'));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_contact
     * @expectedException PDOException
     */
    public function testCreateDuplicate($name, $description) {
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'create', '--name', $name, '--description', $description."_different"));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_contact
     */
    public function testEdit($name, $description) {
        $this->expectOutputRegex("/$name\t${description}_2/");
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'edit', '--name', $name, '--description', $description . '_2'));
    }

    /**
     * @dataProvider provider_contact
     */
    public function testDelete($name, $description) {
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'contact', '--action', 'delete', '--name', $name, '--noinput'));
    }

}

?>
