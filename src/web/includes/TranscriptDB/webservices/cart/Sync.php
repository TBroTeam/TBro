<?php

namespace webservices\cart;

require_once 'TranscriptDB//db.php';

/**
 * Web Service.
 * Replicates cart functionality on server side, syncing client-side cart with server-side cart in SESSION.
 * If the user is logged in, data is loaded/changed/stored to database.
 * Always returns state of the current cart.
 */
class Sync extends \WebService {

    public static $regexCartName = '^[a-z0-9._ ]+$';

    /**
     * Loads cart from database, if logged in.
     * Locks row for update to prevent concurrent changes.
     * @global \PDO $db
     * @return nothing
     */
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

    /**
     * Saves cart if logged in & ends transaction, i.e. releases row lock.
     * @global \PDO $db
     * @return nothing
     */
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
        global $db;
        $db->beginTransaction();

        if (!isset($_SESSION))
            session_start();

        $this->loadCart();

        $this->syncActions($querydata['action'], $querydata['currentContext']);

        //if we are logged in: save our cart back to the DB
        $this->saveCart();
        $db->commit();
        if ($querydata['action']['action'] === 'refreshCart') {
            return array('currentRequest' => isset($querydata['currentRequest']) ? $querydata['currentRequest'] : -1, 'md5sum' => md5(json_encode($_SESSION['cart'])));
        }
        return array('currentRequest' => isset($querydata['currentRequest']) ? $querydata['currentRequest'] : -1, 'cart' => $_SESSION['cart'], 'md5sum' => md5(json_encode($_SESSION['cart'])));
    }

    /**
     * replicates client-side action in the session stored cart.
     * @param type $parms contains action to be executed & parameters
     * @param type $currentContext current context (release-organism-combination)
     */
    public function syncActions($parms, $currentContext) {
        //prepare empty values
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('metadata' => array(), 'carts' => array());
        }
        if (!isset($_SESSION['cart']['carts'][$currentContext]))
            $_SESSION['cart']['carts'][$currentContext] = array();

        //refs for quicker access
        $metadata = &$_SESSION['cart']['metadata'];
        $currentCart = &$_SESSION['cart']['carts'][$currentContext];
        
        //manipulation
        switch ($parms['action']) {
            case 'addItem':
                foreach ($parms['ids'] as $key => $id)
                    $parms['ids'][$key] = intval($id);
                // create cart if it does not already exist
                if (!in_array($parms['groupname'], array_keys($currentCart)))
                    $currentCart[$parms['groupname']] = array();
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
                $metadata[$parms['id']] = $parms['metadata'];
                // if metadata is empty (remove it)
                if((!isset($parms['metadata']['alias']) || $parms['metadata']['alias'] === '') && (!isset($parms['metadata']['annotations']) || $parms['metadata']['annotations'] === '')){
                    unset($metadata[$parms['id']]);
                }
                break;
            case 'removeItem':
                //remove from group
                $pos = array_search($parms['id'], $currentCart[$parms['groupname']]);
                if ($pos !== FALSE)
                    array_splice($currentCart[$parms['groupname']], $pos, 1);
                break;
            case 'addGroup':
                $currentCart[$parms['groupname']] = array();
                break;
            case 'renameGroup':
                $currentCart[$parms['newname']] = $currentCart[$parms['groupname']];
                unset($currentCart[$parms['groupname']]);
                break;
            case 'removeGroup':
                $oldcart = $currentCart[$parms['groupname']];
                unset($currentCart[$parms['groupname']]);
                break;
            case 'clear':
                $_SESSION['cart']['carts'][$currentContext] = array();
                break;
        }
    }

}

?>