<?php

namespace webservices\cart;

require_once 'TranscriptDB//db.php';

class Sync extends \WebService {

    public static $regexCartName = '^[a-z0-9._ ]+$';


    private function loadCart() {
        if (!isset($_SESSION['OpenID']) || empty($_SESSION['OpenID']))
            return;

        global $db;
        if (false)
            $db = new \PDO();

        $stm_retrieve_cart = $db->prepare('SELECT value FROM webuser_data WHERE identity=:identity AND type_id=:type_cart FOR UPDATE');
        $stm_retrieve_cart->bindValue('type_cart', WEBUSER_CART);
        $stm_retrieve_cart->bindValue('identity', $_SESSION['OpenID']);

        $stm_retrieve_cart->execute();
        if ($stm_retrieve_cart->rowCount() == 1) {
            $row = $stm_retrieve_cart->fetch(\PDO::FETCH_ASSOC);
            $_SESSION['cart'] = unserialize($row['value']);
        } else {
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

        //if we are logged in, get our cart from the db. 
        //if we are logged in but have no cart in the db, BUT a cart in the session, this saves our session cart to the DB.
        $this->loadCart();
    }

    public function execute($querydata) {
        global $db;
        $db->beginTransaction();
        $this->init();

        $this->syncActions($querydata['action'], $querydata['currentContext']);

        //if we are logged in: save our cart back to the DB
        $this->saveCart();
        $db->commit();
        return array('currentRequest' => isset($querydata['currentRequest']) ? $querydata['currentRequest'] : -1, 'cart' => $_SESSION['cart']);
    }

    public function syncActions($parms, $currentContext) {
        //prepare empty values
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('cartitems' => array(), 'carts' => array());
        }
        if (!isset($_SESSION['cart']['carts'][$currentContext]))
            $_SESSION['cart']['carts'][$currentContext] = array('all' => array());

        //refs for quicker access
        $cartitems = &$_SESSION['cart']['cartitems'];
        $currentCart = &$_SESSION['cart']['carts'][$currentContext];

        //manipulation
        switch ($parms['action']) {
            case 'addItem':
                foreach ($parms['ids'] as $key=>$id)
                    $parms['ids'][$key] = intval($id);

                $missingIds = array_diff( $parms['ids'], array_keys($cartitems));
                // add item to $cartitems
                if (count($missingIds) > 0) {
                    list($service) = \WebService::factory('details/features');
                    $items = $service->execute(array('terms' => $missingIds));
                    foreach ($items['results'] as $item) {
                        $cartitems[intval($item['feature_id'])] = array_merge($item, array('metadata' => array()));
                    }
                }
                // add item to $currentCart
                foreach ($parms['ids'] as $id) {
                    if (!in_array($id, $currentCart[$parms['groupname']]))
                            $currentCart[$parms['groupname']][] = $id;
                }

                break;
            case 'updateItem':
                //enforce id to be int. might get interpreted as string otherwise, which will lead json_encode to enclose it in ""...
                $parms['id'] = intval($parms['id']);
                //update metadata
                $cartitems[$parms['id']]['metadata'] = $parms['metadata'];
                break;
            case 'removeItem':
                if ($parms['groupname'] == 'all') {
                    //enforce id to be int. might get interpreted as string otherwise, which will lead json_encode to enclose it in ""...
                    $parms['id'] = intval($parms['id']);
                    //remove from all groups
                    foreach ($currentCart as &$group){
                        $pos = array_search($parms['id'], $group);
                        if ($pos !== FALSE)
                            array_splice($group, $pos, 1);
                    }
                    //remove from $cartitems
                    unset($cartitems[$parms['id']]);
                } else {
                    //remove from group
                    $pos = array_search($parms['id'], $currentCart[$parms['groupname']]);
                    if ($pos !== FALSE)
                        array_splice($currentCart[$parms['groupname']], $pos, 1);
                }
                break;
            case 'addGroup':
                $currentCart[$parms['groupname']] = array();
                break;
            case 'renameGroup':
                $currentCart[$parms['newname']] = $currentCart[$parms['groupname']];
                unset($currentCart[$parms['groupname']]);
                break;
            case 'removeGroup':
                unset($currentCart[$parms['groupname']]);
                break;
            case 'clear':
                foreach ($currentCart['all'] as $id)
                    unset($cartitems[$id]);
                $_SESSION['cart']['carts'][$currentContext] = array('all' => array());
                break;
        }
    }

}

?>
