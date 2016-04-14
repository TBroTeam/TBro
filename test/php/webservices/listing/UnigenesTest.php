<?php

namespace webservices\listing;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class UnigenesTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/Unigenes');
        
        $results = ($service->execute(array("terms"=>array(1,2,3,4,5))));
        # This demo dataset contains no unigenes, we need another test database for better testing
        $this->assertEquals(0, count($results));
    }
}
?>