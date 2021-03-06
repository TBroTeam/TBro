<?php

namespace webservices\listing;

require_once __DIR__ . '/../../config.php';
require_once __DIR__ . '/../../../db/cvterms.php';
require_once __DIR__ . '/overload_session_start_function.php';

/**
 * @backupGlobals disabled
 */
class SearchboxTest extends \PHPUnit_Framework_TestCase
{
    public function testExecute()
    {
        list($service) = \WebService::factory('listing/Searchbox');
        
        $results = ($service->execute(array("species"=>13, "release"=>"1.CasaPuKu", "term"=>"bla")));
        $results = $results["results"];
        usort($results, array($this, "cmp"));
        $this->assertEquals(6, count($results));
        $this->assertEquals(array('hit'=>'retinoblastoma-related protein', 'type'=>'description', 'id'=>1099, 'name'=>'gi|351628378|gb|JP481261.1|'), $results[0]);
    }
    
    private function cmp($a, $b)
    {
        if ($a['id'] == $b['id']) {
            return 0;
        }
        return ($a['id'] < $b['id']) ? -1 : 1;
    }
}
?>