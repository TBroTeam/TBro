<?php

namespace webservices\cart;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class DefaultCartTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('cart/DefaultCart');
        
        $results = ($service->execute(array()));
        $this->assertEquals(3, count($results));
        $this->assertEquals(array(), $results["metadata"]);
        $this->assertEquals(array(), $results["carts"]);
        $this->assertEquals(array(), $results["cartorder"]);
    }
}
?>