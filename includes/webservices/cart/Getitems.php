<?php

namespace webservices\cart;

require_once INC . '/db.php';
require_once __DIR__ . '/Sync.php';

class Getitems extends \WebService {

    public function execute($querydata) {
        //make sure cart is in session
        $sync = new Sync();
        $sync->init();
        $groupname = $querydata['query1'];
        if ($groupname == 'all') {
            return $_SESSION['cart']['all'];
        } else {
            $group = $sync->get_group($groupname);
            if ($group != null) {
                //group needs to be filled with items from "all" cart for metadata to be available
                $all = array();
                foreach ($_SESSION['cart']['all'] as &$item) {
                    $all[$item['uniquename']] = $item;
                }
                unset($item);

                $retgroup = array();
                foreach ($group['items'] as $item){
                    $retgroup[] = $all[$item['uniquename']];
                }
                
                return $retgroup;
            }
        }
        return array();
    }

}

?>
