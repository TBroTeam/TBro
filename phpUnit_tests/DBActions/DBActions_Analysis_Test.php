<?php
/**
 * @backupGlobals disabled
 */
class DBActions_Analysis_Test extends PHPUnit_Framework_TestCase {

    static $file = "../../importer/db.php";
    static $id;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    public function provider_analysis() {
        return array(
            array(__CLASS__.'Program1', __CLASS__.'Programversion1', __CLASS__.'Sourcename1', __CLASS__.'Name1', __CLASS__.'Algorithm1', '2030-12-31')
        );
    }

    /**
     * @dataProvider provider_analysis
     */
    public function testInit($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $matches = array();
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'list'));
        $ret = preg_match_all("/^(?<id>\\d*)\t$program/m", ob_get_clean(), $matches);
        foreach ($matches['id'] as $m_id) {
            $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'delete', '--id', $m_id, '--noinput'));
        }
        $this->assertEquals(0, $ret, 'was not clean; cleaned up');
    }

    /**
     * @depends testInit
     * @dataProvider provider_analysis
     */
    public function testCreate($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $matches = array();
        ob_start();
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'create', '--program', $program, '--programversion', $programversion, '--sourcename', $sourcename, '--name', $name, '--algorithm', $algorithm, '--timeexecuted', $timeexecuted));
        $ret = preg_match("/^(?<id>\\d*)\t$program\t$programversion\t$sourcename/m", ob_get_clean(), $matches);
        self::$id= $matches['id'];
        $this->assertEquals(1, $ret);
    }
    
        /**
     * @depends testCreate
     * @dataProvider provider_analysis
     */
    public function testDelete($program, $programversion, $sourcename, $name, $algorithm, $timeexecuted) {
        $this->expectOutputRegex('/1 line\(s\) affected/');
        $this->cliExecute(array(self::$file, '--table', 'analysis', '--action', 'delete', '--id', self::$id, '--noinput'));
    }

}

?>
