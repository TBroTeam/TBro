<?php

#define('DEBUG', true);
require '../importer/includes/db_actions.php';


/**
 * @backupGlobals disabled
 * @backupStaticAttributes disabled
 */
class DBActions_Biomaterial_Test extends PHPUnit_Framework_TestCase {

    private $data;
    
    public function provider_biomaterial() {
        return array(
            array('phpUnitTestName1', 'phpUnitDescription1', 'GO:PhpUnitTest1')
        );
    }

    /**
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_init($name, $description, $dbxref) {
        $this->data = array('name' => $name, 'description' => $description, 'dbxref' => $dbxref);
        $this->assertNotContains(array('name' => $name), biomaterial_list(), 'database not clean for testing!');
    }

    /**
     * @depends test_biomaterial_init
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_create($name, $description, $dbxref){
        biomaterial_create($name, array('--description' => $description, '--dbxref' => $dbxref));
                var_dump(biomaterial_show($name));
        $this->assertEquals(
                array('name' => $name, 'description' => $description, 'dbxref_id' => $dbxref.'()')
                , biomaterial_show($name)
                , 'value not inserted');
    }

    /**
     * @depends test_biomaterial_create
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_show($name, $description, $dbxref){

        $this->expectOutputRegex("/$name\t$description\t$dbxref/");
        biomaterial_show($name);
    }

    /**
     * @depends test_biomaterial_create
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_list($name, $description, $dbxref){
        $this->expectOutputRegex("/$name/");
        biomaterial_list();
    }

    /**
     * @depends test_biomaterial_create
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_edit($name, $description, $dbxref){
        $description .= '_2';
        $dbxref .= '_2';
        biomaterial_edit($name, array('--description' => $description, '--dbxref' => $dbxref));
        $this->assertEquals(
                array('name' => $name, 'description' => $description, 'dbxref_id' => $dbxref.'()')
                , biomaterial_show($name)
                , 'value not edited');
    }

    /**
     * @depends test_biomaterial_create
     * @dataProvider provider_biomaterial
     * @expectedException PDOException
     */
    public function test_biomaterial_duplicateKey($name, $description, $dbxref){
        biomaterial_create($name, array('--description' => 'foo'));
    }

    /**
     * @dataProvider provider_biomaterial
     */
    public function test_biomaterial_delete($name, $description, $dbxref){

        $this->assertEquals(1, biomaterial_delete($name));
        $this->assertNotContains(array('name' => $name, 'description' => $description), biomaterial_list(), 'value not deleted');
        $this->assertEquals(0, biomaterial_delete($name));
    }

}

?>
