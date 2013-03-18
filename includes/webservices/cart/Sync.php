<?php

namespace webservices\cart;

use \PDO as PDO;

class Sync extends \WebService {

    private static function &get_group($groupname) {
        foreach ($_SESSION['cart']['groups'] as &$group) {
            if ($group['name'] == $groupname)
                return $group;
        }
        $x = null;
        return $x;
    }

    public function execute($querydata) {
        session_start();

        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = array('all' => array(), 'groups' => array());
        }

        global $_CONST, $db;

#UI hint
        if (false)
            $db = new PDO();


        if (isset($querydata['action']))
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
                case 'addItemToAll':
                    $item = $querydata['action']['item'];
                    if (in_array($item, $_SESSION['cart']['all'], true))
                        break;
                    $_SESSION['cart']['all'][] = $item;
                    break;
                case 'addItemToGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!in_array($item, $_SESSION['cart']['all'], true))
                        break;
                    if (in_array($item, $group, true))
                        break;
                    $group['items'][] = $item;
                    break;
                case 'removeItemFromGroup':
                    $item = $querydata['action']['item'];
                    $groupname = $querydata['action']['groupname'];
                    $group = &self::get_group($groupname);
                    if (!in_array($item, $group, true))
                        break;
                    $group['items'] = self::array_diff_rec($group['items'], array($item));
                    break;
                case 'removeItemFromAll':
                    $item = $querydata['action']['item'];
                    #var_dump(array($item, $_SESSION['cart']['all']));
                    if (!in_array($item, $_SESSION['cart']['all'], true))
                        break;
                    $_SESSION['cart']['all'] = self::array_diff_rec($_SESSION['cart']['all'], array($item));

                    foreach ($_SESSION['cart']['groups'] as &$group) {
                        if (!in_array($item, $group['items'], true))
                            continue;
                        $group['items'] = self::array_diff_rec($group['items'], array($item));
                    }
                    break;
                case 'resetCart':
                    $_SESSION['cart'] = array('all' => array(), 'groups' => array());
                    break;
            }

        return array_merge($querydata,
                array('syncTime' => isset($querydata['syncRequestTime']) ? $querydata['syncRequestTime'] : -1, 'cart' => $_SESSION['cart']));
    }

    private static function array_diff_rec($first, $second) {
        $ret = array();
        foreach ($first as $f) {
            if (!in_array($f, $second, true))
                $ret[] = $f;
        }
        return $ret;
    }

}

?>
