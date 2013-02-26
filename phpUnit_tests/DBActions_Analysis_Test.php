<?php

/**
 * @backupGlobals disabled
 * @qwbasdackupStaticAttributes enabled
 */
class DBActions_Analysis_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";
    private static $id;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_analysis() {
        return array(
            array('phpUnitTest1Program', 'phpUnitTest1Programversion', 'phpUnitTest1Sourcename', 'phpUnitTest1Name', 'phpUnitTest1Algorithm', '2030-12-31')
        );
    }

    /**
     * @dataProvider provider_analysis
     */
    public function testInit($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        self::$id=5;
        $matches = null;
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'list'));
        $preg_res = preg_match("/^(?<id>\\d*)\t$program/m", ob_get_clean(), &$matches);
        //if this test fails, this will allow testDelete to clean up successfully
        self::$id = $matches['id']; 
        $this->assertEquals(0, $preg_res);
    }

    /**
     * @depends testInit
     * @dataProvider provider_analysis
     */
    public function testCreate($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $matches = null;
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'create', '--program', $program, '--programversion', $programversion, '--sourcename', $sourcename));
        $this->assertEquals(1, preg_match("/^(?<id>\\d*)\t$program\t$programversion\t$sourcename\t$name\t$algorithm\t$timeexecuted\$/m", ob_get_flush(), &$matches));
        self::$id = $matches['id'];
    }

    /**
     * @depends testCreate
     * @dataProvider provider_analysis
     */
    public function testShow($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $this->expectOutputRegex("/$name\t$description/");
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'show', '--name', $name));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_analysis
     */
    public function testList($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $this->expectOutputRegex("/$name/");
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'list'));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_analysis
     * @expectedException PDOException
     */
    public function testCreateDuplicate($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'create', '--name', $name, '--description', $description . "_different"));
    }

    /**
     * @depends testCreate
     * @dataProvider provider_analysis
     */
    public function testEdit($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $this->expectOutputRegex("/$name\t${description}_2/");
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'edit', '--name', $name, '--description', $description . '_2'));
    }

    /**
     * @dataProvider provider_analysis
     */
    public function testDelete($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        echo "testing Delete".self::$id;
        
        
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'delete', '--id', $this->id, '--noinput'));
    }

}

?>
