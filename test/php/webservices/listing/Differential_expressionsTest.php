<?php

namespace webservices\listing;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';
require_once __DIR__ . '/overload_session_start_function.php';

/**
 * @backupGlobals disabled
 */
class Differential_expressionsTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/Differential_expressions');
        
        $results = ($service->execute(array(
            "organism"=>13,
            "release"=>"1.CasaPuKu",
            "query1"=>"fullRelease",
            "analysis"=>24,
            "quantification"=>1,
            "conditionA"=>14,
            "conditionB"=>17,
            "filter_column"=>array(),
            "iDisplayStart"=>0,
            "iDisplayLength"=>10,
            "sEcho"=>0,
        )));
        $this->assertEquals(33215, $results["iTotalRecords"]);
        $this->assertEquals(10, count($results["aaData"]));
        $this->assertEquals(6, count($results["query_details"]));
    }
}
?>