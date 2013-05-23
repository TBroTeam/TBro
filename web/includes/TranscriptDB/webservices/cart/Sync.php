<?php

namespace webservices\cart;

require_once 'TranscriptDB//db.php';

class Sync extends \WebService {

    public static $regexCartName = '^[a-z0-9._ ]+$';

    public static function &get_group($groupname) {
        foreach ($_SESSION['cart']['groups'] as &$group) {
            if ($group['name'] == $groupname)
                return $group;
        }
        $nullreference = null;
        return $nullreference;
    }

    private static function groupContainsItemByFeature_id($group, $feature_id) {
        if (isset($group['items']))
        //we are a group
            $walk = $group['items'];
        else
        //we are the 'all' cart
            $walk = $group;

        foreach ($walk as $item) {
            if ($item['feature_id'] == $feature_id)
                return true;
        }
        return false;
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

    public function init() {
        if (!isset($_SESSION))
            session_start();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('all' => array(), 'groups' => array());
        }

        //if we are logged in, get our cart from the db. 
        //if we are logged in but have no cart in the db, BUT a cart in the session, this saves our session cart to the DB.
        $this->loadCart();
    }

    public function execute($querydata) {
        $this->init();

        if (isset($querydata['action']) && isset($querydata['action']['action']))
            switch ($querydata['action']['action']) {
                case 'edit_item':
                    foreach ($_SESSION['cart']['all'] as &$item) {
                        if ($item['feature_id'] == $querydata['action']['name']) {
                            foreach ($querydata['action']['values'] as $key => $value) {
                                if ($key != 'feature_id')
                                    $item[$key] = $value;
                            }
                            break;
                        }
                    }
                    unset($item);
                    break;
                case 'addGroup':
                    $newname = $querydata['action']['name'];
                    if (self::get_group($newname) != null)
                        break;
                    $_SESSION['cart']['groups'][] = array('name' => $newname, 'items' => array());
                    break;
                case 'renameGroup':
                    $newname = $querydata['action']['newname'];
                    $oldname = $querydata['action']['oldname'];
                    if ($newname == 'all')
                        break;
                    if (!preg_match('/'.self::$regexCartName.'/i', $newname))
                        break;
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
                    if (self::groupContainsItemByFeature_id($_SESSION['cart']['all'], $item['feature_id']))
                        break;
                    $_SESSION['cart']['all'][] = $item;
                    break;
                case 'addItemToGroup':
                    $feature_id = $querydata['action']['item']['feature_id'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!self::groupContainsItemByFeature_id($_SESSION['cart']['all'], $feature_id))
                        break;
                    if (self::groupContainsItemByFeature_id($group, $feature_id))
                        break;
                    $group['items'][] = array('feature_id' => $feature_id);
                    break;
                case 'removeItemFromGroup':
                    $feature_id = $querydata['action']['item']['feature_id'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    foreach ($group['items'] as $key => $item) {
                        if ($item['feature_id'] == $feature_id) {
                            unset($group['items'][$key]);
                        }
                    }
                    break;
                case 'removeItemFromAll':
                    $feature_id = $querydata['action']['item']['feature_id'];

                    foreach ($_SESSION['cart']['all'] as $key => $item) {
                        if ($item['feature_id'] == $feature_id) {
                            unset($_SESSION['cart']['all'][$key]);
                        }
                    }
                    foreach ($_SESSION['cart']['groups'] as &$group) {
                        foreach ($group['items'] as $key => $item) {
                            if ($item['feature_id'] == $feature_id) {
                                unset($group['items'][$key]);
                            }
                        }
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

}

?>
