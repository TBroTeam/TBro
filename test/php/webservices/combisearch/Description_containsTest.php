<?php

namespace webservices\combisearch;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class Description_containsTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('combisearch/Description_contains');
        
        $results = ($service->execute(array("species"=>13, "release"=>"1.CasaPuKu", "term"=>"blue")));
        $results = $results["results"];
        sort($results);
        $this->assertEquals(12, count($results));
        $exp = array(381,5212,6428,6534,7119,11154,11768,15446,17584,20379,30724,31023);
        sort($exp);
        $this->assertEquals($exp, $results);
    }
}
?>