<?php

/**
 * @backupGlobals disabled
 */
class DBActions_Assay_Test extends PHPUnit_Framework_TestCase {

    static $file = "../importer/db.php";
    static $data;

    public function cliExecute($args) {
        global $argc, $argv;
        $argv = $args;
        $argc = count($args);
        require $argv[0];
    }

    
                /*requires
                --name <string>
            optional
                --operator_id <int:contact_id>
                --description <string>
                --assaydate <timestamp>
                --dbxref <string:'DBNAME:ACCESSION'>
                --add-biomaterial <string:biomaterial_name>
                --delete-biomaterial <string:biomaterial_name>*/
    public function provider_assay() {
        return array(
            array('phpUnitTestName1', 'phpUnitTestOperatorId1', 'GO:PhpUnitTest1')
        );
    }
    
    public function setUpbeforeClass(){
        parent::setUpBeforeClass();
        self::$data = array();
        require_once('DBActions_Biomaterial_Test');
        self::$data['biotest'] = new DBActions_Biomaterial_Test();
        $provider = self::$data['biotest']->provider_biomaterial();
        self::$data['biotest_data'] = $provider[0];
        call_user_func_array(array(self::$data['biotest'], 'testInit'), self::$data['biotest_data']);
        call_user_func_array(array(self::$data['biotest'], 'testCreate'), self::$data['biotest_data']);
    }
    
    
    
    public function tearDownAfterClass(){
        parent::tearDownAfterClass();
        call_user_func_array(array(self::$data['biotest'], 'testDelete'), self::$data['biotest_data']);
    }
}

?>
