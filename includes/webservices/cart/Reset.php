<?php

namespace webservices\cart;

class Reset extends \WebService {

    public function execute($querydata) {
        session_start();

        $_SESSION['cart'] = array('all' => array(), 'groups' => array());

        return array($_SESSION['cart']);
    }

}

?>
