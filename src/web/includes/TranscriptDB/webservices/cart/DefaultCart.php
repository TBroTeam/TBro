<?php

namespace webservices\cart;

require_once 'TranscriptDB//db.php';

/**
 * Web Service.
 * Returns default cart as json object
 */
class DefaultCart extends \WebService {

    /**
     * Loads default cart from database (if possible), otherwise returns empty cart.
     * @global \PDO $db
     * @return nothing
     */
    private function loadDefaultCart() {
        if ((!isset($_SESSION['OpenID']) || empty($_SESSION['OpenID'])) && !defined('DEFAULT_CART_OPENID')){
            return array('metadata' => array(), 'carts' => array(), 'cartorder' => array());
        }

        global $db;
        if (false)
            $db = new \PDO();

        $stm_retrieve_cart = $db->prepare('SELECT value FROM webuser_data WHERE identity=:identity AND type_id=:type_cart');
        $stm_retrieve_cart->bindValue('type_cart', WEBUSER_CART);
        $stm_retrieve_cart->bindValue('identity', DEFAULT_CART_OPENID);

        $stm_retrieve_cart->execute();
        if ($stm_retrieve_cart->rowCount() == 1) {
            $row = $stm_retrieve_cart->fetch(\PDO::FETCH_ASSOC);
            return json_decode($row['value'], true);
        } else {
            return array('metadata' => array(), 'carts' => array(), 'cartorder' => array());
        }
    }

    public function execute($querydata) {
        return $this->loadDefaultCart();
    }
}

?>