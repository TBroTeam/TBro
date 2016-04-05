<?php
require_once __DIR__ . DIRECTORY_SEPARATOR . 'config.php';
require_once __DIR__ . DIRECTORY_SEPARATOR . '../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class OrganismsTest extends PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/Organism_release');
        
        $results = ($service->execute(array()));
        $this->assertEquals(2, count($results["results"]));
        $this->assertEquals(array(13 => array("organism_name" => "Weed", "organism_id" => 13)), $results["results"]["organism"]);
        $this->assertEquals(array(13 => array("1.CasaPuKu" => array("release" => "1.CasaPuKu"))), $results["results"]["release"]);
    }
}
?>