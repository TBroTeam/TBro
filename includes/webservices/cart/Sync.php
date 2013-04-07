<?php

namespace webservices\cart;

require_once INC . '/db.php';

class Sync extends \WebService {

    private static function &get_group($groupname) {
        foreach ($_SESSION['cart']['groups'] as &$group) {
            if ($group['name'] == $groupname)
                return $group;
        }
        $x = null;
        return $x;
    }

    private function loadCart() {
        if (!isset($_SESSION['OpenID']) || empty($_SESSION['OpenID']))
            return;

        global $db;
        if (false)
            $db = new \PDO();

        $stm_retrieve_cart = $db->prepare('SELECT value FROM webuser_data WHERE identity=:identity AND type_id=:type_cart');
        $stm_retrieve_cart->bindValue('type_cart', WEBUSER_CART);
        $stm_retrieve_cart->bindValue('identity', $_SESSION['OpenID']);
        $stm_retrieve_cart->execute();
        if ($stm_retrieve_cart->rowCount() == 1) {
            $row = $stm_retrieve_cart->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['cart'] = unserialize($row['value']);
        }
        else {
            $this->saveCart();
        }
    }

    private function saveCart() {
        if (!isset($_SESSION['OpenID']) || empty($_SESSION['OpenID']))
            return;

        global $db;
        if (false)
            $db = new \PDO();

        $stm_save_cart = $db->prepare('UPDATE webuser_data SET value=:value WHERE  identity=:identity AND type_id=:type_cart');
        $stm_save_cart->bindValue('value', serialize($_SESSION['cart']));
        $stm_save_cart->bindValue('type_cart', WEBUSER_CART);
        $stm_save_cart->bindValue('identity', $_SESSION['OpenID']);
        $stm_save_cart->execute();
        if ($stm_save_cart->rowCount() == 1)
            return;
        
        $stm_insert_cart = $db->prepare('INSERT INTO webuser_data (identity, type_id, value) VALUES (:identity, :type_cart, :value)');
        $stm_insert_cart->bindValue('value', serialize($_SESSION['cart']));
        $stm_insert_cart->bindValue('type_cart', WEBUSER_CART);
        $stm_insert_cart->bindValue('identity', $_SESSION['OpenID']);
        $stm_insert_cart->execute();
    }

    public function execute($querydata) {
        if (!isset($_SESSION))
            session_start();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('all' => array(), 'groups' => array());
        }

        
        //if we are logged in, get our cart from the db. 
        //if we are logged in but have no cart in the db, BUT a cart in the session, this saves our session cart to the DB.
        $this->loadCart();
        
        if (isset($querydata['action']) && isset($querydata['action']['action']))
            switch ($querydata['action']['action']) {
                case 'addGroup':
                    $newname = $querydata['action']['name'];
                    if (self::get_group($newname) != null)
                        break;
                    $_SESSION['cart']['groups'][] = array('name' => $newname, 'items' => array());
                    break;
                case 'renameGroup':
                    $newname = $querydata['action']['newname'];
                    $oldname = $querydata['action']['oldname'];
                    $group = &self::get_group($oldname);
                    if (self::get_group($newname) != null || $group == null)
                        break;
                    $group['name'] = $newname;
                    break;
                case 'removeGroup':
                    $groupname = $querydata['action']['groupname'];
                    foreach ($_SESSION['cart']['groups'] as $key => $group) {
                        if ($group['name'] == $groupname)
                            unset($_SESSION['cart']['groups'][$key]);
                    }
                    $_SESSION['cart']['groups'] = array_values($_SESSION['cart']['groups']);
                    break;
                case 'addItemToAll':
                    $item = $querydata['action']['item'];
                    if (self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    $_SESSION['cart']['all'][] = $item;
                    break;
                case 'addItemToGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    if (self::array_in_array($item, $group))
                        break;
                    $group['items'][] = $item;
                    break;
                case 'removeItemFromGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!self::array_in_array($item, $group['items']))
                        break;
                    $group['items'] = self::array_diff_rec($group['items'], array($item));
                    break;
                case 'removeItemFromAll':
                    $item = $querydata['action']['item'];
                    if (!self::array_in_array($item, $_SESSION['cart']['all']))
                        break;
                    $_SESSION['cart']['all'] = self::array_diff_rec($_SESSION['cart']['all'], array($item));

                    foreach ($_SESSION['cart']['groups'] as &$group) {
                        if (!self::array_in_array($item, $group['items']))
                            continue;
                        $group['items'] = self::array_diff_rec($group['items'], array($item));
                    }
                    break;
                case 'resetCart':
                    $_SESSION['cart'] = array('all' => array(), 'groups' => array());
                    break;
            }

        //if we are logged in: save our cart back to the DB
        $this->saveCart();

        return array('syncTime' => isset($querydata['syncRequestTime']) ? $querydata['syncRequestTime'] : -1, 'cart' => $_SESSION['cart']);
    }

    /*
     * in_array either checks string representation or exact match (which wants exact key order). 
     * this function allows for different key order in $needle and $straw
     */

    private static function array_in_array($needle, $haystack) {
        foreach ($haystack as $straw) {
            // see array equality http://php.net/manual/en/language.operators.array.php
            if ($straw == $needle)
                return true;
        }
        return false;
    }

    private static function array_diff_rec($first, $second) {
        $ret = array();
        foreach ($first as $f) {
            if (!self::array_in_array($f, $second))
                $ret[] = $f;
        }
        return $ret;
    }

}

?>
