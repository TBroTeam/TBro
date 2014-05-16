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

        // keep this only for a short while to convert carts to incorporate the new format (cartname->items,notes)
        if (!array_key_exists('cartorder', $_SESSION['cart'])) {
            $_SESSION['cart']['cartorder'] = array();
        }
        foreach (array_keys($_SESSION['cart']['carts']) as $context) {
            foreach (array_keys($_SESSION['cart']['carts'][$context]) as $name) {
                if (!array_key_exists('items', $_SESSION['cart']['carts'][$context][$name])) {
                    $items = $_SESSION['cart']['carts'][$context][$name];
                    $_SESSION['cart']['carts'][$context][$name] = array('items' => $items, 'notes' => '', 'created' => time(), 'modified' => time());
                }
                if (!array_key_exists('created', $_SESSION['cart']['carts'][$context][$name])) {
                    $_SESSION['cart']['carts'][$context][$name]['created'] = time();
                    $_SESSION['cart']['carts'][$context][$name]['modified'] = time();
                }
            }
            //if (!array_key_exists($context, $_SESSION['cart']['cartorder'])) {
            //    $_SESSION['cart']['cartorder'][$context] = array_keys($_SESSION['cart']['carts'][$context]);
            //}
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
            $_SESSION['cart'] = array('metadata' => array(), 'carts' => array(), 'cartorder' => array());
        }
        if (!isset($_SESSION['cart']['carts'][$currentContext]))
            $_SESSION['cart']['carts'][$currentContext] = array();
        if (!isset($_SESSION['cart']['metadata'][$currentContext]))
            $_SESSION['cart']['metadata'][$currentContext] = array();
        if (!isset($_SESSION['cart']['cartorder'][$currentContext]))
            $_SESSION['cart']['cartorder'][$currentContext] = array();

        //refs for quicker access
        $metadata = &$_SESSION['cart']['metadata'][$currentContext];
        $currentCart = &$_SESSION['cart']['carts'][$currentContext];
        $cartorder = &$_SESSION['cart']['cartorder'][$currentContext];

        //manipulation
        switch ($parms['action']) {
            case 'addItem':
                // get all feature ids of the context to check before adding
                list($service) = \WebService::factory('listing/features');
                $cont = explode('_', $currentContext, 2);
                $results = ($service->execute(array('species' => $cont[0], 'release' => $cont[1])));
                // convert ids to int
                foreach ($parms['ids'] as $key => $id)
                    $parms['ids'][$key] = intval($id);
                // only keep ids that belong to this context
                $ids_context = array_intersect($parms['ids'], $results['results']);
                // create cart if it does not already exist
                if (!in_array($parms['groupname'], array_keys($currentCart))) {
                    $currentCart[$parms['groupname']] = array('notes' => '', 'items' => array(), 'created' => time(), 'modified' => time());
                }
                // add item to $currentCart if not already in there
                foreach ($ids_context as $id) {
                    if (!in_array($id, $currentCart[$parms['groupname']]['items']))
                        $currentCart[$parms['groupname']]['items'][] = $id;
                }
                $currentCart[$parms['groupname']]['modified'] = time();
                break;
            case 'updateItem':
                //enforce id to be int. might get interpreted as string otherwise, which will lead json_encode to enclose it in ""...
                $parms['id'] = intval($parms['id']);
                //update metadata
                $metadata[$parms['id']] = $parms['metadata'];
                // if metadata is empty (remove it)
                if ((!isset($parms['metadata']['alias']) || $parms['metadata']['alias'] === '') && (!isset($parms['metadata']['annotations']) || $parms['metadata']['annotations'] === '')) {
                    unset($metadata[$parms['id']]);
                }
                break;
            case 'removeItem':
                //remove from group
                $pos = array_search($parms['id'], $currentCart[$parms['groupname']]['items']);
                if ($pos !== FALSE) {
                    array_splice($currentCart[$parms['groupname']]['items'], $pos, 1);
                    $currentCart[$parms['groupname']]['modified'] = time();
                }
                break;
            case 'addGroup':
                $currentCart[$parms['groupname']] = array('notes' => '', 'items' => array(), 'created' => time(), 'modified' => time());
                array_unshift($cartorder, $parms['groupname']);
                if (isset($parms['groupnotes']))
                    $currentCart[$parms['groupname']]['notes'] = $parms['groupnotes'];
                break;
            case 'renameGroup':
                $currentCart[$parms['newname']] = $currentCart[$parms['groupname']];
                $currentCart[$parms['newname']]['modified'] = time();
                unset($currentCart[$parms['groupname']]);
                $key = array_search($parms['groupname'], $cartorder);
                $cartorder[$key] = $parms['newname'];
                break;
            case 'updateGroup':
                $currentCart[$parms['groupname']]['notes'] = $parms['groupnotes'];
                break;
            case 'setTimestamps':
                $currentCart[$parms['groupname']]['created'] = $parms['created'];
                $currentCart[$parms['groupname']]['modified'] = $parms['modified'];
                break;
            case 'removeGroup':
                unset($currentCart[$parms['groupname']]);
                $key = array_search($parms['groupname'], $cartorder);
                array_splice($cartorder, $key, 1);
                break;
            case 'clear':
                $_SESSION['cart']['carts'][$currentContext] = array();
                break;
            case 'clearAll':
                $_SESSION['cart']['carts'] = array();
                break;
            case 'clearAnnotations':
                $_SESSION['cart']['metadata'][$currentContext] = array();
                break;
            case 'clearAllAnnotations':
                $_SESSION['cart']['metadata'] = array();
                break;
            case 'setCartOrder':
                $cartorder = $parms['neworder'];
                break;
        }
    }

}

?>