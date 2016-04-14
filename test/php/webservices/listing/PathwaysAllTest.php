<?php

namespace webservices\listing;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';

/**
 * @backupGlobals disabled
 */
class PathwaysAllTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/PathwaysAll');
        
        $results = ($service->execute(array()));
        $results = $results["results"];
        sort($results);
        $this->assertEquals(392, count($results));
        $this->assertEquals("Amino sugar and nucleotide sugar metabolism", $results[12]);
    }
}
?>