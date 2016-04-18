<?php

namespace webservices\listing;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class PathwaysTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/Pathways');
        
        $results = ($service->execute(array("parents"=>range(645, 655))));
        $results = $results["results"];
        $this->assertEquals(3, count($results["pathways"]));
        $this->assertEquals("Pectinesterase.", $results["components"]["3.1.1.11"]["definition"]);
    }
}
?>